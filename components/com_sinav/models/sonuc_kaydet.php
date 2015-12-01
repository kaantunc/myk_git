<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries'.DS.'form'.DS.'form.php');

class SinavModelSonuc_Kaydet extends JModel {

    function pratikKaydet($db, $data) {

		$sinavTuru = $data['sinavTuru'];
		$sinavId = $data['sinavId'];
    		
		//if(!evrakSahibiMi($evrakId))
			//return JText::_('EVRAK_YETKI_HATASI');
		
		//$sinavTarihi = "";$data['sinavTarihi'];
		//$sinavYeri = "";$data['sinavYeri'];
		//$sinavYapan = "";$data['sinavYapan'];
		//echo "erakid: $evrakId<br />";
		$sql = "SELECT TC_KIMLIK
					FROM M_OGRENCI
					NATURAL JOIN M_OGRENCI_SINAV
				WHERE M_SINAV_ID = ?";
								
		$returnValues = array();// to check if the queries succeeded
								
		$params = array($sinavId);
		$ogrenciler = $db->prep_exec($sql, $params);
		
		$sql = "INSERT INTO M_SINAV_SONUCU (TC_KIMLIK, M_SINAV_ID, SINAV_DURUM_ID, DOGRU_SAYISI, YANLIS_SAYISI, BOS_SAYISI, ALDIGI_NOT, SERTIFIKA_EVRAK_ID, ALT_BIRIM_ID)
				VALUES(?, ?, ?, null, null, null, ?, null, ?)";
		
		
		/*foreach($ogrenciler AS $ogrenci){
		
			$sinavSonucu = $data["sinav_sonuc_" . $ogrenci['TC_KIMLIK']];
			$puan = $data["puan_" . $ogrenci['TC_KIMLIK']];
			
			$params = array(
					$ogrenci['TC_KIMLIK'],
					$sinavId,
					$sinavSonucu,
					$puan
					);
			//echo "*<br />";
			$returnValues[] = $db->prep_exec_insert($sql, $params);
			//echo "*<br />";
		}*/
		
		foreach($ogrenciler AS $ogrenci){
			$kacsinav = count($data["altbirimId_".$ogrenci['TC_KIMLIK']]);
				
			for($ii = 0; $ii < $kacsinav; $ii++){
				$altbirim = $data["altbirimId_".$ogrenci['TC_KIMLIK']][$ii];
				$puan = $data["puan_" . $ogrenci['TC_KIMLIK']][$ii];
				$sinavSonucu = $data["sinav_sonuc_" . $ogrenci['TC_KIMLIK']][$ii];
					
				if($sinavSonucu == "SeÇiniz"){
					$sinavSonucu = "";
				}
					
				$params = array(
				$ogrenci['TC_KIMLIK'],
				$sinavId,
				$sinavSonucu,
				$puan,
				$altbirim
				);
					
		
				$returnValues[] = $db->prep_exec_insert($sql, $params);
			}
		}
		
				
		$sonucGirildiSql = "UPDATE M_SINAV
				SET BASARILI_ADAY = ".BASARILI_ADAY_EKLENDI."
				WHERE M_SINAV_ID = ?";
		
		$returnValues[] = $db->prep_exec_insert($sonucGirildiSql, array($sinavId));
		
		if(!FormFactory::isThereError($returnValues))
			return JText::_('SINAV_SONUC_KAYDEDILDI');
		else
			return JText::_('SINAV_SONUC_KAYDET_HATA');
		//die();
		
    }

    function teorikKaydet($db, $data) {

		$sinavTuru = $data['sinavTuru'];
		$sinavId = $data['sinavId'];
				
		//if(!evrakSahibiMi($evrakId))
			//return JText::_('EVRAK_YETKI_HATASI');
			
		$sql = "SELECT TC_KIMLIK
					FROM M_OGRENCI
					NATURAL JOIN M_OGRENCI_SINAV
				WHERE M_SINAV_ID = ?";
		
		$returnValues = array();// to check if the queries succeeded
								
		$params = array($sinavId);
		$ogrenciler = $db->prep_exec($sql, $params);
				
		$sql = "INSERT INTO M_SINAV_SONUCU (TC_KIMLIK,M_SINAV_ID,SINAV_DURUM_ID,DOGRU_SAYISI,YANLIS_SAYISI,BOS_SAYISI,ALDIGI_NOT,SERTIFIKA_BASVURU_ID,ALT_BIRIM_ID)
				VALUES( ?, ?, ?, ?, ?, ?, ?, NULL, ?)";
		
		foreach($ogrenciler AS $ogrenci){
			$kacsinav = count($data["altbirimId_".$ogrenci['TC_KIMLIK']]);
			
			for($ii = 0; $ii < $kacsinav; $ii++){
			$altbirim = $data["altbirimId_".$ogrenci['TC_KIMLIK']][$ii];
			$dogruCevap = $data["dogru_cevap_" . $ogrenci['TC_KIMLIK']][$ii];
			$yanlisCevap = $data["yanlis_cevap_" . $ogrenci['TC_KIMLIK']][$ii];
			$bos = $data["bos_" . $ogrenci['TC_KIMLIK']][$ii];
			$puan = $data["puan_" . $ogrenci['TC_KIMLIK']][$ii];
			$sinavSonucu = $data["sinav_sonuc_" . $ogrenci['TC_KIMLIK']][$ii];
			
			if($sinavSonucu == "Se�iniz"){
				$sinavSonucu = "";
			}
			
			$params = array(
					$ogrenci['TC_KIMLIK'],
					$sinavId,
					$sinavSonucu,
					$dogruCevap,
					$yanlisCevap,
					$bos,
					$puan,
					$altbirim
					);
					
		
			$returnValues[] = $db->prep_exec_insert($sql, $params);
			}
		}
		
		$sonucGirildiSql = "UPDATE M_SINAV
				SET BASARILI_ADAY = ".BASARILI_ADAY_EKLENDI."
				WHERE M_SINAV_ID = ?";
		
	//	echo '<pre>';
			//print_r($returnValues);
		//	echo '</pre>';
		if(!FormFactory::isThereError($returnValues))
			$returnValues[] = $db->prep_exec_insert($sonucGirildiSql, array($sinavId));
		
		//echo '<pre>';
			//print_r($returnValues);
			//echo '</pre>';		
				
		if(!FormFactory::isThereError($returnValues))
			return JText::_('SINAV_SONUC_KAYDEDILDI');
		else
			return JText::_('SINAV_SONUC_KAYDET_HATA');
    }
    
