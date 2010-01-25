<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}
	
	function index()
	{
	    $driver = $this->drivers_model->is_driver();

	    $data['title']		= $this->lang->language['home_title'];

		$data['header']		= '';

	    $data['lang']		= $this->lang->language;

	    $data['driver'] = $driver;

		$data['top_drivers']	= Drivers_model::get_top_drivers(0, 3, $filter);
		$data['top_cars']		= Drivers_model::get_top_renault(0, 6);
		$data['body']		= '';

		$this->load->view('layouts/home/home.php', $data);
	}
}