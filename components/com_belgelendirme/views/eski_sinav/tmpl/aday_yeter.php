<?php
$yetBirims = $this->yetBirims;
$birims = $yetBirims[0];
$birimTurs = $yetBirims[1];
$basBirims = $this->basBirims;
$kurulus = $this->kurulus;
$yeterlilik = $this->yeterlilik;
$aday = $this->aday;

$kurSelect = '<option value="0">Seçiniz</option>';
foreach($kurulus as $key=>$val){
	$kurSelect .= '<option value="'.$key.'">'.$val['KURULUS_ADI'].'</option>';
}
?>
<style>
.anaDiv{
width: 100%;
padding:15px 15px;
}
.leftDiv{
width:20%;
float:left;
}
.rightDiv{
width:80%;
float:right;
}
</style>

<div class="anaDiv">
<h2><?php echo $yeterlilik['YETERLILIK_KODU'].'/'.$yeterlilik['REVIZYON'].' '.$yeterlilik['YETERLILIK_ADI'];?></h2>
</div>

<div class="anaDiv">
<div class="leftDiv"><h3>Aday Kimlik No:</h3></div>
<div class="rightDiv"><?php echo $aday[0]['TC_KIMLIK'];?></div>
</div>

<div class="anaDiv">
<div class="leftDiv"><h3>Aday Adı ve Soyadı:</h3></div>
<div class="rightDiv"><?php echo $aday[0]['ADI'].' '.$aday[0]['SOYADI'];?></div>
</div>

<form method="post" action="index.php?option=com_belgelendirme&view=eski_sinav&task=eskiSinavBirimKaydet" enctype="multipart/form-data">
<input type="hidden" name="kimlik" value="<?php echo $aday[0]['TC_KIMLIK'];?>"/>
<input type="hidden" name="yeterlilik" value="<?php echo $yeterlilik['YETERLILIK_ID'];?>"/>

<?php foreach($birims as $key=>$val){ ?>
<div class="anaDiv">
<h3><?php echo $val['KODU'];?></h3>
<table style="width:97%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="5%">Birim Türü</th>
			<th width="10%">Sınav Tarihi</th>
			<th width="10%">Puan</th>
			<th width="55%">Kuruluş</th>
			<th width="10%">Düzenle</th>
			<th width="10%">Sil</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($birimTurs[$key] as $key2=>$val2){?>
		<tr>
			<td><?php echo $key2;?></td>
			<?php if(array_key_exists($key, $basBirims)){
				if(array_key_exists($key2, $basBirims[$key])){
					echo '<td>'.$basBirims[$key][$key2]['SINAV_TARIHI'].'</td>';
					echo '<td>'.$basBirims[$key][$key2]['PUAN'].'</td>';
					echo '<td>'.$kurulus[$basBirims[$key][$key2]['KURULUS_ID']]['KURULUS_ADI'].'</td>';
					if($basBirims[$key][$key2]['ESKI_MI'] == 1){
						echo '<td><input type="button" value="Düzenle" onclick="basBirimTurGetir('.$basBirims[$key][$key2]['BILDIRIM_ID'].')"/></td>';
						echo '<td><input type="button" value="Sil" onclick="basBirimTurSil('.$basBirims[$key][$key2]['BILDIRIM_ID'].')"/></td>';
					}else{
						echo '<td></td><td></td>';
					}
					
				}else{?>
				<td><input style="width: 100%" class="tarih" type="text" name="tarih[<?php echo $key;?>][<?php echo $key2;?>]"/></td>
				<td><input style="width: 100%" type="text" name="puan[<?php echo $key;?>][<?php echo $key2;?>]"/></td>
				<td><select style="width: 100%" name="kurulus[<?php echo $key;?>][<?php echo $key2;?>]"><?php echo $kurSelect;?></select></td>
				<td></td>
				<td></td>
			<?php }					
			}else{?>
				<td><input style="width: 100%" class="tarih" type="text" name="tarih[<?php echo $key;?>][<?php echo $key2;?>]"/></td>
				<td><input style="width: 100%" type="text" name="puan[<?php echo $key;?>][<?php echo $key2;?>]"/></td>
				<td><select style="width: 100%" name="kurulus[<?php echo $key;?>][<?php echo $key2;?>]"><?php echo $kurSelect;?></select></td>
				<td></td>
				<td></td>
			<?php }?>
		</tr>
	<?php }?>
	</tbody>
</table>
</div>	
<?php }?>
<input type="submit" value="Kaydet"/>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
// 	jQuery('#adayGonderilen').lightbox_me({
//     	  centered: true,
//           closeClick:false,
//           closeEsc:false  
//       });
	
	jQuery('.tarih').live('hover',function(e){
	    e.preventDefault();
	    jQuery(this).datepicker({
	        changeYear: true,
	        changeMonth: true,
	        dateFormat: 'dd/mm/yy'
	    });
	});

	jQuery('#updateKaydet').live('click',function(e){
		e.preventDefault();
		if(jQuery('#upTarih').val() == ''){
			alert('Lütfen tarih alanını boş bırakmayınız.');
		}
		else if(jQuery('#upPuan').val() == ''){
			alert('Lütfen puan alanını boş bırakmayınız.');
		}
		else if(jQuery('#upKurulus').val() == 0){
			alert('Lütfen bir kuruluş seçiniz.');
		}
		else{
			jQuery('#loaderGif').lightbox_me({
		    	  centered: true,
		          closeClick:false,
		          closeEsc:false  
		    });
			jQuery('#BirimTurUpdate').submit();
		}
	});

	jQuery('#updateIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#BirimDuzDiv').trigger('close');
		jQuery('#birimDuzKodu').html('');
		jQuery('#birimTurDuzTbody').html('');
		jQuery('#bildirimId').val('');
	});
});

