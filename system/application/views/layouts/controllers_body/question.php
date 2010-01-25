<BR /><BR />
<div class="main_bg">
	<BR /><BR /><BR />
	<form method="post" action="<?= base_url() ?>questions/" name="frm1" id="frm1">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">سوال:</td>
	    	<td><input style="width:150px;" type="text" name="question" id="question" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">گزینه1: </td>
			<td><input style="width:150px;" type="text" name="q1" id="q1" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">گزینه2: </td>
			<td><input style="width:150px;" type="text" name="q2" id="q2" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">گزینه3: </td>
			<td><input style="width:150px;" type="text" name="q3" id="q3" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">گزینه4: </td>
			<td><input style="width:150px;" type="text" name="q4" id="q4" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">شهر: </td>
			<td><input style="width:150px;" type="text" name="city" id="city" value="" /></td>
		  </tr>
		  <tr style="height:25px;">
			<td style="width:200px; text-align:left; padding-left:5px;">جواب: </td>
			<td>
			<select id="ans" name="ans">
			    <option value="1">
			        1
			    </option>
			    <option value="2">
			        2
			    </option>
			    <option value="3">
			        3
			    </option>
			    <option value="4">
			        4
			    </option>
			</select>
			</td>
		  </tr>
		  <tr>
			<td style="width:200px; text-align:left; padding-left:5px;" valign="top">نوع:</td>
			<td>
				<select id="type" name="type" style="font-family:Tahoma; font-size:11px;">
				    <option value="2">
				        رنو
				    </option>
				    <option value="0">
				        اطلاعات عمومی
				    </option>
				    <option value="3">
				        ترافیک
				    </option>
				    <option value="4">
				        ایرانگردی
				    </option>
				</select>
			</td>
		  </tr>
		  <tr style="height:10px;">
			<td></td>
			<td style="width:270px;"></td>
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