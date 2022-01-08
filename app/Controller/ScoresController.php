<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 22:20
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class ScoresController extends Controller
{
    public function addScore(\Players $player, \Games $game, $kills, $deaths, $points, $ping, $winner,$team, $half = 1)
    {
        $score = new \Gamescores();
        $score->setPlayers($player)
            ->setGames($game)
            ->setKills($kills)
            ->setDeaths($deaths)
            ->setScore($points)
            ->setPing($ping)
            ->setWinner($winner)
            ->setTeam($team)
            ->setHalf($half);
        try {
            $score->save();
            return $score;
        } catch (PropelException $e){
            return false;
        }
    }
}