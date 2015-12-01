function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function getSeviye(){
	jQuery("#yeni_yeterlilik_formatiDiv").html("");
	jQuery("#eski_yeterlilik_formatiDiv").html("");

	id=jQuery("#sektor").val();
	jQuery("#seviyeDiv").html("<font color='red'>Lütfen Bekleyin</font>");
	jQuery("#yeterlilikDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="yeterlilik_id" name="yeterlilik_id">'
	    	+'<option value="">Önce Seviye seçiniz.</option>'
	    	+'</select>');
	jQuery("#birimlerDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="birim_id" name="birim_id">'
	    	+'<option value="">Önce Yeterlilik seçiniz.</option>'
	    	+'</select>');		
	jQuery("#ogrenmeCiktisiDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id" onchange="getBasarimOlcutu(jQuery(this).val());">'
	    	+'<option value="">Önce Birim Seçiniz</option>'
	    	+'</select>');
		jQuery("#basarimOlcutuDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="basarim_olcutu_id" name="basarim_olcutu_id">'
		    	+'<option value="">Önce Öğrenme Çıktısı seçiniz</option>'
		    	+'</select>');		

	var uyari="";
	if (id==""){
		uyari="Sektör seçiniz";
	} 
	if (uyari!="") {
		jQuery("#seviyeDiv").html(uyari);
	} else {
		var url = 'index.php?option=com_itembank&task=getSeviye&format=raw';
	    
	    var seviyeIcerik="";
		jQuery.post(
	        url,{sektor_id:id}, function(data) {
	            if(data['success']){
	                var gelenIcerik = data['array'];
	                var adet = gelenIcerik.length;
	                
	                 icerik='<select class="required" style="width: 300px;" id="seviye" name="seviye" onchange="getYeterlilikler(jQuery(\'#sektor\').val(),jQuery(this).val());">'
	                	 +'<option value="">Seviye Seçiniz</option>';
	                for(var i=0;i<adet;i++){
	                	icerik=icerik + '<option value="'+gelenIcerik[i]["SEVIYE_ID"]+'">Seviye '+gelenIcerik[i]["SEVIYE_ID"]+'</option>';
	                }
	                icerik=icerik+'</select>';
	                jQuery("#seviyeDiv").html(icerik);
	            }else{
	            	jQuery("#seviyeDiv").html("Seçtiğiniz sektörde onaylanmış yeterlilik yok.");
	            
	            }
	    	},"json"
	    );
	
	}

}
function getYeterlilikler(){
	jQuery("#yeni_yeterlilik_formatiDiv").html("");
	jQuery("#eski_yeterlilik_formatiDiv").html("");

	id=jQuery("#sektor").val();
	seviye=jQuery("#seviye").val();
	jQuery("#yeterlilikDiv").html("<font color='red'>Lütfen Bekleyin</font>");
	jQuery("#birimlerDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="birim_id" name="birim_id" onchange="">'
	    	+'<option value="">Önce Yeterlilik seçiniz.</option>'
	    	+'</select>');		
	jQuery("#ogrenmeCiktisiDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id" onchange="">'
	    	+'<option value="">Önce Birim Seçiniz</option>'
	    	+'</select>');
		jQuery("#basarimOlcutuDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="basarim_olcutu_id" name="basarim_olcutu_id">'
		    	+'<option value="">Önce Öğrenme Çıktısı seçiniz</option>'
		    	+'</select>');		

	var uyari="";
	if (id==""){
		uyari="Sektör seçiniz";
	} 
	if (seviye==""){
		uyari="Seviye seçiniz";
	}
	if (uyari!="") {
		jQuery("#yeterlilikDiv").html(uyari);
	} else {
		var url = 'index.php?option=com_itembank&task=getYeterlilikler&format=raw';
	    
	    var seviyeIcerik="";
		jQuery.post(
	        url,{sektor_id:id,seviye_id:seviye}, function(data) {
	            if(data['success']){
	                var gelenIcerik = data['array'];
	                var adet = gelenIcerik.length;
	                
	                 icerik='<select class="required" style="width: 300px;" id="yeterlilik_id" name="yeterlilik_id" onchange="eskiYeniTeorikPerformans()">'
	                	 +'<option value="">Yeterlilik Seçiniz</option>';
	                for(var i=0;i<adet;i++){
	                	icerik=icerik + '<option value="'+gelenIcerik[i]["YETERLILIK_ID"]+'-'+gelenIcerik[i]["YENI_MI"]+'">'+gelenIcerik[i]["YETERLILIK_ADI"]+'</option>';
	                }
	                icerik=icerik+'</select>';
	                jQuery("#yeterlilikDiv").html(icerik);
	            }else{
	            	jQuery("#yeterlilikDiv").html("Seçtiğiniz sektörde "+seviye+". seviyeden onaylanmış yeterlilik yok.");
	            
	            }
	    	},"json"
	    );
	
	}

}

