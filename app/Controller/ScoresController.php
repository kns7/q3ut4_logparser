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
    public function add(\Players $player, $score)
    {
        $scores = new \Scores();
        $scores->setPlayers($player)
            ->setScore($score);

        try {
            $scores->save();
            return $scores;
        } catch (PropelException $e){
            return false;
        }
    }
}