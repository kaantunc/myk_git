<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSertifika_Ozet extends JModel {

    function getSinavlar($db, $postData){    	
    	$sinavIds = unserialize($postData['sinavIds']);
    	
    	$sinavIdsStr = implode(',', $sinavIds);
    			
		$sql = "SELECT 	M_SINAV_ID,
						SINAV_SEKLI_ID,
						SINAV_TUR_ADI,
						TO_CHAR(SINAV_TARIHI,'dd.mm.yyyy') AS SINAV_TARIHI_FORMATTED,
						MERKEZ_ADI,
						TOPLAM_ADAY,
						SINAVI_YAPAN
    				FROM M_SINAV 
    				NATURAL JOIN PM_SINAV_TURU 
    				JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    			WHERE 	M_SINAV_ID IN ( " . $sinavIdsStr . " ) AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
		 
		$sinavlar = $db->prep_exec($sql, array());
		
		return $sinavlar;
			    	
    }
    
    function getKapsamlar($db, $postData){    	
    	$sinavIds = unserialize($postData['sinavIds']);
    			
		$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI
    				FROM M_SINAV 
              JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
    			WHERE 	M_SINAV_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
		 
		$kapsamlar = $db->prep_exec($sql, array($sinavIds[0]));
		
		return $kapsamlar;
			    	
    }
    
    function getYetkiNo($db){
    	
    	$userId = JFactory::getUser()->getOracleUserId(); 

		$sql = "SELECT 	KURULUS_YETKILENDIRME_NUMARASI
					FROM 	M_KURULUS
				WHERE 	USER_ID = ? AND
						KURULUS_YETKILENDIRME_NUMARASI IS NOT NULL";
		$yetkiNo = $db->prep_exec_array($sql,array($userId));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    
    function getYeterlilik($db, $postData){    	
    	$sinavIds = unserialize($postData['sinavIds']);
    			
		$sql = "SELECT YETERLILIK_ADI
    				FROM M_SINAV 
              JOIN M_YETERLILIK USING (YETERLILIK_ID)
    			WHERE 	M_SINAV_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
		 
		$yeterlilik = $db->prep_exec($sql, array($sinavIds[0]));
		
		return $yeterlilik[0];
			    	
    }
	
}
?>