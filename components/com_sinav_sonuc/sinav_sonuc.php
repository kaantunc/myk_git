<?php

defined('_JEXEC') or die('Restricted access');

$db = & JFactory::getOracleDBO();

if(isset($_POST['gorev']) && $_POST['gorev'] == "kapsamAl"){
	
	$yetId = isset($_POST['yetId']) ? $_POST['yetId'] : null;
		
	$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?";
 
$kapsamlar = $db->prep_exec($sql,array($yetId));

$comboText = '';
$isFirst = true;

if(isset($kapsamlar)){
foreach ($kapsamlar as $row){
	if($isFirst){
		$comboText .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
		$isFirst = false;
	}
	else
		$comboText .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
}
	//$comboText.="**Başarısız##Başarısız";
}

	echo $comboText;
	
	die();
}

else if(isset($_POST['gorev']) && $_POST['gorev'] == "sonucKaydet"){
	
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
	
	$sinavSekli = $_POST['sinavSekli'];
	$sinavTuru = $_POST['sinavTuru'];
	$evrakId = $_POST['evrakId'];
	$sinavTarihi = $_POST['sinavTarihi'];
	$sinavYeri = $_POST['sinavYeri'];
	$sinavYapan = $_POST['sinavYapan'];
		
	$sql = "SELECT TC_KIMLIK FROM M_OGRENCI
			WHERE EVRAK_ID = ?";
							
	$params = array($evrakId);
	$ogrenciler = $db->prep_exec($sql, $params);
	
	?>
	<div class="sinavGirisBaslik">Sınav Sonucu Giriş Ekranı</div>
	<?php
	
	// sonucları al kaydet
	echo "Sınav sonuçları kaydedildi.<br /><br />
			Başka sınav sonucu girmek istiyorsanız, sınav türünü ve tipini seçiniz.<br />";
	
	if($sinavSekli=="2"){//pratik
		
		$sql = "INSERT INTO M_SINAV_SONUCU
				VALUES(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, null, null, null, null, ?, ?)";
		
		foreach($ogrenciler AS $ogrenci){
		
			$sinavSonucu = $_POST["sinav_sonuc_" . $ogrenci['TC_KIMLIK']];
			
			$params = array(
					$evrakId,
					$ogrenci['TC_KIMLIK'],
					$sinavTuru,
					$sinavTarihi,
					$sinavYeri,
					$sinavSonucu,
					$sinavYapan
					);
					
			$db->prep_exec_insert($sql, $params);
		
		}
		
	}
	
	else if($sinavSekli=="1"){//teorik
				
		$sql = "INSERT INTO M_SINAV_SONUCU
				VALUES(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?, ?, ?, 0, ?)";
		
		foreach($ogrenciler AS $ogrenci){
		
			$dogruCevap = $_POST["dogru_cevap_" . $ogrenci['TC_KIMLIK']];
			$yanlisCevap = $_POST["yanlis_cevap_" . $ogrenci['TC_KIMLIK']];
			$bos = $_POST["bos_" . $ogrenci['TC_KIMLIK']];
			$puan = $_POST["puan_" . $ogrenci['TC_KIMLIK']];
			
			$params = array(
					$evrakId,
					$ogrenci['TC_KIMLIK'],
					$sinavTuru,
					$sinavTarihi,
					$sinavYeri,
					$dogruCevap,
					$yanlisCevap,
					$bos,
					$bos,
					$sinavYapan
					);
		
			$db->prep_exec_insert($sql, $params);
		}
		
	}
	
		$sql = "SELECT * FROM PM_SINAV_TURU";
		$sinavTurleri = $db->prep_exec($sql,array());
		
		$sql = "SELECT * FROM PM_SINAV_SEKLI";
		$sinavSekileri = $db->prep_exec($sql,array());
		
		
		?>
		

		
		<form action="?option=com_sinav_sonuc" method="post">
			<input type="hidden" name="evrakId" value="<?php echo $evrakId?>"></input>
			<input type="hidden" name="gorev" value="ogrListele"></input>
		<table>
			<tr>
				<td>Sınav Türü</td>
				<td style="width:10px;text-align:center">:</td>
				<td><select name="sinav_turu" style="width:105px">
				<option selected="selected" value="Seçiniz">Seçiniz</option>
				<?php 
				foreach($sinavTurleri AS $sinavTuru)
					echo '<option value="'.$sinavTuru['SINAV_TUR_ID'].'">'.$sinavTuru['SINAV_TUR_ADI'].'</option>';
				?>
			</select></td>
			</tr>
			<tr>
				<td>Sınav Şekli</td>
				<td style="width:10px;text-align:center">:</td>
				<td><select name="sinav_sekli" style="width:105px">
				<option selected="selected" value="Seçiniz">Seçiniz</option>
				<?php 
				foreach($sinavSekileri AS $sinavSekli)
					echo '<option value="'.$sinavSekli['SINAV_SEKLI_ID'].'">'.$sinavSekli['SINAV_SEKLI_ADI'].'</option>';
				?>
			</select></td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" value="Sınav Sonucu Gir"></input></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
	<form action="?option=com_sinav_sonuc" method="post">
		<input type="hidden" name="gorev" value="islemiBitir"></input>
		<input type="submit" value="İşlemi Bitir"></input>
	</form>
	<?php
	//die();
}

