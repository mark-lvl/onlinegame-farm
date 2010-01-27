<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_entity extends Main_model
{
	var $id;
	var $first_name;
	var $last_name;
	var $sex;
	var $username;
	var $password;
	var $email;
	var $city = 0;
        var $birthdate;
        var $photo;
	var $registration_ip;
	var $registration_date;
	var $logins;
	var $last_login_ip;
	var $last_login_date;
	
	
	function User_entity($instant = FALSE)
	{
		if($instant) {
                    parent::instant_maker($instant);
                    $this->set_initial_birthdate();
                    $this->set_jd_birthdate();
		}
	}

	function set_initial_birthdate() {
	    if(!isset($this->year)) {
	        return NULL;
	    }
		$jd =  persian_to_jd("13" . $this->year, $this->month, $this->day);
		$gregorian_bd = jd_to_gregorian($jd);
		$this->birthdate = $gregorian_bd['year'] . "-" . $gregorian_bd['mon'] . "-" . $gregorian_bd['mday'];
	}
	
	function set_jd_birthdate() {
	    $this->jd_birthdate = fa_strftime("%d %B %Y", $this->birthdate);
	    $this->jd_birthdate2 = fa_strftime("%d %m %Y", $this->birthdate);
	}
	
//	function get_drivers_next_lock($driver) {
//		if($driver->score < 2000) {
//		    return 1;
//		}
//		else if($driver->score >= 2000 && $driver->score < 8000) {
//		    return 2;
//		}
//		else if($driver->score >= 8000 && $driver->score < 15000) {
//		    return 3;
//		}
//		return 100;
//	}
}
