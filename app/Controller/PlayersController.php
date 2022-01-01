<?php

namespace App\Controller;

use Players;
use PlayersQuery;
use Propel\Runtime\Exception\PropelException;

class PlayersController extends Controller
{

    public function getList()
    {
        return PlayersQuery::create()->orderByName()->find();
    }

    public function get($id)
    {
        return PlayersQuery::create()->findPk($id);
    }

    public function getByName($name){
        return PlayersQuery::create()->findOneByName($name);
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
        $player = PlayersQuery::create()
            ->where("players.name = ?","$name")
            ->_or()
            ->where("players.altname LIKE ?","%$name%")
            ->findOne();
        if(is_null($player)){
            $player = $this->add($name);
        }
        return $player;
    }
}
