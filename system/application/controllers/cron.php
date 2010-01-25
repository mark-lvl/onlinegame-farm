<?php

class Cron extends Controller {

	function Cron()
	{
		parent::Controller();

		$this->load->language('titles', get_lang());
		$this->load->language('labels', get_lang());
		$this->load->language('errors', get_lang());
	}

	function index()
	{
		$driver = $this->drivers_model->is_driver();
		
		$alert = new Alert(Races_model::ask_question($driver, new Race(array("id" => $driver->current_race)), new Checkpoint(array("id" => $driver->current_checkpoint))));
		echo('<pre style="text-align:left;direction:ltr">');print_r($alert);echo('</pre><hr>');die();
		die();
		die();
		header("Location: " . base_url());
	    die();
	}
	
	function create_race() {
	    $sql = "SELECT MAX(id) id FROM `races`";
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    $race_types = array(111, 112, 113,
	    					121, 122, 123,
	    					131,
							211, 212, 213,
	    					221, 222, 223,
	    					231,
							311, 312, 313,
	    					321, 322, 323,
	    					331,
							411, 412, 413,
	    					421, 422, 423,
	    					431);
	    $races = array();
	    $checkpoints = array();
	    
	    $i = 0;
	    foreach($race_types as $x => $k) {
	    	$races[] = Race::create_race($k);
	    	$races[$i++]->id = $result[0]['id'] + $i;
	    	if(Race::register($races[$i - 1])) {
	    		$checkpoints[] = Checkpoint::create_checkpoints($races[$i - 1]);
	    		Checkpoint::register($checkpoints[$i - 1]);
			}
	    }
	}
	
	function update_scores_locks() {
	    $sql = "SELECT * FROM `final_standing` WHERE rank_status = 0";
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    $rank_scores	= array(1 => 200,
	                            2 => 180,
	                            3 => 170,
	                            4 => 160,
	                            5 => 150,
	                            6 => 140,
	                            7 => 130,
	                            8 => 120,
	                            9 => 110,
	                            10 => 109,
	                            11 => 108,
	                            12 => 107,
	                            13 => 106,
	                            14 => 105,
	                            15 => 104,
	                            16 => 103,
	                            17 => 102,
	                            18 => 101,
	                            19 => 101,
	                            20, 101
								);
	    
	    if(is_array($result) && count($result) > 0) {
		    foreach($result as $x => $k) {
		        if(array_key_exists($k['rank'], $rank_scores)) {
		            $mult = substr($k['race_type'], 1);
		            $type = substr($k['race_type'], 0, 1);

		            switch($type) {
		                case 1:
		                    $locker = "city_lock_stat";
		                    break;
		                case 2:
		                    $locker = "mountain_lock_stat";
		                    break;
		                case 3:
		                    $locker = "jungle_lock_stat";
		                    break;
		                case 4:
		                    $locker = "desert_lock_stat";
		                    break;
		            }

					$sql = "UPDATE `users` A SET score = score + (" . $rank_scores[$k['rank']] . " * " . $mult . "), `" . $locker . "` = " . $mult . " WHERE id = '" . $k['driver'] . "'";
    				$resultz = $this->db->query($sql);
		        }
		    }
		}
	}
	
	function update_ranks() {
		$sql = "SELECT * FROM `races` WHERE status = 1 AND date_start <= '" . date("Y-m-d H:i:s") . "'";
	    $result = $this->db->query($sql);
	    $result = $result->result_array();
	    
	    $races = array();
	    $race_ids = array();

	    if(is_array($result) && count($result) > 0) {
		    foreach($result as $x => $k) {
				$sql = "TRUNCATE TABLE `tmp_ranks`";
				$resultx = $this->db->query($sql);
				if($resultx) {
					$sql = "INSERT INTO `tmp_ranks` (race, `time`, final_standing) SELECT race, final_time, id FROM final_standing WHERE race = '" . $k['id'] . "' ORDER BY final_time ASC";
	    			$resulty = $this->db->query($sql);
	    			
	    			if($resulty) {
						$sql = "UPDATE `final_standing` A SET rank = (SELECT id FROM `tmp_ranks` WHERE `final_standing` = A.id) WHERE race = '" . $k['id'] . "'";
	    				$resultz = $this->db->query($sql);
					}
				}
		    }
		}
		if($resultz) {
			die("Done!");
		}
		else {
			die("Error!");
		}
	}
	
	function update_drivers() {
		$sql = "SELECT * FROM `races` WHERE status = 1 AND date_start <= '" . date("Y-m-d H:i:s") . "' AND date_end > '" . date("Y-m-d H:i:s") . "'";
	    $result2 = $this->db->query($sql);
	    $result2 = $result2->result_array();
	    
	    $races = array();
	    $race_ids = array();
	    $drivers = array();
	    
	    if(is_array($result2) && count($result2) > 0) {
		    foreach($result2 as $x => $k) {
		        $races[] = new Race($k);
		        $race_ids[] = $k['id'];
		    }
		}

	    $sql = "SELECT * FROM `users` WHERE current_race IN (" . implode(",", $race_ids) . ") AND time_next_checkpoint <= '" . date("Y-m-d H:i:s") . "'";
	    $result1 = $this->db->query($sql);
	    $result1 = $result1->result_array();

	    if(is_array($result1) && count($result1) > 0) {
	        $i = 0;
		    foreach($result1 as $x => $k) {
		        $drivers[] = new Driver($k);
		        $race = FALSE;
		        foreach($races as $z => $y) {
		            if($y->id == $drivers[$i]->current_race) {
		            	$race = $y;
		            	break;
		            }
		        }
		        if($race) {
		        	Drivers_model::calculate_next_checkpoint(& $drivers[$i], $race);
				}
		        $i++;
		    }
		}
	}
}