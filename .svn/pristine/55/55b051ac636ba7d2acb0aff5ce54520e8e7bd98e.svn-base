<?php
defined('_JEXEC') or die('Restricted access');
$kuruluslar = $this->kuruluslar;
$yeterlilik = $this->yeterlilik;
$kisi = $this->user;
?>
<form action="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=sorgu_sonuc" method="post">
	<div class="form_item">
		<div class="form_element cf_heading">
			<h1 class="contentheading">Mesleki Yeterlilik Belgesi Sorgula/İncele</h1>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php if($kisi == 2 || $kisi == 1){
 if($kisi == 2){?>
	<div class="form_item">
		<div class="form_element cf_textbox">
			<label class="cf_label" style="width: 150px;">Kuruluş:</label>
			<select name="kurulus_id"><option value="">Seçiniz</option><?php foreach($kuruluslar as $rows){
				echo '<option value="'.$rows["USER_ID"].'">'.$rows["KURULUS_ADI"].'</option>';
			} ?></select>

		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	<?php }?>
	<div class="form_item">
		<div class="form_element cf_textbox">
			<label class="cf_label" style="width: 150px;">Yeterlilik:</label>
			<select name="yet_id"><option value="">Seçiniz</option><?php foreach($yeterlilik as $rows){
				echo '<option value="'.$rows["YETERLILIK_ID"].'">'.$rows["YETERLILIK_KODU"].' / '.$rows["YETERLILIK_ADI"].'</option>';
			} ?></select>

		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
		<div class="form_element cf_textbox">
			<label class="cf_label" style="width: 150px;">Tarih</label> <input
				class="pickdatetime" maxlength="150" size="10"
				title="" id="text_0" name="tarih" type="text" />

		</div>
		<div class="cfclear">&nbsp;</div>
	</div>


	<div class="form_item">
		<div class="form_element cf_textbox">
			<label class="cf_label" style="width: 150px;">T.C Kimlik No</label> <input
				class="cf_inputbox numeric" maxlength="150" size="20"
				title="" id="text_0" name="kimlik_no" type="text" />

		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php }
else{?>
<div class="form_item">
		<div class="form_element cf_textbox">
			<label class="cf_label" style="width: 150px;">T.C Kimlik No</label> <input
				class="cf_inputbox numeric" maxlength="150" size="20"
				title="" id="text_0" name="kimlik_no" type="text" />

		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item">
	<div class="form_element cf_captcha">
	<div>
	<label class="cf_label" style="width: 150px;"><?php echo JText::_("CAPTCHA_INFO");?>
					</label>
				</div>
				<div style="float: left;">
					<img
						src="index.php?option=com_egbcaptcha&width=150&height=50&characters=5" />
					<div class="captchaInfo">
						
					<?php echo JText::_("CAPTCHA_PIC_INFO");?></div>
					<input id="verify_code" name="verify_code" type="text" />
				</div>
			</div>
			<div class="cfclear">&nbsp;</div>
		</div>
	<?php }?>
 
	<div class="form_item">
		<div class="form_element cf_button">
			<input value="Sorgula" name="Submit" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

</form>
<script type="text/javascript">

jQuery(".pickdatetime").live("hover",function(){
	jQuery(".tarihsecbuton").hide();
	jQuery(this).datepicker({  
        duration: '',  
        showTime: true,  
        constrainInput: false,
        changeYear: true,
        changeMonth: true,  
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: false  
     });
});
//monthYear
jQuery(".tarihsecbuton").live("hover",function(){
	jQuery(".tarihsecbuton").hide();
});

jQuery('#satirEkle_belgeDuzenlenecekBilgi').live("click",function(){
jQuery(".tarihsecbuton").hide();
});

</script>
