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
$document->addScript( SITE_URL.'/components/com_kurulus_edit/js/kurulus_edit.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

/**
 * Rate Component Controller
 */
class Kurulus_EditController extends JController {
	
	function yeterlilikKaydet (){
		$model 		 = $this->getModel('kurulus_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$tur		 = JRequest::getVar("tur");
		$user_id	 = JRequest::getVar("id");
		$evrak_id	 = $model->getOracleEvrakId ($user_id, $tur);
		
		$message	 = $model->yeterlilikKaydet ($post, $user_id, $evrak_id);
		FormFactory::listeDurumGuncelle ($user_id, $post["editable"], YET_SEKTOR_TIPI);
		
		$this->setRedirect('index.php?option=com_kurulus_edit&layout='.$layout.'&tur='.$tur.'&id='.$user_id, $message);
	}
	
	function standartKaydet (){
		$model 		 = $this->getModel('kurulus_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$tur		 = JRequest::getVar("tur");
		$user_id	 = JRequest::getVar("id");
		$evrak_id	 = $model->getOracleEvrakId ($user_id, $tur);
		
		$message	 = $model->standartKaydet ($post, $user_id, $evrak_id);
		FormFactory::listeDurumGuncelle ($user_id, $post["editable"], MS_SEKTOR_TIPI);
		
		$this->setRedirect('index.php?option=com_kurulus_edit&layout='.$layout.'&tur='.$tur.'&id='.$user_id, $message);
	}
	
	function kurulusGuncelle (){
		$model 		 = $this->getModel('kurulus_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout		 = JRequest::getVar("layout");
		$tur		 = JRequest::getVar("tur");
		$user_id	 = JRequest::getVar("id");
		
		$message	 = $model->kurulusGuncelle ($post, $user_id);
		
		$this->setRedirect('index.php?option=com_kurulus_edit&layout='.$layout.'&tur='.$tur.'&id='.$user_id, $message);
	}
	
	function isTaslak (){
		$model	 = $this->getModel('kurulus_edit');
		$id		 = JRequest::getVar("id");
		
		echo $model->isTaslak ($id);
	}
	
	function KurulusGetir(){
		$model 		 = $this->getModel('kurulus_logo');
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->KurulusGetir($post));
	}
	
	function kurulusLogoUpdate(){
		$model 		 = $this->getModel('kurulus_logo');
		$post 		 = JRequest::get( 'post' );
		$files 		 = JRequest::get( 'files' );
		$message = $model->kurulusLogoUpdate($post,$files);
		
		$this->setRedirect('index.php?option=com_kurulus_edit&view=kurulus_logo&kurulusId='.$post['kurulusId'], $message);
	}
	
    function display() {
    	
        parent::display();
    }

}
?>