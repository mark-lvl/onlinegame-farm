<?php

class Home extends MainController {

        const PASSWORDLENGTH = 6;
        const ADMINEMAIL = "markteams@gmail.com";

	function Home()
	{
		parent::MainController();
                $this->loadJs('generals');
                $this->add_css('home');
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

            $this->data['title'] = $this->lang->language['home_title'];
            $this->loadJs('jquery.hints');
            $this->loadJs('boxy');
            $this->add_css('boxy');

	    $this->render('home');
	}

        function help()
        {
	    $this->data['user'] = $this->user_model->is_authenticated();
            $this->data['title'] = $this->lang->language['helpPage'];
            $this->data['heading'] = '';
            $this->render('home');
        }

        function contact()
        {
            $this->data['user'] = $this->user_model->is_authenticated();
            if(!isset($_POST['name']) || trim($_POST['name'], " ") == "") {
                $this->data['title'] = $this->lang->language['contact'];
                $this->data['heading'] = '';
	    	$this->render('home');
	    }
            else {
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: yummy.com' . "\r\n";

                    $message = "<BR /><BR />Name: " . substr(strip_tags($_POST['name']), 0, 250) . "<BR />";
                    $message .= "e-mail: " . substr(strip_tags($_POST['email']), 0, 250) . "<BR /><BR />";
                    $message .= "Description: " . substr(strip_tags($_POST['body']), 0, 5000) . "<BR />";

                    if(mail(self::ADMINEMAIL, "yummy.com, New contact", $message, $headers))
                            redirect(base_url()."message/index/15/");
                    else
                            redirect(base_url()."message/index/16/");
            }
        }



        function forgot($data = null)
        {
	    $this->data['user'] = $this->user_model->is_authenticated();
            if($_POST['email'] != "")
            {
                $user = $this->user_model->get_user_by_mail($_POST['email']);
                if($user)
                {
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: yummy.com' . "\r\n";

                    //password GENERATOR
                    $length = self::PASSWORDLENGTH;
                    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
                    $string = "";
                    for ($p = 0; $p < $length; $p++) {
                        $string .= $characters[mt_rand(0, strlen($characters))];
                    }

                    $message = str_replace(array('__USER__','__PASSWORD__'), array($user->first_name." ".$user->last_name,$string), $this->lang->language['forgotPassMail']);
                    if(mail($user->email, 'Forgotten Password From Yummy', $message,$headers))
                    {
                        $fields = array('password');
                        $user->password = md5($string);
                        $this->user_model->update($user,$fields);

                        redirect(base_url() . "message/index/20/");
                    }

                }
                else
                {
                    redirect(base_url() . "message/index/19/");
                }
            }

            $this->data['title'] = $this->lang->language['forgotPassword'];
            $this->data['heading'] = '';
            $this->render('home');

        }


}