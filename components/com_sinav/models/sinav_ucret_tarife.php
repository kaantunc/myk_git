<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Ucret_Tarife extends JModel {
    
	function ucretTarifesiKaydet(){
		
		$sil = array();
		$silinecekUcretler = $_POST['silinecekBelgelendirmeProgramlari'];
		$silinecek = explode("-", $silinecekUcretler[0]);
		for($ii = 0; $ii < count($silinecek)-1; $ii++){
				$sil[] = $silinecek[$ii]; 
		}
		
		$eklenecekUcretlerAciklama = $_POST['programAciklamasi'];
		$eklenecekUcretlerUcret = $_POST['programUcreti'];
		$eklenecekUcretlerIndirimliUcret = $_POST['indirimliUcret'];
		$kurulus_id = $_GET['kurulus_id'];
		$ucret_tarifesi_id = $_GET['ucret_tarifesi_id'];
	
		$db  = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM M_UCRET_TARIFESI_UCRETLERI WHERE UCRET_ID IN (".implode(', ', $sil).")";
		if(count($sil)!=0)
		$result = $db->prep_exec_insert($sql, array());
	
		for($i=0; $i<count($eklenecekUcretlerUcret); $i++)
		{
		if(	$eklenecekUcretlerAciklama[$i] != '' ||
		$eklenecekUcretlerUcret[$i] != '' ||
		$eklenecekUcretlerIndirimliUcret[$i] != '')//birinden biri doluysa
		{
		$sql = "INSERT INTO M_UCRET_TARIFESI_UCRETLERI (UCRET_TARIFESI_ID, BELGELENDIRME_PROGRAMI_ACKLM,UCRET, INDIRIMLI_UCRET, UCRET_ID) 
					VALUES (?,?,?,?,?) ";
					$params = array();
		$params[] = $ucret_tarifesi_id;
		$params[] = $eklenecekUcretlerAciklama[$i];
		$params[] = $eklenecekUcretlerUcret[$i];
		$params[] = $eklenecekUcretlerIndirimliUcret[$i];
		$params[] = $db->getNextVal('UCRET_TARIFESI_UCRETLERI_SEQ');
					$result3 =  $db->prep_exec_insert($sql, $params);
		$result = $result && $result3;
		}
			
		}
	
	
		$sql = "UPDATE M_UCRET_TARIFESI SET GENEL_KURAL_SARTLAR=?, INDIRIMLER=?
			WHERE UCRET_TARIFESI_ID=?";
			$params = array();
			$params[] = $_POST['genelKuralveSartlarTextArea'];
		$params[] = $_POST['ucretTarifesiTextArea'];
		$params[] = $ucret_tarifesi_id;
			
		$result2 = $db->prep_exec_insert($sql, $params);
		$result = $result && $result2;
	
		return $result;
	
	
	}
	
	function kurulusIDdenUcretTarifesiGetir($db, $kurulus_id){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UCRET_TARIFESI
		WHERE USER_ID = ?";
	
		$result = $db->prep_exec($sql, array($kurulus_id));
	
		if(count($result)==0)
		{
			$ucretTarifesiID = $db->getNextVal('UCRET_TARIFESI_SEQ');
			$sql = "INSERT INTO M_UCRET_TARIFESI (USER_ID, UCRET_TARIFESI_ID)
			VALUES (?,?)";
	
			$result = $db->prep_exec_insert($sql, array($kurulus_id, $ucretTarifesiID));
	
			$sql = "SELECT * FROM M_UCRET_TARIFESI
			WHERE UCRET_TARIFESI_ID = ?";
	
			$result = $db->prep_exec($sql, array($ucretTarifesiID));
		}
		return $result[0];
	}
	
	
	function getUcretTarifesiUcretleri($db, $ucret_tarifesi_id){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UCRET_TARIFESI_UCRETLERI
		WHERE UCRET_TARIFESI_ID=?";
	
		$result = $db->prep_exec($sql, array($ucret_tarifesi_id));
		return $result;
	}
	
	function kurulusBilgi($db, $user_id){
		$sql = "SELECT KURULUS_ADI FROM M_KURULUS WHERE USER_ID = ?";
		$result = $db->prep_exec($sql, array($user_id));
		return $result;
	}

}
?>
