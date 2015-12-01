function satirEkleKaldir (tableName){
	elementSil(document.getElementById("rowNumber-"+tableName));
	elementSil(document.getElementById("satirEkle_"+tableName));
}

function satirSilKaldir (tableName, colNum){
	// tablo başlığından Satırı Sil? th sini sil
	var tabloElement = document.getElementById("tablo_"+tableName);
	var theadler = tabloElement.getElementsByTagName("thead");
	var thler;
	if(theadler[0])
		thler = theadler[0].getElementsByTagName("th");
	if(thler[colNum])
		elementSil(thler[colNum]);

	// Sil td lerini sil
	var trInp = document.getElementById("tablo_"+tableName+"_1");
	
	for(var i=2; trInp!= null ;i++){
		var tdler = trInp.getElementsByTagName("td");
		for(var j=0;j<tdler.length;j++){
			if(tdler[j].className == "tablo_sil_hucre"){
				elementSil(tdler[j]);
				break;
			}
		}
		
		trInp = document.getElementById("tablo_"+tableName+"_"+i);
	}
}


function elementSil(element){
	element.parentNode.removeChild(element);
}