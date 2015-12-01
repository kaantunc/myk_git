<?php 
$isteks = $this->TesvikIstekleri['isteks'];
$adayCount = $this->TesvikIstekleri['adayCount'];
$istekUcret = $this->TesvikIstekleri['istekUcret'];

// Kota Bilgileri
$KurPro = $this->ABKurPro;
$doviz = $this->doviz;
$TopKota = UcretDuzenle($this->ABKurKota);
$TopKullanilan = UcretDuzenle($this->ABKurKullanilanKota);
$TopKulDez = UcretDuzenle($this->ABKurKullanilanDezKota);
$ABKurBekKota = UcretDuzenle($this->ABKurBekKota);
$ABKurBekDezKota = UcretDuzenle($this->ABKurBekDezKota);

$TopDezKota = 0;
if($KurPro['DEZAVANTAJ']){
	$TopDezKota = $TopKota/10;
}
$TopDezsiz = $TopKota-$TopDezKota;

$dovizKuru = UcretDuzenle($doviz['alis']);

function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}

function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
?>

<div class="anaDiv hColor font20 text-center text-underline fontBold">
	AB Hibesi Ücret İadesi Talepleri
</div>
<form action="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar" enctype="multipart/form-data" method="post">
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
				<th width="5%">İstek ID</th>
				<th width="10%">Ücret İadesi Oluşturma Tarihi</th>
				<th width="10%">Aday Sayısı</th>
				<th width="10%">Durum</th>
				<th width="10%">Düzenle</th>
				<th width="10%">İade Dekontları / Fatura / Hesap Ekstresi</th>
				<th width="10%">Talep Listesi</th>
				<th width="10%">Toplam Ücret</th>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php
		$say = 1;
		foreach ($isteks as $row){
			echo '<tr>';
			echo '<td>'.$row['ID'].'</td>';
			echo '<td>'.$row['BIT_TARIH'].'</td>';
			echo '<td>'.$adayCount[$row['ID']].'</td>';
			if($row['DURUM'] == 0){
				$aciklama = '';
				if($row['ACIKLAMA'] != null){
					$text = '&lt;div class=&quot;anaDiv text-center font18 fontBold text-danger&quot;&gt;İstek Kuruluşa Geri Gönderildi!&lt;/div&gt;&lt;div class=&quot;anaDiv font16&quot;&gt;'.$row['ACIKLAMA'].'!&lt;/div&gt;';
					$aciklama = '<i class="fa fa-question-circle fa-2x text-primary tooltip divPadTopBot" title="'.$text.'"></i>';
				}
				
				if($row['DOSYA'] == null){
					echo '<td><button type="button" class="btn btn-xs btn-warning">İmzalı PDF Yükleyin</button>'.$aciklama.'</td>';
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOnayaSun('.$row['ID'].')">İsteği Gönder</button>'.$aciklama.'</td>';
				}
				
					
				echo '<td>
		<div class="anaDiv">
		<div class="divYan"><a href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_edit&IstekId='.$row['ID'].'" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Düzenle</a></div>
		<div class="divYan"><button type="button" onclick="FuncTesvikIstekSil('.$row['ID'].')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Sil</button></div>
		</div></td>';
				
				echo '<td></td>';
				if($row['DOSYA'] == null){
					echo '<td>';
					echo '<a target="_blank" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvikpdf&IstekId='.$row['ID'].'" class="btn btn-xs btn-danger">PDF</a><br>';
					echo '<button style="margin-top:5px;" type="button" class="btn btn-xs btn-primary" onclick="FuncPdfYukle('.$row['ID'].')">Yükle</button>';
					echo '</td>';
				}else{
					echo '<td>';
					echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF</a><br>';
					echo '<button style="margin-top:5px;" type="button" class="btn btn-xs btn-warning" onclick="FuncPdfSil('.$row['ID'].')">Sil</button>';
					echo '</td>';
				}
				
			}else if($row['DURUM'] == 1){
				echo '<td><button type="button" class="btn btn-xs btn-info">İstek Gönderildi</button></td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td><a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Talep Edilen)</small></a></td>';
			}else if($row['DURUM'] == 2){
				echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOdemeOnayaSun('.$row['ID'].')">Ödemeyi Onayla</button></td>';
				echo '<td></td>';
				echo '<td><a target="_blank" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=tesvik_adaylar_odeme&IstekId='.$row['ID'].'" class="btn btn-xs btn-info" >Yükle</a></td>';
				echo '<td>';
				echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Talep Edilen)</small></a><br>';
				echo '<a style="margin-top:5px;" target="_blank" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Onaylanan)</small></a>';
				echo '</td>';
			}else if($row['DURUM'] == 3){
				echo '<td class="text-warning font16 fontBold">AB Uzmanı Ödemeyi İnceliyor</td>';
				echo '<td></td>';
				echo '<td><a target="_blank" class="btn btn-xs btn-info" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/fatura/'.$row['ID'].'/'.$row['FATURA'].'">Fatura</a>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a>';
				echo '</td>';				
				echo '<td>';
				echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Talep Edilen)</small></a><br>
						<a style="margin-top:5px;" target="_blank" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Onaylanan)</small></a>';
				echo '</td>';
			}else if($row['DURUM'] == 4){
				echo '<td class="text-warning font16 fontBold">AB Uzmanı Ödemeyi Onayladı</td>';
				echo '<td></td>';
				echo '<td><a target="_blank" class="btn btn-xs btn-info" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/fatura/'.$row['ID'].'/'.$row['FATURA'].'">Fatura</a>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a>';
				echo '</td>';
				echo '<td>';
				echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Talep Edilen)</small></a><br>
						<a style="margin-top:5px;" target="_blank" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Onaylanan)</small></a>';
				echo '</td>';
			}else if($row['DURUM'] == 5){
				echo '<td class="text-success font16 fontBold">Ödeme Yapıldı</td>';
				echo '<td></td>';
				echo '<td><a target="_blank" class="btn btn-xs btn-info" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/fatura/'.$row['ID'].'/'.$row['FATURA'].'">Fatura</a>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-info" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a>';
				echo '</td>';
				echo '<td>';
				echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Talep Edilen)</small></a><br>
						<a style="margin-top:5px;" target="_blank" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'" class="btn btn-xs btn-danger">PDF<br><small>(Onaylanan)</small></a>';
				echo '</td>';
			}
			echo '<td>'.Hesapla($istekUcret[$row['ID']]).' TL</td>';
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

	jQuery('i.tooltip').tooltipster({
		contentAsHTML: true,
		theme: 'tooltipster-shadow',
		positionTracker: true,
		interactive: true
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
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikSil&format=raw",
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
	if(confirm('Bu Hibe İsteğini Göndermek İstediğinizden Emin Misiniz? Gönderilen Hibe İstekleri Üzerinde Düzeltme Yapılamaz.')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikOnayaSun&format=raw",
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
	
// 	if(!KotaOdemeKontrolWithId(tId)){}
}

function KotaOdemeKontrolWithId(IstekId){
	var durum = false;

	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme_abhibe&task=KotaOdemeKontrolWithId&format=raw",
		data:"IstekId="+IstekId+'&doviz=<?php echo $dovizKuru;?>'
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat['hata']){
			durum = true;
			alert(dat['mesaj']);
		}
	});

	return durum;
}

