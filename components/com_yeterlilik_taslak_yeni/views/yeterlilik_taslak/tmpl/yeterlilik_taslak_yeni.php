<script type="text/javascript">
	jQuery.blockUI();
	jQuery(window).load(function() {
		jQuery.unblockUI();
	})
</script>
<?php
$yeterlilikList = $this->yeterlilikList;
$yeterlilikBilgi = $this->yeterlilikBilgi;
$taslakYeterlilik = $this->taslakYeterlilik;

$yet_bilgi = $this->yeterlilik_bilgi;
$rev_bilgi = $this->revizyon_bilgi;
$revizyonlar=$this->revizyonListesi;
$gelistiren_kurulus = $this->gelistiren_kurulus;
$birimTur = $this->birimTur;

$kayitliBirimTur = $this->kayitliBirimTur;

$seviyeler = $this->seviyeler;
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

$bagimliBirimlerOlanSektorler = $this->bagimliBirimlerOlanSektorler;
$bagimliBirimlerOlanSektorlerText = "";
for($i=0; $i<count($bagimliBirimlerOlanSektorler); $i++)
{
	$bagimliBirimlerOlanSektorlerText .= "<option value='".$bagimliBirimlerOlanSektorler[$i]["SEKTOR_ID"]."' ".$selected.">".$bagimliBirimlerOlanSektorler[$i]["SEKTOR_ADI"]."</option>";
}

$eklenmisBirim = $this->eklenmisBirim;
$birim_zorunlulukOpt = array('-1' => '-','0'=>'Seçmeli','1'=>'Zorunlu');

$alternatif = $this->alternatif;
$altdata = $alternatif['data'];
$altBirims = $alternatif['birims'];


$zorunluBirim = $this->zorunluBirim;
$secmeliBirim = $this->secmeliBirim;
$sinavsizBirim = $this->sinavsizBirim;

$birims = '';
foreach ($zorunluBirim as $cow){
	$birims .= '<input type="checkbox" checked="checked"  disabled value="'.$cow['BIRIM_ID'].'"/> '.$cow['BIRIM_KODU'].'-'.$cow['BIRIM_ADI'].'<br>';
}
foreach ($secmeliBirim as $cow){
	$birims .= '<input type="checkbox" name="Birims[]" value="'.$cow['BIRIM_ID'].'"/> '.$cow['BIRIM_KODU'].'-'.$cow['BIRIM_ADI'].'<br>';
}

foreach ($sinavsizBirim as $cow){
	$birims .= $cow['BIRIM_KODU'].'-'.$cow['BIRIM_ADI'].'<em style="color: red; font-size: 10px;">  (İlgili birime ait sınav bilgileri bulunamadı !)</em><br>';
}

$ref_kodu=$yet_bilgi["YETERLILIK_KODU"];
$revize_no=$yeterlilikBilgi["REVIZYON_NO"]; 

$user = & JFactory::getUser();
$user_id= $user->getOracleUserId ();
$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);

// Yeterlilik birim düzenleme ve silme yetkilerini düzenler
// Alternatif düzenleme ve silme yetkilerini düzenler
if(($yeterlilikBilgi['YETERLILIK_DURUM_ID'] == PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK) && ($user_id == "40")){
	$edit = true;
}else if(($yeterlilikBilgi['YETERLILIK_DURUM_ID'] == PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK) && ($user_id <> "40")){
	$edit = false;
}else{
	$edit = true;
}

if ($this->canEdit){
	$edit = true;
}

?>
<style>
@CHARSET "UTF-8";
#navigation {
    width:250px;
}

#content {
    width:700px;
}

#navigation,
#content {
    float:left;
    margin:10px;
}

.collapsible,
.page_collapsible {
    margin: 0;
    padding:10px;
    height:20px;

    border-top:#f0f0f0 1px solid;

	background:url(templates/paradigm_shift/images/title_arrow_green.png) no-repeat #cdcdcd scroll 15px 12px;
    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-transform:uppercase;
    color: #000;
    font-size:1em;
}

.collapsible em{
	padding: 0 0 0 25px; 
}
.collapse-open {
    background:url(templates/paradigm_shift/images/title_arrow.png) no-repeat #1C617C scroll 15px 12px;
    color: #fff;
}

.collapse-open span {
    display:block;
    float:right;
    padding:10px;
}

.collapse-open span {
    background:url(images/minus_white.png) center center no-repeat;
}

.collapse-close span {
    display:block;
    float:right;
    background:url(images/plus_green.png) center center no-repeat;
    padding:10px;
}

div.container {
    padding:0;
    margin:0;
}