function getBirimler(seciliIDler){
	info=jQuery("#yeterlilik_id").val();
	jQuery("#birimlerDiv").html("<font color='red'>Lütfen Bekleyin</font>");
	var infoParts=info.split("-");

	jQuery("#ogrenmeCiktisiDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id" onchange="getBasarimOlcutu();">'
	    	+'<option value="">Önce Birim Seçiniz</option>'
	    	+'</select>');
		jQuery("#basarimOlcutuDiv").html('<select class="required cf_label" style="width: 300px;" style="" id="basarim_olcutu_id" name="basarim_olcutu_id">'
		    	+'<option value="">Önce Öğrenme Çıktısı seçiniz</option>'
		    	+'</select>');	
		
	var uyari="";
	var url = 'index.php?option=com_itembank&task=getBirimler&format=raw';
    
    var seviyeIcerik="";
	jQuery.post(
        url,{yeterlilik_id:infoParts[0]}, function(data) {
            if(data['success']){
                var gelenIcerik = data['array'];
                var adet = gelenIcerik.length;
                
                 icerik='<select class="required" style="width: 300px;" id="birim_id" name="birim_id[]" onchange="getOgrenmeCiktisi()">'
                	 +'<option value="">Birim Seçiniz</option>';
                
                for(var i=0;i<adet;i++){
                	var selectedText = '';
                	if(seciliIDler!=undefined && inArray(gelenIcerik[i]['BIRIM_ID'], seciliIDler))
                		selectedText = ' selected ';
                	
                	icerik=icerik + '<option '+selectedText+' value="'+gelenIcerik[i]["BIRIM_ID"]+'">'+gelenIcerik[i]["BIRIM_ADI"]+'</option>';
                }
                
                icerik=icerik+'</select>';
                jQuery("#birimlerDiv").html(icerik);
            }else{
            	jQuery("#birimlerDiv").html("Seçtiğiniz yeterliliğe ait birim bulunamadı.");
            
            }
    	},"json"
    );

	
	
}

