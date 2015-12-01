<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');

$document = &JFactory::getDocument();
$user 		 = &JFactory::getUser();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
if($user->id>0){
$db = & JFactory::getDBO();
		
		$sql = "SELECT active FROM #__users WHERE id = ".$user->id;
		$db->setQuery($sql);
		$data = $db->loadRow();
$kullanicitipi=$data[0];
if ($kullanicitipi==3){
	$sql = "UPDATE #__community_acl_users
					SET group_id = 21,
						role_id = 20
				WHERE user_id = ".$user->id;
	$db->Execute ($sql);
	header('location: index.php?option=com_uzman_basvur');
} else {
	header('location: index.php?option=com_kurulus_kayit&Itemid=277');
}
}
exit;
?>
