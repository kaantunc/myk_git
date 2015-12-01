<?php
// print_r($this->belgeNoBilgi);
$data = $this->belgeNoBilgi;

$belgeNoBilgi = $data['belgeBilgi'];
$kurBilgi = $data['kurBilgi'];
$yetBilgi = $data['yetBilgi'];
?>

<style>
<!--
.fLeft{
	width:30%;
	float: left;
	color:#1C617C;
}

.fRight{
	width:70%;
	float: left;
}
-->
</style>

<div style="width:100%;">
	<div class="fLeft"><h3>Belge No:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['BELGENO'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Adı Soyadı:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['AD'].' '.$belgeNoBilgi['SOYAD'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>TC Kimlik No:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['TCKIMLIKNO'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Yeterlilik:</h3></div>
	<div class="fRight"><?php echo $yetBilgi['YETERLILIK_KODU'].'/'.$yetBilgi['REVIZYON'].' '.$yetBilgi['YETERLILIK_ADI'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Seviye:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['YETERLILIK_SEVIYESI'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Belgelendirme Kuruluşu:</h3></div>
	<div class="fRight"><?php echo $kurBilgi['KURULUS_ADI'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Belge Düzenlenme Tarihi:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['BELGE_DUZENLEME_TARIHI'];?></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Belge Geçerlilik Tarihi:</h3></div>
	<div class="fRight"><?php echo $belgeNoBilgi['GECERLILIK_TARIHI'];?></div>
</div>

<?php 
if($belgeNoBilgi['BELGEDURUMU'] == 1){
?>
<div style="width:100%;">
	<div class="fLeft"><h3>Belge Durumu:</h3></div>
	<div class="fRight"><span style="color:green">Geçerli</span></div>
</div>
<?php	
}else if($belgeNoBilgi['BELGEDURUMU'] == 2){
?>
<div style="width:100%;">
	<div class="fLeft"><h3>Belge Durumu:</h3></div>
	<div class="fRight"><span style="color:red">İptal Edildi</span></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Açıklama:</h3></div>
	<div class="fRight"><?php echo nl2br($belgeNoBilgi['IPTAL_ACIKLAMA']);?></div>
</div>
<?php 	
}else if($belgeNoBilgi['BELGEDURUMU'] == 3){
?>
<div style="width:100%;">
	<div class="fLeft"><h3>Belge Durumu:</h3></div>
	<div class="fRight"><span style="color:red">Askıya Alındı</span></div>
</div>

<div style="width:100%;">
	<div class="fLeft"><h3>Açıklama:</h3></div>
	<div class="fRight"><?php echo nl2br($belgeNoBilgi['IPTAL_ACIKLAMA']);?></div>
</div>
<?php 	
}
?>


<div style="border:1px solid #1C617C; width:100%;float:left;margin-bottom:10px;margin-top:10px;"></div>

<form id="FormBelgeDurum" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeDurumuDuzenle">
<div style="width:100%">
	<div class="fLeft"><h3>Belge Durumu Güncelle:</h3></div>
	<div class="fRight">
		<select id="belgeDurumu" name="belgeDurumu">
			<option value="0">Seçiniz</option>
			<option value="1">Geçerli</option>
			<option value="2">İptal Et</option>
			<option value="3">Askıya Al</option>
		</select>
	</div>
</div>

<div style="width:100%;display:none;float:left;margin-top:10px;" id="belgeAcik">
	<div class="fLeft"><h3>Açıklama:</h3></div>
	<div class="fRight">
		<textarea rows="3" style="width:60%" name="aciklama" id="aciklama"></textarea>
	</div>
</div>

<div style="width:100%;margin-top:10px;float:left">
	<div class="fLeft"><button type="button" id="belgeDurumKaydet">Kaydet</button></div>
	<div class="fRight"></div>
</div>

<input type="hidden" name="belgeNo" value="<?php echo $belgeNoBilgi['BELGENO'];?>"/>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#belgeDurumu').change(function(){
		if(jQuery(this).val() == 2 || jQuery(this).val() == 3){
			jQuery('#belgeAcik').show();
		}else{
			jQuery('#belgeAcik').hide();
		}
	});

	jQuery('#belgeDurumKaydet').live('click',function(){
		if(jQuery('#belgeDurumu').val() == 0){
			alert('Lütfen belge durumunu seçiniz.');
		}
		else if(jQuery('#belgeDurumu').val() == 2 || jQuery('#belgeDurumu').val() == 3){
			if(jQuery('#aciklama').val() == ''){
				alert('Lütfen açıklama alanını doldurunuz.');
			}else{
				jQuery('#FormBelgeDurum').submit();
			}
		}else{
			jQuery('#aciklama').val('');
			jQuery('#FormBelgeDurum').submit();
		}
	});
});
</script>