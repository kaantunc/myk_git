<?php
defined('_JEXEC') or die('Restricted access');

class Terim_SozluguModelTerim_Sozlugu extends JModel {

	function getTerimListesi()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT m_terimler.TERIM_ID, m_terimler.TERIM_ADI, m_terimler.TERIM_ACIKLAMA, pm_terim_aktiflik.AKTIFLIK_ID, pm_terim_aktiflik.ACIKLAMA 
		FROM m_terimler, pm_terim_aktiflik 
		WHERE m_terimler.aktif = pm_terim_aktiflik.aktiflik_id ";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}
	
	function updateAktifPasif($terimArr, $aktiflestirsinMi)
	{
		if($aktiflestirsinMi == 1)
			$aktiflik = PM_TERIM_AKTIFLIK__AKTIF;
		else
			$aktiflik = PM_TERIM_AKTIFLIK__PASIF;
			
		$db  = &JFactory::getOracleDBO();
		$result = '';
		for($i=0; $i<count($terimArr); $i++)
		{
			$sql = "UPDATE m_terimler SET aktif=".$aktiflik." WHERE TERIM_ID = ?";
				
			$params = array ($terimArr[$i]);
			$db->prep_exec($sql, $params);
		}
		return $result;
	}
	
	function ajaxSozlukteAra ($terimAdi, $terimAciklama )
	{
		$_db = JFactory::getOracleDBO();
		
		$find[] = ' ';
		$replace[] = '%';
		$sql = " SELECT m_terimler.TERIM_ID, m_terimler.TERIM_ADI, m_terimler.TERIM_ACIKLAMA, pm_terim_aktiflik.AKTIFLIK_ID, pm_terim_aktiflik.ACIKLAMA  FROM m_terimler, pm_terim_aktiflik WHERE m_terimler.aktif = pm_terim_aktiflik.aktiflik_id   ";
		$params = array();
		if(strlen(str_replace(' ','', $terimAdi))>0)
		{
			$editedterimAdi = "%".str_replace($find, $replace, $terimAdi)."%";
			$adCondition = " TURKCE_UPPER(terim_adi) LIKE TURKCE_UPPER(?) ";
			$params[] = $editedterimAdi;
			$firstAndPart=" AND ";
		}
		if(strlen(str_replace(' ','', $terimAciklama))>0)
		{
			$editedterimAciklama = "%".str_replace($find, $replace, $terimAciklama)."%";
			$aciklamaCondition = " TURKCE_UPPER(terim_aciklama) LIKE TURKCE_UPPER(?) ";
			$params[] = $editedterimAciklama;
			$firstAndPart=" AND ";
		}
		if(strlen(str_replace(' ','', $terimAdi))>0 && strlen(str_replace(' ','', $terimAciklama))>0)
			$andPartBetweenEach=" AND ";
		
		
		$sql = $sql.$firstAndPart.$adCondition.$andPartBetweenEach.$aciklamaCondition;
		
		$results = $_db->prep_exec($sql, $params);
		
		ajax_success_response_with_array("SUCCESS", $results);
		
	}
	
	function ajaxSozlugeEkle ($terimAdi, $terimAciklama )
	{
		$_db = JFactory::getOracleDBO();
		$sql = "INSERT INTO m_terimler (terim_id, terim_adi, terim_aciklama) VALUES (?,?,?,?)";
		$terimID = $_db->getNextVal (TERIM_SEQ);
		$params = array($terimID, $terimAdi, $terimAciklama, PM_TERIM_AKTIFLIK__AKTIF);
		
		if($_db->prep_exec_insert($sql, $params)== true )
			ajax_success_response();
		else
			ajax_error_response("Eklemede hata!");
		
	}
}
?>