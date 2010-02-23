
<div class="middle_box">
	<div class="message_list">
		<div class="message" style="height:20px;">
		    <div class="message_sender" style="font-weight:normal;">
		    	<span class="text_h6">
					<?= $lang['from'] ?>
				</span>
		    </div>
		    <div class="message_title">
		        <span class="text_h6">
					<?= $lang['title'] ?>
				</span>
		    </div>
		    <div class="message_date">
		    	<span class="text_h6">
		    		<?= $lang['date'] ?>
       			</span>
		    </div>
		    <div class="message_delete2" title="<?= $lang['delete_all'] ?>" id="delete_all">
		    </div>
		</div>
		<?php
			if(is_array($messages) && count($messages) > 0) {
			    foreach($messages as $x => $k) {
			?>
					<div class="message" id="msg<?= $k['id'] ?>">
					    <div class="message_sender" id="msgx<?= $k['id'] ?>" <?= ($k['checked'] == 0) ? 'style="font-weight:bold"' : NULL ?>>
					        <a href="<?= base_url() ?>profile/user/<?= $k['from'] ?>" style="color:#444;">
								<?= $k['first_name'] ?>
							</a>
					    </div>
					    <div class="message_title" id="msgxx<?= $k['id'] ?>" <?= ($k['checked'] == 0) ? 'style="font-weight:bold"' : NULL ?>>
					    	<a href="javascript:show_message(<?= $k['id'] ?>)" style="color:#444;">
								<?= $k['title'] ?>
							</a>
					    </div>
					    <div class="message_date">
					    	<?= convert_number(fa_strftime("%d %B %Y", $k['date'] . "")) ?>
					    </div>
						<div class="message_delete" id="<?= $k['id'] ?>">

					    </div>
					</div>
			<?php
			    }
			}
		?>
	</div>
	<div class="message_spacer">
	</div>
	<div class="message_show">
	    <div class="message_box">
	        <?= $lang['message_here'] ?>
		    <div class="eo_message_box">
		    	<?= $lang['endof_message'] ?>
		    </div>
	    </div>
	</div>
</div>
<?php
	$this->load->module('profile_left_boxes');
	$this->profile_left_boxes->method(array("friends" => $friends, "user_profile" => $user_profile, "users_ranks" => $users_ranks, "user" => $user, "lang" => $lang));
?>
<br style="clear:both" />
<br /><br />

<script>
	$(function(){
		$('input[title!=""]').hint("blur_hint");

		$("#delete_all").click( function() {
		    Boxy.confirm("<?= $lang['message_all_delete'] ?>", function() {
				$.post("<?= base_url() ?>gateway/delete_all_message/", { },
					function(data){
						switch(data) {
						    case "FALSE":
						        break;
							default:
		         				$(".message").fadeOut('fast');
							    break;
						}
				});
			}, {title:"<?= $lang['message_all_deletet'] ?>"});
		});
		
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
					    	$(".private_messages_load").html('<BR /><BR /><?= $lang["message_nsent"] ?>');
						    break;
					}
			});
		});
		
		$(".message_delete").click( function() {
		    var idx = this.id;
		    Boxy.confirm("<?= $lang['message_delete_text'] ?>", function() {
				$.post("<?= base_url() ?>gateway/delete_message/", { id: idx },
					function(data){
						switch(data) {
						    case "FALSE":
						        break;
							default:
		         				$("#msg" + idx).fadeOut('fast');
							    break;
						}
				});
			}, {title:"<?= $lang['message_delete'] ?>"});
		});
	});
	
	function show_message(id) {
		$.post("<?= base_url() ?>gateway/get_message/", { id: id },
			function(data){
				switch(data) {
				    case "FALSE":
				    	
				        break;
					default:
         				$("#msgx" + id).css("font-weight", "normal");
         				$("#msgxx" + id).css("font-weight", "normal");
				    	$(".message_box").html(data + '<div class="eo_message_box"><?= $lang['endof_message'] ?></div>');
				    	$(".eo_message_box").fadeIn('fast');
					    break;
				}
		});
	}
</script>