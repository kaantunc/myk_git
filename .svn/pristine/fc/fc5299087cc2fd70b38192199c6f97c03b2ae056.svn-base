<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/form_config.php');

class Protokol_MsModelProtokol_Ms extends JModel {
	
	function getProtokoller()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	PROTOKOL_ID,
						ADI, 
						TO_CHAR(IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI,
						ETKIN,
						ACIKLAMA  
					FROM m_protokol, pm_yetki_durumu 
					WHERE m_protokol.etkin = pm_yetki_durumu.durum_id AND NOT m_protokol.silindi=".PM_PROTOKOL_SILINMIS." AND m_protokol.protokol_turu = ?
					ORDER BY PROTOKOL_ID";
	
		$params = array (PM_PROTOKOLTURU_MESLEKSTANDARDI);
		return $db->prep_exec($sql, $params);
	
	}
	
	function getEtkinlikDurumlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DURUM_ID, ACIKLAMA
				FROM pm_yetki_durumu";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}
	
	function getProtokol($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	PROTOKOL_ID,
						ADI, 
						TO_CHAR(IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI, 
						SAYISI, 
						ETKIN,
						DOSYA, 
						ACIKLAMA,
						SURESI
				FROM m_protokol, pm_yetki_durumu 
				WHERE m_protokol.etkin = pm_yetki_durumu.durum_id AND m_protokol.protokol_id = ?";
	
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	function getProtokolunSektorleri($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_protokol_sektor WHERE protokol_id = ?";
	
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	function getYetkiliKuruluslar (){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	USER_ID,
						KURULUS_ADI,
						KURULUS_YETKILISI,
						KURULUS_YETKILI_UNVANI,
						KURULUS_ADRESI,
						KURULUS_WEB,
						KURULUS_DURUM_ID,
						KURULUS_YETKILENDIRME_NUMARASI,
						KURULUS_SEHIR  
					FROM m_kurulus    
					WHERE kurulus_durum_id IN (".YETKILI_MS_KURULUS_DURUMLARI.")
					ORDER BY USER_ID";
	
		return $db->prep_exec($sql, array());
	}
	
	function getProtokolKuruluslari($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT *
				FROM m_protokol_kurulus, m_kurulus 
				WHERE m_kurulus.USER_id = m_protokol_kurulus.USER_ID AND m_protokol_kurulus.protokol_id = ?
				ORDER BY m_kurulus.user_id";
	
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	function getUzatmalar($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT *
				FROM m_protokol, m_protokol_sure_uzatma 
				WHERE m_protokol.protokol_id = m_protokol_sure_uzatma.protokol_id AND m_protokol_sure_uzatma.protokol_id = ?
				ORDER BY m_protokol_sure_uzatma.uzatma_id";
	
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	function msProtokoluMu($protokolID)
	{
		$result = false;
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_protokol WHERE protokol_turu = ? AND protokol_id = ?";
	
		$params = array ( PM_PROTOKOLTURU_MESLEKSTANDARDI ,$protokolID);
		
		if(count($db->prep_exec($sql, $params)) > 0)
			$result = true;
	
		return $result;
	}
	
	function pdfGoster ($protokolID){
		$_db = &JFactory::getOracleDBO();
	
		$sql = "SELECT DOSYA
				FROM M_PROTOKOL 
				WHERE PROTOKOL_ID = ?";
	
		$r = $_db->prep_exec_array($sql, array ($protokolID));
		$file = $r[0];
		FormFactory::readFileFromDB($file);
	}

}
?>