    function SinavSonucuKaydet($db, $data) {
    
    	$sinavTuru = $data['sinavTuru'];
    	$sinavId = $data['sinavId'];
    	
    	$sqlsil = "DELETE FROM M_SINAV_SONUCU WHERE M_SINAV_ID =" .$sinavId;
    	$db->prep_exec_insert($sqlsil, array());
    	
    	$sql = "SELECT TC_KIMLIK
    					FROM M_OGRENCI
    					NATURAL JOIN M_OGRENCI_SINAV
    				WHERE M_SINAV_ID = ?";
    
    	$returnValues = array();// to check if the queries succeeded
    
    	$params = array($sinavId);
    	$ogrenciler = $db->prep_exec($sql, $params);
    
    	
    	$sql = "INSERT INTO M_SINAV_SONUCU 	(TC_KIMLIK, M_SINAV_ID, SINAV_DURUM_ID, DOGRU_SAYISI, YANLIS_SAYISI, BOS_SAYISI, ALDIGI_NOT, SERTIFIKA_BASVURU_ID, ALT_BIRIM_ID, SEKIL, SERTIFIKA_DURUM_ID, GOZETMEN, DEGERLENDIRICI)
    				VALUES(?, ?, ?, null, null, null, ?, null, ?, ?, ?, ?, ?)";
    		
    		
    
    	foreach($ogrenciler AS $ogrenci){
    	$kacsinav = count($data["altbirimId_".$ogrenci['TC_KIMLIK']]);
    
    	for($ii = 0; $ii < $kacsinav; $ii++){
    		$altbirim = $data["altbirimId_".$ogrenci['TC_KIMLIK']][$ii];
    		$sekil = $data["altbirimSekil_".$ogrenci['TC_KIMLIK']][$ii];
    		$puan = $data["puan_" . $ogrenci['TC_KIMLIK']][$ii];
    		$sinavSonucu = $data["sinav_sonuc_" . $ogrenci['TC_KIMLIK']][$ii];
    		$gozetmen = $data["gozetmen_" . $ogrenci['TC_KIMLIK']][$ii];
    		$deger = $data["deger_" . $ogrenci['TC_KIMLIK']][$ii];
    		
    	if($sinavSonucu == "Seçiniz"){
    					$sinavSonucu = "";
    				}
    	$sertifikadurum = 0;
    	$params = array(
    	$ogrenci['TC_KIMLIK'],
    	$sinavId,
    	$sinavSonucu,
    	$puan,
    	$altbirim,
    	$sekil,
    	$sertifikadurum,
    	$gozetmen,
    	$deger
    	);
    		
    	
    	$returnValues[] = $db->prep_exec_insert($sql, $params);
    	}
    	}
    	
    	$sonucGirildiSql = "UPDATE M_SINAV
    	SET BASARILI_ADAY = ".BASARILI_ADAY_EKLENDI."
    	WHERE M_SINAV_ID = ?";
    
    	$returnValues[] = $db->prep_exec_insert($sonucGirildiSql, array($sinavId));
    	
    	$sqlyetki = "UPDATE M_OGRENCI_SINAV SET YETKI_DURUM = 0 WHERE M_SINAV_ID=?";
    	$returnValues[] = $db->prep_exec_insert($sqlyetki, array($sinavId));
    	
    	if(!FormFactory::isThereError($returnValues))
    	{
    		$buUser = JFactory::getUser();
						
			$ssIdleri = FormFactory::getTumSektorSorumlulari();
			foreach ($ssIdleri as $row)
			{
				FormFactory::sektorSorumlusunaNotificationGonder($buUser->name." Kuruluşu Tarafından Sınav Sonucu Girildi", "index.php?option=com_sinav&view=sinav_sec&userId=".$buUser->getOracleUserId(), $row[1]);
			}
			return JText::_('SINAV_SONUC_KAYDEDILDI');
    	}
    	else
    		return JText::_('SINAV_SONUC_KAYDET_HATA');
    	//die();
    
    }
    
    function SonucGuncelle($db, $post){
    	$sinav = $post['sinav'];
    	$sql = "UPDATE M_SINAV
			    	SET BASARILI_ADAY = ".BASARILI_ADAY_EKLENMEDI."
			    	WHERE M_SINAV_ID = ?";
    	$returnValues[] = $db->prep_exec_insert($sql, array($sinav));
    	
    	$sql1 = "UPDATE M_OGRENCI_SINAV SET YETKI_DURUM = 1 WHERE M_SINAV_ID = ?";
    	$returnValues[] = $db->prep_exec_insert($sql1, array($sinav));
    	
    	if(count($returnValues) > 1){
    		ajax_success_response_with_array('Sorgu başarılı', $returnValues);
    		 
    	}
    	else{
    		ajax_error_response('Kayıt bulunamadı'.$sql);
    	}
    }
}
?>
