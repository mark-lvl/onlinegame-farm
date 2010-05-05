<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Race extends MY_cls
{
	var $id;
	var $min_score;
	var $min_race;
	var $max_speed;
	var $name;
	var $type;
	var $date_start;
	var $date_end;
	var $maximum_time;
	var $checkpoints;
	var $status;
	var $start_speed;

	function Race($instant = FALSE)
	{
		if($instant) {
			parent::instant_maker($instant);
		}
	}
	function register($race) {
	    return Races_model::register($race);
	}
	
	function create_race($type) {
	    $race = new Race();
        $race->type = $type;
        $race->date_start = date("Y-m-d 00:00:01", strtotime("next Friday"));
        $race->maximum_time = "259200";
        $race->date_end = date("Y-m-d 00:00:01", strtotime("next Friday +7 days +" . $race->maximum_time . " seconds"));
        $race->status = "1";
	    switch ($type) {
	    
			/*
				City
			*/
	        case 111:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "بندرعباس-بوشهر";
	            break;
	        case 112:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "ایلام-امیدیه";
	            break;
	        case 113:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "تهران-مشهد";
	            break;
	        case 121:
	            $race->min_score = 8000;
	            $race->min_race = 11;
	            $race->max_speed = 90;
	            $race->start_speed = 40;
	            $race->length = 1500;
	            $race->name = "مریوان-کازرون";
	            break;
	        case 122:
	            $race->min_score = 8000;
	            $race->min_race = 11;
	            $race->max_speed = 90;
	            $race->start_speed = 40;
	            $race->length = 1500;
	            $race->name = "اصفهان-تهران";
	            break;
	        case 123:
	            $race->min_score = 8000;
	            $race->min_race = 11;
	            $race->max_speed = 90;
	            $race->start_speed = 40;
	            $race->length = 1500;
	            $race->name = "یزد-قزوین";
	            break;
	        case 131:
	            $race->min_score = 20000;
	            $race->min_race = 12;
	            $race->max_speed = 100;
	            $race->start_speed = 40;
	            $race->length = 2000;
	            $race->name = "تهران-تهران";
	            break;

			/*
				Mountain
			*/
	        case 211:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "شهرکرد-اردکان";
	            break;
	        case 212:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "فیروزکوه-طالقان";
	            break;
	        case 213:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "کرمانشاه-خرم آباد";
	            break;
	        case 221:
	            $race->min_score = 8000;
	            $race->min_race = 21;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "دماوند-زنجان";
	            break;
	        case 222:
	            $race->min_score = 8000;
	            $race->min_race = 21;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "خرم آباد-شلمزار";
	            break;
	        case 223:
	            $race->min_score = 8000;
	            $race->min_race = 21;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "نهاوند-الیگودرز";
	            break;
	        case 231:
	            $race->min_score = 20000;
	            $race->min_race = 22;
	            $race->max_speed = 80;
	            $race->start_speed = 60;
	            $race->length = 2000;
	            $race->name = "همدان-شلمزار";
	            break;
	            
			/*
				Jungle
			*/
	        case 311:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "آستارا-اردبیل";
	            break;
	        case 312:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "بابلسر-لنگرود";
	            break;
	        case 313:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 60;
	            $race->start_speed = 40;
	            $race->length = 800;
	            $race->name = "گرگان-سراب";
	            break;
	        case 321:
	            $race->min_score = 8000;
	            $race->min_race = 31;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "گنبدکاووس-رودبار";
	            break;
	        case 322:
	            $race->min_score = 8000;
	            $race->min_race = 31;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "ساری-ارومیه";
	            break;
	        case 323:
	            $race->min_score = 8000;
	            $race->min_race = 31;
	            $race->max_speed = 70;
	            $race->start_speed = 50;
	            $race->length = 1500;
	            $race->name = "نور-سقز";
	            break;
	        case 331:
	            $race->min_score = 20000;
	            $race->min_race = 32;
	            $race->max_speed = 80;
	            $race->start_speed = 60;
	            $race->length = 2000;
	            $race->name = "شاهرود-سقز";
	            break;
	            
			/*
				Desert
			*/
	        case 411:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 60;
	            $race->length = 800;
	            $race->name = "دلیجان-اردکان";
	            break;
	        case 412:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 60;
	            $race->length = 800;
	            $race->name = "جیرفت-فردوس";
	            break;
	        case 413:
	            $race->min_score = 0;
	            $race->min_race = 0;
	            $race->max_speed = 80;
	            $race->start_speed = 60;
	            $race->length = 800;
	            $race->name = "کرمان-نیشابور";
	            break;
	        case 421:
	            $race->min_score = 8000;
	            $race->min_race = 41;
	            $race->max_speed = 95;
	            $race->start_speed = 70;
	            $race->length = 1500;
	            $race->name = "بم-نیشابود";
	            break;
	        case 422:
	            $race->min_score = 8000;
	            $race->min_race = 41;
	            $race->max_speed = 95;
	            $race->start_speed = 70;
	            $race->length = 1500;
	            $race->name = "زابل-چابهار";
	            break;
	        case 423:
	            $race->min_score = 8000;
	            $race->min_race = 41;
	            $race->max_speed = 95;
	            $race->start_speed = 70;
	            $race->length = 1500;
	            $race->name = "بیرجند-نیکشهر";
	            break;
	        case 431:
	            $race->min_score = 20000;
	            $race->min_race = 42;
	            $race->max_speed = 110;
	            $race->start_speed = 80;
	            $race->length = 2000;
	            $race->name = "طبس-چابهار";
	            break;
	    }
	    
	    return $race;
	}
}