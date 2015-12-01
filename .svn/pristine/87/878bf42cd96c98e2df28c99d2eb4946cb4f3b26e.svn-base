<?php
defined('_JEXEC') or die('Restricted access');

$takvimYili = isset($_POST['takvim_yili']) ? $_POST['takvim_yili'] : "";

?>

<script type="text/javascript">
var user_id = <?php echo $this->user_id; ?>;
var seciliyil;
var altbirim;
var kackac;
var myarray = new Array();
var myaltarray = new Array();
dTables.sinavTakvimi = new Array(
		new Array("text","required","6"),
		new Array("text","required pickdatetime","15","date"),
		/*new Array("text","required","25"),*/
		new Array( "combo",
				new Array(
			new Array("Seçiniz", "Seçiniz")<?php echo $this->yetCombo;?>),"comboReq","yetSecildi(this.id, this.value, user_id)"),
		new Array("text","sinavbirimisec required",
					new Array(),"comboReq",null,true),
		new Array( "combo",
					new Array(),"comboReq"),
		new Array("text","required pickdatetime","15","date")
		
);

function createTables(){
	var tableName = "sinavTakvimi";
	var headers = new Array('Sıra No',
							'Sınav Tarihi',
							'Yeterlilik',
							'Yeterlilik Birimleri',
							'Sınav Yeri',
							'Sınav Geçerlilik Tarihi'
		
							/*,
							'Sınav Kapsamı'*/
							);
	//yeterlilikleriAl();
	createTable(tableName, headers);
	patchSatirEkleWithDatePick (tableName, headers,new Array ('2'), tableName);
	//patchSatirEkle(tableName, headers, tableName);
	//patchEkleForDatePick(tableName, new Array ('2'), headers);

	jQuery('#sinavTakvimiFormu').hide();
	//document.getElementById('sinavTakvimiFormu').visibility = 'hidden';
	//xmlhttpPost(null, 'index.php?option=com_sinav&task=kapsamAl&format=raw', kapsamGetQueryString, kapsamUpdatePageFunction);


	if(<?php echo isset($_POST['mode'])? "1" : "0";?>){

		jQuery('#sinav_takvim_yili_div').hide();

		jQuery('#takvim_yili')[0].value = "<?php echo $takvimYili;?>";
		
		jQuery('#sinavTakvimiFormu').show();

		//daha Ã¶nce eklenmiÅŸ kayıtları getir doldur tabloyu 
		
		xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=takvimAl&amp;format=raw',
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
	
	//str = trim(str, "\0");

	if(str == "no"){
		alert("Daha önce seçilen yıl için sınav takvimi bildirmemişsiniz. Şimdi Bildirebilirsiniz.");
		
		var rowCount = getCounter('sinavTakvimi');

		// Önceki satırları sil
		for(var i=1;i<=rowCount;i++){
			deleteRow("tablo_sinavTakvimi_"+i);
			rowDeleted('sinavTakvimi');
			rowCounter['sinavTakvimi']--;
		}

		// boÅŸ bir tane satır ekle
		addNRow('sinavTakvimi','6','sinavTakvimi');
		rowAdded('sinavTakvimi','sinavTakvimi');
		addDatePick('sinavTakvimi','2');

		return;
	}

	var rowCount = getCounter('sinavTakvimi');

	// Önceki satırları sil
	for(var i=1;i<=rowCount;i++){
		deleteRow("tablo_sinavTakvimi_"+i);
		rowDeleted('sinavTakvimi');
		rowCounter['sinavTakvimi']--;
	}

	// boÅŸ bir tane satır ekle
	addNRow('sinavTakvimi','6','sinavTakvimi');
	rowAdded('sinavTakvimi','sinavTakvimi');
	addDatePick('sinavTakvimi','2');

	var rows = str.split("**");
	var yeID = new Array(rows.length);
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var tarih = rowsAtt[0];
		var yer = rowsAtt[1];
		var yerAdi = rowsAtt[2];
		var altBirim = rowsAtt[3];
		var altBirimText = rowsAtt[5];
		var gectarih = rowsAtt[6];
		
		var yetVals = rowsAtt[4].split("#*#");
		var yetId = yetVals[0];
		var yetAd = yetVals[1];
        yeID[i] = yetId;
		var siradakiRow = getCounter('sinavTakvimi');

		// tarih
		var id="inputsinavTakvimi-2-"+siradakiRow;
		var inp = document.getElementById(id);
		inp.value = tarih;

		if(i+1 != rows.length){
			addNRow('sinavTakvimi','6','sinavTakvimi');
			rowAdded('sinavTakvimi','sinavTakvimi');
			addDatePick('sinavTakvimi','2');
		}

		// Yeterlilikler ???
		id="inputsinavTakvimi-3-"+siradakiRow;
		var yetInp = document.getElementById(id);
		//yetInp.setAttribute("onclick", "tumYeterlilikAl('"+ merkezInp.id +"', '"+yer+"', '"+yetId+"')");
		removeAllOptions(yetInp);
		addOption(yetInp, yetAd, yetId);

		// ALTBİRİMLER	
		id="inputsinavTakvimi-4-"+siradakiRow;
		var altInp = document.getElementById(id);
		altInp.value = altBirimText;

		// ALTBİRİMLER - Hidden
		id="inputsinavTakvimi-4-"+siradakiRow+"-Hidden";
		var altHiddenInp = document.getElementById(id);
		if(jQuery(altHiddenInp).length==0)
			jQuery('#sinavTakvimiForm').append(jQuery('<input type="hidden" value="'+altBirim+'" id="inputsinavTakvimi-4-'+siradakiRow+'-Hidden" name="inputsinavTakvimi-4-Hidden[]">')); 
		else
			altHiddenInp.value = altBirim;
		
		// sinav merkezi
		id="inputsinavTakvimi-5-"+siradakiRow;
		var merkezInp = document.getElementById(id);
		//merkezInp.setAttribute("onclick", "tumYeterlilikAl('"+ merkezInp.id +"', '"+yer+"', '"+yetId+"')");
		removeAllOptions(merkezInp);
		addOption(merkezInp,yerAdi, yer);

		//gecerlilik tarih
		var id="inputsinavTakvimi-6-"+siradakiRow;
		var inp = document.getElementById(id);
		inp.value = gectarih;

		/*xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=YeterlilikAltBirim&amp;format=raw',
				function (){
			return altBirimGetQueryString(yetId, siradakiRow);
		}, altBirimlerUpdatePageFunction);
	*/

		//var url = 'index.php?option=com_yeterlilik_birim&task=ajaxAddFromVarolanStandartlar&format=raw&birimID=' + jQuery("#birimID").val();
	}
	var sendData = 'yetId=' + yeID + '&yetInpNo='+merkezInp;
	var url = 'index.php?option=com_sinav&task=KayitliYeterlilikAltBirim&format=raw';
    	jQuery.ajax({
    		  url: url,
    		  data: sendData,
    		  type: "POST",
    		  dataType: 'json',
    		  success: function(data) {
    			  if(data['success']){
    				  altBirimlerGelen(data['array']);
     			  }else{
    				  alert("Hata oluştu");
    			  }
    		  }
    	});
}

