<BR /><BR />
<div class="main_bg">
	<BR /><BR /><BR />
	<form method="post" action="<?= base_url() ?>contact/" name="frm1" id="frm1">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;"><?= $lang['name'] ?>:</td>
	    	<td><input style="width:150px;" type="text" name="name" id="name" value="<?= ($driver) ? $driver->first_name . " " . $driver->last_name : NULL ?>" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;"><?= $lang['email'] ?>:</td>
			<td><input style="width:150px; text-align:left;" type="text" name="email" id="email" value="<?= ($driver) ? $driver->email : NULL ?>" /></td>
		  </tr>
		  <tr style="height:5px;">
			<td style="width:200px; text-align:left; padding-left:5px;">&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td style="width:200px; text-align:left; padding-left:5px;" valign="top"><?= $lang['body'] ?>:</td>
			<td>
				<textarea name="comment" id="comment" cols="30" rows="5"></textarea>
			</td>
		  </tr>
		  <tr style="height:30px;">
			<td></td>
			<td><?= $lang['contact_ren'] ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>
		        <input type="submit" value="<?= $lang['submit'] ?>" />
			</td>
		  </tr>
		  </tr>
		</table>
	</form>
</div>
<BR /><BR />