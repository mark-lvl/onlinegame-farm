<?php

class Users extends MainController {

        const ITEMPERPAGE = 8;

        public function __construct()
        {
            parent::__construct();
        }

	function find($page = 0, $filter = "")
	{
                $this->data['controllerName'] = 'users';
                
		$page = (int) $_POST['page'];
                if($page <= 0)
                    $page = 1;

		if(!$_POST['pagination'])
                {
                    $this->data['page']  = 1;
                    $this->data['cnt'] = $this->user_model->get_count_users($_POST['filter']);
                    $this->data['parse'] = $_POST['filter'];

                    $this->data['items'] = $this->user_model->get_top_users($data['page'],  self::ITEMPERPAGE, $_POST['filter']);

                    $this->load->view("partials/search.tpl.php", $this->data);
                }
                else
                {
                    $lastPage = ceil($_POST['cnt']/self::ITEMPERPAGE);
                    if($page > $lastPage)
                        $page = $lastPage;

                    $this->data['page']  = $page;

                    $this->data['cnt'] = $_POST['cnt'];
                    
                    $this->data['items'] = $this->user_model->get_top_users($page,  self::ITEMPERPAGE, $_POST['filter']);

                    $this->load->view("users/search-inner.tpl.php", $this->data);
                }
	}
}