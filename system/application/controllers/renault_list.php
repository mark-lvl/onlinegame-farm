<?php

class Renault_list extends Controller {

	function Renault_list()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}

	function index($page = 0)
	{
		if($data['page'] < 0) {
  			header("Location: " . base_url() . "renault_list/");
		    die();
		}
		
	    $data['driver'] = $this->drivers_model->is_driver();

	    $data['title']		= $this->lang->language['renault_list_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/renault_list/style.css" rel="stylesheet" type="text/css" />';

	    $data['lang']		= $this->lang->language;

		$data['page']       = (int)$page;

		$data['cnt']		= Drivers_model::get_count_renaults();

		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "renault_list/index/" . floor($data['cnt'] / 6));
		    die();
		}
		
		$data['tops']		= Drivers_model::get_top_renault($data['page']);

	    $data['body']		= $this->load->view('layouts/controllers_body/renault_list.php', $data, TRUE);

		$this->load->view('layouts/inside/inside.php', $data);
	}
}