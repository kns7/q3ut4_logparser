<?php
include('header.php');
?>
<div class="row">
    <div class="col">
        <div class="form-group row">
            <label class="col-3 col-form-label" for="player_choose">S&eacute;lectionner un joueur</label>
            <div class="col-9">
                <select class="form-control" id="player_choose">
                    <option value="0" selected>----</option>
                    <?php
                    foreach($players as $p){
                        ?><option value="<?=$p->getId();?>"><?= $p->getName();?></option><?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<hr/>
<div class="row players-stats"></div>
<?php
include('footer.php');