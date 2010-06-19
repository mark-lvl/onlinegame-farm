<style>
  #centerContainer {
    background: #2b3b09;
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
    .closeButton
    {
    	position: absolute;
    	bottom:13px;
    	right:90px;
    }
    .closeButton a img
    {
        width:26px;
    	height:26px;
    	display:block;
    }
</style>
<div>
    <span class="closeButton"><?= anchor("profile/user/$user_profile->id","<img src=\"$base_img"."popup/boxy/close.png\"/>") ?></span>
    <div style="float:right; text-align:right;">
        <?php if($user_profile->sex == 0): ?>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="460" height="390" id="design_car" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="swliveconnect" value="true" />
		<param name="urlx" value="<?= base_url() ?>" />
		<param name="url_file" value="<?= css_url() ?>system/application/assets/flashes/" />
      		<param name="url_base" value="<?= base_url() ?>" />
		<param name="movie" value="<?= base_url() ?>system/application/assets/flashes/yummyAvatar{89-3-18}M.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="wmode" value="transparent" />	<embed swliveconnect="true" FlashVars="url_file=<?= css_url() ?>system/application/assets/flashes/&url_base=<?= base_url() ?>" src="<?= css_url() ?>system/application/assets/flashes/yummyAvatar{89-3-22}M.swf?<?= date('H:i:s') ?>" quality="high" bgcolor="#ffffff" width="460" height="390" name="design_car" wmode="transparent" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
        <?php else: ?>
                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="460" height="390" id="design_car" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="swliveconnect" value="true" />
		<param name="url_file" value="<?= css_url() ?>system/application/assets/flashes/girl/" />
      		<param name="url_base" value="<?= base_url() ?>" />
		<param name="movie" value="<?= base_url() ?>system/application/assets/flashes/girl/yummyAvatar{89-3-18}F.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="wmode" value="transparent" />	<embed swliveconnect="true" FlashVars="url_file=<?= css_url() ?>system/application/assets/flashes/girl/&url_base=<?= base_url() ?>" src="<?= css_url() ?>system/application/assets/flashes/girl/yummyAvatar{89-3-22}F.swf?<?= date('H:i:s') ?>" quality="high" bgcolor="#ffffff" width="460" height="390" name="design_car" wmode="transparent" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
        <?php endif; ?>
    </div>
</div>