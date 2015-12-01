<?php
defined('_JEXEC') or die('Restricted access');

$kuruluslar = $this->kuruluslar;
$postData = $this->postData;

function getKurulusAdi($kuruluslar, $id){
	foreach($kuruluslar AS $kurulus)
		if($kurulus['USER_ID'] == $id)
			return $kurulus['KURULUS_ADI'];
	return FALSE;
}

?>

<div>
<b>Takvim Yılı:</b> <?php echo $postData['takvim_yili'];?>
</div>
<br />
<table cellspacing="1" border="1">
	<tr class="tablo_header">
		<th><b>#</b></th>
		<th><b>Denetleme Tarihi</b></th>
		<th><b>Kuruluş Adı</b></th>
	</tr>

<?php
$id = 'inputsinavTakvimi';

//for($rowNo=1;isset($postData[$id.'-'.$rowNo]);$rowNo++){
//	if($rowNo%2==0)
//		$rowClass = "even_row";
//	else
//		$rowClass = "odd_row";
//		
//	echo '<tr class="'.$rowClass.'">';
//	echo '<td>'.$rowNo.'</td>';
//	
//	$row = $postData[$id.'-'.$rowNo];
//	
//	for($colNo=0;isset($row[$colNo]);$colNo++){
//		
//		echo '<td>'.$row[$colNo].'</td>';
//		
//	}
//	echo '</tr>';
//}


$colNums = 3;
for($rowNo=0;$rowNo < count($postData[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	//echo '<td>'.($rowNo + 1).'</td>';
	
	//$row = $postData[$id.'-'.$rowNo];
	
	for($colNo=1;$colNo <= $colNums;$colNo++){
		
		if($colNo==3){
			echo '<td>'. getKurulusAdi($kuruluslar, $postData[$id.'-'.$colNo][$rowNo]).'</td>';
		}
		else
			echo '<td>'.$postData[$id.'-'.$colNo][$rowNo].'</td>';
		
	}
	echo '</tr>';
}

//JRequest::set($postData, 'POST');

$serializedPost = serialize($postData);
$serializedPost=str_replace(array('&','"','\'','<','>',"\t",),
				array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),
				$serializedPost);

?>
</table>