<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

	class Races_model extends Model
	{
		function Races_model() {
			parent::Model();
		}

		function get_available_races() {
		    $sql = "SELECT * FROM `races` WHERE status = 1 AND date_start <= '" . date("Y-m-d H:i:s") . "' AND date_end >'" . date("Y-m-d H:i:s") . "'";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(!is_array($result) || count($result) <= 0) {
		        return FALSE;
		    }
		    
		    $ret = array();
			foreach($result as $x => $k) {
			    $ret[] = new Race($k);
			}
			
			return $ret;
		}
		
		function get_race($id) {
		    $sql = "SELECT * FROM `races` WHERE id = " . $this->db->escape($id);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(!is_array($result) || count($result) <= 0) {
		        return FALSE;
		    }

		    $race = new Race($result[0]);

			return $race;
		}

		function get_checkpoint($id) {
		    if(!$id || $id == 0) {
		        return FALSE;
		    }
		    $sql = "SELECT * FROM `checkpoints` WHERE id = " . $this->db->escape($id);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(!is_array($result) || count($result) <= 0) {
		        return FALSE;
		    }

		    $checkpoint = new Checkpoint($result[0]);

			return $checkpoint;
		}
		
		function register($race) {
		    if($race->id != "") {
		        $sql = "INSERT INTO `races` (`id`, `min_score`, `min_race`, `max_speed`, `name`, `type`, `date_start`, `date_end`, `maximum_time`, `status`, `start_speed`, `length`) VALUES (" . $this->db->escape($race->id) . ", " . $this->db->escape($race->min_score) . ", " . $this->db->escape($race->min_race) . ", " . $this->db->escape($race->max_speed) . ", " . $this->db->escape($race->name) . ", " . $this->db->escape($race->type) . ", " . $this->db->escape($race->date_start) . ", " . $this->db->escape($race->date_end) . ", " . $this->db->escape($race->maximum_time) . ", " . $this->db->escape($race->status) . ", " . $this->db->escape($race->start_speed) . ", " . $this->db->escape($race->length) . ")";
		    }
		    else {
		        $sql = "INSERT INTO `races` (`min_score`, `min_race`, `max_speed`, `name`, `type`, `date_start`, `date_end`, `maximum_time`, `status`, `start_speed`, `length`) VALUES (" . $this->db->escape($race->min_score) . ", " . $this->db->escape($race->min_race) . ", " . $this->db->escape($race->max_speed) . ", " . $this->db->escape($race->name) . ", " . $this->db->escape($race->type) . ", " . $this->db->escape($race->date_start) . ", " . $this->db->escape($race->date_end) . ", " . $this->db->escape($race->maximum_time) . ", " . $this->db->escape($race->status) . ", " . $this->db->escape($race->start_speed) . ", " . $this->db->escape($race->length) . ")";
		    }

		    if($this->db->query($sql)) {
		        return TRUE;
		    }
		    return FALSE;
		}
		
		function final_standing_record($driver, $race, $time) {
		    $sql = "INSERT INTO `final_standing` (driver, race, final_time, `date`, `race_type`) VALUES (" . $this->db->escape($driver->id) . ", " . $this->db->escape($race->id) . ", " . $this->db->escape($time) . ", '" . date("Y-m-d H:i:s") . "', " . $this->db->escape($race->type) . ")";
		    
		    if($this->db->query($sql)) {
		        return TRUE;
		    }
		    return FALSE;
		}
		
		function record_submission($driver, $race, $time) {
		    $sql = "INSERT INTO `records` (`user`, race, checkpoint, `time`, `date`, speed) VALUES (" . $this->db->escape($driver->id) . ", " . $this->db->escape($race->id) . ", " . $this->db->escape($driver->current_checkpoint) . ", " . $this->db->escape($time) . ", '" . date("Y-m-d H:i:s") . "', " . $this->db->escape($driver->current_speed) . ")";

		    if($this->db->query($sql)) {
		        return TRUE;
		    }
		    return FALSE;
		}
		
		function get_race_best_time($race_id, $checkpoint_id) {
		    if($checkpoint_id == 0 || $race_id == 0) {
		        return "-";
		    }
		    
		    $sql = "SELECT MIN(`time`) mint, user FROM `records` WHERE checkpoint = " . $this->db->escape($checkpoint_id) . " AND race = " . $this->db->escape($race_id);
		    
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result)) {
		        return $result[0];
		    }
		    return FALSE;
		}
		
		function ask_question($driver, $race, $checkpoint) {
		    $sql = "SELECT * FROM `alerts` WHERE status = 1 AND (type = " . $checkpoint->question_type . " OR type = 0 OR city = " . $this->db->escape($checkpoint->city) . " OR type = 1 OR type = 2) ORDER BY RAND() LIMIT 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result)) {
		        return $result[0];
		    }
		    return FALSE;
		}
		
		function submit_question($question) {
  			$sql = "INSERT INTO `questions` (`race`, `checkpoint`, `driver`, `date_asked`, `alert`) VALUES (" . $this->db->escape($question->race) . ", " . $this->db->escape($question->checkpoint) . ", " . $this->db->escape($question->driver) . ", " . $this->db->escape($question->date_asked) . ", " . $this->db->escape($question->alert) . ")";

		    if($this->db->query($sql)) {
		        return $this->db->insert_id();
		    }
		    return FALSE;
		}
		
		function get_challenge_question($driver) {
		    $sql = "SELECT * FROM `alerts` WHERE status = 1 ORDER BY RAND() LIMIT 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result)) {
		        return $result[0];
		    }
		    return FALSE;
		}

		function get_top_drivers_race($race, $page = 0, $count = 6) {
		    $sql = "SELECT B.*, A.final_time FROM `final_standing` A, users B WHERE A.race = " . $this->db->escape($race) . " AND B.id = A.driver ORDER BY rank ASC LIMIT " . $page * $count . ", " . $count;
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        $ret = array();
		        foreach($result as $x => $k) {
		        	$ret[] = new Driver($k);
		        }
		        return $ret;
		    }
		    return FALSE;
		}
	}