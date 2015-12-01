<?php
defined('_JEXEC') or die('Restricted access');

$kapsamlar = $this->kapsamlar;
$sinavlar = $this->sinavlar;
$yetkiNo = $this->yetkiNo;
$yeterlilik = $this->yeterlilik;
$postData = $this->postData;
$tumSonuclar = $this->tumSonuclar;
$ogrenciler = $this->ogrenciler;

$yeterlilikAdi = $yeterlilik['YETERLILIK_ADI'];

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

function getSinavDetay($sinavlar, $sinavId){
	foreach($sinavlar AS $sinav)
		if($sinav['M_SINAV_ID'] == $sinavId)
			return $sinav;
}

//$session =&JFactory::getSession();
//$tumSonuclar = $session->get('tumSonuclar');
//$ogrenciler = $session->get('ogrenciler');
//
//echo '$postData:<pre>';
//print_r($postData);
//echo '</pre>';

//echo 'k<pre>';
//print_r($kapsamlar);
//echo '</pre>k';
//
//echo 'öö<pre>';
//print_r($ogrenciler);
//echo '</pre>öö';
//
//echo '<pre>';
//print_r($tumSonuclar);
//echo '</pre>';



?>
<div class="sinavGirisBaslik"><h3>Genel Bilgiler</h3></div>
<table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="420"><b>Kuruluş Yetki No</b></td>
		<td><?php echo $yetkiNo?></td>
	</tr>
	<tr>
		<td width="420"><b>Sertifika Yeterlilik Adı</b></td>
		<td><?php echo $yeterlilikAdi?></td>
	</tr>
</table>
<br />
<hr />
<div class="sinavGirisBaslik"><h3>Sinavlar</h3></div>

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
		<td width="360"><b>Türü</b></td>
		<td><?php echo $sinav['SINAV_TUR_ADI']?></td>
	</tr>
	<tr>
		<td width="360"><b>Tarihi</b></td>
		<td><?php echo $sinav['SINAV_TARIHI_FORMATTED']?></td>
	</tr>
	<tr>
		<td width="360"><b>Yeri</b></td>
		<td><?php echo $sinav['MERKEZ_ADI']?></td>
	</tr>
	<tr>
		<td width="360"><b>Aday Sayısı</b></td>
		<td><?php echo $sinav['TOPLAM_ADAY']?></td>
	</tr>
	<tr>
		<td width="360"><b>Gözetmen(ler)</b></td>
		<td><?php echo $sinav['GOZETMEN']?></td>
	</tr>
	<tr>
		<td width="360"><b>Değerlendirici(ler)</b></td>
		<td><?php echo $sinav['DEGERLENDIRICI']?></td>
	</tr>
</table>
<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th><b>TC Kimlik No</b></th>
		<th><b>Öğrenci Adı</b></th>
		<th><b>Öğrenci Soyadı</b></th>
			<?php 
			if($sinav['SINAV_SEKLI_ID'] == TEORIK_SINAV_ID){
				?>
				<th><b>Doğru Sayısı</b></th>
				<th><b>Yanlış Sayısı</b></th>
				<th><b>Boş Sayısı</b></th>
				<?php 
			}
			?>
		<th><b>Aldığı Not</b></th>
		<th><b>Sonuç</b></th>
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
<hr />
</div>
<?php

}

?>

<br />
<div class="sinavGirisBaslik"><h3>Öğrenciler</h3></div>
<hr />

<table cellspacing="1" border="1">
	<tr class="tablo_header">
		<th width="50"><b>#</b></th>
		<th><b>TC Kimlik No</b></th>
		<th><b>Öğrenci Adı</b></th>
		<th><b>Öğrenci Soyadı</b></th>
		<th><b>Doğum Tarihi</b></th>
		<th><b>Doğum Yeri</b></th>
		<th><b>Baba Adı</b></th>
		<th><b>Kuruluş Kayıt No</b></th>
		<th width="400"><b>Yeterlilik Kapsamı</b></th>
	</tr>
<?php 


$rowNo=1;
foreach($ogrenciler AS $ogr){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	echo '<td width="50">'.$rowNo.'</td>';
	echo '<td>'.$ogr['TC_KIMLIK'].'</td>';
	echo '<td>'.$ogr['OGRENCI_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_SOYADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_DOGUM_TARIHI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_DOGUM_YERI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_BABA_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_KAYIT_NO'].'</td>';
	echo '<td width="400">'.getOgrKapsamlar($kapsamlar, $rowNo, $postData).'</td>';
	echo '</tr>';
	//echo '<tr><td colspan="9"><hr /></td></tr>';
	$rowNo++;
}



?>
</table>