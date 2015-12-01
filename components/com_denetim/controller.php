<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/functions.php');
require_once('libraries/tcpdf-new/tcpdf.php');

jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/templates/paradigm_shift/js/jquery.validate.min.js' );


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
//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/datatables_bootstrap.css' );

//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

//font-awesome
$document->addStyleSheet( SITE_URL.'/includes/fa/css/font-awesome.min.css');

// ktstyle *** Kaan TUNC
$document->addStyleSheet( SITE_URL.'media/system/css/ktstyle.css' );

class DenetimController extends JController {
	
	function display() {
		
		// AUTHENTICATION CHECK
		$this->authenticationCheckAccordingToLayouts();
		
		$denetim_id = $_REQUEST['denetim_id'];
		if(strlen($denetim_id)>0)//eğer denetim_id = X gibisinden bişey varsa onun doğruluğuna bak
		{
			global $mainframe;
			$model = $this->getModel();
			if($model->isDenetimValid($denetim_id)!=true)
				$mainframe->redirect('index.php?option=com_denetim&layout=denetim_listele', "Böyle bir denetim kayitli değil");
		}	
		parent::display();
	}
	
	function ajaxSaveDisUzman(){
		global $mainframe;
		
		$model = $this->getModel();
		$model->ajaxSaveDisUzman();
	}
	
	function ajaxDelDisUzman(){
		global $mainframe;
		
		$model = $this->getModel();
		$model->ajaxDelDisUzman();
	}
	
	function ajaxGetDisUzman(){
		global $mainframe;
		
		$model = $this->getModel();
		$model->ajaxGetDisUzman();
	}
	
	function ajaxUpdateDisUzman(){
		global $mainframe;
		
		$model = $this->getModel();
		$model->ajaxUpdateDisUzman();
	}
	
	function ajaxGetDisUzmanRols(){
		global $mainframe;
		
		$model = $this->getModel();
		$model->ajaxGetDisUzmanRols();
	}
	
	function denetim_kaydet()
	{
		global $mainframe;
		$denetim_id = $_REQUEST['denetim_id'];
		$model = $this->getModel();
		$model->denetim_kaydet($denetim_id);
		
		
	}
	
	function ekip_kaydet()
	{
		global $mainframe;
		
		$model = $this->getModel();
		$model->ekip_kaydet();
		$mainframe->redirect( "index.php?option=com_denetim&layout=denetim_listele" , "Başarıyla kaydedildi");
	}
	
	function raporKaydet()
	{
		$model = $this->getModel();
		$dosyaAdi = $_REQUEST['dosya'][0];
		$denetim_id = $_REQUEST['denetim_id'];
		$post 		 = JRequest::get( 'post' );
// 		$result = $model->raporKaydet($dosyaAdi, $denetim_id);
		$result = $model->raporKaydet($post, $denetim_id);
		
		global $mainframe;
		if($result == true)
			$mainframe->redirect("index.php?option=com_denetim&layout=rapor_aktar&denetim_id=".$denetim_id, "Başarıyla kaydedildi");
		else
			$mainframe->redirect("index.php?option=com_denetim&layout=rapor_aktar&denetim_id=".$denetim_id, "Hata oluştu", 'error');
		
			
	}
	
