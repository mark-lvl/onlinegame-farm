<?php
	class Profile_left_boxes extends Controller
	{	
		function method($data)
		{
		    $drivers_ranks	= $data['drivers_ranks'];
		    $driver_profile = $data['driver_profile'];
		    $driver 		= $data['driver'];
		    $lang 			= $data['lang'];
		    $friends		= $data['friends'];

			include 'system/application/modules/profile_left_boxes/language/' . get_lang() . '_lang.php';
			include 'system/application/modules/profile_left_boxes/views/profile_left_boxes.php';
		}
	}
?>