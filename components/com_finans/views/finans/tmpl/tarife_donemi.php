<?php 
if($_GET['donem_id']!='')
{
	$donem = $this->seciliDonem;
	$tablo1 = $this->seciliDonemAralikliTablo_1;
	$tablo2 = $this->seciliDonemAralikliTablo_2;
	
}

$user = & JFactory::getUser();
$userId = $user->getOracleUserId();

$adminMi = FormFactory::checkAclGroupId ($user->id, YONETICI_GROUP_ID);

?>
<style>
table tr td
{
	text-align: center;
}
</style>
<script>
function addRowToAralikliTables(tabloNo, baslangici, bitisi, parasi )
{
	if(jQuery('#yillikAidatTable_'+tabloNo+' .dataTables_empty').length>0)
		jQuery('#yillikAidatTable_'+tabloNo+' .dataTables_empty').parent().remove();

	var className='';
	if(jQuery('#yillikAidatTable_'+tabloNo+' tr').length%2==1)
		className='odd';
	else
		className='even';

	
	var firstInputData = '<input type="text" class="numberInput baslangicInput" name="aralikBaslangiclari['+tabloNo+'][]" value="'+baslangici+'">';
	var secondInputData = '<input type="text" class="numberInput bitisInput" name="aralikBitisleri['+tabloNo+'][]" value="'+bitisi+'">';
	var thirdInputData = '<input type="text" class="numberInput" name="aralikFiyatlari['+tabloNo+'][]" value="'+parasi+'">';
	var deleteButtonData = '<input type="button" value="SİL" class="silButton">'
	
	var rowText = '<tr class="'+className+'">'
				+ '<td>'+firstInputData+'&nbsp;&nbsp;-&nbsp;&nbsp;'+secondInputData+'</td>'
				+ '<td>'+thirdInputData+'</td>'
				+ '<td class="silButtonTD">'+deleteButtonData+'</td></tr>';
	
	jQuery('#yillikAidatTable_'+tabloNo).append(rowText);
	
}

</script>

<form id="tarifeDonemiForm" action="index.php?option=com_finans&task=tarifeDonemiKaydet" method="POST">

<input type="hidden" name="donem_id" id="donem_id" value="<?php echo $_GET['donem_id']; ?>">

<?php 
	
printRowHTML_Input('TARİFE DÖNEMİ BAŞLANGICI', 'tarifeBaslangici', 'datepicker', str_replace("/", ".", $donem['TARIFE_BASLANGICI']));
printRowHTML_Input('TARİFE DÖNEMİ BİTİŞİ', 'tarifeBitisi', 'datepicker',  str_replace("/", ".", $donem['TARIFE_BITISI']));
printRowHTML_Input('BELGE MASRAF KARŞILIĞI', 'belgeMasrafi', 'numberInput',  $donem['BELGE_MASRAFI']);
printRowHTML_Input('YETKİLENDİRME BAŞVURU MASRAF KARŞILIĞI', 'yetkilendirmeBasvuruMasrafi', 'numberInput',  $donem['YETKILENDIRME_BASVURU_MASRAFI']);
//YILLIK AIDAT

?>


<br><h4 style="float: left; padding-top: 15px; width: 100%;">YILLIK AİDAT</h4>
<h4>a. Yetkilendirilmiş Belgelendirme Kuruluşları İçin:</h4>


	<table style="width:100%; float:left;" id="yillikAidatTable_1">
		<thead>
			<tr>
				<th style="width: 50%;">
					<input type="button" id="yeniSatirEkle-1" class="yeniSatirEkle" style="float:left" value="EKLE">
					YILLIK DÜZENLENEN MESLEKİ YETERLİLİK BELGE SAYISI
				</th>
				<th style="width: 40%;">YILLIK AİDAT TUTARI</th>
				<th class="silButtonTD">SİL</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>