function getBilgiBeceriYetkinlik(seciliIDler){
	info=jQuery("#yeterlilik_id").val();
//	jQuery("#birimlerDiv").html("Lütfen Bekleyin");
	var infoParts=info.split("-");

	jQuery("#bilgiDiv, #beceriDiv, #yetkinlikDiv").html('<font color="red">Getiriliyor</font>');
	
	var uyari="";
	if (jQuery("#soru_grubu_id").val()==1){
		var url = 'index.php?option=com_itembank&task=getBilgi&format=raw';
		jQuery.post(
		        url,{yeterlilik_id:infoParts[0]}, function(data) {
		            if(data['success']){
		                var gelenIcerik = data['array'];
		                var adet = gelenIcerik.length;
		                
		                 icerik='<select multiple class="required" style="width: 300px;" id="bilgiBeceriYetkinlik_id" name="bilgiBeceriYetkinlik_id[]" onchange="">';
		                for(var i=0;i<adet;i++){
		                	var selectedText = '';
		                	if(seciliIDler!=undefined && inArray(gelenIcerik[i]['BECERI_YETKINLIK_ID'], seciliIDler))
		                		selectedText = ' selected ';
		                	icerik=icerik + '<option '+selectedText+' value="'+gelenIcerik[i]["BECERI_YETKINLIK_ID"]+'">'+gelenIcerik[i]["BECERI_YETKINLIK_ADI"]+'</option>';
		                }
		                icerik=icerik+'</select>';
		                jQuery("#bilgiDiv").html(icerik);
		            }else{
		            	jQuery("#bilgiDiv").html("Seçtiğiniz yeterliliğe ait bilgi bulunamadı.");
		            
		            }
		    	},"json"
		    );
	} else {
		var url = 'index.php?option=com_itembank&task=getBeceri&format=raw';
		jQuery.post(
		        url,{yeterlilik_id:infoParts[0]}, function(data) {
		            if(data['success']){
		            	icerik='<select multiple class="required" style="width: 300px;" id="bilgiBeceriYetkinlik_id" name="bilgiBeceriYetkinlik_id[]" onchange="">';
		                var gelenIcerik = data['array'];
		                var adet = gelenIcerik.length;
		                
	                	for(var i=0;i<adet;i++){
	                		var selectedText = '';
		                	if(seciliIDler!=undefined && inArray(gelenIcerik[i]['BECERI_YETKINLIK_ID'], seciliIDler))
		                		selectedText = ' selected ';
		                	
		                	icerik=icerik + '<option '+selectedText+' value="'+gelenIcerik[i]["BECERI_YETKINLIK_ID"]+'">'+gelenIcerik[i]["BECERI_YETKINLIK_ADI"]+'</option>';
		                }
		                icerik=icerik+'</select>';
		                jQuery("#beceriDiv").html(icerik);
		            }else{
		            	jQuery("#beceriDiv").html("Seçtiğiniz yeterliliğe ait beceri bulunamadı.");
		            
		            }
		    	},"json"
		    );
		var url = 'index.php?option=com_itembank&task=getYetkinlik&format=raw';
		jQuery.post(
		        url,{yeterlilik_id:infoParts[0]}, function(data) {
		            if(data['success']){
		                var gelenIcerik = data['array'];
		                var adet = gelenIcerik.length;
		                icerik='<select multiple class="required" style="width: 300px;" id="bilgiBeceriYetkinlik_id" name="bilgiBeceriYetkinlik_id[]" onchange="">';
			                
	                	for(var i=0;i<adet;i++)
	                	{
	                		var selectedText = '';
		                	if(seciliIDler!=undefined && inArray(gelenIcerik[i]['BECERI_YETKINLIK_ID'], seciliIDler))
		                		selectedText = ' selected ';
		                	
		                	icerik=icerik + '<option '+selectedText+' value="'+gelenIcerik[i]["BECERI_YETKINLIK_ID"]+'">'+gelenIcerik[i]["BECERI_YETKINLIK_ADI"]+'</option>';
		                }
	                	
		                icerik=icerik+'</select>';
		                jQuery("#yetkinlikDiv").html(icerik);
		            }else{
		            	jQuery("#yetkinlikDiv").html("Seçtiğiniz yeterliliğe ait yetkinlik bulunamadı.");
		            
		            }
		    	},"json"
		    );
	}

    

	
	
}

function getOgrenmeCiktisi(){
	id=jQuery("#birim_id").val();
	jQuery("#ogrenmeCiktisiDiv").html("<font color='red'>Lütfen Bekleyin</font>");
	var uyari="";
	var url = 'index.php?option=com_itembank&task=getOgrenmeCiktisi&format=raw';
    
    var seviyeIcerik="";
	jQuery.post(
        url,{birim_id:id}, function(data) {
            if(data['success']){
                var gelenIcerik = data['array'];
                var adet = gelenIcerik.length;
                
                 icerik='<select multiple class="required" style="width: 300px;" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id[]" onchange="getBasarimOlcutu(jQuery(this).val());">'
                	 +'';
                for(var i=0;i<adet;i++){
                	icerik=icerik + '<option value="'+gelenIcerik[i]["OGRENME_CIKTISI_ID"]+'">'+gelenIcerik[i]["OGRENME_CIKTISI_YAZISI"]+'</option>';
                }
                icerik=icerik+'</select>';
                jQuery("#ogrenmeCiktisiDiv").html(icerik);
            }else{
            	jQuery("#ogrenmeCiktisiDiv").html("Seçtiğiniz birime ait Öğrenme Çıktısı bulunamadı.");
            
            }
    	},"json"
    );
}

function getBasarimOlcutu(){
	id=jQuery("#ogrenme_ciktisi_id").val();
	jQuery("#basarimOlcutuDiv").html("<font color='red'>Lütfen Bekleyin</font>");
	var uyari="";
	var url = 'index.php?option=com_itembank&task=getBasarimOlcutu&format=raw';
    
    var seviyeIcerik="";
	jQuery.post(
        url,{birim_id:id}, function(data) {
            if(data['success']){
                var gelenIcerik = data['array'];
                var adet = gelenIcerik.length;
                
                 icerik='<select multiple class="required" style="width: 300px;" id="basarim_olcutu_id" name="basarim_olcutu_id[]" onchange="">'
                	 +'';
                for(var i=0;i<adet;i++){
                	icerik=icerik + '<option value="'+gelenIcerik[i]["BASARIM_OLCUTU_ID"]+'">'+gelenIcerik[i]["BASARIM_OLCUTU_ADI"]+'</option>';
                }
                icerik=icerik+'</select>';
                jQuery("#basarimOlcutuDiv").html(icerik);
            }else{
            	jQuery("#basarimOlcutuDiv").html("Seçtiğiniz Öğrenme Çıktısına ait Başarım Ölçütü bulunamadı.");
            
            }
    	},"json"
    );
}

