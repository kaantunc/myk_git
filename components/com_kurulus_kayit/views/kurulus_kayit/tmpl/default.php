<?php 
$kurulus_statu = $this->kurulus_statu;
$il = $this->il;
?>

<form
	action="index.php?option=com_kurulus_kayit&task=kurulusKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_kurulus_bilgi_formu"
	name="ChronoContact_kurulus_bilgi_formu">

	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">Kuruluş Bilgileri</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Adı</label>
	    <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" id="text_1" name="ad" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder">
			<label class="cf_label" style="width:150px;">Statüsü</label>
			<select id="statu" class="cf_inputbox required" name="statu" title="" size="1" firstoption="1" firstoptiontext="Seçiniz">
				<option value=""></option>
				<?php
				if(isset($kurulus_statu)){
				foreach ($kurulus_statu as $row)
				  echo "<option value='$row[KURULUS_STATU_ID]'> $row[KURULUS_STATU_ADI]</option>";
				}
				?>
			</select>
		</div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;" name="yetkili_title">Yetkilisi</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_4" name="yetkili" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;" name="unvan_title">Yetkili Unvanı</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_5" name="unvan" type="text" />
	  
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
	    <label class="cf_label" style="width: 150px;" name="adres_title">Adresi</label>
	    <textarea class="cf_inputbox required" rows="3" id="text_3" title="" cols="30" name="adres"></textarea>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder">
		<label class="cf_label" style="width:150px;">Şehir</label>
		<select id="sehir" class="cf_inputbox required" name="sehir" title="" size="1" firstoption="1" firstoptiontext="Seçiniz">
			<option value=""></option>
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
	    <label class="cf_label" style="width: 150px;" name="posta_kodu_title">Posta Kodu</label>
	    <input class="cf_inputbox number required" maxlength="150" size="30" title="" id="text_7" name="posta_kodu" type="text" />
	  
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
	    <label class="cf_label" style="width: 150px;" name="telefon_title">Telefon</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="telefon" name="telefon" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;" name="faks_title">Faks</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="faks" name="faks" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;" name="eposta_title">E-Posta</label>
	    <input class="cf_inputbox required email" maxlength="150" size="30" title="" id="text_11" name="eposta" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;" name="web_title">Web</label>
	    <input class="cf_inputbox required" maxlength="150" size="30" title="" id="text_12" name="web" type="text" />
	  
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
	  <div class="form_element cf_placeholder">
	
		<label class="cf_label" style='width:150px;'>Faaliyette Bulunduğu İller (Çoklu seçim için CTRL tuşunu kullanınız)</label>
		<select id="iller" name="iller[]" size="10" title="" style='width:150px;' multiple>
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
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
	    <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" id="text_13" name="logo" type="file" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<br/>
	<div class="form_item">
	  <div class="form_element cf_button">
	    <input value="Kaydet" name="kaydet" type="submit" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

</form>
<br/>
<hr/>

<div class="form_item" style="padding-top: 15px; font-style:italic;">
	<p>(1)-Kuruluş logosu maksimum 2,43 cm yükseklik ve 5,61 cm genişliğinde, .jpg, .gif veya .png formatında olmalıdır.</p>
	<div class="cfclear">&nbsp;</div>
</div>
<script type="text/javascript">
		jQuery("#ChronoContact_kurulus_bilgi_formu").validate();
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
</script>