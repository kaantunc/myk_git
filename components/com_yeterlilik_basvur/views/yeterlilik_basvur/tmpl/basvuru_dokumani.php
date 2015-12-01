<form
	action="index.php?option=com_yeterlilik_basvur&amp;layout=basvuru_dokumani&amp;task=yeterlilikKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_basvuru_t2"
	name="ChronoContact_yeterlilik_basvuru_t2"
>


<?php 
echo $this->pageTree;
$basvuru = $this->basvuru;
$kurulus = $this->kurulus;
?>

<input type="hidden" name="evrak_id" value="<?php echo $basvuru["EVRAK_ID"]; ?>">
<input type="hidden" name="kurulus_id" value="<?php echo $kurulus["USER_ID"]; ?>">

<div class="form_item">
  <div class="form_element cf_placeholder">
	  <div>
	  		Başvuru Belgesi:<br><br>
	  		<?php echo getBasvuruBelgesiTDData($basvuru["BASVURU_EK_DOSYASI_PATH"], $basvuru["EVRAK_ID"], $kurulus ); ?>
	  </div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php } ?>
</form>
<script>
jQuery(document).ready(function(){
	<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2 && $this->ssyetkili != true && $this->evrak_id != -1){?>
		jQuery('#raporSilCheckbox').closest('div').remove();
		jQuery('#formGosterButton').remove();
		jQuery('input[value="Sil"]').remove();
		jQuery('input[type=file]').remove();
	<?php } ?>
	});

jQuery('#formGosterButton').live('click',function(e){
	e.preventDefault();
	
	jQuery('#toggleableDiv').toggle('slow');
	
	if(jQuery('#degistirFieldSelected').val()=='1')
		jQuery('#degistirFieldSelected').val("0");
	else
		jQuery('#degistirFieldSelected').val("1");
});
</script>
<?php 

function getBasvuruBelgesiTDData($raporPath, $evrak_id, $kurulus)
{
	
	$resultToReturn = '';

	$uploaderContent = '<input type="file" name="dosya[]" class="required" id="dosya" style="width: 210px;"  />';

	if(strlen($raporPath) > 0)
	{
		$resultToReturn .= '<div style="width:100%; float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green;">
			<div style="float:left;">
				Başvuru Belgesi Eklenmiş.
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="index.php?dl=basvuruDosyalari/'.$kurulus['USER_ID'].'/'.$evrak_id.'/'.$raporPath.'">İndir</a>
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="#" id="formGosterButton">Değiştir</a>
				<input type="hidden" id="degistirFieldSelected" name="degistirFieldSelected" value="0">
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
			</div>
			<div style="float:left;">
				<input type="checkbox" id="raporSilCheckbox" name="raporSilCheckbox" value="1">
				&nbsp;&nbsp;
				<a onclick="if(jQuery(\'#raporSilCheckbox\').attr(\'checked\')==\'checked\') jQuery(\'#raporSilCheckbox\').removeAttr(\'checked\'); else jQuery(\'#raporSilCheckbox\').attr(\'checked\', \'checked\')" style="color:green; text-decoration:underline;" href="#">Sil</a>
				&nbsp;&nbsp;&nbsp;
			</div>
		</div>';

		$resultToReturn .= '<div id="toggleableDiv" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';

		//$resultToReturn .= '<div style="padding-top:10px; width:100%; float:left;"><input type="button" onclick="window.location=\'index.php?option=com_denetim&layout=denetim_listele\';" value="GERİ" ></div>';


	}
	else
	{
		$resultToReturn .= $uploaderContent;
	}


	return $resultToReturn;
}

?>