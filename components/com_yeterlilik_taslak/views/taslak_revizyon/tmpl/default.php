<?php 
$db = &JFactory::getOracleDBO ();
$revize_no=$_GET[revize_no];
if ($revize_no==""){
	$revize_no=$this->revizyonVarMi;
}
if ($_GET[revizyon]=="yeni"){
	if ($this->revizyonVarMi!="00"){
		$a=$this->revizyonVarMi;
		$yeni_revize_no=$a+1;
	} else {
		$yeni_revize_no="01";
	}
	$revize_no="";
} else {
$rev_bilgi = $this->revizyon_bilgi;
}

$yet_bilgi = $this->yeterlilik_bilgi;
$revizyonlar=$this->revizyonListesi;
$editable  = $yet_bilgi["EDITABLE"];

if ($rev_bilgi["YETERLILIK_KODU"]!=""){
	$ref_kodu=$rev_bilgi["YETERLILIK_KODU"];
} else {
	$ref_kodu=$yet_bilgi["YETERLILIK_KODU"];
}
if ($editable){
	$name  = "Düzenleyebilir";
	$style = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255);margin-top: 10px;"';
}else{
	$name  = "Düzenleyemez";
	$style = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255);margin-top: 10px;"';
}

?>
<form
	action=index.php?option=com_yeterlilik_taslak&view=taslak_revizyon&task=revizyonKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>	
	enctype="multipart/form-data" method="post"
	id="ChronoContact_taslak_revizyon"
	onSubmit = "return validate('ChronoContact_taslak_revizyon')&&grkontrol()"
	name="ChronoContact_taslak_revizyon">

	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">YETERLİLİK BİLGİLERİ</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item" style="padding-top: 25px;">

		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Kuruluş Taslak Düzenleme Yetkisi:</label>
		<input <?php echo $style;?> value="<?php echo $name;?>" id="duzenleme" name="duzenleme" type="button" onclick="changeEditStatus (<?php echo $editable;?>)"/>
	  	<input value="<?php echo $editable;?>" id="editable" name="editable" type="hidden" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Yeterlilik Adı:</label>
	    <label class="cf_label"><?php echo $yet_bilgi["YETERLILIK_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Seviyesi:</label>
	    <label class="cf_label"><?php echo $yet_bilgi["SEVIYE_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Sektörü:</label>
	    <label class="cf_label"><?php echo $yet_bilgi["SEKTOR_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>


	<br />
	<br />
	<div class="form_item">
	  <div class="form_element cf_textbox">
	<label>
	<select  id="revizyon_no">
<option value="00"<?php if ($revize_no=="00"){echo " selected";}?>>Yeterlilik</option>
<?php 
foreach ($revizyonlar as $satir){
	echo "<option value='$satir[REVIZYON_NO]'";
	if ($revize_no==$satir[REVIZYON_NO]){echo " selected";}
	echo ">Revizyon $satir[REVIZYON_NO]</option>";
}
if ($_GET[revizyon]=="yeni"){
	echo "<option value='' selected >Yeni Revizyon</option>";
}
?>
</select><input type=button value="Git" onclick="git(jQuery('#revizyon_no').val());"></label>
	    	<input type="button" value="Yeni Revizyon Oluştur" onclick="window.location='index.php?option=com_yeterlilik_taslak&view=taslak_revizyon&yeterlilik_id=<?php echo $_GET[yeterlilik_id];?>&revizyon=yeni'">

	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>


	<?php if ($revize_no!="00"){?>
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading"> REVİZYON BİLGİLERİ</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Revizyon No:</label>
	    <input class="cf_inputbox" maxlength="150" size="3" readonly 
	    	id="revizyonNo" name="revizyonNo" type="text" value="<?php echo $rev_bilgi["REVIZYON_NO"];?>" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

		<!-- div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Revizyon Tarihi:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  
	    	id="revizyon_tarih" name="revizyon_tarih" type="text" value="<?php echo $rev_bilgi["REVIZYON_TARIHI"];?>" />
	    <input type="button" value="..." id="revizyon_tarih_button"></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div-->
	<?php } else {
?>
<input class="cf_inputbox" maxlength="150" size="3" readonly 
	    	id="revizyonNo" name="revizyonNo" type="hidden" value="00" />
<?php 
	
}
	?>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Referans Kodu:</label>
	    <input class="cf_inputbox" maxlength="150" size="20" <?php echo $this->disabled;?>
	    	id="referans_kodu" name="referans_kodu" type="text" value="<?php echo $ref_kodu;?>" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_placeholder">
	  <?php 
	  if ($revize_no=="00"){
		$data = $this->pm_YETERLILIK_SUREC_DURUM;
	  } else {
	  	$data = $this->pm_YETERLILIK_REVIZYON_SUREC_DURUM;
	  }
		?>
		<label class="cf_label" style="width:150px;font-weight:bold;"><?php if ($revize_no!="00"){?>Revizyon<?php } else {?>Yeterlilik<?php }?> Durumu:</label>
		<select id="durum" class="cf_inputbox" name="revizyon_durum" title="" size="1" firstoption="1" firstoptiontext="Seçiniz" onchange="checkYeterlilikDurum(this)">
		<option value="Seçiniz">Seçiniz</option>
		<?php
		if ($revize_no=="00"){
			$durum=$yet_bilgi[YETERLILIK_SUREC_DURUM_ID];
		} else {
			$durum=$rev_bilgi["REVIZYON_DURUMU"];
		}
			if(isset($data)){
				foreach ($data as $row){
				  if ($durum == $row["YETERLILIK_SUREC_DURUM_ID"]){
				     $selected = 'selected="selected"';
				  } else { 
				     $selected = '';
				  }
				  echo "<option ".$selected." value='".$row['YETERLILIK_SUREC_DURUM_ID']."'>".$row['YETERLILIK_SUREC_DURUM_ADI']."</option>";
				}
			}
		?>
		</select></div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<div style="border-bottom:1px solid #42627D;margin-top: 10px; margin-bottom: 10px;"></div>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Yayın Tarihi:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="yayin_tarihi" name="yayin_tarihi" type="text" value="<?php echo $rev_bilgi["YAYIN_TARIHI"];?>" />
	  	<input type="button" value="..." id="yayin_tarihi_button" <?php echo $this->disabled;?>></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<br />
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h3 class="contentheading">Yönetim Kurulu Kararı</h3>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Tarih:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="karar_tarih" name="karar_tarih" type="text" value="<?php echo $rev_bilgi["KARAR_TARIHI"];?>" />
	  	<input type="button" value="..." id="karar_tarih_button" <?php echo $this->disabled;?>></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Sayı:</label>
	    <input class="cf_inputbox" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="sayi" name="sayi" type="text" value="<?php echo $rev_bilgi["KARAR_SAYI"];?>" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<div style="border-bottom:1px solid #42627D;margin-top: 10px; margin-bottom: 10px;"></div>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Görüşe Gönderilme Tarihi:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  
	    	id="goruse_cikma_tarihi" name="goruse_cikma_tarihi" type="text"   value="<?php echo $rev_bilgi["GORUSE_CIKMA_TARIHI"];?>"/>
	  	<input type="button" value="..." id="goruse_cikma_tarihi_button" <?php //echo $this->disabled;?>></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Son Görüş Tarihi:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  <?php //echo $this->disabled;?>
	    	id="son_gorus_tarihi" name="son_gorus_tarihi" type="text" value="<?php echo $rev_bilgi["SON_GORUS_TARIHI"];?>" />
	  	<input type="button" value="..." id="son_gorus_tarihi_button" <?php //echo $this->disabled;?>></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<br />
	<br />
	
	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">TASLAK PDF YÜKLEME</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_placeholder">
			<div id="taslakPdf_div"></div>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

</form>

<script type="text/javascript">
jQuery(".date").datepicker({});

function git(id){
	window.location='index.php?option=com_yeterlilik_taslak&view=taslak_revizyon&yeterlilik_id=<?php echo $_GET[yeterlilik_id];?>&revize_no='+id;
}

jQuery(document).ready(function(){
	checkYeterlilikDurum(document.getElementById("durum"));
});

dTables.taslakPdf = new Array(new Array("text","read_only", "55"), new Array("upload"));

function createTables(){
	tableName = "taslakPdf";
	createTable(tableName, new Array('Açıklama', 'PDF'));
	belgelerInit (tableName);
}

function belgelerInit (tableName){
	var rowCount = 4; //1
	for(var i=1;i<rowCount;i++){
		document.getElementById ("satirEkle_"+tableName).onclick();
	}

	var belgeAciklamalari = new Array(
		//"Kuruluşun ilk sunduğu taslak",
		"Resmi görüşe/Kamuoyuna sunmadan önceki taslak",
		"Sektör Komitelerine sunmadan önceki taslak",
		"Yönetim Kuruluna sunmadan önceki taslak",
		"Taslak son hali"		
	); //2

	for(var i=1;i<=rowCount;i++){
		var inp = document.getElementById("input"+tableName+"-1-" +i);
		inp.value = belgeAciklamalari[i-1];
		inp.setAttribute("readonly","readonly");
	}
	addTaslakPdf (tableName);
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 2);
}

function addTaslakPdf (tableName){
	var paths = new Array ();
	var fileNames = new Array ();
	<?php
	//$path1 = FormFactory::normalizeVariable ($yet_bilgi["ILK_TASLAK_PDF"]);
	if ($revize_no=="00"){
	$path2 = FormFactory::normalizeVariable ($yet_bilgi["RESMI_GORUS_ONCESI_PDF"]);
	$path3 = FormFactory::normalizeVariable ($yet_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
	$path4 = FormFactory::normalizeVariable ($yet_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
	$path5 = FormFactory::normalizeVariable ($yet_bilgi["SON_TASLAK_PDF"]); //3
	} else {
		$path2 = FormFactory::normalizeVariable ($rev_bilgi["RESMI_GORUS_ONCESI_PDF"]);
		$path3 = FormFactory::normalizeVariable ($rev_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
		$path4 = FormFactory::normalizeVariable ($rev_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
		$path5 = FormFactory::normalizeVariable ($rev_bilgi["SON_TASLAK_PDF"]); //3
	
	}
	//echo "paths[0] = '".$path1."';";
	echo "paths[0] = '".$path2."';";
	echo "paths[1] = '".$path3."';";
	echo "paths[2] = '".$path4."';";
	echo "paths[3] = '".$path5."';"; //4

	//echo "fileNames [0] = '".FormFactory::getNormalFilename(basename  ($path1))."';";
	echo "fileNames [0] = '".FormFactory::getNormalFilename(basename  ($path2))."';";
	echo "fileNames [1] = '".FormFactory::getNormalFilename(basename  ($path3))."';";
	echo "fileNames [2] = '".FormFactory::getNormalFilename(basename  ($path4))."';";
	echo "fileNames [3] = '".FormFactory::getNormalFilename(basename  ($path5))."';"; //5
	?>
	var id = tableName + "_0";
	for (var i = 0; i < 4; i++){//6
		if (paths[i] != null && paths[i] != ''){
			var sira = i+1;
			
			var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
			var inputPath = '<input type="hidden" value="'+paths[i]+'" name="path_'+tableName+'_0_'+sira +'">' +
							'<input type="hidden" value="" name="filename_'+tableName+'_0_'+sira +'">';				

			var result = inputPath + '<br><div id="success_'+tableName+'_0_'+sira+'" class="up_success">'+fileNames[i]+' yüklendi!</div><div> <input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak&amp;view=taslak_revizyon&amp;task=indir&amp;id='+sira+'&amp;yeterlilik_id=<?php echo $this->yeterlilik_id;?>&amp;revize_no=<?php echo $_GET[revize_no];?>\'" class="up_submitbtn" style="float:none;"><input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak&amp;view=taslak_revizyon&amp;task=sil&amp;id='+sira+'&amp;yeterlilik_id=<?php echo $this->yeterlilik_id;?>&amp;revize_no=<?php echo $revize_no;?>\'" class="up_submitbtn" style="float:none;"></div>';
			resultDiv.innerHTML = result;
		
			var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
			uploadSpan.style.visibility = 'hidden';
			uploadSpan.style.height = 0;
		}
	}
}

function changeEditStatus (){
	var duzenlemeButton = document.getElementById ("duzenleme");
	var editable = document.getElementById ("editable");

	if (editable.value == "0"){
		duzenlemeButton.value = "Düzenleyebilir";
		duzenlemeButton.style.backgroundColor = 'rgb(100,150,100)';
		editable.value = 1;
	}else{
		duzenlemeButton.value = "Düzenleyemez";
		duzenlemeButton.style.backgroundColor = 'rgb(170,0,0)';
		editable.value = 0;
	}
}

function checkYeterlilikDurum(obj){
	var durumId = obj.value;

	updateEditableButton (durumId);
	updateDisabledInputs (durumId);
}

function updateEditableButton (durumId){
	var isEditable = true;
	var duzenlemeButton = document.getElementById ("duzenleme");
	var editable = document.getElementById ("editable");
	var editableVal = <?php echo ($editable)?$editable:0;?>;
	<?php echo "var notEditableIds = ".GUNCELLEME_KAPALI_YETERLILIK.";"; ?>

	for (var i = 0; i < notEditableIds.length; i++){
		if (notEditableIds[i] == durumId){
			isEditable = false;
			break;
		}
	}
	
	if (!isEditable){
		duzenlemeButton.value = "Düzenleyemez";
		duzenlemeButton.style.backgroundColor = 'rgb(170,0,0)';
		editable.value = 0;
		duzenlemeButton.disabled = true;
	}else{
		editable.value = 1;
		if (editableVal)
			editable.value = 0;
		changeEditStatus ();
		duzenlemeButton.disabled = false;
	}
}

function updateDisabledInputs (durumId){
	//alert (durumId);
	
	var onaylanmisId = <?php echo ONAYLANMIS_YETERLILIK?>;
	var gorusId = <?php echo GORUSE_GONDERILMIS_YETERLILIK?>;
	var komiteId = <?php echo SEKTOR_KOMITESINE_GONDERILMIS_YETERLILIK?>;
	var kurulId = <?php echo YONETIM_KURULUNA_GONDERILMIS_YETERLILIK?>;

	for (var i = 1; i < 4; i++){
		document.getElementById ("taslakPdf_0_file_" + i).className = "";
	}
	
	if (durumId == onaylanmisId){
		document.getElementById ("yayin_tarihi").disabled = false;
		document.getElementById ("yayin_tarihi_button").disabled = false;
		document.getElementById ("karar_tarih").disabled = false;
		document.getElementById ("karar_tarih_button").disabled = false;
		document.getElementById ("sayi").disabled = false;
		document.getElementById ("referans_kodu").disabled = false;
	}else{
		document.getElementById ("yayin_tarihi").disabled = true;
		document.getElementById ("yayin_tarihi_button").disabled = true;
		document.getElementById ("karar_tarih").disabled = true;
		document.getElementById ("karar_tarih_button").disabled = true;
		document.getElementById ("sayi").disabled = true;
		document.getElementById ("referans_kodu").disabled = true;

/*
		//RESMI GORUSE GONDERILDI
		if (gorusId == durumId){
			document.getElementById ("goruse_cikma_tarihi").value = "<?php echo $db->getSystemDate ("DD.MM.YYYY");?>";

			if (document.getElementById ("success_taslakPdf_0_1") == null){
				document.getElementById ("taslakPdf_0_file_1").className = "uploadReqTaslak";
			}
		}
		//SEKTOR KOMITELERINE SUNULDU
		else if (komiteId == durumId){
			if (document.getElementById ("success_taslakPdf_0_2") == null){
				document.getElementById ("taslakPdf_0_file_2").className = "uploadReqTaslak";
			}
		}
		//YONETIM KURULUNA SUNULDU
		else if (kurulId == durumId){
			if (document.getElementById ("success_taslakPdf_0_3") == null){
				document.getElementById ("taslakPdf_0_file_3").className = "uploadReqTaslak";
				
			}
		}*/
	}
}
function grkontrol(){
	var gorusId = <?php echo GORUSE_GONDERILMIS_YETERLILIK?>;
//	var resmiGazeteId = <?php echo RESMI_GAZETEDE_YAYINLANMIS_STANDART?>;
	
	var kurulId = <?php echo ONAYLANMIS_YETERLILIK?>;
	var durumId=document.getElementById("durum").value;
	
	var gId1 = <?php echo GORUSE_GONDERILMIS_YETERLILIK?>;
	var gId2 = <?php echo KURULUSTAN_GORUS_YANSITMA_ISTENEN_YETERLILIK?>;
	
	var skId1 = <?php echo SEKTOR_KOMITESINE_GONDERILMIS_YETERLILIK?>;
	var skId2 = 6; // Sektör Komitesi Kararları Yansıtılıyor
	var skId3 = 8; // Sektör Komitesi Tarafından Bekletiliyor
	var skId4 = 0; // Sektör Sorumlusu Tarafından İnceleniyor
	
	var ykId1 = <?php echo YONETIM_KURULUNA_GONDERILMIS_YETERLILIK?>;
	var ykId2 = 9; // Yönetim Kurulu Tarafından Bekletiliyor
	var ykId3 = -1; // Yönetim Kurulu Tarafından Reddedildi

	var ykIdson = 1; // Yönetim Kurulu Onayladı

	var rgdosya=document.getElementsByName ("path_taslakPdf_0_1"); // Resmi görüşe/Kamuoyuna sunmadan önceki taslak
	var skdosya=document.getElementsByName ("path_taslakPdf_0_2"); // Sektör Komitelerine sunmadan önceki taslak
	var yskdosya=document.getElementsByName ("path_taslakPdf_0_3"); // Yönetim Kuruluna sunmadan önceki tasla
	var onaydosya=document.getElementsByName ("path_taslakPdf_0_4"); // Taslağın son hali
					
	if ((document.getElementById ("goruse_cikma_tarihi").value == "")&&(gorusId ==document.getElementById("durum").value)){
			alert ("Görüş gönderilme tarihini girmediniz");
			return false;
		}	
	else if ((document.getElementById ("son_gorus_tarihi").value == "")&&(gorusId ==document.getElementById("durum").value)){
			alert ("Son görüş tarihini girmediniz");
			return false;
		}
	else if ((document.getElementById ("karar_tarih").value == "")&&(kurulId ==document.getElementById("durum").value)){
			alert ("Yönetim Kurulu tarihini girmediniz");
			return false;
		}
	else if ((document.getElementById ("sayi").value == "")&&(kurulId ==document.getElementById("durum").value)){
		alert ("Yönetim Kurulu sayısını girmediniz");
		return false;
	}
	else if (rgdosya.length == 0 && (gId1 == durumId || gId2 == durumId || skId1 == durumId || skId2 == durumId || skId3 == durumId || skId4 == durumId || ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykIdson == durumId)){
		alert ("Resmi görüşe/Kamuoyuna sunmadan önceki taslağı yüklemelisiniz.");
		return false;
	}
	else if (skdosya.length == 0 && (skId1 == durumId || skId2 == durumId || skId3 == durumId || skId4 == durumId || ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykIdson == durumId)){
		alert ("Sektör Komitelerine sunmadan önceki taslağı yüklemelisiniz.");
		return false;
	}
	else if (yskdosya.length == 0 && (ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykIdson == durumId)){
		alert ("Yönetim Kuruluna sunmadan önceki taslağı yüklemelisiniz.");
		return false;
	}
	else if (onaydosya.length == 0 && (ykIdson == durumId)){
		alert ("Taslağın son halini yüklemelisiniz.");
		return false;
	}
			else {
			return true;
		}
}
<?php 
if ($_GET[revizyon]=="yeni"){
echo '
	yeni='.$yeni_revize_no.';
	if (yeni<10){yeni="0"+yeni;}
	jQuery("#revizyonNo").val(yeni);
';

}
?>
</script>

<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümkünse en alta </body> den önce

var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});

cal.manageFields("revizyon_tarih_button", "revizyon_tarih", "%d.%m.%Y");
cal.manageFields("yayin_tarihi_button", "yayin_tarihi", "%d.%m.%Y");
cal.manageFields("karar_tarih_button", "karar_tarih", "%d.%m.%Y");
cal.manageFields("goruse_cikma_tarihi_button", "goruse_cikma_tarihi", "%d.%m.%Y");
cal.manageFields("son_gorus_tarihi_button", "son_gorus_tarihi", "%d.%m.%Y");
      
//]]></script>