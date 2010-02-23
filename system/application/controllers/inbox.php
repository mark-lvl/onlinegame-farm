<?php
class Inbox extends MainController {

	function Inbox()
	{
		parent::MainController();
                $this->add_css('profile');
                $this->add_css('inbox');
                $this->loadJs('jquery.hints');
	}
	
	function index()
	{
	    $user = $this->user_model->is_authenticated();

	    if(!$user) 
  		redirect('/');
	    

	    $this->data['title'] = $this->lang->language['messages_title'];
//            $this->data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
//            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
//            $data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/inbox/style.css" rel="stylesheet" type="text/css" />';

	    $this->data['user'] = $user;
	    $this->data['user_profile'] = $user;
	    
	    $this->data['messages'] = user_model::get_messages($user);

            $this->data['friends'] = user_model::get_friends($user);
	    
		$this->data['unchecked'] = 0;
		if(is_array($this->data['messages']) && count($this->data['messages']) > 0) {
			foreach($this->data['messages'] as $x => $k) {
			    if($k['checked'] == 0) {
	                $this->data['unchecked']++;
			    }
			}
		}
	    
	    $this->render('profile');
	}
}