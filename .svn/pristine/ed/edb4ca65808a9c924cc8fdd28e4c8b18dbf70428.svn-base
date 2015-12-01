<?php 
$yets = $this->yets;
$kurs = $this->kurs;

$yeterlilikler = '<option value="">Seçiniz</option>';
foreach ($yets as $row){
	$yeterlilikler .= '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' - '.$row['YETERLILIK_ADI'].'</option>';
}

$kuruluslar = '<option value="">Seçiniz</option>';
foreach ($kurs as $row){
	$kuruluslar .= '<option value="'.$row['KURULUS_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
?>

<div class="anaDiv">
	<div class="divYan"><button type="button" class="btn btn-sm btn-success">Portal Üzerinden Basılan Belge Sayısı</button></div>
<!-- 	<div class="divYan"><button type="button" class="btn btn-sm btn-success">Portal Üzerinden Tekrar Basılan Belge Sayısı</button></div> -->
</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Yeterlilik:
	</div>
	<div class="div80">
		<select id="yeterlilik" class="input-sm" style="width:100%"><?php echo $yeterlilikler;?></select>
	</div>
</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Kuruluş:
	</div>
	<div class="div80">
		<select id="kurulus" class="input-sm" style="width:100%"><?php echo $kuruluslar;?></select>
	</div>
</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">
		Matbaa Basım Tarih Aralığı:
	</div>
	<div class="div80">
		<input type="text" id="basTarih"  class="sinavTarih input-sm"><input type="text" id="bitTarih" class="sinavTarih input-sm">
	</div>
</div>
<div class="anaDiv">
	<button type="button" id="sinavAra" class="btn btn-sm btn-success">Ara</button>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.sinavTarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
	});

	jQuery('#sinavAra').live('click',function(e){
		e.preventDefault();
// 		jQuery('#loaderGif').lightbox_me({
// 			centered: true,
// 	        closeClick:false,
// 	        closeEsc:false  
//         });
		jQuery('.aramaSonuc').hide();
		jQuery('#sonucBody').html('');
		var yet = jQuery('#yeterlilik').val();
		var kur = jQuery('#kurulus').val();
		var bas = jQuery('#basTarih').val();
		var bit = jQuery('#bitTarih').val();
		
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme&task=belgeMatbaahSearch&format=raw",
			data:'yeterlilik_id='+yet+'&kurulus_id='+kur+'&basTarih='+bas+'&bitTarih='+bit+'&durum=2',
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
// 					jQuery('#loaderGif').trigger('close');
					jQuery('#BasimSay #basilan').html(dat['basim']);
					jQuery('#BasimSay #tekrarbasilan').html(dat['tekrarbasim']);
					OpenLightBox('#BasimSay');
				}
				else{
					alert('Aradığınız kriterlere uygun bir sınav bulunamadı.');
					jQuery('#loaderGif').trigger('close');
				}
			}
		});
	});
});

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
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="BasimSay" style=" min-width: 150px; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv">
    	<div class="div50 font18 hColor fontBold">
    		Basılan Belge Sayısı:
    	</div>
    	<div class="div50 font18 fontBold" id="basilan">
    	
    	</div>
    </div>
    <div class="anaDiv">
    	<div class="div50 font18 hColor fontBold">
    		Tekrar Basılan Belge Sayısı:
    	</div>
    	<div class="div50 font18 fontBold" id="tekrarbasilan">
    	
    	</div>
    </div>
    <div class="anaDiv text-right">
    	<button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#BasimSay')">Kapat</button>
    </div>
</div>