<?php
defined('_JEXEC') or die('Restricted access'); 

require_once('libraries'.DS.'form'.DS.'form.php');

// sekilCombo null değilse, seÃ§enekleri gÃ¶ster

$postData = $this->postData;
$sinavOncesiAdlar = $this->sinavOncesiAdlar;

$bilgiValues = array ();
$sekilStr = '';
$yetStr = '';
$rowNumber = 0;


$yeterlilikKonusu = isset($postData['yeterlilik_konusu']) ? $postData['yeterlilik_konusu'] : '';
$sinavYeri = isset($postData['sinav_yeri']) ? $postData['sinav_yeri'] : '';
//$sinavTuru = isset($postData['sinav_turu']) ? $postData['sinav_turu'] : '';
$sinavSekli = isset($postData['sinav_sekli']) ? $postData['sinav_sekli'] : '';
$sinavTarihi = isset($postData['sinav_tarihi']) ? $postData['sinav_tarihi'] : '';
$sinavGozetmen = isset($postData['sinav_gozetmen']) ? $postData['sinav_gozetmen'] : '';
$sinavDegerlendirici = isset($postData['sinav_degerlendirici']) ? $postData['sinav_degerlendirici'] : '';


if($postData){
	
	$rowNumber = count($postData['inputbelgeDuzenlenecekBilgi-1']);
	
	$bilgiValues = FormFactory::getTableValues($postData, array("belgeDuzenlenecekBilgi", 9));
	
	$session =&JFactory::getSession();
	$altBirimStr = $session->get('sinavOncesiAltBirim');
	print_r($altBirimStr);
	$yetStr = array("value"=>$sinavOncesiAdlar[1], "id"=>$postData['yeterlilik_konusu']);
	$tarihStr = array("value"=>$postData['sinav_tarihi']);
	$sekilStr = array("value"=>$sinavOncesiAdlar[3], "id"=>$postData['sinav_sekli']);
	//$yetStr = $session->get('sinavOncesiYet');
	$merkezStr = array("value"=>$sinavOncesiAdlar[0], "id"=>$postData['sinav_yeri']);
}
?>

<script type="text/javascript">
alert("İşlem yapabilmek için lütfen ilk önce 'Sınavın Yeterliliği''ni seçiniz!!!");
var user_id = <?php echo $this->user_id;?>;
var degerarray = new Array();
var degerarrayId = new Array();
var turp;
var altbirim;
var kackac;
var sinavbirimler;
var myarray = new Array();
var myaltarray = new Array();
var sinavArray = new Array();
jQuery(document).ready(function(){
	jQuery('.sinavbirimisec').hide();
	jQuery('#satirEkle_belgeDuzenlenecekBilgi').hide();
	jQuery('#rowNumber-belgeDuzenlenecekBilgi').hide();
	jQuery(".ui-datepicker-trigger").hide();
	jQuery(".tarihsecbuton").hide();	
});
function yetSecildi(yetVal){
	myarray = new Array();
	myaltarray = new Array();
/*	xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiMerkezAl&format=raw',
			function (){
		return yetGetQueryString(yetVal, user_id);
	}, yetUpdatePageFunction);*/

	var sendData = 'yetId=' + yetVal + '&user_id='+user_id;
	var url = 'index.php?option=com_sinav&task=sinavOncesiMerkezAl&format=raw';
    	jQuery.ajax({
    		  url: url,
    		  data: sendData,
    		  type: "POST",
    		  dataType: 'json',
    		  success: function(data) {
    			  if(data['success']){
    				  yetUpdatePageFunction(data['array'][0][0]);
    				  degerlendiriciUpdatePageFunction(data['array'][1]);
    				  
     			  }else{
    				  alert("Hata oluştu");
    			  }
    		  }
    	});	

}


function yetGetQueryString(yetVal, user_id){
	
	var qstr = 'yetId='+yetVal+'&user_id='+user_id;
	
	return qstr;
}

