<?php
defined('_JEXEC') or die('Restricted access');

$kapsamlar = $this->kapsamlar;
$sinavlar = $this->sinavlar;
$yetkiNo = $this->yetkiNo;
$yeterlilik = $this->yeterlilik;
$tumSonuclar = $this->tumSonuclar;
$ogrenciler = $this->ogrenciler;



$yeterlilikAdi = $yeterlilik['YETERLILIK_ADI'];

function getOgrKapsamlar($kapsamlar, $ogrSiraNo){
	$colId = 'inputbelgeDuzenlenecekBilgi-9';
	
	$ogrKapsamlar = array();
	
	foreach($kapsamlar AS $kapsam)
		if(in_array($kapsam['YETERLILIK_ALT_BIRIM_ID'], $_POST[$colId . '-'. $ogrSiraNo]))
			$ogrKapsamlar[] = $kapsam['YETERLILIK_ALT_BIRIM_ADI'];
		
	$kapsamlarStr = implode(', ',$ogrKapsamlar);
	
	if($kapsamlarStr == "")
		return '-';
	else
		return $kapsamlarStr;
			
}

function getSinavDetay($sinavlar, $sinavId){
	foreach($sinavlar AS $sinav)
		if($sinav['M_SINAV_ID'] == $sinavId)
			return $sinav;
}


?>

<div class="sinavGirisBaslik">Öğrenciler</div>


<table cellspacing="1">
	<tr class="tablo_header">
		<th>Sıra No</th>
		<th>TC Kimlik No</th>
		<th>Öğrenci Adı</th>
		<th>Öğrenci Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Kuruluş Kayıt No</th>
		<th>Yeterlilik Kapsamı</th>
	</tr>
<?php 


$rowNo=1;
foreach($ogrenciler AS $ogr){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$ogr['TC_KIMLIK'].'</td>';
	echo '<td>'.$ogr['OGRENCI_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_SOYADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_DOGUM_TARIHI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_DOGUM_YERI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_BABA_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_KAYIT_NO'].'</td>';
	echo '<td>'.getOgrKapsamlar($kapsamlar, $rowNo).'</td>';
	$rowNo++;
}



?>
</table>

<form id="sinavTakvimiGeriForm" action="?option=com_sinav&view=sertifika" method="post">
	<input name="mode" value="duzenle" type="hidden"></input>
	<input type="submit" value="Geri" />
</form>

<form method="POST"
		action="?option=com_sinav&task=sertifikaKaydet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">
		
<input type="submit" value="Kaydet"></input>

</form>