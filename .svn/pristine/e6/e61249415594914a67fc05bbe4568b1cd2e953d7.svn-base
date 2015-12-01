<?php
$yeterlilik = $this->yeterlilik;

$yetSelect = '<option value="">Seçiniz</option>';
foreach ($yeterlilik as $yet){
	$yetSelect .= '<option value="'.$yet[0].'">'.$yet[0].' - '.$yet[1].'</option>';
}
?>
<style>
.llabel{
	width: 200px;
	float: left;
	text-align: left;
	margin-right: 10px;
	display: block;
}
</style>
<h2>Belgendirme İçin Belge Numarası Alma Ekranı</h2><br>

<label class="llabel" for="yetKod">Yeterlilik:</label> <select name="yetKod" id="yetKod"><?php echo $yetSelect;?></select><br><br>
<label class="llabel" for="belSay">Belgelendirilecek Kişi Sayısı:</label> <input type="text" name="belSay" id="belSay" /><br><br>
<input type="button" id="getir" value="Belge Numarası Getir"/>
<input type="button" id="numaraAl" value="Belge Numaralarını Al" style="display: none"/>

<div style="display: none; margin-top:10px" id="BelgeNoGoster">
	<hr>
	<div id="genelBilgi"></div>
	<p>Aşağıdaki belge numralarını kendinize tahsis etmek için 'Belge Numaralarını Al' butonuna basmanız gerekmektedir.</p>
	<h3>Belge Numaraları</h3>
	<div id="belgeNolari" style="margin-top:5px;">
	</div>
</div>

<input type="hidden" id="sonBelgeNo" />

<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery('#yetKod').live('change',function(e){
		e.preventDefault();
		jQuery('#BelgeNoGoster').hide();
		jQuery('#numaraAl').hide();
		jQuery('#sonBelgeNo').val('');
	});

	jQuery('#numaraAl').live('click',function(e){
		e.preventDefault();
		var sonBelge = jQuery('#sonBelgeNo').val();
		var yetKod = jQuery('#yetKod').val();
		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_belgelendirme&view=belge_olusturma&task=BelgeNoVer&format=raw",
			data:'yetKod='+yetKod+'&sonBelge='+sonBelge,
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat == true){
					alert('Belge numaraları size tahsis edilmiştir.');
				}
				else{
					alert('Belge numaralarını bir hatadan dolayı alamadınız. Lütfen tekrar deneyiniz.');
				}
			}
		});
	});
	
	jQuery('#getir').live('click',function(e){
		e.preventDefault();
		jQuery('#BelgeNoGoster').hide();
		jQuery('#numaraAl').hide();
		jQuery('#sonBelgeNo').val('');
		
		var yetKod = jQuery('#yetKod').val();
		var belSay = jQuery('#belSay').val();

		if(yetKod == ''){
			alert('Lütfen bir yeterlilik seçiniz.');
		}
		else if(belSay == '' && belSay == 0){
			alert('Lütfen kaç tane belge vermek istiyorsanız sayısını veriniz.');
		}
		else{
			jQuery.ajax({
				type:'POST',
				url:"index.php?option=com_belgelendirme&view=belge_olusturma&task=BelgeNoAl&format=raw",
				data:'yetKod='+yetKod+'&kacBelge='+belSay,
				success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat.length>0){
						var ekle = '<ul>';
						jQuery.each(dat[1],function(key,value){
							ekle += '<li>'+value+'</li>';
						});
						ekle += '</ul>';
						jQuery('#belgeNolari').html(ekle);
						jQuery('#genelBilgi').html('<h4>Bu yeterlilikten son verilen belge numarası: '+dat[0]+'</h4>');
						jQuery('#numaraAl').show('slow');
						jQuery('#BelgeNoGoster').show('slow');
						jQuery('#sonBelgeNo').val(dat[2]);
					}
				}
			});
		}
	});
});
</script>