function degerlendiriciUpdatePageFunction(str){
	turp = '';
	var id="sinav_degerlendirici";
	var altInp = document.getElementById(id);
	altInp.value = '';
	
	
		for(var ii = 0; ii < str.length; ii++){
			turp += '<span><input type="checkbox" class="'+ii+str[ii]['DEGERLENDIRICI'].replace(' ', '_')+'" id="'+ii+str[ii]['DEGERLENDIRICI'].replace(' ', '_')+'" value="'+str[ii]['DEGERLENDIRICI']+'"/>		'+str[ii]['DEGERLENDIRICI']+'</span><br/>';
			degerarray[ii] = str[ii]['DEGERLENDIRICI'];
			degerarrayId[ii] = ii+str[ii]['DEGERLENDIRICI'].replace(' ', '_');
		}
	
	//alert(str[0]['DEGERLENDIRICI']);
}

function removeAllOptions(selectbox){
	for(var i=selectbox.options.length-1;i>=0;i--)
		selectbox.remove(i);
}

function addOption(selectbox, text, value, id, degis){
	var optn = document.createElement("option");
	optn.text = text;
	optn.value = value;
	optn.id = id;
	optn.setAttribute("onclick", degis+"(this)");
	selectbox.options.add(optn);
}


function yetUpdatePageFunction(str){
	
	str = trim(str, "\0");

	var str2 = str.split("#*#");

	var id = 'sinav_yeri';
	var selectBox = document.getElementById(id);
	var rows = str2[1].split("**");
	removeAllOptions(selectBox);
	if(rows.length == 0 || rows[0] == ""){
		return;
	}
	
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var merkezId = rowsAtt[0];
		var merkezText = rowsAtt[1];
		var yetId = rowsAtt[2];
		
		addOption(selectBox, merkezText, merkezId, yetId, 'merkezSecildi');
		if(i == 0){
			xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiTarihAl&format=raw',
					function (){
				return tarihGetQueryString(merkezId,yetId);
			}, tarihUpdatePageFunction);
			}
		
	}
	
}



function BirimGetQueryString(merkezId, yetId,tarih){
		
	var qstr = 'merkezId=' + merkezId + '&yetId=' + yetId + '&tarih=' + tarih;
	
	return qstr;
}

function BirimUpdatePageFunction(str){
jQuery('div #popupid').remove();
jQuery('input .sinavbirimisec').val('');
sinavbirimler = '';	
kackac = '';
var anabirim ='';
myarray['sinav_sekli'] = '';

	
	var str2 = str.split("#*#");
	var rows = str2[1].split("**");
	var rowsuzunluk = rows.length*2;
	
	altbirim = new Array(rowsuzunluk);
	
	for(var jj = 0; jj<rowsuzunluk; jj++){
		altbirim[jj] = new Array(4);
		}
	
	if(rows.length == 0 || rows[0] == ""){
		return;
	}

	var uzunlukfark = rowsuzunluk - rows.length;
		
		for(var i=0; i<rows.length; i++){
			var rowsAtt = rows[i].split("##");
			if(rowsAtt[4] == 0){
				if(rowsAtt[3] == 0){
					altbirim[i][1] = rowsAtt[2]+'/T1';
					altbirim[i][2] = rowsAtt[0]+'_0';
					altbirim[i][3] = rowsAtt[0]+'_0';
					}
				else{
					altbirim[i][1] = rowsAtt[2]+'/P1';
					altbirim[i][2] = rowsAtt[0]+'_1';
					altbirim[i][3] = rowsAtt[0]+'_1';
				}
				altbirim[i][0] = rowsAtt[1];
				anabirim = rowsAtt[5];
			}
			else if(rowsAtt[4] == 1){
					altbirim[i][0] = rowsAtt[1];
					altbirim[i][1] = rowsAtt[2]+rowsAtt[3]+rowsAtt[5];
					altbirim[i][2] = rowsAtt[0]+'_'+rowsAtt[3]+rowsAtt[5];
					altbirim[i][3] = rowsAtt[7];
					anabirim = rowsAtt[8];
				}
			}
		
		
	
	for(var jj = 0; jj < altbirim.length; jj++){
		if(altbirim[jj][2] != undefined){
			kackac += '<span><input type="checkbox" class="'+altbirim[jj][3]+'" id="'+altbirim[jj][2]+'" value="Ekle"/>		'+altbirim[jj][0]+' ('+altbirim[jj][1]+') </span><br/>';
			sinavbirimler +='<p>'+altbirim[jj][3]+'-	'+altbirim[jj][0]+' ('+altbirim[jj][1]+')</p>';
			}
		
	}

	id="sinav_sekli";
	var altInp = document.getElementById(id);
	altInp.value = anabirim;
	myarray['sinav_sekli'] = sinavbirimler;
	sinavbirimler = '';	
	//jQuery('.sinavbirimisec').attr("disabled",false);
	
	jQuery('.sinavbirimisec').show();
	jQuery('#rowNumber-belgeDuzenlenecekBilgi').show();
	jQuery('#satirEkle_belgeDuzenlenecekBilgi').show();
}


