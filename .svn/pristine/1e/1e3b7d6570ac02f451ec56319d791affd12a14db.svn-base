<?php
defined('_JEXEC') or die('Restricted access');

$kayit_pk = 1;
echo "<a href='index.php?option=com_chronocontact&formname=deneme2&id=".$kayit_pk."&lang=tr&format=pdf'>PDF için tıklayınız...</a>";

// @todo nerden geldiğini bul, eğer formdan gelmiyosa hiçbişey gösterme
//if(isset($_POST['kimlik_no'])){
//	verileriEkle();
//}
	
	function verileriEkle(){
		//Get Oracle Database Object
		$db = & JFactory::getOracleDBO();
		
		$kayit_pk = $db->getNextVal("bilgiformu_seq");
		statikVerileriEkle($db, $_POST, $kayit_pk);

		/** Dinamik Tablo Degerleri 
		****************************************************/
		//Ogrenim
		$tableName = "ogrenim";
		$colCount = 2;
		
		$ogrenim = dinamikTabloyaEkle($db, $tableName, $colCount, $kayit_pk);
	
		//Sertifika
		$tableName = "sertifika";
		$colCount = 3;
		
		$sertifika = dinamikTabloyaEkle($db, $tableName, $colCount, $kayit_pk);
		
		//Is Deneyimi
		$tableName = "is_deneyimi";
		$colCount = 4;	
		
		$is_deneyimi = dinamikTabloyaEkle($db, $tableName, $colCount, $kayit_pk);
		
		/** Dinamik Tablo Degerleri Sonu 
		****************************************************/	
		
		//echo "<a href='index.php?option=com_chronocontact&formname=form2&id=".$kayit_pk."&lang=tr&format=pdf'>PDF için tıklayınız...</a>";
	}
	
	function dinamikTabloyaEkle($db, $tableName, $colCount, $kayit_pk){
						
		$columnIds = $db->loadResultArray("SELECT property_types_pk
				FROM property_types, dinamik_tablolar
				WHERE tablo_adi = '".$tableName."'
					AND dinamik_tablo_pk = tablo_no
				ORDER BY property_types_pk ASC");
		
		if(empty($columnIds))
			return false;
		if(!isset($_POST['input'.$tableName.'-1']))
			return false;
		for ($i=0; $i < $colCount; $i++){
			$array=$_POST['input'.$tableName.'-'.($i+1)];
			
			for($j=0; $j<count($array); $j++)//herbir kolonun herbir elemanı için
			{
				if($array[$j]){
					$db->prep_exec_insert("INSERT INTO
						property_values
						VALUES(NULL, ?, ?, ?, ?)",
						array($columnIds[$i], 
								$array[$j],
								($j+1),
								$kayit_pk));

//					echo '<pre>';
//					print_r($db->getPDO()->errorInfo());
//					echo '</pre>';
				}
								
			}
		}
		
	}
	
	function statikVerileriEkle($db, $_POST, $kayit_pk){
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		//1.Kisisel Bilgiler
		$kimlik_no = $_POST['kimlik_no'];
		$ad = $_POST['ad'];
		$soyad = $_POST['soyad'];
		$telefon = $_POST['telefon'];
		$faks = $_POST['faks'];
		$e_posta = $_POST['e_posta'];
		$ogrenim_durumu = $_POST['ogrenim_durumu'];
		$meslegi = $_POST['meslegi'];
		$gorevi = $_POST['gorevi'];
		$gorev_alacagi_yet = $_POST['gorev_alacagi_yet'];
		
		//4. Egitimler
		$alinan_egitimler = $_POST['alinan_egitimler'];
		
		//6. Yabanci Dil
		$yabanci_diller = $_POST['yabanci_diller'];
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO kisiler_icin_bilgi_formu 
			    values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($kayit_pk,
						$kimlik_no, 
						$ad,
						$soyad,
				        $telefon,
				        $faks,
				        $e_posta,
				        $ogrenim_durumu,
				        $meslegi,
				        $gorevi,
				        $gorev_alacagi_yet,
				        $alinan_egitimler,
				        $yabanci_diller);

		return $db->prep_exec_insert($sql, $params);
	}	
?>
