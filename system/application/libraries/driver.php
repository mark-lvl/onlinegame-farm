<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends MY_cls
{
	var $id;
	var $first_name;
	var $last_name;
	var $sex;
	var $password;
	var $email;
	var $photo;
	var $score;
	var $car;
	var $car_t;
	var $birthdate;
	var $jd_birthdate;
	var $jd_birthdate2;
	var $registration_date;
	var $current_race;
	var $current_speed;
	var $current_tire;
	var $current_fuel;
	var $current_oil;
	var $current_water;
	var $current_tiredness;
	var $time_next_checkpoint;
	var $nitro_count;
	var $nitro_status;
	var $mountain_lock_stat;
	var $desert_lock_stat;
	var $jungle_lock_stat;
	var $city_lock_stat;
	var $car_lock_stat;
	var $last_status_update;
	var $current_position;
	var $current_time_passed;
	var $car_type;
	var $rally_count;
	var $newsletter = 0;
	var $final_time = 0;
	var $challenged = 0;
	var $challenged_time;
	var $challenged_question = 0;
	var $challenge_final_time = 0;
	var $city = 0;
	
	function Driver($instant = FALSE)
	{
		if($instant) {
			parent::instant_maker($instant);
			$this->set_initial_birthdate();
			$this->set_jd_birthdate();
			if($this->current_speed < 1) {
				$this->current_speed = 1;
			}
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
	
	function get_drivers_next_lock($driver) {
		if($driver->score < 2000) {
		    return 1;
		}
		else if($driver->score >= 2000 && $driver->score < 8000) {
		    return 2;
		}
		else if($driver->score >= 8000 && $driver->score < 15000) {
		    return 3;
		}
		return 100;
	}
}