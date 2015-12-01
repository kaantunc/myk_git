<?php 
$db = &JFactory::getOracleDBO ();
$revize_no=$_GET[revize_no];
$durumkontrol=$this->durumKontrol;
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

$std_bilgi = $this->standart_bilgi;
$revizyonlar=$this->revizyonListesi;
$editable  = $std_bilgi["EDITABLE"];

if ($rev_bilgi["STANDART_KODU"]!=""){
	$ref_kodu=$rev_bilgi["STANDART_KODU"];
} else {
	$ref_kodu=$std_bilgi["STANDART_KODU"];
}
if ($editable){
	$name  = "Düzenleyebilir";
	$style = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255);margin-top: 10px;"';
}else{
	$name  = "Düzenleyemez";
	$style = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255);margin-top: 10px;"';
}
if ($revize_no=="00"){
	$durum=$std_bilgi["MESLEK_STANDART_SUREC_DURUM_ID"];
} else {
	$durum=$rev_bilgi["REVIZYON_DURUMU"];
}

?>
<form
	action=index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=revizyonKaydet&amp;standart_id=<?php echo $this->standart_id;?>	
	enctype="multipart/form-data" method="post"
	id="ChronoContact_taslak_revizyon"
	onSubmit = "return (validate('ChronoContact_taslak_revizyon')&&grkontrol());"
	name="ChronoContact_taslak_revizyon">

	<div class="form_item">
	  <div class="form_element cf_heading">
	  	<h1 class="contentheading">STANDART BİLGİLERİ</h1>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item" style="padding-top: 25px;">

		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Kuruluş Taslak Düzenleme Yetkisi:</label>
		<input <?php echo $style;?> value="<?php echo $name;?>" id="duzenleme" name="duzenleme" type="button" onclick="changeEditStatus ()"/>
	  	<input value="<?php echo $editable;?>" id="editable" name="editable" type="hidden" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Standart Adı:</label>
	    <label class="cf_label"><?php echo $std_bilgi["STANDART_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Seviyesi:</label>
	    <label class="cf_label"><?php echo $std_bilgi["SEVIYE_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Sektörü:</label>
	    <label class="cf_label"><?php echo $std_bilgi["SEKTOR_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<!--
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Durumu:</label>
	    <label class="cf_label"><?php //echo $std_bilgi["STANDART_SUREC_DURUM_ADI"];?></label>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	-->

	<br />
	<br />
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	<label>
		<select  id="revizyon_no">
		<option value="00"<?php if ($revize_no=="00"){echo " selected";}?>>Standart</option>
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
		</select>
		<input type=button value="Git" onclick="git(jQuery('#revizyon_no').val());"></label>
		<?php 
		if ($_GET[revizyon]!="yeni" and $durumkontrol[0]==14 and $durumkontrol[1]!=""){
			
		?>
		<input type="button" <?php echo $disable;?> value="Yeni Revizyon Oluştur" onclick="window.location='index.php?option=com_meslek_std_taslak&view=taslak_revizyon&standart_id=<?php echo $_GET[standart_id];?>&revizyon=yeni'">
		<?php			
		} else { 
	?>
		<input type="button" value="Yeni Revizyon Oluştur" disabled title="Stanadart veya Revizyon durumu 'Resmi Gazetede Yayınlandı' ise ve Standartın Son Hali PDF olarak yüklenmişse buton aktif olur.">
	<?php 					
		}
		?>
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
	    	id="revizyon_tarih" name="revizyon_tarih" type="text" value="<?php echo $rev_bilgi["REVIZYON_TARIHI"]?$rev_bilgi["REVIZYON_TARIHI"]:"";?>" />
	  	 <input type="button" value="..." id="revizyon_tarih_button"></input> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div-->
<?php 	
} else {
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

<?php 
if ($this->canEdit){
?>

	<div class="form_item">
	  <div class="form_element cf_placeholder">
	  <?php 
	  if ($revize_no=="00"){
		$data = $this->pm_standart_durum;
	  } else {
	  	$data = $this->pm_standart_revizyon_durum;
	  }
		?>
		<label class="cf_label" style="width:150px;font-weight:bold;"><?php if ($revize_no!="00"){?>Revizyon<?php } else {?>Standart<?php }?> Durumu:</label>
		<select id="durum" class="cf_inputbox" name="revizyon_durum" title="" size="1" firstoption="1" firstoptiontext="Seçiniz" onchange="checkStandartDurum(this)">
		<?php
			if(isset($data)){
				foreach ($data as $row){
				  if ($durum == $row['MESLEK_STANDART_SUREC_DURUM_ID']){
				     $selected = 'selected="selected"';
				  } else { 
				     $selected = '';
				  }
				  echo "<option ".$selected." value='".$row['MESLEK_STANDART_SUREC_DURUM_ID']."'>".$row['STANDART_SUREC_DURUM_ADI']."</option>";
				}
			}
		?>
		</select></div>
	  <div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<div style="border-bottom:1px solid #42627D;margin-top: 10px; margin-bottom: 10px;"></div>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Resmi Gazete Tarih:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="resmi_tarih" name="resmi_tarih" type="text" value="<?php echo $rev_bilgi["RESMI_GAZETE_TARIH"]?$rev_bilgi["RESMI_GAZETE_TARIH"]:"";?>" />
	  	<!-- input type="button" value="..." id="resmi_tarih_button" <?php echo $this->disabled;?>></input--> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Resmi Gazete Sayı:</label>
	    <input class="cf_inputbox" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="resmi_sayi" name="resmi_sayi" type="text" value="<?php echo $rev_bilgi["RESMI_GAZETE_SAYI"]?$rev_bilgi["RESMI_GAZETE_SAYI"]:"";?>" />
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
	    	id="karar_tarih" name="karar_tarih" type="text" value="<?php echo $rev_bilgi["KARAR_TARIHI"]?$rev_bilgi["KARAR_TARIHI"]:"";?>" />
	 	<!-- input type="button" value="..." id="karar_tarih_button" <?php echo $this->disabled;?>></input--> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Sayı:</label>
	    <input class="cf_inputbox" maxlength="150" size="10"  <?php echo $this->disabled;?>
	    	id="sayi" name="sayi" type="text" value="<?php echo $rev_bilgi["KARAR_SAYI"]?$rev_bilgi["KARAR_SAYI"]:"";?>" />
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
	    	id="goruse_cikma_tarihi" name="goruse_cikma_tarihi" type="text" value="<?php echo $rev_bilgi["GORUSE_CIKMA_TARIHI"];?>"/>
	  	<!-- input type="button" value="..." id="goruse_cikma_tarihi_button" <?php //echo $this->disabled;?>></input--> (GG.AA.YYYY)
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 150px;font-weight:bold;">Son Görüş Tarihi:</label>
	    <input class="cf_inputbox date" maxlength="150" size="10"  <?php //echo $this->disabled;?>
	    	id="son_gorus_tarihi" name="son_gorus_tarihi" type="text" value="<?php echo $rev_bilgi["SON_GORUS_TARIHI"];?>"/>
	  	<!-- input type="button" value="..." id="son_gorus_tarihi_button" <?php //echo $this->disabled;?>></input--> (GG.AA.YYYY)
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
<?php 
if ($this->canEdit or $_GET["revizyon"]=="yeni"){
?>

	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>
</form>

<script type="text/javascript">
jQuery(".date").datepicker({});
		

function git(id){
	window.location='index.php?option=com_meslek_std_taslak&view=taslak_revizyon&standart_id=<?php echo $_GET[standart_id];?>&revize_no='+id;
}
		jQuery(document).ready(function(){
	checkStandartDurum(document.getElementById("durum"));
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
		"REGA"		
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
	//$path1 = FormFactory::normalizeVariable ($std_bilgi["ILK_TASLAK_PDF"]);
	if ($revize_no=="00"){
	$path2 = FormFactory::normalizeVariable ($std_bilgi["RESMI_GORUS_ONCESI_PDF"]);
	$path3 = FormFactory::normalizeVariable ($std_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
	$path4 = FormFactory::normalizeVariable ($std_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
	$path5 = FormFactory::normalizeVariable ($std_bilgi["SON_TASLAK_PDF"]); //3
	} else {
		$path2 = FormFactory::normalizeVariable ($rev_bilgi["RESMI_GORUS_ONCESI_PDF"]);
		$path3 = FormFactory::normalizeVariable ($rev_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
		$path4 = FormFactory::normalizeVariable ($rev_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
		$path5 = FormFactory::normalizeVariable ($rev_bilgi["SON_TASLAK_PDF"]); //3
	
	}
		//3
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
	for (var i = 0; i < 4; i++){ //6
		if (paths[i] != null && paths[i] != ''){
			var sira = i+1;
			
			var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
			var inputPath = '<input type="hidden" value="'+paths[i]+'" name="path_'+tableName+'_0_'+sira +'">' +
							'<input type="hidden" value="" name="filename_'+tableName+'_0_'+sira +'">';				
				
			var result = inputPath + '<div id="success_'+tableName+'_0_'+sira+'" class="up_success" >'+fileNames[i]+' yüklendi! </div><div> <input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=indir&amp;id='+sira+'&amp;standart_id=<?php echo $this->standart_id;?>&amp;revize_no=<?php echo $_GET[revize_no];?>\'" class="up_submitbtn" style="float:none;"><input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=sil&amp;id='+sira+'&amp;standart_id=<?php echo $this->standart_id;?>&amp;revize_no=<?php echo $revize_no;?>\'" class="up_submitbtn" style="float:none;"></div>';
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

function checkStandartDurum(obj){
	var durumId = obj.value;

	updateEditableButton (durumId);
	updateDisabledInputs (durumId);
}

function updateEditableButton (durumId){
	var isEditable = true;
	var duzenlemeButton = document.getElementById ("duzenleme");
	var editable = document.getElementById ("editable");
	var editableVal = <?php echo ($editable)?$editable:0;?>;
	<?php echo "var notEditableIds = ".GUNCELLEME_KAPALI_STANDART.";"; ?>

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
	var onaylanmisId = <?php echo ONAYLANMIS_STANDART?>;
	var resmiGazeteId = <?php echo RESMI_GAZETEDE_YAYINLANMIS_STANDART?>;
	var gorusId = <?php echo GORUSE_GONDERILMIS_STANDART?>;
	var komiteId = <?php echo SEKTOR_KOMITESINE_GONDERILMIS_STANDART?>;
	var kurulId = <?php echo YONETIM_KURULUNA_GONDERILMIS_STANDART?>;
	var kurulId = <?php echo YONETIM_KURULUNA_GONDERILMIS_STANDART?>;
	var sektorSorumlusuTarafindanInceleniyorId=0;	

	for (var i = 1; i < 5; i++){
		document.getElementById ("taslakPdf_0_file_" + i).className = "";
	}

	if (durumId == -2 || durumId == 0 || durumId == 3 || durumId == 6 || durumId == 20 ){
		document.getElementById ("goruse_cikma_tarihi").disabled = true;
		document.getElementById ("son_gorus_tarihi").disabled = true;
	} else {
		document.getElementById ("goruse_cikma_tarihi").disabled = false;
		document.getElementById ("son_gorus_tarihi").disabled = false;
	}

	if (durumId == resmiGazeteId || durumId == onaylanmisId || durumId == sektorSorumlusuTarafindanInceleniyorId){
		document.getElementById ("resmi_tarih").disabled = false;
		document.getElementById ("resmi_sayi").disabled = false;
//		document.getElementById ("resmi_tarih_button").disabled = false;

		document.getElementById ("karar_tarih").disabled = false;
//		document.getElementById ("karar_tarih_button").disabled = false;
		document.getElementById ("sayi").disabled = false;
		document.getElementById ("referans_kodu").disabled = false;
		document.getElementById ("goruse_cikma_tarihi").disabled = false;
		document.getElementById ("son_gorus_tarihi").disabled = false;
}else {
		document.getElementById ("karar_tarih").disabled = true;
//		document.getElementById ("karar_tarih_button").disabled = true;
		document.getElementById ("sayi").disabled = true;
		document.getElementById ("referans_kodu").disabled = true;

		document.getElementById ("resmi_tarih").disabled = true;
		document.getElementById ("resmi_sayi").disabled = true;
//		document.getElementById ("resmi_tarih_button").disabled = true;

		//RESMI GORUSE GONDERILDI
/*		if (gorusId == durumId){
			//document.getElementById ("goruse_cikma_tarihi").value = "<?php echo $db->getSystemDate ("DD.MM.YYYY");?>";

			if (document.getElementById ("success_taslakPdf_0_1") == null){
				document.getElementById ("taslakPdf_0_file_1").className = "uploadReqTaslak";
			}			
				
		}
		//SEKTOR KOMITELERINE SUNULDU
		if (komiteId == durumId){
			if (document.getElementById ("success_taslakPdf_0_2") == null){
				document.getElementById ("taslakPdf_0_file_2").className = "uploadReqTaslak";
			}
		}
		//YONETIM KURULUNA SUNULDU
		if (kurulId == durumId){
			if (document.getElementById ("success_taslakPdf_0_3") == null){
				document.getElementById ("taslakPdf_0_file_3").className = "uploadReqTaslak";
			}
		}
		if (resmiGazeteId == durumId){
			if (document.getElementById ("success_taslakPdf_0_4") == null){
				document.getElementById ("taslakPdf_0_file_4").className = "uploadReqTaslak";
			}
		}
		*/
	}
}

function grkontrol(){
		var gorusId = <?php echo GORUSE_GONDERILMIS_STANDART?>;
		var resmiGazeteId = <?php echo RESMI_GAZETEDE_YAYINLANMIS_STANDART?>;
		
		var kurulId = <?php echo ONAYLANMIS_STANDART?>;
		var durumId=document.getElementById("durum").value;
		
		var gId1 = 4; // Resmi Görüşe/Kamuoyunun Görüşüne Sunuldu
		var gId2 = 5; // Gelen Görüşler Doğrultusunda İptal Edildi
		var gId3 = 8; // Kuruluşun Görüşleri Yansıtması Bekleniyor
		var gId4 = 7; // Sektör Komitesi Öncesi Revize Edilmesi İçin Kuruluşa Gönderildi
		
		var skId1 = 2; // Sektör Komitesine Sunuldu
		var skId2 = 11; // Sektör Komitesi Tarafından Bekletiliyor
		var skId3 = 15; // Sektör Komitesi Tarafından Reddedildi
		var skId4 = 9; // Sektör Komitesi Kararları Yansıtılıyor
		
		var ykId1 = 10; // Yönetim Kuruluna Sunuldu
		var ykId2 = 12; // Yönetim Kurulu Tarafından Bekletiliyor
		var ykId3 = -1; // Yönetim Kurulu Tarafından Reddedildi
		var ykId4 = 1; // Yönetim Kurulu Onayladı
		
		var sonId1 = 13; // Hukuk Müşavirliği'ne Gönderildi
		var sonId2 = 14; // Resmi Gazete'de Yayınlandı
		
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
		else if ((document.getElementById ("resmi_sayi").value == "")&&(resmiGazeteId ==document.getElementById("durum").value)){
				alert ("Resmi gazete sayısını girmediniz");
				return false;
			}
		else if ((document.getElementById ("resmi_tarih").value == "")&&(resmiGazeteId ==document.getElementById("durum").value)){
				alert ("Resmi gazete tarihini girmediniz");
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
		else if (rgdosya.length == 0 && (gId1 == durumId || gId2 == durumId || gId3 == durumId || gId4 == durumId || skId1 == durumId || skId2 == durumId || skId3 == durumId || skId4 == durumId || ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykId4 == durumId || sonId1 == durumId || sonId2 == durumId)){
			alert ("Resmi görüşe/Kamuoyuna sunmadan önceki taslağı yüklemelisiniz.");
			return false;
		}
		else if (skdosya.length == 0 && (skId1 == durumId || skId2 == durumId || skId3 == durumId || skId4 == durumId || ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykId4 == durumId || sonId1 == durumId || sonId2 == durumId)){
			alert ("Sektör Komitelerine sunmadan önceki taslağı yüklemelisiniz.");
			return false;
		}
		else if (yskdosya.length == 0 && (ykId1 == durumId || ykId2 == durumId || ykId3 == durumId || ykId4 == durumId || sonId1 == durumId || sonId2 == durumId)){
			alert ("Yönetim Kuruluna sunmadan önceki taslağı yüklemelisiniz.");
			return false;
		}
		else if (onaydosya.length == 0 && (sonId1 == durumId || sonId2 == durumId)){
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
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

//var cal = Calendar.setup({
//    onSelect: function(cal) { cal.hide() }
//});

//cal.manageFields("revizyon_tarih_button", "revizyon_tarih", "%d.%m.%Y");
//cal.manageFields("resmi_tarih_button", "resmi_tarih", "%d.%m.%Y");
//cal.manageFields("karar_tarih_button", "karar_tarih", "%d.%m.%Y");
//cal.manageFields("goruse_cikma_tarihi_button", "goruse_cikma_tarihi", "%d.%m.%Y");
//cal.manageFields("son_gorus_tarihi_button", "son_gorus_tarihi", "%d.%m.%Y");

//]]></script>
