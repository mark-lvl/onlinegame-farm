<?php
	class Profile_information extends Controller
	{	
		function method($data)
		{
		    $user_profile = $data['user_profile'];
		    $user         = $data['user'];
		    $lang 	  = $data['lang'];
		    
                    include 'system/application/modules/profile_information/language/' . get_lang() . '_lang.php';
                    include 'system/application/modules/profile_information/views/profile_information.php';
		}
	}
?>