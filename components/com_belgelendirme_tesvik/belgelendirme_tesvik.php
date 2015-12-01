<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

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
$classname	= 'Belgelendirme_TesvikController'.ucfirst($controller);
$controller = new $classname( );

// reading the request task
$controller->execute(JRequest::getCmd('task'));

// redirect from the controller
$controller->redirect();
?>