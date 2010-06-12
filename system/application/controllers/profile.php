<?php
class Profile extends MainController
{
        const SIGN_DEFFENSE_AMOUNT = 20;
        const SIGN_ATTACK_AMOUNT = 5;
        const SIGN_FAMOUS_AMOUNT = 50;
        const SIGN_SHOVEL_AMOUNT = 0;
        const SIGN_SICKLE_AMOUNT = 2;
        const SIGN_CLOCK_AMOUNT = 4;
        const SIGN_GRASSHOPPERS_AMOUNT = 20;
        const SIGN_PRODUCT_AMOUNT = 1000;

	function Profile()
	{
		parent::MainController();
                $this->load->model(array('Farm','Notification','Farmtransaction','Userrank'));
                $this->add_css('home');
                $this->add_css('profile');

                $this->loadJs('jquery.loading/jquery.loading');
	}

	function index()
	{
		header("Location: " . base_url());
	    die();
	}

	function user($id = "")
        {
	    if($id == "" || !preg_match_all ("/(\\d+)/is", $id, $matches))
                    redirect("/");

	    $user = $this->user_model->is_authenticated();
            $user->profilePage = TRUE;

            if(!$user)
                    redirect("/");

	    if($id != $user->id)
            {
                //this variable shows that this profile not for login user
                $this->data['partner'] = true;

	    	$user_profile = $this->user_model->get_user_by_id($id); //Fetch the owner of profile's information
            }
            else
                $user_profile = $user;

	    if(!$user_profile)
                    redirect("message/index/12");

            $this->data['title']        = $this->lang->language['profile_title'] . " " . $user_profile->first_name;
            $this->data['heading']        = '';
	    $this->data['user']         = $user;
            $this->data['user_profile'] = $user_profile;
	    $this->data['user_profile']->is_related = User_model::is_related($user_profile, $user->id);

            $farmSql = "SELECT f.id,f.user_id,f.name,f.money,f.section,f.level,f.disactive,p.health,t.name AS plantName
                        FROM `farms` AS f
                        LEFT JOIN `plants` AS p ON (f.id = p.farm_id AND p.reap = 0)
                        LEFT JOIN `types` AS t ON (p.type_id = t.id)
                        WHERE f.user_id = ".$user_profile->id." ORDER BY f.create_date DESC LIMIT 1;";

            $farmQuery = $this->db->query($farmSql);
            $this->data['userFarm'] = $farmQuery->row();

            $unreadMesSql = "SELECT count(m.id) AS unreadMess FROM `messages` AS m WHERE m.to = $user_profile->id AND m.checked = 0";
            $farmMessQuery = $this->db->query($unreadMesSql);

            if(!$this->data['userFarm']->id)
                $this->data['userFarm'] = new stdClass();

            $this->data['userFarm']->unreadMess = $farmMessQuery->row()->unreadMess;

            $friends = $this->user_model->get_friends($user_profile);

            if($this->data['userFarm']->id)
            {
                $notMdl = new Notification();
                $notObjs = $notMdl->where(array('farm_id'=>$this->data['userFarm']->id))->where_in('type',array(0,3))->get()->all;
                $this->data['hints'] = $notObjs;

                $usrRnkMdl = new Userrank();
                $usrRnkObjs = $usrRnkMdl->get_where(array('user_id' => $this->data['userFarm']->user_id))->all;
                foreach($usrRnkObjs AS $usrRnkObj)
                {
                    if($usrRnkObj->type == 0)
                    {
                            $farmSign['topLevel']['accept'] = TRUE;
                            $farmSign['topLevel']['detail'] = $usrRnkObj->rank;
                    }
                    elseif($usrRnkObj->type == 1)
                    {
                            $farmSign['endGame']['accept'] = TRUE;
                            $farmSign['endGame']['detail'] = $usrRnkObj->rank;
                    }
                    elseif($usrRnkObj->type == 3 )
                    {
                            if($usrRnkObj->rank > self::SIGN_PRODUCT_AMOUNT)
                                $farmSign['bigProduct']['accept'] = TRUE;
                            else
                            {
                                if(!$usrRnkObj->rank)
                                    $usrRnkObj->rank = '0';
                                else
                                    $farmSign['bigProduct']['detail'] = $usrRnkObj->rank;
                            }
                    }

                    elseif($usrRnkObj->type == 2)
                            $farmSign['grasshoppers']['accept'] = TRUE;
                }


                $sql = "SELECT fa.count , a.type FROM `farmaccessories` AS fa
                                                 LEFT JOIN `accessories` AS a
                                                 ON (fa.accessory_id = a.id)
                                                 WHERE fa.farm_id =". $this->data['userFarm']->id ."
                                                 AND fa.count > 0;";
                $query = $this->db->query($sql);
                $farmAccessories = $query->result();

                $bars['attackBar'] = 0;
                $bars['deffenceBar'] = 0;
                $bars['helpBar'] = 0;

                foreach($farmAccessories AS $accessory)
                {
                    if($accessory->type == 1)
                    {
                            $bars['attackBar'] += 10;
                            if($accessory->count > 1)
                                    $bars['attackBar'] += ($accessory->count - 1);

                            if(!$farmSign['grasshoppers'])
                                if($accessory->accessory_id == 2)
                                {
                                    $farmSign['grasshoppers']['detail'] = $accessory->count;
                                    if($accessory->count > self::SIGN_GRASSHOPPERS_AMOUNT)
                                    {

                                        $userRank = new Userrank();
                                        $userRank->user_id = $this->data['userFarm']->id;
                                        $userRank->type = 2;
                                        $userRank->save();
                                    }
                                }

                    }
                    elseif($accessory->type == 2)
                            $bars['deffenceBar'] += 15;
                }

                $frmTrnMdl = new Farmtransaction();
                $frmTrnObjs = $frmTrnMdl->where('offset_farm',$this->data['userFarm']->id)
                                        ->or_where('goal_farm',$this->data['userFarm']->id)
                                        ->get()->all;


                foreach ($frmTrnObjs as $frmTransaction)
                        if(($frmTransaction->offset_farm == $this->data['userFarm']->id) && ($frmTransaction->type != 3))
                        {
                                if($frmTransaction->flag == 1)
                                    $attack++;

                                $bars['attackBar']++;
                                $frmTransaction->messageStyle = "offensiveBox";
                        }
                        elseif(($frmTransaction->goal_farm == $this->data['userFarm']->id) && ($frmTransaction->type != 3))
                        {
                                $deffence++;
                                $frmTransaction->messageStyle = "attackBox";
                        }
                        elseif(($frmTransaction->offset_farm == $this->data['userFarm']->id) && ($frmTransaction->type == 3))
                        {
                                $frmTransaction->messageStyle = "helpBox";
                                $bars['helpBar'] += 5;
                        }

                $this->data['transactions'] = $frmTrnObjs;

                $num_friends = count($friends);

                //freinds count can improve user deffence bar
                $bars['deffenceBar'] += $num_friends;

                if($attack > self::SIGN_ATTACK_AMOUNT)
                    $farmSign['attack']['accept'] = TRUE;
                else
                {
                    if(!$attack)
                        $attack = '0';
                    $farmSign['attack']['detail'] = $attack;
                }

                if($deffence > self::SIGN_DEFFENSE_AMOUNT)
                    $farmSign['deffence']['accept'] = TRUE;
                else
                {
                    if(!$deffence)
                        $deffence = '0';
                    $farmSign['deffence']['detail'] = $deffence;
                }

                if($num_friends > self::SIGN_FAMOUS_AMOUNT)
                    $farmSign['famous']['accept'] = TRUE;
                else
                {
                    if(!$num_friends)
                        $num_friends = '0';
                    $farmSign['famous']['detail'] = $num_friends;
                }


                $sqlSign = "SELECT id FROM `farmmissions`
                            WHERE id IN (SELECT id FROM `farmmissions` WHERE farm_id = 1 GROUP BY mission_id HAVING count(*) = 1)
                            AND farm_id = ".$this->data['userFarm']->id."
                            AND status = 1";

                $querySign = $this->db->query($sqlSign);
                $oneTryMission = $querySign->num_rows();

                if($querySign->num_rows() > self::SIGN_SHOVEL_AMOUNT)
                        $farmSign['goldenShovel']['accept'] = TRUE;
                else
                {
                    if(!$querySign->num_rows())
                            $farmSign['goldenShovel']['detail'] = '0';
                    else
                            $farmSign['goldenShovel']['detail'] = $querySign->num_rows();

                }

                if($querySign->num_rows() > self::SIGN_SICKLE_AMOUNT)
                        $farmSign['goldenSickle']['accept'] = TRUE;
                else
                {
                    if(!$querySign->num_rows())
                            $farmSign['goldenSickle']['detail'] = '0';
                    else
                            $farmSign['goldenSickle']['detail'] = $querySign->num_rows();

                }

                if($querySign->num_rows() > self::SIGN_CLOCK_AMOUNT)
                        $farmSign['goldenClock']['accept'] = TRUE;
                else
                {
                    if(!$querySign->num_rows())
                            $farmSign['goldenClock']['detail'] = '0';
                    else
                            $farmSign['goldenClock']['detail'] = $querySign->num_rows();

                }

                foreach ($bars as &$bar)
                        if($bar > 100)
                                $bar = 100;

                $this->data['bars'] = $bars;
            }
            else
                $this->data['mainFarm'] = $this->load->view('farms/register.php', $this->data, TRUE);

            if(empty($this->data['transactions']))
            {
                $trans = new stdClass();
                $trans->type = 3;
                $trans->flag = "newUser";
                $trans->create_date = 1276076502;
                $transactions[] = $trans;
                $this->data['transactions'] = $transactions;
            }

            if(empty($this->data['hints']))
            {
                for($i=1;$i<5;$i++)
                {
                    $hint = new stdClass();
                    $hint->id = $i;
                    $hint->body = $this->lang->language["hint-$i"];
                    $hint->create_date = "1276076502";
                    $notObjs[] = $hint;
                }
                $this->data['hints'] = $notObjs;
            }



            if(User_model::is_related($user_profile, $user->id))
                $this->data['user_profile']->is_blocked = true;

	    $this->data['friends'] = $friends;

            $this->data['farmSign'] = $farmSign;

	    $this->add_css('jquery.jcarousel');
            $this->add_css('skin');
            $this->add_css('boxy');
            $this->add_css('validation');
            $this->loadJs('jquery.jcarousel');
            $this->loadJs('jquery.validationEngine-fa');
            $this->loadJs('jquery.validationEngine');
	    $this->loadJs('jquery.progressbar');
            $this->loadJs('boxy');
            $this->loadJs('generals');
            $this->loadJs('jquery.hints');
            $this->render('home');

	}



