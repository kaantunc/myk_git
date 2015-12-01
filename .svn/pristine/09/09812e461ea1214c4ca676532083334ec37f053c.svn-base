<?php
defined('_JEXEC') or die('Restricted access');

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$sinavi_yapan = isset($_POST['sinavi_yapan']) ? $_POST['sinavi_yapan'] : "";
$sinav_tarihi = isset($_POST['sinav_tarihi']) ? $_POST['sinav_tarihi'] : "";

$merkezAdi = $this->merkezAdi;
$yetAdi = $this->yetAdi;
$turAdi = $this->turAdi;
$sekilAdi = $this->sekilAdi;

?>
<div class="sinavGirisBaslik">Sinav Bilgileri</div>
<table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="140">Sınav Yeri</td>
		<td><?php echo $merkezAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınavın Yeterliliği</td>
		<td><?php echo $yetAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınav Türü</td>
		<td><?php echo $turAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınav Şekli</td>
		<td><?php echo $sekilAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınav Tarihi</td>
		<td><?php echo $sinav_tarihi?></td>
	</tr>
	<tr>
		<td width="140">Sınavı Yapan Kişi(ler)</td>
		<td><?php echo $sinavi_yapan?></td>
	</tr>
</table>

<div class="sinavGirisBaslik">Sınava Katılacak Öğrenciler</div>


<table cellspacing="1">
	<tr class="tablo_header">
		<th>Sıra No</th>
		<th>TC Kimlik No</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Kayıt No</th>
	</tr>
<?php 

$id = 'inputbelgeDuzenlenecekBilgi';

$colNums = 8;
for($rowNo=0;$rowNo < count($_POST[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	for($colNo=1;$colNo <= $colNums;$colNo++)
		echo '<td>'.$_POST[$id.'-'.$colNo][$rowNo].'</td>';
	
	echo '</tr>';
}


?>
</table>

<!-- Burada değerleri sinav_oncesine post et, sonra orda göster gelenleri -->
<form id="sinavTakvimiGeriForm" action="?option=com_sinav&view=sinav_oncesi" method="post">
	<input name="mode" value="duzenle" type="hidden"></input>
	<input type="submit" value="Geri" />
</form>

<form method="POST"
		action="?option=com_sinav&task=sinavOncesiKaydet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">
		
<input type="submit" value="Kaydet"></input>

</form>

<input type="button" value="PDF Çıktısını Al"></input>