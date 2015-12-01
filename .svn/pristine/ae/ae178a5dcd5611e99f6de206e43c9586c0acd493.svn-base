<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Oncesi extends JModel {
	
	    
    function getSinavSekilleri($db, $postData){
    	
    	if(isset($postData['yetId']) && isset($postData['merkezId'])){
    		$yetId = $postData['yetId'];
    		$merkezId = $postData['merkezId'];
    	}
    	else
    		return "";    	
    	    	    	
    	// @todo kontrol et bunu
		$sql = "SELECT SINAV_SEKLI_ID, SINAV_SEKLI_ADI FROM PM_SINAV_SEKLI
		    NATURAL JOIN M_MERKEZ_SINAV
		    NATURAL JOIN M_YETERLILIK
		        WHERE MERKEZ_ID = ? AND
		            YETERLILIK_ID = ? AND
		            YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
		 
		$kapsamlar = $db->prep_exec($sql, array($merkezId, $yetId));
		
		$comboStr = $yetId.'#*#';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["SINAV_SEKLI_ID"] . "##". $row["SINAV_SEKLI_ADI"];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["SINAV_SEKLI_ID"] . "##". $row["SINAV_SEKLI_ADI"];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		echo $comboStr;
    	
    }
    
	
	function sinavKaydet($db, $postData){
		
		//$evrakId = isset($postData['evrakId']) ? $postData['evrakId'] : null;
		//$userId = isset($postData['userId']) ? $postData['userId'] : null;
		$yeterlilikId = isset($postData['yeterlilik_konusu']) ? $postData['yeterlilik_konusu'] : null;
		
		
		
		//if(!JFactory::getUser()->yeterlilikSahibiMi($yeterlilikId))
			//return JText::_('YETERLILIK_YETKI_HATASI');
		
		// merkez kendi merkezi mi kontrolü
		$sinavTarihi = isset($postData['sinav_tarihi']) ? $postData['sinav_tarihi'] : null;
		$sinaviYapan = isset($postData['sinavi_yapan']) ? $postData['sinavi_yapan'] : null;
		$merkezId = isset($postData['sinav_yeri']) ? $postData['sinav_yeri'] : null;
		$sinavTuruId = isset($postData['sinav_turu']) ? $postData['sinav_turu'] : null;
		$sinavSekliId = isset($postData['sinav_sekli']) ? $postData['sinav_sekli'] : null;
		//$sinav_kapsamlari = isset($postData['sinav_kapsami']) ? $postData['sinav_kapsami'] : null;
		
		$bilgiValues = FormFactory::getTableValues($postData, array("belgeDuzenlenecekBilgi", 8));
		
		$toplamAday = $this->countOgr($bilgiValues);// ogrleri say
		$basariliAday = "";// sonuc girerken
		
		echo 'post: <pre>';
		print_r($postData);	
		echo '</pre>';
		
		$userId =& JFactory::getUser()->getOracleUserId();
		
		$evrakId = FormFactory::evrakVerisiEkle($userId, SINAV_ONCESI_SAYI_ID);
		
//		$getYetIdSql = "SELECT YETERLILIK_ID FROM M_YETERLILIK_ALT_BIRIM
//							WHERE YETERLILIK_ALT_BIRIM_ID = ?";
//			
//		$yeterlilikId = $db->prep_exec($getYetIdSql, array($sinav_kapsamlari[0]));
//		$yeterlilikId = $yeterlilikId[0]['YETERLILIK_ID'];
		
//		$sql = "SELECT EVRAK_ID
//					FROM m_sinav
//				WHERE EVRAK_ID = ?";
		
		$returnValues = array();// to check if the queries succeeded
	
		//$sonuclar = $db->prep_exec($sql, array($evrakId));
		
		//if(empty($sonuclar)){
		
		$sinavId = $db->getNextVal('SINAV_ID_SEQ');
		
			$sql = "INSERT INTO m_sinav
					values(?, ?, ?, ?, ?, ?, 
					
					(SELECT SINAV_SEKLI_ID
					    FROM M_SINAV_MERKEZI
					      NATURAL JOIN M_MERKEZ_SINAV
					      WHERE MERKEZ_ID = ? AND
					          YETERLILIK_ID = ?),
					          
					 TO_DATE(?,'dd.mm.yyyy'), ?,
															
					".BASARILI_ADAY_EKLENMEDI.", ?)";
			
			$params = array($sinavId,
							$userId,
							$merkezId,
							$yeterlilikId,
							$evrakId,
							$sinavTuruId,
							
							$merkezId,
							$yeterlilikId,
							
							$sinavTarihi,
							$toplamAday,
							$sinaviYapan);
							
			//echo '**********<br>';
			$returnValues[] = $db->prep_exec_insert($sql, $params);
			//echo '**********<br>';
//		}
//		else{
//			
//			$sql = "UPDATE m_sinav SET
//						YETERLILIK_ID = ?,
//						SINAV_TARIHI = TO_DATE(?,'dd.mm.yyyy'),  
//						TOPLAM_ADAY = ?,
//						BASARILI_ADAY = ?
//					WHERE EVRAK_ID = ?";
//			
//			$params = array($yeterlilikId, $sinavTarihi, $toplamAday, $basariliAday, $evrakId);
//			
//			$returnValues[] = $db->prep_exec_insert($sql, $params);
//			
//		}
		
		//echo "-".$userId."-***";
		
	//	echo "***-".SINAV_ONCESI_SAYI_ID."-".$evrakId;
				
		//$yeterlilikId = $db->prep_exec($getYetIdSql, array($sinav_kapsamlari[0]));
			
		// kontrol et varmı diye varsa güncelle
		
		// $sinav_kapsamlari ni kaydet sinav_alt_birim tablosuna
			
		echo 'bilgi values: <pre>';
		print_r($bilgiValues);	
		echo '</pre>';	
		
		$ogrEkleSql = "INSERT INTO M_OGRENCI (TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI, OGRENCI_KAYIT_NO)
				VALUES(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?)";
		
		$valCount = count($bilgiValues);
		//echo "-$valCount-";
		for($i=0;$i<$valCount;$i += 8){
			
			$params = array_slice($bilgiValues, $i, 8);
			
			// kimlik noya göre değerleri al ona göre ekle
			
			$ogr['kimlik_no'] = $params[1];
			$ogr = $this->checkOgr($db, $ogr, "array");
				
//			echo 'mevct ogr: <pre>';
//			print_r($ogr);	
//			echo '</pre>';
			
			//$params[0] = $evrakId;
			array_splice($params, 0, 1);
			if(!empty($ogr)){
			
//				$params[0] = $ogr[0]['TC_KIMLIK'];
//				$params[1] = $ogr[0]['OGRENCI_ADI'];
//				$params[2] = $ogr[0]['OGRENCI_SOYADI'];
//				$params[3] = $ogr[0]['OGRENCI_DOGUM_TARIHI'];
//				$params[4] = $ogr[0]['OGRENCI_DOGUM_YERI'];
//				$params[5] = $ogr[0]['OGRENCI_BABA_ADI'];
//				$params[6] = $ogr[0]['OGRENCI_KAYIT_NO'];
				//array_splice($params, 7, 1);
			}else{
											
//				echo '$params: <pre>';
//				print_r($params);	
//				echo '</pre>';
				
				$db->prep_exec_insert($ogrEkleSql, $params);
			}

			
			
			$ogrSinavEkle = "INSERT INTO M_OGRENCI_SINAV (TC_KIMLIK, M_SINAV_ID)
					VALUES(?, ?)";
			$returnValues[] = $db->prep_exec_insert($ogrSinavEkle, array($params[0], $sinavId));
			
		}
		//die();
		if(FormFactory::isThereError($returnValues))
			return JText::_('SINAV_ONCESI_KAYDET_HATA');
		else
			return JText::_('SINAV_ONCESI_KAYDEDILDI');
		
		
	}

    function getTumKapsamlar($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM
					WHERE YETERLILIK_ID IN (
				  SELECT DISTINCT YETERLILIK_ID FROM M_YETERLILIK_TALEBI
				        NATURAL JOIN M_YETERLILIK
				        NATURAL JOIN PM_YETERLILIK_SUREC_DURUM
				      WHERE (YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID.")
				        AND YETERLILIK_ID IN 
				          (SELECT EVRAK_ID 
				            FROM M_BASVURU
				          WHERE USER_ID = ?)
					)";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id));
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
				$comboStr .= '<option value="'.$row["YETERLILIK_ALT_BIRIM_ID"] . '">'. $row["YETERLILIK_ALT_BIRIM_ADI"] . '</option>';
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
    function getYeterlilikler($db, $merkezId){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI, MERKEZ_ID
					FROM M_BASVURU
					JOIN M_SINAV_MERKEZI USING (EVRAK_ID)
		          	JOIN M_MERKEZ_SINAV USING (MERKEZ_ID)
		          	JOIN M_YETERLILIK USING(YETERLILIK_ID)
		      WHERE USER_ID = ? AND
		            MERKEZ_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id, $merkezId));
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
				$comboStr .= '<option value="'.$row["YETERLILIK_ID"] . '">'. $row["YETERLILIK_ADI"] . '</option>';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		return $comboStr;
    	
    }
    
    function getMerkezler($db, $merkezId){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT MERKEZ_ID, MERKEZ_ADI
					FROM M_BASVURU
					JOIN M_SINAV_MERKEZI USING (EVRAK_ID)
		      WHERE USER_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id));
		
		$comboStr = '';
		$selected = '';
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
				if($merkezId != null && $merkezId == $row['MERKEZ_ID'])
					$selected = 'selected="selected"';
				
				$comboStr .= '<option '.$selected.' value="'.$row["MERKEZ_ID"] . '">'. $row["MERKEZ_ADI"] . '</option>';
				$selected = '';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
