<?php

// Check to ensure this file is included in Joomla!
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

/**
 * Rate Component Controller
 */
class SinavController extends JController {
	
	function sinavOncedenVarmi(){
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
		$post = JRequest::get( 'post' );
		$message = $model->getsinavOncedenVarmi($db, $post);
	}
	
	function DegerlendiriciAl(){
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
		$post = JRequest::get( 'post' );
		$message = $model->getDegerlendirici($db, $post);
	}
	
	function sinavOncesiBirimAl(){
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
        $post = JRequest::get( 'post' );
        $message = $model->getSinavBirimleri($db, $post);
	}
	
	function sinavInceleBirimAl(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi_incele');
		$post = JRequest::get( 'post' );
		$message = $model->getSinavBirimleri($db, $post);
	}
	
	function sinavOncesiMerkezAl(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
		$post = JRequest::get( 'post' );
		$message = $model->getSinavOncesiMerkezler($db, $post);
	}
	
	function sinavOncesiAltBirim(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
		$post = JRequest::get( 'post' );
		$message = $model->getSinavOncesiAltBirimler($db, $post);
	}
	
	function sinavOncesiTarihAl(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
		$post = JRequest::get( 'post' );
		$message = $model->getSinavOncesiTarihler($db, $post);
	}
	
	function merkezYeterlilik(){
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
        $post = JRequest::get( 'post' );
        $message = $model->getMerkezYeterlilikler($db, $post);
	}
	
	function Yeterlilikmerkez(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		$post = JRequest::get( 'post' );
		$message = $model->getYeterlilikMerkezler($db, $post);
	}
	
	function YeterlilikAltBirim(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		$post = JRequest::get( 'post' );
		$message = $model->getYeterlilikAltBirimler($db, $post);
	}
	
	function KayitliYeterlilikAltBirim(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		$post = JRequest::get( 'post' );
		$message = $model->getKayitliYeterlilikAltBirimler($db, $post);
	}
	
	function SinavSecBirimler(){
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_sec');
		$post = JRequest::get( 'post' );
		$message = $model->getSinavSecBirimler($db, $post);
	}
	
	function SonucGuncelle(){
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sonuc_kaydet');
		$post = JRequest::get( 'post' );
		$message = $model->SonucGuncelle($db, $post);
	}
	
	function merkezeGoreSinavTarihleri(){
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		$post = JRequest::get( 'post' );
		$message = $model->getMerkezeGoreTarihler($db, $post);
	}
	
	function sertifikaBasvur(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sertifika');
        $post = JRequest::get( 'post' );
        
        if(!$model->sinavSecildimi($db, $post))
        	$this->setRedirect('index.php?option=com_sinav&amp;view=sinav_sec' ,
        			JText::_('SINAV_SECILMEDI'),
        			"error");
        
        if($model->yeterlilikCeliskilimi($db, $post))
        	$this->setRedirect('index.php?option=com_sinav&amp;view=sinav_sec' ,
        			JText::_('YETERLILIK_CELISKI'),
        			"error");
        
		JRequest::setVar('view', 'sertifika');
		JRequest::setVar('post', $post);
		$this->display();
	}
	
//	function sertifikaKaydet(){
//		
//		$db = & JFactory::getOracleDBO();
//		$model = $this->getModel('sertifika');
//        $post = JRequest::get( 'post' );
//        $message = $model->sertifikaKaydet($db, $post);
//		
//		$this->setRedirect('index.php?option=com_sinav&view=sinav_sec' , $message);
//	}
	
	function sertifikaKaydet(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sertifika');
		
		$session =&JFactory::getSession();
		$post = $session->get('sertifikaPdfPostData');
		$sinavIds = $session->get('sinavIds');
		
		//$session =&JFactory::getSession();
		//$session->clear('tumSonuclar');
		//$session->clear('ogrenciler');
		//$session->clear('sinavIds');
		
		
       // $post = JRequest::get( 'post' );
        $message = $model->sertifikaKaydet($db, $post, $sinavIds);
		//die();
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav&amp;layout=sertifikaPdfLink' , $message);
	}
	
	function kapsamAl(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('kapsam_al');
        $post = JRequest::get( 'post' );
        $message = $model->getKapsamlar($db, $post);
		
	}
	
	/*function pratikKaydet(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sonuc_kaydet');
        $post = JRequest::get( 'post' );
        $message = $model->pratikKaydet($db, $post);
        
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav_sec' , $message);
	}
	
	function teorikKaydet(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sonuc_kaydet');
        $post = JRequest::get( 'post' );
        $message = $model->teorikKaydet($db, $post);
		
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav_sec' , $message);
	}*/
	
	function SinavSonucuKaydet(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sonuc_kaydet');
		$post = JRequest::get( 'post' );
		$message = $model->SinavSonucuKaydet($db, $post);
	
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav_sec' , $message);
	}
	
