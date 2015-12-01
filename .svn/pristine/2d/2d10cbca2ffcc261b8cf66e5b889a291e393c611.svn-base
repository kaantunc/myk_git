<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=birimler&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	

$birimEk2Turleri = $this->birimEk2Turleri;

$seviyeler = $this->seviyeler;
$sektorler = $sektorler;
$bagimliBirimlerOlanSektorler = $this->bagimliBirimlerOlanSektorler;

$yeterlilikBilgi = $this->yeterlilikBilgi;
$eklenmisBirim = $this->eklenmisBirim;

// $zorunluTur = $this->zorunluBirimTur;
// $secmeliTur = $this->secmeliBirimTur;

$kayitliBirimTur = $this->kayitliBirimTur;

$birimTur = $this->birimTur;


$seviyelerText = "";
for($i=0; $i<count($seviyeler); $i++)
{
	$seviyelerText .= "<option value='".$seviyeler[$i]["SEVIYE_ID"]."' ".$selected.">".$seviyeler[$i]["SEVIYE_ADI"]."</option>";
}
	
$sektorlerText = "";
for($i=0; $i<count($sektorler); $i++)
{
	$sektorlerText .= "<option value='".$sektorler[$i]["SEKTOR_ID"]."' ".$selected.">".$sektorler[$i]["SEKTOR_ADI"]."</option>";
}

$bagimliBirimlerOlanSektorlerText = "";
for($i=0; $i<count($bagimliBirimlerOlanSektorler); $i++)
{
	$bagimliBirimlerOlanSektorlerText .= "<option value='".$bagimliBirimlerOlanSektorler[$i]["SEKTOR_ID"]."' ".$selected.">".$bagimliBirimlerOlanSektorler[$i]["SEKTOR_ADI"]."</option>";
}


?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<script type="text/javascript">

	var popupName = 'biriminDetaylariPopupDiv';
	var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
	var rowName = 'ogrenmeCiktisiRow'; 

	var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
	var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

	var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
	var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

	var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
	var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

	var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';
	var basarimOlcutuSilButtonName = 'basarimOlcutuSilButton';
	
	var basarimOlcutuNumaralariDivClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariDiv';




jQuery('.ogrenmeCiktisiEkleButton').live("click",  function (e) {

		var buttonName = 'ogrenmeCiktisiEkleButton';
		var popupIDsi = this.id.substr(buttonName.length+1);
		var ogrenmeCiktisiNumarasi = jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val();
		if(ogrenmeCiktisiNumarasi == undefined)
			ogrenmeCiktisiNumarasi = 0;
		//jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val(parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val())+1);

		yeniOgrenmeCiktisiEkle2(popupIDsi, parseInt(ogrenmeCiktisiNumarasi)+1, "", "");		
		return false;
});
function biriminEk2FormatiniBelirle(birimId, selectedValue )
{
	if(selectedValue == 'Y')
	{
		jQuery('#KontrolListesizEk2-'+birimId).hide();
		jQuery('#KontrolListesizEk2Tablolari-'+birimId).hide();
		jQuery('#kontrolListeliEk2Div1-'+birimId).show();
		jQuery('#kontrolListeliEk2Div2-'+birimId).show();
		
	}
	else
	{
		jQuery('#KontrolListesizEk2-'+birimId).show();
		jQuery('#KontrolListesizEk2Tablolari-'+birimId).show();
		jQuery('#kontrolListeliEk2Div1-'+birimId).hide();
		jQuery('#kontrolListeliEk2Div2-'+birimId).hide();
	}
	
}
function yeniOgrenmeCiktisiEkle2(popupIdsi, ogrenmeCiktisiNumarasi, ogrenmeCiktisiText, ogrenmeCiktisiBaglamiText)
{
	ogrenmeCiktisiText = ogrenmeCiktisiText.replace(/<BR\/>/gi, '\n');
	ogrenmeCiktisiBaglamiText = ogrenmeCiktisiBaglamiText.replace(/<BR\/>/gi, '\n');
	
	var popupName = 'biriminDetaylariPopupDiv';
	var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
	var rowName = 'ogrenmeCiktisiRow'; 
	var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
	var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';
	var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
	var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';
	var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
	var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';
	var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';


	var baglaminDisplayi = "";
	var baglamSilinDisplayi = "";
	var baglamEkleninDisplayi = "";
	if(ogrenmeCiktisiBaglamiText=="")
	{
		baglaminDisplayi = "display:none;";
		baglamSilinDisplayi = "display:none;";
		baglamEkleninDisplayi = "display:block;";
	}
	else
	{
		baglaminDisplayi = "display:block;";
		baglamSilinDisplayi = "display:block;";
		baglamEkleninDisplayi = "display:none;";
	}
	
	var satir='<tr class="' + rowClass + '" id="'+rowName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">'
    +    '<td class="'+ogrenmeCiktisiNumaralariTDClass+'" style="width:4%;" id="'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
    +		'<div id="ogrenmeCiktisiNumaralasiDiv-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiNumarasi+'</div>'
    +	    '<br><input type="button" id="'+ogrenmeCiktisiSilButtonName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Sil" class="'+ogrenmeCiktisiSilButtonName+'">'
    + 	 '</td>'
    +    '<td class="'+ogrenmeCiktisiTDClass+'" style="padding:10px; width:46%;" id="'+ogrenmeCiktisiTDName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
	+		 'Öğrenme Çıktısı:'
	+ 		 '<br><textarea class="ciftTirnaksiz" style="width:80%; height:25px;" name="ogrenmeCiktisi['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisi-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiText+'</textarea>'

	+ 		 '<br><input type="button" style="'+baglamEkleninDisplayi+'" class="ogrenmeCiktisiBaglamiGosterButton" id="ogrenmeCiktisiBaglamiGosterButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Ekle" />'
	
	+ 		 '<div style="'+baglaminDisplayi+'" id="ogrCktBaglamiTextDiv-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
	+ 		 'Öğrenme Çıktısı Bağlamı:'
	+ 		 '<br><textarea class="ciftTirnaksiz" style="width:80%; height:25px;" name="ogrenmeCiktisiBaglami['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisiBaglami-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiBaglamiText+'</textarea>'

	+ 		 '<input type="button" style="'+baglamSilinDisplayi+'" class="ogrenmeCiktisiBaglamiGizleButton" id="ogrenmeCiktisiBaglamiGizleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Sil" />'
	
	+ 		 '</div>'	
	+ 		 '<br><input type="button" class="yeniBasarimOlcutuEkleButton" id="yeniBasarimOlcutuEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Yeni Başarım Ölçütü Ekle >>">'
	+		 '<br><input type="button" class="yeniBasarimOlcutuTopluEkleButton" id="yeniBasarimOlcutuTopluEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Toplu Başarım Ölçütü Ekle >>">'

	
	+ 	 '</td>'
	+  	 '<td class="'+basarimOlcutuNumaralariTDClass+'" style="width:4%;" id="'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">&nbsp;</td>'
    +    '<td class="'+basarimOlcutuTDClass+'-'+ popupIdsi+ '-1" style="padding:10px; width:46%;" id="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">'
    + 	 	'Başarım Ölçütü Eklenmemiş'
    + 	 '</td>'
    +'</tr>';

    jQuery(jQuery('#'+popupName+'-'+popupIdsi+' tr.'+rowName)[jQuery('#'+popupName+'-'+popupIdsi+' tr.'+rowName).length-1]).after(satir);

    jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val(parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val())+1);

    if(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).length==0)
		jQuery('#biriminDetaylariPopupDiv-'+popupIdsi).append('<input id="ogrenmeCiktisiCountHF-'+popupIdsi+'" value="1" type="hidden" >');

	var kacOgrenmeCiktisiEklenmis = parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val());
	jQuery('#biriminDetaylariPopupDiv-'+popupIdsi).append('<input id="ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+kacOgrenmeCiktisiEklenmis+'" value="0" type="hidden" >');

	
}

function birimDetaylarinaSinavEkle (birimID, sinavTipi, sinavAciklamasi, soruSayisi, basariKriteri, minDakika, minSaniyesi, maxDakika, maxSaniyesi , soruSayisiMax, basariKriteriAciklama, sinavID, sinavAdi)
{
	//sinav tipi -> T(teorik), P(performans), D(Diğer)
	//jQuery(txtAreaElmnt).val(str.replace(/<br>/gi, '\n'));
	var rowName, silButtonName, sinavName, ekleButtonName;
	 
	if(sinavTipi=='T')
	{
		rowName = 'teorikSinavlarRow';
		silButtonName = 'teorikSinavSilButton';
		ekleButtonName = 'teorikSinavEkleButton';
		sinavName = 'buBiriminTeorikSinavlari';
		sinavIdentifier = 'T';
	}
	else if(sinavTipi=='P')
	{
		rowName = 'performansSinavlariRow';
		silButtonName = 'performansSinaviSilButton';
		ekleButtonName = 'performansSinaviEkleButton';
		sinavName = 'buBiriminPerformansSinavlari';
		sinavIdentifier = 'P';
	}
	else if(sinavTipi=='D')
	{
		rowName = 'digerSinavlarRow';
		silButtonName = 'digerSinavSilButton';
		ekleButtonName = 'digerSinavEkleButton';
		sinavName = 'buBiriminDigerSinavlari';	
		sinavIdentifier = '';
	}

	var rowClassFromID = 'sinavId-'+sinavID; 
	
	var silButtonClass = silButtonName + ' sinavSilButton';	
	
	var lastRowID = jQuery('#birimDetayiIkinciTable-'+birimID+' tr.'+rowName).length-1;
	var newRowID = lastRowID+1;

	if(sinavTipi=='T')
	{
		var soruSayisiName = 'buBiriminTeorikSinavlarininSoruSayileri';
		var soruSayisiMaxName = 'buBiriminTeorikSinavlarininSoruSayilariMax';
		var minDkSoruSuresiName = 'buBiriminTeorikSinavlarininMinDkSoruSureleri';
		var minSnSoruSuresiName = 'buBiriminTeorikSinavlarininMinSnSoruSureleri';
		var maxDkSoruSuresiName = 'buBiriminTeorikSinavlarininMaxDkSoruSureleri';
		var maxSnSoruSuresiName = 'buBiriminTeorikSinavlarininMaxSnSoruSureleri';
		var sinavAdiName 		= 'buBiriminTeorikSinavlarininAdlari';
		var basariKriteriName = 'buBiriminTeorikSinavlarininBasariKriterleri';
		var soruSayisiClass = 'numberInput';
		var minDkSoruSuresiClass = 'numberInput dakikaSpinEdit';
		var maxDkSoruSuresiClass = 'numberInput dakikaSpinEdit';
		var minSnSoruSuresiClass = 'numberInput saniyeSpinEdit';
		var maxSnSoruSuresiClass = 'numberInput saniyeSpinEdit';
		var sinavAdiClass = 'sinavAdi';
		var basariKriteriClass = 'numberInput percentage';
		
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
				+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  + newRowID 
				+   '<br><input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
				+	'<td>'
				+ 	'<strong>SINAV ADI</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+'" style="width:400px;" name="'+sinavAdiName+'[' + newRowID + ']" value="'+sinavAdi+'"></input>'
				+ 	'<br><strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea class="ciftTirnaksiz" style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi.replace(/<BR\/>/gi, '\n')+'</textarea>'
				+ 	'<br><strong>SORU SAYISI</strong><br>'
				+ 	'<input type="text" class="'+soruSayisiClass+'" style="width:50px;" name="'+soruSayisiName+'[' + newRowID + ']" value="'+soruSayisi+'"></input>(min.)'
				+	'<br>'
				+ 	'<input type="text" class="'+soruSayisiClass+'" style="width:50px;" name="'+soruSayisiMaxName+'[' + newRowID + ']" value="'+soruSayisiMax+'"></input>(max.)'
				+ 	'<br><strong>SORU SURESI (minimum/maximum)</strong><br>'
				+ 	'<div style="float:left; width:150px;">Minimum Soru Süresi</div>'
				+ 	'<input type="text" class="'+minDkSoruSuresiClass+'" style="width:50px;" name="'+minDkSoruSuresiName+'[' + newRowID + ']" value="'+minDakika+'"></input>(dk.)  '
				+ 	'<input type="text" class="'+minSnSoruSuresiClass+'" style="width:50px;" name="'+minSnSoruSuresiName+'[' + newRowID + ']" value="'+minSaniyesi+'"></input>(sn.)<br>'
				+ 	'<div style="float:left; width:150px;">Maximum Soru Süresi</div>'
				+ 	'<input type="text" class="'+maxDkSoruSuresiClass+'" style="width:50px;" name="'+maxDkSoruSuresiName+'[' + newRowID + ']" value="'+maxDakika+'"></input>(dk.) '
				+ 	'<input type="text" class="'+maxSnSoruSuresiClass+'" style="width:50px;" name="'+maxSnSoruSuresiName+'[' + newRowID + ']" value="'+maxSaniyesi+'"></input>(sn.)'
				+ 	'<br><strong>BAŞARI KRİTERİ</strong><br>'
				+ 	'<strong>%</strong><input type="text" class="'+basariKriteriClass+'" style="width:50px;" name="'+basariKriteriName+'[' + newRowID + ']" value="'+basariKriteri+'"></input>'
				+	'</td>'
				+ 	'</tr>');

		
			
	}
	else if(sinavTipi=='P')
	{
		var sinavAdiName 		= 'buBiriminPerformansSinavlarininAdlari';
		var sinavAdiClass = 'sinavAdi';
		var basariKriteriName = 'buBiriminPerformansSinavlarininBasariKriterleri';
		var basariKriteriClass = 'numberInput percentage';
		var basariKriteriAciklamaName = 'buBiriminPerformansSinavlarininBasariKriterleriAciklama';
		var basariKriteriAciklamaClass = '';
				
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
				+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  + newRowID 
				+   '<br><input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
				+	'<td>'
				+ 	'<strong>SINAV ADI</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+'" style="width:400px;" name="'+sinavAdiName+'[' + newRowID + ']" value="'+sinavAdi+'"></input>'
				+ 	'<br><strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea class="ciftTirnaksiz" style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi.replace(/<BR\/>/gi, '\n')+'</textarea>'
				+ 	'<br><strong>BAŞARI KRİTERİ</strong><br>'
				+ 	'<strong>%</strong><input type="text" class="'+basariKriteriClass+'" style="width:50px;" name="'+basariKriteriName+'[' + newRowID + ']"  value="'+basariKriteri+'"></input>'
				+ 	'<br><strong>BAŞARI KRİTERİ AÇIKLAMASI</strong><br>'
				+ 	'<strong></strong><input type="text" class="ciftTirnaksiz '+basariKriteriAciklamaClass+'" style="width:150px;" name="'+basariKriteriAciklamaName+'[' + newRowID + ']"  value="'+basariKriteriAciklama+'"></input>'
				+	'</td>'
				+ 	'</tr>');

			
			
	}
	else	
	{	
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
		+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  /*+ newRowID*/ + '<br>'
		+ 	'<input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
		+	'<td><textarea class="ciftTirnaksiz" style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi.replace(/<BR\/>/gi, '\n')+'</textarea></td>'
		+	'</tr>');

	}

	var degerlendirmeAraciRows = jQuery('#KontrolListesizEk2Tablolari-'+birimID+' tbody tr td.DegerlendirmeAraciTD');
	
	for(var i = 0; i<jQuery(degerlendirmeAraciRows).length; i++)
	{
		var tdIDsiArray = jQuery(degerlendirmeAraciRows)[i].id.split("-");
		var ogrenmeCiktisiID = tdIDsiArray[2];
		var basarimOlcutuID = tdIDsiArray[3];

		var checkboxSinavIdentifier = sinavIdentifier;
		if(sinavIdentifier == '')
			checkboxSinavIdentifier = 'D';
		
		var checkBoxDivID = 'DegerlendirmeAraciTDDiv-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+sinavIdentifier + '-' + newRowID ;
		var checkBoxID = 'DegerlendirmeAraciTDCheck-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+checkboxSinavIdentifier + '-' + newRowID ;
		//var checkBoxName = 'DegerlendirmeAraciTDCheck['+birimID+']['+ogrenmeCiktisiID+']['+basarimOlcutuID+']['+sinavIdentifier + '][]';
		var checkBoxName = 'DegerlendirmeAraciTDCheckbox[]';

		
		var checkBoxValue = ogrenmeCiktisiID + '-' + basarimOlcutuID + '-'+checkboxSinavIdentifier + '-' + newRowID;

		if(sinavTipi=='T' || sinavTipi=='P')
		{	
			jQuery(jQuery(degerlendirmeAraciRows)[i]).append('<div id="'+checkBoxDivID+'" style="border:1px solid #3C3C3C; float:left; width:50px;"><input type="checkbox" value="'+checkBoxValue+'" name="'+checkBoxName+'" id="'+checkBoxID+'"></input>'
			+	'<label style="margin-left:5px; margin-right:5px; font-weight:normal;" for="'+checkBoxID+'">'+sinavIdentifier + newRowID+'</label></div>');

				
		}
	}

	jQuery('textarea').each(function(e){
		jQuery(this).val(jQuery(this).val().replace(/<BR\/>/gi, "\r\n"));
	});
/////////////////////////////// T1 P1 i BAŞARIMÖLÇÜTÜ BİLGİ VE ANLAYIŞ EKLE
/*	var kontrolListeliEk2_1_DegerlendirmaAraciDivleri = jQuery('.KontrolListeliEk2Tablosu1-DegerlendirmeAraci_Div-'+birimID);
	for(var i = 0; i<jQuery(kontrolListeliEk2_1_DegerlendirmaAraciDivleri).length; i++)
	{
		var tdIDsiArray = jQuery(kontrolListeliEk2_1_DegerlendirmaAraciDivleri)[i].id.split("-");
		var ogrenmeCiktisiID = tdIDsiArray[2];
		var basarimOlcutuID = tdIDsiArray[3];

		var checkboxSinavIdentifier = sinavIdentifier;
		if(sinavIdentifier == '')
			checkboxSinavIdentifier = 'D';
		
		var checkBoxDivID = 'DegerlendirmeAraciTDDiv-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+sinavIdentifier + '-' + newRowID ;
		var checkBoxID = 'DegerlendirmeAraciTDCheck-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+checkboxSinavIdentifier + '-' + newRowID ;
		//var checkBoxName = 'DegerlendirmeAraciTDCheck['+birimID+']['+ogrenmeCiktisiID+']['+basarimOlcutuID+']['+sinavIdentifier + '][]';
		var checkBoxName = 'DegerlendirmeAraciTDCheckbox[]';

		
		var checkBoxValue = ogrenmeCiktisiID + '-' + basarimOlcutuID + '-'+checkboxSinavIdentifier + '-' + newRowID;

		if(sinavTipi=='T' || sinavTipi=='P')
		jQuery(jQuery(kontrolListeliEk2_1_DegerlendirmaAraciDivleri)[i]).append('<div id="'+checkBoxDivID+'" style="border:1px solid #3C3C3C; float:left; width:50px;"><input type="checkbox" value="'+checkBoxValue+'" name="'+checkBoxName+'" id="'+checkBoxID+'"></input>'
					+	'<label style="margin-left:5px; margin-right:5px; font-weight:normal;" for="'+checkBoxID+'">'+sinavIdentifier + newRowID+'</label></div>');
				
	}

/////////////////////////////// T1 P1 i BAŞARIMÖLÇÜTÜ BECERİYE EKLE
	var kontrolListeliEk2_2_DegerlendirmaAraciDivleri = jQuery('.KontrolListeliEk2Tablosu2-DegerlendirmeAraci_Div-'+birimID);
	for(var i = 0; i<jQuery(kontrolListeliEk2_2_DegerlendirmaAraciDivleri).length; i++)
	{
		var tdIDsiArray = jQuery(kontrolListeliEk2_2_DegerlendirmaAraciDivleri)[i].id.split("-");
		var ogrenmeCiktisiID = tdIDsiArray[2];
		var basarimOlcutuID = tdIDsiArray[3];

		var checkboxSinavIdentifier = sinavIdentifier;
		if(sinavIdentifier == '')
			checkboxSinavIdentifier = 'D';
		
		var checkBoxDivID = 'DegerlendirmeAraciTDDiv-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+sinavIdentifier + '-' + newRowID ;
		var checkBoxID = 'DegerlendirmeAraciTDCheck-'+birimID+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+checkboxSinavIdentifier + '-' + newRowID ;
		//var checkBoxName = 'DegerlendirmeAraciTDCheck['+birimID+']['+ogrenmeCiktisiID+']['+basarimOlcutuID+']['+sinavIdentifier + '][]';
		var checkBoxName = 'DegerlendirmeAraciTDCheckbox[]';

		
		var checkBoxValue = ogrenmeCiktisiID + '-' + basarimOlcutuID + '-'+checkboxSinavIdentifier + '-' + newRowID;

		if(sinavTipi=='T' || sinavTipi=='P')
		jQuery(jQuery(kontrolListeliEk2_2_DegerlendirmaAraciDivleri)[i]).append('<div id="'+checkBoxDivID+'" style="border:1px solid #3C3C3C; float:left; width:50px;"><input type="checkbox" value="'+checkBoxValue+'" name="'+checkBoxName+'" id="'+checkBoxID+'"></input>'
					+	'<label style="margin-left:5px; margin-right:5px; font-weight:normal;" for="'+checkBoxID+'">'+sinavIdentifier + newRowID+'</label></div>');
				
	}
*/

	

	
}


