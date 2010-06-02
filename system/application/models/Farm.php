<?php
class Farm extends DataMapper {

        const INVITE_BONUS = 50;
        const PLOW_PRICE = 100;
        const TRACTOR_ACC_ID = 42;

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
    	}

        function allExistsFarm()
        {
            return $this->get()->count();
        }
	
	function isPlow($farm_id)
	{
		$farm = $this->get_by_id($farm_id);

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

                        $frmAccMdl = new Farmaccessory();
                        $frmAccObj = $frmAccMdl->get_where(array('farm_id'=>$farm_id,'accessory_id'=>self::TRACTOR_ACC_ID));
                        if(!$frmAccObj->exists())
                            $farm->money -= self::PLOW_PRICE;
                        
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

        function get_count_farms_by_name($filter = "")
        {
            return $this->like('name', $filter)->count();
        }
        function get_farms_by_name($page = 0, $count = 8, $filter = "")
        {
            $offset = 0;
            if($page)
                $offset = ($page-1)* $count;

            $frmObjs = $this->like('name',$filter)->order_by("level", "desc")->limit($count,$offset)->get()->all;

            return $frmObjs;
        }

}
?>
