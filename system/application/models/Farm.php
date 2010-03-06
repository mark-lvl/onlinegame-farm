<?php
class Farm extends DataMapper {


    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
    	}
	
	function isPlow($farm_id)
	{
		$farm = $this->get_by_id($farm_id);

		//TODO fetch are accessories for this farm and if have a auto plower return true


		if($farm->plow)
			return TRUE;
		else
			return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'farmNotPlowed'));
	}

	function plow($farm_id)
	{
		$farm = $this->get_by_id($farm_id);
		if($farm->plow == 1)
			return array('return'=>'false',
                                     'type'=>'public',
                                     'params'=>array('message'=>'farmPlowedBefore'));
		else
		{
			$farm->plow = 1;
			$farm->save();
			return TRUE;
		}

	}

}
?>
