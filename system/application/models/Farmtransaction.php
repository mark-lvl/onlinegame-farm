<?php
class Farmtransaction extends DataMapper {

	var $local_time = TRUE;
        var $unix_timestamp = TRUE;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
    	}

	function add($off_farm,
		     $goal_farm,
		     $accessory_id,
		     $type,
		     $details)
	{
		$frmMdl = new Farm();
		$frmObjOff = $frmMdl->get_by_id($off_farm);
		$frmObjGol = $frmMdl->get_by_id($goal_farm);
		
		//farm with level 1,2,3 only attack from farm with the same level
		if($frmObjGol->level < 4 && $frmObjOff > 3 && $type == 1)
			return FALSE;	

		$this->offset_farm = $off_farm;
		$this->goal_farm = $goal_farm;
		$this->type = $type;
		$this->accessory_id = $accessory_id;
		
		//set efficacy date for offensive type
		if($type == 1)
		{
			$accMdl = new Accessory();
			$accObj = $accMdl->get_by_id($accessory_id);
			$accEffectTime = $accObj->life_time;
			
			$frmAccMdl = new Farmaccessory();
			$frmAccObjs = $frmAccMdl->get_where(array('farm_id'=>$goal_farm));
			
			$accMdl
			foreach($frmAccObjs AS $frmAccObj)
			{
				
			}
		}
		

$this->efficacy_date = 
	}
}
?>
