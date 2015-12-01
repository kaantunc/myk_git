<?php 
$basvuru = $this->basvuru;
?>

<form
	onsubmit="return validate('ChronoContact_yeterlilik_basvuru_t2')"
	action="index.php?option=com_yeterlilik_basvur&amp;layout=faaliyet&amp;task=yeterlilikKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_basvuru_t2"
	name="ChronoContact_yeterlilik_basvuru_t2">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">B. Kuruluşun</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">1. Faaliyet gösterdiği sektör(ler) </h3>
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
  	<h3 class="contentheading">2. Faaliyet alanları </h3>
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
  	<h3 class="contentheading">3. Faaliyet süresi </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_radiobutton">
	<div class="float_left"><?php 
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
  	<h3 class="contentheading">4.Varsa mevcut akreditasyon kapsamı </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder"><div id="mevcutAkKapsam_div">
</div></div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">5. Toplam personel sayısı</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textbox">
    <input class="cf_inputbox numeric" maxlength="150" size="5"  
    	id="text_35" name="personel_sayisi" type="text" value = "<?php echo $basvuru["PERSONEL_SAYISI"]; ?>"/>
  
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">6. Organizasyon şeması </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
 
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="organizasyonSema_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">7. Yeterlilik hazırlamakla/ geliştirmekle görevlendirilen/ görevlendirilecek kişilere(*) ilişkin bilgiler; yeterlilik hazırlama/ geliştirme ve süreci koordine etme konusunda planlanan yetkinlik ve kapasite arttırıcı faaliyetler </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">a)	Yeterlilik hazırlama/ geliştirme ve süreci koordine etme konusunda planlanan yetkinlik ve kapasite arttırıcı faaliyetler</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_34" title="" cols="60" name="madde_7a1"><?php echo $basvuru["EKIP_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">b) Görevlendirilecek ekipteki kişi sayısı</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textbox">
    <input class="cf_inputbox numeric" maxlength="150" size="5"  
    	id="text_76" name="madde_7a2" type="text" value="<?php echo $basvuru["EKIP_SAYISI"]; ?>" />
  
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">8. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?</h3>
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
  	<h3 class="contentheading">9. Yeterlilik hazırlama/geliştirme çalışmaları için mevcut/sağlanacak altyapı imkânları </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="madde_9" title="" cols="60" name="madde_9"><?php echo $basvuru["ALTYAPI_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">10. Yeterliliklerin hazırlanması/geliştirilmesi için dışarıdan hizmet alımı planlanıyor mu?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE = "";
$checkedH = ""; 

if ($basvuru ["DIS_ALIM_HIZMET"] || $basvuru ["DIS_ALIM_TEDBIR"])
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";
?>

<div class="form_item">
  <div class="form_element cf_radiobutton">
    <div class="float_left">
      <input <?php echo $checkedE; ?> value="1" title="" class="radio" id="radio30" name="radio3" type="radio" onclick="hideShowSelected(Array('block'), Array('id_10'))"/>
      <label for="radio30" class="radio_label">Evet</label>
      <br />
      
	  <input <?php echo $checkedH; ?> value="0" title="" class="radio" id="radio31" name="radio3" type="radio" onclick="hideShowSelected(Array('none'), Array('id_10'))"/>
      <label for="radio31" class="radio_label">Hayır</label>
      <br />
      

    </div>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div style="display:none;" id="id_10">

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">a)	Alınması planlanan hizmetler</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_23" title="" cols="60" name="madde_10a"><?php echo $basvuru["DIS_ALIM_HIZMET"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">b)	Alınacak hizmetlerin kalite güvencesine yönelik tedbirler</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_24" title="" cols="60" name="madde_10b"><?php echo $basvuru["DIS_ALIM_TEDBIR"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</div> 

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">11. Yeterlilik taslaklarının resmi görüşe gönderilmesi öncesinde yeterlilik hazırlama/geliştirme sürecine konuyla ilgili tarafların (örgün ve yaygın eğitim ve öğretim kurumları, yetkilendirilmiş belgelendirme kuruluşları, ulusal meslek standardı hazırlamış kuruluşlar, meslek kuruluşları ile personel belgelendirmesi yapan akredite kuruluşlar ve sivil toplum kuruluşları) dâhil edilmesi ve danışma sürecine ilişkin plan ve yöntemler </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_32" title="" cols="60" name="madde_11"><?php echo $basvuru["DANISMA_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">12.Yeterlilik Taslağında yer alan ve Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğinin 10 uncu maddesinin birinci fıkrasının (f) bendindeki hususların (Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri) belirlenmesi amacıyla gerçekleştirilmesi öngörülen pilot uygulamaya ilişkin usul ve yöntemler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_31" title="" cols="60" name="madde_12"><?php echo $basvuru["PILOT_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="button" onclick="submitForm()" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php }?>	
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
      $s .= 'new Array ("'.$id.'","'.FormFactory::normalizeVariable ($value).'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq"), new Array ("text", "", "65"));';
echo $r;
?>
//SEKTORLER SONU
dTables.organizasyonSema = new Array(new Array("upload", "onclickevent"));
dTables.faaliyet = new Array(new Array("text", "required", "80"));
dTables.mevcutAkKapsam = new Array(	new Array("text"), new Array("text"), new Array("upload"));

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
          $s .= 'new Array ("'.$id.'","'.FormFactory::normalizeVariable ($value).'"),';
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

function createTables(){
	var tableName = "sektor";
	createTable( tableName, new Array ('Faaliyet Gösterdiği Sektör(ler)', 'Açıklama'));
	addSektorValues (dTables.sektor, tableName);

	tableName = "faaliyet";
	createTable(tableName, new Array ('Faaliyet Alanları'));
	addFaaliyetValues (dTables.faaliyet, tableName);

	tableName = "mevcutAkKapsam";
	createTable(tableName, new Array('Akreditasyon Adı','Açıklama', 'Belge Gönderimi'));
	addAkreditasyonValues (new Array (new Array ("text"),new Array ("text")), tableName);
	
	tableName = "organizasyonSema";
	createTable(tableName, new Array(''));
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 0);
	addOrganizasyonSema(tableName);
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
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["SEKTOR_ACIKLAMA"]) .'";';
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
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["FALIYET_ALAN_ADI"]) .'";';
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
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_ADI"]) .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["KURULUS_STATU_ID"] .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_YETKILISI"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_ADRES"]) .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["IL_ID"] .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_POSTAKOD"]).'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_TELEFON"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_FAKS"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_EPOSTA"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_WEB"]) .'";';
	}
	?>
	var rowCount = 10;
	createNPanels(panelCount, name, buttonName);

	if (isset (arry))
		addPanelValues (arry, name, panelCount, rowCount);
}


