<?php
class Farmtransactions extends MainController {

        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('Farmtransaction',
                                     'Farm','Accessory'));

            $this->loadJs('jquery.loading/jquery.loading');
        }

        function spraying($farm = null)
        {
            $frmTrnMdl = new Farmtransaction();
            $flag = $frmTrnMdl->spraying($_POST['farm']);

            //if($_POST['viewer_id'])
                    //$this->user_model->add_notification($_POST['farm'], str_replace(array(__VIEWERID__,__VIEWERNAME__), array($_POST['viewer_id'],$_POST['viewer_name']), $this->lang->language['helpFriend']), 4);

            if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);
        }

        function deffenceWithGun()
        {
                $frmTrnMdl = new Farmtransaction();
                $flag = $frmTrnMdl->deffenceWithGun($_POST['farm_id']);


                if(is_array($flag))
                        $this->error_reporter($flag['type'],$flag['params']);
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
                                         $details
                                        );
                if(is_array($flag))
                        echo $this->lang->language['error'][$flag['params']['message']];
                else
                    echo $this->lang->language['attackComplete'];
	}
}
?>
