<?php
defined('_JEXEC') or die('Restricted access');


//$kapsamlar = $this->kapsamlar;
//$sinavlar = $this->sinavlar;
$yetkiNo = $this->yetkiNo;
/*
$postData = $this->postData;
$tumSonuclar = $this->tumSonuclar;*/
$sinavsonuc = $this->ogrenciler['ogr'];
$tc = $this->ogrenciler['tc'];
$yeterlilik = $sinavsonuc[$tc[0]][0]["YETERLILIK_ADI"];

$yeterlilikAdi = $yeterlilik['YETERLILIK_ADI'];


function OgrBilgi($sinavsonuc, $ogr, $rowCount){
	$ekle = '';
	$sonuc = $sinavsonuc[$ogr];
	$say = count($sonuc);
	
	$ekle .='<tr style="text-align:center; font-size:small; width:100%;">
				<td rowspan="'.$say.'">'.$rowCount.'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_KAYIT_NO'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['TC_KIMLIK'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_ADI'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_SOYADI'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_DOGUM_TARIHI'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_DOGUM_YERI'].'</td>
				<td rowspan="'.$say.'">'.$sonuc[0]['OGRENCI_BABA_ADI'].'</td>';
				//<td rowspan="'.$say.'">'.$sonuc[0]['YETERLILIK_ADI'].'</td>';
		
	return $ekle;
}

function Birimler($sinavsonuc, $ogr){
	$ekle = '';
	$say = 0;
	foreach($sinavsonuc[$ogr] as $sonuc)
	{
		if($sonuc['YENI_MI'] == 0)
		{
			if($sonuc['SEKIL'] == 0)
			{
				if($say == 0){
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik</td>
										<td>'.$sonuc['ALDIGI_NOT'].'</td>
										<td>'.$sonuc['SINAV_TARIHI'].'</td>
										<td>'.$sonuc['SINAV_SAAT'].'</td>
										<td>'.$sonuc['MERKEZ_ADI'].'</td>
										<td>'.$sonuc['GOZETMEN'].'</td>
										<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr>';
				}
				else{
					$ekle .= '<tr style="text-align:center; font-size:small;  width:100%;"><td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik</td>
															<td>'.$sonuc['ALDIGI_NOT'].'</td>
															<td>'.$sonuc['SINAV_TARIHI'].'</td>
															<td>'.$sonuc['SINAV_SAAT'].'</td>
															<td>'.$sonuc['MERKEZ_ADI'].'</td>
															<td>'.$sonuc['GOZETMEN'].'</td>
															<td>'.$sonuc['DEGERLENDIRICI'].'</td>
										</tr>';
				}
				/*$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr><tr style="text-align:center; font-size:small;  width:100%;">';//<td>'.$sonuc['DEGERLENDIRICI'].'</td>*/
			}
			else{
				if($say == 0){
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik</td>
										<td>'.$sonuc['ALDIGI_NOT'].'</td>
										<td>'.$sonuc['SINAV_TARIHI'].'</td>
										<td>'.$sonuc['SINAV_SAAT'].'</td>
										<td>'.$sonuc['MERKEZ_ADI'].'</td>
										<td>'.$sonuc['GOZETMEN'].'</td>
										<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr>';
				}
				else{
					$ekle .= '<tr style="text-align:center; font-size:small;  width:100%;"><td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik</td>
															<td>'.$sonuc['ALDIGI_NOT'].'</td>
															<td>'.$sonuc['SINAV_TARIHI'].'</td>
															<td>'.$sonuc['SINAV_SAAT'].'</td>
															<td>'.$sonuc['MERKEZ_ADI'].'</td>
															<td>'.$sonuc['GOZETMEN'].'</td>
															<td>'.$sonuc['DEGERLENDIRICI'].'</td>
										</tr>';
				}
				/*$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr>
					<tr style="text-align:center; font-size:small;  width:100%;">';*/
			}
		}
		else
		{
			if($say == 0){
				$ekle .= '<td>'.$sonuc['BIRIM_KODU'].'/'.$sonuc['OLC_DEG_HARF'].$sonuc['OLC_DEG_NUMARA'].'</td>
								<td>'.$sonuc['ALDIGI_NOT'].'</td>
								<td>'.$sonuc['SINAV_TARIHI'].'</td>
								<td>'.$sonuc['SINAV_SAAT'].'</td>
								<td>'.$sonuc['MERKEZ_ADI'].'</td>
								<td>'.$sonuc['GOZETMEN'].'</td>
								<td>'.$sonuc['DEGERLENDIRICI'].'</td>
				</tr>';
			}
			else{
				$ekle .= '<tr style="text-align:center; font-size:small;  width:100%;"><td>'.$sonuc['BIRIM_KODU'].'/'.$sonuc['OLC_DEG_HARF'].$sonuc['OLC_DEG_NUMARA'].'</td>
												<td>'.$sonuc['ALDIGI_NOT'].'</td>
												<td>'.$sonuc['SINAV_TARIHI'].'</td>
												<td>'.$sonuc['SINAV_SAAT'].'</td>
												<td>'.$sonuc['MERKEZ_ADI'].'</td>
												<td>'.$sonuc['GOZETMEN'].'</td>
												<td>'.$sonuc['DEGERLENDIRICI'].'</td>
								</tr>';
			}
			/*$ekle .= '<td>'.$sonuc['BIRIM_KODU'].'/'.$sonuc['OLC_DEG_HARF'].$sonuc['OLC_DEG_NUMARA'].'</td>
				<td>'.$sonuc['ALDIGI_NOT'].'</td>
				<td>'.$sonuc['SINAV_TARIHI'].'</td>
				<td>'.$sonuc['SINAV_SAAT'].'</td>
				<td>'.$sonuc['MERKEZ_ADI'].'</td>
				<td>'.$sonuc['GOZETMEN'].'</td>
				<td>'.$sonuc['DEGERLENDIRICI'].'</td>
				</tr><tr style="text-align:center; font-size:small;  width:100%;">';*/
			/*<td>'.$sonuc['GOZETMEN'].'</td>
				<td>'.$sonuc['DEGERLENDIRICI'].'</td>*/
		}

		//echo '';
		$say++;
	}
	return $ekle;
}