function tarihGetQueryString(merkezId, yetId){
		
	var qstr = 'merkezId=' + merkezId + '&yetId=' + yetId;
	
	return qstr;
}


function tarihUpdatePageFunction(str){

	
	str = trim(str, "\0");

	var str2 = str.split("#*#");

	var id = 'sinav_tarihi';
	var selectBox = document.getElementById(id);
	var rows = str2[1].split("**");
	removeAllOptions(selectBox);
	if(rows.length == 0 || rows[0] == ""){
		return;
	}
	
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var merkezId = rowsAtt[0];
		var tarihText = rowsAtt[1];
		var yetId = rowsAtt[2];

		addOption(selectBox, tarihText, tarihText, yetId, 'tarihSecildi');
		if(i == 0){
			xmlhttpPost(null, 'index.php?option=com_sinav&task=SinavOncesiBirimAl&format=raw',
					function (){
				return BirimGetQueryString(merkezId, yetId, tarihText);
			}, BirimUpdatePageFunction);
			}
		
		
		/*ÖNEMLİ//xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiAltBirim&format=raw',
				function (){
			return altBirimGetQueryString(yetId);
		}, altBirimUpdatePageFunction);*/
	}
	//selectBox.setAttribute("onchange", (merkezId+', '+yetId+', '+tarihText));
}
//sekil secildi son

function tarihSecildi(inp){
	yetId = inp.id;
	tarih = inp.value;
	//tarih = inp.text;
	xmlhttpPost(null, 'index.php?option=com_sinav&task=SinavOncesiBirimAl&format=raw',
			function (){
		return BirimGetQueryString(null ,yetId, tarih);
	}, BirimUpdatePageFunction);
}


//merkezGeriAl Bas
function merkezGeriAl(value, merkezid){
	var id = 'sinav_yeri';
	var selectBox = document.getElementById(id);
	addOption(selectBox, value, merkezid);
}
//merkezGeriAl Son

//yetGeriAl Bas
function yetGeriAl(value, yetid){
	var id = 'yeterlilik_konusu';
	var selectBox = document.getElementById(id);
	addOption(selectBox, value, yetid);
	xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiAltBirim&format=raw',
			function (){
		return altBirimGetQueryString(yetid);
	}, altBirimUpdatePageFunction);
}
//yetGeriAl Son

//sinavSekilGeriAl Bas
function sinavSekilGeriAl(value, sekilid){
	var id = 'sinav_sekli';
	var selectBox = document.getElementById(id);
	addOption(selectBox, value, sekilid);
}
//sinavSekilGeriAl Son

//sinavSekilGeriAl Bas
function tarihGeriAl(value){
	var id = 'sinav_tarihi';
	var selectBox = document.getElementById(id);
	addOption(selectBox, value, "1");
}
//sinavSekilGeriAl Son

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
		alert("Bu öğrenci daha önce eklenmemidi, lütfen bilgilerini elle giriniz.");
		var id = columns[1];

		for(i=2;i<=9;i++){
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

	for(i=2;i<=9;i++){
		inp = document.getElementById("inputbelgeDuzenlenecekBilgi-" + i + "-" + id);
		inp.value = columns[i-1];
	}
		
}

