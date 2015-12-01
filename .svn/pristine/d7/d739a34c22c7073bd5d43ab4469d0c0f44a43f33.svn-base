<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/functions.php');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addStyleSheet( SITE_URL.'components/com_terim_sozlugu/assets/terim_sozlugu.css' );
//$document->addScript( SITE_URL.'components/com_protokol_ms/assets/protokol_ms.js' );

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

class Terim_SozluguController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID));
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		if(!$isSektorSorumlusu)
			$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
		
		parent::display();
	}
	
	function ajaxSozlukteAra()
	{
		$terimAdi = $_POST['terimAdi'];
		$terimAciklama = $_POST['terimAciklama'];
		
		$model = &$this->getModel('terim_sozlugu');
		$model->ajaxSozlukteAra ($terimAdi, $terimAciklama );
		
	}
	function ajaxSozlugeEkle()
	{
		$terimAdi = $_POST['terimAdi'];
		$terimAciklama = $_POST['terimAciklama'];
	
		$model = &$this->getModel('terim_sozlugu');
		$model->ajaxSozlugeEkle ($terimAdi, $terimAciklama );
	
	}
	function updateAktifPasif()
	{
		$terimArr = JRequest::getVar('seciliTerimIDleri');
		$aktiflestirsinmi = JRequest::getVar('aktiflestirsinmi');
		$model 		 = $this->getModel('terim_sozlugu');
		
		if($aktiflestirsinmi == '1')
			$aktiflik = PM_TERIM_AKTIFLIK__AKTIF;
		else
			$aktiflik = PM_TERIM_AKTIFLIK__PASIF;

		$message	 = $model->updateAktifPasif($terimArr, $aktiflik);
		$this->setRedirect('index.php?option=com_terim_sozlugu', $message);
	}
	

}

?>