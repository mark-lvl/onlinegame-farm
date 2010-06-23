<?php
class Plant extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;
	var $updated_field = 'modified_date';
        //this property hold maximum time in sec for die plant
        var $die_duration;

	const BONUS = 30;
	const RESOURCEDELAYNOTIFICATION = 120;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model(array('Plantresource',
					 'Type',
					 'Typeresource',
				         'Resource',
                                         'User_model',
                                         'Userrank'));

                $this->lang->load('labels', 'persian');
    	}

	function plantSync($id,$data = null)
        {
                $plantObj = new Plant();
                $plantObj->where('farm_id',$id);
		$plantObj->where('reap',0);
                $plantObj->limit(1);
                if($data)
                        foreach($data AS $key=>$value)
                                $plantObj->where($key,$value);

                $plants = $plantObj->get()->all;

                foreach($plants AS &$plant)
                {
			$typMdl = new Type();
			$typObj = $typMdl->get_by_id($plant->type_id);
                        $frmAccMdl = new Farmaccessory();
                        $plant->growth = $frmAccMdl->getGrowthDecreaser($id, $plant->create_date, $typObj->growth_time);

                        //this section calculate dieDuration of palnt based on growth time
                        if($typObj->growth_time < 3)
                                $this->die_duration = ($typObj->growth_time * 3600);
                        else
                                $this->die_duration = 7200;


                        $pltSrcMdl = new Plantresource();
                        $pltSrcObjs = $pltSrcMdl->get_where(array('plant_id'=>$plant->id))->all;
                        $plant->plantresources = $pltSrcObjs;
                        foreach($pltSrcObjs AS &$pltSrcObj)
                        {
                                $typSrcMdl = new Typeresource();
                                $typSrcObjs = $typSrcMdl->get_where(array('id'=>$pltSrcObj->typeresource_id))->all;
                                $pltSrcObj->typeresource = $typSrcObjs;
                                foreach($typSrcObjs AS &$typSrcObj)
                                {
                                        $resMdl = new Resource();
                                        $resource = $resMdl->get_by_id($typSrcObj->resource_id)->all;
                                        $typSrcObj->resource = $resource;
					if($typSrcObj->consumeTime)
                                        {
						$consumeTimeHolder = $typSrcObj->consumeTime * 3600;
                                                $srcLifeTimeHolder = $pltSrcObj->modified_date + $consumeTimeHolder;
                                                $srcLifeTimeHolder -= time();
						$currentDecreaser = (int)( $srcLifeTimeHolder / $consumeTimeHolder);
						if($currentDecreaser < 0)
							$currentDecreaser *= -1;
                                                if($srcLifeTimeHolder < 0)
						{
                                                        //this if create notification with delay for lack resource
                                                        if(abs($srcLifeTimeHolder) > self::RESOURCEDELAYNOTIFICATION)
                                                        {
                                                            $usrMdl = new User_model();
                                                            $usrMdl->add_notification($id,str_replace(__RESOURCE__, $this->lang->language['RESOURCE-'.$typSrcObj->resource_id], $this->lang->language['lackResource']),3,array('resource_id'=>$typSrcObj->resource_id,'details'=>$pltSrcObj->modified_date));
                                                        }
                                                        
                                                        for ($i = 0; $i <= $currentDecreaser; $i++)
								if($pltSrcObj->current)
								{
                                                                	$pltSrcObj->current -= $typSrcObj->minNeed;
									//disable the autoTimestamp for pltSrcMdl when decrease current count
									$pltSrcObj->updated_field = null;
									$pltSrcObj->save();
								}
								else
								{
                                                                        $healthDecHolder =  (int)(($srcLifeTimeHolder/$this->die_duration)*100);
								
									if($healthDecHolder < 0)
										$healthDecHolder *= -1;
									$plant->health -= $healthDecHolder;
							
									//this section check for health value decreased by another lack resource
									//if($plant->health > $planthealthHolder)
										//$plant->health = $planthealthHolder;
									if($plant->health < 20)
										$plant->health = 20;
									$plant->save();
								}
							$pltSrcObj->usedTime = 0;
						}
                                                //this elseif used for plants that being but havn't resources until now
                                                elseif($pltSrcObj->create_date == $pltSrcObj->modified_date)
                                                {
                                                        $createDateHolder = $plant->modified_date - time();
                                                        $pltSrcModifiedDateHolder = $pltSrcObj->modified_date - time();

                                                        if(abs($pltSrcModifiedDateHolder) > self::RESOURCEDELAYNOTIFICATION)
                                                        {
                                                            $usrMdl = new User_model();
                                                            $usrMdl->add_notification($id,str_replace(__RESOURCE__, $this->lang->language['RESOURCE-'.$typSrcObj->resource_id], $this->lang->language['lackResource']),3,array('resource_id'=>$typSrcObj->resource_id,'details'=>$pltSrcObj->modified_date));
                                                        }

                                                        $healthDecHolder =  (int)abs((($createDateHolder/$this->die_duration)*100));

                                                        $plant->health -= $healthDecHolder;

                                                        //this section check for health value decreased by another lack resource
                                                        //if($plant->health > $planthealthHolder)
                                                        //        $plant->health = $planthealthHolder;
                                                        if($plant->health < 20)
                                                                $plant->health = 20;
                                                        $plant->save();
                                                        $pltSrcObj->usedTime = 0;
                                                }
						else
						{
							$pltSrcObj->usedTime = $srcLifeTimeHolder;
						}

                                        }
                                }
                        }
                }
		$returnPlant = array_shift($plants);
		$frmTrnMdl = new Farmtransaction();
		$frmTrnMdl->getFarmTransaction($id, &$returnPlant);
                return $returnPlant;
        }

        //TODO must remove this method
	function getPlant($id,$data = null)
        {
                $plantObj = new Plant();
                $plantObj->where('farm_id',$id);
                $plantObj->limit(1);
                if($data)
                        foreach($data AS $key=>$value)
                                $plantObj->where($key,$value);

                $plants = $plantObj->get()->all;

                foreach($plants AS &$plant)
                {
                        $pltSrcMdl = new Plantresource();
                        $pltSrcObjs = $pltSrcMdl->get_where(array('plant_id'=>$plant->id))->all;
                        $plant->plantresources = $pltSrcObjs;
                        foreach($pltSrcObjs AS &$pltSrcObj)
                        {
                                $typSrcMdl = new Typeresource();
                                $typSrcObjs = $typSrcMdl->get_where(array('id'=>$pltSrcObj->typeresource_id))->all;
                                $pltSrcObj->typeresource = $typSrcObjs;
                                foreach($typSrcObjs AS &$typSrcObj)
                                {
                                        $resMdl = new Resource();
                                        $resource = $resMdl->get_by_id($typSrcObj->resource_id)->all;
                                        $typSrcObj->resource = $resource;
                                        if($typSrcObj->consumeTime)
                                        {
						$consumeTimeHolder = $typSrcObj->consumeTime * 3600;
                                                $srcLifeTimeHolder = $pltSrcObj->modified_date + $consumeTimeHolder;
                                                $srcLifeTimeHolder -= time();
						$currentDecreaser = (int)( $srcLifeTimeHolder / $consumeTimeHolder);
						if($currentDecreaser < 0)
							$currentDecreaser = $currentDecreaser * -1;
                                                if($srcLifeTimeHolder < 0)
						{
                                                        for ($i = 0; $i <= $currentDecreaser; $i++)
								if($pltSrcObj->current)
                                                                	$pltSrcObj->current --;
							$pltSrcObj->usedTime = 0;
						}
						else
						{
							$pltSrcObj->usedTime = $srcLifeTimeHolder;	
						}

                                        }
                                }
                        }
                }
                return array_shift($plants);
        }

	function add($farm_id, $type_id)
	{
		$pltModel = new Plant();

                //if have a plant don't reap return false
		if($pltModel->get_where(array('farm_id'=>$farm_id,'reap'=>0))->exists())
                        return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'plantExists'));
		else
		{
			$frmModel = new Farm();
			$farmPlowed = $frmModel->isPlow($farm_id);
                        
			if(is_array($farmPlowed))
				return $farmPlowed;
			else
			{
                            $typeModel = new Type();
                            $frmScrModel = new Farmresource();
                            $typScrModel = new Typeresource();
                            $srcModel = new Resource();
                            $misModel = new Mission();
                            $frmMisModel = new Farmmission();
                            $frmAccModel = new Farmaccessory();
                            $accModel = new Accessory();


                            $farmDetails = $frmModel->get_by_id($farm_id);
                            $typeDetails = $typeModel->get_by_id($type_id);

                            //this section calculate number of section in farm
                            //multiple by plantType price and return total price
                            $totalPrice = $farmDetails->section * $typeDetails->price * $typeDetails->weight;

                            if($totalPrice > $farmDetails->money)
                                    return array('return'=>'false',
                                                 'type'=>'moneyAlert',
                                                 'params'=>array('money'=>$farmDetails->money,
                                                                 'price'=>$totalPrice));
                            else
                            {
                                    $misObj = $misModel->get_where(array('level'=>$farmDetails->level));
                                    $frmMisObj = $frmMisModel->get_where(array('mission_id'=>$misObj->id,
                                                                               'farm_id'=>$farmDetails->id,
                                                                               'status'=> 0 ));

                                    //this section check for this farm haven't same mission
                                    if(!$frmMisObj->exists())
                                    {
                                            if($misObj->needed_accessory)
                                            {
                                                $neededAccessories = unserialize($misObj->needed_accessory);

                                                $lackAccessory = array();
                                                
                                                foreach($neededAccessories AS $nedAcc)
                                                {
                                                        $frmAccObj = $frmAccModel->get_where(array('farm_id'=>$farmDetails->id,
                                                                                                   'accessory_id'=>$nedAcc));

                                                        if(!$frmAccObj->exists())
                                                        {
                                                                $accObj = $accModel->get_by_id($nedAcc);
                                                                $lackAccessory[] = $accObj->name;
                                                        }
                                                }

                                                if(count($lackAccessory))
                                                {
                                                    return array('return'=>'false',
                                                                 'type'=>'accessory',
                                                                 'params'=>array('accessories'=>$lackAccessory));
                                                }
                                            }
                                            $typeResources = $typScrModel->get_where(array('type_id'=>$type_id))->all;

                                            //check for min requirment resource for create this type of plant
                                            foreach($typeResources AS $tr)
                                            {
                                                    $frmResources = $frmScrModel->get_where(array('farm_id'=>$farm_id,
                                                                                                  'resource_id'=>$tr->resource_id));
                                                    //TODO add type name
                                                    if($frmResources->count < $tr->minNeed)
                                                    {
                                                            $srcDetails = $srcModel->get_by_id($tr->resource_id);
                                                            return array('return'=>'false',
                                                                         'type'=>'resource',
                                                                         'params'=>array('farm_resource'=>$frmResources->count,
                                                                                         'resource'=> $srcDetails->name,
                                                                                         'need'=>$tr->minNeed ));
                                                    }
                                            }


                                            //for calculate money based on Farm->section,Type->weight,Type->price
                                            $farmDetails->money = $farmDetails->money - ($farmDetails->section * $typeDetails->weight * $typeDetails->price);
                                            $farmDetails->save();

                                            //finaly save the plant
                                            $pltModel->weight = ($farmDetails->section * $typeDetails->weight);
                                            $pltModel->farm_id = $farm_id;
                                            $pltModel->type_id = $type_id;
                                            $pltModel->health  = 100;
                                            $pltModel->growth  = 0;

                                            //let's go baby!
                                            $pltModel->save();
                                            $lastPlantId = $this->db->insert_id();

                                            //this part set resource for plant
                                            reset($typeResources);
                                            foreach($typeResources AS $tr)
                                            {
                                                    $pltSrcModel = new Plantresource();
                                                    $pltSrcModel->plant_id = $lastPlantId;
                                                    $pltSrcModel->typeresource_id = $tr->id;
                                                    //$pltSrcModel->current = $tr->minNeed;
						    //$pltSrcModel->updated_field = null;
                                                    $pltSrcModel->save();
                                            }

                                            //this section set mission for farm
                                            $stackHolder = $frmMisModel->order_by("create_date", "desc")->get_where(array('farm_id'=>$farm_id,'mission_id'=>$misObj->id,'status'=>'2'), 1);
                                            unset ($frmMisModel);
                                            $frmMisModel = new Farmmission();
                                            $frmMisModel->stack    = $stackHolder->stack;
                                            $frmMisModel->farm_id    = $farm_id;
                                            $frmMisModel->mission_id = $misObj->id;
                                            $frmMisModel->plant_id   = $lastPlantId;
                                            $frmMisModel->save();

                                            return TRUE;
                                    }
                                    else
                                    {
                                            return array('return'=>'false',
                                                         'type'=>'public',
                                                         'params'=>array('message'=>'missionExists'));
                                    }
                            }
                    }
            }
		
	}

	function reap($plant_id)
	{
		$pltObj = $this->get_by_id($plant_id);
                $pltFrmId = $pltObj->farm_id;
                unset($pltObj);


                //first sync plant for reap that
                $pltObj = $this->plantSync($pltFrmId);
		
		$typMdl = new Type();
		$typObj = $typMdl->get_by_id($pltObj->type_id);
		$frmAccMdl = new Farmaccessory();
                $growthChecker = $frmAccMdl->getGrowthDecreaser($pltObj->farm_id, $pltObj->create_date, $typObj->growth_time);
		if($growthChecker > 0 && $pltObj->health > 0)
			return array('return'=>  'false',
                                                 'type'=>'public',
                                                 'params'=>array('message'=>'notReadyForReap'));

		$frmMdl = new Farm();
                $frmObj = $frmMdl->get_by_id($pltFrmId);


                //$farmCapacity = $typObj->weight * $frmObj->section;
                $farmCapacity = $pltObj->weight;
                $amountProduct = ($pltObj->health / 100) * $farmCapacity;
                $return['params']['amountProduct'] = $amountProduct;
                $return['params']['health'] = $pltObj->health;
                $return['params']['farmCapacity'] = $farmCapacity;
                $return['params']['typeName'] = $typObj->name;
                
                $cost = $amountProduct * $typObj->sell_cost;
                $return['params']['totalCost'] = $cost;

		//add bonus payment for full health product
                if($pltObj->health == 100 && ($farmCapacity == $typObj->weight * $frmObj->section))
                {
                        $bonus = (self::BONUS / 100) * $cost;
			$cost += $bonus;
                        $return['params']['bonus'] = $bonus;
                }

                

		$frmObj->money += $cost;
                
                $pltObj->reap = 1;
                
                if($pltObj->save())
                {
                    $frmMisMdl = new Farmmission();
                    $frmMisObj = $frmMisMdl->get_where(array('farm_id'=>$pltFrmId, 'status'=>0));
                    if($frmMisObj->exists())
                    {
                        $misMdl = new Mission();
                        $misObj = $misMdl->get_by_id($frmMisObj->mission_id);

                        //this check amount of mission for upper level that can choise plant type
                        //TODO think for upper level process
                        if($misObj->amount)
                        {
                            //$frmMisDeadline = $frmMisObj->create_date + ($misObj->deadline * 3600);
                            //$return['params']['misDeadline'] = $frmMisDeadline;

                            $now = mktime();
                            $return['params']['reapTime'] = $now;
                            
                            if($misObj->amount > ($amountProduct + $frmMisObj->stack))
                                $frmMisObj->status = 2;
                            else
                                $frmMisObj->status = 1;

                            $frmMisObj->stack = $amountProduct + $frmMisObj->stack;
                            
                            $return['params']['misAmount'] = $misObj->amount;
                            $return['params']['stackAmount'] = ($frmMisObj->stack);

                            $frmMisStatusHolder = $frmMisObj->status;

                            $frmMisObj->save();

                            if($frmMisStatusHolder == 1)
                            {
                                $frmObj->level++;
                                $return['params']['levelUpgrade'] = TRUE;
                                if($frmObj->level == 11)
                                {
                                    $gameComplete = new Userrank();
                                    $gameCompleteObj = $gameComplete->get_where(array('user_id'=>$frmObj->user_id,'type'=>1));
                                    if($gameCompleteObj->exists())
                                    {
                                            $gameCompleteObj->rank++;
                                            $gameCompleteObj->save();
                                    }
                                    else
                                    {
                                            $gameCompleteObj->user_id = $frmObj->user_id;
                                            $gameCompleteObj->type = 1;
                                            $gameCompleteObj->rank = 1;
                                            $gameCompleteObj->save();
                                    }
                                $frmObj->disactive = 1;
                                $return['params']['endGame'] = TRUE;
                                $return['params']['path'] = "profile/user/$frmObj->user_id";
                                }
                            }
                            
                            $return['params']['level'] = $frmObj->level;

                            //this section add product amount to userRank amount
                            $usrRnkMdl = new Userrank();
                            $usrRnkObj = $usrRnkMdl->get_where(array('user_id'=>$frmObj->user_id,'type'=>3));
                            if($usrRnkObj->exists())
                            {
                                    $usrRnkObj->rank += $amountProduct;
                                    $usrRnkObj->save();
                            }
                            else
                            {
                                    $usrRnkMdl->user_id = $frmObj->user_id;
                                    $usrRnkMdl->type = 3;
                                    $usrRnkMdl->save();
                            }

                            //reset plow for new level
                            $frmObj->plow = 0;

                            if($frmObj->save())
                            {
                                $return['type'] = 'reapConfirm';
                                return $return;
                            }
                            else
                                    return FALSE;

                        }
                    }
                }
	}

        function removePlantWithResources($plant_id)
        {
            if(!$plant_id)
                return false;

            $pltObj = $this->get_by_id($plant_id);
            $pltSrcMdl = new Plantresource();
            $pltResources = $pltSrcMdl->get_where(array('plant_id'=>$plant_id))->all;
            foreach($pltResources AS $pltResource)
                $pltResource->delete();

            $pltObj->delete();
            $frmMisMdl = new Farmmission();
            $frmMisObj = $frmMisMdl->get_where(array('plant_id'=>$plant_id, 'status'=>0));
            $frmMisObj->status = 2;
            if($frmMisObj->save())
                return true;

            return false;
        }
}
?>