	function sinavSonucuGir(){
		JRequest::setVar('view', 'sinav_sonucu_gir');
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_sonucu_gir');
		
		$get = JRequest::get( 'get' );
		
		$sinavSekli = $model->getSinavSekli($db, $get);
		$sinavId = JRequest::getVar( 'sinavId' );
		$sinavTuru = $model->getSinavTuru($db, $get);
		
		if($sinavSekli == -1 || $sinavTuru == -1){
			$this->setRedirect('index.php' , JText::_('EVRAK_YETKI_HATASI'), "error");
		}
		
		JRequest::setVar('sinav_turu', $sinavTuru);
		JRequest::setVar('sinavId', $sinavId);
		
		//$sinavSekli = JRequest::getVar( 'sinav_sekli' );
	
		if($sinavSekli == TEORIK_SINAV_ID)
			JRequest::setVar('layout', 'teorik');
		else if ($sinavSekli == PRATIK_SINAV_ID)
			JRequest::setVar('layout', 'pratik');
		
        //JRequest::setVar('layout', 'pratik');
       // JRequest::setVar('layout', $sinavSekli);
       parent::display();
	}
	
	function ucretTarifesiKaydet(){
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
	
		$model = $this->getModel('sinav_ucret_tarife');
		$model->ucretTarifesiKaydet();
		$mainframe->redirect("index.php?option=com_sinav&amp;view=sinav_ucret_tarife", "Başarıyla kaydedildi");
	}
	
	function ucretTarifesiAra(){
		global $mainframe;
		
		$model = $this->getModel('sinav_ucret_tarife_ara');
		$message = $model->ucretTarifesiAra();
		//JRequest::setVar('view', 'sinav_ucret_tarife_ara');
		//$mainframe->redirect("index.php?option=com_sinav&view=sinav_ucret_tarife_ara", $message);
	}
	
	function yetkiYeterlilikAra(){
		global $mainframe;
	
		$model = $this->getModel('sinav_yetki_yeterlilik_ara');
		$message = $model->yetkiYeterlilikAra();
		//JRequest::setVar('view', 'sinav_ucret_tarife_ara');
		//$mainframe->redirect("index.php?option=com_sinav&view=sinav_ucret_tarife_ara", $message);
	}
	
	function genelBilgiler(){
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('genel_bilgiler_gir');
        $post = JRequest::get( 'post' );
        $message = $model->getKapsamlar($db, $post);		
		
	}
	
	function checkOgr(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
        $post = JRequest::get( 'post' );
        $message = $model->checkOgr($db, $post);	
		
	}
	
	function sinavOncesiKaydet(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi');
        //$post = JRequest::get( 'post' );
        
		$session =&JFactory::getSession();
		$post = $session->get('sinavOncesiPostData');
        
        $message = $model->sinavKaydet($db, $post);
        
        $this->setRedirect('index.php?option=com_sinav&amp;view=sinav&amp;layout=sinavOncesiPdfLink' , $message);
		
	}
	
	function sinavOncesiInceleKaydet(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sinav_oncesi_incele');
		//$post = JRequest::get( 'post' );
	
		$session =&JFactory::getSession();
		$post = $session->get('sinavOncesiPostData');
	
		$message = $model->sinavKaydet($db, $post);
	
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav&amp;layout=sinavOncesiPdfLink' , $message);
	
	}
	
	
	function sertifikaIstegiKaydet(){
	
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('sertifika');
	
		//$session =&JFactory::getSession();
		$post = JRequest::get( 'post' );
	
		$message = $model->sertifikaIstegiKaydet($db, $post);
	
		$this->setRedirect('index.php?option=com_sinav&amp;view=sinav&amp;layout=sertifikaPdfLink' , $message);
	}

	function takvimKaydet(){
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
		
        $post = JRequest::get( 'post' );
        
        $mode = JRequest::getVar( 'mode' );
        
        if($mode == 'taslak'){
        	$message = $model->takvimKaydet($db, $post, SINAV_TAKVIM_TASLAK);
        	JRequest::setVar('view', 'takvim_ozet');
        	//JRequest::set($post,'POST');
        	parent::display();
       		//$this->setRedirect('index.php?option=com_sinav&view=takvim_ozet' , $message);
        }
        else if($mode == 'kaydet'){
			$serializedPost = JRequest::getVar( 'serializedPost' );
        	$post = unserialize($serializedPost);
        	
        	$message = $model->takvimKaydet($db, $post, SINAV_TAKVIM_KAYDEDILDI);
        	//die();
        	$this->setRedirect('index.php?option=com_sinav&amp;view=sinav&amp;layout=takvimPdfLink' , $message);
        }
        
		
	}
	
	function takvimAl(){
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('takvim');
        $post = JRequest::get( 'post' );
        $mode = JRequest::getVar( 'mode' );
        
        if($mode != null)
        	$mode = SINAV_TAKVIM_TASLAK;
        else
        	$mode = SINAV_TAKVIM_KAYDEDILDI;
        
        $message = $model->takvimAl($db, $post, $mode);
		
		
	}
	
    function display() {
    	
    // sets one Standard view
    	//$this->setRedirect('index.php?'.JRequest::getCmd( 'view' ));
        if ( ! JRequest::getCmd( 'view' ) ) {
		//$this->setRedirect('index.php');
        	
       		//JRequest::setVar('view', 'sinav' );
        }
        parent::display();
    }

}
?>