function basBirimTurSil(bildirimId){
	if(confirm('Bu birim türünü silmek istediğinizden emin misiniz?')){
		jQuery('#loaderGif').lightbox_me({
	    	  centered: true,
	          closeClick:false,
	          closeEsc:false  
	    });
		jQuery.ajax({
			async:false,
			type:'POST',
			url:'index.php?option=com_belgelendirme&task=eskiSinavBirimSil&format=raw',
			data:'bildirimId='+bildirimId,
			success:function(data){
				window.location.href='index.php?option=com_belgelendirme&view=eski_sinav&layout=aday_yeter&Kimlik=<?php echo $aday[0]['TC_KIMLIK'];?>&yetSelect=<?php echo $yeterlilik['YETERLILIK_ID'];?>';
			}
		});
	}
}

function basBirimTurGetir(bildirimId){
	
	jQuery.ajax({
		async:false,
		type:'POST',
		url:'index.php?option=com_belgelendirme&task=eskiSinavBirimTurGetir&format=raw',
		data:'bildirimId='+bildirimId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var birimTur = dat[0];
				var birimKod = dat[1];
				jQuery('#birimDuzKodu').html(birimKod['BIRIM_KODU']);
				jQuery('#bildirimId').val(bildirimId);
				var ekle ='<tr><td>'+birimTur['SINAV_TURU_KODU']+'</td>';
				ekle += '<td><input type="text" id="upTarih" name="tarih" class="tarih" value="'+birimTur['SINAV_TARIHI']+'"/></td>';
				ekle += '<td><input type="text" id="upPuan" name="puan" value="'+birimTur['PUAN']+'"/></td>';
				ekle += '<td><select name="kurulus" id="upKurulus" ><?php echo $kurSelect;?></select></td>';
				ekle += '</tr>';

				jQuery('#birimTurDuzTbody').append(ekle);

				jQuery('#upKurulus').val(birimTur['KURULUS_ID']);
				
				jQuery('#BirimDuzDiv').lightbox_me({
				  	  centered: true,
				        closeClick:false,
				        closeEsc:false  
				 });
			}else{
				alert('Bir hata meydana geldi. Sayfayı yenileyip, tekrar deneyiniz.');
			}
		}
	});
}
</script>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="BirimDuzDiv" style="width: 90%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
<form id="BirimTurUpdate" method="post" action="index.php?option=com_belgelendirme&task=eskiSinavBirimUpdate" enctype="multipart/form-data">
<input type="hidden" name="bildirimId" id="bildirimId"/>
<div class="anaDiv">
<h3 id="birimDuzKodu"></h3>
<table style="width:97%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="5%">Birim Türü</th>
			<th width="10%">Sınav Tarihi</th>
			<th width="10%">Puan</th>
			<th width="55%">Kuruluş</th>
		</tr>
	</thead>
	<tbody id="birimTurDuzTbody">
	</tbody>
</table>
</div>
<input type="button" id="updateKaydet" value="Kaydet" />
<input type="button" id="updateIptal" value="İptal" />
</form>
</div>
