<?php
/* Yönetim Kurulu */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//?

//~BURASI LAZIM MI?
require_once('libraries/form/form_config.php');
require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
 
// Require the base controller
 
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
 
// Create the controller
$classname    = 'Yonetim_KuruluController'.$controller;
$controller   = new $classname( );
 
// Perform the Request task
$controller->execute( JRequest::getWord( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();

?>