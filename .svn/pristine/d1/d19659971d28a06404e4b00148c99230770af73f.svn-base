<?php 
	$db = & JFactory::getOracleDBO();


	
	
	
	
	
	
	//////////
	
	
	
	$sql = "SELECT  STANDART_ID,
							STANDART_ADI,
							SEVIYE_ADI,
							TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy')
									AS BASLANGIC_TARIHI_FORMATTED,
							MESLEK_STANDART_DURUM_ADI,
							MESLEK_STANDART_DURUM_ID, 
							SEKTOR_ADI, 
							SEKTOR_ID, 
							EVRAK_ID  
					FROM M_MESLEK_STANDARTLARI
						NATURAL JOIN YENIDYS.EVRAK 
						JOIN M_TASLAK_MESLEK USING (EVRAK_ID, STANDART_ID) 
						JOIN M_BASVURU USING(EVRAK_ID, USER_ID) 
						JOIN PM_SEVIYE USING(SEVIYE_ID) 
						JOIN PM_SEKTORLER USING(SEKTOR_ID) 
						JOIN PM_MESLEK_STANDART_DURUM USING(MESLEK_STANDART_DURUM_ID) 
					WHERE USER_ID = 5596 AND   
						  BASVURU_TIP_ID = 5 AND 
						  BASVURU_SEKLI_ID = 1 AND 
						  MESLEK_STANDART_SUREC_DURUM_ID  IN (1,14 )";

	$params = array ();
	$table =  $db->prep_exec($sql, $params);

	foreach($table as $satir){
		$sql="update m_meslek_standartlari
		set meslek_standart_durum_id=2
		where standart_id=".$satir[STANDART_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}


	$sql = "SELECT  STANDART_ID,
							STANDART_ADI,
							SEVIYE_ADI,
							TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy')
									AS BASLANGIC_TARIHI_FORMATTED,
							MESLEK_STANDART_DURUM_ADI,
							MESLEK_STANDART_DURUM_ID, 
							SEKTOR_ADI, 
							SEKTOR_ID, 
							EVRAK_ID  
					FROM M_MESLEK_STANDARTLARI
						NATURAL JOIN YENIDYS.EVRAK 
						JOIN M_TASLAK_MESLEK USING (EVRAK_ID, STANDART_ID) 
						JOIN M_BASVURU USING(EVRAK_ID, USER_ID) 
						JOIN PM_SEVIYE USING(SEVIYE_ID) 
						JOIN PM_SEKTORLER USING(SEKTOR_ID) 
						JOIN PM_MESLEK_STANDART_DURUM USING(MESLEK_STANDART_DURUM_ID) 
					WHERE USER_ID = 5596 AND   
						  BASVURU_TIP_ID = 5 AND 
						  BASVURU_SEKLI_ID = 1 AND 
						  MESLEK_STANDART_SUREC_DURUM_ID NOT IN (1,14,-3 )";
	
	$params = array ();
	$table =  $db->prep_exec($sql, $params);

	foreach($table as $satir){
		$sql="update m_meslek_standartlari
		set meslek_standart_durum_id=1
		where standart_id=".$satir[STANDART_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	$sql = "
	select standart_id from m_meslek_standartlari join m_taslak_meslek using (standart_id) join yenidys.evrak using(evrak_id)
	where 			   		 meslek_standart_surec_durum_id NOT IN ( ".REDDEDILMIS_STANDART.", ".ONAYLANMIS_STANDART." ) AND 
			   		 standart_id NOT IN (SELECT standart_id 
			   		 					 FROM m_taslak_meslek 
			   		 					 	JOIN ".DB_PREFIX.".evrak USING (evrak_id) 
			   		 					 WHERE basvuru_sekli_id = ".KAYDEDILMIS_BASVURU_SEKLI_ID.") 
		";

	$params = array ();
	$table =  $db->prep_exec($sql, $params);

	foreach($table as $satir){
		$sql="update m_meslek_standartlari
		set meslek_standart_durum_id=-1
		where standart_id=".$satir[STANDART_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	$sql = "
	select standart_id from m_meslek_standartlari 
	where 			   		 meslek_standart_surec_durum_id =14
	";
	
	$params = array ();
	$table =  $db->prep_exec($sql, $params);
	
	foreach($table as $satir){
		$sql="update m_meslek_standartlari
		set meslek_standart_durum_id=2
		where standart_id=".$satir[STANDART_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	
	
	$sql = "
	select standart_id from m_meslek_standartlari
	where 			   		 meslek_standart_surec_durum_id =11
	";
	
	$params = array ();
	$table =  $db->prep_exec($sql, $params);
	
	foreach($table as $satir){
		$sql="update m_meslek_standartlari
		set meslek_standart_durum_id=1
		where standart_id=".$satir[STANDART_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	
	
	
	
	
	/////////////////////////////
	
	
	$sql = "
	select yeterlilik_id from m_yeterlilik join m_taslak_yeterlilik using (yeterlilik_id) join yenidys.evrak using(evrak_id)
	where BASVURU_SEKLI_ID = 1 AND
	YETERLILIK_SUREC_DURUM_ID IN (".ONAYLANMIS_YETERLILIK.")
	";
	
	$params = array ();
	$table =  $db->prep_exec($sql, $params);
	
	foreach($table as $satir){
		$sql="update m_yeterlilik
		set yeterlilik_durum_id=2
		where yeterlilik_id=".$satir[YETERLILIK_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	
	
	
	$sql = "
	select yeterlilik_id from m_yeterlilik join m_taslak_yeterlilik using (yeterlilik_id) join yenidys.evrak using(evrak_id)
	where BASVURU_SEKLI_ID = 1 AND
	YETERLILIK_SUREC_DURUM_ID NOT IN (".ONAYLANMIS_YETERLILIK.",".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK." )
	";
	
	$params = array ();
	$table =  $db->prep_exec($sql, $params);
	
	foreach($table as $satir){
		$sql="update m_yeterlilik
		set yeterlilik_durum_id=1
		where yeterlilik_id=".$satir[YETERLILIK_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	
	
		$sql= "SELECT 	YETERLILIK_ID,
						YETERLILIK_ADI,
						SEVIYE_ADI,
						SEKTOR_ADI 
			   FROM m_yeterlilik 
			   	  JOIN m_yeterlilik_evrak USING (yeterlilik_id) 
			   	  JOIN m_basvuru USING (evrak_id)
			   	  JOIN pm_seviye USING (seviye_id)
			   	  JOIN pm_sektorler USING (sektor_id) 
			   	  JOIN pm_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_id)  
			   WHERE 
			   		 basvuru_durum_id = ".ONAYLANMIS_BASVURU." AND 
			   		(basvuru_tip_id = ".T2_BASVURU_TIP." OR 
			   		 basvuru_tip_id = ".YET_PROTOKOL_BASVURU_TIP.") AND 
			   		 YETERLILIK_SUREC_DURUM_id NOT IN ( ".ONAYLANMIS_YETERLILIK.", ".REDDEDILMIS_YETERLILIK.") AND 
    		   		 yeterlilik_id NOT IN (SELECT yeterlilik_id 
    									   FROM m_taslak_yeterlilik  
    				 						  JOIN ".DB_PREFIX.".evrak USING (evrak_id) 
    				 					   WHERE basvuru_sekli_id = ".KAYDEDILMIS_BASVURU_SEKLI_ID.") 
			   ORDER BY yeterlilik_id";
		
	$params = array ();
	$table =  $db->prep_exec($sql, $params);
	
	foreach($table as $satir){

		$evrakId = getOracleEvrakId ($satir[YETERLILIK_ID]);
		$evrakDurumId =	getEvrakDurumId ($evrakId);
		$evrakDurum		= "";
		
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
		
		
		
		
		
		$sql="update m_yeterlilik
		set yeterlilik_durum_id=".$evrakDurum."
		where yeterlilik_id=".$satir[YETERLILIK_ID];
		$params = array ();
		$db->prep_exec_insert($sql, $params);
	}
	
	echo "Durum işlemleri OK";


function getOracleEvrakId ($yeterlilikId){
	$_db = &JFactory::getOracleDBO();

	$sql= "SELECT evrak_id
	FROM m_taslak_yeterlilik
	WHERE yeterlilik_id = ?";

	$params = array ($yeterlilikId);

	$data = $_db->prep_exec_array($sql, $params);

	if (!empty($data))
		return $data[0];
	else
		return -1;
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


?>