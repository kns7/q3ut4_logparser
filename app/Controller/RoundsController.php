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
    public function add(\Gametypes $gametype){
        $round = new \Rounds();
        $round->setGametypes($gametype)
            ->setWinner("")
            ->setRedScore(0)
            ->setBlueScore(0);
        try {
            $round->save();
            return $round;
        } catch (PropelException $e){
            return false;
        }
    }
}