<?php
$SBkurulus = $this->AllSBKurulus;
$SBkuruluslar = '<option value="0">Seçiniz</option>';
foreach($SBkurulus as $row){
	$SBkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$ProKur = $this->ProKur;
$DonKur = $this->DonKur;
$topHibe = 0;

function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}
function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
?>
<div class="anaDiv text-center font20 fontBold hColor">
	AB Protokol Bilgileri
</div>
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
	<thead style="text-align:center;background-color:#71CEED">
		<tr>
			<th width="10%">ID</th>
			<th width="50%">Kuruluş</th>
			<th width="10%">Protokol</th>
			<th width="20%">Hibe</th>
			<th width="10%">Düzenle</th>
		</tr>
	</thead>
	<tbody class="text-center fontBold">
	<?php foreach($SBkurulus as $row){
		echo '<tr>';
		echo '<td>'.$row['USER_ID'].'</td>';
		echo '<td>'.$row['KURULUS_ADI'].'</td>';
		if(array_key_exists($row['USER_ID'], $ProKur)){
			echo '<td>'.$ProKur[$row['USER_ID']]['PRO_TARIH'].'</td>';
		}else{
			echo '<td class="text-warning">-</td>';
		}
		
		if(array_key_exists($row['USER_ID'], $DonKur)){
			echo '<td>'.Hesapla($DonKur[$row['USER_ID']]['UCRET']).' €</td>';
			$topHibe += UcretDuzenle($DonKur[$row['USER_ID']]['UCRET']);
		}else{
			echo '<td class="text-warning">-</td>';
		}
		
		echo '<td><a target="_blank" class="btn btn-xs btn-primary" href="index.php?option=com_profile&view=abuzman&layout=abdonem&kId='.$row['USER_ID'].'">Düzenle</a></td>';
		echo '</tr>';
	}?>
	</tbody>
</table>
</div>
<div class="anaDiv">
	<div class="div30 hColor font18 fontBold">
		Toplam Hibe:
	</div>
	<div class="div70 font18 fontBold">
		<?php echo Hesapla($topHibe);?> €
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
		"aaSorting": [[ 2, "desc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Kuruluş Var)",
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