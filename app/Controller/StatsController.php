<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 02/01/22
 * Time: 17:25
 */

namespace App\Controller;


class StatsController extends Controller
{
    public function getFragRanking()
    {
        return \FragsQuery::create()->withColumn("COUNT(*)","Frags")->where("Frags.FraggerId <> Frags.FraggedId")->groupByFraggerId()->orderBy("Frags","DESC")->find();
    }

    public function getKDRatioRanking()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList();
        foreach($players as $p){
            $k = $p->getKills();
            $d = $p->getDeaths();
            if($d != 0) {
                $r = $k / $d;
            }else{
                $r = 0;
            }

            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "kills" => $k,
                "deaths" => $d,
                "ratio" => $r
            ]);
        }

        // Array Sort (Ratios DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["ratio"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getPlayingTime()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList();
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "time" => $p->getPlayingTime()
            ]);
        }

        // Array Sort (Time DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["time"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getRoundsWinLooses()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList();
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "wins" => $p->getRoundWins(),
                "looses" => $p->getRoundLooses(),
                "total" => intval($p->getRoundWins()) - intval($p->getRoundLooses())
            ]);
        }

        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["total"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsWeapons()
    {
        $return = [];
        $kills = 0;
        $weapons = $this->app->Ctrl->Weapons->getList();
        foreach($weapons as $w){
            array_push($return,[
               "id" => $w->getId(),
               "name" => $w->getName(),
               "kills" => $w->getKills()
            ]);
            $kills += $w->getKills();
        }

        // Array Sort Kills DESC
        foreach($return as $key => $row){
            $sorting[$key] = $row["kills"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return ["weapons" => $return, "total" => $kills];
    }
}