<div style="margin-top:30px;">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="840" height="370" id="design_car" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="swliveconnect" value="true" />
	<param name="movie" value="<?= base_url() ?>system/application/views/layouts/flash/design_car/design_car.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="wmode" value="transparent" />	<embed swliveconnect="true" src="<?= base_url() ?>system/application/views/layouts/flash/design_car/design_car.swf" quality="high" bgcolor="#ffffff" width="840" height="370" name="design_car" wmode="transparent" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</div>
	
<script>
	$(function(){
		if(window.design_car) { window.document["design_car"].SetVariable('user_id', '<?= $driver->id ?>'); }
		if(document.design_car) { document.design_car.SetVariable('user_id', '<?= $driver->id ?>'); }
		
		if(window.design_car) { window.document["design_car"].SetVariable('url', '<?= base_url() ?>system/application/'); }
		if(document.design_car) { document.design_car.SetVariable('url', '<?= base_url() ?>system/application/'); }
	});
</script>