<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries/form/functions.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once('libraries/form/FormUcretHesabi.php');
require_once("libraries/joomla/utilities/browser_detection.php");
require_once('libraries/tcpdf-new/tcpdf.php');

$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.monthpicker.js');

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


/**
 * Rate Component Controller
 */
class Belgelendirme_TesvikController extends JController {
	
	function belgelendirmeKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T3_BASVURU_TIP, $user);
		
		$message	 = $model->belgelendirmeKaydet ($post, $layout, $evrak_id);		
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_belgelendirme_tesvik&layout='.$layout.'&evrak_id='.$evrak_id, $message);
	}
	
	function TesvikAdayYarat(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->TesvikIstekKaydet($post, $user->getOracleUserId());
		
		if($return){
			if($return['durum'] == 1){
				$redirect = "index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_edit&IstekId=".$return['IstekId'];
			}else if($return['durum'] == 2){
				$redirect = "index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik";
			}
			$type = "";
			$message = $return['message'];
		}else{
			$redirect = "index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik";
			$message = "Teşvik oluşturulurken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$type = "error";
		}
		
		$this->setRedirect($redirect, $message, $type);
	}
	
	function TesvikPdfKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$redirect = "index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik";
		
		$return = $model->TesvikPdfKaydet($post,$files,$user->getOracleUserId());
		
		if($return){
			$type = "";
			$message = "Istek PDF'i başarıyla eklendi. Artık bu isteği onaya sunabilirsiniz.";
		}else{
			$type = "error";
			$message = "Bir hata meydana geldi. Yüklemeye çalıştığınız dosyanın indirdiğiniz pdf olduğuna dikkat ediniz.";
		}
		
		$this->setRedirect($redirect, $message, $type);
	}
	
	function TesvikPdfSil(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikPdfSil($post['IstekId']));
	}
	
	function TesvikSil(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikSil($post['IstekId']));
	}
	
	function TesvikOnayaSun(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikOnayaSun($post['IstekId'],$user->getOracleUserId()));
	}
	
	function TesvikDurumGuncelle(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikDurumGuncelle($post['IstekId'], $post['durum'], $user->getOracleUserId()));
	}
	
	function adayBilgiKontrol(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_tesvik');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->adayBilgiKontrol($post['belgelist']));
	}
	
    function display() {
    	
        parent::display();
    }

}
?>