function yeniBasarimOlcutuEkle2(popupIdsi, rowIDsi, basarimOlcutuText, basarimOlcutuBaglamiText, basarimOlcutId )
{
	basarimOlcutuText = basarimOlcutuText.replace(/<BR\/>/gi, '\n');
	basarimOlcutuBaglamiText = basarimOlcutuBaglamiText.replace(/<BR\/>/gi, '\n');
	// rowIDsi - > hangi rowun altına ekleyeceği  id = ogrenmeCiktisiRow-49-3 gibisinden
	var popupName = 'biriminDetaylariPopupDiv';
	var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
	var rowName = 'ogrenmeCiktisiRow'; 

	var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
	var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

		
	
	var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
	var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

	var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
	var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

	var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';

	var rowElement = jQuery('#'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-1'); 
	var textAreaElements = jQuery('#'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1 textarea');


	var kacOgrenmeCiktisiEklenmis = parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val());
	var kacBasarimOlcutuEklenmis = parseInt(jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val());
	if(isNaN(kacBasarimOlcutuEklenmis))
		kacBasarimOlcutuEklenmis = 0;


	var baglaminDisplayi = "";
	var baglamSilinDisplayi = "";
	var baglamEkleninDisplayi = "";
	if(basarimOlcutuBaglamiText != "")
	{
		baglaminDisplayi = "display:block;";
		baglamSilinDisplayi = "display:block;";
		baglamEkleninDisplayi = "display:none;";
	}
	else
	{
		baglaminDisplayi = "display:none;";
		baglamSilinDisplayi = "display:none;";
		baglamEkleninDisplayi = "display:block;";
	}
		
	var yeniEklenecekBasariOlcutununNumarasi = 0;
	
	if(textAreaElements.length == 0)
	{	
		jQuery('#'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1').html(
				'<div id="'+basarimOlcutuNumaralariDivClass+'-'+popupIdsi+'-'+rowIDsi+'-1">'
				+ jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).text()+".1"
				+ '</div>'
				+ '<br /><input type="button" id="basarimOlcutuSilButton-'+popupIdsi+'-'+rowIDsi+'-1" value="Sil" class="basarimOlcutuSilButton">'
		);

		var basarimOlcutuTextAreaHTML = 'Başarım Ölçütü:'
		+ '<br>'
		+ '<textarea class="ciftTirnaksiz" style="width:80%; height:25px;" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-1" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]"  >'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'" id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-1" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-1" style="'+baglaminDisplayi+'">'

		
		+ 'Başarım Ölçütü Bağlamı:'
		+ '<br><textarea class="ciftTirnaksiz" style="width:80%; height:25px;" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-1"  name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]">'+basarimOlcutuBaglamiText+'</textarea>'

		+ '<br><input style="'+baglamSilinDisplayi+'" id="basarimOlcutuBaglamiGizleButton-'+popupIdsi+'-'+rowIDsi+'-1" class="basarimOlcutuBaglamiGizleButton" type="button" value="Bağlam Sil">'
		+ '</div>'

		;

		jQuery('#'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1').html(basarimOlcutuTextAreaHTML);

		jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val("1");

		yeniEklenecekBasariOlcutununNumarasi = 1;
		
		
	}
	else
	{
		var hiddenFieldName = 'ogrenmeCiktisininBasarimOlcutleriCountHF';
		
		var rowSpanValue = parseInt(jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan"));
		if(isNaN(rowSpanValue)) rowSpanValue = 1;
		var newRowSpanValue = ""+(rowSpanValue+1);
		
		yeniEklenecekBasariOlcutununNumarasi = kacBasarimOlcutuEklenmis +1;
		var rowText = '<tr id="'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="'+rowClass+'">'
		+ '<td id="'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="width:4%;" class="'+basarimOlcutuNumaralariTDClass+'">'
		+ '<div id="'+basarimOlcutuNumaralariDivClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'">'
		+rowIDsi+'.'+yeniEklenecekBasariOlcutununNumarasi
		+'</div><br>'
		+ '<input type="button" class="basarimOlcutuSilButton" value="Sil" id="basarimOlcutuSilButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'"></td>'
		+ '<td id="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="padding:10px; width:46%;" class="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'">'
		+ 'Başarım Ölçütü:'
		+ '<br>'
		+ '<textarea class="ciftTirnaksiz" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'"  id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="'+baglaminDisplayi+'">'
		
		
		+ 'Başarım Ölçütü Bağlamı:<br>'
		+ '<textarea class="ciftTirnaksiz" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuBaglamiText+'</textarea>'

		+ '<br><input style="'+baglamSilinDisplayi+'" id="basarimOlcutuBaglamiGizleButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="basarimOlcutuBaglamiGizleButton" type="button" value="Bağlam Sil">'
		+ '</div>'

		+ '</td>'
		+ '</tr>';

		
		jQuery('#'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-'+kacBasarimOlcutuEklenmis).after(rowText);
		jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", newRowSpanValue);
		jQuery('#'+ogrenmeCiktisiTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", newRowSpanValue);

		if(basarimOlcutuBaglamiText!="")
			jQuery('#basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi).click();
		
	}

	
	jQuery('#'+hiddenFieldName+'-'+popupIdsi+'-'+rowIDsi).val(kacBasarimOlcutuEklenmis+1);
	KontrolListesizEk2TablosunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi, basarimOlcutId);
	KontrolListeliTablolardaDropDownKodunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi, basarimOlcutId);
	
	return true;
}

function basarimOlcutuSil(popupIdsi, rowIDsi, basarimOlcutuIDsi)
{
	var popupName = 'biriminDetaylariPopupDiv';
	var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
	var rowName = 'ogrenmeCiktisiRow'; 

	var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
	var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

	var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
	var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

	var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
	var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

	var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';

	var rowSpanValue = parseInt(jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan"));
	if(isNaN(rowSpanValue) || rowSpanValue == 1 )
	{
		jQuery('#'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+basarimOlcutuIDsi).html("");
		jQuery('#'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+basarimOlcutuIDsi).html("<strong>Başarım Ölçütü Eklenmemiş</strong>");
	}
	else
	{	
		jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", rowSpanValue-1);
		jQuery('#'+ogrenmeCiktisiTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", rowSpanValue-1);
		var rowName = 'ogrenmeCiktisiRow';
		jQuery('#'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-'+basarimOlcutuIDsi).remove();
	}

	var hiddenFieldName = 'ogrenmeCiktisininBasarimOlcutleriCountHF';
	
	var ekliBasarimOlcutuSayisi = jQuery('#'+hiddenFieldName+'-'+popupIdsi+'-'+rowIDsi).val();
	//silmedenSonraBasarimOlcutuNumaralariniDuzenle(popupIdsi, rowIDsi, basarimOlcutuIDsi, ekliBasarimOlcutuSayisi);
		
//	jQuery('#'+hiddenFieldName+'-'+popupIdsi+'-'+rowIDsi).val(parseInt(jQuery('#'+hiddenFieldName+'-'+popupIdsi+'-'+rowIDsi).val())-1);

	OgrenmeCiktisiVeBasarimOlcutuNumaralariniDuzenle(popupIdsi);
}

function ogrenmeCiktisiSil(popupIdsi, rowIDsi)
{
	var tumOgrenmeCiktilari = jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val();
	var eklenmisBasarimOlcutleri = jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val();
	if(eklenmisBasarimOlcutleri==0 )
		eklenmisBasarimOlcutleri = 1;
	for(var i=1; i<=parseInt(eklenmisBasarimOlcutleri); i++)
	{	
		jQuery('#ogrenmeCiktisiRow-'+popupIdsi+'-'+rowIDsi+'-'+i).hide('slow');
		jQuery('#ogrenmeCiktisiRow-'+popupIdsi+'-'+rowIDsi+'-'+i).remove(); 
	}
	
//	jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val(0);

	OgrenmeCiktisiVeBasarimOlcutuNumaralariniDuzenle(popupIdsi);
	
}


function OgrenmeCiktisiVeBasarimOlcutuNumaralariniDuzenle(popupIdsi)
{
	var ogrenmeCiktisiCounter = 0;
	var basarimOlcutuCounter = 0;

	var ogrenmeCiktisiRows = jQuery('#biriminDetaylariTablosu-'+popupIdsi+' tbody').children();

	for(var i= 1; i<ogrenmeCiktisiRows.length; i++)
	{
		var rowIdsi = ogrenmeCiktisiRows[i].id;
		var rowIDsiArray = rowIdsi.split("-"); 
		var ogrenmeCiktisiID = rowIDsiArray[2];
		var basarimOlcutuID = rowIDsiArray[3];

		var rowElement = ogrenmeCiktisiRows[i];
		var rowunTDleri = ogrenmeCiktisiRows[i].getChildren();

		var basOlcNumarasiIndex, basOlcIndex;
		
		if(rowunTDleri.length == 4)//yeni bir ogrenmeCiktisi
		{
			if(ogrenmeCiktisiCounter!=0)
			{
				if(jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter).length == 0)
					jQuery('<input>').attr({
					    type: 'hidden',
					    id: 'ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter,
					    value: ''+basarimOlcutuCounter
					}).appendTo('form#ChronoContact_yeterlilik_taslak');
				else
					jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter).val(basarimOlcutuCounter);						
			}

			
			ogrenmeCiktisiCounter++;
			basarimOlcutuCounter = 0;

			////////////////////////////////
			
			basOlcNumarasiIndex = 2;
			basOlcIndex = 3;

			jQuery(rowunTDleri[0]).attr('id', 'ogrenmeCiktisiNumaralariTD-'+popupIdsi+'-'+ogrenmeCiktisiCounter);
				jQuery(rowunTDleri[0]).children().filter('div').attr('id',  'ogrenmeCiktisiNumaralasiDiv-'+popupIdsi+'-'+ogrenmeCiktisiCounter);
				jQuery(rowunTDleri[0]).children().filter('div').html(ogrenmeCiktisiCounter);

				jQuery(rowunTDleri[0]).children().filter('input').attr('id',  'ogrenmeCiktisiSilButton-'+popupIdsi+'-'+ogrenmeCiktisiCounter);

				jQuery(rowunTDleri[1]).attr('id', 'ogrenmeCiktisiDataTD-'+popupIdsi+'-'+ogrenmeCiktisiCounter);

			var textAreas = jQuery(rowunTDleri[1]).children().filter('textarea');
				jQuery(textAreas[0]).attr('id',   'ogrenmeCiktisi-'+popupIdsi+'-'+ogrenmeCiktisiCounter);
				jQuery(textAreas[0]).attr('name', 'ogrenmeCiktisi['+popupIdsi+']['+ogrenmeCiktisiCounter+']');
				jQuery(textAreas[1]).attr('id',   'ogrenmeCiktisiBaglami-'+popupIdsi+'-'+ogrenmeCiktisiCounter);
				jQuery(textAreas[1]).attr('name', 'ogrenmeCiktisiBaglami['+popupIdsi+']['+ogrenmeCiktisiCounter+']');
					
				jQuery(rowunTDleri[1]).children().filter('input').attr('id', 'yeniBasarimOlcutuEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiCounter);

			if(jQuery(rowunTDleri[3]).children().filter('textarea').length != 0)
				basarimOlcutuCounter = 1;		
				/////////////////////////////////
		}
		else
		{	
			basarimOlcutuCounter++;
			
			basOlcNumarasiIndex = 0;
			basOlcIndex = 1;
			
		}
		
		///// BU KISIM IKISI ICIN DE AYNI, BASARIM OLCUTU ILE DATALARI VAR ////////////////////////
		//rowunTDleri[basOlcNumarasiIndex]
		//rowunTDleri[basOlcIndex]
			var x = 0;	

			var rowunBasarimOlcutuDegeri;
			if(basarimOlcutuCounter == 0)
				rowunBasarimOlcutuDegeri = 1;
			else
				rowunBasarimOlcutuDegeri = basarimOlcutuCounter;
			
			jQuery(rowunTDleri[basOlcNumarasiIndex]).attr('id', 'ogrenmeCiktisininBasarimOlcutuNumaralariTD-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+rowunBasarimOlcutuDegeri);

				if(basarimOlcutuCounter!=0)
				{
					jQuery(rowunTDleri[basOlcNumarasiIndex]).children().filter('div').attr('id',  'ogrenmeCiktisininBasarimOlcutuNumaralariDiv-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+basarimOlcutuCounter);
					jQuery(rowunTDleri[basOlcNumarasiIndex]).children().filter('div').html(ogrenmeCiktisiCounter+'.'+basarimOlcutuCounter);
	
					jQuery(rowunTDleri[basOlcNumarasiIndex]).children().filter('input').attr('id',  'basarimOlcutuSilButton-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+basarimOlcutuCounter);
				}
			jQuery(rowunTDleri[basOlcIndex]).attr('id', 'ogrenmeCiktisininBasarimOlcutuDataTD-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+rowunBasarimOlcutuDegeri);

				if(basarimOlcutuCounter!=0)
				{
					var textAreas = jQuery(rowunTDleri[basOlcIndex]).children().filter('textarea');
					jQuery(textAreas[0]).attr('id',   'basarimOlcutu-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+rowunBasarimOlcutuDegeri);
					jQuery(textAreas[0]).attr('name', 'basarimOlcutu['+popupIdsi+']['+ogrenmeCiktisiCounter+'][]');
					jQuery(textAreas[1]).attr('id',   'basarimOlcutuBaglami-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+rowunBasarimOlcutuDegeri);
					jQuery(textAreas[1]).attr('name', 'basarimOlcutuBaglami['+popupIdsi+']['+ogrenmeCiktisiCounter+'][]');
				}
				
		////////////////////////////////////////////////////////////////////////////////
		
		jQuery(rowElement).attr('id', 'ogrenmeCiktisiRow-'+popupIdsi+'-'+ogrenmeCiktisiCounter+'-'+rowunBasarimOlcutuDegeri);

		jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val(ogrenmeCiktisiCounter);
		
	}
	
	if(jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter).length == 0)
		jQuery('<input>').attr({
		    type: 'hidden',
		    id: 'ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter,
		    value: ''+(basarimOlcutuCounter)
		}).appendTo('form#ChronoContact_yeterlilik_taslak');
	else
		jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+ogrenmeCiktisiCounter).val(basarimOlcutuCounter+1);
	
}


function BirimGelistirenKurumKuruluslaraEkle(kurumKurulusAdi, popupIDsi, yeterliliktenMiEklendi)
{
	var popupAdi = 'biriminDetaylariPopupDiv';
	var rowName = 'birimGelistirenKuruluslarRow';
	var silButtonName = 'birimGelistirenKuruluslardanSilButton';
	var silButtonClass = silButtonName;
	var kurumKurulusInputName = 'birimGelistirenKuruluslar';	
	var newRowID = jQuery('#birimDetayiIkinciTable-'+popupIDsi+' tr.' + rowName ).length;//niye length, çünkü header row da aynı classda
	var lastRowID = newRowID -1;
	
	
	
	if(yeterliliktenMiEklendi==true)
	{
			var readOnly = ' readOnly="readOnly" ';
			silButtonClass += ' yeterliliktenEklendi';
	}
	

	var rowText = '<tr class="' + rowName + '" id="' + rowName + '-'+newRowID +'">' 
	+	'<td class="blueBackgrounded" style="width:30px">'
	+ 	'<input type="button" value="SİL" id="' + silButtonName + '-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
	+	'<td>'
	+ 	'<input type="text" '+ readOnly +' class="'+kurumKurulusInputName+'" style="width:80%;" name="'+kurumKurulusInputName+'-'+popupIDsi+'[' + newRowID + ']" value="' + kurumKurulusAdi + '"></input>'
	+	'</td>'
	+ 	'</tr>';

	var jQselector = '';
	
	if(jQuery('#' + popupAdi + '-' + popupIDsi + ' .' + rowName ).length > 1)
		jQselector = '#' + popupAdi + '-' + popupIDsi + ' #' + rowName + '-' + lastRowID;
	else	
		jQselector = '#' + popupAdi + '-' + popupIDsi + ' .yeterliligiGelistirenKuruluslardan';
	
	jQuery(jQuery(jQselector)[jQuery(jQselector).length-1]).after( rowText );
}

function KontrolListeliTablolardaDropDownKodunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi, basarimOlcutId)
{

	var DropDownText = '<option value=\''+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'#'+basarimOlcutuText+'\'>'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+' : '+basarimOlcutuText+'</option>';
	//var DropDownText = '<option value=\''+basarimOlcutId+'\'>'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+' : '+basarimOlcutuText+'</option>';
	if(jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).length==0)
		jQuery('#biriminDetaylariPopupDiv-'+popupIdsi).append('<input id="biriminKontrolListeliTablolarinaDropdown-'+popupIdsi+'" value="'+DropDownText+'" type="hidden" >');
	else
		jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).val(	jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).val()+DropDownText);
		
	
}

function KontrolListesizEk2TablosunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, ogrenmeCiktisiID, basarimOlcutuID)
{
	var indexToAppendTo = 0;
	var dataRowuVarMi = false;
	for(var i=0; i<jQuery('#KontrolListesizEk2Tablolari-'+popupIdsi+' tbody tr').length ; i++ )
	{
		var curOgrenmeCiktisiid = jQuery('#KontrolListesizEk2Tablolari-'+popupIdsi+' tbody tr')[i].id.split('-');
		if(curOgrenmeCiktisiid=="")
			dataRowuVarMi = false;
		else
			dataRowuVarMi = true;
		if(parseInt(curOgrenmeCiktisiid[2]) < parseInt(ogrenmeCiktisiID))
			indexToAppendTo++;
		else if(parseInt(curOgrenmeCiktisiid[2]) == parseInt(ogrenmeCiktisiID) && parseInt(curOgrenmeCiktisiid[3]) < parseInt(basarimOlcutuID))
			indexToAppendTo++;
		//else just skip
	}

	var trClassText = "";
	if(indexToAppendTo%2 == 1)
		trClassText = "odd";
	else
		trClassText = "even";
	
	var rowText = '<tr id="KontrolListesizEk2TablolariTD-'+popupIdsi+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'" class="'+trClassText+'">'
	+'<td style="width:40%;" class="  sorting_1">'
	+	'<strong>'+ogrenmeCiktisiID+'.'+basarimOlcutuID+': '+basarimOlcutuText+'</strong>'
	+'</td>'
	+'<td style="width:60%;" id="DegerlendirmeAraciTD-'+popupIdsi+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'" class="DegerlendirmeAraciTD ">';
	+'</td>'
	+'</tr>';

	if(dataRowuVarMi == true)
		jQuery(jQuery('#KontrolListesizEk2Tablolari-'+popupIdsi+' tbody tr')[indexToAppendTo-1]).after(rowText);
	else
		jQuery(jQuery('#KontrolListesizEk2Tablolari-'+popupIdsi+' tbody')[0]).html(rowText);
}


function ek2CheckboxlariniCheckle(birimID, checklenecekCheckboxArrayi)
{
	for(var i=0; i<checklenecekCheckboxArrayi.length; i++)
		jQuery('#DegerlendirmeAraciTDCheck-'+birimID+'-'+checklenecekCheckboxArrayi[i]).attr("checked", "checked");	
}

function ek2KontrolListeliOlcmeDegerlendirmeleriniCheckle()
{
	<?php 
	$eklenmisBirim = $this->eklenmisBirim;
	for($ii=0; $ii<count($eklenmisBirim); $ii++)//HER BIRIM ICIN
	{
		if($eklenmisBirim[$ii]["YETERLILIK_ID"] == $eklenmisBirim[$ii]["BAGIMLI_OLDUGU_YET_ID2"])
		{
			$birimID = $eklenmisBirim[$ii]['BIRIM_ID'];
			$biriminEk2si_KontrolListeliTablo1ViewID = 'biriminEk2si_KontrolListeli-Tablo1-'.$birimID;
			$biriminEk2si_KontrolListeliTablo1 = $this->$biriminEk2si_KontrolListeliTablo1ViewID;
			
			$biriminEk2si_KontrolListeliTablo2ViewID = 'biriminEk2si_KontrolListeli-Tablo2-'.$birimID;
			$biriminEk2si_KontrolListeliTablo2 = $this->$biriminEk2si_KontrolListeliTablo2ViewID;
			
			$model=$this->getModel();
			$birimEk2leri = $model->getBiriminEk2si_KontrolListeli($birimID);
			foreach($birimEk2leri as $birimEk2si)
			{
				$ek2_kontrol_listeli_id = $birimEk2si['EK2_KONTROL_LISTELI_ID'];
				$degerlendirmeAraclari = $model->getEk2KontrolListele_DegerlendirmeAraclari ($ek2_kontrol_listeli_id);
				for($jj=0; $jj<count($degerlendirmeAraclari); $jj++)
					echo ' jQuery("#kontrolListeliOlcmeDegerlendirmesi-'.$birimID.'-'.$degerlendirmeAraclari[$jj]['EK2_KONTROL_LISTELI_ID'].'-'.$degerlendirmeAraclari[$jj]['DEGERLENDIRME_ARACI_HARF'].'-'.$degerlendirmeAraclari[$jj]['DEGERLENDIRME_ARACI_NUMARA'].'").attr("checked", "checked"); ';
				
			}
		}
	}
		
	?>
}


function Ek2yeBasarimOlcutuYetkinlikEkle(birimId, yetkinlikValue, bo_text, degerlendirme_araci_text, row_id, sira_no)
{
	jQuery('#KontrolListeliEk2Tablosu1-'+birimId+' tbody').append(

	  '<tr class="KontrolListeliEk2Tablosu1Row RowID-'+row_id+'">'
	  + '<td>'
		+ '<input style="width:40%; float:left; height:21px;" type="button" value="SİL" class="KontrolListeliEk2Tablosu1SilButton" />'
		+ '&nbsp;BG<input class="ciftTirnaksiz" style="width:30%; float:right;" type="text" name="KontrolListeliEk2Tablosu1-SiraNo-'+birimId+'[]" class="numberInput" value="'+sira_no+'" />'
	+ '</td>'
	+ '<td>'
		+ '<input class="ciftTirnaksiz" style="width:100%;" type="text" name="KontrolListeliEk2Tablosu1-Input-'+birimId+'[]" value="'+yetkinlikValue+'" />'
	+ '</td>'
	+ '<td>'
	+ 	'<textarea class="ciftTirnaksiz" style="height:16px; width:100%;" name="KontrolListeliEk2Tablosu1-standartBasarimOlcutu-'+birimId+'[]">'+bo_text+'</textarea>'
	+ '</td>'  
	+ '<td>'
	+ 	'<select style="width:100%;" class="KontrolListeliEk2Tablosu1-Select-'+birimId+'" name="KontrolListeliEk2Tablosu1-Select-'+birimId+'[]" > '+ jQuery('#biriminKontrolListeliTablolarinaDropdown-'+birimId).val() +'</select>'
	+ '</td>'
	+ '<td>'
		+ 	'<div class="KontrolListeliEk2Tablosu1-DegerlendirmeAraci_Div-'+birimId+'">'+degerlendirme_araci_text+'</div>'
	+ '</td>'
	+ '</tr>'		
	);

	var txtAreaElmnt = jQuery('.KontrolListeliEk2Tablosu1Row').filter('.RowID-'+row_id).children()[2].getChildren()[0];
	var str=jQuery(txtAreaElmnt).val();
	jQuery(txtAreaElmnt).val(str.replace(/<BR\/>/gi, '\n'));
}
function Ek2yeBasarimOlcutuAnlayisEkle(birimId, anlayisBilgisiValue, bo_text, degerlendirme_araci_text, row_id, sira_no)
{
	jQuery('#KontrolListeliEk2Tablosu2-'+birimId+' tbody').append(
	  '<tr class="KontrolListeliEk2Tablosu2Row RowID-'+row_id+'">'
	+ '<td>'
		+ 	'<input style="width:40%; height:21px; float:left;" type="button" value="SİL" class="KontrolListeliEk2Tablosu2SilButton" />'
		+ 	'&nbsp;BY<input class="ciftTirnaksiz" style="width:30%; float:right;" type="text" name="KontrolListeliEk2Tablosu2-SiraNo-'+birimId+'[]" value="'+sira_no+'"  />'
	+ '</td>'
	+ '<td>'
		+ '<input class="ciftTirnaksiz" style="width:100%;" type="text" name="KontrolListeliEk2Tablosu2-Input-'+birimId+'[]" value="'+anlayisBilgisiValue+'"  />'
	+ '</td>'
  	+ '<td>'
	+ 	'<textarea class="ciftTirnaksiz" style="height:16px; width:100%;" name="KontrolListeliEk2Tablosu2-standartBasarimOlcutu-'+birimId+'[]" >'+bo_text+'</textarea>'
	+ '</td>'  
	+ '<td>'
	+ '<select style="width:100%;" class="KontrolListeliEk2Tablosu2-Select-'+birimId+'" name="KontrolListeliEk2Tablosu2-Select-'+birimId+'[]" > '+ jQuery('#biriminKontrolListeliTablolarinaDropdown-'+birimId).val() +'< /select></td>'
	
	+ '<td>'
	+ 	'<div class="KontrolListeliEk2Tablosu2-DegerlendirmeAraci_Div-'+birimId+'">'+degerlendirme_araci_text+'</div>'
	+ '</td>'
	+ '</tr>'		
	);

	var txtAreaElmnt = jQuery('.KontrolListeliEk2Tablosu2Row').filter('.RowID-'+row_id).children()[2].getChildren()[0];
	var str=jQuery(txtAreaElmnt).val();
	jQuery(txtAreaElmnt).val(str.replace(/<BR\/>/gi, '\n'));
}

function Ek2yeEnSonEklenenDropDownIndexiniDuzenle1(birimId, ogrenmeCiktisiIndex, basarimOlcutuIndex)
{
	var selectSayisi = jQuery("#KontrolListeliEk2Tablosu1-"+birimId+" .KontrolListeliEk2Tablosu1-Select-"+birimId).length;
	var eklenmisSelect = jQuery("#KontrolListeliEk2Tablosu1-"+birimId+" .KontrolListeliEk2Tablosu1-Select-"+birimId)[selectSayisi-1];
	for(var i=0; i<jQuery(eklenmisSelect).children().length; i++)
	{
		jQuery(jQuery(eklenmisSelect).children()[i]).removeAttr("selected");
	}
	for(var i=0; i<jQuery(eklenmisSelect).children().length; i++)
	{
		var degerler = jQuery(jQuery(eklenmisSelect).children()[i]).val().split("#");
		//if(jQuery(jQuery(eklenmisSelect).children()[i]).val()== ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
		if(degerler[0] == ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
			jQuery(jQuery(eklenmisSelect).children()[i]).attr("selected", "selected");
	}
}
function Ek2yeEnSonEklenenDropDownIndexiniDuzenle2(birimId, ogrenmeCiktisiIndex, basarimOlcutuIndex)
{
	var selectSayisi = jQuery("#KontrolListeliEk2Tablosu2-"+birimId+" .KontrolListeliEk2Tablosu2-Select-"+birimId).length;
	var eklenmisSelect = jQuery("#KontrolListeliEk2Tablosu2-"+birimId+" .KontrolListeliEk2Tablosu2-Select-"+birimId)[selectSayisi-1];
	for(var i=0; i<jQuery(eklenmisSelect).children().length; i++)
	{
		jQuery(jQuery(eklenmisSelect).children()[i]).removeAttr("selected");
	}
	for(var i=0; i<jQuery(eklenmisSelect).children().length; i++)
	{
		var degerler1 = jQuery(jQuery(eklenmisSelect).children()[i]).val().split("#");
		//if(jQuery(jQuery(eklenmisSelect).children()[i]).val()== ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
		if(degerler1[0]== ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
			jQuery(jQuery(eklenmisSelect).children()[i]).attr("selected", "selected");
	}
}


</script>

<div id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv" style=" width: 945px; height:550px; background-color: white; border:1px solid #00A7DE; display: none;">
	<div style="float:left; width:75%; padding-left:25%; height:87%; padding-top:5%; overflow:auto;" id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv">
	
	</div>
	<div style="float:left; width:100%; height:25%;">
		<input type="button" value="Kaydet" id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv-KaydetButton" />
		<input type="button" value="Kapat" onclick="jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv').trigger('close');" />
	</div>
</div>

<!-- Yeterliliğin Yapısı -->
<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">BİRİMLER</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div style="width:100%; float:left;">


	<div style="width: 100%; float: left; padding-left: 40px; padding-top: 10px; padding-bottom:10px;">
		<a id="addBagimsizBirimTogglerButton" href="">Varolan Birim Ekle</a>
	</div>
	<div style="display: none; border: 1px solid #898989; padding-left: 40px; padding-bottom:10px; margin-bottom:15px; padding-top: 10px; padding-right:10px; width: 90%; float: left;"
		class="bagimsiz_birim_wrapper" id="bagimsiz_birim_wrapper">
		<div style="float:left; width:100%;">
			<input onchange="radioButtonsChanged();" type="radio" id="bagimliBagimsizRadio-1" name="bagimliBagimsizRadio" value="1">Bağımlı Birim</input> <br>
			<input onchange="radioButtonsChanged();" type="radio" id="bagimliBagimsizRadio-2" name="bagimliBagimsizRadio" value="2">Bağımsız Birim</input>   
		</div>
		<div style="float: left; width: 100%; display:none; padding-top:10px;" id="BagimsizBirimEkle_OuterSearchDiv" >
			Bağımsız Birim Adı: <br>
			<input type="text" name="BagimsizBirimEkle_NameTextBox"
				id="BagimsizBirimEkle_NameTextBox">
			</input>
			<input type="button"
				name="BagimsizBirimEkle_AratButton"
				id="BagimsizBirimEkle_AratButton" value="ARAT">
			</input>
		</div>
		<div style="float: left; width: 100%; display:none; padding-top:10px;" id="BagimliBirimEkle_OuterSearchDiv" >
			Bağımlı Birim Sektörü:<br>
			<select id="BagimliBirimEkle_SektorSelect">
			<option selected="selected" value="0" >Seçiniz</option>
			<?php 
			echo $bagimliBirimlerOlanSektorlerText;
			?>
			</select>
			
			<br>Seviyesi:<br>
			<select disabled id="BagimliBirimEkle_SeviyeSelect">
			<option selected="selected" value="0" >Seçiniz</option>
			<?php 
			echo $seviyelerText;
			?>
			</select>
			
			<br>Bağlı olduğu yeterlilik<br>
			<select disabled id="BagimliBirimEkle_YeterlilikSelect">
				<option value="0">Lütfen Sektör ve Seviye Seçiniz</option>
			</select>
			
			<input type="button"
				name="BagimliBirimEkle_GetirButton"
				id="BagimliBirimEkle_GetirButton" value="GETİR">
		
		</div>
		
		<div style="float: left; width: 100%;">
			<div style="color: red;" id="BagimsizBirimEkle_ErrorDiv" name="BagimsizBirimEkle_ErrorDiv"></div>
		</div>
		<div style="float: left; width: 100%;">
			<table id="BagimsizBirimEkle_SearchGrid" name="BagimsizBirimEkle_SearchGrid" style="display:none; width: 100%; float:left;">
				<thead>
					<tr>
						<th>#</th>
						<th>Birim Kodu</th>
						<th>Birim Adı</th>
						<th>Birim Seviyesi</th>
						<th>Yeterlilik Adı</th>
						<th>Yeterlilik Seviyesi</th>
					</tr>
				</thead>
			</table>
		</div>

		
		<div style="float:left; width:100%">
		<input id="BagimsizBirimEkle_EkleButton" name="BagimsizBirimEkle_EkleButton" type="button" style="display:none;" value="EKLE"></input>
		</div>


	</div>
	
	<div style="width:100%; float:left;">
		<div style="width: 100%; float: left;"  id="EklenmisBirimlerGrid_div" name="EklenmisBirimlerGrid_div">
	
<?php 

	echo  '<input type="hidden" id="yeterlilikKoduHiddenField" value="'.$yeterlilikBilgi["YETERLILIK_KODU"].'"></input>';
	echo  '<input type="hidden" id="yeterlilikSeviyesiHiddenField" value="'.$yeterlilikBilgi["SEVIYE_ID"].'"></input>';
	echo  '<input type="hidden" id="zorunluBirimlerCountHiddenField" value="0"></input>';
	echo  '<input type="hidden" id="secmeliBirimlerCountHiddenField" value="0"></input>';
	echo  '<input type="hidden" id="belirsizBirimlerCountHiddenField" value="0"></input>';
	
	echo  '<input type="hidden" id="ogrenmeCiktisiCounterHiddenField" value="1"></input>';
	
	
	
?>
		

	<table id="EklenmisBirimlerGrid" style="width: 100%;">
		<thead class="tablo_header">
		<tr>
		<th>#</th>
		<th>Birim Kodu</th>
		<th>Birim Adı</th>
		<th>Birim Seviyesi</th>
		<th>Yeterlilik Adı</th>
		<th>Yeterlilik Seviyesi</th>
		<th>Seçmeli/Zorunlu</th>
		<th>Güncelle</th>
		<th>Sil</th>
		<th>Sıra No</th>
		<th style="width:25px;">Taşı</th>
		</tr>
		</thead>
		
		<tbody class="jqueryUIsortable">
	<?php 	
	
	$zorunluCounter = 0; 
	$secmeliCounter=0;
	$belirsizCounter = 0;
	
	for ($i=0; $i< count($eklenmisBirim); $i++) {
		$arr = $eklenmisBirim[$i];
		
		($i%2 == 1) ? $class="even" : $class = "odd";
		
		
		$onayTarihi = ($arr["BIRIM_ONAY_TAR"].length > 0) ? date('d.m.Y', strtotime($arr["BIRIM_ONAY_TAR"]))  : "";
		$yayinTarihi = ($arr["BIRIM_YAYIN_TAR"].length > 0)? date('d.m.Y', strtotime($arr["BIRIM_YAYIN_TAR"])) : "";
		
		$bagimsizMiText = ($arr["BAGIMSIZMI"]=="1") ? "Bağımsız" : "-";
		
		
		
		if($_REQUEST["yeterlilik_id"] == $arr["BAGIMLI_OLDUGU_YET_ID2"])//KENDI BIRIMIYSE
		{
			$class .= " kendiBirimi ";
			
			$guncelleButtonText = "<a class='editBirim'>".JText::_("EDIT_TEXT")."</a>";
			
			//$bagimliOlduguYeterliliginAdi = "";
			//$bagimliOlduguYeterliliginSeviyesi = "";
			$bagimliOlduguYeterliliginAdi = $arr["BAGIMLI_OLDUGU_YETERLILIK_ADI"];
			$bagimliOlduguYeterliliginSeviyesi = $arr["BAGIMLI_OLDUGU_YET_SEVIYE_ID"];
				
			$yeterlilikSeviyesiSelectText = "<select style='width:110px;' class='birimSeviyesiSelect' name='birimSeviyesi-".$arr["BIRIM_ID"]."' >";
			for($seviyeCounter=0; $seviyeCounter<count($seviyeler); $seviyeCounter++ )
			{
				if($arr["BIRIM_SEVIYE"] == $seviyeler[$seviyeCounter]["SEVIYE_ID"] )
					$selected = " selected ";
				else
					$selected = "";
				
				$yeterlilikSeviyesiSelectText .= "<option ".$selected." value='".$seviyeler[$seviyeCounter]["SEVIYE_ID"]."'>".$seviyeler[$seviyeCounter]["SEVIYE_ADI"]."</option>";
			}
			$yeterlilikSeviyesiSelectText.="</select>";
			
			$birimSeviyesi = $arr['BIRIM_SEVIYE'];
			
			if($arr["ZORUNLU"] == "0")
			{
				
				$secmeliCounter++;
				$siraKodu = $secmeliCounter;
				$zorunlulukKodu = 'B';
				
			}
			else if($arr["ZORUNLU"] == "1")
			{
				$zorunluCounter++;
				$siraKodu = $zorunluCounter;
				$zorunlulukKodu = 'A';
				
			}
			else 
			{
				$belirsizCounter++;
				$siraKodu = $belirsizCounter;
				$zorunlulukKodu = ' ';
				
			}
			
			
			$birimKoduText = $yeterlilikBilgi["YETERLILIK_KODU"].'-'.$birimSeviyesi.'/'.$zorunlulukKodu.$siraKodu;
			
			
		}
		else
		{
			$guncelleButtonText = "";
			$bagimliOlduguYeterliliginAdi = $arr["BAGIMLI_OLDUGU_YETERLILIK_ADI"];
			$bagimliOlduguYeterliliginSeviyesi = $arr["BAGIMLI_OLDUGU_YET_SEVIYE_ID"];
			$yeterlilikSeviyesiSelectText = $arr["BIRIM_SEVIYE"];
			//$birimKoduText = $arr["BIRIM_KODU"]; //AŞAĞI ALDIM
			
		}
		$birimKoduText = $arr["BIRIM_KODU"];
			
		($arr["ZORUNLU"]=="1") ? $zorunluOptSelected = " SELECTED " :  $zorunluOptSelected = " ";
		($arr["ZORUNLU"]=="0") ? $secmeliOptSelected = " SELECTED " :  $secmeliOptSelected = " ";
		($arr["ZORUNLU"]=="-1") ? $belirsizOptSelected = " SELECTED " :  $belirsizOptSelected = " ";
		
		$yeterlilikZorunlulukSelectText = "<select style='width:110px;' class='zorunluSecmeliSelect' name='zorunluSecmeliSelect-".$arr["BIRIM_ID"]."' >";
		$yeterlilikZorunlulukSelectText .= '<option '.$zorunluOptSelected.' value="1">Zorunlu</option>';
		$yeterlilikZorunlulukSelectText .= '<option '.$secmeliOptSelected.' value="0">Seçmeli</option>';
		$yeterlilikZorunlulukSelectText .= '<option '.$belirsizOptSelected.' value="-1">-</option>';
		$yeterlilikZorunlulukSelectText .="</select>";
		
		
		$roww = "<tr id='".$arr['BIRIM_ID']."' class='".$class."'>";
		
		$roww .= '<td>'.$arr["BIRIM_ID"].'</td>';
		
		$roww .= '<td style="width:120px;">'.$birimKoduText.'</td>';
		
		
		$roww .= '<td>'.$arr["BIRIM_ADI"].'</td>';
		$roww .= '<td>'.$yeterlilikSeviyesiSelectText .'</td>';
		$roww .= '<td>';
		$roww .= ($arr["BAGIMLI_OLDUGU_YETERLILIK_ADI"]!="") ? $bagimliOlduguYeterliliginAdi : $bagimsizMiText;
		$roww .= "</td>";

		$roww .= "<td>";
		$roww .= ($arr["BAGIMLI_OLDUGU_YET_SEVIYE_ID"]!="") ? $bagimliOlduguYeterliliginSeviyesi : $bagimsizMiText;
		$roww .= "</td>";//$roww .= "<td>".$arr["ZORUNLU"]."</td>";
		
		$roww .= "<td>".$yeterlilikZorunlulukSelectText."</td>";
		
		
		$roww .= "<td>";
		$roww .= $guncelleButtonText;
		$roww .= "</td>";
		
		$roww .= "<td><a class='deleteBirim' href=''>".JText::_("DELETE_TEXT")."</a></td>";
		
		$roww .= '<td>'.($i+1).'</td>';
		$roww .= '<td><input type="text" class="sirayaTasiTextbox" style="width:50px;" ></td>';
		
		
		$roww .= "</tr>";
		echo $roww;

	}
	?>
	</tbody>
	</table>
		</div>
	</div>
	

	
	
	
	<div class="yeniBirimEklePopupDiv" id="yeniBirimEklePopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:325px; height:130px; display:none; background-color: white;">
			
			<div style="width:50%; float:left;">Adı:</div>
			<div style="width:49%; float:right; vertical-align: middle;"><input class="required" style="float:right; width:145px;" id="yeniBirimEklePopup_BirimAdiTextBox" name="yeniBirimEklePopup_BirimAdiTextBox" type="text"></input>
			</div>
			
			<div style="display:none; width:50%; float:left;">Birim Kodu(Referans Kodu):</div>
			<div style="display:none; width:49%; float:right; vertical-align: middle;"><input style="float:right; width:145px;" id="yeniBirimEklePopup_ReferansKoduTextBox" name="yeniBirimEklePopup_ReferansKoduTextBox" type="text"></input>
			</div>
			
			<div style="width:50%; float:left;">Seviye:</div>
			<div style="width:49%; float:right; vertical-align: middle;"><select style="float:right; width:147px;" id="yeniBirimEklePopup_SeviyeTextBox" name="yeniBirimEklePopup_SeviyeTextBox"> <?php  echo $seviyelerText; ?></select>
			</div>
			
			<div style="display:none; width:50%; float:left;">Yayın Tarihi:</div>
			<div style="display:none; width:49%; float:right; vertical-align: middle;"><input style="float:right; width:145px;" id="yeniBirimEklePopup_YayınTarihiTextBox" name="yeniBirimEklePopup_YayınTarihiTextBox" type="text" class="datepicker" maxLength="10"></input>
			</div>
			
			<div style="display:none; width:50%; float:left;">Revizyon No:</div>
			<div style="display:none; width:49%; float:right; vertical-align: middle;"><input style="float:right; width:145px;" id="yeniBirimEklePopup_RevizyonNoTextBox" name="yeniBirimEklePopup_RevizyonNoTextBox" type="text"></input>
			</div>
			
			<div style="width:50%; float:left;">Zorunlu/Seçmeli:</div>
			<div style="width:49%; float:right; vertical-align: middle;">
			<select id="yeniBirimEklePopup_ZorunluSelect" name="yeniBirimEklePopup_ZorunluSelect" style="float:right; width:147px;">
				<option SELECTED value="-1">-</option>
				<option value="1">Zorunlu</option>
				<option value="0">Seçmeli</option>
			</select>
			</div>
			
			<div style="width:30%; float:left; padding-left:35%; padding-top:10px;">
				<input type="button" value="EKLE" name="yeniBirimEklePopup_EkleButton" id="yeniBirimEklePopup_EkleButton" />
				<input type="button" value="İPTAL" id="yeniBirimEklePopup_EkleButtonIptal" />
			</div>
			
		</div>
	<br>
	<div style="float:left; width:100%;" class="biriminDetaylariPopupDiv" id="biriminDetaylariPopupDiv"> 
	<?php  
	$user = & JFactory::getUser();
	$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
	
		for($i=0; $i<count($eklenmisBirim); $i++)//HER BIRIM ICIN
		{
			if($eklenmisBirim[$i]["YETERLILIK_ID"] == $eklenmisBirim[$i]["BAGIMLI_OLDUGU_YET_ID2"])
			{
				$totalBaglamCount = 0;
				$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
				$birimAdi = $eklenmisBirim[$i]["BIRIM_ADI"];
				$popupVisibility = "display:none";
				$popupStyle = ' style="'.$popupVisibility.'; border: 1px solid #00A7DE; padding: 10px; width:950px; background-color: white; " ';

				
				if(!$isSektorSorumlusu) 
				{
					$birimKoduInputText = $eklenmisBirim[$i]["BIRIM_KODU"];
					$birimSeviyesiInputText = $eklenmisBirim[$i]["BIRIM_SEVIYE"];
					$birimKredisiInputText = $eklenmisBirim[$i]["BIRIM_KREDI"];
					$birimYayinTarihiInputText = $eklenmisBirim[$i]["BIRIM_YAYIN_TAR"];
					$birimRevizyonNoInputText = $eklenmisBirim[$i]["BIRIM_REV_NO"];
					$birimRevizyonTarihiInputText= $eklenmisBirim[$i]["BIRIM_REV_TAR"];
					$birimMYKYonetimKuruluOnayTarihiInputText = $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_TAR"];
					$birimMYKYonetimKuruluOnaySayisiInputText = $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_SAYI"];
				}
				else
				{
					$birimKoduInputText = '<input style="width:500px;" name="birimDetayiPopup-BirimKodu-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_KODU"].'" />';
					$birimSeviyesiInputText = '<input style="width:500px;" class="numberInput" name="birimDetayiPopup-BirimSeviyesi-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_SEVIYE"].'" />';
					$birimKredisiInputText = '<input style="width:500px;" name="birimDetayiPopup-BirimKredisi-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_KREDI"].'" />';
					$birimYayinTarihiInputText = '<input style="width:500px;" class="datepicker" name="birimDetayiPopup-BirimYayinTarihi-'.$birimID.'" type="text" value="'.str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_YAYIN_TAR"]).'" />';
					$birimRevizyonNoInputText = '<input style="width:500px;" class="numberInput" name="birimDetayiPopup-BirimRevizyonNo-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_REV_NO"].'" />';
					$birimRevizyonTarihiInputText= '<input style="width:500px;" class="datepicker" name="birimDetayiPopup-BirimTarihi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_REV_TAR"]) .'" />';
					$birimMYKYonetimKuruluOnayTarihiInputText= '<input style="width:100px; float:left;" class="datepicker" name="birimDetayiPopup-MYKYKOnayTarihi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_TAR"]) .'" />';
					$birimMYKYonetimKuruluOnaySayisiInputText= '<input style="width:100px; float:left;" name="birimDetayiPopup-MYKYKOnaySayi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_SAYI"]) .'" />';
					
				}
				
				
				echo '<input type="hidden" name="gorevlerinIDleri[]" value="'.$birimID.'"></input>';
				
				echo '<div id="biriminDetaylariPopupDiv-'.$birimID.'" '.$popupStyle.'>';
				echo '<div style="height:500px; overflow:auto;">';
					
				echo '<strong>'.$eklenmisBirim[$i]["BIRIM_ADI"].' Yeterlilik Birimi </strong><br>';
				echo '<table id="birimDetayiIlkTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
				<tr>
				<td class="blueBackgrounded" style="width:30px">1</td>
				<td class="blueBackgrounded">YETERLİLİK BİRİMİ ADI</td>
				<td style="width:500px;">
					<input style="width:500px;" name="birimAdiTextbox" id="birimAdiTextbox-'.$birimID.'" value="'.$eklenmisBirim[$i]["BIRIM_ADI"].'" >
				</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">2</td>
				<td class="blueBackgrounded">REFERANS KODU</td>
				<td>'.$birimKoduInputText.'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">3</td>
				<td class="blueBackgrounded">SEVİYE</td>
				<td>'.$birimSeviyesiInputText.'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">4</td>
				<td class="blueBackgrounded">KREDİ DEĞERİ</td>
				<td>'.$birimKredisiInputText.'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" rowspan="3"  style="width:30px">5</td>
				<td class="blueBackgrounded">A)YAYIN TARİHİ</td>
				<td>'.$birimYayinTarihiInputText.'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded">B)REVİZYON NO</td>
				<td>'.$birimRevizyonNoInputText.'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded">C)REVİZYON TARİHİ</td>
				<td>'.$birimRevizyonTarihiInputText.'</td>
				</tr>
					
				</tbody></table>';
					
				echo '<table  id="birimDetayiIkinciTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
				<tr>
				<td class="blueBackgrounded" style="width:30px">6</td>
				<td class="blueBackgrounded">YETERLİLİK BİRİMİNE KAYNAK TEŞKİL EDEN MESLEK STANDARDI</td>
				</tr>
				<tr><td class="" colspan="2">';
				//Teşkil Eden Standartlar Burada
				$yeterlilikKaynaklari = $this->yeterliligeKaynakTeskilEdenler;
				
				$biriminKaynaklariViewID = 'biriminKaynaklari-'.$birimID;
				$biriminKaynaklari = $this->$biriminKaynaklariViewID;
				
				foreach($yeterlilikKaynaklari as $kaynak)
				{
					if($biriminKaynaklari!=null && in_array($kaynak['STANDART_ID'], $biriminKaynaklari))
						$checked = ' checked ';
					else
						$checked = '';
						
					echo '<input style="margin-right:10px;" '.$checked.' type="checkbox" value="'.$kaynak['STANDART_ID'].'" name="birimeYeterlilikKaynagindanKaynak['.$birimID.'][]" id="birimeYeterlilikKaynagindanKaynak-'.$birimID.'-'.$kaynak['STANDART_ID'].'">'.$kaynak['STANDART_ADI'].'(Seviye'.$kaynak['SEVIYE_ID'].')<br>';
				}
				//Teşkil Eden Standartlar Biter
					
				echo '</td></tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">7</td>
				<td class="blueBackgrounded">ÖĞRENME ÇIKTILARI</td>
				</tr>
				<tr><td class="" colspan="2">';
					
				//echo $birimlerleDetaylari[$i]["YETERLILIK_ID"]." - ".$birimlerleDetaylari[$i]["BIRIM_ID"]." - ".$birimlerleDetaylari[$i]["ZORUNLU"]." - ".$birimlerleDetaylari[$i]["OGRENME_CIKTISI_ID"]." - ";
				$ogrenmeCiktisiViewID = 'biriminOgrenmeCiktilari-'.$birimID;
				$buBiriminOgrenmeCiktilari = $this->$ogrenmeCiktisiViewID;
					
				// SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE
				echo '<table id="biriminDetaylariTablosu-'.$birimID.'" class="tableGib" border="0">
				<thead class="gibHeader">
				<tr>
				<td colspan="2">Öğrenme Çıktısı</td>
				<td colspan="2">Başarım Ölçütleri</td>
				</tr>
				</thead>';
					
				
					
				$buBiriminBaglamlariViewID = 'biriminBaglamlari-'.$birimID;
				$buBiriminBaglamlari = $this->$buBiriminBaglamlariViewID;
				$birimBaglamiText = "";
				for($j=0; $j<count($buBiriminBaglamlari); $j++)
				{				
					if($j!=0)
						$birimBaglamiText .= '
';
						$birimBaglamiText .= $buBiriminBaglamlari[$j]["BAGLAM_ACIKLAMA"];
				}
					
				echo '<tr style="text-align:center; display:none;" class="tablo_header_acik ogrenmeCiktisiRow">
				<td colspan="4">Birim Bağlamları:<br>
				<textarea name="birimBaglamlari-'.$birimID.'" id="birimBaglamlari-'.$birimID.'">'.$birimBaglamiText.'</textarea>
				<br>&nbsp;</td>
				</tr>';
				
				
				echo '</table>';
					echo '<input type="button" id="ogrenmeCiktisiEkleButton-'.$birimID.'" class="ogrenmeCiktisiEkleButton" value="Öğrenme Çıktısı Ekle" />
					<input style="display:none;" type="button" onclick="jQuery(\'.gsira\').css(\'display\',\'block\')" value="Yeniden Sırala" />';
					// BITTI SULEYMAN ABININ TABLE--------------------------------------------------------------
					//ÖĞRENME ÇIKTILARI Biter

					
					echo '</td></tr>';
					
					echo '<tr>
					<td class="blueBackgrounded" style="width:30px">8</td>
					<td class="blueBackgrounded">ÖLÇME VE DEĞERLENDİRME</td>
					</tr>
					<tr id="teorikSinavlarRow-0"  class="teorikSinavlarRow"><td class="blueBackgrounded" class="" colspan="2">8 a) Teorik Sınav <input type="button" value="EKLE" id="teorikSinavEkleButton-'.$birimID.'" class="teorikSinavEkleButton sinavEkleButton" ></input></td></tr>';
					
					
					
					echo '<tr id="performansSinavlariRow-0" class="performansSinavlariRow"><td class="blueBackgrounded" class="" colspan="2">8 b) Performansa Dayalı Sınav <input type="button" value="EKLE" id="performansSinaviEkleButton-'.$birimID.'" class="performansSinaviEkleButton sinavEkleButton" ></input></td></tr>';
						
										
					echo '<tr id="digerSinavlarRow-0" class="digerSinavlarRow"><td class="blueBackgrounded" class="" colspan="2">8 c) Ölçme ve Değerlendirmeye İlişkin Diğer Koşullar <input type="button" value="EKLE" id="digerSinavEkleButton-'.$birimID.'" class="digerSinavEkleButton sinavEkleButton" ></input></td></tr>';
					//türler tr
					echo '<tr id="altTurlerrow-0" class="altTurlerRow">
							<td class="blueBackgrounded" class="" colspan="2">8 d) Ölçme ve Değerlendirmeye İlişkin Tür Koşulları 
							<input type="button" value="Tür Alternatifi Ekle" id="SinavTurEkleButton-'.$birimID.'" class="SinavTurEkleButton" /></td></tr>';
					//türler tr
					
					foreach($kayitliBirimTur[$birimID] as $till){
						$turler = '';
						foreach($till as $fill){
							$turler .= $fill['BIRIM_TUR'].$fill['BIRIM_NUMARA'].',';
						}
						$turEkle ='<tr><td><input type="button" value="SİL" class="KayitliTurSilButton" id="KayitliTurSilButton-'.$fill['ALTERNATIF_TUR_ID'].'"></td><td>';
						$turEkle .= $turler;
						$turEkle .='</td></tr>';
						
						echo $turEkle;
					}
					
					//kayıtlı türler
// 					foreach($kayitliBirimTur[$birimID]['T'] as $till){
// 						$turler = '';
// 						foreach ($till as $fill){
// 							$turler .= $fill['BIRIM_TUR'].$fill['BIRIM_NUMARA'].',';
// 						}
// 						$turEkle ='<tr><td><input type="button" value="SİL" class="KayitliTurSilButton" id="KayitliTurSilButton-'.$fill['ALTERNATIF_TUR_ID'].'"></td><td>';
// 						$turEkle .= $turler;
// 						$turEkle .='</td></tr>';
						
// 						echo $turEkle;
// 					}
					
// 					foreach($kayitliBirimTur[$birimID]['P'] as $till){
// 						$turler = '';
// 						foreach ($till as $fill){
// 							$turler .= $fill['BIRIM_TUR'].$fill['BIRIM_NUMARA'].',';
// 						}
// 						$turEkle ='<tr><td><input type="button" value="SİL" class="KayitliTurSilButton" id="KayitliTurSilButton-'.$fill['ALTERNATIF_TUR_ID'].'"></td><td>';
// 						$turEkle .= $turler;
// 						$turEkle .='</td></tr>';
						
// 						echo $turEkle;
// 					}
					//kayıtlı türler son
					
					echo '<tr class="birimGelistirenKuruluslarRow" id="birimGelistirenKuruluslarRow-0"><td class="blueBackgrounded" style="width:30px">9</td><td class="blueBackgrounded">YETERLİLİK BİRİMİNİ GELİŞTİREN KURUM/KURULUŞ(LAR) <input type="button" value="EKLE" id="birimGelistirenKurulusEkleButton-'.$birimID.'" class="birimGelistirenKurulusEkleButton" ></input>  <input type="button" value="Yeterliliği Geliştiren Kuruluslardan Ekle" id="yeterlilikGelistirenKuruluslardanEkleButton-'.$birimID.'" class="yeterlilikGelistirenKuruluslardanEkleButton" ></input></td></tr>';
					
					$yeterliligiGelistirenKuruluslar = $this->gelistiren_kurulus;
					for($j=0; $j<count($yeterliligiGelistirenKuruluslar); $j++)
					echo '<tr class="yeterliligiGelistirenKuruluslardan darkGrayBackgrounded " style="display:none;" >
						<td colspan="2"><input class="yeterliligiGelistirenKuruluslarCheckbox" name="yeterliligiGelistirenKuruluslarCheckbox-'.$birimID.'" type="checkbox" value="'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'" >'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'</input></td>
					</tr>';
					
					
					$buBirimiGelistirenKuruluslarViewID = 'birimiGelistirenKuruluslar-'.$birimID;
					$buBirimiGelistirenKuruluslar = $this->$buBirimiGelistirenKuruluslarViewID;
					for($j=0; $j<count($buBirimiGelistirenKuruluslar); $j++)
					{
						if($buBirimiGelistirenKuruluslar[$j]["YETERLILIKTEN_ALINTI"]=="1")
						{	
							$yeterliliktenEklendi = "yeterliliktenEklendi";
							$readOnly = ' readOnly="readOnly" ';
							
						}
						else 
						{	
							$yeterliliktenEklendi = "";
							$readOnly = ' ';
						}
					
						echo '<tr id="birimGelistirenKuruluslarRow-'.($j+1).'" class="birimGelistirenKuruluslarRow">
						<td style="width:30px" class="blueBackgrounded">
							<input type="button" class="birimGelistirenKuruluslardanSilButton '.$yeterliliktenEklendi.'" id="birimGelistirenKuruluslardanSilButton-'.($j+1).'" value="SİL">
						</td>
						<td>
							<input type="text" value="'.$buBirimiGelistirenKuruluslar[$j]["KURULUS_ADI"].'" name="birimGelistirenKuruluslar-'.$birimID.'['.($j+1).']" style="width:80%;" class="birimGelistirenKuruluslar" '.$readOnly.'>
						</td>
						</tr>';
					}
					
					echo '<tr class="birimDogrulayanSektorKomitesiRow" id="birimDogrulayanSektorKomitesiRow-0">
					<td class="blueBackgrounded" style="width:30px">
						10
					</td>
					<td class="blueBackgrounded">
					YETERLİLİK BİRİMİNİ DOĞRULAYAN SEKTÖR KOMİTESİ : &nbsp;
					<input style="display:none;" type="button" value="EKLE" id="birimDogrulayanSektorKomitesiEkleButton-'.$birimID.'" class="birimDogrulayanSektorKomitesiEkleButton" ></input>
					<font style="font-weight:normal;">MYK '.FormFactory::toUpperCase($this->yeterliliginSektoru[0]["SEKTOR_ADI"]).' SEKTÖR KOMİTESİ</font>
					</td>
					</tr>';
					
					
					$buBirimiDogrulayanKomiteUyeleriViewID = 'birimiDogrulayanKomiteUyeleri-'.$birimID;
					$buBirimiDogrulayanKomiteUyeleri = $this->$buBirimiDogrulayanKomiteUyeleriViewID;
						
					for($j=0; $j<count($buBirimiDogrulayanKomiteUyeleri); $j++)
						echo '<tr>
							<td style="width:30px" class="blueBackgrounded">
								<input type="button" value="SİL" class="birimDogrulayanSektorKomitesiSilButton">
							</td>
							<td>
								<input type="text" style="width:80%;" name="birimDogrulayanSektorKomitesi-'.$birimID.'[]" value="'.$buBirimiDogrulayanKomiteUyeleri[$j]['KOMITE_UYESI_ADI'].'">
							</td>
						</tr>';
					
					
					
					
					echo '<tr class="" id="">
						<td colspan="2" class="blueBackgrounded">
							EKLER 
						</td>
					</tr>';
					
					echo '<tr class="" id="">
						<td class="blueBackgrounded" style="width:30px">EK1</td>
						<td class="blueBackgrounded">Yeterlilik Biriminin Kazandırılması için Tavsiye Edilen Eğitime İlişkin Bilgiler
						</td>
					</tr>';

					//////// EK 1  //////////////////
					echo '<tr>
						<td colspan="2" style="padding-left:20px; ">
						<div style="width: 100%; float: left"><textarea class="ciftTirnaksiz"  style="width: 400px; float: left" id="EK1_EgitimIcerigiAciklamasi-'.$birimID.' " name="EK1_EgitimIcerigiAciklamasi-'.$birimID.'">'.$eklenmisBirim[$i]["BIRIM_EK1_ACIKLAMASI"].'</textarea></div>
						<br/><input id="ek1TekSatirEkleButton-'.$birimID.'" class="ek1TekSatirEkleButton" type="button" style="float:left;" value="Tek Satır Ekle" />
						<input type="button" style="float:left;"  value="Toplu Ekleme Yap" onclick="jQuery(\'#birimEk1TopluEklemeDiv-'.$birimID.'\').toggle(\'slow\')" />
						
						<div style="float:left; width:100%; display:none;" id="birimEk1TopluEklemeDiv-'.$birimID.'">
							<textarea id="birimEk1TopluEklemeTextArea-'.$birimID.'" class="ciftTirnaksiz" style="float:left; width:850px; height:150px; "></textarea>
							<input type="button" class="birimEk1TopluEklemeTumunuEkleButton" id="birimEk1TopluEklemeTumunuEkleButton-'.$birimID.'" value="Tümünü Ekle" style="float:left;" />
						</div>
						
						
					';
					
					echo '
					<table id="birimEk1Tablosu-'.$birimID.'" style="width:100%;">
					<thead><tr><th class="blueBackgrounded" style=" width:30px;">Sil</th><th class="blueBackgrounded">Eğitim İçeriği</th></tr></thead>
					<tbody>';
					$buBiriminEk1YazilariViewID = 'buBiriminEk1Yazilari-'.$birimID;
					$buBiriminEk1Yazilari = $this->$buBiriminEk1YazilariViewID;
					for($j=0; $j<count($buBiriminEk1Yazilari); $j++)
						echo '<tr id="ek1Row-'.$birimID.'-'.$j.'" class="ek1Yazisi">
								<td><input type="button" onClick="jQuery(jQuery(this).parent()[0].getParent()).remove();" value="Sil" /></td>
								<td><input style="width:99%;" name="biriminEk1leri-'.$birimID.'[]" value="'.$buBiriminEk1Yazilari[$j]["EK1_YAZISI"].'" /></td>
						</tr>';
					
					echo '</tbody>
					</table>
					
					</td></tr>
					
					';
					
							
					////    EK1 BITER    //////////////////////
					
					echo '<tr class="" id="">
					<td class="blueBackgrounded" style="width:30px">EK2</td>
					<td class="blueBackgrounded">Yeterlilik Biriminde Belirtilen Değerlendirme Araçları İle Ölçülen Başarım Ölçütlerine İlişkin Tablo
					';
					
					
					if($eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]== 1)
					{
						$kontrolListesizCheckValue = '';
						$kontrolListeliCheckValue = ' checked="checked" ';
						$kontrolListesizEk2HideShow = ' ';
						$kontrolListeliEk2HideShow = '';
						
//						echo '<script>biriminEk2FormatiniBelirle('.$birimID.', "Y" );</script>';
						
					}
					else
					{
						$kontrolListesizCheckValue = ' checked="checked" ';
						$kontrolListeliCheckValue = '';
						$kontrolListesizEk2HideShow = "";
						$kontrolListeliEk2HideShow = ' display:none ';

	//					echo '<script>biriminEk2FormatiniBelirle('.$birimID.', "E" ); </script>';
					}
					
						
					echo '<input style="float:right;" id="KontrolListesiRadioButtonKontrolListeli-'.$birimID.'" type="radio" '.$kontrolListeliCheckValue.' name="Ek2Formati-'.$birimID.'" class="ek2FormatiRadio" value="E" />
					<label style="float:right; margin-left:10px; margin-right:5px; font-weight:normal;" for="KontrolListesiRadioButtonKontrolListeli-'.$birimID.'">Kontrol Listeli</label>
					<input style="float:right;" id="KontrolListesiRadioButtonKontrolListesiz-'.$birimID.'" type="radio" '.$kontrolListesizCheckValue.' name="Ek2Formati-'.$birimID.'" class="ek2FormatiRadio"  value="Y" />
					<label style="float:right; margin-left:10px; margin-right:5px; font-weight:normal;" for="KontrolListesiRadioButtonKontrolListesiz-'.$birimID.'">Kontrol Listesiz</label>
					
					
					</td>
					</tr>';
					
					
					///////////////// Ek - 2 
					$basarimOlcusuKolonGenisligi = 40;
					
					echo '<tr class="">
					<td style="width:30px" colspan="2">
					<div id="kontrolListesizEk2-'.$birimID.'" style="'.$kontrolListesizEk2HideShow.'" >
					<table class="KontrolListesizEk2Tablolari" id="KontrolListesizEk2Tablolari-'.$birimID.'" style="width:100%; padding-bottom:25px;"><thead><tr><th class="blueBackgrounded" style="width:'.$basarimOlcusuKolonGenisligi.'%;">Yeterlilik Birimi Başarım Ölçütü</th><th class="blueBackgrounded" style="width:'.(100-$basarimOlcusuKolonGenisligi).' %;">Değerlendirme Aracı</th></tr></thead><tbody>';
					echo '</tbody></table></div>';
					
					echo '<div id="kontrolListeliEk2-'.$birimID.'" style="width:100%; float:left;" >';
					for($indx = 0 ; $indx < count($birimEk2Turleri); $indx++)
					{
						$row = $birimEk2Turleri[$indx];
						if($row['ID']==1)
							$ekleButtonName = 'BasarimOlcutuYetkinlikEkleButton';
						else 
							$ekleButtonName='BasarimOlcutuAnlayisEkleButton';
						
						echo '<div style="'.$kontrolListeliEk2HideShow.'; float:left; width:100%;" id="kontrolListeliEk2Div'.$row['ID'].'-'.$birimID.'"  >
						<table class="KontrolListeliEk2Tablosu'.$row['ID'].'" id="KontrolListeliEk2Tablosu'.$row['ID'].'-'.$birimID.'" style="width:100%;">
							<thead>
								<tr>
									<th class="blueBackgrounded" style="width:10%;">
										<input type="button" value="EKLE" style="float:left;" id="'.$ekleButtonName.'-'.$birimID.'" class="'.$ekleButtonName.'" /> 
										NO
									</th>
									<th class="blueBackgrounded" style="width:25%;">
											'.$row['ACIKLAMA'].'
									</th>
									<th class="blueBackgrounded" style="width:15%;">
										UMS İlgili Bölüm
									</th>
									<th class="blueBackgrounded" style="width:25%;">
										Yeterlilik Birimi Başarım Ölçütü
									</th>
									
									<th class="blueBackgrounded" style="width:25%;">
										Değerlendirme Aracı
									</th>
								</tr>
							</thead>
							
						<tbody></tbody></table>
						</div>';
							
					}
					echo '</div>';
					/*
					echo '<div style="'.$kontrolListeliEk2HideShow.'; float:left; width:100%;" id="kontrolListeliEk2Div1-'.$birimID.'"  >
					<table class="KontrolListeliEk2Tablosu1" id="KontrolListeliEk2Tablosu1-'.$birimID.'" style="width:100%;">
					<thead>
					<tr>
					<th class="blueBackgrounded" style="width:'.$basarimOlcusuKolonGenisligi.'%;">
					<input type="button" value="EKLE" style="float:left;" id="BasarimOlcutuYetkinlikEkleButton-'.$birimID.'" class="BasarimOlcutuYetkinlikEkleButton" /> Başarım Ölçütü
					</th>
					<th class="blueBackgrounded" style="width:'.(100-$basarimOlcusuKolonGenisligi).' %;">
					Bilgi ve Anlayış
					</th>
					</tr>
					</thead>
						
					<tbody></tbody></table>
					</div>';
						
					echo '<div style="'.$kontrolListeliEk2HideShow.'; float:left; width:100%;"  id="kontrolListeliEk2Div2-'.$birimID.'"  >
					<table class="KontrolListeliEk2Tablosu2" id="KontrolListeliEk2Tablosu2-'.$birimID.'" style="width:100%;">
					<thead>
						<tr>
							<th class="blueBackgrounded" style="width:'.$basarimOlcusuKolonGenisligi.'%;">
							<input type="button" value="EKLE" style="float:left;" id="BasarimOlcutuAnlayisEkleButton-'.$birimID.'" class="BasarimOlcutuAnlayisEkleButton" />	
							Başarım Ölçütü
							</th>
							<th class="blueBackgrounded" style="width:'.(100-$basarimOlcusuKolonGenisligi).' %;">
								Beceri
							</th>
						</tr>
					</thead>
					
					<tbody></tbody></table>
					</div>';
					*/
					
			echo 	'</td>
					</tr>';
					//////////////////// EK 2 BITER
					
					
					echo '</tbody></table>';
						
					echo '<table border="1" style="width:100%;" cellspacing="1"><tbody>';
					echo '<tr style="width:100%; float:left;">
					<td class="blueBackgrounded" style="width:30px">11</td>
					<td class="blueBackgrounded" style="width:52%;">MYK Yönetim Kurulu Onay Tarihi ve Sayısı</td>
					<td style="padding-left:10px;">'.$birimMYKYonetimKuruluOnayTarihiInputText.'<div style="float:left; width:12px; text-align:center;"> - </div>'.$birimMYKYonetimKuruluOnaySayisiInputText.'</td>
					</tr>';
					echo '</tbody></table>';
					
					
					
					echo '</div>';
					
					if ($this->canEdit)
						echo '<input class="popupuKaydetButton" id="popupuKaydetButton-'.$birimID.'" value="KAYDET" type="button" >';
					
					echo '<input class="popupuIptalButton" id="popupuIptalButton-'.$birimID.'" value="İPTAL" type="button" style="margin-left:10px;">';
					echo '</div>';
					
					//// SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT
						
					echo "<script type='text/javascript'>";

					if("".$eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]== "1")
						echo ' biriminEk2FormatiniBelirle('.$birimID.', "Y" ); 
					';
					else
						echo ' biriminEk2FormatiniBelirle('.$birimID.', "E" ); 
					';
						
				
					for($j=0; $j<count($buBiriminOgrenmeCiktilari); $j++)
					{
						$ogrenmeCiktisiID = $buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_ID"];
						$buOgrenmeCiktisininBaglamlariViewID = 'ogrenmeCiktisininBaglamlari-'.$birimID."-".$ogrenmeCiktisiID;
						$buOgrenmeCiktisininBaglamlari = $this->$buOgrenmeCiktisininBaglamlariViewID;
						$buOgrenmeCiktisininBasarimOlcutuViewID = 'ogrenmeCiktisininBasarimOlcutleri-'.$birimID.'-'.$ogrenmeCiktisiID;
						$buOgrenmeCiktisininBasarimOlcutleri = $this->$buOgrenmeCiktisininBasarimOlcutuViewID;
						
						
						echo ' yeniOgrenmeCiktisiEkle2('.$birimID.', '.($j+1).', "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_YAZISI"]).'", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buOgrenmeCiktisininBaglamlari[0]["BAGLAM_ACIKLAMA"]).'" ); 
						';
						//
					
						
						for($k=0; $k<count($buOgrenmeCiktisininBasarimOlcutleri); $k++)
						{
							$basarimOlcutuID = $buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ID"];
								
							$buBasarimOlcutununBaglamlariViewID = 'basarimOlcutununBaglamlari-'.$birimID."-".$ogrenmeCiktisiID."-".$basarimOlcutuID;
							$buBasarimOlcutununBaglamlari = $this->$buBasarimOlcutununBaglamlariViewID;
								
							echo ' yeniBasarimOlcutuEkle2('.$birimID.', '.($j+1).', "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ADI"]).'", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBasarimOlcutununBaglamlari[0]["BAGLAM_ACIKLAMA"]).'",'.$basarimOlcutuID.'); 
							';
						}
					}
					
					
					$buBiriminTeorikSinavlariViewID = 'biriminTeorikSinavlari-'.$birimID;
					$buBiriminTeorikSinavlari = $this->$buBiriminTeorikSinavlariViewID;
						
					$buBiriminPerformansSinavlariViewID = 'biriminPerformansSinavlari-'.$birimID;
					$buBiriminPerformansSinavlari = $this->$buBiriminPerformansSinavlariViewID;
						
					
					$biriminEk2si_KontrolListeliTablo1ViewID = 'biriminEk2si_KontrolListeli-Tablo1-'.$birimID;
					$biriminEk2si_KontrolListeliTablo1 = $this->$biriminEk2si_KontrolListeliTablo1ViewID;
					
					$biriminEk2si_KontrolListeliTablo2ViewID = 'biriminEk2si_KontrolListeli-Tablo2-'.$birimID;
					$biriminEk2si_KontrolListeliTablo2 = $this->$biriminEk2si_KontrolListeliTablo2ViewID;
					
					for($j=0; $j<count($biriminEk2si_KontrolListeliTablo1); $j++)
					{
						$model=$this->getModel();
						$olcmeDegerlendirmeText='';
						for($k=0; $k<count($buBiriminTeorikSinavlari); $k++)
						{
							$olcmeDegerlendirmeText .= "<div style=\'width:30%; float:left;\'><input style=\'float:left;\' type=\'checkbox\' name=\'kontrolListeliOlcmeDegerlendirmesi[".$birimID."][".$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"]."][]\' id=\'kontrolListeliOlcmeDegerlendirmesi-".$birimID."-".$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"]."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."\' value=\'".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."\'>".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF'].$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."</div>";
						}
						for($k=0; $k<count($buBiriminPerformansSinavlari); $k++)
						{
							$olcmeDegerlendirmeText .= "<div style=\'width:30%; float:left;\'><input style=\'float:left;\' type=\'checkbox\' name=\'kontrolListeliOlcmeDegerlendirmesi[".$birimID."][".$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"]."][]\' id=\'kontrolListeliOlcmeDegerlendirmesi-".$birimID."-".$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"]."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."\' value=\'".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."\'>".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF'].$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."</div>";
						}
						//$olcmeDegerlendirmeText
						echo ' Ek2yeBasarimOlcutuYetkinlikEkle('.$birimID.', "'.$biriminEk2si_KontrolListeliTablo1[$j]["EK_YAZISI"].'", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($biriminEk2si_KontrolListeliTablo1[$j]["MESLEK_STANDARDI_BO_TEXT"]).'", "'.$olcmeDegerlendirmeText.'", "'.$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"].'", "'.$biriminEk2si_KontrolListeliTablo1[$j]["SIRA_NO"].'"); 
						';
						echo ' Ek2yeEnSonEklenenDropDownIndexiniDuzenle1('.$birimID.', '.$biriminEk2si_KontrolListeliTablo1[$j]["OGRENME_CIKTISI_INDEX"].', '.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_INDEX"].');
						';
					}
					
					for($j=0; $j<count($biriminEk2si_KontrolListeliTablo2); $j++)
					{
						$olcmeDegerlendirmeText='';
						for($k=0; $k<count($buBiriminTeorikSinavlari); $k++)
						{
							$olcmeDegerlendirmeText .= "<div style=\'width:30%; float:left;\'><input style=\'float:left;\' type=\'checkbox\' name=\'kontrolListeliOlcmeDegerlendirmesi[".$birimID."][".$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"]."][]\' id=\'kontrolListeliOlcmeDegerlendirmesi-".$birimID."-".$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"]."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."\' value=\'".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."\'>".$buBiriminTeorikSinavlari[$k]['OLC_DEG_HARF'].$buBiriminTeorikSinavlari[$k]['OLC_DEG_NUMARA']."</div>";
						}
						for($k=0; $k<count($buBiriminPerformansSinavlari); $k++)
						{
							$olcmeDegerlendirmeText .= "<div style=\'width:30%; float:left;\'><input style=\'float:left;\' type=\'checkbox\' name=\'kontrolListeliOlcmeDegerlendirmesi[".$birimID."][".$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"]."][]\' id=\'kontrolListeliOlcmeDegerlendirmesi-".$birimID."-".$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"]."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."\' value=\'".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF']."-".$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."\'>".$buBiriminPerformansSinavlari[$k]['OLC_DEG_HARF'].$buBiriminPerformansSinavlari[$k]['OLC_DEG_NUMARA']."</div>";
						}
						
						echo ' Ek2yeBasarimOlcutuAnlayisEkle('.$birimID.', "'.$biriminEk2si_KontrolListeliTablo2[$j]["EK_YAZISI"].'", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($biriminEk2si_KontrolListeliTablo2[$j]["MESLEK_STANDARDI_BO_TEXT"]).'", "'.$olcmeDegerlendirmeText.'", "'.$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"].'", "'.$biriminEk2si_KontrolListeliTablo2[$j]["SIRA_NO"].'"); 
						';
						echo ' Ek2yeEnSonEklenenDropDownIndexiniDuzenle2('.$birimID.', '.$biriminEk2si_KontrolListeliTablo2[$j]["OGRENME_CIKTISI_INDEX"].', '.$biriminEk2si_KontrolListeliTablo2[$j]["BASARIM_OLCUTU_INDEX"].');
						';
					}
					
					
					for($j=0; $j<count($buBiriminTeorikSinavlari); $j++)
					{
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "T", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminTeorikSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI"].'", "'.$buBiriminTeorikSinavlari[$j]["BASARI_KRITERI"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_DK"].'",  "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_DK"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI_MAX"].'", "",  "'.$buBiriminTeorikSinavlari[$j]["ID"].'",  "'.$buBiriminTeorikSinavlari[$j]["OLC_DEG_ADI"].'" ); ';
					}
								
					for($j=0; $j<count($buBiriminPerformansSinavlari); $j++)
					{
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "P", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminPerformansSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI"].'","","","","","", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI_ACIKLAMA"].'", "'.$buBiriminPerformansSinavlari[$j]["ID"].'", "'.$buBiriminPerformansSinavlari[$j]["OLC_DEG_ADI"].'"); ';
							
					}
						
					$buBiriminDigerSinavlariViewID = 'biriminDigerSinavlari-'.$birimID;
					$buBiriminDigerSinavlari = $this->$buBiriminDigerSinavlariViewID;
					for($j=0; $j<count($buBiriminDigerSinavlari); $j++)
					{
						echo 'birimDetaylarinaSinavEkle ('.$birimID.', "D", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminDigerSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "", "",  "", "", "", "","", "'.$buBiriminDigerSinavlari[$j]["ID"].'", ""); ';
						
					}
					
					$biriminEk2si_KontrolListesizViewID = 'biriminEk2si_KontrolListesiz-'.$birimID;
					$biriminEk2si_KontrolListesiz = $this->$biriminEk2si_KontrolListesizViewID;
					echo ' var checklenecekCheckboxlar = new Array(); '; 
					for($j=0; $j<count($biriminEk2si_KontrolListesiz); $j++)
					{
						echo ' checklenecekCheckboxlar['.$j.'] = "'.$biriminEk2si_KontrolListesiz[$j]["OGRENME_CIKTISI_INDEX"].'-'.$biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_INDEX"].'-'.$biriminEk2si_KontrolListesiz[$j]["SINAV_IDENTIFIER"].'-'.$biriminEk2si_KontrolListesiz[$j]["SINAV_INDEX"].'"; ';
					}
					echo ' ek2CheckboxlariniCheckle( '.$birimID.' , checklenecekCheckboxlar);  ';
					echo ' ek2KontrolListeliOlcmeDegerlendirmeleriniCheckle(); ';	
					
					
					
					
						
					
					echo "</script>";
						
					// SULEYMAN ABI JAVASCRIPT BITTI
			}
			
			
			
			
			
			
		} 
	?>
	</div>
	
