<?php

class Message extends MainController {

	function Message()
	{
		parent::MainController();
	}
	
	function index($which = "")
	{
	    if($which == "") {
	        header("Location: " . base_url());
	        die();
	    }
	    
	    $data['user'] = $this->user_model->is_authenticated();

	    $data['title']		= $this->lang->language['message_title'];

            $data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/message/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

            $data['m_title'] = $data['lang']['m_title' . $which];

            $data['m_body'] = $data['lang']['m_body' . $which];

	    $data['body']  = $this->load->view('layouts/controllers_body/message.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}
