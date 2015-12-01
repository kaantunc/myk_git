<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once("libraries/joomla/utilities/browser_detection.php");
//$user_browser = browser_detection('browser');

$classBirinci = "leftCol";
$classIkinci = "rightCol";

$uyeID = JRequest::getVar("uyeID");

if(isset($uyeID)){
	$seciliUye = $this->seciliUye;
	$uyeAdiSoyadi = $seciliUye[0]['AD_SOYAD'];
	$uyeUnvani = $seciliUye[0]['UNVAN'];
	$uyeKurumu = $seciliUye[0]['KURUM'];
	$uyeBaslangicTarihi = $seciliUye[0]['ETKINLIK_BASLANGIC_TARIHI'];
	$uyeBitisTarihi = $seciliUye[0]['ETKINLIK_BITIS_TARIHI'];

	$kaydetButtonTexti="Üye Bilgilerini Güncelle";
}
else{
	$kaydetButtonTexti="Üye Bilgilerini Kaydet";
}
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Yönetim Kurulu Üyelerini Düzenle</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form method="post" id="yeniYonetimKuruluForm"
		action="index.php?option=com_yonetim_kurulu&amp;task=uyeKaydet">

		<input type="hidden" id="uyeID" name="uyeID"
			value="<?php echo $uyeID;?>" />

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Ad & Soyad:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="uyeAdiSoyadiTextbox" class="required"
					id="uyeAdiSoyadi" value="<?php echo $uyeAdiSoyadi; ?>"
					maxlength="40" style="width: 300x;" />
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Unvan:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="uyeUnvaniTextbox" class="required"
					id="uyeUnvani" value="<?php echo $uyeUnvani; ?>" maxlength="20" />
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Kurum:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="uyeKurumuTextbox" class="required"
					id="uyeKurumu" value="<?php echo $uyeKurumu; ?>" maxlength="80" />
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Etkinlik Başlangıç Tarihi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required" type="text" maxlength="10"
					name="uyeBaslangicTarihiDatePicker"
					id="uyeBaslangicTarihiDatePicker"
					value="<?php echo $uyeBaslangicTarihi; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Etkinlik Bitiş Tarihi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" maxlength="10" name="uyeBitisTarihiDatePicker"
					id="uyeBitisTarihiDatePicker"
					value="<?php echo $uyeBitisTarihi; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="submit_button">
			<input type="submit" value="<?php echo $kaydetButtonTexti; ?>"
				name="kaydetButton" id="kaydetButton" />
		</div>

	</form>
</div>

<script type="text/javascript">

var inputChanged = false;
var confirmUnload = true;
var msg = 'Sayfayı terketmek üzeresiniz. Kaydedilmemiş verileriniz kaybolacak.';

jQuery(window).bind('beforeunload', function(e) {
	if(confirmUnload)
	{
		// For IE and Firefox prior to version 4
		if (e) {
			e.returnValue = msg;
		}
	
		// For Safari
		if(inputChanged==true)
		return msg;
	}
}); 

jQuery(document).ready(function() {	
	jQuery( "input:submit", ".submit_button" ).button();

	//
	jQuery("#yeniYonetimKuruluForm").submit(function(){
		if(jQuery("#yeniYonetimKuruluForm").valid()){
			confirmUnload=false;
		};
	});
	

	//ON SUBMIT VALIDATE
	jQuery("#yeniYonetimKuruluForm").validate();
	jQuery.extend(jQuery.validator.messages, {
	    required: "*"
	});
	
	//TAKVIM
	jQuery( "#uyeBaslangicTarihiDatePicker" ).datepicker({});
	jQuery( "#uyeBitisTarihiDatePicker" ).datepicker({});
    
	jQuery('input').change(function() {
		inputChanged=true;
	});
	
	
} );

</script>
