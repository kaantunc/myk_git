<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
ini_set("display_errors", "1");
require_once('libraries/form/functions.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");
require_once('libraries/tcpdf-new/tcpdf.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_yeterlilik_taslak_yeni/js/yeterlilik_taslak.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$document->addScript (SITE_URL.'/templates/elegance/js/jquery.collapsible.js');
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');


$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js' );

////////////////////////////////////////////////////////////////////////////////////////////////
$document = &JFactory::getDocument();
// $document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
// $document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
// $document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
// $document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addStyleSheet( SITE_URL.'components/com_yeterlilik_taslak_yeni/assets/yeterlilik_taslak_yeni.css' );
//$document->addScript( SITE_URL.'components/com_protokol/assets/protokol.js' );

$document->addStyleSheet( SITE_URL.'/includes/js/smartspinner/smartspinner.js' );

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
// $document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/editable-table.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/DT_bootstrap.js');
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );
//jQueryCookie
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/development-bundle/external/jquery.cookie.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');


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

class Scheduled_TasksController extends JController { 
	
	function getScheduledTaskById(){
		$model 	= $this->getModel('scheduled_tasks');
		$post 	= JRequest::get( 'post' );
		$data   = $model->getScheduledTaskById($post['taskid']);
		
		echo json_encode($data);
	}
	
	function addScheduledTask(){
		
		$model 	= $this->getModel('scheduled_tasks');
		$post 	= JRequest::get( 'post' );
		$return = $model->addScheduledTask($post);
		
		echo json_encode($return);
	}
	
	function editScheduledTask(){
		$model 	= $this->getModel('scheduled_tasks');
		$post 	= JRequest::get( 'post' );
		$return = $model->editScheduledTask($post);
		
		echo json_encode($return);
	}
	
	function deleteScheduledTaskById(){
		
		$model 	= $this->getModel('scheduled_tasks');
		$post 	= JRequest::get( 'post' );
		$return = $model->deleteScheduledTaskById($post['taskid']);
		
		echo json_encode($return);
	}
	
	function changeTaskStatus(){
		
		$model 	= $this->getModel('scheduled_tasks');
		$post 	= JRequest::get( 'post' );
		$return = $model->changeTaskStatus($post['taskid'],$post['status']);
		
		echo json_encode($return);
	}
	
	function akibetoku(){
		
		$model 	= $this->getModel('scheduled_tasks');
		$return = $model->readFromZiraatTxt();
		
	
	}
	function display() {
		parent::display();
	}
}