function addOrganizasyonSema (tableName){
	<?php
	$path = $this->basvuru["ORGANIZASYON_SEMASI"];	
	echo "var path = '".FormFactory::normalizeVariable ($path)."';\n";
	echo "var fileName = '".FormFactory::getNormalFilename(basename  ($path))."';\n";
	?>
	if (path != null && path != ''){
		var id		 = tableName + "_0";
		var sira	 = 1;
		var resultDiv 	= document.getElementById('organizasyonSemasi'+id + "_result_div_" + sira);
		var inputPath = '<input type="hidden" value="'+path+'" name="path_organizasyonSema_0_'+sira +'">' +
						'<input type="hidden" value="" name="filename_organizasyonSema_0_'+sira +'">';				
			
		var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
		result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\'organizasyonSemasi'+id+'\',\''+sira+'\')" /><\/div>';
		resultDiv.innerHTML = result;
	
		var uploadSpan = document.getElementById('organizasyonSemasi'+id + "_upload_form_span_" + sira);
		uploadSpan.style.visibility = 'hidden';
		uploadSpan.style.height = 0;
	}
}

function addAkreditasyonValues (params, name){
	var arr   	  = new Array ();
	var pathName  = new Array ();
	var fileName  = new Array ();
	var ekId 	  = new Array ();
	<?php
	$data = $this->akreditasyon;
	$tableCount = count ($data);
	
	$c  = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];

		echo 'ekId['.$i.']= "'. $arr["AKREDITASYON_ID"].'";';
		echo 'pathName['.$i.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_PATH"]) .'";';
		echo 'fileName['.$i.']= "'.FormFactory::getNormalFilename (basename($arr["AKREDITASYON_PATH"])) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_ACIKLAMA"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_SEVIYE"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_STANDARDI"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_BASLANGIC"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_BITIS"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_DENETIM"]) .'";';
//		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["AKREDITASYON_KAPSAM"]) .'";';
	}
	
	?>
	if (isset (arr)){
		addTableValues (arr, new Array (), params, name);

		for (var i = 0; i < pathName.length; i++){
			var path 	 = pathName[i]; 
			var fileName = fileName[i];
			var id		 = name + "_0";
			var sira	 = i+1;
			
			var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
			var inputPath 	= '<input type="hidden" value="'+path+'" name="path_mevcutAkKapsam_0_'+sira +'">' +
							  '<input type="hidden" value="" name="filename_mevcutAkKapsam_0_'+sira +'">';	;	
			
			var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
			result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\''+sira+'\')" /><\/div>';
			resultDiv.innerHTML = result;
		
			var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
			uploadSpan.style.visibility = 'hidden';
			uploadSpan.style.height = 0;

			var formDiv = document.getElementById(name + "_div");
			var inputPath = document.createElement("input");
			inputPath.setAttribute("type", "hidden");
			inputPath.setAttribute("id", "akreditasyon_id_"+sira);
			inputPath.setAttribute("name","akreditasyon_id_"+sira);
			inputPath.setAttribute("value", ekId[i]);
			formDiv.appendChild (inputPath);
		}
	}
}

function hideShowRadioButtonText (){
	var item = document.getElementById ("radio10");
	
	item = document.getElementById ("radio20");
	if (item.checked){
		hideShowSelected(Array('block'), Array('id_8'));
	}

	item = document.getElementById ("radio30");
	if (item.checked)
		hideShowSelected(Array('block'), Array('id_10'));
}

function submitForm (){
	var form = document.ChronoContact_yeterlilik_basvuru_t2;    
	var item = document.getElementById ("radio21");
	var element = document.getElementById("id_8");

	if (item.checked && element != null)
		elementSil (element);
	
	if (form.onsubmit()){
		form.submit();
	}
}

jQuery(document).ready(function(){
	<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2  && $this->ssyetkili != true && $this->evrak_id != -1){?>
		jQuery('#satirEkle_sektor').remove();
		jQuery('#rowNumber-sektor').remove();
		jQuery('.tablo_sil_hucre').remove();
		jQuery('#satirEkle_faaliyet').remove();
		jQuery('#rowNumber-faaliyet').remove();
		jQuery('#rowNumber-mevcutAkKapsam').remove();
		jQuery('#satirEkle_mevcutAkKapsam').remove();
		jQuery('.up_submitbtn').remove();
		jQuery('input[type=file]').remove();
		jQuery('.panel_kaldir_button_div').remove();
		jQuery('#addNewPanelButton_kurulus_panel').remove();
	<?php } ?>
	});
</script>
