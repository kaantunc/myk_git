<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
if (!headers_sent()) {
	header_remove();
}
$belgeAdayExcel = $this->belgeAdayExcel;
$sinavId = $this->sinavId;
$yeterlilik = $this->yeterlilik;
?>
<h2 style="color:#1C617C"><?php echo $yeterlilik['YETERLILIK_KODU'].' - '.$yeterlilik['YETERLILIK_ADI'];?> Yeterliliğinden Belgelendirilen Adaylar</h2>
<br>
<a href="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&sinavId=<?php echo $sinavId;?>" id="excelAdayBelge" style="color:#1C617C" target="_blank">Matbaaya Gönderilecek Excel Dosyasını İndir</a><br><br>

<table width="100%" border="0" cellpadding="0" cellspacing="1">
<thead style="background-color:#71CEED">
	<tr>
		<th>T.C. Kimlik</th>
		<th>Ad</th>
		<th>Soyad</th>
		<th>Sınav Tarihi</th>
		<th>Belge Düzenleme Tarihi</th>
		<th>Belge Geçerlilik Tarihi</th>
		<th>Belge No:</th>
	</tr>
</thead>
<tbody>
<?php 
$say = 1;
$even = 'bgcolor="#efefef"';
foreach ($belgeAdayExcel as $belge){
	if($say%2 == 0){
		echo '<tr align="center" '.$even.'>';	
	}
	else{
		echo '<tr align="center">';	
	}
	echo '<td>'.$belge['TC_KIMLIK'].'</td>';
	echo '<td>'.$belge['AD'].'</td>';
	echo '<td>'.$belge['SOYAD'].'</td>';
	echo '<td>'.$belge['SINAV_TARIHI'].'</td>';
	echo '<td>'.$belge['BELGE_DUZENLEME_TARIHI'].'</td>';
	echo '<td>'.$belge['GECERLILIK_TARIHI'].'</td>';
	echo '<td>'.$belge['BELGENO'].'</td>';
	$say++;
}?>
</tbody>
</table>
<br>
<button onclick="window.location.href='index.php?option=com_belgelendirme&view=belge_olusturma'">Geri</button>
