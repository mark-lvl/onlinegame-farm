<?php

class Prize extends Controller {

	function Prize()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('prize', get_lang());
		$this->load->language('labels', get_lang());
	}
	
	function index()
	{
	    $driver = $this->drivers_model->is_driver();
	    $data['driver'] = $driver;
	    
	    $data['title']		= $this->lang->language['prize_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/prize/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/prize.php', $data, TRUE);
	    
		$this->load->view('layouts/inside/inside.php', $data);
	}
}