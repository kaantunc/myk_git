<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewGorus_Listele extends JView
{
	function display($tpl = null)
	{		
		$model = &$this->getModel();		
		$db = & JFactory::getOracleDBO();	
		$standartId = JRequest::getVar('standartId');
		
		$gorusler = $model->getGorusAyrinti($db, $standartId);
			
		$this->assignRef('gorusler'  , $gorusler);
		$this->assignRef('standartId'  , $standartId);

		parent::display($tpl);
		
	}	
}
?>
