<?php
/**
 * Created by PhpStorm.
 * User: miams
 * Date: 02/01/22
 * Time: 17:25
 */

namespace App\Controller;


use Propel\Runtime\ActiveQuery\Criteria;

class StatsController extends Controller
{
    public function getFragRanking($weapons = "",$withoutggame = false, $date = false)
    {

        $query = \FragsQuery::create()->withColumn("COUNT(*)","Frags")->where("Frags.FraggerId <> Frags.FraggedId");
        if($withoutggame){
            $games = \GamesQuery::create()->filterByGametypeId(11)->select("id")->find()->toArray();
            $rounds  = \GameroundsQuery::create()->filterByGameID($games)->select("id")->find()->toArray();
            $query->filterByRoundId($rounds,Criteria::NOT_IN);
        }
        if($date !== false){
            $query->filterByCreated($date);
        }

        switch($weapons){
            default:

                break;

            case "sniper":
                $query->filterByWeaponId([5,8,9]);
                break;

            case "sidearm":
                $query->filterByWeaponId([16,17,18,19,20]);
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

    public function getKDRatioRanking($date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            $k = $p->getKills($date);
            $d = $p->getDeaths($date);
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

    public function getGlobalRanking()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){

            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "ratio" => $p->getPlayingTime()
            ]);
        }

