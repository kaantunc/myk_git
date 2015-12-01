<?php
defined('_JEXEC') or die('Restricted access');

class Kurulus_Akredite_EtModelKurulus_Akredite_Et extends JModel {

	function akreditasyonKurulusuMu($user_id)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BASVURU WHERE BASVURU_TIP_ID=4 
		AND BASVURU_DURUM_ID=6 AND USER_ID=?";      

		$data = $db->prep_exec($sql, array($user_id));
		
		if(count($data)>0)
			return true;
		else 
			return false;
	
	}
	
	function getAkrediteEdilmisKurulusIDleri($user_id)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT DENETLENEN_KURULUS_ID
		FROM M_AKREDITE_KURULUS_YETKI WHERE DENETCI_KURULUS_ID=? ";      

		return $db->prep_exec_array($sql, array($user_id));
	}
	
	function akrediteKurulusKaydet()
	{
		$oncedenKayitlilar = $_POST['oncedenAkrediteOlmusKuruluslar'];
		$simdikiKayitlilar = $_POST['duzenlemedenSonrakiIDler'];
		
		$user = & JFactory::getUser();
		$user_id = $user->getOracleUserId();
		
		for($i=0; $i<count($oncedenKayitlilar); $i++)//her bir onceden kayitli ID için
		{
			if(in_array($oncedenKayitlilar[$i], $simdikiKayitlilar)==false)//şimdi kayitli değil
			{
				$db = JFactory::getOracleDBO();
				$sql = "DELETE FROM M_AKREDITE_KURULUS_YETKI 
				WHERE DENETCI_KURULUS_ID=? AND DENETLENEN_KURULUS_ID=? ";
				$db->prep_exec_insert($sql, array($user_id, $oncedenKayitlilar[$i]));
			}
			//else -> onceden kayıtlı gene kayıtlı bişey yapma
		}
		for($i=0; $i<count($simdikiKayitlilar); $i++)//şimdi kayıtlı olanlar
		{
			if(in_array($simdikiKayitlilar[$i], $oncedenKayitlilar)==false)//onceden kayitli değil, ekle
			{
				$db = JFactory::getOracleDBO();
				$akrediteYetkiID = $db->getNextVal(AKREDITE_YETKI_ID_SEQ);
				$sql = "INSERT INTO M_AKREDITE_KURULUS_YETKI (DENETCI_KURULUS_ID, DENETLENEN_KURULUS_ID, AKREDITE_YETKI_ID, AKREDITASYON_TARIHI)
				VALUES (?,?,?,SYSDATE) ";
				$db->prep_exec_insert($sql, array($user_id, $simdikiKayitlilar[$i], $akrediteYetkiID));
			}
			//şimdi kayıtlı, önceden de kayıtlıymış, bişey yapma
		}
		
	}
	
	function getAkrediteEdenKuruluslar()
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_KURULUS 
		WHERE USER_ID IN (SELECT DENETCI_KURULUS_ID FROM M_AKREDITE_KURULUS_YETKI )
		 ORDER BY KURULUS_ADI";
		
		return $db->prep_exec($sql, array());
	}
	
	function ajaxKurulusunAkrediteEttigiKuruluslariGetir()
	{
		$_db = JFactory::getOracleDBO();
		$user_id = $_GET['akrediteEdenID'];
		//DB Columns
		$sql = " SELECT * FROM M_AKREDITE_KURULUS_YETKI 
		JOIN M_KURULUS ON (M_AKREDITE_KURULUS_YETKI.DENETLENEN_KURULUS_ID=M_KURULUS.USER_ID)
		WHERE DENETCI_KURULUS_ID=?";
					//@ for disable error display
		$result = $_db->prep_exec($sql, array($user_id));
		
		if (count($result)!=0){
			ajax_success_response_with_array('Başarılı', $result);
		}
		else{
			ajax_error_response('Kayıt Bulunamadı');
		}
		
	}
	
	function getAkrediteEdilebilecekKuruluslar()//tüm kuruluş listesi
	{
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT * FROM M_KURULUS	ORDER BY KURULUS_ADI';//WHERE USER_ID IN ('.implode(', ', $idler).')
		$kuruluslar = $db->prep_exec($sql, array());
		
		return $kuruluslar;
	}
		
}
?>