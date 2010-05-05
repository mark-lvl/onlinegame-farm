<style>
#content
{
    background: url(<?= $base_img?>registration/content.png) repeat-x center;
}
</style>
<div id="registration">
    <div id="registerRules">
            <ul>
                <li><img src="<?= $base_img ?>registration/bullet.png" /><?= $lang['must_be_filled'] ?></li>
                <li><img src="<?= $base_img ?>registration/bullet.png" /><?= $lang['nameRule'] ?></li>
                <li><img src="<?= $base_img ?>registration/bullet.png" /><?= $lang['passwordRule'] ?></li>
                <li><img src="<?= $base_img ?>registration/bullet.png" /><?= $lang['emailRule'] ?></li>
            </ul>
    </div>
    <div id="registerForm">
        <form action="<?= base_url() ?>registration/register/" id="register-form" class="registerForm" method="post"  enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="registerFormLable">
                                         <?= $lang['name'] ?>:
                                </td>
                                <td class="registerFormInput">
                                        <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['first_name'] : NULL; ?>" name="first_name" id="first_name" class="validate[required,funcCall[firstnameLength]] registerElement"/>
                                        
                                </td>
                                <td>
                                        <img src="<?= $base_img?>registration/star.png" />
                                </td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                         <?= $lang['last_name'] ?>:
                                </td>
                                <td class="registerFormInput">
                                        <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['last_name'] : NULL; ?>" name="last_name" id="last_name" class="validate[required,funcCall[lastnameLength]] registerElement"/>
                                </td>
                                <td>
                                        <img src="<?= $base_img?>registration/star.png" />
                                </td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                        <?= $lang['sex'] ?>:
                                </td>
                                <td class="registerFormInput">
                                        <label for="sex1" id="sex">
                                                <?= $lang['male'] ?>
                                        </label>
                                        <input type="radio" value="0" name="sex" id="sex1" <?= (isset($_SESSION['rgkeep']) && $_SESSION['rgkeep']['sex'] == "1") ?  NULL : 'checked="checked"'; ?> />

                                        <label for="sex2" id="sex">
                                                <?= $lang['female'] ?>
                                        </label>
                                        <input type="radio" value="1" name="sex" id="sex2"  <?= (!isset($_SESSION['rgkeep']) || $_SESSION['rgkeep']['sex'] == "0") ?  NULL : 'checked="checked"'; ?> />
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                                <?= $lang['birthdate'] ?>:
                                </td>
                                <td class="registerFormInput">
                                                <input type="text" title="<?= $lang['day'] ?>" maxlength="2" class="validate[funcCall[validateDay]] registerDateElement" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['day'] : NULL; ?>" name="day" id="day" />
                                                <input type="text" title="<?= $lang['month'] ?>" maxlength="2" class="validate[funcCall[validateMonth]] registerDateElement" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['month'] : NULL; ?>" name="month" id="month" />
                                                <input type="text" title="<?= $lang['year'] ?>" maxlength="2" class="validate[funcCall[validateYear]] registerDateElement" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['year'] : NULL; ?>" name="year" id="year" />
                                                <?= $lang['pre_year'] ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                                <?= $lang['email'] ?>:
                                </td>
                                <td class="registerFormInput">
                                                <input type="text" value="<?= isset($_SESSION['rgkeep']) ?  $_SESSION['rgkeep']['email'] : ''; ?>" maxlength="50" style="direction:ltr;" name="email" id="email" class="validate[custom[email]] registerElement"/>
                                </td>
                                <td>
                                        <img src="<?= $base_img?>registration/star.png" />
                                </td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                                <?= $lang['password'] ?>:
                                </td>
                                <td class="registerFormInput">
                                                <input type="password" id="password" value="" maxlength="50" style="direction:ltr;" name="password"  class="validate[length[6,12]] registerElement"/>
                                </td>
                                <td>
                                        <img src="<?= $base_img?>registration/star.png" />
                                </td>
                            </tr>
                            <tr>
                                <td class="registerFormLable">
                                                 <?= $lang['repassword'] ?>:
                                </td>
                                <td class="registerFormInput">
                                                <input type="password" value="" maxlength="50" style="direction:ltr;" name="repassword"  id="password2" class="validate[confirm[password]] registerElement"/>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="registerFormLable">
                                                <?= $lang['province'] ?>
                                </td>
                                <td class="registerFormInput">
                                    <?php
                                        $city = get_province();
                                    ?>
                                    <select name="city" id="city" class="validate[funcCall[city]] registerElement">
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
                                <td></td>
                            </tr>

                            <tr>
                                <td class="captcha" colspan="3">
                                    <?php
                                        $output = "";
                                        $title = "";
                                        load_captcha($title, $output, $lang, 5, "&nbsp;&nbsp;&nbsp;");
                                        echo $title . "<BR /><BR />";
                                        echo $output;
                                    ?>
                                    <input type="hidden" value="" name="captcha_val" id="captcha_val" />
                                    <input type="hidden" value="ok" name="ok" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <input type="submit" value="" class="submit"/>
                                </td>
                            </tr>
                        </table>
                        

                </form>
        </div>
</div>
<script type="text/javascript" charset="utf-8">
  function validateDay()
  {
  	if($("#day").val() > 0)
  	if($("#day").val() > 31 || $("#day").val() < 1 )
		return true;
    else
		return false;
  }
  function validateMonth()
  {
  	if($("#month").val() > 0)
  	if($("#month").val() > 12 || $("#month").val() < 1 )
		return true;
    else
		return false;
  }
  function validateYear()
  {
  	if($("#year").val() > 0)
  	if($("#year").val() > 89 || $("#year").val() < 1 )
		return true;
    else
		return false;
  }
  function passwordLength()
  {
  	  if($("#password").val().length > 0)
  	  	  if(($("#password").val().length < 6) || ($("#password").val().length > 12))
  	  	  	return true;
  	  	  else
  	  	  	return false;
  }
  function firstnameLength()
  {
  	  if($("#first_name").val().length > 10)
  	  	  	return true;
  	  	  else
  	  	  	return false;
  }
  function lastnameLength()
  {
  	  if($("#last_name").val().length > 18)
  	  	  	return true;
  	  	  else
  	  	  	return false;
  }
  function city()
  {
  	  if($("#city").val() == "------")
  	  	  	return true;
  	  	  else
  	  	  	return false;
  }
  $(document).ready(function() {
   $("#register-form").validationEngine()
  })
</script>
<script type="text/javascript" charset="utf-8">
	var selected_captcha = -1;
	var reason = "<?= $reason ?>";
	$(function(){
		$('input[title!=""]').hint("blur_hint");

		$(".captcha_img").click( function() {
		    $(".captcha_img").each( function() {
		    	$(this).css('border', '2px solid #699500');
			});
			$(this).css('border', '2px solid #32490D');
			selected_captcha = $(this).attr('title');
			$("#captcha_val").val(selected_captcha);
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
		return true;
	}
</script>