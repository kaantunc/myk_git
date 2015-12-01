<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->taslakAday;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Onaylanmamış ön taslak bulunmamaktadır.</div>';
}
else{


?>

<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Seviye</th>
		<th>Formu Görüntüle</th>
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
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td><a href="?option=com_yeterlilik_taslak&layout=tanitim&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Görüntüle</a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<?php
}

?>

