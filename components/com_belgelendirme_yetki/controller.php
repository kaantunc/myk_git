<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries/form/functions.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );

//tooltip deneme
//http://playground.elliotlings.com/jquery/tooltip/
$document->addScript( SITE_URL.'/components/com_belgelendirme/js/jquery.lingsTooltip.js' );
$document->addStyleSheet( SITE_URL.'/components/com_belgelendirme/css/tooltip.css' );
//tooltip deneme

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

//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');
// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

class BelgelendirmeYetkiController extends JController { 
	
// 	function program_kaydet(){
// 		$model 		 = $this->getModel('belgelendirme_islemleri');
// 		$post 		 = JRequest::get( 'post' );
// 		$file 		 = JRequest::get( 'file' );
// 		$message	 = $model->ProgramKaydet ($post);
		
// 		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout='.JRequest::getVar ("layout"), $message);
// 	}

	public function YeniYetkiKaydet(){
		$model 		 = $this->getModel('belgelendirme_yetki');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->YeniYetkiKaydet($post);
		if($return == 1){
			$message="Yetki verme işlemi Yöneticinin onayına başarıyla sunulmuştur.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$post['kurulusId'], $message);
		}else if($return == 2){
			$message="Yetki verme işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyin.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$post['kurulusId'], $message,'error');
		}else if($return == 3){
			$message="Yetki verme işlemi sırasında bir hata meydana geldi. Bazı birimler için yetki verilememiştir. Yetkiyi düzeltiniz.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$post['kurulusId'], $message,'error');
		}
	}
	
	public function YetkiDuzenleKaydet(){
		$model 		 = $this->getModel('belgelendirme_yetki');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->YetkiDuzenleKaydet($post);
		if($return == 1){
			$message="Yetki verme işlemi Yöneticini onayına sunulmuştur.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki_duzenle&kurulusId='.$post['kurulusId'].'&yetkiYet='.$post['yetId'], $message);
		}else if($return == 2){
			$message="Yetki verme işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyin.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki_duzenle&kurulusId='.$post['kurulusId'].'&yetkiYet='.$post['yetId'], $message,'error');
		}
	}
	
	public function YetkiOnayla(){
		$model 		 = $this->getModel('belgelendirme_yetki');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->YetkiOnayla($post);
		if($return == 1){
			$varMi = $model->OnayBekleyenYetsWithKurs($post['kurulusId']);
			$message="Yetki verme işlemi başarıyla gerçekleşmiştir.";
			if(!empty($varMi)){
				$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=kurulus_yetki&kurulusId='.$post['kurulusId'], $message);
			}else{
				$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay', $message);
			}
			
		}else if($return == 2){
			$message="Yetki verme işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyin.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay', $message,'error');
		}else if($return == 3){
			$message="Yetki verme işlemi sırasında bir hata meydana geldi. Bazı birimler için yetki verilememiştir. Yetkiyi düzeltiniz.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay', $message,'error');
		}
	}
	
	public function AskiyaAl(){
		$model 		 = $this->getModel('belgelendirme_yetki');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->AskiyaAl($post);
		
		if($return){
			$message = "Kuruluşun yetkileri başarıyla Askıya Alındı.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=aski', $message);
		}else{
			$message = "Kuruluşun yetkileri Askıya Alma işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyin.";
			$this->setRedirect('index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=aski', $message, 'error');
		}
	}
	
	public function AskiyiGeriAl(){
		$model 		 = $this->getModel('belgelendirme_yetki');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->AskiyiGeriAl($post);
		echo json_encode($return);
	}
	
	function display() {
		parent::display();
	}
}