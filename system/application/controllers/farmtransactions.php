<?php
class Farmtransactions extends MainController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Farmtransaction',
                                 'Farm'
                                 ));
    }

    function spraying($farm = null)
    {
        $frmTrnMdl = new Farmtransaction();
        $flag = $frmTrnMdl->spraying($_POST['farm']);
        
        if(is_array($flag))
                    $this->error_reporter($flag['type'],$flag['params']);
    }
}
?>