dTables.belgeDuzenlenecekBilgi = new Array(
		new Array("text","required","4","","readonly"),
		new Array("text","required","15"),
		new Array("text","required","15",""),
		new Array("text","required","15",""),
		new Array("text","required date","8","date","readonly"),
		new Array("text","required","12",""),
		new Array("text","required","15",""),
		new Array("text","required","8",""),
		new Array("img","sinavbirimisec","images/info-icon.png")
		//new Array("hidden","sinavbirimisec","12","","",true),
);

function createTables(){
	var tableName = "belgeDuzenlenecekBilgi";
	var headers = new Array('Sıra No',
							'TC Kimlik No',
							'Adı',
							'SoyAdı',
							'Doğum Tarihi',
							'Doğum Yeri',
							'Baba Adı',
							'Kurulus Kayıt No',
							'Yeterlilik Birimleri'
							);
		
	createTable(tableName,headers);

	
	patchForOgrEkle(tableName, headers, new Array ('5'));

	if(<?php echo $postData ? 1 : 0?>){

		var ogrlerStr = "<?php echo implode(',',$bilgiValues)?>";

		var ogrler = ogrlerStr.split(',');

		var sinavYeri = document.getElementById('sinav_yeri');
		var yeterlilikKonusu = document.getElementById('yeterlilik_konusu');
		var sinavTuru = document.getElementById('sinav_turu');
		var sinavSekli = document.getElementById('sinav_sekli');
		var sinavTarihi = document.getElementById('sinav_tarihi');
		var sinavGozetmen = document.getElementById('sinav_gozetmen');
		var sinavDegerlendirici = document.getElementById('sinav_degerlendirici');

		//sinavYeri.options[1].selected = "1";
		
		merkezGeriAl("<?php echo $merkezStr["value"];?>","<?php echo $merkezStr["id"];?>");
		yetGeriAl("<?php echo $yetStr["value"];?>","<?php echo $yetStr["id"];?>");
		sinavSekilGeriAl("<?php echo $sekilStr["value"];?>","<?php echo $sekilStr["id"];?>");
		tarihGeriAl("<?php echo $tarihStr["value"]?>");
		
		sinavYeri.value = "<?php echo $sinavYeri?>";
		yeterlilikKonusu.value = "<?php echo $yeterlilikKonusu?>";
		sinavTuru.value = "<?php echo $sinavTuru?>";
		sinavSekli.value = "<?php echo $sinavSekli?>";
		sinavTarihi.value = "<?php echo $sinavTarihi?>";
		sinavGozetmen.value = "<?php echo $sinavGozetmen?>";
		sinavDegerlendirici.value = "<?php echo $sinavDegerlendirici?>";

		for(var i=0;i<<?php echo $rowNumber - 1?>;i++){
			addNRow('belgeDuzenlenecekBilgi','9','belgeDuzenlenecekBilgi');
			rowAdded('belgeDuzenlenecekBilgi','belgeDuzenlenecekBilgi');
			addDatePick('belgeDuzenlenecekBilgi','5');
			ogrEkle('belgeDuzenlenecekBilgi');
		}
		

		for(var colNo=2;colNo<=9;colNo++){
			for(var rowNo = 1; rowNo <= <?php echo $rowNumber ?>;rowNo++ ){
				//alert('inputbelgeDuzenlenecekBilgi-' + colNo + '-' + rowNo);
				var inpCol = document.getElementById('inputbelgeDuzenlenecekBilgi-' + colNo + '-' + rowNo);
				//var inp = inpCol[rowNo];

				// get table values la array ÅŸeklinde getir sonra al sirayla
				inpCol.value = ogrler[(rowNo-1)*9 + colNo -1];
				
			}
		}

		
	}
	
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

function patchForOgrEkle(id, headers, columnNoArr){
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

	var merkezId = inp.value;
	var yetId = inp.id;

	xmlhttpPost(null, 'index.php?option=com_sinav&task=sinavOncesiTarihAl&format=raw',
			function (){
		return tarihGetQueryString(merkezId,yetId);
	}, tarihUpdatePageFunction);
	
}

jQuery(document).ready(function(){
	var altbirimId;
	jQuery('#satirEkle_belgeDuzenlenecekBilgi').live("click",function(){
		//jQuery('.sinavbirimisec').attr("disabled",false);
		jQuery('.sinavbirimisec').show();
			});
	
	//monthYear
		jQuery(".date").live("hover",function(){
			jQuery(".ui-datepicker-trigger").hide();
			jQuery(".tarihsecbuton").hide();
			jQuery(this).datepicker({
				showOn: "both",
				title:"",
				//buttonImage: "images/calendar.png",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,			
				yearRange: '-70:+10'
			});
		});
	//monthYear


//ANABirimleri Al
jQuery('.sinav_sekil').live('click', function(){
			 altbirimId = jQuery(this).attr('id');
			 jQuery('.'+altbirimId).remove();
			 var altbirimdiv = '<div class="'+altbirimId+'" style="overflow-y:auto; padding:10px; width:400px; height:450px; background-color:white; display:none;">'+myarray[altbirimId]+'</div>';
			 if(!jQuery.contains(jQuery('body').html(), 'class="'+altbirimId+'"')){
				 jQuery('#Anabirimler').html(altbirimdiv);
				} 
				jQuery('.'+altbirimId).lightbox_me({
			        centered: true, 
			    });
});

//ANABirimleri Al SON
	
//Degerlendirici
jQuery('#sinav_degerlendirici').live('click', function(){
			 degerId = jQuery(this).attr('id');
			 //jQuery('.'+altbirimId).remove();
			 var altbirimdiv1 = '<div class="'+degerId+'" style="overflow-y:auto; padding:10px; width:400px; height:450px; background-color:white; display:none;">'+turp+'<input type="button" class="degerbitir" id="degerlendirici" value="Bitir"/></div>';
			 if(!jQuery.contains(jQuery('body').html(), 'class="'+degerId+'"')){
				 jQuery('#Degerlen').html(altbirimdiv1);
				} 
				jQuery('.'+degerId).lightbox_me({
			        centered: true, 
			    });

				
});

jQuery('.degerbitir').live('click',function(){
	var degerbitirId = 'sinav_'+jQuery(this).attr('id');
	var degeryaz = '';
	
	for(var kk = 0; kk < degerarray.length; kk++){
		
		var checck = jQuery('#'+degerarrayId[kk]).attr('checked')?true:false;
		if(checck == true){
			if(kk == (degerarray.length-1)){
				degeryaz += degerarray[kk];
				}
			else{	
				degeryaz += degerarray[kk]+',';
			}
			}
		else{
			}
		}

	jQuery('#'+degerbitirId).val(degeryaz);
	jQuery(".degerbitir").trigger("close");
	});

//Degerlendirici

//sinavbirimisecbas
		jQuery('.sinavbirimisec').live('click', function(e){
			 e.preventDefault();
			 altbirimId = jQuery(this).attr('id');
			 if(myarray[altbirimId] == undefined){
				 myaltarray[altbirimId] = altbirim;
				 myarray[altbirimId] = kackac;
				 } 
			 var bitirValue = jQuery(this).val();
			 var bitirArray = bitirValue.split(" ");
			 var altbirimdiv = '<div class="'+altbirimId+'" id="popupid" style="overflow-y:auto; padding:10px; width:400px; height:450px; background-color:white; display:none;">'+myarray[altbirimId]+'<input type="button" class="bitir" id="'+altbirimId+'" value="Bitir"/></div>';
			 if(!jQuery.contains(jQuery('body').html(), 'class="'+altbirimId+'"')){
				 jQuery('#revizyonlarPopupDiv').html(altbirimdiv);
				} 
			 //alert(jQuery('#revizyonlarPopupDiv').html());
			 jQuery('.'+altbirimId).lightbox_me({
		        centered: true, 
		    });
			
			//return false;
			
			 for(var kk = 0; kk < myaltarray[altbirimId].length; kk++){
					for(var jj = 0 ; jj < bitirArray.length; jj++){					
					if(myaltarray[altbirimId][kk][3] == bitirArray[jj]){
						jQuery('.'+altbirimId+' .'+myaltarray[altbirimId][kk][3]).attr('checked','checked');
						}
					}
				}
		});
		jQuery('.bitir').live('click',function(){
			var BitirId = jQuery(this).attr('id');
			var altbirimyaz = '';
			
			for(var kk = 0; kk < myaltarray[altbirimId].length; kk++){
				
				var checck = jQuery('.'+BitirId+' .'+myaltarray[altbirimId][kk][3]).attr('checked')?true:false;
				if(checck == true){
					altbirimyaz += myaltarray[altbirimId][kk][3]+' ';
					}
				else{
					}
				}
			
			jQuery('input #'+BitirId).val(altbirimyaz);
			jQuery("."+BitirId).trigger("close");
			});

//sinavbirimisecson

//sinav_saati
jQuery('#inputsinav_saati').timepicker({
	'step': 15,
	'timeFormat': 'H:i' 
	});
//sinav_saati
});	
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
			<td width="170">Sınavın Yeterliliği</td>
			<td>
			<?php 
			
			//if(isset($this->yetCombo)){
			
			?>
			<select id="yeterlilik_konusu" class="comboReq" name="yeterlilik_konusu" onchange="yetSecildi(this.value)">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $this->yetCombo?>
			</select>
			
			<?php
			//}
			//else
			//	echo 'Sınav Yeri Seçiniz.';?>
			</td>
		</tr>
		<tr>
			<td width="170">Sınav Yeri</td>
			<td>
			<select id="sinav_yeri" class="comboReq" name="sinav_yeri" onchange="merkezSecildi(this)">
			<!-- <option value="Seçiniz">Seçiniz</option> -->
			<?php //echo $this->yerCombo?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="170">Sınav Tarihi</td>
			<!-- <td><input type="text" id="inputsinav_tarihi" name="sinav_tarihi" size="12" class="required date"></input></td> -->
			<td>
				<select id="sinav_tarihi"  name="sinav_tarihi">
				<!--<select id="sinav_tarihi"  name="sinav_tarihi" onchange="tarihSecildi(this)">-->
				<!--<option value="Seçiniz">Seçiniz</option>-->
				</select>
			</td>
		</tr>
		<tr>
			<td width="170">Sınav Saati</td>
			<td><input type="text" id="inputsinav_saati" name="sinav_saati" size="6" class="required"/></td>
		</tr>
		<tr>
			<td width="170">Sınav Birimleri</td>
			<td>
			<input type="hidden" id="sinav_sekli" class="sinav_sekil"  name="sinav_sekli" size="20"><img id="sinav_sekli" class="sinav_sekil" src="images/info-icon.png"/>
			</td>
		</tr>
		<tr>
			<td width="170">Sınav Gözetmen(ler)i</td>
			<td><textarea id="sinav_gozetmen"
				name="sinav_gozetmen" size="12"></textarea></td>
		</tr>
		<tr>
			<td width="170">Sınav Değerlendirici(ler)i</td>
			<td><input type="text" id="sinav_degerlendirici"
				name="sinav_degerlendirici" size="30"></td>
		</tr>
	</tbody>
</table>

<div class="sinavGirisBaslik">Sınava Katılacak Öğrenciler</div>
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div id="revizyonlarPopupDiv" style="overflow-y:auto; padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<div id="Anabirimler" style="overflow-y:auto; padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<div id="Degerlen" style="overflow-y:auto; padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<div class="form_item">
  <div class="form_element cf_button">
    <input value="İleri" name="submitButton" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
    <script type="text/javascript">//<![CDATA[
	// bu script inputtan sonra konmalı, mümünse en alta </body> den Ã¶nce
	
		var cal = Calendar.setup({
	    onSelect: function(cal) { cal.hide() }
	});

      cal.manageFields("sinav_tarihi_button", "inputsinav_tarihi", "%d.%m.%Y");
      
    //]]></script>

    
    <script type="text/javascript">


    </script>