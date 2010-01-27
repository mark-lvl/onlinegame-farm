<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainController
 *
 * @author mark
 */
class MainController extends Controller {

    function MainController()
    {
        parent::Controller();

        $this->load->language('titles', get_lang());
        $this->load->language('labels', get_lang());
        $this->load->language('errors', get_lang());
    }
    

}
?>
