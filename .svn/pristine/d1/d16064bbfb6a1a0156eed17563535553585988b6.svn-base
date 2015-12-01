<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

$sonuclar = $this->taslakAday;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Onaylanmamış taslak adayı bulunmamaktadır.</div>';
}
else{


?>
<style>
table tr{
	text-align:left;
} 
</style>
<div class="form_item" style="margin: 0 0 20px 0;">
  <div class="form_element cf_heading" style="margin:0;">
  		<?php if($this->sektorSorumlusu) {?>
  		<h3 class="contentheading">Ulusal Yeterlilik Ön Taslakları</h3>
	  	<?php }else{ ?>
	  		<h3 class="contentheading">Yeterlilik Ön Taslaklarım</h3>
	  	<?php }?>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="tableWrapper">
<table cellspacing="0" id="datatable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Yeterlilik Kodu</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Revizyon</th>
		<th class="sortable-text">Sektör</th>
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
			
			if($satir['YENI_MI']=='1')
				$option = "com_yeterlilik_taslak_yeni";
			else
				$option = "com_yeterlilik_taslak_yeni";
// 				$option = "com_yeterlilik_taslak";
				
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.($satir['YETERLILIK_KODU'] <> "" ? $satir['YETERLILIK_KODU'] : "-").'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td>'.$satir['REVIZYON'].'</td>';
			echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
			echo '<td>'.$satir['YETERLILIK_SUREC_DURUM_ADI'].'</td>';
			echo '<td><a href="?option='.$option.'&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Git</a></td>';
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

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#datatable').dataTable({
		"aaSorting": [[ 2, "desc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
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
