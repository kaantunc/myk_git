<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form_config.php');

class Protokol_YetModelProtokol_Kaydet extends JModel {

	/*OK*/function  protokolleriEtkisizlestir($protokollerArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($protokollerArr); $i++)
		{
			$sql = "UPDATE m_protokol SET etkin=2 WHERE protokol_id = ?";
			
			$params = array ($protokollerArr[$i]);
			$db->prep_exec($sql, $params);
		}	
		return $result;
	}
	
	/*OK*/function  protokolleriEtkinlestir($protokollerArr)
	{
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($protokollerArr); $i++)
		{
			$sql = "UPDATE m_protokol SET etkin=1 WHERE protokol_id = ?";
				
			$params = array ($protokollerArr[$i]);
			$db->prep_exec($sql, $params);
		}
		return $result;
	}

	
	/*OK*/function protokolleriSil($protokollerArr, $messageType)
	{
		$message = "";
		for($i=0; $i<count($protokollerArr); $i++)
		{
			$protokolID = $protokollerArr[$i];
			$params = array($protokolID);
			
			$db  = &JFactory::getOracleDBO();
			
			$sql = "SELECT *
					FROM   m_yetki 
					WHERE  ilgili_protokol_id=?";
			
			$kayitliYetkilendirme = $db->prep_exec($sql, $params);
			
			if(count($kayitliYetkilendirme)==0)
			{
				$sql = "UPDATE m_protokol SET silindi=".PM_PROTOKOL_SILINMIS."WHERE protokol_id=? ";
				$db->prep_exec($sql, $params);
			}
			else
			{
				for($j=0; $j<count($kayitliYetkilendirme); $j++)
				$message .= "<li> - <a class='protokolSilErrorLinkleri' href='".$kayitliYetkilendirme[$j]["YETKI_ID"]."'>".$kayitliYetkilendirme[$j]["ADI"]."</a></li>";
			}
			
		}
		
		if(strlen($message)>0)
		{
			$message = JText::_("DELETE_ERROR_MESSAGE").$message;
			$messageType = "error";
		}
		else
			$message = JText::_("DELETE_SUCCESS_MESSAGE");
		
		return $message;
	}
	
	/*OK*/function protokolBilgileriDuzenle($protokolID, $protokolAdi, $imzaTarihi, $sayisi, $suresi, $filePath)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE m_protokol SET adi=? ,imza_tarihi = TO_DATE(?, 'dd.mm.yyyy'), sayisi = ?, suresi=?, dosya = ? WHERE protokol_id=? ";
			
		$params = array ($protokolAdi, $imzaTarihi, $sayisi,FormParametrik::harfleriTexttenCikar($suresi), $filePath, $protokolID);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		return $messageToReturn;
	}
	
	/*OK*/function protokolEkle($protokolID, $protokolAdi, $imzaTarihi, $sayisi,$suresi, $filePath)
	{
		//INPUTLAR DOĞRU, EKLEME YAP
		
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_protokol (PROTOKOL_ID, ADI, IMZA_TARIHI, SAYISI , ETKIN, PROTOKOL_TURU, SURESI, DOSYA, SILINDI) VALUES (?, ?, TO_DATE(?, 'dd.mm.yyyy'), ?, ?, ?, ?, ?, ".PM_PROTOKOL_SILINMEMIS." )";
			
		$params = array ($protokolID, $protokolAdi, $imzaTarihi, $sayisi, 1, PM_PROTOKOLTURU_YETERLILIK, FormParametrik::harfleriTexttenCikar($suresi), $filePath);
		$messageToReturn = $db->prep_exec_insert($sql, $params);			
	
		return $messageToReturn;
	}
	
	/*OK*/function protokolKurulusuEkle($protokolID, $kurulusID, $kurulusTuru)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "INSERT INTO m_protokol_kurulus (USER_ID, PROTOKOL_ID, KURULUS_TURU) VALUES (?, ?, ?)";
			
		$params = array ($kurulusID, $protokolID, $kurulusTuru);
		$messageToReturn = $db->prep_exec_insert($sql, $params);
		
		return $messageToReturn;
	}

	/*OK*/function protokolKuruluslariniDuzenle($protokolID, $kuruluslar, $kurulusTurleri)
	{
		$db  = &JFactory::getOracleDBO();
		$db->prep_exec_insert("DELETE FROM m_protokol_kurulus WHERE protokol_id = ?", array($protokolID));
		
		for($i=0; $i<count($kuruluslar); $i++)
			$message = $this->protokolKurulusuEkle($protokolID, $kuruluslar[$i], $kurulusTurleri[$i]);
		
		return $message;
	}
	
	function protokolleSektorleriIliskilendir($protokolID, $sektorler)
	{
		$db  = &JFactory::getOracleDBO();
		$db->prep_exec_insert("DELETE FROM m_protokol_sektor WHERE protokol_id = ?", array($protokolID));
		
		
		$params = array();
		for($i=0; $i<count($sektorler); $i++)
		{
			$sql .= " INTO m_protokol_sektor (PROTOKOL_ID, SEKTOR_ID) VALUES (?,?) ";
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