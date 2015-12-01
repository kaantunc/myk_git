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
$document->addScript( SITE_URL.'/components/com_akreditasyon_basvur/js/akreditasyon_basvur.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.monthpicker.js');
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

/**
 * Rate Component Controller
 */
class Akreditasyon_BasvurController extends JController {

	function basvuruKaydet (){
		
		
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T4_BASVURU_TIP, $user);
		
		$message	 = $model->basvuruKaydet ($post, $layout, $evrak_id);
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		$this->setRedirect('index.php?option=com_akreditasyon_basvur&view=akreditasyon_basvur&layout='.$layout, $message);
	}
	
	function basvuruBitir (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T1_BASVURU_TIP, $user);
		$session->set("evrak_id", $evrak_id);
		
		$model->basvuruBitir ($evrak_id);
		$message = JText::_("BASVURU_GONDERILDI_MESAJ");
		$this->setRedirect('index.php?option=com_akreditasyon_basvur&view=akreditasyon_basvur&layout=pdf_link', $message);
	}
	
    function display() {
    	
        parent::display();
    }

}
?>