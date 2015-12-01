<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Oncesi_Ozet extends JModel {

    function getMerkezAdi($db, $postData){
    	
		$sql = "SELECT MERKEZ_ADI
					FROM M_SINAV_MERKEZI
				WHERE MERKEZ_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['sinav_yeri']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getYetAdi($db, $postData){
    	
		$sql = "SELECT YETERLILIK_ADI
					FROM M_YETERLILIK
				WHERE YETERLILIK_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['yeterlilik_konusu']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getTurAdi($db, $postData){
    	
		$sql = "SELECT SINAV_TUR_ADI
					FROM PM_SINAV_TURU
				WHERE SINAV_TUR_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['sinav_turu']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getSekilAdi($db, $postData){
    	
		$sql = "SELECT SINAV_SEKLI_ADI
					FROM PM_SINAV_SEKLI
				WHERE SINAV_SEKLI_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['sinav_sekli']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}

}
?>