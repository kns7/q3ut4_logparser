<?php

use App\Controller\Controller;

class LogsController extends Controller {
    private $_frag = "^ *[0-9]+:[0-9]{2} Kill: [0-9]+ [0-9]+ [0-9]+: (?!<world>)(.*) killed (.*) by (?!MOD_CHANGE_TEAM$|MOD_FALLING$|MOD_WATER$|MOD_LAVA$|UT_MOD_BLED$|UT_MOD_FLAG$)(.*)$";
    private $_playerjoin = '^ *([0-9]+):([0-9]+) ClientUserinfo: ([0-9]+) (.*)$';
    private $_playerchange = "^ *[0-9]+:[0-9]+ ClientUserinfoChanged: ([0-9]+) (.*)$";
    private $_playerquits = "^ *([0-9]+):([0-9]+) ClientDisconnect: ([0-9]+)$";
    private $_endgame = "^ *([0-9]+):([0-9]+) ShutdownGame:$";
    private $_initround = "^ *([0-9]+):([0-9]+) InitRound: (.*)$";
    private $_item = "^ *[0-9]+:[0-9]{2} Item: ([0-9]+) (?!<world>)(.*)$";
    private $_flag = "^ *[0-9]+:[0-9]{2} Flag: ([0-9]+) ([0-9]+): (.*)$";
    private $_teamscore = "^ *([0-9]+):([0-9]+) red:([0-9]+)[ ]*blue:([0-9]+)$";
    private $_chat = "^ *[0-9]+:[0-9]{2} (say|sayteam): [0:9]+ (?!<world>)(.*): (.*)$";

    public function parseLog($log)
    {
        
    }
}