<?php
$bestweapon = ($player->getWeaponsRank()->count() > 0)? $player->getWeaponsRank()->getFirst()->getWeapons():null;
$bestsniper = ($player->getWeaponsRank("sniper")->count() > 0)?$player->getWeaponsRank("sniper")->getFirst()->getWeapons():null;
$bestsidearm = ($player->getWeaponsRank("sidearm")->count() > 0)?$player->getWeaponsRank("sidearm")->getFirst()->getWeapons():null;

$picture = (file_exists('img/users/'.$player->getId().".png"))? "/img/users/".$player->getId().".png":"/img/user.png";
?>
<div class="col-sm-2">
    <div class="card">
        <div class="text-center">
        <img src="<?=$picture;?>" class="card-img-top user-profile" alt="<?= $player->getName();?>">
        </div>
        <div class="card-body userprofile">
            <h3 class="card-title text-center text-primary"><?= $player->getName();?></h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Temps de jeu: <strong><?= gmdate("H:i:s",$player->getPlayingTime());?></strong></li>
                <li class="list-group-item">Nombre de Kills: <strong><?= $player->getKills();?></strong></li>
                <li class="list-group-item">Kills / Deaths Ratio: <strong><?= number_format(floatval($player->getRatio()),6,',',' ');?></strong> </li>
                <li class="list-group-item">Arme pr&eacute;f&eacute;r&eacute;e<br/><strong><?= (!is_null($bestweapon))?$bestweapon->getName():"N/A";?></strong></li>
                <li class="list-group-item">Sniper pr&eacute;f&eacute;r&eacute;<br/><strong><?= (!is_null($bestsniper))?$bestsniper->getName():"N/A";?></strong></li>
                <li class="list-group-item">Pistolet pr&eacute;f&eacute;r&eacute;<br/><strong><?= (!is_null($bestsidearm))?$bestsidearm->getName():"N/A";?></strong></li>
            </ul>
            <hr/>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Victoires Gun Game: <strong><?= $player->getGametypeWins(11);?></strong></li>
                <li class="list-group-item">Victoires Free For All: <strong><?= $player->getGametypeWins(1);?></strong></li>
                <li class="list-group-item">Victoires Equipes: <strong><?= $player->getRoundWins();?></strong></li>
                <li class="list-group-item">D&eacute;faites Equipes: <strong><?= $player->getRoundLooses();?></strong></li>
                <li class="list-group-item">Bombes Plant&eacute;es: <strong><?= $player->getBombsCount("planted");?></strong></li>
                <li class="list-group-item">Bombes D&eacute;fus&eacute;es: <strong><?= $player->getBombsCount("defused");?></strong></li>
                <li class="list-group-item">Bombes Explos&eacute;es: <strong><?= $player->getBombsCount("exploded");?></strong></li>
                <li class="list-group-item">Flags Captur&eacute;s: <strong><?= $player->getCTFCount("capture");?></strong></li>
                <li class="list-group-item">Flags Retourn&eacute;s: <strong><?= $player->getCTFCount("return");?></strong></li>
                <li class="list-group-item">Flags Perdus: <strong><?= $player->getCTFCount("drop");?></strong></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-sm-10">
    <div class="row"><div class="col text-center"><h1>Kills & Deaths</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-sm-4">
            <h2 class="text-center">A tu&eacute;</h2>
            <canvas class="chart" id="playerkills_chart" data-name="player-kills" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Tu&eacute; par</h2>
            <canvas class="chart" id="playerdeaths_chart" data-name="player-deaths" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
    <hr/>
    <div class="row"><div class="col text-center"><h1>Hits</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-sm-4">
            <h2 class="text-center">Coups Port&eacute;s</h2>
            <canvas class="chart" id="playerhitsdone_chart" data-name="player-hitsdone" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Coups Pris</h2>
            <canvas class="chart" id="playerhitstaken_chart" data-name="player-hitstaken" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
    <hr/>
    <div class="row"><div class="col text-center"><h1>Utilisation des Armes</h1></div></div>
    <div class="row justify-content-around">
        <div class="col-sm-4">
            <h2 class="text-center">Toutes Armes</h2>
            <canvas class="chart" id="playerweapon_chart" data-name="player-weapon" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Armes Principales</h2>
            <canvas class="chart" id="playerweaponprimary_chart" data-name="player-weaponprimary" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Armes Secondaires</h2>
            <canvas class="chart" id="playerweaponsecondary_chart" data-name="player-weaponsecondary" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Pistolets</h2>
            <canvas class="chart" id="playerweaponsidearm_chart" data-name="player-weaponsidearm" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Snipers</h2>
            <canvas class="chart" id="playerweaponsniper_chart" data-name="player-weaponsniper" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center">Grenades</h2>
            <canvas class="chart" id="playerweapongrenade_chart" data-name="player-weapongrenade" data-id="<?=$player->getId();?>" data-chart="pie"></canvas>
        </div>
    </div>
</div>