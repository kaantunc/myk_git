<?php
$kurulus = $this->kurulus_bilgi;
$basvuruTip = $this->basvuruTip;
$basvurular = $this->basvurular;
// $tips = '<option value="0">Seçiniz</option>';
// foreach($basvuruTip as $row){
// 	$tips .= '<option value="'.$row['BASVURU_TIP_ID'].'">'.$row['BASVURU_TIP_ADI'].'</option>';
// }
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<!-- <div style="width: 100%;display:inline-block;">
<div style="float: left;width:20%"><h2>Başvuru Tipi</h2></div>
<div style="float: right;width:80%">
	<select id="basvuruTip">
		<option value="0" selected="selected">Seçiniz</option>
		<option value="1">Meslek Standardı Hazırlama Başvurusu </option>
		<option value="2">Yeterlilik Hazırlama Başvurusu </option>
		<option value="3">Sınav ve Belgelendirme Başvurusu </option>
		<option value="4">Akreditasyon Başvurusu </option>
	</select>
	<button id="basvuruGetir">Getir</button>
</div>
</div> -->

<table id="sinavListesiGrid" class="display compact" style="text-align:center;margin-bottom:10px; margin-top:20px; width:100%" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">#</th>
			<th width="10%">Evrak ID</th>
			<th width="10%">Başvuru Tarihi</th>
			<th width="15%">Başvuru Tipi</th>
			<th width="15%">Başvuru Durumu</th>
			<?php if($this->canEdit){?>
			<th width="15%">Başvuru Durum Güncelle</th>
			<th width="15%">Başvuru Düzenle</th>
			<?php }else{?>
			<th width="20%">Başvuru İncele</th>
			<?php }?>
		</tr>
	</thead>
	<tbody id="basvurular">
	<?php
	$say = 1;
	foreach ($basvurular as $row){
		if($row['BASVURU_TIP_ID'] == 1){
			$option = 'com_meslek_std_basvur';
			$layout = 'basvuru_yeni';
		}
		else if($row['BASVURU_TIP_ID'] == 2){
			$option = 'com_yeterlilik_basvur';
			$layout = 'basvuru_yeni';
		}
		else if($row['BASVURU_TIP_ID'] == 3){
			$option = 'com_belgelendirme_basvur';
			$layout = 'kurulus_bilgi';
		}
		else if($row['BASVURU_TIP_ID'] == 4){
			$option = 'com_akreditasyon_basvur';
			$layout = 'kurulus_bilgi';
		}
		
		echo '<tr>';
		echo '<td>'.$say.'</td>';
		echo '<td>'.$row['EVRAK_ID'].'</td>';
		echo '<td>'.tarihGenerate($row['BASVURU_TARIHI']).'</td>';
		echo '<td>'.$row['BASVURU_TIP_ADI'].'</td>';
		echo '<td>'.$row['BASVURU_DURUM_ADI'].'</td>';
		if($this->canEdit){
			echo '<td><a href="index.php?option=com_basvuru_ara&gorev=guncelleGoster&id='.$row['EVRAK_ID'].'" target="_blank">Güncelle</a></td>';
			echo '<td><a href="index.php?option='.$option.'&layout='.$layout.'&evrak_id='.$row['EVRAK_ID'].'" target="_blank">İncele</a></td>';
		}else{
			echo '<td><a href="index.php?option='.$option.'&layout='.$layout.'&evrak_id='.$row['EVRAK_ID'].'" target="_blank">İncele</a></td>';
		}
		echo '</tr>';
		$say++;
	}
	?>
	</tbody>
</table>
<?php echo $this->geriLink;?>
<?php 
function tarihGenerate($tarih){
	$date = explode(' ', $tarih);
	return $date[0];
}
?>
<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery('#sinavListesiGrid').dataTable({
// 		"aaSorting": [[ 2, "desc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "Sonuç Yok",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
		});	
	
	jQuery('#basvuruGetir').live('click',function(){
		var tip = jQuery('#basvuruTip').val();
		jQuery('#basvurular').closest('table').hide();
		if(tip == 0){
			alert('Lütfen Başvuru Tipi Seçiniz.');
		}else{
			jQuery.ajax({
				asycn:false,
				type:"POST",
				url:"index.php?option=com_profile&task=BasvuruGetir&format=raw",
				data:'tip='+tip+'&kurulusId=',
				success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat){
						var basvurular = '';
						var option = '';
						if(tip==1){
							option = 'com_meslek_std_basvur';
						}else if(tip==2){
							option = 'com_yeterlilik_basvur';
						}else if(tip==3){
							option = 'com_belgelendirme_basvur';
						}else if(tip == 4){
							option = 'com_akreditasyon_basvur';
						}
						
						var say = 1;
						var bgcolor="#efefef";
						jQuery.each(dat,function(key,vall){
							if(say%2 == 0){
								basvurular += '<tr bgcolor="'+bgcolor+'">';
							}else{
								basvurular += '<tr>';
							}

							basvurular += '<td>'+say+'</td>';
							basvurular += '<td>'+vall['EVRAK_ID']+'</td>';
							basvurular += '<td>'+tarihGenerate(vall['BASVURU_TARIHI'])+'</td>';
							basvurular += '<td>'+vall['BASVURU_TIP_ADI']+'</td>';
							basvurular += '<td>'+vall['BASVURU_DURUM_ADI']+'</td>';
							<?php if($this->canEdit){?>
							basvurular += '<td><a href="index.php?option=com_basvuru_ara&gorev=guncelleGoster&id='+vall['EVRAK_ID']+'" target="_blank">Güncelle</a></td>';
							basvurular += '<td><a href="index.php?option='+option+'&layout=kurulus_bilgi&evrak_id='+vall['EVRAK_ID']+'" target="_blank">İncele</a></td>';
							<?php }else{?>
							basvurular += '<td><a href="index.php?option='+option+'&layout=kurulus_bilgi&evrak_id='+vall['EVRAK_ID']+'" target="_blank">İncele</a></td>';
							<?php }?>
							basvurular += '</tr>';
							say++;
						});

						jQuery('#basvurular').html(basvurular);
						jQuery('#basvurular').closest('table').show();
						
					}else{
						alert('Seçmiş olduğunuz başvuru tipine göre başvuru bulunmamaktadır.');
					}
				}
			});
		}
	});
});

function tarihGenerate(tarih){
	var date = tarih.split(' ');
	return date[0];
}
</script>