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
		$sql = "SELECT TC_KIMLIK FROM M_OGRENCI
				NATURAL JOIN M_OGRENCI_SINAV
				WHERE M_SINAV_ID = ?";
								
		$params = array($sinavId);
		//echo "-<br />";
		$ogrenciler = $db->prep_exec($sql, $params);
		//echo "-<br />";	
		$sql = "INSERT INTO M_SINAV_SONUCU
				VALUES(?, ?, ?, null, null, null, ?)";
		
		$returnValues = array();// to check if the queries succeeded
		
		foreach($ogrenciler AS $ogrenci){
		
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
				
		$sql = "INSERT INTO M_SINAV_SONUCU
				VALUES( ?, ?, ?, ?, ?, ?, ?)";
		
		foreach($ogrenciler AS $ogrenci){
		
			$dogruCevap = $data["dogru_cevap_" . $ogrenci['TC_KIMLIK']];
			$yanlisCevap = $data["yanlis_cevap_" . $ogrenci['TC_KIMLIK']];
			$bos = $data["bos_" . $ogrenci['TC_KIMLIK']];
			$puan = $data["puan_" . $ogrenci['TC_KIMLIK']];
			$sinavSonucu = $data["sinav_sonuc_" . $ogrenci['TC_KIMLIK']];
			
			$params = array(
					$ogrenci['TC_KIMLIK'],
					$sinavId,
					$sinavSonucu,
					$dogruCevap,
					$yanlisCevap,
					$bos,
					$puan
					);
					
//			echo '<pre>';
//			print_r($params);
//			echo '</pre>';
			$returnValues[] = $db->prep_exec_insert($sql, $params);
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
}
?>
