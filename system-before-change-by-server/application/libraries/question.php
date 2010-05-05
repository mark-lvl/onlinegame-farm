<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends MY_cls
{
	var $id;
	var $race;
	var $checkpoint;
	var $driver;
	var $date_asked;
	var $answer;
	var $alert;
	var $date_answered;
	
	function Question($instant = FALSE)
	{
		if($instant) {
			parent::instant_maker($instant);
		}
	}
}