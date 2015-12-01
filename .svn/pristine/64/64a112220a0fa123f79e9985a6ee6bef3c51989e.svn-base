<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->gorusler;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir görüş bildirilmemiş.</div>';
}
else{


?>

<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-date-dmy">Son Görüş Verme Tarihi</th>
		<th class="sortable-text">Görüş Bildiren</th>
		<th class="sortable-text">E-Posta</th>
		<th class="sortable-text">Telefon</th>
		<th class="sortable-text">Faks</th>
		<th>Ayrıntılar</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['SON_GORUS_TARIH_FORMATTED'].'</td>';
			echo '<td>'.$satir['GORUS_BILDIREN'].'</td>';
			echo '<td>'.$satir['GORUS_E_POSTA'].'</td>';
			echo '<td>'.$satir['GORUS_TELEFON'].'</td>';
			echo '<td>'.$satir['GORUS_FAKS'].'</td>';
			echo '<td><a href="?option=com_yeterlilik_taslak&view=gorus_ayrinti&gorusId='.$satir['GORUS_ID'].'&yeterlilikId='.$this->yeterlilikId.'">Ayrıntılar</a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<br />
<input type="button" value="Geri" onclick="javascript:history.go(-1)"></input>
<br />
<br />
<a target="_blank" href="index.php?option=com_yeterlilik_taslak&view=gorus_listele&layout=pdf&format=pdf&yeterlilikId=<?php echo $this->yeterlilikId;?>">PDF Çıktısı Al</a>

<?php
}

?>
