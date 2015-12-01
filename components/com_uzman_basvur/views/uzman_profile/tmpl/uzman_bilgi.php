<?php
$data = $this->pm_il; 
echo $this->pageTree;
?>

<form
	onsubmit="return validate('ChronoContact_uzman_basvuru_t4')"
	action="index.php?option=com_uzman_basvur&view=uzman_profile&layout=uzman_bilgi&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />
<input type='hidden' id="updated" value='0' name='updated'/>

<?php 
if (!$this->canEdit && $this->kurulus['BASVURU_DURUM'] != 0) {
	$disabled='disabled = "disabled"';
// 	$disabled='disabled = "disabled"';
}

if ($this->kurulus["TC_KIMLIK"]){
	$readonly="readonly";
}

?>

<div class="form_item">
  <div class="form_element cf_textbox">
    <div style="width:200px;float:left;">&nbsp;</div>
    
  <div class="cfclear">&nbsp;</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Son Güncelleme
	</div>
	<div class="div80 font16">
		<?php if ($this->kurulus["TARIH"]){echo date("d.m.Y H:i:s",$this->kurulus["TARIH"]);} else {echo "-";}?>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		TC Kimlik No
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" <?php echo $readonly;?> maxlength="150" size="30" type="text" value="<?php echo $this->kurulus["TC_KIMLIK"];?>" <?php echo 'disabled = "disabled"';?>/><b>&nbsp;&nbsp;*</b>
		<input type="hidden" id="tckimlik" name="tckimlik" value="<?php echo $this->kurulus["TC_KIMLIK"];?>" />
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Unvanı
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="text_1_2" name="unvan" type="text" value="<?php echo $this->kurulus["ONEK"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Adı
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="ad" name="ad" type="text" value="<?php echo $this->kurulus["AD"];?>" <?php echo $disabled;?>/><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Soyadı
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="soyad" name="soyad" type="text" value="<?php echo $this->kurulus["SOYAD"];?>" <?php echo $disabled;?>/><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Kurumu/Kuruluşu
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="text_4" name="kurum" type="text" value="<?php echo $this->kurulus["KURUM"];?>" <?php echo $disabled;?>/><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Kurum/Kuruluş Unvanı
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="text_5" name="kurum_unvan" type="text" value="<?php echo $this->kurulus["KURUM_UNVANI"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Memuriyet Derece/Kademesi
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="1"  id="text_5_2" name="derece" type="text" value="<?php echo $this->kurulus["DERECE"];?>" <?php echo $disabled;?>/><label style="padding-left:10px">/</label>      
	    <input class="cf_inputbox input-sm" maxlength="150" size="1"  id="text_5_1" name="kademe" type="text" value="<?php echo $this->kurulus["KADEME"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Telefon
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="telefon" name="telefon" type="text" value="<?php echo $this->kurulus["TEL"];?>" <?php echo $disabled;?>/><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Faks
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox input-sm" maxlength="150" size="30"  id="text_10" name="faks" type="text" value="<?php echo $this->kurulus["FAX"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		E-Posta
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox e-mail input-sm" maxlength="150" size="30"  id="eposta" name="eposta" type="text" value="<?php echo $this->kurulus["EPOSTA"];?>"<?php echo $disabled;?>/><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Web
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox url input-sm" maxlength="150" size="30"  id="text_12" name="web" type="text" value="<?php echo $this->kurulus["WEB"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor" style="vertical-align: top;">
		Adresi
	</div>
	<div class="div80 font16">
		<textarea class="cf_inputbox inputW95" rows="3" id="text_3" title="" cols="26" name="adres" <?php echo $disabled;?>><?php echo $this->kurulus["ADRES"];?></textarea><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Posta Kodu
	</div>
	<div class="div80 font16">
		<input class="cf_inputbox numeric input-sm" maxlength="150" size="30"  id="text_7" name="posta_kodu" type="text" value="<?php echo $this->kurulus["POSTAKODU"];?>" <?php echo $disabled;?>/>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		Şehir
	</div>
	<div class="div80 font16">
		<select id="sehir" class="cf_inputbox required input-sm" name="sehir" title="" size="1" firstoption="1" firstoptiontext="Seçiniz"<?php echo $disabled;?>>
			<option value="">Seçiniz</option>
			<?php
			if(isset($data)){
				foreach ($data as $row){
					echo "<option value='$row[IL_ID]'";
						if ($row["IL_ID"]==$this->kurulus["IL"] ){
							echo " selected";
						}
						
		  			echo "> $row[IL_ADI]</option>";
				}
			}
			?>
		</select><b>&nbsp;&nbsp;*</b>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor" style="vertical-align: top;">
		Fotoğraf
	</div>
	<div class="div80 font16">
		<?php  if ($this->kurulus["FOTO_PATH"]!=""){?>
	    <input type="hidden" name="foto" value='<?php echo $this->kurulus["FOTO_PATH"];?>'>
	    <a href="index.php?img=<?php echo $this->kurulus["FOTO_PATH"];?>" target="_blank"><img height="150px" src="index.php?img=<?php echo $this->kurulus["FOTO_PATH"];?>"/></a>
	  <?php } else {?>
		  <input class="cf_inputbox" maxlength="150" size="30" title="" id="foto" name="foto" type="file" /><b>&nbsp;&nbsp;*</b> (jpg veya png Formatında)
	  <?php }?>
	</div>
	<div class="div80 fRight font16">
		<?php  if ($this->kurulus["FOTO_PATH"]!=""){?>
		  <?php if(!$this->ssmi){?>
		  	<button class="btn btn-xs btn-primary" type="button" id="fotoDeg">Fotoğraf Değiştir</button>
		  <?php }?>
	  </span>
	  <span id="fotodosyasi"></span>
	  <?php }?>
	</div>
</div>

<div class="anaDiv">
	<div class="div20 font16 hColor">
		CV
	</div>
	<div class="div80 font16">
		<?php  if ($this->kurulus["CV_PATH"]!=""){?>
    <input type="hidden" name="cv" value='<?php echo $this->kurulus["CV_PATH"];?>'><b>&nbsp;&nbsp;*</b>
  <span id="kaydedilmiscv"><input type=button onclick="window.location='index.php?dl=<?php echo $this->kurulus["CV_PATH"];?>'" target="_blank" value="OKU / İNDİR">
  <?php if($this->canEdit || $this->kurulus['BASVURU_DURUM'] == 0){ ?>
  <input style="margin-left:20px;" type="button" onclick="jQuery('#kaydedilmiscv').hide();jQuery('#cvdosyasi').html('<input class=\'cf_inputbox required\' maxlength=150 size=30 id=cv name=cv type=file> (PDF veya Word formatında)')" target="_blank" value="Değiştir" <?php echo $disabled;?>>
  <?php }?>
  </span>
  <span id="cvdosyasi"></span>
  <?php } else {?>
  <input class="cf_inputbox required" maxlength="150" size="30" title="" id="cv" name="cv" type="file" /><b>&nbsp;&nbsp;*</b> (PDF veya Word formatında)
  <?php }?>
	</div>
	<div class="div80 font16 fRight" style="margin-top:10px;">
		CV’nizi Avrupa Komisyonununca önerilen Europass CV formatında hazırlamak isterseniz <a href="index.php?dl=ekler/denetciCV.pdf">buraya tıklayınız.</a><br><br>
	</div>
</div>

<div class="anaDiv">
<?php 
if ($this->canEdit || $this->kurulus['BASVURU_DURUM'] == 0){
?>	
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<button name="islem" value="olustur" type="submit" type="submit"  class="btn btn-sm btn-info" onclick="return kontrol();"/>Kaydet</button>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>
</div>

<div class="anaDiv font16 text-primary">
	* Alanların doldurulması zorunludur.
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading"></h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading"></h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>

<script type="text/javascript">
var foto = '<div calss="divYan"><input class="cf_inputbox" maxlength="150" size="30" title="" id="foto" name="foto" type="file" /><b>&nbsp;&nbsp;*</b> (jpg veya png Formatında)</div>';
foto += '<div class="divYan"><button type="button" class="btn btn-xs btn-danger" id="fotoIptal">İptal</button></div>';

jQuery(document).ready(function(){
	jQuery('#fotoDeg').live('click',function(e){
		e.preventDefault();
		jQuery('#fotodosyasi').html(foto);
		jQuery(this).addClass('hidden');
	});

	jQuery('#fotoIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#fotodosyasi').html('');
		jQuery('#fotoDeg').removeClass('hidden');
	});
});

		jQuery("#ChronoContact_uzman_bilgi_formu").validate();
		jQuery("#telefon").mask("(999) 999-9999");
		jQuery("#text_10").mask("(999) 999-9999");
		
		jQuery("#text_12").live("keypress",function(){
			var url = jQuery(this).val();
			if(jQuery(this).val()=="http:/"){
				jQuery(this).val("http://");
				return;
			}
			var urlSplits = url.split("http://");
			if(urlSplits[1])
				jQuery(this).val("http://"+urlSplits[1]);
			else
				jQuery(this).val("http://"+urlSplits[0]);

			
			});

		function kontrol(){
			if (check_tcno()==false){
				return false;
			}else if (jQuery("#ad").val()==""){
				alert("Lütfen adınızı boş bırakmayınız");
				jQuery("#ad").attr("style","border-color:red;");
				jQuery("#ad").focus();
				return false;
			}else if (jQuery("#soyad").val()==""){
				alert("Lütfen soyadınızı boş bırakmayınız");
				jQuery("#soyad").attr("style","border-color:red;");
				jQuery("#soyad").focus();
				return false;
			}else if (jQuery("#telefon").val()==""){
				alert("Lütfen telefon numaranızı boş bırakmayınız");
				jQuery("#telefon").attr("style","border-color:red;");
				jQuery("#telefon").focus();
				return false;
			}else if (jQuery("#eposta").val()==""){
				alert("Lütfen e-posta adresinizi boş bırakmayınız");
				jQuery("#eposta").attr("style","border-color:red;");
				jQuery("#eposta").focus();
				return false;
			}else if(jQuery('input[name="kurum"]').val() == ""){
				alert("Lütfen Kurum/Kuruluş alanını boş bırakmayınız");
				jQuery('input[name="kurum"]').attr("style","border-color:red;");
				jQuery('input[name="kurum"]').focus();
				return false;
			}else if(jQuery('textarea[name="adres"]').html() === ""){
				alert("Lütfen Adres alanını boş bırakmayınız");
				jQuery('textarea[name="adres"]').attr("style","border-color:red;");
				jQuery('textarea[name="adres"]').focus();
				return false;
			}else{
				return true;
			}
		}

		
		function check_tcno(){
			 a=jQuery("#tckimlik").val();
			
			 if(a.substr(0,1)==0 || a.length!=11){
			   alert ("TC Kimlik Numaranız Geçersiz");
			   return false;
			 }
			 var i = 9, md='', mc='', digit, mr='';
			 while(digit = a.charAt(--i)){
			   i%2==0 ? md += digit : mc += digit;
			 }
			 if(((eval(md.split('').join('+'))*7)-eval(mc.split('').join('+')))%10!=parseInt(a.substr(9,1),10)){
			 	alert ("TC Kimlik Numaranız Geçersiz");
			 	return false;
			 }
			 for (c=0;c<=9;c++){
			   mr += a.charAt(c);
			 }
			 if(eval(mr.split('').join('+'))%10!=parseInt(a.substr(10,1),10)){
				 	alert ("TC Kimlik Numaranız Geçersiz");
				 	return false;
			 }
			 <?php echo $this->onclick;?>
			 return true;
			}
</script>
