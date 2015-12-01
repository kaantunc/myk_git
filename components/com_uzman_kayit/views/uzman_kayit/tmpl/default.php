<?php 
$il = $this->il;
$sektor = $this->sektor;
$basvuru_alanlari = $this->basvuru_alanlari;
$deneyim_tipleri = $this->deneyim_tipleri;

?>

<form
	action="index.php?option=com_uzman_kayit&task=uzmanKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_bilgi_formu"
	name="ChronoContact_uzman_bilgi_formu">

	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">Teknik Uzman/Denetçi Bilgileri</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">T.C. Kimlik No</label>
	    <input class="cf_inputbox required" maxlength="11" size="10" title="" id="tckimlik" name="tckimlik" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Ünvanı</label>
	    <input class="cf_inputbox" maxlength="150" size="10" title="" id="text_1_2" name="onek" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Adı</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_1_3" name="ad" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Soyadı</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_1_4" name="soyad" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="yetkili_title">Kurum/Kuruluş</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_4" name="kurum" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="unvan_title">Kurum/Kuruluş Unvanı</label>
	    <input class="cf_inputbox" maxlength="150" size="30" title="" id="text_5" name="unvan" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="derece_title">Memuriyet Derecesi/Kademesi</label>
	    
	    <input class="cf_inputbox" maxlength="150" size="2" title="" id="text_5_2" name="derece" type="text" /><label>/</label>
	  	<input class="cf_inputbox" maxlength="150" size="2" title="" id="text_5_1" name="kademe" type="text" style="margin-right:10px;"/>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
			<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="telefon_title">Telefon</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="telefon" name="telefon" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="faks_title">Faks</label>
	    <input class="cf_inputbox" maxlength="150" size="30" title="" id="faks" name="faks" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="eposta_title">E-Posta</label>
	    <input class="cf_inputbox required email" maxlength="150" size="30" title="" id="text_11" name="eposta" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="web_title">Web</label>
	    <input class="cf_inputbox url" maxlength="150" size="30" title="" id="text_12" name="web" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textarea">
	    <label class="cf_label" style="width: 200px;" name="adres_title">Adresi</label>
	    <textarea class="cf_inputbox required" rows="3" id="text_3" title="" cols="30" name="adres"></textarea>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder">
		<label class="cf_label" style="width:200px;">Şehir</label>
		<select id="sehir" class="cf_inputbox required" name="sehir" title="" size="1" firstoption="1" firstoptiontext="Seçiniz">
			<option value="">Seçiniz</option>
			<?php
			if(isset($il)){
			foreach ($il as $row)
			  echo "<option value='$row[IL_ID]'> $row[IL_ADI]</option>";
			}
			?>
		</select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="posta_kodu_title">Posta Kodu</label>
	    <input class="cf_inputbox number" maxlength="150" size="10" title="" id="text_7" name="posta_kodu" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	
	<!-- div class="form_item">
	  <div class="form_element cf_placeholder">
	
		<label class="cf_label" style='width:200px;'>Sektörler</label>
		<select id="sektorler" name="sektorler[]" size="10" title="" style='width:300px;' multiple>
		<?php
		if(isset($sektor)){
		foreach ($sektor as $row)
		  echo "<option value='$row[SEKTOR_ID]'> $row[SEKTOR_ADI]</option>";
		}
		?>
		</select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="alan_title">Başvuru Alanı</label>
	    <?php 
	    foreach ($basvuru_alanlari as $row){
	    		echo '<input class="cf_inputbox" maxlength="150" size="10" title="Teknik Uzman" id="text_7_'.$row[ALAN_NO].'" name="alan[]" type="checkbox" value="'.$row[ALAN_NO].'" style="height:20px;margin-top:1px; margin-right:3px;"/><label>'.$row[ALAN_ADI].'</label>';	    	
	    }
	    ?>
	    </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="alan_title">Meslekler/Alanlar</label>
	    <input class="cf_inputbox required " maxlength="150" size="30" title="" id="text_11_1" name="meslekler" type="text" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="alan_title">Ulusal Yeterlilikler</label>
	    <?php 
	    foreach ($basvuru_alanlari as $row){
	    		echo '<input class="cf_inputbox" maxlength="150" size="10" title="Teknik Uzman" id="text_7_'.$row[ALAN_NO].'" name="alan[]" type="checkbox" value="'.$row[ALAN_NO].'" style="height:20px;margin-top:1px; margin-right:3px;"/><label>'.$row[ALAN_ADI].'</label>';	    	
	    }
	    ?>
	    </div>
	  <div class="cfclear">&nbsp;</div>
	</div-->
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="CV_title">CV</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="cv" name="cv" type="file" /> (PDF veya Word formatında)
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item" style="margin-left:30px;">
	CV’nizi Avrupa Komisyonununca önerilen Europass CV formatında hazırlamak isterseniz <a href="http://www.europass.gov.tr">buraya tıklayınız.</a>
	</div>
	<!-- div class="form_item">
	  <div class="form_element cf_placeholder">
	
		<label class="cf_label" style='width:200px;'>Faaliyette Bulunduğu İller</label>
		<select id="iller" name="iller[]" size="10" title="" style='width:200px;' multiple>
		<?php
		if(isset($il)){
		foreach ($il as $row)
		  echo "<option value='$row[IL_ID]'> $row[IL_ADI]</option>";
		}
		?>
		</select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div-->
	
		<div class="form_item">
	  <div class="form_element cf_button">
	    <input value="Kaydet" name="kaydet" type="submit" onclick='check_tcno(jQuery("#tckimlik").val());' class="styled-button-8"/>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

</form>

<script type="text/javascript">
		jQuery("#ChronoContact_uzman_bilgi_formu").validate();
		jQuery("#telefon").mask("(999) 999-9999");
		jQuery("#faks").mask("(999) 999-9999");
		
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
		function check_tcno(a){
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
			 return true;
			}
</script>