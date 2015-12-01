function goToPage(view,page,tckimlik){
    var form = document.ChronoContact_uzman_basvuru_t4; 
//    form.action ='index.php?option=com_uzman_basvur&layout='+page; 
    
//    form.submit();
    window.location='index.php?option=com_uzman_basvur&view='+view+'&layout='+page+'&tc_kimlik='+tckimlik;

}

function basvuruGonder(){
	var form = document.ChronoContact_uzman_basvuru_t4; 
    form.action ='index.php?option=com_uzman_basvur&layout=tum_basvuru'; 
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

function hideShowSelected (option, ids)
{	
    for(i=0; i<ids.length; i++)  {
       document.getElementById(ids[i]).style.display = option[i];
    }	
}

function isset(varname){
	return(typeof(varname)!="undefined");
}

function elementSil(element){
	element.parentNode.removeChild(element);
}