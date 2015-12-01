<?php
defined('_JEXEC') or die('Restricted access');

$merkezler = $this->merkezler;
$yeterlilikler = $this->yeterlilikler;
$altbirimler = $this->altBirimler;
$altbirimlerPDF = $this->altBirimlerPDF;
$sekiller = $this->sekiller;
$kurulus = $this->kurulus;
$postData = $this->postData;

function getYeterlilikYeniMiValue($yeterlilikId)
{
	$db = JFactory::getOracleDBO();
	$result = $db->prep_exec_array("SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID=?", array($yeterlilikId));
	$yeniMi = $result[0];
	return $yeniMi;
}
function getMerkezAdi($merkezler, $id){
	foreach($merkezler AS $merkezRow)
		if($merkezRow['MERKEZ_ID'] == $id)
			return $merkezRow['MERKEZ_ADI'];
	return FALSE;
}

function getYetAdi($yeterlilikler, $id){
	foreach($yeterlilikler AS $yetRow)
		if($yetRow[0]['YETERLILIK_ID'] == $id)
			return $yetRow[0]['YETERLILIK_ADI'];
	return FALSE;
}

function getAltBirimAdi($altbirimler,$sekiller, $id, $yeterlilik_id){
	$ekle='';
	$say = count($altbirimler[$id]);
	for($ii = 0; $ii < $say; $ii++){
		if(strlen($sekiller[$id][$ii]) > 0){
			if($sekiller[$id][$ii] == 0){
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Teorik)</p>';
			}
			else{
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Pratik)</p>';
			}
		}
		else{
			$ekle .= '<p>'.$altbirimler[$id][$ii][0]['BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['BIRIM_KODU'].'/'.$altbirimler[$id][$ii][0]['OLC_DEG_HARF'].$altbirimler[$id][$ii][0]['OLC_DEG_NUMARA'].')</p>';
		}
	}
	return $ekle;
	return FALSE;
}

function getAltBirimAdi_2($altbirimler,$sekiller, $yetIndex, $yeterlilik_id, $yeniMi){
	$ekle='';
	for($i = 0; $i < count($altbirimler[$yetIndex]); $i++)
	{
		if($yeniMi=='0')
				$ekle .= '<p>'.$altbirimler[$yetIndex][$i]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$yetIndex][$i]['YETERLILIK_ALT_BIRIM_NO'].'/'.$altbirimler[$yetIndex][$i]['OLCME_DEGERLENDIRME_KOD'].')</p>';
		else{
			$ekle .= '<p>'.$altbirimler[$yetIndex][$i]['BIRIM_ADI'].'('.$altbirimler[$yetIndex][$i]['BIRIM_KODU'].'/'.$altbirimler[$yetIndex][$i]['OLC_DEG_HARF'].$altbirimler[$yetIndex][$i]['OLC_DEG_NUMARA'].')</p>';
		}
	}
	return $ekle;
	return FALSE;
}
?>

<div>
</hr>
<strong><?php echo $kurulus[0]["KURULUS_ADI"]." "; echo $postData['takvim_yili']." ";?>Sınav Takvimi</strong>
</div>

<table cellspacing="1" border="1" style="text-align:center;">
	<tr class="tablo_header">
		<th width="220px">#</th>
		<th width="220px">Tarih</th>
		<th>Yeterlilik Adı</th>
		<th width="800px">Sınav Yapılacak Birimler</th>
		<th>Sınav Merkezi</th>
	</tr>

<?php
$id = 'inputsinavTakvimi';
$kacinciyet = 0;
$colNums = 5;
for($rowNo=0;$rowNo < count($postData[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	for($colNo=1;$colNo <= $colNums;$colNo++){
		
		$yeniMi = getYeterlilikYeniMiValue($yeterlilikler[$kacinciyet][0]['YETERLILIK_ID']);
		
		if($colNo==3){
			echo '<td>'. getYetAdi($yeterlilikler, $postData[$id.'-'.$colNo][$rowNo]).'</td>';
		}
		else if($colNo==4)
		{
			echo '<td width="800px">'. getAltBirimAdi_2($altbirimlerPDF,$sekiller, $rowNo, $yeterlilikler[$kacinciyet][0]['YETERLILIK_ID'], $yeniMi).'</td>';
		}
		else if($colNo==5)
			echo '<td>'. getMerkezAdi($merkezler, $postData[$id.'-'.$colNo][$rowNo]).'</td>';
		else
			echo '<td width="220px;">'.$postData[$id.'-'.$colNo][$rowNo].'</td>';
		
	}
	echo '</tr>';
	$kacinciyet++;
}

//JRequest::set($postData, 'POST');

//$serializedPost = serialize($postData);
/*$serializedPost=str_replace(array('&','"','\'','<','>',"\t",),
				array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),
				$serializedPost);*/

?>
</table>