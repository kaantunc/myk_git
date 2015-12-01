<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Ucret_Tarife_Ara extends JModel {
	
	function KuruluslariGetir(){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT USER_ID, KURULUS_ADI 
					FROM M_KURULUS JOIN M_BASVURU USING(USER_ID) 
					WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 ORDER BY KURULUS_ADI";
		$kuruluslar = $db->prep_exec($sql,array());
		return $kuruluslar;
	}
	
	function YeterlilikGetir(){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT USER_ID, KURULUS_ADI
							FROM M_KURULUS JOIN M_BASVURU USING(USER_ID) 
							WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 ORDER BY KURULUS_ADI";
		$yeterlilikler = $db->prep_exec($sql,array());
		return $yeterlilikler;
	}
	
	function ucretTarifesiAra(){
		$sonuc = $this->kurulusIDdenUcretTarifesiGetir($db, $_POST["kurulus_id"]);
		if(count($sonuc) >= 1){
			ajax_success_response_with_array('Sorgu baÅŸarÄ±lÄ±', $sonuc);
			 
		}
		else{
			ajax_error_response('KayÄ±t bulunamadÄ±-'.$sonuc);
		}
		//return $sonuc;
	}
	
	function kurulusIDdenUcretTarifesiGetir($db, $kurulus_id){
		$db  = &JFactory::getOracleDBO();
		$tarife = array();
	
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
		$tarife[] = $result[0]; 
		$tarife[] = $this->getUcretTarifesiUcretleri($db, $result[0]["UCRET_TARIFESI_ID"]);
		$tarife[] = $this->getKurulusAdi($db, $kurulus_id);
		return $tarife;
	}
	
	function getKurulusAdi($db, $kurulus_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT KURULUS_ADI FROM M_KURULUS
				WHERE USER_ID = ?";
		
		$result = $db->prep_exec($sql, array($kurulus_id));
		return $result;
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
