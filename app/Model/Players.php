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
    public function getKills($date = false)
    {
        $query = \FragsQuery::create()->filterByFraggerId($this->getId())->filterByFraggedId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL);
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getKillsDetails($date = false)
    {
        $query = \FragsQuery::create()->filterByFraggerId($this->getId())->filterByFraggedId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->withColumn("COUNT(*)","Kills")->groupByFraggedId()->orderBy("Kills","DESC");
        if($date != false){ $query->filterByCreated($date); }
        return $query->find();
    }

    public function getKillsPerPlayer($player_id,$date = false)
    {
        $query = \FragsQuery::create()->filterByFraggerId($this->getId())->filterByFraggedId($player_id);
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getDeaths($date = false)
    {
        $query = \FragsQuery::create()->filterByFraggedId($this->getId())->filterByFraggerId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL);
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getDeathsDetails()
    {
        return \FragsQuery::create()->filterByFraggedId($this->getId())->filterByFraggerId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->withColumn("COUNT(*)","Deaths")->groupByFraggerId()->orderBy("Deaths","DESC")->find();
    }

    public function getDeathsPerPlayer($player_id)
    {
        return \FragsQuery::create()->filterByFraggedId($this->getId())->filterByFraggerId($player_id)->count();
    }

    public function getHitsDoneDetails()
    {
        return \HitsQuery::create()->filterByHitterId($this->getId())->withColumn("COUNT(*)","Hitsdone")->groupByBodypartId()->orderBy("Hitsdone","DESC")->find();
    }

    public function getHitsDoneToPlayer($player_id)
    {
        return \HitsQuery::create()->filterByHitterId($this->getId())->filterByHittedId($player_id)->withColumn("COUNT(*)","Hitsdone")->groupByBodypartId()->orderBy("Hitsdone","DESC")->find();
    }

    public function getHitsTakenDetails()
    {
        return \HitsQuery::create()->filterByHittedId($this->getId())->withColumn("COUNT(*)","Hitstaken")->groupByBodypartId()->orderBy("Hitstaken","DESC")->find();
    }

    public function getHitsTakenByPlayer($player_id)
    {
        return \HitsQuery::create()->filterByHittedId($this->getId())->filterByHitterId($player_id)->withColumn("COUNT(*)","Hitsdone")->groupByBodypartId()->orderBy("Hitsdone","DESC")->find();
    }

    public function getRatio()
    {
        return ($this->getDeaths() != 0)? $this->getKills() / $this->getDeaths(): 0;
    }

    public function getPlayingTime($date = false)
    {
        $times = \GametimesQuery::create()->filterByPlayerId($this->getId())->filterByStop("-1", \Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->withColumn("SUM(stop-start)","times");
        if($date != false){ $times->filterByCreated($date); }
        $times->find();
        $return = 0;
        foreach($times as $t){
            $return += $t->getTimes();
        }
        return $return;
    }

    public function getRoundWins($date = false)
    {
        $query = \GamescoresQuery::create()->filterByPlayerId($this->getId())->filterByWinner(true)->filterByTeam("1")->_or()->filterByTeam("2");
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getRoundLooses($date = false)
    {
        $query = \GamescoresQuery::create()->filterByPlayerId($this->getId())->filterByWinner(false)->filterByTeam("1")->_or()->filterByTeam("2");
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getWeaponsRank($type = "",$date = false)
    {
        $query = \FragsQuery::create()
            ->filterByFraggerId($this->getId())
            ->filterByFraggedId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
            //->filterByRoundId($rounds,\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
            ->withColumn("COUNT(*)","kills");
        if($date != false){ $query->filterByCreated($date); }
        switch($type){
            default:
                break;

            case "primary":
                $query->filterByWeaponId([1,2,3,4,5,6,7,8,9]);
                break;

            case "secondary":
                $query->filterByWeaponId([10,11,12,13,14,15]);
                break;

            case "sidearm":
                $query->filterByWeaponId([16,17,18,19,20]);
                break;

            case "grenade":
                $query->filterByWeaponId([4,22]);
                break;

            case "sniper":
                $query->filterByWeaponId([5,8,9]);
                break;
        }

        return $query->groupByWeaponId()->orderBy("kills","DESC")->find();
    }


    public function getBombsCount($type = "all", $date = false)
    {
        $query = \BombsQuery::create()->filterByPlayerId($this->getId());
        if($date != false){ $query->filterByCreated($date); }
        switch($type){
            case "all":

                break;

            default:
                $query->filterByEvent($type);
                break;
        }
        return $query->count();
    }

    public function getGametypeWins($gametype_id,$date = false)
    {
        $games = GamesQuery::create()->filterByGametypeId($gametype_id)->select("id")->find()->toArray();
        $query = GamescoresQuery::create()->filterByPlayerId($this->getId())->filterByGameID($games)->filterByWinner(true);
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getCTFCount($type = "all",$date = false)
    {
        $query = \FlagsQuery::create()->filterByPlayerId($this->getId());
        switch($type){
            case "all":

                break;

            default:
                $query->filterByEvent($type);
                break;
        }
        if($date != false){ $query->filterByCreated($date); }
        return $query->count();
    }

    public function getKillsPerGame(\Games $game)
    {
        $rounds = \GameroundsQuery::create()->filterByGames($game)->select("id")->find()->toArray();
        return \FragsQuery::create()
            ->filterByFraggerId($this->getId())
            ->filterByRoundId($rounds)
            ->filterByFraggedId($this->getId(),\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
            ->count();
    }

    public function getDeathsPerGame(\Games $game)
    {
        $rounds = \GameroundsQuery::create()->filterByGames($game)->select("id")->find()->toArray();
        return \FragsQuery::create()
            ->filterByFraggedId($this->getId())
            ->filterByRoundId($rounds)
            ->count();
    }

    public function getMapsWins($date = false)
    {
        $query = \GamescoresQuery::create()
            ->filterByPlayerId($this->getId())
            ->filterByWinner(true)
            ->useGamesQuery()
            ->groupByMapId()
            ->endUse()
            ->withColumn("COUNT(*)","wins")
            ->orderBy("wins","DESC");
        if($date != false){ $query->filterByCreated($date); }
        return $query->find();
    }
}

