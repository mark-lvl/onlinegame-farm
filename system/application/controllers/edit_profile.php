<?php

class Edit_profile extends MainController {

	function Edit_profile()
	{
		parent::MainController();
	}
	
	function index($reason = "")
	{
	    $user = $this->user_model->is_authenticated();
	    if(!$user) {
  			header("Location: " . base_url());
		    die();
	    }

	    $data['title']		= $this->lang->language['edit_title'];
            $data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/edit_profile/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang'] = $this->lang->language;

	    $data['user'] = $user;
	    $data['user_profile'] = $user;
	    
	    
	    $data['friends'] = user_model::get_friends($user);
	    
	    $data['reason']     = $reason;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/edit_profile.php', $data, TRUE);
	    
            $this->load->view('layouts/inside/inside.php', $data);
	}
	
	function register() {
	    $user = $this->user_model->is_authenticated();

//var_dump($user);exit;
	    if(!$user) {
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

		if($_POST['email'] != $user->email) {
			if(!$this->user_model->is_email_unique(trim($_POST['email'], " "))) { //email already registered
			    header("Location: " . base_url() . "edit_profile/index/email_repeated/");
			    die();
			}
		}
		
		if(isset($_POST['password']) && $_POST['password'] != "" && md5($_POST['password']) != $user->password) {
		    header("Location: " . base_url() . "edit_profile/index/password/");
		    die();
		}
		
		if(isset($_POST['password']) && $_POST['password'] != "" && $_POST['new_password'] != $_POST['repassword']) {
		    header("Location: " . base_url() . "edit_profile/index/password/");
		    die();
		}
		
		$userHolder = new user_entity($_POST);
		
    		$user->first_name	= $userHolder->first_name;
		$user->last_name	= $userHolder->last_name;
		$user->email		= $userHolder->email;
		$user->sex		= $userHolder->sex;
		$user->birthdate	= $userHolder->birthdate;
		$user->city	= $user->city;
		$fields = array("first_name", "last_name", "email", "sex", "birthdate", "city");
		
		if(isset($_POST['password']) && $_POST['password'] != "") {
		    $user->password = md5($_POST['password']);
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
			$user->photo	= $user->photo;
		}
		else {
			$user->photo = "";
		}
		
		if($this->user_model->update($user, $fields)) {
		    header("Location: " . base_url() . "profile/user/" . $user->id);
		    die();
		}
		else {
		    header("Location: " . base_url() . "edit_profile/index/reg_error/");
		    die();
		}
	}
}
