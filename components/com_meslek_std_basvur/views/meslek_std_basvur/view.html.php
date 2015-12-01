<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Meslek_Std_BasvurViewMeslek_Std_Basvur extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId ();
		
		
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$autKurulus = FormFactory::checkAuthorization  ($user, T1_GROUP_ID);
		$autSS 		= FormFactory::checkAuthorization  ($user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
		$this->assignRef('ssyetkili', $autSS);
		$aut = $autKurulus || $autSS;
		
		if (!$aut)
			$mainframe->redirect('index.php?', YETKI_MESAJ);
		
	    
		
		$this->assignRef('belgebasvurular', $model->getBelgeBasvurular($user_id));
		
		$pdf = 0;
		if ($layout == "tum_basvuru")
			$pdf = 1;

		$pages			= $model->pages;
		$pageNames		= $model->pageNames;
		$title 			= $model->title;
		if(strlen($_GET['evrak_id'])>0){
			$evrak_id = $_GET['evrak_id'];
			$basvuruDurum = $model->getBasvuruDurumu($evrak_id);
			$this->assignRef('basvuruDurum', $basvuruDurum);
		}
		else
			$evrak_id		= -1;
		
		if($evrak_id != -1){
			if (!isset ($layout)){
				$layout = "kurulus_bilgi";
				$this->setLayout($layout);
			}
		}
		else{
			if (!isset ($layout) || $layout == "giris"){
				$layout = "giris";
				$this->setLayout($layout);
			}
		}
		
		if ($layout == "basvuru_yeni"){
			$this->assignRef('basvuru_durumlari'	, $model->getBasvuruDurumlari());
			if($evrak_id == "-1"){
				$this->assignRef('durum'	, $evrak_id);
			}
		}
		
			//$evrak_id		= FormFactory::getCurrentEvrakId ($_POST,T1_BASVURU_TIP, $user);
		$pageTree		= FormFactory::getPageTree ($user, $layout, $evrak_id, $pages, $pageNames); 
		$basvuru		= FormFactory::getBasvuruValues ($evrak_id);
		
		if($autKurulus==false)//yani sektör sorumlusu girdiği için ulaşılamamış
			$user_id = $basvuru['USER_ID'];
		
		
		$kurulus 		= FormFactory::getKurulusValues($user_id);	
		$iller	 		= FormFactory::getKurulusIlValues ($user_id, $pdf);
		$irtibat		= FormFactory::getIrtibatValues ($evrak_id);
		$sektor			= FormFactory::getSektorValues ($evrak_id);
		$faaliyet		= FormFactory::getFaaliyetValues ($evrak_id);			
		$bagliKurulus 	= FormFactory::getBagliKurulusValues ($evrak_id);			
		$birlikteKurulus= FormFactory::getBirlikteKurulusValues ($evrak_id);			
		$meslek 		= $model->getMeslekValues ($evrak_id);			
		$personel 		= FormFactory::getPersonelValues ($evrak_id);			
		$egitim 		= FormFactory::getEgitimValues ($evrak_id);			
		$sertifika 		= FormFactory::getSertifikaValues ($evrak_id);			
		$isDeneyim 		= FormFactory::getIsDeneyimValues ($evrak_id);			
		$dil 			= FormFactory::getDilValues ($evrak_id);
		$ekler			= FormFactory::getBasvuruEkValues ($evrak_id);

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		
		$this->assignRef('userId', $user_id);
		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $evrak_id);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		
		//1. Kurulus Bilgi
		$this->assignRef('kurulus'	, $kurulus);
		$this->assignRef('iller'	, $iller);
		
		//2. Irtibat
		$this->assignRef('irtibat'	, $irtibat);
		
		//3. Faaliyet
		$this->assignRef('sektor'	, $sektor);
		$this->assignRef('faaliyet'	, $faaliyet);
		$this->assignRef('bagliKurulus'		, $bagliKurulus);
		$this->assignRef('birlikteKurulus'	, $birlikteKurulus);
		
		//4. Kapsam
		$this->assignRef('meslek'	, $meslek);
		$this->assignRef('ekler'	, $ekler);
		
		//5. Ek
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		//Parametrik Data
		$this->assignRef('pm_il'			, $pm_il);
		$this->assignRef('pm_kurulus_statu'	, $pm_kurulus_statu);
		$this->assignRef('pm_faaliyet_sure' , $pm_faaliyet_sure);
		$this->assignRef('pm_sektor'		, $pm_sektor);
		$this->assignRef('pm_seviye'		, $pm_seviye);
		
		parent::display($tpl);		
	}	
}
?>
