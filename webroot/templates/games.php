<?php
include('header.php');
?>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="form-group">
                <select class="form-control" id="gamesdate">
                    <option value="0" selected>Choisissez une date de jeu</option>
                    <?php
                    foreach($dates as $d){
                        if($d->getCreated()->format("Y-m-d") == "2020-01-01"){
                            $text = "Année 2020 (Ancien Serveur)";
                        }elseif($d->getCreated()->format("Y-m-d") == "2021-01-01"){
                            $text = "Année 2021 (Nouveau Serveur)";
                        }else{
                            $text = $d->getCreated()->format("Y-m-d");
                        }
                        ?>
                        <option value="<?=$d->getCreated()->format("Y-m-d");?>"><?= $text;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <hr/>
            <div class="games-list"></div>
        </div>
        <div class="col-xl-9 col-lg-8 games-scores">

        </div>
    </div>
<?php
include('footer.php');