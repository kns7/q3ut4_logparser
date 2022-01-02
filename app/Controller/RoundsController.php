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
}