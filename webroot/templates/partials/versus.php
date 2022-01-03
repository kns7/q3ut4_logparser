<?php
$picture1 = (file_exists('img/users/'.$p1->getId().".png"))? "/img/users/".$p1->getId().".png":"/img/user.png";
$picture2 = (file_exists('img/users/'.$p2->getId().".png"))? "/img/users/".$p2->getId().".png":"/img/user.png";
$kills = ['1' => $p1->getKills(), '2' => $p2->getKills()];
$time = ['1' => $p1->getPlayingTime(), '2' => $p2->getPlayingTime()];
$ratio = ['1' => $p1->getRatio(), '2' => $p2->getRatio()];
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
        <h2 class="text-center">Statistiques de Kills (Frags)</h2>
    </div>
</div>
<div class="row justify-content-around">
    <div class="col-sm-4">
        <canvas class="chart" id="vskillsdeath1_chart" data-name="vs-killsdeath" data-id="<?=$p1->getId();?>_<?=$p2->getId();?>" data-chart="pie"></canvas>
    </div>
    <div class="col-sm-4">
        <canvas class="chart" id="vskillsdeath2_chart" data-name="vs-killsdeath" data-id="<?=$p2->getId();?>_<?=$p1->getId();?>" data-chart="pie"></canvas>
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