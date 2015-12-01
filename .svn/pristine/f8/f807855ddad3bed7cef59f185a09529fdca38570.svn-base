<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelGorus_Ayrinti extends JModel {
	
    function getGorusAyrinti($db, $gorusId){
  	
		$sql = "SELECT  *
				FROM M_YETERLILIK_GORUS_MADDE
				WHERE GORUS_ID = ?";
							
		$gorusler = $db->prep_exec($sql, array($gorusId));
		

		return $gorusler;
    }
    
    function canEdit($db, $yeterlilikId){
    	
    	$userId =& JFactory::getUser()->getOracleUserId();
    	    	
		$sql = "SELECT USER_ID
				FROM M_TASLAK_YETERLILIK  
					JOIN M_BASVURU USING (EVRAK_ID) 
				WHERE YETERLILIK_ID = ?";
							
		$userIdRows = $db->prep_exec($sql, array($yeterlilikId));
		
		//echo "**".$userIdRows[0]['USER_ID']."**";
		
		if(isset($userIdRows[0]['USER_ID']))
			return $userId == $userIdRows[0]['USER_ID'];
		else
			return false;
    	
    	
    }

}
?>
