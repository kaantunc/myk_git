<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SinavModelTakvim_Gor extends JModel {
	
    function getTakvim($db, $userId, $takvimYili){
		
		$sql = "SELECT  TO_CHAR(TAKVIM_SINAV_TARIHI, 'dd.mm.yyyy')
						AS TAKVIM_SINAV_TARIHI_FORMATTED,
			        MERKEZ_ADI,
			        YETERLILIK_ADI
			    FROM M_SINAV_TAKVIMI
			    JOIN M_BASVURU USING (EVRAK_ID)
			    JOIN M_YETERLILIK USING (YETERLILIK_ID)
			    JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
			      WHERE USER_ID = ? AND
			        TAKVIM_YILI = ? AND
			        SINAV_TAKVIMI_DURUM_ID = ".SINAV_TAKVIM_KAYDEDILDI."
			          ORDER BY TAKVIM_SINAV_TARIHI";
		 
		$sinavlar = $db->prep_exec($sql, array($userId, $takvimYili));
    	
		return $sinavlar;
    }
    
}
?>
