/*function kapsamSecildi(combo){
	
	for(var i=0;i<combo.options.length;i++){
	
		if(combo.options[i].selected && combo.options[i].value == "Başarısız"){
			for(var j=0;j<combo.options.length;j++)
				if(j!=i)
					combo.options[j].selected = false;
		}
	
	}

}*/

var dTables = new Object();
var dPanels = new Object();
var yetKonusu="";
var yetKonusuDegisti=false;
var tabloOgrRowCount=0;

function yetSecildi(){

	if(document.getElementById("yeterlilik_konusu").value == "Seçiniz")
		return;
		
	if(yetKonusu == document.getElementById("yeterlilik_konusu").value)
		return;
		
	yetKonusuDegisti = true;
	
	yetKonusu = document.getElementById("yeterlilik_konusu").value;
	// kapsamları güncelle
	
	xmlhttpPost(null, 'index.php?option=com_sinav&task=kapsamAl&format=raw', kapsamGetQueryString, kapsamUpdatePageFunction);


}

function checkfirstPage(){

	return true;

}


function kapsamGetQueryString(){
	var yetId = document.getElementById("yeterlilik_konusu").value;
	
	var qstr = 'yetId=' + yetId + '&task=kapsamAl';
	return qstr;
}

function kapsamUpdatePageFunction(str){

	//var existingTable = document.getElementById("tablo_belgeDuzenlenecekBilgi");
	
	var kapsamInp = document.getElementById("sinav_kapsami");
	
	// clear previous options
	for(var optCount = kapsamInp.options.length; optCount >=0; optCount--)
		kapsamInp.remove(i);
	
	var options = str.split("**");
	
	// add new options
	for(var i=0,optn =null;i<options.length;i++){
		var optAtt = options[i].split("##");
		var optId = optAtt[0];
		var optName = optAtt[1];
		
		optn = document.createElement("option");
		optn.text = optName;
		optn.value = optId;
		
		kapsamInp.options.add(optn);
	}
	
	
	kapsamInp.disabled=false;
//	if(dTables.belgeDuzenlenecekBilgi.length == 9){
//		dTables.belgeDuzenlenecekBilgi.pop();
//	}
//
//	//alert(str);
//	var element = new Array("listbox");
//	var comboArray = new Array();
//	
//	var options = str.split("**");
//	
//	for(var i=0;i<options.length;i++){
//		var optAtt = options[i].split("##");
//		var optId = optAtt[0];
//		var optName = optAtt[1];
//		comboArray.push(new Array(optId,optName));
//	}
//	element.push(comboArray)
//	//element.push("comboReq","kapsamSecildi(this)","5");
//	element.push("comboReq","","5");
//	
//	dTables.belgeDuzenlenecekBilgi.push(element);


	//document.getElementById("goNextButton").disabled= false;
}


function sondanSil(silmeAdedi){
	var tablo = document.getElementById("tablo_belgeDuzenlenecekBilgi");
	var trler = tablo.getElementsByTagName("tr");
	for(var i=trler.length-1;i>=0;i--){
		var tdler = trler[i].getElementsByTagName("td");
			for(var j=0;j<tdler.length;j++){
				if(tdler[j].className == "tablo_sil_hucre"){
					elementSil(tdler[j]);
					break;
				}
			}
			if(silmeAdedi==trler.length-i)
				break;
	}

}

