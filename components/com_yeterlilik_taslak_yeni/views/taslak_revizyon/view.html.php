<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewTaslak_Revizyon extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		$yeterlilik_id 	 	 = JRequest::getVar ("yeterlilik_id");
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		//YET Sektor Sorumlusu mu?
		$group_id   = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		if (!$aut)
			$mainframe->redirect('index.php?', $message);
		
		// Yeterliligin sektorunu gormeye yetkisi var mi?
		$sektorler 		= FormFactory::getSorumluSektorId ($user->getOracleUserId(), YET_SEKTOR_TIPI);
		$yetSektor		= FormFactory::getTaslakSektorId ($yeterlilik_id, YET_SEKTOR_TIPI);
		
		if (array_search($yetSektor, $sektorler) === FALSE){
			$mainframe->redirect('index.php?', $message);
		}
		/////////////////////////////////////////////////////////////////////////////////
		
		$revizyon_no=$_GET[revize_no];
		$yeterlilik_bilgi	 = $model->getTaslakBilgi ($yeterlilik_id);
		$revizyon_bilgi	 	 = $model->getRevizyonBilgi ($yeterlilik_id,$revizyon_no);
		$YETERLILIK_SUREC_DURUM 	 = $yeterlilik_bilgi["YETERLILIK_SUREC_DURUM_ID"];
		$pm_YETERLILIK_SUREC_DURUM = $model->getYeterlilikDurum (0);
		$pm_YETERLILIK_REVIZYON_SUREC_DURUM = $model->getYeterlilikDurum (1);
		$revizyonVarMi	 =$model->revizyonVarMi($yeterlilik_id);
		$revizyonListesi	 =$model->revizyonListesi($yeterlilik_id);
		$durumKontrol	 =$model->durumKontrol($yeterlilik_id);
		$canEdit=$model->canEdit($yeterlilik_id);
		
		if ($YETERLILIK_SUREC_DURUM != ONAYLANMIS_YETERLILIK)
			$disabled = "disabled";
		else
			$disabled = "";
			
		$this->assignRef ("yeterlilik_id"		, $yeterlilik_id);
		$this->assignRef ("yeterlilik_bilgi"	, $yeterlilik_bilgi);
		$this->assignRef ("revizyon_bilgi"		, $revizyon_bilgi);
		$this->assignRef ("disabled"			, $disabled);
		$this->assignRef ("pm_YETERLILIK_SUREC_DURUM"	, $pm_YETERLILIK_SUREC_DURUM);
		$this->assignRef ("pm_YETERLILIK_REVIZYON_SUREC_DURUM"	, $pm_YETERLILIK_REVIZYON_SUREC_DURUM);
		$this->assignRef ("revizyonVarMi"	, $revizyonVarMi);
		$this->assignRef ("revizyonListesi"	, $revizyonListesi);
		$this->assignRef ("durumKontrol"	, $durumKontrol);
		$this->assignRef ("canEdit"	, $canEdit);
		
		parent::display($tpl);
	}	
}
?>
