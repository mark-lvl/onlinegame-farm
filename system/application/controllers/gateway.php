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
	
	function assign_race() {
	    
		$user = $this->user_model->is_authenticated();
		if(!$user) {
			header("Location: " . base_url() . "message/index/17/");
			die();
		}
		if($user->current_race != 0) {
			header("Location: " . base_url() . "rally/");
			die();
		}
		
	    if(!isset($_POST['race_type']) || trim($_POST['race_type'], " ") == "") {
			header("Location: " . base_url() . "rally_selection/");
		    die();
	    }

	    $sql = "SELECT * FROM `races` WHERE type= '" . $_POST['race_type']  . "' AND status = 1 AND date_start <= '" . date("Y-m-d H:i:s") . "'  AND date_end > '" . date("Y-m-d H:i:s") . "' LIMIT 1;";

	    $result = $this->db->query($sql);
	    $result = $result->result_array();
		$race = new Race($result[0]);

		if(!is_array($result) || count($result) <= 0) { //No race is available
			header("Location: " . base_url() . "message/index/10");
		    die();
	    }
	    
		$sql = "SELECT * FROM `records` WHERE race = " . $race->id . " AND user = " . $user->id;
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    if(is_array($result) && count($result) > 0) { //This user has already played this race before!
			header("Location: " . base_url() . "message/index/11");
		    die();
	    }
		
		$user->current_race = $race->id;
		$user->current_speed = $race->start_speed;
		$user->last_status_update = date("Y-m-d H:i:s");
		$user->current_fuel = 100;
		$user->current_water = 100;
		$user->current_tiredness = 100;
		$user->current_water = 100;
		$user->current_oil = 100;
		$user->current_tire = 100;
		$user->current_position = 0;
		$user->current_checkpoint = 0;
		$user->current_time_passed = 0;
		$user->time_next_checkpoint = "0000-00-00 00:00:00";

		user_model::calculate_next_checkpoint($user, $race, $user->current_speed);
		
		header("Location: " . base_url() . "rally/");
	    die();
	}
	
	function get_next_question() {
		$user = $this->user_model->is_authenticated();
		//if(!$user || $_POST['user'] != $user->id) {
		if(!$user) {
			header("Location: " . base_url() . "message/index/17/");
			die();
		}
		if($user->current_race == 0) {
			header("Location: " . base_url() . "rally_selection/");
			die();
		}
		
		$questions = user_model::get_users_question($user, 1, TRUE);
		
		$this->load->library('json_service');
		$result = $this->json_service->encode($questions);
		
		print_r($result);
		die();
	}
	
	function submit_vote() {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
		if($_POST['vote'] != 0 && $_POST['vote'] != 1) {
		    die("false");
		}
		
		$sql = "SELECT * FROM `votes` WHERE car_id = " . $this->db->escape($_POST['car']) . " AND user_id = " . $this->db->escape($user->id);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    if(is_array($result) && count($result) > 0) {
	        die("false");
	    }
	    
		$sql = "INSERT INTO `votes` (car_id, user_id, type, `date`) VALUES (" . $this->db->escape($_POST['car']) . ", " . $this->db->escape($user->id) . ", " . $this->db->escape($_POST['vote']) . ", '" . date('Y-m-d H:i:s') . "')";
		$result = $this->db->query($sql);
		if($result) {
	        die("TRUE");
		}
		else {
	        die("false");
		}
	}
	
	function set_car() {
	    if(!isset($_POST['user_id'])) {
	    	die();
	    }

		$user = $this->user_model->is_authenticated();
		if(!$user || $user->id != $_POST['user_id']) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
	    $data = explode(",", $_POST['img']);
	    $width = $_POST['width'];
	    $height = $_POST['height'];

	    $image=imagecreatetruecolor($width, $height);
	    imagealphablending($image, true);
	    $i = 0;
	    for($x=0; $x<=$width; $x++){
	        for($y=0; $y<=$height; $y++){
	            $int = hexdec($data[$i++]);
	            $color = imagecolorallocate($image, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
	            imagesetpixel($image, $x, $y, $color);
	        }
	    }

	    imagepng($image, "system/application/views/layouts/images/cars/" . md5($_POST['user_id']) . ".png");

		if($user->car == 0) {
			$user->car = $user->id;
			user_model::update($user, array("car"));
		}
		
		header("Location: " . base_url() . "profile/user/" . $_POST['user_id']);
		die();
	}
	
	function delete_vote($id) {
		$user = $this->user_model->is_authenticated();
		if(!$user) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
		$id = (int) $id;
		$sql = "DELETE FROM `votes` WHERE car_id = " . $this->db->escape($id) . " AND user_id = " . $this->db->escape($user->id);
	    $this->db->query($sql);
	    
		header("Location: " . base_url() . "profile/user/" . $id);
		die();
	}

	function get_users_position($race_length = 1) {
	    $user = $this->user_model->is_authenticated();

		if(!$user) {
		    die("false");
		}
		if($user->current_race == 0) {
		    die("false");
		}

		$race = Races_model::get_race($user->current_race);
		
	    $updated_user = user_model::calculate_next_checkpoint($user, $race, $user->current_speed);
	
	    $lang = $this->lang->language;
	    
		$this->load->library('json_service');
		$result[0] = str_replace("X", convert_number(floor(($updated_user->current_position / 10) / $race_length) . ""), str_replace("XX", convert_number($race_length . ""), str_replace("XXX", convert_number(floor($updated_user->current_position / 1000) . "") , $lang['navigate_hint'])));
		$result[1] = ceil((111 * ((($updated_user->current_position / 10) / $race->length))/100));
		
		$resultx = $this->json_service->encode($result);
		die($resultx);
	}
	
	function submit_question_answer() {
	    $user = $this->user_model->is_authenticated();

		if(!$user) {
		    die("false");
		}
		
		$sql = "SELECT * FROM `alerts` WHERE id = " . $this->db->escape($_POST['aid']);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
		
		$this->load->library('json_service');
		
		if($_POST['qt'] == "1") {
			$result[0]['advantage'] = "5";
		}
		$resultx = $this->json_service->encode($result);
		
	    $sql = "UPDATE `questions` SET answer = " . $this->db->escape($_POST['answer']) . ", date_answered = '" . date('Y-m-d H:i:s') . "' WHERE user = " . $this->db->escape($user->id) . " AND id = " . $this->db->escape($_POST['qid'] . " AND answer = 0");

	    $rt = $this->db->query($sql);
	    
	    if($rt && $result[0]['answer'] == $_POST['answer'] && $_POST['qt'] == "0") { //The answer is right!
	        switch($result[0]['advantage']) {
	            case 0:
	                $user->current_speed += 10;
	                break;
	            case 1:
	                $user->current_speed += 15;
	                break;
	            case 2:
	                $user->current_speed += 25;
	                break;
	            case 3:
	                $user->current_speed += 35;
	                break;
	        }
	        $user->score += 20;
			$fields = array("current_speed", "score", "rally_count", "current_tire", "current_oil", "current_water", "current_tiredness", "current_fuel");
			user_model::update($user, $fields);
	    }
	    if($rt && $result[0]['answer'] == $_POST['answer'] && $_POST['qt'] == "1") { //The answer is right and the question is a challenge
	    
			$next_user = user_model::get_user_by_id($user->challenged);

			$next_user->challenged = 0;
			$next_user->challenged_time = "0000-00-00 00:00:00";
			$next_user->challenged_question = 0;
			$next_user->challenge_final_time = "0000-00-00 00:00:00";
			$next_user->current_speed -= 5;
			if($next_user->current_speed <= 0) {
				$next_user->current_speed = 1;
			}
			$p1 = user_model::update($next_user, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));

			$user->challenged = 0;
			$user->challenged_time = "0000-00-00 00:00:00";
			$user->challenged_question = 0;
			$user->challenge_final_time = "0000-00-00 00:00:00";
			$user->current_speed += 5;
			$p2 = user_model::update($user, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time") );
			
			if($p2 && $p1) {
			    $lang = $this->lang->language;
	    		user_model::send_message($user->id, $next_user->id, $lang['challneglostt'], str_replace("XXX", "<a href='" . base_url() . "profile/user/" . $user->id . "'>" . $user->first_name . " "  . $user->last_name . "</a>", $lang['challneglost']));
			}
	    }
	    else if($rt && $result[0]['answer'] != $_POST['answer'] && $_POST['qt'] == 1) { //The answer is right and the question is a challenge
			$next_user = user_model::get_user_by_id($user->challenged);
			
			$next_user->challenged = 0;
			$next_user->challenged_time = "0000-00-00 00:00:00";
			$next_user->challenged_question = 0;
			$next_user->challenge_final_time = "0000-00-00 00:00:00";
			$next_user->current_speed += 5;

			$p1 = user_model::update($next_user, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));

			$user->challenged = 0;
			$user->challenged_time = "0000-00-00 00:00:00";
			$user->challenged_question = 0;
			$user->challenge_final_time = "0000-00-00 00:00:00";
			$user->current_speed -= 5;
			$p2 = user_model::update($user, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));
			
			if($p2 && $p1) {
				$lang = $this->lang->language;
	    		user_model::send_message($user->id, $next_user->id, $lang['challnegwont'], str_replace("XXX", "<a href='" . base_url() . "profile/user/" . $user->id . "'>" . $user->first_name . " "  . $user->last_name . "</a>", $lang['challnegwon']));
			}
	    }
	    
	    print_r($resultx);
	    die();
	}
	
	function newsletter() {
	    $user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("false");
		}
		
	    $sql = "UPDATE `users` SET newsletter = 1, score = score + 100 WHERE newsletter = 0 AND id = " . $this->db->escape($user->id);
	    $this->db->query($sql);
	    
	    header("Location: http://www.renault.co.ir/?page=13&lang=fa");
	    die();
	}
	
	function ilikeit() {
	    $user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("false");
		}
		
		$sql = "SELECT * FROM `diary_votes` WHERE diary = " . $this->db->escape($_POST['did']) . " AND user = " . $this->db->escape($user->id);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    if(is_array($result) && count($result) > 0) {
		    $sql = "DELETE FROM `diary_votes` WHERE diary = " . $this->db->escape($_POST['did']) . " AND user = " . $this->db->escape($user->id);
	    }
	    else {
		    $sql = "INSERT INTO `diary_votes` (diary, user, type, `date`) VALUES (" . $this->db->escape($_POST['did']) . ", " . $this->db->escape($user->id) . ", 1, '" . date("Y-m-d H:i:s") . "')";
	    }
	    
	    if($this->db->query($sql)) {
	        die("ok");
	    }
	    else {
	    	die("false");
	    }
	}
	
	function submit_diary() {
	    $user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("false");
		}

		if(trim($_POST['title'], " ") == "" || trim($_POST['body'], " ") == "") {
			die("false");
		}

	    $sql = "INSERT INTO `diaries` (user, title, body, `date`) VALUES (" . $this->db->escape($user->id) . ", " . $this->db->escape($_POST['title']) . ", " . $this->db->escape($_POST['body']) . ", '" . date("Y-m-d H:i:s") . "')";
	    
	    if($this->db->query($sql)) {
	        die($this->db->insert_id() . "");
	    }
	    else {
	    	die("false");
	    }
	}
	
	function edit_diary() {
	    $user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("false");
		}

		if(trim($_POST['title'], " ") == "" || trim($_POST['body'], " ") == "") {
			die("false");
		}

	    $sql = "UPDATE `diaries` SET title = " . $this->db->escape($_POST['title']) . ", body = " . $this->db->escape($_POST['body']) . " WHERE user = " . $this->db->escape($user->id) . " AND id = " . $this->db->escape($_POST['id']);

	    if($this->db->query($sql)) {
	        die("ok");
	    }
	    else {
	    	die("false");
	    }
	}
	
	
	
	function set_users_car($id) {
	    $sql = "UPDATE `users` SET car = " . $this->db->escape($id) . " WHERE id = " . $this->db->escape($id);
	    $this->db->query($sql);
	    header("Location: " . base_url() . "profile/user/" . $id);
	    die();
	}
	
	function delete_last_diary() {
	    $user = $this->user_model->is_authenticated();
		if(!$user) {
		    die("");
		}
		$sql = "DELETE FROM `diaries` WHERE user = " . $this->db->escape($user->id) . " ORDER BY id DESC LIMIT 1";
	    $result = $this->db->query($sql);

	    header("Location: " . base_url() . "rally/");
	    die();
	}
	
	function challenge() {
	    $user = $this->user_model->is_authenticated();
		if(!isset($_POST['id']) || !$user || $user->challenged != 0 || $user->id != $_POST['id']) {
		    die("false");
		}
		
		$next_user = user_model::get_next_user($user);
		$question = new Question(Races_model::get_challenge_question($next_user));
		$question->alert = $question->id;
		$question->user = $next_user->id;
		$question->date_asked = date("Y-m-d H:i:s");
		$qid = Races_model::submit_question($question);

		if($qid) {
			$next_user->challenged = $user->id;
			$next_user->challenged_time = date("Y-m-d H:i:s");
			$next_user->challenged_question = $qid;
			$tt = date("Y-m-d H:i:s", strtotime("+10 hours"));
			$next_user->challenge_final_time = $tt;
			user_model::update($next_user, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));
			
			$user->challenged = $next_user->id;
			user_model::update($user, array("challenged"));

			$lang = $this->lang->language;
			
			$body = str_replace("XXX", "<a href='" . base_url() . "profile/user/" . $user->id . "'>" . $user->first_name . " "  . $user->last_name . "</a>", $lang['challnegmsg']);
			$body = str_replace("XX", convert_number(substr($tt, -8, 5) . ", " . fa_strftime("%d %B", $tt . "")), $body);
	    	user_model::send_message($user->id, $next_user->id, $lang['challnegmsgt'], $body);
	    	
			$tt = convert_number(substr($tt, -8, 5) . ", " . fa_strftime("%d %B", $tt . ""));
			die($tt);
		}
		die("false");
	}
	
	function cancel_challenge() {
	    $user = $this->user_model->is_authenticated();
		if(!isset($_POST['id']) || !$user || $user->challenged == 0 || $user->id != $_POST['id']) {
		    die("false");
		}

		$next_user = new user(array("id" => $user->challenged));
		
		$next_user->challenged = 0;
		$next_user->challenged_time = "0000-00-00 00:00:00";
		$next_user->challenged_question = 0;
		$next_user->challenge_final_time = "0000-00-00 00:00:00";
		$p1 = user_model::update($next_user, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));

		$user->challenged = 0;
		$user->challenged_time = "0000-00-00 00:00:00";
		$user->challenged_question = 0;
		$user->challenge_final_time = "0000-00-00 00:00:00";
		$p2 = user_model::update($user, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));
		
		$lang = $this->lang->language;

    	user_model::send_message($user->id, $next_user->id, $lang['challnegcant'], str_replace("XXX", "<a href='" . base_url() . "profile/user/" . $user->id . "'>" . $user->first_name . " "  . $user->last_name . "</a>", $lang['challnegcan']));
    	
		if($p1 && $p2) {
			die("true");
		}
		die("false");
	}
	
	function get_challenge_question() {

		$user = $this->user_model->is_authenticated();
		if(!$user) {
			die("false");
		}
		if(!isset($_POST['id']) || !$user || $user->challenged == 0 || $user->id != $_POST['id'] || $user->current_race == 0 || $user->challenged_question == 0) {
		    die("false");
		}

		$questions = user_model::get_users_question($user, 1, TRUE, FALSE);

		$this->load->library('json_service');
		$result = $this->json_service->encode($questions);

		print_r($result);
		die();
	}
}
