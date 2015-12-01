<?php echo $this->sayfaLink;?>
<form id="kodDuzenleForm" method="post" action="index.php?option=com_denetim&task=kodKaydet&denetim_id=<?php echo $_GET['denetim_id'];?>">

<?php 

$denetim_id = $_GET['denetim_id'];

$db  = &JFactory::getOracleDBO();
	
$sql = "SELECT * FROM M_DENETIM WHERE DENETIM_ID=?";

$result = $db->prep_exec($sql, array($denetim_id));


?>


BK-<input type="text" class="numberInput" id="BKTextbox" value="<?php echo $result[0]['BK_KODU']; ?>" />
<br>
YB-<input type="text" class="numberInput" id="YBTextbox" value="<?php echo $result[0]['YB_KODU']; ?>" />
<br>
<font id="errorText" color="red"></font><br>
<input type="button" id="submitButton" value="Kaydet">

</form>

<script>

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

jQuery('#submitButton').click(function(e){
	e.preventDefault();
	checkIfValuesAreOK();

});

function checkIfValuesAreOK()
{
	var BKValue = jQuery('#BKTextbox').val();
	var YBValue = jQuery('#YBTextbox').val();

	if(BKValue.length==1)
		BKValue = '0'+BKValue;
	
	if(YBValue.length==1)//mesela 1 yazılmışsa 01 diye bakılsın
		YBValue = '0'+YBValue;

	

	jQuery('#errorText').html("Kontrol Ediliyor").show();
	

	jQuery.ajax({
		  url: "index.php?option=com_denetim&task=ajaxCheckBKYBKodlari&format=raw&bk="+BKValue+"&yb="+YBValue+"&denetim_id="+<?php echo $_GET['denetim_id'];?>,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){

				 jQuery('#BKTextbox').css('border', '1px solid #c0c0c0');
				 jQuery('#YBTextbox').css('border', '1px solid #c0c0c0');
				 jQuery('#errorText').html("Kaydediliyor");

				 jQuery('#kodDuzenleForm').attr('action', 'index.php?option=com_denetim&task=kodKaydet&denetim_id=<?php echo $_GET['denetim_id'];?>&bk='+BKValue+'&yb='+YBValue);
				 jQuery('#kodDuzenleForm').submit();  
				
			  }
			  else
			  {

				if(jQuery.inArray('1', data['array'])>=0)
					jQuery('#BKTextbox').css('border', '1px solid red');
				else
					jQuery('#BKTextbox').css('border', '1px solid #c0c0c0');
				
				if(jQuery.inArray('2', data['array'])>=0)
					jQuery('#YBTextbox').css('border', '1px solid red');
				else
					jQuery('#YBTextbox').css('border', '1px solid #c0c0c0');

				jQuery('#errorText').html("Kod(lar) zaten kullanımda").show();
								
				return false;
				
			  }
		  }
	});
	
}

</script>