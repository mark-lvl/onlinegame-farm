<script>
$(".expandStatistic").click(function() {
		$('#lessStatistic').hide();
                $('#moreStatistic').fadeIn('fast');
                $("#healthBar").progressBar(<?= $plant->health ?>,{
                    boxImage: '<?= $base_img ?>profile/progressbar/progressbar.gif',
                    barImage: {
                                0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
                                30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
                                70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
                    }
                });
	});
        $(".collapseStatistic").click(function() {
		$('#moreStatistic').hide();
                $('#lessStatistic').fadeIn('fast');
                $("#healthBar").progressBar(0,{
                    boxImage: '<?= $base_img ?>profile/progressbar/progressbar.gif',
                    barImage: {
                                0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
                                30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
                                70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
                    }
                });
	});
</script>



<div id="lessStatistic">
    <span class="statisticIcon">
        <?php $healthHolder = ($plant->health > 80)?"Good":(($plant->health > 60)?"Middle":(($plant->health > 40)?"Bad":"VeryBad")) ?>
        <span class="health<?= $healthHolder?>"></span>
    </span>
    <span class="statisticText">
    <span class="statisticTextHeader"><?= $lang['healthFarm'] ?></span>
        <?= str_replace('__HEALTH__', $lang[$healthHolder], $lang['farmStatisticsText']) ?>
    <span class="expandStatistic"></span>
    </span>
</div>
<div id="moreStatistic">
    <div class="moreDivation">
        <span class="label"><?= $lang['health'] ?></span>
        <span class="value"><div id="healthBar" class="progressBar"></div></span>
    </div>
    <div class="moreDivation">
        <span class="label"><?= $lang['weightInFarm'] ?></span>
        <span class="value"><?= $plant->weight." ".$lang['kilogram'] ?></span>
    </div>
    <div class="collapseStatistic"></div>
</div>
