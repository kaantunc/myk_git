<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Yeterlilik_BasvurViewYeterlilik_Basvur extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		$group_id   = T2_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$autKurulus = FormFactory::checkAuthorization  ($user, $group_id);
		$autSS = FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
		
		$this->assignRef('ssyetkili', $autSS);
		$aut = $autKurulus || $autSS;
		if (!$aut)
			$mainframe->redirect('index.php?', $message);
		
		
		$pdf = 0;
		if ($layout == "tum_basvuru")
			$pdf = 1;

		$this->assignRef('belgebasvurular', $model->getBelgeBasvurular($user_id));
		
		$pages		= $model->pages;
		$pageNames	= $model->pageNames;
		$title 		= $model->title;
// 		$evrak_id = $_GET['evrak_id'];
// 		if ($evrak_id==""){
// 			if($_POST[evrak_id]!=""){
// 				$evrak_id=$_POST[evrak_id];
// 			} else {
// 				$evrak_id 	 = FormFactory::getCurrentEvrakId ($post, T2_BASVURU_TIP, $user);
// 			}
// 		}

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
		
		$pageTree	= FormFactory::getPageTree ($user, $layout, $evrak_id, $pages, $pageNames); 
		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		
		if($autKurulus==false)//yani sektör sorumlusu girdiği için kurulus kontrolu false
			$user_id = $basvuru['USER_ID'];
		
		
		
		$kurulus 	= FormFactory::getKurulusValues($user_id);	
		$iller	 	= FormFactory::getKurulusIlValues ($user_id, $pdf);
		$irtibat	= FormFactory::getIrtibatValues ($evrak_id);
		$sektor		= FormFactory::getSektorValues ($evrak_id);
		$faaliyet	= FormFactory::getFaaliyetValues ($evrak_id);			
		$birlikteKurulus = FormFactory::getBirlikteKurulusValues ($evrak_id);	
		$yeterlilik		 = $model->getYeterlilikValues ($evrak_id);
		$yeterlilikTum	 = $model->getYeterlilikPdfValues ($evrak_id);
		$personel 	= FormFactory::getPersonelValues ($evrak_id);			
		$egitim 	= FormFactory::getEgitimValues ($evrak_id);			
		$sertifika 	= FormFactory::getSertifikaValues ($evrak_id);			
		$isDeneyim 	= FormFactory::getIsDeneyimValues ($evrak_id);			
		$dil 		= FormFactory::getDilValues ($evrak_id);
		$akreditasyon = $model->getAkreditasyonValues ($evrak_id);
		$ekler		= FormFactory::getBasvuruEkValues ($evrak_id);

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_meslek_standart = FormParametrik::getMeslekStandart ();

		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $evrak_id);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		$this->assignRef('evrak_id'	, $evrak_id);
		//1. Kurulus Bilgi
		$this->assignRef('kurulus'	, $kurulus);
		$this->assignRef('iller'	, $iller);
		
		//2. Irtibat
		$this->assignRef('irtibat'	, $irtibat);
		
		//3. Faaliyet
		$this->assignRef('sektor'	, $sektor);
		$this->assignRef('faaliyet'	, $faaliyet);
		$this->assignRef('birlikteKurulus'	, $birlikteKurulus);
		$this->assignRef('akreditasyon'	, $akreditasyon);
		
		//4. Kapsam
		$this->assignRef('yeterlilik', $yeterlilik);
		$this->assignRef('yeterlilikTum', $yeterlilikTum);
		$this->assignRef('ekler'	 , $ekler);
		
		//5. Ek
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		$this->assignRef('pm_il'			 , $pm_il);
		$this->assignRef('pm_kurulus_statu'  , $pm_kurulus_statu);
		$this->assignRef('pm_faaliyet_sure'  , $pm_faaliyet_sure);
		$this->assignRef('pm_sektor'		 , $pm_sektor);
		$this->assignRef('pm_seviye'		 , $pm_seviye);
		$this->assignRef('pm_meslek_standart', $pm_meslek_standart);

		parent::display($tpl);		
	}	
}
?>
