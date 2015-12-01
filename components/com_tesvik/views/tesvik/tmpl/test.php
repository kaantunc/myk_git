<?php 
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$YetUcret = $this->TesvikAdaylar['YetUcret'];

function DamgasizHesapla($dat){
	$dat = str_replace(',', '.', $dat);
	if (strpos($dat,'.') !== false) {

	}else{
		$dat = floor($dat*100)/100;
	}
	
	
	$hesap = number_format($dat,'2',',','');
	return $hesap;
}
?>
<div class="anaDiv" style="overflow: auto">
<table width="100%" border="1" style="padding:3px;">
		<thead>
			<tr style="text-align:center">
				<th width="6%"><strong>TC Kimlik No</strong></th>
				<th width="5%"><strong>Adı</strong></th>
				<th width="5%"><strong>Soyadı</strong></th>
				<th width="5%"><strong>belgeno</strong></th>
				<th width="5%"><strong>yeterlilikkod</strong></th>
				<th width="5%"><strong>revizyon</strong></th>
		<th width="5%"><strong>yeterlilikad</strong></th>
		<th width="5%"><strong>SEVİYE</strong></th>
		<th width="5%"><strong>TARIH</strong></th>
				<th width="18%"><strong>Kuruluşu</strong></th>
				<th width="5%"><strong>Ücret</strong></th>
			</tr>
		</thead>
	<tbody>
<?php
$say = 0;
$TopSinav = 0;
$FonBürüt = 0;
$FonNet = 0;
$TopBelgeMasraf = 0;
foreach($AdayBilgi as $row){
$say++;
$html .= '<tr nobr="true">';
$html .= '<td align="center">'.$row['TC_KIMLIK'].'</td>';
$html .= '<td >'.$row['ADI'].'</td>';
$html .= '<td >'.$row['SOYADI'].'</td>';
$html .= '<td >'.$row['BELGENO'].'</td>';
$html .= '<td >'.$row['YETERLILIK_KODU'].'</td>';
$html .= '<td >Rev. '.$row['REVIZYON'].'</td>';
$html .= '<td >'.$row['YETERLILIK_ADI'].'</td>';
$html .= '<td >'.$row['YETERLILIK_SEVIYESI'].'</td>';
$html .= '<td >'.$row['SINAV_TARIHI'].'</td>';
$html .= '<td>'.$row['KURULUS_ADI'].'</td>';

$uc = 0;
foreach($UcretBilgi[$row['BELGENO']] as $cow){
	$uc += str_replace(',', '.', $cow['ucret']);
}

$TopSinav += $uc;

if($YetUcret[$row['BELGENO']]['UCRET'] > $uc){
	$html .= '<td align="center">'.DamgasizHesapla($uc).' TL</td>';
}else{
	$html .= '<td align="center">'.DamgasizHesapla($YetUcret[$row['BELGENO']]['UCRET']).' TL</td>';
}

$html .= '</tr>';

}
echo $html;
?>
</tbody>
</table>
</div>