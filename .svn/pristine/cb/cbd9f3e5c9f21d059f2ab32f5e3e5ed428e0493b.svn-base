<?php 
//print_r($this->yetkiTalep);
$basvuru = $this->basvuru;
?>

<form
	onsubmit="return validate('ChronoContact_akreditasyon_basvuru_t4')"
	action="index.php?option=com_akreditasyon_basvur&amp;layout=faaliyet&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_akreditasyon_basvuru_t4"
	name="ChronoContact_akreditasyon_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">5. Faaliyet gösterdiği sektör(ler) </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder"><div id="sektor_div">
</div></div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">6. Faaliyet alanları </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder"><div id="faaliyet_div">
</div></div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">7. Faaliyet süresi </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_radiobutton">
	<div class="float_left">
	<?php 
	$data = $this->pm_faaliyet_sure;
	
	if(isset($data)){
		$i = 0;
		$name = "radio0";
		foreach ($data as $row){
			$checked = "";
			if ($row[0] == $basvuru["FALIYET_SURE_ID"])
				$checked = "checked=\"checked\"";
				
			echo '<input '.$checked.' value="'.$row[0].'" title="" class="radio" id="'.$name.$i.'" name="'.$name.'" type="radio" /> 
				  <label for="'.$name.$i.'" class="radio_label">'.$row[1].'</label><br />';
			$i++;
		}
	}
	?></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">8.	Kuruluşun sürekli çalışan personel sayısı ile eğitim akreditasyonu faaliyetlerinde görev yapan personel sayısı</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textbox"><label class="cf_label"
		style="width: 250px;">a) Sürekli Çalışan Personel Sayısı</label> <input
		class="cf_inputbox numeric" maxlength="150" size="5" id="personel_sayisi"
		name="personel_sayisi" type="text" value="<?php echo $basvuru["PERSONEL_SAYISI"]; ?>"/></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textbox"><label class="cf_label"
		style="width: 250px;">b) Görevli Personel Sayısı</label> <input
		class="cf_inputbox numeric" maxlength="150" size="5" id="kisi_sayisi"
		name="kisi_sayisi" type="text" value="<?php echo $basvuru["EKIP_SAYISI"]; ?>"/></div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">9. Kuruluşun yetkilendirilme talebine ilişkin bilgiler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
  <textarea name="akreditasyonFaaliyetAciklama" style="width:450px; height:60px;"><?php echo $basvuru['AKREDITASYON_FAALIYETI_ACK']; ?></textarea>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder"><div id="yetkiTalep_div">
</div></div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">10. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE = "";
$checkedH = ""; 

if ($this->birlikteKurulus != null)
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";
?>

<div class="form_item">
  <div class="form_element cf_radiobutton">
    <div class="float_left">
      <input <?php echo $checkedE; ?> value="1" title="" class="radio" id="radio20" name="radio2" type="radio" onclick="hideShowSelected(Array('block'), Array('id_8'))"/>
      <label for="radio20" class="radio_label">Evet</label>
      <br />
      
<input <?php echo $checkedH; ?> value="0" title="" class="radio" id="radio21" name="radio2" type="radio" onclick="hideShowSelected(Array('none'), Array('id_8'))"/>
      <label for="radio21" class="radio_label">Hayır</label>
      <br />
    </div>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div style="display:none;" id="id_8">
