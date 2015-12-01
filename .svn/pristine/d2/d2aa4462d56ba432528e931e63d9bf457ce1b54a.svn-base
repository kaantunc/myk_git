<?php 
	$db = & JFactory::getOracleDBO();

	$params = array ();
	
	$sql="delete from m_terim";
	$db->prep_exec_insert($sql,$params);

	$sql="delete from M_STANDART_TASLAK_TERIM";
	$db->prep_exec_insert($sql,$params);
	
	$sql="insert into m_terim  (select  TERIM_ID,TERIM_ADI,TERIM_ACIKLAMA from M_TASLAK_MESLEK_TERIM)";
	$db->prep_exec_insert($sql,$params);

	$sql="insert into m_terim  (select  TERIM_ID,TERIM_ADI,TERIM_ACIKLAMA from M_YETERLILIK_TERIM)";
	$db->prep_exec_insert($sql,$params);
	
	
	$sql="insert into M_STANDART_TASLAK_TERIM  (select  TERIM_ID , TASLAK_MESLEK_ID from M_TASLAK_MESLEK_TERIM)";
	$db->prep_exec_insert($sql,$params);
	$sql="select * from m_yeterlilik_terim";
	$eskiterim=$db->prep_exec($sql,$param);
	
	/*	
	for($i=0;$i<count($eskiterim);$i++){
		$db->getNextVal(TERIM_SEQ);
		$eskiidler[$i]=$eskiterim[$i][TERIM_ID];
		$yeniidler[$i]=$db->getNextVal(TERIM_SEQ);
		
		$insersql="insert into m_terim (terim_id,terim_adi,terim_aciklama) values (".$yeniidler[$i].",'".$eskiterim[$i][TERIM_ADI]."','".$eskiterim[$i][TERIM_ACIKLAMA]."')";
		
		$db->prep_exec_insert($insertsql, $param);
		
		$sql2="update m_yeterlilik_terim set terim_id=".$yeniidler[$i]." where terim_id=".$eskiidler[$i];
		$db->prep_exec_insert($sql2, $param);
		
		
	}


	$sql = "SELECT distinct terim_adi, terim_aciklama from M_TERIM";

	$params = array ();
	$table =  $db->prep_exec($sql, $params);

	for($i=0; $i<count($table); $i++){
	//		echo $table[$i]["TERIM_ADI"]." - ".$table[$i]["TERIM_ACIKLAMA"]."<br>";
	$sql = "SELECT terim_id from M_TERIM
	where
	terim_adi='".iconv("utf-8","ISO-8859-9",$table[$i]["TERIM_ADI"])."' and
	terim_aciklama='".iconv("utf-8","ISO-8859-9",$table[$i]["TERIM_ACIKLAMA"])."'";
	//            echo $sql."<br>";
	$params = array ();
	$table2 =  $db->prep_exec($sql, $params);
	//            echo $table2[0]."<br>";
	/*            for($ii=0; $ii<count($table2); $ii++){
	echo $table2[$ii]["TERIM_ID"]."-".$table2[$ii]["TERIM_ADI"]."\n\n";
	}
	if (count($table2)>1){
		$theString = "UPDATE M_STANDART_TASLAK_TERIM SET TERIM_ID= ".$table2[0]["TERIM_ID"]." WHERE TERIM_ID IN ";
		$theString2 = "DELETE FROM M_TERIM WHERE TERIM_ID IN ";
		for($j=1; $j<count($table2); $j++)
		{
			if($j==1){
				$theString .= "(";
				$theString2 .= "(";
			}
			$theString.= $table2[$j]["TERIM_ID"];
			$theString2.= $table2[$j]["TERIM_ID"];

			if($j!=count($table2)-1){
				$theString .= ", ";
				$theString2 .= ", ";
			}
			if($j==count($table2)-1){
				$theString .= ")";
				$theString2 .= ")";
			}
		}
		//echo $theString.";<br>";
		//echo $theString2.";<br>";
		$db->prep_exec_multi($theString.";".$theString2);
	}
	*/
	echo "terim işlemleri ok";
?>