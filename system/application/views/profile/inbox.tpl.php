<style>
    #centerContainerSecondLayer
    {
    background: #2b3b09 url(<?= $base_img ?>profile/inbox_bg.gif) no-repeat center;
    height: 388px;
    width: 464px;
    display: block;
    margin-top: 9px;
    }
    .closeButton
    {
        width:26px;
        height:26px;
        display:block;
        right:1px;
        position:absolute;
        top:1px;
    }
    .closeButton img
    {
        width:26px;
        height:26px;
        display:block;
        cursor: pointer;
    }
</style>

<script>
    $('.closeButton').click(function(){
        $('#centerContainerSecondLayer').hide();
        $('#centerContainer').show();
    })
</script>
    <div id="inboxHolder">
        <span class="closeButton"><img src="<?= $base_img ?>popup/boxy/close.png" /></span>
        <div id="delete_all"><a style="display:block;width:16px;height:16px;" title="<?= $lang['deleteAll'] ?>"></a></div>
        <div class="message_list">
            <div id="messageListContainer" >
            <?php
                    if(is_array($messages) && count($messages) > 0) {
                        foreach($messages as $x => $k) {
                    ?>
                                    <div class="message" id="msg<?= $k['id'] ?>">
                                        <div class="message_sender" id="msgx<?= $k['id'] ?>" <?= ($k['checked'] == 0) ? 'style="font-weight:bold"' : NULL ?>>
                                            <a href="<?= base_url() ?>profile/user/<?= $k['from'] ?>" >
                                                            <?= $k['first_name'] ?>
                                                    </a>
                                        </div>
                                        <div class="message_title" id="msgxx<?= $k['id'] ?>" <?= ($k['checked'] == 0) ? 'style="font-weight:bold"' : NULL ?>>
                                            <a href="javascript:show_message(<?= $k['id'].",'".$k['first_name']."','".convert_number(fa_strftime("%d %B %Y", $k['date'] . "")) ."'" ?>)" >
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
        </div>
	
	<div class="message_show">
            <div class="messageIcon">
                <span></span>
            </div>
	    <div class="message_box">
                <span class="messageDate"></span>
                <span class="messageSender"></span>
                <span class="messageShowBox">
                    <?= $lang['message_here'] ?>
                </span>
                
	    </div>
	</div>
</div>

<script>
	$(function(){
		$('input[title!=""]').hint("blur_hint");

                $('#messageListContainer').jScrollPane();
                $('.messageShowBox').jScrollPane();

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

	function show_message(id,name,date) {
		$.post("<?= base_url() ?>gateway/get_message/", { id: id },
			function(data){
				switch(data) {
				    case "FALSE":

				        break;
					default:
         				$("#msgx" + id).css("font-weight", "normal");
         				$("#msgxx" + id).css("font-weight", "normal");
                                        $(".messageDate").html(date);
                                        $(".messageSender").html("<span class=\"name\" >"+name+"</span><?= " ".$lang['wrote'].":" ?>");
				    	$(".messageShowBox").html(data + '<div class="eo_message_box"><?= $lang['endof_message'] ?></div>');
				    	$(".eo_message_box").fadeIn('fast');
					    break;
				}
		});
	}
</script>