<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_BirimModelOgrenme_Cikti extends JModel {

	function getOgrenmeCiktilar ($birimID){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT 	OGRENME_CIKTISI_ID,	
						OGRENME_CIKTISI_ADI,
						SIRA_NO
				FROM M_YETERLILIK_BIRIM_OGR_CIKTI
				WHERE YETERLILIK_BIRIM_ID = ?
					ORDER BY SIRA_NO";
		
		$params = array ($birimID);
		return $db->prep_exec($sql, $params);
	}
	
	function getBasarimOlcutler ($birimID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT 	BASARIM_OLCUTU_ID,
						OGRENME_CIKTISI_ID,
						BASARIM_OLCUTU_ADI,
						SIRA_NO
				FROM M_YETERLILIK_BIRIM_BASARIM_OLC 
				WHERE YETERLILIK_BIRIM_ID = ?
					ORDER BY SIRA_NO";
	
		$params = array ($birimID);
		return $db->prep_exec($sql, $params);
	}
	
	function getBaglamlar ($birimID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT 	BAGLAM_ID,
						BASARIM_OLCUTU_ID,
						BAGLAM_ADI,
						SIRA_NO
				FROM M_YETERLILIK_BIRIM_BAGLAM 
				WHERE YETERLILIK_BIRIM_ID = ?
					ORDER BY SIRA_NO";
	
		$params = array ($birimID);
		return $db->prep_exec($sql, $params);
	}
}
?>
