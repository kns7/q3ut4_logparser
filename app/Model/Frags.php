<?php

use Base\Frags as BaseFrags;

/**
 * Skeleton subclass for representing a row from the 'frags' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Frags extends BaseFrags
{
    public function preInsert(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        $this->setWeek(date("Y-W"));
        return true;
    }
}
