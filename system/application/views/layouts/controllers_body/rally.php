<div class="speed_panel" title="<?= $lang['speed'] ?>">
	<?php
	    if($driver_profile->current_speed < 10) {
			echo "00" . $driver_profile->current_speed;
		}
	    else if($driver_profile->current_speed >= 10 && $driver_profile->current_speed < 100) {
			echo "0" . $driver_profile->current_speed;
		}
		else {
			echo $driver_profile->current_speed;
		}
	?>
</div>
<div class="nokia_panel" title="<?= $lang['question'] ?>">
	<div class="question_counter">
	    <?= "<B><span id='qnum'>" . $questions . "</span></B>" ?>
	</div>
</div>
<div class="dialog_box_panel_big" id="dialog_box_panel3">
	<div id="dialog_bk_big">
	</div>
	<div class="dialog_close" id="panel3">
	</div>
	<div class="question_icon" id="panel3_question_icon">
	</div>
	<div class="dialog_text2" id="panel3_question_text">
	</div>
	<div class="dialog_text2" id="panel3_question_question">
	</div>
	<div class="question_submit">
	    <input type="button" id="submit_answer" style="cursor:pointer;" value="<?= $lang['submit'] ?>" />
	</div>
	<div class="dialog_bk_big_loader">
	    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/rally/loader.gif" />
	</div>
</div>
<div class="progress_bar" title="<?= $lang['current_city'] ?>">
	<div class="bar_bk">
		<div class="bar_progress" style="width:<?= ceil((185 * (($driver->current_position / 10) / $race->length)/100)) . "px"  ?>;">
		</div>
	</div>
	<div class="bar_top_info">
	    <?= "<span style='color:yellow;'>" . $race->name . "</span>, " . convert_number($race->length . "") . $lang['race_length'] . " <span style='color:yellow;'>" . $lang['race_passed'] . ":</span> " . convert_number(floor((($driver->current_position / 10) / $race->length)) . "") . "% " ?>
	</div>
	<div class="bar_bottom_info">
	    <?php
	        if($checkpoint->city == "") {
	        	$checkpoint->city = $lang['race_start'];
	        }
	    ?>
	    <?= "<span style='color:yellow;'>" . $lang['current_city'] . ":</span> " . $checkpoint->city ?>,
	    <?= "<span style='color:yellow;'>" . $lang['all_drivers'] . ":</span> " . convert_number(Drivers_model::get_total_race_drivers($driver_profile->current_race) . "") . " " . $lang['person'] ?>
	</div>
</div>

<div class="rank" title="<?= $lang['rank'] ?>">
	<?= $rank ?>
</div>

<div class="challenge">
	<?php
	    if($challenge['profile']) {
	?>
	        <div class="challenge_name">
	            <a href="<?= base_url() ?>profile/driver/<?= $challenge['profile']->id ?>" style="color:#FFF">
	            	<?= $challenge['profile']->first_name . " " . $challenge['profile']->last_name ?>
				</a>
	        </div>
			<div class="challenge_photo">
			    <a href="<?= base_url() ?>profile/driver/<?= $challenge['profile']->id ?>">
			    <?php
			        if($challenge['profile']->photo != "") {
			    ?>
			    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=50&nh=50&source=../views/layouts/images/drivers/<?= $challenge['profile']->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				<?php
				    }
				    else {
			    ?>
			    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=50&nh=50&source=../views/layouts/images/drivers/default.jpg&stype=jpg&dest=x&type=little" border="0" />
				<?php
				    }
				?>
				</a>
			</div>

			<?php
				if($challenge['type'] == 1) {
			?>
					<div class="challeng_button challengim">
					</div>
			<?php
				}
			    else if($challenge['type'] == 2) {
			?>
					<div class="challeng_button has_challenged">
					</div>
					<div class="challeng_button cancel_challenged" id="cancel_challenged">
					</div>
			<?php
			    }
			    else if($challenge['type'] == 3) {
			?>
					<div class="challeng_button get_challenged">
					</div>
					<div class="challeng_button cancel_challenged" id="cancel_challenged">
					</div>
			<?php
			    }
			?>
			<div class="challeng_button ok_challenged">
			</div>
	<?php
	    }
	?>
