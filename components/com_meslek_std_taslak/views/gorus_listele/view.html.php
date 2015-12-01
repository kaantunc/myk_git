<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewGorus_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message = YETKI_MESAJ;
		$user 	 = &JFactory::getUser();
		$user_id = $user->getOracleUserId ();
		$model 	 = &$this->getModel();
		$db 	 = & JFactory::getOracleDBO();
		$standart_id = JRequest::getVar('standartId');	
		
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$isYetkiliKurulus  = FormFactory::standartHazirlamayaProtokoluVarMi ($user->getOracleUserId(), $standart_id);	
		$aktifYetkilendirmesiVarMi = FormFactory::aktifStandartYetkilendirmesiVarMi($standart_id, $user->getOracleUserId());
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$isSektorSorumlusu && !$isYetkiliKurulus && $aktifYetkilendirmesiVarMi)
		{
			if (!($isYetkiliKurulus && $aktifYetkilendirmesiVarMi))
				$message = "Yetkilendirmeniz Aktif Değil";	
				$mainframe->redirect('index.php?', $message, 'error');
		}
		/////////////////////////////////////////////////////////////////////////////////		
		
		$gorusler = $model->getGorusAyrinti($db, $standart_id);
		
		$this->assignRef('gorusler'  , $gorusler);
		$this->assignRef('standartId', $standart_id);
		
		parent::display($tpl);		
	}	
}
?>
