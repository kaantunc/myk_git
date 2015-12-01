<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');

$db  = &JFactory::getOracleDBO();


//KURULUS
$ms_ontaslak_sql = "
SELECT USER_ID,
	   KURULUS_ADI
FROM M_KURULUS
";

$ms_kurulus = $db->prep_exec($ms_ontaslak_sql, array());

//meslekStd ($ms_kurulus, $db);
//yeterlilik ($ms_kurulus, $db);


function yeterlilik ($ms_kurulus, $db) {

	foreach ($ms_kurulus as $kurulus){
		$userId = $kurulus["USER_ID"];
		
		//ON TASLAK
		$yet_ontaslak_sql = "
					
					SELECT 	YETERLILIK_ID,
				        YETERLILIK_ADI
				     FROM m_yeterlilik 
				        JOIN m_yeterlilik_evrak USING (yeterlilik_id) 
				        JOIN m_basvuru USING (evrak_id)
				        JOIN pm_yeterlilik_durum USING (yeterlilik_durum_id)  
				     WHERE user_id = ? AND 
				         basvuru_durum_id = 6 AND 
				        (basvuru_tip_id = 2 OR 
				         basvuru_tip_id = 10) AND 
				         yeterlilik_surec_durum_id NOT IN ( 1, -1, -3) AND 
				           yeterlilik_id NOT IN (SELECT yeterlilik_id 
				                     FROM m_taslak_yeterlilik  
				                      JOIN ".DB_PREFIX.".EVRAK USING (evrak_id) 
				                     WHERE basvuru_sekli_id = 1) 
					
					";
		
		$yet_ontaslak = $db->prep_exec($yet_ontaslak_sql, array($userId));
		
		//TASLAK
		$yet_taslak_sql = "
						SELECT  YETERLILIK_ID,
								EVRAK_ID  
						FROM M_YETERLILIK
							JOIN M_TASLAK_YETERLILIK USING (YETERLILIK_ID) 
							JOIN ".DB_PREFIX.".EVRAK USING (EVRAK_ID) 
							JOIN M_BASVURU USING (EVRAK_ID) 
						WHERE M_BASVURU.USER_ID = ? AND 
							  BASVURU_TIP_ID = 6 AND 
							  BASVURU_SEKLI_ID = 1AND 
							  YETERLILIK_SUREC_DURUM_ID NOT IN (1,-3)
					
					";
		
		$yet_taslak = $db->prep_exec($yet_taslak_sql, array($userId));
		
		
		//ULUSAL
		$yet_ulusal_sql = "
			
		SELECT  YETERLILIK_ID,
							YETERLILIK_ADI 
					FROM M_YETERLILIK
						JOIN M_TASLAK_YETERLILIK USING (YETERLILIK_ID)
						JOIN ".DB_PREFIX.".EVRAK USING (EVRAK_ID) 
						JOIN M_BASVURU USING (EVRAK_ID) 
					WHERE M_BASVURU.USER_ID = ? 
						  BASVURU_TIP_ID = 6 AND 
						  BASVURU_SEKLI_ID = 1 AND 
						  YETERLILIK_SUREC_DURUM_ID = 1
					";
						
		$yet_ulusal = $db->prep_exec($ms_ulusal_sql, array($userId));
		
		if (count($yet_ontaslak) > 0 || count($yet_taslak) > 0 || count($yet_ulusal) > 0){
			//PROTOKOL
			$protokolID = $db->getNextVal (YETKI_SEQ);
			echo "PROTOKOL ID : ".$protokolID." USER ID :".$userId."<br/>";
	
			$protokol_insert_sql = "INSERT INTO m_yetki (YETKI_ID,ADI,IMZA_TARIHI,SURESI,ETKIN, YETKI_TURU, PROTOKOL_DOSYA) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$params = array ($protokolID, "Yeterlilik Hazirlama Protokolü - ".$kurulus["KURULUS_ADI"]."-".$userId, NULL , NULL, 1, PM_PROTOKOLTURU_YETERLILIKPROTOKOLU, NULL);
	
			if ($db->prep_exec_insert($protokol_insert_sql, $params)){
				//KURULUS_YETKI
				$yetki_insert_sql = "INSERT INTO m_kurulus_yetki (user_id, yetki_id) VALUES (?, ?)";
					
				$params = array ($userId, $protokolID);
				$db->prep_exec_insert($yetki_insert_sql, $params);
					
				//ON TASLAK YETERLILIK_YETKI
				$yet_insert_sql = "INSERT INTO m_yetki_yeterlilik VALUES (?, ?)";
					
				foreach ($yet_ontaslak as $row){
						
					$db->prep_exec_insert($yet_insert_sql, array($protokolID, $row["YETERLILIK_ID"]));
						
					//STANDART DURUM
					$evrakId = getOracleEvrakIdYet ($row["YETERLILIK_ID"]);
					$evrakDurumId =	getEvrakDurumId ($evrakId);
					
					if ($evrakDurumId){
						if ($evrakDurumId == KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID){
							$evrakDurum = -2;
						}else if ($evrakDurumId == ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID){
							$evrakDurum = -1;
						}else if ($evrakDurumId == KAYDEDILMEMIS_BASVURU_SEKLI_ID){
							$evrakDurum = 0;
						}
					}else{
						$evrakDurum = -3;
					}
						
					$yet_update_sql = "UPDATE m_yeterlilik set YETERLILIK_DURUM_ID = ? where yeterlilik_id =?";
					$db->prep_exec_insert($yet_update_sql, array($evrakDurum, $row["YETERLILIK_ID"]));
				}
					
					
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								
				//TASLAK YETERLILIK YETKI
				$yet_insert_sql = "INSERT INTO m_yetki_yeterlilik VALUES (?, ?)";
					
				foreach ($yet_taslak as $row){
						
					$db->prep_exec_insert($yet_insert_sql, array($protokolID, $row["YETERLILIK_ID"]));
						
					$yet_update_sql = "UPDATE m_yeterlilik set YETERLILIK_DURUM_ID = ? where yeterlilik_id =?";
					$db->prep_exec_insert($yet_update_sql, array(1, $row["YETERLILIK_ID"]));
				}
					
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
					
				//ULUSAL YETERLILIK_YETKI
				$yet_insert_sql = "INSERT INTO m_yetki_yeterlilik VALUES (?, ?)";
					
				foreach ($yet_ulusal as $row){
						
					$db->prep_exec_insert($yet_insert_sql, array($protokolID, $row["STANDART_ID"]));
						
					$yet_update_sql = "UPDATE m_yeterlilik set YETERLILIK_DURUM_ID = ? where yeterlilik_id =?";
					$db->prep_exec_insert($yet_update_sql, array(2, $row["YETERLILIK_ID"]));
				}
			}
		}
	}
}



