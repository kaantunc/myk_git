<?php
$AskiKur = $this->AskiKur;
$BelKur = $this->BelKur;
$BelKurSelect = '<option value="0">Seçiniz</option>';
foreach($BelKur as $row){
	$BelKurSelect .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
echo $this->pageHeader;
?>

<div class="anaDiv text-center">
	<h2>Belgelendirme Kuruluşlarının Yetkilerini Askıya Alma Modülü</h2>
</div>
<form id="AskiForm" method="POST" action="index.php?option=com_belgelendirme_yetki&task=AskiyaAl" enctype="application/x-www-form-urlencoded">
<div class="anaDiv">	
	<div class="div20 font16 hColor">
		Kuruluşlar:
	</div>
	<div class="div80">
		<select name="kurulus" class="input-sm"><?php echo $BelKurSelect;?></select>
	</div>

</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Askı Tarihi:
	</div>
	<div class="div80">
		<input type="text" class="tarih input-sm" name="tarih" readonly="readonly" />
	</div>
</div>
</form>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" id="AskiyaAl">Askıya Al</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font18 hColor text-center">
	Yetkileri Askıya Alınmış Kuruluşlar
</div>
<div class="anaDiv">
<table width="100%" style="text-align:center;margin-bottom:10px;" border="1" id="TableGrid" class="display compact">
	<thead style="background-color:#71CEED;" class="thPad5">
		<tr>
			<th>Kurulus</th>
			<th>Askıya Alınma Tarihi</th>
			<th>Askıyı Kaldır</th>
		</tr>
	</thead>
	<tbody id="dekTbody" class="tdPad5">
		<?php 
		foreach($AskiKur as $row){
			echo '<tr>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$row['TARIH'].'</td>';
			echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="AskiKaldir('.$row['USER_ID'].')">Askıyı Kaldır</button></td>';
			echo '</tr>';
		}
		?>
	</tbody>
</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#TableGrid').dataTable({
// 		"aaSorting": [[ 2, "desc" ]],
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
	
	jQuery('#AskiyaAl').live('click',function(e){
		e.preventDefault();
		if(jQuery('select[name="kurulus"]').val() == 0){
			alert('Lütfen Kuruluş Seçiniz.');
		}else if(jQuery('input[name="tarih"]').val() == ''){
			alert('Lütfen Kuruluş Askıya Alınma tarihini giriniz.');
		}else{
			jQuery('#AskiForm').submit();
		}
	});

	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});
});
		
function AskiKaldir(kurId){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_belgelendirme_yetki&task=AskiyiGeriAl&format=raw",
		data:'kurId='+kurId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			alert('Kuruluşun aski işlemi kaldırıldı.');
			window.location.reload();
		}else{
			alert('Kuruluşun aski işlemi kaldırılma aşamasında bir hata meydana geldi. Lütfen tekrar deneyin.');
			window.location.reload();
		}
	});
}
</script>