<?php 
$taslakYeterlilik = $this->taslakYeterlilik;
$teorikOlcme = $this->teorikOlcme;
$performansOlcme = $this->performansOlcme;

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=olcme_ve_degerlendirme&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">ÖLÇME ve DEĞERLENDİRME</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?> 
			id="ortam" title="" cols="50" name="ortam"><?php echo $taslakYeterlilik["YETERLILIK_ORTAM"];?></textarea>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('olcme_ve_degerlendirme', <?php echo $this->yeterlilik_id;?>)"/>
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

var degerlendirme = new Array(new Array("text","required", "","", readOnly),	
							  new Array("text","required", "","", readOnly), 
							  new Array("text","required", "","", readOnly),	
							  new Array("text","required", "","", readOnly),
							  new Array("textarea", "required", "3","25", readOnly));

dTables.teorik		= degerlendirme;
dTables.performans  = degerlendirme;

function createTables(){
	var tableCols = new Array ('Değerlendirme Araçları', 'Değerlendirme Materyalleri', 'Puanlama', 'Başarım Ölçütü', 'Gerekli Görülen Diğer Şartlar');
	var tableName = 'teorik';
	createTable(tableName, tableCols);
	addTeorikValues (dTables.teorik, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 5);
	}
	
	tableName = 'performans';
	createTable(tableName, tableCols);
	addPerformansValues (dTables.performans, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 5);
	}		
}
	
function addTeorikValues (degerlendirme, name){
	var length = degerlendirme.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = degerlendirme[i][0];
	}
	<?php
	$tableCount = count ($teorikOlcme);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->teorikOlcme[$i];
		echo 'arrId['.$id++.']= "'.$arr["DEGERLENDIRME_ARAC_ID"].'";';
		
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_ARAC_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_MATERYAL"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_PUANLAMA"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_BASARI_OLCUT"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_DIGER"]) .'";';
	}
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name, arrId, true);
}

function addPerformansValues (degerlendirme, name){
	var length = degerlendirme.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = degerlendirme[i][0];
	}
	<?php
	$tableCount = count ($performansOlcme);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->performansOlcme[$i];
		echo 'arrId['.$id++.']= "'.$arr["DEGERLENDIRME_ARAC_ID"].'";';
		
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_ARAC_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_MATERYAL"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_PUANLAMA"] ).'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_BASARI_OLCUT"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DEGERLENDIRME_DIGER"]) .'";';
	}
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name, arrId, true);
}
</script>