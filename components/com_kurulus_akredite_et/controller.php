<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/functions.php');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addStyleSheet( SITE_URL.'components/com_yetkilendirme_yet/assets/yetkilendirme_yet.css' );
$document->addScript( SITE_URL.'components/com_yetkilendirme_yet/assets/yetkilendirme_yet.js' );

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

class Kurulus_Akredite_EtController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		$this->authenticationCheckAccordingToLayouts();
		
		parent::display();
	}
	function authenticationCheckAccordingToLayouts()
	{
		global $mainframe;
	
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$model = $this->getModel();
		
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
	
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		switch($_GET['layout'])
		{
			case '':
			case 'default':		
				if($user == null || $model->akreditasyonKurulusuMu($userId)==false)
					$mainframe->redirect("index.php", "Onaylı akreditasyon başvurunuz yok.", 'error');
				break;
			case 'akredite_edilmis_kuruluslar': 			//OK
				if(!$isSektorSorumlusu)
					$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
				break;
		}
	
	}
	
	
	
	function akrediteKurulusKaydet()
	{
		global $mainframe;
		$model = $this->getModel();
		$result = $model->akrediteKurulusKaydet();
		$mainframe->redirect("index.php?option=com_kurulus_akredite_et", "Başarıyla Kaydedildi.");
		
	}
	function ajaxKurulusunAkrediteEttigiKuruluslariGetir()
	{
		$model = $this->getModel();
		$result = $model->ajaxKurulusunAkrediteEttigiKuruluslariGetir();
		
	}
}

?>