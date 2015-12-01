<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Yetkilendirme_MsViewYetkilendirme_Ms extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();

		if (!isset ($layout)){
			$layout = "yetkilendirme_listele";
			$this->setLayout($layout);
		}
		
		
		if($_GET['tumKuruluslar']=='1')
			$kuruluslar = $model->getKuruluslar_Tumu();
		else
			$kuruluslar = $model->getKuruluslar_MeslekStandardiYetkili(); // MESLEK STANDARDI HAZIRLAMAYA YETKILILER
		$this->assignRef('kuruluslar', $kuruluslar);
		
		
		$yetkilendirmeler = $model->getYetkilendirmeler();
		$this->assignRef('yetkilendirmeler', $yetkilendirmeler);

		$etkinlikDurumlari = $model->getYetkilendirmeEtkinlikDurumlari();
		$this->assignRef('etkinlikDurumlari', $etkinlikDurumlari);
		
		$yetkilendirmeID = JRequest::getVar("yetkilendirmeID");
		if (isset ($yetkilendirmeID)){
			$seciliYetkilendirme = $model->getYetkilendirme($yetkilendirmeID);
			$this->assignRef('seciliYetkilendirme', $seciliYetkilendirme);
			$seciliYetkilendirmeKuruluslari = $model->getYetkilendirmeKuruluslari($yetkilendirmeID);
			$this->assignRef('seciliYetkilendirmeKuruluslari', $seciliYetkilendirmeKuruluslari);
			$seciliYetkilendirmeStandartlari = $model->getYetkilendirmeStandartlari($yetkilendirmeID);
			$this->assignRef('seciliYetkilendirmeStandartlari', $seciliYetkilendirmeStandartlari);
			$meslekStandardiYetkilendirmesiMi = $model->meslekStandardiYetkilendirmesiMi($yetkilendirmeID);
			$this->assignRef('meslekStandardiYetkilendirmesiMi', $meslekStandardiYetkilendirmesiMi);
			$protokolunSektorleri = $model->getProtokolunSektorleri($yetkilendirmeID);
			$this->assignRef('protokolunSektorleri',$protokolunSektorleri);
			$uzatmalar = $model->getUzatmalar($yetkilendirmeID);
			$this->assignRef('uzatmalar',$uzatmalar);
		}
		$yetkilendirmeTurleri = $model->getYetkilendirmeTurleri();
		$this->assignRef('yetkilendirmeTurleri',$yetkilendirmeTurleri);
		
		$oncedenVarolanStandartlar = $model->getOncedenVarolanStandartlar();
		$this->assignRef('oncedenVarolanStandartlar',$oncedenVarolanStandartlar);
		
		$meslekStandartSektorleri = $model->getMeslekStandartSektorleri();
		$this->assignRef('meslekStandartSektorleri',$meslekStandartSektorleri);
		
		$meslekStandartSeviyeleri = $model->getMeslekStandartSeviyeleri();
		$this->assignRef('meslekStandartSeviyeleri',$meslekStandartSeviyeleri);
		
		$meslekStandartDurumlari = $model->getPmStandartDurumlari();
		$this->assignRef('standartDurumlari',$meslekStandartDurumlari);
		
		parent::display($tpl);
	}
}

?>