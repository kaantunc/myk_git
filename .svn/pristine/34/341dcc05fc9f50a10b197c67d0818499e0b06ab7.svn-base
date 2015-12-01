<form method="post" name="formm" id="formm" action="index.php?option=com_kurulus_akredite_et&task=akrediteKurulusKaydet" >
<h4>Akredite Edilecek Kuruluşları Kaydediniz</h4>

<table style="width:100%; float:left;" id="akrediteEdilecekKuruluslar">
<thead>
	<tr>
		<td>#</td>
		<td>Kuruluş Adı</td>
	</tr>
</thead>
<tbody>
<?php 
$model = $this->getModel();
$kaydedilmisKuruluslarInput='';
//$akrediteEdilebilecekKuruluslarSelectOptions = $model->getAkrediteEdilebilecekKuruluslar($kaydedilmisKuruluslarInput);



$tumKuruluslar = $model->getAkrediteEdilebilecekKuruluslar();

$user = & JFactory::getUser();
$user_id = $user->getOracleUserId();
$seciliKuruluslar = $model->getAkrediteEdilmisKurulusIDleri($user_id);
foreach($tumKuruluslar as $kurulus)
{
	$oncedenKayitliMi = in_array($kurulus['USER_ID'], $seciliKuruluslar);
	$checked = ($oncedenKayitliMi) ? ' checked ' : '';
	$kaydedilmisKuruluslarInput .= ($oncedenKayitliMi) ? ' <input class="oncedenAkrediteOlmusKuruluslar" name="oncedenAkrediteOlmusKuruluslar[]" type="hidden" value="'.$kurulus['USER_ID'].'" > ' : '';
		
	echo '
	<tr>
		<td>
			<input name="duzenlemedenSonrakiIDler_Kaydedilmemis[]" class="akrediteCheckbox" type="checkbox" '.$checked.' value="'.$kurulus['USER_ID'].'" ><script>';
	echo ($checked)?'
			jQuery("#formm").append("<input class=\'duzenlemedenSonrakiIDler\' name=\'duzenlemedenSonrakiIDler[]\' type=\'hidden\' value=\''.$kurulus['USER_ID'].'\'> "); ': '';
	
	echo '</script></td>
		<td>
			'.$kurulus['KURULUS_ADI'].'
		</td>
	</tr>';
}










//echo $akrediteEdilebilecekKuruluslarSelectOptions;
?>
</tbody></table>

<br>
<?php echo $kaydedilmisKuruluslarInput; ?>
<div style="width:100%; float:left;">
	<input type="submit" value="KAYDET" >
</div>
</form>
<script>
var settings = {
		"bSort" : false,
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

	
jQuery('#akrediteEdilecekKuruluslar').dataTable(settings);


jQuery('.akrediteCheckbox').live('click', function(e){
	if(jQuery(this).attr('checked')=='checked')
	{
		jQuery('#formm').append('<input class="duzenlemedenSonrakiIDler" name="duzenlemedenSonrakiIDler[]" type="hidden" value="'+jQuery(this).val()+'">');
	}
	else
	{
		jQuery('.duzenlemedenSonrakiIDler[value="'+jQuery(this).val()+'"]').remove();
	}
});
</script>