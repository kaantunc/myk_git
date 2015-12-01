<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=zorunlu&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
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
  	<h2 class="contentheading">Grup A: Zorunlu Yeterlilik Birimleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="3"
			id="zorunlu_aciklama" title="" cols="50" name="zorunlu_aciklama"><?php echo $this->taslakYeterlilik["ZORUNLU_ACIKLAMA"] ? $this->taslakYeterlilik["ZORUNLU_ACIKLAMA"] : "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="zorunlu_birim_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('zorunlu', <?php echo $this->yeterlilik_id;?>)"/>
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

dTables.zorunlu_birim = new Array(new Array("text","","4", "", readOnly),	
						   		  new Array("text","required", "40", "", readOnly)
						   		);

function createTables(){
	var tableName = 'zorunlu_birim'; 
	var headers	  = new Array ('Sıra No', 'Birim Adı');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addZorunluValues (dTables.zorunlu_birim, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addZorunluValues (zorunlu, name){
	var length = zorunlu.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = zorunlu[i][0];
	}
	<?php
	$tableCount = count ($this->zorunluBirim);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->zorunluBirim[$i];
		
		echo 'arrId['.$id++.']= "'.$arr["YETERLILIK_ALT_BIRIM_ID"].'";';
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_ADI"]) .'";';
		//echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_KREDI"]) .'";';
	}
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name, arrId);
}
</script>