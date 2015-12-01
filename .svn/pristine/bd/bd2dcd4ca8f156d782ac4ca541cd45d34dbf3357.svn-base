<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
ini_set("display_errors", "1");
require_once('libraries/form/functions.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once('libraries/form/FormABHibeUcretHesabi.php');
require_once("libraries/joomla/utilities/browser_detection.php");
require_once('libraries/tcpdf-new/tcpdf.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );

//patchSatirEkle icin
//$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/meslek_std_taslak.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js');

$document->addScript( SITE_URL.'/includes/js/jquery.timepicker.js');
$document->addStyleSheet( SITE_URL.'/includes/js/jquery.timepicker.css');
$document->addScript( SITE_URL.'/includes/js/jquery.blockUI.js');

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

// tooltip
$document->addStyleSheet( SITE_URL.'/includes/js/tooltipster-master/css/tooltipster.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/tooltipster-master/css/themes/tooltipster-light.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/tooltipster-master/css/themes/tooltipster-noir.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/tooltipster-master/css/themes/tooltipster-shadow.css' );
$document->addScript( SITE_URL.'/includes/js/tooltipster-master/js/jquery.tooltipster.js' );


//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');
// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

class Tesvik_AbhibeController extends JController { 
	
	function TesvikAdayYarat(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
// 		$file 		 = JRequest::get( 'file' );
		
		$return	 = $model->TesvikAdayYarat($post);
		
		$error = '';
		if($return['durum'] == 1){
			$layout = "default";
		}else if($return['durum'] == 2){
			$layout = "tesvik_edit";
			$error = "error";
		}else if($return['durum'] == 0){
			$layout = "default";
			$error = "error";
		}
		
		$this->setRedirect('index.php?option=com_tesvik&view=tesvik&layout='.$layout, $return['message'], $error);
	}
	
	function TesvikAdayEditKaydet(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		// 		$file 		 = JRequest::get( 'file' );
		
		$return	 = $model->TesvikAdayEditKaydet($post);
		
		$error = '';
		if($return['durum'] == 1){
			$layout = "default";
		}else if($return['durum'] == 2){
			$layout = "tesvik_edit";
			$error = "error";
		}else if($return['durum'] == 0){
			$layout = "default";
			$error = "error";
		}
		
		$this->setRedirect('index.php?option=com_tesvik&view=tesvik&layout='.$layout, $return['message'], $error);
	}
	
	function TesvikSil(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikSil($post['tId']));
	}
	
	function TesvikOnayaSun(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikOnayaSun($post['tId']));
	}
	
	function TesvikOnayla(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikOnayla($post['tId'],$post['uId']));
	}
	
	function TesvikGeriGonder(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikGeriGonder($post['tId'],$post['uId']));
	}
	
	function AjaxItirazWithBelgeNo(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->AjaxItirazWithBelgeNo($post['belgeNo']));
	}
	
	function AjaxItirazUcretKaydetWithBelgeNo(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->AjaxItirazUcretKaydetWithBelgeNo($post['belgeNo'],$post['ucret']));
	}
	
	function AjaxItirazDurumGuncelleWithBelgeNo(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->AjaxItirazDurumGuncelleWithBelgeNo($post['belgeNo'],$post['durum']));
	}
	
	function TesvikBankayaGonder(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikBankayaGonder($post['tId'],$post['dId']));
	}
	
	function TesvikIskuraGonder(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->TesvikIskuraGonder($post['tId'],$post['dId']));
	}
	
	function istekDetay(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->istekDetay($post['istekId']));
	}
	
	function saveIstekDetay(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->saveIstekDetay($post['istekId'],$post['bankaodemetarihi']));
	}
	
	function DezAvantajDurumGuncelle(){
		$model 		 = $this->getModel('tesvik_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->DezAvantajDurumGuncelle($post));
	}

	function display() {
		parent::display();
	}
}