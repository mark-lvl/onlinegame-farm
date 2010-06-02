<?php

class Home extends MainController {

	function Home()
	{
		parent::MainController();
                $this->loadJs('generals');
                $this->add_css('home');
                $this->add_css('login');
                $this->load->model(array('Farm','Userrank'));
	}
	
	function index()
	{
	    $user = $this->user_model->is_authenticated();

            $this->loadJs('jquery.hints');

            $frmMdl = new Farm();
            $this->data['allExistsFarm'] = $frmMdl->allExistsFarm();

            $usrRnkMdl = new Userrank();
            $this->data['bestUsers'] = $usrRnkMdl->getBestUser();
            //TODO az inja bebado baiad anjam bedam

	    $this->data['title']  = $this->lang->language['home_title'];

            $this->data['heading'] = '';
            
            $this->data['user'] = $user;

	    $this->render('home');
	}
}
