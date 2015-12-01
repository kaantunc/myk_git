<?php
$baslik = "Meslek Standardı Protokol İstatistikleri";
$istatistik_protokol_standart = $this->istatistik_protokol_standart;
?>
<style type="text/css">
	table tr th{font-size: 10px}
	table tr td{font-size: 10px}
</style>
<div class="sinavGirisBaslik"><?php echo $baslik;?></div>
<?php
if(empty($istatistik_protokol_standart)){
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
}else{?>
<div >
<table cellspacing="0" border="1">
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-numeric">Protokol İmzalanan Kuruluş Adı</th>
		<th class="sortable-numeric">Protokol Başlangıç Tarihi</th>
		<th class="sortable-numeric">Protokol Bitiş Tarihi</th>
		<th class="sortable-numeric">Protokol Süresi</th>
		<th class="sortable-numeric">Sektör</th>
		<th class="sortable-numeric">Protokol Kapsamındaki Meslek Standardı Sayısı</th>
	</tr>
<?php
	$rowCount=1;

	foreach($istatistik_protokol_standart AS $yetki){
		
		if($rowCount%2==0)
			$rowClass = "even_row";
		else
			$rowClass = "odd_row";
			echo '<tr class="'.$rowClass.'" >';
		
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$yetki['KURULUS_ADI'].'</td>';
			echo '<td>'.$yetki['IMZA_TARIHI'].'</td>';
			echo '<td>'.$yetki['BITIS_TARIHI'].'</td>';
			echo '<td>'.$yetki['SURESI'].'</td>';
			echo '<td>'.implode(',', $yetki['SEKTORLER']).'</td>';
			echo '<td>'.$yetki['STANDART_SAYI'].'</td>';
			echo '</tr>';
			
			$toplam += $yetki['STANDART_SAYI'];
			$rowCount++;
	}
?>
<tr>
	<td colspan="6" style="text-align: center;">TOPLAM</td>
	<td><?php echo $toplam;?></td>
</tr>
</table>			
</div>
<?php } ?>