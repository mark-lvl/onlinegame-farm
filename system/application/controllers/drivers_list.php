<?php

class Drivers_list extends Controller {

	function Drivers_list()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}

	function index($page = 0, $filter = "")
	{
		if($page < 0) {
  			header("Location: " . base_url() . "drivers_list/index/0/" . $filter);
		    die();
		}

	    $data['driver'] = $this->drivers_model->is_driver();

		if($filter == "") {
	    	$data['title']		= $this->lang->language['drivers_list_title'];
		}
		else {
	    	$data['title']		= $this->lang->language['search_title'];
		}

		if($filter == "") {
	    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/drivers_list/style.css" rel="stylesheet" type="text/css" />';
		}
		else {
	    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/drivers_list/style_search.css" rel="stylesheet" type="text/css" />';
		}

		$data['filter']		= $filter;
		
	    $data['lang']		= $this->lang->language;

		$data['page']       = (int)$page;
		
		$data['cnt']		= Drivers_model::get_count_drivers($filter);
		
		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "drivers_list/index/" . floor($data['cnt'] / 6) . "/" . $filter);
		    die();
		}

		$data['tops']		= Drivers_model::get_top_drivers($data['page'],  6, $filter);
		
	    $data['body']		= $this->load->view('layouts/controllers_body/drivers_list.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
	
	function race($page = 0, $race = 0)
	{
		if($page < 0) {
  			header("Location: " . base_url() . "drivers_list/race/0/" . $filter);
		    die();
		}

		$race = Races_model::get_race((int)$race);

		if(!$race) {
  			header("Location: " . base_url());
		    die();
		}
		
	    $data['driver'] = $this->drivers_model->is_driver();

    	$data['title']		= $this->lang->language['drivers_list_title'];

    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/drivers_list/style.css" rel="stylesheet" type="text/css" />';

		$data['race']		= $race;

	    $data['lang']		= $this->lang->language;

		$data['page']       = (int)$page;

		$data['cnt']		= Drivers_model::get_total_race_drivers($race->id);

		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "drivers_list/race/" . floor($data['cnt'] / 6) . "/" . $race->id);
		    die();
		}

		$data['tops']		= Races_model::get_top_drivers_race($race->id, $data['page'], 6);
		
	    $data['body']		= $this->load->view('layouts/controllers_body/drivers_list_race.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}