<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=gorev_alanlar&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
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
	<div class="form_element cf_placeholder"> 
		<label class="cf_label" style="color:red;">Not: Bu kısım Resmi Gazete’de yayımlanmayacaktır. Sadece MYK web sitesinde yer alacaktır.</label>
	</div> 
</div>

<br />
<br />

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">Ek: Meslek Standardı Hazırlama Sürecinde Görev Alanlar</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">1. Meslek Standardı Hazırlayan Kuruluşun Meslek Standardı Ekibi</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar1_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2. Teknik Çalışma Grubu Üyeleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar2_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3. Görüş İstenen Kişi, Kurum ve Kuruluşlar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar3_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">4. MYK Sektör Komitesi Üyeleri ve Uzmanlar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar4_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">5. MYK Yönetim Kurulu</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar5_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('gorev_alanlar', <?php echo $this->standart_id;?>)"/>
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

// 3. "required" alani silindi:
var gorevAlan = new Array(new Array("text","","4","",readOnly),	
				          new Array("text","required", "25","",readOnly),	
				          new Array("text","", "25","",readOnly),	
					      new Array("text","", "50","",readOnly)); ///
						  
var gorevAlanx = new Array(new Array("text","","4","",readOnly),	
				          new Array("text","required", "25","",readOnly),	
				          new Array("text","required", "25","",readOnly),	
					      new Array("text","required", "50","",readOnly)); ///
						  
dTables.gorevAlanlar1 = gorevAlan;
dTables.gorevAlanlar2 = gorevAlan;
dTables.gorevAlanlar3 = new Array(new Array("text","","4","",readOnly),	
								  new Array("text","", "25","",readOnly),	
						          new Array("text","", "25","",readOnly),	
							      new Array("text","", "50","",readOnly));
dTables.gorevAlanlar4 = gorevAlanx;
dTables.gorevAlanlar5 = gorevAlanx;

function createTables(){
	var tableCount = 5;
	for (var i = 1; i < tableCount + 1; i++){
		var tableName = "gorevAlanlar" + i; 
		var headers = new Array ('Sıra No','Ad / Soyad', 'Unvan', 'Kurum / Kuruluş');
		createTable(tableName, headers);
		patchSatirEkle(tableName, headers, tableName);
		addGorevAlanValues (gorevAlan, tableName, i);
	
		if (isReadOnly){
			satirEkleKaldir (tableName);
			satirSilKaldir (tableName, 3);
		}
	}
}

function addGorevAlanValues (gorevAlan, name, gorevTur){
	var length = gorevAlan.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = gorevAlan[i][0];
	}
	
	<?php
	$gorev = $this->gorevAlan;
	$yonetimKurulu = $this->yonetimKurulu;
	$tableCount = count($gorev);
	
	for ($i=0; $i< $tableCount; $i++) {
		$c = 0;
		$k = 1;
		$data = $gorev[$i]; 
		if ($data != null){
			echo "arr[".$i."] = new Array ();";
			foreach ($data as $row){
				echo 'arr['.$i.']['.$c++.']= "'. $k++ .'";';
				echo 'arr['.$i.']['.$c++.']= "'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'";';
				echo 'arr['.$i.']['.$c++.']= "'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'";';
				echo 'arr['.$i.']['.$c++.']= "'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'";';
			}
		}
	}
	$c = 0;
	$k = 1;
	$data = $yonetimKurulu;
	if($data !=null){
		echo "arr[4] = new Array();";
		foreach ($data as $row){
			echo 'arr[4]['.$c++.']= "'. $k++ .'";';
			echo 'arr[4]['.$c++.']= "'. FormFactory::normalizeVariable ($row["AD_SOYAD"]) .'";';
			echo 'arr[4]['.$c++.']= "'. FormFactory::normalizeVariable ($row["UNVAN"]) .'";';
			echo 'arr[4]['.$c++.']= "'. FormFactory::normalizeVariable ($row["KURUM"]) .'";';
		}
	}
	?>

	if (isset (arr[gorevTur-1]))
		addGorevTableValues (arr[gorevTur-1], params, name);
}

function addGorevTableValues (arr, params, name){
	var colCount  = params.length;
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;

	document.getElementById("rowNumber-"+name).value = rowNumber;
	addNRow (name,colCount,name);
	rowAdded(name, name);
	document.getElementById("rowNumber-"+name).value = 1;
	
	//Add the values to table
	var count = 0;
	for (var i = 0; count < arrLength; i++){
		for (var j = 0; j < colCount; j++){ 
			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
			
		    if (params[j] == "text" || params[j] == "textarea"){
		    	item.value = arr[count];
		    }else if (params[j] == "combo"){
		    	for (var k = 0; k < item.length; k++){
		        	if(item.options[k].value == arr[count])
		            item.options[k].selected = "selected";
		        }
		    }
		    count++;  
		}
	}
}
</script>