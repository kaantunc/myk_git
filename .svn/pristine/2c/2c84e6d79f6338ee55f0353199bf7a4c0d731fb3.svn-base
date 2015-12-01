<?php
defined('_JEXEC') or die('Restricted access');

$kuruluslar = $this->kuruluslar;

function getKurulusAdi($kuruluslar, $id){
	foreach($kuruluslar AS $kurulus)
		if($kurulus['USER_ID'] == $id)
			return $kurulus['KURULUS_ADI'];
	return FALSE;
}

?>

<div>
Takvim Yılı: <?php echo $_POST['takvim_yili'];?>
</div>

<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>Denetleme Tarihi</th>
		<th>Kuruluş Adı</th>
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


$colNums = 3;
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
			echo '<td>'. getKurulusAdi($kuruluslar, $_POST[$id.'-'.$colNo][$rowNo]).'</td>';
		}
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

<form id="sinavTakvimiGeriForm" action="?option=com_akreditasyon&view=takvim" method="post">
	<input name="mode" value="duzenle" type="hidden"></input>
	<input name="takvim_yili" value="<?php echo $_POST['takvim_yili']?>" type="hidden"></input>
	<input type="submit" value="Geri" />
</form>

<br />

<form id="sinavTakvimiKaydetForm" action="?option=com_akreditasyon&task=takvimKaydet" method="post">
	<input name="mode" value="kaydet" type="hidden"></input>
	<input name="serializedPost" value="<?php echo $serializedPost?>" type="hidden"></input>
	<input type="submit" value="Kaydet" />
</form>
<br />
<br />
<a href="index.php?option=com_akreditasyon&view=takvim_ozet&layout=pdf&format=pdf" target="_blank">PDF Çıktısını Al</a>