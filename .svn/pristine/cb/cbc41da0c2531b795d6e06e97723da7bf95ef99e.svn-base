<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/*?>
  
<script type="text/javascript" src="administrator/components/com_chronocontact/js/addrow.js"></script>
<script type="text/javascript" src="administrator/components/com_chronocontact/js/pagination.js"></script>
<script type="text/javascript" src="administrator/components/com_chronocontact/js/dosya_gonder.js"></script>
<script type="text/javascript" src="administrator/components/com_chronocontact/js/panel.js"></script>
<script type="text/javascript" src="administrator/components/com_chronocontact/js/myjsvalidator.js"></script>
<script type="text/javascript" src="components/com_sinav/js/sinav.js"></script>
 
<?php*/

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
$classname	= 'BelgelendirmeController'.ucfirst($controller);
$controller = new $classname( );

// reading the request task
$controller->execute(JRequest::getCmd('task'));

// redirect from the controller
$controller->redirect();
?>