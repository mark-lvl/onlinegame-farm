<div class="farmThumb">
	<?php if(!$partner): ?>
        <?= $mainFarm ?>
        <?php if($farmSnapshot):?>
            <?= anchor("farms/show/",  "<img src=\"".$base_img."farm.png\" />") ?>
        <?php endif; ?>
        <?php else: ?>
        <?php if($farmSnapshot):?>
            <?= anchor("farms/view/$userFarm->id",  "<img src=\"".$base_img."farm.png\" />") ?>
        <?php endif; ?>
        <?php endif; ?>
</div>
