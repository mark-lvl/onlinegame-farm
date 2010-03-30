<?php
class Farms extends MainController {

    //resource id's
    const WATER_ID = 1;
    const MUCK_ID  = 2;

    //have mission
    const MISSION = FALSE;

    var $userSessionHolder;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User',
                                 'Farm',
				 'Mission',
				 'Farmmission',
                                 'Resource',
                                 'Type',
                                 'Typeresource',
                                 'Farmresource',
				 'Farmaccessory',
				 'Farmtransaction',
                                 'Plant',
                                 'Accessory',
				 'Plantresource'));
        //load css files
        $this->add_css('jquery.countdown');
        $this->add_css('farm');

        //load js files
        $this->loadJs('jquery.countdown/jquery.countdown.min');
        $this->loadJs('jquery.countdown/jquery.countdown-fa');
        $this->loadJs('jquery.loading/jquery.loading');

        if($_SESSION['user']){
                  $this->userSessionHolder = unserialize($_SESSION['user']);}
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
            	$farm->user_id = $this->userSessionHolder->id;

            	if($farm->save())
		{
			$farmId = $this->db->insert_id();
		
			$resource = array(self::WATER_ID => 10,
					  self::MUCK_ID => 5);

			foreach( $resource AS $res_id=>$count)
			{
				$frmSrcMdl = new Farmresource();
				$frmSrcMdl->resource_id = $res_id;
				$frmSrcMdl->count = $count;
				$frmSrcMdl->farm_id = $farmId;
				$frmSrcMdl->save();
                                
			}
                        $this->user_model->add_notification($farmId, $this->lang->language['welcomeToFarm'], 4);
                	redirect('farms/show');
		}
	    }
	    else
	    {
                redirect("profile/user/$user->id");
	    }
        }
    }

	function show()
	{
		$user = $this->user_model->is_authenticated();

                if(!$this->user_model->has_farm($user->id))
                        redirect("profile/user/$user->id");

                $this->add_css('popup');
                $this->loadJs('popup');

		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$user->id)->where('disactive','0')->get();

		$resource = new Resource();

		$pltModel = new Plant();

		$userPlant = $pltModel->plantSync($userFarm->id);
		
		//this set disasters for farm in this level by random method
		$this->disasters($userFarm->id);

		$frmMisMdl = new Farmmission();
		$frmMisObj = $frmMisMdl->get_where(array('farm_id'=>$userFarm->id, 'status'=>0));

		$hints = array();
		if(!$frmMisObj->exists())
		{
			$misMdl = new Mission();
			$misObj = $misMdl->get_by_level($userFarm->level);
			$hints[] = $misObj->description;
		}

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
                
                $acsModel = new Accessory();

                $notification = $this->user_model->get_notifications($userFarm->id);

                $frmTrnMdl = new Farmtransaction();
                
		$typeModel = new Type();
		$userPlant->typeName = $typeModel->get_where(array('id'=>$userPlant->type_id))->name;

		//accessory available for user in this level
		$accessories = $acsModel->get_where(array('level <='=>$userFarm->level))->all;

		$allResource = $resource->get()->all;


                $typeModel = new Type();

                if($misObj->type)
        		$allTypes = $typeModel->get()->all;
                else
                        $allTypes = $typeModel->get_where(array('id'=>$misObj->type_id))->all;

		foreach($allTypes AS &$typ)
			$typ->capacity = $typ->weight * $userFarm->section;

                $equipments = array();
                //control farm machine items
                if($userFarm->level > 4 && $userFarm->section == 1 && !$userPlant->id)
                        $equipments[] = 'rockBreaker';
                if($userFarm->level > 6 && $userFarm->section == 2 && !$userPlant->id)
                        $equipments[] = 'waterpump';

		$this->data['accessories'] = $accessories;
		$this->data['plantSources'] = $pltTypSrcHolder;
		$this->data['farmAcc'] = $usrFrmAcc;
		$this->data['plant'] = $userPlant;
		$this->data['farmResources'] = $this->resource_farm($userFarm->id);
		$this->data['resources'] = $allResource;
		$this->data['types'] = $allTypes;
		$this->data['farm'] = $userFarm;
		$this->data['hints'] = $hints;
		$this->data['notifications'] = $notification;
		$this->data['equipments'] = $equipments;

                $this->data['heading'] = '';
                $this->data['title'] = 'FARM';

		$this->render();
	}


	function view($id)
	{
		$user = $this->user_model->is_authenticated();

                $this->add_css('popup');
                $this->loadJs('popup');
		
		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$id)->where('disactive','0')->get();

		$resource = new Resource();

		$pltModel = new Plant();
		
		$userPlant = $pltModel->plantSync($userFarm->id);

		$frmMisMdl = new Farmmission();
		$frmMisObj = $frmMisMdl->get_where(array('farm_id'=>$userFarm->id, 'status'=>0));
		
		$hints = array();
		if(!$frmMisObj->exists())
		{
			$misMdl = new Mission();
			$misObj = $misMdl->get_by_level($userFarm->level);
			$hints[] = $misObj->description;
		}

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

                $farmModel = new Farm();
                $viewerFarm = $farmModel->where('user_id',$this->userSessionHolder->id)->where('disactive','0')->get();

                $frmAcsModel = new Farmaccessory();
		$acsModel = new Accessory();
                
		$viewerAccHolder = $frmAcsModel->get_where(array('farm_id'=>$viewerFarm->id))->all;
                foreach ($viewerAccHolder as $key=>&$viAcc)
                {
                    $acc = $acsModel->select(array('name','type'))->get_by_id($viAcc->accessory_id);
                    if($acc->type != 1)
                    {
                            unset($viewerAccHolder[$key]);
                            continue;
                    }
                    $viAcc->name = $acc->name;
                    $viAcc->type = $acc->type;
                }
                
		$typeModel = new Type();
		$allTypes = $typeModel->get()->all;
		foreach($allTypes AS &$typ)
			$typ->capacity = $typ->weight * $userFarm->section;

		$this->data['viewerAccessories'] = $viewerAccHolder;
		$this->data['plantSources'] = $pltTypSrcHolder;
		$this->data['farmAcc'] = $usrFrmAcc;
		$this->data['plant'] = $userPlant;
		$this->data['farmResources'] = $this->resource_farm($userFarm->id);
		$this->data['types'] = $allTypes;
		$this->data['farm'] = $userFarm;
		$this->data['hints'] = $hints;

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

	function addAccessoryToFarm($farm_id = null,$acc_id = null)
	{
		$accModel = new Farmaccessory();
		$flag = $accModel->add($_POST['farm_id'],$_POST['accessory_id']);
                if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);

                $this->accessory_farm($_POST['farm_id'],true);
	}

	function addResourceToPlant($typeSrc_id = null, $plant_id = null)
        {
		//this section check for healthn of plant
		$pltMdl = new Plant();
                
		$pltObj = $pltMdl->get_by_id($_POST['plant_id']);

                //first sync plant for add resoure to that
                $pltMdl->plantSync($pltObj->farm_id);
                
		if(!$pltObj->health)
                {
                    $this->error_reporter('public',array('message'=>'plantDeath'));
                    return FALSE;
                }

                $pltScrMdlHolder = new Plantresource();
                $srcModel = new Resource();
                $pltSrcObjsHolder = $pltScrMdlHolder->get_where(array('plant_id'=>$_POST['plant_id'],
                                                                      'typeresource_id'=>$_POST['resource_id']))->all;

                foreach($pltSrcObjsHolder AS &$pltSrcObjHolder)
                        if($pltSrcObjHolder->current)
                        {
                            $this->error_reporter('public',array('message'=>'plantResourceExists'));
                            return FALSE;
                        }
                        else
                        {
				$typSrcMdl = new Typeresource();
				$typSrcObj = $typSrcMdl->get_by_id($_POST['resource_id']);
				$frmSrcMdl = new Farmresource();
				$frmSrcObj = $frmSrcMdl->get_where(array('resource_id'=>$typSrcObj->resource_id,'farm_id'=>$pltObj->farm_id));
				if($frmSrcObj->count >= $typSrcObj->minNeed)
				{
					$frmSrcObj->count -= $typSrcObj->minNeed;
					$pltSrcObjHolder->current += $typSrcObj->minNeed;
                                        $pltScrMdlHolder->updated_field = 'modified_date';
					
					//let's go baby
					$frmSrcObj->save();
					$pltSrcObjHolder->save();
                                        
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
                        $this->refresh_page();
        }

	function reap($plant_id = null)
	{
		$pltMdl = new Plant();
		$flag = $pltMdl->reap($_POST['plant_id']);
                if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);

                //redirect('/farms/show');
	}

        function plow()
	{
          $frmModel = new Farm();

          $flag = $frmModel->plow($_POST['farm_id']);
          if(is_array($flag))
              $this->error_reporter($flag['type'],$flag['params']);
          else
              echo '1';
	}

        function sync()
	{
          $pltMdl = new Plant();

          $data['plant'] = $pltMdl->plantSync($_POST['farm_id']);
          $data['base_img'] = $this->data['base_img'];

          echo $this->load->view('farms/sync',$data,TRUE);
          
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

	  if(is_null($resourceHolder))
		$resourceHolder = array();
          $data['farmResources'] = $resourceHolder;
          if($output)
            $this->load->view('farms/addResourceToFarm',$data);
          else
            return $this->load->view('farms/addResourceToFarm',$data, TRUE);

	}

        /*
         * this method return the resource of the specific farm by id
         * params farm_id
         * params output : determine the type of return object
         * return : the view or the output string of view
         */
        function accessory_farm($farm_id = null,$output = null)
	{
          $frmAccModel = new Farmaccessory();
          $accMdl = new Accessory();

          $usrFrmAcc = $frmAccModel->get_where(array('farm_id'=>$farm_id))->all;
		foreach($usrFrmAcc AS $accItem)
		{
			$accObject = $accMdl->get_by_id($accItem->resource_id);
			$accHolder[$accObject->name] = $accItem->count;
		}
	
	  if(is_null($accHolder))
		$accHolder = array();
          $data['farmAccessories'] = $accHolder;
          if($output)
            $this->load->view('farms/addAccessoryToFarm',$data);
          else
            return $this->load->view('farms/addAccessoryToFarm',$data, TRUE);

	}

        /*
         * this function use for refresh farm money from ajax calling
         * params int farm_id
         * return int money
         */
        function moneyCalc()
        {
            $farmModel = new Farm();
	    $userFarm = $farmModel->get_where(array('user_id'=>$this->userSessionHolder->id,
                                                    'disactive'=>'0'));
            echo $userFarm->money;
        }

        function disasters($farm_id = null)
        {
                //this array hold accessory_id for disasters in each level
                // level=>array(acc_ids)
                $levelDisasters = array(
                                        1=>NULL,
                                        2=>array('1')
                                        );
                $farm_id = $_POST['farm_id'];
                
                $frmMdl = new Farm();
                $frmObj = $frmMdl->get_by_id($farm_id);

		$pltMdl = new Plant();
		$pltObj = $pltMdl->get_where(array('farm_id'=>$farm_id,'reap'=>0));

                $random = rand(1,10);
		if($pltObj->exists())
	                if($random > 8)
        	        {
                	        $counter = count($levelDisasters[$frmObj->level]);
                        	$acc_id = $levelDisasters[$frmObj->level][rand(0,$counter-1)];

	                        if($acc_id)
        	                {
                	                $frmTrnMdl = new Farmtransaction();
                        	        //check if this farm have this disasters onWay
                                	$frmTrnObj = $frmTrnMdl->get_where(array('offset_farm'=>0,
                                        	                                 'goal_farm'=>$frmObj->id,
                                                	                         'accessory_id'=>$acc_id,
                                                        	                 'type'=>1,
                                                                	         'flag'=>0));
	                                if(!$frmTrnObj->exists())
        	                        {
        	                                $accMdl = new Accessory();
                	                        $accObj = $accMdl->get_by_id($acc_id);
                        	                $frmTrnMdl->efficacy_date = (time() + ($accObj->life_time * 3600));
	                                        $frmTrnMdl->goal_farm = $farm_id;
        	                                $frmTrnMdl->accessory_id = $acc_id;
                	                        $frmTrnMdl->type = 1;
                        	                $frmTrnMdl->goal_farm = $farm_id;

                                	        $frmTrnMdl->save();
                                                $this->user_model->add_notification($farm_id, $this->data['lang']['farmTransaction'][$accObj->name], 4);
	                                }
                        	}
                	}
        }

        /*
         * this function used for apply equipment such as rock breaker to farm
         */

        function useEquipment()
        {
                if($_POST['equipment'] && $_POST['farm_id'])
		{
	                $frmMdl = new Farm();
			$frmObj = $frmMdl->get_by_id($_POST['farm_id']);
			switch($_POST['equipment'])
			{
				case 'rockBreaker':
					if($frmObj->level > 4 && $frmObj->section == 1)
					{
						$frmObj->money -= 100;
						$frmObj->section = 2;
						$frmObj->save();
					}
					break;
				case 'waterpump':
					if($frmObj->level > 6 && $frmObj->section == 2)
					{
						$frmObj->money -= 200;
						$frmObj->section = 3;
						$frmObj->save();
					}
					break;
			}
			echo $frmObj->section;
        	}	    
        }

        function deleteNotification()
        {
                if($_POST['not_id'])
                {
                        $this->user_model->deleteNotification($_POST['not_id']);
                }
        }
        function syncNotification()
        {
                if($_POST['farm_id'])
                {
                        $notifications = $this->user_model->get_notifications($_POST['farm_id']);

                        if($notifications)
                        foreach($notifications AS $not)
                            echo "<li  id=\"notification-$not[id]\">".anchor("farms/deleteNotification/$not[id]",
                                                                             "DEL",
                                                                             array('onclick'=>"deleteNotification(".$not[id].");return false;"))."<p>$not[body]<br/>".fa_strftime("%d %B %Y", date("l", $not[create_date]))."</p></li>";

                }
        }

}
?>
