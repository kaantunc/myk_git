<?php 
$kurulus = $this->kurulus_bilgi;
$iller	 = $this->iller;
?>
<form onsubmit="return validate('kurulus_edit_form')"
	  action="index.php?option=com_kurulus_edit&amp;layout=kurulus_bilgi&amp;task=kurulusGuncelle&amp;id=<?php echo $this->user_id?>&amp;tur=<?php echo $this->kurulus_tur?>"
	  enctype="multipart/form-data" method="post"
	  id="kurulus_edit_form"
	  name="kurulus_edit_form">

	<?php echo $this->pageTree;?>

	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">KURULUŞ BİLGİLERİ</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h3 class="contentheading">İletişim Bilgileri</h3>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Adı</label>
	    <input class="cf_inputbox required" maxlength="150" size="30"  id="text_1" name="ad" type="text" value="<?php echo $kurulus["KURULUS_ADI"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Yetkilisi</label>
	    <input class="cf_inputbox" maxlength="150" size="30"  id="text_4" name="yetkili" type="text" value="<?php echo $kurulus["KURULUS_YETKILISI"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Yetkili Unvanı</label>
	    <input class="cf_inputbox" maxlength="150" size="30"  id="text_5" name="unvan" type="text" value="<?php echo $kurulus["KURULUS_YETKILI_UNVANI"];?>" />
	  
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
	    <label class="cf_label" style="width: 150px;">Adresi</label>
	    <textarea class="cf_inputbox" rows="3" id="text_3" title="" cols="30" name="adres" ><?php echo $kurulus["KURULUS_ADRESI"];?></textarea>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Posta Kodu</label>
	    <input class="cf_inputbox numeric" maxlength="150" size="30"  id="text_7" name="posta_kodu" type="text" value="<?php echo $kurulus["KURULUS_POSTA_KODU"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder"><?php 
		$data = $this->pm_il;
	?>
	<label class="cf_label" style="width:150px;">Şehir</label>
	<select id="sehir" class="cf_inputbox" name="sehir" title="" size="1" >
	<option value="Seçiniz">Seçiniz</option>
	<?php
	if(isset($data)){
	foreach ($data as $row){
	  if ($row["IL_ID"] != 0 && $kurulus["KURULUS_SEHIR"] == $row["IL_ID"])
	     $selected = 'selected="selected"';
	  else 
	     $selected = '';
	
	  echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
	}
	}
	?>
	</select></div>
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
	    <label class="cf_label" style="width: 150px;">Telefon</label>
	    <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_9" name="telefon" type="text" value="<?php echo $kurulus["KURULUS_TELEFON"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Faks</label>
	    <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_10" name="faks" type="text" value="<?php echo $kurulus["KURULUS_FAKS"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">E-Posta</label>
	    <input class="cf_inputbox e-mail" maxlength="150" size="30"  id="text_11" name="eposta" type="text" value="<?php echo $kurulus["KURULUS_EPOSTA"];?>" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Web</label>
	    <input class="cf_inputbox url" maxlength="150" size="30"  id="text_12" name="web" type="text" value="<?php echo $kurulus["KURULUS_WEB"];?>" />
	  
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
	<?php 
	$data = $this->pm_il;
	?>
	
	<label class="cf_label" style='width:150px;'>Varsa faaliyette bulunduğu diğer iller</label>
	<select id="list" name="iller[]" size="10" title="" style='width:150px;' multiple>
		<?php
		if(isset($data)){
			foreach ($data as $row){
				if (isset ($iller)){
					$selected = '';
					for ($i = 1; $i < count($iller); $i++){
						if ($iller[$i] == $row["IL_ID"]){
							$selected = 'selected';
							break;
						}
					}
	
				}
				echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
			}
		}
		?>
	</select></div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h3 class="contentheading">2.Kuruluşun Statüsü</h3>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder"><?php 
		$data = $this->pm_kurulus_statu;
	?>
	<label class="cf_label" style="width:150px;">Statüsü</label>
	<select id="statu" class="cf_inputbox" name="statu" title="" size="1" >
	<option value="Seçiniz">Seçiniz</option>
	<?php
	if(isset($data)){
		foreach ($data as $row){
		  if ($kurulus["KURULUS_STATU_ID"] == $row["KURULUS_STATU_ID"])
		     $selected = 'selected="selected"';
		  else 
		     $selected = '';
		
		  echo "<option ".$selected." value='".$row['KURULUS_STATU_ID']."'> ".$row['KURULUS_STATU_ADI']."</option>";
		}
	}
	?>
	</select></div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"></h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
<?php if(empty($kurulus["LOGO"])){?>
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
	    <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" id="text_13" name="logo" type="file"/>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
<?php }
	else{?>
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
	    <input class="cf_inputbox uppercase" maxlength="150" size="30" title="" id="text_13" name="logo" type="file" value="<?php echo $kurulus["LOGO"];?>"/>
	  	<a href="index.php?dl=kurulus_logo/<?php echo $kurulus["USER_ID"].'/'.$kurulus["LOGO"];?>">Görüntüle</a>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
<?php }?>
		
	<br/>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
</form>
<br/>
<hr/>

<div class="form_item" style="padding-top: 15px; font-style:italic;">
	<p>(1)-Kuruluş logosu maksimum 2,43 cm yükseklik ve 5,61 cm genişliğinde, .jpg veya .gif formatında olmalıdır.</p>
	<div class="cfclear">&nbsp;</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function (){	
	jQuery("#irtibatTelFax").live("focus",function (){
			jQuery(this).mask("9999999999");
		})
});
</script>