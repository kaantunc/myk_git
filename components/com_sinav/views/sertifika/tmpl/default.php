<?php
defined('_JEXEC') or die('Restricted access');
$sinavsonuc = $this->ogrenciler[0];
$ogrler = $this->ogrenciler[1];
$zorbirims = $this->ogrenciler[2];

function birimTamammı($sinavsonuc, $ogr, $zorbirims){
	$zorbirimsay = count($zorbirims);
	$gelenbirims = array();
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			foreach ($zorbirims as $rows){
				if($rows['BIRIM_ID'] == $sonuc['BIRIM_ID'] && !in_array($rows['BIRIM_ID'], $gelenbirims)){
						$gelenbirims[] = $rows['BIRIM_ID'];
				}
			}
		}
	}
	if($zorbirimsay == count($gelenbirims)){
		return true;
	}
}

function Eksikbirim($sinavsonuc, $ogr, $zorbirims){
	$zorbirimsay = count($zorbirims);
	$gelenbirims = array();
	$gelenAd = array();
	$eksikbirim = array();
	$eksikAdlar = array();
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			foreach ($zorbirims as $rows){
				if($rows['BIRIM_ID'] == $sonuc['BIRIM_ID'] && !in_array($rows['BIRIM_ID'], $gelenbirims)){
					$gelenbirims[] = $rows['BIRIM_ID'];
					$gelenAd[] = $rows['BIRIM_ADI'];
				}
				else if($rows['BIRIM_ID'] != $sonuc['BIRIM_ID'] && !in_array($rows['BIRIM_ID'], $eksikbirim)){
						$eksikbirim[] = $rows['BIRIM_ID'];
						$eksikAdlar[] = $rows['BIRIM_ADI'];
				}
			}
		}
	}
	for($ii = 0; $ii<count($gelenbirims); $ii++){
		if(in_array($gelenbirims[$ii], $eksikbirim)){
			if(($key = array_search($gelenbirims[$ii], $eksikbirim)) !== false) {
				unset($eksikbirim[$key]);
				unset($eksikAdlar[$key]);
			}
		}
	}
	/*$giden[] = $gelenAd;
	$giden[] = $eksikAdlar;*/

	if($zorbirimsay != count($gelenbirims)){
		return $eksikAdlar;
	}
}

function OgrBilgi($sinavsonuc, $ogr, $rowCount, $rowClass){
	$ekle = '';
	$say = '';
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			$say++;
		}
	}
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			$ekle .='<tbody><tr class="'.$rowClass.'" style="text-align:center;">
			<td rowspan = "'.$say.'"><input value="'.$ogr['TC_KIMLIK'].'_'.$sonuc['YETERLILIK_ID'].'" type="checkbox" name="tc_kimlik[]" id = "'.$ogr['TC_KIMLIK'].'_'.$sonuc['YETERLILIK_ID'].'" /></td>
			<td rowspan = "'.$say.'">'.$rowCount.'</td>
			<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_KAYIT_NO'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['TC_KIMLIK'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_SOYADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_TARIHI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_YERI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_BABA_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['YETERLILIK_ADI'].'</td>';
			return $ekle;
		}
	}
}

function Birimler($sinavsonuc, $ogr, $rowClass){
	$ekle = '';
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			if($sonuc['YENI_MI'] == 0){
				if($sonuc['SEKIL'] == 0){
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik)</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr><tr class="'.$rowClass.'" style="text-align:center;">';
				}
				else{
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik)</td>
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
				$ekle .= '<td>'.$sonuc['BIRIM_ADI'].'('.$sonuc['BIRIM_KODU'].'/	'.$sonuc['OLC_DEG_HARF'].$sonuc['OLC_DEG_NUMARA'].')</td>
				<td>'.$sonuc['ALDIGI_NOT'].'</td>
				<td>'.$sonuc['SINAV_TARIHI'].'</td>
				<td>'.$sonuc['SINAV_SAAT'].'</td>
				<td>'.$sonuc['MERKEZ_ADI'].'</td>
				<td>'.$sonuc['GOZETMEN'].'</td>
				<td>'.$sonuc['DEGERLENDIRICI'].'</td>	
				</tr><tr class="'.$rowClass.'" style="text-align:center;">';
			}
		}
	}
	return $ekle.'</tr>';
}

