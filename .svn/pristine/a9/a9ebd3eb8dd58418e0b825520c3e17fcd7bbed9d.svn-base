<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
$document = &JFactory::getDocument();

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_uzman_basvur/js/uzman_basvur.js' );
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.collapsible.js');

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );

//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');

// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

require_once('libraries/form/functions.php');
/**
 * Rate Component Controller
 */
class Uzman_BasvurController extends JController {

	function basvuruKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$view		 = JRequest::getVar("view");
		if ($post[tckimlik]!=""){
			$tc_kimlik=$post[tckimlik];
		} else {
			$tc_kimlik	 = JRequest::getVar("evrak_id");
		}
		
		if(empty($view)){
			$view = "uzman_basvur";
		}
		
		$message	 = $model->basvuruKaydet ($post, $layout);
		if ($tc_kimlik){$linkek="&tc_kimlik=".$tc_kimlik;}
//		$evrak_id = $session->get("evrak_id");
// 		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_uzman_basvur&view='.$view.'&layout='.$layout.$linkek, $message);
	}
	
	function basvuruBitir (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('basvuru_kaydet');
		$post 		 = JRequest::get( 'post' );
//		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T1_BASVURU_TIP, $user);
		$evrak_id=$post[evrak_id];
		$session->set("evrak_id", $evrak_id);
		
		$model->basvuruBitir ($evrak_id);
		$message = "BAŞVURUNUZ ALINMIŞTIR. TEŞEKKÜRLER.";
		$this->setRedirect('index.php?option=com_uzman_basvur&view=uzman_basvur&layout=pdf_link', $message);
	}
	
	function uzmanlardan_ara()
	{
		$model 		 = $this->getModel('uzman_basvurulari');
		$model->uzmanlardanAra();
		
	}
        
         function SertifikaGetir(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->getSertifikaGetir($post));
        }
        
        function SertifikaSil(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->SertifikaSil($post));
        }
        
        function EgitimGetir(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->getEgitimGetir($post));
        }
        
        function MykEgitimGetir(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->getMykEgitimGetir($post));
        }
        
        function EgitimSil(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->EgitimSil($post));
        }
        
        function MykEgitimSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->MykEgitimSil($post));
        }
        
        function DilGetir(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->getDilGetir($post));
        }
        
        function DilSil(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->DilSil($post));
        }
        
        function IsGetir(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->getIsGetir($post));
        }
        
        function IsSil(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->IsSil($post));
        }
        
        function MYKDeneyimGetir(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->getMYKDeneyimGetir($post));
        }
        
        function MYKDeneyimSil(){
            $model 		 = $this->getModel('uzman_basvurulari');
            $post 		 = JRequest::get( 'post' );
            echo json_encode($model->MYKDeneyimSil($post));
        }
        
        function DenetciDeneyimKaydet(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciDeneyimKaydet($post));
        }
        
        function TUzmanDeneyimKaydet(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUzmanDeneyimKaydet($post));
        }
        
        function getAjaxYeterlilikWithSekorIdAndTc(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->getAjaxYeterlilikWithSekorIdAndTc($post));
        }
        
        function DenetciDeneyimSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciDeneyimSil($post));
        }
        
        function DenetciDeneyimGetir(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciDeneyimGetir($post));
        }
        
        function TUDeneyimSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUDeneyimSil($post));
        }
        
        function TUDeneyimGetir(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUDeneyimGetir($post));
        }
        
        function DenetciBelgeGecSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciBelgeGecSil($post));
        }
        
        function DenetciBelgeKanitSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciBelgeKanitSil($post));
        }
        
        function DenetciBelgeDurumKaydet(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciBelgeDurumKaydet($post));
        }
        
        function TUYetDurumKaydet(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUYetDurumKaydet($post));
        }
        
        function TUYetSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUYetSil($post));
        }
        
        function TUBelgeKanitSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TUBelgeKanitSil($post));
        }
        
        function getTaslakYeterlilik(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->getTaslakYeterlilik($post['yetId']));
        }
        
        function DenetciBasvurusuTamamla(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->DenetciBasvurusuTamamla($post));
        }
        
        function TeknikBasvurusuTamamla(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TeknikBasvurusuTamamla($post));
        }
        
        function BilgilendirmeOnayla(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->BilgilendirmeOnayla($post));
        }
        
        function TaahutSil(){
        	$model 		 = $this->getModel('uzman_basvurulari');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->TaahutSil($post));
        }
        
        function ajaxDenetimRaporOnayla(){
        	$model 		 = $this->getModel('uzman_profile');
        	$post 		 = JRequest::get( 'post' );
        	echo json_encode($model->ajaxDenetimRaporOnayla($post));
        }
                
    function display() {
    	
        parent::display();
    }

}
?>