</div>


<BR/>

<div style="width:20%; float:left; padding-bottom:20px;">
	<input value="Yeni" name="yeniButton" id="yeniButton" type="button"/>
</div>
<div style="width:79%; text-align:right; color:#006688; float:right; padding-bottom:20px;">
	Birim sırasını değiştirmek için gerekli alanlara sıra numarasını yazıp (Enter) tuşuna basınız
</div>

<div style="display:none; float:left; width:100%;">
	<input type="button" id="BirimDetaylariToggler" value="Birim Detaylarını Gör/Gizle"></input>
</div>

<div style="border: 1px solid #898989; float:left; width:100%; display:none; margin-bottom:20px;"  id="biriminAciklamalariBaglamlariDiv">
asd
</div>

<br><br>

<div id="dialog-confirm" style="display:none;" title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo JText::_("DELETE_CONFIRM_TEXT");?></p>
</div>
	
	
<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px; ">
		<div class="form_element cf_button">
			<input style="margin-top:25px;" value="Kaydet" name="kaydet" type="button" id="hepsiniKaydetButtonu" />
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('birimler', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>


   
    <script src="includes/js/smartspinner/smartspinner.js" type="text/javascript"></script>
   
    

</form>

<div id="TopluOlcut" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h2>Toplu Başarım Ölçütü Ekle</h2>
	<input type="hidden" id="ToppopupIdsi" />
	<input type="hidden" id="ToprowIdsi" />
	<textarea rows="14" cols="54" id="topluOlcutler" class="ciftTirnaksiz"></textarea>
	<button id="TopluEkle">Ekle</button>
	<button id="ipptal">İptal</button>
</div>

<script src="components/com_yeterlilik_taslak_yeni/js/birimler.js" ></script>


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

var currentRowCount = 0;
var yeniUretilmisBirimIDCounter = 0;//negatife gidecek


 var settings = {
		 		"bPaginate": false,
		 		"bFilter": false,
		 		"bInfo": false,
		 		"bSort": false,
			    "oLanguage": {
				"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
				"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
				"sInfo": "<?php echo JText::_("INFO");?>",
				"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
				"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
				"sSearch": "<?php echo JText::_("SEARCH");?>",
				"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
				
			}
		}
	};

								
