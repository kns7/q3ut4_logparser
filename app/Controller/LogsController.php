<?php

use App\Controller\Controller;

class LogsController extends Controller {
    private $_frag = "/^ *[0-9]+:[0-9]{2} Kill: [0-9]+ [0-9]+ [0-9]+: (?!<world>)(.*) killed (.*) by (?!MOD_CHANGE_TEAM$|MOD_FALLING$|MOD_WATER$|MOD_LAVA$|UT_MOD_BLED$|UT_MOD_FLAG$)(.*)$/i";
    private $_hit = "/^ *[0-9]+:[0-9]{2} Hit: [0-9]+ [0-9]+ [0-9]+ [0-9]+: (.*) hit (.*) in the (.*)$/i";
    private $_playerjoin = '/^ *([0-9]+):([0-9]+) ClientUserinfo: ([0-9]+) (.*)$/i';
    private $_playerchange = "/^ *[0-9]+:[0-9]+ ClientUserinfoChanged: ([0-9]+) (.*)$/i";
    private $_playerquits = "/^ *([0-9]+):([0-9]+) ClientDisconnect: ([0-9]+)$/i";
    private $_endgame = "/^ *([0-9]+):([0-9]+) ShutdownGame:$/i";
    private $_initround = "/^ *([0-9]+):([0-9]+) InitRound: (.*)$/i";
    private $_item = "/^ *[0-9]+:[0-9]{2} Item: ([0-9]+) (?!<world>)(.*)$/i";
    private $_flag = "/^ *[0-9]+:[0-9]{2} Flag: ([0-9]+) ([0-9]+): (.*)$/i";
    private $_bombplanted = "/^ *[0-9]+:[0-9]{2} Bomb was planted by ([0-9]+)$/i";
    private $_bombdefused = "/^ *[0-9]+:[0-9]{2} Bomb was defused by ([0-9]+)/i";
    private $_teamscore = "/^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$/i";
    private $_chat = "/^ *[0-9]+:[0-9]{2} (say|sayteam): [0:9]+ (?!<world>)(.*): (.*)$/i";
    private $_playersarray = [];
    private $_teams = [];
    private $_round = 0;

    public function parseLog($log)
    {
        $handle = fopen($log, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                /* Check Player Connection */
                preg_match($this->_playerjoin,$line,$matches);
                if(count($matches) > 0){
                    $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[4],"name"));
                    if(array_search($player->getId(),$this->_playersarray) === false){
                        /* Player not found in Temp Array, adding it and declare new Connection */
                        echo "Player connect    | ";
                        $this->_playersarray[$matches[3]] = $player->getId();
                        $time = $this->countGameTime($matches);
                        echo $player->getName(). " (".$matches[3].") connected at ".$time." seconds";
                        if($this->app->Ctrl->Games->add($player,$time)){
                            echo " [ADDED]";
                        }else{
                            echo " [ERROR]";
                        }
                        echo "\n";
                    }
                }

                /* Check Frag */
                preg_match($this->_frag,$line,$matches);
                if(count($matches) > 0){
                    echo "Frag found        | ";
                    $fragger = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $fragged = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $weapon = $this->app->Ctrl->Weapons->getORadd($matches[3]);
                    echo $fragger->getName(). " > ". $fragged->getName()." with ".$weapon->getName();
                    if($this->app->Ctrl->Frags->add($fragger,$fragged,$weapon) !== false){
                        echo " [ADDED]";
                    }else{
                        echo " [ERROR]";
                    }
                    echo "\n";
                }

                /* Check Hits */
                preg_match($this->_hit,$line,$matches);
                if(count($matches) > 0){
                    echo "Hit found         | ";
                    $hitter = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $hitted = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $part = $this->app->Ctrl->Hits->getBodyPart($matches[3]);
                    echo $hitter->getName(). " hit ". $hitted->getName()." in ".$matches[3];
                    if($this->app->Ctrl->Hits->add($hitter,$hitted,$part) !== false){
                        echo " [ADDED]";
                    }else{
                        echo " [ERROR]";
                    }
                    echo "\n";
                }

                /* Check Player Changes */
                preg_match($this->_playerchange,$line,$matches);
                if(count($matches) > 0){
                    echo "Player Change     | ";
                    $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[2],"n"));
                    $teamNb = $this->getValueFromConnectionString($matches[2],"t");
                    $this->_teams[$matches[1]] = $teamNb;
                    $team = ($teamNb == 1)? "Red":"Blue";
                    echo $player->getName() ." is now in team $team";
                    echo "\n";
                }

                /* Check Player Disconnection */
                preg_match($this->_playerquits,$line,$matches);
                if(count($matches) > 0){
                    echo "Player Disconnect | ";
                    $time = $this->countGameTime($matches);
                    $player = $this->getPlayerFromTempArray($matches[3]);
                    if(!is_null($player)) {
                        echo $player->getName(). " disconnected at ".$time." seconds";
                        if($this->app->Ctrl->Games->stopGame($player, $time) !== false){
                            echo " [ADDED]";
                        }else{
                            echo " [ERROR]";
                        }
                    }
                    try {
                        unset($this->_playersarray[$matches[3]]);
                    } catch(Exception $e){

                    }
                    echo "\n";
                }

                /* Init Round */
                preg_match($this->_initround,$line,$matches);
                if(count($matches) > 0){
                    echo "Init Round        | ";
                    $gametype = $this->Ctrl->Gametypes->getByCode($this->getValueFromConnectionString("g_gametype"));
                    $newround = $this->app->Ctrl->Rounds->add($gametype);
                    echo "Round ".$newround->getId(). " Game Type: ".$gametype->getName();
                    if($newround !== false){
                        echo " [ADDED]";
                        $this->_round = $newround->getId();
                    }else{
                        echo " [ERROR]";
                    }
                    echo "\n";
                }

                /* Check Endgame: New game, everybody quits */
                preg_match($this->_endgame,$line,$matches);
                if(count($matches) > 0){
                    echo "End Game          | ";
                    $time = $this->countGameTime($matches);
                    foreach($this->_playersarray as $p){
                        $this->app->Ctrl->Games->stopGame($p,$time);
                    }
                    $this->_playersarray = [];
                    echo "Stopped time for all Players at $time seconds";
                    echo "\n";
                }
            }

            fclose($handle);
        } else {
            return false;
        }
    }

    private function getValueFromConnectionString($string,$marker){
        $str = explode("\\",$string);
        $key = array_search($marker, $str);
        return $str[$key + 1];
    }

    private function getPlayerFromTempArray($id){
        return $this->app->Ctrl->Players->get($this->_playersarray[$id]);
    }

    private function countGameTime($matches){
        return intval($matches[1])*60 + intval($matches[2]);;
    }
}