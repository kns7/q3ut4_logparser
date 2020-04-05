<?php

use Propel\Runtime\Connection\ConnectionManagerSingle;
use Propel\Runtime\Propel;
use Slim\Slim;

require("../vendor/autoload.php");

// MySQL Configuration / Connection
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('vmail', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
    'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
    'dsn' => 'mysql:host='.$config['MYSQL_HOST'].';port='.$config['MYSQL_PORT'].';dbname='.$config['MYSQL_DB'],
    'user' => $config['MYSQL_USER'],
    'password' => $config['MYSQL_PASSWD'],
    'attributes' =>
        array (
            'ATTR_EMULATE_PREPARES' => false,
            'ATTR_TIMEOUT' => 30,
        )
));
$manager->setName('vmail');