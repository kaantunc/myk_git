<form
	onsubmit="return validate('ChronoContact_akreditasyon_basvuru_t4')"
	action="index.php?option=com_akreditasyon_basvur&amp;layout=ek&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_akreditasyon_basvuru_t4"
	name="ChronoContact_akreditasyon_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_placeholder">
		<div id="personelForm_panel_div" class="panel_main_div"></div></div>
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
<?php 
if ($this->basvuru["EKIP_SAYISI"] != null)
	echo "var ekip_sayisi = ".$this->basvuru["EKIP_SAYISI"].";"; 
else
	echo "var ekip_sayisi = 0;";
	
echo "var personel_bilgi_sayisi = ".count($this->personel).";";
?>

if (ekip_sayisi > personel_bilgi_sayisi)
	alert ("Başvuruyu gönderebilmeniz için faaliyet bilgilerinde belirtilen ekip sayısı kadar kişi bilgisi girilmelidir. \nBelirtilen ekip sayısı : " +ekip_sayisi + " \nGirilen kişi bilgisi : " +personel_bilgi_sayisi); 
else
	alert ("Başvuruyu gönderebilmek için yeterli sayıda personel bilgisi bulunmaktadır.");


//EK Paneli
dPanels.personelForm_panel = new Array("EK: PERSONELE İLİŞKİN BİLGİ FORMU",
		new Array("1. Kişisel Bilgiler", "baslik"),
		new Array("T.C. Kimlik No/ Pasaport No", "text", "required"),
		new Array("Adı", "text", "required"),
		new Array("Soyadı", "text"),
		new Array("Telefon", "text", "numeric"),
		new Array("Faks", "text" , "numeric"),
		new Array("E-Posta", "text" , "e-mail"),
		new Array("Öğrenim Durumu", "text"),
		new Array("Mesleği", "text"),
		new Array("Görevi", "text"),
		new Array("2. Eğitim", "baslik"),
	 	new Array("", "dtablo", createEgitimTable),
		new Array("3. Mesleğe ilişkin diğer sertifika/belgeler", "baslik"),
		new Array("", "dtablo", createDigerSertifikaEgitim),
		new Array("4. Akreditasyon sürecine ilişkin  alınan eğitimler/özel deneyimler", "baslik"),
		new Array("", "textarea", "", "5", "50"),
		new Array("5. İş Deneyimi", "baslik"),
	 	new Array("", "dtablo", createIsDeneyimiTable),
	 	new Array("6. Yabancı Dil Bilgisi", "baslik"),
		new Array("", "dtablo", createYabanciDilTable));

//ekteki tablo verileri
dTables.egitim = new Array(
		//new Array("text","Year"), 
		//new Array("text","year","5"), 
		  new Array("combo",new Array(
				new Array("Seçiniz","Seçiniz"),
					<?php
						  for($ii=date("Y")-60; $ii<date("Y")-1; $ii++){
							  echo ('new Array("'.$ii.'","'.$ii.'"),');}
							  echo ('new Array("'.date("Y").'","'.date("Y").'")');?>
				)),
		  
		new Array("combo",new Array(
				new Array("Seçiniz","Seçiniz"),
					<?php
						  for($ii=date("Y")-60; $ii<date("Y")-1; $ii++){
							  echo ('new Array("'.$ii.'","'.$ii.'"),');}
							  echo ('new Array("'.date("Y").'","'.date("Y").'")');?>
				)), 
		new Array("text","","95")
		);

dTables.digerSertifikaEgitim = new Array(
		new Array("text"),
		new Array("text"),
		//new Array("text","date","10","date"),
		  new Array("combo",new Array(
				new Array("Seçiniz","Seçiniz"),
					<?php
						  for($ii=date("Y")-60; $ii<date("Y")-1; $ii++){
							  echo ('new Array("'.$ii.'","'.$ii.'"),');}
							  echo ('new Array("'.date("Y").'","'.date("Y").'")');?>
				)),
		new Array("text","","25"));


dTables.isDeneyimi = new Array(
		//new Array("text","date","10","date"), 
		//new Array("text","date","10","date"), 
		new Array("text","ayYil","10"),  
		new Array("text","ayYil","10"),
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
							new Array("5", "5")
							),"","","50"),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5")),"","","50"
				),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5")),"","","50"
				),
		new Array( "combo", new Array(
							new Array("1", "1"),
							new Array("2", "2"),
							new Array("3", "3"),
							new Array("4", "4"),
							new Array("5", "5")),"","","50"
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
							  'Belge Alınma Tarihi<br />(YYYY)',
							  'Belge Hakkında Açıklayıcı Not');
	var tableName = "digerSertifikaEgitim";
	
	createTable(id, header, tableName);

	//patchEkleForDatePick(id, new Array ('3'), header, tableName);
}

function createIsDeneyimiTable(id){
	var header = new Array ('Başlangıç Tarihi<br />(AA/YYYY)',
							'Bitiş Tarihi<br />(AA/YYYY)',
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



jQuery(document).ready(function(){
//monthYear
	jQuery(".ayYil").live("hover",function(){
		jQuery(this).monthpicker({
			monthNames: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran', 'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
			monthNamesShort: ['Oca','Şub','Mar','Nis','May','Hzr', 'Tem','Ağu','Eyl','Eki','Kas','Ara'],
			showOn: "both",
			//buttonImage: "images/calendar.png",
			buttonImageOnly: true,
			changeYear: false,
			yearRange: 'c-70:c',
			dateFormat: 'mm/yy'
		});
	});
//monthYear
	

      
});

	

</script>

<style>
	
</style>
<!--<script type="text/javascript">//<![CDATA[
//bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
var cal = Calendar.setup({
	onSelect: function(cal) { cal.hide() }
});

//]]></script>-->