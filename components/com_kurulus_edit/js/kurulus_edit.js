
function goToPage(pageName, tur, id){
	var form = document.kurulus_edit_form; 
	var action = 'index.php?option=com_kurulus_edit&layout='+pageName+'&tur='+tur+'&id='+id;

    form.action = action; 
	form.submit();
}

function addTableValues (arr, arrId, params, name, silFunc){
	var colCount  = params.length;
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;

	document.getElementById("rowNumber-"+name).value = rowNumber;
	addNRow (name,colCount,name);
//	rowAdded(name, name);
	document.getElementById("rowNumber-"+name).value = 1;
	
	//Add the values to table
	var count = 0;
	for (var i = 0; count < arrLength; i++){
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
		
		if (silFunc){
			var silButton = document.getElementById("satirSil_"+name+"-"+(i+1));
			silButton.onclick = newDeleteRowFunc(name,(i+1),arrId [i]);
		}
		
		for (var j = 0; j < colCount; j++){ 
			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
			
		    if (params[j] == "text" || params[j] == "textarea"){
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

function changeEditStatus (){
	var duzenlemeButton = document.getElementById ("duzenleme");
	var editable = document.getElementById ("editable");

	if (editable.value == "0"){
		duzenlemeButton.value = "Liste Onaylandı";
		duzenlemeButton.style.backgroundColor = 'rgb(100,150,100)';
		editable.value = 1;
	}else{
		duzenlemeButton.value = "Liste Onaylanmadı";
		duzenlemeButton.style.backgroundColor = 'rgb(170,0,0)';
		editable.value = 0;
	}
}

function isset(varname){
	return(typeof(varname)!="undefined");
}