<div class="form_item">
  <div class="form_element cf_placeholder">
     <div id="kurulus_panel_div" class="panel_main_div"></div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</div> 

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">11.	Eğitim akreditasyonu çalışmaları için tahsis edilen kaynaklar, teknik ve fiziki altyapı imkânları</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="3" 
    	id="fiziki" title="" cols="50" name="fiziki"><?php echo $basvuru["ALTYAPI_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="button" onclick="submitForm()" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

</form>

<script type="text/javascript">

jQuery(document).ready(function(){
	hideShowRadioButtonText ();
});

//SEKTORLER
<?php
$data = $this->pm_sektor;

$r = 'dTables.sektor = new Array( new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id = $row[0];
      $value = $row[1];
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq"), new Array ("text", "", "65"));';
echo $r;
?>
//SEKTORLER SONU

//KURULUS PANEL
<?php
$param = array ($this->pm_kurulus_statu, $this->pm_il);
$k = '),"comboReq"), new Array("Yetkilisi", "text"), new Array("Adresi", "textarea"), new Array("Şehir", "combo", new Array(';
$r = 'dPanels.kurulus_panel =  new Array("Kuruluşun;", new Array("Adı", "text"), new Array("Statüsü", "combo", new Array(';
$p = '';

for ($i = 0; $i < count ($param); $i++){
$data = $param[$i];

$s = 'new Array ("Seçiniz", "Seçiniz"),';
if(isset($data)){
  foreach ($data as $row){
      $id = $row[0];
      $value = $row[1];
      if ($id != 0)
          $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$p .= $s.$k;

$k = '),"comboReq"), new Array("Posta Kodu", "text", "numeric"), new Array("Telefon", "text", "numeric"), new Array("Faks", "text", "numeric"), new Array("E-Posta", "text", "e-mail"), new Array("Web", "text", "url"));';
}
$r .= $p;
echo $r;
?>
//KURULUS PANEL SONU

//YETKI TALEP
<?php
$r = 'dTables.yetkiTalep = new Array( new Array("combo", new Array (';
$k ='new Array("text", "numeric"),new Array("text", "numeric"));';
$data = $this->pm_yeterlilik_ad;

$s = 'new Array ("Seçiniz", "Seçiniz"),';
$yetAdi = "";
if(isset($data)){
    foreach ($data as $row){
        if ($row[1] != $yetAdi){
        	$s .= 'new Array ("'.FormFactory::normalizeVariable ($row[0]).'","'.FormFactory::normalizeVariable ($row[1]).'"),';
    		$yetAdi = $row[1];
    	}
    }
}

$s = substr ($s, 0, strlen($s)-1);
$r .= $s.'),"","xmlhttpPost(seviyeCheck,\'index2.php?option=com_akreditasyon_basvur&layout=faaliyet&chosen=1\',seviyeGetQueryString, seviyeUpdatePageFunction, this)"),new Array("combo", new Array (new Array("Seçiniz","Seçiniz"), new Array("1","Seviye 1"), new Array("2","Seviye 2"), new Array("3","Seviye 3"), new Array("4","Seviye 4"), new Array("5","Seviye 5"), new Array("6","Seviye 6"), new Array("7","Seviye 7"), new Array("8","Seviye 8")),"comboReq"),'.$k;
echo $r;
?>
// YETKI TALEP SONU

dTables.faaliyet = new Array(new Array("text", "required", "80"));

function createTables(){
	var tableName = "sektor";
	createTable( tableName, new Array ('Faaliyet Gösterdiği Sektör(ler)', 'Açıklama'));
	addSektorValues (dTables.sektor, tableName);

	tableName = "faaliyet";
	createTable(tableName, new Array ('Faaliyet Alanları'));
	addFaaliyetValues (dTables.faaliyet, tableName);
	
	tableName = "yetkiTalep";
	createTable(tableName , new Array('Yeterliliğin Adı',
                                	  'Seviyesi',
                                	  'Başvuru tarihine kadar verilmiş belge sayısı',
                                	  'Başvuru tarihine kadar gerçekleştirilmiş sınav sayısı'));
	addYetkiTalepValues (dTables.yetkiTalep, tableName);
}

function createPanels (){
	createAddKurulusValues ("kurulus_panel", "Kuruluş");
}

function addSektorValues (sektor, name){
	var length = sektor.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = sektor[i][0];
	}
	
	<?php
	$data = $this->sektor;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arrId['.$id++.']= "'. $arr["SEKTOR_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ID"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ACIKLAMA"] .'";';
	}
	?>

	if (isset (arr))
		addTableValues (arr,arrId, params, name);
}

function addFaaliyetValues (faaliyet, name){
	var length = faaliyet.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = faaliyet[i][0];
	}
	
	<?php
	$data = $this->faaliyet;	
	
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
	
		echo 'arrId['.$id++.']= "'. $arr["FALIYET_ALAN_ID"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["FALIYET_ALAN_ADI"] .'";';
	}
	?>

	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}

