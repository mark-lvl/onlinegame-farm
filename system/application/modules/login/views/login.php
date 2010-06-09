<?php
    if(!$data['user']) {
?>
<div class="login_box">
        <form action="<?= base_url() ?>gateway/login/" method="POST">
            <input type="text" name="email_login" id="email_login" maxlength="250"  class="input" title="<?= $lang['email'] ?>"/>
                <input type="password" name="password_login" id="password_login" maxlength="250" class="input" title="<?= $lang['password'] ?>"/>
                <input type="submit" value=" " class="loginSubmit"/>
        </form>
</div>
<?php
	}
	else {
?>
	    <div class="personal_menu">
	        <div class="personal_menu_photo">
			    <?php
			        if($data['user']->photo != "") {
			    ?>
			    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=15&nh=15&source=../views/layouts/images/users/<?= $data['user']->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				<?php
				    }
				    else {
			    ?>
	       			<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=15&nh=15&source=../views/layouts/images/users/default.jpg&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				<?php
				    }
				?>
			</div>
	    </div>
	    <div class="personal_menu_down">
	        <ul>
		        <li>
		        	<a href="<?= base_url() ?>profile/user/<?= $data['user']->id ?>/"><?= $data['lang']['profile'] ?></a>
		        </li>
		        <li>
		        	<a href="<?= base_url() ?>inbox/"><?= $data['lang']['inbox'] ?> <?= ($data['unchecked'] != 0) ? "(" . convert_number($data['unchecked'] . "") . ")" : NULL;  ?></a>
		        </li>
		        <li>
		        	<a href="<?= base_url() ?>gateway/logout/"><?= $data['lang']['logout'] ?></a>
		        </li>
	        </ul>
	    </div>
<?php
	}
?>
<script>
	var ptxsc = 0;
	$(".personal_menu").click( function() {
	    if(ptxsc == 0) {
	    	$(".personal_menu_down").slideDown('fast');
		}
		else {
	    	$(".personal_menu_down").slideUp('fast');
		}
	    ptxsc = !ptxsc;
	});
</script>
<script>
    $(function(){
 // find all the input elements with title attributes
 $('input[title!=""]').hint();
 });
</script>
