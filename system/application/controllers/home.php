<?php

class Home extends MainController {

	function Home()
	{
		parent::MainController();
                $this->loadJs('generals');
                $this->add_css('home');
                $this->add_css('login');
                $this->load->model(array('Farm','Userrank'));
	}
	
	function index($reason = null)
	{
	    $user = $this->user_model->is_authenticated();

            $frmMdl = new Farm();
            $this->data['allExistsFarm'] = $frmMdl->allExistsFarm();

            $usrRnkMdl = new Userrank();
            $this->data['bestUsers'] = $usrRnkMdl->getBestUser();

	    $this->data['title']  = $this->lang->language['home_title'];

            $this->data['heading'] = '';
            
            $this->data['user'] = $user;

            
            if(isset($reason))
            {
                $this->data['reason'] = $reason;
            }
                

            $this->loadJs('jquery.hints');
            $this->loadJs('boxy');
            $this->add_css('boxy');

	    $this->render('home');
	}

        function getNewestUser()
        {echo '1';
            //$this->data['users'] = $this->user_model->get_newest_users($_POST['offset']);
            //$this->data['page'] = $offset;
            //$this->load->view("home/topUser.tpl.php", $this->data);
        }
}
