<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewOnayli_Taslak_Listele extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message = YETKI_MESAJ;
		$user = &JFactory::getUser ();
		$model = &$this->getModel();
		$db = & JFactory::getOracleDBO();	
		$sektorSorumlusu   = FormFactory::sektorSorumlusuMu ($user);
		$yeterlilikKurulusu = FormFactory::checkAuthorization  ($user, YT2_GROUP_ID);
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$sektorSorumlusu && !$yeterlilikKurulusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		
		$taslaklar = $model->getTaslaklar($db);
			
		$this->assignRef('taslaklar'  , $taslaklar);
		$this->assignRef('sektorSorumlusu'  , $sektorSorumlusu);

		parent::display($tpl);
		
	}	
}
?>
