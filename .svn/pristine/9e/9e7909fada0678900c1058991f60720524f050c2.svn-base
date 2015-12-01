<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=tutum_davranis&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3.4.	Tutum ve Davranışlar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="tutumDavranis_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('tutum_davranis', <?php echo $this->standart_id;?>)"/>
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
		
dTables.tutumDavranis = new Array(new Array("text","","4", "", readOnly),	
							      new Array("text","required","100", "", readOnly));

function createTables(){
	var tableName = 'tutumDavranis';
	var headers = new Array ('Sıra No', 'Tutum / Davranış');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addTutumValues (dTables.tutumDavranis, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}

function addTutumValues (tutum, name){
	var length = tutum.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = tutum[i][0];
	}
	<?php
	$tableCount = count ($this->tutumDavranis);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->tutumDavranis[$i];
		echo 'arrId['.$id++.']= "'. $arr["TUTUM_DAVRANIS_ID"] .'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["TUTUM_DAVRANIS_ADI"]) .'";';
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}
</script>