function tumYeterlilikAl(merkezId, merkezVal, yetid){

	var yetInpNo = merkezId.substring(merkezId.lastIndexOf('-')+1);

	var yetInpId = 'inputsinavTakvimi-5-' + yetInpNo;

	var yetInp = document.getElementById(yetInpId);
	
	merkezSecildi(merkezId, merkezVal, yetid);
	
}

function yilSecildi(takvimYili){
	seciliyil = takvimYili;
	if(takvimYili == "Seçiniz")
		return;

	jQuery('#sinavTakvimiFormu').show();

	//daha Ã¶nce eklenmiÅŸ kayıtları getir doldur tabloyu 
	
	xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=takvimAl&amp;format=raw',
			function (){
				return getTakvimQueryString(takvimYili);
			},
			getTakvimUpdate);
	
}

function merkezSecildi(merkezInpId, merkezInpVal, yetid){

	var yetInpNo = merkezInpId.substring(merkezInpId.lastIndexOf('-')+1);

	xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=merkezYeterlilik&amp;format=raw',
			function (){
		return ayetGetQueryString(merkezInpVal, yetInpNo, yetid);
	}, yetUpdatePageFunction);
	
}

function yetSecildi(merkezInpId, yetInpVal, user_id){
	if(yetInpVal != "Seçiniz"){
	jQuery.blockUI({ message: '<h1>Lütfen Bekleyin!</h1>',
		css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
	}
    //setTimeout(jQuery.unblockUI, 2000); 

	var yetInpNo = merkezInpId.substring(merkezInpId.lastIndexOf('-')+1);
	jQuery('#inputsinavTakvimi-4-'+yetInpNo).val('');
	jQuery('.inputsinavTakvimi-4-'+yetInpNo).remove();

	xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=Yeterlilikmerkez&amp;format=raw',
			function (){
		return yetGetQueryString(yetInpVal, yetInpNo, user_id);
	}, yetUpdatePageFunction);

}

function yetGetQueryString(yetId, yetInpNo, user_id){
	var qstr = 'yetId=' + yetId + '&yetInpNo='+ yetInpNo + '&user_id=' + user_id;
	return qstr;
}

function altBirimGetQueryString(yetId, yetInpNo){
	var qstr = 'yetId=' + yetId + '&yetInpNo='+ yetInpNo;
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

	var str2 = str.split("#*#");
	
	var id = 'inputsinavTakvimi-5-' + str2[0];
	var selectBox = document.getElementById(id);
	
	var previousVal = selectBox.value;

	//alert('previousVal: ' + previousVal);
	
	var rows = str2[1].split("**");
	removeAllOptions(selectBox);
	if(rows.length == 0 || rows[0] == ""){
		return;
	}
	
	for(var i=0;i<rows.length;i++){
		var rowsAtt = rows[i].split("##");
		var yetId = rowsAtt[0];
		var yer = rowsAtt[1];
		var yerAdi = rowsAtt[2];
		
		addOption(selectBox, yerAdi, yer);
		
	}
	selectBox.setAttribute("onclick","");

	if(previousVal != '')
		selectBox.value = previousVal;
	
	xmlhttpPost(null, 'index.php?option=com_sinav&amp;task=YeterlilikAltBirim&amp;format=raw',
			function (){
		return altBirimGetQueryString(yetId, str2[0]);
	}, altBirimlerUpdatePageFunction);
	
}

function altBirimlerUpdatePageFunction(str){
	jQuery.unblockUI({});
	kackac = '';
	
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
				//for(var kk = 0; kk < 3; kk++){
						altbirim[i][1] = rowsAtt[2]+'/T1';
						altbirim[i+uzunlukfark][1] = rowsAtt[2]+'/P1';
						altbirim[i][2] = rowsAtt[0]+'_0';
						altbirim[i+uzunlukfark][2] = rowsAtt[0]+'_1';
						altbirim[i][3] = rowsAtt[0]+'_0';
						altbirim[i+uzunlukfark][3] = rowsAtt[0]+'_1';
						altbirim[i][0] = rowsAtt[1];
						altbirim[i+uzunlukfark][0] = rowsAtt[1];
						altbirim[i][4] = rowsAtt[2];
						altbirim[i+uzunlukfark][4] = rowsAtt[2];
				//}
			}
			//bURADA KALDIN
			else if(rowsAtt[4] == 1){
				//for(var kk = 0; kk < 4; kk++){
					altbirim[i][0] = rowsAtt[1];
					altbirim[i][1] = rowsAtt[2]+rowsAtt[3]+rowsAtt[5];
					altbirim[i][2] = rowsAtt[0]+'_'+rowsAtt[3]+rowsAtt[5];
					altbirim[i][3] = rowsAtt[7];
					altbirim[i][4] = rowsAtt[2];
					//}
				}
			}
		
		
	
	for(var jj = 0; jj < altbirim.length; jj++){
		if(altbirim[jj][2] != undefined){
			kackac += '<span><input type="checkbox" class="'+altbirim[jj][3]+'" birimKodu="'+altbirim[jj][4]+'" id="'+altbirim[jj][2]+'" value="Ekle"/>		'+altbirim[jj][0]+' ('+altbirim[jj][1]+') </span><br/>';
			}
		
	}
		myarray['inputsinavTakvimi-4-'+str2[0]] = kackac;
		kackac = '';
		myaltarray['inputsinavTakvimi-4-'+str2[0]] = altbirim;
		jQuery('#inputsinavTakvimi-4-'+str2[0]).attr("disabled",false);
}


