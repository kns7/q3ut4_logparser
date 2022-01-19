<?php
$picture1 = (file_exists('img/users/'.$p1->getId().".png"))? "/img/users/".$p1->getId().".png":"/img/user.png";
$picture2 = (file_exists('img/users/'.$p2->getId().".png"))? "/img/users/".$p2->getId().".png":"/img/user.png";
$kills = ['1' => $p1->getKills(), '2' => $p2->getKills()];
$time = ['1' => $p1->getPlayingTime(), '2' => $p2->getPlayingTime()];
$ratio = ['1' => $p1->getRatio(), '2' => $p2->getRatio()];
$ggame = ['1' => $p1->getGametypeWins(11), '2' => $p2->getGametypeWins(11)];
$ffa = ['1' => $p1->getGametypeWins(1), '2' => $p2->getGametypeWins(1)];
$team = ['wins' => ['1' => $p1->getRoundWins(), '2' => $p2->getRoundWins()],
    'lost' => ['1' => $p1->getRoundLooses(), '2' => $p2->getRoundLooses()]];
$bomb = ['planted' => ['1' => $p1->getBombsCount("planted"), '2' => $p2->getBombsCount("planted")],
    'defused' => ['1' => $p1->getBombsCount("defused"), '2' => $p2->getBombsCount("defused")],
    'exploded' => ['1' => $p1->getBombsCount("exploded"), '2' => $p2->getBombsCount("exploded")]];
$ctf = [
    'capture' => ['1' => $p1->getCTFCount("capture"), '2' => $p2->getCTFCount("capture")],
    'return' => ['1' => $p1->getCTFCount("return"), '2' => $p2->getCTFCount("return")],
    'drop' => ['1' => $p1->getCTFCount("drop"), '2' => $p2->getCTFCount("drop")]
];

$killsplayer = ['1' => $p1->getKillsPerPlayer($p2->getId()), '2' => $p2->getKillsPerPlayer($p1->getId())];
$deathsplayer = ['1' => $p1->getDeathsPerPlayer($p2->getId()), '2' => $p2->getDeathsPerPlayer($p1->getId())];


if($p1->getWeaponsRank()->count() > 0) {
    $bestweapon['1'] = $p1->getWeaponsRank()->getFirst()->getWeapons();
    $bestsniper['1'] = $p1->getWeaponsRank("sniper")->getFirst()->getWeapons();
    $bestsidearm['1'] = $p1->getWeaponsRank("sidearm")->getFirst()->getWeapons();
}else{
    $bestweapon['1'] = null;
}
if($p2->getWeaponsRank()->count() > 0) {
    $bestweapon['2'] = $p2->getWeaponsRank()->getFirst()->getWeapons();
    $bestsniper['2'] = $p2->getWeaponsRank("sniper")->getFirst()->getWeapons();
    $bestsidearm['2'] = $p2->getWeaponsRank("sidearm")->getFirst()->getWeapons();
}else{
    $bestweapon['2'] = null;
}

