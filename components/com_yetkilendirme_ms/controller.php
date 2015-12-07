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
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');
$document->addStyleSheet( SITE_URL.'components/com_yetkilendirme_ms/assets/yetkilendirme_ms.css' );
$document->addScript( SITE_URL.'components/com_yetkilendirme_ms/assets/yetkilendirme_ms.js' );

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

class Yetkilendirme_MsController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		if(!$isSektorSorumlusu)
			$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
		
		parent::display();
	}
	
	function yetkilendirmeKaydet()
	{
		$yetkilendirmeID = JRequest::getVar('yetkilendirmeID');
		$seciliKurulusIDleri = $_GET["seciliKurulusIDleri"];
		$seciliKurulusRolleri = $_GET["seciliKurulusRolleri"];
		$sektorler = JRequest::getVar('yetkilendirmeSektorleriMultipleSelect');
		$yetkilendirmeSuresi = JRequest::getVar('yetkilendirmeSuresiTextbox');
		$yetkilendirme_turu = JRequest::getVar('kurulusTuruRadioButtons');
		
		$message = $this->yetkilendirmeKaydet_SektorleriIliskilendir($yetkilendirmeID, $sektorler);
		if(strlen($yetkilendirmeID)==0) // ADD
		{
			$yetkilendirmeID = $this->yetkilendirmeKaydet_YeniYetkilendirmeEkle();
			// Eğer buraya geliyorsa hata çıkıp redirect etmemiş demektir, kuruluşları ekle 
			$message = $this->yetkilendirmeKaydet_YetkilendirmeyeDahilKurulusEkle($yetkilendirmeID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			if($message)
				$message="Başarıyla eklendi";
			$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$yetkilendirmeID, $message);
		}
		else // EDIT
		{
			$db  = &JFactory::getOracleDBO();
			$yetkilendirmeAdi = JRequest::getVar('yetkilendirmeAdiTextbox');
			$yetkiBaslangici = JRequest::getVar('yetkiBaslangiciDatePicker');
			$yetkiBitisi = JRequest::getVar('yetkiBitisiDatePicker');
			$kuruluslar = JRequest::getVar('kurulusCheckbox');
			$yetkilendirmeID = JRequest::getVar('yetkilendirmeID');
			$file_path = JRequest::getVar('path_yetkilendirmeDosya_0_1');
			
			$ilgili_protokol_id = JRequest::getVar('ilgiliProtokolIDsiTextbox');
			$protokolMu = JRequest::getVar('protokolMuRadioButtons'); 
				
			for($i=0; $i<count($kuruluslar); $i++)
			{
				$kurulusTurleri[$i] =   JRequest::getVar('kurulusTuruRadioButtons-'.$kuruluslar[$i]);
			}
			
			$message = $this->yetkilendirmeKaydet_VarolanYetkilendirmeyiDuzenle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar, $yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id, $protokolMu[0]);
			$message = " ".$this->yetkilendirmeKaydet_VarolanYetkilendirmeKuruluslariniDuzenle($yetkilendirmeID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			if($message)
				$message = "Başarıyla kaydedildi";
			
			$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$yetkilendirmeID, $message);
		}
	}
	
	function yetkilendirmeKaydet_YeniYetkilendirmeEkle()
	{
		$db  = &JFactory::getOracleDBO();
		
		$post 		 = JRequest::get( 'post' );
		$yetkilendirmeAdi = JRequest::getVar('yetkilendirmeAdiTextbox');
		$yetkiBaslangici = JRequest::getVar('yetkiBaslangiciDatePicker');
		$yetkiBitisi = JRequest::getVar('yetkiBitisiDatePicker');
		$yetkilendirmeTuru = JRequest::getVar('kurulusTuruRadioButtons');
		$yetkilendirmeSuresi = JRequest::getVar('yetkilendirmeSuresiTextbox');
		$filePath = JRequest::getVar('path_yetkilendirmeDosya_0_1');
		
		$ilgili_protokol_id = JRequest::getVar('ilgiliProtokolIDsiTextbox');
			
		$model 		 = $this->getModel('yetkilendirme_kaydet');

		$yetkilendirmeID = $db->getNextVal (YETKI_SEQ);
		$result	 = $model->yetkilendirmeEkle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi,$yetkilendirmeSuresi, $yetkilendirmeTuru, $filePath, $ilgili_protokol_id);
		
		if($result)//SUCCESS, MUST EDIT
			$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$yetkilendirmeID, "Başarıyla Eklendi");
		else
			$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni', "Eklenirken Hata Oluştu");

		
		return $yetkilendirmeID;
		
	}
	function yetkilendirmeKaydet_yetkilendirmeyeDahilKurulusEkle($yetkilendirmeID, $seciliKurulusIDleri, $seciliKurulusRolleri)
	{
		
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$success = TRUE;
		if($yetkilendirmeID!=-1)
		{
			for($i=0; $i<count($seciliKurulusIDleri); $i++)
				$success = $success and (boolean)$model->yetkilendirmeKurulusuEkle($yetkilendirmeID, $seciliKurulusIDleri[$i], $seciliKurulusRolleri[$i]);
		}
		
		if($success)
			$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni', $message);
		
		
		return $success;
	}
	function yetkilendirmeKaydet_VarolanYetkilendirmeyiDuzenle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar, $yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id, $protokolMu)
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$message	 = $model->yetkilendirmeBilgileriDuzenle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar, $yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id,$protokolMu);
			
		return $message;
	}
	function yetkilendirmeKaydet_VarolanYetkilendirmeKuruluslariniDuzenle($yetkilendirmeID,$kuruluslar,$kurulusTurleri)
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$message	 = $model->yetkilendirmeKuruluslariniDuzenle($yetkilendirmeID, $kuruluslar, $kurulusTurleri);
			
		return $message;
	}
	function yetkilendirmeKaydet_SektorleriIliskilendir($protokolID, $sektorler)
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$message	 = $model->yetkilendirmeyleSektorleriIliskilendir($protokolID, $sektorler);
			
		return $message;
	}
	function etkisizlestir()
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
		$message	 = $model->yetkilendirmeleriEtkisizlestir($yetkilendirmeArr);		
		$this->setRedirect('index.php?option=com_yetkilendirme_ms', $message);
	}

	function etkinlestir()
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
		$message	 = $model->yetkilendirmeleriEtkinlestir($yetkilendirmeArr);
		$this->setRedirect('index.php?option=com_yetkilendirme_ms', $message);
	}
	
	function sil()
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
		$message	 = $model->yetkilendirmeleriSil($yetkilendirmeArr, @$messageType);
		$this->setRedirect('index.php?option=com_yetkilendirme_ms', $message, $messageType);
	}
	
	function duzenle()
	{
		$model 		 = $this->getModel('yetkilendirme_kaydet');
		$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
		$message	 = $model->yetkilendirmeleriDuzenle($yetkilendirmeArr[0]);
		$this->setRedirect('index.php?option=com_yetkilendirme_ms', $message);
	}
	
	function indir (){
		$yetkilendirmeID = JRequest::getVar('yetkilendirmeID');
		$model = $this->getModel('yetkilendirme_ms');
		$model->pdfGoster ($yetkilendirmeID);
	}
	
	//AJAX
	function ajaxSaveRow (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxSaveRow ();
	}
	function ajaxEditRow (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxEditRow ();
	}
	function ajaxDeleteRow (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxDeleteRow ();
	}
	function ajaxFetchExistingStandart (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxFetchExistingStandart();
	}
	function ajaxAddFromVarolanStandartlar (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxAddFromVarolanStandartlar ();
		$model->ajaxFetchExistingStandart();
	}
	function ajaxFilterYetkilendirmeler (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$kurulusAdi = JRequest::getVar('detayliArama_kurulusAdiTextbox');
		$yeterlilikAdi = JRequest::getVar('detayliArama_ekliYeterlilikTextbox');
		$yeterlilikSektorID = JRequest::getVar('detayliArama_ekliYeterlilikSektorSelect');
		$model->ajaxFilterYetkilendirmeler($kurulusAdi, $yeterlilikAdi, $yeterlilikSektorID );
	}
	function ajaxUzatmaKaydet (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxUzatmaKaydet ();
	}
	
	function ajaxUzatmaGuncelle (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxUzatmaGuncelle ();
	}
	
	function ajaxUzatmaSil (){
		$model = &$this->getModel('yetkilendirme_ajax');
		$model->ajaxUzatmaSil ();
	}
	
	function ajaxStandartGetirByStatus(){
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ms');
		$result = $model->StandartGetirByStatus ($_GET['yetstatus']);
		echo json_encode($result);
	}
	
	function ajaxStandartGetirById() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ms');
		$result = $model->StandartGetirById ($_GET['standartid']);
		echo json_encode($result);
	}
	
	function ajaxRevizyonOlustur() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ms');
		$datas['STANDART_ID'] =  $post["standart_id"];
		$datas['SEVIYE_ID'] =  $post["meslekseviyesi"];
		$datas['REVIZYON'] =  $post["revizyon"];
		$datas['SEKTOR_ID'] =  $post["mesleksektoru"];
		$datas['STANDART_TESLIM_TARIHI'] =  $post["protokolteslim"];
		$datas['PROTOKOL_ID'] =  $post["protokolid"];
		$result = $model->revizyonOlustur ($datas);
		echo json_encode($result);
	}

	function updateStandartStatus(){
		$post  = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ms');
		$result = $model->updateStandartStatus($post);
		echo json_encode($result);
	}

	function kurulusKaydetAjax(){
		$post  = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ajax');
		$result = $model->kurulusKaydetAjax($post);
		echo json_encode($result);
	}

}

?>