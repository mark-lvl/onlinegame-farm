<?php
	class Login extends Controller
	{	
		function method($data)
		{
		    if($data['user']) {
		    	$data['messages'] = User_model::get_messages($data['user']);
				$data['unchecked'] = 0;
				if(is_array($data['messages']) && count($data['messages']) > 0) {
					foreach($data['messages'] as $x => $k) {
					    if($k['checked'] == 0) {
			                $data['unchecked']++;
					    }
					}
				}
			}
			
			include 'system/application/modules/login/language/' . get_lang() . '_lang.php';
			include 'system/application/modules/login/views/login.php';
		}
	}
?>
