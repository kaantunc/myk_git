<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('components/com_belgelendirme/models/belgelendirme_islemleri.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/functions.php');
require_once('libraries/form/FormABHibeUcretHesabi.php');
require_once('libraries/tcpdf-new/tcpdf.php');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );


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
//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

$document->addScript( SITE_URL.'/includes/js/Jcrop/js/jquery.Jcrop.js' );
$document->addStyleSheet( SITE_URL.'/includes/js/Jcrop/css/jquery.Jcrop.css' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.monthpicker.js');

$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');

$document->addScript (SITE_URL.'/includes/js/jquery.cookie.js');
//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');

// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

/**
 * Rate Component Controller
 */
class ProfileController extends JController {
	
	function ProfileEdit(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get( 'files' );
		$layout		 = JRequest::getVar("layout");
		if(isset($_GET['kurulusId'])){
			$kurulusId = $_GET['kurulusId'];
		}else{
			$kurulusId = $session->get("kurulusId");
		}
		
		if(!isset($layout)){
			$layout = 'kurulus_bilgi';
		}
		
		$message	 = $model->profileKaydet ($post, $files, $layout, $kurulusId);
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		

		$this->setRedirect('index.php?option=com_profile&layout='.$layout.'&kurulus='.$kurulusId.'&nomenu=1', $message);
	}
	
	function ProfilOnayla(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		echo json_encode($model->ProfilOnayla($post));
	}
	
	function BasvuruGetir(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$kurulusId = $session->get('kurulusId');
		
		echo json_encode($model->BasvuruGetir($kurulusId,$post['tip']));
	}
	
	function YetkiliBirims(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$kurulusId = $session->get('kurulusId');
		
		echo json_encode($model->YetkiliBirims($kurulusId,$post['yetId']));
	}
	
	function DocFormKaydet(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get( 'files' );
		
		$kurulusId = $session->get('kurulusId');
		
		$return = $model->docFormKaydet($post,$files,$kurulusId);
		
		if($return){
			$message = "Döküman başarıyla eklendi.";
			$mtype = "";
		}else{
			$message = "Döküman eklenirken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$mtype = "error";
		}
		
		$this->setRedirect('index.php?option=com_profile&layout=ekler&kurulus='.$kurulusId, $message, $mtype);
	}
	
	function DocsOnayla(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$kurulusId = $session->get('kurulusId');
		
		$return = $model->DocsOnayla($post,$kurulusId);
	}
	
	function DocsOnayKaldir(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$kurulusId = $session->get('kurulusId');
		
		$return = $model->DocsOnayKaldir($post,$kurulusId);
	}
	
	function DocsSil(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$kurulusId = $session->get('kurulusId');
		
		$return = $model->DocsSil($post,$kurulusId);
	}
	
	function NotGetirWithId() {
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		$user_id	= $user->getOracleUserId ();
		$return = $model->NotGetir(null,$post['notId'],$user_id);
		echo json_encode($return);
	}
	function NotFormKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
	
		$return = $model->NotEkle($post,$user->getOracleUserId ());
		$this->setRedirect('index.php?option=com_profile&view=profile&layout=notlar&kurulus='.$post['kurulusId'], $return);
	}
	
	function NotSil(){		
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
	
		$return = $model->NotSil($post);
		echo $return;
	}
	
	function NotGuncelle(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		$user		 = &JFactory::getUser ();
		$user_id	= $user->getOracleUserId ();
		$return = $model->NotGuncelle($post,$user_id);
		echo json_encode($return);
	}
	
	function SendArchiveDoc(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
		
		$return = $model->SendArchiveDoc($post);
		echo json_encode($return);
	}
	
	function RemoveFromArchieveDoc(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get('post');
	
		$return = $model->RemoveFromArchieveDoc($post);
		echo json_encode($return);
	}
	
	function degerlendiriciGetDatas() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->degerlendiriciGetDatas($post));
	}
	function sinavYeriGetDatas() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->sinavYeriGetDatas($post));
	}
	function degerlendiriciSubmitOrCancel() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$result = $model->degerlendiriciSubmitOrCancel($post['tcno'],$post['durum']);
		echo json_encode($result);
	}
	function degerlendiriciSubmitForYeterlilik() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$result = $model->degerlendiriciSubmitForYeterlilik($post);
		echo json_encode($result);
	}
	function saveForNewExamAdres() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->saveForNewExamAdres($post));
	}
	
	function confirmForNewExamAdres() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->confirmForNewExamAdres($post['yerid'],$post['status']));
	}
	function getExamAdres() {
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->getExamAdres($post['yerid']));
	}
	function sinavYeriOnayla(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->sinavYeriOnayla($post));
	}
	function sinavYeriOnaylaForYeterlilik(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->sinavYeriOnaylaForYeterlilik($post));
	}
	function UcretKaydet(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->UcretKaydet($post);
		$kurulusId = $post['kId'];
		if($return){
			$message = "Ücret tarifesi başarıyla kaydedildi.";
			$mtype = "";
		}else{
			$message = "Ücret tarifesi kaydedilirken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$mtype = "error";
		}
		
		$this->setRedirect('index.php?option=com_profile&view=profile&layout=tarife&kurulus='.$kurulusId, $message, $mtype);
	}
	
	function UcretSartKaydet(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->UcretSartKaydet($post);
		$kurulusId = $post['kurId'];
		if($return){
			$message = "Ücret tarifesi Detay ve Açıklama başarıyla kaydedildi.";
			$mtype = "";
		}else{
			$message = "Ücret tarifesi Detay ve Açıklama kaydedilirken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$mtype = "error";
		}
		
		$this->setRedirect('index.php?option=com_profile&view=profile&layout=tarife&kurulus='.$kurulusId, $message, $mtype);
	}
	
	function ajaxGetYetUcret(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxGetYetUcret($post));
	}
	
	function ajaxGetYetUcretByDonem(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxGetYetUcretByDonem($post));
	}
	
	function SinavaGirmisTop(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->getKurulusSinavGirenAndBasariliYeni($post['kurId']));
	}
	
	function irtibatkaydet(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$session	 = &JFactory::getSession();
		
		if(isset($_GET['kurulusId'])){
			$kurulusId = $_GET['kurulusId'];
		}else{
			$kurulusId = $session->get("kurulusId");
		}
		$return = $model->irtibatkaydet($kurulusId,$post);
		if($return){
			$message = "Kuruluş irtibat bilgileri başarıyla kaydedildi.";
			$mtype = "";
		}else{
			$message = "Kuruluş irtibat bilgileri kaydedilirken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$mtype = "error";
		}
		$this->setRedirect('index.php?option=com_profile&view=profile&layout=irtibat&kurulus='.$kurulusId, $message, $mtype);
	}
	
	function ajaxGetYetUcretYetkilimi(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxGetYetUcretYetkilimi($post));
	}
	
	function ajaxUcretOnayaGonder(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxUcretOnayaGonder($post));
	}
	
	function verilenBelgelerDetayByYetId(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->verilenBelgelerDetayByYetId($post['kurid'],$post['yetid']));
	}
	
	function verilenBelgelerDetay(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->verilenBelgelerDetay($post['kurid']));
	}
	
	function ABProKaydet(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$view		 = JRequest::getVar("view");
		$files 		 = JRequest::get( 'files' );
		$return = $model->ABProKaydet($post,$files);
		
		if($return['hata']){
			$message = $return['message'];
			$mtype = "error";
		}else{
			$message = $return['message'];
			$mtype = "";
		}
		if($view != null){
			$this->setRedirect('index.php?option=com_profile&view='.$view.'&layout=abdonem&kId='.$post['kId'], $message, $mtype);
		}else{
			$this->setRedirect('index.php?option=com_profile&view=profile&layout=abdonem&kurulus='.$post['kId'], $message, $mtype);
		}
	}
	
	function ABDonemKaydet(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$view		 = JRequest::getVar("view");
		$return = $model->ABDonemKaydet($post);
	
		if($return['hata']){
			$message = $return['message'];
			$mtype = "error";
		}else{
			$message = $return['message'];
			$mtype = "";
		}
		if($view != null){
			$this->setRedirect('index.php?option=com_profile&view='.$view.'&layout=abdonem&kId='.$post['kId'], $message, $mtype);
		}else{
			$this->setRedirect('index.php?option=com_profile&view=profile&layout=abdonem&kurulus='.$post['kId'], $message, $mtype);
		}
	}
	
	function DezUygulamaGuncelle(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->DezUygulamaGuncelle($post);
		echo json_encode($return);
	}
	
	function HibeDonemDuzenle(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->HibeDonemDuzenle($post);
		echo json_encode($return);
	}
	
	function ProDokSil(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->ProDokSil($post);
		echo json_encode($return);
	}
	
	function AjaxKurProGetir(){
		$model 		 = $this->getModel('profile');
		$post 		 = JRequest::get( 'post' );
		$return = $model->AjaxKurProGetir($post);
		echo json_encode($return);
	}

    function AjaxGetKurVergiNo(){
        $model 		 = $this->getModel('profile');
        $post 		 = JRequest::get( 'post' );
        $return = $model->AjaxGetKurVergiNo($post);
        echo json_encode($return);
    }

    function AjaxKurVergiNoGuncelle(){
        $model 		 = $this->getModel('profile');
        $post 		 = JRequest::get( 'post' );
        $return = $model->AjaxKurVergiNoGuncelle($post);
        echo json_encode($return);
    }

	function display() {	
        parent::display();
    }
}
?>