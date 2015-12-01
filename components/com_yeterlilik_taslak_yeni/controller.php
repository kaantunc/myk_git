<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
//patchSatirEkle ve rowAdded icin
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );
require_once("libraries/form/functions.php");
require_once('libraries/form/captcha.php');

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

$document->addScript (SITE_URL.'/templates/elegance/js/jquery.collapsible.js');
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');


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
// $document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/editable-table.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/DT_bootstrap.js');
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );
//jQueryCookie
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/development-bundle/external/jquery.cookie.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');


//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');
// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

/**
 * Yeterlilik_Taslak Component Controller
 */
class Yeterlilik_TaslakController extends JController {
	
	function revizyonKaydet(){
		$model 		 	= $this->getModel('taslak_revizyon');
		$post 		 	= JRequest::get( 'post' );
		$yeterlilik_id 	= JRequest::getVar('yeterlilik_id');
		$redirectLink	= 'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&yeterlilik_id='.$yeterlilik_id.'&revize_no='.$_POST[revizyonNo];

		$message	 	= $model->revizyonKaydet ($post, $yeterlilik_id);
				
		$this->setRedirect($redirectLink, $message);
	}
	
	function gorusCevapla(){
						
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
		$post = JRequest::get( 'post' );
		$yeterlilikId = JRequest::getVar( 'yeterlilikId' );
		$message = $model->gorusCevapla($db, $post);
		        
		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&view=gorus_listele&yeterlilikId='. $yeterlilikId , $message);
		
	}
	
