<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ItembankViewItembank extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		$aut 		= FormFactory::checkAuthorization  ($user, ITEMBANK_GROUP_ID);
        $layout		 = JRequest::getVar("layout");

		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$aut)
			$mainframe->redirect('index.php?', YETKI_MESAJ);

		/////////////////////////////////////////////////////////////////////////////////
		

		parent::display($tpl);
    }    

}
?>