function createAddKurulusValues (name, buttonName){
	var arry = new Array ();
	<?php
	$data = $this->birlikteKurulus;
	
	$panelCount = count($data);
	
	echo 'var panelCount ='. $panelCount.';'; 
	
	$c = 0;
	for ($i=0; $i< $panelCount; $i++) {
		$arrKurulus = $data[$i];
	
		echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_ID"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_ADI"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["KURULUS_STATU_ID"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_YETKILISI"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_ADRES"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["IL_ID"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_POSTAKOD"].'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_TELEFON"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_FAKS"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_EPOSTA"] .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_WEB"] .'";';
	}
	?>
	var rowCount = 10;
	createNPanels(panelCount, name, buttonName);

	if (isset (arry))
		addPanelValues (arry, name, panelCount, rowCount);
}

function addYetkiTalepValues (yetkiTalep, name){
	var length = yetkiTalep.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = yetkiTalep[i][0];
	}
	
	<?php
	$data = $this->yetkiTalep;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
	
		echo 'arrId['.$id++.']= "'.$arr["YETERLILIK_ID"] .'";';
		echo 'arr['.$c++.']= "'. $arr["YETERLILIK_ID"] .'";';
		echo 'arr['.$c++.']= "'. $arr["SEVIYE_ID"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["VERILEN_BELGE"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["YAPILAN_SINAV"] .'";';
	   
	}
	?>

	if (isset (arr))
		addTableValues(arr, arrId, params, name);
}

function hideShowRadioButtonText (){
	var item = document.getElementById ("radio10");

	item = document.getElementById ("radio20");
	if (item.checked){
		hideShowSelected(Array('block'), Array('id_8'));
	}
}

function submitForm (){
	var form = document.ChronoContact_akreditasyon_basvuru_t4;    
	var item = document.getElementById ("radio21");
	var element = document.getElementById("id_8");

	if (item.checked && element != null)
		elementSil (element);
	
	if (form.onsubmit()){
		form.submit();
	}
}

function xmlhttpPost(checkFunction, strURL, getQueryStringFunction, updatePageFunction, comboObj) {
    var id = comboObj.id;
    var splitArr = id.split ("-");
    var lineNo = splitArr[(splitArr.length-1)];

	if(!checkFunction())
		return;
	var xmlHttpReq = false;
	var self = this;
	// Mozilla/Safari
	if (window.XMLHttpRequest) {
		self.xmlHttpReq = new XMLHttpRequest();
	}
	// IE
	else if (window.ActiveXObject) {
		self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
	}
	self.xmlHttpReq.open('POST', strURL, true);
	self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	self.xmlHttpReq.onreadystatechange = function() {
		if (self.xmlHttpReq.readyState == 4) {
			var str = self.xmlHttpReq.responseText;
			updatePageFunction(str, lineNo);
		}
	};
	self.xmlHttpReq.send(getQueryStringFunction(lineNo));
}
	
function seviyeUpdatePageFunction(str, lineNo){
	var sSelect = getSelectClause ("divyetkiTalep-2-"+lineNo);
	var fStr = sSelect + parseStr (str) + "</select>";
	document.getElementById("divyetkiTalep-2-"+lineNo).innerHTML = fStr;
	
	/*sSelect = getSelectClause ("divyetkiTalep-3-"+lineNo);
	fStr = sSelect + '<option value="Seçiniz">Seçiniz</option>' + "</select>";
	document.getElementById( "divyetkiTalep-3-"+lineNo ).innerHTML = fStr;*/
}

function getSelectClause (id){
	var cSeviye = document.getElementById(id);
	var sInner = cSeviye.innerHTML;
	var sIndex = sInner.indexOf(">");
	return sInner.substring(0, sIndex+1);
}

function parseStr (str){
	var startPos = str.lastIndexOf("<div id='parse'>");
	var endPos   = str.indexOf ("</div>",startPos);
	var parsed   = str.substring(startPos+16, endPos);
	return parsed;
}

function seviyeGetQueryString(lineNo){
	var yeterlilikValue = document.getElementById("inputyetkiTalep-1-"+lineNo).value;
	var qstr = 'yet=' + yeterlilikValue;
	return qstr;
}

function seviyeCheck(){
	return true;
}


<?php
$chosen = JRequest::getVar('chosen', '0');
$db =& JFactory::getOracleDBO();

if ($chosen=='1'){
	$yet =JRequest::getVar('yet');
	$options = '<option value="Seçiniz">Seçiniz</option>';
		
	$sql = "SELECT seviye_id, seviye_adi 
			FROM pm_seviye 
			WHERE seviye_id IN
	        (SELECT seviye_id
	         FROM m_yeterlilik 
	         WHERE yeterlilik_adi IN ( SELECT yeterlilik_adi FROM m_yeterlilik WHERE yeterlilik_id = ".$yet."))";
	
	$data = $db->loadList($sql);
	
	if(isset($data)){
		foreach ($data as $row){
		    $options .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}
	echo "<div id='parse'>".$options."</div>";
	
}
?>
</script>
