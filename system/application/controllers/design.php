<?php

class Design extends Controller {

	function Design()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index($reason = "")
	{
	    $data['driver'] = $this->drivers_model->is_driver();
	    
	    if(!$data['driver']) {
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
