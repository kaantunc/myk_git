<?php
$SBkurulus = $this->AllSBKurulus;
$SBkuruluslar = '<option value="0">Seçiniz</option>';
foreach($SBkurulus as $row){
	$SBkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$ProKur = $this->ProKur;
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
	<thead style="text-align:center;background-color:#71CEED" class="thPad5">
		<tr>
			<th width="10%">ID</th>
			<th width="50%">Kuruluş</th>
			<th width="10%">Protokol</th>
			<th width="20%">Hibe</th>
			<th width="10%">Düzenle</th>
		</tr>
	</thead>
	<tbody class="text-center fontBold tdPad5">
	<?php foreach($ProKur as $row){
		echo '<tr>';
		echo '<td>'.$row['USER_ID'].'</td>';
		echo '<td>'.$row['KURULUS_ADI'].'</td>';
        echo '<td>'.$row['PRO_TARIH'].'</td>';

		if(!empty($row['UCRET'])){
			echo '<td>'.Hesapla($row['UCRET']).' €</td>';
			$topHibe += UcretDuzenle($row['UCRET']);
		}else{
			echo '<td class="text-warning">0</td>';
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
<div class="anaDiv">
    <hr>
</div>
<div class="anaDiv text-center font20 fontBold hColor">
    AB Protokolü İmzalanmamış Kuruluşlar
</div>
<div class="anaDiv">
    <div class="div30 font16 fontBold hColor">
        Kuruluşlar:
    </div>
    <div class="div70">
        <select id="selectKur" class="input-sm"><?php echo $SBkuruluslar; ?></select>
    </div>
</div>
<div class="anaDiv">
    <button type="button" class="btn btn-sm btn-success" id="ProEkle">Yeni Protokol Ekle</button>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	/*var oTables = jQuery('#kurTable').dataTable({
		"aaSorting": [[ 3, "desc" ]],
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
	});*/

    jQuery('#ProEkle').live('click',function(e){
        e.preventDefault();
        if(jQuery('#selectKur').val() == 0){
            alert('Lütfen Protokol Eklemek İstediğiniz Kuruluş Seçiniz.');
        }else{
            window.location.href = "index.php?option=com_profile&view=abuzman&layout=abdonem&kId="+jQuery('#selectKur').val();
        }
    });
});
</script>