var oTableBirim = jQuery('#EklenmisBirimlerGrid').dataTable(settings);
var oTableKontrolListesizler = jQuery('.KontrolListesizEk2Tablolari').dataTable(settings);

var seciliBirimRowID = 0;


jQuery('.datepicker').datepicker({ }).draggable();


jQuery('#BagimsizBirimEkle_SearchGrid').dataTable(settings);


jQuery('.sirayaTasiTextbox').live("enterKey",function(e){

	var kacinciSiraya = this.value;
	var rowElement = jQuery(this.getParent().getParent());
	var rowElementPosition = rowElement.index()+1;
	if( ! isNaN(this.value))
	{
		  var satirSayisi = jQuery('#EklenmisBirimlerGrid tbody tr').length;
		  
		  if(parseInt(kacinciSiraya)>satirSayisi || parseInt(kacinciSiraya)< 1 )
		  { 
			  var x = jQuery(this).val();//GEREKSIZ MAL
		  }
		  else
		  {
			  if(parseInt(kacinciSiraya)==satirSayisi)
			  {  
				  jQuery('#EklenmisBirimlerGrid tbody').append(rowElement); 
			  }
			  else
				{
					if(kacinciSiraya < rowElementPosition)
				 		jQuery(jQuery('#EklenmisBirimlerGrid tbody tr')[kacinciSiraya-1] ).before(rowElement);
					else if(kacinciSiraya > rowElementPosition)
						jQuery(jQuery('#EklenmisBirimlerGrid tbody tr')[kacinciSiraya-1] ).after(rowElement);
						 	
				}
		  }
		  
	}
	updateBirimKodlari(e);

	jQuery('.sirayaTasiTextbox').val("");

	
	
});
	
