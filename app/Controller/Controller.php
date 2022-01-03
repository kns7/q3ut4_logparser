<?php

namespace App\Controller;

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
        foreach(["bombs","flags","frags","games","hits","teams","rounds","scores"] as $table) {
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
}