div.content {
    background:#fafafa;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}

div.content ul, div.content p {
    margin:0;
    padding:3px;
}

div.content ul li {
    list-style-position:inside;
    line-height:25px;
}

div.content ul li a {
    color:#555555;
}

code {
    overflow:auto;
}
.form_item{
	padding: 5px 0 5px 0;
}
.form_item input{
	float:none;
}
</style>
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

function birimDetaylarinaSinavEkle (birimID, sinavTipi, sinavAciklamasi, soruSayisi, basariKriteri, minDakika, minSaniyesi, maxDakika, maxSaniyesi , soruSayisiMax, basariKriteriAciklama, sinavID, sinavAdi, yenimi,sinavGecerlilikSuresiName,sinavGecerlilikSuresi,edit)
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
				+   '<br>'+(edit == 'true' ? '<input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input>' : '')+'</td>'
				+	'<td>'
				+ 	'<strong>SINAV ADI</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+'" style="width:400px;" name="'+sinavAdiName+'[' + newRowID + ']" value="'+sinavAdi+'"></input>'
				+ 	'<br><strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea class="ciftTirnaksiz" style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi.replace(/<BR\/>/gi, '\n')+'</textarea>'
				+ 	'<strong>SINAV GECERLİLİK SÜRESİ</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+' numeric" style="width:400px;" maxlenght="1" name="'+sinavGecerlilikSuresiName+'[' + newRowID + ']" value="'+sinavGecerlilikSuresi+'"></input>'

				+ 	(yenimi == '1' ? '<br><strong>SORU SAYISI</strong><br>'
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
				+ 	'<strong>%</strong><input type="text" class="'+basariKriteriClass+'" style="width:50px;" name="'+basariKriteriName+'[' + newRowID + ']" value="'+basariKriteri+'"></input>' : '')
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
				+   '<br>'+(edit == 'true' ? '<input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input>' : '')+'</td>'
				+	'<td>'
				+ 	'<strong>SINAV ADI</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+'" style="width:400px;" name="'+sinavAdiName+'[' + newRowID + ']" value="'+sinavAdi+'"></input>'
				+ 	'<br><strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea class="ciftTirnaksiz" style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi.replace(/<BR\/>/gi, '\n')+'</textarea>'
				+ 	'<strong>SINAV GECERLİLİK SÜRESİ</strong><br>'
				+ 	'<input type="text" class="ciftTirnaksiz '+sinavAdiClass+' numeric" style="width:400px;" maxlenght="1" name="'+sinavGecerlilikSuresiName+'[' + newRowID + ']" value="'+sinavGecerlilikSuresi+'"></input>'
				+ 	(yenimi == '1' ? '<br><strong>BAŞARI KRİTERİ</strong><br>'
				+ 	'<strong>%</strong><input type="text" class="'+basariKriteriClass+'" style="width:50px;" name="'+basariKriteriName+'[' + newRowID + ']"  value="'+basariKriteri+'"></input>'
				+ 	'<br><strong>BAŞARI KRİTERİ AÇIKLAMASI</strong><br>'
				+ 	'<strong></strong><input type="text" class="ciftTirnaksiz '+basariKriteriAciklamaClass+'" style="width:150px;" name="'+basariKriteriAciklamaName+'[' + newRowID + ']"  value="'+basariKriteriAciklama+'"></input>' : '')
				+	'</td>'
				+ 	'</tr>');

			
			
	}
	else	
	{	
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
		+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  /*+ newRowID*/ + '<br>'
		+ 	(edit == 'true' ? '<input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input>' : '')+'</td>'
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
<form
<?php 
$task = "task=taslakKaydetYeni";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">
	<input type="hidden" name="typetaslak" value="1" />
<div class="page_container">
	<?php echo $this->pageTree;?>
	<div id="accordion_container" style="float:left; width:99%; margin-top:20px;">
		<div class="collapsible" id="section1"><em>Temel Bilgiler</em><span></span></div>
		<div class="container">
		    <div class="content">
		        <div class="form_element cf_heading">
					<a href="http://tuikapp.tuik.gov.tr/DIESS/SozlukDetayiGetirAction.do?surumId=210&ustKod=yok&duzey=0" target="_blank">ISCO 08 Uluslararası Standart Meslek Sınıflaması</a>
				</div>
				<div class="form_item">
					<div class="form_element cf_placeholder">
						<div id="standart_div"></div>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Referans Kodu:</label>
				    <input class="cf_inputbox" maxlength="150" size="20" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>
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
						$data = $this->pm_YETERLILIK_SUREC_DURUM;
					  } else {
					  	$data = $this->pm_YETERLILIK_REVIZYON_SUREC_DURUM;
					  }
						?>
						<label class="cf_label" style="width:150px;"><?php if ($revize_no!="00"){?>Revizyon<?php } else {?>Yeterlilik<?php }?> Durumu:</label>
						<select id="revizyon_durum" class="cf_inputbox" name="revizyon_durum" title="" size="1" firstoption="1" firstoptiontext="Seçiniz" onchange="checkYeterlilikDurum(this)" <?php echo ($this->sektorSorumlusu && $edit == "true" ? "" : "disabled"); ?>>
							<option value="">Seçiniz</option>
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
				<?php 
				}
				?>	
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">İlk Yayın Tarihi:</label>
				    <input class="cf_inputbox date" maxlength="150" size="10"  <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>
				    	id="yayin_tarihi" name="yayin_tarihi" type="text" value="<?php echo $yeterlilikBilgi["YAYIN_TARIHI"];?>" />
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
					  <div class="form_element cf_textbox">
					    <label class="cf_label" style="width: 150px;">Onay Tarihi / Sayısı</label>
					    <input class="cf_inputbox date" maxlength="150" size="10" id="onay_tarih" name="onay_tarih" type="text" value="<?php echo  $yeterlilikBilgi['KARAR_TARIHI'];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?> /> /    
					  	<input class="cf_inputbox" maxlength=10 size="6" id="onay_sayi" name="onay_sayi" type="text" value="<?php echo $yeterlilikBilgi['KARAR_SAYI'];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?> />
					  	<em style="color: red; font-size: 10px;">Revizyon ise revizyon onay tarihi girilmelidir !</em>
					  </div>
					  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Görüşe Gönderilme Tarihi:</label>
				    <input class="cf_inputbox date" maxlength="150" size="10"  
				    	id="goruse_cikma_tarihi" name="goruse_cikma_tarihi" type="text"   value="<?php echo $taslakYeterlilik["GORUSE_CIKMA_TARIHI"];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>/>
				  	</div>
				  <div class="cfclear">&nbsp;</div>
				</div>	
				<div class="form_item">
				  <div class="form_element cf_textbox" style="margin-left:32px;">
				    <input type="checkbox" name="belge_zorunluluk_durum" id="belge_zorunluluk_durum" value="1" style="float:left;" <?php echo ($yeterlilikBilgi['BELGE_ZORUNLULUK_DURUM'] == "1" ? "checked='checked'" : "");?> <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>/>
				    <label class="cf_label" style="margin: 0 0 0 10px; line-height: 13px;">Yeterlilik belge zorunluluğu getirilmiş işler sınıfındadır.</label>    
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox" style="margin-left:32px;">
				    <input type="checkbox" name="tehlikeli_is_durum" id="tehlikeli_is_durum" value="1" style="float:left;" <?php echo ($yeterlilikBilgi['TEHLIKELI_IS_DURUM'] == "1" ? "checked='checked'" : "");?> <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>/>
				    <label class="cf_label" style="margin: 0 0 0 10px; line-height: 13px;">Yeterlilik tehlikeli ve çok tehlikeli işler sınıfındadır.</label>    
				  </div> 
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Geliştiren Kuruluş(lar):</label>
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				<div class="form_element cf_placeholder">
					<div>
					<table id="gelistirenKurulusTable" style="width:100%;">
					<thead>
						<tr style="background-color:#E8E8E8;">
							<th width="5%">Sıra No</th>
							<th width="40%">Kuruluş Adı</th>
							<th width="10%">İlk Geliştiren</th>
							<th width="10%">Revizyon</th>
							<th width="3%">Sil?</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(count($gelistiren_kurulus) <= 0){
							echo "<tr id='emptytablegelistiren'><td colspan='6'><center><p>Geliştiren kuruluş bulunamadı !</p></center></td></tr>";
						}else{
							for($i=0; $i<count($gelistiren_kurulus); $i++){
								if($i%2==1) $rowClass='tablo_row'; else $rowClass = 'tablo_row2';
								if($gelistiren_kurulus[$i]["ILK_GELISTIRME_YAPAN"]=='1') $ilkGelistirenChecked = ' checked="checked" '; else  $ilkGelistirenChecked = ' '; 
								if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]=='1') $revizeYapanChecked = ' checked="checked" '; else  $revizeYapanChecked = ' ';
								if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]!='1') $revizeNoTextboxReadOnlyVal = ' readonly="readonly" '; else  $revizeNoTextboxReadOnlyVal = ' ';
								
								
								if($ulusalOlmus==true)
									$ilkGelistirenReadOnly = ' disabled="disabled" ';
								else
									$ilkGelistirenReadOnly = ' ';
									
								echo '<tr class="'.$rowClass.'" style="padding:5px 0 5px 0;">';
								echo '<td width="5%">'.($i+1).'</td>';
								echo '<td width="40%"> <input type="text" name="inputkurulus-2[]" value="'.$gelistiren_kurulus[$i]["YETERLILIK_KURULUS_ADI"].'" class="required"  style="width:100%;"  /> </td>';
								echo '<td width="10%"> <input type="checkbox" name="inputkurulus-3-'.($i+1).'" style="margin-left:40%;" '.$ilkGelistirenChecked.' '.$ilkGelistirenReadOnly.' class="ilkGelistiren"></td>';
								echo '<td width="10%"> <input type="checkbox" name="inputkurulus-4-'.($i+1).'" style="margin-left:40%;" '.$revizeYapanChecked.' class="revizyon"><br></td>';
								echo '<td width="3%"><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>';
								echo '</tr>';
								
							}
						}
						?>
					</tbody>
					</table>
					<input style="float:left; height: 20px;" type="text" id="satirSayisiTextbox" size="3" value="1" ><input style="float:left;" class="yeniKurulusEkleButton" type="button" value="Adet Satır Ekle">
					</div>
				</div>
				<div class="cfclear">&nbsp;</div>
			</div>
			<?php if($this->yeterlilik_duzenleme_yetki){?>
				<input type="button" value="Kaydet" id="save_section1" />	
			<?php }?>
		    </div>
		</div>
		<div class="collapsible" id="section6"><em>Değerlendirici Ölçütleri</em><span></span></div>
		<div class="container">
		    <div class="content">
		    	<div class="form_item">
					<div class="form_element cf_textarea"> 
						<label class="cf_label" style="width: 150px;">Değerlendirici Ölçütleri:</label>
						<textarea class="cf_inputbox" rows="5" id="degerlendirici_olcut" title="" cols="70" name="degerlendirici_olcut"><?php echo $taslakYeterlilik['DEGERLENDIRICI_OLCUT'];?></textarea>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<?php if($this->yeterlilik_duzenleme_yetki){?>
				<input type="button" value="Kaydet" id="save_section6" />
				<?php }?>
			</div>
		</div>
		<div class="collapsible" id="section2"><em>Belgelendirme Kriterleri</em><span></span></div>
		<div class="container">
		    <div class="content">
		     	<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Belge Geçerlilik Süresi(Yıl):</label>
				    <input class="cf_inputbox" maxlength="150" size="20"
				    	id="gecerlilik" name="gecerlilik" type="text" value="<?php echo $taslakYeterlilik['YETERLILIK_GECERLILIK_SURE'];?>" />
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Gözetim Sıklığı:</label>
				    <textarea class="cf_inputbox" rows="5" id="gozetim" title="" cols="70" name="gozetim"><?php echo $taslakYeterlilik['YETERLILIK_METHOD_GOZETIM'];?></textarea>
				 </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
					<div class="form_element cf_textarea"> 
						<label class="cf_label" style="width: 150px;">Sınavsız belge yenileme yapılabilinir mi?</label>
						<br/>
						<input type="radio" name="sinavsiz_belge" id="sinavsiz_belge" value="1" <?php echo ($taslakYeterlilik["SINAVSIZ_BELGE_YENILEME"] == "1" ? "checked" : "");?>/>Evet
						<input type="radio" name="sinavsiz_belge" id="sinavsiz_belge" value="0" <?php echo ($taslakYeterlilik["SINAVSIZ_BELGE_YENILEME"] == "0" ? "checked" : "");?> />Hayır
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
					<div class="form_element cf_textarea"> 
						<label class="cf_label" style="width: 150px;">Belge Yenilemede Uygulanacak Ö.D. Yöntemleri:</label>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
					<div class="form_element cf_textarea"> 
						<textarea class="cf_inputbox" rows="5" id="degerlendirme_yontem" title="" cols="70" name="degerlendirme_yontem" style="margin:-75px 0 0 158px;"><?php echo $taslakYeterlilik['YETERLILIK_DEG_YONTEM'];?></textarea>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<?php if($this->yeterlilik_duzenleme_yetki){?>
				<input type="button" value="Kaydet" id="save_section2" />
				<?php }?>
		    </div>
		</div>
		<div class="collapsible" id="section3"><em>Birimler</em><span></span></div>
		
		<div class="container">
		    <div class="content">
		       <div class="adv-table">
		       	  <?php if($edit == "true"){ ?>
					  <input type="button" id="addnewrow" value="Yeni Birim"/>
					  <input type="button" id="addnewexistingrow" value="Varolan Birim Ekle"/>
				   <?php } ?>
				  <div style="display: none; border: 1px solid #1C617C ; padding-left: 40px; padding-bottom:10px; margin-bottom:15px; padding-top: 10px; padding-right:10px; width: 90%; float: left;"
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
							<table id="BagimsizBirimEkle_SearchGrid" class="display compact table table-hover table-bordered table-striped" name="BagimsizBirimEkle_SearchGrid" style="display:none; width: 100%; float:left;">
								<thead>
									<tr>
										<th>#</th>
										<th>Birim Kodu</th>
										<th>Birim Adı</th>
										<th>Birim Seviyesi</th>
									</tr>
								</thead>
							</table>
						</div>
				
						
						<div style="float:left; width:100%">
						<input id="BagimsizBirimEkle_EkleButton" name="BagimsizBirimEkle_EkleButton" type="button" style="display:none;" value="EKLE"></input>
						</div>
				
				
					</div>
<?php 
	echo  '<input type="hidden" id="yeterlilikKoduHiddenField" value="'.$yeterlilikBilgi["YETERLILIK_KODU"].'"></input>';
	echo  '<input type="hidden" id="yeterlilikSeviyesiHiddenField" value="'.$yeterlilikBilgi["SEVIYE_ID"].'"></input>';
	echo  '<input type="hidden" id="zorunluBirimlerCountHiddenField" value="0"></input>';
	echo  '<input type="hidden" id="secmeliBirimlerCountHiddenField" value="0"></input>';
	echo  '<input type="hidden" id="belirsizBirimlerCountHiddenField" value="0"></input>';
	echo  '<input type="hidden" id="ogrenmeCiktisiCounterHiddenField" value="1"></input>';	
