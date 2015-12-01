<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js' );

$document->addStyleSheet( SITE_URL.'components/com_birim_yonetimi/assets/birim_yonetimi.css' );
$document->addScript( SITE_URL.'components/com_birim_yonetimi/assets/birim_yonetimi.js' );

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

class Birim_YonetimiController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$isAuthorized = (FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID ));
		$isAuthorized = $isAuthorized || (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID ));
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		if(!$isAuthorized)
		$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
		
		parent::display();
	}
	
	function ajaxAddNewBirim (){
		$model = &$this->getModel('birim_yonetimi_ajax');
		$model->ajaxAddNewBirim ();
	}
	function sil()
	{
		$model 		 = $this->getModel('birim_yonetimi');
		$birimArr = JRequest::getVar('protokollerCheckbox');
		$message	 = $model->birimleriSil($birimArr, &$messageType);
		$this->setRedirect('index.php?option=com_birim_yonetimi', $message, $messageType);
	}
}

?>