if($p1->getMapsWins()->count() > 0){
    $bestmap['1'] = (!is_null($p1->getMapsWins()->getFirst()->getGames()->getMaps()))?$p1->getMapsWins()->getFirst():null;
}else{
    $bestmap['1'] = null;
}
if($p2->getMapsWins()->count() > 0){
    $bestmap['2'] = (!is_null($p2->getMapsWins()->getFirst()->getGames()->getMaps()))?$p2->getMapsWins()->getFirst():null;
}else{
    $bestmap['2'] = null;
}
?>
<div class="d-none d-md-block">
    <div class="row justify-content-around">
        <div class="col-xl-2 col-lg-4">
            <div class="card">
                <div class="text-center">
                    <img src="<?=$picture1;?>" class="card-img-top user-profile" alt="<?= $p1->getName();?>">
                </div>
                <div class="card-body userprofile">
                    <h3 class="card-title text-center text-primary"><?= $p1->getName();?></h3>
                </div>
            </div>
            <hr/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <div class="card">
                <div class="text-center">
                    <img src="<?=$picture2;?>" class="card-img-top user-profile" alt="<?= $p2->getName();?>">
                </div>
                <div class="card-body userprofile">
                    <h3 class="card-title text-center text-primary"><?= $p2->getName();?></h3>
                </div>
            </div>
            <hr/>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <table class="table table-hover table-striped">
            <thead class="d-md-none">
            <tr>
                <th class="text-left"><?= $p1->getName();?></th>
                <th>&nbsp;</th>
                <th class="text-right"><?= $p2->getName();?></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left"><?= ($time['1'] > $time['2'])?"<strong class='text-primary'>":"";?><?= gmdate("H:i:s",$time['1']);?><?= ($time['1'] > $time['2'])?"</strong>":"";?></td>
                    <th class="text-center">Temps de jeu</th>
                    <td class="text-right"><?= ($time['2'] > $time['1'])?"<strong class='text-primary'>":"";?><?= gmdate("H:i:s",$time['2']);?><?= ($time['2'] > $time['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($kills['1'] > $kills['2'])?"<strong class='text-primary'>":"";?><?= $kills['1'];?><?= ($kills['1'] > $kills['2'])?"</strong>":"";?></td>
                    <th class="text-center">Nombre de Kills total</th>
                    <td class="text-right"><?= ($kills['2'] > $kills['1'])?"<strong class='text-primary'>":"";?><?= $kills['2'];?><?= ($kills['2'] > $kills['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ratio['1'] > $ratio['2'])?"<strong class='text-primary'>":"";?><?= number_format(floatval($ratio['1']),6,',',' ');?><?= ($ratio['1'] > $ratio['2'])?"</strong>":"";?></td>
                    <th class="text-center">Kills / Deaths Ratio</th>
                    <td class="text-right"><?= ($ratio['2'] > $ratio['1'])?"<strong class='text-primary'>":"";?><?= number_format(floatval($ratio['2']),6,',',' ');?><?= ($ratio['2'] > $ratio['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ggame['1'] > $ggame['2'])?"<strong class='text-primary'>":"";?><?= $ggame['1'];?><?= ($ggame['1'] > $ggame['2'])?"</strong>":"";?></td>
                    <th class="text-center">Victoires Gun Game</th>
                    <td class="text-right"><?= ($ggame['2'] > $ggame['1'])?"<strong class='text-primary'>":"";?><?= $ggame['2'];?><?= ($ggame['2'] > $ggame['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ffa['1'] > $ffa['2'])?"<strong class='text-primary'>":"";?><?= $ffa['1'];?><?= ($ffa['1'] > $ffa['2'])?"</strong>":"";?></td>
                    <th class="text-center">Victoires Free For All</th>
                    <td class="text-right"><?= ($ffa['2'] > $ffa['1'])?"<strong class='text-primary'>":"";?><?= $ffa['2'];?><?= ($ffa['2'] > $ffa['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($team['wins']['1'] > $team['wins']['2'])?"<strong class='text-primary'>":"";?><?= $team['wins']['1'];?><?= ($team['wins']['1'] > $team['wins']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Victoires Equipes</th>
                    <td class="text-right"><?= ($team['wins']['2'] > $team['wins']['1'])?"<strong class='text-primary'>":"";?><?= $team['wins']['2'];?><?= ($team['wins']['2'] > $team['wins']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($team['lost']['1'] < $team['lost']['2'])?"<strong class='text-primary'>":"";?><?= $team['lost']['1'];?><?= ($team['lost']['1'] < $team['lost']['2'])?"</strong>":"";?></td>
                    <th class="text-center">D&eacute;faites Equipes</th>
                    <td class="text-right"><?= ($team['lost']['2'] < $team['lost']['1'])?"<strong class='text-primary'>":"";?><?= $team['lost']['2'];?><?= ($team['lost']['2'] < $team['lost']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($bomb['planted']['1'] > $bomb['planted']['2'])?"<strong class='text-primary'>":"";?><?= $bomb['planted']['1'];?><?= ($bomb['planted']['1'] > $bomb['planted']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Bombes Plant&eacute;es</th>
                    <td class="text-right"><?= ($bomb['planted']['2'] > $bomb['planted']['1'])?"<strong class='text-primary'>":"";?><?= $bomb['planted']['2'];?><?= ($bomb['planted']['2'] > $bomb['planted']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($bomb['defused']['1'] > $bomb['defused']['2'])?"<strong class='text-primary'>":"";?><?= $bomb['defused']['1'];?><?= ($bomb['defused']['1'] > $bomb['defused']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Bombes D&eacute;fus&eacute;es</th>
                    <td class="text-right"><?= ($bomb['defused']['2'] > $bomb['defused']['1'])?"<strong class='text-primary'>":"";?><?= $bomb['defused']['2'];?><?= ($bomb['defused']['2'] > $bomb['defused']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($bomb['exploded']['1'] > $bomb['exploded']['2'])?"<strong class='text-primary'>":"";?><?= $bomb['exploded']['1'];?><?= ($bomb['exploded']['1'] > $bomb['exploded']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Bombes Explos&eacute;es</th>
                    <td class="text-right"><?= ($bomb['exploded']['2'] > $bomb['exploded']['1'])?"<strong class='text-primary'>":"";?><?= $bomb['exploded']['2'];?><?= ($bomb['exploded']['2'] > $bomb['exploded']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ctf['capture']['1'] > $ctf['capture']['2'])?"<strong class='text-primary'>":"";?><?= $ctf['capture']['1'];?><?= ($ctf['capture']['1'] > $ctf['capture']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Flags Captur&eacute;s</th>
                    <td class="text-right"><?= ($ctf['capture']['2'] > $ctf['capture']['1'])?"<strong class='text-primary'>":"";?><?= $ctf['capture']['2'];?><?= ($ctf['capture']['2'] > $ctf['capture']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ctf['return']['1'] > $ctf['return']['2'])?"<strong class='text-primary'>":"";?><?= $ctf['return']['1'];?><?= ($ctf['return']['1'] > $ctf['return']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Flags Retourn&eacute;s</th>
                    <td class="text-right"><?= ($ctf['return']['2'] > $ctf['return']['1'])?"<strong class='text-primary'>":"";?><?= $ctf['return']['2'];?><?= ($ctf['return']['2'] > $ctf['return']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= ($ctf['drop']['1'] < $ctf['drop']['2'])?"<strong class='text-primary'>":"";?><?= $ctf['drop']['1'];?><?= ($ctf['drop']['1'] < $ctf['drop']['2'])?"</strong>":"";?></td>
                    <th class="text-center">Flags Perdus (Dropped)</th>
                    <td class="text-right"><?= ($ctf['drop']['2'] < $ctf['drop']['1'])?"<strong class='text-primary'>":"";?><?= $ctf['drop']['2'];?><?= ($ctf['drop']['2'] < $ctf['drop']['1'])?"</strong>":"";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= (!is_null($bestmap['1']))?$bestmap['1']->getGames()->getMaps()->getName()." (".$bestmap['1']->getWins().")":"N/A";?></td>
                    <th class="text-center">Meilleure carte (victoires)</th>
                    <td class="text-right"><?= (!is_null($bestmap['2']))?$bestmap['2']->getGames()->getMaps()->getName()." (".$bestmap['2']->getWins().")":"N/A";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= (!is_null($bestweapon['1']))?$bestweapon['1']->getName():"N/A";?></td>
                    <th class="text-center">Arme pr&eacute;f&eacute;r&eacute;e</th>
                    <td class="text-right"><?= (!is_null($bestweapon['2']))?$bestweapon['2']->getName():"N/A";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= (!is_null($bestweapon['1']))?$bestsniper['1']->getName():"N/A";?></td>
                    <th class="text-center">Sniper pr&eacute;f&eacute;r&eacute;e</th>
                    <td class="text-right"><?= (!is_null($bestweapon['2']))?$bestsniper['2']->getName():"N/A";?></td>
                </tr>
                <tr>
                    <td class="text-left"><?= (!is_null($bestweapon['1']))?$bestsidearm['1']->getName():"N/A";?></td>
                    <th class="text-center">Pistolet pr&eacute;f&eacute;r&eacute;e</th>
                    <td class="text-right"><?= (!is_null($bestweapon['2']))?$bestsidearm['2']->getName():"N/A";?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-8">
        <hr/>
        <h2 class="text-center">Statistiques de Frags (entre les 2 joueurs)</h2>
    </div>
</div>
<div class="row justify-content-around">
    <div class="col-sm-4">
        <canvas class="chart" id="vskillsdeath1_chart" data-name="vs-killsdeath" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="bar" data-colors="chartColorsVS"></canvas>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-8">
        <hr/>
        <h2 class="text-center">Statistiques de Coups port&eacute;s (Hits)</h2>
    </div>
</div>
<div class="row justify-content-around">
    <div class="col-sm-4">
        <caption  class="d-md-none">Coups port&eacute;s par <?= $p1->getName();?></caption>
        <canvas class="chart" id="vshits1_chart" data-name="vs-hits" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="pie"></canvas>
    </div>
    <div class="col-sm-4">
        <caption  class="d-md-none">Coups port&eacute;s par <?= $p2->getName();?></caption>
        <canvas class="chart" id="vshits2_chart" data-name="vs-hits" data-id="<?=$p2->getId();?>_<?=$p1->getId();?>" data-chart="pie"></canvas>
    </div>
</div>
<hr/>
<div class="row"><div class="col text-center"><h1>Evolution</h1></div></div>
<div class="row justify-content-around">
    <div class="col-sm-6">
        <h2 class="text-center">Frags</h2>
        <canvas class="chart" id="vstimefrags_chart" data-name="vs-timefrags" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
    <div class="col-sm-6">
        <h2 class="text-center">Deaths</h2>
        <canvas class="chart" id="vstimedeaths_chart" data-name="vs-timedeaths" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
    <div class="col-sm-6">
        <h2 class="text-center">Kills / Death Ratio</h2>
        <canvas class="chart" id="vstimeratio_chart" data-name="vs-timeratio" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
    <div class="col-sm-6">
        <h2 class="text-center">Headshots (%)</h2>
        <canvas class="chart" id="vstimeheadshots_chart" data-name="vs-timeheadshots" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
    <div class="col-sm-6">
        <h2 class="text-center">Chestshots (%)</h2>
        <canvas class="chart" id="vstimechestshots_chart" data-name="vs-timechestshots" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
    <div class="col-sm-6">
        <h2 class="text-center">Ping</h2>
        <canvas class="chart" id="vstimeping_chart" data-name="vs-timeping" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="line"></canvas>
    </div>
</div>