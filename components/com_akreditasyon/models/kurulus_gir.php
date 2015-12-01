<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class AkreditasyonModelKurulus_Gir extends JModel {
	
    function getKuruluslar($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT USER_ID, KURULUS_ADI
					FROM M_KURULUS
					LEFT JOIN M_AKREDITE_KURULUS_YETKI ON 
						(M_KURULUS.USER_ID = M_AKREDITE_KURULUS_YETKI.DENETLENEN_KURULUS_ID)
					WHERE M_KURULUS.USER_ID != ? AND 
            (M_AKREDITE_KURULUS_YETKI.DENETCI_KURULUS_ID IS NULL OR 
            M_AKREDITE_KURULUS_YETKI.DENETCI_KURULUS_ID != ?)
					";
		 
		$kapsamlar = $db->prep_exec($sql, array($user_id, $user_id));
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
					$comboStr .= ', new Array("'.$row["USER_ID"] . '","'. $row["KURULUS_ADI"] . '")';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		return $comboStr;
    }
    
    function kurulusSil($db, $kurulusId){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    	
    	$sql = "DELETE FROM M_AKREDITE_KURULUS_YETKI WHERE
    			DENETCI_KURULUS_ID = ? AND
    			DENETLENEN_KURULUS_ID = ?";
    	
    	$rv = $db->prep_exec_insert($sql, array($user_id, $kurulusId));
    	
    	if($rv)
			return JText::_('AKREDITASYON_KURULUS_SILINDI');
		else
			return JText::_('AKREDITASYON_KURULUS_SIL_HATA');
    	
    }
    
    function getYetkiler($db){
    	
    	$user_id = JFactory::getUser()->getOracleUserId();
    			
		$sql = "SELECT AKREDITE_YETKI_ID, AKREDITE_YETKI_ADI
					FROM PM_AKREDITE_YETKI";
		 
		$kapsamlar = $db->prep_exec($sql, array());
		
		$comboStr = '';
		
		if(isset($kapsamlar)){
			foreach ($kapsamlar as $row){
					$comboStr .= ', new Array("'.$row["AKREDITE_YETKI_ID"] . '","'. $row["AKREDITE_YETKI_ADI"] . '")';
			}
			//$comboStr.="**Başarısız##Başarısız";
		}
		
		return $comboStr;
    }
    
	function kurulusKaydet($db, $postData){
		
		//$takvimYili = $postData['takvim_yili'];
		
//		echo '**<pre>';
//		print_r($postData);
//		echo '</pre>**';
				
		$userId =& JFactory::getUser()->getOracleUserId();
		//$akreditasyonId =& JFactory::getUser()->getAkreditasyonId();
		
		//$evrakId = FormFactory::evrakVerisiEkle($userId, TAKVIM_SAYI_ID);
		//echo "-";
		//$rv = FormFactory::basvuruOlustur($evrakId, $userId, TAKVIM_BASVURU_TIP,
		//		TAKVIM_BASVURU_BASLANGIC_DURUM);
		//echo "-$rv-";
		
		$params = array();
		
		$params[0] = $userId;
		
		//echo "-$userId-";
					
//		echo 'bilgi values: <pre>';
//		print_r($_POST);	
//		echo '</pre>';	
				
		$kurulusEkleSql = "INSERT INTO M_AKREDITE_KURULUS_YETKI
			VALUES(?, ?, ?)";
		
		$colNums = 3;
		
		$bilgiValues = FormFactory::getTableValues($postData, array("kurulusGir", $colNums));
		
					
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
							
				//$params[3] = $postVals[1]; // denetim tarihi
				
				$params[1] = $postVals[1];
				
				if($postVals[2] == "Seçiniz")
					$postVals[2] = "";
				
				$params[2] = $postVals[2]; 
				
				//$params[5] = $postVals[3]; // yeterlilik id
				
//				echo 'bilgi values: <pre>';
//		print_r($params);	
//		echo '</pre>';	
				
				$rv = $db->prep_exec_insert($kurulusEkleSql, $params);
				//echo "-$rv-";
			}
		}
		else
			$rv = 1;
			
		if($rv)
			return JText::_('AKREDITASYON_KURULUS_KAYDEDILDI');
		else
			return JText::_('AKREDITASYON_KURULUS_KAYDET_HATA');
			
		// başarılı ise daha önce o yıla ait kayıtları sil
//		$takvimSilSql = "DELETE FROM M_DENETIM_TAKVIMI
//				WHERE 
//        EVRAK_ID IN (SELECT EVRAK_ID FROM M_BASVURU WHERE M_BASVURU.USER_ID = ?) AND
//				DENETIM_YILI = ? AND
//				EVRAK_ID != ? AND
//				DENETIM_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_TASLAK;
//		
//		$paramsDelete = array($userId, $takvimYili, $evrakId);
//		
//		if($rv == 1){
//			//echo "--";
//			//die();
//			$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
//			
//			if($rv2){
//			
//				if($mode == SINAV_TAKVIM_KAYDEDILDI){
//					
//					$takvimSilSql = "DELETE FROM M_DENETIM_TAKVIMI
//							WHERE 
//			        EVRAK_ID IN (SELECT EVRAK_ID FROM M_BASVURU WHERE M_BASVURU.USER_ID = ?) AND
//							DENETIM_YILI = ? AND
//							EVRAK_ID != ? AND
//							DENETIM_TAKVIMI_DURUM_ID =".SINAV_TAKVIM_KAYDEDILDI;
//			
//					$paramsDelete = array($userId, $takvimYili, $evrakId);
//					
//					$rv2 = $db->prep_exec_insert($takvimSilSql, $paramsDelete);
//					
//				}
//			}
//			else
//				return JText::_('AKREDITASYON_KAYDET_HATA');
//			
//			
//			//echo "--";	
//			//die();
//			if($rv2)
//				return JText::_('AKREDITASYON_KAYDEDILDI');
//			else
//				return JText::_('AKREDITASYON_KAYDET_HATA');
//		}
//		else{
//			//die();
//			return JText::_('AKREDITASYON_KAYDET_HATA');
//		}
	}
}
?>