//    function getYeterlilikler($db){
//    	
//    	$user_id = JFactory::getUser()->getOracleUserId();
//    			
//		$sql = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI FROM M_YETERLILIK_TALEBI
//				        NATURAL JOIN M_YETERLILIK
//				        NATURAL JOIN PM_YETERLILIK_SUREC_DURUM
//				      WHERE (YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID.")
//				        AND YETERLILIK_ID IN 
//				          (SELECT EVRAK_ID 
//				            FROM M_BASVURU
//				          WHERE USER_ID = ?) ORDER BY YETERLILIK_ADI";
//		 
//		$kapsamlar = $db->prep_exec($sql, array($user_id));
//		
//		$comboStr = '';
//		
//		if(isset($kapsamlar)){
//		foreach ($kapsamlar as $row){
//				$comboStr .= '<option value="'.$row["YETERLILIK_ID"] . '">'. $row["YETERLILIK_ADI"] . '</option>';
//		}
//			//$comboStr.="**Başarısız##Başarısız";
//		}
//		
//			return $comboStr;
//    	
//    }
    
    function getSinavTurleri($db){
    	    			
		$sql = "SELECT * FROM PM_SINAV_TURU";
		 
		$kapsamlar = $db->prep_exec($sql, array());
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
				$comboStr .= '<option value="'.$row["SINAV_TUR_ID"] . '">'. $row["SINAV_TUR_ADI"] . '</option>';
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
    /*function getSinavSekilleri($db, $merkezId, $yetId){
    	    			
		$sql = "SELECT SINAV_SEKLI_ID, SINAV_SEKLI_ADI FROM M_MERKEZ_SINAV
					JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
					JOIN PM_SINAV_SEKLI USING (SINAV_SEKLI_ID)
				WHERE YETERLILIK_ID = ? AND
					MERKEZ_ID = ?";
		 
		$sinavSekilleri = $db->prep_exec($sql, array($yetId, $merkezId));
		
		$comboStr = '';
		
		if(isset($sinavSekilleri)){
			foreach ($sinavSekilleri as $row){
					$comboStr .= '<option value="'.$row["SINAV_SEKLI_ID"] . '">'. $row["SINAV_SEKLI_ADI"] . '</option>';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }*/
    
    function checkOgr($db, $postData, $returnType="string"){
    	
    	$kimlikNo = $postData['kimlik_no'];
    	$id = isset($postData['id']) ? $postData['id'] : null;
    	
    	$sql = "SELECT 	TC_KIMLIK,
    					OGRENCI_ADI,
    					OGRENCI_SOYADI,
    					TO_CHAR(OGRENCI_DOGUM_TARIHI, 'dd.mm.yyyy') AS OGRENCI_DOGUM_TARIHI,
    					OGRENCI_DOGUM_YERI,
    					OGRENCI_BABA_ADI,
    					OGRENCI_KAYIT_NO
    			FROM M_OGRENCI 
  						WHERE TC_KIMLIK = ?";
    	
    	$kapsamlar = $db->prep_exec($sql, array($kimlikNo));
    	
    	/*echo "<?xml version=\"1.0\" ?>";
    	echo "<ogrenci>";
    	
    	echo '<kimlikNo>'.$kapsamlar[0]['TC_KIMLIK'].'</kimlikNo>';
    	echo '<ad>'.$kapsamlar[0]['OGRENCI_ADI'].'</ad>';
    	echo '<soyad>'.$kapsamlar[0]['OGRENCI_SOYADI'].'</soyad>';
    	echo '<dtarih>'.$kapsamlar[0]['OGRENCI_DOGUM_TARIHI'].'</dtarih>';
    	echo '<dyeri>'.$kapsamlar[0]['OGRENCI_DOGUM_YERI'].'</dyeri>';
    	echo '<babaAdi>'.$kapsamlar[0]['OGRENCI_BABA_ADI'].'</babaAdi>';
    	echo '<kayitNo>'.$kapsamlar[0]['OGRENCI_KAYIT_NO'].'</kayitNo>';
    	
    	echo "</ogrenci>";
    	*/
    	if($returnType == "string"){
	    	if(empty($kapsamlar))
	    		echo "no#*#". $id;
	    	else{
		    	echo $id . '#*#'.
				    	$kapsamlar[0]['TC_KIMLIK']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_ADI']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_SOYADI']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_DOGUM_TARIHI']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_DOGUM_YERI']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_BABA_ADI']. '#*#'.
				    	$kapsamlar[0]['OGRENCI_KAYIT_NO'];
	    	}
	    	die();
    	}
    	else
    		return $kapsamlar;
    }
    
    function countOgr($bilgiValues){
    	return count($bilgiValues)/8;
    }

}
?>
