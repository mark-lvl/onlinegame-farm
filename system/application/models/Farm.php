<?php
class Farm extends DataMapper {

        var $level;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();

                $this->level  = array(  '1'=>  500,
                                        '2'=>  1000,
                                        '3'=>  2000,
                                        '4'=>  4000,
                                        '5'=>  7000,
                                        '6'=>  12000,
                                        '7'=>  20000,
                                        '8'=>  30000,
                                        '9'=>  50000,
                                        '10'=> 100000);
    	}

        /*
         * this function change the laevel of farm based on money
         * params int farm_id
         * params int money amount
         * return bool
         */
        function addMoneyToFarm($farm_id, $money) 
	{
                $levels = $this->level;
		$frmObj = $this->get_by_id($farm_id);
		if($money >= 0)
		{
			$frmObj->money += $money;
			foreach($levels AS $lvl=>$amount)
			{
				if($frmObj->level > $lvl)
					continue;
				else
				{
					if($frmObj->money > $amount)
						continue;
					else
					{
						$upgradeLevel = $lvl - 1;

                                                if($frmObj->level < $upgradeLevel)
                                                    $frmObj->level = $upgradeLevel;
                                                break;
					}
				}
			}
			if($frmObj->save())
				return TRUE;
			else
				return FALSE;
		}
        }
}
?>
