<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Sonucu_Gir extends JModel {
    
    function getOgrListe($db, $data){
    	$yetkidur = array();
    	$sinavId = $data['sinavId'];  
		$gonderilen = array();
    	$sql1 = "SELECT YETKI_DURUM FROM M_OGRENCI_SINAV WHERE M_SINAV_ID=?";
    	$durum = $db->prep_exec($sql1, array($sinavId));
    	foreach($durum as $cows){
    		$yetkidur[] .= $cows["YETKI_DURUM"];
    	}
    	
    	//burası 1 olucak ve kod ona göre düzeltilecek else kısmı asagıdaki gibi olucak.
		if(in_array(1, $yetkidur)){
			$sqlyenimi = "SELECT DISTINCT ALT_BIRIM_ID,M_SINAV_SONUCU.SEKIL 
								FROM M_SINAV_SONUCU
				                JOIN M_OGRENCI ON M_SINAV_SONUCU.TC_KIMLIK = M_OGRENCI.TC_KIMLIK
				                JOIN M_OGRENCI_ALT_BIRIM ON (M_SINAV_SONUCU.TC_KIMLIK = M_OGRENCI_ALT_BIRIM.TC_KIMLIK
                                            AND M_SINAV_SONUCU.M_SINAV_ID = M_OGRENCI_ALT_BIRIM.M_SINAV_ID 
                                            AND M_SINAV_SONUCU.ALT_BIRIM_ID = M_OGRENCI_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID)
                				WHERE M_SINAV_SONUCU.M_SINAV_ID = ? ORDER BY ALT_BIRIM_ID";
			//AND M_SINAV_SONUCU.SEKIL = M_OGRENCI_ALT_BIRIM.SEKIL
			$sekil = $db->prep_exec($sqlyenimi, array($sinavId));
			
			if(strlen($sekil[0]['SEKIL']) <= 0){
				$sql = " SELECT DISTINCT OGRENCI_KAYIT_NO, SINAV_DURUM_ID, ALDIGI_NOT, TC_KIMLIK, M_SINAV_ID, OGRENCI_ADI, OGRENCI_SOYADI, ALT_BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA,
				GOZETMEN, DEGERLENDIRICI
		              FROM M_SINAV_SONUCU
			              NATURAL JOIN M_OGRENCI
			              JOIN M_BIRIM_OLCME_DEGERLENDIRME ON ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
			              JOIN M_YETERLILIK_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID
			              JOIN M_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_BIRIM.BIRIM_ID
		    			  WHERE M_SINAV_ID = ? ORDER BY TC_KIMLIK, ALT_BIRIM_ID";
			}
			else{
				$sql = "SELECT DISTINCT * FROM M_SINAV_SONUCU
                		NATURAL JOIN M_OGRENCI
		         		JOIN M_YETERLILIK_ALT_BIRIM ON ALT_BIRIM_ID = YETERLILIK_ALT_BIRIM_ID
						WHERE M_SINAV_ID = ? ORDER BY TC_KIMLIK,YETERLILIK_ALT_BIRIM_ID";
			}
			$gonderilen[] = 1;
		}
		
		else{
	    	$sqlyenimi = "  SELECT DISTINCT YETERLILIK_ALT_BIRIM_ID, SEKIL 
	    						FROM M_OGRENCI_SINAV
		    					NATURAL JOIN M_OGRENCI
	                			NATURAL JOIN M_OGRENCI_ALT_BIRIM
	    						WHERE M_SINAV_ID = ? ORDER BY YETERLILIK_ALT_BIRIM_ID";
	    	$sekil = $db->prep_exec($sqlyenimi, array($sinavId));
	    	
	    	if(strlen($sekil[0]['SEKIL']) <= 0){
	    		$sql = "SELECT DISTINCT OGRENCI_KAYIT_NO , TC_KIMLIK, M_SINAV_ID, OGRENCI_ADI, OGRENCI_SOYADI, YETERLILIK_ALT_BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA  
	    			FROM M_OGRENCI_SINAV
	    			  NATURAL JOIN M_OGRENCI
			          NATURAL JOIN M_OGRENCI_ALT_BIRIM
			          JOIN M_BIRIM_OLCME_DEGERLENDIRME ON YETERLILIK_ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
			          JOIN M_YETERLILIK_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID
			          JOIN M_BIRIM ON M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_BIRIM.BIRIM_ID
	    			  WHERE M_SINAV_ID = ? ORDER BY TC_KIMLIK,YETERLILIK_ALT_BIRIM_ID";
	    	}
	    	
	    	else{
		    	$sql = "SELECT DISTINCT * FROM M_OGRENCI_SINAV
		    			NATURAL JOIN M_OGRENCI
		           		NATURAL JOIN M_OGRENCI_ALT_BIRIM
		         		NATURAL JOIN M_YETERLILIK_ALT_BIRIM
						WHERE M_SINAV_ID = ? ORDER BY TC_KIMLIK, YETERLILIK_ALT_BIRIM_ID";
	    	}
	    	$gonderilen[] = 0;				
		}
		$params = array($sinavId);
		$ogrenciler = $db->prep_exec($sql, $params);
		$gonderilen[] = $ogrenciler;
		return $gonderilen;
    }
    
    function getDeger($db, $data){
    	$sinavId = $data['sinavId'];
    	$sql = "SELECT DEGERLENDIRICI FROM M_SINAV JOIN M_SINAV_DEGERLENDIRICI USING(YETERLILIK_ID) WHERE M_SINAV_ID = ?";
    	return $db->prep_exec($sql, array($sinavId));
    }
    
    function getSinavDurumlariCombo($db){
    	
    	$sinavDurumSql = "SELECT * FROM PM_SINAV_DURUM";
		$sinavDurumlari = $db->loadList($sinavDurumSql);
		
		$giden = array();
		$comboText = '';
	    foreach($sinavDurumlari AS $sinavDurumu){
	
			if($sinavDurumu['SINAV_DURUM_ID'] !=0)// tan�mlanmad� y� alma
			$comboText .= '<option value="' . $sinavDurumu['SINAV_DURUM_ID'] . '">'.$sinavDurumu['SINAV_DURUM_ADI'].'</option>';
	
		}
    	$giden[] = $sinavDurumlari;
    	$giden[] = $comboText;
		return $giden;
    }
    
    function getSinavSekli($db, $getData){
    	
    	$sinavId = $getData['sinavId'];    	
    			
		//if(!evrakSahibiMi($evrakId))
			//return -1;
    	
    	$sinavSekliSql = "SELECT SINAV_SEKLI_ID FROM M_SINAV
    			WHERE M_SINAV_ID = ?";
    	
    	$sinavSekli = $db->prep_exec($sinavSekliSql, array($sinavId));
    	
    	if(isset($sinavSekli[0]['SINAV_SEKLI_ID']))
			return $sinavSekli[0]['SINAV_SEKLI_ID'];
    	return -2;
    }
    
    function getSinavTuru($db, $getData){
    	
    	$sinavId = $getData['sinavId'];    	
    	    	    			
		//if(!evrakSahibiMi($evrakId))
			//return -1;
    	
    	$sinavSekliSql = "SELECT SINAV_TUR_ID FROM M_SINAV
    			WHERE M_SINAV_ID = ?";
    	
    	$sinavSekli = $db->prep_exec($sinavSekliSql, array($sinavId));
    	
    	if(isset($sinavSekli[0]['SINAV_TUR_ID']))
			return $sinavSekli[0]['SINAV_TUR_ID'];
    	return -2;
    }

}
?>