function soruHTMLiGetir(id)
{
	var uyari="";
	var url = 'index.php?option=com_itembank&task=ajaxSoruGoster&format=raw&soru_id='+id;

	jQuery.ajax({
		  url: url,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success'])
			  {
				  jQuery('#soruPopup').html(data['message']).lightbox_me({
				        centered: true, 
				        closeClick:false,
				        closeEsc:false
			        });

			  }
			  else
			  {
				
			  }
		  }
	});
	
	
}

function kayitPost(form){
	var uyari="";
	var url = 'index.php?option=com_itembank&task=soruKaydet&format=raw';

	  var veriler = new FormData(document.forms.namedItem("ChronoContact_soru_kayit_formu"));
	
	jQuery.ajax({
	    type: "POST",
	    data: veriler,
	    url: url,
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(data){
	    	if (data>0){
	            jQuery("#icerik").html("<font color=red><b>Kaydedildi</b></font>");
				jQuery(".textareaclass").val("");
				jQuery(".dosya").val("");
				jQuery(".textclass").val("");
				jQuery(".checkclass").removeAttr("checked");
				jQuery(".radioclass").removeAttr("checked");
				
            }
	    	if (data=="0"){
                jQuery("#icerik").html("<font color=red><b>Güncellendi</b></font>");
            }
	    }
		
	});
	
	
}

function selectSec(selectId,OptionValue){
	jQuery("#"+selectId+" option").each(function(e){
		jQuery(this).removeAttr("selected");
	});

	jQuery("#"+selectId+" option").each(function(e){
	if(jQuery(this).val()==OptionValue)
		jQuery(this).attr("selected","selected");
	});
}


function boslukDoldurmaCevapNo(){
	var adet = jQuery(".klasikCevapInput").length
	for (i=1;i<=adet;i++){
		jQuery(jQuery(".klasikCevapInput")[i]).html(i+1);
	}
}
window.i=0;
function soruTipiSec(){
	if (jQuery("#soru_grubu_id").val()==1){
		jQuery("#performansSoruTipiDiv").hide();
		jQuery("#teorikSoruTipiDiv").show();
		jQuery("#performansSoruTipiDiv2").hide();
		jQuery("#teorikSoruTipiDiv2").show();
		jQuery("#soru_tipi_id_p").val("");
	} else if (jQuery("#soru_grubu_id").val()==2){
		jQuery("#performansSoruTipiDiv").show();
		jQuery("#teorikSoruTipiDiv").hide();
		jQuery("#performansSoruTipiDiv2").show();
		jQuery("#teorikSoruTipiDiv2").hide();
		jQuery("#soru_tipi_id").val("");
	}
}

