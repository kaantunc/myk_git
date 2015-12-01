<?php
$kuruluslar = $this->kuruluslar;

$kurs = '<option value="0">Seçiniz</option>';
foreach ($kuruluslar as $row){
	$kurs .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
$kurulusBilgi = $this->kurulusBilgi;
?>
<style>
.width150{
	width:250px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>form>div{
	padding-top:10px;
	padding-bottom:10px;
}
.aramaSonuc{
 	display:none;
	margin-top:20px;
}
</style>

<div>
	<select id="kurulus"><?php echo $kurs;?></select>
	<button id="logoGetir">Getir</button>
</div>
<div style="display: none; margin-top:20px;" id="logolar" class="aramaClass">
<form action="index.php?option=com_kurulus_edit&task=kurulusLogoUpdate" enctype="multipart/form-data" method="POST" id="GunKurulus">
<div class="width150">Kuruluş Yetkilendirme Kodu</div><div id="ybKodu">
	<input type="text" id="ybKod" name="ybKod" />
</div>
<div class="width150">Kuruluş Logo</div><div id="kurulusLogodiv">
	<div id="logoGun">
		<input type="file" name="kurLogo" id="kurLogo" /><input type="button" id="iptalLogo" style="background-color:red;color:#ffffff;margin-left:10px;" value="İptal"/>
	</div>
	<div id="logoGoster">
		<a id="logoHref" target="_blank">Kurulus Logo</a>
		<button id="logoDegistir">Değiştir</button>
	</div>
</div>
<div class="width150">Kuruluş MYK Markası</div><div id="mykMarkadiv">
	<div id="mykMarkaGun">
		<input type="file" name="mykMarka" id="mykMarka" /><input type="button" id="iptalMYK" style="background-color:red;color:#ffffff;margin-left:10px;" value="İptal"/>
	</div>
	<div id="mykMarkaGoster">
		<a id="mykMarkaHref" target="_blank">MYK Markası</a>
		<button id="mykMarkaDegistir">Değiştir</button>
	</div>
</div>
<div class="width150">Kuruluş TÜRKAK Kodu</div><div id="turkKodu">
	<input type="text" id="turkKod" name="turkKod" />
</div>
<div class="width150">Kuruluş TÜRKAK Markası</div><div id="turkMarkadiv">
	<div id="turkMarkaGun">
		<input type="file" name="turkMarka" id="turkMarka" /><input type="button" id="iptalTurk" style="background-color:red;color:#ffffff;margin-left:10px;" value="İptal"/>
	</div>
	<div id="turkMarkaGoster">
		<a id="turkMarkaHref" target="_blank">TÜRKAK Markası</a>
		<button id="turkMarkaDegistir">Değiştir</button>
	</div>
</div>
<input type="hidden" id="kurulusId" name="kurulusId">
<input type="submit" value="Kaydet">
</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){

	<?php if(is_array($kurulusBilgi)){
		?>
		var kurulusBilgi = <?php echo json_encode($kurulusBilgi);?>;
		jQuery('#kurulus').val(kurulusBilgi['USER_ID']);
		jQuery('#ybKod').val(kurulusBilgi['YBKODU']);
		jQuery('#turkKod').val(kurulusBilgi['AKREDITASYON_NO']);
		if(kurulusBilgi['LOGO'].length == 0 || kurulusBilgi['LOGO'] == ''){
			jQuery('#logoGoster').hide();
			jQuery('#logoGun').show();
			jQuery('#iptalLogo').hide();
		}else{
			jQuery('#logoHref').attr('href','index.php?img=kurulus_logo/'+kurulusBilgi['USER_ID']+'/'+kurulusBilgi['LOGO']);
			jQuery('#logoGun').hide();
			jQuery('#logoGoster').show();
		}

		if(kurulusBilgi['MYK_MARKASI']){
			if(kurulusBilgi['MYK_MARKASI'].length == 0 || kurulusBilgi['MYK_MARKASI'] == ''){
				jQuery('#mykMarkaGoster').hide();
			}else{
				jQuery('#mykMarkaHref').attr('href','index.php?img=logolar/'+kurulusBilgi['MYK_MARKASI']);
				jQuery('#mykMarkaGun').hide();
				jQuery('#mykMarkaGoster').show();
			}	
		}else{
			jQuery('#mykMarkaGoster').hide();
			jQuery('#mykMarkaGun').show();
			jQuery('#iptalMYK').hide();
		}

		if(kurulusBilgi['TURKAK_MARKASI']){
			if(kurulusBilgi['TURKAK_MARKASI'].length == 0 || kurulusBilgi['TURKAK_MARKASI'] == ''){
				jQuery('#turkMarkaGoster').hide();
			}else{
				jQuery('#turkMarkaHref').attr('href','index.php?img=logolar/'+kurulusBilgi['TURKAK_MARKASI']);
				jQuery('#turkMarkaGun').hide();
				jQuery('#turkMarkaGoster').show();
			}
		}else{
			jQuery('#turkMarkaGoster').hide();
			jQuery('#turkMarkaGun').show();
			jQuery('#iptalTurk').hide();
		}
		
		jQuery('#kurulusId').val(kurulusBilgi['USER_ID']);
		jQuery('#logolar').show();
		<?php 
	}?>
	
	jQuery('#kurulus').live('change',function(){
		jQuery('#logolar').hide();
	});
	
	jQuery('#logoGetir').live('click',function(){
		if(jQuery('#kurulus').val() == 0){
			alert('Lütfen bir kuruluş seçiniz.');
		}else{
			jQuery('#kurulusId').val(jQuery('#kurulus').val());
			jQuery('#logoHref').attr('href','#');
			jQuery('#mykMarkaHref').attr('href','#');
			jQuery('#turkMarkaHref').attr('href','#');
			//jQuery('#logolar').show();
			jQuery.ajax({
				asycn:false,
				type:"POST",
				url:"index.php?option=com_kurulus_edit&task=KurulusGetir&format=raw",
				data:'kurulusId='+jQuery('#kurulus').val(),
				success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat){
						jQuery('#ybKod').val(dat['YBKODU']);
						jQuery('#turkKod').val(dat['AKREDITASYON_NO']);
						if(dat['LOGO'].length == 0 || dat['LOGO'] == ''){
							jQuery('#logoGoster').hide();
							jQuery('#logoGun').show();
							jQuery('#iptalLogo').hide();
						}else{
							jQuery('#logoHref').attr('href','index.php?img=kurulus_logo/'+jQuery('#kurulus').val()+'/'+dat['LOGO']);
							jQuery('#logoGun').hide();
							jQuery('#logoGoster').show();
						}

						if(dat['MYK_MARKASI']){
							if(dat['MYK_MARKASI'].length == 0 || dat['MYK_MARKASI'] == ''){
								jQuery('#mykMarkaGoster').hide();
							}else{
								jQuery('#mykMarkaHref').attr('href','index.php?img=logolar/'+dat['MYK_MARKASI']);
								jQuery('#mykMarkaGun').hide();
								jQuery('#mykMarkaGoster').show();
							}
						}else{
							jQuery('#mykMarkaGoster').hide();
							jQuery('#mykMarkaGun').show();
							jQuery('#iptalMYK').hide();
						}

						if(dat['TURKAK_MARKASI']){
							if(dat['TURKAK_MARKASI'].length == 0 || dat['TURKAK_MARKASI'] == ''){
								jQuery('#turkMarkaGoster').hide();
							}else{
								jQuery('#turkMarkaHref').attr('href','index.php?img=logolar/'+dat['TURKAK_MARKASI']);
								jQuery('#turkMarkaGun').hide();
								jQuery('#turkMarkaGoster').show();
							}	
						}else{
							jQuery('#turkMarkaGoster').hide();
							jQuery('#turkMarkaGun').show();
							jQuery('#iptalTurk').hide();
						}

						

						jQuery('#logolar').show();
					}else{
						alert('Lütfen tekrar deneyin.');
					}
				}
			});
		}
	});

	jQuery('#logoDegistir').live('click',function(e){
		e.preventDefault();
		jQuery('#logoGoster').hide();
		jQuery('#logoGun').show();
	});

	jQuery('#mykMarkaDegistir').live('click',function(e){
		e.preventDefault();
		jQuery('#mykMarkaGoster').hide();
		jQuery('#mykMarkaGun').show();
	});

	jQuery('#turkMarkaDegistir').live('click',function(e){
		e.preventDefault();
		jQuery('#turkMarkaGoster').hide();
		jQuery('#turkMarkaGun').show();
	});

	jQuery('#iptalLogo').live('click',function(e){
		e.preventDefault();
		jQuery('#logoGoster').show();
		jQuery('#logoGun').hide();
	});

	jQuery('#iptalMYK').live('click',function(e){
		e.preventDefault();
		jQuery('#mykMarkaGoster').show();
		jQuery('#mykMarkaGun').hide();
	});

	jQuery('#iptalTurk').live('click',function(e){
		e.preventDefault();
		jQuery('#turkMarkaGoster').show();
		jQuery('#turkMarkaGun').hide();
	});
});
</script>