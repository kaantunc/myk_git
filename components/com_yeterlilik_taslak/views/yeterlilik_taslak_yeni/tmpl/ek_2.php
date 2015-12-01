<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_2&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">EKLER</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="3"
			id="terim_aciklama" title="" cols="105" name="terim_aciklama"><?php echo $this->taslakYeterlilik["TERIM_ACIKLAMA"] ? $this->taslakYeterlilik["TERIM_ACIKLAMA"] : "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK2 : Terimler, Simgeler ve Kısaltmalar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="terimKisaltma_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<br />
<br />

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div >ifade eder.</div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_2', <?php echo $this->standart_id;?>)"/>
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

dTables.terimKisaltma = new Array(new Array("text"	, "","4", "",readOnly),
								  new Array("text"	, "required","35" , "",readOnly),	
								  new Array("textarea", "required","3" , "50",readOnly));

function createTables(){
	var tableName = 'terimKisaltma';
	var headers = new Array ('Sıra No','Terim/Kısaltma Adı', 'Açıklama'); 
	createTable(tableName, headers);
	patchSatirEkle (tableName, headers, tableName);

	addTerimValues (dTables.terimKisaltma, tableName);
	
	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addTerimValues (terim, name){
	var length = terim.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = terim[i][0];
	}
	<?php
	$tableCount = count ($this->terim);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->terim[$i];
		//echo 'arrId['.$id++.']= "'. $arr["TERIM_ID"] .'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["TERIM_ADI"]) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["TERIM_ACIKLAMA"]) .'";';
	}
	
	?>
	
	if (isset (arr)){
		//addTableValues (arr, , params, name, arrId);
		addTableValues (arr, params, name);
	}
}
</script>