<?php
defined('_JEXEC') or die('Restricted access');

class Yonetim_KuruluModelYonetim_Kurulu_Kaydet extends JModel {

	function uyeleriEtkisizlestir($yonetimKuruluArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($yonetimKuruluArr); $i++)
		{
			$sql = "UPDATE m_yonetim_kurulu SET etkin=2 WHERE UYE_ID = ?";
			$params = array ($yonetimKuruluArr[$i]);
			$db->prep_exec($sql, $params);
		}
		return $result;
	}

	function uyeleriEtkinlestir($yonetimKuruluArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($yonetimKuruluArr); $i++)
		{
			$sql = "UPDATE m_yonetim_kurulu SET etkin=1 WHERE UYE_ID = ?";
			$params = array ($yonetimKuruluArr[$i]);
			$db->prep_exec($sql, $params);
		}
		return $result;
	}
	
	function uyeleriSil($yonetimKuruluArr, &$messageType)
	{
		$message = "";
		$db  = &JFactory::getOracleDBO();
		for($i=0; $i<count($yonetimKuruluArr); $i++)
		{
			$uyeID = $yonetimKuruluArr[$i];
			$params = array($uyeID);
			
			$sql = "DELETE FROM m_yonetim_kurulu WHERE UYE_ID=?";
			$db->prep_exec($sql, $params);
			
		}
		$message = JText::_("DELETE_SUCCESS_MESSAGE");
		
		return $message;
	}
	
	function uyeEkle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_yonetim_kurulu (UYE_ID, AD_SOYAD, UNVAN, KURUM, ETKINLIK_BASLANGIC_TARIHI, ETKINLIK_BITIS_TARIHI, ETKIN) VALUES (?, ?, ?, ?, TO_DATE(?, 'dd.mm.yyyy'), TO_DATE(?, 'dd.mm.yyyy'), 1)";
			
		$params = array ($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		return $messageToReturn;
	}
	
	function uyeBilgileriDuzenle($uyeID, $uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE m_yonetim_kurulu SET AD_SOYAD=? , UNVAN=?, KURUM=?, ETKINLIK_BASLANGIC_TARIHI=TO_DATE(?, 'dd.mm.yyyy'), ETKINLIK_BITIS_TARIHI=TO_DATE(?, 'dd.mm.yyyy') WHERE UYE_ID=? ";
			
		$params = array ($uyeAdiSoyadi, $uyeUnvani, $uyeKurumu, $uyeBaslangicTarihi, $uyeBitisTarihi, $uyeID);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		return $messageToReturn;
	}
}
?>