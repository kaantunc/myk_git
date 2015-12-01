<?php
defined('_JEXEC') or die('Restricted access');

class Akreditasyon_BasvurModelAkreditasyon_Basvur extends JModel {
	
	var $title 	  = "Akreditasyon Başvuru Formu"; 
	var $pages 	  = array ("kurulus_bilgi","irtibat","faaliyet","ek","basvuru_ekleri");
	var $pageNames= array ("Kuruluş Bilgileri","İrtibat Bilgileri", "Faaliyet Bilgileri", "Kişi Bilgi Eki","Başvuru Ekleri");
	
	function getYetkiTalepValues ($evrak_id){
		$_db = JFactory::getOracleDBO ();
		
		$sql = " SELECT * 
				 FROM m_yeterlilik_talebi  
				 	NATURAL JOIN m_yeterlilik 
				 	NATURAL JOIN pm_seviye 
				 WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
						 					 	
		return $_db->prep_exec($sql, $params);
	}
	
	function getBasvuruEkleri($user_id){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT *
					FROM M_AKREDITASYON_BASVURU_EKLERI 
					WHERE USER_ID = ?";
	
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
		return $data;
		else
		return null;
	}
	
	function getBasvuruEkleriBelgeTuru($user_id){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT BELGE_TURU
					FROM M_AKREDITASYON_BASVURU_EKLERI WHERE USER_ID = ? 
					GROUP BY BELGE_TURU";
	
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
		return $data;
		else
		return null;
	}
}
?>