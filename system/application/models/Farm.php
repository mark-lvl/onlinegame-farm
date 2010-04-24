<?php
class Farm extends DataMapper {

        const INVITE_BONUS = 50;

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

        function invite_successfull($user_id)
        {
                $frmObj = $this->get_where(array('user_id'=>$user_id,'disactive'=>0));

                if($frmObj->exists())
                {
                        $frmObj->money += self::INVITE_BONUS;
                        $frmObj->save();

                        return $frmObj->id;
                }
                else
                    return FALSE;
        }

}
?>
