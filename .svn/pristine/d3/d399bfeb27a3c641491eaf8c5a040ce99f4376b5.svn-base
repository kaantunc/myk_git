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
// $document->addScript( SITE_URL.'/components/com_belgelendirme/js/jquery.lingsTooltip.js' );
// $document->addStyleSheet( SITE_URL.'/components/com_belgelendirme/css/tooltip.css' );
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

$document->addStyleSheet( SITE_URL.'/includes/js/timepicker/jquery.timepicker.css');
$document->addScript( SITE_URL.'/includes/js/timepicker/jquery.timepicker.js');
/*$document->addStyleSheet( SITE_URL.'/includes/js/timepicker/lib/bootstrap-datepicker.css');
$document->addScript( SITE_URL.'/includes/js/timepicker/lib/bootstrap-datepicker.js');*/
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');

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

class BelgelendirmeController extends JController { 
	
	function program_kaydet(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
        $files 		 = JRequest::get( 'files' );
		$return 	 = $model->ProgramKaydet ($post,$files);

        $message = '';
        $error = '';
        if($return['STATUS']){
            $message = $return['MESSAGE'];
        }else{
            $message = $return['MESSAGE'];
            $error = 'error';
        }

		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout='.JRequest::getVar ("layout"), $message, $error);
	}
	
	function program_bildir(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		return $model->ProgramBildir($post);
	
		//$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_program', $message);
	}
	
	function program_ilKaydet(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		return $model->ProgramIlKaydet($post);
	
		//$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_program', $message);
	}

	function program_iptal(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
        $files 		 = JRequest::get( 'files' );
        $layout		= JRequest::getVar ("layout");
        $view		= JRequest::getVar ("view");
		$return = $model->ProgramSil($post,$files);
        $message = "";
        $error = "";
	    if($return['hata']){
            $message = $return['message'];
            $error = "error";
            $this->setRedirect('index.php?option=com_belgelendirme&view='.$view.'&layout='.$layout, $message, $error);
        }else{
            $message = $return['message'];
            $this->setRedirect('index.php?option=com_belgelendirme&view='.$view.'&layout='.$layout, $message, $error);
        }
		//$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_program', $message);
	}

    function AjaxSinavIptalBilgi(){
        $model 		 = $this->getModel('belgelendirme_islemleri');
        $post 		 = JRequest::get( 'post' );
        $return = $model->AjaxSinavIptalBilgi($post);
        echo json_encode($return);
    }

    function AjaxSinavIptalFileSil(){
        $model 		 = $this->getModel('belgelendirme_islemleri');
        $post 		 = JRequest::get( 'post' );
        $return = $model->AjaxSinavIptalFileSil($post);
        echo json_encode($return);
    }
	
	function sinav_yeri_kaydet(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		$message	 = $model->SinavYeriKaydet ($post);
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout='.JRequest::getVar ("layout"), $message);
	}
	
