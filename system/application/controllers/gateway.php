<?php

class Gateway extends MainController {

	function Gateway()
	{
		parent::MainController();
	}

	function index()
	{
	    header("Location: " . base_url());
	    die();
	}

	function login() {
	    if(!isset($_POST['email_login']) || !isset($_POST['password_login']) || trim($_POST['email_login'], " ") == "") {
			header("Location: " . base_url());
		    die();
	    }
	    else {
	        $user = $this->user_model->log_in($_POST['email_login'], $_POST['password_login']);
	        if($user) {
	            $_SESSION['user'] = $user;
                        redirect('profile/user/'.$user->id);
                    }
		else
                    redirect('message/index/0/');
	    }
	}
	
	function logout() {
		$_SESSION['user'] = "";
		$_SESSION['captcha'] = "";
		$_SESSION['reg_error'] = 0;
	    session_destroy();
		header("Location: " . base_url());
	    die();
	}
	
	function accept_friend($id) {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
                    header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
		
		$sql = "UPDATE `relations` SET status = 1 WHERE `guest` = '" . $user->id . "' AND `inviter` = " . $this->db->escape($id);
		$existSql = "SELECT `id`
                             FROM `relations`
                             WHERE `guest` = '" . $user->id . "'
                             AND `inviter` = " . $this->db->escape($id);

	    if($this->db->query($existSql)->num_rows()
               && $this->db->query($sql)) {
                    header("Location: " . base_url() . "profile/user/" . $id);
		    die();
	    }
	    else {
                    header("Location: " . base_url() . "message/index/18/");
		    die();
	    }
	}

        function ignore_friend($id) {

            $lang = $this->lang->language;
            
            $user = $this->user_model->is_authenticated();

            if(!$user)
            {
                header("Location: " . base_url() . "message/index/17/");
                die("");
            }

	    $sql = "UPDATE `relations`
                    SET status = 3
                    WHERE `guest` = '" . $user->id . "'
                    AND `inviter` = " . $this->db->escape($id);

            if($this->db->query($sql))
            {
                user_model::send_message($user->id,
                                            $id,
                                            str_replace("__SUGGESTNAME__",
                                                        $user->first_name,
                                                        $lang['ignore_request']),
                                            str_replace("__SUGGESTNAME__",
                                                        $user->first_name,
                                                        $lang['ignore_requestbody']));

                header("Location: " . base_url() . "profile/user/" . $user->id);
                die();
	    }
	    else
            {
                header("Location: " . base_url());
                die();
	    }
	}

	
	
	
	function invite_friend($friend) {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
			header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
		if(!preg_match_all("([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})", $friend, $tmp)) {
		    header("Location: " . base_url() . "profile/user/" . $user->id);
		    die();
		}

		$res = $this->user_model->invite_friend($user, $friend);
	    if($res === TRUE) {
			header("Location: " . base_url() . "message/index/9/");
		    die();
	    }
	    else if($res !== FALSE) {
			header("Location: " . base_url() . "profile/user/" . $res);
		    die();
	    }
	    else {
			header("Location: " . base_url() . "message/index/8/");
		    die();
	    }
	}
	
	function send_message() {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("FALSE");
		}

		$lang	= $this->lang->language;
		
		$title = str_replace("XXX", $user->first_name, $lang['new_message']);
		
		if(user_model::send_message($user->id, $_POST['to'], $title, $_POST['body'])) {
		    die("TRUE");
		}
		die("FALSE");
	}
	
	function get_message() {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("FALSE");
		}
		
		$message = user_model::get_message($user, $_POST['id']);
		if($message) {
		    die($message[0]['message']);
		}
		die("FALSE");
	}
	
	function delete_message() {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("FALSE");
		}

		$message = user_model::delete_message($user, $_POST['id']);
		if($message) {
		    die("TRUE");
		}
		die("FALSE");
	}
	
	function delete_all_message() {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("FALSE");
		}

		$message = user_model::delete_all_message($user);
		if($message) {
		    die("TRUE");
		}
		die("FALSE");
	}
	

        function save_avatar() {
    		$user = $this->user_model->is_authenticated();
		if(!$user) {
			die("false");
		}

	    $data = explode(",", $_POST['img']);
	    $width = $_POST['width'];
	    $height = $_POST['height'];

	    $image = imagecreatetruecolor($width - 7, $height - 6);
	    imagealphablending($image, true);

		$color_pallete = array("FFE6B1","FDE8DD","FBD8C5","FCCDAC","EFB69A","EEAE96","E2AC92","FCD4A9","D3AE96","DEA672","D19592","C3996B","B18265","9A8479","73635A","5F4D32","422C26","0099CC","009933","991111","CC9900","996666","FF9966","333333","99CC00","0099FF","006699","999966","669933","336600","CC6699","663399","CC0066","999999","FFFFFF","333300","9966CC","999900","CCCC66","FF9900","FFFF33","FF6600","FF66FF","000000","5A4A42","AA6459","A87C4F","9C7B3A","B7922E","F4B230","FFDE00","0069B1","2E8AC9","26A9E0","93A9D7","BC2026","AC3831","E90A8A","F6A5C1","D9ACCF","009345","A8BA3A","8BC53F","008E86","00ABA9","00AE95","B7D3A3","9CB49A","697C70","A958A2","8256A3","F58771","FBF289","C1AA9F","E0D5C3","006600","666600","666666", "eaeaea", "825f0f", "825f0f", "f0cebc", "f4f4f4");
		$color_pallete_replacer = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","aA","bB","cC","dD","eE","fF","gG","hH","iI","jJ","kK","lL","mM","nN","oO","pP","qQ","rR","sS","tT","uU","vV","wW","xX","yY","zZ","Aa", "1", "2", "3", "4", "5");


	    $i = 0;
	    for($x=0; $x<=$width; $x++){
	        for($y=0; $y<=$height; $y++){
	            $ps = array_search($data[$i], $color_pallete_replacer);
	            if($ps !== FALSE) {
	            	$data[$i] = strtolower($color_pallete[$ps]);
	            }

	            $int = hexdec($data[$i++]);
	            $color = imagecolorallocate($image, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
	            imagesetpixel($image, $x, $y, $color);
	        }
	    }
            if(!empty($user->photo))
                $fileName = $user->photo;
            else
            {
                $fileName = uniqid($user->id);
                $user->photo = $fileName;
                $fields = array("photo");
                $this->user_model->update($user,$fields);
            }
	    imagepng($image, $this->config->item('avatars_url') . $fileName . ".png");

            

	    //redirecting
	    header("Location: " . base_url() . "profile/user/" . $user->id);
	    die();
	}
}
