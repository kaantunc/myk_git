<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');


$sonuclar = $this->meslekStandart;

if(!$sonuclar)
	echo '<div class="sonucBulunamadi">Henüz hiçbir taslak ön başvurusu bulunmamaktadır.</div>';
else{
?>

<div class="tableWrapper">
<table cellspacing="0" id="standartTable">
	<thead>
	<tr class="tablo_header">
		<th>#</th> 
		<th class="sortable-numeric">Id</th>
		<th class="sortable-text">Standart Adı</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Revizyon</th>
		<th class="sortable-text">Sektör</th>
		<th class="sortable-text">Başlangıç Tarihi</th>
		<th class="sortable-text">Taslak Durumu</th>
		<th>Taslağa Git</th>
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
				echo '<td>'.$satir['EVRAK_ID'].'</td>';
				echo '<td>'.$satir['STANDART_ADI'].'</td>';
				echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
				echo '<td>'.$satir['REVIZYON'].'</td>';
				echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
				echo '<td>'.$satir['BASLANGIC_TARIHI_FORMATTED'].'</td>';
				echo '<td>'.$satir['MESLEK_STANDART_DURUM_ADI'].'</td>';
				echo '<td><a href="index.php?option=com_meslek_std_taslak&layout=meslek_std_taslak_yeni&standart_id='.$satir['STANDART_ID'].'">Git</a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<?php } ?>

<script>
jQuery(document).ready(function(){
	jQuery('#standartTable').dataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
		});
	});
</script>