function insertIlkSayfa(){
	
	var yetKonusuSelect = document.getElementById("yeterlilik_konusu");
	if(yetKonusuSelect.value == "Seçiniz"){
	
		alert("Lütfen yeterlilik konusunu seçiniz.");
		yetKonusuSelect.focus();
		return;
	}
	var katilanTextBox = document.getElementById("sinav_katilan");
	
	if(katilanTextBox.value < 1){
	
		alert("Lütfen 1 veya 1 den büyük değer giriniz.");
		katilanTextBox.focus();
		return;
	}
	
	var basariliTextBox = document.getElementById("sinav_basarili");
	if(parseInt(basariliTextBox.value) > parseInt(katilanTextBox.value)){
	
		alert("Sınava katılan kişi sayısı ile başarılı olan kişi sayısı arasında tutarsızlık var.");
		basariliTextBox.focus();
		return;
	}
	
	if(!yetKonusuDegisti){
		
		var toplamAday = katilanTextBox.value;
		
		if(tabloOgrRowCount != 0 && tabloOgrRowCount != toplamAday){
			var rowNumber = document.getElementById("rowNumber-belgeDuzenlenecekBilgi");

			if(toplamAday > tabloOgrRowCount){
			
				rowNumber.value = toplamAday - tabloOgrRowCount;
				addNRow('belgeDuzenlenecekBilgi','9','belgeDuzenlenecekBilgi');
				rowAdded('belgeDuzenlenecekBilgi','belgeDuzenlenecekBilgi');
				rowNumber.value = "1";
				
				sondanSil(toplamAday - tabloOgrRowCount);
				
				tabloOgrRowCount = toplamAday;

				
			}
			else{
				
				for(var i=0;i<tabloOgrRowCount-toplamAday;i++){
				
					deleteRow('tablo_belgeDuzenlenecekBilgi_'+(tabloOgrRowCount-i));
					rowDeleted("belgeDuzenlenecekBilgi");
				}
				tabloOgrRowCount -= (tabloOgrRowCount-toplamAday);
			}
		
		}
	
		goNextPage();
	}
	yetKonusuDegisti= false;
	if(seciliSayfa == 1)
		xmlhttpPost(checkfirstPage, 'index.php?option=com_sinav_sonuc&task=genelBilgiler&format=raw',firstPageGetQueryString,firstPageUpdatePageFunction);
	else
		goNextPage();
}

function firstPageGetQueryString(){
	
	var evrakId = <?php echo $evrakId?>;
	var userId = <?php echo $user_id ?>;
	var yeterlilikId = document.getElementById("yeterlilik_konusu").value;
	var sinavTarihi = document.getElementById("sinav_tarihi").value;
	var toplamAday = document.getElementById("sinav_katilan").value;
	var basariliAday = document.getElementById("sinav_basarili").value;
	
	var qstr = 'evrakId=' + evrakId + '&userId=' +userId+ '&yeterlilikId=' + yeterlilikId + '&sinavTarihi=' + sinavTarihi + '&toplamAday=' + toplamAday + '&basariliAday=' + basariliAday;
	//alert(qstr);
	return qstr;
}


function elementSil(element){

	element.parentNode.removeChild(element);
}

function firstPageUpdatePageFunction(str){
	goNextPage();
	
	var yetId = document.getElementById("yeterlilik_konusu").value;
	
	var t34Form = document.getElementById("genel_bilgiler_form");
	
	var evrakInp = document.createElement("input");
	evrakInp.setAttribute("type", "hidden");
	evrakInp.setAttribute("name", "evrakId");
	evrakInp.setAttribute("value", <?php echo $evrakId?>);
	t34Form.appendChild(evrakInp);
	
	var yetIdInp = document.createElement("input");
	yetIdInp.setAttribute("type", "hidden");
	yetIdInp.setAttribute("name", "yetId");
	yetIdInp.setAttribute("value", yetId);
	t34Form.appendChild(yetIdInp);
	
	var existingTable = document.getElementById("tablo_belgeDuzenlenecekBilgi");
	var existingTableRowNumber = document.getElementById("rowNumber-belgeDuzenlenecekBilgi");
	var existingTableSatirEkle = document.getElementById("satirEkle_belgeDuzenlenecekBilgi");
	
	if(existingTableSatirEkle)
		existingTableSatirEkle.parentNode.removeChild(existingTableSatirEkle);
	
	if(existingTableRowNumber)
		existingTableRowNumber.parentNode.removeChild(existingTableRowNumber);
	
	if(existingTable){
		existingTable.parentNode.removeChild(existingTable);
		rowCounter['belgeDuzenlenecekBilgi'] = 0;
	}
	
	createTable("belgeDuzenlenecekBilgi",
			new Array(
					'Sıra No',
					'TC Kimlik No',
					'Adı',
					'Soyadı',
					'Doğum Tarihi',
					'Doğum Yeri',
					'Baba Adı',
					'Kayıt No',
					'Yeterlilik Kapsamı'
			)
	);
	patchSatirEkle("belgeDuzenlenecekBilgi");
	
	var toplamAday = document.getElementById("sinav_katilan").value;
	var rowNumber = document.getElementById("rowNumber-belgeDuzenlenecekBilgi");
	if(toplamAday > 1){
		rowNumber.value = toplamAday - 1;
		addNRow('belgeDuzenlenecekBilgi','9','belgeDuzenlenecekBilgi');
		rowAdded('belgeDuzenlenecekBilgi','belgeDuzenlenecekBilgi');
		rowNumber.value = "1";
	}
	tabloOgrRowCount = parseInt(toplamAday);
	// yeni satır ekle butonu ve textbox ını sil
	//elementSil(rowNumber);
	//elementSil(document.getElementById("satirEkle_belgeDuzenlenecekBilgi"));	
	
	 rowNumber.setAttribute("style","visibility:hidden");
	 var satirEkleButton = document.getElementById("satirEkle_belgeDuzenlenecekBilgi");
	 satirEkleButton.setAttribute("style","visibility:hidden");
	
	// tablo başlığından Satırı Sil? th sini sil
	var tabloElement = document.getElementById("tablo_belgeDuzenlenecekBilgi");
	var theadler = tabloElement.getElementsByTagName("thead");
	var thler;
	if(theadler[0])
		thler = theadler[0].getElementsByTagName("th");
	if(thler[9])
		elementSil(thler[9]);
	
	// Sil td lerini sil
	for(var i=1;i<=toplamAday;i++){
		var trInp = document.getElementById("tablo_belgeDuzenlenecekBilgi_"+i);
		var tdler = trInp.getElementsByTagName("td");
		for(var j=0;j<tdler.length;j++){
			if(tdler[j].className == "tablo_sil_hucre"){
				elementSil(tdler[j]);
				break;
			}
		}
	}

	

	
	// var rowNumber = document.getElementById("rowNumber-belgeDuzenlenecekBilgi");
	// rowNumber.setAttribute("style","visibility:hidden");
	// var satirEkleButton = document.getElementById("satirEkle_belgeDuzenlenecekBilgi");
	// satirEkleButton.setAttribute("style","visibility:hidden");

}

