<?php

use Base\Bombs as BaseBombs;

/**
 * Skeleton subclass for representing a row from the 'bombs' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Bombs extends BaseBombs
{
    public function preInsert(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        $this->setWeek(date("Y-W"));
        return true;
    }
}
