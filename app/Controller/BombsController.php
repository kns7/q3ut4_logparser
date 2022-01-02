<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 21:19
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class BombsController extends Controller
{
    public function add(\Players $player, $event)
    {
        $bomb = new \Bombs();
        $bomb->setPlayers($player)
            ->setEvent($event);
        try {
            $bomb->save();
            return $bomb;
        }catch (PropelException $e){
            return false;
        }
    }
}