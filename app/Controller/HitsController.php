<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 16:19
 */

namespace App\Controller;


class HitsController extends Controller
{
    function add(\Players $hitter,\Players $hitted, \Bodyparts $part, \Gamerounds $round){
        $hit = new \Hits();
        $hit->setHitter($hitter)
            ->setHitted($hitted)
            ->setBodyparts($part)
            ->setRounds($round);

        try {
            $hit->save();
            return $hit;
        }catch(PropelException $e){
            return false;
        }
    }

    function getBodyPart($part){
        return \BodypartsQuery::create()->findOneByCode($part);
    }
}