	function tcKayitlimi(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->tcKayitlimi($post));
	}
	
	function degerlendiriciSinav_kaydet(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		$file 		 = JRequest::get( 'files' );
		$message	 = $model->DegerlendiriciSinavKaydet ($post,$file);
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout='.JRequest::getVar ("layout"), $message);
	}
	
	function AdayKaydet(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		$message	 = $model->AdayKaydet ($post);
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout='.JRequest::getVar ("layout"), $message);
	}
	
	function tcKayitliAday(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->tcKayitliAday ($post));
	}
	
	function AdayUpdate(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->AdayUpdate($post));
	}
        
        function adaySonucSil(){
                $model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->adaySonucSil($post));
        }
        
        function BildirilmisAdaySil(){
                $model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->BildirilmisAdaySil($post));
        }
        
        function sonucGonderYetkilimi(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->sonucGonderYetkilimi($post));  
        }
        
        function sonucGonder(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->sonucGonder($post));  
        }
        
        function sonucGonderilecekAdaylar(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->sonucGonderilecekAdaylar($post));
        }
        
        function belgeAdaySonucGonder(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	$layout		 = 'belgelendirme_program';
        	$program     = 2;
        	$message = '';
        	$return = $model->belgeAdaySonucGonder($post);
        	if($return){
        		$message = "Sonuç Bildiriminiz Başarıyla Gerçekleşmiş ve Dosya Sorumlusuna Gönderilmiştir.";
        	}else{
        		$message = "Sonuç Bildiriminiz Başarıyla Gerçekleşmiş ve Dosya Sorumlusuna Gönderilmiştir.";
        	}
        	
        	$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=2', $message);
        }
        
        function BelgesiVarmi(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->BelgesiVarmi($post));  
        }
        
        function KurulusSinavlar(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->KurulusSinavlar($post));  
        }
        
        function BelgeAdayGetir(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->BelgeAdayGetir($post));
        }
        
        function BelgeAdayGetirWithBasvuruId(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        
        	echo json_encode($model->BelgeAdayGetirWithBasvuruId($post));
        }
        
        function BelgeAdayBirimler(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->BelgeAdayBirimler($post));
        }
        
        function BelgeSablonGetir(){
            $model 		 = $this->getModel('belgelendirme_islemleri');
            $post 		 = JRequest::get( 'post' );
	
            echo json_encode($model->BelgeSablonGetir($post));
        }
        
        function KurulusSinavlarTckn(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->KurulusSinavlarTckn($post));
        }
        
        function KurulusSinavlarBelgeNo(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	 
        	echo json_encode($model->KurulusSinavlarBelgeNo($post));
        }
        
        function BelgeNoAl(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	 
        	echo json_encode($model->BelgeNoAl($post));
        }
        
        function BelgeNoVer(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->BelgeNoVer($post));
        }
        
        function sinavYeriSil(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	 
        	echo json_encode($model->sinavYeriSil($post));
        }
        
        function geriAdayExcelKont(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->geriAdayExcel(0,$post['sinavId']));
        }
        
        function sonucTaAdaylar(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	 
        	echo json_encode($model->sonucTaAdaylar($post['sinavId']));
        }
        
        function BelgeNoVarMi(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->BelgeNoVarMi($post['belgeNo']));
        }
        
        function BelgeNoSonucGonder(){
        	$model 		 = $this->getModel('belgelendirme_islemleri');
        	$post 		 = JRequest::get( 'post' );
        	$files = JRequest::get( 'files' );
        	 
        	$return = $model->BelgeNoSonucGonder($post,$files);
        	if($return['STATUS'] == false){
        		$mesage = $return['MESSAGE'];
        		$this->setRedirect('index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=aday_bildirim&sinavId='.$post['sinav_id'], $mesage, 'error');
        	}else{
        		$mesage = "Sonuç Bildiriminiz Başarıyla Gerçekleşmiş ve Yüklemiş Olduğunuz Dekont İncelenmek Üzere Dosya Sorumlusuna Gönderilmiştir.";
        		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=2', $mesage);
        	}
        	 
        }
	
	function SinavSearch(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->SinavSearch($post));
	}
	
	function sinavYeriGetir(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->sinavYeriGetir($post));
	}
	
	function sinavDegerGetir(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->sinavDegerGetir($post));
	}
	
	function sinavAdayGetir(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->sinavAdayGetir($post));
	}
	
	function getAlternatifYeterlilik(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->getAlternatifYeterlilik($post));
	}
	
	function BelgeImzaYetkiliGetir(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->BelgeImzaYetkiliGetir($post));
	}
	
	function getKurulusLogoTamMi(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->getKurulusLogoTamMi($post));
	}
	
	function sinavYeriNotYets(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->sinavYeriNotYets($post));
	}
	
	function SinavYeriUpdate(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->SinavYeriUpdate($post);
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_sinav_yeri', $return);
	}
	
	function sinavYeriBildirimIptal(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->sinavYeriBildirimIptal($post));
	}
	
	function sinavYeriBildirim(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
	
		echo json_encode($model->sinavYeriBildirim($post));
	}
	
	function degerlendiriciEtkin(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->degerlendiriciEtkin($post));
	}
	
	function degerYetSil(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->degerYetSil($post));
	}
	
	function BelgeDurumuDuzenle(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeDurumDuzenle($post);
		$belgeNo = $post['belgeNo'];
		
		if($return){
			$message = "Belge Durumu Düzenleme İşlemi Başarıyla Sonuçlandı.";
			$mtype = "";
		}else{
			$message = "Belge Durumu Düzenleme İşlemi Sırasında Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.";
			$mtype = "error";
		}
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belge_olusturma&layout=belge_durum&belgeNo='.urlencode($belgeNo), $message,$mtype);
	}
	
	function belgeMatbaahSearch(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->belgeMatbaahSearch($post));
	}
	
	function eskiSinavBirimKaydet(){
		$model 		 = $this->getModel('eski_sinav');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->EskiSinavBirimKaydet($post);
		$message = 'Gerekli alanları doldurulmuş olan bilgiler sisteme kaydedilmiştir.';
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=eski_sinav&layout=aday_yeter&Kimlik='.$post['kimlik'].'&yetSelect='.$post['yeterlilik'], $message);
	}
	
	function eskiSinavBirimSil(){
		$model 		 = $this->getModel('eski_sinav');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->eskiSinavBirimSil($post['bildirimId']));
	}
	
	function eskiSinavBirimTurGetir(){
		$model 		 = $this->getModel('eski_sinav');
		$post 		 = JRequest::get( 'post' );
		
		echo json_encode($model->eskiSinavBirimTurGetir($post['bildirimId']));
	}
	
	function eskiSinavBirimUpdate(){
		$model 		 = $this->getModel('eski_sinav');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->eskiSinavBirimUpdate($post);
		if($return){
			$message = 'Adayın başarılı olduğu birim türü başarıyla değiştirilmiştir.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=eski_sinav&layout=aday_yeter&Kimlik='.$return['kimlik'].'&yetSelect='.$return['yeterlilik'], $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=eski_sinav', $message, 'error');
		}
	}
	
	function SinavaGirenVeBasariliAday(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->SinavaGirenVeBasariliAday($post);
		echo json_encode($return);
	}
	

	function degerlendiriciGetDatas() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->degerlendiriciGetDatas($post));
	}
	function sinavYeriGetDatas() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->sinavYeriGetDatas($post));
	}
	function degerlendiriciSubmitOrCancel() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		$result = $model->degerlendiriciSubmitOrCancel($post['tcno'],$post['durum']);
		echo json_encode($result);
	}
	function degerlendiriciSubmitForYeterlilik() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		$result = $model->degerlendiriciSubmitForYeterlilik($post);
		echo json_encode($result);
	}
	function saveForNewExamAdres() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->saveForNewExamAdres($post));
	}
	
	function confirmForNewExamAdres() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->confirmForNewExamAdres($post['yerid'],$post['status']));
	}
	function getExamAdres() {
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->getExamAdres($post['yerid']));
	}
	function sinavYeriOnayla(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->sinavYeriOnayla($post));
	}
	
	function ajaxYetRevizyonVarMi(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->ajaxYetRevizyonVarMi($post['yetId']);
		echo json_encode($return);
	}
	
	function getAjaxYbKod(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->getAjaxYbKod($post['kurulus']);
		echo json_encode($return);
	}
	
	function getAjaxYets(){
		$model 		 = $this->getModel('belgelendirme_islemleri');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->getYeterlilikwithYeterlilikId($post['yetId']);
		echo json_encode($return);
	}
	
	function BelgeDuzenleKaydet(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeDuzenleKaydet($post);
		if($return){
			$message = 'Belge Edit işlemi başarıyla gerçekleştirildi.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=belge_olusturma&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=belge_olusturma&layout=belge_duzenleme&belgeNo='.urlencode($post['belgeNo']), $message, 'error');
		}
	}
	
	function sinavDekontGetir(){
		$model 		 = $this->getModel('dekont');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->sinavDekontGetir($post['sinav_id']);
		echo json_encode($return);
	}
	
	function BelgeAdayBilgisi(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeAdayBilgisi($post);
		echo json_encode($return);
	}
	
	function BelgeAdayBilgisiGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeAdayBilgisiGuncelle($post);
		echo json_encode($return);
	}
	
	function BelgeImzaYetkilisiGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get('post');
		
		$return = $model->BelgeImzaYetkilisiGuncelle($post);
		if($return){
			$message = 'Belge İmza Yetkili edit işlemi başarıyla gerçekleştirildi.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($post['belgeNo']), $message, 'error');
		}
	}
	
	function BelgeYetBilgisi(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeYetBilgisi($post);
		echo json_encode($return);
	}
	
	function BelgeYeterlilikBilgisiGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		
		$return = $model->BelgeYeterlilikBilgisiGuncelle($post);
		echo json_encode($return);
	}
	
	function BelgeKurBilgisi(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
	
		$return = $model->BelgeKurBilgisi($post);
		echo json_encode($return);
	}
	
	function BelgeKurulusBilgisiGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
	
		$return = $model->BelgeKurulusBilgisiGuncelle($post);
		echo json_encode($return);
	}
	
	function BelgeBelgeNoGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get('post');
		
		$return = $model->BelgeBelgeNoGuncelle($post);
		if($return){
			$message = 'Belge Numarası Onay İçin Dosya Sorumlusuna Gönderildi.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($post['belgeNo']), $message, 'error');
		}
	}
	
	function BelgeTarihGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get('post');
	
		$return = $model->BelgeTarihGuncelle($post);
		if($return){
			$message = 'Belge Tarih Bilgileri edit işlemi başarıyla gerçekleştirildi.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($post['belgeNo']), $message, 'error');
		}
	}
	
	function BelgeDurumGuncelle(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get('post');
		
		$return = $model->BelgeDurumGuncelle($post);
		if($return){
			$message = 'Belge Durumu edit işlemi başarıyla gerçekleştirildi.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($post['belgeNo']), $message, 'error');
		}
	}
	
	function BelgeNoEditKontrol(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get('post');
		
		$return = $model->BelgeNoKontrol($post);
		echo json_encode($return);
	}
	
	function BelgeTekrarBas(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$return = $model->BelgeTekrarBas($post,$files);
		if($return['durum']){
			if($aut2 || $aut3){
				$this->setRedirect('index.php?option=com_belgelendirme&view=belge_olusturma&layout=sinav_belgeleri', $return['message']);
			}else{
				$this->setRedirect('index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=belgewithbelgeno', $return['message']);
			}
			
		}else{
			$message = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
			$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return['belgeNo']), $return['message'], 'error');
		}
	}
	
	function TekrarBasimBilgi(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->TekrarBasimBilgi($post);
		echo json_encode($return);
	}
	
	function BelgeBasimaGonder(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->BelgeBasimaGonder($post);
		echo json_encode($return);
	}
	
	function BelgeBasimIptal(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->BelgeBasimIptal($post);
		echo json_encode($return);
	}
	
	function BasimdaBelgeVarMi(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->BasimdaBelgeVarMi($post);
		echo json_encode($return);
	}
	
	function BelgeBasariliBirim(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->BelgeBasariliBirim($post);
		echo json_encode($return);
	}
	
	function EskiBelgeBirimKaydet(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->EskiBelgeBirimKaydet($post);
		$message = 'Birimler Başarıyla Kaydedildi.';
		$this->setRedirect('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($return), $message);
	}
	
	function BelgeBasariliBirimOnayla(){
		$model 		 = $this->getModel('belge_edit');
		$post 		 = JRequest::get( 'post' );
		$return = $model->BelgeBasariliBirimOnayla($post);
		echo json_encode($return);
	}

	function sinavYeriGetirEdit() {
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->sinavYeriGetirEdit($post);
		echo json_encode($return);
	}
	
	function SinavYeriYeterlilikUygunlukSozlesmeFormuEkle(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$returns = $model->SinavYeriYeterlilikUygunlukSozlesmeFormuEkle($post);
		
		foreach ($returns as $return){
			$message = $return['MESSAGE']."<br/>";
		}
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_sinav_yeri', $return);
	}
	
	function sozlemeUygunlukFormu(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->sozlemeUygunlukFormu($post);
		
		echo json_encode($return);
	}
	function degerlendiriciOlcutKarsilamaDetay(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->degerlendiriciOlcutKarsilamaDetay($post);
		
		echo json_encode($return);
	}
	
	function degelerdiriciOlcutKarsilamaKaydet(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->degelerdiriciOlcutKarsilamaKaydet($post);
		
		$this->setRedirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_degerlendirici', $return);	
	}
	
	function getYeterlilikDegelendiriciOlcut(){
		
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->getYeterlilikDegelendiriciOlcut($post);
		
		echo json_encode($return);
	}
	
	function degerlendiriciYeterlilikDetay(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->degerlendiriciYeterlilikDetay($post);
		
		echo json_encode($return);
	}
	function basvuruReddet(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->basvuruReddet($post);
		
		echo json_encode($return);
	}
	function BelgeSinavMerkezleriGetirWithBasvuruId(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->BelgeSinavMerkezleriGetirWithBasvuruId($post);
		
		echo json_encode($return);
	}
	
	function GetTesvikSayilariWithBasvuruId(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->GetTesvikSayilariWithBasvuruId($post);
		
		echo json_encode($return);
	}
	function checkBelgeNo(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->checkBelgeNo($post);
		
		echo json_encode($return);
	}
	
	function BelgeNoEditMi(){
		$model  = $this->getModel('belge_edit');
		$post   = JRequest::get( 'post' );
		$return = $model->BelgeNoEditMi($post);
		
		echo json_encode($return);
	}
	
	function BelgeNoGuncelleOnay(){
		$model  = $this->getModel('belge_edit');
		$post   = JRequest::get( 'post' );
		$return = $model->BelgeNoGuncelleOnay($post);
		
		echo json_encode($return);
	}
	
	function BelgeTarihEditMi(){
		$model  = $this->getModel('belge_edit');
		$post   = JRequest::get( 'post' );
		$return = $model->BelgeTarihEditMi($post);
	
		echo json_encode($return);
	}
	
	function BelgeTarihiGuncelleOnay(){
		$model  = $this->getModel('belge_edit');
		$post   = JRequest::get( 'post' );
		$return = $model->BelgeTarihiGuncelleOnay($post);
	
		echo json_encode($return);
	}
	
	function DezFileYukle(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$files   = JRequest::get( 'files' );
		$return = $model->DezFileYukle($post,$files);
		
		echo json_encode($return);
	}
	
	function DezFileSil(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->DezFileSil($post);
		
		echo json_encode($return);
	}
	
	function GetDezFile(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->GetDezFile($post);
		
		echo json_encode($return);
	}
	
	function ABHibeBasvuruFileVarMi(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->ABHibeBasvuruFileVarMi($post);
		
		echo json_encode($return);
	}
	
	function ABHibeBasvuruFileYukle(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$files   = JRequest::get( 'files' );
		$return = $model->ABHibeBasvuruFileYukle($post,$files);
		
		echo json_encode($return);
	}
	
	function ABHibeBasvuruFileSil(){
		$model  = $this->getModel('belgelendirme_islemleri');
		$post   = JRequest::get( 'post' );
		$return = $model->ABHibeBasvuruFileSil($post);
		
		echo json_encode($return);
	}

    function AjaxGetSinavIli(){
        $model  = $this->getModel('belgelendirme_islemleri');
        $post   = JRequest::get( 'post' );
        $return = $model->AjaxGetSinavIli($post);

        echo json_encode($return);
    }

    function AjaxSinavIliKaydet(){
        $model  = $this->getModel('belgelendirme_islemleri');
        $post   = JRequest::get( 'post' );
        $return = $model->AjaxSinavIliKaydet($post);

        echo json_encode($return);
    }
	
	function display() {
		parent::display();
	}
}