<?php
include('header.php');
?>
    <div class="row">
        <div class="col-xl-2 col-lg-3">
            <div class="form-group">
                <select class="form-control" id="gamesdate">
                    <option value="0" selected>Choisissez une date de jeu</option>
                    <?php
                    foreach($dates as $d){
                        ?>
                        <option value="<?=$d->getCreated()->format("Y-m-d");?>"><?= $d->getCreated()->format("d/m/Y");?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <hr/>
            <div class="games-list"></div>
        </div>
        <div class="col-xl-10 col-lg-9 games-scores">

        </div>
    </div>
<?php
include('footer.php');