<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
if (!headers_sent()) {
	header_remove();
}


$belgeAdayExcel = $this->belgeAdayExcel[0];
$yetkili = $this->belgeAdayExcel[1];
$kurData = $this->belgeAdayExcel[2];
$birims = $this->belgeAdayExcel[3];
?>
<style>
br{
mso-data-placement:same-cell;
}
</style>
<table width="100%" border="1">
<thead>
	<tr>
		<th>Belge No</th>
		<th>T.C. No</th>
		<th>Ad</th>
		<th>Soyad</th>
		<th>Yeterlilik Kodu</th>
		<th>Yeterlilik AdiB</th>
		<th>Yeterlilik AdiK</th>
		<th>Yeterlilik Seviyesi</th>
		<th>Yeterlilik Yayinlanma Tarihi</th>
		<th>Revizyon Tarihi</th>
		<th>Revizyon No</th>
		<th>Kurulus Adi</th>
		<th>Kurulus Logo</th>
		<th>MYK Markasi</th>
		<th>TURKAK Markasi</th>
		<th>MYK Markasi Kodu</th>
		<th>TURKAK Markasi Kodu</th>
		<th>Belge Düzenleme Tarihi</th>
		<th>Belge Gecerlilik Tarihi</th>
		<th>Kurulus Internet Sitesi</th>
		<th>Imza Yetkilisi</th>
		<th>Imza Yetkilisi Unvan</th>
		<th>Yeterlilik Birimleri</th>
		<th>KareKod Linki</th>
	</tr>
</thead>
<tbody>
<?php foreach ($belgeAdayExcel as $belge){
	echo '<tr>';
	echo '<td>'.$belge['BELGE_NO'].'</td>';
	echo '<td>'.$belge['TC_KIMLIK'].'</td>';
	echo '<td>'.$belge['ADI'].'</td>';
	echo '<td>'.$belge['SOYADI'].'</td>';
// 	if($belge['REVIZYON_DURUMU']==1){
// 		echo '<td>'.trim(strtoupper($belge['YETERLILIK_REV_KOD'])).'</td>';
// 	}else{
// 		echo '<td>'.trim(strtoupper($belge['YETERLILIK_KODU'])).'</td>';
// 	}
	echo '<td>'.trim(strtoupper($belge['YETERLILIK_KODU'])).'</td>';
	echo '<td>'.trim($belge['YETERLILIK_ADI']).'</td>';
	$yetB = trim(FormFactory::ucWordsTR($belge['YETERLILIK_ADI']));
	if (strpos($yetB,'Nc/cnc') !== false) {
		$yetB = str_replace("Nc/cnc","NC/CNC",$yetB);
	}else if(strpos($yetB,'nc/cnc') !== false){
		$yetB = str_replace("nc/cnc","NC/CNC",$yetB);
	}else if(strpos($yetB,'Nc/Cnc') !== false){
		$yetB = str_replace("Nc/Cnc","NC/CNC",$yetB);
	}else if(strpos($yetB,'Cnc') !== false){
		$yetB = str_replace("Cnc","CNC",$yetB);
	}else if(strpos($yetB,'cnc') !== false){
		$yetB = str_replace("cnc","CNC",$yetB);
	}
	echo '<td>'.$yetB.'</td>';
	echo '<td>Seviye '.$belge['YETERLILIK_SEVIYESI'].'</td>';
	echo '<td>'.tarihAyarla($belge['YAYIN_TARIHI']).'</td>';
	if($belge['REVIZYON_DURUMU'] == 1){
		echo '<td>'.tarihAyarla($belge['REVIZYON_TARIHI']).'</td>';
	}else{
		echo '<td>-</td>';
	}
// 	if($belge['REVIZYON_DURUMU']==1){
// 		echo '<td>'.$belge['REVIZYON'].'</td>';
// 	}else{
// 		echo '<td>'.$belge['REVIZYON'].'</td>';
// 	}
	echo '<td>'.$belge['REVIZYON'].'</td>';
	
	//Kurulus Adı M_KURULUS_EDIT tablosundan geliyorsa
	if($kurData['KUR_AD']){
		echo '<td>'.trim($kurData['KUR_AD']).'</td>';
	}else{
		echo '<td>'.trim($kurData['KURULUS_ADI']).'</td>';
	}
	echo '<td>kurulus/'.$kurData['KURULUS_YETKILENDIRME_NUMARASI'].'.jpg</td>';
	echo '<td>myk/'.$kurData['MYK_MARKASI'].'</td>';
	echo '<td>turkak/'.$kurData['TURKAK_MARKASI'].'</td>';
	echo '<td>'.$kurData['KURULUS_YETKILENDIRME_NUMARASI'].'</td>';
	echo '<td>'.$kurData['AKREDITASYON_NO'].'</td>';
	echo '<td>'.$belge['BELGE_DUZENLEME_TARIHI'].'</td>';
	echo '<td>'.$belge['GECERLILIK_TARIHI'].'</td>';
	
	//Kurulus Web Adresi M_KURULUS_EDIT tablosundan geliyorsa
	if($kurData['KUR_WEB']){
		echo '<td>'.$kurData['KUR_WEB'].'</td>';
	}else{
		echo '<td>'.$kurData['KURULUS_WEB'].'</td>';
	}
	echo '<td>'.trim($yetkili['YETKILI_AD']).' '.trim($yetkili['YETKILI_SOYAD']).'</td>';
	echo '<td>'.trim($yetkili['YETKILI_UNVAN']).'</td>';
	echo '<td>';
	$say=1;
	foreach ($birims[$belge['TC_KIMLIK']] as $tow){
		if(count($birims[$belge['TC_KIMLIK']]) == $say){
			echo trim($tow['BIRIM_KODU']).' '.trim($tow['BIRIM_ADI']);
		}
		else{
			echo trim($tow['BIRIM_KODU']).' '.trim($tow['BIRIM_ADI']).'<br>';	
		}
		$say++;
	}
	echo '</td>';
	echo '<td>karekod/'.str_replace('/', '#', $belge['BELGE_NO']).'.png'.'</td>';
	echo '</tr>';
}?>
</tbody>
</table>
<?php
function tarihAyarla($tarih){
	$dat = explode(' ',$tarih);
	return $dat[0];
}

function revizyonNoAyarla($rev){
	if(strlen($rev)>1){
		return (string)$rev;
	}else{
		return '0'.(string)$rev;
	}
}


// Redirect output to a client’s web browser (Excel2007)
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=BelgelendirmeExceli_".$belgeAdayExcel[0]['MATBAA_ID'].".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

exit;
?>