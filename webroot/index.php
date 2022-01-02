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
        'Bombs' => new \App\Controller\BombsController($app),
        'Flags' => new \App\Controller\FlagsController($app),
        'Frags' => new \App\Controller\FragsController($app),
        'Games' => new \App\Controller\GamesController($app),
        'Gametypes' => new \App\Controller\GametypesController($app),
        'Hits' => new \App\Controller\HitsController($app),
        'Logs' => new LogsController($app),
        'Players' => new PlayersController($app),
        'Rounds' => new \App\Controller\RoundsController($app),
        'Scores' => new \App\Controller\ScoresController($app),
        'Stats' => new \App\Controller\StatsController($app),
        'Teams' => new \App\Controller\TeamsController($app),
        'Weapons' => new WeaponsController($app)
    ];
});

// Routes
$app->get('/',function() use ($app){
    $frags = $app->Ctrl->Stats->getFragRanking();
    $ratios = $app->Ctrl->Stats->getKDRatioRanking();
    $times = $app->Ctrl->Stats->getPlayingTime();
    $app->render('home.php',compact('app','frags','ratios','times'));
})->name("root");

$app->get('/player',function() use($app){
    $app->render('player.php',compact('app'));
})->name('player');

$app->get('/vs',function() use($app){
    $app->render('versus.php',compact('app'));
})->name('vs');



$app->group('/ajax',function() use($app){
    $app->get('/parselog',function() use($app){
        $app->Ctrl->Logs->clearDBTests();
        echo "<pre>";
        $app->Ctrl->Logs->parseLog("/var/www/private/q3ut4_logparser/logs/log2.log");
        echo "</pre>";
    });

    $app->get('/stats/:player',function($player) use($app){

    });

    $app->get('/vs/:player1/:player2',function($player1,$player2) use($app){

    });
});

if($_SERVER['SITE_MODE'] == "development"){
    $app->group('/test', function() use($app){
       $app->get('/player/:player', function($player) use($app){
           echo "<pre>";
           print_r($app->Ctrl->Players->getORadd($player));
           echo "</pre>";
       });
       $app->get('/newround',function() use($app){
           $gametype = $app->Ctrl->Gametypes->getByCode(8);
            $newround = $app->Ctrl->Rounds->add($gametype);
            echo "<pre>";
            print_r($newround);
            echo '</pre>';
       });
       $app->get('/connectionstring',function() use($app){
            $string = '\ip\146.199.115.89:27960\snaps\20\name\Manics69\password\marchelle\racered\3\raceblue\3\racefree\0\rate\25000\ut_timenudge\0\cg_rgb\128 128 128\cg_physics\1\cg_ghost\1\cg_autopickup\-1\sex\male\handicap\100\color2\5\color1\4\gear\GZAORWA\authc\0\cl_guid\83BCF5AF7EC2318AE35629B4830449D7\weapmodes\0000011022000002000200000000';
            echo $app->Ctrl->Logs->getValueFromConnectionString($string,"name");
       });
    });

}

$app->run();