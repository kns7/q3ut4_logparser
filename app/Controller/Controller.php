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


    
}