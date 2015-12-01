<form
	onsubmit="return validate('ChronoContact_meslek_std_basvuru_t1')"
	action="index.php?option=com_meslek_std_basvur&amp;layout=ek&amp;task=standartKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
$basvuru = $this->basvuru;
$kurulus = $this->kurulus;
?>
<h2 style="margin-left: 32px">"Kişi Bilgi Eki" için isterseniz kişilere ait dosya yükleyebilir <strong>veya</strong> kişi bilgi eklerini doldurabilirsiniz.
Dosya yükleyecekseniz, 1- Dosyanızı Gözat diyerek seçiniz, 2- Aşağıdaki personel kaldır butonuna basınız (herhangi bir personel detayı aşağıda yer almamalıdır ve form kapalı olmalıdır.) 3- Kaydet butonuna basınız.
Veya Bilgileri dosya yüklemeden girecekseniz, aşağıdaki tüm alanları doldurunuz.</h2>
<input type="hidden" name="evrak_id" value="<?php echo $basvuru["EVRAK_ID"]; ?>">
<input type="hidden" name="kurulus_id" value="<?php echo $kurulus["USER_ID"]; ?>">

<div class="form_item" style="margin-bottom: 20px; margin-top: 10px">
  <div class="form_element cf_placeholder">
	  <div>
	  		Kişilerin Bilgilerine Ait Dosya:<br><br>
	  		<?php echo getBasvuruBelgesiTDData($basvuru["KISI_BILGI_DOSYASI"], $basvuru["EVRAK_ID"], $kurulus ); ?>
	  </div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<hr>

<div class="form_item">
  <div class="form_element cf_placeholder">
      <div id="personelForm_panel_div" class="panel_main_div"></div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php }?>
</form>

<script type="text/javascript">
<?php 
if ($this->basvuru["EKIP_SAYISI"] != null)
	echo "var ekip_sayisi = ".$this->basvuru["EKIP_SAYISI"].";"; 
else
	echo "var ekip_sayisi = 0;";
	
echo "var personel_bilgi_sayisi = ".count($this->personel).";";
?>

//if (ekip_sayisi > personel_bilgi_sayisi)
//	alert ("Başvuruyu gönderebilmeniz için faaliyet bilgilerinde belirtilen ekip sayısı kadar kişi bilgisi girilmelidir. \nBelirtilen ekip sayısı : " +ekip_sayisi + " \nGirilen kişi bilgisi : " +personel_bilgi_sayisi); 
//else
//	alert ("Başvuruyu gönderebilmek için yeterli sayıda personel bilgisi bulunmaktadır.");

//EK Paneli
dPanels.personelForm_panel = new Array("EK: MESLEK STANDARDI GELİŞTİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU",
		new Array("1. Kişisel Bilgiler", "baslik"),
		new Array("T.C. Kimlik No/ Pasaport No", "text", "required"),
		new Array("Adı", "text", "required"),
		new Array("Soyadı", "text"),
		new Array("Telefon", "text", "irtibatTelFax"),
		new Array("Faks", "text" , "irtibatTelFax"),
		new Array("E-Posta", "text" , "e-mail"),
		new Array("Öğrenim Durumu", "text"),
		new Array("Mesleği", "text"),
		new Array("Görevi", "text"),
		new Array("2. Eğitim", "baslik"),
	 	new Array("", "dtablo", createEgitimTable),
		new Array("3. Mesleğe ilişkin diğer sertifika/belgeler", "baslik"),
		new Array("", "dtablo", createDigerSertifikaEgitim),
		new Array("4. Meslek standardı hazırlama sürecine ilişkin  alınan eğitimler/özel deneyimler", "baslik"),
		new Array("", "textarea", "", "5", "50"),
		new Array("5. İş Deneyimi", "baslik"),
	 	new Array("", "dtablo", createIsDeneyimiTable),
	 	new Array("6. Yabancı Dil Bilgisi", "baslik"),
		new Array("", "dtablo", createYabanciDilTable));

//ekteki tablo verileri
dTables.egitim = new Array(
		new Array("text","year","5"), 
		new Array("text","year","5"), 
		//new Array("text","date","10","date"), 
		//new Array("text","date","10","date"), 
		new Array("text")
		);

dTables.digerSertifikaEgitim = new Array(
		new Array("text"),
		new Array("text"),
		//new Array("text","date","10","date"),
		new Array("text","monthYear","10"),
		new Array("text"));


dTables.isDeneyimi = new Array(
		//new Array("text","date","10","date"), 
		//new Array("text","date","10","date"), 
		new Array("text","year","10"), 
		new Array("text","year","10"), 
		new Array("text","","25"),
		new Array("text","","20"), 
		new Array("text","","25"));

