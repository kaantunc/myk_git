<?php
defined('_JEXEC') or die('Restricted access');

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$sinav_gozetmen = isset($_POST['sinav_gozetmen']) ? $_POST['sinav_gozetmen'] : "";
$sinav_degerlendirici = isset($_POST['sinav_degerlendirici']) ? $_POST['sinav_degerlendirici'] : "";
$sinav_tarihi = isset($_POST['sinav_tarihi']) ? $_POST['sinav_tarihi'] : "";
$sinav_saati = isset($_POST['sinav_saati']) ? $_POST['sinav_saati'] : "";

$merkezAdi = $this->merkezAdi;
$yetAdi = $this->yetAdi;
$turAdi = $this->turAdi;
$sekilAdi = $this->sekilAdi;

?>
<div class="sinavGirisBaslik">Sınav Bilgileri</div>
<table class="sertifikaGenelBilgiTable" cellspacing="1">
	<tr>
		<td width="140">Sınav Yeri</td>
		<td><?php echo $merkezAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınavın Yeterliliği</td>
		<td><?php echo $yetAdi['YETERLILIK_ADI']?></td>
	</tr>
	<tr>
		<td width="140">Sınav Birimi</td>
		<td><?php echo $sekilAdi?></td>
	</tr>
	<tr>
		<td width="140">Sınav Tarihi</td>
		<td><?php echo $sinav_tarihi?></td>
	</tr>
	<tr>
		<td width="140">Sınav Saati</td>
		<td><?php echo $sinav_saati?></td>
	</tr>
	<!-- <tr>
		<td width="140">Sınav Gözetmen(ler)i</td>
		<td><?php //echo $sinav_gozetmen?></td>
	</tr>
	<tr>
		<td width="140">Sınav Değerlendirici(ler)i</td>
		<td><?php //echo $sinav_degerlendirici?></td>
	</tr> -->
</table>

<div class="sinavGirisBaslik">Sınava Katılacak Adaylar</div>


<table cellspacing="1">
	<tr class="tablo_header">
		<th>Sıra No</th>
		<th>TC Kimlik No</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Kuruluş Kayıt No</th>
		<th>Birim No</th>
	</tr>
<?php 

$id = 'inputbelgeDuzenlenecekBilgi';

$colNums = 9;
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