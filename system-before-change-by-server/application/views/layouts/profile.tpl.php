<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<?php echo $css; ?>
<?php echo $js; ?>

</head>

<body>
    <div id="profileWrapper">
         <div id="header">
                <?php
                                $this->load->module('login');
                                $this->login->method(array("user" => $user, "lang" => $lang));
                ?>
	 </div>
         <div id="leftcolumn">

             <div class="users_photo">
                    <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>">
                        <?php
                            if($user_profile->photo != "") {
                        ?>
                        <img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=110&nh=110&source=../views/layouts/images/users/<?= $user_profile->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
                        <?php
                            }else{
                        ?>
                        <img src="<?= $base_img ?>default.png" border="1px solid #EEEEEE" style="padding: 3px;" />
                        <?php
                            }
                        ?>
                    </a>
              </div>

              <div class="users_information">
                <span><?= $lang['name'] ?>:</span>
                <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" style="color:#444;">
                    <?= $user_profile->first_name . " " . $user_profile->last_name ?>
                </a>
                <BR />
                <BR />
                <span><?= $lang['register_date'] ?>:</span>
                <?= convert_number(fa_strftime("%d %B %Y", $user_profile->registration_date . "")) ?>
        
                <table cellpadding="0" cellspacing="0" border="0">
                    <?php
                        if(!is_object($user) || $user_profile->id != $user->id) {
                    ?>
                    <tr>
                    <?php
                        if(!$user_profile->is_related && !$user_profile->is_blocked) {
                    ?>
                        <td>
                            <img src="<?= $base_img ?>profile/add.png" border="0" />
                        </td>
                        <td class="lnk_bg">
                            <a href="<?= base_url() ?>gateway/add_friend/<?= ltrim($user_profile->id, '0') ?>">
                                <?= $lang['add_to_friend'] ?>
                            </a>
                        </td>
                        <?php
                            }elseif($user_profile->is_related) {
                        ?>
                        <td>
                            <img src="<?= $base_img ?>profile/remove.png" border="0" />
                        </td>
                        <td class="lnk_bg">
                            <a href="<?= base_url() ?>gateway/delete_friend/<?= ltrim($user_profile->id, '0') ?>">
                                <?= $lang['delete_friend'] ?>
                            </a>
                        </td>
                        <?php
                            }else{
                        ?>
                        <td>
                            <img src="<?= $base_img ?>profile/remove.png" border="0" />
                        </td>
                        <td class="lnk_bg">
                                <?= $lang['block_friend'] ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?= $base_img ?>profile/report.png" border="0" />
                        </td>
                        <td class="lnk_bg">
                            <a href="#" id="report_abuse">
                                <?= $lang['report_abuse'] ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }else {
                    ?>
                    <tr>
                        <td width="20">
                            <img src="<?= $base_img ?>profile/edit.png" border="0" />
                        </td>
                        <td class="lnk_bg">
                            <a href="<?= base_url() ?>edit_profile/">
                                <?= $lang['profile_set'] ?>
                            </a>
                        </td>
                    </tr>
                    <tr style="height:33px;">
                        <td valign="bottom">
                            <BR />
                                <img src="<?= $base_img ?>profile/invite.png" border="0" />
                            <BR />
                        </td>
                        <td>
                            <span style="font-size:10px;">
                                <?= $lang['invite'] ?>:
                            </span>
                            <input type="text" title="<?= $lang['friends_email'] ?>" name="invite_friend" id="invite_friend" style="text-align:left; direction:ltr; width:80px; float:right;" />
                            <input style="font-size:10px; float:left; width:20px; height:17px;" type="button" value="ok" id="invite_ok" />
                        </td>
                    </tr>
                    <tr style="height:33px;">
                        <td valign="bottom">
                            <BR />
                            <img src="<?= $base_img ?>profile/search.png" border="0" />
                            <BR />
                        </td>
                        <td>
                            <span style="font-size:10px;">
                                <?= $lang['search'] ?>:
                            </span>
                            <input type="text" title="<?= $lang['friends_name'] ?>" name="search_friend" id="search_friend" style="text-align:right; direction:rtl; width:80px; float:right;" /><input style="font-size:10px; float:left; width:20px; height:17px;" type="button" value="ok" id="search_ok" />
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>

         </div>

         <div id="content">
                  <?= $content ?>
         </div>
        
         <div id="rightcolumn">

               <div class="drivers_friends">
                    <div class="all_friends">
                        <?php
                            if(is_array($friends) && count($friends) > 0) {
                            ?>
                                        <a href="<?= base_url() ?>friends/all/<?= $driver_profile->id ?>" style="font-size:10px;">
                                            <?= $lang['all_friends'] ?>
                                        </a>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="friends_list">
                    <?php
                        if(is_array($friends) && count($friends) > 0) {
                                foreach($friends as $x => $k) {
                                    ?>
                                    <div class="friends_photo" title="<?= $k->first_name ?>">
                                        <a href="<?= base_url() ?>profile/user/<?= ltrim($k->id, '0') ?>">
                                                    <?php
                                                    if($k->photo != "") {
                                                    ?>
                                                        <img src="<?= $base_img ?>system/application/helpers/fa_image_helper.php?nw=30&nh=30&source=../views/layouts/images/drivers/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
                                                    <?php
                                                    }
                                                    else {
                                                    ?>
                                                        <img src="<?= $base_img ?>default.png" width="32px" height="32px" border="0"/>
                                                    <?php
                                                    }
                                                    ?>
                                            </a>
                                    </div>
                                    <?php
                                }
                                }
                                else {
                                    echo "<span style='font-size:11px; text-align:right;'>" . $lang['no_friend'] . "</span>";
                                }
                    ?>
                    </div>
                </div>


             <div>

                             <?php
                        if(!is_object($driver) || $driver_profile->id != $driver->id) {
                    ?>
                                    <div class="private_messages">
                                        <div class="private_messages_text">
                                            <textarea id="private_messages_textarea" style="border:0px; overflow:hidden; font-size:10px; font-family:Tahoma;" cols="30" rows="4"></textarea>
                                        </div>
                                        <div class="private_messages_send">
                                            <input style="font-size:10px; float:left;" type="button" value="<?= $lang['submit'] ?>" />
                                        </div>
                                        <div class="private_messages_load">
                                        </div>
                                    </div>
                    <?php
                        }
                        else {
                        ?>
                                    <div class="infos">
                                        <div class="private_messages_text">
                                            <?php
                                                $msg_counter = 0;
                                                $messages = Drivers_model::get_messages($driver_profile);
                                                $i = 0;
                                                if(is_array($messages) && count($messages) > 0) {
                                                        foreach($messages as $x => $k) {
                                                            if($k['checked'] == 0) {
                                                                $i++;
                                                            }
                                                        }
                                                            }
                                                if($i > 0) {
                                                    $msg_counter++;
                                                    echo "<div class='alert'><span style='font-weight:bold'>" . convert_number($i . "") . "</span> " . $lang['new_messages'] . "<BR /><a href='" . base_url() . "inbox/'>" . $lang['go_inbox'] . "</a></div>";
                                                }

                                                if($driver_profile->newsletter == 0) {
                                                    $msg_counter++;
                                                    echo "<div class='newsletter'>" . $lang['join_newsletter'] . "</div>";
                                                }
                                                if($msg_counter < 2) {
                                                    echo "<div class='objective'>" . $lang['next_objective' . Driver::get_drivers_next_lock($driver_profile)] . "</div>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                        <?php
                        }
                    ?>

             </div>

         </div>
		 <div id="footer">

			   <p>This is the Footer</p>

	     </div>
    </div>
<script>
	$("#search_ok").click( function() {
	    if($("#search_friend").val() != "") {
			window.location = "<?= base_url() ?>users/find/0/" + $("#search_friend").val();
		}
	});

	$("#invite_ok").click( function() {
	    if($("#invite_friend").val() != "") {
			window.location = "<?= base_url() ?>gateway/invite_friend/" + $("#invite_friend").val();
		}
	});

	$("#report_abuse").click( function() {
	    Boxy.confirm("<?= $lang['report_body'] ?>", function() {
	        window.location = "<?= base_url() ?>gateway/report_abuse/<?= $driver_profile->id ?>";
		}, {title:"<?= $lang['report_abuse'] ?>"});
	});
</script>

</body>
</html>
