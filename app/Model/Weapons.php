<?php

use Base\Weapons as BaseWeapons;

/**
 * Skeleton subclass for representing a row from the 'weapons' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Weapons extends BaseWeapons
{
    public function getKills()
    {
        return \FragsQuery::create()->filterByWeaponId($this->getId())->count();
    }
}
