<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewTaslak_Adayi_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message   	= YETKI_MESAJ;
		$user = &JFactory::getUser ();
		$model = $this->getModel ();
		$sektorSorumlusu 	= FormFactory::sektorSorumlusuMu ($user);
		$yeterlilikKurulusu = FormFactory::checkAuthorization  ($user, YT2_GROUP_ID);
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$sektorSorumlusu && !$yeterlilikKurulusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		
		$taslakAday 	= $model->getTaslakAday ();
		
		$this->assignRef('taslakAday'  , $taslakAday);

		parent::display($tpl);
	}	
}
?>
