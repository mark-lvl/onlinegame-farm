<?php
class Plant extends DataMapper {

    	public function __construct()
    	{
        	// model constructor
        	parent::__construct();
		$this->load->model('Plantresource');
    	}

	function add($farm_id, $type_id)
	{
		$pltModel = new Plant();

                //if have a plant don't reap return false
		if($pltModel->get_where(array('farm_id'=>$farm_id,'reap'=>0))->exists())
			return FALSE;
		else
		{
			$typeModel = new Type();
			$frmScrModel = new Farmresource();
			$typScrModel = new Typeresource();
			$frmModel = new Farm();


                        $farmDetails = $frmModel->get_by_id($farm_id);

			//this section calculate number of section in farm
			//multiple by plantType price and return total price
			$totalPrice = $farmDetails->section * $typeDetails->price;

			if($totalPrice > $farmDetails->money)
				return FALSE;
			else
			{
                                $typeDetails = $typeModel->get_by_id($type_id);
                                $typeResources = $typScrModel->get_where(array('type_id'=>$type_id))->all;

                                //check for min requirment resource for create this type of plant			
                                foreach($typeResources AS $tr)
                                {
                                        $frmResources = $frmScrModel->get_where(array('farm_id'=>$farm_id,
                                                                                      'resource_id'=>$tr->resource_id));

                                        if($frmResources->count < $tr->minNeed)
                                                return FALSE;
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

                                $farmDetails->money = $farmDetails->money - ($farmDetails->section * $typeDetails->price);
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
				return TRUE;
			}







                        	
			
		}
		
	}

    
}
?>
