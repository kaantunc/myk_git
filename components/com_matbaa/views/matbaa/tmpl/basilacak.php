<div class="anaDiv">
	<div class="divYan">
		<a href="#" class="btn btn-success">Basılacak Belgeler</a>
	</div>
	<div class="divYan">
		<a href="index.php?option=com_matbaa&view=tekrar_basim&layout=basilacak" class="btn btn-xs btn-primary">Tekrar Basılacak Belgeler</a>
	</div>
</div>
<div class="anaDiv text-center">
	<?php
	echo $this->sayfaLink;
	?>
</div>
<?php
$basilacak = $this->basilacak[0];
$adayCount = $this->basilacak[1];

$kurs = $this->getKur;
$kurulus = '<option value="0">Seçiniz</option>';
foreach($kurs as $row){
	if(!empty($kurs['KUR_AD'])){
		$kurulus .= '<option value="'.$row['USER_ID'].'">'.$row['KUR_AD'].'</option>';
	}else{
		$kurulus .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
	}
}
$yets = $this->getYet;
$yeterlilik = '<option value="0">Seçiniz</option>';
foreach ($yets as $cow){
	$yeterlilik .= '<option value="'.$cow['YETERLILIK_ID'].'">'.$cow['YETERLILIK_KODU'].'/'.$cow['REVIZYON'].' '.$cow['YETERLILIK_ADI'].'</option>';
}

if(!$this->kurulusMu && count($basilacak)>0){
?>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Kuruluş:
	</div>
	<div class="div80">
		<select class="input-sm inputW100" id="kurId"><?php echo $kurulus;?></select>
	</div>
</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Yeterlilik:
	</div>
	<div class="div80">
		<select class="input-sm inputW100" id="yetId"><?php echo $yeterlilik;?></select>
	</div>
</div>
<div class="anaDiv text-center">
	<button type="button" class="btn btn-success" id="araBut"><i class="fa fa-search"></i> Getir</button>
</div>
<?php 	
}
?>

<div class="anaDiv">
<table style="width:100%;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="2%">Basım ID</th>
			<th width="2%">Sınav ID</th>
			<th width="30%">Yeterlilik</th>
			<th width="8%">İstek Tarihi</th>
			<th width="20%">Kuruluş Adı</th>
			<th width="25%">Kuruluş Adres</th>
			<th width="10%">Aday Sayısı</th>
			<?php //if($this->canEdit){?>
			<th width="10%">Excel</th>
			<th width="10%">Kare Kod</th>
			<?php //}?>
			<th width="10%">Durum</th>
		</tr>
	</thead>
	<tbody id="basilacakTbody">
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
			<td align="center"><?php echo $row['MATBAA_ID'];?></td>
			<td align="center"><?php echo $row['SINAV_ID'];?></td>
			<td align="center"><?php echo $row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'];?></td>
			<td align="center"><?php echo $row['ISTEK_TARIHI'];?></td>
			<?php if(!empty($row['KUR_AD'])){?>
				<td align="center"><?php echo $row['KUR_AD'];?></td>
				<td align="center"><?php echo $row['KUR_ADRES'].'<br>'.$row['KUR_TELEFON']?></td>
			<?php }else{ ?>
			<td align="center"><?php echo $row['KURULUS_ADI'];?></td>
			<td align="center"><?php echo $row['KURULUS_ADRESI'].'<br>'.$row['KURULUS_TELEFON']?></td>
			<?php }?>
			<td align="center"><?php echo $adayCount[$row['MATBAA_ID']][0]['SAY'];?></td>
			<?php //if($this->canEdit){?>
			<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=matbaaBelge&matbaaId=<?php echo $row['MATBAA_ID'];?>" target="_blank">İndir</a></td>
			<td align="center"><a href="index.php?option=com_matbaa&view=matbaa&layout=zip&matbaaId=<?php echo $row['MATBAA_ID'];?>" target="_blank">İndir</a></td>
			<?php 
			//}
			if(!$this->canEdit){
				echo '<td align="center">Basılıyor</td>';
			}else{
			?>
			<td align="center"><button type="button" onclick="durumBasildi(<?php echo $row['MATBAA_ID'];?>)">Bas</button></td>
			<?php }?>
		</tr>
	<?php 
	}
	}
	else{
		if($this->canEdit){
			echo '<tr><td align="center" colspan="9" style="color:red"><strong>Basılacak Belge Bulunmamaktadır.</strong></td></tr>';
		}else{
			echo '<tr><td align="center" colspan="7" style="color:red"><strong>Basılacak Belge Bulunmamaktadır.</strong></td></tr>';
		}
		
	}
	?>
	</tbody>
</table>
</div>

<script type="text/javascript">
function durumBasildi(matbaaId){
	jQuery.ajax({
		type:"POST",
		url:"index.php?option=com_matbaa&task=BelgeDurum&format=raw",
		data:'durum=2&matbaaId='+matbaaId,
		success:function(data){
			window.location.reload();
			}
	});
}

jQuery(document).ready(function(){
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
						ekle += '<td align="center">'+vall['SINAV_ID']+'</td>';
						ekle += '<td align="center">'+vall['YETERLILIK_KODU']+'/'+vall['REVIZYON']+' '+vall['YETERLILIK_ADI']+'</td>';
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
</script>