else if(isset($_POST['gorev']) && $_POST['gorev'] == "ogrListele"){
	
	$sinavSekli = $_POST['sinav_sekli'];
	$sinavTuru = $_POST['sinav_turu'];
	$evrakId = $_POST['evrakId'];

	
	?>
	<div class="sinavGirisBaslik">Sınav Sonucu Giriş Ekranı</div>
	<?php
	
	
	$sql = "SELECT * FROM M_OGRENCI
			WHERE EVRAK_ID = ?";
							
	$params = array($evrakId);
	$ogrenciler = $db->prep_exec($sql, $params);



$sinavDurumSql = "SELECT * FROM PM_SINAV_DURUM";

$sinavDurumlari = $db->loadList($sinavDurumSql);

$comboText = '';

foreach($sinavDurumlari AS $sinavDurumu){

	if($sinavDurumu['SINAV_DURUM_ID'] !=0)// tan�mlanmad� y� alma
		$comboText .= '<option value="' . $sinavDurumu['SINAV_DURUM_ID'] . '">'.$sinavDurumu['SINAV_DURUM_ADI'].'</option>';


}

	
	
	
	?>
	<h1>Sınav Türü: <?php echo $sinavTuru?></h1>
		<form action="?option=com_sinav_sonuc" method="post">
		<input type="hidden" value="<?php echo $sinavTuru?>" name="sinavTuru" />
		<input type="hidden" value="<?php echo $sinavSekli?>" name="sinavSekli" />
		<input type="hidden" value="<?php echo $evrakId?>" name="evrakId" />
		<input type="hidden" value="sonucKaydet" name="gorev" />
		
		<table>
			<tr>
				<td>Sınav Tarihi</td>
				<td><input type="text" name="sinavTarihi" /></td>
			</tr>
			<tr>
				<td>Sınav Yeri</td>
				<td><input type="text" name="sinavYeri" /></td>
			</tr>
			<tr>
				<td>Sınav Yapan</td>
				<td><input type="text" name="sinavYapan" /></td>
			</tr>
		</table>
		
		<table cellspacing="1">
			<tr class="tablo_header">
				<th>#</th>
				<th>Kayıt No</th>
				<th>TC Kimlik No</th>
				<th>Adı</th>
				<th>Soyadı</th><?php 
				if($sinavSekli == "2"){//pratik
				echo '<th>SONUÇ</th>';
				}
				else if($sinavSekli == "1"){//teorik
				echo '<th>Doğru Cevap Sayısı</th>
					<th>Yanlış Cevap Sayısı</th>
					<th>Boş Cevap Sayısı</th>
					<th>Aldığı Puan</th>';
				}
				?>
			</tr>
			
			<?php
				$rowCount=1;
				$rowClass="";
				foreach($ogrenciler AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nsbp;").'</td>';
					echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nsbp;").'</td>';
					echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nsbp;").'</td>';
					echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nsbp;").'</td>';

					if($sinavSekli == "2"){//pratik
						?>
						<td>
							<select name="sinav_sonuc_<?php echo $satir['TC_KIMLIK']?>">
								<option value="Seçiniz">Seçiniz</option>
								<?php echo $comboText?>
								<!--<option value="1">Başarılı</option>
								<option value="2">Başarısız</option>
								<option value="3">Katılmadı</option>-->
							</select>
						
						</td>
					
						<?php
					}
					else if($sinavSekli == "1"){//teorik
						?>
						<td>
							<input type="text" name="dogru_cevap_<?php echo $satir['TC_KIMLIK']?>"/>
						</td>
						<td>
							<input type="text" name="yanlis_cevap_<?php echo $satir['TC_KIMLIK']?>"/>
						</td>
						<td>
							<input type="text" name="bos_<?php echo $satir['TC_KIMLIK']?>"/>
						</td>
						<td>
							<input type="text" name="puan_<?php echo $satir['TC_KIMLIK']?>"/>
						</td>
						<?php
					}
					echo '</tr>';
					$rowCount++;
				}
			?>
		</table>
		<input type="submit" value="Sonuçları Kaydet" />
		</form>
		<?php
	
	
	
	//die();	
}

