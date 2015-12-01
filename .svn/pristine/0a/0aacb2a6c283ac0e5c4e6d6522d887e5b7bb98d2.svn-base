<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Sec extends JModel {
    
    function getSinavlar($db){
    	
    	$userId = JFactory::getUser()->getOracleUserId();
    	
    	$sql = "SELECT  M_SINAV_ID,
    					TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI_FORMATTED,
    					TOPLAM_ADAY,
    					YETERLILIK_ADI,
    					MERKEZ_ADI,
    					SINAV_TUR_ADI,
    					SINAV_SEKLI_ADI,
    					BASARILI_ADAY
    						FROM M_SINAV
    						JOIN M_YETERLILIK USING (YETERLILIK_ID)
    						JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    						JOIN PM_SINAV_TURU USING (SINAV_TUR_ID)
    						JOIN PM_SINAV_SEKLI USING (SINAV_SEKLI_ID)
    			WHERE 	USER_ID = ?
    			ORDER BY SINAV_TARIHI ASC";
    	
		$sinavlar = $db->prep_exec($sql,array($userId));
		return $sinavlar;
    }
    

}
?>