function altBirimlerGelen(data){
	jQuery.unblockUI({});
var uzunluk = data.length;
for(var pp=0; pp < uzunluk; pp++){
	kackac ='';
	if(data[pp][0]["YENI_MI"] == 0){
	var altuzunluk = data[pp].length;
	var altuzunluk2 = altuzunluk*2;
	altbirim = new Array(altuzunluk2);
	for(var jj = 0; jj<altuzunluk2; jj++){
		altbirim[jj] = new Array(4);
		}
		for(var i=0; i < altuzunluk; i++){
					altbirim[i][0] = data[pp][i]["YETERLILIK_ALT_BIRIM_ADI"];
					altbirim[i+altuzunluk][0] = data[pp][i]["YETERLILIK_ALT_BIRIM_ADI"];
					altbirim[i][1] = data[pp][i]["YETERLILIK_ALT_BIRIM_NO"]+'/T1';
					altbirim[i+altuzunluk][1] = data[pp][i]["YETERLILIK_ALT_BIRIM_NO"]+'/P1';
					altbirim[i][2] = data[pp][i]['YETERLILIK_ALT_BIRIM_ID']+'_0';
					altbirim[i+altuzunluk][2] = data[pp][i]['YETERLILIK_ALT_BIRIM_ID']+'_1';
					altbirim[i][3] = data[pp][i]['YETERLILIK_ALT_BIRIM_ID']+'_0';
					altbirim[i+altuzunluk][3] = data[pp][i]['YETERLILIK_ALT_BIRIM_ID']+'_1';
					altbirim[i][4] = data[pp][i]["YETERLILIK_ALT_BIRIM_NO"];
					altbirim[i+altuzunluk][4] = data[pp][i]["YETERLILIK_ALT_BIRIM_NO"];
					
		}
	}
	else if(data[pp][0]["YENI_MI"] == 1){
		var altuzunluk = data[pp].length;
		altbirim = new Array(altuzunluk);
		for(var jj = 0; jj<altuzunluk; jj++){
			altbirim[jj] = new Array(4);
			}
			for(var i=0; i < altuzunluk; i++){
						altbirim[i][0] = data[pp][i]["BIRIM_ADI"];
						altbirim[i][1] = data[pp][i]["BIRIM_KODU"]+"/"+data[pp][i]["OLC_DEG_HARF"]+""+data[pp][i]["OLC_DEG_NUMARA"];
						altbirim[i][2] = data[pp][i]["BIRIM_ID"]+'_'+data[pp][i]["OLC_DEG_HARF"]+""+data[pp][i]["OLC_DEG_NUMARA"];
						altbirim[i][3] = data[pp][i]["ID"];
						altbirim[i][4] = data[pp][i]["BIRIM_KODU"];
			}
		}
		for(var jj = 0; jj < altbirim.length; jj++){
			if(altbirim[jj][2] != undefined){
			kackac += '<span><input type="checkbox" birimKodu="'+altbirim[jj][4]+'" class="'+altbirim[jj][3]+'" id="'+altbirim[jj][2]+'" value="Ekle"/>		'+altbirim[jj][0]+' ('+altbirim[jj][1]+') </span><br/>';
			}
		}
		myarray['inputsinavTakvimi-4-'+(pp+1)] = kackac;
		kackac ='';
		myaltarray['inputsinavTakvimi-4-'+(pp+1)] = altbirim;
		jQuery('#inputsinavTakvimi-4-'+(pp+1)).attr("disabled",false);
		
}

}
	



