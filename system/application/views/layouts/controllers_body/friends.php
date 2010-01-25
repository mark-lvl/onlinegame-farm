<?php
	$this->load->module('profile_information');
	$this->profile_information->method(array("friends" => $friends, "rank" => $drivers_rank, "driver_profile" => $driver_profile, "driver" => $driver, "lang" => $lang));
?>
<div class="middle_box">
	<div class="edition_list">
	    <?php
	        if(is_array($friends) && count($friends) > 0) {
		        foreach($friends as $x => $k) {
		            ?>
					    <div class="one_friend_item">
					        <div class="friend_photo">
				                <a href="<?= base_url() ?>profile/driver/<?= ltrim($k->id, '0') ?>">
						            <?php
						            if($k->photo != "") {
						            ?>
						            	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=70&nh=70&source=../views/layouts/images/drivers/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
						            <?php
						            }
						            else {
						            ?>
						            	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=70&nh=70&source=../views/layouts/images/drivers/default.jpg&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
						            <?php
						            }
						            ?>
					            </a>
					        </div>
					        <div class="friend_info">
					            <a style='font-weight:bold; color:#444;' href="<?= base_url() ?>profile/driver/<?= ltrim($k->id, '0') ?>"><?= $k->first_name ?></a>
					            <BR />
					            <span class="text_h6"><?= $lang['score'] ?>:</span>
					            <?= convert_number($k->score . "") ?>
					            <BR />
					            <span class="text_h6"><?= $lang['birthdate'] ?>:</span>
					            <?= convert_number($k->jd_birthdate) ?>
								<div class="divider1" style="margin-top:6px; margin-bottom:0px;"></div>
								<?php
								    if($driver->id == $driver_profile->id) {
								?>
					            		<a class="message_delete" href="<?= base_url() ?>gateway/delete_friend/<?= ltrim($k->id, '0') ?>"><?= $lang['delete_friend'] ?></a>
					            <?php
					                }
					                else {
					                    $pt = FALSE;
					                    if($k->id != $driver->id) {
						                    foreach($friends_mine as $x2 => $k2) {
						                        if($k2->id == $k->id) { //Is your friend too!
													?>
													<a class="message_delete" href="<?= base_url() ?>gateway/delete_friend/<?= ltrim($k->id, '0') ?>"><?= $lang['delete_friend'] ?></a>
													<?php
						                            $pt = TRUE;
						                            break;
						                        }
						                    }
										}
					                    if(!$pt && $k->id != $driver->id) { //Can be added
					                        ?>
					                        <a class="add_friendx" href="<?= base_url() ?>gateway/add_friend/<?= ltrim($k->id, '0') ?>"><?= $lang['add_to_friend'] ?></a>
					                        <?php
					                    }
					                    else if($k->id == $driver->id){ //Is you!
					                        echo $lang['you_are'];
					                    }
					                }
					            ?>
					        </div>
					    </div>
		            <?php
		        }
			}
	    ?>
	</div>
</div>
<?php
	$this->load->module('profile_left_boxes');
	$this->profile_left_boxes->method(array("friends" => $friends, "driver_profile" => $driver_profile, "drivers_ranks" => $drivers_ranks, "driver" => $driver, "lang" => $lang));
?>
<br style="clear:both" />
<br /><br />

<script>
	$(function(){
		$('input[title!=""]').hint("blur_hint");
	});
</script>