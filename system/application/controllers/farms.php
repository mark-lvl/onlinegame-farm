<?php
class Farms extends MainController {

    //resource id's
    const WATER_ID = 1;
    const MUCK_ID  = 2;

    //have mission
    const MISSION = FALSE;

    const ITEMPERPAGE = 8;

    const SECTION_INCREASE_PRICE = 500;

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
				 'Plantresource',
                                 'Userrank'));
        //load css files
        $this->add_css('jquery.countdown');
        $this->add_css('farm');
        $this->add_css('home');

        //load js files
        $this->loadJs('jquery.countdown/jquery.countdown.min');
        $this->loadJs('jquery.countdown/jquery.countdown-fa');
        $this->loadJs('jquery.loading/jquery.loading');
        $this->loadJs('jquery.progressbar');

        if($_SESSION['user']){
                  $this->userSessionHolder = unserialize($_SESSION['user']);}
    }

    function find($page = 0, $filter = "")
    {
		$this->data['controllerName'] = 'farms';
                
                $page = (int) $_POST['page'];
                if($page <= 0)
                    $page = 1;

		if(!$_POST['pagination'])
                {
                    $this->data['page']  = 1;
                    $frmMdl = new Farm();
                    $this->data['cnt'] = $frmMdl->get_count_farms_by_name($_POST['filter']);
                    unset($frmMdl);
                    
                    $this->data['parse'] = $_POST['filter'];

                    $frmMdl = new Farm();
                    $this->data['items'] = $frmMdl->get_farms_by_name($this->data['page'],  self::ITEMPERPAGE, $_POST['filter']);

                    $this->load->view("partials/search.tpl.php", $this->data);
                }
                else
                {
                    $lastPage = ceil($_POST['cnt']/self::ITEMPERPAGE);
                    if($page > $lastPage)
                        $page = $lastPage;

                    $this->data['page']  = $page;

                    $this->data['cnt'] = $_POST['cnt'];

                    $frmMdl = new Farm();
                    $this->data['items'] = $frmMdl->get_farms_by_name($this->data['page'],  self::ITEMPERPAGE, $_POST['filter']);

                    $this->load->view("farms/search-inner.tpl.php", $this->data);
                }
    }

    function register()
    {
        
        $user_id = $this->userSessionHolder->id;
        $farm = new Farm();
            $userFarm = $farm->where('user_id',$user_id)->where('disactive','0')->get();
        if($userFarm->exists())
                redirect('farms/show');
        else
        {
            if($this->input->post('name'))
	    {
	    	$farm->name = $this->input->post('name');
            	$farm->user_id = $user_id;

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
                	redirect("profile/user/$user_id");
		}
	    }
	    else
	    {
                redirect('profile/user/'.$user_id);
	    }
        }
    }

	function show()
	{
		$user = $this->user_model->is_authenticated();
                if(!$user)
                        redirect("/");

                if(!$this->user_model->has_farm($user->id))
                        redirect("profile/user/$user->id");

		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$user->id)->where('disactive','0')->get();

		$resource = new Resource();

		$pltModel = new Plant();

		$userPlant = $pltModel->plantSync($userFarm->id);

                $typeModel = new Type();
		$userPlant->typeName = $typeModel->get_where(array('id'=>$userPlant->type_id))->name;
		
		//this set disasters for farm in this level by random method
		$this->disasters($userFarm->id);

		$frmMisMdl = new Farmmission();
		$frmMisObj = $frmMisMdl->get_where(array('farm_id'=>$userFarm->id, 'status'=>0));

		if(!$frmMisObj->exists())
		{
			$misMdl = new Mission();
			$misObj = $misMdl->get_by_level($userFarm->level);
			$missionBox = $misObj;
		}
                
                $frmMisMdl = new Farmmission();
                $frmMisObj = $frmMisMdl->order_by("create_date","desc")->get_where(array('farm_id'=>$userFarm->id,'status'=>'2','mission_id'=>$userFarm->level));
                if($frmMisObj->id)
                    $statusBox = str_replace(array('__AMOUNT__','__TYPENAME__'),
                                           array($frmMisObj->stack,$this->lang->language[$userPlant->typeName]),
                                           $this->data['lang']['mission']['stack']);
                        

		$farmAccModel = new Farmaccessory();
		$usrFrmAcc = $farmAccModel->getFarmAccessoryForDisplay($userFarm->id);

		$pltObj = $pltModel->get_where(array('id'=>$userPlant->id,'farm_id'=>$userFarm->id,'reap'=>0));
		$typSrcMdl = new Typeresource();
		$pltTypSrcs = $typSrcMdl->get_where(array('type_id'=>$pltObj->type_id))->all;
		foreach($pltTypSrcs AS $pltTypSrc)
		{
			$srcHolder = $resource->get_by_id($pltTypSrc->resource_id);
			$pltTypSrcHolder[$srcHolder->name] = array($pltTypSrc->id,$pltObj->id);
		}
                
                $notification = $this->user_model->get_notifications($userFarm->id);

                $frmTrnMdl = new Farmtransaction();

                if($frmTrnMdl->get_where(array('goal_farm'=>$userFarm->id,'type'=>1,'flag'=>0))->exists())
                {
                    $this->data['attacksToFarm'] = $frmTrnMdl->group_by('accessory_id')->where(array('goal_farm'=>$userFarm->id,'type'=>1,'flag'=>0))->get()->all;
                }
                

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
                if($userFarm->level > 4  && !$userPlant->id && $userFarm->section < 2)
                        $equipments[] = 'grassCutter';
                if($userFarm->level > 6  && !$userPlant->id && $userFarm->section < 3)
                        $equipments[] = 'waterPump';
                if($userFarm->level > 8  && !$userPlant->id && $userFarm->section < 4)
                        $equipments[] = 'rockBreaker';


		
		$this->data['plantSources'] = $pltTypSrcHolder;
		$this->data['farmAcc'] = $usrFrmAcc;
		$this->data['plant'] = $userPlant;
		$this->data['farmResources'] = $this->resource_farm($userFarm->id);
		$this->data['resources'] = $allResource;
		$this->data['types'] = $allTypes;
		$this->data['farm'] = $userFarm;
		$this->data['missionBox'] = $missionBox;
		$this->data['statusBox'] = $statusBox;
		$this->data['notifications'] = $notification;
		$this->data['equipments'] = $equipments;

                $this->data['user'] = $user;
                $this->data['heading'] = '';
                $this->data['title'] = $this->lang->language['farm']." ".$userFarm->name;

                $this->add_css('popup');
                $this->loadJs('popup');
                $this->loadJs('boxy');
                $this->loadJs('tooltip');
                
                $this->add_css('boxyFarm');

		$this->render('home');
	}


	function view($id)
	{
		$user = $this->user_model->is_authenticated();

                if(!$user)
                {
                    //this flag show this user is not logged
                    $user->unAuthenticatedUser = TRUE;
                }
                
                //if view id same with userLogin id
                if($id == $user->id)
                        redirect('farms/show');


                $this->add_css('popup');
                $this->loadJs('popup');
		
		$farmModel = new Farm();
		$userFarm = $farmModel->where('user_id',$id)->where('disactive','0')->get();

		$resource = new Resource();

		$pltModel = new Plant();
		
		$userPlant = $pltModel->plantSync($userFarm->id);

//		$frmMisMdl = new Farmmission();
//		$frmMisObj = $frmMisMdl->get_where(array('farm_id'=>$userFarm->id, 'status'=>0));
//
//		$hints = array();
//		if(!$frmMisObj->exists())
//		{
//			$misMdl = new Mission();
//			$misObj = $misMdl->get_by_level($userFarm->level);
//			$hints[] = $misObj->description;
//		}

		$farmAccModel = new Farmaccessory();
		$usrFrmAcc = $farmAccModel->getFarmAccessoryForDisplay($userFarm->id);
	
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

                //this section for hold user with disactive farm and havent new active farm
                if(!$viewerFarm->id)
                    $viewerFarm = $farmModel->where('user_id',$this->userSessionHolder->id)->where('disactive','1')->order_by("create_date DESC")->get();

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
                

                $frmMisMdl = new Farmmission();
                $frmMisObj = $frmMisMdl->order_by("create_date","desc")->get_where(array('farm_id'=>$userFarm->id,'status'=>'2','mission_id'=>$userFarm->level));
                if($frmMisObj->id)
                    $statusBox = str_replace(array('__AMOUNT__','__TYPENAME__'),
                                           array($frmMisObj->stack,$this->lang->language[$userPlant->typeName]),
                                           $this->data['lang']['mission']['stack']);

                $frmTrnMdl = new Farmtransaction();
                $frmTrnObjs = $frmTrnMdl->where('offset_farm',$userFarm->id)
                                        ->or_where('goal_farm',$userFarm->id)
                                        ->order_by('create_date DESC')->limit(3)->get()->all;
  
                foreach ($frmTrnObjs as $frmTransaction)
                        if(($frmTransaction->offset_farm == $userFarm->id) && ($frmTransaction->type != 3))
                            $frmTransaction->messageStyle = "attack";
                        elseif(($frmTransaction->goal_farm == $userFarm->id) && ($frmTransaction->type != 3))
                            $frmTransaction->messageStyle = "deffence";
                        elseif(($frmTransaction->offset_farm == $userFarm->id) && ($frmTransaction->type == 3))
                            $frmTransaction->messageStyle = "help";
                        elseif(($frmTransaction->goal_farm == $userFarm->id) && ($frmTransaction->type == 3))
                                $frmTransaction->messageStyle = "help";

                $frmTrnMdl = new Farmtransaction();
                if($frmTrnMdl->get_where(array('goal_farm'=>$userFarm->id,'type'=>1,'flag'=>0))->exists())
                {
                    $this->data['attacksToFarm'] = $frmTrnMdl->group_by('accessory_id')->where(array('goal_farm'=>$userFarm->id,'type'=>1,'flag'=>0))->get()->all;
                }

                $partnerHintsHolder = array($this->lang->language['partnerHints-1'],
                                            $this->lang->language['partnerHints-2'],
                                            $this->lang->language['partnerHints-3'],
                                            $this->lang->language['partnerHints-4'],
                                            $this->lang->language['partnerHints-5'],
                                            $this->lang->language['partnerHints-6']);
                for($i=0;$i<2;$i++)
                {
                    $hintId = rand(0, count($partnerHintsHolder)-1);
                    $partnerHints[] = $partnerHintsHolder[$hintId];
                }

                $allResource = $resource->get()->all;

                

                $this->data['resources'] = $allResource;
                $this->data['partnerHints'] = $partnerHints;
                $this->data['transactions'] = $frmTrnObjs;
		$this->data['statusBox'] = $statusBox;
		$this->data['viewerAccessories'] = $viewerAccHolder;
		$this->data['plantSources'] = $pltTypSrcHolder;
		$this->data['farmAcc'] = $usrFrmAcc;
		$this->data['plant'] = $userPlant;
		$this->data['farmResources'] = $this->resource_farm($userFarm->id);
		$this->data['types'] = $allTypes;
		$this->data['farm'] = $userFarm;
		$this->data['hints'] = $hints;
                //this flag handel this farm for his friend
                $this->data['viewer'] = $user;
                $this->data['viewerFarm'] = $viewerFarm;
                $this->data['related'] = User_model::is_related($user, $id);

                $this->data['farmOwner'] = $this->user_model->get_user_by_id($id);
                $this->data['user'] = $user;
                $this->data['heading'] = '';
                $this->data['title'] = $this->lang->language['farm']." ".$userFarm->name;

                $this->loadJs('boxy');
                $this->loadJs('jquery.hints');
                $this->loadJs('tooltip');
                $this->add_css('boxyFarm');
		
		$this->render('home');
	}

	function addResourceToFarm()
	{ 
          $frmSrcModel = new Farmresource();

          $flag = $frmSrcModel->add($_POST['farm_id'],$_POST['resource_id']);
          if(is_array($flag))
              $this->error_reporter($flag['type'],$flag['params']);
          
          $this->resource_farm($_POST['farm_id'],$_POST['resource_id']);
		
	}

	function addPlantToFarm()
	{

		$pltModel = new Plant();
		$flag = $pltModel->add($_POST['farm_id'],$_POST['type_id']);

                if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params'],'main','boxyFarm');
                else
                    $this->refresh_page();
	}

	function addAccessoryToFarm($farm_id = null,$acc_id = null)
	{
		$accModel = new Farmaccessory();
		$flag = $accModel->add($_POST['farm_id'],$_POST['accessory_id']);
                
                if(is_array($flag))
                {
                    if($flag['type'] == 'public')
                        echo $this->lang->language['error']['farmAccessoryExists'];
                    elseif($flag['type'] == 'money')
                        echo "<span class=\"errorMessBuyAccessory\">".str_replace(array('__PRICE__','__MONEY__'),array($flag['params']['price'],$flag['params']['money']),$this->lang->language['money']['body'])."</span>";
                }
                else
                    echo $this->lang->language['accessoryAddedSuccessfully'];
               

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
                            $this->error_reporter('public',array('message'=>'plantResourceExists','height'=>80));
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

                                        if($_POST['viewer_id'])
                                        {
                                            $this->user_model->add_notification($pltObj->farm_id,
                                                                                str_replace(array(__VIEWERID__,__VIEWERNAME__),
                                                                                            array($_POST['viewer_id'],$_POST['viewer_name']),
                                                                                            $this->lang->language['helpFriend']),
                                                                                4);
                                            $frmTrnMdl = new Farmtransaction();
                                            if($_POST['viewer_farm_id'])
                                                $frmTrnMdl->add($_POST['viewer_farm_id'], $pltObj->farm_id, 0, 3, 1);
                                        }
                                        
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
                //if(is_array($flag))
                 //   $this->error_reporter($flag['type'],$flag['params']);

                $params['details'] = $flag['params'];
                $params['params']['farmName'] = $_POST['farm_name'];
                $params['action'] = 'reapConfirm';
                $params['farm_id'] = (int) $_POST['farm_id'];
                $params['farm_level'] = (int) $_POST['farm_level'];
                $this->error_reporter('ajaxWindow',$params,'ajaxWindow',true);

                //redirect('/farms/show');
	}

        function plow()
	{
          $frmModel = new Farm();

          $flag = $frmModel->plow($_POST['farm_id']);
          if(is_array($flag))
              $this->error_reporter($flag['type'],$flag['params']);
          else
              echo "<div class=\"plow\"></div>";
	}

        function sync()
	{
          $pltMdl = new Plant();

          $this->data['plant'] = $pltMdl->plantSync($_POST['farm_id']);
          $this->data['base_img'] = $this->data['base_img'];

          echo $this->load->view('farms/sync',$this->data,TRUE);
          
	}

        function syncAttackBox()
        {
            $frmTrnMdl = new Farmtransaction();

            if($frmTrnMdl->get_where(array('goal_farm'=>$_POST['farm_id'],'type'=>1,'flag'=>0))->exists())
            {
                $this->data['attacksToFarm'] = $frmTrnMdl->group_by('accessory_id')->where(array('goal_farm'=>$_POST['farm_id'],'type'=>1,'flag'=>0))->get()->all;
            }
            echo $this->load->view('farms/syncAttackBox',$this->data,TRUE);
        }


        /*
         * this method return the resource of the specific farm by id
         * params farm_id
         * params output : determine the type of return object
         * return : the view or the output string of view
         */
        function resource_farm($farm_id = null,$resourceParam = null)
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
          
          if(!$resourceParam)
            return $resourceHolder;
          else
          {
              if($resourceParam == 1)
                  echo $resourceHolder['Water'];
              elseif($resourceParam == 2)
                  echo $resourceHolder['Muck'];
          }
	}

        /*
         * this method return the resource of the specific farm by id
         * params farm_id
         * params output : determine the type of return object
         * return : the view or the output string of view
         */
        function showInventory($farm_id = null,$output = null)
	{
          $frmAccModel = new Farmaccessory();
          $accMdl = new Accessory();

          $usrFrmAcc = $frmAccModel->get_where(array('farm_id'=>$_POST['farm_id']))->all;
		//7 == scarecrow accessory_id and 8 == dog accessory id
                foreach($usrFrmAcc AS $accItem)
		{
                        //this section gc for expired item
			if($accItem->expire_date)
				if(time() > $accItem->expire_date)
                                {
                                    $accItem->delete();
                                    continue;
                                }

                        //this section gc for item with count 0
                        if($accItem->count < 1)
                        {
                            $accItem->delete();
                            continue;
                        }

			$accObject = $accMdl->get_by_id($accItem->accessory_id);

                        if($accObject->type == 1)
                                $accHolder['attack'][] = array('id'=>$accObject->id,'name'=>$accObject->name,'count'=>$accItem->count);
                        elseif($accObject->type == 2)
                        {
                                if($accObject->id == 7 || $accObject->id == 8)
                                        $accHolder['deffence'][] = array('id'=>$accObject->id,'name'=>$accObject->name,'expire'=>$accItem->expire_date-time());
                                else
                                        $accHolder['deffence'][] = array('id'=>$accObject->id,'name'=>$accObject->name,'count'=>$accItem->count);
                        }
                        elseif($accObject->type == 4)
                        {
                                if($accObject->group == 20)
                                    $accHolder['tools'][] = array('id'=>$accObject->id,'name'=>$accObject->name,'count'=>$accItem->count);
                                elseif ($accObject->group == 10 || $accObject->group == 11)
                                    $accHolder['specialTools'][] = array('id'=>$accObject->id,'name'=>$accObject->name,'count'=>$accItem->count);
                        }
		}

	  if(is_null($accHolder))
		$accHolder = array();
          $params['farmAccessories'] = $accHolder;
          $params['action'] = 'showInventory';
          $params['farm_id'] = (int) $_POST['farm_id'];
          
          //this flag used for control haventAnyAccessory message in partnerView mode
          if($_POST['partner'])
            $params['partnerView'] = TRUE;
          
          $this->error_reporter('ajaxWindow',$params,'ajaxWindow',true);
	}

        /*
         * this method return the accessory of partner user for attack
         * params user_id
         * return : the view of attack accessory
         */
        function showPartnerInventory()
	{
            $farm_id = $this->user_model->has_farm($_POST['user_id']);

            $frmAccModel = new Farmaccessory();
            $accMdl = new Accessory();

            $usrFrmAcc = $frmAccModel->get_where(array('farm_id'=>$farm_id))->all;
		//7 == scarecrow accessory_id and 8 == dog accessory id
                foreach($usrFrmAcc AS $accItem)
		{
                        //this section gc for expired item
			if($accItem->expire_date)
				if(time() > $accItem->expire_date)
                                {
                                    $accItem->delete();
                                    continue;
                                }

                        //this section gc for item with count 0
                        if($accItem->count < 1)
                        {
                            $accItem->delete();
                            continue;
                        }

			$accObject = $accMdl->get_by_id($accItem->accessory_id);
                        
                        if($accObject->type == 1)
                                $accHolder['attack'][] = array('id'=>$accObject->id,'type'=>$accObject->type,'name'=>$accObject->name,'description'=>$accObject->description,'count'=>$accItem->count);
                        
		}

	  if(is_null($accHolder))
		$accHolder = array();
          $params['farmAccessories'] = $accHolder;
          $params['action'] = 'showPartnerInventory';
          $this->error_reporter('ajaxWindow',$params,'ajaxWindow',true);
	}

        /*
         * this function use for refresh farm money from ajax calling
         * params int farm_id
         * return int money
         */
        function moneyCalc()
        {
            //this condition used in farmPartnerView mode
            if(isset($_POST['farm_user_id']))
                $user_id = $_POST['farm_user_id'];
            else
                $user_id = $this->userSessionHolder->id;

            $farmModel = new Farm();
	    $userFarm = $farmModel->get_where(array('user_id'=>$user_id,
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
                        if($frmObj->money > self::SECTION_INCREASE_PRICE)
			switch($_POST['equipment'])
			{
				case 'grassCutter':
					if($frmObj->level > 4 && $frmObj->section == 1)
					{
						$frmObj->money -= self::SECTION_INCREASE_PRICE;
						$frmObj->section = 2;
						$frmObj->save();
					}
					break;
                                case 'waterPump':
					if($frmObj->level > 6 && $frmObj->section == 2)
					{
						$frmObj->money -= self::SECTION_INCREASE_PRICE;
						$frmObj->section = 3;
						$frmObj->save();
					}
					break;
                                case 'rockBreaker':
					if($frmObj->level > 8 && $frmObj->section == 3)
					{
						$frmObj->money -= self::SECTION_INCREASE_PRICE;
						$frmObj->section = 4;
						$frmObj->save();
					}
					break;
			}
                        else
                        {
                            $params = array('money'=>$frmObj->money,'price'=>self::SECTION_INCREASE_PRICE,'height'=>80);
                            $this->error_reporter('money',$params);
                            return FALSE;
                        }

                        if($frmObj->plow)
                            echo "<div class=\"plow\"></div>";
                        else
                            echo "<div class=\"unPlow\"></div>";
        	}	    
        }

        function deleteNotification()
        {
                if($_POST['not_id'])
                {
                    if($_POST['not_id'] == 'all')
                        $this->user_model->deleteNotification($_POST['farm_id'],true);
                    else
                        $this->user_model->deleteNotification($_POST['not_id']);
                }
        }

        function syncNotification()
        {
                if($_POST['farm_id'])
                {
                        $notifications = $this->user_model->get_notifications($_POST['farm_id'],true);

                        if($notifications)
                        foreach($notifications AS $not)
                        {
                            if($not['checked'] == 0)
                                $notDescription = "<img src=\"".$this->data['base_img']."/newNotification.png\">&nbsp;&nbsp;".$not['body']."<br/><span class=\"notificationDate\">".fa_strftime("%H:%M:%S %p %d %B %Y", date("Y-m-d H:i:s", $not[create_date]))."</span>";
                            else
                                $notDescription = $not['body']."<br/><span class=\"notificationDate\">".fa_strftime("%H:%M:%S %p %d %B %Y", date("Y-m-d H:i:s", $not[create_date]))."</span>";
                                
                            echo "<li  id=\"notification-$not[id]\"><p>".anchor("farms/deleteNotification/$not[id]",
                                                                             "X",
                                                                             array('onclick'=>"deleteNotification(".$not[id].");return false;"))."$notDescription</p></li>";
                        }
                }
        }

        function resetFarm($farm_id = null)
        {
                if($_POST['farm_id'])
                        $farm_id = $_POST['farm_id'];

                $frmMdl = new Farm();

                $frmObj = $frmMdl->get_by_id($farm_id);

                $pltMdl = new Plant();


                $pltObj = $pltMdl->get_where(array('farm_id'=>$farm_id,'reap'=>0));
                if($pltObj->exists())
                {
                        $this->error_reporter('public',array('message'=>'cantResetWhenHavePlant'));
                        return FALSE;
                }
                $usrrkMdl = new Userrank();
                $usrrnkObj = $usrrkMdl->get_where(array('type'=>0,'user_id'=>$frmObj->user_id));
                if($usrrnkObj->exists())
                {
                        if($usrrnkObj->rank < $frmObj->level)
                        {
                                $usrrnkObj->rank = $frmObj->level;
                                $usrrnkObj->save();
                        }
                }
                else
                {
                        $usrrkMdl->type = 0;
                        $usrrkMdl->rank = $frmMdl->level;
                        $usrrkMdl->user_id = $frmObj->user_id;
                        $usrrkMdl->save();
                }
                $frmObj->disactive = 1;
                if($frmObj->save())
                        {
                        $this->js_redirect("profile/user/".$frmObj->user_id);
                        return FALSE;
                        }
        }

        function resetLevel($farm_id = null)
        {
                if($_POST['farm_id'] && !$_POST['confirmResetFarm'])
                {
                    $this->error_reporter('resetLevel',$_POST);
                }
                elseif($_POST['farm_id'] && $_POST['confirmResetFarm'])
                {
                    if($_POST['farm_id'])
                        $farm_id = $_POST['farm_id'];

                    $frmMdl = new Farm();

                    $frmObj = $frmMdl->get_by_id($farm_id);

                    $pltMdl = new Plant();


                    $pltObj = $pltMdl->get_where(array('farm_id'=>$farm_id,'reap'=>0));
                    if(!$pltObj->exists())
                    {
                            $this->error_reporter('public',array('message'=>'cantResetWhenHaventPlant','height'=>80));
                            return FALSE;
                    }
                    else
                    {
                        if($pltObj->removePlantWithResources($pltObj->id))
                            $this->error_reporter('public',array('message'=>'levelResetSuccefully','height'=>80,'afterHide'=>'reloadPage'));
                        else
                            $this->error_reporter('public',array('message'=>'levelResetFaild','height'=>80));
                    }

                }
                


                //$frmObj->disactive = 1;
//                if($frmObj->save())
//                        {
//                        $this->js_redirect("profile/user/".$frmObj->user_id);
//                        return FALSE;
//                        }
        }

        function mission()
        {
            $misMdl = new Mission();
            $misObj = $misMdl->get_by_id($_POST['mission']);
            $mission = array();
            $mission['farm_id'] = $_POST['farm_id'];
            $mission['farm_plow'] = $_POST['farm_plow'];
            $mission['section'] = $_POST['section'];
            $mission['level'] = $misMdl->level;
            $mission['description'] = $misMdl->description;

            if($misMdl->needed_accessory)
            {
                $accs = unserialize($misMdl->needed_accessory);
                foreach ($accs as $acc)
                {
                    $accMdl = new Accessory();
                    $accObj = $accMdl->get_by_id($acc);
                    $mission['accessories'][] = $accObj->name;
                }
            }
            $mission['plant'] = array();
            if($misObj->type_id)
            {
                $typMdl = new Type();
                $typObj = $typMdl->get_by_id($misObj->type_id);
                $mission['plant'][0]['id'] = $typObj->id;
                $mission['plant'][0]['name'] = $typObj->name;
                $mission['plant'][0]['price'] = $typObj->price;
                $mission['plant'][0]['sellPrice'] = $typObj->sell_cost;
                $mission['plant'][0]['weight'] = $typObj->weight;
                $mission['plant'][0]['growthTime'] = $typObj->growth_time;

                $typResMdl = new Typeresource();
                $typResObjs = $typResMdl->get_where(array('type_id'=>$misObj->type_id))->all;
                foreach($typResObjs AS $typResObj)
                    $mission['plant'][0]['resource'][$typResObj->resource_id] = $typResObj->consumeTime;
            }
            else
            {
                $typMdl = new Type();
                $typObjs = $typMdl->get()->all;
                $index = 0;
                foreach($typObjs AS $typObj)
                {
                    $mission['plant'][$index]['id'] = $typObj->id;
                    $mission['plant'][$index]['name'] = $typObj->name;
                    $mission['plant'][$index]['price'] = $typObj->price;
                    $mission['plant'][$index]['sellPrice'] = $typObj->sell_cost;
                    $mission['plant'][$index]['weight'] = $typObj->weight;
                    $mission['plant'][$index]['growthTime'] = $typObj->growth_time;

                    $typResMdl = new Typeresource();
                    $typResObjs = $typResMdl->get_where(array('type_id'=>$typObj->id))->all;
                    foreach($typResObjs AS $typResObj)
                        $mission['plant'][$index]['resource'][$typResObj->resource_id] = $typResObj->consumeTime;

                    $index++;
                }
            }
            $params['mission'] = $mission;
            $params['action'] = 'mission';
            $this->error_reporter('ajaxWindow',$params,'ajaxWindow',true);
        }

        function buyAccessory()
        {
            $accMdl = new Accessory();
            $accObjs = $accMdl->order_by('level')->get()->all;
            foreach($accObjs AS $acc)
            {
                if($acc->type == 1)
                        $accHolder['attack'][] = $acc;
                elseif($acc->type == 2)
                        $accHolder['deffence'][] = $acc;
                elseif($acc->type == 4)
                {
                    if($acc->group == 20)
                        $accHolder['tools'][] = $acc;
                    elseif ($acc->group == 10 || $acc->group == 11)
                        $accHolder['specialTools'][] = $acc;
                }
            }
            $frmAccModel = new Farmaccessory();
            $usrFrmAccs = $frmAccModel->get_where(array('farm_id'=>$_POST['farm_id']))->all;
            foreach ($usrFrmAccs as $usrFrmAcc)
                $farmAccs[$usrFrmAcc->accessory_id] = $usrFrmAcc->count;

            if(!is_array($farmAccs))
                $farmAccs = array();

            $params['farmAccs'] = $farmAccs;
            $params['accessories'] = $accHolder;
            $params['action'] = 'buyAccessory';
            $params['farm_id'] = (int) $_POST['farm_id'];
            $params['farm_level'] = (int) $_POST['farm_level'];
            $this->error_reporter('ajaxWindow',$params,'ajaxWindow',true);
        }
}
?>