jQuery(document).ready(function(){

		jQuery(".pickdatetime").live("hover",function(){
			jQuery(".tarihsecbuton").hide();
			jQuery(this).datepicker({  
		        duration: '',  
		        showTime: true,  
		        constrainInput: false,
		        changeYear: true,
		        changeMonth: true,  
		        stepMinutes: 1,  
		        stepHours: 1,  
		        altTimeField: '',  
		        time24h: false  
		     });
		});
	//monthYear
	jQuery(".tarihsecbuton").live("hover",function(){
			jQuery(".tarihsecbuton").hide();
	});

	jQuery('#satirEkle_belgeDuzenlenecekBilgi').live("click",function(){
		jQuery(".tarihsecbuton").hide();
	});

	var altbirimId;


//Altbirimleri Al
	
//sinavbirimisecbas
		jQuery('.sinavbirimisec').live('click', function(e){
			 e.preventDefault();
			 altbirimId = jQuery(this).attr('id');
			 var bitirValue = jQuery('#'+altbirimId+'-Hidden').val();
			 var bitirArray = bitirValue.split(" ");
			 var altbirimdiv = '<div class="'+altbirimId+'" style="padding:10px; width:400px; height:450px; background-color:white; overflow-y:auto; display:none;">'+myarray[altbirimId]+'<input type="button" class="tumunuSecButton" value="Tümünü Seç"><input type="button" class="tumunuKaldirButton" value="Tümünü Kaldır"><input type="button" class="bitir" id="'+altbirimId+'" value="Bitir"/></div>';
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
			var birimkoduu='';			
			for(var kk = 0; kk < myaltarray[altbirimId].length; kk++){
				
				var checck = jQuery('.'+BitirId+' .'+myaltarray[altbirimId][kk][3]).attr('checked')?true:false;
				if(checck == true){
					altbirimyaz += myaltarray[altbirimId][kk][3]+' ';
					birimkoduu += jQuery('.'+BitirId+' .'+myaltarray[altbirimId][kk][3]).attr('birimKodu')+' ';
					}
				else{
					}
				}


			if(jQuery('#'+BitirId+'-Hidden').length==0)
				jQuery('#sinavTakvimiForm').append('<input id="'+BitirId+'-Hidden" type="hidden" value="'+altbirimyaz+'" name="'+jQuery('#'+BitirId).attr('name').substr(0, jQuery('#'+BitirId).attr('name').length-2)+'-Hidden[]">');
			else
				jQuery('#'+BitirId+'-Hidden').val(altbirimyaz);

			
			jQuery('#'+BitirId).val(birimkoduu);
			jQuery("."+BitirId).trigger("close");
			});

//sinavbirimisecson
	
	jQuery(".sil").live("click", function(){
		var silid = jQuery(this).attr("id");
		alert(silid);
	});

	jQuery('.tumunuSecButton').live('click', function(){
		jQuery(this).parent().find('input[type="checkbox"]').attr('checked', 'checked');
	});
	
	jQuery('.tumunuKaldirButton').live('click', function(){
		jQuery(this).parent().find('input[type="checkbox"]').removeAttr('checked');
	});
});
</script>

