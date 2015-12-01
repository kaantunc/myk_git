<?php 
$basvuru = $this->basvuru;
?>
<form
	onsubmit="return validate('ChronoContact_meslek_std_basvuru_t1')"
	action="index.php?option=com_meslek_std_basvur&amp;layout=faaliyet&amp;task=standartKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">KURULUŞUN</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">1. Faaliyet
	gösterdiği sektör (ler)</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="sektor_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">2. Faaliyet
	alanları </span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="faaliyet_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">3. Faaliyet
	süresi</span></div>
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
	<div class="form_element cf_text"><span class="cf_text">4. Kuruluş,
	Meslek / Sivil Toplum Kuruluşu ise;</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kurulus_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textbox"><label class="cf_label"
		style="width: 150px;">Üye (Gerçek kişi) sayısı</label> <input
		class="cf_inputbox numeric" maxlength="150" size="5" id="text_27"
		name="kisi_sayisi" type="text" value="<?php echo $basvuru["UYE_SAYISI"]; ?>"/></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">5. Organizasyon
	şeması ve toplam çalışan personel sayısı</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="organizasyonSema_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textbox"><label class="cf_label"
		style="width: 150px;">Personel Sayısı</label> <input
		class="cf_inputbox numeric" maxlength="150" size="5" id="text_82"
		name="personel_sayisi" type="text" value="<?php echo $basvuru["PERSONEL_SAYISI"]; ?>"/></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">6. Meslek
	standardı hazırlama ekibi oluşturulmuş mudur?</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE = "";
$checkedH = ""; 

if ($basvuru["HAZIRLAMA_EKIBI"])
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";;
?>

<div class="form_item">
	<div class="form_element cf_radiobutton">
		<div class="float_left">
			<input <?php echo $checkedE;?> value="1" title="" class="radio"
				id="radio10" name="radio1" type="radio"
				onclick="hideShowSelected(Array ('block','none'), Array('id_6a', 'id_6b'))" />
			
			<label for="radio10" class="radio_label">Evet</label> <br />
			<input <?php echo $checkedH;?> value="0" title="" class="radio" id="radio11" name="radio1"
				type="radio"
				onclick="hideShowSelected(Array ('none','block'), Array('id_6a', 'id_6b'))" />
			
			<label for="radio11" class="radio_label">Hayır</label> <br />
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div style="display: none;" id="id_6a">
	<div class="form_item">
		<div class="form_element cf_text"><span class="cf_text">a1)
		Görevlendirilen ekipte bulunan personelin* meslek standardı geliştirme
		ve süreci koordine etme konusundaki yetkinliğini artırmak için planlanan
		kapasite geliştirme faaliyetleri vb. hususlar</span></div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_textarea">
		<textarea class="cf_inputbox" rows="5"
			id="text_34" title="" cols="60" name="madde_6a1"><?php if($basvuru["HAZIRLAMA_EKIBI"]) echo $basvuru["EKIP_ACIKLAMA"]; ?></textarea></div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_text"><span class="cf_text">a2)
		Görevlendirilecek ekipteki kişi sayısı</span></div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_textbox">
		<input class="cf_inputbox numeric" value="<?php echo $basvuru["EKIP_SAYISI"]; ?>"	maxlength="150" size="5" id="text_76" name="madde_6a2" type="text" /></div>
		<div class="cfclear">&nbsp;</div>
	</div>
</div>

<div style="display: none;" id="id_6b">
	<div class="form_item">
		<div class="form_element cf_text"><span class="cf_text">b) Meslek
		standardı hazırlama ekibi oluşturulmasına ve kapasite geliştirilmesine
		yönelik planlar </span></div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_textarea">
		<textarea class="cf_inputbox" rows="5"
			id="text_37" title="" cols="60" name="madde_6b"><?php if(!$basvuru["HAZIRLAMA_EKIBI"]) echo $basvuru["EKIP_ACIKLAMA"]; ?></textarea></div>
		<div class="cfclear">&nbsp;</div>
	</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">7. Meslek
	standardı hazırlamada birlikte çalışılması planlanan kurum/kuruluş(lar)
	var mıdır? </span></div>
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
			<input <?php echo $checkedE;?> value="1" title="" class="radio"
				id="radio20" name="radio2" type="radio"
				onclick="hideShowSelected(Array('block'), Array('id_7'))" /> 
			<label for="radio20" class="radio_label">Evet</label> <br />
			<input <?php echo $checkedH;?> value="0" title="" class="radio" id="radio21" name="radio2"
				type="radio" onclick="hideShowSelected(Array('none'), Array('id_7'))"/>
			<label for="radio21" class="radio_label">Hayır</label> <br />
		</div>
	</div>
	
	<div class="cfclear">&nbsp;</div>
