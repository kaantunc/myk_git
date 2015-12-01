<?php
$istatistik = $this->istatistik;
//dd($istatistik);exit;
?>
<div class="anaDiv font20 fontBold hColor text-center">
Teşvik İstatistikleri
</div>
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="15%">Yıl</th>
				<th width="15%">Yararlanan Kişi Sayısı</th>
				<th width="25%">Yararlanıcıların Sınav ve Belge Ücretleri Toplamı</th>
				<th width="25%">Fondan Karşılanan Sınav ve Belge Ücretleri Toplamı</th>
				<th width="20%">Yüzde (%)</th>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php 
		$i = 0;
		foreach($istatistik as $row){
			$i++;
			echo '<tr>';
			echo '<td>'.$row['YIL'].'</td>';
			echo '<td>'.$row['KISI'].'</td>';
			echo '<td>'.formatla(str_replace(",",".",$row['SINAVUCRETI'])).' TL</td>';
			echo '<td>'.formatla(str_replace(",",".",$row['FONLANANUCRET'])).' TL</td>';
			echo '<td>'.formatla(100*str_replace(",",".",$row['FONLANANUCRET'])/str_replace(",",".",$row['SINAVUCRETI'])).'</td>';
			echo '</tr>';
		}
		function formatla($sayi){
			$sayi = floor($sayi*100)/100;
			return number_format($sayi,2,",",".");
		}
		?>
		</tbody>
</table>
<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"bInfo": false,
		"bPaginate": false,
		"bFilter": false,
		"Ordering":false,
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