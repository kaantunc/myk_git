function goToPage(page, evrak_id){
    var form = document.ChronoContact_akreditasyon_basvuru_t4; 
    form.action ='index.php?option=com_akreditasyon_basvur&Itemid=232&layout='+page+'&evrak_id='+evrak_id; 
    
    form.submit();
}

function basvuruGonder(evrak_id){
	var form = document.ChronoContact_akreditasyon_basvuru_t4; 
    form.action ='index.php?option=com_akreditasyon_basvur&layout=tum_basvuru'+'&evrak_id='+evrak_id; 
    
    form.submit();	
}

function addPanelValues (arry,name,panelCount, rowCount, skip){
	if (skip == null)
		skip = 0;
	
	var count = 0;
	if (arry.length != 0){
		for (var i = 1; i < (panelCount+1); i++){
			var elementId =  name+i;
			if(i == 1)
				elementId =  name;
			
			var idInp = document.createElement("input");
			idInp.setAttribute("type", "hidden");
			idInp.setAttribute("id", elementId);
			idInp.setAttribute("name", elementId);
			idInp.setAttribute("value", arry [count]);
			
			var mainDiv = document.getElementById(name + "_div");
			mainDiv.appendChild(idInp);

			count++;			
			for (var j = skip; j < rowCount+skip; j++){
				var itemId = 'input'+ name+i+'-'+(j+2)+'-'+(j+1); 
				if (i == 1) 
					itemId = 'input'+ name+'-'+(j+2)+'-'+(j+1);
      
				var item = document.getElementById (itemId);
				item.value = arry[count];
				count++;
			}
		}
	}
}

function addTableValues (arr, arrId, params, name, tname){
	if (tname == null)
		tname = name;

	var colCount = params.length;
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;

	//var item = document.getElementById("rowNumber-"+name);
	//item.value = rowNumber;
	//addNRow (name,''+colCount,tname);
	//item.value = 1;
	for (var j = 0; j < rowNumber; j++)
		document.getElementById ("satirEkle_"+name).onclick();
	
	//Add the values to table
	var count = 0;
	for (var i = 0; count < arrLength; i++){
		var elementId =  name+(i+1);
		
		var idInp = document.createElement("input");
		idInp.setAttribute("type", "hidden");
		idInp.setAttribute("id", elementId);
		idInp.setAttribute("name", name+"[]");
		idInp.setAttribute("value", arrId [i]);
		
		var mainDiv = document.getElementById(name + "_div");
		mainDiv.appendChild(idInp);
		
		for (var j = 0; j < colCount; j++){ 
			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
			
		    if (params[j] == "text"){
		    	item.value = arr[count];
		    }else if (params[j] == "combo"){
		    	for (var k = 0; k < item.length; k++){
		        	if(item.options[k].value == arr[count])
		            item.options[k].selected = "selected";
		        }
		    }
		    count++;  
		}
	}
}


function addTableValues_SeviyeComboMayNotHaveOption (arr, arrId, params, name, tname){
	if (tname == null)
		tname = name;

	var colCount = params.length;
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;

	//var item = document.getElementById("rowNumber-"+name);
	//item.value = rowNumber;
	//addNRow (name,''+colCount,tname);
	//item.value = 1;
	for (var j = 0; j < rowNumber; j++)
		document.getElementById ("satirEkle_"+name).onclick();
	
	//Add the values to table
	var count = 0;
	for (var i = 0; count < arrLength; i++){
		var elementId =  name+(i+1);
		
		var idInp = document.createElement("input");
		idInp.setAttribute("type", "hidden");
		idInp.setAttribute("id", elementId);
		idInp.setAttribute("name", name+"[]");
		idInp.setAttribute("value", arrId [i]);
		
		var mainDiv = document.getElementById(name + "_div");
		mainDiv.appendChild(idInp);
		
		for (var j = 0; j < colCount; j++){ 
			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
			
		    if (params[j] == "text"){
		    	item.value = arr[count];
		    }else if (params[j] == "combo"){
		    	var found = false;
		    	for (var k = 0; k < item.length; k++){
		        	if(item.options[k].value == arr[count])
		        	{	
		        		item.options[k].selected = "selected";
		        		found = true;
		        	}
		        	if(found==false)
		        		jQuery(item.options).removeAttr('selected').append('<option selected value="'+arr[count]+'">Seviye'+arr[count]+'</option>');
		        }
		    }
		    count++;  
		}
	}
}

function hideShowSelected (option, ids)
{	
    for(var i=0; i<ids.length; i++)  {
       document.getElementById(ids[i]).style.display = option[i];
    }	
}

function isset(varname){
	return(typeof(varname)!="undefined");
}

function elementSil(element){
	element.parentNode.removeChild(element);
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