<div class="sinavGirisBaslik">Sınav Takvimi Bildirimi Listele/Düzenle</div>

<form id="sinavTakvimiForm" action="?option=com_sinav&amp;task=takvimKaydet" method="post" onsubmit="return validate('sinavTakvimiForm')">
	<input name="mode" value="taslak" type="hidden"></input>
	
	<div id="sinav_takvim_yili_div">
	Sınav Takvimi Yılı
	<select name="takvim_yili" id="takvim_yili" onchange="yilSecildi(this.value)">
		<option value="Seçiniz">Seçiniz</option>
		<?php echo $this->yilCombo?>
	</select>
	</div>
	<div id="revizyonlarPopupDiv" style="padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
	<div id="sinavTakvimiFormu">
	<div id="sinavTakvimi_div"></div>
	<br />
	<input type="submit" value="Tümünü görüntüle" id="denetle"/>
	</div>
</form>

<script type="text/javascript">
jQuery("#denetle").live("click",function(){
	var kaan = new Array();
	jQuery("#tablo_sinavTakvimi tbody").children().each(function(){
		kaan[kaan.length] = jQuery(this).attr('id');
	    });
    
	var degerid = new Array(kaan.length);
    for(var i = 0; i<kaan.length; i++){
        var xy = i+1;
    	degerid[i] = new Array("inputsinavTakvimi-2-"+xy, "inputsinavTakvimi-3-"+xy, "inputsinavTakvimi-5-"+xy);
      }

		var l = 0;
		for(var k = 0; k < degerid.length; k++){
				var pow = k+1;
				for(pow; pow < degerid.length; pow++){
					if(jQuery("#"+degerid[k][l]).val() == jQuery("#"+degerid[pow][l]).val() && jQuery("#"+degerid[k][l+1]).val() == jQuery("#"+degerid[pow][l+1]).val() && jQuery("#"+degerid[k][l+2]).val() == jQuery("#"+degerid[pow][l+2]).val()){
						jQuery("#"+kaan[pow]).remove();
						alert("Aynı tarihte, aynı yeterlilikte ve aynı merkezde sınavınız mevcut...");
					}
				}
		}
		return true;
});



    //<![CDATA[
	// bu script inputtan sonra konmalı, mÃ¼mÃ¼nse en alta </body> den Ã¶nce
	
		var cal = Calendar.setup({
	    onSelect: function(cal) { cal.hide() }
	});
      
    //]]></script>
