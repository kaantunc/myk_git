<?php
$kurulus = $this->AllKurulus;

$kuruluslar = '<option value="0">Seçiniz</option>';
foreach($kurulus as $row){
	$kuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$MSkurulus = $this->AllMSKurulus;
$MSkuruluslar = '<option value="0">Seçiniz</option>';
foreach($MSkurulus as $row){
	$MSkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$YETkurulus = $this->AllYETKurulus;
$YETkuruluslar = '<option value="0">Seçiniz</option>';
foreach($YETkurulus as $row){
	$YETkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$SBkurulus = $this->AllSBKurulus;
$SBkuruluslar = '<option value="0">Seçiniz</option>';
foreach($SBkurulus as $row){
	$SBkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}

$AKkurulus = $this->AllAKKurulus;
$AKkuruluslar = '<option value="0">Seçiniz</option>';
foreach($AKkurulus as $row){
	$AKkuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
?>
<style>
<!--
.anaDiv{
width:100%;
margin-bottom:10px;
display: inline-block;
}
-->
</style>
<div class="anaDiv">
<h2>Profil Sayfasına Giriş</h2>
</div>
<div class="anaDiv">
<label class="anaDiv"><input type="radio" name="kurs" value="1" checked="checked"/> <span>Tüm Kuruluşlar</span></label>
<label class="anaDiv"><input type="radio" name="kurs" value="2" /> <span>Meslek Standardı Hazırlayan Kuruluşlar</span></label>
<label class="anaDiv"><input type="radio" name="kurs" value="3" /> <span>Yeterlilik Hazırlayan Kuruluşlar</span></label>
<label class="anaDiv"><input type="radio" name="kurs" value="4" /> <span>Sınav ve Belgelendirme Kuruluşları</span></label>
<label class="anaDiv"><input type="radio" name="kurs" value="5" /> <span>Akreditasyon Kuruluşları</span></label>
</div>

<div class="anaDiv" id="kurulusSelect">
	<div class="div20 hColor font18">
		Kuruluş Adı:
	</div>
	<div class="div80">
		<select class="input-sm inputW100" name="kurulus" id="kurulus"><?php echo $kuruluslar;?></select>
	</div>
</div>
<div class="anaDiv text-center">
	<button type="button" id="getir" class="btn btn-sm btn-success">Getir</button>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	if(jQuery.cookie('kurulustype') != ""){
		jQuery('input[name=kurs][value="'+jQuery.cookie('kurulustype')+'"]').prop("checked", true); 
	}
	if(jQuery.cookie('kurulusname') != ""){
		jQuery('#kurulus').val(jQuery.cookie('kurulusname'));
	}
	jQuery('#getir').live('click',function(e){
		e.preventDefault();
		if(jQuery('#kurulus').val()==0){
			alert('Lütfen bir kuruluş seçiniz.');
		}else{
			jQuery.cookie('kurulustype', jQuery('input[name=kurs]:checked').val(), { expires: 1 });
			jQuery.cookie('kurulusname', jQuery('#kurulus').val(), { expires: 1 });
			window.location.href='index.php?option=com_profile&view=profile&layout=ozet&kurulus='+jQuery('#kurulus').val();
		}
	});

	jQuery('input[name="kurs"]:radio').live('click',function(){
		var val = jQuery(this).val();
		jQuery('#kurulusSelect').hide();
		if(val == 1){
			jQuery('#kurulus').html('<?php echo $kuruluslar;?>');
		}else if(val == 2){
			jQuery('#kurulus').html('<?php echo $MSkuruluslar;?>');
		}else if(val == 3){
			jQuery('#kurulus').html('<?php echo $YETkuruluslar;?>');
		}else if(val == 4){
			jQuery('#kurulus').html('<?php echo $SBkuruluslar;?>');
		}else if(val == 5){
			jQuery('#kurulus').html('<?php echo $AKkuruluslar;?>');
		}

		jQuery('#kurulusSelect').show();
	});
});
</script>