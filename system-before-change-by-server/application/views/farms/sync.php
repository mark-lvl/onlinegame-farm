
PlantHealth:<?= $plant->health ?><br/>
PlantWeight:<?= $plant->weight ?>
<span>
<?=
    anchor("farms/sync/$plant->farm_id",
           "<img src=\"".$base_img."sync.png\" />",
           array('onclick'=>"sync(".$plant->farm_id.");return false;"))."<br/>";
?>
    </span>
<?php if($plant->growth > 0): ?>
        PlantGrowth:

<div id="plantGrowthHolder" class="healthcounter"></div>

<script>
    $(function () {
        var growthTime = <?= $plant->growth; ?>;
        $('#plantGrowthHolder').countdown({until: growthTime,
                                           onExpiry: liftOff
                                         });
    });
</script>

<?php elseif($plant->id):
        echo anchor("farms/reap/$plant->id",
                    "REAP",
                     array('onclick'=>"reap(".$plant->id.");return false;"))."<br/>";
      endif;
?>
