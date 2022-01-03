<?php
include('header.php');
?>
    <div class="row">
        <div class="col">
            <div class="form-group row justify-content-center">
                <div class="col-sm-4">
                    <select class="form-control" id="player_choose1">
                        <option value="0" selected>S&eacute;lectionner un Joueur</option>
                        <?php
                        foreach($players as $p){
                            ?><option value="<?=$p->getId();?>"><?= $p->getName();?></option><?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1 text-center"><img src="/img/versus.png"/></div>
                <div class="col-sm-4">
                    <select class="form-control" id="player_choose2">
                        <option value="0" selected>S&eacute;lectionner un Joueur</option>
                        <?php
                        foreach($players as $p){
                            ?><option value="<?=$p->getId();?>"><?= $p->getName();?></option><?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row justify-content-around">
                <div class="col-sm-3 text-center">
                    <button class="btn btn-primary">Afficher</button>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row versus-stats"></div>
<?php
include('footer.php');