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
    private $_bomb = "/^ *[0-9]+:[0-9]{2} Bomb was (.*) by ([0-9]+)/i";
    private $_bombexploded = "/^ *[0-9]+:[0-9]{2} Pop!/i";
    private $_teamscore = "/^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$/i";
    private $_chat = "/^ *[0-9]+:[0-9]{2} (say|sayteam): [0:9]+ (?!<world>)(.*): (.*)$/i";
    private $_playersarray = [];
    private $_teams = [];
    private $_round = 0;
    private $_bombexplosion = 0;
    private $_triggerbomb  = false;

    public function parseLog($log)
    {
        $handle = fopen($log, "r");
        $l = 1;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                /* Check Player Connection */
                preg_match($this->_playerjoin,$line,$matches);
                if(count($matches) > 0){
                    $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[4],"name"));
                    if(array_search($player->getId(),$this->_playersarray) === false){
                        /* Player not found in Temp Array, adding it and declare new Connection */
                        echo "$l: Player connect    | ";
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
                    echo "$l: Frag found        | ";
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
                    echo "$l: Hit found         | ";
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
                    echo "$l: Player Change     | ";
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
                    echo "$l: Player Disconnect | ";
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
                    echo "$l: Init Round        | ";
                    $gametype = $this->app->Ctrl->Gametypes->getByCode($this->getValueFromConnectionString($matches[3],"g_gametype"));
                    $this->_triggerbomb = ($gametype->getCode() == "8")? true:false;
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

                /* Bomb Actions */
                preg_match($this->_bomb,$line,$matches);
                if(count($matches) > 0){
                    $action = $matches[1];
                    if($action == "planted" || $action == "defused") {
                        echo "$l: Bomb Action       | ";
                        $player = $this->getPlayerFromTempArray($matches[2]);
                        echo $player->getName(). " $action bomb";
                        if($this->app->Ctrl->Bombs->add($player, $action)){
                            echo " [ADDED]";
                        }else{
                            echo " [ERROR]";
                        }
                    }
                }

                /* Flags Actions */


                /* Check Endgame: New game, everybody quits */
                preg_match($this->_endgame,$line,$matches);
                if(count($matches) > 0){
                    echo "$l: End Game          | ";
                    $time = $this->countGameTime($matches);
                    foreach($this->_playersarray as $p){
                        $player = $this->app->Ctrl->Players->get($p);
                        $this->app->Ctrl->Games->stopGame($player,$time);
                    }
                    $this->_playersarray = [];
                    echo "Stopped time for all Players at $time seconds";
                    echo "\n";
                }

                /* Scores */
                preg_match($this->_teamscore,$line,$matches);
                if(count($matches) > 0){
                    echo "$l: End Round Scores  | ";
                    $redscore = intval($matches[3]);
                    $bluescore = intval($matches[4]);
                    echo "Blue $bluescore, Red: $redscore";
                    $winner = "";
                    if($redscore > $bluescore){
                        $winner = "RED";
                    }
                    if($redscore < $bluescore){
                        $winner = "BLUE";
                    }
                    if($this->app->Ctrl->Rounds->updateResults($this->_round,$redscore, $bluescore, $winner) !== false){
                        echo " [ADDED]";
                    }else{
                        echo " [ERROR]";
                    }
                    echo "\n";

                    /* Update Players Team informations */
                    foreach($this->_teams as $key => $value){
                        echo "$l:   Add Teams Infos | ";
                        $player = $this->getPlayerFromTempArray($key);
                        switch($value){
                            default:
                                $team = "";
                                break;
                            case 1:
                                $team = "RED";
                                break;
                            case 2:
                                $team  = "BLUE";
                                break;
                        }
                        echo $player->getName() ." in team $team";
                        if($this->app->Ctrl->Teams->add($this->_round,$player,$team) !== false){
                            echo " [ADDED]";
                        }else{
                            echo " [ERROR]";
                        }
                        echo "\n";

                        if(($team == "RED" && $winner == "RED") || ($team == "BLUE" && $winner == "BLUE")){
                            $this->app->Ctrl->Scores->add($player,1);
                        }
                        if(($team == "RED" && $winner == "BLUE") || ($team == "BLUE" && $winner == "RED")){
                            $this->app->Ctrl->Scores->add($player,-1);
                        }
                    }
                }

                ob_flush();
                flush();
                $l++;
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
        try {
            $player = $this->app->Ctrl->Players->get($this->_playersarray[$id]);
            return $player;
        } catch( ErrorException $e){
            return false;
        }
    }

    private function countGameTime($matches){
        return intval($matches[1])*60 + intval($matches[2]);;
    }
}