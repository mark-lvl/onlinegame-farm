<div class="right_box">
    <div class="users_photo">
        <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>">
            <?php
                if($user_profile->photo != "") {
            ?>
            <img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=110&nh=110&source=../views/layouts/images/users/<?= $user_profile->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
            <?php
                }else{
            ?>
            <img src="<?= base_url() ?>system/application/views/layouts/images/users/default.jpg" border="0" />
            <?php
                }
            ?>
        </a>
    </div>
    <div class="users_information">
        <span class="text_h6"><?= $lang['name'] ?>:</span>
        <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" style="color:#444;">
                <?= $user_profile->first_name . " " . $user_profile->last_name ?>
        </a>
        <BR />
        <BR />
        <span class="text_h6"><?= $lang['register_date'] ?>:</span>
        <?= convert_number(fa_strftime("%d %B %Y", $user_profile->registration_date . "")) ?>
        <div class="divider1">
        </div>
        <table cellpadding="0" cellspacing="0" border="0">
            <?php
                if(!is_object($user) || $user_profile->id != $user->id) {
            ?>
            <tr>
            <?php
                if(!$user_profile->is_related && !$user_profile->is_blocked) {
            ?>
                <td>
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/add.png" border="0" />
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
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/remove.png" border="0" />
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
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/remove.png" border="0" />
                </td>
                <td class="lnk_bg">
                        <?= $lang['block_friend'] ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/report.png" border="0" />
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
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/edit.png" border="0" />
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
                        <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/invite.png" border="0" />
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
                    <img src="<?= base_url() ?>system/application/views/layouts/images/inside/profile/search.png" border="0" />
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

<script>
	$("#search_ok").click( function() {
	    if($("#search_friend").val() != "") {
			window.location = "<?= base_url() ?>users_list/index/0/" + $("#search_friend").val();
		}
	});
	
	$("#invite_ok").click( function() {
	    if($("#invite_friend").val() != "") {
			window.location = "<?= base_url() ?>gateway/invite_friend/" + $("#invite_friend").val();
		}
	});
	
	$("#report_abuse").click( function() {
	    Boxy.confirm("<?= $lang['report_body'] ?>", function() {
	        window.location = "<?= base_url() ?>gateway/report_abuse/<?= $user_profile->id ?>";
		}, {title:"<?= $lang['report_abuse'] ?>"});
	});
</script>