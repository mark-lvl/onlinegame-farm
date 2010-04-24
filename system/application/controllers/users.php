<?php

class Users extends MainController {

	function find($page = 0, $filter = "")
	{
            //TODO this method must be cleanup
		if($page < 0) 
                {
                        redirect("users/find/0/" . $filter);
		}
                
                //TODO must edit this section for check user_profile==user
                $user = $this->user_model->is_authenticated();
                $this->data['user_profile'] = $user;
                $this->data['user']         = $user;

		if($filter == "") 
                    $this->data['title'] = $this->lang->language['drivers_list_title'];
		else 
                    $data['title'] = $this->lang->language['search_title'];
		
		if($filter != "")
                    $this->add_css('style_search');

		$this->data['filter'] = $filter;
		$this->data['page']  = (int)$page;
		$this->data['cnt'] = Drivers_model::get_count_drivers($filter);

		if($data['page'] > floor($data['cnt'] / 6)) {
  			header("Location: " . base_url() . "users_list/index/" . floor($data['cnt'] / 6) . "/" . $filter);
		    die();
		}

		//$this->data['tops']		= Drivers_model::get_top_users($data['page'],  6, $filter);
		
                $this->load->view("profile/search.tpl.php", $this->data);
                
                //$this->add_css('profile');
                //$this->render('profile');
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