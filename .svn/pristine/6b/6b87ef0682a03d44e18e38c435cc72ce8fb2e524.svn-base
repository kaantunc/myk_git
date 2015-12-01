<?php
$baslik = "Meslek Standartları Revizyonları İstatistikleri";
$istatistik_meslek = $this->istatistik_meslek;
$istatistik_meslek_detail = $this->istatistik_meslek_detail;
?>
<style type="text/css">
	table tr th{font-size: 10px}
</style>
<div class="sinavGirisBaslik"><?php echo $baslik;?></div>
<?php
if(empty($istatistik_meslek_detail)){
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
}else{?>
<div>
<table cellspacing="0" border="1">
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-numeric">Kuruluş Adı</th>
		<th class="sortable-numeric">Sektör</th>
		<th class="sortable-numeric">Protokol Kapsamında Yer Alanlar</th>
		<th class="sortable-numeric">Kuruluşca Çalışılanlar</th>
		<th class="sortable-numeric">Görüş Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Görüş Değerlendirme Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Sektör Komitesi Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Yönetim Kurulu Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Yayınlanmak Üzere Gönderilenler</th>
		<th class="sortable-numeric">Resmi Gazetede Yayımlananlar</th>
		<th class="sortable-numeric">Yürürlükten Kaldırılarak İptal Edilenler</th>
	</tr>
<?php
	$rowCount=1;
	$rowClass="";
	$sumPKS=0;
	$sumKTCD=0;
	$sumGA=0;
	$sumGDA=0;
	$sumIEM=0;
	$sumSKA=0;
	$sumYKA=0;
	$sumYUG=0;
	$sumRGY=0;

	foreach($istatistik_meslek_detail AS $yetki){
		foreach($yetki as $sonuc){
			foreach($sonuc as $satir){
		
			
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				echo '<tr class="'.$rowClass.'" >';
			
				echo '<td style="font-size:10px;">'.$rowCount.'</td>';
				echo '<td style="font-size:10px;">'.$satir['KURULUS_ADI'].'</td>';
				echo '<td style="font-size:10px;">'.$satir['SEKTOR_ADI'].'</td>';
				echo '<td>'.$satir['PKS'].'</td>';
				echo '<td>'.$satir['KTCD'].'</td>';
				echo '<td>'.$satir['GA'].'</td>';
				echo '<td>'.$satir['IEM'].'</td>';
				echo '<td>'.$satir['SKA'].'</td>';
				echo '<td>'.$satir['YKA'].'</td>';
				echo '<td>'.$satir['YUG'].'</td>';
				echo '<td>'.$satir['RGY'].'</td>';
				echo '<td>'.$satir['GDA'].'</td>';
				
				echo '</tr>';
					$rowCount++;
			
				
				$sumPKS=$sumPKS+$satir['PKS'];
				$sumKTCD=$sumKTCD+$satir['KTCD'];
				$sumGA=$sumGA+$satir['GA'];
				$sumGDA=$sumGDA+$satir['GDA'];
				$sumIEM=$sumIEM+$satir['IEM'];
				$sumSKA=$sumSKA+$satir['SKA'];
				$sumYKA=$sumYKA+$satir['YKA'];
				$sumYUG=$sumYUG+$satir['YUG'];
				$sumRGY=$sumRGY+$satir['RGY'];
			}
		}
	}
?>
<tr>
	<td colspan="3" style="text-align: center;">TOPLAM</td>
	<td><?php echo $sumPKS;?></td>
	<td><?php echo $sumKTCD;?></td>
	<td><?php echo $sumGA;?></td>
	<td><?php echo $sumGDA;?></td>
	<td><?php echo $sumIEM;?></td>
	<td><?php echo $sumSKA;?></td>
	<td><?php echo $sumYKA;?></td>
	<td><?php echo $sumYUG;?></td>
	<td><?php echo $sumRGY;?></td>
</tr>
</table>
</div>
<?php } ?>