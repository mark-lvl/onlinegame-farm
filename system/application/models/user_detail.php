<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_detail extends Main_model
{
	var $id;
	var $user_id;
	var $score;
	
	function User_entity($instant = FALSE)
	{
		if($instant) {
                    parent::instant_maker($instant);
		}
	}
}
