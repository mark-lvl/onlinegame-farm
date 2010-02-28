<?php

class Message extends MainController {

	function Message()
	{
		parent::MainController();
                $this->add_css('home');
	}
	
	function index($which = "")
	{
	    if($which == "") {
	        header("Location: " . base_url());
	        die();
	    }
	    
	    $this->data['user'] = $this->user_model->is_authenticated();

	    $this->data['title'] = $this->lang->language['message_title'];

            $this->data['heading'] = '';

            $this->data['m_title'] = $this->data['lang']['m_title' . $which];

            $this->data['m_body'] = $this->data['lang']['m_body' . $which];

            $this->render('home');
	}
}