?>
				  <table id="birimlist" class="display compact table table-hover table-bordered table-striped" width="100%">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="10%">Birim Kodu</th>
								<th width="20%">Birim Adı</th>
								<th width="10%">Birim Seviyesi</th>
								<th width="20%">Yeterlilik Adı</th>
								<th width="10%">Yeterlilik Seviyesi</th>
								<th width="10%">Seçmeli/Zorunlu</th>
								<th width="15%">İşlem</th>
								<th width="15%">Sıra</th>
							</tr>
						</thead>
						<tbody id="birimler">
				  <?php $i = 1;
				  		foreach ($eklenmisBirim as $birim){
							$bagimsizMiText = ($birim["BAGIMSIZMI"]=="1") ? "Bağımsız" : "-";
							$bagimliOlduguYeterliliginAdi = $birim["BAGIMLI_OLDUGU_YETERLILIK_ADI"];
							$bagimliOlduguYeterliliginSeviyesi = $birim["BAGIMLI_OLDUGU_YET_SEVIYE_ID"];
							$editable = false;
							if($_REQUEST["yeterlilik_id"] == $birim["BAGIMLI_OLDUGU_YET_ID2"])//KENDI BIRIMIYSE
							{
								$editable = true;
								
								if($birim['YENI_MI'] ==1){
									$yeterlilikBirimSeviyesiSelectText = "<select style='width:110px;' class='birimSeviyesiSelect' name='birimSeviyesi-".$birim["BIRIM_ID"]."' >";
									for($seviyeCounter=0; $seviyeCounter<count($seviyeler); $seviyeCounter++ ){
										if($birim["BIRIM_SEVIYE"] == $seviyeler[$seviyeCounter]["SEVIYE_ID"] )
											$selected = " selected ";
										else
											$selected = "";
										
										$yeterlilikBirimSeviyesiSelectText .= "<option ".$selected." value='".$seviyeler[$seviyeCounter]["SEVIYE_ID"]."'>".$seviyeler[$seviyeCounter]["SEVIYE_ADI"]."</option>";
									}
									$yeterlilikBirimSeviyesiSelectText.="</select>";
								}else{
									$yeterlilikBirimSeviyesiSelectText = " - ";
								}
							}else{
								$editable = false;
								$yeterlilikBirimSeviyesiSelectText = $seviyeler[($birim["BIRIM_SEVIYE"] - 1)]["SEVIYE_ADI"];
							}
							
							($birim["ZORUNLU"]=="1") ? $zorunluOptSelected = " SELECTED " :  $zorunluOptSelected = " ";
							($birim["ZORUNLU"]=="0") ? $secmeliOptSelected = " SELECTED " :  $secmeliOptSelected = " ";
							($birim["ZORUNLU"]=="-1") ? $belirsizOptSelected = " SELECTED " :  $belirsizOptSelected = " ";
							
							$yeterlilikZorunlulukSelectText = "<select style='width:110px;' class='zorunluSecmeliSelect' name='zorunluSecmeliSelect-".$birim["BIRIM_ID"]."' >";
							$yeterlilikZorunlulukSelectText .= '<option '.$zorunluOptSelected.' value="1">Zorunlu</option>';
							$yeterlilikZorunlulukSelectText .= '<option '.$secmeliOptSelected.' value="0">Seçmeli</option>';
							$yeterlilikZorunlulukSelectText .= '<option '.$belirsizOptSelected.' value="-1">-</option>';
							$yeterlilikZorunlulukSelectText .="</select>";
							
							if($birim['BIRIM_PROTECH'] == true){
								
							}
							?>
							<tr>
								<td><?php echo $birim['BIRIM_ID'];?></td>
								<td><?php echo ($birim['BIRIM_KODU'] == "" ? " - " : $birim['BIRIM_KODU']);?></td>
								<td><?php echo $birim['BIRIM_ADI'];?></td>
								<td><?php echo $yeterlilikBirimSeviyesiSelectText;?></td>
								<td><?php echo $bagimliOlduguYeterliliginAdi;?></td>
								<td><?php echo ($birim["BAGIMLI_OLDUGU_YET_SEVIYE_ID"]!="") ? $seviyeler[($bagimliOlduguYeterliliginSeviyesi - 1)]["SEVIYE_ADI"] : $bagimsizMiText;?></td>
								<td><?php echo $yeterlilikZorunlulukSelectText;?></td>
								<td><span><input type="hidden" class="yenimi" value="<?php echo $birim["YENI_MI"];?>" /></span>
									<?php if($editable == true){ ?>
									<a href="javascript:void(0);" class="updaterow"><img src="images/updatebutton.png" /></a>  
									<?php } ?>
									<?php if($edit == true){ ?>
									<a href="javascript:void(0);" class="deleterow"><img src="images/recyclebin.png" /></a>
									<?php }?>
								</td>
								<?php if($i == 1){ ?>
									<td><a href="javascript:void(0);" class="uprow" style="display:none;"><img src="images/arrow_up.png"/></a>   <a href="javascript:void(0);" class="downrow"><img src="images/arrow_down.png"/></a></td>
								<?php }else if($i == count($eklenmisBirim)){?>
									<td><a href="javascript:void(0);" class="uprow"><img src="images/arrow_up.png"/></a>   <a href="javascript:void(0);" class="downrow" style="display:none;"><img src="images/arrow_down.png"/></a></td>
								<?php }else{?>
									<td><a href="javascript:void(0);" class="uprow"><img src="images/arrow_up.png"/></a>   <a href="javascript:void(0);" class="downrow"><img src="images/arrow_down.png"/></a></td>
								<?php }?>
							</tr>
						<?php 
							$i++;
						} ?>
						</tbody>
					</table>
				</div>
				 <div style="clear: both;"></div>
				 <?php if($this->yeterlilik_duzenleme_yetki){?>
				 <input type="button" value="Kaydet" id="save_section3" />
				 <?php }?>
		    </div>
		</div>
		<div class="collapsible" id="section4"><em>Birim Gruplandırma Alternatifleri</em><span></span></div>
		<div class="container">
		    <div class="content">
		    	<div style="margin-bottom:10px">
			        <p>Aşağıdaki alanlardan seçim yapılmaması durumunda belge hak edilmesi için zorunlu birimlerin alınmasının yeterli olacağı varsayılacaktır.</p>
		        </div>
		        <label>Belge hak edilmesi için;</label><br>
		        <label><input type="radio" name="radioAlter" value="radioNewNum">Gerekli minimum seçmeli birim sayısını girmek istiyorum</label><br>
		        <label><input type="radio" name="radioAlter" value="radioNewAlter">Gruplandırma alternatiflerini birimleri seçerek belirlemek istiyorum</label>  
		    	<div id="radioNewNum" style="display: none;">
				    <hr style="margin-top:10px">
				    <form id="AltEkleNum" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">
				            <div style="padding:5px 5px 5px 0;">
					            <div style="float:left;">
						            <strong>Belge verilmesi için gereken minumum seçmeli birim sayısı:</strong> 
						            <input type="text" id="altsay" name="altSay"/>
						            <input type="hidden" name="altTipi" value="1"/>
					            </div>
					            <div style="margin:-1px 0 0 5px; float:left;">
						       <!-- <img src="images/save_button.png" id="saveMinBirimCount" alt="Kaydet" style="width:18px;" /> 
						            <img src="images/delete_button.png" id="deleteMinBirimCount" alt="Sil" style="width:18px;" />
						         -->       
						            <input type="button" id="KayAltNum" value="Kaydet"/>
						            <input type="button" id="deleteNum" value="Sil"/> 
					            </div>    
				            </div> 
				    </form> 
				</div>
				<div id="radioNewAlter" style="display: none;">
				    <?php if($edit == "true"){ ?>
				    	<hr style="margin-top:10px">
				    	<a href="#" id="addAlt">Yeni Alternatif Ekle</a>
				    <?php } ?> 
				    <div id="alterAdd" style="display:none">
				            <form id="AltEkle" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">
				                    <strong>Alternatif Adı:</strong> <input type="text" id="altname" name="altName"/><br>
				                    <strong>Birimler:</strong>
				                            <div id="Birims" style="margin-left:30px;">
				                                    <?php echo $birims;?>
				                            </div>
				                    <input type="hidden" name="altTipi" value="2"/>
				                    <input type="button" id="KayAlt" value="Kaydet"/>
				            </form> 
					</div><hr style="margin-top:10px;">
				</div>
				<div id="Alters" style="margin-top:10px">
					<?php foreach ($altdata as $cow){
						echo '<div id="'.$cow['ALTERNATIF_ID'].'"><div id="AltUp">
							<strong>Alternatif Adı:</strong> '.$cow['ALTERNATIF_ADI'].'<br>
							<strong>Birimler:</strong> ';
						$ss = count($altBirims[$cow['ALTERNATIF_ID']]);
						if( $ss > 0){
							foreach ($zorunluBirim as $pow){
								echo $pow['BIRIM_KODU'].',';
							}
							$row = 1;
							foreach ($altBirims[$cow['ALTERNATIF_ID']] as $tow){
								if($ss != $row){
									echo $tow['BIRIM_KODU'].',';
								}
								else{
									echo $tow['BIRIM_KODU'];
								}
								$row++;
							}
						}
						else{
							$row = 1;
							$ss = count($zorunluBirim);
							foreach ($zorunluBirim as $pow){
								if($ss != $row){
									echo $pow['BIRIM_KODU'].',';
								}
								else{
									echo $pow['BIRIM_KODU'];
								}
								$row++;
							}
						}
						if ($edit == "true"){
							echo '<br><a href="#" id="update">Güncelle</a> | <a href="#" id="delete">Sil</a><hr></div></div>';
						}
					}?>
				</div>
		    </div>
		</div>
		<?php 
		if ($revize_no=="00"){
			$path2 = FormFactory::normalizeVariable ($this->yeterlilik_bilgi["RESMI_GORUS_ONCESI_PDF"]);
			$path3 = FormFactory::normalizeVariable ($this->yeterlilik_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
			$path4 = FormFactory::normalizeVariable ($this->yeterlilik_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
			$path5 = FormFactory::normalizeVariable ($this->yeterlilik_bilgi["SON_TASLAK_PDF"]); //3
		} else {
			$path2 = FormFactory::normalizeVariable ($this->revizyon_bilgi["RESMI_GORUS_ONCESI_PDF"]);
			$path3 = FormFactory::normalizeVariable ($this->revizyon_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
			$path4 = FormFactory::normalizeVariable ($this->revizyon_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
			$path5 = FormFactory::normalizeVariable ($this->revizyon_bilgi["SON_TASLAK_PDF"]); //3
		
		}
		?>
		<div class="collapsible" id="section5"><em>Versiyonlar</em><span></span></div>
		<div class="container">
		    <div class="content">
		    	<!-- 
		    	<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 225px;">Kurulusun ilk taslağı:</label>
				    <div><?php echo FormFactory::getNormalFilename(basename  ($path2));?></div><br/>
				    <input type="hidden" value="<?php echo path2; ?>" name="path_0_1" />
					<input type="hidden" value="" name="filename_0_1">	
				  	<input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&amp;id=1&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $_GET[revize_no];?>\';" class="up_submitbtn" style="float:none;">
					<input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=sil&amp;id=1&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $revize_no;?>\';" class="up_submitbtn" style="float:none;">
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 225px;">Resmi görüşe sunulan taslak:</label>
				    <div><?php echo FormFactory::getNormalFilename(basename  ($path3));?></div><br/>
				    <input type="hidden" value="<?php echo path3; ?>" name="path_0_2" />
					<input type="hidden" value="" name="filename_0_2">
				  	<input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&amp;task=indir&amp;id=2&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $_GET[revize_no];?>\';" class="up_submitbtn" style="float:none;">
    				<input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&amp;task=sil&amp;id=2&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $revize_no;?>\';" class="up_submitbtn" style="float:none;">
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 225px;">Sektör komitesine sunulan taslak:</label>
				    <div><?php echo FormFactory::getNormalFilename(basename  ($path4));?></div><br/>
				     <input type="hidden" value="<?php echo path4; ?>" name="path_0_3" />
					<input type="hidden" value="" name="filename_0_3">
				  	<input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&amp;id=3&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $_GET[revize_no];?>\';" class="up_submitbtn" style="float:none;">
					<input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=sil&id=3&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $revize_no;?>\';" class="up_submitbtn" style="float:none;">
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 225px;">Yönetim kuruluna sunulan taslak:</label>
				    <div><?php echo FormFactory::getNormalFilename(basename  ($path5));?></div><br/>
				    <input type="hidden" value="<?php echo path5; ?>" name="path_0_4" />
					<input type="hidden" value="" name="filename_0_4">
				    <input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&amp;id=4&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $_GET[revize_no];?>\';" class="up_submitbtn" style="float:none;">
					<input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=sil&amp;id=4&yeterlilik_id=<?php echo $this->yeterlilik_id;?>&revize_no=<?php echo $revize_no;?>\';" class="up_submitbtn" style="float:none;">
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				   <label class="cf_label" style="width: 225px;">Yayınlanmış yeterlilik:</label>
				   <input type="file" name="yayinlanmis_yeterlilik" />
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<input type="button" value="Kaydet" id="save_section3" />
	        </div>
	         -->
	        <div class="form_item">
				<div class="form_element cf_placeholder">
					<div id="taslakPdf_div"></div>
				</div>
				<div class="cfclear">&nbsp;</div>
			</div>
			<?php if($this->yeterlilik_duzenleme_yetki){?>
			<input type="button" value="Kaydet" id="save_section5" />
			<?php }?>	
		</div>
	</div>
</div>
<div class="yeniBirimEklePopupDiv" id="yeniBirimEklePopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:325px; height:85px; display:none; background-color: white;">
			
	<div style="width:50%; float:left;">Adı:</div>
	<div style="width:49%; float:right; vertical-align: middle;"><input class="required" style="float:right; width:145px;" id="yeniBirimEklePopup_BirimAdiTextBox" name="yeniBirimEklePopup_BirimAdiTextBox" type="text"></input>
	</div>
	
	<div style="display:none; width:50%; float:left;">Birim Kodu(Referans Kodu):</div>
	<div style="display:none; width:49%; float:right; vertical-align: middle;"><input style="float:right; width:145px;" id="yeniBirimEklePopup_ReferansKoduTextBox" name="yeniBirimEklePopup_ReferansKoduTextBox" type="text"></input>
	</div>
	
	<div style="width:50%; float:left;">Seviye:</div>
	<div style="width:49%; float:right; vertical-align: middle;">
		<select style="float:right; width:147px;" id="yeniBirimEklePopup_SeviyeTextBox" name="yeniBirimEklePopup_SeviyeTextBox">
	 		<?php 
	 		for($i=0; $i<count($seviyeler); $i++){
	 			echo "<option value='".$seviyeler[$i]["SEVIYE_ID"]."' ".$selected.">".$seviyeler[$i]["SEVIYE_ADI"]."</option>";
	 		}?>
	 	</select>
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
	
	<div style="width:30%; float:right; padding-left:35%; padding-top:10px;">
		<input type="button" value="EKLE" name="yeniBirimEklePopup_EkleButton" id="yeniBirimEklePopup_EkleButton" />
		<input type="button" value="İPTAL" id="yeniBirimEklePopup_EkleButtonIptal" />
	</div>
	
</div>
<div class="yerineGecerliBirimPanel" id="yerineGecerliBirimPanel" style="border: 1px solid #00A7DE; padding: 10px; width:325px; height:85px; display:none; background-color: white;">		
	<div style="width:50%; float:left;">Yeterlilik Adı:</div>
	<div style="width:49%; float:left;">
		<select id="yerinegecerlibirim_yeterlilik" name="yerinegecerlibirim_yeterlilik" style="width: 163px;">
			<option>Seçiniz</option>
			<?php foreach ($yeterlilikList as $val){?>
			<option value="<?php echo $val['YETERLILIK_ID']?>"><?php echo $val['YETERLILIK_BILGISI']?></option>
			<?php }?>
		</select>
	</div>
	<div style="width:50%; float:left;">Yeterlilik Birimleri:</div>
	<div style="width:49%; float:left;">
		<select id="yerinegecerlibirim_birim" name="yerinegecerlibirim_birim" style="width: 163px;">
			<option>Seçiniz</option>
		</select>
	</div>
	<div style="float:right; margin:20px;">
		<input type="hidden" name="aktifbirim" />
		<input id="yerineGecerliBirimPanelSecButton" value="SEÇ" type="button">
		<input id="yerineGecerliBirimPanelIptalButton" value="İPTAL" type="button" style="margin-left:10px;">
	</div>
</div>
	<div style="float:left; width:100%;" class="biriminDetaylariPopupDiv" id="biriminDetaylariPopupDiv"> 
	<?php  
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
					$birimGecerlilikSuresiText = $eklenmisBirim[$i]["BIRIM_GECERLILIK_SURESI"];
				}
				else
				{
					$birimKoduInputText = '<input style="width:500px;" name="birimDetayiPopup-BirimKodu-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_KODU"].'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimSeviyesiInputText = '<input style="width:500px;" class="numberInput" name="birimDetayiPopup-BirimSeviyesi-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_SEVIYE"].'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimKredisiInputText = '<input style="width:500px;" name="birimDetayiPopup-BirimKredisi-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_KREDI"].'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimYayinTarihiInputText = '<input style="width:500px;" class="datepicker" name="birimDetayiPopup-BirimYayinTarihi-'.$birimID.'" type="text" value="'.str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_YAYIN_TAR"]).'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimRevizyonNoInputText = '<input style="width:500px;" class="numberInput" name="birimDetayiPopup-BirimRevizyonNo-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_REV_NO"].'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimRevizyonTarihiInputText= '<input style="width:500px;" class="datepicker" name="birimDetayiPopup-BirimTarihi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_REV_TAR"]) .'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimMYKYonetimKuruluOnayTarihiInputText= '<input style="width:100px; float:left;" class="datepicker" name="birimDetayiPopup-MYKYKOnayTarihi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_TAR"]) .'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimMYKYonetimKuruluOnaySayisiInputText= '<input style="width:100px; float:left;" namek="birimDetayiPopup-MYKYKOnaySayi-'.$birimID.'" type="text" value="'. str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_SAYI"]) .'" '.($edit == false ? "disabled='disabled'" : "").'/>';
					$birimGecerlilikSuresiText =  '<input style="width:500px;" class="numeric" maxlength="1" name="birimDetayiPopup-BirimGecerlilikSuresi-'.$birimID.'" type="text" value="'.$eklenmisBirim[$i]["BIRIM_GECERLILIK_SURESI"].'" '.($edit == false ? "disabled='disabled'" : "").'/>';
				}
				
				if($eklenmisBirim[$i]['YENI_MI'] == 1){
					$display = "";
				}else{
					$display = "style='display:none;'";
				}
				echo '<input type="hidden" name="gorevlerinIDleri[]" value="'.$birimID.'"></input>';
				echo '<div id="biriminDetaylariPopupDiv-'.$birimID.'" '.$popupStyle.'>';
				echo '<input type="hidden" name="yenimi" id="yenimi" value="'.$eklenmisBirim[$i]['YENI_MI'].'"></input>';
				echo '<div style="background-color:#1C617C; color:#FFF; height:45px; line-height:40px; padding:0 0 0 10px; margin: -11px -10px 0 -11px;"><strong>'.$eklenmisBirim[$i]["BIRIM_ADI"].' Yeterlilik Birimi </strong></div><br>';
				echo '<div style="height:500px; overflow:auto;">';
					
				echo '<table id="birimDetayiIlkTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
				<tr>
				<td class="blueBackgrounded" style="width:30px">1</td>
				<td class="blueBackgrounded">YETERLİLİK BİRİMİ ADI</td>
				<td style="width:500px;">
					<input style="width:500px;" name="birimAdiTextbox" id="birimAdiTextbox-'.$birimID.'" value="'.$eklenmisBirim[$i]["BIRIM_ADI"].'" >
				</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded" style="width:30px">2</td>
				<td class="blueBackgrounded">REFERANS KODU</td>
				<td>'.$birimKoduInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded" style="width:30px">3</td>
				<td class="blueBackgrounded">SEVİYE</td>
				<td>'.$birimSeviyesiInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded" style="width:30px">4</td>
				<td class="blueBackgrounded">KREDİ DEĞERİ</td>
				<td>'.$birimKredisiInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded" rowspan="3"  style="width:30px">5</td>
				<td class="blueBackgrounded">A)YAYIN TARİHİ</td>
				<td>'.$birimYayinTarihiInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded">B)REVİZYON NO</td>
				<td>'.$birimRevizyonNoInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded">C)REVİZYON TARİHİ</td>
				<td>'.$birimRevizyonTarihiInputText.'</td>
				</tr>
				<tr '.$display.'>
				<td class="blueBackgrounded" style="width:30px">6</td>
				<td class="blueBackgrounded">BİRİM GEÇERLİLİK SÜRESİ</td>
				<td>'.$birimGecerlilikSuresiText.'</td>
				</tr>	
				</tbody></table>';
					
				echo '<table  id="birimDetayiIkinciTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>';
					echo '<tr>
					<td class="blueBackgrounded" style="width:30px">8</td>
					<td class="blueBackgrounded">ÖLÇME VE DEĞERLENDİRME</td>
					</tr>
					<tr id="teorikSinavlarRow-0"  class="teorikSinavlarRow"><td class="blueBackgrounded" class="" colspan="2">8 a) Teorik Sınav '.($edit == true ? '<input type="button" value="EKLE" id="teorikSinavEkleButton-'.$birimID.'" class="teorikSinavEkleButton sinavEkleButton" ></input>' : '').'</td></tr>';
					
					
					
					echo '<tr id="performansSinavlariRow-0" class="performansSinavlariRow"><td class="blueBackgrounded" class="" colspan="2">8 b) Performansa Dayalı Sınav '.($edit == true ? '<input type="button" value="EKLE" id="performansSinaviEkleButton-'.$birimID.'" class="performansSinaviEkleButton sinavEkleButton" ></input>' : '').'</td></tr>';
						
										
					echo '<tr id="digerSinavlarRow-0" class="digerSinavlarRow" '.$display.' ><td class="blueBackgrounded" class="" colspan="2">8 c) Ölçme ve Değerlendirmeye İlişkin Diğer Koşullar '.($edit == true ? '<input type="button" value="EKLE" id="digerSinavEkleButton-'.$birimID.'" class="digerSinavEkleButton sinavEkleButton" ></input>' : '').'</td></tr>';
					//türler tr
					echo '<tr id="altTurlerrow-0" class="altTurlerRow" '.$display.'>
							<td class="blueBackgrounded" class="" colspan="2">8 d) Ölçme ve Değerlendirmeye İlişkin Tür Koşulları
							'.($edit == true ? '<input type="button" value="Tür Alternatifi Ekle" id="SinavTurEkleButton-'.$birimID.'" class="SinavTurEkleButton" />' : '').'<br/> <i>Tür alternatiflerini düzenleyebilmeniz için sınav türlerini kaydetmiş olmanız gerekmektedir.</i>
							</td>
						 </tr>';
					//türler tr
					
					foreach($kayitliBirimTur[$birimID] as $till){
						$turler = '';
						foreach($till as $fill){
							$turler .= $fill['BIRIM_TUR'].$fill['BIRIM_NUMARA'].',';
						}
						$turEkle ='<tr><td>'.($edit == true ? '<input type="button" value="SİL" class="KayitliTurSilButton" id="KayitliTurSilButton-'.$fill['ALTERNATIF_TUR_ID'].'">' : '').'</td><td>';
						$turEkle .= $turler;
						$turEkle .='</td></tr>';
						
						echo $turEkle;
					}
										
					echo '<tr class="birimGelistirenKuruluslarRow" id="birimGelistirenKuruluslarRow-0" '.$display.'><td class="blueBackgrounded" style="width:30px">9</td><td class="blueBackgrounded">YETERLİLİK BİRİMİNİ GELİŞTİREN KURUM/KURULUŞ(LAR) <input type="button" value="EKLE" id="birimGelistirenKurulusEkleButton-'.$birimID.'" class="birimGelistirenKurulusEkleButton" ></input>  <input type="button" value="Yeterliliği Geliştiren Kuruluslardan Ekle" id="yeterlilikGelistirenKuruluslardanEkleButton-'.$birimID.'" class="yeterlilikGelistirenKuruluslardanEkleButton" ></input></td></tr>';
					
					$yeterliligiGelistirenKuruluslar = $this->gelistiren_kurulus;
					for($j=0; $j<count($yeterliligiGelistirenKuruluslar); $j++)
					echo '<tr class="yeterliligiGelistirenKuruluslardan darkGrayBackgrounded " style="display:none;" >
						<td colspan="2"><input class="yeterliligiGelistirenKuruluslarCheckbox" name="yeterliligiGelistirenKuruluslarCheckbox-'.$birimID.'[]" type="checkbox" value="'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'" >'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'</input></td>
					</tr>';
					
					
					$buBirimiGelistirenKuruluslarViewID = 'birimiGelistirenKuruluslar-'.$birimID;
					$buBirimiGelistirenKuruluslar = $this->$buBirimiGelistirenKuruluslarViewID;
					
					$yerineGecerliBirim = "yerineGecerliBirimList-".$birimID;
					$yerineGecerliBirimList = array();
					foreach ($this->$yerineGecerliBirim as $key => $val){
						array_push($yerineGecerliBirimList, $val['YERINE_GECERLI_BIRIM_ID']);
					}
					$buBiriminYerineGecerliBirim = implode(",",$yerineGecerliBirimList);
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
					
						echo '<tr id="birimGelistirenKuruluslarRow-'.($j).'" class="birimGelistirenKuruluslarRow">
						<td style="width:30px" class="blueBackgrounded">
							<input type="button" class="birimGelistirenKuruluslardanSilButton '.$yeterliliktenEklendi.'" id="birimGelistirenKuruluslardanSilButton-'.($j).'" value="SİL">
						</td>
						<td>
							<input type="text" value="'.$buBirimiGelistirenKuruluslar[$j]["KURULUS_ADI"].'" name="birimGelistirenKuruluslar-'.$birimID.'['.($j).']" style="width:80%;" class="birimGelistirenKuruluslar" '.$readOnly.'>
						</td>
						</tr>';
					}
					
					echo '</tbody></table>';
						
					echo '<table border="1" width="100%" cellspacing="1" '.$display.'><tbody>';
					echo '<tr style="width:100%; float:left;">
					<td class="blueBackgrounded" style="width:30px">11</td>
					<td class="blueBackgrounded" style="width:52%;">MYK Yönetim Kurulu Onay Tarihi ve Sayısı</td>
					<td style="padding-left:10px;">'.$birimMYKYonetimKuruluOnayTarihiInputText.'<div style="float:left; width:12px; text-align:center;"> - </div>'.$birimMYKYonetimKuruluOnaySayisiInputText.'</td>
					</tr>';
					echo '<tr style="width:100%;">
					<td class="blueBackgrounded" colspan="3">
					<em style="color: red; font-size: 10px;">Revizyon ise revizyon onay tarihi girilmelidir !</em>
					</td>
					</tr>';
					echo '<tr style="width:100%;">
							<td class="blueBackgrounded" colspan="2">12 Bu birim yerine geçerli kabul edilebilecek birimler
								'.($edit == true ? '<input type="button" value="EKLE" id="yerineGecerliBirimEkle-'.$birimID.'" class="yerineGecerliBirimEkleButton" birimID="'.$birimID.'" ></input>' : '').'
							</td>
						  </tr>';
					echo '<tr style="width:100%;">
							<td class="blueBackgrounded" colspan="2">
								<input type="text" name="yerineGecerliBirim-'.$birimID.'" id="yerineGecerliBirim-'.$birimID.'" style="'.($buBiriminYerineGecerliBirim=="" ? "display:none;" : "").' width:100%;" value="'.$buBiriminYerineGecerliBirim.'" '.($edit == false ? "disabled='disabled'" : "").'/>
							</td>
						  </tr>';
					echo '</tbody></table>';
					
					
					
					echo '</div>';
					echo '<div style="background-color:#1C617C; color:#FFF; height:35px; line-height:35px; padding:0 0 0 10px; margin: 0 -10px -11px -11px;">
	 						<div style="float:right; width:%20; margin:10px 20px 0 0;">';
					if ($this->canEdit || $this->yeterlilik_duzenleme_yetki){
						echo '<input class="popupuKaydetButton" id="popupuKaydetButton-'.$birimID.'" value="KAYDET" type="button" >';
					}
					echo '<input class="popupuIptalButton" id="popupuIptalButton-'.$birimID.'" value="İPTAL" type="button" style="margin-left:10px;">';
					echo '</div>
					</div>';
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
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "T", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminTeorikSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI"].'", "'.$buBiriminTeorikSinavlari[$j]["BASARI_KRITERI"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_DK"].'",  "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_DK"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI_MAX"].'", "",  "'.$buBiriminTeorikSinavlari[$j]["ID"].'",  "'.$buBiriminTeorikSinavlari[$j]["OLC_DEG_ADI"].'", "'.$buBiriminTeorikSinavlari[$j]["YENI_MI"].'","buBiriminTeorikSinavlariGecerlilikSuresi", "'.$buBiriminTeorikSinavlari[$j]["OLC_DEG_GECERLILIK_SURESI"].'","'.$edit.'"); ';
					}
								
					for($j=0; $j<count($buBiriminPerformansSinavlari); $j++)
					{
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "P", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminPerformansSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI"].'","","","","","", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI_ACIKLAMA"].'", "'.$buBiriminPerformansSinavlari[$j]["ID"].'", "'.$buBiriminPerformansSinavlari[$j]["OLC_DEG_ADI"].'", "'.$buBiriminTeorikSinavlari[$j]["YENI_MI"].'","buBiriminPerformansSinavlariGecerlilikSuresi", "'.$buBiriminPerformansSinavlari[$j]["OLC_DEG_GECERLILIK_SURESI"].'","'.$edit.'"); ';
							
					}
						
					$buBiriminDigerSinavlariViewID = 'biriminDigerSinavlari-'.$birimID;
					$buBiriminDigerSinavlari = $this->$buBiriminDigerSinavlariViewID;
					for($j=0; $j<count($buBiriminDigerSinavlari); $j++)
					{
						echo 'birimDetaylarinaSinavEkle ('.$birimID.', "D", "'.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminDigerSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "", "",  "", "", "", "","", "'.$buBiriminDigerSinavlari[$j]["ID"].'", "", "'.$buBiriminDigerSinavlari[$j]["YENI_MI"].'","buBiriminDigerSinavlariGecerlilikSuresi", "'.$buBiriminDigerSinavlari[$j]["OLC_DEG_GECERLILIK_SURESI"].'","'.$edit.'"); ';
						
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
</form>
<script>
	jQuery(document).ready(function(){
// 		jQuery(".navpage").hide();
// 		jQuery('input[value="Tümünü Göster"]').hide();
// 		jQuery('input[value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun"]').removeAttr('disabled');
// 		jQuery(".navpage").closest("div").css("height","30");
		jQuery("#onay_tarih").mask("99/99/9999");
		jQuery("#yayin_tarihi").mask("99/99/9999");
		jQuery("#goruse_cikma_tarihi").mask("99/99/9999");
 		jQuery("#gecerlilik").mask("9");
 		jQuery(".numeric").mask("9");
// 		jQuery("#gozetim").mask("999");

		var altdata = <?php echo json_encode($altdata);?>;
		var altBirims = <?php echo json_encode($altBirims);?>;
		var zorunlu = <?php echo json_encode($zorunluBirim);?>;
		var secmeli = <?php echo json_encode($secmeliBirim);?>;

		if(jQuery("#Alters div:not(#AltUp)").length > 0){
			jQuery("input[name=radioAlter][value=radioNewAlter]").trigger('click');
			jQuery("input[name=radioAlter][value=radioNewNum]").parent().hide();
			jQuery("input[name=radioAlter][value=radioNewAlter]").parent().hide();
			jQuery("input[name=radioAlter][value=radioNewNum]").parent().parent().find('label:first').hide();
			jQuery("#radioNewAlter").show();
		}
		if(parseInt(altdata)){
			jQuery('#altsay').val(altdata);
		}
		if(jQuery("#altsay").val() != ""){
			jQuery("input[name=radioAlter][value=radioNewNum]").trigger('click');
			jQuery("input[name=radioAlter][value=radioNewNum]").parent().hide();
			jQuery("input[name=radioAlter][value=radioNewAlter]").parent().hide();
			jQuery("input[name=radioAlter][value=radioNewNum]").parent().parent().find('label:first').hide();
			jQuery("#deleteNum").show();
			jQuery("#radioNewNum").show();
		}else{
			jQuery("#deleteNum").hide();
		}
		 jQuery('.collapsible').collapsible({
            defaultOpen: 'section1'
         });
		 jQuery("#onay_tarih,#yayin_tarihi,#goruse_cikma_tarihi").datepicker({
	            changeYear: true,
	            changeMonth: true
	     });
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
		 var yeniUretilmisBirimIDCounter = 0;
		 var options = new Array();
		 options['id'] = "birimlist";
		 options['paging'] = false;
		 var oTableBirim = Datatable_bootstrap.init(options);
		 
		 jQuery("#addnewrow").click(function(){
			 jQuery('#yeniBirimEklePopupDiv').lightbox_me({
	        	centered: true,
	        	closeClick:false,
	        	closeEsc:false,
	         });
	     });

		 jQuery(".yerineGecerliBirimEkleButton").live("click",function(e){
			 jQuery('#yerineGecerliBirimPanel  input[name=aktifbirim]').val(jQuery(this).attr('birimID'));
			 jQuery('#yerineGecerliBirimPanel').lightbox_me({
		        	centered: true,
		        	closeClick:false,
		        	closeEsc:false,
		         });
		 });
		 jQuery("#yerinegecerlibirim_yeterlilik").live("change",function(e){
				jQuery.ajax({
					  url: "index.php?option=com_yeterlilik_taslak_yeni&task=ajaxYeterliliginBirimleriniGetir&format=raw&yeterlilikID="+jQuery(this).val(),
					  type: "POST",
					  dataType: 'json',
					  beforeSend:function(){
							 jQuery.blockUI();
			 		  },
					  success: function(data) {
						  if(data['success']){
							  jQuery("#yerinegecerlibirim_birim").html("");
							  jQuery.each( data['array'], function( key,val ) {
								  jQuery("#yerinegecerlibirim_birim").append("<option value='"+val['BIRIM_ID']+"'>"+val['BIRIM_BILGISI']+"</option>");
							  });
						  }else{
							  jQuery("#yerinegecerlibirim_birim option[value]").remove();
						  }
					  },
					  complete : function (){
							jQuery.unblockUI();
			          }
				});	
		 });
		 jQuery("#yerineGecerliBirimPanelSecButton").live("click",function(e){
			aktifbirim = jQuery('#yerineGecerliBirimPanel  input[name=aktifbirim]').val();
			jQuery("#yerineGecerliBirim-"+aktifbirim).show();
			val = (jQuery("#yerineGecerliBirim-"+aktifbirim).val() != "" ? jQuery("#yerineGecerliBirim-"+aktifbirim).val()+"," : "");
			if(jQuery("#yerineGecerliBirim-"+aktifbirim).val() != ""){
				chosed = jQuery("#yerineGecerliBirim-"+aktifbirim).val().split(",");
			}else{
				chosed = new Array();
			}

			if(jQuery.inArray( jQuery("#yerinegecerlibirim_birim option:selected").val(), chosed ) == -1){
				jQuery("#yerineGecerliBirim-"+aktifbirim).val(val+jQuery("#yerinegecerlibirim_birim option:selected").val());
				jQuery("#yerinegecerlibirim_yeterlilik").val('');
				jQuery("#yerinegecerlibirim_yeterlilik").trigger('change');
			 	jQuery('#yerineGecerliBirimPanel').trigger("close");
			}else{
				alert("Yerine geçerli birim seçimi daha önce yapılmıştır.Lütfen farklı bir birim seçiniz !");
			}
		});
		
		 jQuery('.KayitliTurSilButton').live('click',function(e){
		 	var altTur = jQuery(this).attr('id');
		 	var turId = altTur.split('-');
		 	jQuery('#'+altTur).closest('tr').remove();
		 	jQuery.ajax({
		 		asycn:false,
		 		type:"POST",
		 		url:"index.php?option=com_yeterlilik_taslak_yeni&task=alternatifTurSil&format=raw",
		 		data:"alterTurId="+turId[1],
		 		success:function(data){
		 			var dat = jQuery.parseJSON(data);
		 			if(dat == 1){
		 				alert('Tür koşulu başarıyla silindi.');
		 				window.location.reload();
		 			}else{
		 				alert('Tür koşulunu silerken bir hata meydana geldi. Lütfen tekrar deneyiniz.');
		 			}
		 		}
		 	});
		 });
		
		 jQuery("#yerineGecerliBirimPanelIptalButton").live("click",function(e){
			jQuery("#yerinegecerlibirim_yeterlilik").val('');
			jQuery("#yerinegecerlibirim_yeterlilik").trigger('change');
		 	jQuery('#yerineGecerliBirimPanel').trigger("close");
		 });
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
							 alert("Birim detayları başarıyla kaydedildi !");
							 window.location = window.location.href+'&popup='+birimID;
						  }
						  else
						  {
							alert("Kaydetmede hata, "+data['array']);
						  }
			 
					  }
				});

				
			});
		 jQuery(".popupuIptalButton").click(function(){
			jQuery("#yerineGecerliBirimPanelIptalButton").trigger('click');
			jQuery('#'+jQuery(this).attr('id')).trigger('close');
	     });
	     jQuery(".uprow").live('click',function(){
	    	 	var index = jQuery(this).parents("tr").index();
	    	    if ((index-1) >= 0) {
	    	        var data = oTableBirim.fnGetData();
	    	        oTableBirim.fnClearTable();
	    	        data.splice((index-1), 0, data.splice(index,1)[0]);
	    	        oTableBirim.fnAddData(data);
	    	    }
// 	    	    updateBirimKodlari(oTableBirim);
	    	    jQuery(".uprow").show();
		    	 jQuery(".downrow").show();
		    	 jQuery(".uprow:first").hide();
		    	 jQuery(".downrow:first").show();
		    	 jQuery(".uprow:last").show();
		    	 jQuery(".downrow:last").hide();
		 });
	     jQuery(".downrow").live('click',function(){
	    	  var index = jQuery(this).parents("tr").index();
		   	    if ((index+1) >= 0) {
		   	        var data = oTableBirim.fnGetData();
			   	 	oTableBirim.fnClearTable();		   	     	
		   	        data.splice((index+1), 0, data.splice(index,1)[0]);
		   	     	oTableBirim.fnAddData(data);
		   	    }
// 		   	 updateBirimKodlari(oTableBirim);
		   	 jQuery(".uprow").show();
	    	 jQuery(".downrow").show();
	    	 jQuery(".uprow:first").hide();
	    	 jQuery(".downrow:first").show();
	    	 jQuery(".uprow:last").show();
	    	 jQuery(".downrow:last").hide();
		 });
		 jQuery(".updaterow").live('click',function(){
			 selectedBirimId = jQuery(this).closest('tr').find("td:eq(0)").html();
			 jQuery('#biriminDetaylariPopupDiv-'+selectedBirimId).lightbox_me({
			        centered: true,
			        closeClick:false,
			     	closeEsc:false  
			        });
	     });
		 jQuery(".deleterow").live('click',function(){
			 if(confirm('Bu birimi silmek istediğinizden emin misiniz?')){
				 var nRow = jQuery(this).parents('tr')[0];
				 oTableBirim.fnDeleteRow(nRow);
				 jQuery("#save_section3").trigger('click');
			 }
	     });

		 jQuery('#yeniBirimEklePopup_EkleButtonIptal').live('click',function(e){
			jQuery('#yeniBirimEklePopupDiv').trigger('close');
		 });
		 jQuery('#yeniBirimEklePopup_EkleButton').click(function(){
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
						                             		"<td><a class='deleteBirim' href='javascript:void(0);'><img src='images/recyclebin.png' /></a></td>",
						                             		"<td><a href='javascript:void(0);' class='uprow'><img src='images/arrow_up.png'/></a>   <a href='javascript:void(0);' class='downrow' style='display:none;'><img src='images/arrow_down.png'/></a></td>"
					                             		]);
					setUpDownButtons("birimlist");
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

