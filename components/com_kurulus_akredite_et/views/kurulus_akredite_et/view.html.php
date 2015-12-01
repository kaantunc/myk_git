<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Kurulus_Akredite_EtViewKurulus_Akredite_Et extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		
		$akrediteEdilmisKurulusIDleri = $model->getAkrediteEdilmisKurulusIDleri();
		$this->assignRef('akrediteEdilmisKurulusIDleri', $akrediteEdilmisKurulusIDleri);
		
		/*
		$aut 		= FormFactory::checkAuthorization  ($user, T1_GROUP_ID);

		if (!$aut)
		$mainframe->redirect('index.php?', YETKI_MESAJ);
		

		if (!isset ($layout)){
			$layout = "yetkilendirme_listele";
			$this->setLayout($layout);
		}
		
		if($_GET['tumKuruluslar']=='1')
			$kuruluslar = $model->getKuruluslar_Tumu();
		else
			$kuruluslar = $model->getKuruluslar_MeslekiYeterlilikYetkili(); // MESLEK STANDARDI HAZIRLAMAYA YETKILILER
		
		$this->assignRef('kuruluslar', $kuruluslar);
		
		$protokoller = $model->getProtokoller();
		$this->assignRef('protokoller', $protokoller);

		$etkinlikDurumlari = $model->getProtokolEtkinlikDurumlari();
		$this->assignRef('etkinlikDurumlari', $etkinlikDurumlari);
		
		$protokolID = JRequest::getVar("protokolID");
		if (isset ($protokolID)){
			$seciliProtokol = $model->getProtokol($protokolID);
			$this->assignRef('seciliProtokol', $seciliProtokol);
			$seciliProtokolunKuruluslari = $model->getProtokolKuruluslari($protokolID);
			$this->assignRef('seciliProtokolunKuruluslari', $seciliProtokolunKuruluslari);
			$seciliProtokolunYeterlilikleri = $model->getProtokolYeterlilikleri($protokolID);
			$this->assignRef('seciliProtokolunYeterlilikleri', $seciliProtokolunYeterlilikleri);
			$meslekiYeterlilikProtokoluMu = $model->meslekiYeterlilikProtokoluMu($protokolID);
			$this->assignRef('meslekiYeterlilikProtokoluMu', $meslekiYeterlilikProtokoluMu);
			$protokolunSektorleri = $model->getProtokolunSektorleri($protokolID);
			$this->assignRef('protokolunSektorleri',$protokolunSektorleri);
			$uzatmalar = $model->getUzatmalar($protokolID);
			$this->assignRef('uzatmalar',$uzatmalar);
			
		}
		$yetkilendirmeTurleri = $model->getYetkilendirmeTurleri();
		$this->assignRef('yetkilendirmeTurleri',$yetkilendirmeTurleri);
		
		$meslekStandartSektorleri = $model->getMeslekStandartSektorleri();
		$this->assignRef('meslekStandartSektorleri',$meslekStandartSektorleri);
		
		$meslekStandartSeviyeleri = $model->getMeslekStandartSeviyeleri();
		$this->assignRef('meslekStandartSeviyeleri',$meslekStandartSeviyeleri);
		
		$ulusalStandartlar = $model->getUlusalStandartlar();
		$this->assignRef('ulusalStandartlar',$ulusalStandartlar);
		
		*/
		
		/*
		$pages			= $model->pages;
		$pageNames		= $model->pageNames;
		$title 			= $model->title;
		$evrak_id		= FormFactory::getCurrentEvrakId ($_POST,T1_BASVURU_TIP, $user);
		$pageTree		= FormFactory::getPageTree ($user, $layout, $evrak_id, $pages, $pageNames);
		$basvuru		= FormFactory::getBasvuruValues ($evrak_id);
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

		
		*/
		parent::display($tpl);
	}
}

?>