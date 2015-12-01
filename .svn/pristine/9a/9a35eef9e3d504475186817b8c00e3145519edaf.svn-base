<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Scheduled_TasksViewScheduled_Tasks extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		
		$model = JModel::getInstance('Scheduled_Tasks','Scheduled_TasksModel');
		$layout		= JRequest::getVar ("layout");

		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId ();
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		if (!isset ($layout)){
			$layout = "default";
			$this->setLayout($layout);
		}
		
		$scheduledTasks = $model->getScheduledTasks();
		$this->assignRef('scheduledTasks', $scheduledTasks);
		
		parent::display($tpl);
	}
}

?>