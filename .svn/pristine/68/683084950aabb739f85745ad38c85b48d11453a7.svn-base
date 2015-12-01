<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');

?>
<script>
var seciliBirimRowID = 0;
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



function yeniBasarimOlcutuEkle2(popupIdsi, rowIDsi, basarimOlcutuText, basarimOlcutuBaglamiText )
{
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
		+ '<textarea style="width:80%; height:25px;" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-1" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]"  >'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'" id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-1" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-1" style="'+baglaminDisplayi+'">'

		
		+ 'Başarım Ölçütü Bağlamı:'
		+ '<br><textarea style="width:80%; height:25px;" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-1"  name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]">'+basarimOlcutuBaglamiText+'</textarea>'

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
		+ '<textarea id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'"  id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="'+baglaminDisplayi+'">'
		
		
		+ 'Başarım Ölçütü Bağlamı:<br>'
		+ '<textarea id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuBaglamiText+'</textarea>'

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
	KontrolListesizEk2TablosunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi);
	KontrolListeliTablolardaDropDownKodunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi);
	
	return true;
}
function yeniOgrenmeCiktisiEkle2(popupIdsi, ogrenmeCiktisiNumarasi, ogrenmeCiktisiText, ogrenmeCiktisiBaglamiText)
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
	+ 		 '<br><textarea style="width:80%; height:25px;" name="ogrenmeCiktisi['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisi-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiText+'</textarea>'

	+ 		 '<br><input type="button" style="'+baglamEkleninDisplayi+'" class="ogrenmeCiktisiBaglamiGosterButton" id="ogrenmeCiktisiBaglamiGosterButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Ekle" />'
	
	+ 		 '<div style="'+baglaminDisplayi+'" id="ogrCktBaglamiTextDiv-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
	+ 		 'Öğrenme Çıktısı Bağlamı:'
	+ 		 '<br><textarea style="width:80%; height:25px;" name="ogrenmeCiktisiBaglami['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisiBaglami-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiBaglamiText+'</textarea>'

	+ 		 '<input type="button" style="'+baglamSilinDisplayi+'" class="ogrenmeCiktisiBaglamiGizleButton" id="ogrenmeCiktisiBaglamiGizleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Sil" />'
	
	+ 		 '</div>'	
	+ 		 '<br><input type="button" class="yeniBasarimOlcutuEkleButton" id="yeniBasarimOlcutuEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Yeni Başarım Ölçütü Ekle >>">'

	
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
function yeniBasarimOlcutuEkle2(popupIdsi, rowIDsi, basarimOlcutuText, basarimOlcutuBaglamiText )
{
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
		+ '<textarea style="width:80%; height:25px;" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-1" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]"  >'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'" id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-1" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-1" style="'+baglaminDisplayi+'">'

		
		+ 'Başarım Ölçütü Bağlamı:'
		+ '<br><textarea style="width:80%; height:25px;" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-1"  name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]">'+basarimOlcutuBaglamiText+'</textarea>'

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
		+ '<textarea id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuText+'</textarea>'

		
		+ '<input style="'+baglamEkleninDisplayi+'"  id="basarimOlcutuBaglamiGosterButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="basarimOlcutuBaglamiGosterButton" type="button" value="Bağlam Ekle">'
		+ '<div id="bsrOlcBaglamiTextDiv-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="'+baglaminDisplayi+'">'
		
		
		+ 'Başarım Ölçütü Bağlamı:<br>'
		+ '<textarea id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]" style="width:80%; height:25px;">'+basarimOlcutuBaglamiText+'</textarea>'

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
	KontrolListesizEk2TablosunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi);
	KontrolListeliTablolardaDropDownKodunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi);
	
	return true;
}

function yeniOgrenmeCiktisiEkle2(popupIdsi, ogrenmeCiktisiNumarasi, ogrenmeCiktisiText, ogrenmeCiktisiBaglamiText)
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
	+ 		 '<br><textarea style="width:80%; height:25px;" name="ogrenmeCiktisi['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisi-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiText+'</textarea>'

	+ 		 '<br><input type="button" style="'+baglamEkleninDisplayi+'" class="ogrenmeCiktisiBaglamiGosterButton" id="ogrenmeCiktisiBaglamiGosterButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Ekle" />'
	
	+ 		 '<div style="'+baglaminDisplayi+'" id="ogrCktBaglamiTextDiv-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
	+ 		 'Öğrenme Çıktısı Bağlamı:'
	+ 		 '<br><textarea style="width:80%; height:25px;" name="ogrenmeCiktisiBaglami['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisiBaglami-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiBaglamiText+'</textarea>'

	+ 		 '<input type="button" style="'+baglamSilinDisplayi+'" class="ogrenmeCiktisiBaglamiGizleButton" id="ogrenmeCiktisiBaglamiGizleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Bağlam Sil" />'
	
	+ 		 '</div>'	
	+ 		 '<br><input type="button" class="yeniBasarimOlcutuEkleButton" id="yeniBasarimOlcutuEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Yeni Başarım Ölçütü Ekle >>">'

	
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

