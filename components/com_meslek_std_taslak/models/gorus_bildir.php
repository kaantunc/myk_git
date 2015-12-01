<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Meslek_Std_TaslakModelGorus_Bildir extends JModel {

    function getStandartAdi($db, $standartId) {
			
		$sql = "SELECT STANDART_ADI
					FROM M_MESLEK_STANDARTLARI
				WHERE STANDART_ID = ?";
					
		$result = $db->prep_exec_array($sql, array($standartId));
			
		return $result[0];

    }
    function getSeviye($db, $standartId) {
			
		$sql = "SELECT SEVIYE_ID, SEVIYE_ADI
					FROM M_MESLEK_STANDARTLARI
					NATURAL JOIN PM_SEVIYE
				WHERE STANDART_ID = ?";
					
		$result = $db->prep_exec($sql, array($standartId));
			
		return $result[0];

    }
    
    function getSonGorusTarihi ($db, $standartId){
    	$sql = "SELECT TO_CHAR (SON_GORUS_TARIHI, 'dd.mm.yyyy') SON_GORUS_TARIHI
					FROM M_TASLAK_MESLEK 
				WHERE STANDART_ID = ?";
					
		$result = $db->prep_exec_array($sql, array($standartId));
			
		return $result[0];
    }
}
?>
