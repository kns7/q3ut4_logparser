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
    private $_teamscore = "/^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$/i";
    private $_chat = "/^ *[0-9]+:[0-9]{2} (say|sayteam): [0:9]+ (?!<world>)(.*): (.*)$/i";

    public function parseLog($log)
    {
        $handle = fopen($log, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                /* Check Frag */
                preg_match($this->_frag,$line,$matches);
                if(count($matches) > 0){
                    echo "Frag found! ";
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
                    echo "Hit found! ";
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
            }

            fclose($handle);
        } else {
            return false;
        }
    }
}