<center>
	<div class="middle_box">
	    <?php
	        if(is_array($tops)) {
	        	foreach($tops as $x => $k) {
 	   ?>
				    <div class="car_item">
				        <div class="car_image">
				            <div class="car_image_holder1">
					            <div class="car_image_holder2">
					            	<img src="<?= base_url() ?>system/application/helpers/render.php?bg=profile_bg.jpg&driver_id=<?= $k['bid'] ?>&left=28&top=30&nw=224&nh=100&date=<?= date('Y_m_d_H_i_s') ?>" />
					            </div>
							</div>
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
				            <?= $lang['machine_of'] . " <a style='font-weight:bold;' href='" . base_url() . "profile/driver/" . $k['bid'] . "/'>" . $k['first_name'] . "</a>" ?>
				            <BR />
				            <?= $lang['score'] . ": <B>" . (int)($k['avt'] * 100) ?>%</B>
				            <BR />
				            <?= str_replace("XXX", " <B>" . convert_number($k['cnt'] + 1 . "</B>"), $lang['voters']) ?>
				        </div>
	    			</div>
	    <?php
	        	}
			}
	    ?>
	</div>
	<a href="<?= base_url() ?>renault_list/index/<?= floor($cnt / 6) ?>">
	    <?= $lang['last'] ?>
	</a>
	:
	<a href="<?= base_url() ?>renault_list/index/<?= $page + 1 ?>">
	    <?= $lang['next'] ?>
	</a>
	&nbsp;
	<input type="text" value="<?= $page + 1 ?>" name="page" id="page" style="width:30px; text-align:center;" maxlength="4" />
	&nbsp;
	<a href="<?= base_url() ?>renault_list/index/<?= $page - 1 ?>">
	    <?= $lang['previuos'] ?>
	</a>
	:
	<a href="<?= base_url() ?>renault_list/index/0/">
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
	        window.location = "<?= base_url() ?>drivers_list/index/" + tmp;
	    }
	});
</script>