<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewGorus_Listele extends JView
{
	function display($tpl = null)
	{		
		$model = &$this->getModel();		
		$db = & JFactory::getOracleDBO();	
		$yeterlilikId = JRequest::getVar('yeterlilikId');
		
		$gorusler = $model->getGorusAyrinti($db, $yeterlilikId);
			
		$this->assignRef('gorusler'  , $gorusler);
		$this->assignRef('yeterlilikId'  , $yeterlilikId);

		parent::display($tpl);
		
	}	
}
?>
