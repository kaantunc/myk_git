<?php
defined('_JEXEC') or die('Restricted access'); 

$sinavlar = $this->sinavlar;

?>

<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>Sınav Tarihi</th>
		<th>Sınav Merkezi</th>
		<th>Yeterlilik</th>
	</tr>
<?php
$rowNo=1;

foreach($sinavlar AS $sinav){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$sinav['TAKVIM_SINAV_TARIHI_FORMATTED'].'</td>';
	echo '<td>'.$sinav['MERKEZ_ADI'].'</td>';
	echo '<td>'.$sinav['YETERLILIK_ADI'].'</td>';

	echo '</tr>';
	$rowNo++;
}

?>
</table>