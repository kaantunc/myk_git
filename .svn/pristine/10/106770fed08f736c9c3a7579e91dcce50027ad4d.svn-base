<?php
defined('_JEXEC') or die('Restricted access'); 

$sinavSonuclari = $this->sinavSonuclari;
$sinavSekli = $this->sinavSekli;

?>

<table cellspacing="1" border="2">
	<tr class="tablo_header">
		<th>#</th>
		<th>Kuruluş Kayıt No</th>
		<th>TC Kimlik No</th>
		<th>Ögrenci Adi</th>
		<th>Ögrenci Soyadi</th>
		<th>Sınavı</th>
		<th>Aldığı Not</th>
		<th>Sonuç</th>
		<th>Gözetmen</th>
		<th>Degerlendirici</th>
	</tr>
<?php
$rowNo=1;

foreach($sinavSonuclari AS $ogr){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'" style="text-align:center;">';
	echo '<td>'.$rowNo.'</td>';
	if(strlen($ogr['SEKIL']) <= 0){
	echo '<td>'.($ogr['OGRENCI_KAYIT_NO']?$ogr['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['TC_KIMLIK']?$ogr['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['OGRENCI_ADI']?$ogr['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['OGRENCI_SOYADI']?$ogr['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($ogr['OLC_DEG_HARF'] == 'P')
							echo '<td>'.($ogr['BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/PRATİK-'.$ogr['OLC_DEG_NUMARA'].')'?$ogr['BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/PRATİK-'.$ogr['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$ogr['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$ogr['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$ogr['SEKIL'].'" name="altbirimSekil_'.$ogr['TC_KIMLIK'].'[]"/></td>';
						else if($ogr['OLC_DEG_HARF'] == 'T')
							echo '<td>'.($ogr['BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/TEORİK-'.$ogr['OLC_DEG_NUMARA'].')'?$ogr['BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/TEORİK-'.$ogr['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$ogr['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$ogr['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$ogr['SEKIL'].'" name="altbirimSekil_'.$ogr['TC_KIMLIK'].'[]"/></td>';
						else if($ogr['OLC_DEG_HARF'] == 'D')
							echo '<td>'.($ogr['BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/DRATİK-'.$ogr['OLC_DEG_NUMARA'].')'?$ogr['YETERLILIK_ALT_BIRIM_ADI'].'('.$ogr['BIRIM_KODU'].'/DRATİK-'.$ogr['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$ogr['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$ogr['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$ogr['SEKIL'].'" name="altbirimSekil_'.$ogr['TC_KIMLIK'].'[]"/></td>';
						echo '<td>'.($ogr['ALDIGI_NOT'] != '' ? $ogr['ALDIGI_NOT'] : '-').'</td>';
						echo '<td>'.($ogr['SINAV_DURUM_ADI'] != '' ? $ogr['SINAV_DURUM_ADI'] : '-').'</td>';
						echo '<td>'.($ogr['GOZETMEN']?$ogr['GOZETMEN']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['DEGERLENDIRICI']?$ogr['DEGERLENDIRICI']:"&nbsp;").'</td>';
	}
	else{
		echo '<td>'.($ogr['OGRENCI_KAYIT_NO']?$ogr['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['TC_KIMLIK']?$ogr['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['OGRENCI_ADI']?$ogr['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['OGRENCI_SOYADI']?$ogr['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($ogr['SEKIL'] == 0)
							echo '<td>'.($ogr['YETERLILIK_ALT_BIRIM_ADI'].'('.$ogr['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)'?$ogr['YETERLILIK_ALT_BIRIM_ADI'].'('.$ogr['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)':"&nbsp;").'<input type="hidden" value="'.$ogr['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$ogr['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$ogr['SEKIL'].'" name="altbirimSekil_'.$ogr['TC_KIMLIK'].'[]"/></td>';
						else if($ogr['SEKIL'] == 1)
							echo '<td>'.($ogr['YETERLILIK_ALT_BIRIM_ADI'].'('.$ogr['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)'?$ogr['YETERLILIK_ALT_BIRIM_ADI'].'('.$ogr['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)':"&nbsp;").'<input type="hidden" value="'.$ogr['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$ogr['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$ogr['SEKIL'].'" name="altbirimSekil_'.$ogr['TC_KIMLIK'].'[]"/></td>';
						echo '<td>'.($ogr['ALDIGI_NOT'] != '' ? $ogr['ALDIGI_NOT'] : '-').'</td>';
						echo '<td>'.($ogr['SINAV_DURUM_ADI'] != '' ? $ogr['SINAV_DURUM_ADI'] : '-').'</td>';
						echo '<td>'.($ogr['GOZETMEN']?$ogr['GOZETMEN']:"&nbsp;").'</td>';
						echo '<td>'.($ogr['DEGERLENDIRICI']?$ogr['DEGERLENDIRICI']:"&nbsp;").'</td>';
	}
	echo '</tr>';
	$rowNo++;
}

?>
</table>

<a href="javascript:history.go(-1);">Geri</a>