//					jQuery('#biriminDetaylariPopupDiv').append( returnEmptyPopupData(yeniUretilmisBirimIDCounter, birimAdi));

					updateBirimKodlari(oTableBirim);
					
					var satirSayisi = jQuery('#birimlist tbody tr').length;
					for(var i=0; i<satirSayisi; i++)
						jQuery(jQuery('#birimlist tbody tr')[i].getChildren()[9]).html((i+1));
					  
				}
		 });	
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
				birimDetaylarinaSinavEkle (birimID, sinavIdentifier, "", "", "", "", "", "", "", "", "", "", "",jQuery(this).closest('biriminDetaylariPopupDiv-'+birimID).find('#yenimi').val(),"","","");
			});	 

		 jQuery('.birimGelistirenKurulusEkleButton').live("click",  function (e) {
				var ekleButtonName = 'birimGelistirenKurulusEkleButton';
				var popupIDsi = this.id.substr(ekleButtonName.length+1);
				BirimGelistirenKurumKuruluslaraEkle('', popupIDsi, false);
			});
		 jQuery('.yeterlilikGelistirenKuruluslardanEkleButton').live('click', function (e) {
				var ekleButtonClass = 'yeterlilikGelistirenKuruluslardanEkleButton';
				var popupNumber = this.getId().substr(ekleButtonClass.length+1);
				var popupName = 'biriminDetaylariPopupDiv';
				var hiddenRowsClass = 'yeterliligiGelistirenKuruluslardan';
				jQuery('#'+popupName+'-'+popupNumber+' .'+hiddenRowsClass).toggle("slow");
			}); 
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
		jQuery("#addnewexistingrow").click(function(){
			jQuery('#bagimsiz_birim_wrapper').toggle("slow");
		});   
		jQuery('#BagimliBirimEkle_SektorSelect').change( function (e) {
			BagimliBirimEkleValuesChanged_Sektor();
			return false;
		});
		jQuery('#BagimliBirimEkle_SeviyeSelect').change( function (e) {
			BagimliBirimEkleValuesChanged();
			return false;
		});

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
		        	var bagimliOlanYeterliliginAdi = jQuery("#BagimliBirimEkle_YeterlilikSelect  option:selected").text();//this.getParent().getParent().cells[4].innerHTML; 
		        	var bagimliOlanYeterliliginSeviyesi = jQuery("#BagimliBirimEkle_SeviyeSelect  option:selected").text();//this.getParent().getParent().cells[5].innerHTML; 

		        	var birimZorunlulugu = "Zorunlu"; //Defaultta zorunlu		
		        	var guncelleButtonText = '<a class="editBirim">Güncelle</a>';
		        	var zorunluSelectText = '<select name="zorunluSecmeliSelect-'+birimID+'" class="zorunluSecmeliSelect" style="width:110px;"><option value="1">Zorunlu</option><option value="0">Seçmeli</option><option value="-1" selected="selected">-</option></select>';
					var silButtonText = '<a class="deleterow" href="">Sil</a>'
		        	var sirayaTasiTextbox = '<input type="text" class="sirayaTasiTextbox" style="width:50px;">';
		        	
		        	oTableBirim.fnAddData ([birimID, birimKodu, birimAdi, birimSeviyesi, "Bağımsız", bagimliOlanYeterliliginSeviyesi, zorunluSelectText, silButtonText,"<td><a href='javascript:void(0);' class='uprow'><img src='images/arrow_up.png'/></a>   <a href='javascript:void(0);' class='downrow' style='display:none;'><img src='images/arrow_down.png'/></a></td>"]);
		        	setUpDownButtons("birimlist");
			    	}
			});
			
			if(ekliDegerCiktiMi == true)
				alert("Seçili Birimler Arasında Önceden Eklenmiş Birimler Var, Diğer Birimler Başarıyla Eklendi");
			
			// Stop event handling in IE
			return false;
		});

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

		});	

		jQuery('input:radio[name="radioAlter"]').change(function(e){
	       e.preventDefault();
	       if(jQuery(this).val() == 'radioNewNum'){
	           jQuery('#radioNewAlter').hide('slow');
	           jQuery('#radioNewNum').show('slow');
	       }
	       else if(jQuery(this).val() == 'radioNewAlter'){
	           jQuery('#radioNewNum').hide('slow');
	           jQuery('#radioNewAlter').show('slow');
	       }
	       
	    });	
	    
		jQuery('#addAlt').live('click',function(e){
			e.preventDefault();
			var altupId = jQuery('#updateAlt').parent('div').attr('id');
			jQuery('div#'+altupId).children('#AltUp').show();
			jQuery('#updateAlt').remove();
			jQuery('#alterAdd').show('slow');
			jQuery('#addAlt').attr('id','alterHide');
		});

		jQuery('#alterHide').live('click',function(e){
			e.preventDefault();
			jQuery('#alterAdd').hide('slow');
			jQuery('#altname').val('');
			jQuery('#Birims').html('');
			jQuery('#Birims').html('<?php echo $birims;?>');
			jQuery('#alterHide').attr('id','addAlt');
		});

		jQuery('#Guncelle').live('click',function(e){
			e.preventDefault();
			var altId = jQuery(this).closest('#updateAlt').parent('div').attr('id');
			if(jQuery('div#'+altId+' div#updateAlt #form_'+altId).children('#altname').val() == '' ){
				alert('Lütfen Alternatif Adı Girniz.');
			}
			else{
				data = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+'&'+jQuery('#form_'+altId).serialize();
				saveSection('section4',data);
			}
		});
		
		// güncelleme iptal
		jQuery('#iptal').live('click',function(e){
			e.preventDefault();
			var altId = jQuery(this).closest('#updateAlt').parent('div').attr('id');
			jQuery('div#'+altId).children('#updateAlt').remove();
			jQuery('div#'+altId).children('#AltUp').show();
		});
		jQuery('#delete').live('click',function(e){
			e.preventDefault();
			var altId = jQuery(this).closest('#AltUp').parent('div').attr('id');
			if(confirm('Bu alternatifi silmek istediğinizden emin misiniz?')){
				data = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+'&altId='+altId+'&delete='+2;
				saveSection('section4',data);
			}
		});

		 jQuery('#deleteNum').live('click',function(e){
	           e.preventDefault();
	           if(confirm('Bu alternatifi silmek istediğinizden emin misiniz?')){
	        	    data = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+'&delete='+1;
					saveSection('section4',data);
	            }
	        });

		jQuery('#KayAlt').live('click',function(e){
			e.preventDefault();

			if(jQuery('#altname').val() == '' ){
				alert('Lütfen Alternatif Adı Girniz.');
			}
			else{
				data = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+'&'+jQuery('form#AltEkle').serialize();
				saveSection('section4',data);
			}
		});

		jQuery('#AltUp #update').live('click',function(e){
			e.preventDefault();
			var altupId = jQuery('#updateAlt').parent('div').attr('id');
			jQuery('div#'+altupId).children('#AltUp').show();
			jQuery('#updateAlt').remove();
			var altId = jQuery(this).closest('#AltUp').parent('div').attr('id');
			var zor = '';
			var sec = '';
			jQuery.each(zorunlu,function(key,vall){
				zor +='<input type="checkbox" checked="checked"  disabled value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
			});
			jQuery.each(secmeli,function(key,vall){
				if(typeof altBirims[altId][vall['BIRIM_ID']] == 'undefined'){
					sec +='<input type="checkbox" name="Birims[]" value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
				}
				else{
					sec += '<input type="checkbox" name="Birims[]" checked="checked" value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
				}
				
			});
			var ekle = '<div id="updateAlt">'+
				'<form id="form_'+altId+'" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">'+
				'<strong>Alternatif Adı:</strong> <input type="text" id="altname" name="altName" value="'+altdata[altId]['ALTERNATIF_ADI']+'"/><br>'+
					'<strong>Birimler:</strong>'+
					'<div id="Birims" style="margin-left:30px;">'+
					zor+sec+
					'</div>'+
					'<input type="hidden" name="altId" value="'+altId+'" />'+
					'<input type="hidden" name="upGun" value="1"/>'+
					'<a href="#" id="Guncelle">Kaydet</a> | <a href="#" id="iptal">İptal</a></form><hr></div>';
			jQuery('div#'+altId).children('#AltUp').hide();
			jQuery('div#'+altId).append(ekle);
			
		});
		jQuery("#saveMinBirimCount").click(function(){

		});
		jQuery("#deleteMinBirimCount").click(function(){

		});

		jQuery("#save_section1").click(function(){
			parameters = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+
							'&onayTarihi='+jQuery("#onay_tarih").val()+
		     				'&onaySayisi='+jQuery("#onay_sayi").val()+
						    '&yayinTarihi='+jQuery("#yayin_tarihi").val()+
						    '&goruse_cikma_tarihi='+jQuery("#goruse_cikma_tarihi").val()+
						    '&referans_kodu='+jQuery("#referans_kodu").val()+
						    '&revizyon_durum='+jQuery("#revizyon_durum").val()+
						    '&belge_zorunluluk_durum='+(jQuery("#belge_zorunluluk_durum:checked").val() ? "1" : "0")+
						    '&tehlikeli_is_durum='+(jQuery("#tehlikeli_is_durum:checked").val() ? "1" : "0")+
						   '&'+jQuery("input[name='inputstandart-2[]']").serialize()+
						  '&'+jQuery("textarea[name='inputstandart-3[]']").serialize()+
						 '&'+jQuery("input[name='inputkurulus-2[]']").serialize()+
						'&'+jQuery(".ilkGelistiren").serialize()+
						'&'+jQuery(".revizyon").serialize();
			saveSection('section1',parameters);
		});
		jQuery("#save_section2").click(function(){
			parameters = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+ 
						'&gecerlilik_suresi='+jQuery("#gecerlilik").val()+
					    '&gozetim='+jQuery("#gozetim").val()+
					  '&degerlendirme_yontem='+jQuery("#degerlendirme_yontem").val()+
					  '&sinavsiz_belge='+jQuery("#sinavsiz_belge:checked").val();
				saveSection('section2',parameters);
		});
		
		jQuery("#save_section5").click(function(){ 
			parameters = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+ 
						'&path_taslakPdf_0_1='+(jQuery("input[name=path_taslakPdf_0_1]").length > 0 ? jQuery("input[name=path_taslakPdf_0_1]").val() : "")+
						'&path_taslakPdf_0_2='+(jQuery("input[name=path_taslakPdf_0_2]").length > 0 ? jQuery("input[name=path_taslakPdf_0_2]").val() : "")+
						'&path_taslakPdf_0_3='+(jQuery("input[name=path_taslakPdf_0_3]").length > 0 ? jQuery("input[name=path_taslakPdf_0_3]").val() : "")+
						'&path_taslakPdf_0_4='+(jQuery("input[name=path_taslakPdf_0_4]").length > 0 ? jQuery("input[name=path_taslakPdf_0_4]").val() : "")+
						'&path_taslakPdf_0_5='+(jQuery("input[name=path_taslakPdf_0_5]").length > 0 ? jQuery("input[name=path_taslakPdf_0_5]").val() : "");
				saveSection('section5',parameters);
		});
		jQuery("#save_section6").click(function(){
			parameters = 'yeterlilik_id='+'<?php echo $this->yeterlilik_id;?>'+ 
						'&degerlendirici_olcut='+jQuery("#degerlendirici_olcut").val();
				saveSection('section6',parameters);
		});
		
		jQuery("#save_section3").click(function(){

			var birimRowlari = jQuery('#birimlist tbody tr');

		    var kendibirimIdArray =new Array();
		    var kendizorunluSecmeliDurumuArray = new Array();
		    var kendibirimSiraNoArray = new Array();
		    var kendibirimAdiArray = new Array();
		    var kendibirimKoduArray = new Array();
		    var kendibirimSeviyesiArray = new Array();

		    var disbirimIdArray =new Array();
		    var diszorunluSecmeliDurumuArray = new Array();
		    var disbirimSiraNoArray = new Array();
		    
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
		            var zorunluSecmeliDurumu = jQuery('[name="zorunluSecmeliSelect-'+birimID+'"]').val();
		            var birimSiraNo = (i+1);//birimRowlari[i].getChildren()[siraNoIndex].getHTML();
		            
		            if(jQuery(birimRowlari[i].getChildren()[seviyeIndex]).children().length == 0) //kendi birimi değil
		            {
		                    disbirimIdArray.push(birimID);
		        		    diszorunluSecmeliDurumuArray.push(zorunluSecmeliDurumu);
		        		    disbirimSiraNoArray.push(birimSiraNo);
				    }
		            else // kendi birimi
		            { 
		                    var birimAdi = birimRowlari[i].getChildren()[adIndex].getHTML();
		                    var birimKodu = birimRowlari[i].getChildren()[birimKoduIndex].getHTML();
		                    var birimSeviyesi = jQuery('select[name="birimSeviyesi-'+birimID+'"]').val();

		                    kendibirimIdArray.push(birimID);
		                    kendizorunluSecmeliDurumuArray.push(zorunluSecmeliDurumu);
		                    kendibirimSiraNoArray.push(birimSiraNo);
		                    kendibirimAdiArray.push(birimAdi);
		                    kendibirimKoduArray.push(birimKodu);
		                    kendibirimSeviyesiArray.push(birimSeviyesi);
		            }        
		        }
		    }

			parameters = {
					'yeterlilik_id' : '<?php echo $this->yeterlilik_id;?>',
					'kendibirimId' : kendibirimIdArray,
					'kendizorunluSecmeliDurumu' : kendizorunluSecmeliDurumuArray,
					'kendibirimSiraNo' : kendibirimSiraNoArray,
					'kendibirimAdi' : kendibirimAdiArray,
					'kendibirimKodu' : kendibirimKoduArray,
					'kendibirimSeviyesi' : kendibirimSeviyesiArray,
					'disbirimId' : disbirimIdArray,
					'diszorunluSecmeliDurumu' : diszorunluSecmeliDurumuArray,
					'disbirimSiraNo' : disbirimSiraNoArray,
					'yenimi' : birimRowlari.find('.yenimi').val()};
			saveSection('section3',parameters);
		});

		jQuery('#kurulusTopluEklemeTumunuEkleButton').click( function (e) {
			text=jQuery("#gelistirenkurulus_editarea").val();
		    text=text.replace("\r\n","\n");
		    var ek1Array=text.split("\n");
			if(ek1Array.length > 0){
				jQuery("#ek5Tablosu #emptytable").hide();
			}else{
				if(jQuery("#ek5Tablosu tbody tr").length > 0){
					jQuery("#ek5Tablosu #emptytable").hide();
				}else{
					jQuery("#ek5Tablosu #emptytable").show();
				}
			}
		    for(var i=0; i<ek1Array.length; i++)
		    {   
			    
			    var readOnlyValue = "";
				if (isReadOnly)
					readOnlyValue = ' readOnly="true" ';
				
			    
				var x = "inputkurulus-1[]";
				var rowCount = jQuery('#ek5Tablosu tbody tr:not(#emptytable)').length;
				var nextRowNumber = rowCount+1;

				satirRow = '<tr>'
					+'<td class="siraNoTD" style="text-align:center;">'+nextRowNumber+'</td>'
	                +'<td><input style="width:100%;" id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ ek1Array[i] +'"></td>' 
	                +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';

	    		if(jQuery(".dataTables_empty").length == 0)
					jQuery('#ek5Tablosu tbody').append(satirRow);
	    		else
	    		{
	    			jQuery('#ek5Tablosu tbody tr').remove();
	    			jQuery('#ek5Tablosu tbody').append(satirRow);
	    		}
			    
			//    var satirText = '<tr class="tablo_row2 even" id="tablo_kurulus_6"><td class="  sorting_1"><input type="text" id="inputkurulus-1-6" name="inputkurulus-1[]" size="4" value="6" readonly=""></td><td class=" "><input type="text" id="inputkurulus-2-6" name="inputkurulus-2[]" size="40"></td><td width="10%" class="tablo_sil_hucre "><input type="button" id="satirSil_kurulus-6" value="SİL"></td></tr>';
		   	//	jQuery('#tablo_kurulus  tbody').append(satirText);
		    }
		    jQuery("#kurulusTopluEklemeTextArea").val("");
		    jQuery("#kurulusTopluEklemeDiv").toggle("slow");

		    tabloyuDuzenle();
			return false;
		});

        jQuery('#KayAltNum').live('click',function(e){
    		e.preventDefault();
    		if(jQuery('#altsay').val() == '' ){
    			alert('Lütfen Alternatif Adı Girniz.');
    		}
    		else{
    			parameters = {
    					'yeterlilik_id' : '<?php echo $this->yeterlilik_id;?>',
    					'altSay' : jQuery("#altsay").val(),
    					'altTipi' : jQuery("input[name=altTipi]").val()};
    			saveSection('section4',parameters);
    		}
    	});
        
        jQuery('.gelistirenKurulusSilButton').live("click", function(e){

        	jQuery(this.getParent().getParent()).remove();
        	console.log(jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)'));
        	if(jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)').length == 0){
        		jQuery("#emptytablegelistiren").show();
            }
        	adjustNumbersOfTable();
        });
        jQuery('.yeniKurulusEkleButton').live("click", function(e){
			jQuery("#emptytablegelistiren").hide();
        	var eklenecekSatirlar = jQuery('#satirSayisiTextbox');

        	if(!isNaN(parseInt(jQuery('#satirSayisiTextbox').val())))
        	{
        		var count = parseInt(jQuery('#satirSayisiTextbox').val());
        		jQuery('#gelistirenKurulusTable tbody tr td.dataTables_empty').parent().remove();
        		
        		for(var i=0; i<count; i++)
        		{
        			
        			var satirCount = jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)').length + 1;
        			
        			var rowClass = "even";
        			if(satirCount%2 == 1) rowClass = "odd";
        			
        			var satir = '<tr class="'+rowClass+'">'
        			+ '<td>'+satirCount+'</td>'
        			+ '<td> <input type="text" name="inputkurulus-2[]" class="required"  style="width:100%;"  /> </td>'
        			+ '<td> <input type="checkbox" name="inputkurulus-3-'+satirCount+'" style="margin-left:40%;" <?php echo $ilkGelistirenReadOnly; ?> class="ilkGelistiren"></td>'
        			+ '<td> <input type="checkbox" name="inputkurulus-4-'+satirCount+'" style="margin-left:40%;" class="revizyon"><br></td>'
        			+ '<td style><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>'
        			+ '</tr>';

        			jQuery('#gelistirenKurulusTable tbody').append(satir);
        				
        		}
        						
        	}
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

        		var yeniyeterlilikKurulusuRowText = '<tr style="" class="yeterliligiGelistirenKuruluslardan darkGrayBackgrounded "><td colspan="2"><input type="checkbox" value="'+jQuery(textBoxItem).val()+'" name="yeterliligiGelistirenKuruluslarCheckbox-'+birimIDsi+'[]" class="yeterliligiGelistirenKuruluslarCheckbox">'+jQuery(textBoxItem).val()+'</td></tr>';
        		
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
        jQuery('.TurSilButton').live('click',function(e){
        	e.preventDefault();
        	jQuery(this).closest('tr').remove();
        	
        });

        jQuery('#birimlist a.deleteBirim').live('click', function (e) {
            e.preventDefault();
            var nRow = jQuery(this).parents('tr')[0];
            var id = nRow.id;

            jQuery("#biriminDetaylariPopupDiv-"+id).remove();
          	//Satir yeni eklenmemisse

            oTableBirim.fnDeleteRow( nRow ); 

            setUpDownButtons("birimlist");
         	// Stop event handling in IE
            return false;
        } );
        jQuery('#birimlist tbody tr td:not(:nth-child(4),:nth-child(7),:nth-child(8),:last-child)').live('click',function(){
        	selectedBirimId = jQuery(this).closest('tr').find("td:eq(0)").html();
			 jQuery('#biriminDetaylariPopupDiv-'+selectedBirimId).lightbox_me({
			        centered: true,
			        closeClick:false,
			     	closeEsc:false  
			        });
        });
	});

	function adjustNumbersOfTable()
	{
		var rows = jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)');
		for(var i=0; i<rows.length; i++)
		{
			rows[i].getChildren()[0].innerHTML = (i+1);
		}
	}
	
	dTables.taslakPdf = new Array(new Array("text","read_only", "55"), new Array("upload"));

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
			"Yayınlanmış yeterlilik"
		); //2

		for(var i=1;i<=rowCount;i++){
			var inp = document.getElementById("input"+tableName+"-1-" +i);
			inp.value = belgeAciklamalari[i-1];
			inp.setAttribute("readonly","readonly");
			<?php if(!$this->sektorSorumlusu){ ?>
			var inp_file = document.getElementById(tableName+"_0_file_" +i);
			inp_file.setAttribute("disabled","disabled");
			jQuery(".up_submitbtn").attr("disabled","disabled");
			<?php } ?>
		}
		addTaslakPdf (tableName);
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
	function userSubmit (index, yeterlilik_id){
		var form = document.ChronoContact_yeterlilik_taslak;
		if (index == 1){
			form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=sektorSorumlusunaGonder&yeterlilik_id='+yeterlilik_id;  
	    }else if (index == 2){ // Onaylanmis
	    	form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=onBasvuruBitir&yeterlilik_id='+yeterlilik_id;  
		}else if (index == 3){ // Onaylanmis Taslak Basvuru
	    	form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=basvuruBitir&yeterlilik_id='+yeterlilik_id;  
		} 
		form.submit(); 
	}
	function addTaslakPdf (tableName){
		var paths = new Array ();
		var fileNames = new Array ();
		<?php
		//$path1 = FormFactory::normalizeVariable ($yet_bilgi["ILK_TASLAK_PDF"]);
		
		$path2 = FormFactory::normalizeVariable ($yet_bilgi["RESMI_GORUS_ONCESI_PDF"]);
		$path3 = FormFactory::normalizeVariable ($yet_bilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
		$path4 = FormFactory::normalizeVariable ($yet_bilgi["YONETIM_KURULU_ONCESI_PDF"]);
		$path5 = FormFactory::normalizeVariable ($yet_bilgi["SON_TASLAK_PDF"]); //3
		$path6 = FormFactory::normalizeVariable ($yet_bilgi["YAYINLANMIS_YETERLILIK_PDF"]); //3
		
		//echo "paths[0] = '".$path1."';";
		echo "paths[0] = '".$path2."';";
		echo "paths[1] = '".$path3."';";
		echo "paths[2] = '".$path4."';";
		echo "paths[3] = '".$path5."';"; //4
		echo "paths[4] = '".$path6."';"; //4
		
		$filename2 = FormFactory::getNormalFilename(basename  ($path2));
		$filename3 = FormFactory::getNormalFilename(basename  ($path3));
		$filename4 = FormFactory::getNormalFilename(basename  ($path4));
		$filename5 = FormFactory::getNormalFilename(basename  ($path5));
		$filename6 = FormFactory::getNormalFilename(basename  ($path6));

		//echo "fileNames [0] = '".FormFactory::getNormalFilename(basename  ($path1))."';";
		echo "fileNames [0] = '".(strlen($filename2) > 10 ? substr($filename2,0,10)."....".substr($filename2,-3) : $filename2)."';";
		echo "fileNames [1] = '".(strlen($filename3) > 10 ? substr($filename3,0,10)."....".substr($filename3,-3) : $filename3)."';";
		echo "fileNames [2] = '".(strlen($filename4) > 10 ? substr($filename4,0,10)."....".substr($filename4,-3) : $filename4)."';";
		echo "fileNames [3] = '".(strlen($filename5) > 10 ? substr($filename5,0,10)."....".substr($filename5,-3) : $filename5)."';"; //5
		echo "fileNames [4] = '".(strlen($filename6) > 10 ? substr($filename6,0,10)."....".substr($filename6,-3) : $filename6)."';"; //5
		?>
		var id = tableName + "_0";
		for (var i = 0; i < 5; i++){//6
			if (paths[i] != null && paths[i] != ''){
				var sira = i+1;
				
				var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
				var inputPath = '<input type="hidden" value="'+paths[i]+'" name="path_'+tableName+'_0_'+sira +'">' +
								'<input type="hidden" value="" name="filename_'+tableName+'_0_'+sira +'">';				

				var result = inputPath + '<br><div id="success_'+tableName+'_0_'+sira+'" class="up_success">'+fileNames[i]+' yüklendi!</div><div> <input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&amp;view=taslak_revizyon&amp;task=indir&amp;id='+sira+'&amp;yeterlilik_id=<?php echo $this->yeterlilik_id;?>&amp;revize_no=<?php echo $_GET[revize_no];?>\'" class="up_submitbtn" style="float:none;"><input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_yeterlilik_taslak_yeni&amp;view=taslak_revizyon&amp;task=silYeni&amp;id='+sira+'&amp;yeterlilik_id=<?php echo $this->yeterlilik_id;?>&amp;revize_no=<?php echo $revize_no;?>\'" class="up_submitbtn" style="float:none;"></div>';
				resultDiv.innerHTML = result;
			
				var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
				uploadSpan.style.visibility = 'hidden';
				uploadSpan.style.height = 0;
			}
		}
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
	function saveSection(section,parameters){
		jQuery.ajax({
 			type: "POST",
 			dataType:"json",
 			url: "index.php?option=com_yeterlilik_taslak_yeni&task=taslakKaydetYeni&section="+section,
 			data: parameters,
 			beforeSend:function(){
 				 jQuery.blockUI();
	 		},
 			success: function(data){
 				
 			},
 			complete : function (){
 				jQuery.unblockUI();
 				window.location.reload();
             }
 		});
	}
	function tabloyuDuzenle(){
		var rowElements = jQuery('#ek5Tablosu tbody tr:not(#emptytable)');
		for(var i=0; i<rowElements.length; i++)
		{
			var classname = "even";
			if(i%2 == 1)
				classname = "odd";
				
			jQuery(rowElements[i]).attr("class", classname);
			jQuery(rowElements[i].getChildren()[0]).html(i+1);
		}		
	}
	function updateSearchedBirimTable(arrayToPut)
	{
		var options = new Array();
		 options['id'] = "BagimsizBirimEkle_SearchGrid";
		 options['paging'] = true;
		var oTableMS = Datatable_bootstrap.init(options);

		oTableMS.fnClearTable();
		for(var i=0; i<arrayToPut.length; i++)
	    {
	    	var a = oTableMS.fnAddData( [
	    	                         	
	'<td><input onclick="" type="checkbox" value="'+arrayToPut[i]["BIRIM_ID"]+'" class="BirimlerCheckbox" name="BirimlerCheckbox[]" id="BirimlerCheckbox'+i+'"></td>',
	'<td>'+arrayToPut[i]["BIRIM_KODU"]+'</td>',
	'<td>'+arrayToPut[i]["BIRIM_ADI"]+'</td>',
	'<td>'+arrayToPut[i]["BIRIM_SEVIYE"]+'</td>'

	      ]);
	    }   
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
		return result;
	}
	function updateBirimKodlari(oTableBirim)
	{
		var zorunluCount = 0;
		var secmeliCount = 0;
		var belirsizCount = 0;

		
		
		var tableRowsArray = jQuery('#birimlist tbody tr');
		for(var i=0; i<tableRowsArray.length; i++)//her row için
		{
			var biriminKodu = '';
			var birimSeviyesiValue = tableRowsArray[i].getChildren()[3].getChildren().getValue();
// 			var birimSeviyesiValue = tableRowsArray[i].getChildren()[3].innerHTML;
			biriminKodu += jQuery('#yeterlilikKoduHiddenField').val();
// 			biriminKodu += '-'
// 			biriminKodu += birimSeviyesiValue;//jQuery('#yeterlilikSeviyesiHiddenField').val();
			biriminKodu += '/';

			var birimZorunluluguValue = tableRowsArray[i].getChildren()[6].getChildren().getValue();

			//birim Seviyesi <Select> elementi varsa bu birim bu yeterliliğindir, yani kodu update edilebilir
	
			if(tableRowsArray[i].getChildren()[3].getChildren('select').length > 0)
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
// 				tableRowsArray[i].getChildren()[birimKoduIndex].innerHTML = biriminKodu;
				oTableBirim.fnUpdate(biriminKodu, i, birimKoduIndex, true, true);

			}

			
			
		}

		jQuery('#zorunluBirimlerCountHiddenField').val(zorunluCount);
		jQuery('#secmeliBirimlerCountHiddenField').val(secmeliCount);
		jQuery('#belirsizBirimlerCountHiddenField').val(belirsizCount);
			
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

	dTables.standart = new Array(new Array("text","required","4", "", readOnly),
			                       	   new Array("text","required","" , "", readOnly),	
									   new Array("textarea", "", "3","30", readOnly));

	function createTables(){
		var tableName = 'standart';
		var headers = new Array ('Sıra No', 'Uluslararası Standart Kodu', 'Açıklama');
		createTable(tableName, headers);
		patchSatirEkle(tableName, headers, tableName);
		addStandartValues (dTables.standart, tableName);

		if (isReadOnly){
			satirEkleKaldir (tableName);
			satirSilKaldir (tableName, 3);
		}

		tableName = "taslakPdf";
		createTable(tableName, new Array('Açıklama', 'PDF'));
		belgelerInit (tableName);
	}

	function addStandartValues (standart, name){
		var length = standart.length;
		var params = new Array ();
		var arr    = new Array ();
		
		for (var i = 0; i < length; i++){
			params[i] = standart[i][0];
		}
		<?php
		$tableCount = count ($this->standart);

		$c = 0;
		$id = 0;
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $this->standart[$i];
			
			echo 'arr['.$c++.']= "'. ($i+1) .'";';
			echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ADI"]) .'";';
		    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ACIKLAMA"]) .'";';
		}
		
		?>
		
		if (isset (arr))
			addTableValues (arr, params, name);
	}
	function setUpDownButtons(table_id){
		jQuery("#"+table_id+" tbody tr").each(function(index){
			if(index == 0){
				jQuery(this).find(".uprow").hide();
				jQuery(this).find(".downrow").show();
			}else if(index == (jQuery("#"+table_id+" tbody tr").length - 1)){
				jQuery(this).find(".uprow").show();
				jQuery(this).find(".downrow").hide();
			}else{
				jQuery(this).find(".uprow").show();
				jQuery(this).find(".downrow").show();
			}
		});
	}
</script>