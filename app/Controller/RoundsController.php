<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 20:32
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class RoundsController extends Controller
{
    public function add(\Gametypes $gametype,$nbplayers)
    {
        $round = new \Rounds();
        $round->setGametypes($gametype)
            ->setWinner("")
            ->setRedScore(0)
            ->setBlueScore(0)
            ->setNbplayers($nbplayers);
        try {
            $round->save();
            $newround = \RoundsQuery::create()->orderById("DESC")->findOne();
            return $newround;
        } catch (PropelException $e){
            return false;
        }
    }

    public function updateResults($roundid, $redscore, $bluescore, $winner)
    {
        $round = \RoundsQuery::create()->findPk($roundid);
        $round->setBlueScore($bluescore)
            ->setRedScore($redscore)
            ->setWinner($winner);

        try {
            $round->save();
            return $round;
        } catch(PropelException $e){
            return false;
        }
    }

    public function getNextRoundNB()
    {
        $query = \GameroundsQuery::create()->orderByRoundNB("DESC")->findOne();
        return (is_null($query))? 1: $query->getRoundNB() + 1;
    }

    public function addRound(\Games $game, $roundnb,$half = 1)
    {
        $round = new \Gamerounds();
        $round->setGames($game)
            ->setRoundNB($roundnb)
            ->setHalf($half);

        try {
            $round->save();
            $newround = \GameroundsQuery::create()->orderById("DESC")->findOne();
            return $newround;
        } catch(PropelException $e){
            return false;
        }
    }

    public function deleteFromGame($gameid)
    {
        try {
            \GameroundsQuery::create()->filterByGameID($gameid)->delete();
            return true;
        } catch (PropelException $e){
            return false;
        }
    }
}