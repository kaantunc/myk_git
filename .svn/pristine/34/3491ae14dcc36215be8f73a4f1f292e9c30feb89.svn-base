<?php

defined('_JEXEC') or die('Restricted access'); 

$takvimListe = $this->takvimListe;
$userId = $this->userId;
$aramaSozcugu = $this->aramaSozcugu;

if(empty($takvimListe)){
	echo '<div class="sonucBulunamadi">Kuruluşun takvim bildirimi yok.</div>';
	echo '<br /><a href="index.php?option=com_kurulus_ara&gorev=kurulus_adi&kurulus_adi='.$aramaSozcugu.'">Geri</a>';
}
else{
?>

<table cellspacing="1">
	<tr class="tablo_header">
		<th>#</th>
		<th>Sınav Takvimi Yılı</th>
		<th>Ayrıntılar</th>
	</tr>
<?php
$rowNo=1;

foreach($takvimListe AS $satir){
	
	if($rowNo%2==0)
		$rowClass = "even_row";
	else
		$rowClass = "odd_row";
		
	echo '<tr class="'.$rowClass.'">';
	
	echo '<td>'.$rowNo.'</td>';
	echo '<td>'.$satir['TAKVIM_YILI'].'</td>';
	echo '<td><a href="?option=com_sinav&view=takvim_gor&aramaSozcugu='.$aramaSozcugu.'&userId='.$userId.'&takvimYili='.$satir['TAKVIM_YILI'].'">Gözat</a></td>';

	echo '</tr>';
	$rowNo++;
}

?>
</table>

<a href="index.php?option=com_kurulus_ara&gorev=kurulus_adi&kurulus_adi=<?php echo $aramaSozcugu?>">Geri</a>

<?php }?>