<div class="row justify-content-between">
    <div class="col-8 gamesscores">
        <?php
        $trigger_half = (is_null($game->getRedscore2()))?false:true;
        $teamplay = (is_null($game->getRedscore()) && is_null($game->getBluescore()))? false:true;
        if($teamplay) {
            if($trigger_half){
                ?><h3>Premier Round</h3><?php
            }
            ?>
            <div class="row score-header red justify-content-between">
                <div class="col-2 text-left">(<?=($trigger_half)?$game->getTeamsMemberCount(1,1):$game->getTeamsMemberCount(1);?> Players)</div>
                <div class="col-8 text-center">Terrorists</div>
                <div class="col-2 text-right"><?= $game->getRedscore();?></div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>kills</th>
                        <th>deaths</th>
                        <th>score</th>
                        <th>ping</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($scores as $s){
                    if($s->getTeam() == 1 && $s->getHalf() == 1){
                        ?>
                        <tr class="line-red">
                            <td><?= $s->getPlayers()->getName();?></td>
                            <td><?= $s->getKills();?></td>
                            <td><?= $s->getDeaths();?></td>
                            <td><?= $s->getScore();?></td>
                            <td><?= $s->getPing();?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="row score-header blue justify-content-between">
                <div class="col-2 text-left">(<?=($trigger_half)?$game->getTeamsMemberCount(2,1):$game->getTeamsMemberCount(2);?> Players)</div>
                <div class="col-8 text-center">Counter Terrorists</div>
                <div class="col-2 text-right"><?= $game->getBluescore();?></div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>name</th>
                    <th>kills</th>
                    <th>deaths</th>
                    <th>score</th>
                    <th>ping</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($scores as $s){
                    if($s->getTeam() == 2 && $s->getHalf() == 1){
                        ?>
                        <tr class="line-blue">
                            <td><?= $s->getPlayers()->getName();?></td>
                            <td><?= $s->getKills();?></td>
                            <td><?= $s->getDeaths();?></td>
                            <td><?= $s->getScore();?></td>
                            <td><?= $s->getPing();?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
            if($trigger_half){
                ?>
                <h3>Second Round</h3>
                <div class="row score-header red justify-content-between">
                    <div class="col-2 text-left">(<?=$game->getTeamsMemberCount(1,2);?> Players)</div>
                    <div class="col-8 text-center">Terrorists</div>
                    <div class="col-2 text-right"><?= $game->getRedscore2();?></div>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>kills</th>
                        <th>deaths</th>
                        <th>score</th>
                        <th>ping</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($scores as $s){
                        if($s->getTeam() == 1 && $s->getHalf() == 2){
                            ?>
                            <tr class="line-red">
                                <td><?= $s->getPlayers()->getName();?></td>
                                <td><?= $s->getKills();?></td>
                                <td><?= $s->getDeaths();?></td>
                                <td><?= $s->getScore();?></td>
                                <td><?= $s->getPing();?></td>
                            </tr>
                            <?php
                        }
                        if($s->getHalf() == 2){
                            $trigger_half = true;
                        }
                    }
                    ?>
                    </tbody>
                </table>

                <div class="row score-header blue justify-content-between">
                    <div class="col-2 text-left">(<?=$game->getTeamsMemberCount(2,2);?> Players)</div>
                    <div class="col-8 text-center">Counter Terrorists</div>
                    <div class="col-2 text-right"><?= $game->getBluescore2();?></div>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>kills</th>
                        <th>deaths</th>
                        <th>score</th>
                        <th>ping</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($scores as $s){
                        if($s->getTeam() == 2 && $s->getHalf() == 2){
                            ?>
                            <tr class="line-blue">
                                <td><?= $s->getPlayers()->getName();?></td>
                                <td><?= $s->getKills();?></td>
                                <td><?= $s->getDeaths();?></td>
                                <td><?= $s->getScore();?></td>
                                <td><?= $s->getPing();?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            }
        }else{
            ?>
            <div class="score-header green">
                <div class="players">(<?= $game->getNbPlayers();?> Players)</div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>name</th>
                    <th>kills</th>
                    <th>deaths</th>
                    <th>score</th>
                    <th>ping</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($scores as $s){
                    ?>
                    <tr>
                        <td><?= $s->getPlayers()->getName();?></td>
                        <td><?= $s->getKills();?></td>
                        <td><?= $s->getDeaths();?></td>
                        <td><?= $s->getScore();?></td>
                        <td><?= $s->getPing();?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>
    <div class="col-4">
        <?php
        if(!is_null($game->getMaps())){
            ?>
            <div class="card" style="width: 18rem;">
                <img src="https://urt-admin.12salopards.fr/maps/<?=$game->getMaps()->getFile();?>.jpg"/>
                <div class="card-body">
                    <h5 class="card-title">Carte <?= $game->getMaps()->getName();?></h5>
                    <ul class="card-text">
                        <?php
                        if(!is_null($game->getGamestypes()))
                        {
                          ?><li>Mode <?= $game->getGamestypes()->getName();?></li><?php
                        }
                        ?>
                            <li>Dur&eacute;e de la Partie: <?= $game->getTimelimit();?></li>
                            <li>Dur&eacute;e d'un Round: <?= $game->getRoundtime();?></li>
                    </ul>
            </div>
            <?php
        }
        ?>
    </div>
</div>