dTables.yabanciDil = new Array(
		new Array("text"),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5"))
				),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5"))
				),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5"))
				),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5"))
		)
);

function createPanels (){
	var panelName = "personelForm_panel";
	createAddPersonelValues ( panelName, "Personel");
}

//ekteki tablolar için fonksiyonlar
function createEgitimTable(id){
	var header =  new Array ( 'Başlangıç Tarihi<br />(YYYY)',
							  'Bitiş Tarihi<br />(YYYY)',
							  'Eğitim Kurumu/Bölüm Adı');
	var tableName = "egitim";
	createTable(id, header, tableName);

	//patchEkleForDatePick(id, new Array ('1', '2'),  header, tableName);
}

function createDigerSertifikaEgitim(id){
	var header =  new Array ( 'Belge Adı',
							  'Belge Alınan Yer',
							  'Belge Alınma Tarihi<br />(AA.YYYY)',
							  'Belge Hakkında Açıklayıcı Not');
	var tableName = "digerSertifikaEgitim";
	
	createTable(id, header, tableName);

	//patchEkleForDatePick(id, new Array ('3'), header, tableName);
}

function createIsDeneyimiTable(id){
	var header = new Array ('Başlangıç Tarihi<br />(YYYY)',
							'Bitiş Tarihi<br />(YYYY)',
							'İşyeri',
							'Unvan',
							'İş Tanımı');
	var tableName = "isDeneyimi";
	
	createTable(id, header, tableName);
	
	//patchEkleForDatePick(id, new Array ('1' , '2'), header, tableName);
}

function createYabanciDilTable(id){

	createTable(id, new Array (
			'Yabancı Dil',
			'Okuma',
			'Konuşma',
			'Yazma',
			'Anlama'),"yabanciDil");
}

function createAddPersonelValues (name, buttonName){
	var arry = new Array ();
	var deneyim = new Array ();
	<?php
	$data = $this->personel;
	$dataCount = count($data);
	
	echo 'var dataCount ='. $dataCount.';';
	
	$c = 0;
	for ($i=0; $i< $dataCount; $i++) {
		$arr = $data[$i];
				
		echo 'arry['.$c++.']= "'. $arr["GOREVLI_PERSONEL_ID"] .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_KIMLIK_NO"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_ADI"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_SOYAD"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_TELEFON"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_FAKS"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_EPOSTA"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_OGRENIM"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_MESLEK"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_UZMANLIK"]) .'";';
		
		echo 'deneyim['.$i.']= "'.FormFactory::normalizeVariable ($arr["GOREVLI_PERSONEL_DENEYIM"]) .'";';
	}
	 
	?>
	var rowCount = 9;

	createNPanels(dataCount, name, buttonName);

	if (dataCount > 0){
		addPanelValues 		(arry, name, dataCount, rowCount, 1);
		addDeneyimValues	(deneyim); 
		addEgitimValues 	(dTables.egitim, dataCount);
		addSertifikaValues 	(dTables.digerSertifikaEgitim, dataCount);
		addIsDeneyimValues 	(dTables.isDeneyimi, dataCount);
		addDilValues 		(dTables.yabanciDil, dataCount);
	}
}

function addDeneyimValues (deneyim){
	var length = deneyim.length;

	for (var i = 1; i < length+1; i++){
		if (i == 1)
			inpName = "inputpersonelForm_panel-17-16";
		else
			inpName = "inputpersonelForm_panel"+ i +"-17-16";

		document.getElementById (inpName).value = deneyim[i-1];
	}
}

function addEgitimValues (egitim, panelCount){
	var length = egitim.length;
	var params = new Array ();
	var arr	= new Array ();
	var arrId= new Array ();
		
	for (var i = 0; i < length; i++){
		params[i] = egitim[i][0];
	}
	
	<?php
	$data = $this->egitim;
	
	if (isset ($data[0])){
		$tableCount = count ($data);
		$personel_id = $data[0]["GOREVLI_PERSONEL_ID"];	
	
		$p = 0;
		$id = 1;
		$c = 0;
		echo 'arrId[0]= "'.$personel_id.'";';
		echo "arr[0] = new Array ();";
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $data[$i];
			
			if ($personel_id != $arr ["GOREVLI_PERSONEL_ID"]){
				$p++;
				echo "arr[".$p."] = new Array ();";
				echo 'arrId['.$id.']= "'. $arr["GOREVLI_PERSONEL_ID"] .'";';
				$personel_id = $arr ["GOREVLI_PERSONEL_ID"];
				$id++;
				$c = 0;
			}
			
			echo 'arr['.$p.']['.$c++.']= "'. $arr["EGITIM_BASLANGIC"] .'";';
			echo 'arr['.$p.']['.$c++.']= "'. $arr["EGITIM_BITIS"] .'";';
			echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["EGITIM_YERI"]) .'";';
		}
	}
	?>

	var inpName = "";
	for (var i = 1; i < panelCount+1; i++){
		if (i == 1)
			inpName = "divpersonelForm_panel-13-12";
		else
			inpName = "divpersonelForm_panel"+ i +"-13-12";

		if (isset (arr[i-1]))
			addTableValues (arr[i-1], arrId, params, inpName, "egitim");
	}		
}

