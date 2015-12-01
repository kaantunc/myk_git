<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Kurulus_KayitViewKurulus_Kayit extends JView
{
	function display($tpl = null)
	{	
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$group_id   = KURULUS_KAYDI_OLMAYAN_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
// 		if (!$aut)
// 			$mainframe->redirect('index.php?', $message);
		
		//Kurulus Statuleri (Parametrik)
		$kurulus_statu = FormParametrik::getKurulusStatu();
		//Iller
		$il	= FormParametrik::getIl ();
		
		$this->assignRef('kurulus_statu', $kurulus_statu);
		$this->assignRef('il', $il);
		parent::display($tpl);		
	}	
}
?>
