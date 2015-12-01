<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=hazirlayan&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	enctype="multipart/form-data" method="post"
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />

<?php 
echo $this->pageTree;
?>

<!--<div class="form_item">-->
<!--	<div class="form_element cf_placeholder"> -->
<!--		<label class="cf_label" style="color:red;">Not: Bu kısım Sektör Sorumlusu tarafından düzenlenecektir.</label>-->
<!--	</div> -->
<!--</div>-->
<!---->
<!--<br/>-->
<!--<br/>-->

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">STANDARDI HAZIRLAYAN KURULUŞ(LAR)</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="hazirlayan_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('hazirlayan', <?php echo $this->standart_id;?>)"/>
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
/*if (isReadOnly)
	readOnly = "readOnly";*/

dTables.hazirlayan = new Array(new Array("text"	, "","4", "",readOnly),
							   new Array("text"	, "required","100" , "",readOnly),
							   new Array("radio", new Array(new Array("1","Yüklenici", "checked"), new Array("2","Yardımcı")),"100" , "",readOnly)
							);

function createTables(){
	var tableName = 'hazirlayan';
	var headers = new Array ('#','Standardı Hazırlayan Kuruluş(lar)', 'Yardımcı/Yüklenici Kuruluş'); 
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);

	addHazirlayanValues (dTables.hazirlayan, tableName);
/*	document.getElementById("satirSil_" + tableName + "-1").setAttribute("disabled", "disabled");
	document.getElementById("input" + tableName + "-2-1").setAttribute("readOnly", "readonly");
	document.getElementById("input" + tableName + "-3-1-0").checked = true;
	document.getElementById("input" + tableName + "-3-1-0").setAttribute("disabled", "disabled");
	document.getElementById("input" + tableName + "-3-1-1").setAttribute("disabled", "disabled");
*/	
	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}

function addHazirlayanValues (hazirlayan, name){
	var length = hazirlayan.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = hazirlayan[i][0];
	}
	<?php
	$tableCount = count ($this->hazirlayan);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->hazirlayan[$i];
		
 			echo 'arrId['.$id++.']= -2;';
 			echo 'arr['.$c++.']= "'. ($i+1) .'";';
 			if ($arr["HAZIRLAYAN_KURULUS_ADI"]){
 				echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["HAZIRLAYAN_KURULUS_ADI"]) .'";';
 			} else {
 				echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["KURULUS_ADI"]) .'";';
 			}
 			echo 'arr['.$c++.']= "'. $arr["KURULUS_TURU"] .'";';

// 		if ($i == 0){
// 			echo 'arrId['.$id++.']= -2;';
// 			echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 			echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["KURULUS_ADI"]) .'";';
// 			echo 'arr['.$c++.']= "'. $arr["KURULUS_TURU"] .'";';
// 		}
		
// 		// Bu haliyle HAZIRLAYAN_ID olmadıgında da if'e giriliyor. O yuzden empty() ile kontrol edildi.
// 		// if ($arr["HAZIRLAYAN_ID"])
// 		if (!empty($arr["HAZIRLAYAN_ID"])){
// 			echo 'arrId['.$id++.']= "'. $arr["HAZIRLAYAN_ID"] .'";';
// 			echo 'arr['.$c++.']= "'. ($i+2) .'";';
// 			echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["HAZIRLAYAN_KURULUS_ADI"]) .'";';
// 			echo 'arr['.$c++.']= "'. $arr["KURULUS_TURU"] .'";';
// 		}
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}
</script>