<?php

use App\Controller\PlayersController;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Propel\Runtime\Propel;
use Slim\Slim;

require("../vendor/autoload.php");
require("../app/config/config.php");

// MySQL Configuration / Connection
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
    'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
    'dsn' => 'mysql:host='.$_SERVER['MYSQL_HOST'].';port='.$_SERVER['MYSQL_PORT'].';dbname='.$_SERVER['MYSQL_DB'],
    'user' => $_SERVER['MYSQL_USER'],
    'password' => $_SERVER['MYSQL_PASSWORD'],
    'attributes' =>
        array (
            'ATTR_EMULATE_PREPARES' => false,
            'ATTR_TIMEOUT' => 30,
        )
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');

$app = new Slim([
    'template.path' => 'templates/',
    'mode' => $_SERVER["SITE_MODE"]
]);

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

// Controllers declaration
$app->container->singleton('Ctrl',function() use ($app){
    return (object)[
        'Frags' => new \App\Controller\FragsController($app),
        'Hits' => new \App\Controller\HitsController($app),
        'Logs' => new LogsController($app),
        'Players' => new PlayersController($app),
        'Weapons' => new WeaponsController($app)
    ];
});

// Routes
$app->get('/',function() use ($app){
    $app->render('home.php',compact('app'));
})->name("root");

$app->group('/ajax',function() use($app){
    $app->get('/parselog',function() use($app){
        echo "<pre>";
        $app->Ctrl->Logs->parseLog("/var/www/private/q3ut4_logparser/logs/testlog.log");
        echo "</pre>";
    });
});

if($_SERVER['SITE_MODE'] == "development"){
    $app->group('/test', function() use($app){
       $app->get('/player/:player', function($player) use($app){
           echo "<pre>";
           print_r($app->Ctrl->Players->getORadd($player));
           echo "</pre>";
       });
    });
    $app->get('/logtest',function() use($app){
        echo "<pre>";
        echo "Opening Logfile...\n";
        $l = 1;
        $handle = fopen("../logs/testlog.log", "r");
        $hit = "/^ *[0-9]+:[0-9]{2} Hit: [0-9]+ [0-9]+ [0-9]+ [0-9]+: (.*) hit (.*) in the (.*)$/i";
        $frag = "/^ *[0-9]+:[0-9]{2} Kill: [0-9]+ [0-9]+ [0-9]+: (?!<world>)(.*) killed (.*) by (?!MOD_CHANGE_TEAM$|MOD_FALLING$|MOD_WATER$|MOD_LAVA$|UT_MOD_BLED$|UT_MOD_FLAG$)(.*)$/i";
        $hits = 0;
        $frags = 0;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                echo "Line $l \n";
                preg_match($hit,$line,$matches);
                if(count($matches)> 0){
                    echo "Fragger: ".$matches[1] ."\n";
                    echo "Fragged: ".$matches[2] ."\n";
                    echo "Where: ".$matches[3] ."\n";
                    $hits++;
                }
                preg_match($frag,$line,$matches);
                if(count($matches)> 0){
                    echo "Fragger: ".$matches[1]."\n";
                    echo "Fragged: ".$matches[2]."\n";
                    echo "Weapon: ".$matches[3]."\n";
                    $frags++;
                }
                $l++;
            }


            fclose($handle);
            echo "--------------------------\n";
            echo "Stats:\n";
            echo "Hits: $hits\n";
            echo "Frags: $frags\n";
            echo "--------------------------\n";
            echo "Closing Logfile\n";
            echo "</pre>";
        } else {
            return false;
        }
    });
}

$app->run();