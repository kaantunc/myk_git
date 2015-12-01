<?php 

?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_5&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 5 : Resmi Görüşe Gönderilmesi Öncesinde Yeterlilik Taslağına Katkıda Bulunan Kurum/Kuruluşlar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item"  style="float:left; width:100%;">
	<div style="float:left; width:100%;padding:15px 30px;">
		<input type="button" style="float:left;"  value="Ekleme Yap" onclick="jQuery('#kurulusTopluEklemeDiv').toggle('slow');" />
	
	</div>
	<div style="float:left; width:100%; display:none;padding-left:30px;" id="kurulusTopluEklemeDiv">
		<textarea id="kurulusTopluEklemeTextArea" style=" width:800px; height:150px; "></textarea><br>
		<input type="button" class="kurulusTopluEklemeTumunuEkleButton" id="kurulusTopluEklemeTumunuEkleButton" value="Tümünü Ekle" style="float:left; " />
	</div>
</div>


<div class="form_item"  style="float:left; width:100%;">
	<table id="ek5Tablosu" style="width:100%; padding-left:20px; padding-right:30px;">
		<thead><tr><th class="siraNoTD">Sıra No</th><th>Kurum/Kurulus Adı</th><th class="silButtonTD">SİL?</th></tr></thead>
		<tbody>
		<?php 
		$ek5Tablosu = $this->ek5Tablosu;
		for($i=0; $i<count($ek5Tablosu); $i++)
		{
			
			echo '<tr>
				<td class="siraNoTD">'.($i+1).'</td>
				<td><input style="width:100%;" type="text" id="inputkurulus-2-'.($i+1).'" name="inputkurulus-2[]" value="'.$ek5Tablosu[$i]["YETERLILIK_KURULUS_ADI"].'"></td>
				<td class="silButtonTD"><input type="button" value="SİL" onClick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle(); " /></td>
			</tr>';
		}
		
		
		?>
		</tbody>
	</table>
</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_5', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";



var settings = {
		"bPaginate": false,
 		"bFilter": false,
 		"bInfo": false,
	    
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

						
var oTable = jQuery('#ek5Tablosu').dataTable(settings);


jQuery('#kurulusTopluEklemeTumunuEkleButton').click( function (e) {
		text=jQuery("#kurulusTopluEklemeTextArea").val();
	    text=text.replace("\r\n","\n");
	    var ek1Array=text.split("\n");

	    for(var i=0; i<ek1Array.length; i++)
	    {   
		    
		    var readOnlyValue = "";
			if (isReadOnly)
				readOnlyValue = ' readOnly="true" ';
			
		    
			var x = "inputkurulus-1[]";
			var rowCount = jQuery('#ek5Tablosu tbody tr').length;
			var nextRowNumber = rowCount+1;

			satirRow = '<tr>'
				+'<td class="siraNoTD">'+nextRowNumber+'</td>'
                +'<td><input style="width:100%;" id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ ek1Array[i] +'"></td>' 
                +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';

    		if(jQuery(".dataTables_empty").length == 0)
				jQuery('#ek5Tablosu tbody').append(satirRow);
    		else
    		{
    			jQuery('#ek5Tablosu tbody tr').remove();
    			jQuery('#ek5Tablosu tbody').append(satirRow);
    		}
		    
		//    var satirText = '<tr class="tablo_row2 even" id="tablo_kurulus_6"><td class="  sorting_1"><input type="text" id="inputkurulus-1-6" name="inputkurulus-1[]" size="4" value="6" readonly=""></td><td class=" "><input type="text" id="inputkurulus-2-6" name="inputkurulus-2[]" size="40"></td><td width="10%" class="tablo_sil_hucre "><input type="button" id="satirSil_kurulus-6" value="SİL"></td></tr>';
	   	//	jQuery('#tablo_kurulus  tbody').append(satirText);
	    }
	    jQuery("#kurulusTopluEklemeTextArea").val("");
	    jQuery("#kurulusTopluEklemeDiv").toggle("slow");

	    tabloyuDuzenle();
		return false;
	} );



function tabloyuDuzenle()
{
	var rowElements = jQuery('#ek5Tablosu tbody tr');
	for(var i=0; i<rowElements.length; i++)
	{
		var classname = "even";
		if(i%2 == 1)
			classname = "odd";
			
		jQuery(rowElements[i]).attr("class", classname);
		jQuery(rowElements[i].getChildren()[0]).html(i+1);
	}
		
}




</script>
