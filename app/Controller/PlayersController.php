<?php

namespace App\Controller;

use Players;
use PlayersQuery;
use Propel\Runtime\Exception\PropelException;

class PlayersController extends Controller
{

    public function list()
    {
        return PlayersQuery::create()->orderByName()->find();
    }

    public function get($id)
    {
        return PlayersQuery::create()->findPk($id);
    }

    public function add($name)
    {
        $player = new Players();
        $player->setName($name);
        try {
            $player->save();
            return $player;
        }Catch (PropelException $e){
            return false;
        }
    }

    public function getORadd($name)
    {
        $player = PlayersQuery::create()->findOneByCode($name);
        if(is_null($player)){
            $player = $this->add($name);
        }
        return $player;
    }
}
