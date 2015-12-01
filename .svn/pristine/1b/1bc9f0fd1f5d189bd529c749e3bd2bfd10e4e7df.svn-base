<?php
defined('_JEXEC') or die('Restricted access');

$kapsamlar = $this->kapsamlar;
$sinavlar = $this->sinavlar;
$yetkiNo = $this->yetkiNo;
$yeterlilik = $this->yeterlilik;

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

$session =&JFactory::getSession();
$tumSonuclar = $session->get('tumSonuclar');
$ogrenciler = $session->get('ogrenciler');

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
//
//echo 'k<pre>';
//print_r($kapsamlar);
//echo '</pre>k';
//
//echo 'öö<pre>';
//print_r($ogrenciler);
//echo '</pre>öö';

//echo '<pre>';
//print_r($tumSonuclar);
//echo '</pre>';

?>
<div class="sinavGirisBaslik">Genel Bilgiler</div>
<table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="120">Kuruluş Yetki No</td>
		<td><?php echo $yetkiNo?></td>
	</tr>
	<tr>
		<td width="120">Sertifika Yeterlilik Adı</td>
		<td><?php echo $yeterlilikAdi?></td>
	</tr>
</table>

<div class="sinavGirisBaslik">Sinavlar</div>

<?php

foreach($tumSonuclar AS $ogrler){
	
	$sinavId = $ogrler[0]['M_SINAV_ID'];
	
	$sinav = getSinavDetay($sinavlar, $sinavId);
	
//	echo '$sinav: <pre>';
//print_r($sinav);
//echo '</pre>';

?>
<div class="sinavOzetDiv">
<table class="sinavBilgiTable" cellspacing="1">
	<tr>
		<td width="120">Türü</td>
		<td><?php echo $sinav['SINAV_TUR_ADI']?></td>
	</tr>
	<tr>
		<td width="120">Tarihi</td>
		<td><?php echo $sinav['SINAV_TARIHI_FORMATTED']?></td>
	</tr>
	<tr>
		<td width="120">Yeri</td>
		<td><?php echo $sinav['MERKEZ_ADI']?></td>
	</tr>
	<tr>
		<td width="120">Aday Sayısı</td>
		<td><?php echo $sinav['TOPLAM_ADAY']?></td>
	</tr>
	<tr>
		<td width="120">Yapan</td>
		<td><?php echo $sinav['SINAVI_YAPAN']?></td>
	</tr>
</table>
<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>TC Kimlik No</th>
		<th>Öğrenci Adı</th>
		<th>Öğrenci Soyadı</th>
			<?php 
			if($sinav['SINAV_SEKLI_ID'] == TEORIK_SINAV_ID){
				?>
				<th>Doğru Sayısı</th>
				<th>Yanlış Sayısı</th>
				<th>Boş Sayısı</th>
				<?php 
			}
			?>
		<th>Aldığı Not</th>
		<th>Sonuç</th>
	</tr>
<?php
$rowNo=1;

foreach($ogrler AS $ogr){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$ogr['TC_KIMLIK'].'</td>';
	echo '<td>'.$ogr['OGRENCI_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_SOYADI'].'</td>';
	
	if($sinav['SINAV_SEKLI_ID'] == TEORIK_SINAV_ID){
		echo '<td>'.$ogr['DOGRU_SAYISI'].'</td>';
		echo '<td>'.$ogr['YANLIS_SAYISI'].'</td>';
		echo '<td>'.$ogr['BOS_SAYISI'].'</td>';
	}
	
	echo '<td>'.$ogr['ALDIGI_NOT'].'</td>';
	echo '<td>'.$ogr['SINAV_DURUM_ADI'].'</td>';
	
	echo '</tr>';
	$rowNo++;
}

?>
</table>
</div>
<?php

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
		<th>Kayıt No</th>
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
		action="?option=com_sinav&task=sertifikaKaydet2"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">
		
<input type="submit" value="Kaydet"></input>

</form>