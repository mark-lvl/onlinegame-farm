<?php

class Users_list extends MainController {

	function Users_list()
	{
		parent::MainController();
	}

	function index($page = 0, $filter = "")
	{
		if($page < 0) {
  			header("Location: " . base_url() . "users_list/index/0/" . $filter);
		    die();
		}

	    $data['user'] = $this->user_model->is_authenticated();

		if($filter == "") {
	    	$data['title']		= $this->lang->language['users_list_title'];
		}
		else {
	    	$data['title']		= $this->lang->language['search_title'];
		}

		if($filter == "") {
	    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/users_list/style.css" rel="stylesheet" type="text/css" />';
		}
		else {
	    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/users_list/style_search.css" rel="stylesheet" type="text/css" />';
		}

		$data['filter']		= $filter;
		
	    $data['lang']		= $this->lang->language;

		$data['page']       = (int)$page;
		
		$data['cnt']		= user_model::get_count_users($filter);
		
		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "users_list/index/" . floor($data['cnt'] / 6) . "/" . $filter);
		    die();
		}

		$data['tops']		= user_model::get_top_users($data['page'],  6, $filter);
		
	    $data['body']		= $this->load->view('layouts/controllers_body/users_list.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
	
	function race($page = 0, $race = 0)
	{
		if($page < 0) {
  			header("Location: " . base_url() . "users_list/race/0/" . $filter);
		    die();
		}

		$race = Races_model::get_race((int)$race);

		if(!$race) {
  			header("Location: " . base_url());
		    die();
		}
		
	    $data['user'] = $this->user_model->is_user();

    	$data['title']		= $this->lang->language['users_list_title'];

    	$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/users_list/style.css" rel="stylesheet" type="text/css" />';

		$data['race']		= $race;

	    $data['lang']		= $this->lang->language;

		$data['page']       = (int)$page;

		$data['cnt']		= user_model::get_total_race_users($race->id);

		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "users_list/race/" . floor($data['cnt'] / 6) . "/" . $race->id);
		    die();
		}

		$data['tops']		= Races_model::get_top_users_race($race->id, $data['page'], 6);
		
	    $data['body']		= $this->load->view('layouts/controllers_body/users_list_race.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}