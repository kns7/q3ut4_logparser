<div class="list-group-flush">
    <a href="#<?= str_replace("-","",$date) ."-global";?>" class="list-group-item list-group-item-action btn-gamescores" data-id="global" data-date="<?=$date;?>">Stats globales</a>
    <?php
    $counter = 0;
    foreach($games as $g){
    if($g->getScores()->count() > 0) { $counter++; }
    }
    foreach($games as $g){
        if($g->getScores()->count() > 0) {
            $name = "#" . $counter;
            if (!is_null($g->getGamestypes())) {
                $name .= ": " . $g->getGamestypes()->getName();
            } else {
                $name .= ": Mode Inconnu";
            }
            if (!is_null($g->getMaps())) {
                $name .= " sur " . $g->getMaps()->getName();
            } else {
                $name .= " sur carte inconnue";
            }
            ?>
            <a href="#<?= $g->getCreated()->format("Ymd") . "-" . $g->getId(); ?>"
               class="list-group-item list-group-item-action btn-gamescores"
               data-id="<?= $g->getId(); ?>"><?= $name; ?></a>
            <?php
            $counter--;
        }
    }
    ?>
</div>