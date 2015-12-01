<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Kurulus_EditViewKurulus_Edit extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	= &JFactory::getUser();
		$model 	= &$this->getModel();
		$layout	= JRequest::getVar ("layout");
		$tur	= JRequest::getVar ("tur");
		$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		$message = YETKI_MESAJ;
		if (!$sektorSorumlusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		if (isset($layout)){
			$user_id	   		= JRequest::getVar ("id");
			$pageTree			= $model->getPageTree ($layout, $tur, $user_id);
			$kurulus_bilgi 		= FormFactory::getKurulusValues($user_id);
			$iller 	 	   		= FormFactory::getKurulusIlValues($user_id);
			$meslek				= $model->getMeslekValues($user_id);
			$yeterlilik			= $model->getYeterlilikValues ($user_id);
			$ms_liste_durum 	= FormFactory::getListeDurum ($user_id, MS_SEKTOR_TIPI);
			$yet_liste_durum	= FormFactory::getListeDurum ($user_id, YET_SEKTOR_TIPI);
			$pm_il				= FormParametrik::getIl();
			$pm_kurulus_statu 	= FormParametrik::getKurulusStatu();
			$pm_seviye 			= FormParametrik::getSeviye ();
			$pm_sektor 			= FormParametrik::getSektor ();
			$pm_meslek_std		= FormParametrik::getMeslekStandart ();
			
			$this->assignRef('pageTree'		, $pageTree);
			$this->assignRef('kurulus_bilgi', $kurulus_bilgi);
			$this->assignRef('iller'  	    , $iller);
			$this->assignRef('meslek'	    , $meslek);
			$this->assignRef('yeterlilik'   , $yeterlilik);
			$this->assignRef('ms_liste_durum' , $ms_liste_durum);
			$this->assignRef('yet_liste_durum', $yet_liste_durum);
			$this->assignRef('pm_il'		, $pm_il);
			$this->assignRef('pm_kurulus_statu'	, $pm_kurulus_statu);
			$this->assignRef('pm_seviye'	, $pm_seviye);
			$this->assignRef('pm_sektor'	, $pm_sektor);
			$this->assignRef('pm_meslek_standart', $pm_meslek_std);
			
		}else{
			$kuruluslar    = $model->getKuruluslar ($tur);		
			$this->assignRef('kuruluslar'  , $kuruluslar);
		}
		
		$this->assignRef('user_id'	  , $user_id);
		$this->assignRef('kurulus_tur', $tur);
		
		parent::display($tpl);
	}	
}
?>