else if(isset($_POST['gorev']) && $_POST['gorev'] == "ilkSayfa"){
	//echo "helele";

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

	$evrakId = isset($_POST['evrakId']) ? $_POST['evrakId'] : null;
	$userId = isset($_POST['userId']) ? $_POST['userId'] : null;
	$yeterlilikId = isset($_POST['yeterlilikId']) ? $_POST['yeterlilikId'] : null;
	$sinavTarihi = isset($_POST['sinavTarihi']) ? $_POST['sinavTarihi'] : null;
	$toplamAday = isset($_POST['toplamAday']) ? $_POST['toplamAday'] : null;
	$basariliAday = isset($_POST['basariliAday']) ? $_POST['basariliAday'] : null;
	
	// kontrol et varmı diye varsa güncelle
	
	$sql = "SELECT EVRAK_ID
				FROM m_sinav
			WHERE EVRAK_ID = ?";
	
	$sonuclar = $db->prep_exec($sql, array($evrakId));
	
	if(empty($sonuclar)){
	
		$sql = "INSERT INTO m_sinav
				values(?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?)";
		
		$params = array($evrakId, $userId, $yeterlilikId, $sinavTarihi, $toplamAday, $basariliAday);
		
		$db->prep_exec_insert($sql, $params);
	}
	else{
		
		$sql = "UPDATE m_sinav SET
					YETERLILIK_ID = ?,
					SINAV_TARIHI = TO_DATE(?,'dd.mm.yyyy'),  
					TOPLAM_ADAY = ?,
					BASARILI_ADAY = ?
				WHERE EVRAK_ID = ?";
		
		$params = array($yeterlilikId, $sinavTarihi, $toplamAday, $basariliAday, $evrakId);
		
		$db->prep_exec_insert($sql, $params);
		
	}
	//die();
	
}

else if(isset($_POST['gorev']) && $_POST['gorev'] == "islemiBitir"){
	
	echo 'Eklediğiniz veriler kaydedildi.';

}