function birimDetaylarinaSinavEkle (birimID, sinavTipi, sinavAciklamasi, soruSayisi, basariKriteri, minDakika, minSaniyesi, maxDakika, maxSaniyesi , soruSayisiMax, basariKriteriAciklama, sinavID)
{
	//sinav tipi -> T(teorik), P(performans), D(Diğer)
	
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
		var basariKriteriName = 'buBiriminTeorikSinavlarininBasariKriterleri';
		var soruSayisiClass = 'numberInput';
		var minDkSoruSuresiClass = 'numberInput dakikaSpinEdit';
		var maxDkSoruSuresiClass = 'numberInput dakikaSpinEdit';
		var minSnSoruSuresiClass = 'numberInput saniyeSpinEdit';
		var maxSnSoruSuresiClass = 'numberInput saniyeSpinEdit';
		var basariKriteriClass = 'numberInput percentage';
		
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
				+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  + newRowID 
				+   '<br><input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
				+	'<td>'
				+ 	'<strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi+'</textarea>'
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
		var basariKriteriName = 'buBiriminPerformansSinavlarininBasariKriterleri';
		var basariKriteriClass = 'numberInput percentage';
		var basariKriteriAciklamaName = 'buBiriminPerformansSinavlarininBasariKriterleriAciklama';
		var basariKriteriAciklamaClass = '';
				
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
				+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  + newRowID 
				+   '<br><input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
				+	'<td>'
				+ 	'<strong>SINAV AÇIKLAMASI</strong><br>'
				+ 	'<textarea style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi+'</textarea>'
				+ 	'<br><strong>BAŞARI KRİTERİ</strong><br>'
				+ 	'<strong>%</strong><input type="text" class="'+basariKriteriClass+'" style="width:50px;" name="'+basariKriteriName+'[' + newRowID + ']"  value="'+basariKriteri+'"></input>'
				+ 	'<br><strong>BAŞARI KRİTERİ AÇIKLAMASI</strong><br>'
				+ 	'<strong></strong><input type="text" class="'+basariKriteriAciklamaClass+'" style="width:150px;" name="'+basariKriteriAciklamaName+'[' + newRowID + ']"  value="'+basariKriteriAciklama+'"></input>'
				+	'</td>'
				+ 	'</tr>');

			
			
	}
	else	
	{	
		jQuery('#birimDetayiIkinciTable-'+birimID+' tr#' + rowName + '-' + lastRowID ).after('<tr class="' + rowName + ' ' + rowClassFromID + '" id="' + rowName + '-'+newRowID +'">' 
		+	'<td class="blueBackgrounded" style="width:30px">' +sinavIdentifier  /*+ newRowID*/ + '<br>'
		+ 	'<input type="button" value="SİL" id="' + silButtonName + '-'+birimID+'-' + newRowID + '" class="' + silButtonClass + '" ></input></td>'
		+	'<td><textarea style="width:100%;" rows="3" name="' + sinavName + '[' + newRowID + ']">'+sinavAciklamasi+'</textarea></td>'
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
function KontrolListeliTablolardaDropDownKodunaBasarimOlcutunuEkle(popupIdsi, basarimOlcutuText, rowIDsi, yeniEklenecekBasariOlcutununNumarasi)
{

	var DropDownText = '<option value=\''+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'\'>'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+' : '+basarimOlcutuText+'</option>';
	
	if(jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).length==0)
		jQuery('#biriminDetaylariPopupDiv-'+popupIdsi).append('<input id="biriminKontrolListeliTablolarinaDropdown-'+popupIdsi+'" value="'+DropDownText+'" type="hidden" >');
	else
		jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).val(	jQuery('#biriminKontrolListeliTablolarinaDropdown-'+popupIdsi).val()+DropDownText);
		
	
}
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

