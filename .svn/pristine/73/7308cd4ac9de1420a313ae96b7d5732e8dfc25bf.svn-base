jQuery(function() {
	jQuery("input:submit", ".submit_button_bo" ).button();
	jQuery("input:submit", ".submit_button_oc" ).button();
	jQuery("input:submit", ".basarim-ekle-button" ).button();
	jQuery("input:submit", ".ogrenme-ekle-button" ).button();
	
	//DIALOG
	jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );

	jQuery( "#dialog-confirm" ).dialog({
		resizable: false,
		modal: true,
		autoOpen: false
	});
	
	jQuery(".sortable1").sortable({
		items:'div.ogrenme_ciktisi_wrapper'
	}); // Ogrenme Ciktilarini sort etmek icin

	jQuery(".sortable2").sortable({
		items:'div.basarim_olcutu_wrapper'
	});  // Basarim Olcutlerini sort etmek icin

	//EXPAND and COLLAPSE BUTTON
	jQuery(".ogrenme_expand_button").live('click', function() {
		var classToAdd 	  = "ui-icon-plusthick";
		var elm = jQuery(this).parent().parent().find(".sortable2");
		elm.toggle('slow');

		jQuery(this).toggleClass (classToAdd);
	});	

	/////////////////////////////////////////////////////////////////////////
	//OGRENME CIKTISI
	jQuery(".ogrenme_input_click").live('click', function(e) {
		e.preventDefault();
		openInputEdit (jQuery(this), "ogrenme_ciktisi", "ogrenme_input_click", "ogrenme_guncelle", "ogrenme_iptal", "ogrenme_sil");
		return false;
	});		

	jQuery(".ogrenme_iptal").live('click', function(e) {
		e.preventDefault();
		closeInputEdit (jQuery(this), "ogrenme_input_click");
		return false;
	});	

	jQuery(".ogrenme_guncelle").live('click', function(e) {
		e.preventDefault();
		ogrenmeCiktisiGuncelle (jQuery(this));
		return false;
	});		
	
	jQuery(".ogrenme_sil").live('click', function(e) {
		e.preventDefault();
		ogrenmeCiktisiSil (jQuery(this));
		return false;
	});	

	jQuery(".ogrenme_ekle").live('click', function(e) {
		e.preventDefault();
		ogrenmeCiktisiEkle (jQuery(this));
		return false;
	});

	jQuery(".ogrenme_ekle_iptal").live('click', function(e) {
		e.preventDefault();
		cancelInputEdit (jQuery(this), "ogrenme_ciktisi_wrapper");
		return false;
	});

	jQuery(".ogrenme_ekle_kaydet").live('click', function(e) {
		e.preventDefault();
		ogrenmeCiktisiEkleKaydet (jQuery(this));
		return false;
	});
	//OGRENME CIKTISI END
	
	///////////////////////////////////////////////////////////////////////////
	//BASARIM OLCUTU
	jQuery(".basarim_input_click").live('click', function(e) {
		e.preventDefault();
		openInputEdit (jQuery(this), "basarim_olcutu", "basarim_input_click", "basarim_guncelle", "basarim_iptal", "basarim_sil");
		return false;
	});		

	jQuery(".basarim_iptal").live('click', function(e) {
		e.preventDefault();
		closeInputEdit (jQuery(this), "basarim_input_click");
		return false;
	});	

	jQuery(".basarim_guncelle").live('click', function(e) {
		e.preventDefault();
		basarimOlcutuGuncelle (jQuery(this));		
		return false;
	});
	
	jQuery(".basarim_sil").live('click', function(e) {
		e.preventDefault();
		basarimOlcutuSil (jQuery(this));
		return false;
	});	
	
	//BASARIM OLCUTU EKLE
	jQuery(".basarim_ekle").live('click', function(e) {
		e.preventDefault();
		basarimOlcutuEkle (jQuery(this));
		return false;
	});
	
	//BASARIM OLCUTU EKLE IPTAL
	jQuery(".basarim_ekle_iptal").live('click', function(e) {
		e.preventDefault();
		cancelInputEdit (jQuery(this), "basarim_olcutu_wrapper");
		return false;
	});
	
	//BASARIM OLCUTU EKLE KAYDET
	jQuery(".basarim_ekle_kaydet").live('click', function(e) {
		e.preventDefault();
		basarimOlcutuEkleKaydet (jQuery(this));
		return false;
	});
	//BASARIM OLCUTU END
	
	/////////////////////////////////////////////////////////////////////////////////
	//BAGLAM
	jQuery(".baglam_input_click").live('click', function(e) {
		e.preventDefault();
		openInputEdit (jQuery(this), "baglam", "baglam_input_click", "baglam_guncelle", "baglam_iptal", "baglam_sil");
		return false;
	});		

	jQuery(".baglam_iptal").live('click', function(e) {
		e.preventDefault();
		closeInputEdit (jQuery(this), "baglam_input_click");
		return false;
	});	

	jQuery(".baglam_guncelle").live('click', function(e) {
		e.preventDefault();
		baglamGuncelle (jQuery(this));	
		return false;
	});	
	
	jQuery(".baglam_sil").live('click', function(e) {
		e.preventDefault();
		baglamSil (jQuery(this));
		return false;
	});	
	
	//BAGLAM EKLE
	jQuery(".baglam_ekle").live('click', function(e) {
		e.preventDefault();
		baglamEkle (jQuery(this));
		return false;
	});		
	
	//BAGLAM EKLE IPTAL
	jQuery(".baglam_ekle_iptal").live('click', function(e) {
		e.preventDefault();
		var parent = jQuery(this).parents(".basarim_olcutu_wrapper");
		var ekleHTML = '<a href="" class="baglam_ekle"><div class="baglam_ekle_button"></div> Bağlam Ekle</a>';
		cancelInputEdit (jQuery(this), "baglam");
		parent.append (ekleHTML);
		return false;
	});
	
	//BAGLAM EKLE KAYDET
	jQuery(".baglam_ekle_kaydet").live('click', function(e) {
		e.preventDefault();
		var parent = jQuery(this).parents(".basarim_olcutu_wrapper");
		var ekleHTML = '<a href="" class="baglam_ekle"><div class="baglam_ekle_button"></div> Bağlam Ekle</a>';
		baglamEkleKaydet (jQuery(this));
		parent.append (ekleHTML);
		return false;
	});
	//BAGLAM END
	
	/////////////////////////////////////////////////////////////////////////////////
	//OGRENME CIKTISI SIRASI
	jQuery("#oc-sira-kaydet").live('click', function(e) {
		var birimID = jQuery("#birimID").val();
		var sendData = jQuery('.ogrenme-ciktisi-id input:hidden').serializeArray();		
		var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxOgrenmeCiktisiSirasiGuncelle&birimID="+birimID;
		siraKaydet (url, sendData);
	    return false;
	});	

	//BASARIM OLCUTU SIRASI 
	jQuery("#bo-sira-kaydet").live('click', function(e) {
		var birimID  = jQuery("#birimID").val();
		var parent   = jQuery(this).parents(".ogrenme_ciktisi_wrapper");
		var sendData = jQuery('input:hidden', parent).serializeArray();			
		var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBasarimOlcutuSirasiGuncelle&birimID="+birimID;//+"&"+sendData;
		siraKaydet (url, sendData);
		return false;
	});
	
});

