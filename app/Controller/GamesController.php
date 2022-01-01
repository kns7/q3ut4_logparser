<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 18:45
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class GamesController extends Controller
{
    public function add(\Players $player, $start)
    {
        $game = new \Games();
        $game->setPlayers($player)
            ->setStart($start)
            ->setStop("-1");

        try{
            $game->save();
            return $game;
        }catch (PropelException $e){
            return false;
        }
    }

    public function stopGame(\Players $player,$stop)
    {
        $game = \GamesQuery::create()->filterByPlayers($player)->filterByStop("-1")->findOne();
        if(!is_null($game)){
            $game->setStop($stop);
            try {
                $game->save();
                return $game;
            }catch (PropelException $e){
                return false;
            }
        }else{
            return false;
        }
    }
}