function meslekStd ($ms_kurulus, $db) {

	foreach ($ms_kurulus as $kurulus){
		$userId = $kurulus["USER_ID"];
		
		//ON TASLAK
		$ms_ontaslak_sql = "
					
					SELECT STANDART_ID, 
					    STANDART_ADI
					 FROM m_meslek_standartlari 
					      JOIN m_meslek_stan_evrak USING (standart_id) 
					      JOIN m_basvuru USING (evrak_id)    
					 WHERE user_id = ? AND 
					     basvuru_durum_id = 6 AND 
					    (basvuru_tip_id = 1 OR 
					     basvuru_tip_id = 9 ) AND 
					     meslek_standart_surec_durum_id NOT IN ( -1,-3, 5, 15, 1 ) AND 
					     standart_id NOT IN (SELECT standart_id 
					               FROM m_taslak_meslek 
					                JOIN ".DB_PREFIX.".EVRAK USING (evrak_id) 
					               WHERE basvuru_sekli_id = 1) 
					 ORDER BY standart_id
					
					";
			
		$ms_ontaslak = $db->prep_exec($ms_ontaslak_sql, array($userId));
		
		//TASLAK
		$ms_taslak_sql = "
					
					SELECT  STANDART_ID,
							STANDART_ADI, 
							SEKTOR_ID, 
							EVRAK_ID  
					FROM M_MESLEK_STANDARTLARI
						JOIN M_TASLAK_MESLEK USING (STANDART_ID)
						JOIN ".DB_PREFIX.".EVRAK  USING (EVRAK_ID) 
						JOIN M_BASVURU USING(EVRAK_ID) 
					WHERE M_BASVURU.USER_ID = ? AND
						  BASVURU_TIP_ID = 1 AND 
						  BASVURU_SEKLI_ID = 1 AND 
						  MESLEK_STANDART_SUREC_DURUM_ID NOT IN (1,14,-3)
					
					";
			
		$ms_taslak = $db->prep_exec($ms_taslak_sql, array($userId));
		
		//ULUSAL
		$ms_ulusal_sql = "
					
					SELECT  STANDART_ID,
							STANDART_ADI
					FROM M_MESLEK_STANDARTLARI
						JOIN M_TASLAK_MESLEK USING (STANDART_ID) 
						JOIN ".DB_PREFIX.".EVRAK  USING (EVRAK_ID) 
						JOIN M_BASVURU USING(EVRAK_ID) 
					WHERE M_BASVURU.USER_ID = ? AND 
						  BASVURU_TIP_ID = 5 AND 
						  BASVURU_SEKLI_ID = 1 AND 
						  MESLEK_STANDART_SUREC_DURUM_ID IN (1,14)
					";
			
		$ms_ulusal = $db->prep_exec($ms_ulusal_sql, array($userId));
			
		if (count($ms_ontaslak) > 0 || count($ms_taslak) > 0 || count($ms_ulusal) > 0){
			
			//PROTOKOL
			$protokolID = $db->getNextVal (YETKI_SEQ);
			echo "PROTOKOL ID : ".$protokolID." USER ID :".$userId."<br/>";
			
			$protokol_insert_sql = "INSERT INTO m_yetki (YETKI_ID,ADI,IMZA_TARIHI,SURESI,ETKIN, YETKI_TURU, PROTOKOL_DOSYA) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$params = array ($protokolID, "MS Hazirlama Protokolü - ".$kurulus["KURULUS_ADI"]."-".$userId, NULL , NULL, 1, PM_PROTOKOLTURU_MESLEKSTANDARDIPROTOKOLU, NULL);
			
			if ($db->prep_exec_insert($protokol_insert_sql, $params)){
				//KURULUS_YETKI
				$yetki_insert_sql = "INSERT INTO m_kurulus_yetki (user_id, yetki_id) VALUES (?, ?)";
				
				$params = array ($userId, $protokolID);
				$db->prep_exec_insert($yetki_insert_sql, $params);
				
	
				
				//ON TASLAK STANDART_YETKI
				$standart_insert_sql = "INSERT INTO m_yetki_standart VALUES (?, ?)";
				
				foreach ($ms_ontaslak as $row){
				
					$db->prep_exec_insert($standart_insert_sql, array($protokolID, $row["STANDART_ID"]));
				
					//STANDART DURUM
					$evrakId = getOracleEvrakId ($row["STANDART_ID"]);
					$evrakDurumId =	getEvrakDurumId ($evrakId);
				
				
					if ($evrakDurumId){
						if ($evrakDurumId == KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID){
							$evrakDurum = -2;
						}else if ($evrakDurumId == ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID){
							$evrakDurum = -1;
						}else if ($evrakDurumId == KAYDEDILMEMIS_BASVURU_SEKLI_ID){
							$evrakDurum = 0;
						}
					}else{
						$evrakDurum = -3;
					}
				
					$standart_update_sql = "UPDATE m_meslek_standartlari set MESLEK_STANDART_DURUM_ID = ? where standart_id =?";
					$db->prep_exec_insert($standart_update_sql, array($evrakDurum, $row["STANDART_ID"]));
				}
				
				
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							
				//TASLAK STANDART_YETKI
				$standart_insert_sql = "INSERT INTO m_yetki_standart VALUES (?, ?)";
				
				foreach ($ms_taslak as $row){
				
					$db->prep_exec_insert($standart_insert_sql, array($protokolID, $row["STANDART_ID"]));
				
					$standart_update_sql = "UPDATE m_meslek_standartlari set MESLEK_STANDART_DURUM_ID = ? where standart_id =?";
					$db->prep_exec_insert($standart_update_sql, array(1, $row["STANDART_ID"]));
				}
				
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//ULUSAL STANDART_YETKI
				$standart_insert_sql = "INSERT INTO m_yetki_standart VALUES (?, ?)";
				
				foreach ($ms_ulusal as $row){
				
					$db->prep_exec_insert($standart_insert_sql, array($protokolID, $row["STANDART_ID"]));
				
					$standart_update_sql = "UPDATE m_meslek_standartlari set MESLEK_STANDART_DURUM_ID = ? where standart_id =?";
					$db->prep_exec_insert($standart_update_sql, array(2, $row["STANDART_ID"]));
				}
			}
		}
	}
}


function getEvrakDurumId ($evrak_id){
	$_db = &JFactory::getOracleDBO();

	$sql = "SELECT basvuru_sekli_id
				FROM ".DB_PREFIX.".evrak 
				WHERE evrak_id = ?";

	$params = array ($evrak_id);

	$data = $_db->prep_exec_array($sql, $params);

	if (!empty($data))
		return $data[0];
	else
		return false;
}

function getOracleEvrakId ($standart_id){
	$_db = &JFactory::getOracleDBO();

	$sql= "SELECT evrak_id
			   FROM m_taslak_meslek 
			   WHERE standart_id = ?";

	$params = array ($standart_id);

	$data = $_db->prep_exec_array($sql, $params);

	if (!empty($data))
		return $data[0];
	else
		return -1;
}

function getOracleEvrakIdYet ($yeterlilik_id){
	$_db = &JFactory::getOracleDBO();

	$sql= "SELECT evrak_id
			   FROM m_taslak_yeterlilik 
			   WHERE standart_id = ?";

	$params = array ($yeterlilik_id);

	$data = $_db->prep_exec_array($sql, $params);

	if (!empty($data))
	return $data[0];
	else
	return -1;
}
?>