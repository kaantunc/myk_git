<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries/form/functions.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once('libraries/form/FormABHibeUcretHesabi.php');
require_once("libraries/joomla/utilities/browser_detection.php");

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

$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');
/**
 * Rate Component Controller
 */
class Belgelendirme_AbhibeController extends JController {
	
	function belgelendirmeKaydet (){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T3_BASVURU_TIP, $user);
		
		$message	 = $model->belgelendirmeKaydet ($post, $layout, $evrak_id);		
		$evrak_id = $session->get("evrak_id");
		$session->set("evrak_id", $evrak_id);
		
		$this->setRedirect('index.php?option=com_belgelendirme_abhibe&layout='.$layout.'&evrak_id='.$evrak_id, $message);
	}
	
	function TesvikAdayYarat(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->TesvikIstekKaydet($post, $user->getOracleUserId());
		
		if($return){
			if($return['durum'] == 1){
				$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_edit&IstekId=".$return['IstekId'];
			}else if($return['durum'] == 2){
				$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe";
			}
			$type = "";
			$message = $return['message'];
		}else{
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe";
			$message = "Teşvik oluşturulurken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$type = "error";
		}
		
		$this->setRedirect($redirect, $message, $type);
	}
	
	function TesvikPdfKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe";
		
		$return = $model->TesvikPdfKaydet($post,$files,$user->getOracleUserId());
		
		if($return){
			$type = "";
			$message = "Aday PDF Dosyası başarıyla eklendi. Artık bu isteği onaya sunabilirsiniz.";
		}else{
			$type = "error";
			$message = "Bir hata meydana geldi. Yüklemeye çalıştığınız dosyanın pdf formatında olduğuna dikkat ediniz.";
		}
		
		$this->setRedirect($redirect, $message, $type);
	}
	
	function TesvikPdfSil(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikPdfSil($post['IstekId']));
	}
	
	function TesvikSil(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikSil($post['IstekId']));
	}
	
	function TesvikOnayaSun(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikOnayaSun($post['IstekId'],$user->getOracleUserId()));
	}
	
	function TesvikOdemeOnayaSun(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikOdemeOnayaSun($post['IstekId'],$user->getOracleUserId()));
	}
	
	function TesvikDurumGuncelle(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->TesvikDurumGuncelle($post['IstekId'], $post['durum'], $user->getOracleUserId()));
	}
	
	function adayBilgiKontrol(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->adayBilgiKontrol($post['belgelist']));
	}
	
	public function ABHibeAdayOdemeFileYukle(){
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get('files');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayOdemeFileYukle($post,$files);
		echo json_encode($return);
	}
	
	public function ABHibeAdayOdemeFileSil(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayOdemeFileSil($post);
		echo json_encode($return);
	}
	
	public function ABHibeFaturaYukle(){
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get('files');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeFaturaYukle($post,$files);
		if($return['hata']){
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar_odeme&IstekId=".$post['tId'];
			$type = "error";
			$message = $return['message'];
		}else{
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar_odeme&IstekId=".$post['tId'];
			$type = "";
			$message = $return['message'];
		}
		$this->setRedirect($redirect, $message, $type);
	}
	
	public function ABHibeFaturaSil(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeFaturaSil($post);
		echo json_encode($return);
	}
	
	public function ABHibeEkstreYukle(){
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get('files');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeEkstreYukle($post,$files);
		if($return['hata']){
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar_odeme&IstekId=".$post['tId'];
			$type = "error";
			$message = $return['message'];
		}else{
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar_odeme&IstekId=".$post['tId'];
			$type = "";
			$message = $return['message'];
		}
		$this->setRedirect($redirect, $message, $type);
	}
	
	public function ABHibeEkstreSil(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeEkstreSil($post);
		echo json_encode($return);
	}
	
	public function ABHibeOdemeDosyalariYukluMu(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeOdemeDosyalariYukluMu($post);
		echo json_encode($return);
	}
	
	public function TesvikAdayPDFOnayaSun(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->TesvikAdayPDFOnayaSun($post['IstekId'],$user->getOracleUserId());
		echo json_encode($return);
	}
	
	function ABHibeAdayDezFileYukle(){
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get('files');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayDezFileYukle($post,$files);
		echo json_encode($return);
	}
	
	function ABHibeAdayDezFileSil(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayDezFileSil($post);
		echo json_encode($return);
	}
	
	function ABHibeAdayBasFileYukle(){
		$post 		 = JRequest::get('post');
		$files 		 = JRequest::get('files');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayBasFileYukle($post,$files);
		echo json_encode($return);
	}
	
	function ABHibeAdayBasFileSil(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayBasFileSil($post);
		echo json_encode($return);
	}
	
	function ABHibeAdayIbanGetir(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayIbanGetir($post);
		echo json_encode($return);
	}
	
	function ABHibeAdayIbanKaydet(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('belgelendirme_abhibe');
		$return = $model->ABHibeAdayIbanKaydet($post);
		echo json_encode($return);
	}

    function AjaxAdayBasvuruDosyasi(){
        $post 		 = JRequest::get('post');
        $model 		 = $this->getModel('belgelendirme_abhibe');
        $return = $model->AjaxAdayBasvuruDosyasi($post);
        echo json_encode($return);
    }

    function BasvuruListesiYukle(){
        $user		 = &JFactory::getUser ();
        $user_id = $user->getOracleUserId();
        $files 		 = JRequest::get('files');
        $model 		 = $this->getModel('belgelendirme_abhibe');
        $return = $model->BasvuruExcelKadyet($user_id,$files);
        $redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=basvuru_listesi";
        if($return){
            $type = "";
            $message = "Başvuru Listesi Başarıyla Yüklendi.";
        }else{
            $message = "Bir hata meydana geldi. Lütfen tekrar deneyin.";
            $type = "error";
        }

        $this->setRedirect($redirect, $message, $type);
    }

    function AjaxGetAbHibeKurulusBelgeNo(){
        $user		 = &JFactory::getUser ();
        $user_id = $user->getOracleUserId();
        $model 		 = $this->getModel('belgelendirme_abhibe');
        $post 		 = JRequest::get( 'post' );

        echo json_encode($model->AjaxGetAbHibeBelgeNo($post['bNo']),$user_id);
    }

    function ABHibeKurulusAdayKaydet(){
        $user		 = &JFactory::getUser ();
        $user_id = $user->getOracleUserId();
        $model 		 = $this->getModel('belgelendirme_abhibe');
        $post 		 = JRequest::get( 'post' );
        $files 		 = JRequest::get( 'files' );
        $return = $model->ABHibeYoneticiAdayKaydet($post,$files,$user_id);

        $redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=abaday";
        if($return['hata']){
            $type = "error";
            $message = $return['message'];
            $redirect .= "&bNo=".$post['bNo'];
        }else{
            $message = $return['message'];
        }

        $this->setRedirect($redirect, $message, $type);
    }

	// Yonetici ********************************************************************************//
	public function TesvikAdayKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('yonetici');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->TesvikIstekKaydet($post, $user->getOracleUserId());
		
		if($return){
			if($return['durum'] == 1){
				$redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=tesvik_edit&IstekId=".$return['IstekId'];
			}else if($return['durum'] == 2){
				$redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici";
			}
			$type = "";
			$message = $return['message'];
		}else{
			$redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici";
			$message = "Teşvik oluşturulurken bir hata meydana geldi. Lütfen tekrar deneyin.";
			$type = "error";
		}
		
		$this->setRedirect($redirect, $message, $type);
	}
	
	public function YoneticiHibeOnayla(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('yonetici');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->YoneticiHibeOnayla($post, $user->getOracleUserId());
		echo json_encode($return);
	}
	
	public function SGBUcretKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('yonetici');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		
		$return = $model->SGBUcretKaydet($post, $files, $user->getOracleUserId());
		
		if($return){
			$this->setRedirect("index.php?option=com_belgelendirme_abhibe&view=yonetici&dId=5", "AB Hibe Ücreti Başarıyla sisteme işlendi.");
		}else{
			$this->setRedirect("index.php?option=com_belgelendirme_abhibe&view=yonetici&dId=4", "Bir hata meydana geldi. Lütfen tekrar deneyin.","error");
		}
	}
	
	public function KotaOdemeKontrol(){
		$post 		 = JRequest::get('post');
		$IstekId = array_key_exists('IstekId', $post)?$post['IstekId']:0;
		$return = FormABHibeUcretHesabi::KotaOdemeKontrol($post['TopUcret'],$post['TopDez'],$post['doviz'],$post['kId'],$IstekId);
		echo json_encode($return);
	}
	
	public function KotaOdemeKontrolWithId(){
		$post 		 = JRequest::get('post');
		$return = FormABHibeUcretHesabi::KotaOdemeKontrolWithId($post['IstekId'],$post['doviz']);
		echo json_encode($return);
	}
	
	public function GeriOdemeBilgi(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('yonetici');
		$return = $model->GeriOdemeBilgi($post['IstekId']);
		echo json_encode($return);
	}
	
	public function ABHibeGeriGonder(){
		$post 		 = JRequest::get('post');
		$model 		 = $this->getModel('yonetici');
		$return = $model->ABHibeGeriGonder($post);
		
		if($return){
			$this->setRedirect("index.php?option=com_belgelendirme_abhibe&view=yonetici", "AB Hibe İsteği Başarıyla Kuruluşa Geri Gönderildi.");
		}else{
			$this->setRedirect("index.php?option=com_belgelendirme_abhibe&view=yonetici", "Geri Gönderim Sırasında Bir hata meydana geldi. Lütfen tekrar deneyin.","error");
		}
	}
	
	function TesvikAdayImzaliPdfKaydet(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('yonetici');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici&dId=1";
	
		$return = $model->TesvikPdfKaydet($post,$files,$user->getOracleUserId());
	
		if($return){
			$type = "";
			$message = "Aday PDF Dosyası başarıyla eklendi. Artık bu isteği ödeme için kuruluşa gönderebilirsiniz.";
		}else{
			$type = "error";
			$message = "Bir hata meydana geldi. Yüklemeye çalıştığınız dosyanın pdf formatında olduğuna dikkat ediniz.";
		}
	
		$this->setRedirect($redirect, $message, $type);
	}
	
	function TesvikAdayImzaliPdfSil(){
		$session	 = &JFactory::getSession();
		$user		 = &JFactory::getUser ();
		$model 		 = $this->getModel('yonetici');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->TesvikPdfSil($post['IstekId']));
	}

    function AjaxGetFaturaBilgi(){
        $model 		 = $this->getModel('yonetici');
        $post 		 = JRequest::get( 'post' );

        echo json_encode($model->AjaxGetFaturaBilgi($post['IstekId']));
    }

    function AjaxGetAbHibeBelgeNo(){
        $model 		 = $this->getModel('yonetici');
        $post 		 = JRequest::get( 'post' );

        echo json_encode($model->AjaxGetAbHibeBelgeNo($post['bNo']));
    }

    function ABHibeYoneticiAdayKaydet(){
        $model 		 = $this->getModel('yonetici');
        $post 		 = JRequest::get( 'post' );
        $files 		 = JRequest::get( 'files' );
        $return = $model->ABHibeYoneticiAdayKaydet($post,$files);

        $redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=abaday";
        if($return['hata']){
            $type = "error";
            $message = $return['message'];
            $redirect .= "&bNo=".$post['bNo'];
        }else{
            $message = $return['message'];
        }

        $this->setRedirect($redirect, $message, $type);
    }
	
    function display() {
    	
        parent::display();
    }

}
?>