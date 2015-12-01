<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addStyleSheet( SITE_URL.'components/com_protokol_ms/assets/protokol_ms.css' );
$document->addScript( SITE_URL.'components/com_protokol_ms/assets/protokol_ms.js' );

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

class Protokol_YetController extends JController {
	
	/*OK*/function display() {
		
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
	
	/*OK*/function protokolKaydet()
	{
		$protokolID = JRequest::getVar('protokolID');
		$seciliKurulusIDleri = $_GET["seciliKurulusIDleri"];
		$seciliKurulusRolleri = $_GET["seciliKurulusRolleri"];
		$sektorler = JRequest::getVar('protokolSektorleriMultipleSelect');
		$suresi = JRequest::getVar('protokolSuresiTextbox');
		
		if(strlen($protokolID)==0) // YENI EKLE
		{
			$protokolID = $this->yeniProtokolEkle();
			// Eğer buraya geliyorsa hata çıkıp redirect etmemiş demektir, kuruluşları ekle
			$message = $this->protokoleKurulusEkle($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			$message .= $this->protokolleSektorleriIliskilendir($protokolID, $sektorler);
			if($message)
				$message=JText::_("SUCCESS_MESSAGE");
				
			$this->setRedirect('index.php?option=com_protokol_yet&layout=yeni&protokolID='.$protokolID, $message);
		}
		else // DUZENLE
		{
			$db  = &JFactory::getOracleDBO();
			$protokolAdi = JRequest::getVar('protokolAdiTextbox');
			$imzaTarihi = JRequest::getVar('imzaTarihiDatePicker');
			$yetSayisi = JRequest::getVar('yetSayisiTextbox');
			$kuruluslar = JRequest::getVar('kurulusCheckbox');
			$file_path = JRequest::getVar('path_protokolDosya_0_1');
				
			for($i=0; $i<count($kuruluslar); $i++)
			{
			$kurulusTurleri[$i] =   JRequest::getVar('kurulusTuruRadioButtons-'.$kuruluslar[$i]);
			}
				
			$message = $this->protokolDuzenle($protokolID, $protokolAdi, $imzaTarihi, $yetSayisi,$suresi, $file_path);
			$message = " ".$this->protokolKuruluslariniDuzenle($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			$message .= $this->protokolleSektorleriIliskilendir($protokolID, $sektorler);
			if($message)
			$message = JText::_("SUCCESS_MESSAGE");
				
			$this->setRedirect('index.php?option=com_protokol_yet&layout=yeni&protokolID='.$protokolID, $message);
		}
	}
	
	/*OK*/function yeniProtokolEkle()
	{
		global $mainframe;
		$db  = &JFactory::getOracleDBO();
		
		$post 		 = JRequest::get( 'post' );
		$protokolAdi = JRequest::getVar('protokolAdiTextbox');
		$imzaTarihi  = JRequest::getVar('imzaTarihiDatePicker');
		$sayisi = JRequest::getVar('yetSayisiTextbox');
		$filePath = JRequest::getVar('path_protokolDosya_0_1');
				
		$model 		 = $this->getModel('protokol_kaydet');
		$suresi = JRequest::getVar('protokolSuresiTextbox');
				
				$protokolID = $db->getNextVal (PROTOKOL_SEQ);
		$result	 = $model->protokolEkle($protokolID, $protokolAdi, $imzaTarihi, $sayisi,$suresi, $filePath);
		
		if($result == false){
		//ERROR
		$mainframe->redirect('index.php?option=com_protokol_yet&layout=yeni', JText::_("PROTOKOL_EKLE_ERROR_MESSAGE"), 'error');
				}
		
		return $protokolID;
	
	}
	/*OK*/function protokoleKurulusEkle ($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri)
	{
		
		$model 		 = $this->getModel('protokol_kaydet');
		$success = TRUE;
		if($protokolID !=-1)
		{
			for($i=0; $i<count($seciliKurulusIDleri); $i++)
				$success = $success and (boolean)$model->protokolKurulusuEkle($protokolID, $seciliKurulusIDleri[$i], $seciliKurulusRolleri[$i]);
		}
		
			return $success;
	}
	function protokolleSektorleriIliskilendir($protokolID, $sektorler)
	{
		$model 		 = $this->getModel('protokol_kaydet');
		$message	 = $model->protokolleSektorleriIliskilendir($protokolID, $sektorler);
		
		return $message;
	}
	
		/*OK*/function protokolDuzenle($protokolID, $protokolAdi, $imzaTarihi, $yetSayisi,$suresi, $file_path)
		{
			$model 		 = $this->getModel('protokol_kaydet');
			$message	 = $model->protokolBilgileriDuzenle($protokolID, $protokolAdi, $imzaTarihi, $yetSayisi,$suresi, $file_path);
	
			return $message;
		}
	
		/*OK*/function protokolKuruluslariniDuzenle($protokolID, $kuruluslar, $kurulusTurleri)
		{
			$model 		 = $this->getModel('protokol_kaydet');
			$message	 = $model->protokolKuruluslariniDuzenle($protokolID, $kuruluslar, $kurulusTurleri);
	
			return $message;
		}
	
		/*OK*/function etkisizlestir()
		{
			$model 		 = $this->getModel('protokol_kaydet');
			$protokolArr = JRequest::getVar('protokollerCheckbox');
			$message	 = $model->protokolleriEtkisizlestir($protokolArr);
			$this->setRedirect('index.php?option=com_protokol_yet', $message);
		}
	
		/*OK*/function etkinlestir()
		{
			$model 		 = $this->getModel('protokol_kaydet');
			$protokolArr = JRequest::getVar('protokollerCheckbox');
			$message	 = $model->protokolleriEtkinlestir($protokolArr);
			$this->setRedirect('index.php?option=com_protokol_yet', $message);
		}
	
		/*OK*/function sil()
		{
			$model 		 = $this->getModel('protokol_kaydet');
			$protokolArr = JRequest::getVar('protokollerCheckbox');
			$message	 = $model->protokolleriSil($protokolArr, &$messageType);
			$this->setRedirect('index.php?option=com_protokol_yet', $message, $messageType);
		}
	
		/*OK*/function indir (){
			$protokolID = JRequest::getVar('protokolID');
			$model = $this->getModel('protokol_yet');
			$model->pdfGoster ($protokolID);
		}
		
		//AJAX
		function ajaxUzatmaKaydet (){
			$model = &$this->getModel('protokol_ajax');
			$model->ajaxUzatmaKaydet ();
		}
		
		function ajaxUzatmaGuncelle (){
			$model = &$this->getModel('protokol_ajax');
			$model->ajaxUzatmaGuncelle ();
		}
		
		function ajaxUzatmaSil (){
			$model = &$this->getModel('protokol_ajax');
			$model->ajaxUzatmaSil ();
		}
	
}

?>