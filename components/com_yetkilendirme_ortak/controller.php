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
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');
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

class Yetkilendirme_OrtakController extends JController {
	
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
	
	function protokolKaydet()
	{
		$protokolID = JRequest::getVar('protokolID');
		$seciliKurulusIDleri = $_GET["seciliKurulusIDleri"];
		$seciliKurulusRolleri = $_GET["seciliKurulusRolleri"];
		$sektorler = JRequest::getVar('yetkilendirmeSektorleriMultipleSelect');
		$yetkilendirmeSuresi = JRequest::getVar('yetkilendirmeSuresiTextbox');
		$yetkilendirme_turu = JRequest::getVar('kurulusTuruRadioButtons');
		
		if(strlen($protokolID)==0) // ADD
		{
			$protokolID = $this->protokolKaydet_YeniProtokolEkle();
			// Eğer buraya geliyorsa hata çıkıp redirect etmemiş demektir, kuruluşları ekle 
			$message = $this->protokolKaydet_ProtokoleDahilKurulusEkle($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			$message = $this->yetkilendirmeKaydet_SektorleriIliskilendir($protokolID, $sektorler);
			
			if($message)
				$message="Başarıyla eklendi";
			
			$this->setRedirect('index.php?option=com_yetkilendirme_ortak&layout=yeni&protokolID='.$protokolID, $message);
		}
		else // EDIT
		{
			$db  = &JFactory::getOracleDBO();
			$protokolAdi = JRequest::getVar('protokolAdiTextbox');
			$yetkiBaslangici = JRequest::getVar('yetkiBaslangiciDatePicker');
			$yetkiBitisi = JRequest::getVar('yetkiBitisiDatePicker');
			$kuruluslar = JRequest::getVar('kurulusCheckbox');
			$protokolID = JRequest::getVar('protokolID');
			
			$ilgili_protokol_id = JRequest::getVar('ilgiliProtokolIDsiTextbox');
			$protokolMu = JRequest::getVar('protokolMuRadioButtons');
			
			$file_path = JRequest::getVar('path_protokolDosya_0_1');
			
			for($i=0; $i<count($kuruluslar); $i++)
			{
				$kurulusTurleri[$i] =   JRequest::getVar('kurulusTuruRadioButtons-'.$kuruluslar[$i]);
			}
			
			$message = $this->yetkilendirmeKaydet_SektorleriIliskilendir($protokolID, $sektorler);
			
			$message = $this->protokolKaydet_VarolanProtokoluDuzenle($protokolID, $protokolAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar,$yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id, $protokolMu[0]);
			$message = " ".$this->protokolKaydet_VarolanProtokolunKuruluslariniDuzenle($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri);
			if($message==TRUE)
				$message = "Başarıyla kaydedildi";
			
			$this->setRedirect('index.php?option=com_yetkilendirme_ortak&layout=yeni&protokolID='.$protokolID, $message);
		}
	}
	
	function protokolKaydet_YeniProtokolEkle()
	{
		$db  = &JFactory::getOracleDBO();
		
		$post 		 = JRequest::get( 'post' );
		$protokolAdi = JRequest::getVar('protokolAdiTextbox');
		$yetkiBaslangici = JRequest::getVar('yetkiBaslangiciDatePicker');
		$yetkiBitisi = JRequest::getVar('yetkiBitisiDatePicker');
		$yetkilendirmeSuresi = JRequest::getVar('yetkilendirmeSuresiTextbox');
		$filePath = JRequest::getVar('path_protokolDosya_0_1');
		$yetkilendirme_turu = JRequest::getVar('kurulusTuruRadioButtons');
		
		$ilgili_protokol_id = JRequest::getVar('ilgiliProtokolIDsiTextbox');
			
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		
		$protokolID = $db->getNextVal (YETKI_SEQ);
		$message	 = $model->protokolEkle($protokolID, $protokolAdi, $yetkiBaslangici, $yetkiBitisi, $yetkilendirmeSuresi,$yetkilendirme_turu, $filePath, $ilgili_protokol_id);
		
		if($message)//SUCCESS, MUST EDIT
			$this->setRedirect('index.php?option=com_yetkilendirme_ortak&layout=yeni&protokolID='.$protokolID, "Başarıyla Eklendi");
		else
			$this->setRedirect('index.php?option=com_yetkilendirme_ortak&layout=yeni', $message);
		
		return $protokolID;	
	}
	
	function protokolKaydet_ProtokoleDahilKurulusEkle($protokolID, $seciliKurulusIDleri, $seciliKurulusRolleri)
	{
		
		
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$success = TRUE;
		if($protokolID!=-1)
		{
			for($i=0; $i<count(seciliKurulusIDleri); $i++)
				$success = $success and (boolean)$model->ProtokolKurulusuEkle($protokolID, $seciliKurulusIDleri[$i], $seciliKurulusRolleri[$i]);
		}
		$message="";
		if($success == FALSE)
			$this->setRedirect('index.php?option=com_yetkilendirme_ortak&layout=yeni', $message);

		
		return $success;
	}
	function protokolKaydet_VarolanProtokoluDuzenle($protokolID, $protokolAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar,$yetkilendirmeSuresi, $yetkilendirme_turu, $file_path,  $ilgili_protokol_id, $protokolMu)
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$message	 = $model->protokolBilgileriDuzenle($protokolID, $protokolAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar,$yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id, $protokolMu);
			
		return $message;
	}
	function protokolKaydet_VarolanProtokolunKuruluslariniDuzenle($protokolID,$kuruluslar, $kurulusTurleri)
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$message	 = $model->protokolunKuruluslariniDuzenle($protokolID, $kuruluslar, $kurulusTurleri);
			
