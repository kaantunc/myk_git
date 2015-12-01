<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SinavModelTakvim_Gor extends JModel {
	
    function getTakvim($db, $userId, $takvimYili){
		
		$sql = "SELECT DISTINCT TO_CHAR(TAKVIM_SINAV_TARIHI, 'dd.mm.yyyy')
						AS SINAV_TARIHI,
			        MERKEZ_ADI,
			        YETERLILIK_ADI,
			        YETERLILIK_ID,
              		ALT_BIRIMLER
			    	FROM M_SINAV_TAKVIMI
			    	JOIN M_YETERLILIK USING (YETERLILIK_ID)
			    	JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
			      	WHERE USER_ID = ? AND
			        TAKVIM_YILI = ? AND
			        SINAV_TAKVIMI_DURUM_ID = ".SINAV_TAKVIM_KAYDEDILDI."
			          ORDER BY SINAV_TARIHI";
		 
		$sinavlar[] = $db->prep_exec($sql, array($userId, $takvimYili));

    	foreach($sinavlar[0] as $cows){
    		$altbirim[] = $this->AltBirimAdlari($db, $cows['ALT_BIRIMLER']);
    		$sekil[] = $this->Sekiller($db, $cows['ALT_BIRIMLER']);
    	}    	
    	$sinavlar[] = $altbirim; 
    	$sinavlar[] = $sekil;
		return $sinavlar;
    }
    
    function getTakvimListe($db, $userId){
    		
		$sql = "SELECT DISTINCT TAKVIM_YILI
			    FROM M_SINAV_TAKVIMI
			      WHERE USER_ID = ? AND
			        SINAV_TAKVIMI_DURUM_ID = ".SINAV_TAKVIM_KAYDEDILDI."
			          ORDER BY TAKVIM_YILI ASC";
		 
		$takvimler = $db->prep_exec($sql, array($userId));
    	
		return $takvimler;
    	
    }
    
   private function AltBirimAdlari($db, $yetIds){
    		$altayir = $this->birimAyir($yetIds);
    		 
    		if(strlen($altayir[1][0]) > 0){
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO
    		    				FROM M_YETERLILIK_ALT_BIRIM
    		    				WHERE YETERLILIK_ALT_BIRIM_ID = ? ";
    				$yetler[] = $db->prep_exec($sql, array($altayir[0][$ii]));
    			}
    		}
    		else{
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sql = "SELECT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA
    						    FROM M_YETERLILIK_BIRIM 
    						        JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) 
    						        JOIN M_BIRIM USING(BIRIM_ID)
    		                		WHERE ID = ? ";
    				$yetler[] = $db->prep_exec($sql, array($altayir[0][$ii]));
    			}
    		}
    	
    	return $yetler;
    }
    
   private function Sekiller($db, $yetIds){
   	
    		$altayir = $this->birimAyir($yetIds);
    		 
    		if(strlen($altayir[1][0]) > 0){
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    
    				$sekiller[] = $altayir[1][$ii];
    			}
    		}
    		else{
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sekiller[] = $altayir[1][$ii];
    			}
    		}
    
    	return $sekiller;
    }
    
    private function birimAyir($altbirimler){
    	$butunbirimler = array();
    	$anabirimler = array();
    	$sekiller = array();
    	$birimler = explode(' ', $altbirimler);
    	foreach($birimler as $cows){
    		$birims = explode('_', $cows);
    		array_push($anabirimler, $birims[0]);
    		array_push($sekiller, $birims[1]);
    	}
    	array_push($butunbirimler, $anabirimler);
    	array_push($butunbirimler, $sekiller);
    	return $butunbirimler;
    }
}
?>