function xmlhttpPost(checkFunction, strURL, getQueryStringFunction, updatePageFunction) {
	if(checkFunction != null && !checkFunction())
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
			//document.getElementById("debug").innerHTML = str;
			updatePageFunction(str);
		}
	};
	self.xmlHttpReq.send(getQueryStringFunction());
}

var satirNoObj = new Object();
var panelCount = new Object();

var seciliSayfa = 1;
var sayfaSayisi = 2;

function rowAdded(id, counterId){
	//alert("ROW ADDED FUNCTION");
	//alert(rowCounter[id]);
	//alert("input"+id+ "-" + "-1" + "-" + satirNoObj[id]);
		var rowNumber = document.getElementById("rowNumber-"+id).value;
		//alert("rowNumber:" +rowNumber);

		//alert("input"+id + "-1" + "-" + (rowCounter[counterId]- rowNumber +1));
	var satirInp = document.getElementById("input"+id + "-1" + "-" + (rowCounter[counterId]- rowNumber +1));

	//alert("input"+id + "-1" + "-" + (rowCounter[id]- rowNumber +1));
	//alert(rowNumber);

	for(var i=0;i<rowNumber;i++){
		satirInp.setAttribute("value", satirNoObj[id]);
		satirInp.setAttribute("readonly", "readonly");
		//alert("rc: "+rowCounter[counterId]);
		patchSatirSil(id, (rowCounter[counterId] - rowNumber +i +1));
		satirNoObj[id]++;
		satirInp = document.getElementById("input"+id + "-1" + "-" + (rowCounter[counterId] - rowNumber +i +2));
	}

}

function rowDeleted(id){
	satirNoObj[id]--;

	var satirInps = document.getElementsByName("input"+id+"-1[]");

	for(var i=0;i<satirInps.length;i++){
		satirInps[i].value = i+1;
	}
	
}

// -6-5
function panelAdded(id,tableNo){

	if(panelCount[id+'_panel']!=1)
	patchSatirEkle("div"+id+"_panel"+panelCount[id+'_panel']+tableNo,id);
	else
		patchSatirEkle("div"+id+"_panel"+tableNo,id);
	panelCount[id+"_panel"]++;
}

function patchPanelEkle(id, tableNo){

	//addNewPanelButton_sinavSonuc_panel
	
	panelCount[id+"_panel"]=1;
	var ekleInp = document.getElementById("addNewPanelButton_"+id+"_panel");
	var onclick = ekleInp.getAttribute("onclick");
	ekleInp.setAttribute("onclick",onclick+";panelAdded('"+id+"','"+tableNo+"')");
	//alert(onclick);
		//document.getElementById("satirEkle_"+id).setAttribute("onclick","");
	panelAdded(id, tableNo);
}

