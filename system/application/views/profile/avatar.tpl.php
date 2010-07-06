<style>
    #centerContainerSecondLayer
    {
        background: #2b3b09;
        height: 388px;
        width: 464px;
        display: block;
        margin-top: 7px;
    }
    .closeButton
    {
    	position: absolute;
    	bottom:13px;
    	right:90px;
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
    <div style="float:right; text-align:right;">
        <?php if($user_profile->sex == 0): ?>
        <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="440" height="370" id="design_car" align="middle">
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="false" />
            <param name="swliveconnect" value="true" />
            <param name="movie" value="<?= base_url() ?>system/application/assets/flashes/yummyAvatar{89-3-22}M.swf?<?= date('H:i:s') ?>" />
            <param name="FlashVars" value="url_file=<?= base_url() ?>system/application/assets/flashes/&url_base=<?= base_url() ?>" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="wmode" value="transparent" />
            <embed swliveconnect="true" FlashVars="url_file=<?= base_url() ?>system/application/assets/flashes/&url_base=<?= base_url() ?>" src="<?= base_url() ?>system/application/assets/flashes/yummyAvatar{89-3-22}M.swf?<?= date('H:i:s') ?>" quality="high" bgcolor="#ffffff" width="460" height="390" name="design_car" wmode="transparent" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </object>
        <?php else: ?>
        <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="440" height="370" id="design_car" align="middle">
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="false" />
            <param name="swliveconnect" value="true" />
            <param name="movie" value="<?= base_url() ?>system/application/assets/flashes/girl/yummyAvatar{89-3-22}F.swf?<?= date('H:i:s') ?>" />
            <param name="FlashVars" value="url_file=<?= base_url() ?>system/application/assets/flashes/girl/&url_base=<?= base_url() ?>" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="wmode" value="transparent" />
            <embed swliveconnect="true" FlashVars="url_file=<?= base_url() ?>system/application/assets/flashes/&url_base=<?= base_url() ?>" src="<?= base_url() ?>system/application/assets/flashes/girl/yummyAvatar{89-3-22}F.swf?<?= date('H:i:s') ?>" quality="high" bgcolor="#ffffff" width="460" height="390" name="design_car" wmode="transparent" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </object>
        <?php endif; ?>
    </div>