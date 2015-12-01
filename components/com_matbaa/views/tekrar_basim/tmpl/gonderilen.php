<?php
$data = $this->basilacak;
$basilacak = $data['basilacak'];
$KurBilgi = $data['KurBilgi'];
?>
<div class="anaDiv">
	<div class="divYan">
		<a href="index.php?option=com_matbaa&view=matbaa&layout=gonderilen" class="btn btn-xs btn-primary">Basılacak Belgeler</a>
	</div>
	<div class="divYan">
		<a href="#" class="btn btn-success">Tekrar Basılacak Belgeler</a>
	</div>
</div>
<div class="anaDiv text-center">
<?php echo $this->sayfaLink;?>
</div>
<div class="anaDiv">
<h2 class="hColor"><u>Tekrar Basılıp Gönderilen Belgeler</u></h2>
</div>
<div class="anaDiv">
<table id="TableGrid" class="display compact" style="width:100%;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED;" class="thPad5">
		<tr>
			<th width="2%">ID</th>
			<th width="20%">Belge No.</th>
			<th width="20%">Ad ve Soyad</th>
			<th width="8%">İstek Tarihi</th>
			<th width="8%">Basım Tarihi</th>
			<th width="8%">Gönderim Tarihi</th>
			<th width="20%">Kuruluş Adı</th>
			<th width="10%">Excel</th>
			<th width="10%">Kare Kod</th>
			<th width="10%">Durum</th>
			<th width="10%">Kargo Takip</th>
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
			<td align="center"><?php echo $row['BASIM_TARIHI'];?></td>
			<td align="center"><?php echo $row['GONDERIM_TARIHI'];?></td>
			<td align="center"><?php echo $row['BELGELENDIRME_KURULUSU'];?></td>
			<td align="center"><a href="index.php?option=com_matbaa&view=tekrar_basim&layout=matbaaBelge&basimId=<?php echo $row['BASIM_ID'];?>" target="_blank">İndir</a></td>
			<td align="center"><a href="index.php?option=com_matbaa&view=tekrar_basim&layout=zip&basimId=<?php echo $row['BASIM_ID'];?>" target="_blank">İndir</a></td>
			<td align="center">Gönderildi</td>
			<?php if($this->canEdit){ ?>
				<td align="center"><a target="_blank" href="http://www.yurticikargo.com/bilgi-servisleri/sayfalar/kargom-nerede.aspx?q=<?php echo $row['KARGONO'];?>"><?php echo $row['KARGONO'];?></a><br><button type="button" class="btn btn-xs btn-warning" onclick="takipDegistir(<?php echo $row['BASIM_ID']; ?>)">Değiştir</button></td>
			<?php 
			}else{?>
				<td align="center"><a target="_blank" href="http://www.yurticikargo.com/bilgi-servisleri/sayfalar/kargom-nerede.aspx?q=<?php echo $row['KARGONO'];?>"><?php echo $row['KARGONO'];?></a></td>
			<?php }?>
		</tr>
	<?php 
	}
	}
	?>
	</tbody>
</table>
</div>

<div id="yeniDis" style=" width: 300px; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h2>Kargo No Değiştir</h2><br>
	<input type="hidden" id="basimId" />
	<span class="font18 hColor">Kargo No: </span><input type="text" class="input-sm" id="kargono" />
	<br><br>
	<button id="takipNoKaydet" type="button" class="btn btn-xs btn-success">Kaydet</button><button id="takipNoIptal" type="button" class="btn btn-xs btn-danger">İptal</button>
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
			data:'kurId='+jQuery('#kurId').val()+'&yetId='+jQuery('#yetId').val()+'&durum=3',
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
						ekle += '<td align="center">'+vall['BASIM_TARIHI']+'</td>';
						ekle += '<td align="center">'+vall['GONDERIM_TARIHI']+'</td>';
						ekle += '<td align="center">'+vall['KURULUS_ADI']+'</td>';
						ekle += '<td align="center">'+vall['KURULUS_ADRESI']+'<br>'+vall['KURULUS_TELEFON']+'</td>';
						ekle += '<td align="center">'+adayCount[vall['MATBAA_ID']][0]['SAY']+'</td>';
						ekle += '<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=matbaaBelge&matbaaId='+vall['MATBAA_ID']+'" target="_blank">İndir</a></td>';
						ekle += '<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=zip&matbaaId='+vall['MATBAA_ID']+'" target="_blank">İndir</a></td>';
						ekle += '<td align="center">Gönderildi</td>';
						var urll = 'http://www.yurticikargo.com/bilgi-servisleri/sayfalar/kargom-nerede.aspx?q='+vall['KARGONO'];
						<?php if($this->canEdit){ ?>
						ekle += '<td align="center"><a href="'+urll+'" target="_blank">'+vall['KARGONO']+'</a><br><button onclick="takipDegistir('+vall['MATBAA_ID']+')">Değiştir</button></td>';
						<?php }else{?>
						ekle += '<td align="center"><a href="'+urll+'" target="_blank">'+vall['KARGONO']+'</a></td>';
						<?php }?>
						
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

	jQuery('#takipNoIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniDis').trigger('close');
	});

	jQuery('#takipNoKaydet').live('click',function(e){
		e.preventDefault();
		var basimId = jQuery('#yeniDis #basimId').val();
		var takipNo = jQuery('#yeniDis #kargono').val();

		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_matbaa&task=takipNoUpdateTekrar&format=raw",
			data:"basimId="+basimId+'&kargono='+takipNo,
			success:function(data){
				var dat = jQuery.parseJSON(data);
					if(dat){
						alert('Kargo Takip Numarası Başarıyla Düzenlendi.');
						window.location.reload();
					}else{
						alert('Lütfen tekrar deneyin.');
					}
				}
		});
	});
});

function takipDegistir(basimId){
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_matbaa&task=takipNoGetirTekrar&format=raw",
		data:"basimId="+basimId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
				if(dat){
					jQuery('#yeniDis').children('#basimId').val(basimId);
					jQuery('#yeniDis').children('#kargono').val(dat[0]['KARGONO']);
					jQuery('#yeniDis').lightbox_me({
			        	  centered: true,
			              closeClick:false,
			              closeEsc:false 
			        });
				}
			}
	});
}
</script>