<?php 

?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=ek_degerlendirme&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
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
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 3 : Yeterlilikte Belirtilen Değerlendirme Araçları İle Ölçülen Öğrenme Çıktılarına İlişkin Tablo</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="degerlendirme_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_degerlendirme', <?php echo $this->yeterlilik_id;?>)"/>
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

//DEGERLENDIRME
<?php
$dataO = array_merge($this->teorikOlcme, $this->performansOlcme);
$dataO = subval_sort($dataO, 'DEGERLENDIRME_ARAC_ADI');
$dataB = array_merge($this->bilgi, $this->beceri, $this->yetkinlik);
$dataB = subval_sort($dataB, 'BECERI_YETKINLIK_ADI');
$r = 'dTables.degerlendirme = new Array(new Array("combo", new Array(';
$so = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($dataO)){
  foreach ($dataO as $row){
      $id 	 = $row["DEGERLENDIRME_ARAC_ID"];
      $value = FormFactory::normalizeVariable ($row["DEGERLENDIRME_ARAC_ADI"] );
      $so .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$sb = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($dataB)){
  foreach ($dataB as $row){
      $id 	 = $row["BECERI_YETKINLIK_ID"];
      $value = FormFactory::normalizeVariable ($row["BECERI_YETKINLIK_ADI"] );
      $sb .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$so = substr ($so, 0, strlen($so)-1);
$sb = substr ($sb, 0, strlen($sb)-1);
$r = $r.$so.'),"comboReq", "", "250"), new Array("combo", new Array('.$sb.'),"comboReq", "", "250"));';
echo $r;
?>
//DEGERLENDIRME SON

//dTables.degerlendirme =  new Array(new Array("text","","40", "", readOnly),new Array("text","","40", "", readOnly));

function createTables(){
	var tableName = 'degerlendirme'; 
	createTable(tableName, new Array ('Değerlendirme Aracı', 'Ölçülen Öğrenme Çıktıları'));
	addDegerlendirmeValues (dTables.degerlendirme, tableName);
	
	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}

function addDegerlendirmeValues (degerlendirme, name){
	var length = degerlendirme.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = degerlendirme[i][0];
	}
	<?php
	$tableCount = count ($this->degerlendirme_ogrenme);

	$c = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->degerlendirme_ogrenme[$i];
		
		echo 'arr['.$c++.']= "'. $arr["DEGERLENDIRME_ARAC_ID"] .'";';
		echo 'arr['.$c++.']= "'. $arr["BECERI_YETKINLIK_ID"] .'";';
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name);
}
</script>
<?php
function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	if ($b != NULL){
		asort($b);
	
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
	}
	
	return $c;
}
?>
