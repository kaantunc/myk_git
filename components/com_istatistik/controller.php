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
//$document->addScript( SITE_URL.'/components/com_belgelendirme/js/jquery.lingsTooltip.js' );
//$document->addStyleSheet( SITE_URL.'/components/com_belgelendirme/css/tooltip.css' );
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

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

class IstatistikController extends JController { 
	
    function program_kaydet(){
        $model = $this->getModel('istatistik');
        $post = JRequest::get( 'post' );
        $message = $model->ProgramKaydet ($post);

        $this->setRedirect('index.php?option=com_belgelendirme&view=istatistik&layout=default', $message);
    }
    
    function savestatistics(){
    	$model = $this->getModel('istatistik');
    	$post = JRequest::get( 'post' );
    	$return = $model->savestatistics ($post);
    	
    	if($return){
    		$message = "Belirtmiş olduğunuz istatistik değerleri başarıyla kaydedildi !";
    	}else{
    		$message = "Belirtmiş olduğunuz istatistik değerleri başarıyla kaydedilirken hata oluştu !";
    	}
    	$this->setRedirect('index.php?option=com_istatistik&view=istatistik&layout='.JRequest::getVar ("layout"), $message);
    }
                
    function display() {
        parent::display();
    }
}