function patchSatirEkle(id, counterId){

	counterId = counterId == null ? id : counterId;
	
	satirNoObj[id]=1;
	var ekleInp = document.getElementById("satirEkle_"+id);
	var onclick = ekleInp.getAttribute("onclick");
	ekleInp.setAttribute("onclick",onclick+";rowAdded('"+id+"','"+counterId+"')");
	//alert(onclick);
		//document.getElementById("satirEkle_"+id).setAttribute("onclick","");
	rowAdded(id, counterId);
}

function patchSatirSil(id,sira){
	//alert("sad");
	var silInp = document.getElementById("satirSil_"+id+"-"+sira);
	var onclick = silInp.getAttribute("onclick");
	silInp.setAttribute("onclick",onclick+";rowDeleted('"+ id +"')");
	//alert(onclick);
		//document.getElementById("satirEkle_"+id).setAttribute("onclick","");
}

dPanels.sinavSonuc_panel = new Array("Personel Belgelendirme Sınav Tutanak Formu",
		new Array('Sınavın Türü','text','required'),
		new Array('Sınavın Tarihi','text','required','12'),
		new Array('Sınav Yeri','text','required'),
		new Array('Aday Sayısı','text','required','4'),
		new Array('','dtablo',createSinavSonuc)
		);

dPanels.yaziliSinavSonuc_panel = new Array("Personel Belgelendirme Yazılı Sınav Değerlendirme",
		new Array('Sınavın Tarihi','text','required','12'),
		new Array('Sınavı Yapan','text','required','30'),
		new Array('Aday Sayısı','text','required','4'),
		new Array('Başarılı','text','required','4'),
		new Array('Başarısız','text','required','4'),
		new Array('','dtablo',createYaziliSinavSonuc)
		);

dTables.belgeDuzenlenecek = new Array(
		new Array("text","required","6"),
		new Array("text","required","8"),
		new Array("text","required","20"),
		new Array("text","required","20"),
		new Array("text","required","30")
);

dTables.sinavSonuc = new Array(
		new Array("text","required","6"),
		new Array("text","required","8"),
		new Array("text","required","30"),
		new Array("text","required","30"),
		<?php echo $comboText?>
);

dTables.yaziliSinavSonuc = new Array(
		new Array("text","required","6"),
		new Array("text","required","30"),
		new Array("text","required","8"),
		new Array("text","required","8"),
		new Array("text","required","8"),
		new Array("text","required","8"),
		<?php echo $comboText?>
);

function createSinavSonuc(id){

	createTable(id,
			new Array(
					'Sıra No',
					'Kayıt No',
					'Adı Soyadı',
					'Belge Türü',
					'Sonuç'
			), "sinavSonuc"
	);
	
	//patchSatirEkle("sinavSonuc");
}

function createYaziliSinavSonuc(id){


	createTable(id,
			new Array(
					'Sıra No',
					'Adı Soyadı',
					'Doğru<br />Cevap<br />Sayısı',
					'Yanlış<br />Cevap<br />Sayısı',
					'Boş<br />Bırakılan',
					'Puan',
					'Sonuç'
			), "yaziliSinavSonuc"
	);

	//patchSatirEkle("divyaziliSinavSonuc_panel-7-11","yaziliSinavSonuc");
	
}

//function createTables(){

	// createTable("belgeDuzenlenecek",
			// new Array(
					// 'Sıra No',
					// 'Kayıt No',
					// 'TC Kimlik No',
					// 'Adı',
					// 'Soyadı'
			// )
	// );

	// createTable("belgeDuzenlenecekBilgi",
			// new Array(
					// 'Sıra No',
					// 'TC Kimlik No',
					// 'Adı',
					// 'Soyadı',
					// 'Doğum Tarihi',
					// 'Doğum Yeri',
					// 'Baba Adı',
					// 'Kayıt No',
					// 'Yeterlilik Kapsamı'
			// )
	// );

	//patchSatirEkle("belgeDuzenlenecek");
	
	
//}

//function createPanels(){

// createNPanels(1,"sinavSonuc_panel","Sınav Sonucları");
// patchPanelEkle("sinavSonuc","-6-5");

// createNPanels(1,"yaziliSinavSonuc_panel","Yazılı Sınav Sonucları");
// patchPanelEkle("yaziliSinavSonuc","-7-6");

//}