<h4>b. Yetkilendirilmiş Eğitim Akreditasyon Kuruluşları İçin:</h4>


	<table style="width:100%; float:left; padding-bottom:10px;" id="yillikAidatTable_2">
		<thead>
			<tr>
				<th style="width: 50%;">
					<input type="button" id="yeniSatirEkle-2"  class="yeniSatirEkle" style="float:left" value="EKLE">
					AKREDİTE KURULUŞ SAYISI
				</th>
				<th style="width: 40%;">YILLIK AİDAT TUTARI</th>
				<th class="silButtonTD">SİL</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>

	
<?php
printRowHTML_Input('DENETİM BEDELİ (ADAM/GÜN)', 'denetimBedeli', 'numberInput', $donem['DENETIM_BEDELI_ADAM_UCRET']);

echo '<script>';

foreach ($tablo1 as $row)
	echo ' addRowToAralikliTables(1, '.$row['BASLANGIC'].', '.$row['BITIS'].', '.$row['FIYAT'].'); ';

foreach ($tablo2 as $row)
	echo ' addRowToAralikliTables(2, '.$row['BASLANGIC'].', '.$row['BITIS'].', '.$row['FIYAT'].'); ';

echo '</script>';

?>	


<?php 


if($adminMi==true)
	echo '<input type="button" value="KAYDET" id="kaydetButtonu">';
else //sil ve ekle buttonlarını gizle
	echo '<script>jQuery(".silButton, .silButtonTD, .yeniSatirEkle").remove();</script>';
?>

<font id="errorDiv" color="red" style="display:none; width:100%; float:left;">Lütfen Gerekli Alanları Doldurunuz</font>





<script>

var settings = {
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
		"bSort":false,
	    "oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("FILTER");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
};


var oTableKurulus1 = jQuery('#yillikAidatTable_1').dataTable(settings);
var oTableKurulus2 = jQuery('#yillikAidatTable_2').dataTable(settings);
jQuery('.datepicker').datepicker({});

jQuery('#kaydetButtonu').click(function(e){

	if(inputlarValidMi() == true)
	{
		jQuery('#tarifeDonemiForm').attr("action", "index.php?option=com_finans&task=tarifeDonemiKaydet");
		jQuery('#tarifeDonemiForm').submit();
	}
	
});


function inputlarValidMi()
{
	result = true;
	//text inputs
	jQuery('#tarifeDonemiForm input').filter('[type=text]').filter('[value=""]').each(function(e){

		if(jQuery(this).val()=='')
		{
			result = false;
			jQuery(this).css('border','1px solid red');
			jQuery('#errorDiv').html("Lütfen Gerekli Alanları Doldurunuz");
		}
		else
		{
			jQuery(this).css('border','1px solid #C0C0C0');
		}
	});

	
	if(result==false)
	{	
		jQuery('#kaydetButtonu').css('border','1px solid red');
		jQuery('#errorDiv').show("slow");
	}
	else
	{
		jQuery('#kaydetButtonu').css('border','1px solid #C0C0C0');
		jQuery('#errorDiv').hide("slow");
	}

	return result;
}


jQuery('.yeniSatirEkle').live('click', function(e){
	var tabloNo = jQuery(this).attr('id').split('-')[1];
	
	addRowToAralikliTables(tabloNo, '', '', '' );
	
});




jQuery('.silButton').live('click', function(e){
	jQuery(this).parent().parent().remove();
});

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


//

</script>





<?php 



function printRowHTML_Input($title, $inputName, $inputClass, $inputValue)
{
	$width1 = '35%';
	$width2 = '64%;';
	
	echo '
	<div style="width:100%; float:left; padding-bottom:3px;">
		<div style="width:'.$width1.'; float:left;">
		<strong>'.$title.'</strong>
	</div>
	<div style="width:'.$width2.'; float:left;">
		<input class="'.$inputClass.'" name="'.$inputName.'" type="text" value="'.$inputValue.'">
		</div>
	</div>
	';
}
?>


</form>
