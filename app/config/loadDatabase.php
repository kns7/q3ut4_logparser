<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'default' => 
  array (
    0 => '\\Map\\BodypartsTableMap',
    1 => '\\Map\\BombsTableMap',
    2 => '\\Map\\ConfigTableMap',
    3 => '\\Map\\FlagsTableMap',
    4 => '\\Map\\FragsTableMap',
    5 => '\\Map\\GameroundsTableMap',
    6 => '\\Map\\GamesTableMap',
    7 => '\\Map\\GamescoresTableMap',
    8 => '\\Map\\GametimesTableMap',
    9 => '\\Map\\GametypesTableMap',
    10 => '\\Map\\HitsTableMap',
    11 => '\\Map\\MapsTableMap',
    12 => '\\Map\\PlayersTableMap',
    13 => '\\Map\\WeaponsTableMap',
  ),
));