function eskiYeniTeorikPerformans(seciliIDler, singleSelectMi){
	info=jQuery("#yeterlilik_id").val();
	var infoParts=info.split("-");
	var	yeni_yeterlilik_formati='<div class="form_item">'+
			'		  <div class="form_element cf_inputbox">'+
			'		    <label class="cf_label" style="width: 200px;">Birim</label>'+
			'		    <div id="birimlerDiv">'+
			'		    	<select class="required cf_label" style="width: 300px;" style="" id="birim_id" name="birim_id" onchange="getOgrenmeCiktisi();">'+
			'		    	<option value="">Önce Yeterlilik seçiniz.</option>'+
			'		    	</select>'+
			'		    </div>	  '+
			'		  </div>'+
			'		  <div class="cfclear">&nbsp;</div>'+
			'		</div>'+
					
			'		<div class="form_item">'+
			'		  <div class="form_element cf_inputbox">'+
			'		    <label class="cf_label" style="width: 200px;">Öğrenme Çıktısı</label>'+
			'		    <div id="ogrenmeCiktisiDiv">'+
			'		    	<select class="required cf_label" style="width: 300px;" style="" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id" onchange="getBasarimOlcutu();">'+
			'		    	<option value="">Önce Birim Seçiniz</option>'+
			'		    	</select>'+
			'		    </div>'+
			'		  </div>'+
			'		  <div class="cfclear">&nbsp;</div>'+
			'		</div>'+
					
						
			'		<div class="form_item">'+
			'		  <div class="form_element cf_inputbox">'+
			'		    <label class="cf_label" style="width: 200px;">Başarım Ölçütü</label>'+
			'		    <div id="basarimOlcutuDiv">'+
			'		    	<select class="required cf_label" style="width: 300px;" style="" id="basarim_olcutu_id" name="basarim_olcutu_id">'+
			'		    	<option value="">Önce Öğrenme Çıktısı seçiniz</option>'+
			'		    	</select>'+
			'		    </div>'+
			'		  </div>'+
			'		  <div class="cfclear">&nbsp;</div>'+
			'</div>';
	
	var eski_yeterlilik_formati='<div id="teorik_ise">'+
								'	</div>'+
								'	<div id="pratik_ise">'+
								'	</div>';
	
	var eski_yeterlilik_formatiTeorikse='	<div class="form_item">'+
									'		  <div class="form_element cf_inputbox">'+
									'		    <label class="cf_label" style="width: 200px;">Bilgi</label>'+
									'		    <div id="bilgiDiv">'+
									'		    	<select multiple class="required cf_label" style="width: 300px;" style="" id="bilgi_id" name="bilgiBeceriYetkinlik[]" onchange="getOgrenmeCiktisi();">'+
									'		    	<option value="">Önce Yeterlilik seçiniz.</option>'+
									'		    	</select>'+
									'		    </div>'+	  
									'		  </div>'+
									'		  <div class="cfclear">&nbsp;</div>'+
									'		</div>';
	var eski_yeterlilik_formatiPratikse='		<div class="form_item">'+
									'		  <div class="form_element cf_inputbox">'+
									'		    <label class="cf_label" style="width: 200px;">Beceri</label>'+
									'		    <div id="beceriDiv">'+
									'		    	<select multiple class="required cf_label" style="width: 300px;" style="" id="beceri_id" name="bilgiBeceriYetkinlik[]" onchange="getOgrenmeCiktisi();">'+
									'		    	<option value="">Önce Yeterlilik seçiniz.</option>'+
									'		    	</select>'+
									'		    </div>'+	  
									'		  </div>'+
									'		  <div class="cfclear">&nbsp;</div>'+
									'		</div>'+
									'		<div class="form_item">'+
									'		  <div class="form_element cf_inputbox">'+
									'		    <label class="cf_label" style="width: 200px;">Yetkinlik</label>'+
									'		    <div id="yetkinlikDiv">'+
									'		    	<select multiple class="required cf_label" style="width: 300px;" style="" id="yetkinlik_id" name="bilgiBeceriYetkinlik[]" onchange="getOgrenmeCiktisi();">'+
									'		    	<option value="">Önce Yeterlilik seçiniz.</option>'+
									'		    	</select>'+
									'		    </div>	  '+
									'		  </div>'+
									'		  <div class="cfclear">&nbsp;</div>'+
									'		</div>';


	if (infoParts[1]==0){
		jQuery("#yeni_yeterlilik_formatiDiv").html("");
		jQuery("#eski_yeterlilik_formatiDiv").html(eski_yeterlilik_formati);
		if (jQuery("#soru_grubu_id").val()==1){
			jQuery("#teorik_ise").html(eski_yeterlilik_formatiTeorikse);
			jQuery("#pratik_ise").html();
		} else {
			jQuery("#teorik_ise").html("");
			jQuery("#pratik_ise").html(eski_yeterlilik_formatiPratikse);
		}

		getBilgiBeceriYetkinlik(seciliIDler);
	} else {
		jQuery("#eski_yeterlilik_formatiDiv").html("");
		jQuery("#yeni_yeterlilik_formatiDiv").html(yeni_yeterlilik_formati);
		getBirimler(seciliIDler);
	}
}


function silCevap(e){
	jQuery(e.getParent().getParent().getParent().getParent().getParent().getParent()).remove();
	boslukDoldurmaCevapNo();
}

function dosyaislem (hiddenInput,div,input){
	jQuery ("#"+hiddenInput).val("1");
	jQuery ("#"+div).html(input);
	
}
function toTitleCase(str)
{
    return str;//.replace(/([\wöçşğüıİ])/gi, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}