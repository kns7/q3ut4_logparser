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
        'Games' => new \App\Controller\GamesController($app),
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
        $app->Ctrl->Logs->clearDBTests();
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
        $join = "/^ *([0-9]+):([0-9]+) ClientUserinfo: ([0-9]+) (.*)$/i";
        $quit = "/^ *([0-9]+):([0-9]+) ClientDisconnect: ([0-9]+)$/i";
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                preg_match($join,$line,$matches);
                $l++;
            }


            fclose($handle);
            echo "--------------------------\n";
            echo "Stats:\n";

            echo "--------------------------\n";
            echo "Closing Logfile\n";
            echo "</pre>";
        } else {
            return false;
        }
    });
}

$app->run();