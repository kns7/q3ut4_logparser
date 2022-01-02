<?php

use App\Controller\Controller;
use Propel\Runtime\Exception\PropelException;

class WeaponsController extends Controller {

    public function getList()
    {
        return WeaponsQuery::create()->filterByType("world",\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->orderByName()->find();
    }

    public function get($id)
    {
        return WeaponsQuery::create()->findPk($id);
    }

    public function add($code,$name="")
    {
        $weapon = new Weapons();
        $weapon->setCode($code)
                ->setName($name);   
        try {
            $weapon->save();
            return $weapon;
        } Catch(PropelException $e){
            return false;
        }
    }

    public function getORadd($code)
    {
        if($code == "UT_MOD_HK69_HIT"){ $code = "UT_MOD_HK69"; }
        $weapon = WeaponsQuery::create()->findOneByCode($code);
        if(is_null($weapon)){
            $weapon = $this->add($code);
        }
        return $weapon;
    }
}