jQuery('.sirayaTasiTextbox').live("keyup", function(e){
	if(e.keyCode == 13)
	{
	  jQuery(this).trigger("enterKey");
	}
	else
		e.preventDefault();

	var satirSayisi = jQuery('#EklenmisBirimlerGrid tbody tr').length;
	for(var i=0; i<satirSayisi; i++)
		jQuery(jQuery('#EklenmisBirimlerGrid tbody tr')[i].getChildren()[9]).html((i+1));
});



jQuery('#yeniBirimEklePopup_YayınTarihiTextBox').datepicker({ });
/*
jQuery('.percentage').spinit({min:0,max:100,stepInc:1, height: 13 });
jQuery('.dakikaSpinEdit').spinit({min:0,stepInc:1, height: 13 });
jQuery('.saniyeSpinEdit').spinit({min:0,max:59,stepInc:1, height: 13});
jQuery('.numberInput').spinit({min:0,stepInc:1, height: 13});
*/

jQuery(".numberInput").live("keydown", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 40)) {

    	if(event.keyCode == 38 && event.currentTarget.value!="")//yukarı
       		event.currentTarget.value = parseInt(event.currentTarget.value)+1;  
    	else if(event.keyCode == 40  && event.currentTarget.value!="")//aşagı
   			event.currentTarget.value = parseInt(event.currentTarget.value)-1;  
    	

             // let it happen, don't do anything
             return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        } 
        
              
    }
});

jQuery(".ciftTirnaksiz").live("keydown", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode != 162 ) {
       // let it happen, don't do anything
       return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        event.preventDefault(); 
        jQuery(this).val(jQuery(this).val()+"'");
              
    }
});

