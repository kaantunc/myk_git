<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
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

$document->addStyleSheet( SITE_URL.'components/com_yonetim_kurulu/assets/yonetim_kurulu.css' );

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


class Yonetim_KuruluController extends JController
{

    function display()
    {
    	// AUTHENTICATION CHECK
    	global $mainframe;
    	$user = & JFactory::getUser();
    	$userId = $user->getOracleUserId();
    	$isAdmin = (FormFactory::checkAclGroupId($user->id, YONETICI_GROUP_ID));
    	// MESLEK STANDARDI SEKTOR SORUMLUSU
    	if(!$isAdmin)
    	$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
        parent::display();
    }
    
    function uyeKaydet()
    {
    	$uyeID = JRequest::getVar('uyeID');
    	
    	if(strlen($uyeID)==0) // ADD
    	{
    		$uyeID = $this->uyeKaydet_YeniUyeEkle();
    		$message="Başarıyla eklendi";
    		$this->setRedirect('index.php?option=com_yonetim_kurulu', $message);
    	}
    	else // EDIT
    	{
    		$db  = &JFactory::getOracleDBO();
    		
    		$uyeAdiSoyadi = JRequest::getVar('uyeAdiSoyadiTextbox');
    		$uyeUnvani = JRequest::getVar('uyeUnvaniTextbox');
    		$uyeKurumu = JRequest::getVar('uyeKurumuTextbox');
    		$uyeBaslangicTarihi = JRequest::getVar('uyeBaslangicTarihiDatePicker');
    		$uyeBitisTarihi = JRequest::getVar('uyeBitisTarihiDatePicker');

    		$message = $this->uyeKaydet_VarolanUyeyiDuzenle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi);
    		$message = "Başarıyla kaydedildi";
    		$this->setRedirect('index.php?option=com_yonetim_kurulu', $message);
    	}
    }
    
    function uyeKaydet_YeniUyeEkle(){
    	$db  = &JFactory::getOracleDBO();
    	
    	$uyeAdiSoyadi = JRequest::getVar('uyeAdiSoyadiTextbox');
    	$uyeUnvani = JRequest::getVar('uyeUnvaniTextbox');
    	$uyeKurumu = JRequest::getVar('uyeKurumuTextbox');
    	$uyeBaslangicTarihi = JRequest::getVar('uyeBaslangicTarihiDatePicker');
    	$uyeBitisTarihi = JRequest::getVar('uyeBitisTarihiDatePicker');
    		
    	$model 		 = $this->getModel('yonetim_kurulu_kaydet');
    	
    	$uyeID = $db->getNextVal (YONETIM_KURULU_ID_SEQ);
    	$result	 = $model->uyeEkle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi);
    	
    	if($result)//SUCCESS, MUST EDIT
    	$this->setRedirect('index.php?option=com_yonetim_kurulu', "Başarıyla Eklendi");
    	else
    	$this->setRedirect('index.php?option=com_yonetim_kurulu&layout=yeni', $message);
    	
    	
    	return $uyeID;
    }
    
    function uyeKaydet_VarolanUyeyiDuzenle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi)
    {
    	$model 		 = $this->getModel('yonetim_kurulu_kaydet');
    	$message	 = $model->uyeBilgileriDuzenle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi);
    	
    	return $message;
    }
	
    function etkisizlestir()
    {
    	$model 		 = $this->getModel('yonetim_kurulu_kaydet');
    	$yonetimKuruluArr = JRequest::getVar('yonetimKuruluCheckbox');
    	$message	 = $model->uyeleriEtkisizlestir($yonetimKuruluArr);
    	$this->setRedirect('index.php?option=com_yonetim_kurulu', $message);
    }
    
    function etkinlestir()
    {
    	$model 		 = $this->getModel('yonetim_kurulu_kaydet');
    	$yonetimKuruluArr = JRequest::getVar('yonetimKuruluCheckbox');
    	$message	 = $model->uyeleriEtkinlestir($yonetimKuruluArr);
    	$this->setRedirect('index.php?option=com_yonetim_kurulu', $message);
    }
    
    function sil()
	{
		$model 		 = $this->getModel('yonetim_kurulu_kaydet');
		$yonetimKuruluArr = JRequest::getVar('yonetimKuruluCheckbox');
		$message	 = $model->uyeleriSil($yonetimKuruluArr, &$messageType);
		$this->setRedirect('index.php?option=com_yonetim_kurulu', $message, $messageType);
	}
 
}
?>