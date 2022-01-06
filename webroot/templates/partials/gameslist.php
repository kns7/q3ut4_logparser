<div class="list-group">
    <?php
    foreach($games as $g){
        $name = "#".$g->getGameNB();
        if(!is_null($g->getGamestypes())){
            $name .= ": ".$g->getGamestypes()->getName();
        }else{
            $name .= ": Mode Inconnu";
        }
        if(!is_null($g->getMaps())){
            $name .= " sur ". $g->getMaps()->getName();
        }else{
            $name .= " sur carte inconnue";
        }
        ?>
        <a href="#<?=$g->getCreated()->format("Ymd")."-".$g->getId();?>" class="list-group-item list-group-item-action btn-gamescores" data-id="<?=$g->getId();?>"><?= $name;?></a>
        <?php
    }
    ?>
</div>