<?php 
$taslakYeterlilik = $this->taslakYeterlilik;

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=tanitim&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">ULUSLARARASI SINIFLAMADAKİ YERİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_element cf_heading">
<a href="http://tuikapp.tuik.gov.tr/DIESS/SozlukDetayiGetirAction.do?surumId=210&ustKod=yok&duzey=0" target="_blank">ISCO 08 Uluslararası Standart Meslek Sınıflaması</a>
</div>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="standart_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>	

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">AMAÇ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5"  <?php echo $readOnly;?> 
			id="amac" title="" cols="60" name="amac"><?php echo $taslakYeterlilik["YETERLILIK_AMAC"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input id="KaydetButton" value="Kaydet" name="kaydet" type="button" />
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('tanitim', <?php echo $this->yeterlilik_id;?>)"/>
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

dTables.standart = new Array(new Array("text","required","4", "", readOnly),
		                       	   new Array("text","required","" , "", readOnly),	
								   new Array("textarea", "", "3","30", readOnly));

jQuery('#KaydetButton').live('click', function (e) {
    e.preventDefault();

    if(jQuery('input[name="inputstandart-2[]"]').length == 0)
        alert("En az bir değer girmek zorunludur");
    else
    	jQuery('#ChronoContact_yeterlilik_taslak').submit();
 	// Stop event handling in IE
    return false;
} );
								   
function createTables(){
	var tableName = 'standart';
	var headers = new Array ('Sıra No', 'Uluslararası Standart Adı', 'Açıklama');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addStandartValues (dTables.standart, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addStandartValues (standart, name){
	var length = standart.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = standart[i][0];
	}
	<?php
	$tableCount = count ($this->standart);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->standart[$i];
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ADI"]) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ACIKLAMA"]) .'";';
	}
	
	?>
	
	if (isset (arr))
		addTableValues (arr, params, name);
}

</script>