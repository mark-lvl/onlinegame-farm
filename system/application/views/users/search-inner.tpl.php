<div id="searchItems">
<?php
    if(is_array($items))
            foreach($items as $x => $k):
?>
            <div class="item">
                <span class="searchAvatar">
                    <a href="<?= base_url() ?>profile/user/<?= $k->id ?>">
                            <?php if($k->photo != ""): ?>
                                <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=52&nh=52&source=<?= $base_img."avatars/".$k->photo.".png" ?>&stype=png&dest=x&type=little" border="0" />
                            <?php else: ?>
                                <img src="<?= $base_img ?>default.png" border="0" width="52px" height="52px"/>
                            <?php endif; ?>
                    </a>
                </span>
                <span class="searchField">
                    <a href="<?= base_url() ?>profile/user/<?= $k->id ?>">
                        <?= $k->first_name . " " . $k->last_name ?>
                    </a>
                </span>

                <span class="searchField">
                    <span><?= $lang['level_label'] ?>:</span>
                    <B><?php if($k->level)
                                 echo convert_number($k->level . "");
                    		 else
                    			 echo $lang['havingAnyFarm']; ?>
                    </B>
                </span>
            </div>
            <?php endforeach; ?>
</div>
<div id="searchPager">
        <span class="pagerItem">
            <?= anchor("",
                       $lang['last'],
                       array('onclick'=>"searchPager(".ceil($cnt / 8).",$cnt);return false;"));
            ?>
        </span>
        <span class="pagerItem">
            <?php $nextPage = $page+1; ?>
            <?= anchor("",
                       $lang['next'],
                       array('onclick'=>"searchPager($nextPage,$cnt);return false;"));
            ?>
        </span>
        <span class="pagerItem">
            <form id="searchPagerForm" onsubmit="searchPager(0,<?= $cnt ?>);return false;">
                <input type="text"  name="page" id="page" value="<?= $page ?>" style="width:30px; text-align:center;" maxlength="4" />
            </form>
        </span>
        <span class="pagerItem">
            <?php $previuosPage = $page-1; ?>
            <?= anchor("",
                       $lang['previuos'],
                       array('onclick'=>"searchPager(". $previuosPage .",$cnt);return false;"));
            ?>
        </span>
        <span class="pagerItem">
            <?= anchor("",
                       $lang['first'],
                       array('onclick'=>"searchPager(1,$cnt);return false;"));
            ?>
        </span>
</div>