<?php

use App\Controller\Controller;

class LogsController extends Controller {
    private $_frag = "/^ *[0-9]+:[0-9]{2} Kill: [0-9]+ [0-9]+ [0-9]+: (?!<world>)(.*) killed (.*) by (?!MOD_CHANGE_TEAM$|MOD_FALLING$|MOD_WATER$|MOD_LAVA$|UT_MOD_BLED$|UT_MOD_FLAG$)(.*)$/i";
    private $_hit = "/^ *[0-9]+:[0-9]{2} Hit: [0-9]+ [0-9]+ [0-9]+ [0-9]+: (.*) hit (.*) in the (.*)$/i";
    private $_playerjoin = '/^ *([0-9]+):([0-9]+) ClientUserinfo: ([0-9]+) (.*)$/i';
    private $_playerchange = "/^ *[0-9]+:[0-9]+ ClientUserinfoChanged: ([0-9]+) (.*)$/i";
    private $_playerquits = "/^ *([0-9]+):([0-9]+) ClientDisconnect: ([0-9]+)$/i";
    private $_endgame = "/^ *([0-9]+):([0-9]+) ShutdownGame:$/i";
    private $_initround = "/^ *([0-9]+):([0-9]+) (InitRound|InitGame): (.*)$/i";
    private $_item = "/^ *[0-9]+:[0-9]{2} Item: ([0-9]+) (?!<world>)(.*)$/i";
    private $_flag = "/^ *[0-9]+:[0-9]{2} Flag: ([0-9]+) ([0-9]+): (.*)$/i";
    private $_bomb = "/^ *[0-9]+:[0-9]{2} Bomb was (.*) by ([0-9]+)/i";
    private $_bombexploded = "/^ *[0-9]+:[0-9]{2} Pop!/i";
    private $_teamscore = "/^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$/i";
    private $_gungameend = "/^ *([0-9]+):([0-9]+) Exit: Gunlimit hit\./i";
    private $_gungamescore = "/^ *([0-9]+):([0-9]+) score: ([0-9]+)  ping: [0-9]+  client: ([0-9]+) (.*)/i";
    private $_freegameend = "/^ *([0-9]+):([0-9]+) Exit: Timelimit hit\./i";
    private $_freegamescore = "/^ *([0-9]+):([0-9]+) score: ([0-9]+)  ping: [0-9]+  client: ([0-9]+) (.*)/i";

    private $_playersarray = [];
    private $_teams = [];
    private $_round = 0;
    private $_triggerbomb  = false;
    private $_triggergungame = false;
    private $_triggerfreegame = false;
    private $_bomber = null;
    private $_gametype = null;

