<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();

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

/**
 * Finans Component Controller
 */
class FinansController extends JController {
	
    function display() {
    	$this->authenticationCheckAccordingToLayouts();
    	
        parent::display();
    }
    
    function tarifeDonemiKaydet()
    {
    	global $mainframe;
    
    	$model = $this->getModel();
    	 
    	if($_POST['donem_id']=='')
    		$model->tarifeDonemiKaydet();
    	else
    		$model->tarifeDonemiDuzenle($_POST['donem_id']);
    	
    	$mainframe->redirect('index.php?option=com_finans&layout=tarife_donemi_listele');
    }
    
	function ajaxKurulusFinansalBilgileriGetir()
    {
    	$model = $this->getModel();
    	$user_id = $_GET['user_id'];
    	$model->ajaxKurulusFinansalBilgileriGetir($user_id);
    }
    function ajaxDekontEkle()
    {
    	$model = $this->getModel();
    	$model->ajaxDekontEkle();
    }
    function ajaxDekontSil()
    {
    	$model = $this->getModel();
    	$model->ajaxDekontSil();
    }
    function kurulusFinansalBilgileriKaydet()
    {
    	global $mainframe;
    	
    	$model = $this->getModel();
    	$errorText = '';
    	$result = $model->kurulusFinansalBilgileriKaydet($errorText);
    	 
    	if($result==false)
    		$mainframe->redirect('index.php?option=com_finans&layout=kurulus_finansal_bilgileri&uid='.$_POST['user_id'], "Hatayla Karşılaşıldı - ".$errorText, "error");
    	else
    		$mainframe->redirect('index.php?option=com_finans&layout=kurulus_finansal_bilgileri&uid='.$_POST['user_id']);
    	 
    }
    function authenticationCheckAccordingToLayouts()
    {
    	global $mainframe;
    
    	$user = & JFactory::getUser();
    	$userId = $user->getOracleUserId();
    
    	if(	$_GET['layout']=='tarife_donemi_listele' ||
    		$_GET['layout']=='tarife_donemi')
    	{
    		//PUBLIC PAGE
    	}
    	else 
    	{
    		if($user->id == null)
    		$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
    	}	 
    	
    	$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
    	$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
    	$adminMi = FormFactory::checkAclGroupId ($user->id, YONETICI_GROUP_ID);
    	 
    	// MESLEK STANDARDI SEKTOR SORUMLUSU
/*    	switch($_GET['layout'])
    	{
    		case '':
    		case 'denetimlerim':
    			if($user==null )//login olmuşlar görecek
    				$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
    			break;
    	}
*/    
    }
}
?>