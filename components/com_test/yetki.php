<?php 
$db = & JFactory::getOracleDBO();
$params = array ();

$sql="delete from m_kurulus_yetki";
$db->prep_exec_insert($sql,$params);
$sql="delete from m_yetki_sektor";
$db->prep_exec_insert($sql,$params);
$sql="delete from m_yetki_standart";
$db->prep_exec_insert($sql,$params);
$sql="delete from m_yetki_yeterlilik";
$db->prep_exec_insert($sql,$params);
$sql="delete from m_yetki";
$db->prep_exec_insert($sql,$params);

$sql="SELECT DISTINCT YENIDYS.TG_USER.USER_ID as user_id, YENIDYS.TG_USER.DISPLAY_NAME as adi
FROM YENIDYS.TG_USER, m_yeterlilik, m_taslak_yeterlilik, YENIDYS.EVRAK
WHERE M_YETERLILIK.yeterlilik_id=M_TASLAK_YETERLILIK.yeterlilik_id
AND M_TASLAK_YETERLILIK.EVRAK_ID=YENIDYS.EVRAK.EVRAK_ID
AND YENIDYS.EVRAK.USER_ID=YENIDYS.TG_USER.USER_ID
AND M_YETERLILIK.yeterlilik_surec_durum_id<>-3
order by adi
";
$result=$db->prep_exec($sql, $params);

foreach($result as $row){

	$yetki_id=$db->getNextVal(YETKI_SEQ);
	$adi=$row[ADI]." Yeterlilik Protokolu";
	$sql="insert into M_YETKI
	(YETKI_ID, ADI, ETKIN, YETKI_TURU, YETKILENDIRME_TURU)
	values(?,?,?,?,?)";

	$params = array ($yetki_id,$adi,1,2,1);
	$db->prep_exec_insert($sql, $params);

	$sql="insert into M_KURULUS_YETKI
	(USER_ID,  YETKI_ID, KURULUS_TURU)
	values(?,?,?)";

	$params = array ($row[USER_ID],$yetki_id,1);
	$db->prep_exec_insert($sql, $params);

	$sql="select sektor_id
	from m_basvuru_sektor, yenidys.evrak
	where m_basvuru_sektor.evrak_id= yenidys.evrak.evrak_id
	and yenidys.evrak.user_id=".$row[USER_ID];
	$params = array ();
	$result2=$db->prep_exec($sql, $params);
	foreach($result2 as $row2){
		$sql="insert into M_YETKI_SEKTOR
			(YETKI_ID, SEKTOR_ID)
			values(?,?)";

		$params = array ($yetki_id,$row2[SEKTOR_ID]);
		$db->prep_exec_insert($sql, $params);

	}

	$sql="SELECT 	YETERLILIK_ID 
			   FROM m_yeterlilik 
			   	  JOIN m_yeterlilik_evrak USING (yeterlilik_id) 
			   	  JOIN m_basvuru USING (evrak_id)
			   WHERE user_id =".$row[USER_ID]."
	";
	$params = array ();
	$result3=$db->prep_exec($sql, $params);
	foreach($result3 as $row3){

		$sql="insert into M_YETKI_YETERLILIK
			(YETKI_ID, YETERLILIK_ID)
			values(?,?)";

		$params = array ($yetki_id,$row3[YETERLILIK_ID]);
		$db->prep_exec_insert($sql, $params);
	}
}


//STANDARTLAR
$sql="SELECT DISTINCT YENIDYS.TG_USER.USER_ID as user_id, YENIDYS.TG_USER.DISPLAY_NAME as adi
	FROM YENIDYS.TG_USER, M_MESLEK_STANDARTLARI, M_TASLAK_MESLEK, YENIDYS.EVRAK
	WHERE M_MESLEK_STANDARTLARI.STANDART_ID=M_TASLAK_MESLEK.STANDART_ID
	AND M_TASLAK_MESLEK.EVRAK_ID=YENIDYS.EVRAK.EVRAK_ID
	AND YENIDYS.EVRAK.USER_ID=YENIDYS.TG_USER.USER_ID
	AND M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID<>-3
	order by adi
	";
$params = array ();
$result=$db->prep_exec($sql, $params);

foreach($result as $row){

	$yetki_id=$db->getNextVal(YETKI_SEQ);
	$adi=$row[ADI]." MS Protokolu";
	$sql="insert into M_YETKI
		(YETKI_ID, ADI, ETKIN, YETKI_TURU, YETKILENDIRME_TURU)
		values(?,?,?,?,?)";

	$params = array ($yetki_id,$adi,1,1,1);
	$db->prep_exec_insert($sql, $params);

	$sql="insert into M_KURULUS_YETKI
		(USER_ID, YETKI_ID, KURULUS_TURU)
		values(?,?,?)";

	$params = array ($row[USER_ID],$yetki_id,1);
	$db->prep_exec_insert($sql, $params);

	$sql="select sektor_id
	from m_basvuru_sektor, yenidys.evrak
	where m_basvuru_sektor.evrak_id= yenidys.evrak.evrak_id
	and yenidys.evrak.user_id=".$row[USER_ID];
	$params = array ();
	$result2=$db->prep_exec($sql, $params);
	foreach($result2 as $row2){
		$sql="insert into M_YETKI_SEKTOR
		(YETKI_ID, SEKTOR_ID)
		values(?,?)";

		$params = array ($yetki_id,$row2[SEKTOR_ID]);
		$db->prep_exec_insert($sql, $params);

	}

	$sql="SELECT
	M_MESLEK_STANDARTLARI.STANDART_ID
	FROM YENIDYS.TG_USER, M_MESLEK_STANDARTLARI, M_TASLAK_MESLEK, YENIDYS.EVRAK
	WHERE M_MESLEK_STANDARTLARI.STANDART_ID=M_TASLAK_MESLEK.STANDART_ID
	AND M_TASLAK_MESLEK.EVRAK_ID=YENIDYS.EVRAK.EVRAK_ID
	AND YENIDYS.EVRAK.USER_ID=YENIDYS.TG_USER.USER_ID
	AND M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID<>-3
	AND YENIDYS.EVRAK.USER_ID=".$row[USER_ID];
	$params = array ();
	$result3=$db->prep_exec($sql, $params);
	foreach($result3 as $row3){


		$sql="insert into M_YETKI_STANDART
		(YETKI_ID, STANDART_ID)
		values(?,?)";

		$params = array ($yetki_id,$row3[STANDART_ID]);
		$db->prep_exec_insert($sql, $params);
	}
}

echo "yetki işlemleri ok";
?>