else if(isset($_POST['submitButton'])){
	
	if($_POST['submitButton'] == "Öğrencileri Kaydet"){
	
	?>
	<div class="sinavGirisBaslik">Sınav Sonucu Giriş Ekranı</div>
	<?php
		
		echo "Öğrenciler kaydedildi, belirtmiş olduğunuz öğrencilerin sınav sonuçlarını giriniz.<br />";
		
//		echo 'POST:<br><pre>';
//		print_r($_POST);
//		echo '</pre>';
		
		$bilgiValues = getTableValues($_POST, array("belgeDuzenlenecekBilgi", 9));
		
//		echo '$bilgiValues:<br><pre>';
//		print_r($bilgiValues);
//		echo '</pre>';
		
		$evrakId = $_POST['evrakId'];
		
		
		$yeterlilikId = $_POST['yetId'];

		
		//echo "yetKap: $yeterlilikKapsam";
		
//		echo 'yeterlilikKapsam:<br><pre>';
//		print_r($yeterlilikKapsam);
//		echo '</pre>';
//		
//		echo 'Düzenle bilgi:<br><pre>';
//		print_r($bilgiValues);
//		echo '</pre>';
		
		$sql = "INSERT INTO M_OGRENCI (TC_KIMLIK, OGRENCI_ADI, OGRENCI_SOYADI, OGRENCI_DOGUM_TARIHI, OGRENCI_DOGUM_YERI, OGRENCI_BABA_ADI, OGRENCI_KAYIT_NO)
			VALUES(?, ?, ?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?)";
		
		$valCount = count($bilgiValues);
		//echo "-$valCount-";
		for($i=0;$i<$valCount;$i += 9){
			
			$params = array_slice($bilgiValues, $i, 9);
			
			$yeterlilikKapsamlar = $params[8];
			unset($params[8]);
			// öğrenci-kapsam ekle
			$params[0] = $evrakId;
			$db->prep_exec_insert($sql, $params);
			
			$sqlAltBirim = "INSERT INTO M_OGRENCI_ALT_BIRIM (M_SINAV_ID, TC_KIMLIK, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ID)
					VALUES(?, ?, ?, ?)";
			
			if($yeterlilikKapsamlar != "")
				foreach($yeterlilikKapsamlar AS $yetAltBirimId){
					
					if($yetAltBirimId == "Başarısız")
						break;
					
					$params = array($evrakId, $params[1], $yetAltBirimId, $yeterlilikId);
					$db->prep_exec_insert($sqlAltBirim, $params);
					
				}			
			
		}
		
		
		$sql = "SELECT * FROM PM_SINAV_TURU";
		$sinavTurleri = $db->prep_exec($sql,array());
				$sql = "SELECT * FROM PM_SINAV_SEKLI";
		$sinavSekilleri = $db->prep_exec($sql,array());
		
		?>
		<form action="?option=com_sinav_sonuc" method="post">
			<input type="hidden" name="evrakId" value="<?php echo $evrakId?>"></input>
			<input type="hidden" name="gorev" value="ogrListele"></input>
			
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>Sınav Türü</td>
					<td style="width:10px;text-align:center">:</td>
					<td><select name="sinav_turu" style="width:85px">
				<option selected="selected" value="Seçiniz">Seçiniz</option>
				<?php 
				foreach($sinavTurleri AS $sinavTuru)
					echo '<option value="'.$sinavTuru['SINAV_TUR_ID'].'">'.$sinavTuru['SINAV_TUR_ADI'].'</option>';
				?>
			</select></td>
				</tr>
				<tr>
					<td>Sınav Şekli</td>
					<td style="width:10px;text-align:center">:</td>
					<td><select name="sinav_sekli" style="width:85px">
				<option selected="selected" value="Seçiniz">Seçiniz</option>
				<?php 
				foreach($sinavSekilleri AS $sinavSekli)
					echo '<option value="'.$sinavSekli['SINAV_SEKLI_ID'].'">'.$sinavSekli['SINAV_SEKLI_ADI'].'</option>';
				?>
			</select></td>
				</tr>
				<tr><td colspan="3"><input type="submit" value="Sinav Sonucu Gir" /></td></tr>
			</table>
				
		</form>
		
		<?php
		//die();
	}
	
}

function getTableValues ($_POST, $paramArray){	
	$result 	= array();
	$inputName 	= "input".$paramArray[0];
	$colCount 	= $paramArray[1];
	$rowCount 	= 0;
	
	//Tablo Degerlerini array yap
	for ($i=0; $i < $colCount; $i++){
		if($paramArray[0] == "belgeDuzenlenecekBilgi" && $i == 8)
			continue;
		$array[$i] = $_POST[$inputName.'-'.($i+1)];
	}
	
	if (isset($array[0])){
		$rowCount = count($array[0]);
	}
	
	$count = 0;
	for ($i=0; $i < $rowCount; $i++){
		for($j=0; $j< $colCount; $j++){
			if($j==8 && $paramArray[0] == "belgeDuzenlenecekBilgi"){
				//$result[$count] = implode(",",$_POST[$inputName.'-9-'.($i+1)]);
				$result[$count] = isset($_POST[$inputName.'-9-'.($i+1)]) ?
						$_POST[$inputName.'-9-'.($i+1)] : "";
			}else
				$result[$count] = trim ($array[$j][$i]);
			$count++;							
		}
	}

	return $result;
}


?>