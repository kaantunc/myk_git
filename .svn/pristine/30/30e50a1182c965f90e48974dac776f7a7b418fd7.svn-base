<?php 
$isteks = $this->TesvikIstekleri['isteks'];
$adayCount = $this->TesvikIstekleri['adayCount'];
$odenmeyenSayisi=$this->OdenmeyenSayisi;
?>

<div class="anaDiv hColor font20 text-center text-underline fontBold">
	Ücret İadesinden Yararlanmak İsteyen Adaylar
</div>
<form action="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_adaylar" enctype="multipart/form-data" method="post">
<div class="anaDiv">
	<div class="div30 hColor font18">
		Ücret İadesi Talep Tarihi:
	</div>
	<div class="div70">
		<div class="divYan">
			<input class="input-sm tarih" type="text" name="bitTarih" title="teasdasdsd"/>
		</div>
		<div class="divYan">
			<button type="submit" class="btn btn-sm btn-primary">Yeni Ücret İadesi Talebi Oluştur</button>
		</div>
	</div>
</div>
<div class="anaDiv">
<hr>
</div>
</form>

<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar) -->
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">#</th>
				<th width="5%">İstek ID</th>
				<th width="10%">Ücret İadesi Talep Tarihi</th>
				<th width="8%">Aday Sayısı</th>
				<th width="12%">Durum</th>
				<th width="10%">Düzenle</th>
				<th width="10%">PDF Yükle</th>
				<th width="10%">PDF</th>
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
			echo '<td>'.$adayCount[$row['ID']].'</td>';
			if($row['DURUM'] == 0){
				if($this->canEdit){
					if(empty($row['DOSYA'])){
						echo '<td></td>';
					}else{
						echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOnayaSun('.$row['ID'].')">İsteği Gönder</button></td>';
					}
					
					echo '<td>
		<div class="anaDiv">
		<div class="divYan"><a href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_edit&IstekId='.$row['ID'].'" class="btn btn-xs btn-warning">Düzenle</a></div>
		<div class="divYan"><button type="button" onclick="FuncTesvikIstekSil('.$row['ID'].')" class="btn btn-xs btn-danger">Sil</button></div>
		</div></td>';
					if(empty($row['DOSYA'])){
						echo '<td><button type="button" class="btn btn-xs btn-info" onclick="FuncPdfYukle('.$row['ID'].')">Yükle</button></td>';
					}else{
						echo '<td><div class="anaDiv">
						<div class="divYan"><a class="btn btn-xs btn-info" href="index.php?dl='.$row['DOSYA'].'">İndir</a></div>
						<div class="divYan"><button type="button" class="btn btn-xs btn-danger" onclick="FuncPdfSil('.$row['ID'].')">Sil</button></div>
					</div></td>';
					}
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-info">Oluşturuluyor</button></td>';
					echo '<td></td>';
					if(empty($row['DOSYA'])){
						echo '<td></td>';
					}else{
						echo '<td><a class="btn btn-xs btn-info" href="index.php?dl='.$row['DOSYA'].'">İndir</a></td>';
					}
				}
				
			}else if($row['DURUM'] == 1){
				echo '<td><button type="button" class="btn btn-xs btn-info">İstek Gönderildi</button></td>';
				echo '<td></td>';
				echo '<td><a class="btn btn-xs btn-info" href="index.php?dl='.$row['DOSYA'].'">İndir</a></td>';
			}else{
				echo '<td>İstek Onaylandı';
				if ($odenmeyenSayisi>0) {
				echo " <a href='index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_adaylar_hata'>(!)</a>";
				}
				echo '</td>';
				echo '<td></td>';
				echo '<td></td>';
			}
			echo '<td><a target="_blank" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvikpdf&IstekId='.$row['ID'].'" class="btn btn-xs btn-danger">PDF</a></td>';
			echo '</tr>';
			$say++;
		} 
		?>
		</tbody>
	</table>
</div>
<?php
if ($odenmeyenSayisi>0){
	echo "<div style='color:red'><b>(!) NOT: </b>Daha önceki istekleriniz içindeki ".$odenmeyenSayisi." aday için hatalı IBAN'dan dolayı ödeme yapılamamıştır. Liste için <a href='index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_adaylar_hata'>tıklayınız.</a></div>";
}

?>
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

function FuncPdfYukle(IstekId){
	jQuery('#TesvikPdfIstek input[name="IstekId"]').val(IstekId);
	OpenLightBox('#TesvikPdf');
}

function FuncTesvikIstekSil(tId){
	if(confirm('Bu Teşvik İsteğini Silmek İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_tesvik&task=TesvikSil&format=raw",
			data:'IstekId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Talebi Başarıyla Silindi.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Silme İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncTesvikOnayaSun(tId){
	if(confirm('Bu Teşvik İsteğini Göndermek İstediğinizden Emin Misiniz? Gönderilen Teşvik İstekleri Üzerinde Düzeltme Yapılamaz.')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_tesvik&task=TesvikOnayaSun&format=raw",
			data:'IstekId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat['ERR'] == "0"){
				alert('Teşvik İsteği Başarıyla Yönetici Onayına Sunuldu.');
				window.location.reload();
			}else{
				alert(dat['ERR_TEXT']);
				window.location.reload();
			}
		});
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

function FuncPdfSil(IstekId){
	if(confirm("İstek PDF'ini silmek istediğinizden emin misiniz?")){
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_tesvik&task=TesvikPdfSil&format=raw",
			data:'IstekId='+IstekId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Başarıyla silindi.');
				window.location.reload();
			}else{
				alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="TesvikPdf" style=" min-width: 150px; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="TesvikPdfIstek" action="index.php?option=com_belgelendirme_tesvik&task=TesvikPdfKaydet" enctype="multipart/form-data" method="post">
    	<input type="hidden" name="IstekId" value="0"/>
    	<div class="anaDiv text-center fontBold hColor font18">
    		Ücret İadesi Talep PDF Dökümanı Yükle
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Döküman:
    		</div>
    		<div class="div70">
    			<input type="file" name="IstekPdf" class="input-sm inputW90"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div50 text-left">
    			<button type="button" class="btn btn-danger fontBold font18" onclick="CloseLightBox('#TesvikPdf')">İptal</button>
    		</div>
    		<div class="div50 text-right">
    			<button type="submit" class="btn btn-success fontBold font18">Kaydet</button>
    		</div>
    	</div>
    </form>
</div>