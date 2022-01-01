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
        $conn = Propel::getConnection();
        $stmt = $conn->prepare("TRUNCATE TABLE frags");
        $stmt->execute();
        $stmt = null;
        $stmt = $conn->prepare("TRUNCATE TABLE hits");
        $stmt->execute();
        $stmt = null;
        $stmt = $conn->prepare("ALTER TABLE frags AUTO_INCREMENT = 1");
        $stmt->execute();
        $stmt = null;
        $stmt = $conn->prepare("ALTER TABLE hits AUTO_INCREMENT = 1");
        $stmt->execute();
        $stmt = null;
        $stmt = $conn->prepare("TRUNCATE TABLE games");
        $stmt->execute();
        $stmt = null;
        $stmt = $conn->prepare("ALTER TABLE games AUTO_INCREMENT = 1");
        $stmt->execute();
        $stmt = null;
    }


    
}