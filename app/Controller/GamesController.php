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
    public function add($gamenb, $map, \Gametypes $gametype, $timelimit, $roundtime,$nbplayers)
    {
        $game = new \Games();

        $game->setGamestypes($gametype)
            ->setGameNB($gamenb)
            ->setTimelimit($timelimit)
            ->setRoundtime($roundtime)
            ->setNbplayers($nbplayers);
        if(!is_null($map)){
            $game->setMaps($map);
        }else{
            $game->setMapId(0);
        }

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

    public function updateGametype($id, $gametype)
    {
        $game = \GamesQuery::create()->findPk($id);
        if(!is_null($game)){
            if(!is_null($gametype)){
                $game->setGamestypes($gametype);
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
    }

    public function updateMap($id,$map){
        $game = \GamesQuery::create()->findPk($id);
        if(!is_null($game)){
            if(!is_null($map)){
                $game->setMaps($map);
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