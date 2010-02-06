<?php
class Farmresource extends DataMapper {

    public function __construct()
    {
        // model constructor
        parent::__construct();
	$this->load->model(array('Farm'));
    }

	function add($farm_id,$src_id)
	{
		$sourceModel = new Resource();
		$source = $sourceModel->where('id',$src_id)
				      ->get();
		
		$farmModel = new Farm();
		$farm = $farmModel->get_by_id($farm_id);
		if($farm->money > $source->price)
		{	
			$farmResourceModel = new Farmresource();
			$frObject = $farmResourceModel->where('farm_id',$farm->id)
					    	      ->where('resource_id',$src_id)
					              ->get();

			if($frObject->exists())
			{
				$frObject->count = $frObject->count+1;
				$frObject->save();
			}
			else
			{
				$frObject->resource_id = $src_id;
				$frObject->farm_id = $farm->id;
				$frObject->save();	
			}

			$farm->money -= $source->price;
			$farm->save();

			return TRUE;
		}
		else
			return FALSE;
		
	}

    
}
?>
