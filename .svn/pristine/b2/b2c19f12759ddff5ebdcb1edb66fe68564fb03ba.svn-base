<?php
$kurulus = $this->kurulus_bilgi;
$yetkiYeterlilik = $this->yetkiliYet;
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<style>
<!--
#tBodyYet td{
	padding:10px;
}
-->
</style>
<div style="width:100%;display: inline-block;">

<table style="margin-bottom:10px; margin-top:20px; width:100%" border="1" id="yetkiTable">
	<thead style="background-color:#71CEED;text-align:center;">
		<tr>
			<th width="10%">#</th>
			<th width="70%">Yeterlilik</th>
			<th width="20%">Birimler</th>
		</tr>
	</thead>
	<tbody id="tBodyYet">
	<?php
	$say = 1;
	$bgcolor = 'bgcolor="#efefef"'; 
	foreach ($yetkiYeterlilik as $yet){
		if($say%2 == 0){
			echo '<tr '.$bgcolor.'>';
		}else{
			echo '<tr>';
		}
		
		echo '<td>'.$say.'</td>';
		echo '<td>';
		echo trim($yet['YETERLILIK_KODU']).'/'.$yet['REVIZYON'].' - '.$yet['YETERLILIK_ADI'];
		echo '</td>';
		
		echo '<td align="center"><button type="button" class="btn btn-xs btn-info" onclick="getBirims('.$yet['YETERLILIK_ID'].')" >Birimler</button></td>';
		
		$say++;
	}
	?>
	</tbody>
</table>
</div>
<div style="display: inline-block; margin-top:5px;">
<?php echo $this->geriLink;?>
</div>

<div id="YetkiBirim" style=" min-width: 50%; max-height:500px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
    
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#yetkiTable').dataTable({
		"aaSorting": [[ 0, "asc" ]],
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
});
function getBirims(yetId){
	jQuery('#YetkiBirim').html('');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_profile&task=YetkiliBirims&format=raw",
		data:"yetId="+yetId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var ekle = '<h2><u>'+dat[0]['YETERLILIK_KODU']+' '+dat[0]['YETERLILIK_ADI']+'</u></h2><br>';
				ekle += '<table style="margin-bottom:10px; margin-top:10px; width:100%" border="1">'
						+'<thead style="background-color:#71CEED">'
					+'<tr>'
						+'<th width="10%">#</th>'
						+'<th width="70%">Yeterlilik</th>'
						+'<th width="20%">Yetki Tarihi</th>'
					+'</tr>'
				+'</thead>'
				+'<tbody>';
				var say = 1;
				jQuery.each(dat[1],function(key,vall){
					if(say%2 == 0){
						ekle += '<tr bgcolor="#efefef">';
					}else{
						ekle += '<tr>';
					}
					ekle+='<td align="center">'+say+'</td>';
					if(dat[0]['YENI_MI'] == 0){
						ekle += '<td>'+dat[0]['YETERLILIK_KODU']+'/'+vall['BIRIM_KODU']+' - '+vall['BIRIM_ADI']+'</td>';
					}
					else{
						ekle += '<td>'+vall['BIRIM_KODU']+' - '+vall['BIRIM_ADI']+'</td>';
					}
					ekle+='<td align="center">'+vall['TARIH']+'</td>';
					ekle+='</tr>';
					say++;
				});

				jQuery('#YetkiBirim').html(ekle);
				
	             jQuery('#YetkiBirim').lightbox_me({
	           	  	centered: true,
	             });
			}
		}
	});
}
</script>