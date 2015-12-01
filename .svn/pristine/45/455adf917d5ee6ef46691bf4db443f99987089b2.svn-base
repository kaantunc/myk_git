<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSertifika extends JModel {
	
	function sertifikaKaydet($db, $postData){
		
		//yeni evrak id al
		$userId =& JFactory::getUser()->getOracleUserId();
		$evrakId = FormFactory::evrakVerisiEkle($userId, SERTIFIKA_SAYI_ID);
//		    			
//		echo '$postData: <pre>';
//		print_r($postData);		
//		echo '</pre>';
		
		$ogrKapsamEkle = "INSERT INTO M_OGRENCI_ALT_BIRIM (M_SINAV_ID, TC_KIMLIK, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ID)
				VALUES(?, ?, ?, ?)";
		
		$yetId = "";
		
		$returnValues = array();// to check if the queries succeeded
		$sertifikaIstenenOgrSayisi = 0;
		
		for($i=1;isset($postData['inputbelgeDuzenlenecekBilgi-9-'.$i]);$i++){

			$tcKimlik = $postData['inputbelgeDuzenlenecekBilgi-2'][$i-1];
			
			for($j=0;isset($postData['inputbelgeDuzenlenecekBilgi-9-'.$i][$j]);$j++){
				$kapsamId = $postData['inputbelgeDuzenlenecekBilgi-9-'.$i][$j];
				
				if($kapsamId == KAPSAM_BASARISIZ)
					break;
				
				$sertifikaIstenenOgrSayisi++;
				if($yetId == ""){
					
					$yetIdAl = "SELECT DISTINCT YETERLILIK_ID
							FROM M_YETERLILIK_ALT_BIRIM
							WHERE YETERLILIK_ALT_BIRIM_ID = ?";
					
					$yetIds = $db->prep_exec($yetIdAl, array($kapsamId));
					$yetId = $yetIds[0]['YETERLILIK_ID'];
							
					//if(!yeterlilikSahibiMi($yetId))
						//return JText::_('YETERLILIK_YETKI_HATASI');
					
				}
				
				$params = array($evrakId, $tcKimlik, $kapsamId, $yetId);
				
//						echo '$postData: <pre>';
//		print_r($params);		
//		echo '</pre>';
			
				$returnValues[] = $db->prep_exec_insert($ogrKapsamEkle, $params);
				
			}

		}
		
		if(!FormFactory::isThereError($returnValues)){
					
			$sertifikaBasvuru = "INSERT INTO M_SERTIFIKA_BASVURU
				VALUES(?, SYSTIMESTAMP, ?)";
			
			$params = array($evrakId, $sertifikaIstenenOgrSayisi);
			
			$returnValues[] = $db->prep_exec_insert($sertifikaBasvuru, $params);

		}
		
		if(!FormFactory::isThereError($returnValues)){
			
			$serializedSinavIds = $postData['sinavIds'];
			
			$sinavIds = unserialize($serializedSinavIds);
			
			$updateSinav = "UPDATE M_SINAV
					SET BASARILI_ADAY = ?
					WHERE M_SINAV_ID = ?";
			
			foreach($sinavIds AS $sinavId){
				
				//if(!evrakSahibiMi($sinavId))
					//return JText::_('EVRAK_YETKI_HATASI');
				
				$params = array($sertifikaIstenenOgrSayisi, $sinavId);
				$returnValues[] = $db->prep_exec_insert($updateSinav, $params);
				
			}
			
		}
		
		if(!FormFactory::isThereError($returnValues))
			return JText::_('SERTIFIKA_KAYDEDILDI');
		else {
			return JText::_('SERTIFIKA_KAYDET_HATA');
		}
	}

    function getKapsamlar($db, $postData){
    	
    	//$yetId = isset($postData['yetId']) ? $postData['yetId'] : null;
    	
//    			
//		echo 'kpsam: <pre>';
//		print_r($_POST);		
//		echo '</pre>';
		
		    	
    	$userId = JFactory::getUser()->getOracleUserId();    	
    	
    	$yetId = $this->getSelectedYeterlilik($db, $userId, $postData);
    	
    	//echo "-$yetId-";
		//die();
    	//$yetId = "207";// Sınavlardan birinin yeterlilik id si olacak
    	
    	//echo "id: -$id-";
    			
		$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($yetId));
		
		$comboText = '';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboText .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
				$isFirst = false;
			}
			else
				$comboText .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
		}
			//$comboText.="**Başarısız##Başarısız";
		}
		
			return $comboText;
			    	
    }
    
    function getSelectedSinavIds($db, $userId, $postData){
    	    	
    	$tumSinavlarSql = "SELECT  M_SINAV_ID
    				FROM M_SINAV
    			WHERE 	USER_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
    	
		$sinavlar = $db->prep_exec($tumSinavlarSql,array($userId));
		
		$selected = array();
		
		foreach($sinavlar AS $sinavEvrakRow){
    		
    		$sinavId = $sinavEvrakRow['M_SINAV_ID'];
    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		
    		if(isset($postData['sertifika_'.$sinavId])){
    			
    			$selected[] = $sinavId;
    			
    		}
    		
		}
    	return $selected;
    }
    
    function getSelectedSinavlar($db, $sinavIds){
    	    	
    	$sqlIn = implode(',',$sinavIds);
    	    	    	
    	$tumSinavlarSql = "SELECT 
    					TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI_FORMATTED,
    					TOPLAM_ADAY,
    					YETERLILIK_ADI,
    					MERKEZ_ADI,
    					SINAV_TUR_ADI,
    					SINAV_SEKLI_ADI,
    					BASARILI_ADAY
    						FROM M_SINAV
    						JOIN M_YETERLILIK USING (YETERLILIK_ID)
    						JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    						JOIN PM_SINAV_TURU USING (SINAV_TUR_ID)
    						JOIN PM_SINAV_SEKLI USING (SINAV_SEKLI_ID)
    			WHERE 	M_SINAV_ID IN (".$sqlIn.")
    			ORDER BY SINAV_TARIHI DESC";
    	
		$sinavlar = $db->prep_exec($tumSinavlarSql,array());
				
    	return $sinavlar;
    }
    
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
    						NATURAL JOIN PM_SINAV_DURUM
    						NATURAL JOIN M_OGRENCI
    					WHERE M_SINAV_ID = ?";
    	
		$sinavSonuclar = $db->prep_exec($tumSinavlarSql,array($sinavId));
				
    	return $sinavSonuclar;
    }
    
    function getSelectedYeterlilik($db, $userId, $postData){
    	    	
    	$tumSinavlarSql = "SELECT M_SINAV_ID, YETERLILIK_ID
    				FROM M_SINAV
    			WHERE 	USER_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
    	
		$sinavlar = $db->prep_exec($tumSinavlarSql,array($userId));
		
		$selected = array();
		
		foreach($sinavlar AS $sinavEvrakRow){
    		
    		$sinavId = $sinavEvrakRow['M_SINAV_ID'];
    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		
    		if(isset($postData['sertifika_'.$sinavId])){
    			
    			return $sinavEvrakRow['YETERLILIK_ID'];
    			
    		}
    		
		}
    }
    
    // seçilen sınavların yeterlilikleri aynı mı diye kontrol eder
    function yeterlilikCeliskilimi($db, $postData){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    
    	    	
    	$tumSinavlarSql = "SELECT M_SINAV_ID, YETERLILIK_ID
    				FROM M_SINAV
    			WHERE 	USER_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
    	
		$sinavlar = $db->prep_exec($tumSinavlarSql,array($userId));
		
		$selected = array();
		
		$yetId = "";
		
		foreach($sinavlar AS $sinavEvrakRow){
    		
    		$sinavId = $sinavEvrakRow['M_SINAV_ID'];
    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		
    		if(isset($postData['sertifika_'.$sinavId])){
    			
    			if($yetId != "" && $yetId != $sinavEvrakRow['YETERLILIK_ID'])
    				return 1;
    			$yetId = $sinavEvrakRow['YETERLILIK_ID'];
    		}
    		
		}
		return 0;
    }
    
    function sinavSecildimi($db, $postData){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    
    	    	
    	$tumSinavlarSql = "SELECT M_SINAV_ID, YETERLILIK_ID
    				FROM M_SINAV
    			WHERE 	USER_ID = ? AND
    					BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI;
    	
		$sinavlar = $db->prep_exec($tumSinavlarSql,array($userId));
		
		$selected = false;
		
		foreach($sinavlar AS $sinavEvrakRow){
    		
    		$sinavId = $sinavEvrakRow['M_SINAV_ID'];
    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		
    		if(isset($postData['sertifika_'.$sinavId])){
    			$selected = true;
    			break;
    		}
    		
		}
		return $selected;
    }
    
    function getOgrenciler($db, $postData){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    	
    	
    	$sinavlar = $this->getSelectedSinavIds($db, $userId, $postData);
		
    	$ogrler = array();
    	
    	foreach($sinavlar AS $sinavId){
    		    		
    		//echo "-".$sinavEvrakId."-<br />";
    		    		    			
    			//echo "-".$sinavEvrakId."-";
    			
    			// sinava katilan ögr leri al, duplicate olmasın
    			
    			$tumSinavlarSql = "
    			SELECT  TC_KIMLIK,
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

}
?>
