<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewTaslak_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user = &JFactory::getUser ();
		$model = &$this->getModel();
		$db = & JFactory::getOracleDBO();
		
		$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
		$standartKurulusu = FormFactory::checkAuthorization  ($user, YT1_GROUP_ID);
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		$message = YETKI_MESAJ;
		if (!$sektorSorumlusu && !$standartKurulusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////

		$taslaklar = $model->getTaslaklar($db);
					
		$this->assignRef('taslaklar'  		, $taslaklar);
		$this->assignRef('sektorSorumlusu'  , $sektorSorumlusu);

		parent::display($tpl);
		
	}	
}
?>
