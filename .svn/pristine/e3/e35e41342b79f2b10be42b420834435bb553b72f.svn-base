<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly=\"readOnly\"";
	
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=meslek_tanitimi&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">
	
<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">2. MESLEK TANITIMI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.1. Meslek Tanımı</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="8" <?php echo $readOnly;?> 
			id="meslek_tanimi" title="" cols="100" name="meslek_tanimi"><?php if (isset($this->meslekTanitim["MESLEK_TANIM"])) echo $this->meslekTanitim["MESLEK_TANIM"]; else echo "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.2. Mesleğin Uluslararası Sınıflandırma Sistemlerindeki Yeri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="meslekStandart_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.3. Sağlık, Güvenlik ve Çevre ile İlgili Düzenlemeler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="8" <?php echo $readOnly;?> 
			id="duzenleme" title="" cols="100" name="duzenleme"><?php if (isset($this->meslekTanitim["MESLEK_SAGLIK_DUZENLEME"])) echo $this->meslekTanitim["MESLEK_SAGLIK_DUZENLEME"]; else echo "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.4. Meslek ile İlgili Diğer Mevzuat</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?> 
			id="mevzuat" title="" cols="100" name="mevzuat"><?php if (isset($this->meslekTanitim["MESLEK_MEVZUAT"])) echo $this->meslekTanitim["MESLEK_MEVZUAT"]; else echo "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.5.	Çalışma Ortamı ve Koşulları</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="8" <?php echo $readOnly;?> 
			id="kosul" title="" cols="100" name="kosul"><?php if (isset($this->meslekTanitim["MESLEK_CALISMA_KOSUL"])) echo $this->meslekTanitim["MESLEK_CALISMA_KOSUL"]; else echo "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2.6.	Mesleğe İlişkin Diğer Gereklilikler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?> 
			id="gereklilik" title="" cols="100" name="gereklilik"><?php if (isset($this->meslekTanitim["MESLEK_GEREKLILIK"])) echo $this->meslekTanitim["MESLEK_GEREKLILIK"]; else echo "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('meslek_tanitimi', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv_Kurulus;

if (!$this->sektorSorumlusu && $this->yorumDiv_Kurulus!=""){
	?>
    <div style="width:100%;float: none;text-align:center;">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet_Kurulus('bilgi_beceri', <?php echo $this->standart_id;?>)"/>
	</div>
<?php 
}


?>

</form>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";
		
dTables.meslekStandart = new Array(new Array("text","","4", "", readOnly),
		                       	   new Array("text","required","30" , "", readOnly),	
								   new Array("textarea", "", "5","60", readOnly));

function createTables(){
	var tableName = 'meslekStandart';
	var headers = new Array ('Sıra No', 'Uluslararası Sınıflandırma Sistemi Adı', 'Açıklama');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addMeslekStandartValues (dTables.meslekStandart, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addMeslekStandartValues (meslekStandart, name){
	var length = meslekStandart.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = meslekStandart[i][0];
	}
	<?php
	$tableCount = count ($this->meslekStandart);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->meslekStandart[$i];
		echo 'arrId['.$id++.']= "'. $arr["STANDART_ID"] .'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ADI"]) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ACIKLAMA"]) .'";';
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}

</script>