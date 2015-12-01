<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );

$document->addScript( SITE_URL.'components/com_yetkilendirme_yet/assets/yetkilendirme_yet.js' );

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


$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/editable-table.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/DT_bootstrap.js');
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );

$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');


require_once('libraries/form/functions.php');

/**
 * Admin Component Controller
 */
class AdminController extends JController {
	
    function display() {    	
        parent::display();
    }
    
	function yonetimKaydet(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=yonetim&etkin='.$_REQUEST["etkin"];
		$message	 	= $model->yonetimKaydet ($post);		
		$this->setRedirect($redirectLink, $message);
	}

	function genelKurulKaydet(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=genelkurul';
		$message	 	= $model->genelKurulKaydet ($post);		
		$this->setRedirect($redirectLink, $message);
	}

	function komiteKaydet(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=komite&sektorId='.$_REQUEST["sektorId"];
		$message	 	= $model->komiteKaydet ($post);		
		$this->setRedirect($redirectLink, $message);
	}

	function yetkiKaydet(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorSorumlusuYetki';
		$message	 	= $model->yetkiKaydet ($post);		
		$this->setRedirect($redirectLink, $message);
	}

	function sektorDurumGuncelle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorIslemleri';	
		$message	 	= $model->sektorDurumGuncelle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function sektorEkle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorIslemleri';	
		$message	 	= $model->sektorEkle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function sektorSorumlusuGuncelle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorSorumlusu';	
		$message	 	= $model->sektorSorumlusuGuncelle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function sektorSorumlusuEkle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorSorumlusu';	
		$message	 	= $model->sektorSorumlusuEkle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function itemBankUsersGuncelle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=itemBankKullanicilari';	
		$message	 	= $model->itemBankUsersGuncelle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function itemBankUsersEkle(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=itemBankKullanicilari';	
		$message	 	= $model->itemBankUsersEkle ($post);	
		$this->setRedirect($redirectLink, $message);
	}
	
	function kurulusaGorevlendir(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=sektorSorumlusuGorev&kurulus='.$post['kurs'];
		$message	 	= $model->kurulusaGorevlendir ($post);
		$this->setRedirect($redirectLink, $message);
	}
	
	function getUserByGroup(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$data	 		= $model->getUserByGroup ($post['userGroup']);
		echo json_encode($data);
	}
	
	function tesvikOnayKomitesiKaydet(){
		$model 		 	= $this->getModel('admin');
		$post 		 	= JRequest::get( 'post' );
		$redirectLink	= 'index.php?option=com_admin&layout=tesvikonaykomitesi';
		$message	 	= $model->tesvikOnayKomitesiKaydet ($post);
		$this->setRedirect($redirectLink, $message);
	}
}

?>