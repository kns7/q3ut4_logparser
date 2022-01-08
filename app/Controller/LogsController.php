<?php

use App\Controller\Controller;

class LogsController extends Controller {
    private $_frag = "/^ *[0-9]+:[0-9]{2} Kill: [0-9]+ [0-9]+ [0-9]+: (?!<world>)(.*) killed (.*) by (?!MOD_CHANGE_TEAM$|MOD_FALLING$|MOD_WATER$|MOD_LAVA$|UT_MOD_FLAG$)(.*)$/i";
    private $_hit = "/^ *[0-9]+:[0-9]{2} Hit: [0-9]+ [0-9]+ [0-9]+ [0-9]+: (.*) hit (.*) in the (.*)$/i";
    private $_playerjoin = '/^ *([0-9]+):([0-9]+) ClientUserinfo: ([0-9]+) (.*)$/i';
    private $_playerchange = "/^ *[0-9]+:[0-9]+ ClientUserinfoChanged: ([0-9]+) (.*)$/i";
    private $_playerquits = "/^ *([0-9]+):([0-9]+) ClientDisconnect: ([0-9]+)$/i";
    private $_endgame = "/^ *([0-9]+):([0-9]+) ShutdownGame:$/i";
    private $_initround = "/^ *([0-9]+):([0-9]+) InitRound: (.*)$/i";
    private $_initgame = "/^ *([0-9]+):([0-9]+) InitGame: (.*)$/i";
    private $_item = "/^ *[0-9]+:[0-9]{2} Item: ([0-9]+) (?!<world>)(.*)$/i";
    private $_flag = "/^ *[0-9]+:[0-9]{2} Flag: ([0-9]+) ([0-9]+): (.*)$/i";
    private $_bomb = "/^ *[0-9]+:[0-9]{2} Bomb was (.*) by ([0-9]+)/i";
    private $_bombexploded = "/^ *[0-9]+:[0-9]{2} Pop!/i";
    private $_teamscore = "/^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$/i";
    private $_gungameend = "/^ *([0-9]+):([0-9]+) Exit: Gunlimit hit\./i";
    private $_score = "/^ *([0-9]+):([0-9]+) score: ([0-9]+)  ping: ([0-9]+)  client: ([0-9]+) (.*)/i";
    private $_timelimit = "/^ *([0-9]+):([0-9]+) Exit: Timelimit hit\./i";

    private $_playersarray = [];
    private $_teams = [];
    private $_triggergungame = false;
    private $_triggerfreegame = false;
    private $_bomber = null;
    private $gamenb = 0;
    private $roundnb = 0;
    private $gametype = null;
    private $players = [];
    private $currentgame = null;
    private $currentround = null;
    private $currentmap = null;
    private $winningteam = 0;
    private $frags = 0;
    private $hits = 0;
    private $half = 1;
    private $triggertimelimit = false;


