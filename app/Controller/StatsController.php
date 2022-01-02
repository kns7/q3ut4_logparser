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
    public function getFragRanking($weapons = "")
    {
        $query = \FragsQuery::create()->withColumn("COUNT(*)","Frags")->where("Frags.FraggerId <> Frags.FraggedId");
        switch($weapons){
            default:

                break;

            case "sniper":
                $query->filterByWeaponId([5,8,9]);
                break;

            case "grenade":
                $query->filterByWeaponId(22);
                break;

            case "knife":
                $query->filterByWeaponId(21);
                break;
        }

        return $query->groupByFraggerId()->orderBy("Frags","DESC")->find();
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
        $total = 0;
        $weapons = $this->app->Ctrl->Weapons->getList();
        foreach($weapons as $w){
            array_push($return,[
               "id" => $w->getId(),
               "name" => $w->getName(),
               "kills" => $w->getKills()
            ]);
            $total += $w->getKills();
        }

        // Array Sort Kills DESC
        foreach($return as $key => $row){
            $sorting[$key] = $row["kills"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return ["weapons" => $return, "total" => $total];
    }

    public function getStatsGametypes()
    {
        $return = [];
        $total = 0;
        foreach($this->app->Ctrl->Gametypes->getList() as $g){
            array_push($return, [
                "id" => $g->getId(),
                "name" => $g->getName(),
                "rounds" => $g->getRoundsCount()
            ]);
            $total += $g->getRoundsCount();
        }

        // Array Sort Rounds DESC
        foreach($return as $key => $row){
            $sorting[$key] = $row["rounds"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return ["gametypes" => $return, "total" => $total];
    }
}