<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewGorus_Ayrinti extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message = YETKI_MESAJ;
		$user 	 = &JFactory::getUser();
		$user_id = $user->getOracleUserId ();
		$model = &$this->getModel();
		$db = & JFactory::getOracleDBO();
		$gorusId = JRequest::getVar('gorusId');
		$yeterlilikId = JRequest::getVar('yeterlilikId');
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$isYetkiliKurulus  = FormFactory::yeterlilikHazirlamayaYetkiliMi ($user_id, $yeterlilikId);	
			
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$isSektorSorumlusu && !$isYetkiliKurulus){
			$mainframe->redirect('index.php?', $message);
		}
		/////////////////////////////////////////////////////////////////////////////////
		
		$canEdit = $model->canEdit($db, $yeterlilikId);
		$goruslerAyrinti = $model->getGorusAyrinti($db, $gorusId);
			
		$this->assignRef('canEdit'  , $canEdit);
		$this->assignRef('goruslerAyrinti'  , $goruslerAyrinti);
		$this->assignRef('yeterlilikId'  , $yeterlilikId);

		parent::display($tpl);	
	}	
}
?>
