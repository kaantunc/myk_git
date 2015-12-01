<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelTakvim extends JModel {
	
    function getMerkezler($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT MERKEZ_ID, MERKEZ_ADI
					FROM M_BASVURU
					JOIN M_SINAV_MERKEZI USING (EVRAK_ID)
		      WHERE USER_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id));
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
					$comboStr .= ', new Array("'.$row["MERKEZ_ID"] . '","'. $row["MERKEZ_ADI"] . '")';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		return $comboStr;
    }
    
    function geciciGirdileriSil($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "DELETE FROM
					M_SINAV_TAKVIMI
						WHERE EVRAK_ID IS NULL AND
							SINAV_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_TASLAK;
		 
		$db->prep_exec_insert($sql, array());
		
    }
	
	function takvimAl($db, $postData, $mode){
		
		$takvimYili = $postData['takvimYili'];
		
		$userId =& JFactory::getUser()->getOracleUserId();
		
		//echo '$takvimYili: ' .$takvimYili .'<br />';
		//echo '$$userId: ' .$userId .'<br />';
		
		$getTakvimSql = "SELECT DISTINCT TO_CHAR(TAKVIM_SINAV_TARIHI, 'dd.mm.yyyy') 
						AS TAKVIM_SINAV_TARIHI,
						MERKEZ_ID,
						MERKEZ_ADI,
						YETERLILIK_ID,
						YETERLILIK_ADI,
						SEVIYE_ADI,
           				M_SINAV_TAKVIMI.ALT_BIRIMLER,
           				GECERLILIK_TARIHI,
           				YENI_MI
					FROM M_SINAV_TAKVIMI
						JOIN M_YETERLILIK USING (YETERLILIK_ID)
						JOIN M_SINAV_MERKEZI USING(MERKEZ_ID)
						JOIN PM_SEVIYE USING(SEVIYE_ID)
						JOIN M_BASVURU ON (M_BASVURU.EVRAK_ID = M_SINAV_MERKEZI.EVRAK_ID)
					WHERE 	M_BASVURU.USER_ID = ? AND
							TO_CHAR(TAKVIM_SINAV_TARIHI, 'yyyy') = ? AND
							SINAV_TAKVIMI_DURUM_ID = ?
					ORDER BY TAKVIM_SINAV_TARIHI";
		
		$sinavlar = $db->prep_exec($getTakvimSql, array($userId, $takvimYili, $mode));
		
		
		
		$sinavlarStr = '';
		$isFirst = true;
		if(!empty($sinavlar)){
			foreach($sinavlar AS $sinav){
				
				if($sinavlarStr != '')
					$sinavlarStr .= "**";
				
				$sinavlarStr .= $sinav["TAKVIM_SINAV_TARIHI"] . "##". $sinav["MERKEZ_ID"]. "##". $sinav["MERKEZ_ADI"]. "##".$sinav["ALT_BIRIMLER"]. "##".
						$sinav["YETERLILIK_ID"]. '#*#'. $sinav["YETERLILIK_ADI"]. " - ". $sinav["SEVIYE_ADI"]. '##';
				
				$birimKodlariText = '';
				if($sinav["ALT_BIRIMLER"]!='')
				{	
					
					$altBirimlerParts = explode(' ', $sinav["ALT_BIRIMLER"]);
					foreach($altBirimlerParts as $altBirimlerPart)
					{
						$birimKoduParts = explode('_', $altBirimlerPart);
						$birimKoduAsilPart = $birimKoduParts[0]; 
						if($sinav['YENI_MI']=='1')
						{
							$sql = 'SELECT * FROM M_BIRIM 
									JOIN M_YETERLILIK_BIRIM USING (BIRIM_ID) 
									JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) WHERE YETERLILIK_ID=? AND ID=?';
							$result = $db->prep_exec($sql, array($sinav["YETERLILIK_ID"], $birimKoduAsilPart));
							
							$sinavlarStr .= $result[0]['BIRIM_KODU'] .'/'. ($result[0]['ZORUNLU']=='1'?'T':'P') . $result[0]['SIRA_NO'].' ';
						}
						else //eski birim
						{
							$sql = 'SELECT YETERLILIK_ALT_BIRIM_NO FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ALT_BIRIM_ID=?';
							$result = $db->prep_exec($sql, array($birimKoduAsilPart));
							$sinavlarStr .= $result[0]['YETERLILIK_ALT_BIRIM_NO'].' ';
						}
					}
					//if(count($altBirimlerParts)==0)	$sinavlarStr.="-----altbirimlerParts 0 -----";		
				}
				$sinavlarStr .='##'.$sinav["GECERLILIK_TARIHI"]. '##';
			}
		}
		else{
			$sinavlarStr = "no";
		}
		
		echo $sinavlarStr;
	}

	function takvimKaydet($db, $postData, $mode){
		
		$takvimYili = $postData['takvim_yili'];
		
		
				
		$userId =& JFactory::getUser()->getOracleUserId();
		//echo "-";
		//$evrakId = $this->getTakvimYilEvrakId($db, $userId, $takvimYili);
		//echo "-";
		if($mode == SINAV_TAKVIM_KAYDEDILDI){
		$evrakId = FormFactory::evrakVerisiEkle($userId, TAKVIM_SAYI_ID);
		echo "-";
		$rv = FormFactory::basvuruOlustur($evrakId, $userId, TAKVIM_BASVURU_TIP,
				TAKVIM_BASVURU_BASLANGIC_DURUM);
		//echo "-$rv-";
		}
		else{
			$evrakId = "";
			$rv = 1;
			$rv2 = 1;
		}
		
		$params = array();
		
		$params[0] = $evrakId;
		$params[2] = $mode;
		$params[3] = $takvimYili;
		$params[6] = $userId;
					
//		echo 'bilgi values: <pre>';
//		print_r($_POST);	
//		echo '</pre>';	
				
		$takvimEkleSql = "INSERT INTO M_SINAV_TAKVIMI (EVRAK_ID, MERKEZ_ID, SINAV_TAKVIMI_DURUM_ID, TAKVIM_YILI, TAKVIM_SINAV_TARIHI, YETERLILIK_ID, USER_ID, SEKIL, ALT_BIRIMLER, ALT_BIRIM_ID, GECERLILIK_TARIHI)
			VALUES(?, ?, ?, ?, TO_DATE(?,'dd/mm/yyyy'), ?, ? , ? , ? , ? , TO_DATE(?,'dd/mm/yyyy'))";
		
		$colNums = 6;
		
		$bilgiValues = $this->getTableValues_Takvim($postData, array("sinavTakvimi", $colNums));
		
					
		
	//	die();
		if(isset($bilgiValues[1]) && $bilgiValues[1] != "null"){
			//echo "*$bilgiValues[1]*";
			$valCount = count($bilgiValues);
			//echo "-$valCount-";
			for($i=0;$i<$valCount;$i += $colNums){
				
				$postVals = array_slice($bilgiValues, $i, $colNums);
							
				$params[4] = $postVals[1]; // sınav tarihi
				
				$params[1] = $postVals[4]; // sınav yeri
				
				$params[5] = $postVals[2]; // yeterlilik id
				
				$params[8] = $postVals[3]; // alt birimler
				
				$params[10] = $postVals[5];
				
				$altbirimler = explode(" ", $postVals[3]);
				$altbirimId = Array();
				$altbirimSekil = Array();
				for($ii = 0; $ii < count($altbirimler); $ii++){
					$altbirimayir = explode('_', $altbirimler[$ii]);
					array_push($altbirimId, $altbirimayir[0]);
					array_push($altbirimSekil, $altbirimayir[1]);
				}
				
				for($jj = 0; $jj < count($altbirimId); $jj++){
					$params[9] = $altbirimId[$jj]; // alt birimler Id
					$params[7] = $altbirimSekil[$jj]; // alt birimler Sekil
					//$rv = $db->prep_exec_insert($takvimEkleSql, $params);
					$rv = $db->prep_exec_insert($takvimEkleSql, $params);
				}
				
				
				//echo "-$rv-";
			}
		}
		else
			$rv = 1;
			
		// başarılı ise daha önce o yıla ait kayıtları sil
//		$takvimSilSql = "DELETE FROM M_SINAV_TAKVIMI
//				WHERE 
//        EVRAK_ID IN (SELECT EVRAK_ID FROM M_BASVURU WHERE M_BASVURU.USER_ID = ?) AND
//				TAKVIM_YILI = ? AND
//				EVRAK_ID != ? AND
//				SINAV_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_TASLAK;

		$takvimSilSql = "DELETE FROM M_SINAV_TAKVIMI
				WHERE 
				USER_ID = ? AND
				TAKVIM_YILI = ? AND
				EVRAK_ID IS NULL AND
				SINAV_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_TASLAK;
		
		$paramsDelete = array($userId, $takvimYili);
		if($rv == 1){
			//echo "--";
			//die();
			
			if($mode== SINAV_TAKVIM_KAYDEDILDI){
			
				$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
				
				if($rv2){
				
					if($mode == SINAV_TAKVIM_KAYDEDILDI){
						
						$takvimSilSql = "DELETE FROM M_SINAV_TAKVIMI
					WHERE 
					USER_ID = ? AND
					TAKVIM_YILI = ? AND
					EVRAK_ID != ? AND
					SINAV_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_KAYDEDILDI;
				
						$paramsDelete = array($userId, $takvimYili, $evrakId);
						
						$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
						
					}
				}
				else
					return JText::_('TAKVIM_KAYDET_HATA');
			
			}
			
			if($rv2)
			{	
				if($mode== SINAV_TAKVIM_KAYDEDILDI)
				{
					$buUser = JFactory::getUser();
						
					$ssIdleri = FormFactory::getTumSektorSorumlulari();
					foreach ($ssIdleri as $row)
					{
						FormFactory::sektorSorumlusunaNotificationGonder($buUser->name." Kuruluşu Tarafından Yıllık Sınav Takvimi Kaydı Yapıldı", "index.php?option=com_sinav&view=takvim_gor&layout=listele&userId=".$buUser->getOracleUserId(), $row[1]);
					}
					
				}
				return JText::_('TAKVIM_GUNCELLENDI').'<br />';
			}
			else
				return JText::_('TAKVIM_KAYDET_HATA');
		}
		else{
			//die();
			return JText::_('TAKVIM_KAYDET_HATA');
		}
	}

	public function getTableValues_Takvim ($data, $paramArray, $t3=0){
		$result 	= array();
		$inputName 	= "input".$paramArray[0];
		$colCount 	= $paramArray[1];
		$rowCount 	= 0;
	
		//Tablo Degerlerini array yap
		for ($i=0; $i < $colCount; $i++){
			if($i==3)
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
	
    function getTumKapsamlar($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID IN (
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
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
    function getYeterlilikler($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    	
    	/*$sqlyet = "  SELECT EVRAK_ID, YETERLILIK_ID, YENI_MI FROM M_MERKEZ_SINAV 
					JOIN M_BASVURU USING(EVRAK_ID)
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					WHERE USER_ID = ? AND BASVURU_DURUM_ID = 6 AND BASVURU_TIP_ID = 3";
    	$yetler = $db->prep_exec($sqlyet, array($user_id));
    	
    	foreach($yetler as $pows){
    		if($pows['YENI_MI'] == 0){
    			$birimeski = "SELECT YETERLILIK_ALT_BIRIM_ID FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?";
    			$birimler[$pows['YETERLILIK_ID']] = $db->prep_exec($birimeski, array($pows['YETERLILIK_ID']));
    		}
    		else{
    			$birimyeni = "SELECT BIRIM_ID FROM M_BIRIM WHERE BAGIMLI_OLDUGU_YET_ID = ?";
    			$birimler[$pows['YETERLILIK_ID']] = $db->prep_exec($birimyeni, array($pows['YETERLILIK_ID']));
    		}
    	}
    	foreach($yetler as $cows){
    		$say = 0;
    		$birimvar = array();
    		$birimlertop = count($birimler[$cows['YETERLILIK_ID']]);
    		if($cows['YENI_MI'] == 0){
	    		foreach($birimler[$cows['YETERLILIK_ID']] as $tows){
	    			$birimdenetimvarmi = "SELECT * FROM M_DENETIM_YETKI WHERE YETKININ_GERI_ALINDIGI_TARIH IS NULL AND BIRIM_ID = ?";
	    			if($db->prep_exec($birimdenetimvarmi, array($tows['YETERLILIK_ALT_BIRIM_ID']))){
	    				$birimvar[] = $tows['YETERLILIK_ALT_BIRIM_ID'];
	    			}
	    		}
	    		if(count($birimvar) == $birimlertop){
	    			$yetkiyeterlilik[] = $cows['YETERLILIK_ID'];
	    		}
    		}
    		else{
    			foreach($birimler[$cows['YETERLILIK_ID']] as $tows){
    				$birimdenetimvarmi = "SELECT * FROM M_DENETIM_YETKI WHERE YETKININ_GERI_ALINDIGI_TARIH IS NULL AND BIRIM_ID = ?";
    				if($db->prep_exec($birimdenetimvarmi, array($tows['BIRIM_ID']))){
    					$birimvar[] = $tows['BIRIM_ID'];
    				}
    			}
    			if(count($birimvar) == $birimlertop){
    				$yetkiyeterlilik[] = $cows['YETERLILIK_ID'];
    			}
    		}
    	}
    	
    	foreach($yetkiyeterlilik as $rows){
    		$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ID FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    		$kapsamlar[] = $db->prep_exec($sql, array($rows));
    	}
    	
    	$comboStr = '';
    	$isFirst = true;
    	
    	foreach ($kapsamlar as $row){
    			$comboStr .= ', new Array("'.$row[0]["YETERLILIK_ID"] . '","'. $row[0]["YETERLILIK_ADI"] ."-Seviye".$row[0]['SEVIYE_ID'] . '")';
    	}
    	*/
    	$yeterlilikler = array();
    	$sqleski = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ID FROM M_MERKEZ_SINAV
			JOIN M_BASVURU USING (EVRAK_ID)
			JOIN M_YETERLILIK USING (YETERLILIK_ID)
			JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
			JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
			WHERE USER_ID = ?
			AND YENI_MI = 0
			AND BASVURU_TIP_ID = 3
			AND BASVURU_DURUM_ID = 6
    		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
    	
    	$params = array ($user_id);
		$yeterlilikler[] = $db->prep_exec($sqleski, $params);
		
		
		$sqlyeni = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ID FROM M_MERKEZ_SINAV
					JOIN M_BASVURU USING (EVRAK_ID)
					JOIN M_YETERLILIK USING (YETERLILIK_ID)
					JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
					JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID)
    				JOIN M_BIRIM USING(BIRIM_ID)
					JOIN M_DENETIM_YETKI USING (BIRIM_ID)
					WHERE user_id = ?
					AND YENI_MI = 1 
					AND BASVURU_TIP_ID = 3
					AND BASVURU_DURUM_ID = 6
					AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
		 
		$params = array ($user_id);
		$yeterlilikler[] = $db->prep_exec($sqlyeni, $params);
		
		$comboStr = '';
		$isFirst = true;
		
			foreach ($yeterlilikler[0] as $row){
				if(strlen($row['YETKININ_GERI_ALINDIGI_TARIH']) <= 0 ){
					$comboStr .= ', new Array("'.$row["YETERLILIK_ID"] . '","'. $row["YETERLILIK_ADI"] ."-Seviye".$row['SEVIYE_ID'] . '")';
				}
			}
			//$comboStr.="**Başarısız##Başarısız";
		
		
			foreach ($yeterlilikler[1] as $row){
				if(strlen($row['YETKININ_GERI_ALINDIGI_TARIH']) <= 0 ){
					$comboStr .= ', new Array("'.$row["YETERLILIK_ID"] . '","'. $row["YETERLILIK_ADI"] ."-Seviye".$row['SEVIYE_ID'] . '")';
				}
			}
		
			return $comboStr;
    	
    }
    
    function getMerkezYeterlilikler($db, $postData){
    	$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";
    	/*if(isset($postData['merkezId'])){
    		$merkezId = $postData['merkezId'];
    		$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";
    	}*/
    	
    	if(isset($postData['yetid'])){
    		$yetid = $postData['yetid'];
    		$sql = "  SELECT m_sinav_merkezi.evrak_id, m_basvuru.user_id, yeterlilik_id, m_sinav_merkezi.merkez_id, m_sinav_merkezi.merkez_adi  FROM M_SINAV_MERKEZI
        	          JOIN M_MERKEZ_SINAV ON M_SINAV_MERKEZI.MERKEZ_ID = M_MERKEZ_SINAV.MERKEZ_ID 
        	          JOIN m_basvuru on m_sinav_merkezi.evrak_id = m_basvuru.evrak_id 
        	          WHERE m_basvuru.basvuru_durum_id = 6 and m_merkez_sinav.yeterlilik_id = ?";
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
    		$params = array($yetid);
    		$kapsamlar = $db->prep_exec($sql, $params);
    	}
    	else if(isset($postData['merkezId'])){
    		$merkezId = $postData['merkezId'];
    		$sql = " SELECT m_sinav_merkezi.evrak_id, m_basvuru.user_id, yeterlilik_id, m_sinav_merkezi.merkez_id, m_sinav_merkezi.merkez_adi FROM M_SINAV_MERKEZI
    		          JOIN M_MERKEZ_SINAV ON M_SINAV_MERKEZI.MERKEZ_ID = M_MERKEZ_SINAV.MERKEZ_ID 
    		          JOIN m_basvuru on m_sinav_merkezi.evrak_id = m_basvuru.evrak_id 
    		          WHERE m_basvuru.basvuru_durum_id = 6 and m_sinav_merkezi.merkez_id = ?";
    		$params = array($merkezId);
    		$kapsamlar = $db->prep_exec($sql, $params);
    		 
    	}
		$comboStr = $yetInpNo.'#*#';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		if($yetInpNo == ""){
			
			$session =&JFactory::getSession();
			$session->set('sinavOncesiYet', $comboStr);
			
		}
		
		echo $comboStr;
    	
    }
    
    function getYeterlilikMerkezler($db, $postData){
    	/*$yetid = $postData['merkezId'];
    	$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";*/
    	if(isset($postData['yetId']) && isset($postData['yetInpNo']) && isset($postData['user_id'])){
    		$yetid = $postData['yetId'];
    		$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";
    		$user_id = $postData['user_id'];
    	}
    	else
    		return "";
    		
    		$sql = " SELECT DISTINCT m_sinav_merkezi.evrak_id, m_basvuru.user_id, yeterlilik_id, m_sinav_merkezi.merkez_id, m_sinav_merkezi.merkez_adi  
    				  FROM M_SINAV_MERKEZI
        	          JOIN M_MERKEZ_SINAV ON M_SINAV_MERKEZI.MERKEZ_ID = M_MERKEZ_SINAV.MERKEZ_ID 
        	          JOIN m_basvuru on m_sinav_merkezi.evrak_id = m_basvuru.evrak_id 
        	          WHERE m_basvuru.basvuru_durum_id = 6 and m_merkez_sinav.yeterlilik_id = ? and m_basvuru.user_id = ?";
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
   
    	$comboStr = $yetInpNo.'#*#';
    	$isFirst = true;
    
    	if(isset($kapsamlar)){
    		foreach ($kapsamlar as $row){
    			if($isFirst){
    				$comboStr .= $row["YETERLILIK_ID"] . "##". $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"];
    				$isFirst = false;
    			}
    			else
    			$comboStr .= "**". $row["YETERLILIK_ID"] . "##". $row["MERKEZ_ID"] . "##". $row["MERKEZ_ADI"];
    		}
    		//$comboStr.="**Başarısız##Başarısız";
    	}
    
    	if($yetInpNo == ""){
    			
    		$session =&JFactory::getSession();
    		$session->set('sinavOncesiYet', $comboStr);
    			
    	}
    
    	echo $comboStr;
    	 
    }
    
    
    function getYillarCombo(){
    	$optionsStr = '';
    	$thisYear = date('Y');
    	
    	for($j = 5; $j > 0; $j--)
    		$optionsStr .= '<option value="'.($thisYear - $j).'">'.($thisYear - $j).'</option>';
    	for($i = 0; $i < 5; $i++)
    		$optionsStr .= '<option value="'.($thisYear + $i).'">'.($thisYear + $i).'</option>';
    		
    	return $optionsStr;
    }
    

function getTableValuesWithCombo ($postData, $paramArray){
	$result 	= array();
	$inputName 	= "input".$paramArray[0];
	$colCount 	= $paramArray[1];
	$rowCount 	= 0;
	
	//Tablo Degerlerini array yap
	for ($i=0; $i < $colCount; $i++){
		if(($i == 3)||($i == 4))
			continue;
		$array[$i] = $postData[$inputName.'-'.($i+1)];
	}
	
	if (isset($array[0])){
		$rowCount = count($array[0]);
	}
	
	$count = 0;
	for ($i=0; $i < $rowCount; $i++){
		for($j=0; $j< $colCount; $j++){
			if(($j == 3)||($j == 4)){
				//$result[$count] = implode(",",$postData[$inputName.'-9-'.($i+1)]);
				$result[$count] = isset($postData[$inputName.'-'.($j+1).'-'.($i+1)]) ?
						$postData[$inputName.'-'.($j+1).'-'.($i+1)] : "";
			}else
				$result[$count] = trim ($array[$j][$i]);
			$count++;							
		}
	}

	return $result;
}
//
/*function getTakvimYilEvrakId($db, $userId, $yil){
	
	$sql = "SELECT DISTINCT EVRAK_ID
    FROM M_SINAV_TAKVIMI
        JOIN M_BASVURU USING (EVRAK_ID)
            WHERE M_BASVURU.USER_ID = ? AND
              TAKVIM_YILI = ?";
	
	$evrakRows = $db->prep_exec($sql, array($userId, $yil));
	
	if(isset($evrakRows[0]['EVRAK_ID']))
		return $evrakRows[0]['EVRAK_ID'];
	else
		return false;
//	
}*/

function getYeterlilikAltBirimler($db, $postData){
	$user_id = JFactory::getUser()->getOracleUserId();
	if(isset($postData['yetId']) && isset($postData['yetInpNo'])){
		$yetid = $postData['yetId'];
		$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";
	}
	else
	return "";
	
	$sql ="SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
	$params = array($yetid);
	$yenimi = $db->prep_exec($sql, $params);
	
	if($yenimi[0]['YENI_MI'] == 0)
	{
		$sql = "SELECT DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, 
				   YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, YETERLILIK_ZORUNLU, YENI_MI
				   FROM M_YETERLILIK 
  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
             		JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
             		JOIN M_DENETIM USING(DENETIM_ID)
  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
					AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
		$params = array($yetid, $user_id);
		$kapsamlar = $db->prep_exec($sql, $params);
	
		$comboStr = $yetInpNo.'#*#';
		$isFirst = true;
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
				if($isFirst){
					$comboStr .= $row["BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["YETERLILIK_ZORUNLU"]. "##". $row["YENI_MI"];
					$isFirst = false;
				}
				else
				$comboStr .= "**". $row["BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"]. "##". $row["YETERLILIK_ALT_BIRIM_NO"]. "##". $row["YETERLILIK_ZORUNLU"]. "##". $row["YENI_MI"];
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
			
		echo $comboStr;
		
	}
	else if($yenimi[0]['YENI_MI'] == 1)
	{
		$sql = " SELECT DISTINCT ID,YETERLILIK_ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, 
						OLC_DEG_HARF, OLC_DEG_NUMARA, YENI_MI
				    	FROM M_YETERLILIK
		                JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
						JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) 
		                JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
		                JOIN M_DENETIM USING(DENETIM_ID)
				       WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?
              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL AND (OLC_DEG_HARF = 'P' OR OLC_DEG_HARF = 'T') ORDER BY BIRIM_ID";
	
	
	$params = array($yetid, $user_id);
	$kapsamlar = $db->prep_exec($sql, $params);
	 
	$comboStr = $yetInpNo.'#*#';
	$isFirst = true;

	if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"];
				$isFirst = false;
			}
			else
			$comboStr .= "**". $row["BIRIM_ID"] . "##". $row["BIRIM_ADI"]. "##". $row["BIRIM_KODU"]. "##". $row["OLC_DEG_HARF"]. "##". $row["YENI_MI"]. "##". $row["OLC_DEG_NUMARA"]. "##". $row["ZORUNLU"]. "##". $row["ID"];
		}
		//$comboStr.="**Başarısız##Başarısız";
	}

	echo $comboStr;
	}
}