function Ek2yeBasarimOlcutuYetkinlikEkle(birimId, yetkinlikValue, bo_text, degerlendirme_araci_text="", row_id="")
{
	jQuery('#KontrolListeliEk2Tablosu1-'+birimId+' tbody').append(

	  '<tr class="KontrolListeliEk2Tablosu1Row RowID-'+row_id+'">'
	+ '<td>'
	+ 	'<input style="width:11%; height:21px;" type="button" value="SİL" class="KontrolListeliEk2Tablosu1SilButton" />'
	+ 	'<input style="width:88%;" type="text" name="KontrolListeliEk2Tablosu1-standartBasarimOlcutu-'+birimId+'[]" value="'+bo_text+'">'
	+ '</td>'  
	+ '<td>'
	+ 	'<select style="width:100%;" class="KontrolListeliEk2Tablosu1-Select-'+birimId+'" name="KontrolListeliEk2Tablosu1-Select-'+birimId+'[]" > '+ jQuery('#biriminKontrolListeliTablolarinaDropdown-'+birimId).val() +'</select>'
	+ '</td>'
	+ '<td>'
	+ 	'<input style="width:100%;" type="text" name="KontrolListeliEk2Tablosu1-Input-'+birimId+'[]" value="'+yetkinlikValue+'" />'
	+ '</td>'
	+ '<td>'
		+ 	'<div class="KontrolListeliEk2Tablosu1-DegerlendirmeAraci_Div-'+birimId+'">'+degerlendirme_araci_text+'</div>'
	+ '</td>'
	+ '</tr>'		
	);
}
function Ek2yeBasarimOlcutuAnlayisEkle(birimId, anlayisBilgisiValue, bo_text, degerlendirme_araci_text="", row_id="")
{
	jQuery('#KontrolListeliEk2Tablosu2-'+birimId+' tbody').append(
	  '<tr class="RowID-'+row_id+'">'
	+ '<td>'
	+ 	'<input style="width:11%; height:21px;" type="button" value="SİL" class="KontrolListeliEk2Tablosu2SilButton" />'
	+ 	'<input style="width:88%;" type="text" name="KontrolListeliEk2Tablosu2-standartBasarimOlcutu-'+birimId+'[]" value="'+bo_text+'">'
	+ '</td>'  
	+ '<td>'
	+ '<select style="width:100%;" class="KontrolListeliEk2Tablosu2-Select-'+birimId+'" name="KontrolListeliEk2Tablosu2-Select-'+birimId+'[]" > '+ jQuery('#biriminKontrolListeliTablolarinaDropdown-'+birimId).val() +'< /select></td>'
	+ '<td>'
	+ 	'<input style="width:100%;" type="text" name="KontrolListeliEk2Tablosu2-Input-'+birimId+'[]" value="'+anlayisBilgisiValue+'"  />'
	+ '</td>'
	+ '<td>'
	+ 	'<div class="KontrolListeliEk2Tablosu2-DegerlendirmeAraci_Div-'+birimId+'">'+degerlendirme_araci_text+'</div>'
	+ '</td>'
	+ '</tr>'		
	);
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
		if(jQuery(jQuery(eklenmisSelect).children()[i]).val()== ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
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
		if(jQuery(jQuery(eklenmisSelect).children()[i]).val()== ogrenmeCiktisiIndex+'-'+basarimOlcutuIndex)
			jQuery(jQuery(eklenmisSelect).children()[i]).attr("selected", "selected");
	}
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

</script>
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Birim Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="protokolForm" name="protokolForm" method="post"
		action="index.php?option=com_yetkilendirme_yet&amp;task=etkisizlestir">
	
		<div class="toolbar">
			<!-- <input
				id="etkinlestirButton" value="Etkin Hale Getir"
				name="etkinlestirButton" type="button"
				onclick="OnButton1();" /> 
			<input
				id="etkisizlestirButton" value="Etkisiz Hale Getir"
				name="etkisizlestirButton" type="button"
				onclick="OnButton2();" />  
				
			<input id="duzenleButton" value="Düzenle"
				name="duzenleButton" type="button" disabled="disabled"  
				onclick="OnButton4();"/>
			-->
			<input 
				id="silButton" value="Sil" name="silButton" type="button"
				formaction="index.php?option=com_yetkilendirme_yet&amp;task=sil"
				onclick="OnButton3();" /> 
				
				
			<input id="yeniButton" value="Yeni"
				name="yeniButton" type="button" 
				/>
	
			<div style="clear: both;"></div>
		</div>
		
		<div class="detayliAramaDiv">
			 <a id="detayliAramaGosterGizleButton" href="">Detaylı Arama Yap</a>
			 <br>
			
			<div id="detayliAramaFilters" class="detayliAramaFilters" style="display:none;">
				Kuruluş Adı:
				<br><input type="text" name="detayliArama_kurulusAdiTextbox" id="detayliArama_kurulusAdiTextbox" class="detayliArama" />
				<br>Standart Adı:
				<br><input type="text" name="detayliArama_ekliYeterlilikTextbox" id="detayliArama_ekliYeterlilikTextbox" class="detayliArama" />
				<br>Standart Sektörü:
				<br><select multiple="multiple" name="detayliArama_ekliYeterlilikSektorSelect[]" id="detayliArama_ekliYeterlilikSektorSelect" class="detayliArama" >
				<?php
					$sektorler = $this->meslekStandartSektorleri;
					echo "<option value='0'>Tümü</option>";
					for($i = 0; $i< count($sektorler); $i++)
					echo "<option value='".$sektorler[$i]["SEKTOR_ID"]."'>" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
				?>
				</select>
				
			</div>
			
		</div>
		
		<div class="yeniBirimEklePopupDiv" id="yeniBirimEklePopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:600px; height:500px; display:none; background-color: white;">
			ADI:<input id="yeniBirimEklePopup_BirimAdiTextBox" name="yeniBirimEklePopup_BirimAdiTextBox" type="text"></input>
			<br>Birim Kodu(Referans Kodu):<input id="yeniBirimEklePopup_ReferansKoduTextBox" name="yeniBirimEklePopup_ReferansKoduTextBox" type="text"></input>
			<br>Seviye:<input id="yeniBirimEklePopup_SeviyeTextBox" name="yeniBirimEklePopup_SeviyeTextBox" type="text"></input>
		<!-- 	<br>Yayın Tarihi:<input id="yeniBirimEklePopup_YayınTarihiTextBox" name="yeniBirimEklePopup_YayınTarihiTextBox" type="text"></input>
			<br>Revizyon No:<input id="yeniBirimEklePopup_RevizyonNoTextBox" name="yeniBirimEklePopup_RevizyonNoTextBox" type="text"></input>
		 -->	<br><input type="button" value="EKLE" name="yeniBirimEklePopup_EkleButton" id="yeniBirimEklePopup_EkleButton" />
			
		</div>
		
		
		<div>
			<table id="BirimListe" style="width:100%;">
				<thead > 
					<tr>
						<th>#</th>
						<th class="protokolHead">Birim Adı</th>
						<th>Yayın Tarihi</th>
						<th>Onay Tarihi</th>
						<th>Düzenle</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$birimler = $this->birimler;
				
				for($i=0; $i<count($birimler); $i++)
				{
					$backgroundColor = '';
					if($birimler[$i]["DURUM_ID"]== 3){//AKTIF
						$backgroundClass = "enabled";
					}
					else{//ETKISIZ
						$backgroundClass = "disabled";
					}
	
					echo '<tr id="'.$birimler[$i]["BIRIM_ID"].'">';
					echo '<td><input onclick="doThis();" type="checkbox" value="'.$birimler[$i]["BIRIM_ID"].'" name="protokollerCheckbox[]" id="protokollerCheckbox'.$i.'"></td>';
					
					echo '<td><a style="text-decoration: underline;" href="#">'.$birimler[$i]["BIRIM_ADI"].'</a></td>';
					echo '<td>'.$birimler[$i]["BIRIM_YAYIN_TAR"].'</td>';
					echo '<td>'.$birimler[$i]["BIRIM_ONAY_TAR"].'</td>';
					echo "<td><a class='editBirim'>".JText::_("EDIT_TEXT")."</a></td>";
					//echo '<td class="'.$backgroundClass.'">'.$birimler[$i]["DURUM_ACIKLAMA"].'</td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
		
		
		<div id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv" style=" width: 945px; height:550px; background-color: white; border:1px solid #00A7DE; display: none;">
			<div style="float:left; width:75%; padding-left:25%; height:87%; padding-top:5%; overflow:auto;" id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv-InnerDiv">
			
			</div>
			<div style="float:left; width:100%; height:25%;">
				<input type="button" value="Kaydet" id="kontrolListeliEk2DegerlendirmeAraclariPopupDiv-KaydetButton" />
				<input type="button" value="Kapat" onclick="jQuery('#kontrolListeliEk2DegerlendirmeAraclariPopupDiv').trigger('close');" />
			</div>
		</div>
		
		
		<?php  
		$eklenmisBirim = $birimler;
		for($i=0; $i<count($eklenmisBirim); $i++)//HER BIRIM ICIN
		{
				$totalBaglamCount = 0;
				$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
				$birimAdi = $eklenmisBirim[$i]["BIRIM_ADI"];
				$popupVisibility = "display:none";
				$popupStyle = ' style="'.$popupVisibility.'; border: 1px solid #00A7DE; padding: 10px; width:950px; background-color: white; " ';
					
				echo '<input type="hidden" name="gorevlerinIDleri[]" value="'.$birimID.'"></input>';
				
				echo '<div id="biriminDetaylariPopupDiv-'.$birimID.'" '.$popupStyle.'>';
				echo '<div style="height:500px; overflow:auto;">';
					
				echo '<strong>'.$eklenmisBirim[$i]["BIRIM_ADI"].' YETERLILIK BIRIMI</strong><br>';
				echo '<table id="birimDetayiIlkTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
				<tr>
				<td class="blueBackgrounded" style="width:30px">1</td>
				<td class="blueBackgrounded">YETERLİLİK BİRİMİ ADI</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_ADI"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">2</td>
				<td class="blueBackgrounded">REFERANS KODU</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_KODU"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">3</td>
				<td class="blueBackgrounded">SEVİYE</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_SEVIYE"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" style="width:30px">4</td>
				<td class="blueBackgrounded">KREDİ DEĞERİ</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_KREDI"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded" rowspan="3"  style="width:30px">5</td>
				<td class="blueBackgrounded">A)YAYIN TARİHİ</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_YAYIN_TAR"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded">B)REVİZYON NO</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_REV_NO"].'</td>
				</tr>
				<tr>
				<td class="blueBackgrounded">C)REVİZYON TARİHİ</td>
				<td>'.$eklenmisBirim[$i]["BIRIM_REV_TAR"].'</td>
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
					if(in_array($kaynak['STANDART_ID'], $biriminKaynaklari))
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
					
					
					echo '<tr class="birimGelistirenKuruluslarRow" id="birimGelistirenKuruluslarRow-0"><td class="blueBackgrounded" style="width:30px">9</td><td class="blueBackgrounded">YETERLİLİK BİRİMİNİ GELİŞTİREN KURUM/KURULUŞ(LAR): - <input style="display:none;" type="button" value="EKLE" id="birimGelistirenKurulusEkleButton-'.$birimID.'" class="birimGelistirenKurulusEkleButton" ></input>  <input style="display:none;" type="button" value="Yeterliliği Geliştiren Kuruluslardan Ekle" id="yeterlilikGelistirenKuruluslardanEkleButton-'.$birimID.'" class="yeterlilikGelistirenKuruluslardanEkleButton" ></input></td></tr>';
					
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
						
						<input id="ek1TekSatirEkleButton-'.$birimID.'" class="ek1TekSatirEkleButton" type="button" style="float:left;" value="Tek Satır Ekle" />
						<input type="button" style="float:left;"  value="Toplu Ekleme Yap" onclick="jQuery(\'#birimEk1TopluEklemeDiv-'.$birimID.'\').toggle(\'slow\')" />
						
						<div style="float:left; width:100%; display:none;" id="birimEk1TopluEklemeDiv-'.$birimID.'">
							<textarea id="birimEk1TopluEklemeTextArea-'.$birimID.'" style="float:left; width:850px; height:150px; "></textarea>
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
					<table class="KontrolListesizEk2Tablolari" id="KontrolListesizEk2Tablolari-'.$birimID.'" style="width:100%; padding-bottom:25px;"><thead><tr><th class="blueBackgrounded" style="width:'.$basarimOlcusuKolonGenisligi.'%;">Birim Başarım Ölçütü</th><th class="blueBackgrounded" style="width:'.(100-$basarimOlcusuKolonGenisligi).' %;">Değerlendirme Aracı</th></tr></thead><tbody>';
					echo '</tbody></table></div>';
					
					echo '<div id="kontrolListeliEk2-'.$birimID.'" style="width:100%; float:left;" >';
					$birimEk2Turleri = $this->birimEk2Turleri;
					
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
									<th class="blueBackgrounded" style="width:25%;">
										<input type="button" value="EKLE" style="float:left;" id="'.$ekleButtonName.'-'.$birimID.'" class="'.$ekleButtonName.'" /> 
										Meslek Standardı Başarım Ölçütü
									</th>
									<th class="blueBackgrounded" style="width:25%;">
										Birim Başarım Ölçütü
									</th>
									<th class="blueBackgrounded" style="width:25%;">
										'.$row['ACIKLAMA'].'
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
					
					
			echo 	'</td>
					</tr>';
					//////////////////// EK 2 BITER
					
					
					
					echo '</tbody></table>';
						
					
					echo '</div>';
					
					echo '<input class="popupuKaydetButton" id="popupuKaydetButton-'.$birimID.'" value="KAYDET" type="button" >';
					
					echo '</div>';
					
					//// SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT
						
					echo "<script>";

					if("".$eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]== "1")
						echo ' biriminEk2FormatiniBelirle('.$birimID.', "Y" ); ';
					else
						echo ' biriminEk2FormatiniBelirle('.$birimID.', "E" ); ';
						
				
					for($j=0; $j<count($buBiriminOgrenmeCiktilari); $j++)
					{
						$ogrenmeCiktisiID = $buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_ID"];
						$buOgrenmeCiktisininBaglamlariViewID = 'ogrenmeCiktisininBaglamlari-'.$birimID."-".$ogrenmeCiktisiID;
						$buOgrenmeCiktisininBaglamlari = $this->$buOgrenmeCiktisininBaglamlariViewID;
						$buOgrenmeCiktisininBasarimOlcutuViewID = 'ogrenmeCiktisininBasarimOlcutleri-'.$birimID.'-'.$ogrenmeCiktisiID;
						$buOgrenmeCiktisininBasarimOlcutleri = $this->$buOgrenmeCiktisininBasarimOlcutuViewID;
						
						
						echo ' yeniOgrenmeCiktisiEkle2('.$birimID.', '.($j+1).', "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_YAZISI"]).'", "'.FormFactory::replaceNewLinesForJavascriptCode($buOgrenmeCiktisininBaglamlari[0]["BAGLAM_ACIKLAMA"]).'" ); ';
						//
					
						
						for($k=0; $k<count($buOgrenmeCiktisininBasarimOlcutleri); $k++)
						{
							$basarimOlcutuID = $buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ID"];
								
							$buBasarimOlcutununBaglamlariViewID = 'basarimOlcutununBaglamlari-'.$birimID."-".$ogrenmeCiktisiID."-".$basarimOlcutuID;
							$buBasarimOlcutununBaglamlari = $this->$buBasarimOlcutununBaglamlariViewID;
								
							echo ' yeniBasarimOlcutuEkle2('.$birimID.', '.($j+1).', "'.FormFactory::replaceNewLinesForJavascriptCode($buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ADI"]).'", "'.FormFactory::replaceNewLinesForJavascriptCode($buBasarimOlcutununBaglamlari[0]["BAGLAM_ACIKLAMA"]).'" 	); ';
						}
					}
					
					$biriminEk2si_KontrolListeliTablo1ViewID = 'biriminEk2si_KontrolListeli-Tablo1-'.$birimID;
					$biriminEk2si_KontrolListeliTablo1 = $this->$biriminEk2si_KontrolListeliTablo1ViewID;
					for($j=0; $j<count($biriminEk2si_KontrolListeliTablo1); $j++)
					{
						echo ' Ek2yeBasarimOlcutuYetkinlikEkle('.$birimID.', "'.$biriminEk2si_KontrolListeliTablo1[$j]["EK_YAZISI"].'", "'.$biriminEk2si_KontrolListeliTablo1[$j]["MESLEK_STANDARDI_BO_TEXT"].'", "<a class=\'kontrolListeliEk2yeDegerlendirmeAraciEkleButton ek2_kontrol_listeli_id-'.$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"].'\'>Değerlendirme Araçları</a>", "'.$biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"].'"); 
						';
						echo ' Ek2yeEnSonEklenenDropDownIndexiniDuzenle1('.$birimID.', '.$biriminEk2si_KontrolListeliTablo1[$j]["OGRENME_CIKTISI_INDEX"].', '.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_INDEX"].');
						';
					}
					
					$biriminEk2si_KontrolListeliTablo2ViewID = 'biriminEk2si_KontrolListeli-Tablo2-'.$birimID;
					$biriminEk2si_KontrolListeliTablo2 = $this->$biriminEk2si_KontrolListeliTablo2ViewID;
					for($j=0; $j<count($biriminEk2si_KontrolListeliTablo2); $j++)
					{
						echo ' Ek2yeBasarimOlcutuAnlayisEkle('.$birimID.', "'.$biriminEk2si_KontrolListeliTablo2[$j]["EK_YAZISI"].'", "'.$biriminEk2si_KontrolListeliTablo2[$j]["MESLEK_STANDARDI_BO_TEXT"].'", "<a class=\'kontrolListeliEk2yeDegerlendirmeAraciEkleButton ek2_kontrol_listeli_id-'.$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"].'\'>Değerlendirme Araçları</a>", "'.$biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"].'"); 
						';
						echo ' Ek2yeEnSonEklenenDropDownIndexiniDuzenle2('.$birimID.', '.$biriminEk2si_KontrolListeliTablo2[$j]["OGRENME_CIKTISI_INDEX"].', '.$biriminEk2si_KontrolListeliTablo2[$j]["BASARIM_OLCUTU_INDEX"].');
						';
					}
					
					
					$buBiriminTeorikSinavlariViewID = 'biriminTeorikSinavlari-'.$birimID;
					$buBiriminTeorikSinavlari = $this->$buBiriminTeorikSinavlariViewID;
					for($j=0; $j<count($buBiriminTeorikSinavlari); $j++)
					{
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "T", "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminTeorikSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI"].'", "'.$buBiriminTeorikSinavlari[$j]["BASARI_KRITERI"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_DK"].'",  "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_DK"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI_MAX"].'", "",  "'.$buBiriminTeorikSinavlari[$j]["ID"].'" ); ';
					}
								
					$buBiriminPerformansSinavlariViewID = 'biriminPerformansSinavlari-'.$birimID;
					$buBiriminPerformansSinavlari = $this->$buBiriminPerformansSinavlariViewID;
					for($j=0; $j<count($buBiriminPerformansSinavlari); $j++)
					{
						echo ' birimDetaylarinaSinavEkle ('.$birimID.', "P", "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminPerformansSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI"].'","","","","","", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI_ACIKLAMA"].'", "'.$buBiriminPerformansSinavlari[$j]["ID"].'"); ';
							
					}
						
					$buBiriminDigerSinavlariViewID = 'biriminDigerSinavlari-'.$birimID;
					$buBiriminDigerSinavlari = $this->$buBiriminDigerSinavlariViewID;
					for($j=0; $j<count($buBiriminDigerSinavlari); $j++)
					{
						echo 'birimDetaylarinaSinavEkle ('.$birimID.', "D", "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminDigerSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'", "", "", "",  "", "", "", "","", "'.$buBiriminDigerSinavlari[$j]["ID"].'" ); ';
						
					}
					
					$biriminEk2si_KontrolListesizViewID = 'biriminEk2si_KontrolListesiz-'.$birimID;
					$biriminEk2si_KontrolListesiz = $this->$biriminEk2si_KontrolListesizViewID;
					echo ' var checklenecekCheckboxlar = new Array(); '; 
					for($j=0; $j<count($biriminEk2si_KontrolListesiz); $j++)
					{
						echo ' checklenecekCheckboxlar['.$j.'] = "'.$biriminEk2si_KontrolListesiz[$j]["OGRENME_CIKTISI_INDEX"].'-'.$biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_INDEX"].'-'.$biriminEk2si_KontrolListesiz[$j]["SINAV_IDENTIFIER"].'-'.$biriminEk2si_KontrolListesiz[$j]["SINAV_INDEX"].'"; ';
					}
					echo 'ek2CheckboxlariniCheckle( '.$birimID.' , checklenecekCheckboxlar);';
						
					
					
					
					
						
					
					echo "</script>";
						
					// SULEYMAN ABI JAVASCRIPT BITTI
			
			
			
			
			
			
			
		} 
	?>
		
		
		
		
	</form>
	<div style="clear:both;"></div>
