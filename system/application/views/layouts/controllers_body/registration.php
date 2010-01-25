<BR /><BR /><BR />
<div class="general_box">
	<BR />
	<form action="<?= base_url() ?>registration/register/" method="post" onsubmit="return frm_submit()" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" border="0">
		    <tr>
		        <td width="100">
		        	* <?= $lang['name'] ?>:
		        </td>
		        <td>
		        	<input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['first_name'] : NULL; ?>" name="first_name" id="first_name" />
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	* <?= $lang['last_name'] ?>:
		        </td>
		        <td>
		        	<input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['last_name'] : NULL; ?>" name="last_name" id="last_name" />
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<?= $lang['sex'] ?>:
		        </td>
		        <td>
		        	<label for="sex1" id="sex">
		            	<?= $lang['male'] ?>
					</label>
					<input type="radio" value="0" name="sex" id="sex1" <?= (isset($_SESSION['rgkeep']) && $_SESSION['rgkeep']['sex'] == "1") ?  NULL : 'checked="checked"'; ?> />
					<label for="sex2" id="sex">
						<?= $lang['female'] ?>
					</label>
					<input type="radio" value="1" name="sex" id="sex2"  <?= (!isset($_SESSION['rgkeep']) || $_SESSION['rgkeep']['sex'] == "0") ?  NULL : 'checked="checked"'; ?> />
		        </td>
		    </tr>
		    <tr>
		        <td>
					<?= $lang['birthdate'] ?>:
		        </td>
		        <td>
					<input type="text" title="<?= $lang['day'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['day'] : NULL; ?>" name="day" id="day" />
					<input type="text" title="<?= $lang['month'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['month'] : NULL; ?>" name="month" id="month" />
					<input type="text" title="<?= $lang['year'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['year'] : NULL; ?>" name="year" id="year" />
					<?= $lang['pre_year'] ?>
		        </td>
		    </tr>
		    <tr>
		        <td>
					* <?= $lang['email'] ?>:
		        </td>
		        <td>
					<input type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['email'] : ''; ?>" maxlength="50" style="direction:ltr;" name="email" id="email" />
		        </td>
		    </tr>
		    <tr>
		        <td>
					* <?= $lang['password'] ?>:
		        </td>
		        <td>
					<input type="password" value="" maxlength="50" style="direction:ltr;" name="password" id="password" />
		        </td>
		    </tr>
		    <tr>
		        <td>
					&nbsp;
		        </td>
		        <td>
					<input type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['car_tt'] : ''; ?>" maxlength="50" style="direction:rtl; display:none;" name="car_tt" id="car_tt" title="<?= $lang['car'] ?>" />
		        </td>
		    </tr>
		    <tr>
		        <td>
					<?= $lang['province'] ?>
		        </td>
		        <td>
		            <?php
		                $city = get_province();
		            ?>
		            <select name="city" id="city">
						<?php
						    foreach($city as $x => $k) {
						    ?>
						    	<option value="<?= $k ?>" <?= isset($_SESSION['rgkeep']) && $_SESSION['rgkeep']['city'] == $k ?  "selected='selected'" : ''; ?>>
						    		<?= $k ?>
						    	</option>
						    <?php
						    }
						?>
		            </select>
		        </td>
		    </tr>
		    <tr>
		        <td>
					<?= $lang['photo'] ?>:
		        </td>
		        <td>
		        	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
					<input type="file" value="" name="photo" id="photo" />
		        </td>
		    </tr>
		    <tr style="height:75px;">
		        <td>
					&nbsp;
		        </td>
		        <td>
		            <?php
		            	$output = "";
		            	$title = "";
		            	load_captcha($title, $output, $lang, 5, "&nbsp;&nbsp;&nbsp;");
		            	echo $title . "<BR /><BR />";
		            	echo $output;
		            ?>
		        </td>
		    </tr>
		    <tr style="height:23px;">
		        <td>
					&nbsp;
		        </td>
		        <td>
					* <?= $lang['must_be_filled'] ?>
		        </td>
		    </tr>
			<tr>
		        <td>
					&nbsp;
		        </td>
		        <td>
					<input type="submit" value="<?= $lang['submit'] ?>" />
		        </td>
		    </tr>
		</table>
		<input type="hidden" value="ok" name="ok" />
		<input type="hidden" value="" name="captcha_val" id="captcha_val" />
	</form>
</div>
<BR />
<script type="text/javascript" charset="utf-8">
	var selected_captcha = -1;
	var reason = "<?= $reason ?>";
	$(function(){
		$('input[title!=""]').hint("blur_hint");
		
		$(".captcha_img").click( function() {
		    $(".captcha_img").each( function() {
		    	$(this).css('border', '1px solid #f6f6f6');
			});
			$(this).css('border', '1px solid #9d9d9d');
			selected_captcha = $(this).attr('title');
			$("#captcha_val").val(selected_captcha);
		});
		
		$("#car_t").change( function() {
      		if($("#car_t").val() == "سایر") {
      		    $("#car_tt").fadeIn('fast');
      		}
      		else {
      			$("#car_tt").fadeOut('fast');
      			$("#car_tt").val("");
      		}
		});
		
		<?php
		if($reason != "") {
		?>
			if(reason != "") {
			    switch(reason) {
			        case "email":
			        	Boxy.alert("<?= $lang['email_failure1'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
			            break;
			        case "fill":
			        	Boxy.alert("<?= $lang['starred_filling'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
			            break;
					case "email_repeated":
						Boxy.alert("<?= $lang['email_repeated'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
					    break;
					case "date":
						Boxy.alert("<?= $lang['date_over'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
					    break;
					case "reg_error":
						Boxy.alert("<?= $lang['reg_error'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
					    break;
					case "captcha":
						Boxy.alert("<?= $lang['captcha_error'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
					    break;
			    }
			}
		<?php
  		}
		?>
	});
	
	function frm_submit() {
	    if(selected_captcha == -1) {
	    	Boxy.alert("<?= $lang['choose_captcha'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
	    	return false;
	    }
	    if($("#first_name").val() == "" || $("#last_name").val() == "" || $("#email").val() == "" || $("#password").val() == "") {
	    	Boxy.alert("<?= $lang['starred_filling'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
	    	return false;
	    }
		return true;
	}
</script>
