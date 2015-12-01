<?php
defined('_JEXEC') or die('Restricted access');
$sinavsonuc = $this->ogrenciler['ogr'];
$tc = $this->ogrenciler['tc'];

function OgrBilgi($sinavsonuc, $ogr, $rowCount, $rowClass){
	$ekle = '';
	$sonuc = $sinavsonuc[$ogr];
	$say = count($sonuc);
	/*foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr){
			$say++;
		}
	}*/
	//foreach($sinavsonuc[$ogr] as $sonuc){
		//if($sonuc['TC_KIMLIK'] == $ogr){
			$ekle .='<tbody><tr class="'.$rowClass.'" style="text-align:center;">
			<td rowspan = "'.$say.'">'.$rowCount.'</td>
			<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_KAYIT_NO'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['TC_KIMLIK'].'<input type = "hidden" name="tc[]" value = "'.$sonuc[0]["TC_KIMLIK"].'"/></td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_SOYADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_DOGUM_TARIHI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_DOGUM_YERI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['OGRENCI_BABA_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc[0]['YETERLILIK_ADI'].'</td>';
			
		
	//}
	return $ekle;
}

function Birimler($sinavsonuc, $ogr, $rowClass){
	$ekle = '';
	foreach($sinavsonuc[$ogr] as $sonuc){
		//if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			if($sonuc['YENI_MI'] == 0){
				if($sonuc['SEKIL'] == 0){
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik)
					<input type = "hidden" name = "birim['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YETERLILIK_ALT_BIRIM_ID"].'"/>
					<input type = "hidden" name = "sekil['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["SEKIL"].'"/>
					<input type = "hidden" name = "sinav['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["M_SINAV_ID"].'"/>
					<input type = "hidden" name = "yeterlilik['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YETERLILIK_ID"].'"/>
					<input type = "hidden" name = "yenimi['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YENI_MI"].'"/>
					</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr><tr class="'.$rowClass.'" style="text-align:center;">';
				}
				else{
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik)
					<input type = "hidden" name = "birim['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YETERLILIK_ALT_BIRIM_ID"].'"/>
					<input type = "hidden" name = "sekil['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["SEKIL"].'"/>
					<input type = "hidden" name = "sinav['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["M_SINAV_ID"].'"/>
					<input type = "hidden" name = "yeterlilik['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YETERLILIK_ID"].'"/>
					<input type = "hidden" name = "yenimi['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YENI_MI"].'"/>
					</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr>
					<tr class="'.$rowClass.'" style="text-align:center;">';
				}
			}
			else{
				$ekle .= '<td>'.$sonuc['BIRIM_ADI'].'('.$sonuc['BIRIM_KODU'].'/	'.$sonuc['OLC_DEG_HARF'].$sonuc['OLC_DEG_NUMARA'].')
				<input type = "hidden" name = "birim['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["BIRIM_ID"].'"/>
				<input type = "hidden" name = "sekil['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["SEKIL"].'"/>
				<input type = "hidden" name = "sinav['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["M_SINAV_ID"].'"/>
				<input type = "hidden" name = "yeterlilik['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YETERLILIK_ID"].'"/>
				<input type = "hidden" name = "yenimi['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["YENI_MI"].'"/>
				<input type = "hidden" name = "sinavbirim_id['.$sonuc["TC_KIMLIK"].'][]" value = "'.$sonuc["ID"].'"/>
				</td>
				<td>'.$sonuc['ALDIGI_NOT'].'</td>
				<td>'.$sonuc['SINAV_TARIHI'].'</td>
				<td>'.$sonuc['SINAV_SAAT'].'</td>
				<td>'.$sonuc['MERKEZ_ADI'].'</td>
				<td>'.$sonuc['GOZETMEN'].'</td>
				<td>'.$sonuc['DEGERLENDIRICI'].'</td>	
				</tr><tr class="'.$rowClass.'" style="text-align:center;">';
			}
		
	}
	return $ekle.'</tr>';
}

function SinavNotlari($sinavsonuc, $ogr){
	$ekle = '';
foreach($sinavsonuc as $sonuc){
	if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
				$ekle .= '<td>'.$sonuc['ALDIGI_NOT'].'</td>';
	}
}
return $ekle;
}
?>
<form method="POST"
		action="?option=com_sinav&task=sertifikaIstegiKaydet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">

<!--  <input type="hidden" name="sinavIds" value="<?php echo $this->sinavIds?>"></input> -->
<div class="sinavGirisBaslik">Adaylar</div>
<div style="overflow-x:auto;">
<table style="overflow-x:auto; width:auto" heigth: cellspacing="0" class="paginate-10 sortable" border=2>
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th>Kuruluş Kayıt No</th>
		<th>TC Kimlik</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Yeterlilik Adı</th>
		<th>Yeterlilik Birimleri</th>
		<th>Aldığı Not</th>
		<th>Sınav Tarihi</th>
		<th>Sınav Saati</th>
		<th>Sınav Yeri</th>
		<th>Gözetmen</th>
		<th>Değerlendirici</th>
		<!-- <th>
			<table border=1>
				<thead>
				<tr class="tablo_header">
				
				</tr>
				</thead>
			</table>
		</th> -->
		
	</tr>
	</thead>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($tc AS $ogr){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
			echo OgrBilgi($sinavsonuc, $ogr, $rowCount, $rowClass);
			echo Birimler($sinavsonuc, $ogr, $rowClass);
			echo '</tbody>';
			$rowCount++;
		}
	?>
	
</table>
</div>
<input type = "hidden" name = "user_id" value = "<?php echo $this->user_id; ?>"/>
<br />
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div class="form_item">
  <div class="form_element cf_button">
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
    <input value = "Kaydet" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
