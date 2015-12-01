<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );

/**
 * Rate Component Controller
 */
class AkreditasyonController extends JController {

	function takvimKaydet(){

		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		
        $post = JRequest::get( 'post' );
        
        $mode = JRequest::getVar( 'mode' );
        
        if($mode == 'taslak'){
        	$message = $model->takvimKaydet($db, $post, SINAV_TAKVIM_TASLAK);
        	JRequest::setVar('view', 'takvim_ozet');
        	//JRequest::set($post,'POST');
        	parent::display();
       		//$this->setRedirect('index.php?option=com_sinav&view=takvim_ozet' , $message);
        }
        else if($mode == 'kaydet'){
        	
        	
//			echo '<pre>';
//			print_r($_POST);
//			echo '</pre>';
			$serializedPost = JRequest::getVar( 'serializedPost' );
        	$post = unserialize($serializedPost);
        	
        	$message = $model->takvimKaydet($db, $post, SINAV_TAKVIM_KAYDEDILDI);
        	//die();
        	$this->setRedirect('index.php?option=com_akreditasyon&view=takvim' , $message);
        }
        
		
	}
	function kurulusKaydet(){

		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('kurulus_gir');
		
        $post = JRequest::get( 'post' );
                       	
        $message = $model->kurulusKaydet($db, $post);
        //echo $message;
        //die();
        $this->setRedirect('index.php' , $message);
        
        
		
	}
	
	function takvimAl(){

		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
        $post = JRequest::get( 'post' );
        $mode = JRequest::getVar( 'mode' );
        
        if($mode != null)
        	$mode = SINAV_TAKVIM_TASLAK;
        else
        	$mode = SINAV_TAKVIM_KAYDEDILDI;
        
        $message = $model->takvimAl($db, $post, $mode);
		
		
	}
	
	function kurulusSil(){

		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('kurulus_gir');
		
        $kurulusId = JRequest::getVar( 'kurulusId' );
                       	
        $message = $model->kurulusSil($db, $kurulusId);
        echo $message;
        //die();
        //$this->setRedirect('index.php' , $message);
	}
	
    function display() {
    	
    // sets one Standard view
    	//$this->setRedirect('index.php?'.JRequest::getCmd( 'view' ));
        if ( ! JRequest::getCmd( 'view' ) ) {
		//$this->setRedirect('index.php');
        	
       		//JRequest::setVar('view', 'sinav' );
        }
        parent::display();
    }
    
}
?>