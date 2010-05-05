<?php
class Plantresource extends DataMapper {

    var $local_time = TRUE;
    var $unix_timestamp = TRUE;
    var $updated_field = 'modified_date';

    public function __construct()
    {
        // model constructor
        parent::__construct();
    }


	function addResourceToPlant($typeSrc_id,$plant_id)
	{
		$pltScrMdl = new Plantresource();
		$pltSrcObjs = $pltScrMdl->get_where(array('plant_id'=>$plant_id,
			   		                  'typeresource_id'=>$typeSrc_id))->all;

		foreach($pltSrcObjs AS $pltSrcObj)
			if($pltSrcObj->current)
				return FALSE;
			else
			{

			}
	}
}
?>
