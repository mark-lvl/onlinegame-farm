<center>
	<div class="middle_box">
	    <?php
	        if(is_array($tops)) {
	        	foreach($tops as $x => $k) {
 	   ?>
                        <div>
                            <div>
                                <a href="<?= base_url() ?>profile/user/<?= $k->id ?>">
                                            <?php
                                                if($k->photo != "") {
                                            ?>
                                                <img src="<?= $base_img ?> />
                                                <?php
                                                    }
                                                    else {
                                            ?>
                                                <img src="<?= $base_img ?>default.png" border="0" width="64px" height="64px"/>
                                                <?php
                                                    }
                                                ?>
                                </a>
                            </div>
                            <div>
                                 <span><?= $lang['name'] ?>:</span>
                                 <a href="<?= base_url() ?>profile/user/<?= $k->id ?>" style="color:#444; font-weight:bold;">
                                        <?= $k->first_name . " " . $k->last_name ?>
                                 </a>
                                 <BR />
                                 <span><?= $lang['level_label'] ?>:</span>
                                 <B><?= convert_number($k->level . "") ?></B>
                                 <BR />
                            </div>
                    </div>
	    <?php
	        	}
			}
			if(!is_array($tops) || count($tops) <= 0) {
			    echo '<center><BR /><BR /><BR /><B>' . $lang['no_match'] . '</B></center>';
			}
	    ?>
	</div>
	<a href="<?= base_url() ?>users/find/<?= floor($cnt / 6) ?>/<?= $filter ?>">
	    <?= $lang['last'] ?>
	</a>
	:
	<a href="<?= base_url() ?>users/find/<?= $page + 1 ?>/<?= $filter ?>">
	    <?= $lang['next'] ?>
	</a>
	&nbsp;
	<input type="text" value="<?= $page + 1 ?>" name="page" id="page" style="width:30px; text-align:center;" maxlength="4" />
	&nbsp;
	<a href="<?= base_url() ?>users/find/<?= $page - 1 ?>/<?= $filter ?>">
	    <?= $lang['previuos'] ?>
	</a>
	:
	<a href="<?= base_url() ?>users/find/<?= $filter ?>">
	    <?= $lang['first'] ?>
	</a>
	<BR /><BR />
</center>
<script>
	$("#page").keypress( function(e) {
	    if(!((e.which > 47 && e.which < 58) || e.which == 8 || e.which == 13 || e.which == 0)) {
	    	return false;
	    }
	    if(e.which == 13) {
	        var tmp = $("#page").val();
	        tmp--;
	        window.location = "<?= base_url() ?>users/find/" + tmp + "/<?= $filter ?>";
	    }
	});
</script>