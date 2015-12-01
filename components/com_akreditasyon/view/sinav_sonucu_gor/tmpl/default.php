<?php
defined('_JEXEC') or die('Restricted access'); 

$sinavSonuclari = $this->sinavSonuclari;
$sinavSekli = $this->sinavSekli;

?>

<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>TC Kimlik No</th>
		<th>Öğrenci Adı</th>
		<th>Öğrenci Soyadı</th>
			<?php 
			if($sinavSekli == TEORIK_SINAV_ID){
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

foreach($sinavSonuclari AS $ogr){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$ogr['TC_KIMLIK'].'</td>';
	echo '<td>'.$ogr['OGRENCI_ADI'].'</td>';
	echo '<td>'.$ogr['OGRENCI_SOYADI'].'</td>';
	
	if($sinavSekli == TEORIK_SINAV_ID){
		echo '<td>'.$ogr['DOGRU_SAYISI'].'</td>';
		echo '<td>'.$ogr['YANLIS_SAYISI'].'</td>';
		echo '<td>'.$ogr['BOS_SAYISI'].'</td>';
	}
	
	echo '<td>'.($ogr['ALDIGI_NOT'] != '' ? $ogr['ALDIGI_NOT'] : '-').'</td>';
	echo '<td>'.$ogr['SINAV_DURUM_ADI'].'</td>';
	
	echo '</tr>';
	$rowNo++;
}

?>
</table>