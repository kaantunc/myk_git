<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Terimler Sözlüğü</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="terimSozluguForm" name="terimSozluguForm" method="post"
		action="#">
	
		<div class="toolbar">
			<input
				id="aktiflestirButton" value="Aktif Hale Getir"
				name="aktiflestirButton" type="button"
				/> 
			<input
				id="pasiflestirButton" value="Pasif Hale Getir"
				name="pasiflestirButton" type="button"
				/> 
			<input
				id="silButton" value="Sil" 
				name="silButton" type="button" 
				/> 
			<input id="duzenleButton" value="Düzenle"
				name="duzenleButton" type="button" disabled="disabled" class="disabled"  />
			
			<input id="yeniButton" value="Yeni" name="yeniButton"
				type="button"/> 
			
						
			<div id="yeniTerimDiv" class="yeniTerimDiv">
			
				
				<input type="text" id="terimDuzenle_HiddenField" class="uppercase" name="terimDuzenle_HiddenField" />
				
				Terim Adı
				<input type="text" id="yeniTerim_AdTextbox" class="uppercase" name="yeniTerim_AdTextbox" />
				
				Açıklama
				<textarea id="yeniTerim_AciklamaTextArea" class="yeniTerim_AciklamaTextArea"></textarea>
			
			
			NOT:::: TEK CHECKBOX'U CHECK EDIP UNCHECK EDINCE SHOW HIDE OLUYOR ONA BAK!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			
				<input id="yeniTerim_GetirButton" class="buttonOnTheBottom" value="GETIR" name="yeniTerim_GetirButton"
				type="button"/>
				<input id="yeniTerim_EkleButton" class="buttonOnTheBottom" value="EKLE" name="yeniTerim_EkleButton"
				type="button"/>
				<input id="terimDuzenle_KaydetButton" class="buttonOnTheBottom" value="KAYDET" name="terimDuzenle_KaydetButton"
				type="button"/>
				
				 
			</div>
			
			<div style="clear: both;"></div>
		</div>
		
		<div style="margin-top:10px;">
			<table style="width:100%;" id="terimlerGridview">
				<thead >
					<tr>
						<th>#</th>
						<th>Terim ID</th>
						<th>Terim Adı</th>
						<th>Terim Açıklama</th>
						<th>Aktiflik</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$terimListesi = $this->terimListesi;
				
				for ($i = 0; $i < count($terimListesi); $i++)
				{
					$satir = $terimListesi[$i];
					if($satir["AKTIFLIK_ID"]== PM_TERIM_AKTIFLIK__AKTIF)
						$class = "greenTextClass";
					else
						$class = "redTextClass";
							
					
					echo '<tr>';
					echo '<td><input onclick="checkboxaGoreDuzenleTusunuDisableEt();" type="checkbox" value="'.$satir["TERIM_ID"].'" name="terimlerCheckbox[]" class="terimlerCheckbox" id="terimlerCheckbox'.$i.'"></td>';
					echo '<td>'.$satir["TERIM_ID"].'</td>';
					echo '<td>'.$satir["TERIM_ADI"].'</td>';
					echo '<td>'.$satir["TERIM_ACIKLAMA"].'</td>';
					echo '<td><font class="'.$class.'">'.$satir["ACIKLAMA"].'</font></td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
		
		<div class="modal"><!-- Place at bottom of page --></div>
		
	</form>
	
	<div style="clear:both;"></div>
</div>

<script type="text/javascript">
var settings = {
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
	
var seciliTerimIDleri = [];

jQuery(document).ready(function() {
	//INIT DATATABLE
    var oTableTerimler = jQuery('#terimlerGridview').dataTable(settings);
	var terimIDToEdit = 0;
	var duzenleniyorMu = false;
	var yeniTerimGiriliyorMu = false;
	
    jQuery('#yeniButton').live('click', function (e) {
    	
    	if(jQuery('.yeniTerimDiv').css('display') != 'none')
    	{	//AÇIK BU, KAPANIRKEN YAPMASI GEREKENLERI BURAYA YAZ.
    		
    		if(duzenleniyorMu == true)
    		{
    			jQuery('.yeniTerimDiv').toggle('slow');
    			jQuery('#yeniTerim_GetirButton').show();
        		jQuery('#yeniTerim_EkleButton').show();
        		jQuery('#terimDuzenle_KaydetButton').hide();

        		duzenleniyorMu = false;    
        		yeniTerimGiriliyorMu = true;
        	}
    		else
    		{
        	}
        }
    	else
    	{	//KAPALI O, AÇILIRKEN YAPMASI GEREKENLERI BURAYA YAZ.
    		jQuery('#yeniTerim_GetirButton').show();
    		jQuery('#yeniTerim_EkleButton').show();
    		jQuery('#terimDuzenle_KaydetButton').hide();

    		duzenleniyorMu = false;    
    		yeniTerimGiriliyorMu = true;		
        }
        
    	
    	jQuery('.yeniTerimDiv').toggle('slow');//EN SON KAPA
     	// Stop event handling in IE
        return false;
    } );

    jQuery('#duzenleButton').live('click', function (e) {

    	if(jQuery('.yeniTerimDiv').css('display') != 'none')
    	{	//AÇIK BU, KAPANIRKEN YAPMASI GEREKENLERI BURAYA YAZ.
    		if(yeniTerimGiriliyorMu == true)
    		{
    			jQuery('.yeniTerimDiv').toggle('slow');
    			jQuery('#yeniTerim_GetirButton').hide();
        		jQuery('#yeniTerim_EkleButton').hide();
        		jQuery('#terimDuzenle_KaydetButton').show();

        		yeniTerimGiriliyorMu = false;    
        		duzenleniyorMu = true;
        	}
    		else
    		{
        	}
    		
        }
    	else
    	{	//KAPALI BU, AÇILIRKEN YAPMASI GEREKENLERI BURAYA YAZ.
        	duzenleniyorMu = true;
    		jQuery('#yeniTerim_GetirButton').hide();
    		jQuery('#yeniTerim_EkleButton').hide();
    		jQuery('#terimDuzenle_KaydetButton').show();
    		terimIDToEdit = jQuery('input[type=checkbox]').filter(':checked').val();

    		jQuery('#terimDuzenle_HiddenField').val(terimIDToEdit);
			var nRow = jQuery('input[type=checkbox]').filter(':checked').parents('tr')[0]; 
    		
    		
    		duzenleniyorMu = false;    
    		yeniTerimGiriliyorMu = false;		
        }
        
    	
    	jQuery('.yeniTerimDiv').toggle('slow');//EN SON KAPA
     	// Stop event handling in IE
        return false;
    } );

    jQuery('#yeniTerim_GetirButton').live('click', function (e) {

    	searchDictionary();
        return false;
    } );
    
    jQuery('#yeniTerim_EkleButton').live('click', function (e) {
        
		addToDictionary();
    	// Stop event handling in IE
        return false;
    } );
    
    
    jQuery("body").on({
        ajaxStart: function() { 
        	jQuery(this).addClass("loading"); 
        },
        ajaxStop: function() { 
        	jQuery(this).removeClass("loading"); 
        }    
    });

    jQuery('#terimlerGridview_next, #terimlerGridview_previous').live('mousedown', function (e) {
		terimIDleriniKaydet();
	});

	jQuery('#pasiflestirButton').live('click', function (e) {
		terimIDleriniKaydet();
		setAktiflik(seciliTerimIDleri, 0);
    	// Stop event handling in IE
        return false;
    } );

	jQuery('#aktiflestirButton').live('click', function (e) {
		terimIDleriniKaydet();
		setAktiflik(seciliTerimIDleri, 1);
    	// Stop event handling in IE
        return false;
    } );
    
});


function terimIDleriniKaydet()
{
	jQuery('.terimlerCheckbox').each(function() {
		var index = seciliTerimIDleri.indexOf(jQuery(this).val());
		if( index != -1)
			seciliTerimIDleri.splice(index, 1);				
		
	 }); //DROP ALL THE CHECKBOXES IF THEY EXIST

	jQuery('.terimlerCheckbox:checked').each(function() {
		var terimID = jQuery(this).val();
		seciliTerimIDleri.push(terimID);
		
	 });//ADD THE ONES THAT ARE SELECTED AND NOT IN THE ARRAY
}


function addToDictionary()
{
	var terimAdi = jQuery("#yeniTerim_AdTextbox").val();  
	var terimAciklama = jQuery("#yeniTerim_AciklamaTextArea").val();

	if(terimAdi.length>0 && terimAciklama.length>0 )
	{
		jQuery("#yeniTerim_AdTextbox").css("border", "1px solid #C0C0C0");
		jQuery("#yeniTerim_AciklamaTextArea").css("border", "1px solid #C0C0C0");
		
		var jqInputs = jQuery("#yeniTerim_AdTextbox");
		var sendData = jqInputs.serializeArray();

		var obj = new Object;
		obj.name= 'terimAdi';
		obj.value= terimAdi;
		sendData.push(obj);
		
		var obj2 = new Object;
		obj2.name= 'terimAciklama';
		obj2.value= terimAciklama;
		sendData.push(obj2);
		
		jQuery.ajax({
			  url: "index.php?option=com_terim_sozlugu&task=ajaxSozlugeEkle&format=raw",
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
						alert("Başarıyla Eklendi");
						searchDictionary();
				  }
				  else
				  {
					  	alert("FAIL, LOL !");
				  }
			  }
		});
	
	}
	else
	{
		alert("Terim Adı veya Açıklaması Boş Bırakılamaz.");
		jQuery("#yeniTerim_AdTextbox").css("border", "1px solid red");
		jQuery("#yeniTerim_AciklamaTextArea").css("border", "1px solid red");
	}	
}