	function DenetimRaporOnayla(){
		$model = $this->getModel();
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->DenetimRaporOnayla($post['denetim_id']));
	}
	
	function DenetimRaporOnayIptal(){
		$model = $this->getModel();
		$post 		 = JRequest::get( 'post' );
		echo json_encode($model->DenetimRaporOnayIptal($post['denetim_id']));
	}
	
	function uygunsuzlukKaydet()
	{
		global $mainframe;
		
		$model = $this->getModel();
		
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$denetciMi = FormFactory::buIDDenetciMi($userId);
		$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
		$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
		if(!empty($_POST['uygunsuzluk_id'])){
			$uygunsuzluk_id = $_POST['uygunsuzluk_id'];
			$sayfaYon = "index.php?option=com_denetim&layout=uygunsuzluk&uygunsuzluk_id=".$uygunsuzluk_id;
		}else{
			$sayfaYon = "index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".$_POST['denetim_id'];
		}
		
		
		if($isSektorSorumlusu || $denetciMi)
			$model->uygunsuzlukKaydet_SS();
		else
			$model->uygunsuzlukKaydet();
			
			
		if($isSektorSorumlusu==true)
			$mainframe->redirect($sayfaYon, "Başarıyla kaydedildi");
		else 
			$mainframe->redirect($sayfaYon, "Başarıyla kaydedildi");
			
	}
	
	function yetkiKapsamiKaydet()
	{
		global $mainframe;
		
		$model = $this->getModel();
		$model->yetkiKapsamiKaydet();
		$mainframe->redirect("index.php?option=com_denetim&layout=yetki_kapsami&denetim_id=".$_GET['denetim_id'], "Başarıyla kaydedildi");
		
	}
	
	function togglePara()
	{
		global $mainframe;
		
		$model = $this->getModel();
		
		if($model->togglePara($_REQUEST['denetim_id'])==true)
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele");
		else
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele", "Hata oluştu", "error");
		
	}
	function yetkilendirmeyiKaydet()
	{
		global $mainframe;
		
		$model = $this->getModel();
		$model->yetkilendirmeyiKaydet();
		$mainframe->redirect("index.php?option=com_denetim&layout=yetkilendirme&denetim_id=".$_GET['denetim_id'], "Başarıyla kaydedildi");
		
	}
	
	function ajaxCheckBKYBKodlari()
	{
		$model = $this->getModel();
		
		return $model->ajaxCheckBKYBKodlari();
	}
	function kodKaydet()
	{
		global $mainframe;
	
		$model = $this->getModel();
		$model->kodKaydet();
		$mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele", "Başarıyla kaydedildi");
	
	}
	function ajaxBKKoduKullanimdaMi()
	{
		$model = $this->getModel();
		$model->ajaxBKKoduKullanimdaMi();	
	}
	function ucretTarifesiKaydet()
	{
		global $mainframe;
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$denetciMi = FormFactory::buIDDenetciMi($userId);
		$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
		$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
		
		if($denetlemesiYapilacakKurulusMu)
			$layout='denetimlerim';
		else if($isSektorSorumlusu)
			$layout='denetim_listele';
		
		
		$model = $this->getModel();
		$model->ucretTarifesiKaydet();
		$mainframe->redirect("index.php?option=com_denetim&layout=".$layout, "Başarıyla kaydedildi");
		
	}
	
	function authenticationCheckAccordingToLayouts()
	{
		global $mainframe;
		
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$denetciMi = FormFactory::buIDDenetciMi($userId);
		$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
		$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
		
		// MESLEK STANDARDI SEKTOR SORUMLUSU
		switch($_GET['layout'])
		{
			case '':
			case 'default':					//yalnızca SS
			case 'denetim_ekibi':			//yalnızca SS
			case 'denetim_listele':			//yalnızca SS
			case 'kod_duzenle':				//yalnızca SS
			case 'rapor_aktar':				//yalnızca SS
			//case 'uygunsuzluk_listele':		//yalnızca SS
			case 'yeni_denetim':			//yalnızca SS
			//case 'yetki_kapsami':			//yalnızca SS
			case 'yetkilendirme':			//yalnızca SS
				if(!$isSektorSorumlusu)
					$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
				break;
			
		
			
			case 'uygunsuzluk':
				if($this->buUygunsuzlukBuKurulusaMiAit($userId, $isSektorSorumlusu)== false)
					$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
				break;
				
			case 'denetimlerim':
				if($user==null )//login olmuşlar görecek
					$mainframe->redirect("index.php", "Bu sayfayı görmeye hakkınız yok.", 'error');
				break;	
			case 'ucret_tarifesi': 			//HERKES GOREBILIR
			break;
		}
		
	}

	function buUygunsuzlukBuKurulusaMiAit($userId, $isSektorSorumlusu)
	{
		if($isSektorSorumlusu==true)
			return true;
		else
		{
			if($_GET['uygunsuzluk_id']=='')//uygunsuzluk_id= X yazmıyorsa
				return false;
			else
			{
				$adrestekiUygunsuzlukID = $_GET['uygunsuzluk_id'];
				
				$db  = &JFactory::getOracleDBO();
				$sql = "SELECT UYGUNSUZLUK_ID, USER_ID 
						FROM      M_UYGUNSUZLUK 
						    JOIN  M_DENETIM USING (DENETIM_ID) 
						    JOIN  M_KURULUS ON (M_KURULUS.USER_ID = M_DENETIM.DENETIM_KURULUS_ID)
						WHERE UYGUNSUZLUK_ID=? AND USER_ID=?";
				
				$data = $db->prep_exec($sql, array($adrestekiUygunsuzlukID, $userId));
				
				if(count($data)==0)
					return false;
				else
					return true;
			}
			
		}
		
	}
        
        function ajaxBelgeBasvuru(){
            global $mainframe;
		
            $model = $this->getModel();
            echo json_encode($model->getBelgeBasvuru());
        }
        
        function uygunsuzlukSil(){
        	$model 		 = $this->getModel();
        	$post 		 = JRequest::get( 'post' );
        	
        	echo json_encode($model->uygunsuzlukSil($post));
        }
	
	function getDenetimEkibi(){
		$model 		 = $this->getModel();
		$post 		 = JRequest::get( 'post' );
		 
		echo json_encode($model->denetimEkibiDenetimId($post['denetimId']));
	}
	
	function DenetimSMKaydet(){
		$model 		 = $this->getModel();
		$post 		 = JRequest::get( 'post' );
			
		$result = $model->DenetimSMKaydet($post);
		
		global $mainframe;
		if($result['hata'] == 1){
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_sinavyeri&denetim_id=".$post['dId'], $result['message'], 'error');
		}
		else{
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_sinavyeri&denetim_id=".$post['dId'], $result['message']);
		}
	}
	
	function DenetimYetKaydet(){
		$model 		 = $this->getModel();
		$post 		 = JRequest::get( 'post' );
			
		$result = $model->DenetimYetKaydet($post);
	
		global $mainframe;
		if($result['hata'] == 1){
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_yeterlilik&denetim_id=".$post['dId'], $result['message'], 'error');
		}
		else{
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_yeterlilik&denetim_id=".$post['dId'], $result['message']);
		}
	}
}

?>