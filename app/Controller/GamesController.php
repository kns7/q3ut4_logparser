<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 04/01/22
 * Time: 17:32
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class GamesController extends Controller
{
    public function add($gamenb, \Maps $map, \Gametypes $gametype, $timelimit, $roundtime,$nbplayers)
    {
        $game = new \Games();
        $game->setMaps($map)
            ->setGamestypes($gametype)
            ->setGameNB($gamenb)
            ->setTimelimit($timelimit)
            ->setRoundtime($roundtime)
            ->setNbplayers($nbplayers);

        try {
            $game->save();
            $newgame = \GamesQuery::create()->orderById("DESC")->findOne();
            return $newgame;
        } catch (PropelException $e){
            return false;
        }
    }

    public function getNextGameNB()
    {
        $query = \GamesQuery::create()->orderByGameNB("DESC")->findOne();
        return (is_null($query))? 1: $query->getGameNB() + 1;
    }

    public function update($id, $nbplayers)
    {
        $game = \GamesQuery::create()->findPk($id);
        if(!is_null($game)){
            if($game->getNbplayers() < $nbplayers){
                $game->setNbplayers($nbplayers);
                try {
                    $game->save();
                } catch(PropelException $e){
                    return false;
                }
            }
            return $game;
        }else{
            return false;
        }
    }

    public function updateScores($id, $redscore, $bluescore)
    {
        $game = \GamesQuery::create()->findPk($id);
        if(!is_null($game)){

            $game->setRedScore($redscore)
            ->setBlueScore($bluescore);
            try {
                $game->save();
            } catch(PropelException $e){
                return false;
            }
            return $game;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        $game = \GamesQuery::create()->findPk($id);
        if(!is_null($game)){
            try {
                $game->delete();
                return true;
            } catch(PropelException $e){
                return false;
            }
        }else{
            return false;
        }
    }

    public function getList()
    {
        return \GamesQuery::create()->orderByName()->find();
    }

    public function get($id)
    {
        return \GamesQuery::create()->findPk($id);
    }
}