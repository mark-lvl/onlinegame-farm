<?php
    if(!$data['user']) {
?>
<div class="login_box">
        <form action="<?= base_url() ?>gateway/login/" method="POST" >
                <input type="text" name="email_login" id="email_login" maxlength="250"  class="input" title="<?= $lang['email'] ?>"/>
                <input type="password" name="password_login" id="password_login" maxlength="250" class="input" title="<?= $lang['password'] ?>"/>
                <input type="submit" value=" " class="loginSubmit"/>
        </form>
        <?= anchor('gateway/forgotPassword',$this->lang->language['forgotPassword'],array('class'=>'whiteBoldLink')) ?>
</div>
<?php
	}
	else {
?>
	    <div class="loginBoxLogged">
	        <ul>
		        <li>
		        	<a href="<?= base_url() ?>profile/user/<?= $data['user']->id ?>/"><?= $data['lang']['profile'] ?></a>
		        </li>
		        <li>
                                <?= anchor(base_url()."farms/view/".$data['user']->id, $this->lang->language['GotoFarm']) ?>
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