        function edit($id = "")
        {
	    $user = $this->user_model->is_authenticated();

            if($_POST['ok'])
            {
                    $userHolder = new user_entity($_POST);

                    $user->first_name = $userHolder->first_name;
                    $user->last_name = $userHolder->last_name;
                    $user->sex = $userHolder->sex;
                    $user->birthdate = $userHolder->birthdate;
                    $user->city	= $userHolder->city;
                    $fields = array("first_name", "last_name", "email", "sex", "birthdate", "city");

                    if(isset($_POST['password']) && $_POST['password'] != "") {
                        $user->password = md5($_POST['password']);
                        $fields[] = "password";
                    }
                    if($this->user_model->update($user, $fields))
                            redirect("profile/user/$user->id");
            }

            if($_POST['user_id'] == "" || !preg_match_all ("/(\\d+)/is", $_POST['user_id'], $matches))
                    redirect("profile/user/$user->id");


	    if($_POST['user_id'] != $user->id)
                    redirect("profile/user/$user->id");

            if(!$user)
                    $this->js_redirect('/');

            $this->data['heading']        = '';
            $this->data['user_profile'] = $user;


            $this->load->view("profile/edit.tpl.php", $this->data);
	}
        
        function avatar()
        {
	    $user = $this->user_model->is_authenticated();


            if(!$user)
                    $this->js_redirect('/');

            $this->data['heading']        = '';
            $this->data['user_profile'] = $user;


            $this->load->view("profile/avatar.tpl.php", $this->data);
	}
        function inbox($id = "")
        {
	    $user = $this->user_model->is_authenticated();

            if(!$user)
                    $this->js_redirect('/');

	    //TODO ghange that when layout is available.
            $this->data['title']        = $this->lang->language['inbox'];
            $this->data['heading']        = '';
            $this->data['user_profile'] = $user;

            $this->data['messages'] = user_model::get_messages($user);

		$this->data['unchecked'] = 0;
		if(is_array($this->data['messages']) && count($this->data['messages']) > 0) {
			foreach($this->data['messages'] as $x => $k) {
			    if($k['checked'] == 0) {
	                $this->data['unchecked']++;
			    }
			}
		}


            $this->load->view("profile/inbox.tpl.php", $this->data);
	}
        function history()
        {
            $user = $this->user_model->is_authenticated();

            if(!$user)
                    $this->js_redirect('/');

	    //TODO ghange that when layout is available.
            $this->data['title']        = $this->lang->language['inbox'];
            $this->data['heading']        = '';
            $this->data['user_profile'] = $user;

            $this->data['messages'] = user_model::get_messages($user);

		$this->data['unchecked'] = 0;
		if(is_array($this->data['messages']) && count($this->data['messages']) > 0) {
			foreach($this->data['messages'] as $x => $k) {
			    if($k['checked'] == 0) {
	                $this->data['unchecked']++;
			    }
			}
		}


            $this->load->view("profile/history.tpl.php", $this->data);
        }



