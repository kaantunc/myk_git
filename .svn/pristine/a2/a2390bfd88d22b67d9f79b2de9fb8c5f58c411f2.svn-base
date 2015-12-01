<?php
defined('_JEXEC') or die('Restricted access');

$merkezler = $this->merkezler;
$yeterlilikler = $this->yeterlilikler;
$altbirimler = $this->altBirimler;
$altbirimlerPDF = $this->altBirimlerPDF;
$sekiller = $this->sekiller;

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

function getAltBirimAdi($altbirimler,$sekiller, $id){
	$ekle='';
	$say = count($altbirimler[$id]);
	for($ii = 0; $ii < $say; $ii++){
		if(strlen($sekiller[$id][$ii]) > 0){
			if($sekiller[$id][$ii] == 0){
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Teorik)</p><br>';
			}
			else{
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Pratik)</p><br>';
			}
		}
		else{
			$ekle .= '<p>'.$altbirimler[$id][$ii][0]['BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['BIRIM_KODU'].'/'.$altbirimler[$id][$ii][0]['OLC_DEG_HARF'].$altbirimler[$id][$ii][0]['OLC_DEG_NUMARA'].')</p><br>';
		}
	}
	return $ekle;
	return FALSE;
}

function getAltBirimAdi_2($altbirimler,$sekiller, $yetIndex, $yeterlilik_id, $yeniMi){
	$ekle='';
	for($i = 0; $i < count($altbirimler[$yetIndex]); $i++)
	{
		if($yeniMi == 0)
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
<strong>Takvim Yılı: <?php echo $_POST['takvim_yili'];?></strong>
</div>

<table cellspacing="1" border="1" style="text-align:center;">
	<tr class="tablo_header">
		<th>#</th>
		<th>Tarih</th>
		<th>Yeterlilik Adı</th>
		<th>Sınav Yapılacak Birimler</th>
		<th>Sınav Merkezi</th>
		<th>Sınav Geçerlilik Tarihi</th>
	</tr>

<?php
$id = 'inputsinavTakvimi';
$kacinciyet = 0;
$colNums = 6;
for($rowNo=0;$rowNo < count($_POST[$id.'-1']);$rowNo++){
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	//echo '<td>'.($rowNo + 1).'</td>';
	
	//$row = $_POST[$id.'-'.$rowNo];
	$yeniMi = getYeterlilikYeniMiValue($yeterlilikler[$kacinciyet][0]['YETERLILIK_ID']);
	
	for($colNo=1;$colNo <= $colNums;$colNo++){
		
		if($colNo==3){
			echo '<td>'. getYetAdi($yeterlilikler, $_POST[$id.'-'.$colNo][$rowNo]).'</td>';
		}
		else if($colNo==4)
		{
			echo '<td>'. getAltBirimAdi_2($altbirimlerPDF,$sekiller, $rowNo, $yeterlilikler[$kacinciyet][0]['YETERLILIK_ID'], $yeniMi ).'</td>';
		}
		else if($colNo==5)
			echo '<td>'. getMerkezAdi($merkezler, $_POST[$id.'-'.$colNo][$rowNo]).'</td>';
		else
			echo '<td>'.$_POST[$id.'-'.$colNo][$rowNo].'</td>';
		
	}
	echo '</tr>';
	$kacinciyet++;
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