jQuery(".ciftTirnaksiz").live("keyup", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    jQuery(this).val(jQuery(this).val().replace(/\"/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\”/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\“/g, "'"));
});

jQuery(".ciftTirnaksiz").live("change", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    jQuery(this).val(jQuery(this).val().replace(/\"/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\”/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\“/g, "'"));
});

jQuery(".ciftTirnaksiz").live("blur", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    jQuery(this).val(jQuery(this).val().replace(/\"/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\”/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\“/g, "'"));
});

jQuery(".ciftTirnaksiz").live("cut copy paste", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    jQuery(this).val(jQuery(this).val().replace(/\"/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\”/g, "'"));
	jQuery(this).val(jQuery(this).val().replace(/\“/g, "'"));
});

jQuery('.ek2FormatiRadio').live('click', function (e) {
	var birimId = this.id.split('-')[1];
	var selectedValue = "";

	if( jQuery('#KontrolListesiRadioButtonKontrolListesiz-'+birimId).filter(':checked') != undefined
		&& jQuery('#KontrolListesiRadioButtonKontrolListesiz-'+birimId).filter(':checked').length == 0) // secili değil
		selectedValue= 'Y';
	else 
		selectedValue = 'E';

	biriminEk2FormatiniBelirle(birimId, selectedValue );

		
//	KontrolListesiRadioButtonEskiFormat
//	KontrolListesiRadioButtonYeniFormat
});


jQuery('.yeterliligiGelistirenKuruluslarCheckbox').live('click', function (e) {

	var checkboxClass = 'yeterliligiGelistirenKuruluslarCheckbox';
	var tabloIDsi = this.name.substr(checkboxClass.length+1);
	BirimGelistirenKurumKuruluslaraEkle(this.value, tabloIDsi , true);

	this.getParent().getParent().remove();
	
});



jQuery('.birimDogrulayanSektorKomitesiEkleButton').live('click', function (e) {
	var buttonClass = 'birimDogrulayanSektorKomitesiEkleButton';
	var popupID = this.id.substr(buttonClass.length+1); 
	
	jQuery(this.getParent().getParent()).after('<tr><td class="blueBackgrounded" style="width:30px">'
		+ '<input type="button" class="birimDogrulayanSektorKomitesiSilButton" value="SİL">'
		+ '</td>'
		+ '<td>'
		+ '<input type="text" value="" name="birimDogrulayanSektorKomitesi-'+popupID+'[]" style="width:80%;">'
		+ '</td></tr>');
});


jQuery('.birimDogrulayanSektorKomitesiSilButton').live('click', function (e) {
	this.getParent().getParent().remove();
});


jQuery('#EklenmisBirimlerGrid tbody tr *').live('click', function (e) {

	var thisRow = jQuery(this)[0];
	var thisTableBody = jQuery(this).parent()[0];

	while(thisRow.getTag()!="tr")
	{
		thisRow = thisRow.getParent();
		thisTableBody = thisTableBody.getParent();
	}
		
	for(var i=0; i<thisTableBody.getChildren().length; i++)
	{
		if(	thisTableBody.getChildren()[i].classList!=undefined 
			&& thisTableBody.getChildren()[i].classList.contains("odd"))
			jQuery(thisTableBody.getChildren()[i]).css("background-color","#E1E1E1");
		else
			jQuery(thisTableBody.getChildren()[i]).css("background-color","white");
	}
	thisRow.setStyle("background-color","#C1D1E1");
	seciliBirimRowID = thisRow.getId();

});




jQuery('.yeterlilikGelistirenKuruluslardanEkleButton').live('click', function (e) {
	var ekleButtonClass = 'yeterlilikGelistirenKuruluslardanEkleButton';
	var popupNumber = this.getId().substr(ekleButtonClass.length+1);
	var popupName = 'biriminDetaylariPopupDiv';
	var hiddenRowsClass = 'yeterliligiGelistirenKuruluslardan';
	jQuery('#'+popupName+'-'+popupNumber+' .'+hiddenRowsClass).toggle("slow");
	
});


jQuery('#BirimDetaylariToggler').live('click', function (e) {
	manageBirimDetayiPopup();
});

jQuery('#hepsiniKaydetButtonu').live('click', function (e) {
    e.preventDefault();
    //Get the row as a parent of the link that was clicked on
    //var birimler = oTableBirim.fnGetData();
    var birimRowlari = jQuery('#EklenmisBirimlerGrid tbody tr');
    
    if(birimRowlari.length == 1 && birimRowlari.children('td').attr('class') == "dataTables_empty"){
        
    }
    else{
        for(var i=0; i<birimRowlari.length; i++)
        {
            var IDIndex = 0;
            var birimKoduIndex = 1;
            var adIndex = 2;
            var seviyeIndex = 3;
            var zorunluSecmeliIndex = 6;
            var siraNoIndex = 9;

            var birimID = parseInt(birimRowlari[i].getChildren()[IDIndex].getHTML());
            var zorunluSecmeliDurumu = jQuery('select[name="zorunluSecmeliSelect-'+birimID+'"]').val();
                    var birimSiraNo = birimRowlari[i].getChildren()[siraNoIndex].getHTML();

            if(jQuery(birimRowlari[i].getChildren()[seviyeIndex]).children().length == 0) //kendi birimi değil
            {
                    jQuery('<input class="disBirimHiddenInput"  name="disBirimHiddenInput-IDler[]" id="disBirimHiddenInput-IDler['+i+']"  type="hidden" value="' + birimID + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="disBirimHiddenInput"  name="disBirimHiddenInput-Zorunluluklar[]" id="disBirimHiddenInput-Zorunluluklar['+i+']"  type="hidden" value="' + zorunluSecmeliDurumu + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="disBirimHiddenInput"  name="disBirimHiddenInput-SiraNo[]" id="disBirimHiddenInput-SiraNolar['+i+']"  type="hidden" value="' + birimSiraNo + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');

            }
            else // kendi birimi
            {
                    var birimAdi = birimRowlari[i].getChildren()[adIndex].getHTML();
                            var birimKodu = birimRowlari[i].getChildren()[birimKoduIndex].getHTML();
                            var birimSeviyesi = jQuery('select[name="birimSeviyesi-'+birimID+'"]').val();

                            jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-IDler[]" id="kendiBirimiHiddenInput-IDler['+i+']"  type="hidden" value="' + birimID + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-Zorunluluklar[]" id="kendiBirimiHiddenInput-Zorunluluklar['+i+']"  type="hidden" value="' + zorunluSecmeliDurumu + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-Adlar[]" id="kendiBirimiHiddenInput-Adlar['+i+']"  type="hidden" value="' + birimAdi + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-Kodlar[]" id="kendiBirimiHiddenInput-Kodlar['+i+']"  type="hidden" value="' + birimKodu + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-Seviyeler[]" id="kendiBirimiHiddenInput-Seviyeler['+i+']"  type="hidden" value="' + birimSeviyesi + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');
                    jQuery('<input class="kendiBirimiHiddenInput"  name="kendiBirimiHiddenInput-SiraNo[]" id="kendiBirimiHiddenInput-SiraNolar['+i+']"  type="hidden" value="' + birimSiraNo + '" />').appendTo('form#ChronoContact_yeterlilik_taslak');


            }        
        }
    }
    jQuery('#ChronoContact_yeterlilik_taslak').submit();
    // Stop event handling in IE
    return false;
} );


jQuery('#EklenmisBirimlerGrid a.editBirim').live('click', function (e) {
    e.preventDefault();
    manageBirimDetayiPopup();
    //Get the row as a parent of the link that was clicked on
   /* var nRow = jQuery(this).parents('tr')[0];
     
    if (this.innerHTML == "<?php //echo JText::_("SAVE_TEXT");?>" ) {
        //This row is being edited and should be saved
        if (validate (nRow)){
        	saveBirimRow( oTableBirim, nRow, false);
        	manageBirimDetayiPopup();
        }
    }
    else {
        //No row currently being edited
        editBirimRow( oTableBirim, nRow, false );
    }
*/
 	// Stop event handling in IE
    return false;
} );





jQuery('#EklenmisBirimlerGrid a.cancelBirim').live('click', function (e) {
	e.preventDefault();
    
    var nRow = jQuery(this).parents('tr')[0];
    cancelBirimEdit( oTableBirim, nRow );

 	// Stop event handling in IE
    return false;
} );


jQuery('#yeniButton').live(	"click", function(e) {
	var oTableBirim = jQuery('#EklenmisBirimlerGrid').dataTable();
	
    jQuery('#yeniBirimEklePopupDiv').lightbox_me({
        centered: true,
        closeClick:false,
        closeEsc:false,
        });
    e.preventDefault();
});

jQuery('#yeniBirimEklePopup_EkleButtonIptal').live('click',function(e){
	jQuery('#yeniBirimEklePopupDiv').trigger('close');
});


jQuery('.kontrolListeliEk2yeDegerlendirmeAraciEkleButton').live("click", function(e) {
	jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv').html("GETİRİLİYOR");

	var kontrolListeliEk2TabloElementID = jQuery(this).attr('class').split(' ')[1].split('-')[1]

	jQuery.ajax({
		  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxKontrolListeliEk2DataGetir&format=raw&element_id="+kontrolListeliEk2TabloElementID,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){

				  jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv').html('');
				  jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv').append('<input type="hidden" value="'+kontrolListeliEk2TabloElementID+'" name="ek2_kontrol_listeli_id_input">');
	
				  for(var i=0; i<data['array']['TUM_OLCME_DEGERLENDIRMELER'].length; i++)
				  {
					 	var harf = data['array']['TUM_OLCME_DEGERLENDIRMELER'][i]['OLC_DEG_HARF'];
						var no = data['array']['TUM_OLCME_DEGERLENDIRMELER'][i]['OLC_DEG_NUMARA']
				 		jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv').append('<input type="checkbox" class="kontrolListeliEk2DegerlendirmeAraclari_Checkbox" value="'+kontrolListeliEk2TabloElementID+'-'+harf+'-'+no+'" id="'+harf+'-'+no+'">'+harf+'-'+no+'<br>');
				 		
				  }
				  if(data['array']['TUM_OLCME_DEGERLENDIRMELER'].length == 0)
					  jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv').append('Kayıtlı');
					  
	
				  for(var i=0; i<data['array']['SECILI_OLCME_DEGERLENDIRMELER'].length; i++)
				  {
					var harf = data['array']['SECILI_OLCME_DEGERLENDIRMELER'][i]['DEGERLENDIRME_ARACI_HARF'];
					var no = data['array']['SECILI_OLCME_DEGERLENDIRMELER'][i]['DEGERLENDIRME_ARACI_NUMARA'];
				 	
				  	jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv #'+harf+'-'+no).attr('checked', 'checked');
	
				  }
				  
				
			  }else{

				jQuery('#BagimsizBirimEkle_SearchGrid').hide();
				jQuery('#BagimsizBirimEkle_ErrorDiv').html("Bulunamadı");
				jQuery('#BagimsizBirimEkle_EkleButton').hide();
				jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide();
				
			  }
		  }
	});
	
	
	jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv').lightbox_me({
        centered: true, 
        });
    e.preventDefault();
});


jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv-KaydetButton').live("click", function(e) {
	var jqInputs = jQuery('.kontrolListeliEk2DegerlendirmeAraclari_Checkbox').filter(':checked');
	var InputText = '';

	jQuery(jqInputs).each(function(e){
		InputText += '&checkboxValue[]='+jQuery(this).val();
	});
	
	var urlText = "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxKontrolListeliEk2DataKaydet&format=raw"+InputText;

	jQuery.ajax({
		  url: urlText,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){

				 jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv').trigger('close');
				  alert('Başarılı');
				
			  }
			  else
			  {
				  alert('Hata oluştu');
			  }
		  }
	});
	
});


jQuery('#yeniBirimEklePopup_EkleButton').live("click", function(e){

	if(checkIfPopupValuesAreValid()==true)
	{
		var jqInputs = jQuery('#yeniBirimEklePopupDiv input');
		var sendData = jqInputs.serializeArray();

		
		var birimAdi = jQuery('#yeniBirimEklePopup_BirimAdiTextBox').val();
		var birimZorunlulugu = jQuery('#yeniBirimEklePopup_ZorunluSelect').val();
		var birimSeviyesi = jQuery('#yeniBirimEklePopup_SeviyeTextBox').val();

		var birimIdentifier = '';
		var birimCounter = '';
		if(birimZorunlulugu == "1")//zorunlu
		{
			birimIdentifier = 'A';
			counterName = '#zorunluBirimlerCountHiddenField';
		}
		else if(birimZorunlulugu == "0")//seçmeli
		{	
			birimIdentifier = 'B';
			counterName = '#secmeliBirimlerCountHiddenField';
		}
		else //belirsiz
		{	
			birimIdentifier = '-';
			counterName = '#belirsizBirimlerCountHiddenField';
		}
		
		jQuery(counterName).val(parseInt(jQuery(counterName).val())+1);
		birimCounter = jQuery(counterName).val();
		
		var birimKodu = jQuery('#yeterlilikKoduHiddenField').val()
		+ '-'
		+ jQuery('#yeterlilikSeviyesiHiddenField').val()
		+ '/'
		+ birimIdentifier
		+ birimCounter;

		//var birimYayinTarihi = jQuery('#yeniBirimEklePopup_YayınTarihiTextBox').val();
		//var birimRevizyonNo = jQuery('#yeniBirimEklePopup_RevizyonNoTextBox').val();
		
		
		var oSettings = oTableBirim.fnSettings();
		
		var aiAdded = oTableBirim.fnAddData([
			                             		""+(--yeniUretilmisBirimIDCounter), 
			                             		"", 
			                             		birimAdi, 
			                             		"<select style='width:110px;' class='birimSeviyesiSelect' name='birimSeviyesi-"+yeniUretilmisBirimIDCounter+"'> <?php  echo $seviyelerText; ?></select>", 
			                             		"<?php echo $yeterlilikBilgi['YETERLILIK_ADI'];?>", 
			                             		"<?php echo $yeterlilikBilgi['SEVIYE_ID']; ?>",
			                             		"<select style='width:110px;' class='zorunluSecmeliSelect' name='zorunluSecmeliSelect-"+yeniUretilmisBirimIDCounter+"'><option value='1'>Zorunlu</option><option value='0'>Seçmeli</option><option value='-1'>-</option></select>",
			                             		"&nbsp;",
			                             		"<td><a class='deleteBirim' href=''>Sil</a></td>", 
			                             		"<td>"+(jQuery("#EklenmisBirimlerGrid tbody tr").length+1) +"</td>", 
			                             		"<td><input class='sirayaTasiTextbox' type='text' style='width:50px;'></td>"
		                             		]);
		oSettings.aoData[ aiAdded[0] ].nTr.id = yeniUretilmisBirimIDCounter;

		jQuery('select[name="birimSeviyesi-'+yeniUretilmisBirimIDCounter+'"] option').each(function () {
			jQuery(this).removeAttr("selected");
		});
		jQuery('select[name="birimSeviyesi-'+yeniUretilmisBirimIDCounter+'"] option')[birimSeviyesi-1].setProperty("selected", "selected");

		jQuery('select[name="zorunluSecmeliSelect-'+yeniUretilmisBirimIDCounter+'"] option').each(function () {
			jQuery(this).removeAttr("selected");
		});
		jQuery('select[name="zorunluSecmeliSelect-'+yeniUretilmisBirimIDCounter+'"] option').each(function () {
			if(this.value==birimZorunlulugu)
				jQuery(this).attr("selected", "selected");
		});

		
		window.setTimeout(function() {  
			jQuery('#yeniBirimEklePopup_BirimAdiTextBox').val("");
			jQuery('#yeniBirimEklePopup_SeviyeTextBox').val("");
			
			jQuery('#yeniBirimEklePopupDiv').trigger('close');
			
		}, 250);

//		jQuery('#biriminDetaylariPopupDiv').append( returnEmptyPopupData(yeniUretilmisBirimIDCounter, birimAdi));

		updateBirimKodlari();
		
		var satirSayisi = jQuery('#EklenmisBirimlerGrid tbody tr').length;
		for(var i=0; i<satirSayisi; i++)
			jQuery(jQuery('#EklenmisBirimlerGrid tbody tr')[i].getChildren()[9]).html((i+1));
		  
	}
		
});

jQuery('#addBagimsizBirimTogglerButton').live("click", function (e) {
	
	jQuery('#bagimsiz_birim_wrapper').toggle("slow");
	
	// Stop event handling in IE
	return false;
} );


jQuery('.ek1TekSatirEkleButton').live("click", function (e) {
	
	var buttonIDVariables = this.id.split('-');
	var birimID = buttonIDVariables[1];
	jQuery('#birimEk1Tablosu-'+birimID+' tbody').append('<tr class="ek1Yazisi">'
		+ '<td><input type="button" value="Sil" onclick="jQuery(jQuery(this).parent()[0].getParent()).remove();"></td>'
		+ '<td><input value="" name="biriminEk1leri-'+birimID+'[]" class="ciftTirnaksiz" style="width:99%;"></td>'
		+ '</tr>'
	);
	// Stop event handling in IE
	return false;
} );



jQuery('.ogrenmeCiktisiBaglamiGosterButton').live("click", function (e) {
	var variables = this.id.split('-');
	jQuery(this).hide();
	jQuery('#ogrCktBaglamiTextDiv-'+variables[1]+'-'+variables[2]).toggle("slow");
	jQuery('#ogrenmeCiktisiBaglamiGizleButton-'+variables[1]+'-'+variables[2]).show();	
	// Stop event handling in IE
	return false;
} );

jQuery('.ogrenmeCiktisiBaglamiGizleButton').live("click", function (e) {
	var variables = this.id.split('-');
	jQuery('#ogrCktBaglamiTextDiv-'+variables[1]+'-'+variables[2]).toggle("slow");
	jQuery('#ogrenmeCiktisiBaglami-'+variables[1]+'-'+variables[2]).val("");
	jQuery('#ogrenmeCiktisiBaglamiGosterButton-'+variables[1]+'-'+variables[2]).show();
	
	// Stop event handling in IE
	return false;
} );

jQuery('.basarimOlcutuBaglamiGosterButton').live("click", function (e) {
	var variables = this.id.split('-');
	jQuery(this).hide();
	jQuery('#bsrOlcBaglamiTextDiv-'+variables[1]+'-'+variables[2]+'-'+variables[3]).toggle("slow");
	jQuery('#basarimOlcutuBaglamiGizleButton-'+variables[1]+'-'+variables[2]+'-'+variables[3]).show();
		
	// Stop event handling in IE
	return false;
} );

jQuery('.basarimOlcutuBaglamiGizleButton').live("click", function (e) {
	var variables = this.id.split('-');
	jQuery('#bsrOlcBaglamiTextDiv-'+variables[1]+'-'+variables[2]+'-'+variables[3]).toggle("slow");
	jQuery('#basarimOlcutuBaglami-'+variables[1]+'-'+variables[2]+'-'+variables[3]).val("");
	jQuery('#basarimOlcutuBaglamiGosterButton-'+variables[1]+'-'+variables[2]+'-'+variables[3]).show();
	
	// Stop event handling in IE
	return false;
} );

jQuery('.yeniBasarimOlcutuEkleButton').live("click", function (e) {

	var ekleButtonVariables = this.id.split("-"); 
	yeniBasarimOlcutuEkle2(ekleButtonVariables[1], ekleButtonVariables[2], "", "" );
	// Stop event handling in IE
	return false;
});

jQuery('.yeniBasarimOlcutuTopluEkleButton').live("click", function (e) {

	var ekleButtonVariables = this.id.split("-");
	jQuery('#ToppopupIdsi').val(ekleButtonVariables[1]);
	jQuery('#ToprowIdsi').val(ekleButtonVariables[2]);
	//alert(ekleButtonVariables[1]+" - "+ekleButtonVariables[2]);
	jQuery('#TopluOlcut').lightbox_me({
				        centered: true, 
				        });
	// Stop event handling in IE
	return false;
});

jQuery('#TopluEkle').live('click',function(e){
	e.preventDefault();
	var topluOlcut = jQuery('#topluOlcutler').val();
	text=topluOlcut.replace("\r\n","\n");
    var ek1Array=text.split("\n");
    for(var i=0; i<ek1Array.length; i++){
    	yeniBasarimOlcutuEkle2(jQuery('#ToppopupIdsi').val(),jQuery('#ToprowIdsi').val(),ek1Array[i],'');
    }
	jQuery('#topluOlcutler').html('');
	jQuery('#ToppopupIdsi').val('');
	jQuery('#ToprowIdsi').val('');
	jQuery('#TopluOlcut').trigger('close');
// 	window.location.reload();
});

jQuery('#ipptal').live('click',function(e){
	e.preventDefault();
	jQuery('#topluOlcutler').html('');
	jQuery('#ToppopupIdsi').val('');
	jQuery('#ToprowIdsi').val('');
	jQuery('#TopluOlcut').trigger('close');
});

jQuery('.basarimOlcutuSilButton').live("click", function (e) {

	var silButtonVariables = this.id.split("-"); 
	var popupIDsi = silButtonVariables[1];
	var ogrenmeCiktisiID = silButtonVariables[2];
	var basarimOlcutuID = silButtonVariables[3];
	
	if(basarimOlcutuID=="1")//en usttekine tıklanmıs
	{
		if(jQuery('#basarimOlcutuSilButton-'+popupIDsi+'-'+ogrenmeCiktisiID+'-2').length ==0 )
		{
			jQuery('#ogrenmeCiktisininBasarimOlcutuNumaralariTD-'+popupIDsi+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID).html("");
			jQuery('#ogrenmeCiktisininBasarimOlcutuDataTD-'+popupIDsi+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID).html("<strong>Başarım Ölçütü Eklenmemiş</strong>");
		}
		else // iki tane basarim Olcutu mutlaka var
		{
			jQuery('#basarimOlcutu-'+popupIDsi+'-'+ogrenmeCiktisiID+'-1').val(jQuery('#basarimOlcutu-'+popupIDsi+'-'+ogrenmeCiktisiID+'-2').val());
			jQuery('#basarimOlcutuBaglami-'+popupIDsi+'-'+ogrenmeCiktisiID+'-1').val(jQuery('#basarimOlcutuBaglami-'+popupIDsi+'-'+ogrenmeCiktisiID+'-2').val());
			basarimOlcutuSil(popupIDsi, ogrenmeCiktisiID, parseInt(basarimOlcutuID)+1);
		}
		
	}
	else	
		basarimOlcutuSil(popupIDsi, ogrenmeCiktisiID, basarimOlcutuID);

	
	OgrenmeCiktisiVeBasarimOlcutuNumaralariniDuzenle(popupIDsi);

	// Stop event handling in IE
	return false;
});

jQuery('.ogrenmeCiktisiSilButton').live("click", function (e) {

	var silButtonVariables = this.id.split("-"); 
	ogrenmeCiktisiSil(silButtonVariables[1], silButtonVariables[2]);
	// Stop event handling in IE
	return false;
});

