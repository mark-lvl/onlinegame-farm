<?php

class Home extends MainController {

	function Home()
	{
		parent::MainController();
                $this->loadJs('generals');
                $this->add_css('home');
                $this->add_css('login');
	}
	
	function index()
	{
	    $user = $this->user_model->is_authenticated();

	    $this->data['title']  = $this->lang->language['home_title'];

            $this->data['heading'] = '';
            
            $this->data['user'] = $user;

	    $this->render('home');
	}
}
