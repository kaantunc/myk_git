var tableLetters = ['A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Y','Z'];

function goToPage(pageName, standartId){
	var form = document.ChronoContact_meslek_std_taslak; 
	var action = 'index.php?option=com_meslek_std_taslak&layout='+pageName+'&standart_id='+standartId;

    form.action = action; 
	form.submit();
}

function yorumKaydet(pageName, standartId){
	var form = document.ChronoContact_meslek_std_taslak; 
	var action = 'index.php?option=com_meslek_std_taslak&task=yorumKaydet&layout='+pageName+'&standart_id='+standartId;

    form.action = action; 
	form.submit();
}
function yorumKaydet_Kurulus(pageName, standartId){
	var form = document.ChronoContact_meslek_std_taslak; 
	var action = 'index.php?option=com_meslek_std_taslak&task=yorumKaydet_Kurulus&layout='+pageName+'&standart_id='+standartId;

    form.action = action; 
	form.submit();
}

function tableGibSatirEkleKaldir (){

	for(var i=1; i <  tableLetters.length+1;i++){	
		var inp1 = document.getElementById ("ekle_"+tableLetters[i-1]);

		if (inp1 != null){
			elementSil (inp1);
		
			var inp2 = document.getElementById ("ekle_"+tableLetters[i-1]+"_1");
			for (var j=1; inp2!= null ;j++){
				elementSil (inp2);
				
				var inp3 = document.getElementById ("sil_"+tableLetters[i-1]+"_"+j+"_1"); 
				for (var k=1; inp3!= null ;k++){
					elementSil (inp3);
					inp3 = document.getElementById ("sil_"+tableLetters[i-1]+"_"+j+"_" + (k+1));
				}
				
				inp2 = document.getElementById ("ekle_"+tableLetters[i-1]+"_"+(j+1));
			}
		}
	}

}

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

function createAddGibValues (gorevArr, islemArr, basarimArr,dipnotArr, readOnly){
	var inp = "";
	
	if (gorevArr.length != 0){
		for (var i = 0; i < gorevArr.length; i++){
			addGibTable('gibTable', readOnly);
			inp = document.getElementById ("input_" + tableLetters[i]);
			inp.value = gorevArr[i];
		}
		
		for (var i = 0; i < islemArr.length; i++){
			inp = document.getElementById ("input_" + tableLetters[i]+"_1");
			inp.value = islemArr[i][0];
			
			for (var j = 1; j < islemArr[i].length; j++){
				islemEkle(tableLetters[i], readOnly);
				
				inp = document.getElementById ("input_" + tableLetters[i]+"_" +(j+1));
				inp.value = islemArr[i][j];
			}
		}
		
		var profil = 0;
		var tableLetter = "";
		var letterCount = 0;
		var boCount = 1;
		for (var i = 0; i < basarimArr.length; i++){
			for (var j = 1; j < basarimArr[i].length; j++){
				if (basarimArr[i][0] != profil){
					boCount = 1;
					profil = basarimArr[i][0];
					tableLetter = tableLetters[letterCount];
					letterCount++;
				}
				
				if (j < basarimArr[i].length-1)
					boEkle(tableLetter, boCount, readOnly);
				
				inp = document.getElementById ("input_" + tableLetter+"_"+ boCount +"_"+ j);
				inpDipnot = document.getElementById ("input_dipnot_" + tableLetter+"_"+ boCount +"_"+ j);
				inp.value = basarimArr[i][j];
				inpDipnot.value = dipnotArr[i][j];
	
			}	
			boCount ++;
		}
	}else{
		addGibTable('gibTable', readOnly);
	}
}

