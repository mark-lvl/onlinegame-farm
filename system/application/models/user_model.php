<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

	class User_model extends Model
	{
		function User_model() {
			parent::Model();
		}

		function is_authenticated()
                {
		    if(!isset($_SESSION['user']))
		        //TODO must be registration/login
                        //redirect('registration/');
                        return false;
                    else {
		    	$user = new User_entity($_SESSION['user']);

                        $sql = "SELECT A.* FROM `users` 
                                A WHERE email = " . $this->db->escape($user->email) .
                                        " AND password = " . $this->db->escape($user->password);
                        
                        $result = $this->db->query($sql)->result_array();
                        if(count($result) <= 0)
                            return FALSE;
                        else {
                            $user = new User_entity($result[0]);
                            $_SESSION['user'] = $user;
                            return $user;
                        }
		    }
		}

                function has_farm($user_id)
                {
                    $sql = "SELECT id FROM `farms`
                            WHERE user_id = $user_id
                                AND disactive = 0";

                    $result = $this->db->query($sql)->result_array();
                        if(count($result) <= 0)
                            return FALSE;
                        else
                            return TRUE;
                }

		function log_in($email, $pass) {
		    $sql = "SELECT * FROM `users` WHERE email = " . $this->db->escape($email) . " AND password = " . $this->db->escape(md5($pass));
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    if(count($result) <= 0) {
		        return FALSE;
		    }
		    else {
		        $user = new User_entity($result[0]);
		        return $user;
		    }
		}

		function is_email_unique($email) {

		    $sql = "SELECT * FROM `users` WHERE email = " . $this->db->escape($email);

		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(count($result) > 0) {
		        return FALSE;
		    }
	        return TRUE;
		}

		function register_user($user) {
		    $sql = "INSERT INTO `users` (first_name,
                                                 last_name,
                                                 email,
                                                 password,
                                                 photo,
                                                 sex,
                                                 birthdate,
                                                 registration_ip,
                                                 registration_date,
                                                 city)
                           VALUES(" .
                                                 $this->db->escape($user->first_name) . ", " .
                                                 $this->db->escape($user->last_name) . ", " .
                                                 $this->db->escape($user->email) . ", " .
                                                 $this->db->escape(md5($user->password)) . ", " .
                                                 $this->db->escape($user->photo) . ", " .
                                                 $this->db->escape($user->sex) . ", " .
                                                 $this->db->escape($user->birthdate) . ", '" .
                                                 $_SERVER['REMOTE_ADDR'] . "', '" .
                                                 date('Y-m-d H:i:s') . "'," .
                                                 $this->db->escape($user->city) . ");";

                        if($this->db->query($sql))
			    return $this->db->insert_id();

                        return FALSE;
		}
		
		function update($user, $fields, $exp = NULL) {
			$cols = "";
		    foreach($fields as $x => $k) {
		        if(is_array($exp) && array_search($k, $exp) !== FALSE) {
		        	$cols .= $k . " = " . $user->$k . ",";
		        }
		        else {
		        	$cols .= $k . " = " . $this->db->escape($user->$k) . ",";
				}
		    }
		    $cols = rtrim($cols, ",");
		    $sql = "UPDATE `users` SET " . $cols . " WHERE id = '" . $user->id . "'";
			if($this->db->query($sql)) {
			    return TRUE;
			}
			return FALSE;
		}
		
		function get_user_by_id($id) {
		    $sql = "SELECT * FROM `users` WHERE id = " . $this->db->escape($id);
		    $result = $this->db->query($sql)->result_array();
		    
		    if(count($result) <= 0) {
		        return FALSE;
		    }
		    else {
		        $user = new User_entity($result[0]);
		        return $user;
		    }
		}
		
		function relate_users($user, $guest_id, & $stat = FALSE) {
		    if($user->id == $guest_id) {
		        return FALSE;
		    }
		    $sql = "SELECT * FROM `relations` WHERE (`inviter` = " . $this->db->escape($user->id) . " AND `guest` = " . $this->db->escape($guest_id) . ") OR (`inviter` = " . $this->db->escape($guest_id) . " AND `guest` = " . $this->db->escape($user->id) . ")";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(count($result) > 0) {
		        if($stat !== FALSE) {
		            $stat = $result[0]['status'];
		        }
		        return FALSE;
		    }
		    else {
		        $sql = "INSERT INTO `relations` (`inviter`, `guest`, `invitation_date`, `status`)
						VALUES (" . $this->db->escape($user->id) . ", " . $this->db->escape($guest_id) . ", '" . date('Y-m-d H:i:s') . "', '0')";
				if($this->db->query($sql)) {
				    return TRUE;
				}
			    return FALSE;
		    }
		}
		
		function delete_relation($user, $guest_id) {
		    if($user->id == $guest_id) {
		        return FALSE;
		    }
		    $sql = "DELETE FROM `relations` WHERE (`inviter` = " . $this->db->escape($user->id) . " AND `guest` = " . $this->db->escape($guest_id) . ") OR (`inviter` = " . $this->db->escape($guest_id) . " AND `guest` = " . $this->db->escape($user->id) . ")";
		    $result = $this->db->query($sql);

		    if($result) {
		        return TRUE;
		    }
		    return FALSE;
		}

		function is_related($user, $guest_id) {
		    if($user->id == $guest_id) {
		        return TRUE;
		    }
			$sql = "SELECT * FROM `relations` WHERE (`inviter` = " . $this->db->escape($user->id) . " AND `guest` = " . $this->db->escape($guest_id) . ") OR (`inviter` = " . $this->db->escape($guest_id) . " AND `guest` = " . $this->db->escape($user->id) . ")";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(count($result) > 0) {
		        return TRUE;
		    }
		    return FALSE;
		}
		
                function is_blocked($user, $guest_id) {
		    if($user->id == $guest_id) {
		        return TRUE;
		    }
		    
                    $sql = "SELECT * FROM `relations`
                                WHERE `inviter` = " . $this->db->escape($user->id) .
                                    " AND `guest` = " . $this->db->escape($guest_id) .
                                    " AND `status` = 3";
		    $result = $this->db->query($sql)->num_rows();

		    if($result) {
		        return TRUE;
		    }
		    return FALSE;
		}
		
		function get_friends($user) {
		    $sql = "SELECT * FROM `relations` A, `users` B WHERE (A.`inviter` = " . $this->db->escape($user->id) ." OR A.`guest` = " . $this->db->escape($user->id) . ") AND A.status = 1 AND B.id != " . $this->db->escape($user->id) ." AND (B.id = A.`inviter` OR B.id = A.`guest`) ORDER BY B.last_login_date DESC";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(count($result) > 0) {
		    	$ret = array();
		        foreach($result as $x => $k) {
		            $ret[] = new User_entity($k);
		        }
	            return $ret;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function invite_friend($user, $email) {
		    $sql = "SELECT * FROM `users` WHERE email = " . $this->db->escape($email);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    if(count($result) > 0) {
		        return $result[0]['id'];
		    }

			$sql = "SELECT * FROM `invitations` WHERE friend_email = " . $this->db->escape($email);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
			if(count($result) > 0) {
		        return FALSE;
		    }

			$sql = "INSERT INTO `invitations` (`user`, `friend_email`, `hash`, `date_invited`) VALUES ('" . $user->id . "', " . $this->db->escape($email) . ", '" . md5($email) . "', '" . date("Y-m-d H:i:s") . "')";
			$result = $this->db->query($sql);
			if($result) {
			    return TRUE;
			}
			return FALSE;
		}
		
		function send_message($from_id, $to_id, $title, $body, $real_mail = FALSE) {
		    $sql = "INSERT INTO `messages` (`from`, `to`, `title`, `message`, `date`, `ip`)
					VALUES (" . $this->db->escape($from_id) .", " . $this->db->escape($to_id) .", " . $this->db->escape($title) .", " . $this->db->escape($body) .", '" . date('Y-m-d H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "')";
					
		    if($this->db->query($sql)) {
		        return TRUE;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function get_messages($user) {
		    $sql = "SELECT A.*, B.first_name FROM `messages` A, `users` B WHERE B.id = A.from AND `to` = " . $this->db->escape($user->id) . " ORDER BY `id` DESC";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(count($result) > 0) {
		        return $result;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function get_message($user, $id) {
		    $sql = "SELECT A.* FROM `messages` A WHERE `to` = " . $this->db->escape($user->id) . " AND id = " . $this->db->escape($id);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(count($result) > 0) {
		        $sql = "UPDATE `messages` SET checked = 1 WHERE id = " . $result[0]['id'];
		        $this->db->query($sql);
		        return $result;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function delete_message($user, $id) {
		    $sql = "DELETE FROM `messages` WHERE `to` = " . $this->db->escape($user->id) . " AND id = " . $this->db->escape($id);
		    $result = $this->db->query($sql);

		    if($result) {
		        return TRUE;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function delete_all_message($user) {
		    $sql = "DELETE FROM `messages` WHERE `to` = " . $this->db->escape($user->id);
		    $result = $this->db->query($sql);

		    if($result) {
		        return TRUE;
		    }
		    else {
		        return FALSE;
		    }
		}
		
		function get_users_rank_in_race($user) {
		    if($user->current_checkpoint == 0) {
		    	return "-";
		    }
		    
		    $sql = "SELECT COUNT(*) cnt FROM `records` WHERE checkpoint = " . $this->db->escape($user->current_checkpoint) . " AND race = " . $this->db->escape($user->current_race) . " AND `time` < (SELECT `time` FROM `records` WHERE checkpoint = " . $this->db->escape($user->current_checkpoint) . " AND race = " . $this->db->escape($user->current_race) . " AND user = " . $this->db->escape($user->id) . ")";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(is_array($result)) {
		        return $result[0]['cnt'] + 1;
		    }
		    return FALSE;
		}
		
		function get_users_ranks($user) {
		    //$sql = "SELECT * FROM `final_standing` WHERE `user` = " . $this->db->escape($user->id) . " AND rank <= 20 AND rank > 0 ORDER BY rank";
		    //$result = $this->db->query($sql);
		    //$result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        return $result;
		    }
		    return FALSE;
		}
		
		function get_users_total_rank($user) {
		    //$sql = "SELECT COUNT(*) cnt FROM `users` WHERE `score` > " . $this->db->escape($user->score);
		   // $result = $this->db->query($sql);
		   // $result = $result->result_array();

		    if(is_array($result)) {
		        return $result[0]['cnt'] + 1;
		    }
		    return FALSE;
		}
		
		function get_next_speed($user, $race, $checkpoint) {
		    //$speed = min(array($checkpoint->max_speed, $race->max_speed));
		    if($user->current_speed < 1) {
				$user->current_speed = 1;
			}
			
		    $speed = $user->current_speed;
		    $max_speed = $speed;
		    /*
		        Road situation affects speed
		    */
		    
		    /*
		    if(is_object($checkpoint) && isset($checkpoint->road_situation)) {
			    switch($checkpoint->road_situation) {
			        case 0: //Normal
			            $speed = $speed;
			            break;
			        case 1: //Sloppy
			        	$speed = $speed / 1.5;
			            break;
			        case 2: //Slippery
			        	$speed = $speed / 2;
			            break;
			        case 3: //Rainy
			        	$speed = $speed / 1.3;
			            break;
			        case 4: //Foggy
			        	$speed = $speed / 2.5;
			            break;
			        case 5: //Snowy
			        	$speed = $speed / 2.1;
			            break;
			    }
			}
			*/

		    /*
		        Fuel affects speed
		    */

		    //$speed *= ($user->current_fuel / 100);

		    /*
		        Oil affects speed
		    */
		    //$speed *= ($user->current_oil / 100);

		    /*
		        Water affects speed
		    */
		    //$speed *= ($user->current_water / 100);

		    /*
		        Tire affects speed
		    */
		    //$speed *= ($user->current_tire / 100);

		    /*
		        Tiredness affects speed
		    */
		    //$speed *= ($user->current_tiredness / 100);
		    
		    if($speed > $max_speed) {
		    	//$speed = $max_speed;
		    }
		    return floor($speed);
		}
		
		function get_total_race_users($race_id) {
		    $sql = "SELECT COUNT(*) cnt FROM `records` WHERE race = " . $this->db->escape($race_id) . " GROUP BY user";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result)) {
		        return count($result);
		    }
		    return FALSE;
		}
		
		function calculate_next_checkpoint(& $user, $race, $next_speed = 0) {
			if($next_speed <= 0) {
			    $next_speed = $user->current_speed;
			}
			if($user->current_speed < 1) {
				$user->current_speed = 1;
			}
			
			$year = substr($user->last_status_update, 0, 4);
			$month = substr($user->last_status_update, 5, 2);
			$day = substr($user->last_status_update, 8, 2);
			$hour = substr($user->last_status_update, 11, 2);
			$min = substr($user->last_status_update, 14, 2);
			$sec = substr($user->last_status_update, 17, 2);

		    $cpx = 0;
		    $cpt = 0;
		    
		    $sql = "SELECT * FROM `checkpoints` WHERE race_id = " . $this->db->escape($race->id) . " AND id > " . $user->current_checkpoint . " AND kilometer != 0 ORDER BY id ASC LIMIT 1";
		    $result = $this->db->query($sql); //Getting this passed checkpoint
		    $result = $result->result_array();
		    
			if(is_array($result) && count($result) > 0) {
				$cpx = $result[0]['id'];
				$cpt = $result[0]['kilometer'];
			}

			//The seconds passed from the last update
		    $seconds_passed = time() - mktime($hour, $min, $sec, $month, $day, $year);

			//The meters passed between last update and now
			$metters_passed = floor((($user->current_speed * 1000) * $seconds_passed) / 3600);

		    $meters_passed_total = $metters_passed + $user->current_position;

		    $meters_left = ($cpt * 1000) - $meters_passed_total;

		    $time_left = floor(($meters_left * 3600) / ($next_speed * 1000)); //Seconds left
		    
		    $change_checkpoint = FALSE;

		    if($user->current_time_passed == 0 && $user->current_position == 0) {
		    	$user->current_checkpoint = $cpx;
			    $alert = new Alert(Races_model::ask_question($user, $race, new Checkpoint($result[0])));
			    $question = new Question();
			    $question->alert = $alert->id;
			    $question->user = $user->id;
			    $question->race = $race->id;
			    $question->checkpoint = $cpx;
			    $question->date_asked = date("Y-m-d H:i:s");
				Races_model::submit_question($question);
				$user->current_checkpoint = 0;
				$user->current_time_passed = 1;
		    }
		    
		    if($user->current_time_passed + $seconds_passed > $race->maximum_time) { //user is out!
			    $this->load->language('labels', get_lang());
			    $lang = $this->lang->language;

			    $title	= str_replace("XXX", $race->name, $lang['failed_title']);
			    $msg	= str_replace("XXX", $race->name, $lang['failed_msg']);
			    $msg	= str_replace("XX", convert_number("" . ceil(($race->maximum_time) / 3600)), $msg);
			    $msg	= str_replace("X", $race->id, $msg);

			    users_model::send_message(1, $user->id, $title, $msg);
			    
			    $user->current_race = 0;
			    $user->current_checkpoint = 0;
			    $user->rally_count = $user->rally_count + 1;
		    }
		    
		    else if($user->time_next_checkpoint <= date("Y-m-d H:i:s") && $meters_passed_total >= $cpt) {
				$user->current_checkpoint = $cpx;
				
				if($cpx == 0) { //This is the final checkpoint and user has finished the race
				    Races_model::final_standing_record($user, $race, $user->current_time_passed + $seconds_passed);
				    
				    $this->load->language('labels', get_lang());
				    $lang = $this->lang->language;
				    
				    $title	= str_replace("XXX", $race->name, $lang['finished_title']);
				    $msg	= str_replace("XXX", $race->name, $lang['finished_msg']);
				    $msg	= str_replace("XX", convert_number("" . ceil(($user->current_time_passed + $seconds_passed) / 3600)), $msg);
				    $msg	= str_replace("X", $race->id, $msg);
				    
				    users_model::send_message(1, $user->id, $title, $msg);
				    $user->current_race = 0;
				    $user->current_checkpoint = 0;
				    $user->rally_count = $user->rally_count + 1;
				}
				else { //A question must be asked
				    $alert = new Alert(Races_model::ask_question($user, $race, new Checkpoint($result[0])));
				    $question = new Question();
				    $question->alert = $alert->id;
				    $question->user = $user->id;
				    $question->race = $race->id;
				    $question->checkpoint = $cpx;
				    $question->date_asked = date("Y-m-d H:i:s");
					Races_model::submit_question($question);
					
					$user->current_tire = $user->current_tire - 10;
					$user->current_oil = $user->current_oil - 10;
					$user->current_water = $user->current_water - 10;
					$user->current_tiredness = $user->current_tiredness - 10;
					$user->current_fuel = $user->current_fuel - 10;
					
				    $sql = "SELECT * FROM `checkpoints` WHERE race_id = " . $this->db->escape($race->id) . " AND id > " . $cpx . " AND kilometer != 0 ORDER BY id ASC LIMIT 1";
				    $result = $this->db->query($sql); //Getting this passed checkpoint
				    $result = $result->result_array();
				    $meters_left = ($result[0]['kilometer'] * 1000) - $meters_passed_total;
				    $time_left = floor(($meters_left * 3600) / ($next_speed * 1000)); //Seconds left
				    Races_model::record_submission($user, $race, $user->current_time_passed + $seconds_passed);
				}
				$change_checkpoint = TRUE;
			}

			$user->current_speed = $next_speed;

			$user->last_status_update = date("Y-m-d H:i:s");
			$user->current_position = $meters_passed_total;
			if($change_checkpoint) {
				$user->current_checkpoint = $cpx;
			}
			$user->current_time_passed = $user->current_time_passed + $seconds_passed;
			$user->time_next_checkpoint = date("Y-m-d H:i:s", strtotime("+" . $time_left . " seconds"));
			
			if($user->current_speed > $race->max_speed) {
				$user->current_speed = $race->max_speed;
			}
			
			if($user->time_next_checkpoint > 0) {
				$fields = array("current_speed", "last_status_update", "current_position", "current_checkpoint", "current_time_passed", "time_next_checkpoint", "current_race", "score", "rally_count", "current_tire", "current_oil", "current_water", "current_tiredness", "current_fuel");
				users_model::update($user, $fields);
			}
			
			return $user;
		}
		
		function get_users_question($user, $limit = NULL, $hide_answer = FALSE, $cht = TRUE) {
		    if(!$user->id || !$user->current_race) {
		        return FALSE;
		    }
		    
		    if($limit) {
		    	$limit = " LIMIT " . $limit;
		    }
		    
		    $rc = " = " . $this->db->escape($user->current_race);
		    if(!$cht) {
		    	$rc = " IS NULL ";
		    }
		    
		    $sql = "SELECT B.*, A.id qid, A.date_asked FROM `questions` A, `alerts` B
					WHERE A.user = " . $this->db->escape($user->id) . " AND A.race " . $rc . " AND A.answer = 0 AND A.alert = B.id ORDER BY A.id" . $limit;

		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
				if($hide_answer) {
				    foreach($result as $x => $k) {
				    	$result[$x]['answer'] = "0";
				    }
				}
		        return $result;
		    }
		    return FALSE;
		}
		
		function get_users_question_number($user) {
		    if(!$user->id || !$user->current_race) {
		        return FALSE;
		    }

		    $sql = "SELECT count(*) cnt FROM `questions` A
					WHERE A.user = " . $this->db->escape($user->id) . " AND A.race = " . $this->db->escape($user->current_race) . " AND A.answer = '0'";

		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result)) {
		        return $result[0]['cnt'];
		    }
		    return FALSE;
		}
		
		function get_car_votes($user) {
		    $sql = "SELECT COUNT(*) cnt, AVG(`type`) avt, SUM(`type`) smt FROM `votes` WHERE `car_id` = " . $this->db->escape($user->car);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    return $result;
		}
		
		function get_users_vote_to_car($user, $car) {
		    $sql = "SELECT * FROM `votes` WHERE `car_id` = " . $this->db->escape($car) . " AND `user_id` = " . $this->db->escape($user->id);

		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        return $result;
		    }
		    return FALSE;
		}
		
		function get_top_renault($page = 0, $count = 6) {
		    $sql = "SELECT AVG(A.type) avt, COUNT(*) cnt, A.*, B.id bid, CONCAT(B.first_name, ' ', B.last_name) first_name FROM `votes` A, `users` B WHERE B.car = A.car_id GROUP BY car_id HAVING COUNT(*) > 1 ORDER BY AVG(A.type) DESC LIMIT " . $page * $count . ", " . $count;
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        return $result;
		    }
		    return FALSE;
		}
		
		function get_top_users($page = 0, $count = 6, $filter = "") {
		    if($filter != "") {
		    	$filter = " WHERE CONCAT(first_name, ' ', last_name) LIKE '%" . $filter . "%'";
		    }
		    $sql = "SELECT u.*, d.score
                            FROM users AS u
                            LEFT JOIN user_detail
                            AS d ON u.id = d.user_id"
                            . $filter .
                            " ORDER BY score DESC LIMIT " . $page * $count . ", " . $count;

		    $result = $this->db->query($sql)->result_array();

		    if(is_array($result) && count($result) > 0) {
		        $ret = array();
		        foreach($result as $x => $k) {
		        	$ret[] = new User_entity($k);
		        }
		        return $ret;
		    }
		    return FALSE;
		}
		
		function get_count_users($filter = "") {
		    if($filter != "") {
		    	$filter = " WHERE CONCAT(first_name, ' ', last_name) LIKE '%" . $filter . "%'";
		    }
		    $sql = "SELECT COUNT(*) cnt FROM `users`" . $filter;
		    $result = $this->db->query($sql)->result_array();
		    
		    return $result[0]['cnt'];
		}
		
		function get_count_renaults() {
		    $sql = "SELECT COUNT(*) cnt FROM `votes` A GROUP BY car_id HAVING COUNT(*) > 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    return count($result);
		}
		
		function get_last_diary($user) {
		    $sql = "SELECT * FROM diaries A
      				WHERE A.user = " . $this->db->escape($user->id) . " ORDER BY id DESC LIMIT 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(is_array($result) && count($result) > 0) {
		        return $result;
		    }
		    return FALSE;
		}
		
		function get_diary_votes($id) {
			$sql = "SELECT COUNT(*) cnt FROM `diary_votes` WHERE diary = " . $this->db->escape($id) . " AND type = 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(is_array($result) && count($result) > 0) {
		        return $result[0]['cnt'];
		    }
		    return FALSE;
		}
		
		function get_diary_vote($id, $user) {
			$sql = "SELECT * FROM `diary_votes` WHERE diary = " . $this->db->escape($id) . " AND user = " . $this->db->escape($user->id) . " LIMIT 1";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        return $result[0];
		    }
		    return FALSE;
		}
		
		function get_next_user($user) {
			$sql = "SELECT * FROM `users` WHERE current_race = " . $this->db->escape($user->current_race) . " AND current_position > " . $this->db->escape($user->current_position) . " AND challenged = 0 ORDER BY current_position DESC LIMIT 1";

		    $result = $this->db->query($sql);
		    $result = $result->result_array();

		    if(is_array($result) && count($result) > 0) {
		        return new user($result[0]);
		    }
		    return FALSE;
		}
		
		function challenge($from_user, $to_user) {
		}

                function get_mutual_freinds($firstUser ,$secondUser)
                {
                    if(!isset($firstUser) || !isset($secondUser)) {
		        return FALSE;
		    }

                    $statusQueryHolder = " AND `status` = 1";

                    $sqlFirstUser = "SELECT `id` FROM `relations`
                                     WHERE ((`inviter` = " . $firstUser . ")
                                         OR (`guest` = " . $firstUser . "))".$statusQueryHolder;

                    $countFirst = $this->db->query($sqlFirstUser)->num_rows();
                    
                    $sqlSecondUser = "SELECT `id` FROM `relations`
                                      WHERE ((`inviter` = " . $secondUser . ")
                                         OR (`guest` = " . $secondUser . "))".$statusQueryHolder;

                    $countSecond = $this->db->query($sqlSecondUser)->num_rows();

                    if($countFirst > $countSecond)
                    {
                        $maint   = 'secondUser';
                        $partner = 'firstUser';
                    }
                    else
                    {
                        $maint   = 'firstUser';
                        $partner = 'secondUser';
                    }

                    $sqlHolder = "SELECT `inviter`,`guest` FROM `relations`
                                  WHERE ((`inviter` = " . $$maint . ")
                                    OR (`guest` = " . $$maint . "))".$statusQueryHolder;
		    
		    $searchedFriend = $this->db->query($sqlHolder)->result_array();
		    foreach($searchedFriend AS $item)
			foreach($item AS $inner)
				if($inner != $$maint)
					$objectFreinds[] = $inner;

                    $objectFreinds = array_unique($objectFreinds);

                    $sqlFinder = "SELECT `inviter`,`guest` FROM `relations`
				  WHERE ((`inviter` = " . $$partner . " AND `guest` IN (" . implode(",", $objectFreinds) . "))
				  	OR (`guest`=" . $$partner . " AND `inviter` IN (" . implode(",", $objectFreinds) . ")))"
                                .$statusQueryHolder;
                    
                    $findMutual = $this->db->query($sqlFinder)->result_array();

                    foreach ($findMutual AS $node)
                        foreach ($node as $mutual)
                            if($mutual != $firstUser && $mutual != $secondUser)
                                $return[] = $mutual;

                    $return = array_unique($return);

                    return $return;
               }
}
