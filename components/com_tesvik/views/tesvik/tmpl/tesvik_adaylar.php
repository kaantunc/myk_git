<?php
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];

?>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	Teşvik Yararlanma Tarihi:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $this->bitTarih;?>
	</div>
</div>
<form id="TesvikIstek" action="index.php?option=com_tesvik&task=TesvikAdayYarat" enctype="multipart/form-data" method="post">
<!-- <input type="hidden" name="bas_tarih" value="<?php echo $this->basTarih;?>"/> -->
<input type="hidden" name="bit_tarih" value="<?php echo $this->bitTarih;?>"/>
<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">#</th>
				<th width="20%">Adı Soyadı</th>
				<th width="10%">TC Kimlik</th>
				<th width="15%">Belge No</th>
				<th width="25%">Kuruluş</th>
				<th width="25%">Yeterlilik</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 0;
		foreach ($AdayBilgi as $row){
			$say++;
			echo '<tr>';
// 			if(empty($row['IBAN']) || empty($row['TELEFON'])){
// 				echo '<td><input type="checkbox" name="tesvik[]" value="'.$row['BELGENO'].'" disabled="disabled"/></td>';
// 			}else{
// 				echo '<td><input type="checkbox" name="tesvik[]" value="'.$row['BELGENO'].'" checked="checked"/></td>';
// 			}
			echo '<td><input type="checkbox" name="tesvik[]" value="'.$row['BELGENO'].'" checked="checked"/></td>';
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '</tr>';
		} 
		?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50">
		<a href="index.php?option=com_tesvik&view=tesvik" class="btn btn-sm btn-danger">İptal</a>
	</div>
	<div class="div50 text-right">
		<button type="button" class="btn btn-sm btn-success" id="TesvikKaydet">Kaydet</button>
	</div>
</div>
</form>
<script type="text/javascript">
jQuery(document).ready(function($){
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
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Belge Var)",
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

	jQuery('#TesvikKaydet').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();
		if(jQuery('input[name="tesvik[]"]:checked').length > 0){
			jQuery('#TesvikIstek').submit();
		}else{
			alert('Tesvik isteiğinde bulunmak için en az bir aday seçmelisiniz.');
		}
	});
});
</script>