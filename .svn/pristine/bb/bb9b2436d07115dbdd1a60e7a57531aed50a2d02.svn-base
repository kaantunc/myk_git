<?php 
$data = $this->ek_8;
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_8&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 8 : Yeterliliğin Kazanılmasında Uygulanacak Ölçütlerin Belirlenmesi Amacıyla Gerçekleştirilen Pilot Çalışmaya Yönelik Bilgiler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="ekler_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_8', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<script type="text/javascript">
function removeUploaded(id, sira){
	// dosya adini silmesi için submit et
	document.getElementById(id +'_upload_form_span_'+sira).style.height='24px';
	document.getElementById(id +'_upload_process_'+sira).style.height='0px';
	document.getElementById(id +'_upload_form_span_'+sira).style.visibility = 'visible';
	//document.getElementById(id +'_form_div_'+sira).style.visibility = 'visible';
	} 

	
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";

dTables.ekler = new Array(new Array("text", "required"), new Array("upload"));

function createTables(){
	createTable('ekler', new Array ('Açıklama', 'Belge Gönderimi'));

	tableName = 'ekler';
	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}

	addEkValues (dTables.ekler, 'ekler', 1);
}

function addEkValues (ek, name, colCount){
	var length = ek.length;
	var params = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = ek[i][0];
	}
	var arr 	 = new Array ();
	var aciklama = new Array ();
	<?php
	$tableCount = count ($data);

	$c = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arr['.$c++.']= "'.FormFactory::normalizeVariable ($arr["BASVURU_EK_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_ID"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_PATH"]) .'";';
		echo 'aciklama['.$i.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_ACIKLAMA"]) .'";';
	}
	
	?>
	if (isset (arr)){
		addTableValues (aciklama, params, name, null, true, colCount);

		for (var i = 0; i < aciklama.length; i++){
			var fileName = arr[i*3];
			var ekId = arr[(i*3)+1];
			var destinationPath = arr[(i*3)+2];
			var id		 = name + "_0";
			var sira	 = i+1;

			//alert(id);

			var formDiv = document.getElementById(name + "_div");
			var inputPath = document.createElement("input");
			inputPath.setAttribute("type", "hidden");
			inputPath.setAttribute("id", "ek_id_"+sira);
			inputPath.setAttribute("name","ek_id_"+sira);
			inputPath.setAttribute("value", ekId);
			formDiv.appendChild (inputPath);

			var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
			var inputPath = '<input type="hidden" value="'+destinationPath+'" name="path_'+id+'_'+sira +'">' +
				 			'<input type="hidden" value="1_'+fileName+'" name="filename_'+id+'_'+sira +'">';
			var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
			var tableName = 'ekler_0';
			result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded2(\''+tableName+'\',\''+id+'\',\''+sira+'\')" /><\/div>';
			resultDiv.innerHTML = result;
		
			var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
			uploadSpan.style.visibility = 'hidden';
			uploadSpan.style.height = 0;
		}
	}
}
</script>
