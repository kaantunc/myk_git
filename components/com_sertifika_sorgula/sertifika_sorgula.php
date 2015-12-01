<?php

defined('_JEXEC') or die('Restricted access');
// loading of the Joomla! basic controller
require_once (JPATH_COMPONENT.DS.'controller.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/formBelgelendirme.php');
require_once('libraries/form/form_parametrik.php');

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
$classname	= 'Sertifika_SorgulaController'.ucfirst($controller);
$controller = new $classname( );

// reading the request task
$controller->execute(JRequest::getCmd('task'));

// redirect from the controller
$controller->redirect();


?>