</div>
<?php
	if($driver_profile->id == $driver->id) {
	    if($driver_profile->current_speed >= $race->max_speed) {
	        $box = "info";
	        $msg = $lang['max_speed'];
	    }
	    else if($questions > 0) {
	        $box = "info";
	        $msg = str_replace("XXX", convert_number($questions . ""), $lang['info_alert']);
	    }
	    else if(!$questions) {
	        $box = "info";
	        $msg = str_replace("XXX", convert_number(fa_strftime("%A", $driver_profile->time_next_checkpoint . "") . " " . substr($driver_profile->time_next_checkpoint, 11, 5)) ,$lang['time_hint']) . " " . $lang['rest_till'];
	    }

		if($box == "alert") {
?>
			<div class="alert_panel" id="panelic">
			    <div class="alert_panel_close" id="panelic_close">
			    </div>
				<?= $msg ?>
			</div>
			<div class="alert_icon" id="iconic">
			</div>
<?php
		}
		else if($box == "info") {
?>
			<div class="info_panel" id="panelic">
			    <div class="alert_panel_close" id="panelic_close">
			    </div>
			    <span id="panelic_msg">
					<?= $msg ?>
				</span>
			</div>
			<div class="info_icon" id="iconic">
			</div>
<?php
		}
	}
	else {
?>
			<div class="pov_panel" id="panelic">
			    <div class="alert_panel_close" id="panelic_close">
			    </div>
			    <div class="pov_text">
				    <a style="color:#FFF;" href="<?= base_url() ?>profile/driver/<?= $driver_profile->id ?>">
						<?= $driver_profile->first_name . " " . $driver_profile->last_name ?>
					</a>
				</div>
			    <div class="pov_photo">
					<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=40&nh=40&source=../views/layouts/images/drivers/<?= $driver_profile->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date('Y-m-dH:i:s') ?>" border="0" />
				</div>
				<div class="photo_border">
				</div>
			</div>
			<div class="pov_icon" id="iconic">
			</div>
<?php
	}
?>
<div class="dialog_box_panel" id="dialog_box_panel2">
	<div class="dialog_bk">
	</div>
	<div class="dialog_close" id="panel2">
	</div>
	<div class="dialog_text" id="dialog_box_panel2_text">
	    <?php
			echo str_replace("X", convert_number(floor(($updated_driver->current_position / 10) / $race->length) . ""), str_replace("XX", convert_number($race->length . ""), str_replace("XXX", convert_number(floor($driver_profile->current_position / 1000) . "") , $lang['navigate_hint'])));
		?>
	</div>
</div>

<div class="dialog_box_panel" id="dialog_box_panel1">
	<div class="dialog_bk">
	</div>
	<div class="dialog_close" id="panel1">
	</div>
	<div class="dialog_textx">
	    <?php
			echo str_replace("XXX", "<font style='color:yellow;'>" . convert_number(fa_strftime("%A", $driver_profile->time_next_checkpoint . "") . " " . substr($driver_profile->time_next_checkpoint, 11, 5)) . "</font>" ,$lang['time_hint']);
		?>
	</div>
</div>

<div class="first_hint" <?= ($driver->current_position > 100 || $driver->rally_count != 0) ? "style='display:none'" : "" ?>>
	<div class="hint_close">
	</div>
</div>

