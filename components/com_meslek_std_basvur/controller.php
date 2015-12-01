<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");

$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_meslek_std_basvur/js/meslek_std_basvur.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

/**
 * Rate Component Controller
 */
class Meslek_Std_BasvurController extends JController {
	
	function standartKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		//$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T1_BASVURU_TIP, $user);
		$evrak_id = $_POST['evrak_id'];
		$message	 = $model->standartKaydet ($post, $layout, $evrak_id);
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_meslek_std_basvur&layout='.$layout.'&evrak_id='.$evrak_id, $message);
	}
	
	function standartKaydetYeni() {
		$model 		 = $this->getModel('basvuru_kaydet');
		$session	 = &JFactory::getSession();
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$data        = $model->standartKaydetYeni($post,$files);
	
		$evrak_id = $data['evrak_id'];
		$session->set("evrak_id", $evrak_id);
	
		$this->setRedirect('index.php?option=com_meslek_std_basvur&evrak_id='.$evrak_id.'&layout='.$layout, $message);
	}
	
	function basvuruBitir (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T1_BASVURU_TIP, $user);
		$session->set("evrak_id", $evrak_id);
		
		$model->basvuruBitir ($evrak_id, $user->getOracleUserId());
		$message = JText::_("BASVURU_GONDERILDI_MESAJ");
		$this->setRedirect('index.php?option=com_meslek_std_basvur&view=meslek_std_basvur&layout=pdf_link&evrak_id='.$evrak_id, $message);
	}
	
	function ajaxBasvuruSil(){
		$model 		 = $this->getModel('meslek_std_basvur');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxBasvuruSil($post));
	}
	
    function display() {
    	
        parent::display();
    }
    
    
    

}
?>