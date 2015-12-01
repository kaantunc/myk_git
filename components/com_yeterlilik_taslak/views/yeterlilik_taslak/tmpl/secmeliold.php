<?php 
$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=secmeli&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİĞİ OLUŞTURAN YETERLİLİK BİRİMLERİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Grup B: Seçmeli Yeterlilik Birimleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="3" <?php echo $readOnly;?>
			id="secmeli_aciklama" title="" cols="50" name="secmeli_aciklama"><?php echo $this->taslakYeterlilik["SECMELI_ACIKLAMA"] ? $this->taslakYeterlilik["SECMELI_ACIKLAMA"] : "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="secmeli_birim_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">BİRİMLERİN GRUPLANDIRMA ALTERNATİFLERİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="alternatif" title="" cols="50" name="alternatif"><?php echo $this->taslakYeterlilik["YETERLILIK_GRUP_ALTERNATIF"];?></textarea>
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

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('secmeli', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
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

dTables.secmeli_birim = new Array(new Array("text","","4", "", readOnly),
								  new Array("text","required", "40", "", readOnly),
								  new Array("text","numeric", "5", "", readOnly));

function createTables(){
	var tableName = 'secmeli_birim'; 
	var headers   = new Array ('Sıra No', 'Birim Adı', 'Kredi Değeri');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addSecmeliValues (dTables.secmeli_birim, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addSecmeliValues (secmeli, name){
	var length = secmeli.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = secmeli[i][0];
	}
	<?php
	$tableCount = count ($this->secmeliBirim);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->secmeliBirim[$i];
		echo 'arrId['.$id++.']= "'.$arr["YETERLILIK_ALT_BIRIM_ID"].'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_KREDI"]) .'";';
	}
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name, arrId);
}
</script>