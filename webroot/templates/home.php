<?php
include('header.php');
?>
<div class="row">
    <div class="col text-center">
        <h1>Classement Global</h1>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <h2 class="text-center">Nombre de Frags</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Frags</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($frags as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player/<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-3">
        <h2 class="text-center">Ratio Kill/Death</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Ratio</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($ratios as $r){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player/<?=$r['id'];?>"><?= $r['name'];?></a></td>
                    <td data-toggle="tooltip" data-placement="right" title="Kills: <?=$r['kills']?> / Deaths: <?=$r['deaths'];?>" ><?= number_format(floatval($r['ratio']),6,',',' ');?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-3">
        <h2 class="text-center">Rounds gagnés / perdus</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Total</th>
                <th>Gagné</th>
                <th>Perdu</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($winlooses as $w){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player/<?=$w['id'];?>"><?= $w['name'];?></a></td>
                    <td><strong><?= $w["total"];?></strong></td>
                    <td><?=$w['wins']?></td>
                    <td><?=$w['looses']?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-3">
        <h2 class="text-center">Temps de jeu</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Temps</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($times as $t){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player/<?=$t['id'];?>"><?= $t['name'];?></a></td>
                    <td><?= gmdate("H:i:s",$t['time']);?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<hr/>
    <div class="row">
        <div class="col">
            <h1 class="text-center">Classement par Type de jeu</h1>
        </div>
    </div>
<hr/>
<div class="row">
    <div class="col">
        <h1 class="text-center">Statistiques du Serveur</h1>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <h2 class="text-center">Armes les plus utilisées</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Arme</th>
                <th>Kills</th>
                <th>%</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($weapons["weapons"] as $w){
                $percentKill = $w["kills"] * 100 / $weapons["total"];
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/weapon/<?=$t['id'];?>"><?= $w['name'];?></a></td>
                    <td><?= $w["kills"];?></td>
                    <td><?= number_format(floatval($percentKill),2,","," ");?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-4">
        <h2 class="text-center">Modes de Jeux</h2>
    </div>
    <div class="col-4">
        <h2 class="text-center">Nombre de Rounds</h2>
    </div>
</div>
<?php
include('footer.php');