</div>

<div style="display: none;" id="id_7">
	<div class="form_item">
		<div class="form_element cf_placeholder">
			<div id="kurulus_panel_div" class="panel_main_div"></div>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">8. Meslek
	standardı hazırlama çalışmaları için mevcut / sağlanacak altyapı
	imkanları</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea">
	<textarea class="cf_inputbox" rows="5"
		id="text_52" title="" cols="60" name="madde_8"><?php echo $basvuru["ALTYAPI_ACIKLAMA"]; ?></textarea></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">9. Meslek
	standartlarının hazırlanması için dışarıdan hizmet alımı planlanıyor mu?
	</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE = "";
$checkedH = ""; 

if ($basvuru ["DIS_ALIM_HIZMET"]!= null || $basvuru ["DIS_ALIM_TEDBIR"]!= null)
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";
?>

<div class="form_item">
	<div class="form_element cf_radiobutton">
		<div class="float_left">
			<input <?php echo $checkedE; ?> value="1" title="" class="radio"
				id="radio30" name="radio3" type="radio"
				onclick="hideShowSelected(Array('block'), Array('id_9'))" />
			<label for="radio30" class="radio_label">Evet</label> <br />
		<input <?php echo $checkedH; ?> value="0" title="" class="radio" id="radio31" name="radio3"
			type="radio" onclick="hideShowSelected(Array('none'), Array('id_9'))"/>
		<label for="radio31" class="radio_label">Hayır</label> <br />
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div style="display: none;" id="id_9">
	<div class="form_item">
		<div class="form_element cf_text"><span class="cf_text">a) Alınması
		planlanan hizmetler</span></div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_textarea">
			<textarea class="cf_inputbox" rows="5"
				id="text_56" title="" cols="60" name="madde_9a"><?php echo $basvuru["DIS_ALIM_HIZMET"]; ?></textarea>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_text"><span class="cf_text">b) Alınacak
		hizmetlerin kalite güvencesine yönelik tedbirler</span></div>
		<div class="cfclear">&nbsp;</div>
	</div>


	<div class="form_item">
		<div class="form_element cf_textarea">
			<textarea class="cf_inputbox" rows="5"
				id="text_58" title="" cols="60" name="madde_9b"><?php echo $basvuru["DIS_ALIM_TEDBIR"]; ?></textarea>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

</div>

<div class="form_item">
	<div class="form_element cf_text">
	<span class="cf_text">10. Meslek
		standardı hazırlama sürecine ilgili tarafların (meslekle ilgili kamu
		kurumları, işçi, işveren, meslek örgütleri, eğitim sağlayıcılar) dahil
		edilmesi ve danışma sürecine ilişkin plan ve yöntemler
	</span>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea">
		<textarea class="cf_inputbox" rows="5"
			id="text_60" title="" cols="60" name="madde_10"><?php echo $basvuru["DANISMA_ACIKLAMA"]; ?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="button" onclick = "submitForm();"/>
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
$r = $r.$s.'),"comboReq"), new Array ("text", "" , "65"));';
echo $r;
?>
//SEKTORLER SONU
dTables.organizasyonSema = new Array(new Array("upload", "onclickevent"));
dTables.faaliyet = new Array(new Array("text", "required", "80"));
dTables.kurulus = new Array(new Array("text", "required", "50"));

