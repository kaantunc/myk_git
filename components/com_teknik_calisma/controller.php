<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
//patchSatirEkle ve rowAdded icin
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );
require_once("libraries/form/functions.php");

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_yeterlilik_taslak_yeni/js/yeterlilik_taslak.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js' );

////////////////////////////////////////////////////////////////////////////////////////////////
$document = &JFactory::getDocument();
// $document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
// $document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
// $document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addStyleSheet( SITE_URL.'components/com_yeterlilik_taslak_yeni/assets/yeterlilik_taslak_yeni.css' );
//$document->addScript( SITE_URL.'components/com_protokol/assets/protokol.js' );

$document->addStyleSheet( SITE_URL.'/includes/js/smartspinner/smartspinner.js' );

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


/**
 * Teknik Calisma Component Controller
 */
class Teknik_CalismaController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID)
								||
							  FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
		
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		if(!$isSektorSorumlusu)
			$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
		
        parent::display();
    }
    
   
    function teknikCalismaGrubuKaydet()
    {
    	$model = &$this->getModel();
    	if(strlen($_POST['userIdToUpdate'])==0)
    		$message = $model->teknikCalismaGrubuKaydet();
    	else
     		$message = $model->teknikCalismaGrubuUpdateEt();
    		
    	$this->setRedirect('index.php?option=com_teknik_calisma&layout=listele', $message);
    }
    
    function TCG_Sil()
    {
    	$model = &$this->getModel();
    	$message = $model->TCG_Sil();
    	$this->setRedirect('index.php?option=com_teknik_calisma&layout=listele', $message);
    }
    
    

}
?>