function FuncOdemeDosyalariYukluMu(tId){
	var durum = true;
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme_abhibe&task=ABHibeOdemeDosyalariYukluMu&format=raw",
		data:'IstekId='+tId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat['hata']){
			jQuery('#UyariContent').html(dat['message']);
			OpenLightBox('#UyariLoader');
			durum = false;
		}
	});
	return durum;
}

function FuncTesvikAdayPdfOnayaSun(tId){
	if(confirm('Bu Hibe İsteğini Aday Dosyası Onayı İçin Göndermek İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikAdayPDFOnayaSun&format=raw",
			data:'IstekId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Hibe Ödeme Dosyası Başarıyla Yönetici Onayına Sunuldu.');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncTesvikOdemeOnayaSun(tId){
	if(!FuncOdemeDosyalariYukluMu(tId)){
		return false;
	}else{
		if(confirm('Bu Hibe İsteğini Ödeme Onayı İçin Göndermek İstediğinizden Emin Misiniz?')){
			OpenLightBox('#loaderGif');
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_belgelendirme_abhibe&task=TesvikOdemeOnayaSun&format=raw",
				data:'IstekId='+tId
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Hibe Ödeme Dosyası Başarıyla Yönetici Onayına Sunuldu.');
					window.location.reload();
				}else{
					alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
					window.location.reload();
				}
			});
		}else{
			return false;
		}
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
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikPdfSil&format=raw",
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
<div id="UyariLoader" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		<i class="fa fa-exclamation-circle"></i> Uyarı <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center" id="UyariContent">
		 
	</div>
	<div class="anaDiv">
		<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">İptal</button>
	</div>
</div>
<div id="TesvikPdf" style=" width: 50%; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="TesvikPdfIstek" action="index.php?option=com_belgelendirme_abhibe&task=TesvikPdfKaydet" enctype="multipart/form-data" method="post">
    	<input type="hidden" name="IstekId" value="0"/>
    	<div class="anaDiv text-center fontBold hColor font18">
    		İmzalı Aday Talep Dökümanı Yükle
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