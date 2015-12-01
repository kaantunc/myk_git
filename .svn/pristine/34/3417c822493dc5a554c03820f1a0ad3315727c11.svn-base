<?php
/**
 * @version		$Id: view.pdf.php 11371 2008-12-30 01:31:50Z ian $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class Belgelendirme_BasvurViewBelgelendirme_Basvur extends JView
{
	function display($tpl = null)
	{
	global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory2::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory2::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory2::checkAuthorization ($user, $group_id3);
		
		if (!$aut and !$aut2 and !$aut3)
			$mainframe->redirect('index.php?', $message);

		
		
	    if (!isset ($layout)){
    		$layout = "giris";
			$this->setLayout($layout);
		}
		
		$pdf = 0;
		if ($layout == "pdf")
			$pdf = 1;

		$pages		= $model->pages;
		$pageNames	= $model->pageNames;
		$title 		= $model->title;
		$evrak_id = $_GET['id'];
		if(!isset($evrak_id)){
			$evrak_id	= -1;
		}
		
		$pageTree	= FormFactory2::getPageTree ($user, $layout, $evrak_id, $pages, $pageNames,$user_id); 
		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
// 		$kurulus 	= FormFactory2::getKurulusValues($user_id);
// 		if(!isset($kurulus))
// 			$kurulus = 	FormFactory2::getKurulusValuesEvrak($evrak_id);
		$kurulus = $model->getKurulus($evrak_id);
		$iller	 	= FormFactory::getKurulusIlValues ($user_id, $pdf);
		if(!isset($iller[0]))
		$iller = FormFactory2::getKurulusIlValuesEvrak ($evrak_id, $pdf);
		$irtibat	= FormFactory2::getIrtibatValues ($evrak_id);
		$sektor		= FormFactory2::getSektorValues ($evrak_id);
		$faaliyet	= FormFactory2::getFaaliyetValues ($evrak_id);			
		$bagliKurulus 	 = FormFactory2::getBagliKurulusValues ($evrak_id);			
		$birlikteKurulus = FormFactory2::getBirlikteKurulusValues ($evrak_id);			
		$yetkiTalep	= $model->getYetkiTalepValues  ($evrak_id);
		$sinavMerkez= $model->getSinavMerkezValues ($evrak_id);
		$akreditasyon = $model->getAkreditasyonValues ($evrak_id);
		$personel 	= FormFactory2::getPersonelValues ($evrak_id);			
		$egitim 	= FormFactory2::getEgitimValues ($evrak_id);			
		$sertifika 	= FormFactory2::getSertifikaValues ($evrak_id);			
		$isDeneyim 	= FormFactory2::getIsDeneyimValues ($evrak_id);			
		$dil 		= FormFactory2::getDilValues ($evrak_id);	
		//$ekler		= FormFactory2::getBasvuruEkValues ($evrak_id);
		$belgebasvurular = $model->getBelgelendirmeBasvurular($user_id);
		if(!isset($belgebasvurular[0]))
			$belgebasvurular = $model->getBelgelendirmeBasvurularEvrak($evrak_id);
		$basvuru_ekleri = $model->getBasvuruEkleriPDF($evrak_id);
		$basvuru_ekleri_tur = $model->getBasvuruEkleriBelgeTuru($evrak_id);
		$kayitli_yeterlilikler = $model->getKayitliYeterlilikler($evrak_id);
		

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_yeterlilik_ad = FormParametrik::getYeterlilikAd ();
		$pm_yeterlilik 	  = FormParametrik::getYeterlilik ();
		$pm_sinav_sekli	  = FormParametrik::getSinavSekli ();

		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $evrak_id);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		$this->assignRef('user_id'	, $user_id);

		//giris
		$this->assignRef('belgebasvurular', $belgebasvurular);
		
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
		$this->assignRef('yetkiTalep',$yetkiTalep);
		
		//4. Akreditasyon
		$this->assignRef('akreditasyon', $akreditasyon);
		
		//5. Kapsam
		$this->assignRef('sinavMerkez', $sinavMerkez);
		
		//6. Kişi Bilgi Eki
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		//7. Ekler
		$this->assignRef('ekler'	, $ekler);
		$this->assignRef('basvuru_ekleri', $basvuru_ekleri);
		$this->assignRef('turler', $basvuru_ekleri_tur);
		
		//Parametrik Data
		$this->assignRef('pm_il'			, $pm_il);
		$this->assignRef('pm_kurulus_statu'	, $pm_kurulus_statu);
		$this->assignRef('pm_faaliyet_sure' , $pm_faaliyet_sure);
		$this->assignRef('pm_sektor'		, $pm_sektor);
		$this->assignRef('pm_seviye'		, $pm_seviye);
		$this->assignRef('pm_yeterlilik_ad' , $pm_yeterlilik_ad);
		$this->assignRef('pm_yeterlilik' 	, $pm_yeterlilik);
		$this->assignRef('pm_sinav_sekli' 	, $pm_sinav_sekli);		

				
		parent::display($tpl);
	}

}
?>