</div>

<script type="text/javascript">
jQuery('.BasarimOlcutuYetkinlikEkleButton').live("click",  function (e) {
	var birimId = this.id.split('-')[1];

	Ek2yeBasarimOlcutuYetkinlikEkle(birimId, "", "", "Değerlendirme Aracı Eklemek İçin Kaydediniz", "");
	

});



jQuery('.BasarimOlcutuAnlayisEkleButton').live("click",  function (e) {
	var birimId = this.id.split('-')[1];
	Ek2yeBasarimOlcutuAnlayisEkle(birimId, "", "", "Değerlendirme Aracı Eklemek İçin Kaydediniz", "");
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
	
	
	birimDetaylarinaSinavEkle (birimID, sinavIdentifier, "", "", "", "", "", "", "", "", "", "" );
	
} );
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
				 window.location = 'index.php?option=com_birim_yonetimi';
			  }
			  else
			  {
				alert("Kaydetmede hata, "+data['array']);
			  }
 
		  }
	});

	
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

} );
jQuery('#BirimListe tbody tr *').live('click', function (e) {

	var thisRow = jQuery(this)[0];
	var thisTableBody = jQuery(this).parent()[0];

	while(thisRow.getTag()!="tr")
	{
		thisRow = thisRow.getParent();
		thisTableBody = thisTableBody.getParent();
	}
		
	for(var i=0; i<thisTableBody.getChildren().length; i++)
	{
		if(thisTableBody.getChildren()[i].classList.contains("odd"))
			jQuery(thisTableBody.getChildren()[i]).css("background-color","#E1E1E1");
		else
			jQuery(thisTableBody.getChildren()[i]).css("background-color","white");
	}
	thisRow.setStyle("background-color","#C1D1E1");
	seciliBirimRowID = thisRow.getId();

});
jQuery('.ek1TekSatirEkleButton').live("click", function (e) {
	
	var buttonIDVariables = this.id.split('-');
	var birimID = buttonIDVariables[1];
	jQuery('#birimEk1Tablosu-'+birimID+' tbody').append('<tr class="ek1Yazisi">'
		+ '<td><input type="button" value="Sil" onclick="jQuery(jQuery(this).parent()[0].getParent()).remove();"></td>'
		+ '<td><input value="" name="biriminEk1leri-'+birimID+'[]" style="width:99%;"></td>'
		+ '</tr>'
	);
	// Stop event handling in IE
	return false;
} );
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
jQuery('.yeniBasarimOlcutuEkleButton').live("click", function (e) {

	var ekleButtonVariables = this.id.split("-"); 
	yeniBasarimOlcutuEkle2(ekleButtonVariables[1], ekleButtonVariables[2], "", "" );
	// Stop event handling in IE
	return false;
});
jQuery('.ogrenmeCiktisiBaglamiGosterButton').live("click", function (e) {
	var variables = this.id.split('-');
	jQuery(this).hide();
	jQuery('#ogrCktBaglamiTextDiv-'+variables[1]+'-'+variables[2]).toggle("slow");
	jQuery('#ogrenmeCiktisiBaglamiGizleButton-'+variables[1]+'-'+variables[2]).show();	
	// Stop event handling in IE
	return false;
} );
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

