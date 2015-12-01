<h4>Akredite Edilmiş Kuruluşlar</h4>

<select style="float:left;" id="akrediteEdenSelect">
<?php 

$model = $this->getModel();
$akrediteEdecekKuruluslar = $model->getAkrediteEdenKuruluslar();

for($i=0; $i<count($akrediteEdecekKuruluslar); $i++)
	echo '<option value="'.$akrediteEdecekKuruluslar[$i]['USER_ID'].'">'.$akrediteEdecekKuruluslar[$i]['KURULUS_ADI'].'</option>';
?>
</select>
<input style="float:left;" id="getirButton" value="GETİR" type="button">
<div id="uyariDiv" style="float:left; color:red;"></div>
<br>
<div id="akrediteEdilmisKuruluslarTableDiv"  style="float:left; width:100%;" >
<table style="width:100%; float:left;" id="akrediteEdilmisKuruluslarTable">
<thead><tr><th>Akredite Edilen Kuruluş Adı</th><th>Akreditasyon Tarihi</th></tr></thead>
<tbody>
</tbody>
</table>
</div>


<script>
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

	
jQuery('#akrediteEdilmisKuruluslarTable').dataTable(settings);

jQuery('#getirButton').click(function(e){

	jQuery('#akrediteEdilmisKuruluslarTableDiv').hide('slow');
	jQuery('#uyariDiv').html('Getiriliyor').show('slow');

	var url = 'index.php?option=com_kurulus_akredite_et&task=ajaxKurulusunAkrediteEttigiKuruluslariGetir&format=raw&akrediteEdenID='+jQuery('#akrediteEdenSelect').val();

	jQuery.ajax({
		  url: url,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			 			  
			  if(data['success']){
				  content = data['array'];

				  jQuery('#akrediteEdilmisKuruluslarTable tbody tr').remove();
				  
				  for(var i=0; i<content.length; i++)
				  { 
					  var satirClass = (i%2==0) ? 'odd' : 'even';
					  var satirText = '<tr class="'+satirClass+'"><td>'+content[i]['KURULUS_ADI']+'</td><td>'+content[i]['AKREDITASYON_TARIHI']+'</td></tr>';
				  	  jQuery('#akrediteEdilmisKuruluslarTable tbody').append(satirText);
				  }
			  }
			  else
			  {
				alert("Hata");
			  }

			  jQuery('#akrediteEdilmisKuruluslarTableDiv').show('slow');
			  jQuery('#uyariDiv').hide('slow');
			
		  }
	});
	
});

</script>