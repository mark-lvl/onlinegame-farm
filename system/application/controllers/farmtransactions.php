<?php
class Farmtransactions extends MainController {

        var $userSessionHolder;

        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('Farmtransaction',
                                     'Farm','Accessory'));

            $this->loadJs('jquery.loading/jquery.loading');

            if($_SESSION['user']){
                  $this->userSessionHolder = unserialize($_SESSION['user']);}
        }

        function spraying($farm = null)
        {
            if(!isset($_POST['confirmAccept']))
                $this->error_reporter('farmActionConfirm',$_POST);
            else
            {
                $frmTrnMdl = new Farmtransaction();
                $flag = $frmTrnMdl->spraying($_POST['farm_id']);

                if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);
            }
        }

        function deffenceWithGun()
        {
                if(!isset($_POST['confirmAccept']))
                    $this->error_reporter('farmActionConfirm',$_POST);
                else
                {
                    $frmTrnMdl = new Farmtransaction();
                    $flag = $frmTrnMdl->deffenceWithGun($_POST['farm_id']);


                    if(is_array($flag))
                            $this->error_reporter($flag['type'],$flag['params']);
                }

        }

	function add()
	{
		$farmTrnMdl = new Farmtransaction();

                if($_POST['acc_id'])
                {
                    $accMdl = new Accessory();
                    $accObj = $accMdl->get_by_id($_POST['acc_id']);
                    $details = $this->data['lang']['farmTransaction'][$accObj->name];
                }
                else
                    $details = $_POST['details'];


                $flag = $farmTrnMdl->add($_POST['off_farm'],
					 $_POST['goal_farm'],
					 $_POST['acc_id'],
					 $_POST['type'],
                                         $details,
                                         $_POST['user_id']
                                        );

                if(is_array($flag))
                    if ($flag['type'] == 'public' && ($flag['params']['message'] != 'cantHelpTwiceInADay'))
                        echo $this->lang->language['error'][$flag['params']['message']];
                    else
                        $this->error_reporter($flag['type'],$flag['params']);
                else
                    if($flag == 'attackComplete')
                        echo $this->lang->language['attackComplete'];
                    else
                        $this->error_reporter('alert',array('message'=>$this->lang->language['helpComplete'],'title'=>$this->lang->language['helpTitle'],'height'=>80));
	}

        function moneyHelp()
        {
            $this->is_logged_user($_POST['user_id']);
            if($_POST['acc_id'] == 0 && $_POST['type'] == 3 && $_POST['details'] == 3)
            {
                $this->error_reporter('moneyHelp',$_POST);
            }
        }
}
?>
