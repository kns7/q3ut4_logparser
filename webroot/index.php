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
    $app->render('home.php',compact('app'));
})->name("root");

$app->get('/player',function() use($app){
    $players = $app->Ctrl->Players->getList();
    $app->render('player.php',compact('app','players'));
})->name('player');

$app->get('/vs',function() use($app){
    $players = $app->Ctrl->Players->getList();
    $app->render('versus.php',compact('app','players'));
})->name('vs');

$app->get('/weapon/:id',function($id) use($app){
    $app->Ctrl->Weapons->get($id);
    $app->render('weapon.php',compact('app','weapon'));
})->name('weapon');




$app->group('/views',function() use($app){
    $app->get('/home',function() use($app){
        $frags = $app->Ctrl->Stats->getFragRanking();
        $ratios = $app->Ctrl->Stats->getKDRatioRanking();
        $times = $app->Ctrl->Stats->getPlayingTime();
        $winlooses = $app->Ctrl->Stats->getRoundsWinLooses();
        $weapons = $app->Ctrl->Stats->getStatsWeapons();
        $snipers = $app->Ctrl->Stats->getFragRanking("sniper");
        $grenades = $app->Ctrl->Stats->getFragRanking("grenade");
        $knives = $app->Ctrl->Stats->getFragRanking("knife");
        $bombs = $app->Ctrl->Stats->getStatsBombs();
        $ggame = $app->Ctrl->Stats->getStatsGunGame();
        $ffa = $app->Ctrl->Stats->getStatsFFA();
        $ctf = $app->Ctrl->Stats->getStatsCTF();
        $app->render('partials/home.php',compact('app','frags','ratios','times','winlooses','weapons','snipers','grenades','knives', 'bombs', 'ggame', 'ffa', 'ctf'));
    });
    $app->get('/stats/:player',function($player) use($app){
        $player = $app->Ctrl->Players->get($player);
        $app->render('partials/player.php',compact('app','player'));
    });

    $app->get('/vs/:player1/:player2',function($player1,$player2) use($app){
        $p1 = $app->Ctrl->Players->get($player1);
        $p2 = $app->Ctrl->Players->get($player2);
        $app->render('partials/versus.php',compact('app','p1','p2'));
    });
});




$app->group("/ajax",function() use($app){
    $app->group('/charts',function() use($app){
        $app->get('/weapons-use',function() use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Stats->getStatsWeapons()["weapons"] as $w){
                array_push($datas,$w["kills"]);
                array_push($labels,$w["name"]);
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/gametypes',function() use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Stats->getStatsGametypes()["gametypes"] as $g){
                array_push($datas,$g["rounds"]);
                array_push($labels,$g["name"]);
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-kills/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getKillsDetails() as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getFragged()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-deaths/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getDeathsDetails() as $p){
                array_push($datas,$p->getDeaths());
                array_push($labels,$p->getFragger()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-hitsdone/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getHitsDoneDetails() as $p){
                array_push($datas,$p->getHitsdone());
                array_push($labels,$p->getBodyparts()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-hitstaken/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getHitsTakenDetails() as $p){
                array_push($datas,$p->getHitstaken());
                array_push($labels,$p->getBodyparts()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weapon/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank() as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weaponprimary/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank("primary") as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weaponsecondary/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank('secondary') as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weaponsidearm/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank('sidearm') as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weaponsniper/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank('sniper') as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/player-weapongrenade/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $datas = [];
            $labels = [];
            foreach($app->Ctrl->Players->get($id)->getWeaponsRank('grenade') as $p){
                array_push($datas,$p->getKills());
                array_push($labels,$p->getWeapons()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });

        $app->get('/vs-killsdeath/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $ids = explode("_",$id);
            $p1 = $app->Ctrl->Players->get($ids[0]);
            $p2 = $app->Ctrl->Players->get($ids[1]);
            $datas = [$p1->getKillsPerPlayer($ids[1]),$p1->getDeathsPerPlayer($ids[1])];
            $labels = ["Frags de ".$p1->getName(),"Frags de ".$p2->getName()];
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });
        $app->get('/vs-hits/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $ids = explode("_",$id);
            $player = $app->Ctrl->Players->get($ids[0]);
            $datas = [];
            $labels = [];
            foreach($player->getHitsDoneToPlayer($ids[1]) as $p){
                array_push($datas,$p->getHitsdone());
                array_push($labels,$p->getBodyparts()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });
        $app->get('/vs-hits2/:id',function($id) use($app){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json; charset=utf-8');
            $ids = explode("_",$id);
            $player = $app->Ctrl->Players->get($ids[0]);
            $datas = [];
            $labels = [];
            foreach($player->getHitsDoneToPlayer($ids[1]) as $p){
                array_push($datas,$p->getHitsdone());
                array_push($labels,$p->getBodyparts()->getName());
            }
            $return = new StdClass();
            $return->datas = $datas;
            $return->labels = $labels;
            echo json_encode($return);
        });
    });
});




if($_SERVER['SITE_MODE'] == "development"){
    $app->group('/test', function() use($app){
       $app->get('/player/:player', function($player) use($app){
           echo "<pre>";
           $player = $app->Ctrl->Players->get($player);
           echo $player->getName();
           print_r(\RoundsQuery::create()->filterByGametypeId(1)->filterByWinner($player->getId())->find());
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