jQuery('.yeniBasarimOlcutuEkleButton2').live("click", function (e) {

	var rowElement = e.currentTarget;
	var tableElement = e.currentTarget
	var tableName = 'biriminDetaylariTablosu';
	var basarimOlcutuEkleButtonName = 'yeniBasarimOlcutuEkle';
	
	while (rowElement != null && rowElement.getTag() != "tr")
	{	
		rowElement = rowElement.getParent();
	}
	while (tableElement != null && tableElement.getTag() != "table")
	{	
		tableElement = tableElement.getParent();
	}

	var popupIDsi = tableElement.id.substr(tableName.length+1);
	var rowIDsi = e.currentTarget.id.substr(basarimOlcutuEkleButtonName.length+1);
	
	var tdArray = rowElement.getChildren();

	var td0RowSpanValue = jQuery(tdArray[0]).attr("rowspan");
	var td1RowSpanValue = jQuery(tdArray[1]).attr("rowspan");
/*
	if(td0RowSpanValue == undefined)
		jQuery(tdArray[0]).attr("rowspan", "2");
	else
		jQuery(tdArray[0]).attr("rowspan", parseInt(jQuery(tdArray[0]).attr("rowspan"))+1)
	
	if(td1RowSpanValue == undefined)
		jQuery(tdArray[1]).attr("rowspan", "2");
	else
		jQuery(tdArray[1]).attr("rowspan", parseInt(jQuery(tdArray[1]).attr("rowspan"))+1)
*/	
		
	var result =  yeniBasarimOlcutuEkle2(popupIDsi, rowIDsi, "", "");
	
	// Stop event handling in IE
	return false;
} );


jQuery('#BagimliBirimEkle_SektorSelect').change( function (e) {
	
	BagimliBirimEkleValuesChanged_Sektor();
	// Stop event handling in IE
	return false;
} );
jQuery('#BagimliBirimEkle_SeviyeSelect').change( function (e) {
	
	BagimliBirimEkleValuesChanged();
	// Stop event handling in IE
	return false;
} );



jQuery('#BagimsizBirimEkle_AratButton').live("click",  function (e) {
	jQuery('#BagimsizBirimEkle_ErrorDiv').html("Aranıyor");
	jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide();
	
	var jqInputs = jQuery('#BagimsizBirimEkle_NameTextBox');
	var sendData = jqInputs.serializeArray();

	/*  VALIDATION?????  */
	
	jQuery.ajax({
		  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxAdaGoreBagimsizBirimArat&format=raw",
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				//jQuery("#bilgilendirme").html(data['data']);
				//oTable.fnDeleteRow( nRow );
				updateSearchedBirimTable(data['array']);
				jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').show("slow");
				jQuery('#BagimsizBirimEkle_SearchGrid').show("slow");
				jQuery('#BagimsizBirimEkle_EkleButton').show();
				jQuery('#BagimsizBirimEkle_ErrorDiv').html(" ");
				
			  }else{

				jQuery('#BagimsizBirimEkle_SearchGrid').hide();
				jQuery('#BagimsizBirimEkle_ErrorDiv').html("Bulunamadı");
				jQuery('#BagimsizBirimEkle_EkleButton').hide();
				jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide();
				
			  }
		  }
	});
	
	
	
	// Stop event handling in IE
	return false;
} );

//DELETE ROW FOR UZATMALAR
jQuery('#EklenmisBirimlerGrid a.deleteBirim').live('click', function (e) {
    e.preventDefault();
    var nRow = jQuery(this).parents('tr')[0];
    var id = nRow.id;

    jQuery("#biriminDetaylariPopupDiv-"+id).remove();
  	//Satir yeni eklenmemisse

    oTableBirim.fnDeleteRow( nRow ); 

 	// Stop event handling in IE
    return false;
} );
	//END DELETE ROW FOR UZATMALAR

	
jQuery('#BagimliBirimEkle_GetirButton').live("click",  function (e) {
	
	if(jQuery('#BagimliBirimEkle_YeterlilikSelect').val() == "0")
	{
		jQuery('#BagimliBirimEkle_YeterlilikSelect').css("border", "1px solid red");
	}
	else
	{

		var sendData = null
		var yeterlilikValue = jQuery("#BagimliBirimEkle_YeterlilikSelect").val();
		
		/*  VALIDATION?????  */
		
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxYeterliliginBirimleriniGetir&format=raw&yeterlilikID="+yeterlilikValue,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){

					  	
					  updateSearchedBirimTable(data['array']);
						jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').show("slow");
						jQuery('#BagimsizBirimEkle_SearchGrid').show("slow");
						jQuery('#BagimsizBirimEkle_EkleButton').show();
						jQuery('#BagimsizBirimEkle_ErrorDiv').html(" ");
						
					  }else{

						jQuery('#BagimsizBirimEkle_SearchGrid').hide();
						jQuery('#BagimsizBirimEkle_EkleButton').hide();
						jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide();
					  	jQuery('#BagimsizBirimEkle_ErrorDiv').html("Arama kriterlerine uygun birim bulunamadı");
				  }
			  }
		});		
	}
	// Stop event handling in IE
	return false;
} );


jQuery('.BasarimOlcutuYetkinlikEkleButton').live("click",  function (e) {
	var birimId = this.id.split('-')[1];

	Ek2yeBasarimOlcutuYetkinlikEkle(birimId, "", "", "Değerlendirme Aracı Eklemek İçin Kaydediniz", "", "");
	

});



jQuery('.BasarimOlcutuAnlayisEkleButton').live("click",  function (e) {
	var birimId = this.id.split('-')[1];
	Ek2yeBasarimOlcutuAnlayisEkle(birimId, "", "", "Değerlendirme Aracı Eklemek İçin Kaydediniz", "", "");
});



jQuery('.KontrolListeliEk2Tablosu1SilButton , .KontrolListeliEk2Tablosu2SilButton').live("click",  function (e) {
	this.getParent().getParent().remove();
});



jQuery('.birimEk1TopluEklemeTumunuEkleButton').live("click",  function (e){
	var birimID = this.id.split('-')[1];
	text=jQuery("#birimEk1TopluEklemeTextArea-"+birimID).val();
    text=text.replace("\r\n","\n");
    var ek1Array=text.split("\n");

    for(var i=0; i<ek1Array.length; i++)
    jQuery('#birimEk1Tablosu-'+birimID+' tbody').append('<tr class="ek1Yazisi">'
    		+ '<td><input type="button" value="Sil" onclick="jQuery(jQuery(this).parent()[0].getParent()).remove();"></td>'
    		+ '<td><input value="'+ek1Array[i]+'" name="biriminEk1leri-'+birimID+'[]" style="width:99%;" value="'+ek1Array+'"></td>'
    		+ '</tr>'
    	);
    jQuery("#birimEk1TopluEklemeTextArea-"+birimID).val("");
    jQuery("#birimEk1TopluEklemeDiv-"+birimID).toggle("slow");

    
});

jQuery('#BagimsizBirimEkle_EkleButton').live("click",  function (e) {
	var jqInputs = jQuery('.BirimlerCheckbox');
	var sendData = jqInputs.serializeArray();
	var ekliDegerCiktiMi = false;
	
	jQuery('.BirimlerCheckbox').filter(":checked").each(function () {
    	//alert(this.value);
		var buDegerEkliMi = false;
    	for(var i=0; i< oTableBirim.fnGetData().length; i++)
    	{
    		if(oTableBirim.fnGetNodes()[i].cells[0].innerHTML == ""+this.value)
    		{	
        		buDegerEkliMi = true;
        		ekliDegerCiktiMi = true;
    		}
        }
        
        if(buDegerEkliMi == false)
        {
            var birimID = this.value;
        	var birimAdi = this.getParent().getParent().cells[2].innerHTML;
        	var birimKodu = this.getParent().getParent().cells[1].innerHTML;
        	var birimSeviyesi = this.getParent().getParent().cells[3].innerHTML;
        	var bagimliOlanYeterliliginAdi = this.getParent().getParent().cells[4].innerHTML; 
        	var bagimliOlanYeterliliginSeviyesi = this.getParent().getParent().cells[5].innerHTML; 

        	var birimZorunlulugu = "Zorunlu"; //Defaultta zorunlu		
        	var guncelleButtonText = '<a class="editBirim">Güncelle</a>';
        	var zorunluSelectText = '<select name="zorunluSecmeliSelect-'+birimID+'" class="zorunluSecmeliSelect" style="width:110px;"><option value="1">Zorunlu</option><option value="0">Seçmeli</option><option value="-1" selected="selected">-</option></select>';
			var silButtonText = '<a class="deleteBirim" href="">Sil</a>'
        	var sirayaTasiTextbox = '<input type="text" class="sirayaTasiTextbox" style="width:50px;">';
        	
        	oTableBirim.fnAddData ([birimID, birimKodu, birimAdi, birimSeviyesi, "Bağımsız", bagimliOlanYeterliliginSeviyesi, zorunluSelectText, "", silButtonText, '-' , sirayaTasiTextbox ]);
    	}
        	
        	
	});
	
	if(ekliDegerCiktiMi == true)
		alert("Seçili Birimler Arasında Önceden Eklenmiş Birimler Var, Diğer Birimler Başarıyla Eklendi");
	
	// Stop event handling in IE
	return false;
} );

function kayitliAnlayisYetkinliklerinIDleriniHiddenInputOlarakKaydet(birimID)
{
	var tablo1Rows = jQuery('#biriminDetaylariPopupDiv-'+birimID+' .KontrolListeliEk2Tablosu1Row');
	var tablo2Rows = jQuery('#biriminDetaylariPopupDiv-'+birimID+' .KontrolListeliEk2Tablosu2Row');	

	var tablo1IDleri = '';
	var tablo2IDleri = '';
	
	jQuery(tablo1Rows).each(function(e){
		var fullClassName = jQuery(this).attr('class');
		if(fullClassName.split(' ')[1] != undefined)
		{
			var row_id = (fullClassName.split(' ')[1]).split('-')[1];
			if(row_id != undefined && row_id != '' )
			{
				tablo1IDleri += (row_id + '-');
			}
		}
		
	});

	jQuery(tablo2Rows).each(function(e){
		var fullClassName = jQuery(this).attr('class');
		if(fullClassName.split(' ')[1] != undefined)
		{
			var row_id = (fullClassName.split(' ')[1]).split('-')[1];
			if(row_id != undefined && row_id != '' )
			{
				tablo2IDleri += (row_id + '-');
			}
		}
		
	});

	jQuery('#biriminDetaylariPopupDiv-'+birimID).append('<input type="hidden" name="duzenlemedenGeriyeKalanKontrolListeliEk2_1" value="'+tablo1IDleri+'">');
	jQuery('#biriminDetaylariPopupDiv-'+birimID).append('<input type="hidden" name="duzenlemedenGeriyeKalanKontrolListeliEk2_2" value="'+tablo2IDleri+'">');
	
}


function kayitliSinavlarinIDleriniHiddenInputOlarakKaydet(birimID)
{
	var teorikSinavRows = jQuery('#biriminDetaylariPopupDiv-'+birimID+' .teorikSinavlarRow');
	var performansSinavlariRows = jQuery('#biriminDetaylariPopupDiv-'+birimID+' .performansSinavlariRow');	

	var teorikSinavIDleri = '';
	var performansSinaviIDleri = '';
	
	jQuery(teorikSinavRows).each(function(e){
		var fullClassName = jQuery(this).attr('class');
		if(fullClassName.split(' ')[1] != undefined)
		{
			var sinavID = (fullClassName.split(' ')[1]).split('-')[1];
			teorikSinavIDleri += (sinavID + '-');
		}
		
	});

	jQuery(performansSinavlariRows).each(function(e){
		var fullClassName = jQuery(this).attr('class');
		if(fullClassName.split(' ')[1] != undefined)
		{
			var sinavID = (fullClassName.split(' ')[1]).split('-')[1];
			if(sinavID != undefined && sinavID != '' )
			{
				performansSinaviIDleri += (sinavID + '-');
			}
		}
		
	});

	jQuery('#biriminDetaylariPopupDiv-'+birimID).append('<input type="hidden" name="duzenlemedenGeriyeKalanTeorikSinavlar" value="'+teorikSinavIDleri+'">');
	jQuery('#biriminDetaylariPopupDiv-'+birimID).append('<input type="hidden" name="duzenlemedenGeriyeKalanPerformansSinavlari" value="'+performansSinaviIDleri+'">');
			
}

jQuery('.popupuKaydetButton').live("click", function (e) {

	var kaydetButtonName = 'popupuKaydetButton';
	var popupName = 'biriminDetaylariPopupDiv';
	var birimID = e.currentTarget.id.substr(kaydetButtonName.length+1);

	kayitliSinavlarinIDleriniHiddenInputOlarakKaydet(birimID);
	kayitliAnlayisYetkinliklerinIDleriniHiddenInputOlarakKaydet(birimID);
	
	var serializedTextareas = jQuery('#'+popupName+'-'+birimID+' textarea').serializeArray();
	var serializedInputs = jQuery('#'+popupName+'-'+birimID+' input').serializeArray();
	var serializedSelects = jQuery('#'+popupName+'-'+birimID+' select').serializeArray();

	var kontrolListesiURLPart = '';
	if( jQuery('#KontrolListesiRadioButtonKontrolListesiz-'+birimID).attr("checked") != undefined
		&&	jQuery('#KontrolListesiRadioButtonKontrolListesiz-'+birimID).attr("checked").length>0)
		kontrolListesiURLPart = 'ek2KontrolListeliMi=0';
	else
		kontrolListesiURLPart = 'ek2KontrolListeliMi=1';
			
	var url = 'index.php?option=com_yeterlilik_taslak_yeni&task=ajaxSaveBirimDetayi&format=raw&birimID='+birimID+'&'+kontrolListesiURLPart;

	var sendData = serializedTextareas.concat(serializedInputs).concat(serializedSelects);

	
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				 jQuery('#biriminDetaylariPopupDiv-'+birimID).trigger('close');
				 alert("başarılı");
				 window.location = window.location.href+'&popup='+birimID;
			  }
			  else
			  {
				alert("Kaydetmede hata, "+data['array']);
			  }
 
		  }
	});

	
});

jQuery('.popupuIptalButton').live('click',function(){
	jQuery('#'+jQuery(this).attr('id')).trigger('close');
});

jQuery('.birimGelistirenKurulusEkleButton').live("click",  function (e) {

	var ekleButtonName = 'birimGelistirenKurulusEkleButton';
	var popupIDsi = this.id.substr(ekleButtonName.length+1);
	BirimGelistirenKurumKuruluslaraEkle('', popupIDsi, false);
	
});



jQuery('.birimGelistirenKuruluslardanSilButton').live("click",  function (e) {

	var rowElement = this.getParent().getParent();
	var tableElement = rowElement.getParent();
	
	var rowName = 'birimGelistirenKuruluslarRow';
	var silButtonName = 'birimGelistirenKuruluslardanSilButton';
	var kurulusAdiTextboxName = "birimGelistirenKuruluslar";

	var textBoxItem = rowElement.getChildren()[1].getChildren()[0];
	var outerTableElement = tableElement.getParent();
	var outerTableName = 'birimDetayiIkinciTable';
	var birimIDsi = outerTableElement.id.substr(outerTableName.length+1);

		//readOnly ise yukarı ekle
	if(jQuery(textBoxItem).attr("readOnly")!=undefined && jQuery(textBoxItem).attr("readOnly").length > 0)
	{
		var yeterlilikKuruluslariRows = jQuery(tableElement).children().filter('.yeterliligiGelistirenKuruluslardan');

		var yeniyeterlilikKurulusuRowText = '<tr style="" class="yeterliligiGelistirenKuruluslardan darkGrayBackgrounded "><td colspan="2"><input type="checkbox" value="'+jQuery(textBoxItem).val()+'" name="yeterliligiGelistirenKuruluslarCheckbox-'+birimIDsi+'" class="yeterliligiGelistirenKuruluslarCheckbox">'+jQuery(textBoxItem).val()+'</td></tr>';
		
		jQuery(tableElement).children().filter('#birimGelistirenKuruluslarRow-0').after(yeniyeterlilikKurulusuRowText);
		
		
	}

	rowElement.remove();

	
	//diger Rowlardaki numaralandırmaları düzelt
	while(rowElement.getNext()!=null && rowElement.getNext().hasClass('birimGelistirenKuruluslarRow'))//tüm birim gelistiren Kuruluslar Rowu için
	{
		rowElement = rowElement.getNext();
		var rowIDNumber = rowElement.id.substr(rowName.length+1);
		var newRowIDNumber = parseInt(rowIDNumber)-1;

		rowElement.id = rowName + '-' + newRowIDNumber;
		var silButtonElement = rowElement.getChildren()[0].getChildren()[0];
		silButtonElement.id = silButtonName + '-' + newRowIDNumber;

		var kurulusNameTextboxElement = rowElement.getChildren()[1].getChildren()[0];
		kurulusNameTextboxElement.name = kurulusAdiTextboxName + '[' + newRowIDNumber + ']';
		
	}
	
	
});


//SinavTür
jQuery('.SinavTurEkleButton').live('click',function(e){
	var birims = jQuery(this).attr('id');
	var birimId = birims.split('-');
	var turs = <?php echo json_encode($birimTur);?>;
	
	
		var ekleTur = '';
		var say = jQuery('.alterTur').length+1;

		if(turs[birimId[1]]['T']){
			jQuery.each(turs[birimId[1]]['T'],function(key,vall){
				ekleTur += '<input style="margin-left:5px;" type="checkbox" name="birimTur['+say+'][]" value="'+birimId[1]+'_'+vall['OLC_DEG_HARF']+'_'+vall['OLC_DEG_NUMARA']+'"><span> '+vall['OLC_DEG_HARF']+vall['OLC_DEG_NUMARA']+'</span>';
			});
		}

		if(turs[birimId[1]]['P']){
			jQuery.each(turs[birimId[1]]['P'],function(key,vall){
				ekleTur += '<input style="margin-left:5px;" type="checkbox" name="birimTur['+say+'][]" value="'+birimId[1]+'_'+vall['OLC_DEG_HARF']+'_'+vall['OLC_DEG_NUMARA']+'"><span> '+vall['OLC_DEG_HARF']+vall['OLC_DEG_NUMARA']+'</span>';
			});
		}
			var trTur = '<tr class="alterTur"><td><input id="TurSilButton-'+birimId[1]+'" class="TurSilButton" type="button" value="SİL"></td><td>'+ekleTur+'</td></tr>';

			jQuery(this).closest('tr').after(trTur);	

});
//SinavTür Son

//SinavTür Sil
jQuery('.TurSilButton').live('click',function(e){
	e.preventDefault();
	jQuery(this).closest('tr').remove();
	
});
//SinavTür Sil Son

//Kayitli Sinav Tür Sil
jQuery('.KayitliTurSilButton').live('click',function(e){
	var altTur = jQuery(this).attr('id');
	var turId = altTur.split('-');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_yeterlilik_taslak_yeni&task=alternatifTurSil&format=raw",
		data:"alterTurId="+turId[1],
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat == 1){
				jQuery('#'+altTur).closest('tr').remove();
				alert('Tür koşulu başarıyla silindi.');
			}else{
				alert('Tür koşulunu silerken bir hata meydana geldi. Lütfen tekrar deneyiniz.');
			}
		}
	});
});
//Kayitli Sinav Tür Sil Son

jQuery('.sinavEkleButton').live("click",  function (e) {

	

	if(jQuery(this).hasClass("teorikSinavEkleButton"))
	{
		ekleButtonName = 'teorikSinavEkleButton';
		sinavIdentifier = 'T';
	}
	else if(jQuery(this).hasClass("performansSinaviEkleButton"))
	{
		ekleButtonName = 'performansSinaviEkleButton';
		sinavIdentifier = 'P';
	}
	else if(jQuery(this).hasClass("digerSinavEkleButton"))
	{
		ekleButtonName = 'digerSinavEkleButton';	
		sinavIdentifier = 'D';
	}

	
	var birimID = this.id.substr(ekleButtonName.length+1);
	
	
	birimDetaylarinaSinavEkle (birimID, sinavIdentifier, "", "", "", "", "", "", "", "", "", "", "" );
	
} );

