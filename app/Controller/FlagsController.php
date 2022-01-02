<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 22:19
 */

namespace App\Controller;


class FlagsController extends Controller
{
    public function add(\Players $player, $event)
    {
        $flag = new \Flags();
        $flag->setPlayers($player)
            ->setEvent($event);
        try {
            $flag->save();
            return $flag;
        }catch (PropelException $e){
            return false;
        }
    }
}