<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_BirimModelYeterlilik_Birim extends JModel {

	function birimEkle($birimID, $birimAdi, $referansKodu, $seviye, $krediDegeri, $yayinTarihi, $revizyonNo, $revizyonTarihi)
	{
		//INPUTLAR DOĞRU, EKLEME YAP
		
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_yeterlilik_birim 
				(YETERLILIK_BIRIM_ID, YETERLILIK_BIRIM_ADI,YETERLILIK_BIRIM_KODU,YETERLILIK_BIRIM_SEVIYE,YETERLILIK_BIRIM_KREDI, YETERLILIK_BIRIM_YAYIN_TAR, YETERLILIK_BIRIM_REV_NO, YETERLILIK_BIRIM_REV_TAR) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
		if (isset($yayinTarihi) && !empty($yayinTarihi)){
			$yayinTarihi = "TO_DATE($yayinTarihi, 'dd.mm.yyyy')";
		}
		
		if (isset($revizyonTarihi) && !empty($revizyonTarihi)){
			$revizyonTarihi = "TO_DATE($revizyonTarihi, 'dd.mm.yyyy')";
		}
			
		$params = array ($birimID, $birimAdi, $referansKodu, $seviye, $krediDegeri, $yayinTarihi, $revizyonNo, $revizyonTarihi);
		return $db->prep_exec_insert($sql, $params);
	}
	
	function getBirimInfo ($birimID){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT YETERLILIK_BIRIM_ID,
					   YETERLILIK_BIRIM_ADI,
					   YETERLILIK_BIRIM_KODU,
					   YETERLILIK_BIRIM_SEVIYE,
					   YETERLILIK_BIRIM_KREDI,
					   TO_CHAR(YETERLILIK_BIRIM_YAYIN_TAR, 'dd.mm.yyyy') AS YETERLILIK_BIRIM_YAYIN_TAR,
					   YETERLILIK_BIRIM_REV_NO,
					   TO_CHAR(YETERLILIK_BIRIM_REV_TAR, 'dd.mm.yyyy') AS YETERLILIK_BIRIM_REV_TAR
				FROM m_yeterlilik_birim
				WHERE yeterlilik_birim_id = ?
		";
		
		$params = array ($birimID);
		return $db->prep_exec($sql, $params);	
	}
	
	function getBirimKaynak ($birimID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT	KAYNAK_ID,
						YETERLILIK_BIRIM_ID,
						KAYNAK_ACIKLAMA,
						KAYNAK_TUR_ID,
						STANDART_KODU,
						STANDART_ADI,
						STANDART_ID,
						SEVIYE_ADI
				FROM m_yeterlilik_birim_kaynak
		             LEFT JOIN m_meslek_standartlari USING (standart_id)
		             LEFT JOIN pm_seviye USING (seviye_id)
				WHERE yeterlilik_birim_id = ?
				";
	
		$params = array ($birimID);
		return $db->prep_exec($sql, $params);
	}
}
?>