function getOgrKapsamlar($kapsamlar, $ogrSiraNo, $postData){
	$colId = 'inputbelgeDuzenlenecekBilgi-9';
	
	$ogrKapsamlar = array();
	
	foreach($kapsamlar AS $kapsam)
		if(in_array($kapsam['YETERLILIK_ALT_BIRIM_ID'], $postData[$colId . '-'. $ogrSiraNo]))
			$ogrKapsamlar[] = $kapsam['YETERLILIK_ALT_BIRIM_ADI'];
		
	$kapsamlarStr = implode(', ',$ogrKapsamlar);
	
	if($kapsamlarStr == "")
		return '-';
	else
		return $kapsamlarStr;
			
}

?>
<div class="sinavGirisBaslik"><h3>Genel Bilgiler</h3></div>
<table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="420"><b>Kuruluş Yetki No: </b></td>
		<td><?php echo $yetkiNo;?></td>
	</tr>
	<tr>
		<td width="420"><b>Sertifika Yeterlilik Adı: </b></td>
		<td><?php echo $yeterlilik;?></td>
	</tr>
</table>

<hr />

<div class="sinavGirisBaslik"><h3>Belge Almaya Hak Kazanan Adaylar</h3></div>
</hr>
<table cellspacing="1" border="1">
	<thead class="tablo_header">
	<tr style="text-align:center; font-weight: bold; font-size:small;">
		<th>#</th>
		<th>Kuruluş Kayıt No</th>
		<th>TC Kimlik</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<!-- <th>Yeterlilik Adı</th> -->
		<th>Yeterlilik Birimleri</th>
		<th>Aldığı Not</th>
		<th>Sınav Tarihi</th>
		<th>Sınav Saati</th>
		<th>Sınav Yeri</th>
		<th>Gözetmen</th>
		<th>Değerlendirici</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($tc AS $ogr){
			/*if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";*/
			echo OgrBilgi($sinavsonuc, $ogr, $rowCount);
			echo Birimler($sinavsonuc, $ogr);
			echo '';
			$rowCount++;
		}
	?>
	</tbody>
</table>
