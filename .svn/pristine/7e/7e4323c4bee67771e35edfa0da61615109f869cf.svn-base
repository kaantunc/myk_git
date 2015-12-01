<?php
defined('_JEXEC') or die('Restricted access');

$kurulus = $this->kurulus;
$merkezAdi = $this->merkezAdi;
$yetAdi = $this->yetAdi;
$sekilAdi = $this->sekilAdi;
$postData = $this->postData;


$sinavGozetmen = isset($postData['sinav_gozetmen']) ? $postData['sinav_gozetmen'] : "";
$sinavDegerlendirici = isset($postData['sinav_degerlendirici']) ? $postData['sinav_degerlendirici'] : "";
$sinav_tarihi = isset($postData['sinav_tarihi']) ? $postData['sinav_tarihi'] : "";
$sinav_saati = isset($postData['sinav_saati']) ? $postData['sinav_saati'] : "";
?>
<!--<div class="sinavGirisBaslik"><h3>Sinav Bilgileri</h3></div>
 <table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="540"><b>Sınav Yeri</b></td>
		<td><?php echo $merkezAdi;?></td>
	</tr>
	<tr>
		<td width="540"><b>Sınavın Yeterliliği</b></td>
		<td><?php echo $yetAdi["YETERLILIK_KODU"].' '.$yetAdi["YETERLILIK_ADI"];?></td>
	</tr>
	<tr>
		<td width="540"><b>Sınav Birimleri</b></td>
		<td><?php echo $sekilAdi;?></td>
	</tr>
	<tr>
		<td width="540"><b>Sınav Tarihi</b></td>
		<td><?php echo $sinav_tarihi;?></td>
	</tr>
	<tr>
		<td width="540"><b>Sınav Saati</b></td>
		<td><?php echo $sinav_saati;?></td>
	</tr>
</table> -->

<div class="sinavGirisBaslik"><h3><?php echo $kurulus;?> <?php echo $sinav_tarihi;?> Tarihli Sınava Başvuranların Listesi</h3></div>


<table border="1" cellspacing="1" cellpadding="6" width="100%" style="text-align:center;">
	<tr class="tablo_header">
		<th width="150px"><b>Sıra No</b></th>
		<th><b>TC Kimlik No</b></th>
		<th><b>Adı</b></th>
		<th><b>Soyadı</b></th>
		<th><b>Sınav Tarihi ve Saati</b></th>
		<th width="600px"><b>Yeterlilik</b></th>
		<!-- <th width="250"><b>Doğum Tarihi</b></th>
		<th width="250"><b>Doğum Yeri</b></th>
		<th width="250"><b>Baba Adı</b></th>
		<th width="250"><b>Kuruluş Kayıt No</b></th>
		<th width="250"><b>Sınav Birimleri</b></th> -->
	</tr>
<?php 

$id = 'inputbelgeDuzenlenecekBilgi';

//$colNums = 9;
$colNums = 4;
for($rowNo=0;$rowNo < count($postData[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	for($colNo=1;$colNo <= $colNums;$colNo++)
	if($colNo == 1)
		echo '<td width="150px">'.$postData[$id.'-'.$colNo][$rowNo].'</td>';
	else if($colNo == 2)
		echo '<td>'.$postData[$id.'-'.$colNo][$rowNo].'</td>';
	else
	echo '<td>'.$postData[$id.'-'.$colNo][$rowNo].'</td>';
	echo '<td>'.$sinav_tarihi.'   '.$sinav_saati.'</td><td width="600px">'.$yetAdi["YETERLILIK_KODU"].'<br/>'.$yetAdi["YETERLILIK_ADI"].'</td></tr>';
}


?>
</table>