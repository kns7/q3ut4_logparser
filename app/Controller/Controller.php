<?php

namespace App\Controller;

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

    
}