<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class AkreditasyonModelTakvim extends JModel {
	
    function getKuruluslar($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT DISTINCT DENETLENEN_KURULUS_ID, KURULUS_ADI
					FROM M_AKREDITE_KURULUS_YETKI
					JOIN M_KURULUS ON (M_AKREDITE_KURULUS_YETKI.DENETLENEN_KURULUS_ID = M_KURULUS.USER_ID)
						WHERE DENETCI_KURULUS_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id));
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
					$comboStr .= ', new Array("'.$row["DENETLENEN_KURULUS_ID"] . '","'. $row["KURULUS_ADI"] . '")';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		return $comboStr;
    }
    
	
	function takvimAl($db, $postData, $mode){
		
		$takvimYili = $postData['takvimYili'];
		
		$userId =& JFactory::getUser()->getOracleUserId();
		
		//echo '$takvimYili: ' .$takvimYili .'<br />';
		//echo '$$userId: ' .$userId .'<br />';
		
//		$getTakvimSql = "SELECT TO_CHAR(DENETIM_TARIHI, 'dd.mm.yyyy')
//										AS DENETIM_TARIHI_FORMATTED,
//								USER_ID, KURULUS_ADI
//		    FROM M_DENETIM_TAKVIMI
//		      JOIN M_KURULUS ON (
//		      		M_DENETIM_TAKVIMI.DENETLENECEK_USER_ID = M_KURULUS.USER_ID)
//		      		
//        WHERE AKREDITASYON_ID = (SELECT DISTINCT AKREDITASYON_ID
//                                    FROM M_AKREDITASYON
//                                    NATURAL JOIN M_BASVURU
//                                        WHERE USER_ID = ?) AND
//              DENETIM_YILI = ? AND
//              DENETIM_TAKVIMI_DURUM_ID = ?
//             		ORDER BY DENETIM_TARIHI ASC";

				$getTakvimSql = "SELECT TO_CHAR(DENETIM_TARIHI, 'dd.mm.yyyy')
										AS DENETIM_TARIHI_FORMATTED,
								DENETLENEN_KURULUS_ID AS USER_ID, KURULUS_ADI
                FROM M_DENETIM_TAKVIMI
                JOIN M_KURULUS ON (M_DENETIM_TAKVIMI.DENETLENEN_KURULUS_ID = M_KURULUS.USER_ID)
                	WHERE DENETCI_KURULUS_ID = ? AND
                		DENETIM_YILI = ? AND
                		DENETIM_TAKVIMI_DURUM_ID = ?
                	ORDER BY DENETIM_TARIHI ASC";
		
		$sinavlar = $db->prep_exec($getTakvimSql, array($userId, $takvimYili, $mode));
		
		//echo '<pre>';
		//print_r($sinavlar);
		//echo '</pre>';
		
		$sinavlarStr = '';
		$isFirst = true;
		if(!empty($sinavlar)){
			foreach($sinavlar AS $sinav){
				if($isFirst){
					$sinavlarStr .= $sinav["DENETIM_TARIHI_FORMATTED"] . "##".
							$sinav["USER_ID"]. '#*#'. $sinav["KURULUS_ADI"];
							
					$isFirst = false;
				}
				else
					$sinavlarStr .= "**".$sinav["DENETIM_TARIHI_FORMATTED"] . "##".
							$sinav["USER_ID"]. '#*#'. $sinav["KURULUS_ADI"];
				
			}
		}
		else{
			$sinavlarStr = "no";
		}
		
		echo $sinavlarStr;
	}

	function takvimKaydet($db, $postData, $mode){
		
		$takvimYili = $postData['takvim_yili'];
		
//		echo '**<pre>';
//		print_r($postData);
//		echo '</pre>**';
				
		$userId =& JFactory::getUser()->getOracleUserId();
		//$akreditasyonId =& JFactory::getUser()->getAkreditasyonId();
		
		$evrakId = FormFactory::evrakVerisiEkle($userId, TAKVIM_SAYI_ID);
		//echo "-";
		$rv = FormFactory::basvuruOlustur($evrakId, $userId, TAKVIM_BASVURU_TIP,
				TAKVIM_BASVURU_BASLANGIC_DURUM);
		//echo "-$rv-";
		//echo "-";
		$params = array();
		
		$params[0] = $evrakId;
		$params[5] = $mode;
		$params[4] = $takvimYili;
		$params[1] = $userId;
					
//		echo 'bilgi values: <pre>';
//		print_r($_POST);	
//		echo '</pre>';	
				
		$takvimEkleSql = "INSERT INTO M_DENETIM_TAKVIMI
			VALUES(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?)";
		
		$colNums = 3;
		
		$bilgiValues = FormFactory::getTableValues($postData, array("sinavTakvimi", $colNums));
		
					
//		echo 'bilgi values: <pre>';
//		print_r($bilgiValues);	
//		echo '</pre>';
		
	//	die();
		
		if(isset($bilgiValues[1]) && $bilgiValues[1] != "null"){
			//echo "*$bilgiValues[1]*";
			$valCount = count($bilgiValues);
			//echo "-$valCount-";
			for($i=0;$i<$valCount;$i += $colNums){
				
				$postVals = array_slice($bilgiValues, $i, $colNums);
							
				$params[3] = $postVals[1]; // denetim tarihi
				
				$params[2] = $postVals[2]; // denetlecek
				
				//$params[5] = $postVals[3]; // yeterlilik id
				
//				echo 'bilgi values: <pre>';
//		print_r($params);	
//		echo '</pre>';	
				
				$rv = $db->prep_exec_insert($takvimEkleSql, $params);
				//echo "-$rv-";
			}
		}
		else
			$rv = 1;
			
		// başarılı ise daha önce o yıla ait kayıtları sil
		$takvimSilSql = "DELETE FROM M_DENETIM_TAKVIMI
				WHERE 
        EVRAK_ID IN (SELECT EVRAK_ID FROM M_BASVURU WHERE M_BASVURU.USER_ID = ?) AND
				DENETIM_YILI = ? AND
				EVRAK_ID != ? AND
				DENETIM_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_TASLAK;
		
		$paramsDelete = array($userId, $takvimYili, $evrakId);
		
		if($rv == 1){
			//echo "--";
			//die();
			$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
			
			if($rv2){
			
				if($mode == SINAV_TAKVIM_KAYDEDILDI){
					
					$takvimSilSql = "DELETE FROM M_DENETIM_TAKVIMI
							WHERE 
			        EVRAK_ID IN (SELECT EVRAK_ID FROM M_BASVURU WHERE M_BASVURU.USER_ID = ?) AND
							DENETIM_YILI = ? AND
							EVRAK_ID != ? AND
							DENETIM_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_KAYDEDILDI;
			
					$paramsDelete = array($userId, $takvimYili, $evrakId);
					
					$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
					
				}
			}
			else
				return JText::_('AKREDITASYON_KAYDET_HATA');
			
			
			//echo "--";	
			//die();
			if($rv2)
				return JText::_('AKREDITASYON_KAYDEDILDI');
			else
				return JText::_('AKREDITASYON_KAYDET_HATA');
		}
		else{
			//die();
			return JText::_('AKREDITASYON_KAYDET_HATA');
		}
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
    			
		$sql = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI FROM M_YETERLILIK_TALEBI
				        NATURAL JOIN M_YETERLILIK
				        NATURAL JOIN PM_YETERLILIK_SUREC_DURUM
				      WHERE (YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID.")
				        AND YETERLILIK_ID IN 
				          (SELECT EVRAK_ID 
				            FROM M_BASVURU
				          WHERE USER_ID = ?) ORDER BY YETERLILIK_ADI";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id));
		
		$comboStr = '';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
			return $comboStr;
    	
    }
    
    function getMerkezYeterlilikler($db, $postData){
    	
    	if(isset($postData['merkezId']) && isset($postData['yetInpNo'])){
    		$merkezId = $postData['merkezId'];
    		$yetInpNo = $postData['yetInpNo'];
    	}
    	else
    		return "";
    		
    	
    	    	    	
    	// @todo kontrol et bunu
		$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI FROM M_YETERLILIK
                JOIN M_MERKEZ_SINAV USING (YETERLILIK_ID)
				        JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
				        NATURAL JOIN PM_YETERLILIK_SUREC_DURUM
				      WHERE YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID."
				      	AND MERKEZ_ID = ?
				        	ORDER BY YETERLILIK_ADI";
		 
		$kapsamlar = $db->prep_exec($sql, array($merkezId));
		
		$comboStr = $yetInpNo.'#*#';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				$comboStr .= $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"];
				$isFirst = false;
			}
			else
				$comboStr .= "**". $row["YETERLILIK_ID"] . "##". $row["YETERLILIK_ADI"];
		}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		echo $comboStr;
    	
    }
    
    function getYillarCombo(){
    	$optionsStr = '';
    	$thisYear = date('Y');
    	//echo "---$thisYear---";
    	for($i=0;$i<5;$i++)
    		$optionsStr .= '<option value="'.($thisYear + $i).'">'.($thisYear + $i).'</option>';
    	//echo "**$optionsStr**";
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

}
?>
