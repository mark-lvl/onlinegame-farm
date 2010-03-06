<div class="farmThumb">
	<?php if(!$partner): ?>
            <?= $mainFarm ?>
            <?php if($farmSnapshot):?>
                <?= anchor("farms/show/",  "<img src=\"".$base_img."farm.png\" />") ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if($farmSnapshot):?>
                <?= anchor("farms/view/$user_profile->id",  "<img src=\"".$base_img."farm.png\" />") ?>
            <?php endif; ?>
        <?php endif; ?>
</div>
