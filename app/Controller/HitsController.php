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
    function add(\Players $hitter,\Players $hitted, \Bodyparts $part){
        $hit = new \Hits();
        $hit->setHitter($hitter)
            ->setHitted($hitted)
            ->setBodyparts($part);

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