<?php

class Rally extends Controller {

	function Rally()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index($id = 0)
	{
		$id = (int) $id;
	    $driver = $this->drivers_model->is_driver();

		if(!$driver) {
			header("Location: " . base_url() . "message/index/17/");
			die("false");
		}
		if($driver->current_race == 0) {
  			header("Location: " . base_url() . "rally_selection/");
		    die("");
		}
		
	    if($id != $driver->id && $id != 0) {
	    	$driver_profile = $this->drivers_model->get_driver_by_id($id);
		}
		else {
			$driver_profile = $driver;
		}
		
		$race = Races_model::get_race($driver_profile->current_race);
		$checkpoint = Races_model::get_checkpoint($driver_profile->current_checkpoint);
		
	    if($id == $driver->id || $id == 0) {
	    	$next_speed = Drivers_model::get_next_speed($driver_profile, $race, $checkpoint);
	    	Drivers_model::calculate_next_checkpoint($driver_profile, $race, $next_speed);
		}
		$questions = Drivers_model::get_drivers_question_number($driver_profile);
		
	    $data['title']		= $this->lang->language['rally_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/rally/style.css" rel="stylesheet" type="text/css" />';
		$data['header']		.= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<script src="' . base_url() . 'system/application/views/scripts/jquery.scrollTo-1.4.2-min.js"></script>';


	    $data['lang']		= $this->lang->language;

	    $data['driver'] = $driver;
	    $data['driver_profile'] = $driver_profile;
	    
	    $data['diary']  = Drivers_model::get_last_diary($driver_profile);
	    $data['diary_votes']  = Drivers_model::get_diary_votes($data['diary'][0]['id']);
	    
	    if($driver->id != $driver_profile->id) {
	    	$data['diary_vote']  = Drivers_model::get_diary_vote($data['diary'][0]['id'], $driver);
	    }
	    
	    $data['race'] = $race;
	    $data['checkpoint'] = $checkpoint;
	    $data['questions'] = $questions;
		$data['rank']       = Drivers_model::get_drivers_rank_in_race($driver_profile);
		
		if($data['rank'] > 1 && $driver_profile->challenged == 0) { //Get next driver
			$data['challenge']['profile']	= Drivers_model::get_next_driver($driver_profile);
			$data['challenge']['type']  	= 1;
		}
		else if($driver_profile->challenged != 0 && $driver_profile->challenged_question == 0) { //Driver has already challenged a driver
			$data['challenge']['profile'] = Drivers_model::get_driver_by_id($driver_profile->challenged);
			$data['challenge']['type']  	= 2;
			//$data['challenge']['question'] 	= Races_model::;
		}
		else if($driver_profile->challenged != 0 && $driver_profile->challenged_question != 0) { //Driver is challenged!
			$data['challenge']['profile'] = Drivers_model::get_driver_by_id($driver_profile->challenged);
			$data['challenge']['type']  	= 3;
			//$data['challenge']['question'] 	= Races_model::;
		}
		
	    $data['body']		= $this->load->view('layouts/controllers_body/rally.php', $data, TRUE);
	    
        $data['hide_header'] = TRUE;
		$this->load->view('layouts/inside/inside.php', $data);
	}
}