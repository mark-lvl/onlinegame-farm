<?php
class Farmtransaction extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;
	var $updated_field = 'modified_date';
	var $sprayingPrice = 100;
	var $accMdl;
        const  GUNACCID = 5;
        const  SCARECROWACCID = 7;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model(array('Accessory','Plant','Farmaccessory'));
		$this->accMdl = new Accessory();
                $this->load->language('labels', get_lang());
                
    	}

	function add($off_farm,
		     $goal_farm,
		     $accessory_id,
		     $type,
		     $details = null)
	{
		$frmMdl = new Farm();
		$frmObjOff = $frmMdl->get_by_id($off_farm);
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
                $accMdl = new Accessory();
                $accObj = $accMdl->get_by_id($accessory_id);
                if($frmObjGol->level < $accObj->level)
                        return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttackWithHavntAnti'));
                unset ($accObj);

                //farm with no plant rejected new attack
                $pltMdl = new Plant();
                $pltObj = $pltMdl->get_where(array('farm_id'=>$goal_farm, 'reap'=>0));
                if(!$pltObj->exists())
                        return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttackBeacuseHavntPlant'));

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
				$frmTrnObj->details = $details;
				$frmTrnObj->save();
				return $frmAccObj->count;
			}
			else
			return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'cantAttack'));

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
                        if($plant->health < 0)
                                $plant->health = 0;
                        $plant->updated_field = null;
                        $plant->save();

                        if(time() > $transaction->efficacy_date)
                                $transaction->flag = 1;
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

                $plant->weight -= $decHolder;
                if($plant->weight < 0)
                        $plant->weight = 0;
                $plant->updated_field = null;
                $plant->save();

                if(time() > $transaction->efficacy_date)
                        $transaction->flag = 1;
                else
                        $transaction->flag = 0;

                if($decHolder > 1 || (time() > $transaction->efficacy_date))
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
                                $transaction->flag = 2;
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
                            $attack->flag = 1;
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
                            $attack->flag = 2;
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
}
?>
