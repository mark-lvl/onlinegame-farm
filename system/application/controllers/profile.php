<?php

class Profile extends MainController {

	function Profile()
	{
		parent::MainController();
                $this->load->model(array('Farm'));
	}
	
	function index()
	{
		header("Location: " . base_url());
	    die();
	}
	
	function user($id = "")
        {
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches)) {
			header("Location: " . base_url());
		    die();
	    }

	    $user = $this->user_model->is_authenticated();
	    if($id != $user->id) {
	    	$user_profile = $this->user_model->get_user_by_id($id); //Fetch the owner of profile's information
		}
		else {
			$user_profile = $user;
		}
	    
	    if(!$user_profile) {
	        header("Location: " . base_url() . "message/index/12/");
	    }

            
	    
	    //TODO ghange that when layout is available.
            $data['title']        = $this->lang->language['profile_title'];
	    $data['header']       = '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
	    $data['header']      .= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
            $data['lang']         = $this->lang->language;
	    $data['user']         = $user;
            $data['user_profile'] = $user_profile;
	    $data['user_profile']->is_related = User_model::is_related($user_profile, $user->id);
            
            $farm = new Farm();
            $userFarm = $farm->where('user_id',$user->id)->where('disactive','0')->get();
            if($userFarm->exists())
            {
                //TODO change that to view screenshot from village
                $data['mainFarm'] = "You have a farm";
                //$data['mainFarm'] = $this->load->view('farm/show.php', $data, TRUE);
            }
            else
                $data['mainFarm'] = $this->load->view('farm/register.php', $data, TRUE);


            if(User_model::is_related($user_profile, $user->id))
                $data['user_profile']->is_blocked = true;

	    $data['friends']     = User_model::get_friends($user_profile);
	    $data['body']	 = $this->load->view('layouts/controllers_body/profile.php', $data, TRUE);

	    $this->load->view('layouts/inside/inside.php', $data);
	}
}
