<?php

class Gateway extends Controller {

	function Gateway()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
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
	        $driver = $this->drivers_model->log_in($_POST['email_login'], $_POST['password_login']);
	        if($driver) {
	            $_SESSION['driver'] = $driver;
	            if($driver->car == 0) {
					header("Location: " . base_url() . "design/");
				    die();
	            }
				header("Location: " . base_url() . "profile/driver/" . $driver->id);
			    die();
	        }
	        else {
				header("Location: " . base_url() . "message/index/0/");
			    die();
	        }
	    }
	}
	
	function logout() {
		$_SESSION['driver'] = "";
		$_SESSION['captcha'] = "";
		$_SESSION['reg_error'] = 0;
	    session_destroy();
		header("Location: " . base_url());
	    die();
	}
	
	function accept_friend($id) {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
		
		$sql = "UPDATE `relations` SET status = 1 WHERE `guest` = '" . $driver->id . "' AND `inviter` = " . $this->db->escape($id);
	    if($this->db->query($sql)) {
			header("Location: " . base_url() . "profile/driver/" . $id);
		    die();
	    }
	    else {
			header("Location: " . base_url());
		    die();
	    }
	}
	
	function add_friend($id = "") {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches)) {
			header("Location: " . base_url());
		    die();
	    }

		$lang = $this->lang->language;
	    
	    if($this->drivers_model->relate_drivers($driver, $id)) {
	    	Drivers_model::send_message($driver->id, $id, str_replace("XXX", $driver->first_name, $lang['add_request']), str_replace("XXX", $driver->id, $lang['add_requestbody']));
			header("Location: " . base_url() . "message/index/5/");
		    die();
	    }
	    else {
			header("Location: " . base_url() . "message/index/6/");
		    die();
	    }
	}
	
	function delete_friend($id = "") {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches)) {
			header("Location: " . base_url());
		    die();
	    }

	    if($this->drivers_model->delete_relation($driver, $id)) {
			header("Location: " . base_url() . "message/index/7/");
		    die();
	    }
	    else {
			header("Location: " . base_url() . "message/index/8/");
		    die();
	    }
	}
	
	function invite_friend($friend) {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
		    die("");
		}
		if(!preg_match_all("([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})", $friend, $tmp)) {
		    header("Location: " . base_url() . "profile/driver/" . $driver->id);
		    die();
		}

		$res = $this->drivers_model->invite_friend($driver, $friend);
	    if($res === TRUE) {
			header("Location: " . base_url() . "message/index/9/");
		    die();
	    }
	    else if($res !== FALSE) {
			header("Location: " . base_url() . "profile/driver/" . $res);
		    die();
	    }
	    else {
			header("Location: " . base_url() . "message/index/8/");
		    die();
	    }
	}
	
	function send_message() {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("FALSE");
		}

		$lang	= $this->lang->language;
		
		$title = str_replace("XXX", $driver->first_name, $lang['new_message']);
		
		if(Drivers_model::send_message($driver->id, $_POST['to'], $title, $_POST['body'])) {
		    die("TRUE");
		}
		die("FALSE");
	}
	
	function get_message() {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("FALSE");
		}
		
		$message = Drivers_model::get_message($driver, $_POST['id']);
		if($message) {
		    die($message[0]['message']);
		}
		die("FALSE");
	}
	
	function delete_message() {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("FALSE");
		}

		$message = Drivers_model::delete_message($driver, $_POST['id']);
		if($message) {
		    die("TRUE");
		}
		die("FALSE");
	}
	
	function delete_all_message() {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("FALSE");
		}

		$message = Drivers_model::delete_all_message($driver);
		if($message) {
		    die("TRUE");
		}
		die("FALSE");
	}
	
	function assign_race() {
	    
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die();
		}
		if($driver->current_race != 0) {
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
	    
		$sql = "SELECT * FROM `records` WHERE race = " . $race->id . " AND user = " . $driver->id;
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    if(is_array($result) && count($result) > 0) { //This driver has already played this race before!
			header("Location: " . base_url() . "message/index/11");
		    die();
	    }
		
		$driver->current_race = $race->id;
		$driver->current_speed = $race->start_speed;
		$driver->last_status_update = date("Y-m-d H:i:s");
		$driver->current_fuel = 100;
		$driver->current_water = 100;
		$driver->current_tiredness = 100;
		$driver->current_water = 100;
		$driver->current_oil = 100;
		$driver->current_tire = 100;
		$driver->current_position = 0;
		$driver->current_checkpoint = 0;
		$driver->current_time_passed = 0;
		$driver->time_next_checkpoint = "0000-00-00 00:00:00";

		Drivers_model::calculate_next_checkpoint($driver, $race, $driver->current_speed);
		
		header("Location: " . base_url() . "rally/");
	    die();
	}
	
	function get_next_question() {
		$driver = $this->drivers_model->is_driver();
		//if(!$driver || $_POST['driver'] != $driver->id) {
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die();
		}
		if($driver->current_race == 0) {
			header("Location: " . base_url() . "rally_selection/");
			die();
		}
		
		$questions = Drivers_model::get_drivers_question($driver, 1, TRUE);
		
		$this->load->library('json_service');
		$result = $this->json_service->encode($questions);
		
		print_r($result);
		die();
	}
	
	function submit_vote() {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
		if($_POST['vote'] != 0 && $_POST['vote'] != 1) {
		    die("false");
		}
		
		$sql = "SELECT * FROM `votes` WHERE car_id = " . $this->db->escape($_POST['car']) . " AND user_id = " . $this->db->escape($driver->id);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    if(is_array($result) && count($result) > 0) {
	        die("false");
	    }
	    
		$sql = "INSERT INTO `votes` (car_id, user_id, type, `date`) VALUES (" . $this->db->escape($_POST['car']) . ", " . $this->db->escape($driver->id) . ", " . $this->db->escape($_POST['vote']) . ", '" . date('Y-m-d H:i:s') . "')";
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

		$driver = $this->drivers_model->is_driver();
		if(!$driver || $driver->id != $_POST['user_id']) {
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

		if($driver->car == 0) {
			$driver->car = $driver->id;
			Drivers_model::update($driver, array("car"));
		}
		
		header("Location: " . base_url() . "profile/driver/" . $_POST['user_id']);
		die();
	}
	
	function delete_vote($id) {
		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
		$id = (int) $id;
		$sql = "DELETE FROM `votes` WHERE car_id = " . $this->db->escape($id) . " AND user_id = " . $this->db->escape($driver->id);
	    $this->db->query($sql);
	    
		header("Location: " . base_url() . "profile/driver/" . $id);
		die();
	}

	function get_drivers_position($race_length = 1) {
	    $driver = $this->drivers_model->is_driver();

		if(!$driver) {
		    die("false");
		}
		if($driver->current_race == 0) {
		    die("false");
		}

		$race = Races_model::get_race($driver->current_race);
		
	    $updated_driver = Drivers_model::calculate_next_checkpoint($driver, $race, $driver->current_speed);
	
	    $lang = $this->lang->language;
	    
		$this->load->library('json_service');
		$result[0] = str_replace("X", convert_number(floor(($updated_driver->current_position / 10) / $race_length) . ""), str_replace("XX", convert_number($race_length . ""), str_replace("XXX", convert_number(floor($updated_driver->current_position / 1000) . "") , $lang['navigate_hint'])));
		$result[1] = ceil((111 * ((($updated_driver->current_position / 10) / $race->length))/100));
		
		$resultx = $this->json_service->encode($result);
		die($resultx);
	}
	
	function submit_question_answer() {
	    $driver = $this->drivers_model->is_driver();

		if(!$driver) {
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
		
	    $sql = "UPDATE `questions` SET answer = " . $this->db->escape($_POST['answer']) . ", date_answered = '" . date('Y-m-d H:i:s') . "' WHERE driver = " . $this->db->escape($driver->id) . " AND id = " . $this->db->escape($_POST['qid'] . " AND answer = 0");

	    $rt = $this->db->query($sql);
	    
	    if($rt && $result[0]['answer'] == $_POST['answer'] && $_POST['qt'] == "0") { //The answer is right!
	        switch($result[0]['advantage']) {
	            case 0:
	                $driver->current_speed += 10;
	                break;
	            case 1:
	                $driver->current_speed += 15;
	                break;
	            case 2:
	                $driver->current_speed += 25;
	                break;
	            case 3:
	                $driver->current_speed += 35;
	                break;
	        }
	        $driver->score += 20;
			$fields = array("current_speed", "score", "rally_count", "current_tire", "current_oil", "current_water", "current_tiredness", "current_fuel");
			Drivers_model::update($driver, $fields);
	    }
	    if($rt && $result[0]['answer'] == $_POST['answer'] && $_POST['qt'] == "1") { //The answer is right and the question is a challenge
	    
			$next_driver = Drivers_model::get_driver_by_id($driver->challenged);

			$next_driver->challenged = 0;
			$next_driver->challenged_time = "0000-00-00 00:00:00";
			$next_driver->challenged_question = 0;
			$next_driver->challenge_final_time = "0000-00-00 00:00:00";
			$next_driver->current_speed -= 5;
			if($next_driver->current_speed <= 0) {
				$next_driver->current_speed = 1;
			}
			$p1 = Drivers_model::update($next_driver, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));

			$driver->challenged = 0;
			$driver->challenged_time = "0000-00-00 00:00:00";
			$driver->challenged_question = 0;
			$driver->challenge_final_time = "0000-00-00 00:00:00";
			$driver->current_speed += 5;
			$p2 = Drivers_model::update($driver, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time") );
			
			if($p2 && $p1) {
			    $lang = $this->lang->language;
	    		Drivers_model::send_message($driver->id, $next_driver->id, $lang['challneglostt'], str_replace("XXX", "<a href='" . base_url() . "profile/driver/" . $driver->id . "'>" . $driver->first_name . " "  . $driver->last_name . "</a>", $lang['challneglost']));
			}
	    }
	    else if($rt && $result[0]['answer'] != $_POST['answer'] && $_POST['qt'] == 1) { //The answer is right and the question is a challenge
			$next_driver = Drivers_model::get_driver_by_id($driver->challenged);
			
			$next_driver->challenged = 0;
			$next_driver->challenged_time = "0000-00-00 00:00:00";
			$next_driver->challenged_question = 0;
			$next_driver->challenge_final_time = "0000-00-00 00:00:00";
			$next_driver->current_speed += 5;

			$p1 = Drivers_model::update($next_driver, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));

			$driver->challenged = 0;
			$driver->challenged_time = "0000-00-00 00:00:00";
			$driver->challenged_question = 0;
			$driver->challenge_final_time = "0000-00-00 00:00:00";
			$driver->current_speed -= 5;
			$p2 = Drivers_model::update($driver, array("current_speed", "challenged", "challenged_time", "challenged_question", "challenge_final_time"));
			
			if($p2 && $p1) {
				$lang = $this->lang->language;
	    		Drivers_model::send_message($driver->id, $next_driver->id, $lang['challnegwont'], str_replace("XXX", "<a href='" . base_url() . "profile/driver/" . $driver->id . "'>" . $driver->first_name . " "  . $driver->last_name . "</a>", $lang['challnegwon']));
			}
	    }
	    
	    print_r($resultx);
	    die();
	}
	
	function newsletter() {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("false");
		}
		
	    $sql = "UPDATE `users` SET newsletter = 1, score = score + 100 WHERE newsletter = 0 AND id = " . $this->db->escape($driver->id);
	    $this->db->query($sql);
	    
	    header("Location: http://www.renault.co.ir/?page=13&lang=fa");
	    die();
	}
	
	function ilikeit() {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("false");
		}
		
		$sql = "SELECT * FROM `diary_votes` WHERE diary = " . $this->db->escape($_POST['did']) . " AND driver = " . $this->db->escape($driver->id);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    if(is_array($result) && count($result) > 0) {
		    $sql = "DELETE FROM `diary_votes` WHERE diary = " . $this->db->escape($_POST['did']) . " AND driver = " . $this->db->escape($driver->id);
	    }
	    else {
		    $sql = "INSERT INTO `diary_votes` (diary, driver, type, `date`) VALUES (" . $this->db->escape($_POST['did']) . ", " . $this->db->escape($driver->id) . ", 1, '" . date("Y-m-d H:i:s") . "')";
	    }
	    
	    if($this->db->query($sql)) {
	        die("ok");
	    }
	    else {
	    	die("false");
	    }
	}
	
	function submit_diary() {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("false");
		}

		if(trim($_POST['title'], " ") == "" || trim($_POST['body'], " ") == "") {
			die("false");
		}

	    $sql = "INSERT INTO `diaries` (driver, title, body, `date`) VALUES (" . $this->db->escape($driver->id) . ", " . $this->db->escape($_POST['title']) . ", " . $this->db->escape($_POST['body']) . ", '" . date("Y-m-d H:i:s") . "')";
	    
	    if($this->db->query($sql)) {
	        die($this->db->insert_id() . "");
	    }
	    else {
	    	die("false");
	    }
	}
	
	function edit_diary() {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("false");
		}

		if(trim($_POST['title'], " ") == "" || trim($_POST['body'], " ") == "") {
			die("false");
		}

	    $sql = "UPDATE `diaries` SET title = " . $this->db->escape($_POST['title']) . ", body = " . $this->db->escape($_POST['body']) . " WHERE driver = " . $this->db->escape($driver->id) . " AND id = " . $this->db->escape($_POST['id']);

	    if($this->db->query($sql)) {
	        die("ok");
	    }
	    else {
	    	die("false");
	    }
	}
	
	function report_abuse($id) {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		
		$id = (int)$id;
		if(!$id) {
		    die("");
		}
		
		$sql = "SELECT * FROM `abuse` WHERE driver = " . $this->db->escape($id) . " AND sender = " . $this->db->escape($driver->id);
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    if(is_array($result) && count($result) > 0) {
			header("Location: " . base_url() . "message/index/13/");
		    die();
	    }
	    else {
		    $sql = "INSERT INTO `abuse` (driver, sender, `date`) VALUES (" . $this->db->escape($id) . ", " . $this->db->escape($driver->id) . ", '" . date("Y-m-d H:i:s") . "')";
		    $this->db->query($sql);
		    
			header("Location: " . base_url() . "message/index/14/");
		    die();
	    }
	}
	
	function set_drivers_car($id) {
	    $sql = "UPDATE `users` SET car = " . $this->db->escape($id) . " WHERE id = " . $this->db->escape($id);
	    $this->db->query($sql);
	    header("Location: " . base_url() . "profile/driver/" . $id);
	    die();
	}
	
	function delete_last_diary() {
	    $driver = $this->drivers_model->is_driver();
		if(!$driver) {
		    die("");
		}
		$sql = "DELETE FROM `diaries` WHERE driver = " . $this->db->escape($driver->id) . " ORDER BY id DESC LIMIT 1";
	    $result = $this->db->query($sql);

	    header("Location: " . base_url() . "rally/");
	    die();
	}
	
	function challenge() {
	    $driver = $this->drivers_model->is_driver();
		if(!isset($_POST['id']) || !$driver || $driver->challenged != 0 || $driver->id != $_POST['id']) {
		    die("false");
		}
		
		$next_driver = Drivers_model::get_next_driver($driver);
		$question = new Question(Races_model::get_challenge_question($next_driver));
		$question->alert = $question->id;
		$question->driver = $next_driver->id;
		$question->date_asked = date("Y-m-d H:i:s");
		$qid = Races_model::submit_question($question);

		if($qid) {
			$next_driver->challenged = $driver->id;
			$next_driver->challenged_time = date("Y-m-d H:i:s");
			$next_driver->challenged_question = $qid;
			$tt = date("Y-m-d H:i:s", strtotime("+10 hours"));
			$next_driver->challenge_final_time = $tt;
			Drivers_model::update($next_driver, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));
			
			$driver->challenged = $next_driver->id;
			Drivers_model::update($driver, array("challenged"));

			$lang = $this->lang->language;
			
			$body = str_replace("XXX", "<a href='" . base_url() . "profile/driver/" . $driver->id . "'>" . $driver->first_name . " "  . $driver->last_name . "</a>", $lang['challnegmsg']);
			$body = str_replace("XX", convert_number(substr($tt, -8, 5) . ", " . fa_strftime("%d %B", $tt . "")), $body);
	    	Drivers_model::send_message($driver->id, $next_driver->id, $lang['challnegmsgt'], $body);
	    	
			$tt = convert_number(substr($tt, -8, 5) . ", " . fa_strftime("%d %B", $tt . ""));
			die($tt);
		}
		die("false");
	}
	
	function cancel_challenge() {
	    $driver = $this->drivers_model->is_driver();
		if(!isset($_POST['id']) || !$driver || $driver->challenged == 0 || $driver->id != $_POST['id']) {
		    die("false");
		}

		$next_driver = new Driver(array("id" => $driver->challenged));
		
		$next_driver->challenged = 0;
		$next_driver->challenged_time = "0000-00-00 00:00:00";
		$next_driver->challenged_question = 0;
		$next_driver->challenge_final_time = "0000-00-00 00:00:00";
		$p1 = Drivers_model::update($next_driver, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));

		$driver->challenged = 0;
		$driver->challenged_time = "0000-00-00 00:00:00";
		$driver->challenged_question = 0;
		$driver->challenge_final_time = "0000-00-00 00:00:00";
		$p2 = Drivers_model::update($driver, array("challenged", "challenged_time", "challenged_question", "challenge_final_time"));
		
		$lang = $this->lang->language;

    	Drivers_model::send_message($driver->id, $next_driver->id, $lang['challnegcant'], str_replace("XXX", "<a href='" . base_url() . "profile/driver/" . $driver->id . "'>" . $driver->first_name . " "  . $driver->last_name . "</a>", $lang['challnegcan']));
    	
		if($p1 && $p2) {
			die("true");
		}
		die("false");
	}
	
	function get_challenge_question() {

		$driver = $this->drivers_model->is_driver();
		if(!$driver) {
			die("false");
		}
		if(!isset($_POST['id']) || !$driver || $driver->challenged == 0 || $driver->id != $_POST['id'] || $driver->current_race == 0 || $driver->challenged_question == 0) {
		    die("false");
		}

		$questions = Drivers_model::get_drivers_question($driver, 1, TRUE, FALSE);

		$this->load->library('json_service');
		$result = $this->json_service->encode($questions);

		print_r($result);
		die();
	}
}