function checkboxaGoreDuzenleTusunuDisableEt()
{
	var $b = jQuery('input[type=checkbox]');
	var count = $b.filter(':checked').length; // works
	if(count==1)
	{
		jQuery("#duzenleButton").removeAttr('disabled');
		var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
		
	}
	else
	{
		jQuery("#duzenleButton").attr('disabled', 'disabled');
		jQuery('.yeniTerimDiv').toggle('slow');//EN SON KAPA
	}
}

function searchDictionary()
{
	
	var terimAdi = jQuery("#yeniTerim_AdTextbox").val();  
	var terimAciklama = jQuery("#yeniTerim_AciklamaTextArea").val();

	if(terimAdi.length > 0 || terimAciklama > 0)
	{
		jQuery("#yeniTerim_AdTextbox").css("border", "1px solid #C0C0C0");
		jQuery("#yeniTerim_AciklamaTextArea").css("border", "1px solid #C0C0C0");

		var jqInputs = jQuery("#yeniTerim_AdTextbox");
		var sendData = jqInputs.serializeArray();

		var obj = new Object;
		obj.name= 'terimAdi';
		obj.value= terimAdi;
		sendData.push(obj);
		
		var obj2 = new Object;
		obj2.name= 'terimAciklama';
		obj2.value= terimAciklama;
		sendData.push(obj2);
		
		jQuery.ajax({
			  url: "index.php?option=com_terim_sozlugu&task=ajaxSozlukteAra&format=raw",
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					  putTerimlerToGrid(data['array']);
				  }
				  else
				  {
					  	
				  }
			  }
		});
		
	} 
	else
	{
		alert("En az bir alanı doldurunuz.");

		jQuery("#yeniTerim_AdTextbox").css("border", "1px solid #C0C0C0");
		jQuery("#yeniTerim_AciklamaTextArea").css("border", "1px solid #C0C0C0");

			
	}
		
	
	
}