<div class="sliding_panel">
</div>
<div class="sliding_panel_open">
	<div class="sliding_panel_close">
	</div>
	<div class="diary_title"><?php
	        if($diary) {
	            echo $diary[0]['title'];
	        }
	    ?></div>
	<div class="diary_body"><?php
	        if($diary) {
	            echo $diary[0]['body'];
	        }
	        else {
	            echo $lang['nodiary'];
	        }
	    ?></div>
	<?php
 	if($diary) {
 	?>
		<div class="diary_body_sim">
			<div class="updown">
			    <div class="up">
			    </div>
			    <div class="down">
			    </div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="diary_title2" id="input_title">
		<input type="text" value="" name="dtitle" id="dtitle" maxlength="30" title="<?= $lang['title'] ?>" />
	</div>
	<div class="diary_body2" id="diary_input">
	    <textarea rows="7" cols="17" id="diary_textarea" title="<?= $lang['body'] ?>"></textarea>
	</div>
	<?php
    if($diary && $driver_profile->id == $driver->id) {
    ?>
	    <div class="diary_box_item_delete" title="<?= $lang['delete_woym'] ?>" id="delete_diary">
	    </div>
	<?php
 	}
	?>
	<div class="diary_box">
	    <div class="diary_box_item heart" title="<?= ($diary_vote) ? $lang['nlikeitd'] : $lang['likeit'] ?>" <?= (!$diary) ? "style='display:none'": NULL; ?>><?php
	            if($driver_profile->id != $driver->id) {
	                if($diary_vote) {
	                	echo $lang['nlikeit'];
	                }
	                else {
	                	echo $lang['likeit'];
	                }
	            }
	            else {
	                echo "<span id='votes_num'>" . $diary_votes . "</span> " . $lang['times'];
	            }
	        ?></div>
        <?php
            if($driver_profile->id == $driver->id) {
		?>
	    <div class="diary_box_item new" title="<?= $lang['new_woym'] ?>" id="new_diary">
	    	<?= $lang['new_woym'] ?>
	    </div>
	    <div class="diary_box_item edit" title="<?= $lang['edit_woym'] ?>" id="edit_diary" <?= (!$diary) ? "style='display:none'": NULL; ?>>
	        <?= $lang['edit_woym'] ?>
	    </div>
	    <input type="hidden" value="<?= ($diary) ? $diary[0]['id'] : NULL ?>" name="did" id="did" />
	    <?php
	        }
	        elseif($diary) {
	    ?>
	        <div style="color:#DDD; margin-top:4px;">
	        	<?= convert_number($diary_votes . "") . " " . $lang['peoplelike'] ?>
			</div>
	    <?php
	        }
	    ?>
	</div>
</div>

<?php
	$ch_flash = $checkpoint->road_situation;
	if($ch_flash < 3) {
		$ch_flash = 0;
	}
?>

<!--
<div class="dashboard_panel" id="dashboard_panel">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="878" height="425" id="mountain" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="swliveconnect" value="true" />
	<param name="wmode" value="transparent" />
	<param name="movie" value="<?= base_url() ?>system/application/views/layouts/flash/scenes/<?= substr($race->type, 0, 1) . $ch_flash ?>.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffd401" />	<embed swliveconnect="true" wmode="transparent" src="<?= base_url() ?>system/application/views/layouts/flash/scenes/<?= substr($race->type, 0, 1) . $ch_flash ?>.swf" quality="high" bgcolor="#ffd401" width="878" height="425" name="mountain" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</div>
-->

<div class="dashboard_panel" id="dashboard_panel">
	<div class="dashboard_up">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="878" height="180" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="swliveconnect" value="true" />
		<param name="wmode" value="transparent" />
		<param name="movie" value="<?= base_url() ?>system/application/views/layouts/flash/scenes/1.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffd401" />	<embed swliveconnect="true" wmode="transparent" src="<?= base_url() ?>system/application/views/layouts/flash/scenes/1.swf" quality="high" bgcolor="#ffd401" width="878" height="180" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
	</div>
	<div class="dashboard_down">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="878" height="330" id="mountain" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="swliveconnect" value="true" />
		<param name="wmode" value="transparent" />
		<param name="movie" value="<?= base_url() ?>system/application/views/layouts/flash/scenes/2.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffd401" />	<embed swliveconnect="true" wmode="transparent" src="<?= base_url() ?>system/application/views/layouts/flash/scenes/2.swf" quality="high" bgcolor="#ffd401" width="878" height="330" name="mountain" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
	</div>
</div>

<div class="rank_popup">
	<em><?= $lang['rank_pos'] ?></em>
</div>

<div class="speed_popup">
	<em><?= str_replace("XXX", $race->max_speed, $lang['speed_pos']) ?></em>
</div>

<div class="cancel_challenged_popup">
	<em><?= $lang['cancel_chal'] ?></em>
</div>

<div class="challenge_popup">
	<em>
		<?php
			if($challenge['type'] == 1) {
				echo $lang['challengim'];
			}
		    else if($challenge['type'] == 2) {
		        echo str_replace("XXX", convert_number(substr($challenge['profile']->challenge_final_time, -8, 5) . ", " . fa_strftime("%d %B", $challenge['profile']->challenge_final_time . "")), $lang['challengleft']);
		    }
		    else if($challenge['type'] == 3) {
				echo $lang['challengans'];
		    }
		?>
	</em>
</div>

<div class="question_popup">
	<em><B><span id='qnum2'><?= $questions ?></span></B> <?= $lang['not_answered'] ?></em>
</div>

<script>
	var sc = 0;
	var ondownx = false;
	var onupx = false;
	function ondown() {
	    if(!ondownx) {
	        return;
	    }
		sc += 1;
		if(sc > 100) {
			sc = 100;
		}
		$(".diary_body").scrollTo(sc + "%");
		window.setTimeout("ondown()", 50);
	}

	function onup() {
	    if(!onupx) {
	        return;
	    }
		sc -= 1;
		if(sc < 0) {
			sc = 0;
		}
		$(".diary_body").scrollTo(sc + "%");
		window.setTimeout("onup()", 50);
 	}

	var	sent_like = false;
	var	sent_d = false;

    $(function(){

		$(".rank").mouseover(function() {
			$(".rank_popup em").stop(true, true).animate({opacity: "show", top: "-60"}, "slow");
		}, function() {
			$(".rank_popup em").animate({opacity: "hide", top: "-70"}, "fast");
		});

		$(".rank").mouseout(function() {
			$(".rank_popup em").stop(true, true).animate({opacity: "hide", top: "-80"}, "slow");
		}, function() {
			$(".rank_popup em").animate({opacity: "hide", top: "-90"}, "fast");
		});

		$(".speed_panel").mouseover(function() {
			$(".speed_popup em").stop(true, true).animate({opacity: "show", top: "-60"}, "slow");
		}, function() {
			$(".speed_popup em").animate({opacity: "hide", top: "-70"}, "fast");
		});

		$(".speed_panel").mouseout(function() {
			$(".speed_popup em").stop(true, true).animate({opacity: "hide", top: "-80"}, "slow");
		}, function() {
			$(".speed_popup em").animate({opacity: "hide", top: "-90"}, "fast");
		});

		$(".challeng_button").mouseover(function() {
		    if(this.id == "cancel_challenged") {
		        return;
		    }
			$(".challenge_popup em").stop(true, true).animate({opacity: "show", top: "-60"}, "slow");
		}, function() {
			$(".challenge_popup em").animate({opacity: "hide", top: "-70"}, "fast");
		});

		$(".challeng_button").mouseout(function() {
		    if(this.id == "cancel_challenged") {
		        return;
		    }
			$(".challenge_popup em").stop(true, true).animate({opacity: "hide", top: "-80"}, "slow");
		}, function() {
			$(".challenge_popup em").animate({opacity: "hide", top: "-90"}, "fast");
		});

		$(".cancel_challenged").mouseover(function() {
			$(".cancel_challenged_popup em").stop(true, true).animate({opacity: "show", top: "-60"}, "slow");
		}, function() {
			$(".cancel_challenged_popup em").animate({opacity: "hide", top: "-70"}, "fast");
		});

		$(".cancel_challenged").mouseout(function() {
			$(".cancel_challenged_popup em").stop(true, true).animate({opacity: "hide", top: "-80"}, "slow");
		}, function() {
			$(".cancel_challenged_popup em").animate({opacity: "hide", top: "-90"}, "fast");
		});

		$(".nokia_panel").mouseover(function() {
			$(".question_popup em").stop(true, true).animate({opacity: "show", top: "-60"}, "slow");
		}, function() {
			$(".question_popup em").animate({opacity: "hide", top: "-70"}, "fast");
		});

		$(".nokia_panel").mouseout(function() {
			$(".question_popup em").stop(true, true).animate({opacity: "hide", top: "-80"}, "slow");
		}, function() {
			$(".question_popup em").animate({opacity: "hide", top: "-90"}, "fast");
		});

    	$('input[title!=""]').hint("blur_hint");
    	$('textarea[title!=""]').hint("blur_hint");

		if(window.mountain) { window.document["mountain"].SetVariable("speed_x", "<?= $driver_profile->current_speed ?>"); }
		if(document.mountain) { document.mountain.SetVariable('speed_x', '<?= $driver_profile->current_speed ?>'); }

		if(window.mountain) { window.document["mountain"].SetVariable('hour_x', '<?= date("H") ?>'); }
		if(document.mountain) { document.mountain.SetVariable('hour_x', '<?= date("H") ?>'); }

		if(window.mountain) { window.document["mountain"].SetVariable('minute_x', '<?= date("i") ?>'); }
		if(document.mountain) { document.mountain.SetVariable('minute_x', '<?= date("i") ?>'); }

		if(window.mountain) { window.document["mountain"].SetVariable('second_x', '<?= date("s") ?>'); }
		if(document.mountain) { document.mountain.SetVariable('second_x', '<?= date("s") ?>'); }

		var chals = false;
		$(".challengim").click( function() {
		    if(chals) {
		        return;
		    }
			Boxy.confirm("<?= $lang['challnegim1'] ?>",
				function() {
					chals = true;
					$.post("<?= base_url() ?>gateway/challenge/", { id: <?= $driver->id ?> },
						function(data){
							if(data != "false") {
							    var tmp_txt = "<?= $lang['challnegim_txt'] ?>";
							    Boxy.alert(tmp_txt.replace("XXX", data), null, {title : "<?= $lang['challnegimtitle'] ?>"});
							    $(".challeng_button").hide();
							    $(".ok_challenged").show();
							}
							else {
								Boxy.alert("<?= $lang['challnegim_ert'] ?>", null, {title : "<?= $lang['challnegimerti'] ?>"});
								$(".challeng_button").show();
								$(".ok_challenged").hide();
								chals = false;
							}
					});
				}
			, {title : "<?= $lang['challnegimtitl1'] ?>"});
		});

		$(".cancel_challenged").click( function() {
			$(".challeng_button").hide();
			$.post("<?= base_url() ?>gateway/cancel_challenge/", { id: <?= $driver->id ?> },
				function(data){
					if(data == "true") {
					    Boxy.alert("<?= $lang['challnegcan_txt'] ?>", null, {title : "<?= $lang['challnegcan_txt'] ?>"});
					    $(".ok_challenged").show();
					}
					else {
						Boxy.alert("<?= $lang['challnegcan_ert'] ?>", null, {title : "<?= $lang['challnegimerti'] ?>"});
						$(".challeng_button").show();
						$(".ok_challenged").hide();
					}
			});
		});

		var chal = false;
		$(".get_challenged").click( function() {
			$(".challeng_button").hide();
		    if(!qtp) {
	            $("#dialog_box_panel3").fadeIn('fast');
				$("#dialog_box_panel3").css("z-index", "100001");
				$(".dialog_bk_big_loader").fadeIn('fast');
				$.post("<?= base_url() ?>gateway/get_challenge_question/", { id: "<?= $driver->id ?>" },
					function(data){
						$(".dialog_bk_big_loader").fadeOut('fast');
						if(!data[0]) {
							$(".challeng_button").show();
							$(".ok_challenged").hide();
							$("#panel3_question_question").html("<?= $lang['no_question'] ?>");
							return;
						}
						chal = true;
						qidx = data[0].qid;
						aidx = data[0].id;;

						$("#panel3_question_text").html("<B>" + data[0].title + "</B><BR /><BR />" + data[0].message);
						var question = "";
						if(data[0].question1 != "") {
							question += "<input type='radio' name='ans' id='ans1' value='1' /><label id='ans' for='ans1'>" + data[0].question1 + "</label>";
						}
						if(data[0].question2 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans2' value='2' /><label id='ans' for='ans2'>" + data[0].question2+ "</label>";
						}
						if(data[0].question3 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans3' value='3' /><label id='ans' for='ans3'>" + data[0].question3+ "</label>";
						}
						if(data[0].question4 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans4' value='4' /><label id='ans' for='ans4'>" + data[0].question4+ "</label>";
						}
						$(".question_submit").fadeIn('fast');
						$("#panel3_question_question").html(question);
					    $(".ok_challenged").show();
				}, "json");
			}
			else {
				$("#dialog_box_panel3").fadeOut('fast');
			}
			qtp = !qtp;
		});

        <?php
        if($driver_profile->id != $driver->id) {
        ?>
	        $(".heart").click( function() {
	            if(sent_like) {
	                return;
	            }
	        	sent_like = true;
				$.post("<?= base_url() ?>gateway/ilikeit/", { did: "<?= $diary[0]['id'] ?>" },
					function(data){
					    if($(".heart").html() == "<?= $lang['likeit'] ?>") {
					    	$(".heart").html("<?= $lang['nlikeit'] ?>");
					    	$(".heart").attr("title", "<?= $lang['nlikeitd'] ?>")
						}
						else {
					    	$(".heart").html("<?= $lang['likeit'] ?>");
					    	$(".heart").attr("title", "<?= $lang['likeit'] ?>")
						}
						sent_like = false;
				});
			});
		<?php
		}
		?>

		var	new_d = false;
		var first_n = false;

		$("#new_diary").click( function() {
		    if(!new_d) {
		        if(first_n) {
					$("#dtitle").val("");
					$("#diary_textarea").val("");
				}
			    $(".diary_body").fadeOut('fast');
			    $(".diary_title").fadeOut('fast');
			    $(".diary_body_sim").fadeOut('fast');
			    $("#input_title").fadeIn('fast');
			    $("#diary_input").fadeIn('fast');
			    $(".diary_body2").fadeIn('fast');
			    $("#new_diary").addClass("submit");
			    $("#new_diary").html("<?= $lang['submitd'] ?>");
			    $("#new_diary").removeClass("new");
			}
			else {
	            if(sent_d) {
	                return;
	            }
	            first_n = true;
	            sent_d = true;
				$.post("<?= base_url() ?>gateway/submit_diary/", { title:  $("#dtitle").val(), body: $("#diary_textarea").val() },
					function(data){
						if(data != "false") {
						    $(".diary_body").html($("#diary_textarea").val());
						    $(".diary_title").html($("#dtitle").val());
						    $("#did").val(data);
							$("#edit_diary").fadeIn('fast');
							$("#votes_num").html("0");
						}
						sent_d = false;
				});

			    $(".diary_body").fadeIn('fast');
			    $(".diary_title").fadeIn('fast');
			    $(".diary_body_sim").fadeIn('fast');
			    $("#input_title").fadeOut('fast');
			    $("#diary_input").fadeOut('fast');
			    $(".diary_body2").fadeOut('fast');
			    $("#new_diary").addClass("new");
			    $("#new_diary").html("<?= $lang['new_woym'] ?>");
				$("#new_diary").removeClass("submit");
			}
		    new_d = !new_d;
		});

		var	edit_d = false;
		$("#delete_diary").click( function() {
			Boxy.confirm("<?= $lang['delete_last'] ?>", function() {
			    window.location = "<?= base_url() ?>gateway/delete_last_diary/";
			}, {title:"<?= $lang['delete_last_title'] ?>"});
		});

		$("#edit_diary").click( function() {

		    if(!edit_d) {
				$("#dtitle").val($(".diary_title").html());
				$("#diary_textarea").val($(".diary_body").html());

			    $(".diary_body").fadeOut('fast');
			    $(".diary_title").fadeOut('fast');
			    $(".diary_body_sim").fadeOut('fast');
			    $("#input_title").fadeIn('fast');
			    $("#diary_input").fadeIn('fast');
			    $(".diary_body2").fadeIn('fast');
			    $("#edit_diary").addClass("submit");
			    $("#edit_diary").html("<?= $lang['submitd'] ?>");
			    $("#edit_diary").removeClass("edit");
			}
			else {
	            if(sent_d) {
	                return;
	            }
	            sent_d = true;
				$.post("<?= base_url() ?>gateway/edit_diary/", { id: $("#did").val(), title:  $("#dtitle").val(), body: $("#diary_textarea").val() },
					function(data){
						if(data == "ok") {
						    $(".diary_body").html($("#diary_textarea").val());
						    $(".diary_title").html($("#dtitle").val());
						    $("#votes_num").html("0");
						}
						sent_d = false;
				});

			    $(".diary_body").fadeIn('fast');
			    $(".diary_title").fadeIn('fast');
			    $(".diary_body_sim").fadeIn('fast');
			    $("#input_title").fadeOut('fast');
			    $("#diary_input").fadeOut('fast');
			    $(".diary_body2").fadeOut('fast');
			    $("#edit_diary").addClass("edit");
			    $("#edit_diary").html("<?= $lang['edit_woym'] ?>");
				$("#edit_diary").removeClass("submit");
			}
		    edit_d = !edit_d;
		});

        $(".sliding_panel_close").click( function() {
            $(".diary_title").fadeOut('fast');
        	$(".sliding_panel_open").animate({width: "0px"}, 200);
        	$(".diary_body").css('display', 'none');
        	$(".sliding_panel").fadeIn('fast');
		});
        $(".sliding_panel").click( function() {
        	$(".diary_title").fadeIn('fast');
        	$(".sliding_panel_open").animate({width: "216px"}, 200);
        	$(".diary_body").animate({width: "175px"}, 200);
        	$(".diary_body").fadeIn('fast');
        	$(".diary_body").scrollTo("0%");
        	$(".sliding_panel").fadeOut('fast');

		    $(".diary_body_sim").fadeIn('fast');
		    $("#input_title").fadeOut('fast');
		    $("#diary_input").fadeOut('fast');
		    $(".diary_body2").fadeOut('fast');
		    $("#new_diary").addClass("new");
		    $("#new_diary").html("<?= $lang['new_woym'] ?>");
			$("#new_diary").removeClass("submit");
		    $("#edit_diary").addClass("edit");
		    $("#edit_diary").html("<?= $lang['edit_woym'] ?>");
			$("#edit_diary").removeClass("submit");
		});

		$(".up").mouseover( function() {
			onupx = true;
			window.setTimeout("onup()", 50);
		});

		$(".down").mouseover( function() {
			ondownx = true;
			window.setTimeout("ondown()", 50);
		});

		$(".up").mouseout( function() {
			onupx = false;
		});

		$(".down").mouseout( function() {
			ondownx = false;
		});

        $(".race_drivers").click( function() {
            window.location = "<?= base_url() ?>drivers_list/race/0/<?= $race->id ?>";
		});

    	var mtp = false;

		$(".hint_close").click( function() {
		    $(".first_hint").fadeOut('fast');
		});

		$(".photo_border").click( function() {
		    window.location = "<?= base_url() ?>profile/driver/<?= $driver_profile->id ?>";
		});

		var panelic = true;
		$("#panelic_close").click( function() {
		    if(panelic) {
		    	$("#panelic").fadeOut('fast');
			}
			else {
		    	$("#panelic").fadeIn('fast');
			}
			panelic = !panelic;
		});

		$("#iconic").click( function() {
		    if(panelic) {
		    	$("#panelic").fadeOut('fast');
			}
			else {
		    	$("#panelic").fadeIn('fast');
			}
			panelic = !panelic;
		});

		var rans = 0;
		$("#submit_answer").click(function() {
		    var ct = "0";
		    if(chal) {
		        ct = "1";
		    }
			$(".question_submit").fadeOut('fast');
			$.post("<?= base_url() ?>gateway/submit_question_answer/", { qid: qidx, aid: aidx, answer: $("input[@name='ans']:checked").val(), qt: ct},
				function(data){
				    if(data != "false") {
				    	if($("input[@name='ans']:checked").val() == data[0].answer) {
				    		rans++;
				    	    var txt = "";
							switch (data[0].advantage) {
							    case "0":
							    	txt = "<?= $lang['right_answer0'] ?>";
							    	//CSS up
							    	var spx = $(".speed_panel").html();
							    	spx++;
									spx += 9;
									if(spx > <?= $race->max_speed ?>) {
										spx = <?= $race->max_speed ?>;
									}
							    	if(spx < 100) {
							    		spx = "0" + spx;
							    	}
							    	$(".speed_panel").html(spx);
							        break;
							    case "5":
							    	txt = "<?= $lang['right_answer5'] ?>";
							    	//CSS up
							    	var spx = $(".speed_panel").html();
							    	spx++;
									spx += 4;
									if(spx > <?= $race->max_speed ?>) {
										spx = <?= $race->max_speed ?>;
									}
						    		if(spx < 100 && spx > 9) {
								    	spx = "0" + spx;
								    }
								    else if(spx < 10) {
								    	spx = "00" + spx;
								    }
							    	$(".speed_panel").html(spx);
							        break;
							    case "1":
							    	txt = "<?= $lang['right_answer1'] ?>";
							    	var spx = $(".speed_panel").html();
							    	spx++;
									spx += 14;
									if(spx > <?= $race->max_speed ?>) {
										spx = <?= $race->max_speed ?>;
									}
							    	if(spx < 100) {
							    		spx = "0" + spx;
							    	}
							    	$(".speed_panel").html(spx);
							        break;
							    case "2":
							    	txt = "<?= $lang['right_answer2'] ?>";
							    	var spx = $(".speed_panel").html();
							    	spx++;
									spx += 24;
									if(spx > <?= $race->max_speed ?>) {
										spx = <?= $race->max_speed ?>;
									}
							    	if(spx < 100) {
							    		spx = "0" + spx;
							    	}
							    	$(".speed_panel").html(spx);
							        break;
							}
				    		Boxy.alert(txt, null, {title:"<?= $lang['right_title'] ?>"});
				    	}
				    	else {
				    		Boxy.alert("<?= $lang['wrong_answer'] ?>", null, {title:"<?= $lang['wrong_title'] ?>"});
				    		if(data[0].advantage == "5") {
						    	var spx = $(".speed_panel").html();
						    	spx--;
								spx -= 4;
								if(spx < 1) {
									spx = 1;
								}
					    		if(spx < 100 && spx > 9) {
							    	spx = "0" + spx;
							    }
							    else if(spx < 10) {
							    	spx = "00" + spx;
							    }
				    			$(".speed_panel").html(spx);
				    		}
				    	}
					}
				    if(!chal) {
					    var qnums = $("#qnum").html();
					    qnums--;
					    if(qnums <= 0) {
					    	qnums = 0;
					    	if(rans - <?= $questions ?> == 0) {
					    		$("#panelic_msg").html("<?= $lang['answerall3'] ?>");
							}
					    	else if(rans - <?= $questions ?> == -<?= $questions ?>) {
					    		$("#panelic_msg").html("<?= $lang['answerall1'] ?>");
							}
							else {
					    		$("#panelic_msg").html("<?= $lang['answerall2'] ?>");
							}
					    }
					    else {
					    	$("#panelic_msg").html("<?= $lang['answerall'] ?>");
					    }
					    $("#qnum").html(qnums);
					    $("#qnum2").html(qnums);
					}
					chal = false;
					$(".dialog_text2").html("");
					$(".nokia_panel").trigger("click");
			}, "json");
		});

		var qtp = false;
		var qidx = 0;
		var aidx = 0;
		<?php
			if($driver_profile->id == $driver->id) {
		?>
		$(".nokia_panel").click( function() {
		    if(!qtp) {
	            $("#dialog_box_panel3").fadeIn('fast');
				$("#dialog_box_panel3").css("z-index", "100001");
				$(".dialog_bk_big_loader").fadeIn('fast');
				$.post("<?= base_url() ?>gateway/get_next_question/", { driver: "<?= $driver_profile->id ?>" },
					function(data){
						$(".dialog_bk_big_loader").fadeOut('fast');
						if(!data[0]) {
							$("#panel3_question_question").html("<?= $lang['no_question'] ?>");
							return;
						}
						qidx = data[0].qid;
						aidx = data[0].id;;

						$("#panel3_question_text").html("<B>" + data[0].title + "</B><BR /><BR />" + data[0].message);
						var question = "";
						if(data[0].question1 != "") {
							question += "<input type='radio' name='ans' id='ans1' value='1' /><label id='ans' for='ans1'>" + data[0].question1 + "</label>";
						}
						if(data[0].question2 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans2' value='2' /><label id='ans' for='ans2'>" + data[0].question2+ "</label>";
						}
						if(data[0].question3 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans3' value='3' /><label id='ans' for='ans3'>" + data[0].question3+ "</label>";
						}
						if(data[0].question4 != "") {
							question += "<BR /><input type='radio' name='ans' id='ans4' value='4' /><label id='ans' for='ans4'>" + data[0].question4+ "</label>";
						}
						$(".question_submit").fadeIn('fast');
						$("#panel3_question_question").html(question);
				}, "json");
			}
			else {
				$("#dialog_box_panel3").fadeOut('fast');
			}
			qtp = !qtp;
        });
        <?php
        }
        ?>
        var nop = false;
        var retnp = true;

		$(".dialog_close").click( function() {
		    $("#dialog_box_" + this.id).fadeOut('fast');
		    qtp = !qtp;
		    nop = !nop;
		    mtp = !mtp;
		});
	});
</script>
<script type="text/javascript" src="<?= base_url() ?>system/application/views/scripts/flashie.js"></script>