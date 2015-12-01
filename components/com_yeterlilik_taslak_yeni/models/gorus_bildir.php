<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelGorus_Bildir extends JModel {

    function getYeterlilikAdi($db, $yeterlilikId) {
			
		$sql = "SELECT YETERLILIK_ADI
					FROM M_YETERLILIK
				WHERE YETERLILIK_ID = ?";
					
		$result = $db->prep_exec_array($sql, array($yeterlilikId));
			
		return $result[0];

    }
    function getSeviye($db, $yeterlilikId) {
			
		$sql = "SELECT SEVIYE_ID, SEVIYE_ADI 
					FROM M_YETERLILIK 
					JOIN PM_SEVIYE USING (SEVIYE_ID)
				WHERE YETERLILIK_ID = ?";
					
		$result = $db->prep_exec($sql, array($yeterlilikId));
			
		return $result[0];

    }
    
    function getSonGorusTarihi ($db, $yeterlilikId){
    	$sql = "SELECT TO_CHAR (SON_GORUS_TARIHI, 'dd.mm.yyyy') SON_GORUS_TARIHI
					FROM M_TASLAK_YETERLILIK 
				WHERE YETERLILIK_ID = ?";
					
		$result = $db->prep_exec_array($sql, array($yeterlilikId));
			
		return $result[0];
    }
}
?>
