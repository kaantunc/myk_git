<style>
table td {
  padding: 0px;
}
</style>


<?php 
$model = $this->getModel();
$donemlerOptionText = $model->getDonemlerOptions(2);

$user = &JFactory::getUser();
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
$adminMi = FormFactory::checkAclGroupId ($user->id, YONETICI_GROUP_ID);

if($user!=null && !$isSektorSorumlusu && !$adminMi && $_GET['uid']=='')//login olmuşsa ve ss veya admin değilse
	header( 'Location: index.php?option=com_finans&layout=kurulus_finansal_bilgileri&uid='.$user->getOracleUserId() ) ;

?>
<form id="finansalForm" method="post" enctype="multipart/form-data" action="index.php?option=com_finans&task=kurulusFinansalBilgileriKaydet">
<?php

if($isSektorSorumlusu || $adminMi)
{
	echo '<div style="width:15%; float:left;">
	KURULUŞ SEÇİNİZ:
	</div>
	<div style="width:75%; float:left;">
	<select style="width:100%;margin-top:4px;" id="kurulusSelect" name="kurulusSelect">';
		
	$kuruluslar = $this->kuruluslar;
	foreach($kuruluslar as $kurulus)
		echo '<option value="'.$kurulus['USER_ID'].'">'.$kurulus['KURULUS_ADI'].'</option>';
	
	echo '</select>
	</div>
	
	<div style="width:9%; float:left;">
	<input type="button" value="GETİR" id="getirButton">
	</div>';
	
}
else
	echo '<h4>'.$this->seciliKurulusunAdi.' FİNANSAL BİLGİLERİ</h4><br>';
	


?>

<div id="uyariDiv" style="color:red;">
</div>
<div id="kurulusFinansalBilgileriDiv">
<h4 style="margin-top:10px;float:left; width:100%;">BELGE MASRAF KARŞILIĞI</h4>	
	
	<div style="float:left; width:100%;">
		<table id="belgeMasrafKarsiligiTable" style="float:left; width:100%;">
			<thead>
			<tr>
				<th style="width:130px;">Tarife Dönemi</th>
				<th style="width:10%">Verilen Belge Sayısı</th>
				<th style="width:10%">Verilmiş Belge Sayısı</th>
				<th style="width:10%">Ödenmesi Gereken Tutar</th>
				<th style="width:10%">Borç Miktarı</th>
				<th>Dekontlar</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	
	
<h4 style="margin-top:10px;float:left; width:100%;">YILLIK AİDAT</h4>	
	<div style="float:left; width:100%; overflow:auto;">
		<table id="yillikAidatTable" style="float:left; width:100%;">
			<thead>
			<tr>
				<th style="width:130px;">Tarife Dönemi</th>
				<th style="width:5%">Sınav ve Belgelendirme Gün</th>
				<th style="width:5%">Verilen Belge Sayısı</th>
				<th style="width:5%">Eğitim ve Akreditasyon Gün</th>
				<th style="width:5%">Akredite Kuruluş Sayısı</th>
				<th style="width:5%">Sınav ve Belgelendirme Aidat Tutarı</th>
				<th style="width:5%">Eğitim ve Akreditasyon Aidat Tutarı</th>
				<th style="width:5%">Toplam Aidat Tutarı</th>
				<th style="width:5%">Borç</th>
				<th>Dekont</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	
	 
	 
<h4 style="margin-top:10px;float:left; width:100%;">DENETİMLER</h4>	
	<div style="float:left; width:100%;">
		<table id="denetimlerTable" style="float:left; width:100%;">
			<thead>
			<tr>
				<th>Denetim Tarihi</th>
				<th>Denetim Kodu</th>
				<th>Ekipteki Kişi Sayısı</th>
				<th>Denetim Ücreti</th>
				<th>İlave Denetim Bedeli</th>
				<th>Toplam Denetim Bedeli</th>	
				<th>Borç Miktarı</th>	
				<th>Dekont</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	
</div>


