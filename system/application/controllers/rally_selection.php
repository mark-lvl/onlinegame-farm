<?php

class Rally_selection extends Controller {

	function Rally_selection()
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

		if($driver->current_race != 0) {
  			header("Location: " . base_url() . "rally/");
		    die();
		}

	    $data['title']		= $this->lang->language['rally_selection_title'];

		$data['header']		= '<script type="text/javascript" src="' . base_url() . 'system/application/views/scripts/jquery.hints.js"></script>';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/profile/style.css" rel="stylesheet" type="text/css" />';
		$data['header']		.= '<link href="' . base_url() . 'system/application/views/layouts/style/rally_selection/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

	    $data['driver'] = $driver;
	    $data['driver_profile'] = $driver;
		$data['races'] = Races_model::get_available_races();
		
	    $data['drivers_rank']   = Drivers_model::get_drivers_total_rank($driver);
	    $data['drivers_ranks']  = Drivers_model::get_drivers_ranks($driver);
	    
	    $data['lock_stat']      = Driver::get_drivers_next_lock($driver);
		//echo('<pre style="text-align:left;direction:ltr">');print_r($driver);echo('</pre><hr>');die();
		
		$data['friends']		= Drivers_model::get_friends($driver);

	    $data['body']		= $this->load->view('layouts/controllers_body/rally_selection.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}