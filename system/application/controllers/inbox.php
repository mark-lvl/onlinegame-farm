<?php

class Inbox extends Controller {

	function Inbox()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index()
	{
	    $driver = $this->drivers_model->is_driver();

	    if(!$driver) {
  			header("Location: " . base_url());
		    die();
	    }

	    $data['title']		= $this->lang->language['messages_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/inbox/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

	    $data['driver'] = $driver;
	    $data['driver_profile'] = $driver;
	    
	    $data['messages'] = Drivers_model::get_messages($driver);

		$data['friends']		= Drivers_model::get_friends($driver);
		
	    $data['drivers_rank']   = Drivers_model::get_drivers_total_rank($driver);
	    $data['drivers_ranks']  = Drivers_model::get_drivers_ranks($driver);
	    
		$data['unchecked'] = 0;
		if(is_array($data['messages']) && count($data['messages']) > 0) {
			foreach($data['messages'] as $x => $k) {
			    if($k['checked'] == 0) {
	                $data['unchecked']++;
			    }
			}
		}
		//echo('<pre style="text-align:left;direction:ltr">');print_r($data['messages']);echo('</pre><hr>');die();
		
	    $data['body']		= $this->load->view('layouts/controllers_body/inbox.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}