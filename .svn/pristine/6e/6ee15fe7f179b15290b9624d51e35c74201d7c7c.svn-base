<?php
defined('_JEXEC') or die('Restricted access');


class Yetkilendirme_MsModelYetkilendirme_Kaydet extends JModel {

	function  yetkilendirmeleriEtkisizlestir($yetkilendirmelerArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($yetkilendirmelerArr); $i++)
		{
			$sql = "UPDATE m_yetki SET etkin=2 WHERE YETKI_ID = ?";
			
			$params = array ($yetkilendirmelerArr[$i]);
			$db->prep_exec($sql, $params);
		}	
		return $result;
	}
	
	function  yetkilendirmeleriEtkinlestir($yetkilendirmelerArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($yetkilendirmelerArr); $i++)
		{
		$sql = "UPDATE m_yetki SET etkin=1 WHERE YETKI_ID = ?";
			
		$params = array ($yetkilendirmelerArr[$i]);
		$db->prep_exec($sql, $params);
		}
		return $result;
	}
	
	function yetkilendirmeleriSil($yetkilendirmelerArr, $messageType)
	{
		$message = "";
		for($i=0; $i<count($yetkilendirmelerArr); $i++)
		{
			$yetkilendirmeID = $yetkilendirmelerArr[$i];
			$params = array($yetkilendirmeID);
			
			$db  = &JFactory::getOracleDBO();
			
			$sql = "SELECT m_yetki.YETKI_ID, STANDART_ID, adi
							FROM m_yetki_standart, m_yetki 
							WHERE m_yetki.YETKI_ID = m_yetki_standart.YETKI_ID
								AND m_yetki.YETKI_ID=?";
			
			$kayitliStandartlar = $db->prep_exec($sql, $params);
			
			
			if(count($kayitliStandartlar)==0)
			{
				/*Bu tabloya refer eden tablolar: 	m_yetki_yeterlilik  -> 
				 * 									m_yetki_standart   -> BU KISIMLARI ZATEN ADAMA SILDIRCEZ
				 * 									m_kurulus_yetki
				 */
				
				//DELETE FROM M_KURULUS_YETKI
				
				$sql = "DELETE FROM m_kurulus_yetki WHERE YETKI_ID=?";
				$db->prep_exec($sql, $params);
				// DELETE FROM M_YETKI
				$sql = "DELETE FROM m_yetki WHERE YETKI_ID=?";
				$db->prep_exec($sql, $params);
				
			}
			else
			{
				$message .= "<li> - ".$kayitliStandartlar[0]["ADI"]."</li>";
			}
			
		}
		
		
		if(strlen($message)>0)
		{
			$message = JText::_("DELETE_ERROR_MESSAGE")."<br>".$message;
			$messageType = "error";
		}
		else
		$message = JText::_("DELETE_SUCCESS_MESSAGE");
		
		return $message;
	}
	
	function yetkilendirmeBilgileriDuzenle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $kuruluslar, $yetkilendirmeSuresi, $yetkilendirme_turu, $file_path,  $ilgili_protokol_id, $protokolMu)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE m_yetki 
				SET 
					adi=? ,
					IMZA_TARIHI=TO_DATE(?, 'dd.mm.yyyy'), 
					BITIS_TARIHI=TO_DATE(?, 'dd.mm.yyyy'), 
					SURESI=?, 
					YETKILENDIRME_TURU=?, 
					DOSYA = ?, 
					ILGILI_PROTOKOL_ID=?,
					PROTOKOL_MU=? 
				WHERE YETKI_ID=? ";
			
		$params = array ($yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $yetkilendirmeSuresi, $yetkilendirme_turu, $file_path, $ilgili_protokol_id, $protokolMu, $yetkilendirmeID);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		
		return $messageToReturn;
	}
	
	function yetkilendirmeEkle($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, $yetkilendirmeSuresi,$yetkilendirme_turu, $filePath,  $ilgili_protokol_id)
	{
		//INPUTLAR DOĞRU, EKLEME YAP
		
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_yetki (YETKI_ID,ADI,IMZA_TARIHI,BITIS_TARIHI,ETKIN, YETKI_TURU, SURESI, YETKILENDIRME_TURU, DOSYA, ILGILI_PROTOKOL_ID) VALUES (?, ?, TO_DATE(?, 'dd.mm.yyyy'), TO_DATE(?, 'dd.mm.yyyy'), ?, ?, ?, ?, ?, ?)";
			
		$params = array ($yetkilendirmeID, $yetkilendirmeAdi, $yetkiBaslangici, $yetkiBitisi, 1, PM_YETKILENDIRMETURU_MESLEKSTANDARDIYETKILENDIRME,$yetkilendirmeSuresi, $yetkilendirme_turu, $filePath,  $ilgili_protokol_id);
		$messageToReturn = $db->prep_exec_insert($sql, $params);			
		
		return $messageToReturn;
	}
	
	function yetkilendirmeKurulusuEkle($yetkilendirmeID, $kurulusID, $kurulusTuru)
	{
		
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_kurulus_yetki (user_id, YETKI_ID, kurulus_turu) VALUES (?, ?, ?)";
			
		$params = array ($kurulusID, $yetkilendirmeID, $kurulusTuru);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		
		return $messageToReturn;
	}

	function yetkilendirmeKuruluslariniDuzenle($yetkilendirmeID, $kuruluslar, $kurulusTurleri)
	{
		$db  = &JFactory::getOracleDBO();
		$db->prep_exec_insert("DELETE FROM m_kurulus_yetki WHERE YETKI_ID = ?", array($yetkilendirmeID));
		
		for($i=0; $i<count($kuruluslar); $i++)
			$message = $this->yetkilendirmeKurulusuEkle($yetkilendirmeID, $kuruluslar[$i], $kurulusTurleri[$i]);
		
		return $message;
	}
	function yetkilendirmeyleSektorleriIliskilendir($protokolID, $sektorler)
	{
		$db  = &JFactory::getOracleDBO();
		$db->prep_exec_insert("DELETE FROM m_yetki_sektor WHERE yetki_id = ?", array($protokolID));
		
		
		$params = array();
		for($i=0; $i<count($sektorler); $i++)
		{
			$sql .= " INTO m_yetki_sektor (YETKI_ID, SEKTOR_ID) VALUES (?,?) ";
			$params[] = $protokolID;
			$params[] = $sektorler[$i];
		}
		
		$sql = "INSERT ALL 	".$sql." SELECT * FROM DUAL";
				
		if(count($sektorler)>0)
			$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		return $messageToReturn;
		
	}
}
?>