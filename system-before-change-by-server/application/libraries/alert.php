<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert extends MY_cls
{
	var $id;
	var $title;
	var $message;
	var $question1;
	var $question2;
	var $question3;
	var $question4;
	var $type;
	var $status;
	var $answer;
	var $advantage;
	var $advantage_value;
	var $city;

	function Alert($instant = FALSE)
	{
		if($instant) {
			parent::instant_maker($instant);
		}
	}
}