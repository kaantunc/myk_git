<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Oncesi extends JModel {
	
	function getsinavOncedenVarmi($db, $post){
		$sql = "SELECT * FROM M_SINAV 
				WHERE USER_ID=? AND MERKEZ_ID=? AND YETERLILIK_ID=? AND SINAV_TARIHI=? AND SINAV_SAAT=?";

		$durum = $db->prep_exec($sql, array($post["user_id"], $post["merkez_id"], $post["yetId"], $post["tarih"], $post["saat"]));
		if(count($durum) > 0){
			ajax_success_response_with_array('Sorgu baÅŸarÄ±lÄ±', $kaan);
		}
		else{
			ajax_error_response('KayÄ±t bulunamadÄ±-'.$sql);
		}
	}
	
	function getSinavlar($db, $user_id){
		$sql = "SELECT M_SINAV_ID, YETERLILIK_ADI, YETERLILIK_KODU, SEVIYE_ID, MERKEZ_ADI, SINAV_TARIHI, SINAV_SAAT, TOPLAM_ADAY FROM M_SINAV
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
					WHERE USER_ID = ?";
		return $db->prep_exec($sql, array($user_id));
	}
	
	    
    function getSinavBirimleri($db, $postData){
    	
    	$tarih = $postData['tarih'];
    	$yetid = $postData['yetId'];
    	
    	$sql ="SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    	$params = array($yetid);
    	$yenimi = $db->prep_exec($sql, $params);
    	
    	if($postData['merkezId'] != 'null'){
    	$merkezId = $postData['merkezId'];
    	if($yenimi[0]['YENI_MI'] == 0)
    	{
    		$sql = "SELECT DISTINCT M_SINAV_TAKVIMI.YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID, SEKIL, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, YETERLILIK_ZORUNLU, YENI_MI, ALT_BIRIMLER
    				FROM M_SINAV_TAKVIMI  
                 	JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_SINAV_TAKVIMI.YETERLILIK_ID
                 	JOIN M_YETERLILIK_ALT_BIRIM ON  M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
                 	WHERE M_YETERLILIK.YETERLILIK_ID = ? AND MERKEZ_ID = ? AND TAKVIM_SINAV_TARIHI = ?
                 	ORDER BY YETERLILIK_ALT_BIRIM_NO";
    		
    		$params = array($yetid, $merkezId, $tarih);
    		$kapsamlar = $db->prep_exec($sql, $params);
    	
    		$comboStr = $yetInpNo.'#*#';
    		$isFirst = true;
    	
    		if(isset($kapsamlar)){
    			foreach ($kapsamlar as $row){
    				if($isFirst){
    					$comboStr .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["SEKIL"]. "##". $row["YENI_MI"]. "##". $row["ALT_BIRIMLER"];
    					$isFirst = false;
    				}
    				else
    				$comboStr .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["SEKIL"]. "##". $row["YENI_MI"]. "##". $row["ALT_BIRIMLER"];
    			}
    			//$comboStr.="**Başarısız##Başarısız";
    		}
    			
    		echo $comboStr;
    	
    	}
    	else if($yenimi[0]['YENI_MI'] == 1)
    	{
    		$sql = " SELECT DISTINCT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA, ZORUNLU, SIRA_NO, YENI_MI, ALT_BIRIMLER, M_SINAV_TAKVIMI.YETERLILIK_ID
    					    FROM M_SINAV_TAKVIMI  
                  JOIN M_YETERLILIK ON M_SINAV_TAKVIMI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                  JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
                  JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
                  JOIN M_BIRIM USING(BIRIM_ID)
                  WHERE M_SINAV_TAKVIMI.YETERLILIK_ID = ? AND MERKEZ_ID = ? AND TAKVIM_SINAV_TARIHI = '".$tarih."' AND (OLC_DEG_HARF = 'P' OR OLC_DEG_HARF = 'T')
                  ORDER BY M_SINAV_TAKVIMI.YETERLILIK_ID, SIRA_NO";
    	
    	
    		$params = array($yetid, $merkezId);
    		$kapsamlar = $db->prep_exec($sql, $params);
    	
    		$comboStr = $yetInpNo.'#*#';
    		$isFirst = true;
    	
    		if(isset($kapsamlar)){
    			foreach ($kapsamlar as $row){
    				if($isFirst){
    					$comboStr .= $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"]. "##". $row["ALT_BIRIMLER"];
    					$isFirst = false;
    				}
    				else
    				$comboStr .= "**". $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"]. "##". $row["ALT_BIRIMLER"];
    			}
    			//$comboStr.="**Başarısız##Başarısız";
    		}
    	
    		echo $comboStr;
    	}
    	}
    	else{
    		if($yenimi[0]['YENI_MI'] == 0)
    		{
    			$sql = "SELECT DISTINCT M_SINAV_TAKVIMI.YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID, SEKIL, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, YETERLILIK_ZORUNLU, YENI_MI, ALT_BIRIMLER
    		    				FROM M_SINAV_TAKVIMI  
    		                 	JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_SINAV_TAKVIMI.YETERLILIK_ID
    		                 	JOIN M_YETERLILIK_ALT_BIRIM ON  M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
    		                 	WHERE M_YETERLILIK.YETERLILIK_ID = ? AND TAKVIM_SINAV_TARIHI = ?
    		                 	ORDER BY YETERLILIK_ALT_BIRIM_NO";
    		
    			$params = array($yetid, $tarih);
    			$kapsamlar = $db->prep_exec($sql, $params);
    			 
    			$comboStr = $yetInpNo.'#*#';
    			$isFirst = true;
    			 
    			if(isset($kapsamlar)){
    				foreach ($kapsamlar as $row){
    					if($isFirst){
    						$comboStr .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["SEKIL"]. "##". $row["YENI_MI"]. "##". $row["ALT_BIRIMLER"];
    						$isFirst = false;
    					}
    					else
    					$comboStr .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["SEKIL"]. "##". $row["YENI_MI"]. "##". $row["ALT_BIRIMLER"];
    				}
    				//$comboStr.="**Başarısız##Başarısız";
    			}
    			 
    			echo $comboStr;
    			 
    		}
    		else if($yenimi[0]['YENI_MI'] == 1)
    		{
    			$sql = " SELECT DISTINCT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA, ZORUNLU, SIRA_NO, YENI_MI, ALT_BIRIMLER
    		    					    FROM M_SINAV_TAKVIMI  
    		                  JOIN M_YETERLILIK ON M_SINAV_TAKVIMI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
    		                  JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
    		                  JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
    		                  JOIN M_BIRIM USING(BIRIM_ID)
    		                  WHERE M_SINAV_TAKVIMI.YETERLILIK_ID = ? AND TAKVIM_SINAV_TARIHI = ?
    		                  ORDER BY M_SINAV_TAKVIMI.YETERLILIK_ID, SIRA_NO";
    			 
    			 
    			$params = array($yetid, $tarih);
    			$kapsamlar = $db->prep_exec($sql, $params);
    			 
    			$comboStr = $yetInpNo.'#*#';
    			$isFirst = true;
    			 
    			if(isset($kapsamlar)){
    				foreach ($kapsamlar as $row){
    					if($isFirst){
    						$comboStr .= $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"]. "##". $row["ALT_BIRIMLER"];
    						$isFirst = false;
    					}
    					else
    					$comboStr .= "**". $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"]. "##". $row["ALT_BIRIMLER"];
    				}
    				//$comboStr.="**Başarısız##Başarısız";
    			}
    			 
    			echo $comboStr;
    		}
    	}
    }
    
    public function getTableValues_SinavBilgi ($data, $paramArray, $t3=0){
    	$result 	= array();
    	$inputName 	= "input".$paramArray[0];
    	$colCount 	= $paramArray[1];
    	$rowCount 	= 0;
    
    	//Tablo Degerlerini array yap
    	for ($i=0; $i < $colCount; $i++){
    		if($i==8)
    		$inp = $data[$inputName.'-'.($i+1).'-Hidden'];
    		else		
    		$inp = $data[$inputName.'-'.($i+1)];
    		if (isset ($inp))
    			$array[$i] = $inp;
    		else if ($t3){ //(T3) Radio Button olursa -> input<tablo_adi>-1-1
    			$rowCount 	= count (($data[$inputName.'-1']));
    			$arr = array ();
    			for ($j = 0; $j < $rowCount; $j++){
    				$inp = $data[$inputName.'-'.($i+1).'-'.($j+1).'[]'];
    				if (isset ($inp))
    					$arr[$j] = $inp;
    			}
    
    			$array[$i] = $arr;
    		}
    	}
    
    	if (isset($array[0])){
    		$rowCount = count($array[0]);
    	}
    
    	$count = 0;
    	for ($i=0; $i < $rowCount; $i++){
    		for($j=0; $j< $colCount; $j++){
    			$result[$count] = trim ($array[$j][$i]);
    			$count++;
    		}
    	}
    
    
    	/*echo "-----------------<br><pre>";
    	 print_r($result);
    	echo "</pre>";*/
    
    	return $result;
    
    }
    
	function sinavKaydet($db, $postData){
		$birimliste = array();
		$sekilliste = array();
		//exit;
		//$evrakId = isset($postData['evrakId']) ? $postData['evrakId'] : null;
		//$userId = isset($postData['userId']) ? $postData['userId'] : null;
		$yeterlilikId = isset($postData['yeterlilik_konusu']) ? $postData['yeterlilik_konusu'] : null;
	
		$sinavTarihi = isset($postData['sinav_tarihi']) ? $postData['sinav_tarihi'] : null;
		$sinavGozetmen = isset($postData['sinav_gozetmen']) ? $postData['sinav_gozetmen'] : null;
		$sinavDegerlendirici = isset($postData['sinav_degerlendirici']) ? $postData['sinav_degerlendirici'] : null;
		$merkezId = isset($postData['sinav_yeri']) ? $postData['sinav_yeri'] : null;
		$sinavSekliId = isset($postData['sinav_sekli']) ? $postData['sinav_sekli'] : null;
		$sinavSaati = isset($postData['sinav_saati']) ? $postData['sinav_saati'] : null;
		//$sinav_kapsamlari = isset($postData['sinav_kapsami']) ? $postData['sinav_kapsami'] : null;
		
		$bilgiValues = $this->getTableValues_SinavBilgi($postData, array("belgeDuzenlenecekBilgi", 9));
		
		$toplamAday = $this->countOgr($bilgiValues);// ogrleri say
		$basariliAday = "";// sonuc girerken
		
		
		
		
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
		
//			$sql = "INSERT INTO m_sinav
//					values(?, ?, ?, ?, ?, ?, 
//					
//					(SELECT DISTINCT SINAV_SEKLI_ID
//					    FROM M_SINAV_MERKEZI
//					      NATURAL JOIN M_MERKEZ_SINAV
//					      WHERE MERKEZ_ID = ? AND
//					          YETERLILIK_ID = ?),
//					          
//					 TO_DATE(?,'dd.mm.yyyy'), ?,
//															
//					".BASARILI_ADAY_EKLENMEDI.", ?)";
			$sql = "INSERT INTO M_SINAV (M_SINAV_ID, USER_ID, MERKEZ_ID, YETERLILIK_ID, EVRAK_ID, SINAV_BIRIMLERI, SINAV_TARIHI, TOPLAM_ADAY, BASARILI_ADAY, SINAV_SAAT)
					VALUES(?, ?, ?, ?, ?, ?, 
					          
					 TO_DATE(?,'dd.mm.yyyy'),?,
															
					".BASARILI_ADAY_EKLENMEDI.", ?)";
			
			$params = array($sinavId,
							$userId,
							$merkezId,
							$yeterlilikId,
							$evrakId,
							$sinavSekliId,
							$sinavTarihi,
							$toplamAday,
							$sinavSaati);
							
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
			
//		echo 'bilgi values: <pre>';
//		print_r($bilgiValues);	
//		echo '</pre>';	
			
		$ogrEkleSql = "INSERT INTO M_OGRENCI (TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI, OGRENCI_KAYIT_NO)
				VALUES(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?)";
		
		$valCount = count($bilgiValues);
		//echo "-$valCount-";
		for($i=0;$i<$valCount;$i += 9){
			
			//$params = array_slice($bilgiValues, $i, 9);
			$ogr = array_slice($bilgiValues, $i, 9);
			// kimlik noya göre değerleri al ona göre ekle
			
			//$ogr['kimlik_no'] = $params[1];
			//$ogr = $this->checkOgr($db, $ogr, "array");
			
//			echo 'mevct ogr: <pre>';
//			print_r($ogr);	
//			echo '</pre>';
			
			//$params[0] = $evrakId;
			array_splice($params, 0, 1);
			if(!empty($ogr)){
			
				$ogrekle = array($ogr[1],
								$ogr[2],
								$ogr[3],
								$ogr[4],
								$ogr[5],
								$ogr[6],
								$ogr[7]);
				
				
			}
			else{
											
			}
			$ogrencivarmi = "SELECT TC_KIMLIK FROM M_OGRENCI WHERE TC_KIMLIK = ?";
			$ogrkayitlimi = $db->prep_exec($ogrencivarmi, array($ogr[1]));
			if($ogrkayitlimi[0] == null){
				$returnValues[] = $db->prep_exec_insert($ogrEkleSql, $ogrekle);
			}
			/*else{
				
			}*/
			
			
			$ogrSinavEkle = "INSERT INTO M_OGRENCI_SINAV (TC_KIMLIK, M_SINAV_ID)
					VALUES(?, ?)";
			$returnValues[] = $db->prep_exec_insert($ogrSinavEkle, array($ogrekle[0], $sinavId));
			
			//Ogrenci Altbirim Ekle Bas
			$altbirimler = explode(" ", $ogr[8]);
			foreach($altbirimler as $rows){
				$analiste = explode('_', $rows);

				/*$altbirimara = "SELECT 
			    	YETERLILIK_ALT_BIRIM_ID 
			    	FROM M_YETERLILIK_ALT_BIRIM 
			    	WHERE YETERLILIK_ID = ? AND YETERLILIK_ALT_BIRIM_NO = ?";
				
				$alts = $db->prep_exec($altbirimara, array($yeterlilikId, $rows));*/
				
				$ogrenciAltBirimEkle = "INSERT INTO M_OGRENCI_ALT_BIRIM (M_SINAV_ID, TC_KIMLIK, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ID, SEKIL)
						VALUES(?, ?, ?, ?, ?)";
				//$returnValues[] = $db->prep_exec_insert($ogrenciAltBirimEkle, array($sinavId, $ogrekle[0], $alts[0]['YETERLILIK_ALT_BIRIM_ID'], $yeterlilikId));
				if(isset($analiste[1])){
					$returnValues[] = $db->prep_exec_insert($ogrenciAltBirimEkle, array($sinavId, $ogrekle[0], $analiste[0], $yeterlilikId, $analiste[1]));
				}
				else{
					$returnValues[] = $db->prep_exec_insert($ogrenciAltBirimEkle, array($sinavId, $ogrekle[0], $analiste[0], $yeterlilikId, null));
				}
				}
			//Ogrenci Altbirim Ekle Son
		}
		//die();
		if(FormFactory::isThereError($returnValues))
			return JText::_('SINAV_ONCESI_KAYDET_HATA');
		else{
			$session =&JFactory::getSession();
			//$session->set('sinavOncesiSekil',null);
			//$session->set('sinavOncesiPostData',null);
			//$session->set('sinavOncesiAdlar',null);
			
			$session->set('sinavOncesiKaydedildi', 1);
			
//			global $mainframe;
//			$mainframe->close();

			
			
			//return JText::_('SINAV_ONCESI_KAYDEDILDI').'<br />'.JText::_('ISLAK_IMZA');
			return "Sınav  Öncesi Bildiriminiz kaydedilmiştir.
					Aşağıdaki linkteki belgenin çıktısını alarak MYK’ya gönderebilirsiniz.";
		}
		
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
    			
		$sql = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, MERKEZ_ID
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
    
    function getMerkezler($db){
    	
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
//				if($merkezId != null && $merkezId == $row['MERKEZ_ID'])
//					$selected = 'selected="selected"';
				
				$comboStr .= '<option '.$selected.' value="'.$row["MERKEZ_ID"] . '">'. $row["MERKEZ_ADI"] . '</option>';
				$selected = '';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
function getBASYeterlilikler($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    	
		/*$sql = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ID FROM m_merkez_sinav
				        NATURAL JOIN M_YETERLILIK where m_merkez_sinav.evrak_id in (SELECT EVRAK_ID 
				            FROM M_BASVURU
				          WHERE USER_ID = ? and basvuru_durum_id = 1) ";*/
    	
		$sql = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ID FROM m_sinav_takvimi
				        JOIN M_YETERLILIK USING(YETERLILIK_ID)
				        WHERE USER_ID = ?";
		$params = array ($user_id);
		$kapsamlar = $db->prep_exec($sql, $params);
		
		$comboStr = '';
		$isFirst = true;
		
		/*if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"]." Seviye".$row['SEVIYE_ID'];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"]." Seviye".$row['SEVIYE_ID'];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		*/
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
				$comboStr .='<option value="'.$row["YETERLILIK_ID"] . '">'. $row["YETERLILIK_ADI"] ."-Seviye".$row['SEVIYE_ID'] . '</option>'; 
				
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
			return $comboStr;
    	
    }
    
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
    	return count($bilgiValues)/9;
    }
    
    function getSinavOncesiMerkezler($db, $postData){
    	if(isset($postData['yetId']) && isset($postData['user_id'])){
    		$yetid = $postData['yetId'];
    		$user_id = $postData['user_id'];
    	}
    	else
    	return "";
    
    	$sql = " select DISTINCT  m_sinav_takvimi.merkez_id, m_sinav_merkezi.merkez_adi 
    				from m_sinav_takvimi 
					join m_sinav_merkezi on m_sinav_takvimi.merkez_id = m_sinav_merkezi.merkez_id 
            	          WHERE m_sinav_takvimi.yeterlilik_id = ? and m_sinav_takvimi.user_id = ?";
    	//BASVURU_DURUM_ID yi belirle ona gore cagır
    	 
    	// @todo kontrol et bunu
    	/*$sql = "SELECT DISTINCT 	YETERLILIK_ID,
    	 YETERLILIK_ADI,
    	SEVIYE_ADI
    	FROM M_YETERLILIK
    	JOIN M_MERKEZ_SINAV USING (YETERLILIK_ID)
    	JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    	NATURAL JOIN PM_YETERLILIK_SUREC_DURUM
    	JOIN PM_SEVIYE USING (SEVIYE_ID)
    	WHERE YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID."
    	AND MERKEZ_ID = ?
    	ORDER BY YETERLILIK_ADI";
    	*/
    	$params = array($yetid, $user_id);
    	$kapsamlar = $db->prep_exec($sql, $params);
    	 
    	$comboStr ='#*#';
    	$isFirst = true;
    
    	if(isset($kapsamlar)){
    		foreach ($kapsamlar as $row){
    			if($isFirst){
    				$comboStr .= $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"]."##".$yetid;
    				$isFirst = false;
    			}
    			else
    			$comboStr .= "**". $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"]."##".$yetid;
    		}
    		//$comboStr.="**Başarısız##Başarısız";
    	}
    
    	if($yetInpNo == ""){
    		 
    		$session =&JFactory::getSession();
    		$session->set('sinavOncesiMerkez', $comboStr);
    		 
    	}
    	$sql = "SELECT
    	    			    	DEGERLENDIRICI  
    	    			    	FROM M_SINAV_DEGERLENDIRICI 
    	    			    	WHERE YETERLILIK_ID = ? AND USER_ID = ?";
    	 
    	$params = array($yetid, $user_id);
    	$kapsamlar = $db->prep_exec($sql, $params);
    	$vakvak[] = $comboStr;
    	$kaan[] = $vakvak;
    	$kaan[] = $kapsamlar;
    	if(count($kaan) > 0){
    		ajax_success_response_with_array('Sorgu baÅŸarÄ±lÄ±', $kaan);
    	
    	}
    	else{
    		ajax_error_response('KayÄ±t bulunamadÄ±-'.$sql);
    	}
    	//echo $comboStr;
    
    }
    
    function getSinavOncesiTarihler($db, $postData){
    	if(isset($postData['yetId']) && isset($postData['merkezId'])){
    		$yetid = $postData['yetId'];
    		$merkezId = $postData['merkezId'];
    	}
    	else
    	return "";
    
    	$sql = " SELECT DISTINCT MERKEZ_ID,TAKVIM_SINAV_TARIHI FROM M_SINAV_TAKVIMI WHERE MERKEZ_ID= ? AND YETERLILIK_ID = ?";
    	$params = array($merkezId,$yetid);
    	$kapsamlar = $db->prep_exec($sql, $params);
    
    	$comboStr ='#*#';
    	$isFirst = true;
    
    	if(isset($kapsamlar)){
    		foreach ($kapsamlar as $row){
    			if($isFirst){
    				$comboStr .= $row["MERKEZ_ID"] . "##". $row["TAKVIM_SINAV_TARIHI"]."##".$yetid;
    				$isFirst = false;
    			}
    			else
    			$comboStr .= "**". $row["MERKEZ_ID"] . "##". $row["TAKVIM_SINAV_TARIHI"]."##".$yetid;
    		}
    		//$comboStr.="**Başarısız##Başarısız";
    	}
    
    
    	echo $comboStr;
    
    }
    
    function getSinavOncesiAltBirimler($db, $postData){
    	if(isset($postData['yetId'])){
    		$yetid = $postData['yetId'];
    	}
    	else
    	return "";
    
    	$sql = "SELECT 
		    	YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_NO, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ZORUNLU  
		    	FROM M_YETERLILIK_ALT_BIRIM 
		    	WHERE YETERLILIK_ID = ?";
  
    	$params = array($yetid);
    	$kapsamlar = $db->prep_exec($sql, $params);
    
    	$comboStr ='#*#';
    	$isFirst = true;
    
    	if(isset($kapsamlar)){
    		foreach ($kapsamlar as $row){
    			if($isFirst){
    				$comboStr .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_NO"]."##". $row["YETERLILIK_ALT_BIRIM_ADI"]."##". $row["YETERLILIK_ZORUNLU"];
    				$isFirst = false;
    			}
    			else
    			$comboStr .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_NO"]."##". $row["YETERLILIK_ALT_BIRIM_ADI"]."##". $row["YETERLILIK_ZORUNLU"];
    		}
    		//$comboStr.="**Başarısız##Başarısız";
    	}
    	
    	$session =&JFactory::getSession();
    	$session->set('sinavOncesiAltBirim', $comboStr);
    	echo $comboStr;
    
    }
    
    function getDegerlendirici($db, $postData){
    	if(isset($postData['yetId']) && isset($postData['user_id'])){
    		$yetid = $postData['yetId'];
    		$user_id = $postData['user_id'];
    	}
    	else
    	return "";
    	
    	$sql = "SELECT
    			    	DEGERLENDIRICI  
    			    	FROM M_SINAV_DEGERLENDIRICI 
    			    	WHERE YETERLILIK_ID = ? AND USER_ID = ?";
    	
    	$params = array($yetid, $user_id);
    	$kapsamlar = $db->prep_exec($sql, $params);
    	return $kapsamlar;
    }

}
?>
