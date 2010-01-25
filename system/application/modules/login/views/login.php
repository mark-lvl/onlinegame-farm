<?php
	if(!$data['driver']) {
?>
		<div class="login_box">
			<form action="<?= base_url() ?>gateway/login/" method="POST">
				<?= $data['lang']['email'] ?>: <input type="text" name="email_login" id="email_login" maxlength="250" style="width:80px; direction:ltr;" />
				<?= $data['lang']['password'] ?>: <input type="password" name="password_login" id="password_login" maxlength="250" style="width:80px; direction:ltr;" />
				<input type="submit" value="<?= $data['lang']['submit'] ?>" />
			</form>
		</div>
<?php
	}
	else {
?>
	    <div class="personal_menu">
	        <div class="personal_menu_photo">
			    <?php
			        if($data['driver']->photo != "") {
			    ?>
			    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=15&nh=15&source=../views/layouts/images/drivers/<?= $data['driver']->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				<?php
				    }
				    else {
			    ?>
	       			<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=15&nh=15&source=../views/layouts/images/drivers/default.jpg&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
				<?php
				    }
				?>
			</div>
	    </div>
	    <div class="personal_menu_down">
	        <ul>
		        <li>
		        	<a href="<?= base_url() ?>profile/driver/<?= $data['driver']->id ?>/"><?= $data['lang']['profile'] ?></a>
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