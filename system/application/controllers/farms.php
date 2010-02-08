<?php
class Farms extends MainController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User',
                                 'Farm',
                                 'Resource',
                                 'Type',
                                 'Typeresource',
                                 'Farmresource',
				 'Farmaccessory',
                                 'Plant',
                                 'Accessory',
				 'Plantresource'));
    }

    function index($offset=0)
    {
        $user = new User();
        $userDetails = $user->where('id','32')->get();

        $farm = new Farm();
        $farms = $farm->where('user_id',$userDetails->id)->where('disactive','0')->get();
        $this->output->enable_profiler(TRUE);
        //var_dump($userDetails);
        //var_dump($farms);
        //exit;

        $this->load->view('farm/index', $data);
    }

    function register()
    {
        $farm = new Farm();
            $userFarm = $farm->where('user_id',$user->id)->where('disactive','0')->get();
        if($userFarm->exists())
                redirect('farms/show');
        else
        {
            if($this->input->post('name'))
	    {
	    	$farm->name = $this->input->post('name');
            	$farm->user_id = $_SESSION['user']->id;

            	if($farm->save())
                	redirect('farms/show');
	    }
	    else
	    {
		$data['lang'] = $this->lang->language;

		$this->load->view('farm/register',$data);
	    }
        }
    }

	function show()
	{
		$user = $this->user_model->is_authenticated();
		
		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$user->id)->where('disactive','0')->get();

		$frmSrcModel = new Farmresource();
		$resource = new Resource();

		//TODO can create plugin for this section
		$usrFrmSrc = $frmSrcModel->get_where(array('farm_id'=>$userFarm->id))->all;
		foreach($usrFrmSrc AS $sourceItem)
		{
			$resourceObject = $resource->get_by_id($sourceItem->resource_id);		
			$resourceHolder[$resourceObject->name] = $sourceItem->count;
		}

		$pltModel = new Plant();
		//$userPlant = $pltModel->get_where(array('farm_id'=>$userFarm->id,'reap'=>0));
		$userPlant = $pltModel->plantSync($userFarm->id);
		$farmAccModel = new Farmaccessory();
		$usrFrmAcc = $farmAccModel->getFarmAccessory($userFarm->id);
	
		$pltObj = $pltModel->get_where(array('id'=>$userPlant->id,'farm_id'=>$userFarm->id,'reap'=>0));
		$typSrcMdl = new Typeresource();
		$pltTypSrcs = $typSrcMdl->get_where(array('type_id'=>$pltObj->type_id))->all;
		foreach($pltTypSrcs AS $pltTypSrc)
		{
			$srcHolder = $resource->get_by_id($pltTypSrc->resource_id);
			$pltTypSrcHolder[$srcHolder->name] = array($pltTypSrc->id,$pltObj->id);
		}

		$typeModel = new Type();
		$userPlant->typeName = $typeModel->get_where(array('id'=>$userPlant->type_id))->name;

		$acsModel = new Accessory();
		$accessories = $acsModel->get()->all;

		$allResource = $resource->get()->all;

		$typeModel = new Type();
		$allTypes = $typeModel->get()->all;

		$data['accessories'] = $accessories;
		$data['plantSources'] = $pltTypSrcHolder;
		$data['farmAcc'] = $usrFrmAcc;
		$data['plant'] = $userPlant;
		$data['farmResources'] = $resourceHolder;
		$data['resources'] = $allResource;
		$data['types'] = $allTypes;
		$data['farm'] = $userFarm;
		
		$this->load->view('farm/show',$data);
	}

	function addResourceToFarm($farm_id,$src_id)
	{
		$frModel = new Farmresource();
		$flag = $frModel->add($farm_id,$src_id);
	}

	function addPlantToFarm($farm_id, $type_id)
	{
		$pltModel = new Plant();
		$pltModel->add($farm_id,$type_id);
	}

	function addAccessoryToFarm($farm_id,$acc_id)
	{
		$accModel = new Farmaccessory();
		$accModel->add($farm_id,$acc_id);
	}

	function addResourceToPlant($typeSrc_id,$plant_id)
        {
		//this section check for healthn of plant
		$pltMdl = new Plant();
		$pltObj = $pltMdl->get_by_id($plant_id);
		if(!$pltObj->health)
			return FALSE;

                $pltScrMdl = new Plantresource();
                $pltSrcObjs = $pltScrMdl->get_where(array('plant_id'=>$plant_id,
                                                          'typeresource_id'=>$typeSrc_id))->all;

                foreach($pltSrcObjs AS &$pltSrcObj)
                        if($pltSrcObj->current)
                                return FALSE;                   
                        else
                        {
				$typSrcMdl = new Typeresource();
				$typSrcObj = $typSrcMdl->get_by_id($typeSrc_id);
				$frmSrcMdl = new Farmresource();
				$frmSrcObj = $frmSrcMdl->get_where(array('resource_id'=>$typSrcObj->resource_id));
				if($frmSrcObj->count > $typSrcObj->minNeed)
				{
					$frmSrcObj->count -= $typSrcObj->minNeed;
					$pltSrcObj->current += $typSrcObj->minNeed;
					
					//let's go baby
					$frmSrcObj->save();
					$pltSrcObj->save();
				}
				else
					return FALSE;
				
                        }
        }

	function reap($plant_id)
	{
		$pltMdl = new Plant();
		$pltMdl->reap($plant_id);
	}
}
?>
