<center>
	<div class="middle_box">
	    <?php
	        if(is_array($tops)) {
	        	foreach($tops as $x => $k) {
 	   ?>
				    <div class="driver_item">
				        <div class="driver_image">
				        	<a href="<?= base_url() ?>profile/driver/<?= $k->id ?>">
							    <?php
							        if($k->photo != "") {
							    ?>
							    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=110&nh=110&source=../views/layouts/images/drivers/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date('Y_m_d_H_i_s') ?>" border="0" />
								<?php
								    }
								    else {
							    ?>
							    	<img src="<?= base_url() ?>system/application/views/layouts/images/drivers/default.jpg" border="0" />
								<?php
								    }
								?>
							</a>
				        </div>
				        <div class="car_descritpion">
				            <div class="label">
				                <?php
				                    $tt = ($page * 6) + $x + 1;
				                    if($tt <= 9999) {
				                        echo $tt;
				                    }
				                    else {
				                        echo "+10k";
				                    }
								?>
				            </div>
						    <span class="text_h6"><?= $lang['name'] ?>:</span>
							<a href="<?= base_url() ?>profile/driver/<?= $k->id ?>" style="color:#444; font-weight:bold;">
								<?= $k->first_name . " " . $k->last_name ?>
							</a>
							<BR />
							<span class="text_h6"><?= $lang['score'] ?>:</span>
							<B><?= convert_number($k->score . "") ?></B>
							<BR />
							<span class="text_h6"><?= $lang['rally_count'] ?>:</span>
							<?= convert_number($k->rally_count . "") ?>
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
	<a href="<?= base_url() ?>drivers_list/index/<?= floor($cnt / 6) ?>/<?= $filter ?>">
	    <?= $lang['last'] ?>
	</a>
	:
	<a href="<?= base_url() ?>drivers_list/index/<?= $page + 1 ?>/<?= $filter ?>">
	    <?= $lang['next'] ?>
	</a>
	&nbsp;
	<input type="text" value="<?= $page + 1 ?>" name="page" id="page" style="width:30px; text-align:center;" maxlength="4" />
	&nbsp;
	<a href="<?= base_url() ?>drivers_list/index/<?= $page - 1 ?>/<?= $filter ?>">
	    <?= $lang['previuos'] ?>
	</a>
	:
	<a href="<?= base_url() ?>drivers_list/index/0/<?= $filter ?>">
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
	        window.location = "<?= base_url() ?>drivers_list/index/" + tmp + "/<?= $filter ?>";
	    }
	});
</script>