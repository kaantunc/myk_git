<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");

// loading of the Joomla! basic controller
require_once (JPATH_COMPONENT.DS.'controller.php');
// loading from further controller
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// produce an object of the class controllers
$classname	= 'Yeterlilik_TaslakController'.ucfirst($controller);
$controller = new $classname( );

// reading the request task
$controller->execute(JRequest::getCmd('task'));

// redirect from the controller
$controller->redirect();

?>