jQuery('.ogrenmeCiktisiSilButton').live("click", function (e) {

	var silButtonVariables = this.id.split("-"); 
	ogrenmeCiktisiSil(silButtonVariables[1], silButtonVariables[2]);
	// Stop event handling in IE
	return false;
});

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


function OnButton1()
{
    document.protokolForm.action = "index.php?option=com_yetkilendirme_yet&amp;task=etkinlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton2()
{
    document.protokolForm.action = "index.php?option=com_yetkilendirme_yet&amp;task=etkisizlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton3()
{
	<?php 
			$protokolArr = JRequest::getVar('protokollerCheckbox');
			
			$yeterlilikKayitliProtokollerString = "";
			$standartlarKayitliProtokollerString = "";
			$x="..";
			?>

	if(confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' )==true)
	{		
	    document.protokolForm.action = "index.php?option=com_birim_yonetimi&amp;task=sil";
	    document.protokolForm.submit();             // Submit the page
	}
    return true;
}
function OnButton4()
{
	var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
	document.protokolForm.action = "index.php?option=com_yetkilendirme_yet&amp;layout=yeni&amp;protokolID="+editIndex;
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton5()
{
    document.protokolForm.action = "#";
    document.protokolForm.submit();             // Submit the page
    return true;
}

jQuery(document).ready(function() {
	//INIT DATATABLE
	var detayliAramaResultsHidden = 1;
	
    var oTableKurulus = jQuery('#BirimListe').dataTable({
    	"oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("FILTER");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
    });


    jQuery('a.editBirim').live('click', function (e) {
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
    function manageBirimDetayiPopup()
    {
    	jQuery('#biriminDetaylariPopupDiv-'+seciliBirimRowID).lightbox_me({
            centered: true, 
            });
    }

    jQuery('#detayliAramaGosterGizleButton').click( function (e) {

		if(detayliAramaResultsHidden==0)//gizli değilse gizle
    	{
	    	jQuery('#detayliAramaFilters').hide("slow");
    		
   			detayliAramaResultsHidden = 1;
    	}
    	else // zaten gizliyse göster
    	{
    		jQuery('#detayliAramaFilters').show("slow");

			detayliAramaResultsHidden = 0;
        	
    	}	
        
     	// Stop event handling in IE
        return false;
    } );

    jQuery('#detayliArama_kurulusAdiTextbox').keyup(function() {
		filterVariablesChanged();
	});
    jQuery('#detayliArama_ekliYeterlilikTextbox').keyup(function() {
    	filterVariablesChanged();
	});
    jQuery('#detayliArama_ekliYeterlilikSektorSelect').change(function() {
    	filterVariablesChanged();
	});



    
});

function filterVariablesChanged()
{
	var jqInputs = jQuery('.detayliArama');
	var sendData = jqInputs.serializeArray();

	
	var url = 'index.php?option=com_yetkilendirme_yet&task=ajaxFilterYetkilendirmeler&format=raw';

	
	
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
					
				  	var arrayToPut = data['array'];
				  	var oTableMS = jQuery('#BirimListe').dataTable();

					oTableMS.fnClearTable();
					for(var i=0; i<arrayToPut.length; i++)
				    {
					    var backgroundClass = "";
					    if(arrayToPut[i]["ETKIN"]=="1") 
					    	backgroundClass = "enabled";
					    else 
					    	backgroundClass = "disabled";

				    	var a = oTableMS.fnAddData( [
							'<td><input onclick="doThis();" type="checkbox" value="'+arrayToPut[i]["YETKI_ID"]+'" name="yetkilendirmelerCheckbox[]" id="yetkilendirmelerCheckbox'+i+'"></td>',
							'<td><a href="index.php?option=com_yetkilendirme_yet&layout=yeni&protokolID='+arrayToPut[i]["YETKI_ID"]+'">'+arrayToPut[i]["ADI"]+'</a></td>',
							'<td>'+arrayToPut[i]["IMZA_TARIHI"]+'</td>',
							'<td>'+arrayToPut[i]["BITIS_TARIHI"]+'</td>',
							'<td class="'+backgroundClass+'">'+arrayToPut[i]["ACIKLAMA"]+'</td>'
				        ]);
				    	
				        
				    }  
			    	
			  }else{
				  
				  var oTableMS = jQuery('#BirimListe').dataTable();

					oTableMS.fnClearTable();
					
			  }
		  }
	});
}


function doThis()
{
	var $b = jQuery('input[type=checkbox]');
	var count = $b.filter(':checked').length; // works
	if(count==1)
	{
		jQuery("#duzenleButton").removeAttr('disabled');
		var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
		//alert(editIndex);
		//document.protokolForm.action = "index.php?option=com_protokol&amp;layout=yeni&amp;protokolID="+editIndex;
		$("#protokolForm").attr("action", "index.php?option=com_yetkilendirme_yet&amp;layout=yeni&amp;protokolID="+editIndex);
		
	}
	else
	{
		jQuery("#duzenleButton").attr('disabled', 'disabled');
	}

	
}
function JS_Sil()
{
	<?php 
	$protokolArr = JRequest::getVar('protokollerCheckbox');
	
	$yeterlilikKayitliProtokollerString = "";
	$standartlarKayitliProtokollerString = "";
	$x="..";
	?>

	return confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' );
}

jQuery('#yeniButton').click(function(e) {
    jQuery('#yeniBirimEklePopupDiv').lightbox_me({
        centered: true, 
        });
    e.preventDefault();
});



jQuery('#yeniBirimEklePopup_EkleButton').click(function(e){

	var jqInputs = jQuery('#yeniBirimEklePopupDiv input');
	var sendData = jqInputs.serializeArray();

	/*  VALIDATION?????  */
	
	jQuery.ajax({
		  url: "index.php?option=com_birim_yonetimi&task=ajaxAddNewBirim&format=raw",
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				//jQuery("#bilgilendirme").html(data['data']);
				//oTable.fnDeleteRow( nRow );
				updateBirimTable(data['array']);
				jQuery('#yeniBirimEklePopupDiv').trigger('close');
				alert('Başarıyla kaydedildi');
			  }else{
			  	//jQuery("#bilgilendirme").html(data['data']);
			  	//oTable.fnDraw();
			  }
		  }
	});
		
});

function updateBirimTable(arrayToPut)
{
	var oTableMS = jQuery('#BirimListe').dataTable();

	oTableMS.fnClearTable();
	for(var i=0; i<arrayToPut.length; i++)
    {
    	var a = oTableMS.fnAddData( [
    	                         	
'<td><input onclick="doThis();" type="checkbox" value="'+arrayToPut[i]["BIRIM_ID"]+'" name="protokollerCheckbox[]" id="protokollerCheckbox'+i+'"></td>',
'<td><a style="text-decoration: underline;" href="#">'+arrayToPut[i]["BIRIM_ADI"]+'</a></td>',
'<td>'+arrayToPut[i]["BIRIM_YAYIN_TAR"]+'</td>',
'<td>'+arrayToPut[i]["BIRIM_ONAY_TAR"]+'</td>'
//,'<td>'+arrayToPut[i]["DURUM_ACIKLAMA"]+'</td>'

      ]);
		
      	
      
    }   
	
}
</script>
