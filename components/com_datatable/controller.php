<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class DatatableController extends JController {
	
    function display() {
    	
        parent::display();
    }
    
    function ajaxSaveRow (){
    	$model = &$this->getModel('datatable'); 	 
    	$model->ajaxSaveRow ();
    }
    
    function ajaxEditRow (){
    	$model = &$this->getModel('datatable');
    	$model->ajaxEditRow ();
    }
    
    function ajaxDeleteRow (){
    	$model = &$this->getModel('datatable');
    	$model->ajaxDeleteRow ();
    }
}
?>