function getKayitliYeterlilikAltBirimler($db, $postData){
	$user_id = JFactory::getUser()->getOracleUserId();
	if(isset($postData['yetId']) && isset($postData['yetInpNo'])){
		$yetid = $postData['yetId'];
		$yetInpNo = isset($postData['yetInpNo']) ? $postData['yetInpNo'] : "";
	}
	else
	return "";
	$yetid = explode(',', $yetid);
	
	foreach($yetid as $id){
		$sql ="SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$params = array($id);
		$yenimi = $db->prep_exec($sql, $params);

	if($yenimi[0]['YENI_MI'] == 0)
	{
		$sql = "   SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO, YETERLILIK_ZORUNLU, YENI_MI
				   FROM M_YETERLILIK 
  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID)
             	   JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
             	   JOIN M_DENETIM USING(DENETIM_ID)
  				   WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?  ORDER BY YETERLILIK_ALT_BIRIM_NO";

		$params = array($id,$user_id);
		$kapsamlar[] = $db->prep_exec($sql, $params);
		

	}
	else if($yenimi[0]['YENI_MI'] == 1)
	{
		$sql = "SELECT DISTINCT M_BIRIM_OLCME_DEGERLENDIRME.ID,M_YETERLILIK_BIRIM.YETERLILIK_ID, M_YETERLILIK_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_ADI,
					M_BIRIM.BIRIM_KODU, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_ACIKLAMA, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF,
					M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_NUMARA, M_YETERLILIK.YENI_MI, SIRA_NO
				    FROM M_YETERLILIK_BIRIM 
				        JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_YETERLILIK_BIRIM.BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID
				        JOIN M_BIRIM ON M_YETERLILIK_BIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID  
				        JOIN M_YETERLILIK ON M_YETERLILIK_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
		                JOIN M_DENETIM_YETKI ON  M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID = M_DENETIM_YETKI.BIRIM_ID
		                JOIN M_DENETIM USING(DENETIM_ID)
				        WHERE M_YETERLILIK_BIRIM.YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? AND (OLC_DEG_HARF = 'P' OR OLC_DEG_HARF = 'T')
				        ORDER BY M_YETERLILIK_BIRIM.YETERLILIK_ID, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_NUMARA";


		$params = array($id, $user_id);
		$kapsamlar[] = $db->prep_exec($sql, $params);

		
	}
	}
	if(count($kapsamlar) > 0){
		$x = 10;
		ajax_success_response_with_array('Sorgu baÅŸarÄ±lÄ±', $kapsamlar);

	}
	else{
		$y =20;
		ajax_error_response('KayÄ±t bulunamadÄ±-'.$sql);
	}
}


}
?>
