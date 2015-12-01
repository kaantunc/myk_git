<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class DatatableViewDatatable extends JView
{
	function display($tpl = null)
	{	
		global $mainframe;
		$model = &$this->getModel();
		
		$data = $model->getDataFromDB();
		
		$this->assignRef('data', $data);

		parent::display($tpl);		
	}	
}
?>