//Ogrenme Ciktisi Guncelle
function ogrenmeCiktisiGuncelle (elm){
	var parentUst = elm.parent();
	var parent = elm.parents(".ogrenme_ciktisi_wrapper");
	var inpID = jQuery('.ogrenme-ciktisi-id input:hidden', parent);
	var sendData = jQuery("input", parentUst).serializeArray();
	var sendDataID = inpID.serializeArray();
	var sendDataAll = sendData.concat(sendDataID);
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxOgrenmeCiktisiGuncelle";
	ogrenmeCiktilariGuncelle (url, elm, sendDataAll, "ogrenme_input_click");
}
//Ogrenme Ciktisi Sil
function ogrenmeCiktisiSil (elm){
	var parent = elm.parents(".baglam");
	var sendData = jQuery("input:hidden", parent).serializeArray();
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxOgrenmeCiktisiSil";
	
    jQuery( "#dialog-confirm" ).dialog({
        buttons: {
			Sil: function() {
				ogrenmeCiktilariSil (url, elm, sendData, "baglam");					
		        jQuery( this ).dialog( "close" );
			},
			İptal: function() {
				jQuery( this ).dialog( "close" );	
			}
        }
	});
    jQuery( "#dialog-confirm" ).dialog("open");
}
//Ogrenme Ciktisi HTML Ekle
function ogrenmeCiktisiEkle (elm){
	var parent = elm.parents(".sortable1");
	
	var ocHTML = 
	'<div class="ogrenme_ciktisi_wrapper">' +
		'<div class="sort_button"></div>' +
		'<div class="ogrenme_ciktisi">' +
			'<div class="ui-icon ui-icon-minusthick ogrenme_expand_button"></div>' +
			'<div class="siraNo"></div>' +
			'<div class="ogrenme_input"><input maxlength="150" size="100" id="ogrenmeInput" name="ogrenme_ciktisi[]" type="text" value=""/>' +
			'<a href="" class="ogrenme_ekle_kaydet">Kaydet</a><a href="" class="ogrenme_ekle_iptal">İptal</a></div>' +
			'<div class="cfclear">&nbsp;</div>' +
		'</div>' +
		'<div class="sortable2"><div class="cfclear">&nbsp;</div></div>' +
		'<div class="cfclear">&nbsp;</div>' +
	'</div>';

	parent.append(ocHTML);
	jQuery("#ogrenmeInput").focus();
}
//Ogrenme Ciktisi Ekle Kaydet
function ogrenmeCiktisiEkleKaydet (elm){
	var birimID  = jQuery("#birimID").val();
	var parent   = elm.parents(".ogrenme_ciktisi_wrapper");
	var sendData = jQuery('input', parent).serializeArray();			
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxOgrenmeCiktisiEkle&birimID="+birimID;//+"&"+sendData;

	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){		
				  var ID = data["array"]["ID"];
				  var HTML = '<div class="ogrenme-ciktisi-id"><input type="hidden" value="'+ID+'" name="ogrenme_ciktisi_id[]"></div>';
				  var parentWrp =  elm.parents(".ogrenme_ciktisi_wrapper");
				  var parent =  elm.parents(".ogrenme_ciktisi_wrapper");
				  var siraNo = data["array"]["siraNo"];
				  var siraNoDiv = parent.children(".siraNo");
				  
				  siraNoDiv.html (siraNo);
				  parentWrp.append(HTML);
				  
				  closeInputEdit (elm, "ogrenme_input_click");
			  }else{
				  alert ("Hata Oluştu");
			  }
		  }
	});	
}
//Basarim Olcutu Guncelle
function basarimOlcutuGuncelle (elm){
	var parent = elm.parents(".basarim_olcutu");
	var sendData = jQuery("input", parent).serializeArray();
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBasarimOlcutuGuncelle";
	ogrenmeCiktilariGuncelle (url, elm, sendData, "basarim_input_click");
}
//Basarim Olcutu Sil
function basarimOlcutuSil (elm){
	var parent = elm.parents(".basarim_olcutu_wrapper");
	var sendData = jQuery("input:hidden", parent).serializeArray();
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBasarimOlcutuSil";
	
    jQuery( "#dialog-confirm" ).dialog({
        buttons: {
			Sil: function() {
				ogrenmeCiktilariSil (url, elm, sendData, "basarim_olcutu_wrapper");					
		        jQuery( this ).dialog( "close" );
			},
			İptal: function() {
				jQuery( this ).dialog( "close" );
			}
        }
	});
    jQuery( "#dialog-confirm" ).dialog("open");
}
//Basarim Olcutu HTML Ekle
function basarimOlcutuEkle (elm){
	var parent = elm.parents(".ogrenme_ciktisi_wrapper");
	var boWrapper = parent.children(".sortable2");
	var boHTML = '<div class="basarim_olcutu_wrapper">' +
		'<div class="sort_button"></div>' +
		'<div class="basarim_olcutu">' +
			'<div class="siraNo"></div>' +
			'<div class="ogrenme_input"><input maxlength="150" size="100" id="boInput" name="basarim_olcutu[]" type="text" value=""/>' +
			'<a href="" class="basarim_ekle_kaydet">Kaydet</a><a href="" class="basarim_ekle_iptal">İptal</a></div>' +
			'<div class="cfclear">&nbsp;</div>' +
		'</div>' +
		'<a href="" class="baglam_ekle"><div class="baglam_ekle_button"></div> Bağlam Ekle</a>' +
		'<div class="cfclear">&nbsp;</div>' +
	'</div>';

	boWrapper.append(boHTML);
	jQuery("#boInput").focus();
}
//Basarim Olcutu Ekle Kaydet
function basarimOlcutuEkleKaydet (elm){
	var birimID  = jQuery("#birimID").val();
	var parent   = elm.parents(".ogrenme_ciktisi_wrapper");
	var sendData = jQuery('input', parent).serializeArray();			
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBasarimOlcutuEkle&birimID="+birimID;//+"&"+sendData;

	ogrenmeCiktilariEkle (url, elm, sendData, "basarim_olcutu", "basarim_olcutu_id", "basarim_input_click");
}
//Baglam Guncelle
function baglamGuncelle (elm){
	var parent = elm.parents(".baglam");
	var sendData = jQuery("input", parent).serializeArray();
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBaglamGuncelle";
	
	ogrenmeCiktilariGuncelle (url, elm, sendData, "baglam_input_click");
}
//Baglam Sil
function baglamSil (elm){
	var parent = elm.parents(".baglam");
	var sendData = jQuery("input:hidden", parent).serializeArray();
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBaglamSil";
	
    jQuery( "#dialog-confirm" ).dialog({
        buttons: {
			Sil: function() {
				ogrenmeCiktilariSil (url, elm, sendData, "baglam");					
		        jQuery( this ).dialog( "close" );
			},
			İptal: function() {
				jQuery( this ).dialog( "close" );		
			}
        }
	});
    jQuery( "#dialog-confirm" ).dialog("open");
}
//Baglam HTML Ekle
function baglamEkle (elm){
	var parent = elm.parent();
	var baglamHTML = '<div class="baglam">' +
		'<div class="siraNo"></div>' +
		'<div class="ogrenme_input"><input maxlength="150" size="100" id="baglamInput" name="baglam[]" type="text" value=""/>' +
		'<a href="" class="baglam_ekle_kaydet">Kaydet</a><a href="" class="baglam_ekle_iptal">İptal</a></div>' +
		'<div class="cfclear">&nbsp;</div>' +
	'</div>';

	parent.append(baglamHTML);
	elm.remove();
	jQuery("#baglamInput").focus();
}
//Baglam Ekle Kaydet
function baglamEkleKaydet (elm){
	var birimID  = jQuery("#birimID").val();
	var parent   = elm.parents(".basarim_olcutu_wrapper");
	var sendData = jQuery('input', parent).serializeArray();			
	var url = "index.php?option=com_yeterlilik_birim&view=ogrenme_cikti&task=ajaxBaglamEkle&birimID="+birimID;//+"&"+sendData;

	ogrenmeCiktilariEkle (url, elm, sendData, "baglam", "baglam_id", "baglam_input_click");
}
//Ogrenme Ciktisi, Basarim Olcutu ve Baglam Guncelleme
function ogrenmeCiktilariEkle (url, elm, sendData, parentClass, IDName, closeInputEditClass){
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){		
				  var ID = data["array"]["ID"];
				  var HTML = '<input type="hidden" value="'+ID+'" name="'+IDName+'[]">';
				  var parent =  elm.parents("." + parentClass);
				  var siraNo = data["array"]["siraNo"];
				  var siraNoDiv = parent.children(".siraNo");
				  
				  siraNoDiv.html (siraNo);
				  parent.append(HTML);
				  
				  closeInputEdit (elm, closeInputEditClass);
			  }else{
				  alert ("Hata Oluştu");
			  }
		  }
	});	
}
//Ogrenme Ciktisi, Basarim Olcutu ve Baglam Guncelleme
function ogrenmeCiktilariGuncelle (url, elm, sendData, closeInputClass){
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){				
				  closeInputEdit (elm, closeInputClass);
			  }
			  else{
				  alert("Güncellenirken Hata Oluştu");
			  }
		  }
	});
}
//Ogrenme Ciktisi, Basarim Olcutu ve Baglam Sil
function ogrenmeCiktilariSil (url, elm, sendData, closeInputClass){
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){				
				  cancelInputEdit(elm, closeInputClass);
			  }
			  else{
				  alert("Silerken Hata Oluştu");
			  }
		  }
	});
}
//Sira Kaydet
function siraKaydet (url, sendData){
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){				
				  location.reload();
			  }
		  }
	});	
}

function openInputEdit (elm, inputName,inputClassName, guncelleClassName, iptalClassName, silClassName){
	var oi = elm.html();
	var input = '<input maxlength="150" size="100" name="'+inputName+'[]" type="text" value="'+oi+'"/>';
	var buttons = '<a href="" class="'+guncelleClassName+'">Güncelle</a><a href="" class="'+iptalClassName+'">İptal</a><a href="" class="'+silClassName+'">Sil</a>'; 
	elm.html(input + buttons);
	elm.removeClass (inputClassName);
}

function closeInputEdit (elm, inputClassName){
	var parent = elm.parent();
	var inpVal = parent.children('input').val();
	var html = '<div class="ogrenme_input '+inputClassName+'">'+inpVal+'</div>';
	parent.html(html);
}

function cancelInputEdit(elm, parentClassName){
	var parent = elm.parents("."+parentClassName);
	parent.remove("."+parentClassName);
}