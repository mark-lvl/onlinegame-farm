<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkpoint extends MY_cls
{
	var $id;
	var $race_id;
	var $name = "";
	var $city = "";
	var $kilometer = 0;
	var $max_speed = 0;
	/*
	    Road situation:
	        0: normal
	        1: sloppy
	        2: slippery
	        3: rainy
	        4: foggy
	        5: snowy
	        
	*/
	var $road_situation = 0;
	var $question_type = 0;
	var $distance = 50000; //Meters

	function Checkpoint($instant = FALSE)
	{
		if($instant) {
			parent::instant_maker($instant);
		}
	}
	
	function register($checkpoints) {
		$sql = "INSERT INTO `checkpoints` (`race_id`, `name`, `city`, `kilometer`, `max_speed`, `road_situation`, `question_type`) VALUES ";
	    foreach($checkpoints as $x => $k) {
	        $sql .= "(" . $this->db->escape($k->race_id) . ", " . $this->db->escape($k->name) . ", " . $this->db->escape($k->city) . ", " . $this->db->escape($k->kilometer) . ", " . $this->db->escape($k->max_speed) . ", " . $this->db->escape($k->road_situation) . ", " . $this->db->escape($k->question_type) . ") , ";
	    }
        $sql = rtrim($sql, ", ");
        
	    if($this->db->query($sql)) {
	        return TRUE;
	    }
	    return FALSE;
	}
	
	function add_checkpoint($main_checkpoint, $road_situation, $city, $kilometer, $max_speed = "", $name = "") {
	    if(!is_object($main_checkpoint)) {
	        return FALSE;
	    }
	    
	    $checkpoint = new Checkpoint($main_checkpoint);
	 	$checkpoint->road_situation = $road_situation;
	 	$checkpoint->city = $city;
	 	$checkpoint->kilometer = $kilometer;
	 	if($max_speed != "") {
	 		$checkpoint->max_speed = $max_speed;
		}
	 	if($name != "") {
	 		$checkpoint->name = $name;
		}
		return $checkpoint;
	}
	
	function create_checkpoints($race) {
	    $checkpoint = array(); //Array of checkpoints
	    switch($race->type) {
	        case 111:
				$cities = array("بندرعباس",
								"بندرخمیر",
								"لار",
								"خنج",
								"بندردیر",
								"برازجان",
								"بوشهر");
								
				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");
								
	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 112:
				$cities = array("ایلام",
								"مریوان",
								"دهلران",
								"دزفول",
								"اهواز",
								"آبادان",
								"امیدیه");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 113:
				$cities = array("تهران",
								"قزوین",
								"گلپایگان",
								"اراک",
								"سمنان",
								"شاهرود",
								"مشهد");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 121:
				$cities = array("مریوان",
								"ایلام",
								"دهلران",
								"دزفول",
								"اهواز",
								"آبادان",
								"امیدیه",
								"بندرگناوه",
								"کازرون");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 122:
				$cities = array("اصفهان",
				                "کاشان",
				                "شاهرود",
				                "سمنان",
								"گلپایگان",
								"اراک",
								"زنجان",
								"قزوین",
								"تهران");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 123:
				$cities = array("یزد",
								"کاشان",
								"اصفهان",
								"شاهرود",
								"سمنان",
								"گلپایگان",
								"زنجان",
								"اراک",
								"قزوین");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 3);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 3), $k, $kilometers[$x]);
				}

	            break;
	        case 131:
				$cities = array("تهران",
								"سمنان",
								"شاهرود",
								"مشهد",
								"گناباد",
								"یزد",
								"کاشان",
								"اصفهان",
								"گلپایگان",
								"اراک",
								"قزوین",
								"تهران");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1300",
									"1450",
									"1600",
									"1750",
									"1900",
									"2000");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	            
	        case 211:
				$cities = array("شهرکرد",
								"اردل",
								"بروجن",
								"لردگان",
								"سمیرم",
								"یاسوج",
								"میبد");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 212:
				$cities = array("فیروزکوه",
								"دماوند",
								"تهران",
								"قزوین",
								"بلده",
								"آسارا",
								"طالقان");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 213:
				$cities = array("کرمانشاه",
								"سنقر",
								"کنگاور",
								"نهاوند",
								"بروجرد",
								"الیگودرز",
								"خرم آباد");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 221:
				$cities = array("دماوند",
								"فیروزکوه",
								"بلده",
								"آسارا",
								"طالقان",
								"الوند",
								"کوهین",
								"خرمدره",
								"زنجان");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 222:
				$cities = array("خرم آباد",
								"کنگاور",
								"بروجرد",
								"نهاوند",
								"دورود",
								"الیگودرز",
								"فریدونشهر",
								"چلگرد",
								"شلمزار");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 223:
				$cities = array("نهاوند",
								"بروجرد",
								"خرم آباد",
								"دورود",
								"الیگودرز",
								"فریدونشهر",
								"چلگرد",
								"فریدونشهر",
								"الیگودرز");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	        case 231:
				$cities = array("همدان",
								"سنقر",
								"کرمانشاه",
								"کنگاور",
								"نهاوند",
								"بروجرد",
								"خرم آباد",
								"دورود",
								"الیگودرز",
								"فریدونشهر",
								"چلگرد",
								"شلمزار");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1300",
									"1450",
									"1600",
									"1750",
									"1900",
									"2000");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(1, 5);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(1, 5), $k, $kilometers[$x]);
				}

	            break;
	            
	        case 311:
				$cities = array("آستارا",
								"بندرانزلی",
								"لاهیجان",
								"رودبار",
								"فومن",
								"تالش",
								"اردبیل");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}
	            break;
	        case 312:
				$cities = array("بابلسر",
								"نور",
								"رامسر",
								"نوشهر",
								"کلاردشت",
								"تنکابن",
								"لنگرود");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}
	            break;
	        case 313:
				$cities = array("گرگان",
								"ساری",
								"نور",
								"رامسر",
								"لوشان",
								"خلخال",
								"سراب");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}
	            break;
	        case 321:
				$cities = array("گنبدکاووس",
								"بندرترکمن",
								"بابلسر",
								"نوشهر",
								"کلاردشت",
								"تنکابن",
								"لنگرود",
								"صومعه سرا",
								"رودبار");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}
				
	            break;
	        case 322:
				$cities = array("ساری",
								"نور",
								"رامسر",
								"لوشان",
								"خلخال",
								"سراب",
								"تبریز",
								"سلماس",
								"ارومیه");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}

	            break;
	        case 323:
				$cities = array("نور",
								"رامسر",
								"لوشان",
								"خلخال",
								"سراب",
								"تبریز",
								"سلماس",
								"ارومیه",
								"سقز");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}

	            break;
	        case 331:
				$cities = array("شاهرود",
								"گرگان",
								"ساری",
								"نور",
								"رامسر",
								"لوشان",
								"خلخال",
								"سراب",
								"تبریز",
								"سلماس",
								"ارومیه",
								"سقز");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1300",
									"1450",
									"1600",
									"1750",
									"1900",
									"2000");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(2, 4);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(2, 4), $k, $kilometers[$x]);
				}

	            break;
	            
	        case 411:
				$cities = array("دلیجان",
								"بادرود",
								"نایین",
								"انارک",
								"خور",
								"خوانق",
								"اردکان");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 412:
				$cities = array("جیرفت",
								"بافت",
								"کرمان",
								"راور",
								"دیهوک",
								"کاشمر",
								"فردوس");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 413:
				$cities = array("کرمان",
								"بافت",
								"راور",
								"دیهوک",
								"فردوس",
								"کاشمر",
								"نیشابور");

				$kilometers = array("0",
									"300",
									"450",
									"550",
									"650",
									"750",
									"800");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 421:
				$cities = array("بم",
								"جیرفت",
								"بافت",
								"کرمان",
								"راور",
								"دیهوک",
								"فردوس",
								"کاشمر",
								"نیشابور");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 422:
				$cities = array("زابل",
								"زاهدان",
								"محمدآباد",
								"ایرانشهر",
								"خاش",
								"زابلی",
								"راسک",
								"نیکشهر",
								"چابهار");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 423:
				$cities = array("بیرجند",
								"نهبندان",
								"زابل",
								"زاهدان",
								"محمدآباد",
								"ایرانشهر",
								"خاش",
								"راسک",
								"نیکشهر");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1200",
									"1350",
									"1500");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	        case 431:
				$cities = array("طبس",
								"بیرجند",
								"نهبندان",
								"زابل",
								"زاهدان",
								"محمدآباد",
								"ایرانشهر",
								"خاش",
								"زابلی",
								"راسک",
								"نیکشهر",
								"چابهار");

				$kilometers = array("0",
									"300",
									"600",
									"800",
									"950",
									"1100",
									"1300",
									"1450",
									"1600",
									"1750",
									"1900",
									"2000");

	            $checkpoint[0]				= new Checkpoint();
	            $checkpoint[0]->race_id		= $race->id;
	            $checkpoint[0]->name		= "";
	            $checkpoint[0]->city        = $cities[0];
	            $checkpoint[0]->max_speed   = $race->max_speed;
	            $checkpoint[0]->road_situation   = mt_rand(0, 1);

				foreach($cities as $x => $k) {
				    if($x == 0) {
				        continue;
				    }
				    $checkpoint[] = Checkpoint::add_checkpoint($checkpoint[0], mt_rand(0, 1), $k, $kilometers[$x]);
				}

	            break;
	    }
	    
	    return $checkpoint;
	}
}