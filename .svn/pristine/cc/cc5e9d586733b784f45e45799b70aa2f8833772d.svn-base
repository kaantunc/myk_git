<?php
echo $this->sayfaLink;
$Yet = $this->Yet;
$allY = $Yet['allY'];
$savedY = $Yet['savedY'];

$seciliDenetim = $this->seciliDenetim;
?>
<style>
table.dataTable tr.odd.bg-success,
table.dataTable tr.even.bg-success{
	color:#ffffff;
	background-color:#28b62c;
}
</style>
<form id="YetForm" method="POST" enctype="application/x-www-form-urlencoded" action="index.php?option=com_denetim&task=DenetimYetKaydet">
<input type="hidden" name="dId" value="<?php echo $seciliDenetim['DENETIM_ID'];?>"/>
<div class="anaDiv">
	<div class="divYan">
		<button type="button" class="btn btn-xs btn-primary" id="HepSec">Hepsini Seç</button>
	</div>
	<div class="divYan">
		<button type="button" class="btn btn-xs btn-danger" id="UnSec">Hepsini Kaldır</button>
	</div>
</div>
<div class="anaDiv">
<table style="width:100%" border="1" id="yetkiTable" class="font16">
	<thead style="background-color:#71CEED;text-align:center;">
		<tr>
			<th>Seçili</th>
			<th>Yeterlilik</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$say = 0;
	foreach($allY as $row){
		$say++;
		$checked = "";
		$class='';
		if(in_array($row['YETERLILIK_ID'], $savedY)){
			$checked = 'checked="checked"';
			$class .= ' bg-success';
		}
		echo '<tr class="'.$class.'">';
		echo '<td align="center"><input class="checkSM" type="checkbox" '.$checked.' name="sm[]" value="'.$row['YETERLILIK_ID'].'" /></td>';		
		echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
		echo '</tr>';
	}
	?>
	</tbody>
</table>
</div>
</form>
<div class="anaDiv">
<button type="button" id="YetKaydet" class="btn btn-sm btn-success">Kaydet</button>
</div>
<script type="text/javascript">
jQuery.fn.dataTableExt.afnSortData['dom-checkbox'] = function  ( oSettings, iColumn )
{
    var aData = [];
    jQuery( 'td:eq('+iColumn+') input', oSettings.oApi._fnGetTrNodes(oSettings) ).each( function () {
        aData.push( this.checked==true ? "1" : "0" );
    } );
    return aData;
}
jQuery(document).ready(function(){
	var oTables = jQuery('#yetkiTable').dataTable({
		"aoColumns": [
		              { "sSortDataType": "dom-checkbox" },
		              null
		          ],
		"aaSorting": [[ 0, "desc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
        "sPaginationType": "bootstrap",
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
// 		"sPaginationType": "full_numbers",
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

	jQuery('#yetkiTable_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
	jQuery('#yetkiTable_wrapper .dataTables_length select').addClass("input-sm"); // modify table per page dropdown

	jQuery('#YetKaydet').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();
        jQuery('#YetForm').submit();
	});

	jQuery('#HepSec').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();
        jQuery('.checkSM').prop('checked',true);
	});

	jQuery('#UnSec').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();
        jQuery('.checkSM').prop('checked',false);
	});
});
</script>