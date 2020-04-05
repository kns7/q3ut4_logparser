<?php

namespace App\Controller;

use PlayersQuery;

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

    public function getFrags()
    {
        
    }
}
