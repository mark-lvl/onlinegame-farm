<?php
class Farmtransaction extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;
	var $updated_field = 'modified_date';
	var $sprayingPrice = 100;
	var $accMdl;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model(array('Accessory','Plant'));
		$this->accMdl = new Accessory();
    	}

//	function add($off_farm,
//		     $goal_farm,
//		     $accessory_id,
//		     $type,
//		     $details)
//	{
//		$frmMdl = new Farm();
//		$frmObjOff = $frmMdl->get_by_id($off_farm);
//		$frmObjGol = $frmMdl->get_by_id($goal_farm);
//
//		//farm with level 1,2,3 only attack from farm with the same level
//		if($frmObjGol->level < 4 && $frmObjOff > 3 && $type == 1)
//			return FALSE;
//
//		$this->offset_farm = $off_farm;
//		$this->goal_farm = $goal_farm;
//		$this->type = $type;
//		$this->accessory_id = $accessory_id;
//
//		//set efficacy date for offensive type
//		if($type == 1)
//		{
//			$accMdl = new Accessory();
//			$accObj = $accMdl->get_by_id($accessory_id);
//			$accEffectTime = $accObj->life_time;
//
//			$frmAccMdl = new Farmaccessory();
//			$frmAccObjs = $frmAccMdl->get_where(array('farm_id'=>$goal_farm));
//
//			$accMdl
//			foreach($frmAccObjs AS $frmAccObj)
//			{
//
//			}
//		}
//
//
//$this->efficacy_date =
//	}

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
			}
		}
	}
	
	function type_1_effect($transaction, $farm, $plant)
	{
		$accessory = $this->accMdl->get_by_id($transaction->accessory_id);
		$consumeTime = ($accessory->life_time * 3600) / $accessory->effect;
		$effectTime = time() - $transaction->modified_date;
		$decHolder = (int)($effectTime / $consumeTime);//echo $transaction->modified_date;exit;

		$plant->health -= $decHolder;
		$plant->updated_field = null;
		$plant->save();
//echo($decHolder);exit;
		if(time() > $transaction->efficacy_date)
			$transaction->flag = 1;
		else
			$transaction->flag = 0;
		
		if($decHolder > 1 || (time() > $transaction->efficacy_date))
		$transaction->save();
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
                                        ->where_in('accessory_id', array(1))
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
}
?>
