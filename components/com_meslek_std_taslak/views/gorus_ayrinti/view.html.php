<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewGorus_Ayrinti extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message = YETKI_MESAJ;
		$user 	 = &JFactory::getUser();
		$user_id = $user->getOracleUserId ();
		$model 	 = &$this->getModel();
		$db 	 = & JFactory::getOracleDBO();
		$standartId = JRequest::getVar('standartId');
		
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$isYetkiliKurulus  = FormFactory::standartHazirlamayaYetkiliMi ($user_id, $standartId);
		$aktifYetkilendirmesiVarMi = FormFactory::aktifStandartYetkilendirmesiVarMi($standart_id, $user->getOracleUserId());
			
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$isSektorSorumlusu && !$isYetkiliKurulus && $aktifYetkilendirmesiVarMi){
 			$mainframe->redirect('index.php?', $message);
 		}
		/////////////////////////////////////////////////////////////////////////////////	
		
		$gorusId = JRequest::getVar('gorusId');	
		$canEdit = $model->canEdit($db, $standartId);
		$goruslerAyrinti = $model->getGorusAyrinti($db, $gorusId);
		
		$this->assignRef('canEdit'  , $canEdit);
		$this->assignRef('goruslerAyrinti'  , $goruslerAyrinti);
		$this->assignRef('standartId'  , $standartId);
		
		parent::display($tpl);		
	}	
}
?>
