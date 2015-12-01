<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Teknik_CalismaViewTeknik_Calisma extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		
		/*/YETKI KONTROL
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
		////////////////////////////////////////////////////////////////////////////////
		 * */
		
		$uh = $model->getUzmanHavuzu();
		$this->assignRef ("uzman_havuzu", $uh);
		
		$teknikCalismaGruplari = $model->getTeknikCalismaGruplari();
		$this->assignRef ("teknikCalismaGruplari", $teknikCalismaGruplari);
		
		if($_GET['tcg_id']!='')
		{
			$seciliTeknikCalismaninUzmanlari = $model->getSeciliTeknikCalismaninUzmanlari($_GET['tcg_id']);
			$this->assignRef ("seciliTeknikCalismaninUzmanlari", $seciliTeknikCalismaninUzmanlari);
		
			$uzmanHavuzu_VeBuTCGDisindakiCalismaSaatleri = $model->getUzmanHavuzu_VeBuTCGDisindakiCalismaSaatleri($_GET['tcg_id']);
			$this->assignRef ("uzman_havuzu_VeBuTCGDisindakiCalismaSaatleri", $uzmanHavuzu_VeBuTCGDisindakiCalismaSaatleri);
		
		}
		
		parent::display($tpl);
	}	
}
?>