	function gorusKaydet(){
		
		captcha::check("index.php?option=com_yeterlilik_taslak_yeni&view=gorus_bildir&standartId=".JRequest::getVar("standartId"));
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
		$post = JRequest::get( 'post' );
		$message = $model->gorusKaydet($db, $post);
		        
		$this->setRedirect('index.php' , $message);
		
	}
	function ajaxAdaGoreBagimsizBirimArat()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$post = JRequest::get( 'post' );
		$searchText = $_REQUEST['BagimsizBirimEkle_NameTextBox'];
		$message = $model->ajaxAdaGoreBagimsizBirimArat($searchText);
	}
	
	function ajaxKontrolListeliEk2DataGetir()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$element_id = $_GET['element_id'];
		$message = $model->ajaxKontrolListeliEk2DataGetir($element_id);
		
	}
	
	function ajaxKontrolListeliEk2DataKaydet()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$message = $model->ajaxKontrolListeliEk2DataKaydet();
	}
	function ajaxSektoreGoreSeviyeGetir()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$message = $model->ajaxSektoreGoreSeviyeGetir();
	}
	function ajaxSeviyeVeSektoreGoreYeterlilikGetir()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$message = $model->ajaxSeviyeVeSektoreGoreYeterlilikGetir();
	}
	function ajaxYeterliliginBirimleriniGetir()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$message = $model->ajaxYeterliliginBirimleriniGetir();
	}
	function ajaxSeciliBirimleriEkle()
	{
		$model = $this->getModel('yeterlilik_taslak');
		$post = JRequest::get( 'post' );
		$seciliBirimler = $_REQUEST['BirimlerCheckbox'];
		$message = $model->ajaxSeciliBirimleriEkle($seciliBirimler);
	}
	function ajaxSaveBirimDetayi()
	{

		$model = $this->getModel('yeterlilik_taslak');
		$birimID = $_REQUEST['birimID'];
		if($_REQUEST['yenimi'] == "1"){
			$message = $model->ajaxSaveBirimDetayi($birimID);
		}else{
			$component_modelpath = JPATH_ROOT.DS.'components'.DS.'com_yeterlilik_taslak'.DS.'models';
			JModel::addIncludePath( $component_modelpath);
			$model_old =& JModel::getInstance('yeterlilik_taslak_old','Yeterlilik_TaslakModel');
		
			$data['BirimId'] = $_REQUEST['birimID'];
			for($i = 1 ; $i < (count($_REQUEST['buBiriminTeorikSinavlari'])+1) ; $i++){
				$data['TeorikSinavTuru'][$i]     = "T".($i+1);
				$data['TeorikSinavAdi'][$i]      = $_REQUEST['buBiriminTeorikSinavlarininAdlari'][$i];
				$data['TeorikSinavAciklama'][$i] = $_REQUEST['buBiriminTeorikSinavlari'][$i];
				$data['TeorikSinavlariGecerlilikSuresi'][$i] = $_REQUEST['buBiriminTeorikSinavlariGecerlilikSuresi'][$i];
			}

			for($i = 1 ; $i < (count($_REQUEST['buBiriminPerformansSinavlari'])+1) ; $i++){
				$data['PerformansSinavTuru'][$i]     = "P".($i+1);
				$data['PerformansSinavAdi'][$i]      = $_REQUEST['buBiriminPerformansSinavlarininAdlari'][$i];
				$data['PerformansSinavAciklama'][$i] = $_REQUEST['buBiriminPerformansSinavlari'][$i];
				$data['PerformansSinavlariGecerlilikSuresi'][$i] = $_REQUEST['buBiriminPerformansSinavlariGecerlilikSuresi'][$i];
			}
 		
			$return = $model_old->turKaydet($data);
			if($return ==  true){
				$response['success'] = true;
				$response['data'] = "Birim başarıyla kaydedildi";
				echo json_encode($response);
			}else{
				$response['success'] = false;
				$response['data'] = "Birim kaydı sırasında teknik bir problem oluştu";
				echo json_encode($response);
			}
		}
	}
	
	function taslakKaydet(){
		$layout		 = JRequest::getVar("layout");
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		$redirectLink= 'index.php?option=com_yeterlilik_taslak_yeni&layout='.$layout.'&yeterlilik_id='.$yeterlilik_id;

		$message	 = $model->taslakKaydet ($post, $layout, $evrak_id, $yeterlilik_id);
				
		$this->setRedirect($redirectLink, $message);
	}
	
        function AlternatifSil(){
                $model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
                echo json_encode($model->DeleteAlternatif($post,$post['delete']));
        }
        
 	function sektorSorumlusunaGonder (){
		$model 		 = $this->getModel('taslak_kaydet');
		$yeterlilik_id= JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->sektorSorumlusunaGonder ($evrak_id, $yeterlilik_id);
		
		$message 	 = "Yeterlilik Formatı Sektör Sorumlusu Onayına Gönderildi"; 
		$this->setRedirect('index.php', $message);
 	}
 	
 	function yorumKaydet (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout 	 = JRequest::getVar('layout');
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->yorumKaydet_SS ($post, $evrak_id, $layout);
		
		$message 	 = "Yorum Kaydedildi"; 
		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout='.$layout.'&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
 	function yorumlariGonder (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->yorumlariGonder ($evrak_id);
		
		$message 	 = "Yorumlar Gönderildi"; 
		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=tanitim&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
	function onBasvuruOnayla (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		if(isset($post['typetaslak']) && $post['typetaslak'] == "1"){
			$model->onBasvuruOnaylaYeni ($evrak_id, $yeterlilik_id);
		}else{
			$model->onBasvuruOnayla ($evrak_id, $yeterlilik_id);
		}
		
		if(isset($post['typetaslak']) && $post['typetaslak'] == "1"){
			$message 	 = "Yeterlilik Formatı Onaylandı ve Taslak Haline Getirildi";
			$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$yeterlilik_id, $message);
		}else{
			$message 	 = "Yeterlilik Formatı Onaylandı. <br>Kuruluş tarafından başvurunun son onayının verilip, ıslak imzalı olarak MYK'ya gönderilmesini temin ediniz.";
			$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=tanitim&yeterlilik_id='.$yeterlilik_id, $message);
		}
	}
 	
 	function onBasvuruBitir (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->onBasvuruBitir ($evrak_id, $yeterlilik_id);

		$message 	 = "Yeterlilik Taslağı Sektör Sorumlusuna Gönderildi"; 
		if(isset($post['typetaslak']) && $post['typetaslak'] == "1"){
			$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$yeterlilik_id, $message);
 		}else{
			$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$yeterlilik_id, $message);
 		}
	}
	
	function basvuruKurulusaGonder (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
	
		$model->basvuruKurulusaGonder ($evrak_id, $yeterlilik_id);
	
		$message 	 = "Yeterlilik Taslağı Kuruluşa Geri Gönderildi";
		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$yeterlilik_id, $message);
	}
 	
 	function indir (){
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$revize_no = JRequest::getVar('revize_no');
 		$id = JRequest::getVar('id');
 		
 		$model = $this->getModel('taslak_revizyon');
 		$model->pdfGoster ($yeterlilik_id, $id, $revize_no);
 	}
 	
 	/**
 	 * 
 	 * Secilen pdf belgesini veritabanindan siler.
 	 */
 	
 	function sil (){
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$revize_no = JRequest::getVar('revize_no');
 		$id = JRequest::getVar('id');
 		$redirectLink = 'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&yeterlilik_id='.$yeterlilik_id.'&revize_no='.$revize_no;
 		
 		$model = $this->getModel('taslak_revizyon');
 		$message = $model->pdfSil ($yeterlilik_id, $id,$revize_no);
 		
 		$this->setRedirect($redirectLink, $message);
 	}
	
 	/**
 	 *
 	 * Secilen pdf belgesini veritabanindan siler.(Yeni)
 	 */
 	
 	function silYeni (){
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$revize_no = JRequest::getVar('revize_no');
 		$id = JRequest::getVar('id');
 		$redirectLink = 'index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$yeterlilik_id.'&revize_no='.$revize_no;
 			
 		$model = $this->getModel('taslak_revizyon');
 		$message = $model->pdfSilYeni ($yeterlilik_id, $id,$revize_no);
 			
 		$this->setRedirect($redirectLink, $message);
 	}
 	
 	function getStandart (){
		$standartTur = JRequest::getVar('standartTur');
		
		if ($standartTur != "uluslararasi")
			echo json_encode( array("result"=>"success", "data"=>FormParametrik::getMeslekStandart2 ($standartTur)));
		else 
			echo json_encode( array("result"=>"error"));
 	}
	function getYeterlilikBirim (){
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
	//	header( 'Location: http://www.google.com' ) ;
	
			echo json_encode( array("result"=>"success", "data"=>FormParametrik::getYeterlilikAltBirim ($yeterlilik_id)));
		
 	}
 	
 	function AlternatifGetir(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get('post');
 		echo json_encode($model->AlternatifGetir($post));
 	}
 	
 	function alternatifTurSil(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get('post');
 		echo json_encode($model->alternatifTurSil($post));
 	}
 	
 	function ajaxYeterlilikGetirByStatus() {
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('yetkilendirme_yet');
 		$result = $model->YeterlilikGetirByStatus ($_GET['yetstatus']);
 		echo json_encode($result);
 	}
 	function getYeterlilikSablon(){
 		$model 		 = &$this->getModel('yeterlilik_taslak'); 
 		if(isset($_GET['layout']) && isset($_GET['yetid'])){ 
 			$result = $model->getYeterlilikSablon($_GET['layout'],$_GET['yetid']);
 			echo json_encode($result);
 		}else{
 			
 		}
 	}
 	
 	function taslakKaydetYeni(){
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('taslak_kaydet');
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
 		
 		$model->taslakKaydetYeni($post,$evrak_id);
 		
 	}
 	
 	function getVersionDatas(){
 		$post 		 = JRequest::get( 'post' ); 
 		$model = &$this->getModel('taslak_listele');
 		$datas = $model->getVersionDatas($post);
 		echo json_encode($datas);
 	}
 	

 	function getYeterlilikDatas(){
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('onayli_taslak_listele');
 		$yeterlilikKodu = $post['yeterlilikkodu']; 
 		$datas = $model->getYeterlilikDatas($yeterlilikKodu);
 		echo json_encode($datas);
 	}
 	
 	function YetUcretGetir(){
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('yeterlilik_ucret');
 		$datas = $model->YetUcretGetir($post);
 		echo json_encode($datas);
 	}
 	
 	function YeterlilikUcretKaydet(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 		$return = $model->YeterlilikUcretKaydet ($post);
 		if($return['durum']){
 			$type="";
 		}else{
 			$type="error";
 		}
 		$message = $return['message'];
 		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout=yeterlilik_ucret&yetId='.$return['yetId'], $message,$type);
 	}
 	
 	function AjaxGetYetUcret(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 		
 		$return = $model->AjaxGetYetUcret($post['yetUcId']);
 		echo json_encode($return);
 	}
 	
 	function AjaxDeleteYetUcret(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 			
 		$return = $model->AjaxDeleteYetUcret($post['yetUcId']);
 		echo json_encode($return);
 	}
 	
 	function ToplamZamUygula(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 		
 		$return = $model->ToplamZamUygula($post);
 		
 		if($return['durum']){
 			$type="";
 		}else{
 			$type="error";
 		}
 		$message = $return['message'];
 		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret', $message,$type);
 	}
 	
 	function kararNoEkle(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
		
 		$return = $model->kararNoEkle ($post);
 		
 		$this->setRedirect('index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout=kurul_kararno', $return['MESSAGE'],$type);
 	}
 	
 	function kararNoSil(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 		$datas = $model->kararNoSil ($post['kararId']);
 		echo json_encode($datas);
 	}
 	
 	function kararNoDuzenle(){
 		$model 		 = $this->getModel('yeterlilik_ucret');
 		$post 		 = JRequest::get( 'post' );
 		$datas = $model->kararNoDuzenle ($post);
 		echo json_encode($datas);
 	}
 	
    function display() {

        parent::display();
    }
    
   
    

}
?>