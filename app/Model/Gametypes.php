<?php

use Base\Gametypes as BaseGametypes;

/**
 * Skeleton subclass for representing a row from the 'gametypes' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Gametypes extends BaseGametypes
{
    public function getRoundsCount($date = false)
    {
        $query = \GamesQuery::create()->filterByGametypeId($this->getId())->filterByNbplayers(0,\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL);
        if($date !== false){
            $query->filterByCreated($date);
        }
        return $query->count();
    }
}
