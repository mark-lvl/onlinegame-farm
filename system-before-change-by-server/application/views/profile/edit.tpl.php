<style>
  #centerContainer {
    background: #2b3b09 url(<?= $base_img ?>profile/edit_background.gif) no-repeat top center;
    height: 395px;
    width: 464px;
    display: block;
    margin-top: 2px;
}
</style>
<style>
    
    #registerForm
    {
        right: 75px;
        top: 30px;
    }
</style>
<div id="centerContainer">
    <div id="registerForm">
                <form action="<?= base_url() ?>profile/edit/" id="register-form" class="registerForm" method="post">
                                <table>
                                    <tr>
                                        <td class="registerFormLable">
                                                 <?= $lang['name'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" name="first_name" id="first_name" class="validate[required] registerElement" value="<?= $user_profile->first_name ?>"/>

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
                                                <input onkeypress="return FarsiType(this,event)" maxlength="50" type="text" name="last_name" id="last_name" class="validate[required] registerElement" value="<?= $user_profile->last_name ?>"/>
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
                                                        <input type="text" title="<?= $lang['day'] ?>" maxlength="2" class="registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 0, 2) ?>" name="day" id="day" />
                                                        <input type="text" title="<?= $lang['month'] ?>" maxlength="2" class="registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 3, 2) ?>" name="month" id="month" />
                                                        <input type="text" title="<?= $lang['year'] ?>" maxlength="2" class="registerDateElement" value="<?= substr($user_profile->jd_birthdate2, 8, 2) ?>" name="year" id="year" />
                                                        <?= $lang['pre_year'] ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="registerFormLable">
                                                        <?= $lang['email'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                        <input type="text" value="<?= $user_profile->email ?>" maxlength="50" style="direction:ltr;" name="email" id="email" class="validate[custom[email]] registerElement"/>
                                        </td>
                                        <td>
                                                <img src="<?= $base_img?>registration/star.png" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="registerFormLable">
                                                        <?= $lang['new_password'] ?>:
                                        </td>
                                        <td class="registerFormInput">
                                                        <input type="password" id="password" value="" maxlength="50" style="direction:ltr;" name="password"  class=" registerElement"/>
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
                                            <select name="city" id="city" class="registerElement">
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
</div>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
   $("#register-form").validationEngine()
  })
</script>
