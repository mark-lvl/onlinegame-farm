<div class="left_box">
	<div class="drivers_friends">
		<div class="all_friends">
		    <?php
		        if(is_array($friends) && count($friends) > 0) {
			?>
				    <a href="<?= base_url() ?>friends/all/<?= $driver_profile->id ?>" style="font-size:10px;">
				    	<?= $lang['all_friends'] ?>
				    </a>
		    <?php
		        }
		    ?>
		</div>
	    <div class="friends_list">
	    <?php
	        if(is_array($friends) && count($friends) > 0) {
		        foreach($friends as $x => $k) {
		            ?>
		            <div class="friends_photo" title="<?= $k->first_name ?>">
		                <a href="<?= base_url() ?>profile/driver/<?= ltrim($k->id, '0') ?>">
				            <?php
				            if($k->photo != "") {
				            ?>
				            	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=30&nh=30&source=../views/layouts/images/drivers/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				            <?php
				            }
				            else {
				            ?>
				            	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=30&nh=30&source=../views/layouts/images/drivers/default.jpg&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				            <?php
				            }
				            ?>
			            </a>
		            </div>
		            <?php
		        }
			}
			else {
			    echo "<span style='font-size:11px; text-align:right;'>" . $lang['no_friend'] . "</span>";
			}
	    ?>
	    </div>
	</div>
	<div class="positions">
	    <?php
			$ranks = array();
			if(is_array($drivers_ranks)) {
		        foreach($drivers_ranks as $x => $k) {
		            if(!isset($ranks[$k['rank']])) {
		            	$ranks[$k['rank']] = 1;
		            }
		            else {
		        		$ranks[$k['rank']]++;
					}
				}

				$i = 0;
				foreach($ranks as $x => $k) {
				    $i++;
				    if($i > 4) { //Show only 4 top ranks
				        break;
				    }
				    
				    if($x == 1) {
				    ?>
				        <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/first.png" style="float:right" />
				    <?php
				    }
				    else if($x == 2) {
				    ?>
				        <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/second.png" style="float:right" />
				    <?php
				    }
				    else if($x == 3) {
				    ?>
				        <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/third.png" style="float:right" />
				    <?php
				    }
				    else {
				    ?>
				        <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/medal.png" style="float:right" />
				    <?php
				    }
					?>
			        &nbsp;<?= convert_number($k . "") . " " . $lang['times'] . " " . $lang['f' . $x] ?>
			        <br style="clear:both;" />
			        <?php
				}
			}
			else {
			    echo $lang['no_rank'];
	        }
	    ?>
	</div>
	<?php
	    if(!is_object($driver) || $driver_profile->id != $driver->id) {
	?>
			<div class="private_messages">
			    <div class="private_messages_text">
			        <textarea id="private_messages_textarea" style="border:0px; overflow:hidden; font-size:10px; font-family:Tahoma;" cols="30" rows="4"></textarea>
			    </div>
			    <div class="private_messages_send">
			    	<input style="font-size:10px; float:left;" type="button" value="<?= $lang['submit'] ?>" />
			    </div>
			    <div class="private_messages_load">
			    </div>
			</div>
	<?php
	    }
	    else {
	    ?>
			<div class="infos">
			    <div class="private_messages_text">
			        <?php
			            $msg_counter = 0;
			            $messages = Drivers_model::get_messages($driver_profile);
			            $i = 0;
			            if(is_array($messages) && count($messages) > 0) {
				            foreach($messages as $x => $k) {
				                if($k['checked'] == 0) {
				                    $i++;
				                }
				            }
						}
			            if($i > 0) {
			            	$msg_counter++;
			                echo "<div class='alert'><span style='font-weight:bold'>" . convert_number($i . "") . "</span> " . $lang['new_messages'] . "<BR /><a href='" . base_url() . "inbox/'>" . $lang['go_inbox'] . "</a></div>";
			            }

			            if($driver_profile->newsletter == 0) {
               				$msg_counter++;
			            	echo "<div class='newsletter'>" . $lang['join_newsletter'] . "</div>";
			            }
			            if($msg_counter < 2) {
			            	echo "<div class='objective'>" . $lang['next_objective' . Driver::get_drivers_next_lock($driver_profile)] . "</div>";
			            }
			        ?>
			    </div>
			</div>
	    <?php
	    }
	?>
</div>