<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Akreditasyon_BasvurViewAkreditasyon_Basvur extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$group_id   = T4_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$autKurulus = FormFactory::checkAuthorization  ($user, $group_id);
		$autMS =  FormFactory::checkAuthorization  ($user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
		$autYet =  FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
		
		$aut = $autMS || $autYet || $autKurulus; 
		
		if (!$aut)
			$mainframe->redirect('index.php?', $message);
		
	    if (!isset ($layout)){
    		$layout = "kurulus_bilgi";
			$this->setLayout($layout);
		}
		
		$pdf = 0;
		if ($layout == "tum_basvuru")
			$pdf = 1;

		$pages		= $model->pages;
		$pageNames	= $model->pageNames;
		$title 		= $model->title;
		
		if(strlen($_GET['evrak_id'])>0)
			$evrak_id = $_GET['evrak_id'];
		else
			$evrak_id	= FormFactory::getCurrentEvrakId ($_POST,T4_BASVURU_TIP, $user);
		
		$pageTree	= FormFactory::getPageTree ($user, $layout, $evrak_id, $pages, $pageNames); 
		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		
		if($autKurulus==false)//yani sektör sorumlusu girdiği için ulaşılamamış
			$user_id = $basvuru['USER_ID'];
		
		
		$kurulus 	= FormFactory::getKurulusValues($user_id);	
		$iller	 	= FormFactory::getKurulusIlValues ($user_id, $pdf);
		$irtibat	= FormFactory::getIrtibatValues ($evrak_id);
		$sektor		= FormFactory::getSektorValues ($evrak_id);
		$faaliyet	= FormFactory::getFaaliyetValues ($evrak_id);					
		$birlikteKurulus = FormFactory::getBirlikteKurulusValues ($evrak_id);	
		$yetkiTalep	= $model->getYetkiTalepValues  ($evrak_id);			
		$personel 	= FormFactory::getPersonelValues ($evrak_id);			
		$egitim 	= FormFactory::getEgitimValues ($evrak_id);			
		$sertifika 	= FormFactory::getSertifikaValues ($evrak_id);			
		$isDeneyim 	= FormFactory::getIsDeneyimValues ($evrak_id);			
		$dil 		= FormFactory::getDilValues ($evrak_id);
		$basvuru_ekleri = $model->getBasvuruEkleri($user_id);
		$basvuru_ekleri_tur = $model->getBasvuruEkleriBelgeTuru($user_id);
		
		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_yeterlilik_ad = FormParametrik::getYeterlilikAd ();

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
		$this->assignRef('birlikteKurulus'	, $birlikteKurulus);
		$this->assignRef('yetkiTalep'	, $yetkiTalep);
		
		//4. Ek
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		//5. Basvuru Ekleri
		$this->assignRef('basvuru_ekleri', $basvuru_ekleri);
		$this->assignRef('turler', $basvuru_ekleri_tur);
		
		//Parametrik Data
		$this->assignRef('pm_il'			, $pm_il);
		$this->assignRef('pm_kurulus_statu'	, $pm_kurulus_statu);
		$this->assignRef('pm_faaliyet_sure' , $pm_faaliyet_sure);
		$this->assignRef('pm_sektor'		, $pm_sektor);
		$this->assignRef('pm_seviye'		, $pm_seviye);
		$this->assignRef('pm_yeterlilik_ad' , $pm_yeterlilik_ad);	

		parent::display($tpl);		
	}	
}
?>