        // Array Sort (Time DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["time"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getPlayingTime($date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "time" => $p->getPlayingTime($date)
            ]);
        }

        // Array Sort (Time DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["time"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getRoundsWinLooses($date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "wins" => $p->getRoundWins($date),
                "looses" => $p->getRoundLooses($date),
                "total" => intval($p->getRoundWins($date)) - intval($p->getRoundLooses($date))
            ]);
        }

        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["total"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsWeapons($date = false)
    {
        $return = [];
        $total = 0;
        $weapons = $this->app->Ctrl->Weapons->getList();
        foreach($weapons as $w){
            array_push($return,[
               "id" => $w->getId(),
               "name" => $w->getName(),
               "kills" => $w->getKills($date)
            ]);
            $total += $w->getKills($date);
        }

        // Array Sort Kills DESC
        foreach($return as $key => $row){
            $sorting[$key] = $row["kills"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return ["weapons" => $return, "total" => $total];
    }

    public function getStatsGametypes($date = false)
    {
        $return = [];
        $total = 0;
        foreach($this->app->Ctrl->Gametypes->getList() as $g){
            array_push($return, [
                "id" => $g->getId(),
                "name" => $g->getName(),
                "rounds" => $g->getRoundsCount($date)
            ]);
            $total += $g->getRoundsCount($date);
        }

        // Array Sort Rounds DESC
        foreach($return as $key => $row){
            $sorting[$key] = $row["rounds"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return ["gametypes" => $return, "total" => $total];
    }

    public function getStatsBombs($date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "planted" => $p->getBombsCount("planted",$date),
                "defused" => $p->getBombsCount("defused",$date),
                "exploded" => $p->getBombsCount("exploded",$date),
                "total" => intval($p->getBombsCount("planted",$date)) + intval($p->getBombsCount("defused",$date)) + intval($p->getBombsCount("exploded",$date))
            ]);
        }

        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["total"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getWinsGametypes($gametype,$date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "wins" => $p->getGametypeWins($gametype,$date)
            ]);
        }
        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["wins"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsGunGame()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList();
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "wins" => $p->getGunGameCount()
            ]);
        }
        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["wins"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsFFA()
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList();
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "wins" => $p->getFFACount()
            ]);
        }
        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["wins"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsCTF($date = false)
    {
        $return = [];
        // Get all players
        $players = $this->app->Ctrl->Players->getList($date);
        foreach($players as $p){
            array_push($return,[
                "id" => $p->getId(),
                "name" => $p->getName(),
                "capture" => $p->getCTFCount("capture",$date),
                "drop" => $p->getCTFCount("drop",$date),
                "return" => $p->getCTFCount("return",$date),
                "total" => intval($p->getCTFCount("capture",$date)) + intval($p->getCTFCount("return",$date)) - intval($p->getCTFCount("drop",$date))
            ]);
        }

        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["total"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }

    public function getStatsMaps($date = false)
    {
        $return = [];
        $maps = $this->app->Ctrl->Maps->getList();
        foreach($maps as $m){
            if($date !== false) {
                $games = \GamesQuery::create()->filterByMapId($m->getId())->filterByCreated($date);
            }else{
                $games = $m->getGames();
            }
            if($games->count() > 1 && $date == false || $games->count() > 0 && $date !== false) {
                array_push($return, [
                    "id" => $m->getId(),
                    "name" => $m->getName(),
                    "played" => $games->count()
                ]);
            }
        }

        // Array Sort (Total DESC)
        foreach($return as $key => $row){
            $sorting[$key] = $row["played"];
        }
        array_multisort($sorting, SORT_DESC, $return);

        return $return;
    }


    public function getStatsEvolution($playerid,$values)
    {
        $datas = [];
        $labels = [];
        $dataset = [];

        $player = \PlayersQuery::create()->findPk($playerid);
        foreach($this->getParseDates("ASC") as $game){
            $date = $game->getCreated();
            switch($values){
                case "ratio":
                    $deaths = \FragsQuery::create()->filterByFraggedId($playerid)->filterByFraggerId($playerid,Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                    $kills = \FragsQuery::create()->filterByFraggerId($playerid)->filterByFraggedId($playerid,Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                    $count = ($deaths == 0)? 0: $kills / $deaths;
                    break;

                case "frags":
                    $count = \FragsQuery::create()->filterByFraggerId($playerid)->filterByFraggedId($playerid,Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                    break;

                case "deaths":
                    $count = \FragsQuery::create()->filterByFraggedId($playerid)->filterByFraggerId($playerid,Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                    break;

                case "ping":
                    $pings = \GamescoresQuery::create()->filterByCreated($date->format("Y-m-d"))->find();
                    $amount = $pings->count();
                    $count = 0;
                    foreach($pings as $ping){
                        $count += $ping->getPing();
                    }
                    $count = $count / $amount;
                    break;
            }
            switch($date->format("Y-m-d")){
                case "2020-01-01":
                    $displaydate = $date->format("Y");
                    $total = ($values == "frags" || $values == "deaths")? $count / 10:$count;
                    break;

                case "2021-01-01":
                    $displaydate = $date->format("Y");
                    $total = ($values == "frags" || $values == "deaths")? $count / 36:$count;
                    break;

                default:
                    $displaydate = $date->format("d/m/Y");
                    $total = $count;
                    break;
            }
            array_push($datas, $total);
            array_push($labels,$displaydate);
        }
        array_push($dataset, (object)[
            "type"=> 'line',
            "label" => $player->getName(),
            "data" => $datas
        ]);

        return ["datasets" => $dataset, "labels" => $labels];
    }


    public function getStatsMultiplayerEvolution($players,$values)
    {
        $labels = [];
        foreach($this->getParseDates("ASC") as $game){
            $date = $game->getCreated();
            switch($date->format("Y-m-d")){
                case "2020-01-01":
                    $displaydate = $date->format("Y");
                    break;

                case "2021-01-01":
                    $displaydate = $date->format("Y");
                    break;

                default:
                    $displaydate = $date->format("d/m/Y");
                    break;
            }
            array_push($labels,$displaydate);
        }

        $dataset = [];
        $i = 0;
        $colors = json_decode($this->config->chartcolors);
        foreach($players as $playerid){
            $datas = [];
            $player = \PlayersQuery::create()->findPk($playerid);
            foreach($this->getParseDates("ASC") as $game){
                $date = $game->getCreated();
                switch($values){
                    case "ratio":
                        $deaths = \FragsQuery::create()->filterByFraggedId($player->getId())->filterByFraggerId($player->getId(),Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                        $kills = \FragsQuery::create()->filterByFraggerId($player->getId())->filterByFraggedId($player->getId(),Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                        $count = ($deaths == 0)? 0: $kills / $deaths;
                        break;

                    case "frags":
                        $count = \FragsQuery::create()->filterByFraggerId($player->getId())->filterByFraggedId($player->getId(),Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                        break;

                    case "deaths":
                        $count = \FragsQuery::create()->filterByFraggedId($player->getId())->filterByFraggerId($player->getId(),Criteria::NOT_EQUAL)->filterByCreated($date->format("Y-m-d"))->count();
                        break;

                    case "ping":
                        $pings = \GamescoresQuery::create()->filterByPlayerId($player->getId())->filterByCreated($date->format("Y-m-d"))->find();
                        $amount = $pings->count();
                        $tcount = 0;
                        foreach($pings as $ping){
                            $tcount += $ping->getPing();
                        }
                        $count = ($amount == 0)? 0: intval($tcount / $amount);
                        break;
                }
                switch($date->format("Y-m-d")){
                    case "2020-01-01":
                        $total = ($values == "frags" || $values == "deaths")? intval($count / 10):$count;
                        break;

                    case "2021-01-01":
                        $total = ($values == "frags" || $values == "deaths")? intval($count / 36):$count;
                        break;

                    default:
                        $total = $count;
                        break;
                }
                array_push($datas, $total);
            }
            array_push($dataset, (object)[
                "type"=> 'line',
                "label" => $player->getName(),
                "data" => $datas,
                "borderColor" => $colors[$i],
                "backgroundColor" => $colors[$i]

            ]);
            $i++;
        }

        return ["datasets" => $dataset, "labels" => $labels];
    }


    public function getStatsGamesEvolution($games,$values)
    {
        $labels = [];
        $label = 1;
        $players = [];
        $gamesid = [];

        foreach($games as $game){
            array_push($labels,"#".$label);
            array_push($gamesid,$game->getId());
            $label++;
            foreach($game->getScores() as $s){
                if(!in_array($s->getPlayerId(),$players)) {
                    array_push($players,$s->getPlayerId());
                }
            }
        }

        $dataset = [];
        $i = 0;
        $colors = json_decode($this->config->chartcolors);
        foreach($players as $playerid){
            $datas = [];
            $player = \PlayersQuery::create()->findPk($playerid);
            foreach($gamesid as $game){
                $rounds = \GameroundsQuery::create()->filterByGameID($game)->find();
                switch($values){
                    case "ratio":
                        $deaths = \FragsQuery::create()->filterByFraggedId($player->getId())->filterByFraggerId($player->getId(),Criteria::NOT_EQUAL)->filterByRounds($rounds)->count();
                        $kills = \FragsQuery::create()->filterByFraggerId($player->getId())->filterByFraggedId($player->getId(),Criteria::NOT_EQUAL)->filterByRounds($rounds)->count();
                        $count = ($deaths == 0)? 0: $kills / $deaths;
                        break;

                    case "frags":
                        $count = \FragsQuery::create()->filterByFraggerId($player->getId())->filterByFraggedId($player->getId(),Criteria::NOT_EQUAL)->filterByRounds($rounds)->count();
                        break;

                    case "deaths":
                        $count = \FragsQuery::create()->filterByFraggedId($player->getId())->filterByFraggerId($player->getId(),Criteria::NOT_EQUAL)->filterByRounds($rounds)->count();
                        break;

                    case "ping":
                        $pings = \GamescoresQuery::create()->filterByPlayerId($player->getId())->filterByGameID($game)->find();
                        $amount = $pings->count();
                        $tcount = 0;
                        foreach($pings as $ping){
                            $tcount += $ping->getPing();
                        }
                        $count = ($amount == 0)? 0: intval($tcount / $amount);
                        break;
                }
                array_push($datas, $count);
            }
            array_push($dataset, (object)[
                "type"=> 'line',
                "label" => $player->getName(),
                "data" => $datas,
                "borderColor" => $colors[$i],
                "backgroundColor" => $colors[$i]

            ]);
            $i++;
        }

        return ["datasets" => $dataset, "labels" => $labels];
    }
}