<?php
class Farmaccessory extends DataMapper {

    var $unix_timestamp = TRUE;

    public function __construct()
    {
        // model constructor
        parent::__construct();
    }

	function add($farm_id,$acc_id)
	{
		$accessoryModel = new Accessory();
		$accessory = $accessoryModel->where('id',$acc_id)
				      	    ->get();
		
		$farmModel = new Farm();
		$farm = $farmModel->get_by_id($farm_id);
		if($farm->money >= $accessory->price)
                {
		    if($farm->level >= $accessory->level)
                    {
                        $farmAccModel = new Farmaccessory();
                        $faObject = $farmAccModel->where('farm_id',$farm->id)
                                                 ->where('accessory_id',$acc_id)
                                                 ->get();

			if(($accessory->type == 1 && $accessory->group == 1) ||
                           ($accessory->type == 2 && $accessory->group == 2 && $accessory->id == 5) ||
			   ($accessory->type == 1 && $accessory->group == 2))
			{
                            if($faObject->exists())
                            {
                                $faObject->count++;
                                $faObject->save();
                            }
                            else
                            {
                                $faObject->accessory_id = $acc_id;
                                $faObject->farm_id = $farm->id;
                                $faObject->count = 1;
                                $faObject->save();
                            }
				
			}
                        elseif(($accessory->type == 2 && $accessory->group == 1)  ||
                               ($accessory->type == 4 && $accessory->group == 10) ||
                               ($accessory->type == 4 && $accessory->group == 11) ||
                               ($accessory->type == 4 && $accessory->group == 20))
                        {
                                if($faObject->exists())
                                {
                                    return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'farmAccessoryExists'));
                                }
                                else
                                {
                                    $faObject->accessory_id = $acc_id;
                                    $faObject->farm_id = $farm->id;
                                    $faObject->count = 1;
                                    $faObject->save();
                                }
                        }
                        elseif(($accessory->type == 2 && $accessory->group == 2))
                        {
                            if($faObject->exists())
                            {
                                return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'farmAccessoryExists'));
                            }
                            else
                            {
                                $faObject->accessory_id = $acc_id;
                                $faObject->farm_id = $farm->id;
                                $faObject->count = 1;
                                if($accessory->type == 2)
                                        $faObject->expire_date =  strtotime("+$accessory->life_time hours");
                                $faObject->save();
                            }
                        }

                        $farm->money -= $accessory->price;
                        $farm->save();

                        return TRUE;
                    }
                    else
                    {
                        return array('return'=>  'false',
                                                 'type'=>'level',
                                                 'params'=>array('yourLevel'=>$farm->level,
                                                                 'accessory'=> $accessory->name,
                                                                 'needLevel'=>$accessory->level ));
                    }
                }
                else
                {
                        return array('return'=>'false',
                                               'type'=>'money',
                                               'params'=>array('money'=>$farm->money,
                                                               'price'=>$accessory->price));
                }
	}
        /*
         * this function select only for accessory can display in user farm preview
         * dog_id = 8
         * scarecrow_id = 7
         * silo_id = 45
         */
	function getFarmAccessoryForDisplay($farm_id)
	{
		$farmAcc = $this->where_in('accessory_id', array('7','8','45'))->where('farm_id',$farm_id)->get()->all;

		foreach($farmAcc AS &$item)
		{
			//this section gc for expired item
			if($item->expire_date)
				if(time() > $item->expire_date)
					$item->delete();

                        if($item->accessory_id == 7)
                                $return[] = 'scarecrow';
                        elseif($item->accessory_id == 8)
                                $return[] = 'dog';
                        elseif($item->accessory_id == 45)
                                $return[] = 'silo';
		}
		return $return;
	}

        function getGrowthDecreaser($farm_id, $plantCreateDate, $growthTime)
        {
                $farmAcc = $this->get_where(array('farm_id'=>$farm_id))->all;
		$accModel = new Accessory();
                $decHolder = 0;
		foreach($farmAcc AS &$item)
		{
                        if($item->accessory_id == 40)
                        {
                                $accObject = $accModel->get_where(array('id'=>$item->accessory_id));
                                $decHolder += (($accObject->effect/100) * $growthTime);
                        }
                        elseif($item->accessory_id == 44)
                        {
                                $accObject = $accModel->get_where(array('id'=>$item->accessory_id));
                                $decHolder += (($accObject->effect/100) * $growthTime);
                        }
		}
                $return = ($plantCreateDate + (($growthTime-$decHolder) * 3600)) - time();
		return $return;
        }
}
?>
