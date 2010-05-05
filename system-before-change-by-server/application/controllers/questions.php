<?php

class Questions extends Controller {

	function Questions()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
	}
	
	function index()
	{
	    $driver = $this->drivers_model->is_driver();
	    $data['driver'] = $driver;
	    
	    $data['title']		= $this->lang->language['home_title'];

		$data['header']		= '<link href="' . base_url() . 'system/application/views/layouts/style/contact/style.css" rel="stylesheet" type="text/css" />';
		
	    $data['lang']		= $this->lang->language;
	    
	    if(!isset($_POST['question']) || trim($_POST['question'], " ") == "") {
	    	$data['body']		= $this->load->view('layouts/controllers_body/question.php', $data, TRUE);
	    	$this->load->view('layouts/inside/inside.php', $data);
	    }
		else {
		    $sql = "INSERT INTO `alerts` (`message`, `question1`, `question2`, `question3`, `question4`, `answer`, `type`, `city`)
					VALUES (" . $this->db->escape($_POST['question']) . ", " . $this->db->escape($_POST['q1']) . ", " . $this->db->escape($_POST['q2']) . ", " . $this->db->escape($_POST['q3']) . ", " . $this->db->escape($_POST['q4']) . ", " . $this->db->escape($_POST['ans']) . ", " . $this->db->escape($_POST['type']) . ", " . $this->db->escape($_POST['city']) . ")";
			if($this->db->query($sql)) {
			    header("Location: " . base_url() . "questions/");
			}
			else {
			    die("ERROR!");
			}
		}
	}
}