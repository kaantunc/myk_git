<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewTaslak_Revizyon extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		$standart_id 	 	= JRequest::getVar ("standart_id");
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		//MS Sektor Sorumlusu mu?
		$group_id   = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		if (!$aut)
			$mainframe->redirect('index.php?', $message);
		
		//Standardin sektorunu gormeye yetkisi var mi?
		$sektorler  		= FormFactory::getSorumluSektorId ($user->getOracleUserId(), MS_SEKTOR_TIPI);
		$standartSektor		= FormFactory::getTaslakSektorId ($standart_id, MS_SEKTOR_TIPI);
		
		if (array_search($standartSektor, $sektorler) === FALSE){
			$mainframe->redirect('index.php?', $message);
		}
		/////////////////////////////////////////////////////////////////////////////////
		
		$revizyon_no=$_GET[revize_no];
		$standart_bilgi	 	= $model->getTaslakBilgi ($standart_id);
		$revizyon_bilgi	 	= $model->getRevizyonBilgi ($standart_id,$revizyon_no);
		$standart_durum	   	= $standart_bilgi["MESLEK_STANDART_SUREC_DURUM_ID"];
		$pm_standart_durum 	= $model->getStandartDurum (0);
		$pm_standart_revizyon_durum 	= $model->getStandartDurum (1);
		$revizyonVarMi	 =$model->revizyonVarMi($standart_id);
		$revizyonListesi	 =$model->revizyonListesi($standart_id);
		$durumKontrol	 =$model->durumKontrol($standart_id);
		$canEdit=$model->canEdit($standart_id);
		
		if ($standart_durum != ONAYLANMIS_STANDART)
			$disabled = "disabled";
		else
			$disabled = "";
			
		$this->assignRef ("standart_id"		, $standart_id);
		$this->assignRef ("standart_bilgi"	, $standart_bilgi);
		$this->assignRef ("revizyon_bilgi"	, $revizyon_bilgi);
		$this->assignRef ("pm_standart_durum"	, $pm_standart_durum);
		$this->assignRef ("pm_standart_revizyon_durum"	, $pm_standart_revizyon_durum);
		$this->assignRef ("disabled"		, $disabled);
		$this->assignRef ("revizyonVarMi"	, $revizyonVarMi);
		$this->assignRef ("revizyonListesi"	, $revizyonListesi);
		$this->assignRef ("durumKontrol"	, $durumKontrol);
		$this->assignRef ("canEdit"	, $canEdit);
		
		parent::display($tpl);
	}	
}
?>
