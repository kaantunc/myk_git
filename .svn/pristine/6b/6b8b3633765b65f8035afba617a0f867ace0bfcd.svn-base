<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class AkreditasyonModelTakvim_Ozet extends JModel {
	
    function getKurulusAdlari($db, $kurulusIds){
    	
    	$soruStr = $this->getSoruStr($kurulusIds);
		
		$sql = "SELECT USER_ID, KURULUS_ADI
					FROM M_KURULUS
				WHERE USER_ID IN (".$soruStr.")
					ORDER BY USER_ID ASC";
		 
		$kuruluslar = $db->prep_exec($sql, $kurulusIds);
    	
		return $kuruluslar;
    }
    
    private function getSoruStr($array){
        $count = count($array);
    	$soruStr = '';
    	
    	if($count > 0){
    		$soruStr = '?';
	    	for($i=1;$i<$count;$i++){
	    		$soruStr .= ',?';	
	    	}
    	}
    	return $soruStr;
    }
    
}
?>
