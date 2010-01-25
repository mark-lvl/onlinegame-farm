<?php

class Edit_profile extends Controller {

	function Edit_profile()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index($reason = "")
	{
	    $driver = $this->drivers_model->is_driver();

	    if(!$driver) {
  			header("Location: " . base_url());
		    die();
	    }

	    $data['title']		= $this->lang->language['edit_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/edit_profile/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

	    $data['driver'] 		= $driver;
	    $data['driver_profile'] = $driver;
	    
	    $data['drivers_rank']   = Drivers_model::get_drivers_total_rank($driver);
	    $data['drivers_ranks']  = Drivers_model::get_drivers_ranks($driver);
	    
	    $data['friends']		= Drivers_model::get_friends($driver);
	    
	    $data['reason']     = $reason;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/edit_profile.php', $data, TRUE);
	    
		$this->load->view('layouts/inside/inside.php', $data);
	}
	
	function register() {
	    $driver = $this->drivers_model->is_driver();

	    if(!$driver) {
  			header("Location: " . base_url());
		    die();
	    }
		
		if(!isset($_POST['ok'])) { //No direct access
		    header("Location: " . base_url() . "edit_profile/");
		    die();
		}

		if(!preg_match_all("([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})", $_POST['email'], $tmp)) {
		    header("Location: " . base_url() . "edit_profile/index/email/");
		    die();
		}
		if(trim($_POST['first_name'], " ") == "" || trim($_POST['last_name'], " ") == "") {
		    header("Location: " . base_url() . "edit_profile/index/fill/");
		    die();
		}
		if($_POST['day'] > 31 || $_POST['month'] > 12 || $_POST['month'] < 1 || $_POST['day'] < 1 || $_POST['year'] > 88 || $_POST['year'] < 1) {
		    header("Location: " . base_url() . "edit_profile/index/date/");
		    die();
		}

		if($_POST['email'] != $driver->email) {
			if(!$this->drivers_model->is_email_unique(trim($_POST['email'], " "))) { //email already registered
			    header("Location: " . base_url() . "edit_profile/index/email_repeated/");
			    die();
			}
		}
		
		if(isset($_POST['password']) && $_POST['password'] != "" && md5($_POST['password']) != $driver->password) {
		    header("Location: " . base_url() . "edit_profile/index/password/");
		    die();
		}
		
		if(isset($_POST['password']) && $_POST['password'] != "" && $_POST['new_password'] != $_POST['repassword']) {
		    header("Location: " . base_url() . "edit_profile/index/password/");
		    die();
		}
		
		$user = new Driver($_POST);
		
		$driver->first_name	= $user->first_name;
		$driver->last_name	= $user->last_name;
		$driver->email		= $user->email;
		$driver->sex		= $user->sex;
		$driver->car_t		= $user->car_t;
		$driver->birthdate	= $user->birthdate;
		$driver->city	= $user->city;
		
        if(isset($_POST['car_tt']) && trim($_POST['car_tt'], " ") != "") {
            $driver->car_t = $_POST['car_tt'];
        }
        
		$fields = array("first_name", "last_name", "email", "sex", "car_t", "birthdate", "city");
		
		if(isset($_POST['password']) && $_POST['password'] != "") {
		    $driver->password = md5($_POST['password']);
		    $fields[] = "password";
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
			$fields[] = "photo";
			$driver->photo	= $user->photo;
		}
		else {
			$user->photo = "";
		}
		
		if($this->drivers_model->update($driver, $fields)) {
		    header("Location: " . base_url() . "profile/driver/" . $driver->id);
		    die();
		}
		else {
		    header("Location: " . base_url() . "edit_profile/index/reg_error/");
		    die();
		}
	}
}