<?php

namespace App\Controller;

use Base\Games;
use Propel\Runtime\Propel;

class Controller
{
    protected $app;
    /**
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }


    public function clearDBTests()
    {
        foreach(["bombs","flags","frags","gametimes","hits","teams","rounds","scores"] as $table) {
            $conn = Propel::getConnection();
            $stmt = $conn->prepare("DELETE FROM $table");
            $stmt->execute();
            $stmt = null;
            $stmt = $conn->prepare("ALTER TABLE $table AUTO_INCREMENT = 1");
            $stmt->execute();
            $stmt = null;
        }
    }

    public function clearNewDBTests()
    {
        foreach(["bombs","flags","frags","games","gamerounds","gamescores","gametimes","hits"] as $table) {
            $conn = Propel::getConnection();
            $stmt = $conn->prepare("DELETE FROM $table");
            $stmt->execute();
            $stmt = null;
            $stmt = $conn->prepare("ALTER TABLE $table AUTO_INCREMENT = 1");
            $stmt->execute();
            $stmt = null;
        }
    }


    public function logOutput($message, $line = "", $action = "", $level = "INFO")
    {
        $now = new \DateTime();
        $log = $now->format("Y-m-d H:i:s")." | ".$level." | ";
        if($line != "") {
            $log .= $line . ". ";
        }
        if($action != "") {
            $log .= "[". strtoupper($action)."] ";
        }
        $log .= $message;

        echo $log."\n";
    }

    public function getTeamName($id)
    {
        switch($id){
            case "0": $teamname = "Green"; break;
            case "1": $teamname = "Red"; break;
            case "2": $teamname = "Blue"; break;
            case "3": $teamname = "Spectator"; break;
            default: $teamname = "Unknown"; break;
        }
        return $teamname;
    }

    public function getLatestParseDate()
    {
        return \GamesQuery::create()->orderByCreated("DESC")->findOne()->getCreated()->format("Y-m-d");
    }
    public function getParseDates()
    {
        return \GamesQuery::create()->orderByCreated("DESC")->groupByCreated()->find();
    }

    public function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a jours, %h:%i:%s');
    }
}