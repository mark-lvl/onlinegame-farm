<?php

class Registration extends Controller {

	function Registration()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
		
		$this->load->helper('captcha');
	}
	
	function index($reason = "")
	{
	    $data['title']		= $this->lang->language['registration_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/registration/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    $data['reason']		= $reason;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/registration.php', $data, TRUE);
	    
		$this->load->view('layouts/inside/inside.php', $data);
	}
	
	function register() {
		if(!isset($_POST['ok'])) { //No direct access
		    header("Location: " . base_url() . "registration/");
		    die();
		}
		
		$_SESSION['rgkeep'] = $_POST;
		
		if(!preg_match_all("([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})", $_POST['email'], $tmp)) {
		    header("Location: " . base_url() . "registration/index/email/");
		    die();
		}
		if(trim($_POST['first_name'], " ") == "" || trim($_POST['last_name'], " ") == "" || trim($_POST['password'], " ") == "") {
		    header("Location: " . base_url() . "registration/index/fill/");
		    die();
		}
		if($_POST['day'] > 31 || $_POST['month'] > 12 || $_POST['month'] < 1 || $_POST['day'] < 1 || $_POST['year'] > 88 || $_POST['year'] < 1) {
		    header("Location: " . base_url() . "registration/index/date/");
		    die();
		}
		
		if($_SESSION['captcha'] != $_POST['captcha_val']) { //Captcha error
		    if(!isset($_SESSION['reg_error'])) {
				$_SESSION['reg_error'] = 1;
			}
			else {
				$_SESSION['reg_error']++;
			}
			if(isset($_SESSION['reg_error']) && $_SESSION['reg_error'] > 2) {
			    header("Location: " . base_url() . "registration/index/reg_error/");
			    die();
			}
			else {
		    	header("Location: " . base_url() . "registration/index/captcha/");
		    	die();
			}
		}
		
		if(isset($_SESSION['reg_error']) && $_SESSION['reg_error'] > 2) {
		    header("Location: " . base_url() . "registration/index/reg_error/");
		    die();
		}
		
		if(!$this->drivers_model->is_email_unique(trim($_POST['email'], " "))) { //email already registered
		    header("Location: " . base_url() . "registration/index/email_repeated/");
		    die();
		}

		$user = new Driver($_POST);

        if(isset($_POST['car_tt']) && trim($_POST['car_tt'], " ") != "") {
            $user->car_t = $_POST['car_tt'];
        }

		if(isset($_FILES['photo']) && is_array($_FILES['photo']) && (strtolower(substr(basename($_FILES['photo']['name']), -4)) == ".jpg" || strtolower(substr(basename($_FILES['photo']['name']), -4)) == ".jpeg")) { //Set the address
			$uploaddir = $this->config->item('upload_url');
			$name = md5(trim($_POST['email'], " ") . $this->config->item('security_code')) . substr(basename($_FILES['photo']['name']), -4);
			$uploadfile = $uploaddir . $name;
			if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
				$user->photo = $name;
			}
			else {
				$user->photo = "";
			}
		}
		else {
			$user->photo = "";
		}
		
		$dr = $this->drivers_model->register_user($user);
		if($dr) {
			$lang = $this->lang->language;
			Drivers_model::send_message(1, $dr, $lang['welcome_title'], $lang['welcome_body']);
			$_SESSION['rgkeep'] = "";
			session_destroy();
		    header("Location: " . base_url() . "message/index/1/");
		    die();
		}
		else {
		    header("Location: " . base_url() . "message/index/0/");
		    die();
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */