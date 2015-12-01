<?php
defined('_JEXEC') or die('Restricted access'); 

// sekilCombo null değilse, seçenekleri göster


?>

<script type="text/javascript">


function yetSecildi(yetVal){

	//alert("merkezId: " + merkezInp.value);
		
	//var yetInpNo = merkezInpId.substring(merkezInpId.lastIndexOf('-')+1);

	//alert(yetInpNo);

	xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiSekilAl&format=raw',
			function (){
		return yetGetQueryString(yetVal);
	}, yetUpdatePageFunction);
	
}

function yetGetQueryString(yetVal){
	
	var merkezInp = document.getElementById('sinav_yeri');

	var merkezId = merkezInp.value;
	
	var qstr = 'yetId=' + yetVal + '&merkezId=' + merkezId;
	
	return qstr;
}

function removeAllOptions(selectbox){
	for(var i=selectbox.options.length-1;i>=0;i--)
		selectbox.remove(i);
}

function addOption(selectbox,text,value ){
	var optn = document.createElement("option");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function yetUpdatePageFunction(str){

	//var id='inputsinavTakvimi-4-5';

	//alert(str);

	var str2 = str.split("#*#");

	var id = 'sinav_sekli';
	var selectBox = document.getElementById(id);
	var rows = str2[1].split("**");
	removeAllOptions(selectBox);
	if(rows.length == 0 || rows[0] == ""){
		return;
	}
	
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var yetId = rowsAtt[0];
		var yetText = rowsAtt[1];

		addOption(selectBox, yetText, yetId);
		
	}
	selectBox.setAttribute("onclick","");
}


function checkOgr(rowNo, inputId){

	var kimlikNo = document.getElementById(inputId).value;

	if(kimlikNo==""){
		alert("TC Kimlik numarasını giriniz.");
		return;
	}
	
	xmlhttpPost(null, 'index.php?option=com_sinav&task=checkOgr&format=raw',
			function(){ return 'kimlik_no=' + kimlikNo + '&id='+ rowNo; }, checkOgrUpdatePageFunction);
}

function checkOgrUpdatePageFunction(str){
	var columns = str.split("#*#");
	
	if(columns[0]=="no"){
		alert("Bu öğrenci daha önce eklenmemiş, lütfen bilgilerini elle giriniz.");
		var id = columns[1];

		for(i=2;i<=8;i++){
			inp = document.getElementById("inputbelgeDuzenlenecekBilgi-" + i + "-" + id);
			dateButton = document.getElementById("datebuttonbelgeDuzenlenecekBilgi-" + i + "-" + id);
			if(dateButton != null)
				dateButton.removeAttribute("disabled");
			inp.removeAttribute("readonly");
		}
		
		return;
	}
	var id = columns[0];
	
	
	var inp;

	for(i=2;i<=8;i++){
		inp = document.getElementById("inputbelgeDuzenlenecekBilgi-" + i + "-" + id);
		inp.value = columns[i-1];
	}
		
}

dTables.belgeDuzenlenecekBilgi = new Array(
		new Array("text","required","6","","readonly"),
		new Array("text","required","15"),
		new Array("text","required","15","","readonly"),
		new Array("text","required","20","","readonly"),
		new Array("text","required date","10","date","readonly"),
		new Array("text","required","12","","readonly"),
		new Array("text","required","15","","readonly"),
		new Array("text","required","8","","readonly")
);

function createTables(){
	var tableName = "belgeDuzenlenecekBilgi";
	var headers = new Array('Sıra No',
							'TC Kimlik No',
							'Adı',
							'Soyadı',
							'Doğum Tarihi',
							'Doğum Yeri',
							'Baba Adı',
							'Kayıt No'
							);
		
	createTable(tableName,headers);

	
	//patchSatirEkle(tableName, headers, tableName);
	//patchEkleForDatePick(tableName, new Array ('5'));
	patchForOgrEkle(tableName, headers, new Array ('5'));
}

function ogrEkle(id){

	var rowNumber = document.getElementById("rowNumber-"+id).value;
	var inp = document.getElementById("input"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1));
	
	for(var i=0;i<rowNumber;i++){

		kimlikNo = inp.value;

		var buttonInp = document.createElement("input");
		buttonInp.setAttribute("id", "button"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1));
		buttonInp.setAttribute("type", "button");
		buttonInp.setAttribute("value", ">");
		//buttonInp.setAttribute("onclick", "checkOgr('"+(rowCounter[id]- rowNumber +1)+"', '"+"input"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1)+"')");

		buttonInp.onclick = function (){
			checkOgr((rowCounter[id]- rowNumber +1) , "input"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1));
		}

		inp.parentNode.appendChild(buttonInp);

		inp = document.getElementById("input"+id + "-2" + "-" + (rowCounter[id] - rowNumber +i +2));
	}
	
}

function patchForOgrEkle(id){
	satirNoObj[id]=1;
	var ekleInp = document.getElementById("satirEkle_"+id);
	
	ekleInp.onclick = function(){
		addNRow(id , headers.length , id);
		for (var i = 0; i < columnNoArr.length; i++){
			var columnNo = columnNoArr[i];
			addDatePick(id, columnNo);
		}
		ogrEkle (id);
		rowAdded(id, id);
		return true;
	};
	
	for (var i = 0; i < columnNoArr.length; i++){
		var columnNo = columnNoArr[i];	
		addDatePick(id, columnNo);
	}
	
	rowAdded(id, id);
	ogrEkle(id);
	
}

function merkezSecildi(inp){

	var value= inp.value;

	//alert(value);

	document.getElementById('merkezIdInp').value=value;

	document.sinav_merkez.submit();
	
}


</script>
<form method="POST" action="?option=com_sinav&view=sinav_oncesi" id="sinav_merkez" name="sinav_merkez">
<input type="hidden" value="" name="merkezId" id="merkezIdInp"></input>
<input type="hidden" value="" name="yetId" id="yetId"></input>
</form>
<div class="sinavGirisBaslik">Sınav Bilgileri</div>
<!-- <form method="POST" action="?option=com_sinav&task=sinavOncesiKaydet" id="sinav_oncesi_form" name="sinav_oncesi_form" onsubmit="return validate('sinav_oncesi_form')"> -->
<form method="POST" action="?option=com_sinav&view=sinav_oncesi_ozet" id="sinav_oncesi_form" name="sinav_oncesi_form" onsubmit="return validate('sinav_oncesi_form')">
<table>
	<tbody>
		<tr>
			<td width="170">Sınav Yeri</td>
			<td>
			<select id="sinav_yeri" class="comboReq" name="sinav_yeri" onchange="merkezSecildi(this)">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $this->yerCombo?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="170">Sınavın Yeterliliği</td>
<td>
<?php 

if(isset($this->yetCombo)){

?>
<select id="yeterlilik_konusu" class="comboReq" name="yeterlilik_konusu" onchange="yetSecildi(this.value)">
<option value="Seçiniz">Seçiniz</option>
<?php echo $this->yetCombo?>
</select>

<?php
}
else
	echo 'Sınav Yeri Seçiniz.';?>
</td>
		</tr>
		<tr>
			<td width="170">Sınav Türü</td>
			<td>
			<select id="sinav_turu" class="comboReq" name="sinav_turu">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $this->turCombo?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="170">Sınav Şekli</td>
			<td>
			<select id="sinav_sekli" name="sinav_sekli">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $this->sekilCombo?>
			</select>
			</td>
		</tr>
		<!-- <tr>
			<td width="170">Sınav Kapsamı</td>
<td>

<select id="sinav_kapsami" disabled="disabled" multiple="multiple" size="5" class="required" name="sinav_kapsami[]">
<option value="Seçiniz">Önce konuyu seçiniz.</option>
</select>
		</tr> -->
		<tr>
			<td width="170">Sınav Tarihi</td>
			<td><input type="text" id="inputsinav_tarihi"
				name="sinav_tarihi" size="12" class="required date">
				<input type="button" value="..." id="sinav_tarihi_button"></input></td>
		</tr>
		<tr>
			<td width="170">Sınavı Yapan Kişi(ler)</td>
			<td><input type="text" id="sinavi_yapan"
				name="sinavi_yapan" size="12" class="required"></td>
		</tr>
	</tbody>
</table>

<div class="sinavGirisBaslik">Sınava Katılacak Öğrenciler</div>
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div class="form_item">
  <div class="form_element cf_button">
    <input value="İleri" name="submitButton" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
    <script type="text/javascript">//<![CDATA[
	// bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
		var cal = Calendar.setup({
	    onSelect: function(cal) { cal.hide() }
	});

      cal.manageFields("sinav_tarihi_button", "inputsinav_tarihi", "%d.%m.%Y");
      
    //]]></script>
