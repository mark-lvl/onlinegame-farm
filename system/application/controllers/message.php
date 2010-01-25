<?php

class Message extends Controller {

	function Message()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index($which = "")
	{
	    if($which == "") {
	        header("Location: " . base_url());
	        die();
	    }
	    
	    $data['driver'] = $this->drivers_model->is_driver();

	    $data['title']		= $this->lang->language['message_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/message/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

        $data['m_title'] 	= $data['lang']['m_title' . $which];
        $data['m_body'] 	= $data['lang']['m_body' . $which];

	    $data['body']		= $this->load->view('layouts/controllers_body/message.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}