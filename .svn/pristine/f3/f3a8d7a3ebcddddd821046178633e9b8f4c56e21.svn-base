<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once('libraries'.DS.'form'.DS.'form.php');

if(!FormFactory::akreditasyonKurulusumu()){
	global $mainframe;
	$mainframe->redirect('index.php', JText::_('AKREDITASYON_YETKINIZ_YOK'), "error");
}


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
$classname	= 'AkreditasyonController'.ucfirst($controller);
$controller = new $classname( );

// reading the request task
$controller->execute(JRequest::getCmd('task'));

// redirect from the controller
$controller->redirect();

function akreditasyonKurulusumu(){
    $user_id = JFactory::getUser()->getOracleUserId();
    $db = & JFactory::getOracleDBO();
    
    $sql = "SELECT KURULUS_DURUM_ID FROM M_KURULUS WHERE USER_ID = ?";
    
    $durumIdler = $db->prep_exec($sql, array($user_id));
    
    if(isset($durumIdler)){
    	if($durumIdler[0]['KURULUS_DURUM_ID'] == 8)
    		return true;
    	else
    		return false;
    }
    
}

?>