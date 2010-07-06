<style>
    #centerContainerSecondLayer
    {
        background: #2b3b09 url(<?= $base_img ?>profile/edit_background.gif) no-repeat top center;
        height: 388px;
        width: 464px;
        display: block;
        margin-top: 9px;
    }
    #registerForm
    {
        right: 75px;
        top: 30px;
    }
    .closeButton
    {
        position: absolute;
        top:16px;
        right:8px;
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
<span class="closeButton"><img src="<?= $base_img ?>popup/boxy/close.png" /></span>
    <div id="registerForm">
                <form action="<?= base_url() ?>profile/edit/" id="register-form" class="registerForm" method="post">
                                <table>
                                    <tr>
                                        <td class="registerFormLable">
                                                 <?= $lang['name'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" name="first_name" id="first_name" class="validate[required,funcCall[firstnameLength]] registerElement" value="<?= $user_profile->first_name ?>"/>

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
                                                <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" name="last_name" id="last_name" class="validate[required,funcCall[lastnameLength]] registerElement" value="<?= $user_profile->last_name ?>"/>
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
                                                <input type="radio" value="0" name="sex" id="sex1" <?= ($user_profile->sex == "1") ?  NULL : 'checked="checked"'; ?> />

                                                <label for="sex2" id="sex">
                                                        <?= $lang['female'] ?>
                                                </label>
                                                <input type="radio" value="1" name="sex" id="sex2"  <?= ($user_profile->sex == "0") ?  NULL : 'checked="checked"'; ?> />
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="registerFormLable">
                                                        <?= $lang['birthdate'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                        <input type="text" title="<?= $lang['day'] ?>" maxlength="2" class="validate[funcCall[validateDay]] registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 0, 2) ?>" name="day" id="day" />
                                                        <input type="text" title="<?= $lang['month'] ?>" maxlength="2" class="validate[funcCall[validateMonth]] registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 3, 2) ?>" name="month" id="month" />
                                                        <input type="text" title="<?= $lang['year'] ?>" maxlength="2" class="validate[funcCall[validateYear]] registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 8, 2) ?>" name="year" id="year" />
                                                        <?= $lang['pre_year'] ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="registerFormLable">
                                                        <?= $lang['changeAvatars'] ?>:
                                        </td>
                                        <td class="registerFormInput" colspan="2">
                                            <?= anchor("profile/edit/avatar"," ",array('onclick'=>"avatar();return false;",'class'=>'avatarLinkInChangeProfile')); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="registerFormLable">
                                                        <?= $lang['new_password'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                        <input type="password" id="password" value="" maxlength="50" style="direction:ltr;" name="password"  class="validate[funcCall[passwordLength]] registerElement"/>
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
                                                                        <option value="<?= $k ?>" <?= $user_profile->city == $k ?  "selected='selected'" : ''; ?>>
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
                                        <td colspan="3">
                                            <input type="hidden" name="ok" value="ok" />
                                            <input type="submit" value="" class="submit"/>
                                        </td>
                                    </tr>
                                </table>


                        </form>
                </div>

<script type="text/javascript" charset="utf-8">
  function validateDay()
  {
  	if($("#day").val() > 31 || $("#day").val() < 1 )
		return true;
    else
		return false;
  }
  function validateMonth()
  {
  	if($("#month").val() > 12 || $("#month").val() < 1 )
		return true;
    else
		return false;
  }
  function validateYear()
  {
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
