<?php

class Profile extends Controller {

	function Profile()
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
	
	function driver($id = "") {
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches)) {
			header("Location: " . base_url());
		    die();
	    }

	    $driver = $this->drivers_model->is_driver();

        if($driver && $driver->car == 0) {
			header("Location: " . base_url() . "design/");
		    die();
        }

	    if($id != $driver->id) {
	    	$driver_profile = $this->drivers_model->get_driver_by_id($id); //Fetch the owner of profile's information
		}
		else {
			$driver_profile = $driver;
		}
	    
	    if(!$driver_profile) {
	        header("Location: " . base_url() . "message/index/12/");
	    }
	    
	    $data['title']		= $this->lang->language['profile_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

	    $data['driver'] = $driver;
	    $data['driver_profile'] = $driver_profile;
	    
	    if(is_object($driver)) {
	    	$data['driver_car_vote'] = Drivers_model::get_drivers_vote_to_car($driver, $driver_profile->car);
	    }
	    
	    $data['car_vote'] = Drivers_model::get_car_votes($driver_profile);
		$data['car_vote'][0]['first'] = FALSE;
		
		if(!$data['car_vote'] || count($data['car_vote']) <= 0 || !$data['car_vote'][0]['avt']) {
			$data['car_vote'][0]['avt'] = 0;
			$data['car_vote'][0]['first'] = TRUE;
		}
		
	    $data['race']   = Races_model::get_race($driver_profile->current_race);
	    
	    $data['drivers_rank']   = Drivers_model::get_drivers_total_rank($driver_profile);
	    $data['drivers_ranks']  = Drivers_model::get_drivers_ranks($driver_profile);
	    
	    $data['driver_profile']->is_related = Drivers_model::is_related($driver_profile, $driver->id);

	    $data['friends']		= Drivers_model::get_friends($driver_profile);
	    
	    $data['body']		= $this->load->view('layouts/controllers_body/profile.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}