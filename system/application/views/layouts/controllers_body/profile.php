<?php
	$this->load->module('profile_information');
	$this->profile_information->method(array("friends" => $friends, "rank" => $drivers_rank, "driver_profile" => $driver_profile, "driver" => $driver, "lang" => $lang));
?>
<div class="middle_box">
	<div class="drivers_car">
	    <div class="like">
	    </div>
	    <div class="dislike">
	    </div>
	    <div class="voters">
	        <?= (int)($car_vote[0]['avt'] * 100) . "%" ?>
	    </div>
	    <div class="vote_description">
	        <?= $lang['profile_desc'] ?>
	    </div>
	    <div class="voters_submit">
	        <?= $lang['fromx'] ?>
	        <span id='voters_num'><?= $car_vote[0]['cnt']  ?></span>
			<?= $lang['votesx'] ?>
	    </div>
	    <div class="car_view">
	        <img src="<?= base_url() ?>system/application/helpers/render.php?bg=profile_bg.jpg&driver_id=<?= $driver_profile->id ?>&left=28&top=30&date=<?= date('Y-m-d H:i:s') ?>" />
	    </div>
	    <?php
	    	if($driver_profile->id == $driver->id) {
	    ?>
			    <div class="car_edit" title="<?= $lang['redesign_car'] ?>">
			    </div>
				<div class="car_edit_desc">
					<?= $lang['redesign_desc'] ?>
					<BR />
					<a href="<?= base_url() ?>design/">
						<?= $lang['yes'] ?>
					</a>
					|
					<a href="javascript:edition_hide()">
						<?= $lang['no'] ?>
					</a>
				</div>
		<?php
		    }
	        if(isset($driver_car_vote) && is_array($driver_car_vote)) {
		?>
			    <div class="delete_vote" title="<?= $lang['delete_vote'] ?>">
			    </div>
		<?php
		    }
		?>
	</div>
    <?php
        $class = "";
        if(isset($race) && is_object($race)) {
	        switch(substr($race->type, 0, 2)) {
	            case 11:
	            	$race_type = $lang['race_type'] . " " . $lang['type_11'];
	            	$class = "driver_current_race_free";
	            	break;
	            case 12:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_12'];
	            	$class = "driver_current_race_free";
	            	break;
	            case 13:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_13'];
	                $class = "driver_current_race_free";
	                break;
	            case 21:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_21'];
	            	$class = "driver_current_race_mountain";
	            	break;
	            case 22:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_22'];
	            	$class = "driver_current_race_mountain";
	            	break;
	            case 23:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_23'];
	                $class = "driver_current_race_mountain";
	                break;
	            case 31:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_31'];
	            	$class = "driver_current_race_jungle";
	            	break;
	            case 32:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_32'];
	            	$class = "driver_current_race_jungle";
	            	break;
	            case 33:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_33'];
	                $class = "driver_current_race_jungle";
	                break;
	            case 41:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_41'];
	            	$class = "driver_current_race_desert";
	            	break;
	            case 42:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_42'];
	            	$class = "driver_current_race_desert";
	            	break;
	            case 43:
	            	$race_type = $lang['race_type'] . " " .  $lang['type_43'];
	                $class = "driver_current_race_desert";
	                break;
	        }
	        ?>
		    <div class="<?= $class ?>" id="rally_gogo">
		        <div class="driver_current_speed">
		            <B><?= convert_number($driver->current_speed . "") ?></B>
		            <?= $lang['kph'] ?>
		        </div>
		        <div class="driver_current_race_name">
		            <?= $race->name ?>
		        </div>
		        <div class="driver_nex_checkpoint">
		        	<?= $lang['aprox'] ?> <?= convert_number(fa_strftime("%A", $driver->time_next_checkpoint . "") . " <B>" . substr($driver->time_next_checkpoint, 11, 5) . "</B>") ?>
		        </div>
		        <div class="driver_position">
		         	<?php
		         	    $rnk = Drivers_model::get_drivers_rank_in_race($driver);
		         	    if($rnk > 99) {
					 	    echo "99k+";
					 	}
					 	else {
					 	    echo $rnk;
					 	}
					?>
				</div>
				<div class="race_type">
					<?= $race_type ?>
				</div>
		    </div>
	        <?php
		}
		else if($driver_profile->id == $driver->id) {
		?>
		<div class="no_current_race">
		</div>
		<?php
		}
    ?>
</div>
<?php
	$this->load->module('profile_left_boxes');
	$this->profile_left_boxes->method(array("friends" => $friends, "driver_profile" => $driver_profile, "drivers_ranks" => $drivers_ranks, "driver" => $driver, "lang" => $lang));
