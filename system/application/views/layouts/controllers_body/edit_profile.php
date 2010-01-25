<?php
	$this->load->module('profile_information');
	$this->profile_information->method(array("friends" => $friends, "rank" => $drivers_rank, "driver_profile" => $driver_profile, "driver" => $driver, "lang" => $lang));
?>
<div class="middle_box">
	<div class="edition_list">
		<form action="<?= base_url() ?>edit_profile/register/" method="post" onsubmit="return frm_submit()" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" class="tbl_ins">
			    <tr>
			        <td width="100">
			        	* <?= $lang['name'] ?>:
			        </td>
			        <td>
			        	<input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= $driver->first_name ?>" name="first_name" id="first_name" />
			        </td>
			    </tr>
			    <tr>
			        <td>
			        	* <?= $lang['last_name'] ?>:
			        </td>
			        <td>
			        	<input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= $driver->last_name ?>" name="last_name" id="last_name" />
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
						<input type="radio" value="0" name="sex" id="sex1" <?= ($driver->sex == "1") ?  NULL : 'checked="checked"'; ?> />
						<label for="sex2" id="sex">
							<?= $lang['female'] ?>
						</label>
						<input type="radio" value="1" name="sex" id="sex2"  <?= ($driver->sex == "0") ?  NULL : 'checked="checked"'; ?> />
			        </td>
			    </tr>
			    <tr>
			        <td>
						<?= $lang['birthdate'] ?>:
			        </td>
			        <td>
						<input type="text" title="<?= $lang['day'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= substr($driver->jd_birthdate2, 0, 2) ?>" name="day" id="day" />
						<input type="text" title="<?= $lang['month'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= substr($driver->jd_birthdate2, 3, 2) ?>" name="month" id="month" />
						<input type="text" title="<?= $lang['year'] ?>" maxlength="2" style="width:25px; text-align:center;" value="<?= substr($driver->jd_birthdate2, 8, 2) ?>" name="year" id="year" />
						<?= $lang['pre_year'] ?>
			        </td>
			    </tr>
			    <tr>
			        <td>
						* <?= $lang['email'] ?>:
			        </td>
			        <td>
						<input type="text" value="<?= $driver->email ?>" maxlength="50" style="direction:ltr;" name="email" id="email" />
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
			    <tr>
			        <td>
						<?= $lang['have_car'] ?>
			        </td>
			        <td>
			            <?php
			                $cars = car_array();
			            ?>
			            <select name="car_t" id="car_t" style="width:100px;">
			                <option value="">
							خودرو ندارم
							</option>
							<?php
							    $crx = FALSE;
							    foreach($cars as $x => $k) {
							    	$tmz = "";
									if($driver->car_t == $k) {
									    $crx = TRUE;
									    $tmz = "selected='selected'";
									}
									else if($driver->car_t != "" && $k == "سایر" && !$crx) {
										$tmz = "selected='selected'";
									}
							    ?>
							    	<option value="<?= $k ?>" <?= $tmz ?>>
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
			            <span id="car_tttitle" style="<?= ($crx || $tmz == "") ?  "display:none;" : ""; ?>">
							<?= $lang['car'] ?>:
						</span>
			        </td>
			        <td>
						<input type="text" value="<?= $driver->car_t ?>" maxlength="50" style="direction:rtl; <?= ($crx || $tmz == "") ?  "display:none;" : ""; ?>" name="car_tt" id="car_tt" />
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
							    	$tmz = "";
									if($driver->city == $k) {
									    $tmz = "selected='selected'";
									}
							    ?>
							    	<option value="<?= $k ?>" <?= $tmz ?>>
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
						<?= $lang['password'] ?>:
			        </td>
			        <td>
						<input type="password" value="" maxlength="50" style="direction:ltr;" name="password" id="password" />
			        </td>
			    </tr>
			    <tr>
			        <td>
						<?= $lang['new_password'] ?>:
			        </td>
			        <td>
						<input type="password" value="" maxlength="50" style="direction:ltr;" name="new_password" id="new_password" />
			        </td>
			    </tr>
			    <tr>
			        <td>
						<?= $lang['repassword'] ?>:
			        </td>
			        <td>
						<input type="password" value="" maxlength="50" style="direction:ltr;" name="repassword" id="repassword" />
			        </td>
			    </tr>
			    <tr style="height:35px;">
			        <td>
						&nbsp;
			        </td>
			        <td style="line-height:17px;">
						* <?= $lang['no_pass_change'] ?>
			        </td>
			    </tr>
				<tr>
			        <td>
						&nbsp;
			        </td>
			        <td>
			            <BR />
						<input type="submit" value="<?= $lang['submit'] ?>" />
			        </td>
			    </tr>
			</table>
			<input type="hidden" value="ok" name="ok" />
		</form>
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
		$("#car_t").change( function() {
      		if($("#car_t").val() == "سایر") {
      			$("#car_tttitle").fadeIn('fast');
      		    $("#car_tt").fadeIn('fast');
      		}
      		else {
      			$("#car_tt").fadeOut('fast');
      			$("#car_tttitle").fadeOut('fast');
      			$("#car_tt").val("");
      		}
		});
		
		$('input[title!=""]').hint("blur_hint");
		var reason = "<?= $reason ?>";
		
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
					case "password":
						Boxy.alert("<?= $lang['password_error'] ?>", null, {title:"<?= $lang['filling_error'] ?>"});
					    break;
			    }
			}
		<?php
  		}
		?>
	});
</script>