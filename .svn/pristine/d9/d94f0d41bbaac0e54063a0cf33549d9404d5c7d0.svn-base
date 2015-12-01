<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewGorus_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message = YETKI_MESAJ;
		$user 	 = &JFactory::getUser();
		$user_id = $user->getOracleUserId ();
		$model = &$this->getModel();
		$db = & JFactory::getOracleDBO();
		$yeterlilikId = JRequest::getVar('yeterlilikId');
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$isYetkiliKurulus  = FormFactory::yeterlilikHazirlamayaYetkiliMi ($user_id, $yeterlilikId);	
			
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$isSektorSorumlusu && !$isYetkiliKurulus){
			$mainframe->redirect('index.php?', $message);
		}
		/////////////////////////////////////////////////////////////////////////////////	
		
		$gorusler = $model->getGorusler($db, $yeterlilikId);
		
		$this->assignRef('gorusler'  , $gorusler);
		$this->assignRef('yeterlilikId'  , $yeterlilikId);

		parent::display($tpl);
		
	}	
}
?>