//KURULUS PANEL
<?php
$param = array ($this->pm_kurulus_statu, $this->pm_il);
//$k = '),"comboReq"), new Array("Yetkilisi", "text"), new Array("Adresi", "textarea"), new Array("Şehir", "combo", new Array(';
$k = ')), new Array("Yetkilisi", "text"), new Array("Adresi", "textarea"), new Array("Şehir", "combo", new Array(';
$r = 'dPanels.kurulus_panel =  new Array("Kuruluşun;", new Array("Adı", "text"), new Array("Statüsü", "combo", new Array(';
$p = '';

for ($i = 0; $i < count ($param); $i++){
$data = $param[$i];

$s = 'new Array ("Seçiniz", "Seçiniz"),';
if(isset($data)){
  foreach ($data as $row){
      $id 	 = $row[0];
      $value = $row[1];
      
      if ($id != 0)
      	$s .= 'new Array ("'.$id.'","'.FormFactory::normalizeVariable ($value).'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$p .= $s.$k;

//$k = '),"comboReq"), new Array("Posta Kodu", "text", "numeric"), new Array("Telefon", "text", "numeric"), new Array("Faks", "text", "numeric"), new Array("E-Posta", "text", "e-mail"), new Array("Web", "text", "url"));';
$k = ')), new Array("Posta Kodu", "text", "numeric"), new Array("Telefon", "text", "numeric"), new Array("Faks", "text", "numeric"), new Array("E-Posta", "text", "e-mail"), new Array("Web", "text", "url"));';
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

	tableName = "kurulus";
	createTable(tableName, new Array ('Bağlı Kuruluş (Oda, Federasyon, Dernek, Sendika vb.) adları'));
	addKurulusValues (dTables.kurulus, tableName);
	
	tableName = "organizasyonSema";
	createTable(tableName, new Array(''));
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 0);
	addOrganizasyonSema (tableName);

	
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

function addKurulusValues (kurulus, name){
	var length = kurulus.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = kurulus[i][0];
	}
	
	<?php
	$data = $this->bagliKurulus;	
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
	
		echo 'arrId['.$id++.']= "'. $arr["BAGLI_KURULUS_ID"] .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BAGLI_KURULUS_ADI"]) .'";';
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
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_FAKS"] ).'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_EPOSTA"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_WEB"] ).'";';
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
	echo "var path = '".FormFactory::normalizeVariable ($path)."';";
	echo "var fileName = '".FormFactory::getNormalFilename(basename  ($path))."';";
	?>
	if (path != null && path != ''){
		var id		 = tableName + "_0";
		var sira	 = 1;
		var resultDiv 	= document.getElementById('organizasyonSemasi'+id + "_result_div_" + sira);
		var inputPath = '<input type="hidden" value="'+path+'" name="path_organizasyonSema_0_'+sira +'">' +
						'<input type="hidden" value="" name="filename_organizasyonSema_0_'+sira +'">';				
			
		var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
		result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\''+sira+'\')" /><\/div>';
		resultDiv.innerHTML = result;
	
		var uploadSpan = document.getElementById('organizasyonSemasi'+id + "_upload_form_span_" + sira);
		uploadSpan.style.visibility = 'hidden';
		uploadSpan.style.height = 0;
	}
}

function hideShowRadioButtonText (){
	var item = document.getElementById ("radio10");
	
	if (item.checked) 
		hideShowSelected(Array ('block','none'),Array('id_6a','id_6b'));
	else
		hideShowSelected(Array ('none','block'),Array('id_6a','id_6b')); 

	item = document.getElementById ("radio20");
	if (item.checked){
		hideShowSelected(Array('block'), Array('id_7'));
	}

	item = document.getElementById ("radio30");
	if (item.checked)
		hideShowSelected(Array('block'), Array('id_9'));
}

function submitForm (){
	var form = document.ChronoContact_meslek_std_basvuru_t1;    
	var item = document.getElementById ("radio21");
	var element = document.getElementById("id_7");

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
	jQuery('#satirEkle_kurulus').remove();
	jQuery('#rowNumber-kurulus').remove();
	jQuery('.panel_kaldir_button_div').remove();
	jQuery('#addNewPanelButton_kurulus_panel').remove();
	jQuery('input[value="Değiştir"]').remove();
<?php } ?>
});
</script>