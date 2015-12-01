<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

//require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Meslek_Std_TaslakModelGorus_Ayrinti extends JModel {
	
    function getGorusAyrinti($db, $gorusId){
    	    	
//    	echo '******<pre>';
//    	print_r($standartId);
//    	echo '</pre>******';
    	
		$sql = "SELECT  *
					FROM M_MESLEK_STANDART_GORUS_MADDE
						WHERE GORUS_ID = ?";
							
		$gorusler = $db->prep_exec($sql, array($gorusId));
		

		return $gorusler;
    }
    
    function canEdit($db, $standartId){
    	
    	$userId =& JFactory::getUser()->getOracleUserId();
    	    	
		$sql = "SELECT USER_ID
				FROM M_TASLAK_MESLEK 
				NATURAL JOIN M_BASVURU 
					WHERE STANDART_ID = ?";
							
		$userIdRows = $db->prep_exec($sql, array($standartId));
		
		//echo "**".$userIdRows[0]['USER_ID']."**";
		
		if(isset($userIdRows[0]['USER_ID']))
			return $userId == $userIdRows[0]['USER_ID'];
		else
			return false;
    	
    	
    }

}
?>
