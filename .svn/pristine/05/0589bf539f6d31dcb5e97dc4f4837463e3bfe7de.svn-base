<?php
$data = $this->basilacak;
$basilacak = $data['basilacak'];
$KurBilgi = $data['KurBilgi'];

$kurs = $this->getKur;
$kurulus = '<option value="0">Seçiniz</option>';
foreach($kurs as $row){
	if(!empty($kurs['KUR_AD'])){
		$kurulus .= '<option value="'.$row['USER_ID'].'">'.$row['KUR_AD'].'</option>';
	}else{
		$kurulus .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
	}
}
?>
<div class="anaDiv">
	<div class="divYan">
		<a href="index.php?option=com_matbaa&view=matbaa&layout=basilacak" class="btn btn-xs btn-primary">Basılacak Belgeler</a>
	</div>
	<div class="divYan">
		<a href="#" class="btn btn-success">Tekrar Basılacak Belgeler</a>
	</div>
</div>
<div class="anaDiv text-center">
<?php echo $this->sayfaLink;?>
</div>
<div class="anaDiv">
<h2 class="hColor"><u>Tekrar Basılıcak Belgeler</u></h2>
</div>
<?php
if(!$this->kurulusMu && count($basilacak)>0){
?>
<!-- <div class="anaDiv"> -->
<!-- 	<div class="div20 hColor font16"> -->
<!-- 		Kuruluş: -->
<!-- 	</div> -->
<!-- 	<div class="div80"> -->
<!-- 		<select id="kurId" class="input-sm"></select> -->
<!-- 	</div> -->
<!-- </div> -->
<!-- <div class="anaDiv"> -->
<!-- 	<div class="div20 hColor font16"> -->
<!-- 		Yeterlilik: -->
<!-- 	</div> -->
<!-- 	<div class="div80"> -->
<!-- 		<select id="yetId" class="input-sm"></select> -->
<!-- 	</div> -->
<!-- </div> -->
<!-- <div class="anaDiv"> -->
<!-- 	<button type="button" class="btn btn-xs btn-success" id="araBut">Getir</button> -->
<!-- </div> -->
<?php 	
}
?>
<div class="anaDiv">
<table id="TableGrid" class="display compact" style="width:100%;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED;" class="thPad5">
		<tr>
			<th width="2%">ID</th>
			<th width="20%">Belge No.</th>
			<th width="20%">Ad ve Soyad</th>
			<th width="8%">İstek Tarihi</th>
			<th width="20%">Kuruluş Adı</th>
			<th width="10%">Excel</th>
			<th width="10%">Kare Kod</th>
			<th width="10%">Durum</th>
		</tr>
	</thead>
	<tbody id="basilacakTbody" class="tdPad5">
	<?php 
	$say = 1;
	if(count($basilacak)>0){
	foreach ($basilacak as $row){
		if($say%2==0){
			$bcolor = 'bgcolor="#efefef"';
		}else{
			$bcolor = 'bgcolor="#ffffff"';
		}
		$say++;
	?>
		<tr <?php echo $bcolor;?>>
			<td align="center"><?php echo $row['BASIM_ID'];?></td>
			<td align="center"><?php echo $row['BELGENO'];?></td>
			<td align="center"><?php echo $row['AD'].' '.$row['SOYAD'];?></td>
			<td align="center"><?php echo $row['ISTEK_TARIHI'];?></td>
			<td align="center"><?php echo $row['BELGELENDIRME_KURULUSU'];?></td>
			<td align="center"><a href="index.php?option=com_matbaa&view=tekrar_basim&layout=matbaaBelge&basimId=<?php echo $row['BASIM_ID'];?>" target="_blank">İndir</a></td>
			<td align="center"><a href="index.php?option=com_matbaa&view=tekrar_basim&layout=zip&basimId=<?php echo $row['BASIM_ID'];?>" target="_blank">İndir</a></td>
			<?php 
			if(!$this->canEdit){
				echo '<td align="center">Basılıyor</td>';
			}else{
			?>
			<td align="center"><button type="button" class="btn btn-xs btn-warning" onclick="durumBasildi(<?php echo $row['BASIM_ID'];?>)">Bas</button></td>
			<?php }?>
		</tr>
	<?php 
	}
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
	
	jQuery('#araBut').live('click',function(){
		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_matbaa&task=SearchMatbaa&format=raw",
			data:'kurId='+jQuery('#kurId').val()+'&yetId='+jQuery('#yetId').val()+'&durum=1',
			success:function(data){
				var pat = jQuery.parseJSON(data);
				var dat = pat[0];
				var adayCount = pat[1];
				if(dat){
					var ekle='';
					var say = 1;
					jQuery.each(dat,function(key,vall){
						if(say%2==0){
							var bcolor = 'bgcolor="#efefef"';
						}else{
							var bcolor = 'bgcolor="#ffffff"';
						}
						say++;

						ekle += '<tr '+bcolor+'>';
						ekle += '<td align="center">'+vall['MATBAA_ID']+'</td>';
						ekle += '<td align="center">'+vall['YETERLILIK_KODU']+'/'+vall['REVIZYON']+' '+vall['YETERLILIK_ADI']+'</td>';
						ekle += '<td align="center">'+vall['SINAV_TARIHI']+'</td>';
						ekle += '<td align="center">'+vall['ISTEK_TARIHI']+'</td>';
						ekle += '<td align="center">'+vall['KURULUS_ADI']+'</td>';
						ekle += '<td align="center">'+vall['KURULUS_ADRESI']+'<br>'+vall['KURULUS_TELEFON']+'</td>';
						ekle += '<td align="center">'+adayCount[vall['MATBAA_ID']][0]['SAY']+'</td>';
						ekle += '<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=matbaaBelge&matbaaId='+vall['MATBAA_ID']+'" target="_blank">İndir</a></td>';
						ekle += '<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=zip&matbaaId='+vall['MATBAA_ID']+'" target="_blank">İndir</a></td>';
						<?php if($this->canEdit){?>
							ekle += '<td align="center"><button type="button" onclick="durumBasildi('+vall['MATBAA_ID']+')">Bas</button></td>';
						<?php }
						else {
						?>
							ekle += '<td align="center">Basılıyor</td>';
						<?php 
						}?>
						
						ekle += '</tr>';
					});

					jQuery('#basilacakTbody').html(ekle);
				}
				else{
					alert('Arama kriterlerine uygun sonuç bulunamadı.')
				}
			}
		});
	});
});

function durumBasildi(basimId){
	jQuery.ajax({
		type:"POST",
		url:"index.php?option=com_matbaa&task=TekrarBelgeDurum&format=raw",
		data:'durum=2&basimId='+basimId,
		success:function(data){
			window.location.reload();
			}
	});
}
</script>
