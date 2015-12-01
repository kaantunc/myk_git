<?php
$odenemeyen = $this->odenemeyen;
?>
<div class="anaDiv font20 fontBold hColor text-center">
Teşvik Kapsamında Ödenemeyen Ücretler
</div>
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">Sıra</th>
				<th width="5%">İstek ID</th>
				<th width="15%">TC Kimlik</th>
				<th width="15%">Ad Soyad</th>
				<th width="15%">Belge No:</th>
				<th width="15%">Ödenemeyen Ücret</th>
				<th width="25%">Açıklama</th>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php 
		$i = 0;
		foreach($odenemeyen as $row){
			$i++;
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$row['TESVIK_ID'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['AD'].' '.$row['SOYAD'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['DAMGASIZ_UCRET'].'</td>';
			echo '<td>'.nl2br($row['ACIKLAMA']).'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
</table>
<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ İstek Oluşturuldu)",
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