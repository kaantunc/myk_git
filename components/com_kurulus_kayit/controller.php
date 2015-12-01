<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
//$document->addScript( SITE_URL.'/templates/elegance/js/jquery.validate.min.js' );

class Kurulus_KayitController extends JController {
	
    function display() {
    	
        parent::display();
    }
    
    function kurulusKaydet() {
		$model 		 = $this->getModel('kurulus_kayit');
		$post 		 = JRequest::get( 'post' );
		
		$model->kurulusKaydet ($post);
    }

}
?>