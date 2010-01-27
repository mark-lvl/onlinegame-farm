<?php

class Design extends MainController {

	function Design()
	{
		parent::MainController();
	}
	
	function index($reason = "")
	{
	    $data['user'] = $this->user_model->is_authenticated();
	    
	    if(!$data['user']) {
  			header("Location: " . base_url());
		    die();
	    }

	    $data['title']		= $this->lang->language['design_title'];

	    $data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/design/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/design.php', $data, TRUE);
	    
		$this->load->view('layouts/inside/inside.php', $data);
	}
}
