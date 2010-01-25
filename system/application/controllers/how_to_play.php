<?php

class How_to_play extends Controller {

	function How_to_play()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('how_to_play', get_lang());
		$this->load->language('labels', get_lang());
	}
	
	function index()
	{
		$driver = $this->drivers_model->is_driver();
		$data['driver'] = $driver;
		
	    $data['title']		= $this->lang->language['htp_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/how_to_play/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/how_to_play.php', $data, TRUE);
	    
		$this->load->view('layouts/inside/inside.php', $data);
	}
}