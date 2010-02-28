<?php

class Profile extends MainController {

	function Profile()
	{
		parent::MainController();
                $this->load->model(array('Farm'));
                $this->add_css('login');
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
	    if($id != $user->id)
            {
                //this variable shows that this profile not for login user
                $this->data['partner'] = true;
                
	    	$user_profile = $this->user_model->get_user_by_id($id); //Fetch the owner of profile's information
            }
            else
                $user_profile = $user;
	    
	    if(!$user_profile) {
	        header("Location: " . base_url() . "message/index/12/");
	    }

            
	    
	    //TODO ghange that when layout is available.
            $this->data['title']        = $this->lang->language['profile_title'];
            $this->data['heading']        = '';
	    $this->data['user']         = $user;
            $this->data['user_profile'] = $user_profile;
	    $this->data['user_profile']->is_related = User_model::is_related($user_profile, $user->id);
            
            $farm = new Farm();
            $this->data['userFarm'] = $farm->where('user_id',$user->id)->where('disactive','0')->get();
            if($this->data['userFarm']->exists())
            {
                //TODO change that to view screenshot from village
                $this->data['farmSnapshot'] = true ;
                //$data['mainFarm'] = $this->load->view('farm/show.php', $data, TRUE);
            }
            else
                $this->data['mainFarm'] = $this->load->view('farms/register.php', $this->data, TRUE);


            if(User_model::is_related($user_profile, $user->id))
                $this->data['user_profile']->is_blocked = true;

	    $this->data['friends']     = User_model::get_friends($user_profile);

            $this->add_css('profile');
	    $this->render('profile');
	}
}
