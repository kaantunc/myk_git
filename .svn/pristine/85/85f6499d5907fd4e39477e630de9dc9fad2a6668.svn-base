<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSertifika_Ozet extends JModel {
	
	
   	function getTumSinavSonuclari($db, $sinavIds){
   		
   		$tumSonuclar = array();
   		
   		foreach($sinavIds AS $sinavId){
   			
   			$tumSonuclar[] = $this->getSinavSonuclari($db, $sinavId);
   			
   		}
   		
   		return $tumSonuclar;
   	}
    
	
    function getSinavSonuclari($db, $sinavId){
    	    	    	    	    	
    	$tumSinavlarSql = "SELECT *
    						FROM M_SINAV_SONUCU
    						LEFT JOIN PM_SINAV_DURUM USING (SINAV_DURUM_ID)
    						NATURAL JOIN M_OGRENCI
    						JOIN M_SINAV USING (M_SINAV_ID)
               			    JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
    					WHERE M_SINAV_ID = ?";
    	
		$sinavSonuclar = $db->prep_exec($tumSinavlarSql,array($sinavId));
				
    	return $sinavSonuclar;
    }
    
    function getOgrenciler1($db, $sinavlar){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    	
    	
    	//$sinavlar = $this->getSelectedSinavIds($db, $userId, $postData);
		
    	$ogrler = array();
    	
    	foreach($sinavlar AS $sinavId){
    		    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		    			
    			//echo "-".$sinavEvrakId."-";
    			
    			// sinava katilan ögr leri al, duplicate olmasın
    			
    			$tumSinavlarSql = "
    			SELECT DISTINCT TC_KIMLIK,
    					OGRENCI_ADI,
    					OGRENCI_SOYADI,
    					TO_CHAR(OGRENCI_DOGUM_TARIHI, 'dd.mm.yyyy')
    						AS OGRENCI_DOGUM_TARIHI,
    					OGRENCI_DOGUM_YERI,
    					OGRENCI_BABA_ADI,
    					OGRENCI_KAYIT_NO
    					
    			FROM    M_OGRENCI_SINAV
              			NATURAL JOIN M_SINAV
    					NATURAL JOIN M_OGRENCI
    					
    			WHERE 	USER_ID = ? AND
    					M_SINAV_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI . "
    					
    			ORDER BY SINAV_TARIHI DESC";
    	
				$sinavOgrleri = $db->prep_exec($tumSinavlarSql,array($userId, $sinavId));
				
						
//		echo 'sinavOgrleri: <pre>';
//		print_r($sinavOgrleri);		
//		echo '</pre>';
				foreach($sinavOgrleri AS $ogr)
					if(!$this->eklenmismi($ogrler, $ogr))
						array_push($ogrler, $ogr);
				//$ogrler[] = $sinavOgrleri;
    			    		
    	}
    	
    					
						
//		echo 'ogrler: <pre>';
//		print_r($ogrler);		
//		echo '</pre>';
    	
    	return $ogrler;
    }
    
    function eklenmismi($ogrler, $yeni){
    	
    	foreach($ogrler AS $ogr)
    		if($ogr['TC_KIMLIK'] == $yeni['TC_KIMLIK'])
    			return true;
    	return false;
    }

    function getSinavlar($db, $postData){    	
    	$sinavIds = unserialize($postData['sinavIds']);
    	
		$soruStr = $this->getSoruStr($sinavIds);
    	
		$sql = "SELECT M_SINAV_ID,
						SINAV_SEKLI_ID,
						SINAV_TUR_ADI,
						TO_CHAR(SINAV_TARIHI,'dd.mm.yyyy') AS SINAV_TARIHI_FORMATTED,
						MERKEZ_ADI,
						TOPLAM_ADAY,
						GOZETMEN,
						DEGERLENDIRICI
    				FROM M_SINAV 
    				JOIN PM_SINAV_TURU USING (SINAV_TUR_ID) 
    				JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    			WHERE 	M_SINAV_ID IN ( " . $soruStr . " ) AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
		 
		$sinavlar = $db->prep_exec($sql, $sinavIds);
		
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
    
    function getOgrencilerBak($db, $postdata){
    
    	foreach($postdata['tc_kimlik'] AS $deger){
    		$data = explode('_', $deger);
    		$yeterlilikId = $data[1];
    		$tc_kimlik = $data[0];
    		
    		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    		$yenimi = $db->prep_exec($sql, array($yeterlilikId));
    
    		if($yenimi[0]['YENI_MI'] == 0){
    			$tumSinavlarSql = "SELECT DISTINCT M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI,
    					OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, ALT_BIRIM_ID, SEKIL, 
    					YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_NO, ALDIGI_NOT, YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
    					FROM M_SINAV_SONUCU
    					JOIN M_SINAV USING(M_SINAV_ID)
    					JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
    					JOIN M_OGRENCI USING(TC_KIMLIK)
    					JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
    					JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
              			WHERE M_SINAV.YETERLILIK_ID = ? AND TC_KIMLIK = ? 
              			AND SERTIFIKA_DURUM_ID = 0
    					AND SINAV_DURUM_ID = 1  AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ." ORDER BY YETERLILIK_ALT_BIRIM_ID";
    			//AND YETERLILIK_ZORUNLU = 1
    			 
    			$sinavOgrleri['ogr'][$tc_kimlik] = $db->prep_exec($tumSinavlarSql,array($yeterlilikId, $tc_kimlik));
    
    		}
    		else{
    			$sql= "SELECT DISTINCT ID, M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI,
        			OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, ALT_BIRIM_ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF,
        			OLC_DEG_NUMARA, ALDIGI_NOT, M_YETERLILIK.YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
        			FROM M_SINAV_SONUCU
        			JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
        			JOIN M_SINAV USING(M_SINAV_ID)
        			JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
        			JOIN M_OGRENCI USING(TC_KIMLIK)
        			JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
        			JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
        			JOIN M_BIRIM USING(BIRIM_ID)
        			WHERE M_SINAV.YETERLILIK_ID = ? AND TC_KIMLIK = ?
        			AND SERTIFIKA_DURUM_ID = 0
        			AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ." ORDER BY ALT_BIRIM_ID";
    			 
    			$sinavOgrleri['ogr'][$tc_kimlik] = $db->prep_exec($sql,array($yeterlilikId, $tc_kimlik));
    		}
    		$tc[] = $tc_kimlik; 
    	}
    	$sinavOgrleri['tc'] = $tc; 
    
    	return $sinavOgrleri;
    }
    
    function getOgrenciler($db, $postdata){
    
    	foreach($postdata['tc_kimlik'] AS $deger){
    		$data = explode('_', $deger);
    		$yeterlilikId = $data[1];
    		$tc_kimlik = $data[0];
    
    		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    		$yenimi = $db->prep_exec($sql, array($yeterlilikId));
    
    		if($yenimi[0]['YENI_MI'] == 0){
    			$tumSinavlarSql = "SELECT DISTINCT M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI,
        					OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, ALT_BIRIM_ID, SEKIL, 
        					YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_NO, ALDIGI_NOT, YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
        					FROM M_SINAV_SONUCU
        					JOIN M_SINAV USING(M_SINAV_ID)
        					JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
        					JOIN M_OGRENCI USING(TC_KIMLIK)
        					JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
        					JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
                  			WHERE M_SINAV.YETERLILIK_ID = ? AND TC_KIMLIK = ? 
                  			AND SERTIFIKA_DURUM_ID = 0
        					AND SINAV_DURUM_ID = 1  AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ." ORDER BY YETERLILIK_ALT_BIRIM_ID ";
    			//AND YETERLILIK_ZORUNLU = 1
    
    			$sinavOgrleri['ogr'][$tc_kimlik] = $db->prep_exec($tumSinavlarSql,array($yeterlilikId, $tc_kimlik));
    
    		}
    		else{
    			$sql= "SELECT DISTINCT ID, M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI,
            			OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, ALT_BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF,
            			OLC_DEG_NUMARA, ALDIGI_NOT, M_YETERLILIK.YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
            			FROM M_SINAV_SONUCU
            			JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
            			JOIN M_SINAV USING(M_SINAV_ID)
            			JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
            			JOIN M_OGRENCI USING(TC_KIMLIK)
            			JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
            			JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
            			JOIN M_BIRIM USING(BIRIM_ID)
            			WHERE M_SINAV.YETERLILIK_ID = ? AND TC_KIMLIK = ?
            			AND SERTIFIKA_DURUM_ID = 0
            			AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ." ORDER BY ALT_BIRIM_ID";
    
    			$sinavOgrleri['ogr'][$tc_kimlik] = $db->prep_exec($sql,array($yeterlilikId, $tc_kimlik));
    		}
    		$tc[] = $tc_kimlik;
    	}
    	$sinavOgrleri['tc'] = $tc;
    
    	return $sinavOgrleri;
    }
	
}
?>