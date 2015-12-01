<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = &JFactory::getDocument();

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class AjaxViewAjax extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();

		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////////////////////////
		
//		$finans_bilgi = $model->getFinansBilgi ();
			
//		$this->assignRef ("finans_bilgi"		, $finans_bilgi);


		parent::display($tpl);
	}	
}
?>
