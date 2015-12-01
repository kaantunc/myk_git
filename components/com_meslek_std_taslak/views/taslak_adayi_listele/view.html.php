<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewTaslak_Adayi_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user = &JFactory::getUser ();
		$model = $this->getModel ();
		$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
		$standartKurulusu = FormFactory::checkAuthorization  ($user, YT1_GROUP_ID);
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		$message = YETKI_MESAJ;
		if (!$sektorSorumlusu && !$standartKurulusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		
		$taslakAday 	= $model->getTaslakAday ();
		
		$this->assignRef('taslakAday'  , $taslakAday);

		parent::display($tpl);
		
	}	
}
?>
