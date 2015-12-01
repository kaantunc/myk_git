<?php
echo $this->pageTree;
?>

<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">Denetim ID</th>			
				<th width="25%">Kuruluş Adı</th>
				<th width="15%">Denetim Türü</th>
				<th width="15%">Denetim Rolü</th>
				<th width="15%">Görev Başlangıç Tarihi</th>
				<th width="10%">Görev Süresi(Gün)</th>
				<th width="10%">Denetim Raporu</th>
				<th width="10%">Denetim Raporu Onay</th>
			</tr>
		</thead>
		<tbody id="KursTbody" class="tdPad5 text-center">
		<?php 
		foreach($this->denetim as $row){
			echo '<tr>';
			echo '<td>'.$row['DENETIM_ID'].'</td>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$row['DENETIM_TURU_ACIKLAMA'].'</td>';
			echo '<td>'.$row['ROL_ADI'].'</td>';
			echo '<td>'.$row['BASLANGIC_TARIHI'].'</td>';
			echo '<td>'.$row['GOREVLENDIRILDIGI_GUN_SAYISI'].'</td>';
			if($row['DURUM'] == 1){
				echo '<td><a target="_blank" href="index.php?option=com_denetim&view=denetim&layout=raporpdf&format=pdf&denetim_id='.$row['DENETIM_ID'].'" class="btn btn-xs btn-danger">PDF</a></td>';
			}else{
				echo '<td></td>';
			}
			if(($row['ROL_ID'] == 1 || $row['ROL_ID'] == 2) && $row['DURUM'] == 1){
				if($row['ONAY'] == 0){
					echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncDenetimRoparOnayla('.$row['DENETIM_ID'].','.$this->evrak_id.')">Onayla</button></td>';
				}else{
					echo '<td class="bg-success font16 text-white">Onaylandı</td>';
				}
			}else{
				echo '<td></td>';
			}
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>

<script>
jQuery(document).ready(function(){
	jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
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

function FuncDenetimRoparOnayla(dId,uId){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_uzman_basvur&task=ajaxDenetimRaporOnayla&format=raw",
		data:'dId='+dId+'&uId='+uId
	}).done(function(data){
		window.location.reload();
	});
}
</script>