<div id="dekontEklePopup" style="width:300px; display:none; background-color:white;">
	TARİH:
	<br><input id="dekontEklePopup_Tarih" name="dekontEklePopup_Tarih" class="datepicker" >
	<br>DEKONT NO
	<br><input id="dekontEklePopup_DekontNo" name="dekontEklePopup_DekontNo" class="" >
	<br>TUTAR
	<br><input id="dekontEklePopup_Tutar" name="dekontEklePopup_Tutar" class="numberInput" >
	<br>AÇIKLAMA
	<br><textarea id="dekontEklePopup_Aciklama" name="dekontEklePopup_Aciklama"></textarea>
	<input type="hidden" id="dekontEklePopup_DekontTipi" name="dekontEklePopup_DekontTipi">
	<input type="hidden" id="dekontEklePopup_DekontEklenenID" name= "dekontEklePopup_DekontEklenenID">
	<br>
	<div id="dekontEklePopup_UyariDiv" style="color:red"></div>
	<input id="dekontEklePopup_KaydetButton" value="Ekle" name="dekontEklePopup_KaydetButton" type="button">
</div>

<div style="width:100%; float:left;">
<?php 		
	if($isSektorSorumlusu || $adminMi)
		echo '<input type="submit" value="KAYDET" >';
	
	?>
</div>
</form>
<script>

jQuery('.formGosterButton').live('click',function(e){
	e.preventDefault();
	var dekontId=jQuery(this).attr('id').split('-')[1];
	
	jQuery('#toggleableDiv-'+dekontId).toggle('slow');
	
	if(jQuery('#degistirFieldSelected-'+dekontId).val()=='1')
		jQuery('#degistirFieldSelected-'+dekontId).val("0");
	else
		jQuery('#degistirFieldSelected-'+dekontId).val("1");
});


jQuery('#getirButton').click(function(){
verileriGetir();
});

var settings = {
		"bInfo": false,
		"bPaginate": false,
		"bFilter": false,
		"bSort":false,
	    "oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
	};
				
jQuery('#belgeMasrafKarsiligiTable, #yillikAidatTable, #denetimlerTable').dataTable(settings);

jQuery('.datepicker').datepicker({});

jQuery(".numberInput").live("keydown", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 40)) {

    	if(event.keyCode == 38 && event.currentTarget.value!="")//yukarı
       		event.currentTarget.value = parseInt(event.currentTarget.value)+1;  
    	else if(event.keyCode == 40  && event.currentTarget.value!="")//aşagı
   			event.currentTarget.value = parseInt(event.currentTarget.value)-1;  
    	

             // let it happen, don't do anything
             return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        } 
        
              
    }
});

jQuery('.verilenBelgeSayisiInput').live('keyup', function(e){

	var rowID = jQuery(this).attr('class').split(' ')[1].substr(4);
	var belgelendirmeUcreti = parseInt(jQuery('.seciliDoneminBelgeMasrafi-'+rowID).val(), 10);
	var yeniOdemesiGerekenTutar = parseInt(jQuery(this).val()*belgelendirmeUcreti);

	
	
	jQuery('.verilenBelgelerinParasi').filter('.row-'+rowID).html(yeniOdemesiGerekenTutar);

	var dekontToplami = parseInt(jQuery('.dekontToplami').filter('.row-'+rowID).val(), 10);
	jQuery('.adaminBorcluOlduguMiktar').filter('.row-'+rowID).html(yeniOdemesiGerekenTutar-dekontToplami);
	
	
});


jQuery('.ilaveDenetimBedeli').live('keyup', function(e){

	var rowID = jQuery(this).attr('class').split(' ')[2].substr(4);
	var ilaveUcret = parseInt(jQuery(this).val(), 10);
	if(isNaN(ilaveUcret)==true)
		ilaveUcret = 0;
	
	var denetimUcreti = parseInt(jQuery('.denetimUcretiDiv').filter('.row-'+rowID).html(), 10);
	if(isNaN(denetimUcreti)==true)
		denetimUcreti = 0;

	var yeniOdemesiGerekenTutar = (ilaveUcret + denetimUcreti);
	jQuery('.toplamDenetimUcreti').filter('.row-'+rowID).html(yeniOdemesiGerekenTutar);
	
	var dekontToplami = parseInt(jQuery('.denetimDekontlariToplami').filter('.row-'+rowID).val(), 10);
	jQuery('.adaminDenetimeBorcluOlduguMiktar').filter('.row-'+rowID).html(yeniOdemesiGerekenTutar-dekontToplami);
	
});

jQuery('.dekontEkleButton').live('click', function(e){
	jQuery('#dekontEklePopup').lightbox_me({
        centered: true, 
    });

    if(this.classList.contains('belgeMasrafiDekont'))
    {	
    	jQuery('#dekontEklePopup_DekontTipi').val('belgeMasrafi');
    	jQuery('#dekontEklePopup_DekontEklenenID').val(this.classList[2].split('-')[1]);
    	        
    }
    else if(this.classList.contains('denetimDekont'))
    {	
    	jQuery('#dekontEklePopup_DekontTipi').val('denetimDekontu');
    	jQuery('#dekontEklePopup_DekontEklenenID').val(this.classList[2].split('-')[1]);
    	        
    }
    else if(this.classList.contains('yillikAidatDekont'))
    {	
    	jQuery('#dekontEklePopup_DekontTipi').val('yillikAidatDekont');
    	jQuery('#dekontEklePopup_DekontEklenenID').val(this.classList[2].split('-')[1]);
    	        
    }
});


jQuery('.dekontSilButton').live('click', function(e){

		var dekontID = this.classList[1].split('-')[1];
		var sendData = null;

		
		var url = 'index.php?option=com_finans&task=ajaxDekontSil&format=raw&dekont_id='+dekontID;
		
		jQuery.ajax({
			  url: url,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					  window.location = window.location.href+'&uid='+jQuery('#user_id').val();
				  }
				  else
				  {
					  alert(data['data']);
				    }

			  }
		});
			
	
	
});

jQuery('#dekontEklePopup_KaydetButton').live('click', function(e){

	var allValid = true;
	jQuery('#dekontEklePopup_Tarih, #dekontEklePopup_DekontNo, #dekontEklePopup_Tutar').each(function(e){
		if(jQuery(this).val()=='')
		{			
			jQuery(this).css('border', '1px solid red');
			allValid = false;
		}
		else
			jQuery(this).css('border', '1px solid #ABADB3');
		
	});

	if(allValid==true)
	{
		var jqInputs = jQuery('#dekontEklePopup input, #dekontEklePopup textarea');
		var sendData = jqInputs.serializeArray();

		
		var url = 'index.php?option=com_finans&task=ajaxDekontEkle&format=raw';

		jQuery('#dekontEklePopup_UyariDiv').html('Kaydediliyor').show("slow");
		jQuery('#dekontEklePopup_KaydetButton').hide();
		
		jQuery.ajax({
			  url: url,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					  window.location = window.location.href+'&uid='+jQuery('#user_id').val();
				  }
				  else
				  {
					  alert(data['data']);
					  jQuery('#dekontEklePopup_UyariDiv').hide('slow');
						jQuery('#dekontEklePopup_KaydetButton').show('slow');
				
				  }


					

			  }
		});
			
	}
	
});

function verileriGetir()
{
	if(confirm('Kaydedilmemiş verileriniz kaybolacak'))
	{
		var user_id = jQuery('#kurulusSelect').val();

		putUserDataToGrids(user_id);		
	}
}