        function seeAllFriends($user_id = null)
        {
            $params['friends'] = $this->user_model->get_friends($_POST['user_id']);

            $this->error_reporter('list',$params);
        }
        function inviteFriend()
        {
            $return = $this->user_model->invite_friend($_POST['user'],$_POST['email']);
            switch ($return) {
                case 0:
                        echo $this->lang->language['invitation-complete'];
                    break;
                case 1:
                        echo $this->lang->language['invitation-isUser'];
                    break;
                case 2:
                        echo $this->lang->language['invitation-beforeInvited'];
                    break;
                case 3:
                        echo $this->lang->language['invitation-notComplete'];
                    break;

                default:
                    break;
            }
        }
        function sendMessage()
        {
            $return = $this->user_model->send_message($_POST['from'], $_POST['to'], str_replace('__USERNAME__', $_POST['senderName'], $this->lang->language['message_title']) , $_POST['message']);
            if($return)
                echo $this->lang->language['send_message_successfull'];
            else
                echo $this->lang->language['send_message_faild'];

        }
        function addToFriend($id = "")
        {
            $user = $this->user_model->is_authenticated();
            if(!$user) {
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_title17'],'height'=>40));
                return FALSE;
            }
	    if($_POST['id'] == "" || !preg_match_all ("/(\\d+)/is", $_POST['id'], $matches))
            {
                $this->error_reporter('public',array('message'=>$this->lang->language['m_title8']));
                return FALSE;
            }

	    if($this->user_model->relate_users($user, $_POST['id']))
            {
	    	user_model::send_message($user->id, $_POST['id'], str_replace("XXX", $user->first_name, $this->lang->language['add_request']), str_replace("XXX", $user->id, $this->lang->language['add_requestbody']));
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_title5'],'height'=>40));
                return FALSE;
	    }
	    else {
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_body6'],'height'=>50));
                return FALSE;
	    }
	}
        function deleteFriend($id = "")
        {
            $user = $this->user_model->is_authenticated();
            if(!$user) {
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_title17'],'height'=>40));
                return FALSE;
            }
	    if($_POST['id'] == "" || !preg_match_all ("/(\\d+)/is", $_POST['id'], $matches)) {
		$this->error_reporter('public',array('message'=>$this->lang->language['m_title8']));
                return FALSE;
	    }

	    if($this->user_model->delete_relation($_POST['id'], $_POST['user_id'])) {
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_title7'],'height'=>40));
                return FALSE;
	    }
	    else {
		$this->error_reporter('alert',array('message'=>$this->lang->language['m_body8'],'height'=>40));
                return FALSE;
	    }
	}
        function abuseReport($id = "")
        {
	    	$user = $this->user_model->is_authenticated();

            if(!$user)
            {
                $this->error_reporter('alert',array('message'=>$this->lang->language['m_title17'],'height'=>40));
                return FALSE;
            }
			if($_POST['id'])
			{
				$this->data['id'] = $_POST['id'];
				$this->load->view("profile/abuse.tpl.php", $this->data);
			}
			else
			{
				$_POST['user_id'] = (int)$_POST['user_id'];
            	if(!$_POST['user_id'])
					echo $this->lang->language['m_title8'];

				$sql = "SELECT * FROM `abuse` WHERE user_id = " . $this->db->escape($_POST['user_id']) . " AND sender = " . $this->db->escape($user->id). " AND type = " . $_POST['abuseType'];
	    		$result = $this->db->query($sql);
	    		$result = $result->result_array();
	    		if(is_array($result) && count($result) > 0)
					echo $this->lang->language['m_title13'];
			    else {
		    		$sql = "INSERT INTO `abuse` (user_id, sender, type, `date`) VALUES (" . $this->db->escape($_POST['user_id']) . ", " . $this->db->escape($user->id). ", " . $this->db->escape($_POST['abuseType']) . ", '" . date("Y-m-d H:i:s") . "')";
		    		$this->db->query($sql);

					echo $this->lang->language['m_body14'];
	            }
			}
	}
}