?>

<br style="clear:both" />
<br /><br />

<script>
	function edition_hide() {
		$(".car_edit_desc").animate({height: "0px"}, 150);
	}
	
	$(function(){
	    $("#rally_gogo").click( function() {
	        <?php
	        	if($driver_profile->id == $driver->id) {
	        ?>
	        		window.location = "<?= base_url() ?>rally/";
	        <?php
	            }
	            else {
            ?>
            		window.location = "<?= base_url() ?>rally/index/<?= $driver_profile->id ?>";
            <?php
	            }
	        ?>
		});
		
		var tpx = '<?= $car_vote[0]['cnt'] ?>';
	    var vote = false;
	    <?php
	        if((isset($driver_car_vote) && is_array($driver_car_vote)) || $driver_profile->id == $driver->id || !$driver) {
	            ?>
		    	$(".dislike").fadeOut('fast');
		    	$(".like").animate({height: "0px", top: "88px"}, 350, "", function() {
		    		$(".voters").animate({height: "55px", top: "49px"}, 350);
		    		$(".voters_submit").fadeIn('fast');
				});
	            <?php
	        }
	    ?>
		$(".delete_vote").click( function() {
		    window.location = "<?= base_url() ?>gateway/delete_vote/<?= $driver_profile->car ?>";
		});

		$(".car_edit").click( function() {
	    	$(".car_edit_desc").animate({height: "25px"}, 150);
		});
		
		$(".no_current_race").click( function() {
		    window.location = "<?= base_url() ?>rally_selection/";
		});
		
	    $(".like").click(function(){
	    	tpx++;
	    	$("#voters_num").html(tpx);
	        if(vote) {
	            return;
	        }
	        <?php
	            if($car_vote[0]['first']) {
	        ?>
	        	var tmx = "100%";
	        <?php
	            } else {
	            ?>
	            var tmx = "<?= (int)((($car_vote[0]['smt'] + 1) / ($car_vote[0]['cnt'] + 1)) * 100) ?>%";
	            <?php
	            }
			?>
	    	vote = true;
	    	$(".dislike").fadeOut('fast');
			$.post("<?= base_url() ?>gateway/submit_vote/", { car: "<?= $driver_profile->car ?>", vote: 1 },
				function(data){
					switch(data) {
					    case "TRUE":
					    	$(".like").animate({height: "0px", top: "88px"}, 350, "", function() {
					    		$(".voters").html(tmx);
					    		$(".voters").animate({height: "55px", top: "49px"}, 350);
					    		$(".voters_submit").fadeIn('fast');
							});
							break;
						default:
					    	$(".dislike").fadeIn('fast');
						    break;
					}
			});
		});

	    $(".dislike").click(function(){
	    	tpx++;
	    	$("#voters_num").html(tpx);
	        if(vote) {
	            return;
	        }
	        <?php
	            if($car_vote[0]['first']) {
	        ?>
	        	var tmx = "0%";
	        <?php
	            } else {
	            ?>
	            var tmx = "<?= (int)(($car_vote[0]['smt'] / ($car_vote[0]['cnt'] + 1)) * 100) ?>%";
	            <?php
	            }
			?>
	    	vote = true;
	    	$(".like").fadeOut('fast');
			$.post("<?= base_url() ?>gateway/submit_vote/", { car: "<?= $driver_profile->car ?>", vote: 0 },
				function(data){
					switch(data) {
					    case "TRUE":
					    	$(".dislike").animate({height: "0px", top: "88px"}, 350, "", function() {
					    		$(".voters").html(tmx);
					    		$(".voters").animate({height: "55px", top: "49px"}, 350);
					    		$(".voters_submit").fadeIn('fast');
							});
							break;
						default:
					    	$(".like").fadeIn('fast');
						    break;
					}
			});
		});

		
		$('input[title!=""]').hint("blur_hint");

		$(".private_messages_send").click( function() {
			$(".private_messages_send").css('display', 'none');
		    $(".private_messages_load").fadeIn();
		    $(".private_messages_load").html('<BR /><BR /><?= $lang["wait_a_moment"] ?>');

			$.post("<?= base_url() ?>gateway/send_message/", { to: "<?= $driver_profile->id ?>", body: $("#private_messages_textarea").val() },
				function(data){
					switch(data) {
					    case "TRUE":
					    	$(".private_messages_load").html('<BR /><BR /><?= $lang["message_sent"] ?>');
					        break;
						default:
					    	$(".private_messages_load").html('<BR /><?= $lang["message_nsent"] ?>');
						    break;
					}
			});
		});
	});
</script>