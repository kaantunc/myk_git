<?php
$itiraz = $this->itiraz['itirazlar'];
$BelgeUcretBilgi = $this->itiraz['BelgeUcretBilgi'];
$kurulus = $this->itiraz['kurulus'];
function UcretHesapla($dat){
	$dat = floor($dat*100)/100;
	return number_format($dat,'2',',','.');
}
?>

<div class="anaDiv text-center font20 hColor fontBold">
	Teşvik Ücret İtirazı
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		Belge No:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['BELGENO'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		Sınav Tarihi:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['BASLANGIC_TARIHI'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		İtiraz Tarihi:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['ITIRAZ_TARIHI'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		TC Kimlik No:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['TC_KIMLIK'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		Adı Soyadı:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['ADI'].' '.$itiraz[0]['SOYADI'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		Belgelendirme Kuruluşu:
	</div>
	<div class="div80 fontBold">
		<?php echo $kurulus[$itiraz[0]['BELGENO']]['KURULUS_ADI'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		Portal Üzerinden Hesaplanan Ücret:
	</div>
	<div class="div80 fontBold">
		<?php
		$hesap = 0;
		foreach($BelgeUcretBilgi[$itiraz[0]['BELGENO']]['UcretBilgi'][$itiraz[0]['BELGENO']] as $cow){
			$hesap += $cow['ucret'];
		}
		echo UcretHesapla($hesap).' TL';
		?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		İtiraz Ücreti:
	</div>
	<div class="div20 fontBold">
		<?php
		echo UcretHesapla($itiraz[0]['ITIRAZ_UCRET']).' TL';
		?>
	</div>
	<div class="div60">
		<button type="button" class="btn btn-sm btn-warning" onclick="FuncItirazUcretDuzenle('<?php echo $itiraz[0]['BELGENO'];?>')">Ücreti Düzenle</button>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		İtiraz Açıklaması:
	</div>
	<div class="div80 fontBold">
		<?php echo $itiraz[0]['ITIRAZ_ACIKLAMA'];?>
	</div>
</div>
<div class="anaDiv font18">
	<div class="div20 hColor">
		İtiraz Dosyası:
	</div>
	<div class="div80 fontBold">
		<?php 
		$dosyaType = strtolower(pathinfo($itiraz[0]['ITIRAZ_DOSYA'], PATHINFO_EXTENSION));
		if($dosyaType == 'pdf' || $dosyaType == 'doc' || $dosyaType == 'docx' || $dosyaType == 'zip' || $dosyaType == 'rar'){
			echo '<td><a target="_blank" href="index.php?dl=sinavABHibeItiraz/'.$itiraz[0]['SINAV_ID'].'/'.$itiraz[0]['ITIRAZ_DOSYA'].'" class="btn btn-sm btn-info">İndir</a></td>';
		}else if($dosyaType == 'jpg' || $dosyaType == 'jpeg' || $dosyaType == 'png' || $dosyaType == 'gif' || $dosyaType == 'pjpeg'){
			echo '<td><a target="_blank" href="index.php?img=sinavABHibeItiraz/'.$itiraz[0]['SINAV_ID'].'/'.$itiraz[0]['ITIRAZ_DOSYA'].'" class="btn btn-sm btn-info">İndir</a></td>';
		}
		?>
	</div>
</div>

<div class="anaDiv">
<hr>
</div>

<div class="anaDiv">
	<div class="div60">
		<a href="index.php?option=com_tesvik_abhibe_abhibe&view=tesvik&layout=itirazlar" class="btn btn-sm btn-danger">Geri</a>
	</div>
	<div class="div20 text-right">
		<button type="button" class="btn btn-sm btn-danger" onclick="FuncItirazDurumGuncelle('<?php echo $itiraz[0]['BELGENO'];?>',-1)">Reddet</button>
	</div>
	<div class="div20">
		<button type="button" class="btn btn-sm btn-success" onclick="FuncItirazDurumGuncelle('<?php echo $itiraz[0]['BELGENO'];?>',1)">Onayla</button>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	
});

function FuncItirazDurumGuncelle(belgeNo,durum){
	if(durum == 1){
		if(confirm('Onaylanan veya Reddedilen itirazlar üzerinde tekrardan işlem yapılamaz. İtiraz ücretini kabul ederek, onaylamak istediğinizden emin misiniz?')){
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_tesvik_abhibe&task=AjaxItirazDurumGuncelleWithBelgeNo&format=raw",
				data:'belgeNo='+belgeNo+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('İtiraz Onaylandı.');
					window.location.href = "index.php?option=com_tesvik_abhibe&view=tesvik&layout=itirazlar";
				}else{
					alert('Bir Hata meydana geldi. Lütfen Tekrar Deneyin.');
					window.location.reload();
				}
			});
		}
	}else{
		if(confirm('Onaylanan veya Reddedilen itirazlar üzerinde tekrardan işlem yapılamaz. İtirazı reddetmek istediğinizden emin misiniz?')){
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_tesvik_abhibe&task=AjaxItirazDurumGuncelleWithBelgeNo&format=raw",
				data:'belgeNo='+belgeNo+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('İtiraz Reddedildi.');
					window.location.href = "index.php?option=com_tesvik_abhibe&view=tesvik&layout=itirazlar";
				}else{
					alert('Bir Hata meydana geldi. Lütfen Tekrar Deneyin.');
					window.location.reload();
				}
			});
		}
	}
}

function FuncItirazUcretDuzenle(belgeNo){
	jQuery('input[name="ItirazUcret"]').val('');
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_tesvik_abhibe&task=AjaxItirazWithBelgeNo&format=raw",
		data:'belgeNo='+belgeNo
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('input[name="ItirazUcret"]').val(dat['ITIRAZ_UCRET']);
			OpenLightBox('#UcretPopUp');
		}else{
			alert('Bir Hata meydana geldi. Lütfen Tekrar Deneyin.');
			window.location.reload();
		}
	});
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

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   
   if (!(
		   charCode == 8 
		   || charCode == 46 
		   || (charCode >= 35 && charCode <= 40)
		   || (charCode >= 48 && charCode <= 57)
     )){
      return false;
   }

   return true;
}

function FuncItirazUcretKaydet(belgeNo){
	if(confirm('İtiraz Ücretini Güncellemek İstediğinizden Emin misiniz?')){
		CloseLightBox('#UcretPopUp');
		OpenLightBox('#loaderGif');
		var ucret = jQuery('input[name="ItirazUcret"]').val();
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik_abhibe&task=AjaxItirazUcretKaydetWithBelgeNo&format=raw",
			data:'belgeNo='+belgeNo+'&ucret='+ucret
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				window.location.reload();
			}else{
				alert('Bir Hata meydana geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}
	return false;
}
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="UcretPopUp" style="width: 600px; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv font18">
    	<div class="div20 hColor">
			Belge No:
		</div>
		<div class="div80 fontBold">
			<?php echo $itiraz[0]['BELGENO'];?>
		</div>
    </div>
    <div class="anaDiv font18">
    	<div class="div20 hColor">
			İtiraz Ücreti:
		</div>
		<div class="div80 fontBold">
			<input type="text" class="input-sm inputW50" name="ItirazUcret" onkeypress="return isNumberKey(event)"/>
		</div>
    </div>
    <div class="anaDiv">
    	<div class="div50">
			<button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#UcretPopUp')">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-sm btn-success" onclick="FuncItirazUcretKaydet('<?php echo $itiraz[0]['BELGENO'];?>')">Kaydet</button>
		</div>
    </div>
</div>