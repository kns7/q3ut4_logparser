<?php

use App\Controller\PlayersController;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Propel\Runtime\Propel;
use Slim\Slim;

require("../vendor/autoload.php");
require("../app/config/config.php");

// MySQL Configuration / Connection
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion(2);
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
    'dsn' => 'mysql:host='.$config['MYSQL_HOST'].';port='.$config['MYSQL_PORT'].';dbname='.$config['MYSQL_DB'],
    'user' => $config['MYSQL_USER'],
    'password' => $config['MYSQL_PASSWD'],
    'settings' =>
        array (
            'charset' => 'utf8',
            'queries' =>
                array (
                ),
        ),
    'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
    'model_paths' =>
        array (
            0 => 'src',
            1 => 'vendor',
        ),
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');
require_once __DIR__ . '/../app/config/loadDatabase.php';


$app = new Slim([
    'template.path' => 'templates/',
    'mode' => $config["SITE_MODE"]
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
        'Bombs' => new \App\Controller\BombsController($app),
        'Flags' => new \App\Controller\FlagsController($app),
        'Frags' => new \App\Controller\FragsController($app),
        'Games' => new \App\Controller\GamesController($app),
        'Gametimes' => new \App\Controller\GametimesController($app),
        'Gametypes' => new \App\Controller\GametypesController($app),
        'Hits' => new \App\Controller\HitsController($app),
        'Logs' => new LogsController($app),
        'Maps' => new \App\Controller\MapsController($app),
        'Players' => new PlayersController($app),
        'Rounds' => new \App\Controller\RoundsController($app),
        'Scores' => new \App\Controller\ScoresController($app),
        'Stats' => new \App\Controller\StatsController($app),
        'Weapons' => new WeaponsController($app)
    ];
});

if($config["PARSE_MODE"] == "full") {
    $app->Ctrl->Logs->clearNewDBTests();
}
$app->Ctrl->Logs->logParser($config["PARSE_LOGFILE"]);