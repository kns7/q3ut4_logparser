<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 20:31
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class TeamsController extends Controller
{
    public function add($round_id,\Players $player, $team)
    {
        $teams = new \Teams();
        $teams->setPlayers($player)
            ->setRoundId($round_id)
            ->setTeam($team);
        try {
            $teams->save();
            return $teams;
        } catch(PropelException $e){
            return false;
        }
    }
}