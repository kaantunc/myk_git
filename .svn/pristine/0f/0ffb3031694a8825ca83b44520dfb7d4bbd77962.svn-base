<?php
defined('_JEXEC') or die('Restricted access');

$takvimYili = isset($_POST['takvim_yili']) ? $_POST['takvim_yili'] : "";

?>

<script type="text/javascript">

dTables.sinavTakvimi = new Array(
		new Array("text","required","6"),
		new Array("text","required date","12","date"),
		/*new Array("text","required","25"),*/
		new Array( "combo",
				new Array(
			new Array("Seçiniz", "Seçiniz")<?php echo $this->yerCombo?>),"comboReq","merkezSecildi(this.id,this.value)"),
		new Array( "combo",
					new Array(),"comboReq")
);

function createTables(){
	var tableName = "sinavTakvimi";
	var headers = new Array('Sıra No',
							'Sınav Tarihi',
							'Sınav Yeri',
							'Yeterlilik'/*,
							'Sınav Kapsamı'*/
							);
	//yeterlilikleriAl();
	createTable(tableName, headers);
	patchSatirEkleWithDatePick (tableName, headers,new Array ('2'), tableName);

	jQuery('#sinavTakvimiFormu').hide();
	//document.getElementById('sinavTakvimiFormu').visibility = 'hidden';
	//xmlhttpPost(null, 'index.php?option=com_sinav&task=kapsamAl&format=raw', kapsamGetQueryString, kapsamUpdatePageFunction);


	if(<?php echo isset($_POST['mode'])? "1" : "0";?>){

		jQuery('#sinav_takvim_yili_div').hide();

		jQuery('#takvim_yili')[0].value = "<?php echo $takvimYili;?>";
		
		jQuery('#sinavTakvimiFormu').show();

		//daha önce eklenmiş kayıtları getir doldur tabloyu 
		
		xmlhttpPost(null, 'index.php?option=com_sinav&task=takvimAl&format=raw',
				function (){
					return 'takvimYili=' + "<?php echo $takvimYili;?>" + '&mode=taslak';
				},
				getTakvimUpdate);
		
	}
	
}

function getTakvimQueryString(takvimYili){
	
	var qstr = 'takvimYili=' + takvimYili;
	//alert("qstr: " + qstr);
	return qstr;
	
}

function getTakvimUpdate(str){

	//alert(str);

	if(str == "no"){
		alert("Daha önce seçilen yıl için sınav takvimi bildirmemişsiniz. Şimdi Bildirebilirsiniz.");
		
		var rowCount = getCounter('sinavTakvimi');

		// önceki satırları sil
		for(var i=1;i<=rowCount;i++){
			deleteRow("tablo_sinavTakvimi_"+i);
			rowDeleted('sinavTakvimi');
			rowCounter['sinavTakvimi']--;
		}

		// boş bir tane satır ekle
		addNRow('sinavTakvimi','4','sinavTakvimi');
		rowAdded('sinavTakvimi','sinavTakvimi');
		addDatePick('sinavTakvimi','2');

		return;
	}

	var rowCount = getCounter('sinavTakvimi');

	// önceki satırları sil
	for(var i=1;i<=rowCount;i++){
		deleteRow("tablo_sinavTakvimi_"+i);
		rowDeleted('sinavTakvimi');
		rowCounter['sinavTakvimi']--;
	}

	// boş bir tane satır ekle
	addNRow('sinavTakvimi','4','sinavTakvimi');
	rowAdded('sinavTakvimi','sinavTakvimi');
	addDatePick('sinavTakvimi','2');

	var rows = str.split("**");
	
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var tarih = rowsAtt[0];
		var yer = rowsAtt[1];

		var yetVals = rowsAtt[2].split("#*#");
		var yetId = yetVals[0];
		var yetAd = yetVals[1];

		var siradakiRow = getCounter('sinavTakvimi');

		// tarih
		var id="inputsinavTakvimi-2-"+siradakiRow;
		var inp = document.getElementById(id);
		inp.value = tarih;

		if(i+1 != rows.length){
			addNRow('sinavTakvimi','4','sinavTakvimi');
			rowAdded('sinavTakvimi','sinavTakvimi');
			addDatePick('sinavTakvimi','2');
		}

		// Sınav Merkezi
		id="inputsinavTakvimi-3-"+siradakiRow;
		var merkezInp = document.getElementById(id);
		merkezInp.value = yer;

		// yeterlilikler 
		id="inputsinavTakvimi-4-"+siradakiRow;
		inp = document.getElementById(id);

		inp.setAttribute("onclick","merkezSecildi('"+merkezInp.id+"', '"+ merkezInp.value +"')");
		
		removeAllOptions(inp);
		addOption(inp, yetAd, yetId);
		
	}
	
}

function yilSecildi(takvimYili){
	
	if(takvimYili == "Seçiniz")
		return;

	jQuery('#sinavTakvimiFormu').show();

	//daha önce eklenmiş kayıtları getir doldur tabloyu 
	
	xmlhttpPost(null, 'index.php?option=com_sinav&task=takvimAl&format=raw',
			function (){
				return getTakvimQueryString(takvimYili);
			},
			getTakvimUpdate);
	
}

function merkezSecildi(merkezInpId, merkezInpVal){

	//alert("merkezId: " + merkezInp.value);
		
	var yetInpNo = merkezInpId.substring(merkezInpId.lastIndexOf('-')+1);

	//alert(yetInpNo);

	xmlhttpPost(null, 'index.php?option=com_sinav&task=merkezYeterlilik&format=raw',
			function (){
		return yetGetQueryString(merkezInpVal, yetInpNo);
	}, yetUpdatePageFunction);
	
}

function yetGetQueryString(merkezId, yetInpNo){
	var qstr = 'merkezId=' + merkezId + '&yetInpNo='+ yetInpNo;
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

	var id = 'inputsinavTakvimi-4-' + str2[0];
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

</script>

<div class="sinavGirisBaslik">Yıllık Sınav Takvimi Gir</div>

<form id="sinavTakvimiForm" action="?option=com_sinav&task=takvimKaydet" method="post" onsubmit="return validate('sinavTakvimiForm')">
	<input name="mode" value="taslak" type="hidden"></input>
	
	<div id="sinav_takvim_yili_div">
	Sınav Takvimi Yılı
	<select name="takvim_yili" id="takvim_yili" onchange="yilSecildi(this.value)">
		<option value="Seçiniz">Seçiniz</option>
		<?php echo $this->yilCombo?>
	</select>
	</div>
	<div id="sinavTakvimiFormu">
	<div id="sinavTakvimi_div"></div>
	<br />
	<input type="submit" value="İleri" />
	</div>
</form>

    <script type="text/javascript">//<![CDATA[
	// bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
		var cal = Calendar.setup({
	    onSelect: function(cal) { cal.hide() }
	});
      
    //]]></script>
