<?php
defined('_JEXEC') or die('Restricted access'); 

$takvimIcerik = $this->takvimIcerik[0];
$birimAdlari = $this->takvimIcerik[1];
$sekiller = $this->takvimIcerik[2];
$userId = $this->userId;
$aramaSozcugu = JRequest::getVar('aramaSozcugu');

function AltBirimAdi($birimAdlari, $sekiller, $id){
	$ekle='';
	$say = count($birimAdlari[$id]);
	for($ii = 0; $ii < $say; $ii++){
		if(strlen($sekiller[$id][$ii]) > 0){
			if($sekiller[$id][$ii] == 0){
				$ekle .= '<p>'.$birimAdlari[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$birimAdlari[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Teorik)</p><br>';
			}
			else{
				$ekle .= '<p>'.$birimAdlari[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$birimAdlari[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Pratik)</p><br>';
			}
		}
		else{
			$ekle .= '<p>'.$birimAdlari[$id][$ii][0]['BIRIM_ADI'].'('.$birimAdlari[$id][$ii][0]['BIRIM_KODU'].'/'.$birimAdlari[$id][$ii][0]['OLC_DEG_HARF'].$birimAdlari[$id][$ii][0]['OLC_DEG_NUMARA'].')</p><br>';
		}
	}
	return $ekle;
	return FALSE;
}

?>

<table cellspacing="1" border=1>
	<tr class="tablo_header">
		<th>#</th>
		<th>Sınav Tarihi</th>
		<th>Sınav Merkezi</th>
		<th>Yeterlilik</th>
		<th>Sınav Birimleri</th>
	</tr>
<?php
$rowNo=1;

foreach($takvimIcerik AS $sinav){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$sinav['SINAV_TARIHI'].'</td>';
	echo '<td>'.$sinav['MERKEZ_ADI'].'</td>';
	echo '<td>'.$sinav['YETERLILIK_ADI'].'</td>';
	echo '<td>'.AltBirimAdi($birimAdlari, $sekiller, ($rowNo-1)).'</td>';

	echo '</tr>';
	$rowNo++;
}

?>
</table>

<a href="index.php?option=com_sinav&view=takvim_gor&layout=listele&aramaSozcugu=<?php echo $aramaSozcugu?>&userId=<?php echo $userId?>">Geri</a>