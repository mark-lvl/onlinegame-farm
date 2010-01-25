<?php

class Contact extends Controller {

	function Contact()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
	}
	
	function index()
	{
	    $driver = $this->drivers_model->is_driver();
	    $data['driver'] = $driver;
	    
	    $data['title']		= $this->lang->language['contact_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/contact/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    if(!isset($_POST['name']) || trim($_POST['name'], " ") == "") {
	    	$data['body']		= $this->load->view('layouts/controllers_body/contact.php', $data, TRUE);
	    	$this->load->view('layouts/inside/inside.php', $data);
	    }
		else {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: RenaultRally.com' . "\r\n";

			//$headers .= 'Bcc: fouad@parspake.com' . "\r\n";

			$message = "<BR /><BR />Name: " . substr(strip_tags($_POST['name']), 0, 250) . "<BR />";
			$message .= "e-mail: " . substr(strip_tags($_POST['email']), 0, 250) . "<BR /><BR />";
			$message .= "Comment: " . substr(strip_tags($_POST['comment']), 0, 5000) . "<BR />";
			
			if(mail("fouad.amiri@gmail.com", "RenaultRally.com, New contact", $message, $headers)) {
				header("Location:" . $url . "message/index/15/");
				die();
			}
			else {
				header("Location:" . $url . "message/index/16/");
				die();
			}
		}
	}
}