    public function parseLog($log)
    {
        $time_start = microtime(true);
        $this->logOutput("Start parsing Logfile ($log)");
        $handle = fopen($log, "r");
        $l = 1;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                /* Check Frag */
                preg_match($this->_frag,$line,$matches);
                if(count($matches) > 0){
                    $action ="Frag";
                    $fragger = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $fragged = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $weapon = $this->app->Ctrl->Weapons->getORadd($matches[3]);
                    $message = $fragger->getName(). " killed ". $fragged->getName()." with ".$weapon->getName();
                    if($this->app->Ctrl->Frags->add($fragger,$fragged,$weapon) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Check Hit */
                preg_match($this->_hit,$line,$matches);
                if(count($matches) > 0){
                    $action = "Hit";
                    $hitter = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $hitted = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $part = $this->app->Ctrl->Hits->getBodyPart($matches[3]);
                    $message = $hitter->getName(). " hit ". $hitted->getName()." in ".$matches[3];
                    if($this->app->Ctrl->Hits->add($hitter,$hitted,$part) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Check Player Connection */
                preg_match($this->_playerjoin,$line,$matches);
                if(count($matches) > 0){
                    $action = "Connection";
                    $playername = $this->getValueFromConnectionString($matches[4], "name");
                    if(strpos($playername,":27960") !== false){
                        // Skipped, because of Server Connection
                        $message = "Skipped, Server connection ($playername)";
                        $level = "INFO";
                    }else {
                        $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[4], "name"));
                        if (array_search($player->getId(), $this->_playersarray) === false) {
                            /* Player not found in Temp Array, adding it and declare new Connection */
                            $this->_playersarray[$matches[3]] = $player->getId();
                            $time = $this->countGameTime($matches);
                            $message = $player->getName() . " (" . $matches[3] . ") connected at " . $time . " seconds";
                            if ($this->app->Ctrl->Games->add($player, $time)) {
                                $level = "INFO";
                            } else {
                                $level = "ERROR";
                            }
                        }else{
                            $message = "Skipped, User ".$player->getName()." already in Game (GameID: ". $matches[3] .", Name: $playername)";
                            $level = "INFO";
                        }
                    }
                    $this->logOutput($message, $l, $action, $level);
                }


                /* Check Player Change */
                preg_match($this->_playerchange,$line,$matches);
                if(count($matches) > 0){
                    $action = "Change";
                    $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[2],"n"));
                    $teamNb = $this->getValueFromConnectionString($matches[2],"t");
                    $this->_teams[$matches[1]] = $teamNb;
                    $team = ($teamNb == 1)? "Red":"Blue";
                    $message = $player->getName() ." is now in team $team";
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Check Player Disconnection */
                preg_match($this->_playerquits,$line,$matches);
                if(count($matches) > 0){
                    $action = "Disconnection";
                    $time = $this->countGameTime($matches);
                    $player = $this->getPlayerFromTempArray($matches[3]);
                    if(!is_null($player)) {
                        $message = $player->getName(). " disconnected at ".$time." seconds";
                        if($this->app->Ctrl->Games->stopGame($player, $time) !== false){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                        $this->logOutput($message,$l,$action,$level);
                    }
                    try {
                        unset($this->_playersarray[$matches[3]]);
                    } catch(Exception $e){

                    }
                }


                /* Init Round or game */
                preg_match($this->_initround,$line,$matches);
                if(count($matches) > 0){
                    $action = "Init Round";
                    $gametype = $this->app->Ctrl->Gametypes->getByCode($this->getValueFromConnectionString($matches[4],"g_gametype"));
                    $this->_triggerbomb = ($gametype->getCode() == "8")? true:false;
                    $newround = $this->app->Ctrl->Rounds->add($gametype,count($this->_playersarray));
                    $message = "Round: ".$newround->getId(). ", Game Type: ".$gametype->getName().", Players: ".count($this->_playersarray);
                    $this->_gametype = $gametype->getCode();
                    if($newround !== false){
                        $level = "INFO";
                        $this->_round = $newround->getId();
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Bomb Action */
                preg_match($this->_bomb,$line,$matches);
                if(count($matches) > 0){
                    $event = $matches[1];
                    if($event == "planted" || $event == "defused") {
                        $player = $this->getPlayerFromTempArray($matches[2]);
                        if(!is_null($player)){
                            $action = "Bomb";
                            $message = $player->getName(). " $event bomb";
                            if($this->app->Ctrl->Bombs->add($player, $event)){
                                $level = "INFO";
                                if($event == "planted"){
                                    $this->_bomber  = $player;
                                }elseif($event == "defused"){
                                    $this->_bomber  = null;
                                }
                            }else{
                                $level = "ERROR";
                            }
                            $this->logOutput($message,$l,$action,$level);
                        }
                    }
                }
                preg_match($this->_bombexploded,$line,$matches);
                if(count($matches) > 0 && !is_null($this->_bomber)){
                    $event = "exploded";
                    $action = "Bomb";
                    $message = "bomb exploded (".$this->_bomber->getName(). ")";

                    if($this->app->Ctrl->Bombs->add($this->_bomber, $action)){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->_bomber = null;
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Flag Pickup */
                preg_match($this->_item,$line,$matches);
                if(count($matches) > 0){
                    if($matches[2] == "team_CTF_redflag" || $matches[2] == "team_CTF_blueflag"){
                        $player = $this->getPlayerFromTempArray($matches[1]);
                        if(!is_null($player)) {
                            $action = "Flag Pickup";
                            $message = $player->getName(). "picked up ".str_replace("team_CTF_","",$matches[2]);
                            if($this->app->Ctrl->Flags->add($player,"catch")){
                                $level = "INFO";
                            }else{
                                $level = "ERROR";
                            }
                            $this->logOutput($message,$l,$action,$level);
                        }
                    }
                }


                /* Flag Return, Drop or Capture */
                preg_match($this->_flag,$line,$matches);
                if(count($matches) > 0){
                    $player = $this->getPlayerFromTempArray($matches[1]);
                    if(!is_null($player)) {
                        switch ($matches[2]){
                            case "0":
                                $action = "Flag Drop";
                                $event = "drop";
                                break;

                            case "1":
                                $action = "Flag Return";
                                $event = "return";
                                break;

                            case "2":
                                $action = "Flag Capture";
                                $event = "capture";
                                break;
                        }
                        $message = $player->getName(). " $action ".str_replace("team_CTF_","",$matches[3]);
                        if($this->app->Ctrl->Flags->add($player,$event)){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                        $this->logOutput($message,$l,$action,$level);
                    }
                }


                /* Check Endgame: New game, everybody quits */
                preg_match($this->_endgame,$line,$matches);
                if(count($matches) > 0){
                    $action = "End Game";
                    $time = $this->countGameTime($matches);
                    foreach($this->_playersarray as $p){
                        $player = $this->app->Ctrl->Players->get($p);
                        $this->app->Ctrl->Games->stopGame($player,$time);
                    }
                    //$this->_playersarray = [];
                    $message = "Stopped time for all Players at $time seconds";
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }


                /* Gun Game End: Trigger On for Score Reading */
                preg_match($this->_gungameend,$line,$matches);
                if(count($matches) > 0) {
                    $action = "End GunGame";
                    $this->_triggergungame = $matches[1].":".$matches[2];
                    $message = "Stopped at ".$matches[1].":".$matches[2];
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }
                preg_match($this->_gungamescore,$line,$matches);
                if(count($matches) > 0 && $this->_triggergungame !== false) {
                    if($matches[1].":".$matches[2] == $this->_triggergungame){
                        $action = "GunGame Score";
                        $player = $this->getPlayerFromTempArray($matches[4]);
                        if(!is_null($player)) {
                            $message = "Winner is ".$matches[5]." (".$matches[4].")";
                        }
                        if($this->app->Ctrl->Rounds->updateResults($this->_round,0, 0, $player->getId()) !== false){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                        $this->logOutput($message,$l,$action,$level);
                        $this->_triggergungame = false;
                    }
                }


                /* Free For All End: Trigger On for Score Reading */
                preg_match($this->_freegameend,$line,$matches);
                if(count($matches) > 0) {
                    $action = "End FreeForAll";
                    $this->_triggerfreegame = $matches[1].":".$matches[2];
                    $message = "Stopped at ".$matches[1].":".$matches[2];
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }
                preg_match($this->_freegamescore,$line,$matches);
                if(count($matches) > 0 && $this->_triggerfreegame !== false) {
                    if($matches[1].":".$matches[2] == $this->_triggerfreegame && $this->_gametype == "0"){
                        $action = "FreeForAll Score";
                        $player = $this->getPlayerFromTempArray($matches[4]);
                        if(!is_null($player)) {
                            $message = "Winner is ".$matches[5]." (".$matches[4].")";
                        }
                        if($this->app->Ctrl->Rounds->updateResults($this->_round,0, 0, $player->getId()) !== false){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                        $this->logOutput($message,$l,$action,$level);
                        $this->_triggerfreegame = false;
                    }
                }


                /* Score */
                preg_match($this->_teamscore,$line,$matches);
                if(count($matches) > 0){
                    $action ="Round Scores";
                    $redscore = intval($matches[3]);
                    $bluescore = intval($matches[4]);
                    $message = "Blue $bluescore, Red: $redscore";
                    $winner = "";
                    if($redscore > $bluescore){
                        $winner = "RED";
                    }
                    if($redscore < $bluescore){
                        $winner = "BLUE";
                    }
                    if($this->app->Ctrl->Rounds->updateResults($this->_round,$redscore, $bluescore, $winner) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);

                    /* Update Players Team informations */
                    foreach($this->_teams as $key => $value){
                        $player = $this->getPlayerFromTempArray($key);
                        if(!is_null($player)){
                            $action = "eams Infos";
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
                            $message = $player->getName() ." in team $team";
                            if($this->app->Ctrl->Teams->add($this->_round,$player,$team) !== false){
                                $level = "INFO";
                            }else{
                                $level = "ERROR";
                            }
                            $this->logOutput($message,$l,$action,$level);

                            if(($team == "RED" && $winner == "RED") || ($team == "BLUE" && $winner == "BLUE")){
                                $this->app->Ctrl->Scores->add($player,1);
                            }
                            if(($team == "RED" && $winner == "BLUE") || ($team == "BLUE" && $winner == "RED")){
                                $this->app->Ctrl->Scores->add($player,-1);
                            }
                        }
                    }
                }
                $l++;
            }
            fclose($handle);
            $time_end = microtime(true);
            $this->logOutput("Execution Time:".gmdate("H:i:s",($time_end - $time_start)),"","","INFO");
            $this->logOutput("Script Done","","","INFO");
        } else {
            return false;
        }
    }

    public function getValueFromConnectionString($string,$marker){
        $str = explode("\\",$string);
        $key = array_search($marker, $str);
        return $str[$key + 1];
    }

    private function getPlayerFromTempArray($id){
        if(array_key_exists($id,$this->_playersarray)){
            try {
                $player = $this->app->Ctrl->Players->get($this->_playersarray[$id]);
                return $player;
            } catch( ErrorException $e){
                return false;
            }
        }else{
            return null;
        }
    }

    private function countGameTime($matches){
        return intval($matches[1])*60 + intval($matches[2]);;
    }
}