function putTerimlerToGrid(arrayToPut)
{
	var oTableTerimler = jQuery('#terimlerGridview').dataTable();
	oTableTerimler.fnClearTable();
	
    for(var i=0; i<arrayToPut.length; i++)
    {
        var aktiflikTextClass = "";
        if(arrayToPut[i]["AKTIFLIK_ID"]=='1')
        	aktiflikTextClass = "greenTextClass";
        else
        	aktiflikTextClass = "redTextClass";
    	
    	oTableTerimler.fnAddData( [
			'<input onclick="checkboxaGoreDuzenleTusunuDisableEt();" type="checkbox" value="'+arrayToPut[i]["TERIM_ID"]+'" name="terimlerCheckbox[]" class="terimlerCheckbox" id="terimlerCheckbox'+i+'">',
			arrayToPut[i]["TERIM_ID"],
			arrayToPut[i]["TERIM_ADI"],
			arrayToPut[i]["TERIM_ACIKLAMA"],
			'<font class="'+aktiflikTextClass+'">'+arrayToPut[i]["ACIKLAMA"]+'</font>'				
    	]);

    }  
    
}

function setAktiflik(seciliTerimIDleri, aktiflestirsinMi)
{
	var aktiflik ="";
	var idlerString = "";
	for(var i=0; i<seciliTerimIDleri.length; i++)
	{
		idlerString += "&seciliTerimIDleri[]=";
		idlerString += seciliTerimIDleri[i];
	}

	if(aktiflestirsinMi==1)
		aktiflik="&aktiflestirsinmi=1";
	else
		aktiflik="&aktiflestirsinmi=0";

	document.terimSozluguForm.action = "index.php?option=com_terim_sozlugu&amp;task=updateAktifPasif"+aktiflik+idlerString;
    document.terimSozluguForm.submit();             // Submit the page
    return true;
}

</script>
