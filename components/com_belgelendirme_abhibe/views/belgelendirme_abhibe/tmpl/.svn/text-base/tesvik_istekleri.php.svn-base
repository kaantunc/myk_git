<?php 
$isteks = $this->TesvikIstekleri['isteks'];
$adayCount = $this->TesvikIstekleri['adayCount'];
echo $this->sayfa;
?>

<div class="anaDiv hColor font20 text-center text-underline fontBold">
	Ücret İadesi İstekleri
</div>

<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar) -->
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">#</th>
				<th width="5%">İstek ID</th>
				<th width="10%">Ücret İadesi Talep Tarihi</th>
				<th width="10%">Kuruluş Adı</th>
				<th width="10%">Aday Sayısı</th>
				<th width="10%">Durum</th>
				<th width="10%">PDF Yüklenen</th>
				<th width="10%">PDF</th>
				<?php if($this->durum == 1){
					echo '<th width="10%">Geri Gönder</th>';
				}?>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php
		$say = 1;
		foreach ($isteks as $row){
			echo '<tr>';
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['ID'].'</td>';
			echo '<td>'.$row['BIT_TARIH'].'</td>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$adayCount[$row['ID']].'</td>';
			if($row['DURUM'] == 1){
				echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncDurumGuncelle('.$row['ID'].',2)">Onayla</button></td>';
			}else{
				echo '<td><button type="button" class="btn btn-xs btn-success">Onaylandı</button></td>';
			}
			
			echo '<td><a class="btn btn-xs btn-info" href="index.php?dl='.$row['DOSYA'].'">İndir</a></td>';
			echo '<td><a target="_blank" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvikpdf&IstekId='.$row['ID'].'" class="btn btn-xs btn-danger">PDF</a></td>';
			
			if($row['DURUM'] == 1){
				echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncDurumGuncelle('.$row['ID'].',0)">Geri Gönder</button></td>';
			}
			echo '</tr>';
			$say++;
		} 
		?>
		</tbody>
	</table>
</div>
<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar son) -->

<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ İstek Oluşturuldu)",
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
	
	jQuery('.tarih').live('hover',function(e){
		e.preventDefault();
		jQuery(this).datepicker({
			changeYear: true,
		    changeMonth: true
		});
	});
});

function FuncDurumGuncelle(tId,durum){
	if(durum == 2){
		if(confirm('Bu Ücret İadesi Talebini onaylamak istediğinizden emin misiniz?')){
			OpenLightBox('#loaderGif');
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_belgelendirme_tesvik&task=TesvikDurumGuncelle&format=raw",
				data:'IstekId='+tId+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Ücret İadesi Talebi Başarıyla Onaylandı.');
					window.location.reload();
				}else{
					alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
					window.location.reload();
				}
			});
		}else{
			return false;
		}
	}else if(durum == 0){
		if(confirm('Bu Ücret İadesi Talebini geri göndermek istediğinizden emin misiniz?')){
			OpenLightBox('#loaderGif');
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_belgelendirme_tesvik&task=TesvikDurumGuncelle&format=raw",
				data:'IstekId='+tId+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Ücret İadesi Talebi Başarıyla Geri Gönderildi.');
					window.location.reload();
				}else{
					alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
					window.location.reload();
				}
			});
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function CloseLightBox(ele){
	jQuery(ele).trigger('close');
	return true;
}

function OpenLightBox(ele, overSpeed, boxSpeed){
	jQuery(ele).lightbox_me({
		overlaySpeed: 350,
		lightboxSpeed: 400,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

function UyariLightBox(sonra){
	if(sonra){
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7},
	        onClose: OpenLightBox(sonra)
	    });
	}else{
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	}
}


</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
