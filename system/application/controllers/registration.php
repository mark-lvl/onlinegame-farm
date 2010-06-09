<?php

class Registration extends MainController {

	function Registration()
	{
		parent::MainController();
		
		$this->load->helper('captcha');
                $this->loadJs('generals');
                $this->loadJs('jquery.hints');
                $this->loadJs('jquery.validationEngine-fa');
                $this->loadJs('jquery.validationEngine');
                $this->loadJs('boxy');
                $this->add_css('boxy');
                $this->add_css('home');
                $this->add_css('validation');
	}
	
	function index($reason = "")
	{
	    $this->data['title'] = $this->lang->language['registration_title'];
	    $this->data['heading'] = '';
	    $this->data['reason'] = $reason;
	    
            $this->render('home');
	}
	
	function register() {
		if(!isset($_POST['ok']))
                    redirect('registration/');

		$_SESSION['rgkeep'] = $_POST;
                
		
		if(!preg_match_all("([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})", $_POST['email'], $tmp)) 
                    redirect('registration/index/email/');

                if(trim($_POST['first_name'], " ") == "" || trim($_POST['last_name'], " ") == "" || trim($_POST['password'], " ") == "")
                    redirect('registration/index/fill/');
		
//		if( $_POST['day'] > 31   ||
//                    $_POST['month'] > 12 ||
//                    $_POST['month'] < 1  ||
//                    $_POST['day'] < 1    ||
//                    $_POST['year'] > 88  ||
//                    $_POST['year'] < 1)die('12');
//                    redirect('registration/index/date/');
		
		if($_SESSION['captcha'] != $_POST['captcha_val']) { 
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
		
		if(!$this->user_model->is_email_unique(trim($_POST['email'], " "))) { //email already registered
		    header("Location: " . base_url() . "registration/index/email_repeated/");
		    die();
		}

		$user = new User_entity($_POST);


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
		
		$dr = $this->user_model->register_user($user);
		if($dr) {
			$lang = $this->lang->language;
			User_model::send_message(1, $dr, $lang['welcome_title'], $lang['welcome_body']);
			$_SESSION['rgkeep'] = "";
			
                        $user = $this->user_model->log_in($_POST['email'],$_POST['password']);
                        $_SESSION['user'] = $user;
                        
                        redirect(base_url()."profile/user/".$user->id);
                        //header("Location: " . base_url() . "message/index/1/");
		    //die();
		}
		else {
		    header("Location: " . base_url() . "message/index/0/");
		    die();
		}
	}

        function invite($hash)
        {
            $user_id = $this->user_model->accept_invitation($hash);
            if($user_id)
            {
                $this->load->model(array('Farm'));
                $frmMdl = new Farm();
                $farm_id = $frmMdl->invite_successfull($user_id);
                if($farm_id)
                        $this->user_model->add_notification($farm_id,$this->lang->language['inviteBonus'], 4);
            }
            redirect('registration/');
        }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */