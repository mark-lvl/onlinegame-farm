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
        //load css files
        $this->add_css('jquery.countdown');

        //load js files
        $this->loadJs('jquery.countdown/jquery.countdown.min');
        $this->loadJs('jquery.countdown/jquery.countdown-fa');
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
                redirect('farm/show');
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

		$this->load->view('farms/register',$data);
	    }
        }
    }

	function show()
	{
		$user = $this->user_model->is_authenticated();
		
		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$user->id)->where('disactive','0')->get();

		$resource = new Resource();

		$pltModel = new Plant();
		
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

		$this->data['accessories'] = $accessories;
		$this->data['plantSources'] = $pltTypSrcHolder;
		$this->data['farmAcc'] = $usrFrmAcc;
		$this->data['plant'] = $userPlant;
		$this->data['farmResources'] = $this->resource_farm($userFarm->id);
		$this->data['resources'] = $allResource;
		$this->data['types'] = $allTypes;
		$this->data['farm'] = $userFarm;

                $this->data['heading'] = '';
                $this->data['title'] = 'FARM';
		
		$this->render();
	}

	function addResourceToFarm()
	{ 
          $frmSrcModel = new Farmresource();

          $flag = $frmSrcModel->add($_POST['farm_id'],$_POST['resource_id']);
          if(is_array($flag))
              $this->error_reporter($flag['type'],$flag['params']);
          
          $this->resource_farm($_POST['farm_id'],true);
		
	}

	function addPlantToFarm()
	{
		$pltModel = new Plant();
		$flag = $pltModel->add($_POST['farm_id'],$_POST['type_id']);

                if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);
                else
                    $this->refresh_page();
	}

	function addAccessoryToFarm($farm_id,$acc_id)
	{
		$accModel = new Farmaccessory();
		$accModel->add($farm_id,$acc_id);
	}

	function addResourceToPlant($typeSrc_id = null, $plant_id = null)
        {
		//this section check for healthn of plant
		$pltMdl = new Plant();
		$pltObj = $pltMdl->get_by_id($_POST['plant_id']);
		if(!$pltObj->health)
                {
                    $this->error_reporter('public',array('message'=>'plantDeath'));
                    return FALSE;
                }

                $pltScrMdl = new Plantresource();
                $srcModel = new Resource();
                $pltSrcObjs = $pltScrMdl->get_where(array('plant_id'=>$_POST['plant_id'],
                                                          'typeresource_id'=>$_POST['resource_id']))->all;

                foreach($pltSrcObjs AS &$pltSrcObj)
                        if($pltSrcObj->current)
                        {
                            $this->error_reporter('public',array('message'=>'plantResourceExists'));
                            return FALSE;
                        }
                        else
                        {
				$typSrcMdl = new Typeresource();
				$typSrcObj = $typSrcMdl->get_by_id($_POST['resource_id']);
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
                                {
                                    $srcDetails = $srcModel->get_by_id($typSrcObj->resource_id);
                                    $this->error_reporter('resource',array('farm_resource'=>$frmSrcObj->count,
                                                                           'resource'=> $srcDetails->name,
                                                                           'need'=>$typSrcObj->minNeed ));
                                    return FALSE;
                                }
				
                        }
        }

	function reap($plant_id)
	{
		$pltMdl = new Plant();
		$pltMdl->reap($plant_id);
	}


        /*
         * this method return the resource of the specific farm by id
         * params farm_id
         * params output : determine the type of return object
         * return : the view or the output string of view
         */
        function resource_farm($farm_id = null,$output = null)
	{
          $frmSrcModel = new Farmresource();
          $resource = new Resource();

          $usrFrmSrc = $frmSrcModel->get_where(array('farm_id'=>$farm_id))->all;
		foreach($usrFrmSrc AS $sourceItem)
		{
			$resourceObject = $resource->get_by_id($sourceItem->resource_id);
			$resourceHolder[$resourceObject->name] = $sourceItem->count;
		}

          $data['farmResources'] = $resourceHolder;
          if($output)
            $this->load->view('farms/addResourceToFarm',$data);
          else
            return $this->load->view('farms/addResourceToFarm',$data, TRUE);

	}
}
?>
