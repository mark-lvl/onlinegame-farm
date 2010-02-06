<?php
	$this->load->module('profile_information');
	$this->profile_information->method(array("friends" => $friends, "rank" => $users_rank, "user_profile" => $user_profile, "user" => $user, "lang" => $lang));
?>
<div class="middle_box">
	<?= $mainFarm ?>
</div>
<?php
	$this->load->module('profile_left_boxes');
	$this->profile_left_boxes->method(array("friends" => $friends, "user_profile" => $user_profile, "users_ranks" => $users_ranks, "user" => $user, "lang" => $lang));
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
	        	if($user_profile->id == $user->id) {
	        ?>
	        		window.location = "<?= base_url() ?>rally/";
	        <?php
	            }
	            else {
            ?>
            		window.location = "<?= base_url() ?>rally/index/<?= $user_profile->id ?>";
            <?php
	            }
	        ?>
		});
		
		var tpx = '<?= $car_vote[0]['cnt'] ?>';
	    var vote = false;
	    <?php
	        if((isset($user_car_vote) && is_array($user_car_vote)) || $user_profile->id == $user->id || !$user) {
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
		    window.location = "<?= base_url() ?>gateway/delete_vote/<?= $user_profile->car ?>";
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
			$.post("<?= base_url() ?>gateway/submit_vote/", { car: "<?= $user_profile->car ?>", vote: 1 },
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
			$.post("<?= base_url() ?>gateway/submit_vote/", { car: "<?= $user_profile->car ?>", vote: 0 },
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

			$.post("<?= base_url() ?>gateway/send_message/", { to: "<?= $user_profile->id ?>", body: $("#private_messages_textarea").val() },
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