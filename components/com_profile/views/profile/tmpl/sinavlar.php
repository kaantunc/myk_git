<?php
$kurulus = $this->kurulus_bilgi;
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php 
echo $this->sayfaLink;
echo $this->tipLink;

$sinavlar = $this->sinavlar;
$sinavTipi = $this->sinavTipi;

if($sinavTipi == 1){
?>
<table id="sinavListesiTable" class="display compact" width="100%" style="text-align:center" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th class="sortable" width="5%">Sınav ID</th>
			<th class="sortable-text" width="30%">Yeterlilik</th>
			<th class="sortable-date-dmy" width="10%">Sınav Tarihi</th>
			<th class="sortable-text" width="10%">Sınav Yeri</th>
			<th class="sortable-text" width="10%">Sınav Değerlendirici</th>
			<th class="sortable-text" width="10%">Adaylar</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$say = 0;
	foreach($sinavlar as $row){
		if($say%2==0){
			echo '<tr bgcolor="#efefef">';
		}else{
			echo '<tr bgcolor="#ffffff">';
		}
	
		echo '<td>'.$row['SINAV_ID'].'</td>';
		if(strlen($row['REVIZYON_NO'])>0 && $row['REVIZYON_DURUMU']==1){
			echo '<td>'.$row['YETERLILIK_REV_KOD'].'/'.$row['REVIZYON_NO'].' - '.$row['YETERLILIK_ADI'].'</td>';
		}else{
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' - '.$row['YETERLILIK_ADI'].'</td>';
		}
		echo '<td>'.$row['BASLANGIC_TARIHI'].'</td>';
		echo '<td><button type="button" class="btn btn-xs btn-info" onclick="sinavYeriGetir('.$row['SINAV_ID'].')">Sınav Yeri</button></td>';
		echo '<td><button type="button" class="btn btn-xs btn-info" onclick="sinavDegerlendiriciGetir('.$row['SINAV_ID'].')">Değerlendirici</button></td>';
		echo '<td><button type="button" class="btn btn-xs btn-info" onclick="sinavAdayGetir('.$row['SINAV_ID'].')">Aday Exceli</button></td>';
		echo '</tr>';
		$say++;
	}
	?>
	</tbody>
</table>
<?php	
}
else if($sinavTipi == 2){
?>
<table id="sinavListesiTable" class="display compact" width="100%" style="text-align:center" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th class="sortable" width="5%">Sınav ID</th>
			<th class="sortable-text" width="25%">Yeterlilik</th>
			<th class="sortable-date-dmy" width="10%">Sınav Tarihi</th>
			<th class="sortable-text" width="15%">Aday Dosyası</th>
			<?php if($this->canEdit){?>
			<th class="sortable-text" width="20%">Aday Dosyası Yükle</th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
	<?php 
	$say = 0;
	foreach($sinavlar as $row){
		if($say%2==0){
			echo '<tr bgcolor="#efefef">';
		}else{
			echo '<tr bgcolor="#ffffff">';
		}
	
		echo '<td>'.$row['SINAV_ID'].'</td>';
		if(strlen($row['REVIZYON_NO'])>0 && $row['REVIZYON_DURUMU']==1){
			echo '<td>'.$row['YETERLILIK_REV_KOD'].'/'.$row['REVIZYON_NO'].' - '.$row['YETERLILIK_ADI'].'</td>';
		}else{
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' - '.$row['YETERLILIK_ADI'].'</td>';	
		}
		echo '<td>'.$row['BASLANGIC_TARIHI'].'</td>';
		echo '<td><button type="button" class="btn btn-xs btn-info" onclick="adayDosyasi('.$row['SINAV_ID'].')">Aday Dosyası</button></td>';
		if($this->canEdit){
			$urlpath = "window.open('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav=".$row['SINAV_ID']."')";
			echo '<td><button type="button" class="btn btn-xs btn-info" onclick="'.$urlpath.'">Aday Dosyası Yükle</button></td>';	
		}
		echo '</tr>';
		$say++;
	}
	?>
	</tbody>
</table>
<?php 	
}
else if($sinavTipi == 3){
?>
<table id="sinavListesiTable" class="display compact" width="100%" style="text-align:center" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th class="sortable" width="5%">Sınav ID</th>
			<th class="sortable-text" width="30%">Yeterlilik</th>
			<th class="sortable-date-dmy" width="10%">Sınav Tarihi</th>
			<?php if($this->canEdit){?>
			<th class="sortable-text" width="20%">Aday Dosyası Yükle</th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
	<?php
	$say = 0;
	foreach($sinavlar as $row){
		if($say%2==0){
			echo '<tr bgcolor="#efefef">';
		}else{
			echo '<tr bgcolor="#ffffff">';
		}
		
		echo '<td>'.$row['SINAV_ID'].'</td>';
		if(strlen($row['REVIZYON_NO'])>0 && $row['REVIZYON_DURUMU']==1){
			echo'<td>'.$row['YETERLILIK_REV_KOD'].'/'.$row['REVIZYON_NO'].' - '.$row['YETERLILIK_ADI'].'</td>';
		}else{
			echo'<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' - '.$row['YETERLILIK_ADI'].'</td>';
		}
		echo'<td>'.$row['BASLANGIC_TARIHI'].'</td>';
		if($this->canEdit){
			$urlpath = "window.open('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav=".$row['SINAV_ID']."')";
			echo'<td><button type="button" class="btn btn-xs btn-info" onclick="'.$urlpath.'">Aday Dosyası Yükle</button></td>';
		}
		echo'</tr>';
		$say++;
	} 
	?>
	</tbody>
</table>
<?php	
}
?>
<?php echo $this->geriLink;?>
<script type="text/javascript">

jQuery(document).ready(function(){
	jQuery('#sinavListesiTable').dataTable({
		"aaSorting": [[ 2, "desc" ]],
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
	
	
	jQuery('#sinavListesiTable_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
	jQuery('#sinavListesiTable_wrapper .dataTables_length select').addClass("input-sm"); // modify table per page dropdown	
});

function sinavYeriGetir(sinavId){
	jQuery('#sinavYeriIcerik').html('');
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavYeriGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			jQuery.each(dat,function(key,vall){
				ekle += '<div class="width150">Yer Adı:</div><div>'+vall['YER_ADI']+'</div>';
				ekle += '<div class="width150">Yer Adresi:</div><div>'+vall['ADRES']+'</div><br><hr>';
			});
			
			jQuery('#sinavYeriIcerik').html(ekle);
			jQuery('#sinavYeri').lightbox_me({
          	  	centered: true
            });
		}
	});
}

function sinavDegerlendiriciGetir(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavDegerGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			jQuery.each(dat,function(key,vall){
				var beyan = 'index.php?dl='+vall['BEYAN'];
				var cv = 'index.php?dl='+vall['CV'];
				ekle += '<div class="width150">Ad Soyad:</div><div>'+vall['ADI']+' '+vall['SOYADI']+'</div>';
				ekle += '<div class="width150">Kişisel Beyan:</div><div><a href="'+beyan+'" target="_blank"><img alt="" src="/MYK-BOR/images/pdf.png" width="30" height="30"></a></div>';
				ekle += '<div class="width150">Öz Geçmiş:</div><div><a href="'+cv+'" target="_blank"><img alt="" src="/MYK-BOR/images/pdf.png" width="30" height="30"></a></div><br><hr>';
			});

			jQuery('#sinavDegerIcerik').html(ekle);
			jQuery('#sinavDeger').lightbox_me({
          	  	centered: true
            });
		}
	});
}

