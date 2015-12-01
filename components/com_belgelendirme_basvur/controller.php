<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_belgelendirme_basvur/js/belgelendirme_basvur.js' );

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

/**
 * Rate Component Controller
 */
class Belgelendirme_BasvurController extends JController {
	
	function belgelendirmeKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$evrak_id 	 = FormFactory2::getCurrentEvrakId ($post, T3_BASVURU_TIP, $user);
		
		$message	 = $model->belgelendirmeKaydet ($post, $layout, $evrak_id);		
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_belgelendirme_basvur&layout='.$layout.'&evrak_id='.$evrak_id, $message);
	}
	
	function basvuruBitir (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		$evrak_id 	 = $get['evrak_id'];
		
		$model->basvuruBitir ($evrak_id);
		$session->set("evrak_id", $evrak_id);

		$this->setRedirect('index.php?option=com_belgelendirme_basvur&layout=pdf_link&evrak_id='.$evrak_id, "Başvuru gönderildi, ıslak imzalı dokümanınızı MYK'ya iletiniz.");
	}
        
        function belgelendirmeEkSil(){
            $model 		 = $this->getModel('belgelendirme_basvur');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->belgelendirmeEkSil($post));
        }
        
        function ajaxDelBasvuruDocs(){
        	$model 		 = $this->getModel('belgelendirme_basvur');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DelBasvuruDoc($post));
        }
        
        function sinavMerkeziKaydet(){
                $model 		 = $this->getModel('belgelendirme_basvur');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->sinavMerkeziKaydet($post));
        }
        
        function sinavMerkeziSil(){
            $model 		 = $this->getModel('belgelendirme_basvur');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->sinavMerkeziSil($post));
        }
        
        function ajaxGetSinavMerkezi(){
        	$model 		 = $this->getModel('belgelendirme_basvur');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->ajaxGetSinavMerkezi($post));
        }
        
        function sinavMerkeziUpdate(){
        	$model 		 = $this->getModel('belgelendirme_basvur');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->sinavMerkeziUpdate($post));
        }
        
        function ajaxBelgeSil(){
        	$model 		 = $this->getModel('belgelendirme_basvur');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->ajaxBelgeSil($post));
        }

    function AjaxYetTalepSil(){
        $model 		 = $this->getModel('belgelendirme_basvur');
        $post 		 = JRequest::get( 'post' );
        echo json_encode($model->AjaxYetTalepSil($post));
    }
	
    function display() {
    	
        parent::display();
    }

}
?>