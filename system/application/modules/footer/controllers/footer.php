<?php
	class Footer extends Controller
	{	
		function method($data)
		{
			include 'system/application/modules/footer/language/' . get_lang() . '_lang.php';
			include 'system/application/modules/footer/views/footer.php';
		}
	}
?>