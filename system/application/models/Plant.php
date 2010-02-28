<?php
class Plant extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;

	//this cinst hold maximum time in sec for die plant
	const DIE_DURATION = 7200;
	const BONUS = 30;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model('Plantresource');
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
			$plant->growth = ($plant->create_date + ($typObj->growth_time * 3600)) - time();

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
                                                        for ($i = 0; $i <= $currentDecreaser; $i++)
								if($pltSrcObj->current)
								{
                                                                	$pltSrcObj->current -= $typSrcObj->minNeed;
									//disable the autoTimestamp for pltSrcMdl when decrease current count
									$pltSrcMdl->updated_field = null;
									$pltSrcObj->save();
								}
								else
								{
									$healthDecHolder =  (int)(($srcLifeTimeHolder/self::DIE_DURATION)*100);
								
									if($healthDecHolder < 0)
										$healthDecHolder *= -1;
									$planthealthHolder = 100 - $healthDecHolder;
							
									//this section check for health value decreased by another lack resource
									if($plant->health > $planthealthHolder)
										$plant->health = $planthealthHolder;
									if($plant->health < 0)
										$plant->health = 0;
									$plant->save();
								}
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
			$typeModel = new Type();
			$frmScrModel = new Farmresource();
			$typScrModel = new Typeresource();
			$frmModel = new Farm();
			$srcModel = new Resource();
			$misModel = new Mission();
			$frmMisModel = new Farmmission();


                        $farmDetails = $frmModel->get_by_id($farm_id);
                        $typeDetails = $typeModel->get_by_id($type_id);

			//this section calculate number of section in farm
			//multiple by plantType price and return total price
			$totalPrice = $farmDetails->section * $typeDetails->price;

			if($totalPrice >= $farmDetails->money)
				return array('return'=>'false',
                                             'type'=>'money',
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

                                        reset($typeResources);
                                        //now if all resource is available used that resource.
                                        foreach($typeResources AS $tr)
                                        {
                                                $frmResources = $frmScrModel->get_where(array('farm_id'=>$farm_id,
                                                                                              'resource_id'=>$tr->resource_id));
                                                $frmResources->count -= $tr->minNeed;
                                                $frmResources->save();
                                        }

                                        //for calculate money based on Farm->section,Type->weight,Type->price
                                        $farmDetails->money = $farmDetails->money - ($farmDetails->section * $typeDetails->weight * $typeDetails->price);
                                        $farmDetails->save();

                                        //finaly save the plant
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
                                                $pltSrcModel->current = $tr->minNeed;
                                                $pltSrcModel->save();
                                        }

                                        //this section set mission for farm
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

	function reap($plant_id)
	{
		$pltObj = $this->get_by_id($plant_id);
                $pltFrmId = $pltObj->farm_id;
                unset($pltObj);

                //first sync plant for reap that
                $pltObj = $this->plantSync($pltFrmId);
		
		$typMdl = new Type();
		$typObj = $typMdl->get_by_id($pltObj->type_id);
		
		$growthChecker = ($pltObj->create_date + ($typObj * 3600)) - time();
		if($growthChecker > 0)
			return array('return'=>  'false',
                                                 'type'=>'public',
                                                 'params'=>array('message'=>'notReadyForReap'));

		$frmMdl = new Farm();
                $frmObj = $frmMdl->get_by_id($pltFrmId);


                $farmCapacity = $typObj->weight * $frmObj->section;
                $amountProduct = ($pltObj->health / 100) * $farmCapacity;
                $return['params']['amountProduct'] = $amountProduct;
                $return['params']['health'] = $pltObj->health;
                $return['params']['farmCapacity'] = $farmCapacity;
                $return['params']['typeName'] = $typObj->name;
                
                $cost = $amountProduct * $typObj->sell_cost;
                $return['params']['totalCost'] = $cost;

		//add bonus payment for full health product
                if($pltObj->health == 100)
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
                            $frmMisDeadline = $frmMisObj->create_date + ($misObj->deadline * 3600);
                            $return['params']['misDeadline'] = $frmMisDeadline;

                            $now = mktime();
                            $return['params']['reapTime'] = $now;
                            
                            if($now < $frmMisDeadline)
                                if($misObj->amount > $amountProduct)
                                    $frmMisObj->status = 2;
                                else
                                    $frmMisObj->status = 1;
                            else
                            {
                                $frmMisObj->status = 1;
                                $return = 'time';
                            }
                            $return['params']['misAmount'] = $misObj->amount;

                            $frmMisStatusHolder = $frmMisObj->status;

                            $frmMisObj->save();

                            if($frmMisStatusHolder == 1)
                                $frmObj->level++;

                            $return['params']['level'] = $frmObj->level;

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
}
?>
