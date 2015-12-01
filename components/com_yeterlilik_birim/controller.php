<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/components/com_yeterlilik_birim/assets/ogrenme_cikti.js' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_yeterlilik_birim/assets/yeterlilik_birim.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );

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
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.20.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

require_once('libraries/form/functions.php');

/**
 * Yeterlilik_Birim Component Controller
 */
class Yeterlilik_BirimController extends JController {
	
    function display() {

        parent::display();
    }
    
    function birimKaydet (){
    	$birimID = JRequest::getVar('birimID');

    	if(!isset($birimID) || empty($birimID)) // YENI EKLE
    	{
    		$birimID = $this->yeniBirimEkle();
    		
    		if($birimID != null){
    			$message= JText::_("BIRIM_EKLEME_SUCCESS_MESSAGE");
    		}else{
    			$message= JText::_("BIRIM_EKLEME_ERROR_MESSAGE");
    		}
    		
    		$this->setRedirect('index.php?option=com_yeterlilik_birim&layout=birim&birimID='.$birimID, $message);
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
    	
    	
    		for($i=0; $i<count($kuruluslar); $i++)
    		{
    		$kurulusTurleri[$i] =   JRequest::getVar('kurulusTuruRadioButtons-'.$kuruluslar[$i]);
    		}
    			
    		$message = $this->yetkilendirmeKaydet_VarolanYetkilendirmeyiDuzenle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar, $file_path, $ilgili_protokol_id);
    		$message = " ".$this->yetkilendirmeKaydet_VarolanYetkilendirmeKuruluslariniDuzenle($yetkilendirmeID, $seciliKurulusIDleri, $seciliKurulusRolleri);
    		if($message)
    		$message = "Başarıyla kaydedildi";
    				
    				$this->setRedirect('index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$yetkilendirmeID, $message);
    	}
    }
    
    function yeniBirimEkle(){
    	$db  = &JFactory::getOracleDBO();
    	$model = &$this->getModel('yeterlilik_birim');
    	
    	$post = JRequest::get( 'post' );
    	
    	$birimAdi = JRequest::getVar('birim_ad');
    	$referansKodu = JRequest::getVar('referans_kodu');
    	$seviye = JRequest::getVar('seviye');
    	$krediDegeri = JRequest::getVar('kredi_degeri');	
    	$yayinTarihi = JRequest::getVar('yayin_tarihi');
    	$revizyonNo = JRequest::getVar('revizyon_no');
    	$revizyonTarihi = JRequest::getVar('revizyon_tarihi');
	
    	$birimID = $db->getNextVal (BIRIM_SEQ);
    	$result	 = $model->birimEkle($birimID, $birimAdi, $referansKodu, $seviye, $krediDegeri, $yayinTarihi, $revizyonNo, $revizyonTarihi);
    	
    	if(!$result)//SUCCESS, MUST EDIT
    		$birimID = null;  	
    	
    	return $birimID;
    }
    
    //BIRIM AJAX METHODS
	function ajaxFetchExistingStandart (){
		$model = $this->getModel('yeterlilik_birim_ajax');
		$model->ajaxFetchExistingStandart();
	}
	
	function ajaxAddFromVarolanStandartlar (){
		$model = &$this->getModel('yeterlilik_birim_ajax');
		$model->ajaxAddFromVarolanStandartlar ();
		$model->ajaxFetchExistingStandart();
	}
	
	function ajaxKaynakKaydet (){
		$model = &$this->getModel('yeterlilik_birim_ajax');
		$model->ajaxKaynakKaydet ();
	}
	
	function ajaxKaynakGuncelle (){
		$model = &$this->getModel('yeterlilik_birim_ajax');
		$model->ajaxKaynakGuncelle ();
	}
	
	function ajaxKaynakSil (){
		$model = &$this->getModel('yeterlilik_birim_ajax');
		$model->ajaxKaynakSil ();
	}
	//OGRENME CIKTI AJAX METHODS
	function ajaxOgrenmeCiktisiSirasiGuncelle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$result = $model->ajaxOgrenmeCiktisiSirasiGuncelle();

		if($result){
			ajax_success_response(JText::_("OGREME_CIKTI_SUCCESS_MESSAGE"));
		}else{
			ajax_error_response(JText::_("OGREME_CIKTI_ERROR_MESSAGE"));
		}
	}
	
	function ajaxBasarimOlcutuSirasiGuncelle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$result = $model->ajaxBasarimOlcutuSirasiGuncelle();
	
		if($result){
			ajax_success_response(JText::_("BASARIM_OLCUT_SUCCESS_MESSAGE"));
		}else{
			ajax_error_response(JText::_("BASARIM_OLCUT_ERROR_MESSAGE"));
		}
	}
	
	//OGRENME CIKTISI
	function ajaxOgrenmeCiktisiEkle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxOgrenmeCiktisiEkle();
	}
	
	function ajaxOgrenmeCiktisiGuncelle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxOgrenmeCiktisiGuncelle();
	}
	
	function ajaxOgrenmeCiktisiSil (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxOgrenmeCiktisiSil();
	}

	//BASARIM OLCUTU
	function ajaxBasarimOlcutuEkle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBasarimOlcutuEkle();
	}
	
	function ajaxBasarimOlcutuGuncelle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBasarimOlcutuGuncelle();
	}
	
	function ajaxBasarimOlcutuSil (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBasarimOlcutuSil();
	}

	//BAGLAM
	function ajaxBaglamEkle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBaglamEkle();
	}
	
	function ajaxBaglamGuncelle (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBaglamGuncelle();
	}

	function ajaxBaglamSil (){
		$model = $this->getModel('ogrenme_cikti_ajax');
		$model->ajaxBaglamSil();
	}
}
?>