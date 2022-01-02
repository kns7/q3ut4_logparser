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
        $players = \PlayersQuery::create()->find();
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
            $ratios[$key] = $row["ratio"];
        }
        array_multisort($ratios, SORT_DESC, $return);

        return $return;
    }

    public function getPlayingTime()
    {
        $return = [];
        // Get all players
        $players = \PlayersQuery::create()->find();
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "time" => $p->getPlayingTime()
            ]);
        }

        // Array Sort (Ratios DESC)
        foreach($return as $key => $row){
            $time[$key] = $row["time"];
        }
        array_multisort($time, SORT_DESC, $return);

        return $return;
    }


}