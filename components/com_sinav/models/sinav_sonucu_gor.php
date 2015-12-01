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
    	
    	$sqlyenimi = "SELECT SEKIL FROM M_SINAV_SONUCU
    					WHERE M_SINAV_ID = ?";
    	$sekil = $db->prep_exec($sqlyenimi, array($sinavId));
    	
    	if(strlen($sekil[0]['SEKIL']) <= 0){
    		$sql = "SELECT DISTINCT OGRENCI_KAYIT_NO, M_SINAV_SONUCU.TC_KIMLIK, M_SINAV_SONUCU.M_SINAV_ID, OGRENCI_ADI, 
    				OGRENCI_SOYADI, M_SINAV_SONUCU.ALT_BIRIM_ID, 
    				BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA, SINAV_DURUM_ID, ALDIGI_NOT, SINAV_DURUM_ADI,
    				DEGERLENDIRICI, GOZETMEN
    			  FROM M_SINAV_SONUCU
    			  JOIN M_OGRENCI ON M_SINAV_SONUCU.TC_KIMLIK = M_OGRENCI.TC_KIMLIK
		       	  JOIN M_OGRENCI_ALT_BIRIM ON (M_SINAV_SONUCU.M_SINAV_ID = M_OGRENCI_ALT_BIRIM.M_SINAV_ID 
		       	  AND M_SINAV_SONUCU.ALT_BIRIM_ID = M_OGRENCI_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID 
            	  AND M_SINAV_SONUCU.TC_KIMLIK = M_OGRENCI_ALT_BIRIM.TC_KIMLIK) 
		          JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
		          JOIN M_YETERLILIK_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID
		          JOIN M_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_BIRIM.BIRIM_ID
		          LEFT JOIN PM_SINAV_DURUM USING (SINAV_DURUM_ID)
    			  WHERE M_SINAV_SONUCU.M_SINAV_ID = ? ORDER BY TC_KIMLIK, BIRIM_KODU";
    	}
    	
    	else{
	    	$sql = "SELECT DISTINCT * FROM M_SINAV_SONUCU
	    			JOIN M_OGRENCI USING (TC_KIMLIK)
	    			LEFT JOIN PM_SINAV_DURUM USING (SINAV_DURUM_ID)
	          		JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					WHERE M_SINAV_ID = ? ORDER BY TC_KIMLIK, YETERLILIK_ALT_BIRIM_ID";
    	}				

		$params = array($sinavId);
		$sinavSonuclari = $db->prep_exec($sql, $params);

		return $sinavSonuclari;
    }

}
?>
