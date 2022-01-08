<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 01/01/22
 * Time: 16:05
 */

namespace App\Controller;


use Propel\Runtime\Exception\PropelException;

class FragsController extends Controller
{
    function add(\Players $fragger,\Players $fragged, \Weapons $weapon, \Gamerounds $round){
        $frag = new \Frags();
        $frag->setFragger($fragger)
            ->setFragged($fragged)
            ->setWeapons($weapon)
            ->setRounds($round);

        try {
            $frag->save();
            return $frag;
        }catch(PropelException $e){
            return false;
        }
    }
}