function EksikOgr($eksik, $sinavsonuc, $ogr, $rowCount, $rowClass){
	$ekle = '';
	/*if(count($eksik[0]) > count($eksik[1])){
		$say = count($eksik[0]);
	}
	else{
		$say = count($eksik[1]);
	}*/
	$say = count($eksik);
	
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			$ekle .='<tbody><tr class="'.$rowClass.'" style="text-align:center;">
				<td rowspan = "'.$say.'"><input value="'.$ogr['TC_KIMLIK'].'_'.$sonuc['YETERLILIK_ID'].'" type="checkbox" name="tc_kimlik[]" id = "'.$ogr['TC_KIMLIK'].'_'.$sonuc['YETERLILIK_ID'].'"  DISABLED/></td>
				<td rowspan = "'.$say.'">'.$rowCount.'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_KAYIT_NO'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['TC_KIMLIK'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_ADI'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_SOYADI'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_TARIHI'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_YERI'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_BABA_ADI'].'</td>
					<td rowspan = "'.$say.'">'.$sonuc['YETERLILIK_ADI'].'</td>';
			return $ekle;
		}
	}
}

function EksikBirimler($eksik, $ogr, $rowClass){
	$ekle = '';
	foreach($eksik as $sonuc){
		/*for($kk = 0; $kk < count($sonuc); $kk++ ){
					$ekle .= '<td>'.$sonuc[$kk].'</td>';
		}
		$ekle .= '</tr><tr class="'.$rowClass.'" style="text-align:center;">';*/
		$ekle .= '<td>'.$sonuc.'</td></tr><tr class="'.$rowClass.'" style="text-align:center;">';
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
		action="?option=com_sinav&view=sertifika_ozet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">

<!--  <input type="hidden" name="sinavIds" value="<?php echo $this->sinavIds?>"></input> -->
<div class="sinavGirisBaslik">Adaylar</div>
<div style="overflow-x:auto;">
<table style="overflow-x:auto; width:auto" cellspacing="0" class="paginate-10 sortable" border=2>
	<thead>
	<tr class="tablo_header">
		<th>Seç</th>
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
		foreach($ogrler AS $ogr){
			if(birimTamammı($sinavsonuc, $ogr, $zorbirims)){
				if($rowCount%2==0)
					$rowClass = "even_row";
				else
					$rowClass = "odd_row";
				echo OgrBilgi($sinavsonuc, $ogr, $rowCount, $rowClass);
				echo Birimler($sinavsonuc, $ogr, $rowClass);
				echo '</tr></tbody>';
				$rowCount++;
			}
			/*else{
				echo "Sertifika Başvurusu Yapılacak Adaylardan Hiç Biri Zorunlu Yeterlilikleri Sağlayamamıştır.<br/>";
			}*/
		}
	?>
	
</table>
</div>
<br/>
<hr/>
<br/>
<div class="sinavGirisBaslik">Yeterliliği Eksik Olan Adaylar</div>
<div style="overflow-x:auto;">
<table style="overflow-x:auto; width:auto" cellspacing="0" class="paginate-10 sortable" border=2>
	<thead>
	<tr class="tablo_header">
		<th>Seç</th>
		<th>#</th>
		<th>Kuruluş Kayıt No</th>
		<th>TC Kimlik</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Yeterlilik Adı</th>
		<!-- <th>Başarılı Olduğu Yeterlilik Birimleri</th> -->
		<th>Eksik Yeterlilik Birimleri</th>
		<!-- <th>Aldığı Not</th>
		<th>Sınav Tarihi</th>
		<th>Sınav Saati</th>
		<th>Sınav Yeri</th>
		<th>Gözetmen</th>
		<th>Değerlendirici</th> -->
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
		foreach($ogrler AS $ogr){
			if(!birimTamammı($sinavsonuc, $ogr, $zorbirims)){
				$eksikler = Eksikbirim($sinavsonuc, $ogr, $zorbirims);
				if($rowCount%2==0)
					$rowClass = "even_row";
				else
					$rowClass = "odd_row";
				echo EksikOgr($eksikler, $sinavsonuc, $ogr, $rowCount, $rowClass);
				echo EksikBirimler($eksikler, $ogr, $rowClass);
				echo '</tr></tbody>';
				$rowCount++;
			}
			/*else{
				echo "Sertifika Başvurusu Yapılacak Adaylardan Hiç Biri Zorunlu Yeterlilikleri Sağlayamamıştır.<br/>";
			}*/
		}
	?>
	
</table>
</div>
<br />
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div class="form_item">
  <div class="form_element cf_button">
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
    <input value = "İleri" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
