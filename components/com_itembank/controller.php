<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

$document->addScript( SITE_URL.'components/com_itembank/js/sorugirisi.js' );
$document->addScript( SITE_URL.'components/com_itembank/js/sorulari_listele.js' );

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

require_once('libraries/form/functions.php');

/**
 * Admin Component Controller
 */


class ItembankController extends JController {
	
    function display() {    
    	if($_GET['view']==	'sorulari_listele')
    	{
    		$view=$this->getView('sorulari_listele','html');
			$view->setModel($this->getModel('sorugirisi'));
    	}
    	parent::display();
    }
    
	function getSeviye(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getSeviye ();			
	}	
	function getYeterlilikler(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getYeterlililer ();			
	}	
	function getBirimler(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getBirimler ();			
	}	
	function getBilgi(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getBilgiBeceriYetkinlik (0);			
	}	
	function getBeceri(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getBilgiBeceriYetkinlik (1);			
	}	
	function getYetkinlik(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getBilgiBeceriYetkinlik (2);			
	}	
	function getOgrenmeCiktisi(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getOgrenmeCiktisi ();			
	}	
	function getBasarimOlcutu(){
			$model 		 	= $this->getModel('sorugirisi');
			$message	 	= $model->getBasarimOlcutu ();			
	}	
	function soruKaydet(){
			$model 		 	= $this->getModel('sorugirisi');
			if ($_POST["soru_id"]==""){
				$message	 	= $model->soruKaydet ();
			} else {
				$message	 	= $model->soruGuncelle ();
			}			
	}	
	function soruGoster(){
		$model 		 	= $this->getModel('sorulari_listele');
		if ($_GET["soru_id"]==""){
			return $model->soruGoster($_GET["soru_id"]);
		} else {
			return '';
		}
	}
	function ajaxSoruGoster(){
		$model 		 	= $this->getModel('sorulari_listele');
		if ($_GET["soru_id"]==""){
			ajax_success_response($model->soruGoster($_GET["soru_id"]));
		} else {
			ajax_error_response(''); 
		}
	}
	function ara(){
			$model 		 	= $this->getModel('sorulari_listele');
			$message	 	= $model->ara ();			
	}	
	function secilenleriSil(){
			$model 		 	= $this->getModel('sorulari_listele');
			$message	 	= $model->secilenleriSil ();			
	}	
	function durumDegistir(){
			$model 		 	= $this->getModel('sorulari_listele');
			$message	 	= $model->durumDegistir ();			
	}	
}

?>