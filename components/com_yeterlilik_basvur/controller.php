<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();


$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_yeterlilik_basvur/js/yeterlilik.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.monthpicker.js');
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
/**
 * Rate Component Controller
 */
class Yeterlilik_BasvurController extends JController {
	
	function yeterlilikKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
// 		$evrak_id = $session->get("evrak_id");
// 		if ($evrak_id==""){
// 			if($_POST[evrak_id]!=""){
// 				$evrak_id=$_POST[evrak_id];
// 			} else {
// 				$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T2_BASVURU_TIP, $user);
// 			}
// 		}
		$evrak_id = $_POST['evrak_id'];		
		$message	 = $model->yeterlilikKaydet ($post, $layout, $evrak_id);
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_yeterlilik_basvur&evrak_id='.$evrak_id.'&layout='.$layout, $message);
	}
	
	function basvuruBitir (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T2_BASVURU_TIP, $user);
		
		$model->basvuruBitir ($evrak_id);
		$session->set("evrak_id", $evrak_id);
		$message = "Başvuru Başarıyla Gönderildi";

		$this->setRedirect('index.php?option=com_yeterlilik_basvur&view=yeterlilik_basvur&layout=pdf_link', $message);
	}
	
	function ajaxBasvuruSil(){
		$model 		 = $this->getModel('yeterlilik_basvur');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->ajaxBasvuruSil($post));
	}
	
	function yeterlilikKaydetYeni() {
		$model 		 = $this->getModel('basvuru_kaydet');
		$session	 = &JFactory::getSession();
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$layout		 = JRequest::getVar("layout");
		$data = $model->yeterlilikKaydetYeni($post,$files);
		
		$evrak_id = $data['evrak_id'];
		$session->set("evrak_id", $evrak_id);

		$this->setRedirect('index.php?option=com_yeterlilik_basvur&evrak_id='.$evrak_id.'&layout='.$layout, $message);
	}
	
	function BasvuruEkSil() {
		$post 		 = JRequest::get( 'post' );
		$model 		 = $this->getModel('basvuru_kaydet');
		$return 	 = $model->BasvuruEkSil($post['ekId']);
		echo json_encode($return);
	}
	function basvuruBitirYeni(){
		$post 		 = JRequest::get( 'post' );
		$model 		 = $this->getModel('basvuru_kaydet');
	
		$return = $model->basvuruBitirYeni($post['evrak_id']);
		echo json_encode($return);
	}
    function display() {
    	
        parent::display();
    }

}
?>