<?php 
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
print_r($UcretBilgi);
$YetUcret = $this->TesvikAdaylar['YetUcret'];

$_SESSION['tesvik'] = $this->tesvik;
if(strlen($this->tesvikId) == 1){
	$_SESSION['tesvikId'] = '00'.$this->tesvikId;
}else if(strlen($this->tesvikId) == 2){
	$_SESSION['tesvikId'] = '0'.$this->tesvikId;
}else{
	$_SESSION['tesvikId'] = $this->tesvikId;
}
?>
<div class="anaDiv" style="overflow: auto">
<?php
$html = '
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
	<tbody>';

$say = 0;
$TopSinav = 0;
$FonBürüt = 0;
$FonNet = 0;
$TopBelgeMasraf = 0;
foreach($AdayBilgi as $row){
$say++;
$html .= '<tr nobr="true">';
$html .= '<td align="center">'.$row['TC_KIMLIK'].'</td>';
$html .= '<td >'.$row['ADI'].' '.$row['SOYADI'].'</td>';
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

$html .='</tbody>
</table>
';

echo $html;
?>
</div>
<?php
function DamgasizHesapla($dat){
	$dat = floor($dat*100)/100;
	return number_format($dat,'2',',','.');
}