		return $message;
	}
	function yetkilendirmeKaydet_SektorleriIliskilendir($protokolID, $sektorler)
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$message	 = $model->yetkilendirmeyleSektorleriIliskilendir($protokolID, $sektorler);
			
		return $message;
	}
	function etkisizlestir()
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$protokolArr = JRequest::getVar('protokollerCheckbox');
		$message	 = $model->protokolleriEtkisizlestir($protokolArr);		
		$this->setRedirect('index.php?option=com_yetkilendirme_ortak', $message);
	}

	function etkinlestir()
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$protokolArr = JRequest::getVar('protokollerCheckbox');
		$message	 = $model->protokolleriEtkinlestir($protokolArr);
		$this->setRedirect('index.php?option=com_yetkilendirme_ortak', $message);
	}
	
	function sil()
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$protokolArr = JRequest::getVar('protokollerCheckbox');
		$message	 = $model->protokolleriSil($protokolArr);
		$this->setRedirect('index.php?option=com_yetkilendirme_ortak', $message );
	}
	
	function duzenle()
	{
		$model 		 = $this->getModel('yetkilendirme_ortak_kaydet');
		$protokolArr = JRequest::getVar('protokollerCheckbox');
		$message	 = $model->protokolleriDuzenle($protokolArr[0]);
		$this->setRedirect('index.php?option=com_yetkilendirme_ortak', $message);
	}
	
	function indir (){
		$protokolID = JRequest::getVar('protokolID');
		$model = $this->getModel('yetkilendirme_ortak');
		$model->pdfGoster ($protokolID);
	}
	
	//AJAX
	function ajaxSaveRow (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxSaveRow ();
	}
	function ajaxEditRow (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxEditRow ();
	}
	function ajaxDeleteRow (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxDeleteRow ();
	}

	function ajaxSaveRowMS (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxSaveRowMS ();
	}
	function ajaxEditRowMS (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxEditRowMS ();
	}
	function ajaxDeleteRowMS (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxDeleteRowMS ();
	}

	function ajaxFetchExistingYeterlilik (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		if($_GET['revizyonMu']==1)
			$revizyonMu = 1;
		else 
			$revizyonMu=0;
			
		$model->ajaxFetchExistingYeterlilik($revizyonMu);
	}
	function ajaxAddFromVarolanYeterlilikler (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxAddFromVarolanYeterlilikler ();
		$model->ajaxFetchExistingYeterlilik();
	}
	function ajaxFetchExistingStandart (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxFetchExistingStandart();
	}
	function ajaxAddFromVarolanStandartlar (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxAddFromVarolanStandartlar ();
		$model->ajaxFetchExistingStandart();
	}

	function ajaxFilterYetkilendirmelerYet (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$kurulusAdi = JRequest::getVar('detayliArama_kurulusAdiTextbox');
		$yeterlilikAdi = JRequest::getVar('detayliArama_ekliYeterlilikTextbox');
		$yeterlilikSektorID = JRequest::getVar('detayliArama_ekliYeterlilikSektorSelect');
		$model->ajaxFilterYetkilendirmeler($kurulusAdi, $yeterlilikAdi, $yeterlilikSektorID );
	}
	function ajaxFilterYetkilendirmelerMS (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$kurulusAdi = JRequest::getVar('detayliArama_kurulusAdiTextbox');
		$standartAdi = JRequest::getVar('detayliArama_ekliStandartTextbox');
		$yeterlilikSektorID = JRequest::getVar('detayliArama_ekliYeterlilikSektorSelect');
		$model->ajaxFilterYetkilendirmelerMS($kurulusAdi, $standartAdi, $yeterlilikSektorID );
	}
	function ajaxUzatmaKaydet (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxUzatmaKaydet ();
	}
	
	function ajaxUzatmaGuncelle (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxUzatmaGuncelle ();
	}
	
	function ajaxUzatmaSil (){
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$model->ajaxUzatmaSil ();
	}
	function ajaxRevizyonOlusturYet() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak');
		$datas['YETERLILIK_ID'] =  $post["yeterlilik_id"];
		$datas['SEVIYE_ID'] =  $post["meslekseviyesi"];
		$datas['REVIZYON'] =  $post["revizyon"];
		$datas['SEKTOR_ID'] =  $post["mesleksektoru"];
		$datas['YETERLILIK_TESLIM_TARIHI'] =  $post["protokolteslim"];
		$datas['PROTOKOL_ID'] =  $post["protokolid"];
		$result = $model->revizyonOlusturYet ($datas);
		echo json_encode($result);
	}

	function ajaxRevizyonOlusturMS() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ms');
		$datas['STANDART_ID'] =  $post["standart_id"];
		$datas['SEVIYE_ID'] =  $post["meslekseviyesi"];
		$datas['REVIZYON'] =  $post["revizyon"];
		$datas['SEKTOR_ID'] =  $post["mesleksektoru"];
		$datas['STANDART_TESLIM_TARIHI'] =  $post["protokolteslim"];
		$datas['PROTOKOL_ID'] =  $post["protokolid"];
		$result = $model->revizyonOlusturMS ($datas);
		echo json_encode($result);
	}

	function ajaxYeterlilikGetirByStatus() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak');
		$result = $model->YeterlilikGetirByStatus ($_GET['yetstatus']);
		echo json_encode($result);
	}
	function ajaxYeterlilikGetirById() {
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak');
		$result = $model->YeterlilikGetirById ($_GET['yetid']);
		echo json_encode($result);
	}
	function updateYeterlilikStatus(){
		$post  = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak');
		$result = $model->updateYeterlilikStatus($post);
		echo json_encode($result);
	}

	function ajaxStandartGetirByStatusMS(){
		$post 		 = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak');
		$result = $model->StandartGetirByStatusMS ($_GET['yetstatus']);
		echo json_encode($result);
	}

	function kurulusKaydetAjax(){
		$post  = JRequest::get( 'post' );
		$model = &$this->getModel('yetkilendirme_ortak_ajax');
		$result = $model->kurulusKaydetAjax($post);
		echo json_encode($result);
	}


}

?>