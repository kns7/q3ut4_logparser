<?php

use Base\Players as BasePlayers;

/**
 * Skeleton subclass for representing a row from the 'players' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Players extends BasePlayers
{
    public function getKills()
    {
        return \FragsQuery::create()->filterByFraggerId($this->getId())->filterByFraggedId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->count();
    }

    public function getDeaths()
    {
        return \FragsQuery::create()->filterByFraggedId($this->getId())->filterByFraggerId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->count();
    }

    public function getPlayingTime()
    {
        $times = \GamesQuery::create()->filterByPlayerId($this->getId())->filterByStop("-1", \Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->withColumn("SUM(stop-start)","times")->find();
        $return = 0;
        foreach($times as $t){
            $return += $t->getTimes();
        }
        return $return;
    }
}
