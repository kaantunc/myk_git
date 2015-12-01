<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=bilgi_beceri&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
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
  	<h2 class="contentheading">3.3.	Bilgi ve Beceriler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="bilgiBeceri_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('bilgi_beceri', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}


echo $this->yorumDiv_Kurulus;

if (!$sektorSorumlusu && !$this->yorumDiv_Kurulus!=""){
	?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('bilgi_beceri', <?php echo $this->standart_id;?>)"/>
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
		
dTables.bilgiBeceri = new Array(new Array("text","","4", "", readOnly),	
							    new Array("text","required", "100", "", readOnly));

function createTables(){
	var tableName = 'bilgiBeceri'; 
	var headers = new Array ('Sıra No', 'Bilgi / Beceri');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addBilgiBeceriValues (dTables.bilgiBeceri, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}

function addBilgiBeceriValues (bilgiBeceri, name){
	var length = bilgiBeceri.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = bilgiBeceri[i][0];
	}
	<?php
	$tableCount = count ($this->bilgiBeceri);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->bilgiBeceri[$i];
		echo 'arrId['.$id++.']= "'. $arr["BILGI_BECERI_ID"] .'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BILGI_BECERI_ADI"])  .'";';
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}
</script>