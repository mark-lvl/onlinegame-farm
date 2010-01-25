<?php

class Friends extends Controller {

	function Friends()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}

	function index()
	{
		header("Location: " . base_url());
	    die();
	}
	
	function all($id = "")
	{
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches)) {
			header("Location: " . base_url());
		    die();
	    }

	    $driver = $this->drivers_model->is_driver();
	    if($id != $driver->id) {
	    	$driver_profile = $this->drivers_model->get_driver_by_id($id); //Fetch the owner of profile's information
		}
		else {
			$driver_profile = $driver;
		}

	    if(!$driver_profile) {
	        die("Not found!");
	    }

	    $data['title']		= $this->lang->language['friends_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/friends/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']			= $this->lang->language;

	    $data['driver'] 		= $driver;
	    $data['driver_profile'] = $driver_profile;
	    $data['friends']		= Drivers_model::get_friends($driver_profile);
	    $data['friends_mine']	= Drivers_model::get_friends($driver);
	    $data['driver_profile']->is_related = Drivers_model::is_related($driver_profile, $driver->id);
	    
	    $data['drivers_rank']   = Drivers_model::get_drivers_total_rank($driver_profile);
	    $data['drivers_ranks']  = Drivers_model::get_drivers_ranks($driver_profile);
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/friends.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}