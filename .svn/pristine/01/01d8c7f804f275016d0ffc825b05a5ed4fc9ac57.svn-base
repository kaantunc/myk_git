<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSertifika extends JModel {
	
	function sertifikaKaydet($db, $postData, $sinavIds){
		
		//echo '-';
		
		//yeni evrak id al
		$userId =& JFactory::getUser()->getOracleUserId();
		//$evrakId = FormFactory::evrakVerisiEkle($userId, SERTIFIKA_SAYI_ID);
//		    			

		/*$ogrKapsamEkle = "INSERT INTO M_OGRENCI_ALT_BIRIM
				VALUES(?, ?, ?, ?)";
		
		$yetId = "";
		*/
		$returnValues = array();// to check if the queries succeeded
		$sertifikaIstenenOgrSayisi = 0;
		//echo '-';
		for($i=1;isset($postData['inputbelgeDuzenlenecekBilgi-9-'.$i]);$i++){

			$tcKimlik = $postData['inputbelgeDuzenlenecekBilgi-2'][$i-1];
			
				$sertifikaIstenenOgrSayisi++;
			for($j=0;isset($postData['inputbelgeDuzenlenecekBilgi-9-'.$i][$j]);$j++){
				$kapsamId = $postData['inputbelgeDuzenlenecekBilgi-9-'.$i][$j];
				
				if($kapsamId == KAPSAM_BASARISIZ){
					$sertifikaIstenenOgrSayisi--;
					break;
				}
				
				if($yetId == ""){
					
					$yetIdAl = "SELECT DISTINCT YETERLILIK_ID
							FROM M_YETERLILIK_ALT_BIRIM
							WHERE YETERLILIK_ALT_BIRIM_ID = ?";
					
					$yetIds = $db->prep_exec($yetIdAl, array($kapsamId));
					$yetId = $yetIds[0]['YETERLILIK_ID'];
							
					//if(!yeterlilikSahibiMi($yetId))
						//return JText::_('YETERLILIK_YETKI_HATASI');
					
				}
				
				/*$params = array($evrakId, $tcKimlik, $kapsamId, $yetId);
				
//						echo '$postData: <pre>';
//		print_r($params);		
//		echo '</pre>';
			
				$returnValues[] = $db->prep_exec_insert($ogrKapsamEkle, $params);
			*/	
			}

		}
		//echo '-';
		if(!FormFactory::isThereError($returnValues)){
					
			$sertifikaBasvuru = "INSERT INTO M_SERTIFIKA_BASVURU (M_SINAV_ID, SERTIFIKA_BASVURU_TARIHI, SERTIFIKA_BASVURU_ID)
				VALUES(?, SYSTIMESTAMP, ?)";
			
			$params = array($sinavIds[0], $sertifikaIstenenOgrSayisi);
			
			$returnValues[] = $db->prep_exec_insert($sertifikaBasvuru, $params);

		}
		//echo '-';
		if(!FormFactory::isThereError($returnValues)){
			
//		echo '$postData: <pre>';
//		print_r($sinavIds);		
//		echo '</pre>';
			
			//$serializedSinavIds = $postData['sinavIds'];
			
			//$sinavIds = unserialize($serializedSinavIds);
			
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
		
		$this->getOgrenciler2($db, $sinavIds, $evrakId);
		
		if(!FormFactory::isThereError($returnValues)){
			//$session =&JFactory::getSession();
			//$session->clear('sertifikaPdfPostData');
			return JText::_('SERTIFIKA_KAYDEDILDI'). '<br />'. JText::_('ISLAK_IMZA');
		}
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
    	    	    	
    	/*$tumSinavlarSql = "SELECT 
    					TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI,
              YETERLILIK_ADI,
    					MERKEZ_ADI,
              SINAV_BIRIMLERI,
              TOPLAM_ADAY,
    					BASARILI_ADAY
    						FROM M_SINAV
    						JOIN M_YETERLILIK USING (YETERLILIK_ID)
    						JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    			WHERE M_SINAV_ID IN (".$sqlIn.")
    			ORDER BY SINAV_TARIHI DESC";*/
    	$tumSinavlarSql = "SELECT
    	    					TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI,
    	              			YETERLILIK_ADI,
    	    					MERKEZ_ADI,
    	             			SINAV_BIRIMLERI,
    	              			TOPLAM_ADAY,
    	    					BASARILI_ADAY
    	    						FROM M_SINAV
    	    						JOIN M_YETERLILIK USING (YETERLILIK_ID)
    	    						JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    	    			WHERE M_SINAV_ID IN (".$sqlIn.")
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
    						LEFT JOIN PM_SINAV_DURUM USING (SINAV_DURUM_ID)
    						NATURAL JOIN M_OGRENCI
    						JOIN M_SINAV USING (M_SINAV_ID)
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
    
    
    function getOgrenciler2($db, $sinavlar, $evrakId){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    	
    	
    	//$sinavlar = $this->getSelectedSinavIds($db, $userId, $postData);
		
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
					if(!$this->eklenmismi($ogrler, $ogr)){
						array_push($ogrler, $ogr);
						
						
				$sql= "UPDATE M_SINAV_SONUCU
					SET SERTIFIKA_EVRAK_ID = ?
						WHERE TC_KIMLIK = ? AND M_SINAV_ID = ?";
				
				$returnValues[] = $db->prep_exec_insert($sql, array($evrakId, $ogr['TC_KIMLIK'], $sinavId));
						
					}
				//$ogrler[] = $sinavOgrleri;
    			    		
    	}
    }
    function getOgrenciler3($db, $sinavlar){
    	
    	$userId = JFactory::getUser()->getOracleUserId();    	
    	
    	//$sinavlar = $this->getSelectedSinavIds($db, $userId, $postData);
		
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
    
    
    function getOgrenciler($db, $sinavlar){

    	$userId = JFactory::getUser()->getOracleUserId();
    
    	$ogrler = array();
    	$zorunlu_birimler = array();
    	 
    	foreach($sinavlar AS $sinavId){
    		$sql = "SELECT YENI_MI, YETERLILIK_ID FROM M_YETERLILIK JOIN M_SINAV USING(YETERLILIK_ID) WHERE M_SINAV_ID = ?";
    		$yenimi = $db->prep_exec($sql, array($sinavId));
    		
    		$ogr = "SELECT DISTINCT TC_KIMLIK FROM M_SINAV_SONUCU WHERE M_SINAV_ID = ?";
    		$ogrler = $db->prep_exec($ogr, array($sinavId));
    
    		if($yenimi[0]['YENI_MI'] == 0){
    		/*$tumSinavlarSql = "SELECT M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI, 
					OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, ALT_BIRIM_ID AS BIRIM_ID, SEKIL, 
					YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, ALDIGI_NOT, YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
					FROM M_SINAV_SONUCU
					JOIN M_SINAV USING(M_SINAV_ID)
					JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
					JOIN M_OGRENCI USING(TC_KIMLIK)
					JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					WHERE M_SINAV.YETERLILIK_ID = (SELECT YETERLILIK_ID FROM M_SINAV WHERE M_SINAV_ID = ?) 
					AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ."
					AND SERTIFIKA_DURUM_ID = 0
    				AND USER_ID = (SELECT USER_ID FROM M_SINAV WHERE M_SINAV_ID = ?) ORDER BY ALT_BIRIM_ID";*/
    			
    			$tumSinavlarSql = "SELECT DISTINCT M_SINAV.M_SINAV_ID, M_SINAV.SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI, 
					OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, M_SINAV_SONUCU.ALT_BIRIM_ID AS BIRIM_ID, M_SINAV_SONUCU.SEKIL, 
					YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, ALDIGI_NOT, YENI_MI, SINAV_SAAT, GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
					FROM M_SINAV_SONUCU
					JOIN M_SINAV ON M_SINAV_SONUCU.M_SINAV_ID =M_SINAV.M_SINAV_ID
          			JOIN M_SINAV_TAKVIMI ON (M_SINAV.SINAV_TARIHI = TAKVIM_SINAV_TARIHI AND M_SINAV.MERKEZ_ID = M_SINAV_TAKVIMI.MERKEZ_ID
         				 AND M_SINAV.USER_ID = M_SINAV_TAKVIMI.USER_ID AND M_SINAV.YETERLILIK_ID = M_SINAV_TAKVIMI.YETERLILIK_ID)
					JOIN M_SINAV_MERKEZI ON M_SINAV.MERKEZ_ID = M_SINAV_MERKEZI.MERKEZ_ID
					JOIN M_OGRENCI USING(TC_KIMLIK)
					JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
         			WHERE M_SINAV.YETERLILIK_ID = (SELECT YETERLILIK_ID FROM M_SINAV WHERE M_SINAV_ID = ?) 
						AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ."
						AND SERTIFIKA_DURUM_ID = 0
    					AND M_SINAV.USER_ID = (SELECT USER_ID FROM M_SINAV WHERE M_SINAV_ID = ?) 
            			AND TO_CHAR(GECERLILIK_TARIHI, 'YYYYMMDD') > TO_CHAR(sysdate, 'YYYYMMDD')
            			ORDER BY M_SINAV_SONUCU.ALT_BIRIM_ID";
    		 
    		$sinavOgrleri[] = $db->prep_exec($tumSinavlarSql,array($sinavId, $sinavId));
    		
    		$zorbirimlerSql = "SELECT YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI
    							FROM M_YETERLILIK_ALT_BIRIM 
    							WHERE YETERLILIK_ID = ? AND YETERLILIK_ZORUNLU = 1 ORDER BY YETERLILIK_ALT_BIRIM_ID";
  
    		$zorunlu_birimler = $db->prep_exec($zorbirimlerSql,array($yenimi[0]['YETERLILIK_ID']));
    		}
    		else{
    			/*$sql= "SELECT M_SINAV_ID, SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI,
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
    			WHERE M_SINAV.YETERLILIK_ID = (SELECT YETERLILIK_ID FROM M_SINAV WHERE M_SINAV_ID = ?)
    			AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ." 
    			AND SERTIFIKA_DURUM_ID = 0
    			AND USER_ID = (SELECT USER_ID FROM M_SINAV WHERE M_SINAV_ID = ?) ORDER BY ALT_BIRIM_ID";*/
    			
    			$sql = "SELECT DISTINCT M_SINAV.M_SINAV_ID, M_SINAV.SINAV_TARIHI, TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, 
					        OGRENCI_BABA_ADI, OGRENCI_KAYIT_NO,M_YETERLILIK.YETERLILIK_ID, YETERLILIK_ADI, M_SINAV_SONUCU.ALT_BIRIM_ID, BIRIM_ID, 
					        BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA, ALDIGI_NOT, M_YETERLILIK.YENI_MI, SINAV_SAAT, 
					        GOZETMEN, DEGERLENDIRICI, MERKEZ_ADI
		    			FROM M_SINAV_SONUCU
		    			JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_SONUCU.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
		    			JOIN M_SINAV ON M_SINAV_SONUCU.M_SINAV_ID =M_SINAV.M_SINAV_ID
				        JOIN M_SINAV_TAKVIMI ON M_SINAV.SINAV_TARIHI = TAKVIM_SINAV_TARIHI AND M_SINAV.MERKEZ_ID = M_SINAV_TAKVIMI.MERKEZ_ID
				        	AND M_SINAV.USER_ID = M_SINAV_TAKVIMI.USER_ID AND M_SINAV.YETERLILIK_ID = M_SINAV_TAKVIMI.YETERLILIK_ID
				        JOIN M_SINAV_MERKEZI ON M_SINAV.MERKEZ_ID = M_SINAV_MERKEZI.MERKEZ_ID
		    			JOIN M_OGRENCI USING(TC_KIMLIK)
		    			JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
		    			JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
		    			JOIN M_BIRIM USING(BIRIM_ID)
		    			WHERE M_SINAV.YETERLILIK_ID = (SELECT YETERLILIK_ID FROM M_SINAV WHERE M_SINAV_ID = ?) 
							AND SINAV_DURUM_ID = 1 AND BASARILI_ADAY != ".BASARILI_ADAY_EKLENMEDI ."
							AND SERTIFIKA_DURUM_ID = 0
	    					AND M_SINAV.USER_ID = (SELECT USER_ID FROM M_SINAV WHERE M_SINAV_ID = ?) 
	            			AND TO_CHAR(GECERLILIK_TARIHI, 'YYYYMMDD') > TO_CHAR(sysdate, 'YYYYMMDD')
	            			ORDER BY M_SINAV_SONUCU.ALT_BIRIM_ID";
    			
    			$sinavOgrleri[] = $db->prep_exec($sql,array($sinavId, $sinavId));
    			
    			$zorbirimlerSql = "SELECT BIRIM_ID, BIRIM_ADI 
    								FROM M_YETERLILIK_BIRIM 
    								WHERE YETERLILIK_ID = ? AND ZORUNLU = 1 ORDER BY BIRIM_ID";
    			
    			$zorunlu_birimler = $db->prep_exec($zorbirimlerSql,array($yenimi[0]['YETERLILIK_ID']));
    		}
    		$sinavOgrleri[] = $ogrler;
    		$sinavOgrleri[] = $zorunlu_birimler;
    	}
    	 
	 
    	return $sinavOgrleri;
    }
    
    function sertifikaIstegiKaydet($db, $postData){
    	$_db =& JFactory::getDBO();
    	$sqlbildirim = "SELECT DISTINCT tgUserId FROM jos_community_acl_users
    	    					JOIN jos_users ON user_id = jos_users.id 
    	    					WHERE group_id = 17 ORDER BY tgUserId";
    	
    	$_db->setQuery($sqlbildirim);
    	$bildirims = $_db->loadResultArray();
    	
    	$tc = $postData["tc"];
    	$birim = $postData["birim"];
    	$sekil = $postData["sekil"];
    	$sinav = $postData["sinav"];
    	$yeterlilik = $postData["yeterlilik"];
    	$yenimi = $postData["yenimi"];
    	$sinavbirim_id = $postData["sinavbirim_id"];
    	$user_id = $postData["user_id"];
    	$returnValues = array();
    	
			foreach($tc as $rows){
				$seridsql = "SELECT DISTINCT SERTIFIKA_BASVURU_ID FROM M_SERTIFIKA_BASVURU ORDER BY SERTIFIKA_BASVURU_ID DESC";
					
				$serid = $db->prep_exec($seridsql, array());
				
				$yeniSertifikaBasvuruID = $db->getNextVal(SERTIFIKA_BASVURU_ID_SEQ);
				
				for($ii = 0; $ii < count($yenimi[$rows]); $ii++){
					if($yenimi[$rows][$ii] == 0){
							
							$sertifikaBasvuru = "INSERT INTO M_SERTIFIKA_BASVURU (SERTIFIKA_BASVURU_ID, M_SINAV_ID, SERTIFIKA_BASVURU_TARIHI, USER_ID, TC_KIMLIK, YETERLILIK_ID, BIRIM_ID, SEKIL, SERTIFIKA_DURUM_ID)
							    							VALUES(?, ?, SYSTIMESTAMP, ?, ?, ?, ?, ?, ?)";
							$params = array($yeniSertifikaBasvuruID, $sinav[$rows][$ii], $user_id, $rows, $yeterlilik[$rows][$ii], $birim[$rows][$ii], $sekil[$rows][$ii], 0);
							
							$returnValues[] = $db->prep_exec_insert($sertifikaBasvuru, $params);
							
							$sinavsonucuUpdate = "UPDATE M_SINAV_SONUCU SET SERTIFIKA_BASVURU_ID = ?, SERTIFIKA_DURUM_ID = 1 WHERE TC_KIMLIK = ? AND M_SINAV_ID = ? AND ALT_BIRIM_ID = ? AND SEKIL = ?";
							
							$karams = array($yeniSertifikaBasvuruID, $rows, $sinav[$rows][$ii], $birim[$rows][$ii], $sekil[$rows][$ii]);
							
							$db->prep_exec($sinavsonucuUpdate, $karams);
							
							$sonucGirildiSql = "UPDATE M_SINAV
							    	SET BASARILI_ADAY = ".SERTIFIKA_BASVURULDU."
							    	WHERE M_SINAV_ID = ?";
							
							$db->prep_exec_insert($sonucGirildiSql, array($sinav[$rows][$ii]));
					}
					else{
						
							$sertifikaBasvuru = "INSERT INTO M_SERTIFIKA_BASVURU (SERTIFIKA_BASVURU_ID, M_SINAV_ID, SERTIFIKA_BASVURU_TARIHI, USER_ID, TC_KIMLIK, YETERLILIK_ID, BIRIM_ID, BIRIM_SINAV_ID, SERTIFIKA_DURUM_ID)
														    							VALUES(?, ?, SYSTIMESTAMP, ?, ?, ?, ?, ?, ?)";
							$params = array($yeniSertifikaBasvuruID, $sinav[$rows][$ii], $user_id, $rows, $yeterlilik[$rows][$ii], $birim[$rows][$ii], $sinavbirim_id[$rows][$ii], 0);
							
							$returnValues[] = $db->prep_exec_insert($sertifikaBasvuru, $params);
							
							$sinavsonucuUpdate = "UPDATE M_SINAV_SONUCU SET SERTIFIKA_BASVURU_ID = ?, SERTIFIKA_DURUM_ID = 1 WHERE TC_KIMLIK = ? AND M_SINAV_ID = ? AND ALT_BIRIM_ID = ?";
							
							$karams = array($yeniSertifikaBasvuruID, $rows, $sinav[$rows][$ii], $sinavbirim_id[$rows][$ii]);
							
							$db->prep_exec($sinavsonucuUpdate, $karams);
							
							$sonucGirildiSql = "UPDATE M_SINAV
														    	SET BASARILI_ADAY = ".SERTIFIKA_BASVURULDU."
														    	WHERE M_SINAV_ID = ?";
								
							$db->prep_exec_insert($sonucGirildiSql, array($sinav[$rows][$ii]));
					}
				}
			}
    
    			if(!FormFactory::isThereError($returnValues)){
    				$sqlUser = "SELECT KURULUS_ADI FROM M_KURULUS WHERE USER_ID =".$user_id;
    				$user_ad = $db->prep_exec($sqlUser, array());
    				
    				$sqluyarid = "SELECT UYARI_ID FROM M_UYARILAR ORDER BY UYARI_ID DESC";
    				$sqluyari = "INSERT INTO M_UYARILAR (UYARI_ID ,FROM_USER_ID, ACIKLAMA, LINK, TARIH, TO_USER_ID) VALUES(?, ?, ?, ?, ?, ?)";
    				$aciklama = $user_ad[0]["KURULUS_ADI"]."Tarafından Sertifika Başvurusu Yapıldı.";
    				$link = "index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=sorgu_sonuc&userId=".$user_id."&tarih=".date("d.m.Y");
    				foreach($bildirims as $cows){
    					$uyari_id = $db->prep_exec($sqluyarid, array());
    					$sonucc = $db->prep_exec_insert($sqluyari, array($db->getNextVal(UYARI_ID_SEQ) ,$user_id, $aciklama, $link, time(), $cows));
    				}
    				return JText::_('SERTIFIKA_KAYDEDILDI'). '<br/>'. JText::_('ISLAK_IMZA');
    			}
    			else {
    			return JText::_('SERTIFIKA_KAYDET_HATA');
    		}
    
    	}

}
?>
