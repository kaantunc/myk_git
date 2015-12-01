<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ItembankViewSorugirisi extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		$aut 		= FormFactory::checkAuthorization  ($user, ITEMBANK_GROUP_ID);
		$aut2 		= FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
		$layout		 = JRequest::getVar("layout");

		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$aut and !$aut2)
			$mainframe->redirect('index.php?', YETKI_MESAJ);
		
		if ($aut2 and $_GET["soru_id"]==""){
			$mainframe->redirect('index.php?option=com_itembank&view=sorulari_listele', YETKI_MESAJ);
		}

		/////////////////////////////////////////////////////////////////////////////////
		
       

		parent::display($tpl);
    }    

}
?>
