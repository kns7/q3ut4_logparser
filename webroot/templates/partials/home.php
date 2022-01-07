<div class="row">
    <div class="col text-center">
        <h1>Classement Global</h1>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-lg-6">
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
                    <td><a href="/player#<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-4 col-lg-6">
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
                    <td><a href="/player#<?=$r['id'];?>"><?= $r['name'];?></a></td>
                    <td data-toggle="tooltip" data-placement="right" title="Kills: <?=$r['kills']?> / Deaths: <?=$r['deaths'];?>" ><?= number_format(floatval($r['ratio']),6,',',' ');?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-4 col-lg-6">
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
                if($t['time'] >= 86400){
                    $time = $app->Ctrl->Stats->secondsToTime($t["time"]);
                }else{
                    $time = gmdate("H:i:s",$t['time']);
                }
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$t['id'];?>"><?= $t['name'];?></a></td>
                    <td data-toggle="tooltip" data-placement="right" title="<?= $t['time'];?>  secondes"><?= $time;?></td>
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
    <div class="col text-center">
        <h1>Classement par Type d'armes <small>Sans Gun Game</small></h1>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-6">
        <h2 class="text-center">Snipers</h2>
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
            foreach($snipers as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-3 col-lg-6">
        <h2 class="text-center">Pistolets</h2>
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
            foreach($sidearms as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-3 col-lg-6">
        <h2 class="text-center">Grenadiers (Grenades HE)</h2>
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
            foreach($grenades as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-3 col-lg-6">
        <h2 class="text-center">Charcuteurs (Couteau)</h2>
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
            foreach($knives as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$f->getFragger()->getId();?>"><?= $f->getFragger()->getName();?></a></td>
                    <td><?= $f->getFrags();?></td>
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
    <div class="col-sm">
        <h1 class="text-center">Classement par Type de jeu</h1>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-lg-6">
        <h2 class="text-center">Gun Game</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Victoires</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($ggame as $g){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$g['id'];?>"><?= $g['name'];?></a></td>
                    <td><?= $g["wins"];?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-4 col-lg-6">
        <h2 class="text-center">Bomb & Defuse</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Explos&eacute;es</th>
                <th>D&eacute;fus&eacute;es</th>
                <th>Plant&eacute;es</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($bombs as $b){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$b['id'];?>"><?= $b['name'];?></a></td>
                    <td><?= $b["exploded"];?></td>
                    <td><?=$b['defused']?></td>
                    <td><?=$b['planted']?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-4 col-lg-6">
        <h2 class="text-center">Jeux en Equipes</h2>
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
                    <td><a href="/player#<?=$w['id'];?>"><?= $w['name'];?></a></td>
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
    <div class="col-xl-4 col-lg-6">
        <h2 class="text-center">Free For All</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Victoires</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($ffa as $f){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$f['id'];?>"><?= $f['name'];?></a></td>
                    <td><?= $f["wins"];?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-xl-4 col-lg-6">
        <h2 class="text-center">Capture The Flag</h2>
        <table class="table table-hover table-striped">
            <thead>
            <tr class="bg-dark text-light">
                <th></th>
                <th>Joueur</th>
                <th>Captur&eacute;s</th>
                <th>Retourn&eacute;s</th>
                <th>Perdus</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($ctf as $c){
                ?>
                <tr>
                    <td>#<?= $i;?></td>
                    <td><a href="/player#<?=$c['id'];?>"><?= $c['name'];?></a></td>
                    <td><?= $c["capture"];?></td>
                    <td><?=$c['return']?></td>
                    <td><?=$c['drop']?></td>
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
    <div class="col-sm">
        <h1 class="text-center">Statistiques du Serveur</h1>
    </div>
</div>
<div class="row justify-content-around">
    <div class="col-lg-6 col-xl-4">
        <h2 class="text-center">Armes les plus utilisées</h2>
        <canvas class="chart" id="weaponuse_chart" data-name="weapons-use" data-chart="pie"></canvas>
    </div>
    <div class="col-lg-6 col-xl-4">
        <h2 class="text-center">Modes de Jeux</h2>
        <canvas class="chart" id="gametype_chart" data-name="gametypes" data-chart="pie"></canvas>
    </div>
</div>