function addSertifikaValues (sertifika, panelCount){
	var length = sertifika.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = sertifika[i][0];
	}
	
	<?php
	$data = $this->sertifika;
	
	if (isset ($data[0])){
		$tableCount = count ($data);
		$personel_id = $data[0]["GOREVLI_PERSONEL_ID"];	
		
		$p = 0;
		$id = 1;
		$c = 0;
		echo "arr[0] = new Array ();";
		echo 'arrId[0]= "'.$personel_id.'";';
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $data[$i];
			
			if ($personel_id != $arr ["GOREVLI_PERSONEL_ID"]){
				$p++;
				echo "arr[".$p."] = new Array ();";
				echo 'arrId['.$id.']= "'. $arr["GOREVLI_PERSONEL_ID"] .'";';
				$personel_id = $arr ["GOREVLI_PERSONEL_ID"];
				$id++;
				$c = 0;
			}
		
			echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["SERTIFIKA_ADI"] ).'";';
		    echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["SERTIFIKA_YER"]) .'";';
		    echo 'arr['.$p.']['.$c++.']= "'. $arr["SERTIFIKA_TARIH"] .'";';
		    echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["SERTIFIKA_ACIKLAMA"]) .'";';
		    
		}
	}
	?>

	var inpName = "";
	for (var i = 1; i < panelCount+1; i++){
		if (i == 1)
			inpName = "divpersonelForm_panel-15-14";
		else
			inpName = "divpersonelForm_panel"+ i +"-15-14";

		if (isset (arr[i-1])){
			addTableValues (arr[i-1], arrId, params, inpName, "digerSertifikaEgitim");
		}
	}		
}

function addIsDeneyimValues (isDeneyim, panelCount){
	var length = isDeneyim.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = isDeneyim[i][0];
	}
	
	<?php
	$data = $this->isDeneyim;
	
	if (isset ($data[0])){
		$tableCount = count ($data);
		$personel_id = $data[0]["GOREVLI_PERSONEL_ID"];	
	
		$p = 0;
		$id = 1;
		$c = 0;
		echo 'arrId[0]= "'.$personel_id.'";';
		echo "arr[0] = new Array ();";
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $data[$i];
			
			if ($personel_id != $arr ["GOREVLI_PERSONEL_ID"]){
				$p++;
				echo "arr[".$p."] = new Array ();";
				echo 'arrId['.$id.']= "'. $arr["GOREVLI_PERSONEL_ID"] .'";';
				$personel_id = $arr ["GOREVLI_PERSONEL_ID"];
				$id++;
				$c = 0;
			}
				
			echo 'arr['.$p.']['.$c++.']= "'. $arr["DENEYIM_BASLANGIC"] .'";';
			echo 'arr['.$p.']['.$c++.']= "'. $arr["DENEYIM_BITIS"] .'";';
		    echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DENEYIM_ISYERI"]) .'";';
		    echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DENEYIM_UNVAN"]) .'";';
		    echo 'arr['.$p.']['.$c++.']= "'. FormFactory::normalizeVariable ($arr["DENEYIM_ISTANIMI"]) .'";';
		}
	}
	?>

	var inpName = "";
	for (var i = 1; i < panelCount+1; i++){
		if (i == 1)
			inpName = "divpersonelForm_panel-19-18";
		else
			inpName = "divpersonelForm_panel"+ i +"-19-18";

		if (isset (arr[i-1]))
			addTableValues (arr[i-1], arrId, params, inpName, "isDeneyimi");
	}
	
}