function sinavAdayGetir(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavAdayGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			jQuery.each(dat,function(key,vall){
				var exurl = "index.php?dl=sinav_bildirimleri/"+vall['KURULUS_ID']+'_'+vall['SINAV_ID']+'_'+vall['PAKET_ID']+'.xlsx';
				ekle += '<div class="width150">Aday Dosyası:</div><div><a href="'+exurl+'" target="_blank">Dosya İndir</a></div><br><hr>';
			});

			jQuery('#sinavAdayIcerik').html(ekle);
			jQuery('#sinavAday').lightbox_me({
          	  	centered: true
            });
		}
	});
}

function adayDosyasi(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavAdayGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			if(dat.length > 0){
				jQuery.each(dat,function(key,vall){
					var exurl = "index.php?dl=sinav_bildirimleri/"+vall['KURULUS_ID']+'_'+vall['SINAV_ID']+'_'+vall['PAKET_ID']+'.'+vall['UZANTI'];
					ekle += '<div class="width150">Aday Dosyası:</div><div><a href="'+exurl+'">Dosya İndir</a></div><br><hr>';
				});
			}else{
				ekle = '<h3>Henüz aday bildirilmemiştir.</h3>';
			}
			jQuery('#sinavAdayIcerik').html(ekle);
			jQuery('#sinavAday').lightbox_me({
          	  	centered: true
            });
		}
	});
}
</script>

<div id="sinavYeri" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Yeri</u></h2>
    <div id="sinavYeriIcerik">
    
    </div>
</div>

<div id="sinavDeger" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Değerlendiricileri</u></h2>
    <div id="sinavDegerIcerik">
    
    </div>
</div>

<div id="sinavAday" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Adayları</u></h2>
    <div id="sinavAdayIcerik">
    
    </div>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>