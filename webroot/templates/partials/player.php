<?php
if($player->getWeaponsRank()->count() > 0) {
    $bestweapon = $player->getWeaponsRank()->getFirst()->getWeapons();
}else{
    $bestweapon = null;
}
?>
<div class="col-2">
    <div class="card">
        <div class="text-center">
        <img src="/img/user.png" class="card-img-top user-profile" alt="<?= $player->getName();?>">
        </div>
        <div class="card-body userprofile">
            <h3 class="card-title text-center"><?= $player->getName();?></h3>
                <ul class="list-group list-group-flush">
                <li class="list-group-item">Nombre de Kills: <strong><?= $player->getKills();?></strong></li>
                <li class="list-group-item">Kill / Death Ratio: <strong><?= number_format(floatval($player->getRatio()),6,',',' ');?></strong> </li>
                <li class="list-group-item">Arme pr&eacute;f&eacute;r&eacute;e: <strong><?= (!is_null($bestweapon))?$bestweapon->getName():"N/A";?></strong></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-10">
    <div class="row"><div class="col text-center"><h1>Kills & Deaths</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-4">
            <h2 class="text-center">A tu&eacute;</h2>
            <canvas class="chart" id="playerkills_chart" data-name="player-kills" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Tu&eacute; par</h2>
            <canvas class="chart" id="playerdeaths_chart" data-name="player-deaths" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
    <hr/>
    <div class="row"><div class="col text-center"><h1>Hits</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-4">
            <h2 class="text-center">Coups Port&eacute;s</h2>
            <canvas class="chart" id="playerhitsdone_chart" data-name="player-hitsdone" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Coups Pris</h2>
            <canvas class="chart" id="playerhitstaken_chart" data-name="player-hitstaken" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
    <hr/>
    <div class="row"><div class="col text-center"><h1>Utilisation des Armes</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-4">
            <h2 class="text-center">Toutes Armes</h2>
            <canvas class="chart" id="playerweapon_chart" data-name="player-weapon" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Armes Principales</h2>
            <canvas class="chart" id="playerweaponprimary_chart" data-name="player-weaponprimary" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Armes Secondaires</h2>
            <canvas class="chart" id="playerweaponsecondary_chart" data-name="player-weaponsecondary" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Pistolets</h2>
            <canvas class="chart" id="playerweaponsidearm_chart" data-name="player-weaponsidearm" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Snipers</h2>
            <canvas class="chart" id="playerweaponsniper_chart" data-name="player-weaponsniper" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-4">
            <h2 class="text-center">Grenades</h2>
            <canvas class="chart" id="playerweapongrenade_chart" data-name="player-weapongrenade" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
</div>