<?php

class Home extends MainController {

	function Home()
	{
		parent::MainController();
	}
	
	function index()
	{
	    $user = $this->user_model->is_authenticated();

	    $data['title']  = $this->lang->language['home_title'];

            $data['header'] = '';

	    $data['lang']  = $this->lang->language;
	
            $data['user'] = $user;
            
            $data['top_users'] = user_model::get_top_users(0, 3, $filter);;

            $data['body'] = '';

            $this->load->view('layouts/home/home.php', $data);
	}
}
