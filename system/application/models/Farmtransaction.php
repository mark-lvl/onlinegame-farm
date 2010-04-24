<?php
class Farmtransaction extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;
	var $updated_field = 'modified_date';
	var $sprayingPrice = 100;
	var $accMdl;
        const  GUNACCID = 5;
        const  SCARECROWACCID = 7;
        const  DOGACCID = 8;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model(array('Accessory','Plant','Farmaccessory','User_model'));
		$this->accMdl = new Accessory();
                $this->lang->load('labels', 'persian');
    	}

	function add($off_farm,
		     $goal_farm,
		     $accessory_id,
		     $type,
		     $details = null)
	{
		$frmMdl = new Farm();
		$frmObjOff = $frmMdl->get_by_id($off_farm);
                $frmMdl = new Farm();
		$frmObjGol = $frmMdl->get_by_id($goal_farm);



		//farm with level 1,2,3 only attack from farm with the same level
		if($frmObjGol->level < 4 && $frmObjOff > 3 && $type == 1)
			return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttackToLevelBelow3'));

                //offset farm only attack goal farm once a day
                $frmTrnMdl = new Farmtransaction();
                $frmTrnObj = $frmTrnMdl->get_where(array('offset_farm'=>$off_farm,
                                                         'goal_farm'=>$goal_farm,
                                                         'type'=>1));
                if($frmTrnObj->create_date > strtotime('-1 day'))
                       return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttackTwiceInADay'));
                unset($frmTrnMdl);
                unset($frmTrnObj);


                //cant attack to farm havn't anti this accessory level
		if($accessory_id)
		{
                	$accMdl = new Accessory();
	                $accObj = $accMdl->get_by_id($accessory_id);
        	        if($frmObjGol->level < $accObj->level)
                	        return array('return'=>'false',
                        	             'type'=>'public',
                                	     'params'=>array('message'=>'cantAttackWithHavntAnti'));
	                unset ($accObj);
		}

                //farm with no plant rejected new attack
                $pltMdl = new Plant();
                $pltObj = $pltMdl->get_where(array('farm_id'=>$goal_farm, 'reap'=>0));
                if(!$pltObj->exists())
                        return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttackBeacuseHavntPlant'));

		if($type == 1)
		{
			//each time only attack to goal_farm once
        	        $frmTrnObj = new Farmtransaction();
                	$attackedFarmByOffset = $frmTrnObj->get_where(array('goal_farm'=>$goal_farm, 'offset_farm'=>$off_farm, 'type'=>1,'flag'=>0));
	                if($attackedFarmByOffset->exists())
        	                return array('return'=>'false',
                	                     'type'=>'public',
                        	             'params'=>array('message'=>'cantAttackAttackAlreadyExists'));
                
	                //farm with have 5 attack rejected new attack
        	        $frmTrnObj = new Farmtransaction();
			$attackedFarm = $frmTrnObj->get_where(array('goal_farm'=>$goal_farm,'type'=>1,'flag'=>0));
			if($attackedFarm->count() > 5)
				return array('return'=>'false',
                	                     'type'=>'public',
                        	             'params'=>array('message'=>'cantAttack'));
			else
			{
				$frmAccMdl = new Farmaccessory();
				$frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$off_farm, 'accessory_id'=>$accessory_id));
				if($frmAccObj->count > 0)
				{
					$frmAccObj->count--;
					$frmAccObj->save();
                	                $frmTrnObj = new Farmtransaction();
					$frmTrnObj->offset_farm = $off_farm;
					$frmTrnObj->goal_farm = $goal_farm;
					$frmTrnObj->type = $type;
					$frmTrnObj->accessory_id = $accessory_id;
					$accMdl = new Accessory();
					$accObj = $accMdl->get_by_id($accessory_id);
                        	        $frmTrnObj->efficacy_date = (time() + ($accObj->life_time * 3600));
					$frmTrnObj->save();
                	                $usrMdl = new User_model();
                        	        if($frmObjOff->id)
               		                         $details .= "<br/>".str_replace(array(__FARMID__,__FARMNAME__), array($frmObjOff->user_id,$frmObjOff->name), $this->lang->language['farmTransaction']['attacker']);
                        	        $usrMdl->add_notification($goal_farm, $details, 0);
					return $frmAccObj->count;
				}
				else
				return array('return'=>'false',
                                	     'type'=>'public',
	                                     'params'=>array('message'=>'cantAttack'));

			}
		}
		else
		{
			//this section for adding help transaction

			$frmTrnObj = new Farmtransaction();
			$frmTrnObj->offset_farm = $off_farm;
			$frmTrnObj->goal_farm = $goal_farm;
			$frmTrnObj->type = $type;
			$frmTrnObj->details = $details;
			$frmTrnObj->save();
			return TRUE;
		}
	}

	function getFarmTransaction($farm_id, $pltObj = null)
	{
		if(is_null($pltObj))
			return FALSE;
		$frmMdl = new Farm();
		$frmObj = $frmMdl->get_by_id($farm_id);

		$goalFarms = $this->get_where(array('goal_farm'=>$farm_id,'flag'=>0))->all;
		
		foreach($goalFarms AS $goal)
		{
			switch($goal->accessory_id)
			{
				case 1:
					$this->type_1_effect($goal, $frmObj, &$pltObj);
					break;
                                case 2:
                                        $this->type_1_effect($goal, $frmObj, &$pltObj);
                                        break;
                                case 4:
                                        $this->type_4_effect($goal, $frmObj, &$pltObj);
                                        break;
                                case 6:
                                        $this->type_4_effect($goal, $frmObj, &$pltObj);
                                        break;
			}
		}
	}
	
	function type_1_effect($transaction, $farm, $plant)
	{
                if(!$this->autoSpraying($transaction, $farm))
                {
                        $accessory = $this->accMdl->get_by_id($transaction->accessory_id);
                        $consumeTime = ($accessory->life_time * 3600) / $accessory->effect;
                        $effectTime = time() - $transaction->modified_date;
                        $decHolder = (int)($effectTime / $consumeTime);//echo $transaction->modified_date;exit;

                        $plant->health -= $decHolder;
                        if($plant->health < 20)
                                $plant->health = 20;
                        $plant->updated_field = null;
                        $plant->save();

                        if(time() > $transaction->efficacy_date)
                                //$transaction->flag = 1;
                                $this->changeTransactionFlag(&$transaction, 1);
                        else
                                $transaction->flag = 0;

                        if($decHolder > 1 || (time() > $transaction->efficacy_date))
                        $transaction->save();
                }
	}
        
	function type_4_effect($transaction, $farm, $plant)
	{
                $accessory = $this->accMdl->get_by_id($transaction->accessory_id);
                $consumeTime = ($accessory->life_time * 3600) / $accessory->effect;
                $effectTime = time() - $transaction->modified_date;
                $decHolder = (int)($effectTime / $consumeTime);

                $decHolder = $this->deffenceWithScarecrow($farm, $decHolder);
                $dogFuncHolder = $this->deffenceWithDog($farm, $decHolder,&$transaction);
                $decHolder = $dogFuncHolder['decHolder'];

                $plant->weight -= $decHolder;
                if($plant->weight < 0)
                        $plant->weight = 0;
                $plant->updated_field = null;
                $plant->save();

                if(time() > $transaction->efficacy_date)
                        //$transaction->flag = 1;
                        $this->changeTransactionFlag(&$transaction, 1);
                else
                        $transaction->flag = 0;

                if($decHolder > 1 || (time() > $transaction->efficacy_date) || $transaction->alert_flag)
                        $transaction->save();
	}

        function autoSpraying($transaction, $farm)
        {
                //assume sprayer accessory_id is 3
                $frmAccMdl = new Farmaccessory();
                $frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$farm->id, 'accessory_id'=>3));
                if($frmAccObj->exists())
                {
                        if($farm->money > 100)
                        {
                                $farm->money -= $this->sprayingPrice;
                                $farm->save();
                                //$transaction->flag = 2;
                                $this->changeTransactionFlag(&$transaction, 2);
                                if($transaction->save())
                                    return TRUE;
                                else
                                    return FALSE;
                        }
                        else
                                return FALSE;
                }
        }

	function spraying($farm_id)
	{
                $frmMdl = new Farm();
                $farmObj = $frmMdl->get_by_id($farm_id);

		if($farmObj->money < $this->sprayingPrice)
		{
			return array('return'=>'false',
                                               'type'=>'money',
                                               'params'=>array('money'=>$farmObj->money,
                                                               'price'=>$this->sprayingPrice));
		}
		else
		{
                        $pltMdl = new Plant();
                        $pltMdl->plantSync($farm_id);

			$attack = $this->get_where(array('goal_farm' => $farmObj->id,
					                 'flag' => 0))
                                        //TODO this can be hold others accessory affect by spraying
                                        ->where_in('accessory_id', array(1,2))
                                        ->where_in('type', array(1,4))
			                ->order_by('create_date', 'asc');

                        if($attack->exists())
                        {
                            $this->changeTransactionFlag(&$attack, 2 , $_POST);
                            $attack->save();
                            $farmObj->money -= $this->sprayingPrice;
                            $farmObj->save();


                            $accessory = $this->accMdl->get_by_id($attack->accessory_id);
                            $consumeTime = ($accessory->life_time * 3600) / $accessory->effect;
                            $effectTime = time() - $attack->create_date;
                            $decHolder = (int)($effectTime / $consumeTime);

                            $return['params']['affectTime'] = time() - $attack->create_date;

                            $return['params']['decHealth'] = $decHolder;
                            $return['params']['accessory'] = $accessory->name;
                            $return['type'] = 'spraying';
                            $return['return'] = 'true';
                            return $return;
                        }
                        else
                        {
                            return array('return'=>'false',
                                         'type'=>'public',
                                         'params'=>array('message'=>'farmNotNeedSpray'));
                        }
		}
	}

	function deffenceWithGun($farm_id)
	{
                $pltMdl = new Plant();
                $pltMdl->plantSync($farm_id);

                $attack = $this->where(array('goal_farm' => $farm_id,
                                                 'flag' => 0))
                                //TODO this can be hold others accessory affect by spraying
                                ->where_in('accessory_id', array(4,6))
                                ->where_in('type', array(1))
                                ->order_by('create_date', 'asc')->get();

                if($attack->exists())
                {
                    $frmAccMdl = new Farmaccessory();
                    $frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$farm_id,'accessory_id'=>self::GUNACCID));
                    if($frmAccObj->count > 0 )
                    {
                            $frmAccObj->count--;
                            $frmAccObj->save();
                            //$attack->flag = 2;
                            $this->changeTransactionFlag(&$attack, 2, $_POST);
                            $attack->save();

                            $accessory = $this->accMdl->get_by_id($attack->accessory_id);
                            $consumeTime = ($accessory->life_time * 3600) / $accessory->effect;
                            $effectTime = time() - $attack->create_date;
                            $decHolder = (int)($effectTime / $consumeTime);

                            $return['params']['affectTime'] = time() - $attack->create_date;

                            $return['params']['decWeight'] = $decHolder;
                            $return['params']['accessory'] = $accessory->name;
                            $return['type'] = 'gun';
                            $return['return'] = 'true';
                            return $return;
                    }
                    else
                            return array('return'=>'false',
                                         'type'=>'public',
                                         'params'=>array('message'=>'lackAccessory'));
                }
                else
                {
                    return array('return'=>'false',
                                 'type'=>'public',
                                 'params'=>array('message'=>'farmNotNeedDeffence'));
                }
	}

        function deffenceWithScarecrow($farm, $decHolder)
        {
                $frmAccMdl = new Farmaccessory();
                $frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$farm->id,'accessory_id'=>self::SCARECROWACCID));
                if($frmAccObj->expire_date > time())
                {
                        $frmAccObj->delete();
                        return $decHolder;
                }
                else
                {
                        $accMdl = new Accessory();
                        $accObj = $accMdl->get_by_id(self::SCARECROWACCID);
                        return (($accObj->effect/100)*$decHolder);
                }
        }

        function deffenceWithDog($farm, $decHolder, $transaction)
        {
                $frmAccMdl = new Farmaccessory();
                $frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$farm->id,'accessory_id'=>self::DOGACCID));
                if($frmAccObj->exists())
                    if($frmAccObj->expire_date < time())
                    {
                            $frmAccObj->delete();
                            return $decHolder;
                    }
                    else
                    {
                            $accMdl = new Accessory();
                            $accObj = $accMdl->get_by_id(self::DOGACCID);

                            if($transaction->alert_flag == 0)
                            {
                                    $usrMdl = new User_model();
                                    $friends = $usrMdl->get_friends($farm->user_id);

                                    $friendNumber = count($friends);

                                    if($friendNumber > 10)
                                            for($i=0; $i < 10; $i++)
                                                    $friendsList[] = $friends[rand(0, $friendNumber)];
                                    else
                                            $friendsList = $friends;



                                    array_unique(&$friendsList);

                                    foreach($friendsList AS $friend)
                                            //TODO must change sender message form 1 to admin id
                                            $usrMdl->send_message(1, $friend->id, $this->lang->language['m_title10'], str_replace(__FARM__, $farm->id, $this->lang->language['m_body10']));

                                    $transaction->alert_flag = 1;
                            }

                            $return['decHolder'] = (($accObj->effect/100)*$decHolder);
                            $return['transaction'] = $transaction;

                            return $return;
                    }
                else
                {
                        $return['decHolder'] = $decHolder;
                        $return['transaction'] = $transaction;
                }
        }

        public function changeTransactionFlag($transaction,$flag, $details = null)
        {
                $usrMdl = new User_model();

                if($flag == 1)
                {
                        $transaction->flag = 1;
                        $usrMdl->add_notification($transaction->goal_farm,
                                                  $this->lang->language["farmTransactionDone-$transaction->accessory_id"],
                                                  1);
                }
                elseif ($flag == 2)
                {
                        $transaction->flag = 2;
                        if($details['viewer_farm_id'])
                        {
                                $usrMdl->add_notification($transaction->goal_farm,
                                                                    str_replace(array(__VIEWERID__,__VIEWERNAME__),
                                                                                array($details['viewer_id'],$details['viewer_name']),
                                                                                $this->lang->language["farmTransactionRejectByFreind-$transaction->accessory_id"]),
                                                                    4);
                                $frmTrnObj = new Farmtransaction();
                                $frmTrnObj->offset_farm = $details['viewer_farm_id'];
                                $frmTrnObj->goal_farm = $transaction->goal_farm;
                                $frmTrnObj->type = 3;
                                $frmTrnObj->details = "2".$transaction->accessory_id;
                                $frmTrnObj->save();
			}
                        else
                            $usrMdl->add_notification($transaction->goal_farm,
                                                      $this->lang->language["farmTransactionReject-$transaction->accessory_id"],
                                                      2);
                }
        }
}
?>
