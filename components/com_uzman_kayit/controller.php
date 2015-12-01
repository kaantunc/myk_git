<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
require_once("libraries/form/functions.php");
//$document->addScript( SITE_URL.'/templates/elegance/js/jquery.validate.min.js' );

class Uzman_KayitController extends JController {
	
    function display() {
    	
        parent::display();
    }
    
    function uzmanKaydet() {
		$model 		 = $this->getModel('uzman_kayit');
		$post 		 = JRequest::get( 'post' );
		
		$model->uzmanKaydet ($post);
    }

}
?>