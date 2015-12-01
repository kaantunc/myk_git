<?php
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
var ogrler = new Array();
</script>
<?php
$this->ogrenciler;
$i=0;
foreach($this->ogrenciler AS $ogrenci){
	
//	echo '<pre>';
//	print_r($ogrenci);	
//	echo '</pre>';
	
	?>
		<script type="text/javascript">
		
		ogrler[<?php echo $i?>] = new Array(7);
		ogrler[<?php echo $i?>][0] = "<?php echo $ogrenci['TC_KIMLIK']?>";
		ogrler[<?php echo $i?>][1] = "<?php echo $ogrenci['OGRENCI_ADI']?>";
		ogrler[<?php echo $i?>][2] = "<?php echo $ogrenci['OGRENCI_SOYADI']?>";
		ogrler[<?php echo $i?>][3] = "<?php echo $ogrenci['OGRENCI_DOGUM_TARIHI']?>";
		ogrler[<?php echo $i?>][4] = "<?php echo $ogrenci['OGRENCI_DOGUM_YERI']?>";
		ogrler[<?php echo $i?>][5] = "<?php echo $ogrenci['OGRENCI_BABA_ADI']?>";
		ogrler[<?php echo $i?>][6] = "<?php echo $ogrenci['OGRENCI_KAYIT_NO']?>";
		</script>
	<?php
	$i++;
}

?>

<script type="text/javascript">

var str = "<?php echo $this->kapsamlar?>";

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
	str = trim(str, "\0");
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
		new Array("text","required","15","","readonly"),
		new Array("text","required","15","","readonly"),
		new Array("text","required","20","","readonly"),
		new Array("text","required date","10","","readonly"),
		new Array("text","required","12","","readonly"),
		new Array("text","required","15","","readonly"),
		new Array("text","required","8","","readonly")
);

var element = new Array("listbox");
var comboArray = new Array();
comboArray.push(new Array("BAŞARISIZ","BAŞARISIZ"));
var options = str.split("**");

for(var i=0;i<options.length;i++){
	var optAtt = options[i].split("##");
	var optId = optAtt[0];
	var optName = optAtt[1];
	comboArray.push(new Array(optId,optName));
}
element.push(comboArray)
element.push("required comboReq","kapsamSecildi(this)","5");
//element.push("comboReq","","5");

dTables.belgeDuzenlenecekBilgi.push(element);

function kapsamSecildi(combo){
	
	for(var i=0;i<combo.options.length;i++){
	
		if(combo.options[i].selected && combo.options[i].value == "BAŞARISIZ"){
			for(var j=0;j<combo.options.length;j++)
				if(j!=i)
					combo.options[j].selected = false;
		}
	
	}

}

function createTables(){
	var tableName = "belgeDuzenlenecekBilgi";
	var headers = new Array('Sıra No',
							'TC Kimlik No',
							'Adı',
							'Soyadı',
							'Doğum Tarihi',
							'Doğum Yeri',
							'Baba Adı',
							'Kayıt No',
							'Yeterlilik Kapsamı'
							);
	
	createTable(tableName,headers);
	//patchSatirEkle("belgeDuzenlenecekBilgi");
	//patchEkleForDatePick("belgeDuzenlenecekBilgi", 5);
	patchForOgrEkle(tableName,headers);

	var toplamAday = <?php echo count($this->ogrenciler)?>;
	
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

	// ogr verilerini ekle
	for(var i=0;i<toplamAday;i++){
		for(var j=0;j<=6;j++){
			
			var inp = document.getElementById("inputbelgeDuzenlenecekBilgi-"+(j+2)+"-"+(i+1));

			inp.value = ogrler[i][j];

		}
	}
	
}

function ogrEkle(id){
/*
	var rowNumber = document.getElementById("rowNumber-"+id).value;
	var inp = document.getElementById("input"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1));
	
	for(var i=0;i<rowNumber;i++){

		kimlikNo = inp.value;

		var buttonInp = document.createElement("input");
		buttonInp.setAttribute("id", "button"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1));
		buttonInp.setAttribute("type", "button");
		buttonInp.setAttribute("value", ">");
		buttonInp.setAttribute("onclick", "checkOgr('"+(rowCounter[id]- rowNumber +1)+"', '"+"input"+id + "-2" + "-" + (rowCounter[id]- rowNumber +1)+"')");

		inp.parentNode.appendChild(buttonInp);

		inp = document.getElementById("input"+id + "-2" + "-" + (rowCounter[id] - rowNumber +i +2));
	}
	*/
}

function patchForOgrEkle(id , headers){
	satirNoObj[id]=1;
	var ekleInp = document.getElementById("satirEkle_"+id);

	ekleInp.onclick = function(){
		addNRow(id , headers.length , id);
		rowAdded(id, id);
		ogrEkle(id);
	    return true;
	};
	
	rowAdded(id, id);
	
//	var ekleInp = document.getElementById("satirEkle_"+id);
//	var onclick = ekleInp.getAttribute("onclick");
//	ekleInp.setAttribute("onclick",onclick+";ogrEkle('"+id+"')");
//	//alert(onclick);
//		//document.getElementById("satirEkle_"+id).setAttribute("onclick","");
	ogrEkle(id);
	
}



</script>

<!--<form method="POST"-->
<!--		action="?option=com_sinav&task=sertifikaKaydet"-->
<!--		id="sinav_oncesi_form"-->
<!--		name="sinav_oncesi_form"-->
<!--		onsubmit="return validate('sinav_oncesi_form')">-->

<form method="POST"
		action="?option=com_sinav&view=sertifika_ozet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">

<input type="hidden" name="sinavIds" value="<?php echo $this->sinavIds?>"></input>

<div class="sinavGirisBaslik">Seçilen Sınavlar</div>

<table style="width:750px" cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-date-dmy">Sınav Tarihi</th>
		<th class="sortable-text">Sınav Merkezi</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Sınav Türü</th>
		<th class="sortable-text">Sınav Şekli</th>
		<th class="sortable-numeric">Toplam Aday</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($this->sinavlar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'" style="text-align:center;">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.($satir['SINAV_TARIHI_FORMATTED']?$satir['SINAV_TARIHI_FORMATTED']:"&nsbp;").'</td>';
			echo '<td>'.($satir['MERKEZ_ADI']?$satir['MERKEZ_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['YETERLILIK_ADI']?$satir['YETERLILIK_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_TUR_ADI']?$satir['SINAV_TUR_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_SEKLI_ADI']?$satir['SINAV_SEKLI_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['TOPLAM_ADAY']?$satir['TOPLAM_ADAY']:"&nsbp;").'</td>';
			
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
<br />
<div class="sinavGirisBaslik">Öğrenciler</div>
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div class="form_item">
  <div class="form_element cf_button">
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
    <input value="İleri" name="submitButton" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
