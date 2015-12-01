<?php
defined('_JEXEC') or die('Restricted access');

$merkezler = $this->merkezler;
$yeterlilikler = $this->yeterlilikler;

function getMerkezAdi($merkezler, $id){
	foreach($merkezler AS $merkezRow)
		if($merkezRow['MERKEZ_ID'] == $id)
			return $merkezRow['MERKEZ_ADI'];
	return FALSE;
}

function getYetAdi($yeterlilikler, $id){
	foreach($yeterlilikler AS $yetRow)
		if($yetRow['YETERLILIK_ID'] == $id)
			return $yetRow['YETERLILIK_ADI'];
	return FALSE;
}

?>

<div>
Takvim Yılı: <?php echo $_POST['takvim_yili'];?>
</div>

<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>Tarih</th>
		<th>Sınav Merkezi</th>
		<th>Yeterlilik Adı</th>
	</tr>

<?php
$id = 'inputsinavTakvimi';

//for($rowNo=1;isset($_POST[$id.'-'.$rowNo]);$rowNo++){
//	if($rowNo%2==0)
//		$rowClass = "even_row";
//	else
//		$rowClass = "odd_row";
//		
//	echo '<tr class="'.$rowClass.'">';
//	echo '<td>'.$rowNo.'</td>';
//	
//	$row = $_POST[$id.'-'.$rowNo];
//	
//	for($colNo=0;isset($row[$colNo]);$colNo++){
//		
//		echo '<td>'.$row[$colNo].'</td>';
//		
//	}
//	echo '</tr>';
//}


$colNums = 4;
for($rowNo=0;$rowNo < count($_POST[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	//echo '<td>'.($rowNo + 1).'</td>';
	
	//$row = $_POST[$id.'-'.$rowNo];
	
	for($colNo=1;$colNo <= $colNums;$colNo++){
		
		if($colNo==3){
			echo '<td>'. getMerkezAdi($merkezler, $_POST[$id.'-'.$colNo][$rowNo]).'</td>';
		}
		else if($colNo==4)
			echo '<td>'. getYetAdi($yeterlilikler, $_POST[$id.'-'.$colNo][$rowNo]).'</td>';
		else
			echo '<td>'.$_POST[$id.'-'.$colNo][$rowNo].'</td>';
		
	}
	echo '</tr>';
}

//JRequest::set($_POST, 'POST');

$serializedPost = serialize($_POST);
$serializedPost=str_replace(array('&','"','\'','<','>',"\t",),
				array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),
				$serializedPost);

?>
</table>

<form id="sinavTakvimiGeriForm" action="?option=com_sinav&view=takvim" method="post">
	<input name="mode" value="duzenle" type="hidden"></input>
	<input name="takvim_yili" value="<?php echo $_POST['takvim_yili']?>" type="hidden"></input>
	<input type="submit" value="Geri" />
</form>

<br />

<form id="sinavTakvimiKaydetForm" action="?option=com_sinav&task=takvimKaydet" method="post">
	<input name="mode" value="kaydet" type="hidden"></input>
	<input name="serializedPost" value="<?php echo $serializedPost?>" type="hidden"></input>
	<input type="submit" value="Kaydet" />
</form>

<input type="button" value="PDF Çıktısını Al"></input>