jQuery('.sinavSilButton').live("click", function (e) {
	var rowName, silButtonName, sinavName, sinavIdentifier, RowIDToBeDeleted;
	 
	if(jQuery(this).hasClass("teorikSinavSilButton"))
	{
		rowName = 'teorikSinavlarRow';
		silButtonName = 'teorikSinavSilButton';
		sinavName = 'buBiriminTeorikSinavlari'
		sinavIdentifier = 'T';		
	}
	else if(jQuery(this).hasClass("performansSinaviSilButton"))
	{
		rowName = 'performansSinavlariRow';
		silButtonName = 'performansSinaviSilButton';
		sinavName = 'buBiriminPerformansSinavlari'
		sinavIdentifier = 'P';			
	}
	else if(jQuery(this).hasClass("digerSinavSilButton"))
	{
		rowName = 'digerSinavlarRow';
		silButtonName = 'digerSinavSilButton';
		sinavName = 'buBiriminDigerSinavlari'
		sinavIdentifier = '';	
	}

	var silButtonClass = silButtonName + ' sinavSilButton'; 

	birimID = e.currentTarget.id.split('-')[1];
	RowIDToBeDeleted = e.currentTarget.id.split('-')[2];
	
	jQuery('#birimDetayiIkinciTable-'+birimID + ' tbody tr#' + rowName + '-' + RowIDToBeDeleted ).remove();
	
	for(var i=0; i<jQuery('.' + rowName).length; i++)
	{
		if((jQuery('.' + rowName)[i]).getId().substr(rowName.length+1) > RowIDToBeDeleted)
		{
			var newID = (jQuery('.' + rowName)[i]).getId().substr(rowName.length+1) -1;
			//set id of row
			(jQuery('.' + rowName)[i]).id = rowName + '-' + newID;
			//set inner html of first td
			jQuery('.' + rowName)[i].getChildren()[0].innerHTML = sinavIdentifier + newID + '<br><input value="SİL" id="' + silButtonName + '-' + birimID + '-' + newID + '" class="' + silButtonClass + '" type="button">';  //1. td

			var sinavAciklamasiTextAreaChildIndex = 2;
			if(jQuery(this).hasClass("teorikSinavSilButton"))
			{
				var soruSayisiName = 'buBiriminTeorikSinavlarininSoruSayileri';
				var minSoruSuresiName = 'buBiriminTeorikSinavlarininMinSoruSureleri';
				var maxSoruSuresiName = 'buBiriminTeorikSinavlarininMaxSoruSureleri';
				var basariKriteriName = 'buBiriminTeorikSinavlarininBasariKriterleri';
				
				jQuery('.' + rowName)[i].getChildren()[1].getChildren()[6].name = soruSayisiName + '[' + newID + ']'; //2. td
				jQuery('.' + rowName)[i].getChildren()[1].getChildren()[10].name = minSoruSuresiName + '[' + newID + ']'; //2. td
				jQuery('.' + rowName)[i].getChildren()[1].getChildren()[11].name = maxSoruSuresiName + '[' + newID + ']'; //2. td
				jQuery('.' + rowName)[i].getChildren()[1].getChildren()[16].name = basariKriteriName + '[' + newID + ']'; //2. td
				
			}
			if(jQuery(this).hasClass("performansSinaviSilButton"))
			{
				var basariKriteriName = 'buBiriminTeorikSinavlarininBasariKriterleri';
				
				jQuery('.' + rowName)[i].getChildren()[1].getChildren()[7].name = basariKriteriName + '[' + newID + ']'; //2. td
				
			}
			else 
			{
				sinavAciklamasiTextAreaChildIndex = 0;
			}

			//set id and name of the textarea in second td
			jQuery('.' + rowName)[i].getChildren()[1].getChildren()[sinavAciklamasiTextAreaChildIndex].name = sinavName + '[' + newID + ']'; //2. td
			
			
		}
		
	}

	// Ek2 den silmek için
	var birimId = this.id.split("-")[1];
	var KontrolListesizEk2RowElements = jQuery('#KontrolListesizEk2Tablolari-'+birimId+' tbody tr')
	for(var i=0; i<KontrolListesizEk2RowElements.length; i++)
	{
		var variables = jQuery(KontrolListesizEk2RowElements)[i].id.split("-");
		var ogrenmeCiktisiID = variables[2];
		var basarimOlcutuID = variables[3];

		var RowIDToBeDeleted2 = jQuery('#birimDetayiIkinciTable-'+birimId+' tbody tr.'+rowName).length; 
		jQuery('#DegerlendirmeAraciTDDiv-'+birimId+'-'+ogrenmeCiktisiID+'-'+basarimOlcutuID+'-'+sinavIdentifier+'-'+RowIDToBeDeleted2).remove();
	}

} );


function manageBirimDetayiPopup()
{
	jQuery('#biriminDetaylariPopupDiv-'+seciliBirimRowID).lightbox_me({
        centered: true,
        closeClick:false,
     	closeEsc:false  
        });
}

function BagimliBirimEkleValuesChanged(YeniYeterliliklerYuklensinMi)
{
	
	var sektorDegeri = jQuery('#BagimliBirimEkle_SektorSelect').val(); 
	var seviyeDegeri = jQuery('#BagimliBirimEkle_SeviyeSelect').val();

	if(sektorDegeri==0)
	{
		jQuery('#BagimliBirimEkle_SektorSelect').css("border", "1px solid red");
	}
	else
	{
		if(seviyeDegeri==0)
		{
			jQuery('#BagimliBirimEkle_SeviyeSelect').css("border", "1px solid red");
			jQuery('#BagimliBirimEkle_SektorSelect').css("border", "1px solid #C0C0C0");

			jQuery("#BagimliBirimEkle_SeviyeSelect").attr('disabled', 'disabled');
			
			var sektorValue = jQuery("#BagimliBirimEkle_SektorSelect").val();
			
			
			jQuery.ajax({
				  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxSektoreGoreSeviyeGetir&format=raw&sektor="+sektorValue,
				  data: null,
				  type: "POST",
				  dataType: 'json',
				  success: function(data) {
					  if(data['success']){

						  jQuery("#BagimliBirimEkle_SeviyeSelect").empty();
						  for(var i=0; i<data['array'].length; i++)
						  {
							  var option = jQuery('<option></option>').attr("value", data['array'][i]).text('Seviye '+data['array'][i]);
							  jQuery("#BagimliBirimEkle_SeviyeSelect").append(option).removeAttr('disabled');
						  }
						  if(data['array'].length==0)
						 	  jQuery("#BagimliBirimEkle_SeviyeSelect").append(jQuery('<option></option>').attr("value", 0).text('Seçili Birime Ait Yeterlilik Yok')); 	

						  jQuery('#BagimliBirimEkle_SeviyeSelect').css("border", "1px solid #C0C0C0");


						  var sektorDegeri = jQuery('#BagimliBirimEkle_SektorSelect').val(); 
						  var seviyeDegeri = jQuery('#BagimliBirimEkle_SeviyeSelect').val();
						  if(sektorDegeri!=0 && seviyeDegeri!=0) //ikisi de set edilmiş
						  {
								sektorVeSeviyedenYeterlilikGetir();
						  }
							
					  }else{

						  jQuery("#BagimliBirimEkle_SeviyeSelect").empty();
						  var option = jQuery('<option></option>').attr("value", 0).text('Hata');
						  jQuery("#BagimliBirimEkle_SeviyeSelect").append(option);
						  
					  }
					  
					  
						
				  }
			});
			
		}
		
	}

	
	if(sektorDegeri!=0 && seviyeDegeri!=0) //ikisi de set edilmiş
	{
		sektorVeSeviyedenYeterlilikGetir();
	}
	
	


}

function BagimliBirimEkleValuesChanged_Sektor(YeniYeterliliklerYuklensinMi)
{
	
	var sektorDegeri = jQuery('#BagimliBirimEkle_SektorSelect').val(); 
	var seviyeDegeri = jQuery('#BagimliBirimEkle_SeviyeSelect').val();

	if(sektorDegeri==0)
	{
		jQuery('#BagimliBirimEkle_SektorSelect').css("border", "1px solid red");
	}
	else
	{
		jQuery('#BagimliBirimEkle_SeviyeSelect').css("border", "1px solid red");
		jQuery('#BagimliBirimEkle_SektorSelect').css("border", "1px solid #C0C0C0");
	
		var sektorValue = jQuery("#BagimliBirimEkle_SektorSelect").val();
			
			
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxSektoreGoreSeviyeGetir&format=raw&sektor="+sektorValue,
			  data: null,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					  jQuery("#BagimliBirimEkle_SeviyeSelect").removeAttr('disabled').empty();

					  for(var i=0; i<data['array'].length; i++)
					  {
						  var option = jQuery('<option></option>').attr("value", data['array'][i]).text('Seviye '+data['array'][i]);
						  jQuery("#BagimliBirimEkle_SeviyeSelect").append(option);
					  }
					  if(data['array'].length==0)
					 	  jQuery("#BagimliBirimEkle_SeviyeSelect").append(jQuery('<option></option>').attr("value", 0).text('Seçili Birime Ait Yeterlilik Yok')); 	

					  jQuery('#BagimliBirimEkle_SeviyeSelect').css("border", "1px solid #C0C0C0");

					  var sektorDegeri = jQuery('#BagimliBirimEkle_SektorSelect').val(); 
					  var seviyeDegeri = jQuery('#BagimliBirimEkle_SeviyeSelect').val();
					  if(sektorDegeri!=0 && seviyeDegeri!=0) //ikisi de set edilmiş
					  {
							sektorVeSeviyedenYeterlilikGetir();
					  }
							
				  }else{

					  jQuery("#BagimliBirimEkle_SeviyeSelect").empty();
					  var option = jQuery('<option></option>').attr("value", 0).text('Hata');
					  jQuery("#BagimliBirimEkle_SeviyeSelect").append(option);
					  
				  }
					  
					  
						
			  }
		});
			
		
		
	}

	
	if(sektorDegeri!=0 && seviyeDegeri!=0) //ikisi de set edilmiş
	{
		sektorVeSeviyedenYeterlilikGetir();
	}
	
	


}

function sektorVeSeviyedenYeterlilikGetir( )
{

	jQuery('#BagimliBirimEkle_SeviyeSelect').css("border", "1px solid #C0C0C0");

	jQuery('#BagimliBirimEkle_YeterlilikSelect').css("border", "1px solid #C0C0C0");
	jQuery('#BagimsizBirimEkle_ErrorDiv').show();
	jQuery('#BagimsizBirimEkle_ErrorDiv').html("Getiriliyor");
					
	var sendData = null
	var sektorValue = jQuery("#BagimliBirimEkle_SektorSelect").val();
	var seviyeValue = jQuery("#BagimliBirimEkle_SeviyeSelect").val();
		
		
	jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxSeviyeVeSektoreGoreYeterlilikGetir&format=raw&sektor="+sektorValue+"&seviyeValue="+seviyeValue,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){

					  jQuery("#BagimliBirimEkle_YeterlilikSelect").empty();
					  for(var i=0; i<data['array'].length; i++)
					  {
						  var option = jQuery('<option></option>').attr("value", data['array'][i]["YETERLILIK_ID"]).text(data['array'][i]["YETERLILIK_ADI"]);
						  jQuery("#BagimliBirimEkle_YeterlilikSelect").append(option);
					  }
				  
					  jQuery('#BagimsizBirimEkle_ErrorDiv').html(" ");
					  jQuery("#BagimliBirimEkle_YeterlilikSelect").removeAttr('disabled');	
					
				  }else{

					  var option = jQuery('<option></option>').attr("value", "0").text("Lütfen Sektör ve Seviye Seçiniz");
					  jQuery("#BagimliBirimEkle_YeterlilikSelect").empty().append(option);
					  jQuery('#BagimsizBirimEkle_ErrorDiv').html("Arama kriterlerine uygun birim bulunamadı");

					  jQuery('#BagimsizBirimEkle_SearchGrid').hide();
					  jQuery('#BagimsizBirimEkle_EkleButton').hide();
					  jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide();
				  }
			  }
	});
			
}

function radioButtonsChanged()
{
	var radioValue = jQuery('input[name="bagimliBagimsizRadio"]').filter(':checked').val();
	if(radioValue==2)//bağımsız birim
	{
		jQuery('#BagimsizBirimEkle_OuterSearchDiv').show();
		jQuery('#BagimliBirimEkle_OuterSearchDiv').hide();
		
	}
	else //bağımlı birim
	{
		jQuery('#BagimsizBirimEkle_OuterSearchDiv').hide();
		jQuery('#BagimliBirimEkle_OuterSearchDiv').show();
		
	}
	jQuery('#BagimsizBirimEkle_SearchGrid').hide();
	jQuery('#BagimsizBirimEkle_ErrorDiv').html(" ");
	jQuery('#BagimsizBirimEkle_EkleButton').hide();
	jQuery('#BagimsizBirimEkle_SearchGrid_wrapper').hide("slow");
}

function saveBirimRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);

	var aData = oTable.fnGetData(nRow);
	if(aData[0]=="")
	{				
		oTable.fnUpdate( jqInputs[0].value, nRow, 2, false );
		//oTable.fnUpdate( jqInputs[1].value, nRow, 2, false );
		//oTable.fnUpdate( jqInputs[2].value, nRow, 5, false );
		oTable.fnUpdate( jqSelects[0].value, nRow, 3, false );
		oTable.fnUpdate( jqSelects[1].value, nRow, 6, false );
		
		//oTable.fnUpdate( jqInputs[3].value, nRow, 7, false );
		//oTable.fnUpdate( jqSelects[1].value, nRow, 8, false );
	}
	else
	{	
		oTable.fnUpdate( jqSelects[0].value, nRow, 6, false );
	}
	
	
	oTable.fnUpdate( '<a class="editBirim"><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 7, false );

			
	oTable.fnDraw();	 
		 
	
}

function cancelBirimEdit ( oTable, nRow )
{
	
  var aData = oTable.fnGetData(nRow);
  var jqTds = jQuery('>td', nRow);

  if(aData[0]=="")
  {
	  jqTds[1].innerHTML = aData[1];
	  jqTds[2].innerHTML = aData[2];
	  jqTds[5].innerHTML = aData[5];
	  jqTds[6].innerHTML = aData[6];
	  jqTds[7].innerHTML = aData[7];
  }
  
  jqTds[6].innerHTML = aData[6];
  jqTds[8].innerHTML = aData[8];
  
  jqTds[7].innerHTML = '<a class="editBirim"><?php echo JText::_("EDIT_TEXT");?></a>';

}



function checkIfPopupValuesAreValid()
{
	var result = true;

	var birimAdi = jQuery('#yeniBirimEklePopup_BirimAdiTextBox').val();
	var birimKodu = jQuery('#yeniBirimEklePopup_ReferansKoduTextBox').val();
	var birimSeviyesi = jQuery('#yeniBirimEklePopup_SeviyeTextBox').val();
	var birimYayinTarihi = jQuery('#yeniBirimEklePopup_YayınTarihiTextBox').val();
	var birimRevizyonNo = jQuery('#yeniBirimEklePopup_RevizyonNoTextBox').val();

	if(birimAdi==null || birimAdi.length == 0)
	{
		result = false;
		jQuery('#yeniBirimEklePopup_BirimAdiTextBox').css("border", "1px solid red");
	}
	else
	{
		jQuery('#yeniBirimEklePopup_BirimAdiTextBox').css("border", "1px solid #C0C0C0");
	}


	/*if(!isDate(birimYayinTarihi))
	{
		result = false;
		jQuery('#yeniBirimEklePopup_YayınTarihiTextBox').css("border", "1px solid red");
	}
	else
		jQuery('#yeniBirimEklePopup_YayınTarihiTextBox').css("border", "1px solid #C0C0C0");
*/

	
	return result;
}

function isDate(value) {
    try {
        //Change the below values to determine which format of date you wish to check. It is set to dd/mm/yyyy by default.
        var DayIndex = 0;
        var MonthIndex = 1;
        var YearIndex = 2;
 
        //value = value.replace(/-/g, ".").replace(/\./g, "."); 
        var SplitValue = value.split(".");
        var OK = true;
        if (!(SplitValue[DayIndex].length == 1 || SplitValue[DayIndex].length == 2)) {
            OK = false;
        }
        if (OK && !(SplitValue[MonthIndex].length == 1 || SplitValue[MonthIndex].length == 2)) {
            OK = false;
        }
        if (OK && SplitValue[YearIndex].length != 4) {
            OK = false;
        }
        if (OK) {
            var Day = parseInt(SplitValue[DayIndex], 10);
            var Month = parseInt(SplitValue[MonthIndex], 10);
            var Year = parseInt(SplitValue[YearIndex], 10);
            if (OK = (Year > 1900)) {
                if (OK = (Month <= 12 && Month > 0)) {
                    var LeapYear = (((Year % 4) == 0) && ((Year % 100) != 0) || ((Year % 400) == 0));
 
                    if (Month == 2) {
                        OK = LeapYear ? Day <= 29 : Day <= 28;
                    }
                    else {
                        if ((Month == 4) || (Month == 6) || (Month == 9) || (Month == 11)) {
                            OK = (Day > 0 && Day <= 30);
                        }
                        else {
                            OK = (Day > 0 && Day <= 31);
                        }
                    }
                }
            }
        }
        return OK;
    }
    catch (e) {
        return false;
    }
}

function updateSearchedBirimTable(arrayToPut)
{
	var oTableMS = jQuery('#BagimsizBirimEkle_SearchGrid').dataTable();

	oTableMS.fnClearTable();
	for(var i=0; i<arrayToPut.length; i++)
    {
    	var a = oTableMS.fnAddData( [
    	                         	
'<td><input onclick="" type="checkbox" value="'+arrayToPut[i]["BIRIM_ID"]+'" class="BirimlerCheckbox" name="BirimlerCheckbox[]" id="BirimlerCheckbox'+i+'"></td>',
'<td>'+arrayToPut[i]["BIRIM_KODU"]+'</td>',
'<td>'+arrayToPut[i]["BIRIM_ADI"]+'</td>',
'<td>'+arrayToPut[i]["BIRIM_SEVIYE"]+'</td>',
'<td>-</td>',
'<td>-</td>'

      ]);
    }   
}

function deleteBirimRow ( oTable, nRow)
{
	
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();

	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');

	sendData.push(obj);

	var protokolID = document.getElementById("protokolID").value;
	
	oTable.fnDeleteRow( nRow );
	oTable.fnDraw();
	
	
}
function editBirimRow ( oTable, nRow, isSave )
{
	inputChanged=true;
	
  var aData = oTable.fnGetData(nRow);
  var jqTds = jQuery('>td', nRow);

  if(aData[0]=="")
  {		
	  //jqTds[1].innerHTML = '<input class="required" size="10" value="'+aData[1]+'" type="text" name="BirimAdi" />';// onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" 
	  jqTds[2].innerHTML = '<input maxLength="10" size="10" class="required" value="'+aData[2]+'" type="text" name="BirimYayinTarihi"/>';
	  //jqTds[5].innerHTML = '<input class="required" size="10" value="'+aData[5]+'" type="text" name="BirimKodu" />';// onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" 
	  //jqTds[6].innerHTML = '<input class="required" size="10" value="'+aData[6]+'" type="text" name="BirimKodu" />';// onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" 
	  //jqTds[7].innerHTML = '<input class="required" size="10" value="'+aData[7]+'" type="text" name="BirimRevizyon" />';// onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" 

  	  //jQuery('input[name=BirimYayinTarihi]').datepicker({ });
	
	  //--------------------------------------
	  jqTds[3].innerHTML = "<select class='seviyeSelect'><?php echo $seviyelerText; ?></select>" ;
	  var seviyeSelect = jQuery('.seviyeSelect', nRow);
	  seviyeSelect.val(aData[3]);	
	  //----------------------------------
  

    }


  
  

  //-----------------------------------
  var zorunluSelected, secmeliSelected;
  if(aData[6]=="Zorunlu")
  {
	  zorunluSelected = " selected ";
	  secmeliSelected = "";
  }
  else
  {
	  zorunluSelected = "";
	  secmeliSelected = " selected ";
  }  
  jqTds[6].innerHTML = '<select class="zorunluSecmeliSelect"><option value="Zorunlu" '+zorunluSelected+'>Zorunlu</option><option value="Seçmeli" '+secmeliSelected+'>Seçmeli</option></select>';// onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" 
  //-----------------------------------
  
  if (!isSave)
  	jqTds[7].innerHTML = '<a class="editBirim"><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelBirim" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
  else
  	jqTds[7].innerHTML = '<a class="saveBirim"><?php echo JText::_("SAVE_TEXT");?></a>';
	
}




jQuery('.birimSeviyesiSelect, .zorunluSecmeliSelect').live("change", function (e) {
	updateBirimKodlari(e);
	
});

function updateBirimKodlari(e)
{
	var zorunluCount = 0;
	var secmeliCount = 0;
	var belirsizCount = 0;

	
	
	var tableRowsArray = jQuery('#EklenmisBirimlerGrid tbody tr');
	for(var i=0; i<tableRowsArray.length; i++)//her row için
	{
		var biriminKodu = '';
		var birimSeviyesiValue = tableRowsArray[i].getChildren()[3].getChildren().getValue();

		biriminKodu += jQuery('#yeterlilikKoduHiddenField').val();
		biriminKodu += '-'
		biriminKodu += birimSeviyesiValue;//jQuery('#yeterlilikSeviyesiHiddenField').val();
		biriminKodu += '/';

		var birimZorunluluguValue = tableRowsArray[i].getChildren()[6].getChildren().getValue();

		//birim Seviyesi <Select> elementi varsa bu birim bu yeterliliğindir, yani kodu update edilebilir
		if(tableRowsArray[i].getChildren()[3].getChildren().length > 0)
		{
			if(birimZorunluluguValue=="0")//Seçmeli
			{
				biriminKodu += 'B';
				secmeliCount++;
				biriminKodu += secmeliCount;
			}
			else if(birimZorunluluguValue=="1")//Zorunlu
			{
				biriminKodu += 'A';
				zorunluCount++;
				biriminKodu += zorunluCount;
			}
			else //Belirsiz(-1)
			{
				biriminKodu += ' ';
				belirsizCount++;
				biriminKodu += belirsizCount;
			}

			var birimKoduIndex = 1;
			tableRowsArray[i].getChildren()[birimKoduIndex].innerHTML = biriminKodu;
			//oTableBirim.fnUpdate(biriminKodu, i, birimKoduIndex, true, true);

		}

		
		
	}

	jQuery('#zorunluBirimlerCountHiddenField').val(zorunluCount);
	jQuery('#secmeliBirimlerCountHiddenField').val(secmeliCount);
	jQuery('#belirsizBirimlerCountHiddenField').val(belirsizCount);
		
}


<?php 
if($_GET['popup']!='')
echo "jQuery('#biriminDetaylariPopupDiv-".$_GET['popup']."').lightbox_me({
		centered: true,
		});
";
?>


</script>
