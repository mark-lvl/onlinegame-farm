<?php

class Inbox extends MainController {

	function Inbox()
	{
		parent::MainController();
	}
	
	function index()
	{
	    $user = $this->user_model->is_authenticated();

	    if(!$user) {
  			header("Location: " . base_url());
		    die();
	    }

	    $data['title']		= $this->lang->language['messages_title'];

            $data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/inbox/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

	    $data['user'] = $user;
	    $data['user_profile'] = $user;
	    
	    $data['messages'] = user_model::get_messages($user);

            $data['friends'] = user_model::get_friends($user);
		
	    //$data['users_rank']   = user_model::get_users_total_rank($user);
	    //$data['users_ranks']  = user_model::get_users_ranks($user);
	    
		$data['unchecked'] = 0;
		if(is_array($data['messages']) && count($data['messages']) > 0) {
			foreach($data['messages'] as $x => $k) {
			    if($k['checked'] == 0) {
	                $data['unchecked']++;
			    }
			}
		}
		
	    $data['body'] = $this->load->view('layouts/controllers_body/inbox.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}