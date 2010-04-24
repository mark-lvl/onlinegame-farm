<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

	class User_model extends Model
	{
		function User_model() {
			parent::Model();
                        $this->lang->load('labels', 'persian');
		}

		function is_authenticated()
                {
		    if(!isset($_SESSION['user']))
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
                            $_SESSION['user'] = serialize($user);
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
                    if(is_object($user))
                        $user_id = $user->id;
                    else
                        $user_id = $user;
                    
		    $sql = "SELECT * FROM `relations` A, `users` B WHERE (A.`inviter` = " . $this->db->escape($user_id) ." OR A.`guest` = " . $this->db->escape($user_id) . ") AND A.status = 1 AND B.id != " . $this->db->escape($user_id) ." AND (B.id = A.`inviter` OR B.id = A.`guest`) ORDER BY B.last_login_date DESC";
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
		
		function invite_friend($user_id, $email) {
		    $sql = "SELECT * FROM `users` WHERE email = " . $this->db->escape($email);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    if(count($result) > 0) {
		        return 1;
		    }

			$sql = "SELECT * FROM `invitations` WHERE friend_email = " . $this->db->escape($email);
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
			if(count($result) > 0) {
		        return 2;
		    }

			$sql = "INSERT INTO `invitations` (`user_id`, `friend_email`, `hash`, `date_invited`) VALUES ('" . $user_id . "', " . $this->db->escape($email) . ", '" . md5($email) . "', '" . date("Y-m-d H:i:s") . "')";
			$result = $this->db->query($sql);
			if($result) 
                        {
                            $this->load->helper('email');

                            $message = str_replace(array('__BASEPATH__',
                                             '__HASH__'),
                                        array(base_url(),
                                              md5($email)),
                                        $this->lang->language['inviteMailBody']);

                            send_email($user['email'], $this->lang->language['inviteMailTitle'], $message);

			    return 0;
			}
			return 3;
		}
                
                function forgot_password($data) {
                    $fetchUser = $this->db->get_where('users', array('email' => $data))->result_array();

                    $user = $fetchUser[0];

                    if(empty ($user))
                        return FALSE;
                    else
                    {
                        $this->load->helper('email');

                        $message  = "$user[first_name] $user[last_name], ";
                        $message .= " password:";
                        $message .= $user['plain_password'];

                        send_email($user['email'], 'Forgotten Password From Renault', $message);

                        return TRUE;

                        }

                }

		function accept_invitation($hash)
                {
                    $sqlFinder = "SELECT hash,friend_email,user_id FROM `invitations` WHERE hash = ".$this->db->escape($hash).";";

                    $query = $this->db->query($sqlFinder);
                    $invitation = $query->row();

                    if($invitation->hash == $hash)
                    {
                            $sqlUpdate = "UPDATE `invitations` SET `status` = 1,
                                                             `date_answered` = '" . date("Y-m-d H:i:s") . "'
                                                         WHERE status = 0
                                                            AND user_id = " . $invitation->user_id . "
                                                            AND friend_email = '" . $invitation->friend_email ."';";
                            if($this->db->query($sqlUpdate))
                                return $invitation->user_id;
                            else
                                return FALSE;
                    }
                    else
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


		function add_notification($farm_id,$body, $type, $details = null)
                {
                    if($type == 3)
                    {
                        $query = "SELECT id FROM `notifications` WHERE `details` = ".$this->db->escape($details).";";
                        $result = $this->db->query($query);
                        $result = $result->result_array();
                        //this section controll not sending multiple notification for the same lack resource
                        if(count($result) < 2)
                            $addNotQry = "INSERT INTO `notifications` (`farm_id`, `details`, `body`, `type`, `create_date`)
                                                VALUES (" . $this->db->escape($farm_id) .", " .
                                                            $this->db->escape($details) .", " .
                                                            $this->db->escape($body) .", " .
                                                            $this->db->escape($type).", UNIX_TIMESTAMP())";
                    }
                    else
                        $addNotQry = "INSERT INTO `notifications` (`farm_id`, `body`, `type`, `create_date`)
                                            VALUES (" . $this->db->escape($farm_id) .", " .
                                                        $this->db->escape($body) .", " .
                                                        $this->db->escape($type).", UNIX_TIMESTAMP())";
                    if($addNotQry)
                        if($this->db->query($addNotQry)) {
                            return TRUE;
                        }
                        else {
                            return FALSE;
                        }
		}

		function get_notifications($farmId) {
		    $sql = "SELECT * FROM `notifications`  WHERE  `farm_id` = " . $this->db->escape($farmId) . " ORDER BY `create_date` ASC LIMIT 10";
		    $result = $this->db->query($sql);
		    $result = $result->result_array();
		    
		    if(count($result) > 0) {
		        return $result;
		    }
		    else {
		        return FALSE;
		    }
		}

                function deleteNotification($id)
                {
                    $sql = "DELETE FROM `notifications` WHERE id =".$this->db->escape($id).";";
                    $result = $this->db->query($sql);
                    if($result)
                            return TRUE;
                    else
                            return FALSE;
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
		
		
		function get_count_users($filter = "") {
		    if($filter != "") {
		    	$filter = " WHERE CONCAT(first_name, ' ', last_name) LIKE '%" . $filter . "%'";
		    }
		    $sql = "SELECT COUNT(*) cnt FROM `users`" . $filter;
		    $result = $this->db->query($sql)->result_array();
		    
		    return $result[0]['cnt'];
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