function addTableValues (arr, params, name, arrId, noRowAdd, colCount){
	
	//alert("addTableValues: "+arr);
	
	
	if (noRowAdd == null)
		noRowAdd = false;
	
	var addRowColCount  = params.length;
	
	if (colCount == null)
		colCount = addRowColCount;
	
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;
	
//	document.getElementById("rowNumber-"+name).value = rowNumber;
//	addNRow (name,addRowColCount,name);
//	if (!noRowAdd)
//		rowAdded(name, name);
//	document.getElementById("rowNumber-"+name).value = 1;
	for (var j = 0; j < rowNumber; j++)
		document.getElementById ("satirEkle_"+name).onclick();
	
//	fireOnchangeFuncs(arr, params, name);
	
	jQuery(document).ready(function() {
		//Add the values to table
		var count = 0;
		for (var i = 0; count < arrLength; i++){		
			if (isset (arrId) && arrId != null){
				var rowId =  "tablo_" + name + "_"+(i+1);
				var elementId = name+"_"+(i+1);
				
				var idInp = document.createElement("input");
				idInp.setAttribute("type", "hidden");
				idInp.setAttribute("id", elementId);
				idInp.setAttribute("name",elementId);
				idInp.setAttribute("value", arrId [i]);
				
				var rowInp = document.createElement("input");
				rowInp.setAttribute("type", "hidden");
				rowInp.setAttribute("id", rowId);
				rowInp.setAttribute("name",rowId);
				rowInp.setAttribute("value", "1");
				
				var mainDiv  = document.getElementById(name+"_div");
				mainDiv.appendChild (idInp);
				var tableRow = document.getElementById(rowId);
				tableRow.appendChild(rowInp);
			}
			
			for (var j = 0; j < colCount; j++){ 
				var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
				
			    if (params[j] == "text" || params[j] == "textarea"){
			    	item.value = arr[count];
			    	
			    }
			    else if (params[j] == "combo"){
			    	for (var k = 0; k < item.length; k++){
			        	if(item.options[k].value == arr[count]){
			        		item.selectedIndex = k;
			        		jQuery(item).change();
			    		}
			        }

			    }
			    else if(params[j]== "checkbox")
			    {
			    	
			    	if(arr[count]=="checked")
			    		item.checked = true;
			    	else
			    		item.checked = false;
			    } 
			    count++;  
			}
		}
	});
}

//function addTableValues (arr, arrId, params, name){
//	var colCount  = params.length;
//	var arrLength = arr.length;
//	var rowNumber = (arrLength/colCount)-1;
////alert (rowNumber+"-"+arrLength+"-"+colCount);
//	document.getElementById("rowNumber-"+name).value = rowNumber;
//	addNRow (name,colCount,name);
//	rowAdded(name, name);
//	document.getElementById("rowNumber-"+name).value = 1;
//	
//	//Add the values to table
//	var count = 0;
//	for (var i = 0; count < arrLength; i++){
//		var rowId =  "tablo_" + name + "_"+(i+1);
//		var elementId = name+"_"+(i+1);
//		
//		var idInp = document.createElement("input");
//		idInp.setAttribute("type", "hidden");
//		idInp.setAttribute("id", elementId);
//		idInp.setAttribute("name",elementId);
//		idInp.setAttribute("value", arrId [i]);
//		
//		var rowInp = document.createElement("input");
//		rowInp.setAttribute("type", "hidden");
//		rowInp.setAttribute("id", rowId);
//		rowInp.setAttribute("name",rowId);
//		rowInp.setAttribute("value", "1");
//		
//		var mainDiv  = document.getElementById(name+"_div");
//		mainDiv.appendChild (idInp);
//		var tableRow = document.getElementById(rowId);
//		tableRow.appendChild(rowInp);
//		
//		for (var j = 0; j < colCount; j++){ 
//			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
//			
//		    if (params[j] == "text" || params[j] == "textarea"){
//		    	item.value = arr[count];
//		    }else if (params[j] == "combo"){
//		    	for (var k = 0; k < item.length; k++){
//		        	if(item.options[k].value == arr[count])
//		            item.options[k].selected = "selected";
//		        }
//		    }else if (params[j] == "radio"){
//		    	var item2 = document.getElementsByName ('input'+name+'-'+(j+1)+'-'+(i+1)+'[]');
//		    	//alert("count"+item2.length+"item's value:"+item2[0].value+" arrays value:"+arr[count]);
//		    	for (var k = 0; k < item2.length; k++){
//		        	if(item2[k].value == arr[count])
//		            item2[k].checked = true;
//		        }
//		    }
//		    count++;  
//		}
//	}
//}

function userSubmit (index, standart_id){
	var action = "";

	action = "index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout=tum_basvuru&standart_id=" + standart_id+"&id="+index;
	
	var form = document.ChronoContact_meslek_std_taslak;
	form.action = action;
    form.submit();
}

function sektorSorumlusuSubmit (index, standart_id){
	var action = "";
	if (index == 1){
		action = "index.php?option=com_meslek_std_taslak&task=yorumlariGonder&standart_id=" + standart_id;
	}else if (index == 2){
		action = "index.php?option=com_meslek_std_taslak&task=onBasvuruOnayla&standart_id=" + standart_id;
	}else if (index == 3){
		action = "index.php?option=com_meslek_std_taslak&task=basvuruOnayla&standart_id=" + standart_id;
	}else if (index == 4){
		action = "index.php?option=com_meslek_std_taslak&task=basvuruKurulusaGonder&standart_id=" + standart_id;
	}
	
	var form = document.ChronoContact_meslek_std_taslak;
	form.action = action;
	
    if (form.onsubmit())
        form.submit();
}

function elementSil(element){
	element.parentNode.removeChild(element);
}

function isset(varname){
	return(typeof(varname)!="undefined");
}