function putUserDataToGrids(user_id)
{
	if(jQuery('input[name="user_id"]').length == 0)
		jQuery('#finansalForm').append('<input name="user_id" id="user_id" value="'+user_id+'" type="hidden" >');
	else
		jQuery('input[name="user_id"]').val(user_id);

	
	jQuery('#kurulusFinansalBilgileriDiv').hide();
	jQuery('#uyariDiv').html('Getiriliyor').show();
	
	var url = 'index.php?option=com_finans&task=ajaxKurulusFinansalBilgileriGetir&format=raw&user_id='+user_id;
	var sendData = null;
	
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){

				  	var kurulusMu = (data['array']['KURULUS_MU']==true) ? true: false;
				  
					jQuery('#kurulusFinansalBilgileriDiv').show("slow");
					jQuery('#uyariDiv').hide();
								  
					//HER BELGE MASRAFI ICIN
					jQuery('#belgeMasrafKarsiligiTable tbody tr').remove();
					var belgeMasraflari = data['array']['BelgeMasraf'];

					for(var i=0; i<belgeMasraflari.length; i++)
					{
						//  DEKONTLARIN OLDUGU TDYI OLUŞTUR  //////////////////////////////
						var dekontlarinToplami = 0;
						var dekontTD = '';//ADAMIN DEKONTLARI VE EN ALTTA DEKONTLARIN TOPLAMI
						var buBelgeMasrafininDekontlari = (data['array']['BelgeMasraflariDekontlari']!=undefined) ? data['array']['BelgeMasraflariDekontlari'][i] : {};
						for(var j=0; buBelgeMasrafininDekontlari!=undefined && j<buBelgeMasrafininDekontlari.length; j++)
						{
							if(j==0)
								dekontTD += '<tr><td>SİL</td><td>DEKONT NO</td><td>TARIH</td><td>AÇIKLAMA</td><td>TUTARI</td></tr>';
								
							dekontTD += '<tr>';
							dekontTD += '<td rowspan="2">';
							dekontTD += (kurulusMu)?'':'<input type="button" value="SİL" class="dekontSilButton dekontID-'+buBelgeMasrafininDekontlari[j]['DEKONT_ID']+'">';
							dekontTD += '</td>';
							dekontTD += '<td>'+buBelgeMasrafininDekontlari[j]['DEKONT_NO']+'</td>';
							dekontTD += '<td>'+buBelgeMasrafininDekontlari[j]['DEKONT_TARIHI']+'</td>';
							dekontTD += '<td>'+buBelgeMasrafininDekontlari[j]['DEKONT_ACIKLAMA']+'</td>';
							dekontTD += '<td>'+buBelgeMasrafininDekontlari[j]['DEKONT_UCRETI']+'</td>';
							dekontTD += '</tr>';
							dekontTD += '<tr><td colspan="4">'+buBelgeMasrafininDekontlari[j]['DEKONT_UPLOADER_TD']+'</td></tr>';
							
							dekontlarinToplami += parseInt(buBelgeMasrafininDekontlari[j]['DEKONT_UCRETI']);
							if(j==buBelgeMasrafininDekontlari.length-1)
								dekontTD += '<tr><td colspan="5">TOPLAM: '+dekontlarinToplami+'</td></tr>';
							
						}
						if(buBelgeMasrafininDekontlari!=undefined && buBelgeMasrafininDekontlari[0]!=undefined)
							dekontTD = '<table border="1" cellspacing="0" style="width:100%"><tbody>'+dekontTD+'</tbody></table>';
						///// DEKONTLAR BITTI //////////////////////////////////////
						
						// BORÇLARINA BAK
						var thisRow = belgeMasraflari[i];
						var adaminOdemesiGerekenMiktar = (thisRow['VERILEN_BELGE_SAYISI'] * thisRow['BELGE_MASRAFI']);

						var adaminBorcluOlduguMiktar = adaminOdemesiGerekenMiktar - dekontlarinToplami;
						
						jQuery('#finansalForm').append('<input name="belgeMasraflariIDleri[]" type="hidden" value="'+thisRow['TARIFE_DONEMI_ID']+'" >');

						var verilenBelgeSayisiValue = (thisRow['VERILEN_BELGE_SAYISI'].length > 0) ? thisRow['VERILEN_BELGE_SAYISI'] : 0;
						
						var satirText = '<td><input type="hidden" name="kaydedilecekTarifeDonemiID[]" value="'+thisRow['TARIFE_DONEMI_ID']+'"><select disabled>'+thisRow['DONEM_OPTIONS']+'</select></td>'
						 + '<td>'+((thisRow['HESAPLANAN_BELGE_SAYISI']=='')? 0 : thisRow['HESAPLANAN_BELGE_SAYISI'])+'</td>'
						 + '<td><input style="width:75px;" name="tarifeDonemindeVerilmisBelgeSayisi[]" class="verilenBelgeSayisiInput row-'+i+' numberInput tarifeDonemi-'+thisRow['TARIFE_DONEMI_ID']+'" value="'+verilenBelgeSayisiValue+'"></td>'
						 + '<td><div class="verilenBelgelerinParasi row-'+i+'">'+adaminOdemesiGerekenMiktar+'</div><input type="hidden" class="seciliDoneminBelgeMasrafi-'+i+'" value="'+thisRow['BELGE_MASRAFI']+'"></td>'
						 + '<td class="adaminBorcluOlduguMiktar row-'+i+'">'+adaminBorcluOlduguMiktar+'</td>'
						 + '<td>'+dekontTD+'<input type="hidden" class="dekontToplami row-'+i+'" value="'+dekontlarinToplami+'">'
						 + '<div>'
						 + ((kurulusMu)?'':'<input type="button" class="dekontEkleButton belgeMasrafiDekont belgeMasrafiID-'+thisRow['BELGE_MASRAFI_ID']+'" value="Ekle">')
						 + '</div>'
						 + '</td>';

						if(i%2==0)
							trClassName = 'odd';
						else
							trClassName = 'even';
						 
						satirText = '<tr class="'+trClassName+'">' + satirText + '</tr>';
						jQuery('#belgeMasrafKarsiligiTable').append(satirText); 
					}


					//HER DENETIM ICIN
					jQuery('#denetimlerTable tbody tr').remove();
					var denetimler = data['array']['DENETIM'];
					var rowNumber = 0;
					for(var i=0; denetimler!=undefined && i<denetimler.length; i++)
					{
						var denetimDonemi = denetimler[i];
						var buDoneminDenetimleri = denetimDonemi['DONEMIN_DENETIMLERI'];
						for(var j=0; buDoneminDenetimleri!=undefined && j<buDoneminDenetimleri.length; j++)
						{
							var denetimID = buDoneminDenetimleri[j]['DENETIM_ID'];
							var ekiptekiKisiSayisi = (buDoneminDenetimleri[j]['COUNT(*)']=='')? 0 : parseInt(buDoneminDenetimleri[j]['COUNT(*)']);

							jQuery('#finansalForm').append('<input name="kaydetmeyeDenetimIDleri[]" type="hidden" value="'+denetimID+'" >');
							//
							var buDenetiminDekontlari = data['array']['DENETIM_DEKONTLARI'][denetimID];
							var buDenetiminIlaveUcreti = (data['array']['DENETIM_ILAVE_UCRETLERI'][denetimID][0]!=undefined) ? parseInt(data['array']['DENETIM_ILAVE_UCRETLERI'][denetimID][0]['ILAVE_DENETIM_UCRETI']) : 0;
							var dekontlarinToplami = 0;
							var dekontTD = '';
							for(var k=0; buDenetiminDekontlari!=undefined && k<buDenetiminDekontlari.length; k++)
							{
								if(k==0)
									dekontTD += '<tr><td>SİL</td><td>DEKONT NO</td><td>TARİH</td><td>AÇIKLAMA</td><td>TUTARI</td></tr>';
									
								dekontTD += '<tr>';
								dekontTD += '<td rowspan="2">';
								dekontTD += (kurulusMu)?'':'<input type="button" value="SİL" class="dekontSilButton dekontID-'+buDenetiminDekontlari[k]['DEKONT_ID']+'">';
								dekontTD += '</td>';
								dekontTD += '<td>'+buDenetiminDekontlari[k]['DEKONT_NO']+'</td>';
								dekontTD += '<td>'+buDenetiminDekontlari[k]['DEKONT_TARIHI']+'</td>';
								dekontTD += '<td>'+buDenetiminDekontlari[k]['DEKONT_ACIKLAMA']+'</td>';
								dekontTD += '<td>'+buDenetiminDekontlari[k]['DEKONT_UCRETI']+'</td>';
								dekontTD += '</tr>';
								dekontTD += '<tr><td colspan="4">'+buDenetiminDekontlari[k]['DEKONT_UPLOADER_TD']+'</td></tr>';
								
								dekontlarinToplami += parseInt(buDenetiminDekontlari[k]['DEKONT_UCRETI']);
								if(k==buDenetiminDekontlari.length-1)
									dekontTD += '<tr><td colspan="5">TOPLAM: '+dekontlarinToplami+'</td></tr>';
								
							}
							if(buDenetiminDekontlari.length != 0)
								dekontTD = '<table border="1" cellspacing="0" style="width:100%"><tbody>'+dekontTD+'</tbody></table>';

							var toplamDenetimUcreti = parseInt(buDoneminDenetimleri[j]['DENETIM_UCRETI']) + buDenetiminIlaveUcreti;
							var denetimBorcu = toplamDenetimUcreti - dekontlarinToplami;
							//


							var satirText = 
								'<td>'+buDoneminDenetimleri[j]['DENETIM_TARIHI_BASLANGIC']+'</td>'
							+	'<td>'+((buDoneminDenetimleri[j]['YB_KODU']!='') ? 'YB-'+buDoneminDenetimleri[j]['YB_KODU'] : 'BK-'+buDoneminDenetimleri[j]['BK_KODU'] )+'</td>'
							+	'<td>'+ekiptekiKisiSayisi+'</td>'
							+	'<td><div class="denetimUcretiDiv row-'+j+'">'+buDoneminDenetimleri[j]['DENETIM_UCRETI']+'</div></td>'
							+	'<td><input style="width:75px;" value="'+buDenetiminIlaveUcreti+'" class="numberInput ilaveDenetimBedeli row-'+j+'" name="kaydetmeyeIlaveDenetimBedelleri[]"></td>'
							+	'<td><div class="toplamDenetimUcreti row-'+j+'">'+toplamDenetimUcreti+'</td>'
							+	'<td><div class="adaminDenetimeBorcluOlduguMiktar row-'+j+'">'+(parseInt(denetimBorcu))+'</td>'
							+	'<td>'+dekontTD+'<input type="hidden" class="denetimDekontlariToplami row-'+rowNumber+'" value="'+dekontlarinToplami+'">'
							+ 	((kurulusMu)?'':'<input type="button" class="dekontEkleButton denetimDekont denetimID-'+buDoneminDenetimleri[j]['DENETIM_ID']+'" value="Ekle">')
							+ 	'</td>';
							
								
							if(rowNumber%2==0)
								trClassName = 'odd';
							else
								trClassName = 'even';
								 
							satirText = '<tr id="'+denetimID+'" class="'+trClassName+'">' + satirText + '</tr>';
							rowNumber++;
							jQuery('#denetimlerTable').append(satirText); 
						}
					}

					//// DENETIM BITEEEER ////

					
					//// YILLIK AIDAT //////
					jQuery('#yillikAidatTable tbody tr').remove();
					var tarifeDonemleri = data['array']['TARIFE_DONEMLERI'];
					var rowNumber = 0;
					for(var i=0; tarifeDonemleri!=undefined && i<tarifeDonemleri.length; i++)
					{
						var tarifeDonemi = tarifeDonemleri[i];
						
						var buDonemdeVerilmisBelgeSayisi = (data['array']['BelgeMasraf'][i]['VERILEN_BELGE_SAYISI'].length > 0) ? data['array']['BelgeMasraf'][i]['VERILEN_BELGE_SAYISI'] : 0
						var buDonemdeAkrediteEdilmisKurulusSayisi = (tarifeDonemi['BU_DONEMDE_AKREDITE_EDILMIS_KURULUS']!=undefined && tarifeDonemi['BU_DONEMDE_AKREDITE_EDILMIS_KURULUS']!='') ? tarifeDonemi['BU_DONEMDE_AKREDITE_EDILMIS_KURULUS'] : 0

						var tarifeBirimFiyati = (tarifeDonemi['BIRIM_FIYAT']!='' && tarifeDonemi['BIRIM_FIYAT']!=undefined) ? tarifeDonemi['BIRIM_FIYAT'] : 0;
						var tarifeBirimFiyati_AkrediteKurulustan = (tarifeDonemi['YILLIK_AIDAT_AKREDITE_KURULUSTAN']!='' && tarifeDonemi['YILLIK_AIDAT_AKREDITE_KURULUSTAN']!=undefined) ? parseInt(tarifeDonemi['YILLIK_AIDAT_AKREDITE_KURULUSTAN']) : 0;
						var yillikAidataTabiGunler = (tarifeDonemi['YILLIK_AIDAT']!=undefined && tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDATA_TABI_GUN']!='') ? tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDATA_TABI_GUN']:0;  
						var yillikAidataTabiGunler2 = (tarifeDonemi['YILLIK_AIDAT']!=undefined && tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDATA_TABI_GUN_AKRDT']!='') ? tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDATA_TABI_GUN_AKRDT']:0;  
						var tarifeBaslangici = tarifeDonemi['TARIFE_BASLANGICI'].match(/(\d+)/g)[1]+'/'+tarifeDonemi['TARIFE_BASLANGICI'].match(/(\d+)/g)[0]+'/'+tarifeDonemi['TARIFE_BASLANGICI'].match(/(\d+)/g)[2];
						var tarifeBitisi = tarifeDonemi['TARIFE_BITISI'].match(/(\d+)/g)[1]+'/'+tarifeDonemi['TARIFE_BITISI'].match(/(\d+)/g)[0]+'/'+tarifeDonemi['TARIFE_BITISI'].match(/(\d+)/g)[2];
						var tarifeDonemiKacGun = daydiff(parseDate(tarifeBaslangici), parseDate(tarifeBitisi));
						var tarifeninYillikBedeli = yillikAidataTabiGunler * (tarifeBirimFiyati / tarifeDonemiKacGun).toFixed(2);
						var tarifeninYillikBedeli_Akr = tarifeBirimFiyati_AkrediteKurulustan * yillikAidataTabiGunler2 / tarifeDonemiKacGun;
						//var yillikAidatDekontlari = data['array']['AIDAT_DEKONTLARI'][tarifeDonemi['TARIFE_DONEMI_ID']];
						var yillikAidatDekontlari = (tarifeDonemi['YILLIK_AIDAT']!=undefined)?data['array']['AIDAT_DEKONTLARI'][tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDAT_ID']] : {};
						
						//var yillikAidatDekontlari = data['array']['AIDAT_DEKONTLARI'][(i+1)];
						var dekontlarinToplami = 0;
						var satirText = '';
						var dekontTD = '';
						for(var k=0; yillikAidatDekontlari!=undefined && k<yillikAidatDekontlari.length; k++)
						{
							if(k==0)
								dekontTD += '<tr><td>SİL</td><td>DEKONT NO</td><td>TARİH</td><td>AÇIKLAMA</td><td>TUTARI</td></tr>';
								
							dekontTD += '<tr>';
							dekontTD += '<td rowspan="2">';
							dekontTD += (kurulusMu)?'':'<input type="button" value="SİL" class="dekontSilButton dekontID-'+yillikAidatDekontlari[k]['DEKONT_ID']+'">';
							dekontTD += '</td>';
							dekontTD += '<td>'+yillikAidatDekontlari[k]['DEKONT_NO']+'</td>';
							dekontTD += '<td>'+yillikAidatDekontlari[k]['DEKONT_TARIHI']+'</td>';
							dekontTD += '<td>'+yillikAidatDekontlari[k]['DEKONT_ACIKLAMA']+'</td>';
							dekontTD += '<td>'+yillikAidatDekontlari[k]['DEKONT_UCRETI']+'</td>';
							dekontTD += '</tr>';
							dekontTD += '<tr><td colspan="4">'+yillikAidatDekontlari[k]['DEKONT_UPLOADER_TD']+'</td></tr>';
							
							dekontlarinToplami += parseInt(yillikAidatDekontlari[k]['DEKONT_UCRETI']);
							if(k==yillikAidatDekontlari.length-1)
								dekontTD += '<tr><td colspan="5">TOPLAM: '+dekontlarinToplami+'</td></tr>';
							
						}
						if(yillikAidatDekontlari!=undefined && yillikAidatDekontlari.length != 0)
							dekontTD = '<table border="1" cellspacing="0" style="width:100%"><tbody>'+dekontTD+'</tbody></table>';

						var aidatIDData = (tarifeDonemi['YILLIK_AIDAT']!=undefined) ? tarifeDonemi['YILLIK_AIDAT']['YILLIK_AIDAT_ID'] : 'undefined';

						var yillikAidatHesaplanisiText = '('+ tarifeBirimFiyati +'<br>*'+ yillikAidataTabiGunler +'<br>/'+ tarifeDonemiKacGun +')<br>+('+tarifeBirimFiyati_AkrediteKurulustan+'<br>*'+ yillikAidataTabiGunler +'<br>/'+ tarifeDonemiKacGun +')<br>=' + (tarifeninYillikBedeli+tarifeninYillikBedeli_Akr).toFixed(2);
						
						satirText = 
							'<td><select disabled>'+tarifeDonemi['DONEM_OPTIONS']+'</select></td>'
						+	'<td><input type="hidden" name="kaydedilecekYillikAidatlarinTarifeDonemiIDleri[]" value="'+tarifeDonemi['TARIFE_DONEMI_ID']+'" >'
						+ 		'<input style="width:80px;" type="text" class="numberInput" name="kaydedilecekYillikAidataTabiGunler[]" value="'+ yillikAidataTabiGunler +'"></td>'
						+	'<td>'+buDonemdeVerilmisBelgeSayisi+'</td>'//((tarifeDonemi['HESAPLANAN_BELGE_SAYISI']!='') ? tarifeDonemi['HESAPLANAN_BELGE_SAYISI'] : 0 )
						+ 	'<td><input style="width:80px;" type="text" class="numberInput" name="kaydedilecekYillikAidataTabiGunler2[]" value="'+ yillikAidataTabiGunler2 +'"></td>'
					//	+	'<td>'+yillikAidatHesaplanisiText+'</td>'
						+	'<td>'+buDonemdeAkrediteEdilmisKurulusSayisi+'</td>'
						+	'<td>'+ (tarifeninYillikBedeli).toFixed(2) +'</td>'
						+	'<td>'+ (tarifeninYillikBedeli_Akr).toFixed(2) +'</td>'
						+	'<td>'+ (tarifeninYillikBedeli+tarifeninYillikBedeli_Akr).toFixed(2) +'</td>'
						+	'<td>'+ (tarifeninYillikBedeli+tarifeninYillikBedeli_Akr-dekontlarinToplami).toFixed(2) +'</td>'
						+	'<td>'+ dekontTD
						+ 	((kurulusMu)?'':'<input type="button" class="dekontEkleButton yillikAidatDekont aidatID-'+aidatIDData+'" value="Ekle">')
						+	'</td>';

						if(i%2==0)
							trClassName = 'odd';
						else
							trClassName = 'even';

						if(satirText!='')
							satirText = '<tr class="'+trClassName+'">'+satirText+'</tr>';
							
						jQuery(yillikAidatTable).append(satirText); 
						
					}
			  }
			  else
			  {
				  alert(data['data']);
			  }

		  }
	});

	
}

<?php 
if($_GET['uid']!='')
	echo ' kurulusSelectiniAyarla('.$_GET['uid'].');  putUserDataToGrids('.$_GET['uid'].'); ';

?>

function kurulusSelectiniAyarla(user_id)
{
	jQuery('#kurulusSelect option').removeAttr('selected');
	jQuery('#kurulusSelect option').each(function(e){
		if(jQuery(this).val()==user_id)
			jQuery(this).attr('selected','selected');
	});
}

function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function daydiff(first, second) {
	var saysay = (second-first)/(1000*60*60*24)+1;
	if(saysay == 366){
		saysay = 365;
	}
    return saysay; 
}


</script>