function addDilValues (dil, panelCount){
	var length = dil.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = dil[i][0];
	}
	
	<?php
	$data = $this->dil;

	if (isset ($data[0])){
		$tableCount = count ($data);
		$personel_id = $data[0]["GOREVLI_PERSONEL_ID"];	
		
		$p = 0;
		$id = 1;
		$c = 1;
		echo 'arrId[0]= "'.$personel_id.'";';
		echo "arr[0] = new Array ();";
		echo 'arr[0][0]= "'. $data[0]["DIL_ADI"] .'";';
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $data[$i];
			
			if ($personel_id != $arr ["GOREVLI_PERSONEL_ID"]){
				$p++;
				echo "arr[".$p."] = new Array ();";
				echo 'arrId['.$id.']= "'. $arr["GOREVLI_PERSONEL_ID"] .'";';
				echo 'arr['.$p.'][0]= "'. FormFactory::normalizeVariable ($arr["DIL_ADI"]) .'";';
				$personel_id = $arr ["GOREVLI_PERSONEL_ID"];
				$id++;
				$c=1;
			}

			if ($c % 5 == 0){
				echo 'arr['.$p.']['.$c.']= "'. FormFactory::normalizeVariable ($arr["DIL_ADI"]) .'";';
				$c++;
			}
			echo 'arr['.$p.']['.$c.']= "'. $arr["DIL_DERECESI"] .'";';
			$c++;
		}
	}
	?>

	var inpName = "";
	for (var i = 1; i < panelCount+1; i++){
		if (i == 1)
			inpName = "divpersonelForm_panel-21-20";
		else
			inpName = "divpersonelForm_panel"+ i +"-21-20";

		if (isset (arr[i-1]))
			addTableValues (arr[i-1], arrId, params, inpName, "yabanciDil");
	}
}
jQuery(document).ready(function (){
	
	jQuery(".irtibatTelFax").live("focus",function (){jQuery(this).mask("(999) 999-9999");});
	jQuery(".year").live("focus",function (){jQuery(this).mask("9999");});
        
	jQuery(".monthYear").live("focus",function (){jQuery(this).mask("99/9999");});

<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2 && $this->ssyetkili != true && $this->evrak_id != -1){?>
	jQuery('#satirEkle_divpersonelForm_panel-13-12').remove();
	jQuery('#rowNumber-divpersonelForm_panel-13-12').remove();
	jQuery('.panel_kaldir_button_div').remove();
	jQuery('#satirEkle_divpersonelForm_panel-15-14').remove();
	jQuery('#rowNumber-divpersonelForm_panel-15-14').remove();
	jQuery('#rowNumber-divpersonelForm_panel-19-18').remove();
	jQuery('#satirEkle_divpersonelForm_panel-19-18').remove();
	jQuery('#satirEkle_divpersonelForm_panel-21-20').remove();
	jQuery('#rowNumber-divpersonelForm_panel-21-20').remove();
	jQuery('#addNewPanelButton_personelForm_panel').remove();
	jQuery('#raporSilCheckbox').closest('div').remove();
	jQuery('#formGosterButton').remove();
	jQuery('input[value="Sil"]').remove();
	jQuery('input[type=file]').remove();
<?php } ?>
		
});

jQuery('#formGosterButton').live('click',function(e){
	e.preventDefault();
	
	jQuery('#toggleableDiv').toggle('slow');
	
	if(jQuery('#degistirFieldSelected').val()=='1')
		jQuery('#degistirFieldSelected').val("0");
	else
		jQuery('#degistirFieldSelected').val("1");
});

</script>

<?php 

function getBasvuruBelgesiTDData($raporPath, $evrak_id, $kurulus)
{
	
	$resultToReturn = '';

	$uploaderContent = '<input type="file" name="dosya[]" id="dosya" style="width: 210px;"  />';

	if(strlen($raporPath) > 0)
	{
		$resultToReturn .= '<div style="width:100%; float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green;">
			<div style="float:left;">
				Başvuru Belgesi Eklenmiş.
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="index.php?dl=basvuruDosyalari/'.$kurulus['USER_ID'].'/'.$evrak_id.'/'.$raporPath.'">İndir</a>
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="#" id="formGosterButton">Değiştir</a>
				<input type="hidden" id="degistirFieldSelected" name="degistirFieldSelected" value="0">
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
			</div>
			<div style="float:left;">
				<input type="checkbox" id="raporSilCheckbox" name="raporSilCheckbox" value="1">
				&nbsp;&nbsp;
				<a onclick="if(jQuery(\'#raporSilCheckbox\').attr(\'checked\')==\'checked\') jQuery(\'#raporSilCheckbox\').removeAttr(\'checked\'); else jQuery(\'#raporSilCheckbox\').attr(\'checked\', \'checked\')" style="color:green; text-decoration:underline;" href="#">Sil</a>
				&nbsp;&nbsp;&nbsp;
			</div>
		</div>';

		$resultToReturn .= '<div id="toggleableDiv" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';

		//$resultToReturn .= '<div style="padding-top:10px; width:100%; float:left;"><input type="button" onclick="window.location=\'index.php?option=com_denetim&layout=denetim_listele\';" value="GERİ" ></div>';


	}
	else
	{
		$resultToReturn .= $uploaderContent;
	}


	return $resultToReturn;
}

?>

<!--<script type="text/javascript">//<![CDATA[
//bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
var cal = Calendar.setup({
	onSelect: function(cal) { cal.hide() }
});

//]]></script>-->