    public function logParser($log)
    {
        $time_start = microtime(true);
        $this->logOutput("Start parsing Logfile ($log)");
        $handle = fopen($log, "r");
        $l = 1;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                /*
                ---- Init Game ----
                    - Get Game Type
                    - Get Map
                    - Get Game Parameters (Timelimit + Roundtime)
                    - Get Next Game Number
                    - Create New Game in DB
                    - By Gametypes FFA, GunGame, TeamDeathMatch: Create New Round in DB
                */
                preg_match($this->_initgame,$line,$matches);
                if(count($matches) > 0){
                    $action = "Init Game";
                    $this->hits = 0;
                    $this->frags = 0;
                    $this->triggertimelimit = false;
                    $this->half = 1;
                    $this->gametype = $this->app->Ctrl->Gametypes->getByCode($this->getValueFromConnectionString($matches[3], "g_gametype"));
                    $timelimit = $this->getValueFromConnectionString($matches[3], "timelimit");
                    $roundtime = $this->getValueFromConnectionString($matches[3], "g_roundtime");
                    $this->currentmap = $this->app->Ctrl->Maps->getByFile($this->getValueFromConnectionString($matches[3], "mapname"));
                    $this->gamenb = $this->app->Ctrl->Games->getNextGameNB();
                    $this->currentgame = $this->app->Ctrl->Games->add($this->gamenb,$this->currentmap,$this->gametype,$timelimit,$roundtime,count($this->players));

                    if($this->currentgame !== false ){
                        $mapname = (!is_null($this->currentmap))?$this->currentmap->getName():"Map inconnue";
                        $message = "Game (".$this->gamenb."). Map: $mapname, Gametype: ".$this->gametype->getName().", Timelimit: ".$timelimit.", Roundtime: ". $roundtime." Players: ".count($this->players);
                        $this->logOutput($message,$l,$action,"INFO");
                        switch($this->gametype->getCode()){
                            case 0:
                            case 11:
                                // No InitRound for FFA & Gun game
                                $this->roundnb = $this->app->Ctrl->Rounds->getNextRoundNB();
                                $this->currentround = $this->app->Ctrl->Rounds->addRound($this->currentgame,$this->roundnb);
                                $message = "Round (".$this->roundnb."). Players: ".count($this->players);
                                $this->logOutput($message,$l,$action,"INFO");
                                break;
                        }
                    }
                }



                /*
                ---- Init Round ----
                    - Get Next Round Number
                    - Create New Round in DB
                */
                preg_match($this->_initround,$line,$matches);
                if(count($matches) > 0){
                    $action = "Init Round";
                    $newgametype = $this->app->Ctrl->Gametypes->getByCode($this->getValueFromConnectionString($matches[3], "g_gametype"));
                    $newmap = $this->app->Ctrl->Maps->getByFile($this->getValueFromConnectionString($matches[3], "mapname"));
                    $this->roundnb = $this->app->Ctrl->Rounds->getNextRoundNB();
                    if($this->triggertimelimit){
                        $this->triggertimelimit = false;
                        $this->half=2;
                    }
                    $message = "Round (".$this->roundnb.") [".$this->half."/2]. Players: ".count($this->players);
                    $this->currentround = $this->app->Ctrl->Rounds->addRound($this->currentgame,$this->roundnb,$this->half);
                    if(!is_null($newgametype)) {
                        if ($newgametype->getId() != $this->gametype->getId()) {
                            $message .= ", Update Gametype to " . $newgametype->getName();
                            $this->gametype = $newgametype;
                            $this->app->Ctrl->Games->updateGametype($this->currentgame->getId(),$newgametype);
                        }
                    }
                    if(!is_null($newmap)) {
                        if ($newmap->getId() != $this->currentmap->getId()) {
                            $message .= ", Update Map to " . $newmap->getName();
                            $this->currentmap = $newmap;
                            $this->app->Ctrl->Games->updateMap($this->currentgame->getId(),$this->currentmap);
                        }
                    }
                    $this->logOutput($message,$l,$action,"INFO");
                }


                /*
                ---- End Game ----
                    -
                */
                preg_match($this->_endgame,$line,$matches);
                if(count($matches) > 0){
                    $action = "End Game";
                    if(count($this->players) == 0 || ($this->frags == 0 && $this->hits == 0)) {
                        $message = "Empty Game... remove it!";
                        $this->app->Ctrl->Games->delete($this->currentgame->getId());
                        $this->app->Ctrl->Rounds->deleteFromGame($this->currentgame->getId());
                    }else{
                        $message = "Closing Game, number of players: ".count($this->players);
                        $this->app->Ctrl->Games->update($this->currentgame->getId(),count($this->players));
                        $this->logOutput($message,$l,$action,"INFO");
                    }
                    if(count($this->players) > 0) {
                        // Disconnect all Players
                        $time = $this->countGameTime($matches);
                        foreach ($this->players as $key => $id) {
                            $player = $this->getPlayerFromArray($key);
                            if (!is_null($player)) {
                                $message = "Disconnecting Player " . $player->getName() . " after " . $time ." seconds";
                                if ($this->app->Ctrl->Gametimes->stopGame($player, $time) !== false) {
                                    $level = "INFO";
                                } else {
                                    $level = "ERROR";
                                }
                            } else {
                                $level = "ERROR";
                                $message .= " Could not find user for ID '$id' in Array";
                            }
                            $this->logOutput($message, $l, $action, $level);
                        }
                    }
                }


                /*
                 ---- Scores at End game ----
                    - Set Triggers at the end of the Game
                */
                /* Gun Games: Set Trigger when Winner "Gunlimit hit" */
                preg_match($this->_gungameend,$line,$matches);
                if(count($matches) > 0){
                    $action = "End GunGame";
                    $this->winningteam = 0;
                    $this->_triggergungame = $matches[1].":".$matches[2];
                    $message = "Stopped at ".$matches[1].":".$matches[2] ."  (GunGame, Gunlimit hit: First Score will be winner)";
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }

                /* Timelimit hit */
                preg_match($this->_timelimit,$line,$matches);
                if(count($matches) > 0){
                    $action = "Timelimit";
                    $level = "INFO";
                    $this->winningteam = 0;
                    $this->triggertimelimit = true;
                    if($this->gametype->getCode() == 0) {
                        $this->_triggerfreegame = $matches[1] . ":" . $matches[2];
                        $message = "Stopped at " . $matches[1] . ":" . $matches[2] ." (FreeForAll: First Score will be winner)";
                        $this->logOutput($message, $l, $action, $level);
                    }else {
                        $this->_triggerfreegame = false;
                        $this->_triggergungame = false;
                        $message = "Stopped at ".$matches[1].":".$matches[2]." (winner are in winning team)";
                        $this->logOutput($message,$l,$action,$level);
                    }
                }

                /*
                ---- Team Scores ----
                */
                preg_match($this->_teamscore,$line,$matches);
                if(count($matches) > 0) {
                    $action = "Team Score";
                    $redscore = intval($matches[3]);
                    $bluescore = intval($matches[4]);
                    $this->winningteam = 0;
                    if($redscore > $bluescore){
                        $this->winningteam = 1;
                    }
                    if($redscore < $bluescore){
                        $this->winningteam = 2;
                    }
                    if($this->app->Ctrl->Games->updateScores($this->currentgame->getId(),$redscore,$bluescore,$this->half) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $message = "Red: ".$redscore." - Blue: ".$bluescore;
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                ---- Games Scores ----
                */
                preg_match($this->_score,$line,$matches);
                if(count($matches) > 0) {
                    $action = "Score";
                    $player = $this->getPlayerFromArray($matches[5]);
                    $winner = false;
                    $kills = $player->getKillsPerGame($this->currentgame);
                    $deaths = $player->getDeathsPerGame($this->currentgame);
                    $message = $player->getName()." [".$this->getTeamName($this->_teams[$matches[5]])."] (K:$kills / D:$deaths) Score: ".$matches[3]." Ping: ".$matches[4];
                    // For Gun Game, First is winner if Gunlimit hit
                    if($matches[1].":".$matches[2] == $this->_triggergungame && $this->_triggergungame !== false) {
                        $message.= " Gungame Trigger";
                        $winner = true;
                        $this->_triggergungame = false;
                    }
                    // For Free For All, First is winner
                    if($matches[1].":".$matches[2] == $this->_triggerfreegame && $this->_triggerfreegame !== false) {
                        $message.= " Free For All Trigger";
                        $winner = true;
                        $this->_triggerfreegame = false;
                    }
                    // For Team plays: if Player in Winning Team, set winner
                    if($this->winningteam != 0){
                        $message.= " Team Play Trigger";
                        $winner = ($this->_teams[$matches[5]] == $this->winningteam)?true:false;
                    }
                    $message .= ($winner)?" Winner!":"";
                    if($this->app->Ctrl->Scores->addScore($player,$this->currentgame,$kills,$deaths,$matches[3],$matches[4],$winner,$this->_teams[$matches[5]],$this->half) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                 ---- Player Connection ----
                    -
                */
                preg_match($this->_playerjoin,$line,$matches);
                if(count($matches) > 0){
                    $action = "Connection";
                    $playername = $this->getValueFromConnectionString($matches[4], "name");
                    if(strpos($playername,":27960") !== false){
                        // Skipped, because of Server Connection
                        $message = "Skipped, Server connection ($playername)";
                        $level = "INFO";
                    }else{
                        $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[4], "name"));
                        if (array_search($player->getId(), $this->_playersarray) === false) {
                            $this->players[$matches[3]] = $player->getId();
                            $time = $this->countGameTime($matches);
                            if ($this->app->Ctrl->Gametimes->add($player, $time)) {
                                $level = "INFO";
                            } else {
                                $level = "ERROR";
                            }
                            $message = $player->getName() . " (" . $matches[3] . ") connected at " . $time . " seconds";
                        }else{
                            $message = "Skipped, User ".$player->getName()." already in Game (GameID: ". $matches[3] .", Name: $playername)";
                            $level = "INFO";
                        }
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                 ---- Player Change ----
                    -
                */
                preg_match($this->_playerchange,$line,$matches);
                if(count($matches) > 0){
                    $action = "Change";
                    $player = $this->app->Ctrl->Players->getORadd($this->getValueFromConnectionString($matches[2],"n"));
                    $teamNb = $this->getValueFromConnectionString($matches[2],"t");
                    $this->_teams[$matches[1]] = $teamNb;
                    $message = $player->getName() ." is now in team ".$this->getTeamName($teamNb);
                    $level = "INFO";
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                 ---- Player Disconnection ----
                    -
                */
                preg_match($this->_playerquits,$line,$matches);
                if(count($matches) > 0){
                    $action = "Disconnection";
                    $time = $this->countGameTime($matches);
                    $player = $this->getPlayerFromArray($matches[3]);
                    if(!is_null($player)) {
                        $message = $player->getName(). " disconnected at ".$time." seconds";
                        if($this->app->Ctrl->Gametimes->stopGame($player, $time) !== false){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                    } else {
                        $level = "ERROR";
                        $message = "Could not find user for ID '".$matches[3]."' in Array";
                    }
                    try {
                        unset($this->players[$matches[3]]);
                    } catch(Exception $e){
                        $level = "ERROR";
                        $message = "Could not remove Player from Array";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                ---- Frag ----
                */
                preg_match($this->_frag,$line,$matches);
                if(count($matches) > 0){
                    $action ="Frag";
                    $this->frags++;
                    $fragger = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $fragged = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $weapon = $this->app->Ctrl->Weapons->getORadd($matches[3]);
                    $message = $fragger->getName(). " killed ". $fragged->getName()." with ".$weapon->getName();
                    if($this->app->Ctrl->Frags->add($fragger,$fragged,$weapon,$this->currentround) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                ---- Hit ----
                */
                preg_match($this->_hit,$line,$matches);
                if(count($matches) > 0){
                    $action = "Hit";
                    $this->hits++;
                    $hitter = $this->app->Ctrl->Players->getORadd($matches[1]);
                    $hitted = $this->app->Ctrl->Players->getORadd($matches[2]);
                    $part = $this->app->Ctrl->Hits->getBodyPart($matches[3]);
                    $message = $hitter->getName(). " hit ". $hitted->getName()." in ".$matches[3];
                    if($this->app->Ctrl->Hits->add($hitter,$hitted,$part,$this->currentround) !== false){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                ---- Bomb Action ----
                */
                preg_match($this->_bomb,$line,$matches);
                if(count($matches) > 0){
                    $action = "Bomb";
                    $event = $matches[1];
                    $message = "bomb $event ";
                    if($event == "planted" || $event == "defused") {
                        $player = $this->getPlayerFromArray($matches[2]);
                        if(!is_null($player)){
                            $message .= "by ".$player->getName();
                            if($event == "planted"){
                                $this->_bomber  = $player;
                            }elseif($event == "defused"){
                                $this->_bomber  = null;
                            }
                            if($this->app->Ctrl->Bombs->add($player, $event, $this->currentround)){
                                $level = "INFO";
                            }else{
                                $level = "ERROR";
                            }
                        } else {
                            $level = "ERROR";
                            $message .= "Could not find user for ID '".$matches[2]."' in Array";
                        }
                        $this->logOutput($message,$l,$action,$level);
                    }
                }
                preg_match($this->_bombexploded,$line,$matches);
                if(count($matches) > 0 && !is_null($this->_bomber)){
                    $event = "exploded";
                    $action = "Bomb";
                    $message = "bomb exploded (".$this->_bomber->getName(). ")";
                    if($this->app->Ctrl->Bombs->add($this->_bomber, $event, $this->currentround)){
                        $level = "INFO";
                    }else{
                        $level = "ERROR";
                    }
                    $this->_bomber = null;
                    $this->logOutput($message,$l,$action,$level);
                }


                /*
                ---- Flag Pickup ----
                */
                preg_match($this->_item,$line,$matches);
                if(count($matches) > 0){
                    if($matches[2] == "team_CTF_redflag" || $matches[2] == "team_CTF_blueflag"){
                        $action = "Flag Pickup";
                        $message = "Pick up ".str_replace("team_CTF_","",$matches[2]);
                        $player = $this->getPlayerFromArray($matches[1]);
                        if(!is_null($player)) {
                            $message .= " by ".$player->getName();
                            if($this->app->Ctrl->Flags->add($player,"catch",$this->currentround)){
                                $level = "INFO";
                            }else{
                                $level = "ERROR";
                            }
                        } else {
                            $level = "ERROR";
                            $message .= "Could not find user for ID '".$matches[1]."' in Array";
                        }
                        $this->logOutput($message,$l,$action,$level);
                    }
                }


                /*
                ---- Flag Return, Drop or Capture ----
                */
                preg_match($this->_flag,$line,$matches);
                if(count($matches) > 0){

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
                    $message = " $action ".str_replace("team_CTF_","",$matches[3]);
                    $player = $this->getPlayerFromArray($matches[1]);
                    if(!is_null($player)) {
                        $message .= " by ".$player->getName();
                        if($this->app->Ctrl->Flags->add($player,$event,$this->currentround)){
                            $level = "INFO";
                        }else{
                            $level = "ERROR";
                        }
                    } else {
                        $level = "ERROR";
                        $message .= " Could not find user for ID '".$matches[1]."' in Array";
                    }
                    $this->logOutput($message,$l,$action,$level);
                }
                $l++;
            }
            $time_end = microtime(true);
            $this->logOutput("Execution Time: ".gmdate("H:i:s",($time_end - $time_start)),"","","INFO");
            $this->logOutput("Script Done","","","INFO");
        }else{
            $this->logOutput("Could not open the Logfile","","","ERROR");
        }
    }


    public function getValueFromConnectionString($string,$marker){
        $str = explode("\\",$string);
        $key = array_search($marker, $str);
        return $str[$key + 1];
    }

    private function getPlayerFromArray($id){
        if(array_key_exists($id,$this->players)){
            try {
                $player = $this->app->Ctrl->Players->get($this->players[$id]);
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