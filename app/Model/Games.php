<?php

use Base\Games as BaseGames;

/**
 * Skeleton subclass for representing a row from the 'games' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Games extends BaseGames
{
    public function preInsert(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        $date = new \DateTime();
        $date->modify("-1 day");
        $this->setCreated($date->format("Y-m-d"));
        return true;
    }

    public function getTeamsMemberCount($team,$half = false){
        if($half !== false){
            return \GamescoresQuery::create()->filterByGameID($this->getId())->filterByTeam($team)->filterByHalf($half)->count();
        }else{
            return \GamescoresQuery::create()->filterByGameID($this->getId())->filterByTeam($team)->count();
        }
    }
}
