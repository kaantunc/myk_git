<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Sonucu_Gor extends JModel {
    
    function getSinavSekli($db, $data){
    	
    	$sinavId = $data['sinavId'];  
    	
    	$sql = "SELECT SINAV_SEKLI_ID FROM PM_SINAV_SEKLI
    			NATURAL JOIN M_SINAV
			WHERE M_SINAV_ID = ?";
							
		$params = array($sinavId);
		$sinavSekli = $db->prep_exec($sql, $params);

		if(isset($sinavSekli[0]['SINAV_SEKLI_ID']))
			return $sinavSekli[0]['SINAV_SEKLI_ID'];
		return false;
    }
    
    function getSinavSonuclari($db, $data){
    	
    	$sinavId = $data['sinavId'];  
    	
    	$sql = "SELECT * FROM M_SINAV_SONUCU
    			NATURAL JOIN M_OGRENCI
    			NATURAL JOIN PM_SINAV_DURUM
			WHERE M_SINAV_ID = ?";
							
		$params = array($sinavId);
		$sinavSonuclari = $db->prep_exec($sql, $params);

		return $sinavSonuclari;
    }

}
?>
