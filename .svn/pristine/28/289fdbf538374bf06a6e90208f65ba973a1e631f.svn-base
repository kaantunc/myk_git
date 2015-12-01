<?php echo $this->sayfaLink;?>
<style>
a
{
	text-decoration: underline;
}
table thead tr td
{
	font-weight: bold;
}
</style>


<?php
$user = & JFactory::getUser();
$userId = $user->getOracleUserId();
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);

$seciliDenetiminUygunsuzluklari = $this->seciliDenetiminUygunsuzluklari;



?>
<div style="overflow: auto">
<?php 
if($denetciMi || $isSektorSorumlusu)
	echo '<div style="width:100%; float:left;"><a href="index.php?option=com_denetim&layout=denetim_listele">GERİ</a>
				&nbsp;&nbsp;&nbsp; 
				| 
				&nbsp;&nbsp;&nbsp;
				<a href="index.php?option=com_denetim&layout=uygunsuzluk&denetim_id='.$_GET['denetim_id'].'">Yeni Uygunsuzluk Tanımla</a> 
		</div>';
?>

<br><br>
	
<table style="width:100%; float:left; padding-top:10px; padding-bottom:10px;" id="uygunsuzlukTable">
<thead><tr>
	<td align="center">#</td>
	<td align="center" width="30%">UYGUNSUZLUK AÇIKLAMASI</td>
	<td align="center" width="5%">TÜRÜ</td>
	<td align="center" width="10%">YERİNDE TAKİP</td>
	<td align="center" width="30%">DÜZELTİCİ FAALİYET AÇIKLAMASI</td>
	<td align="center" width="5%">GİDERİLDİ</td>
	<td align="center" width="5%">DÜZENLE</td>
    <td align="center" width="5%">PDF</td>
    <td align="center" width="5%">WORD</td>
    <?php if($denetciMi || $isSektorSorumlusu){?>
    	<td align="center" width="5%">Sil</td>
    <?php }?>
</tr></thead>
<tbody>


<?php 
foreach($seciliDenetiminUygunsuzluklari as $uygunsuzluk)
{
	echo '<tr>';
	$maximumCharacters = 100;
	
	if($uygunsuzluk['GIDERILDI_MI']=='1')
		$uygunsuzlukGiderildiMi = '<font color="green">Evet</font>';
	else
		$uygunsuzlukGiderildiMi = '<font color="red">Hayır</font>';

	if($uygunsuzluk['UYGUNSUZLUK_TURU']==PM_UYGUNSUZLUK_TURU__KUCUK)
		$uygunsuzlukTuru = '<font color="green">Küçük</font>';
	else
		$uygunsuzlukTuru = '<font color="red">Büyük</font>';
	
	if($uygunsuzluk['YERINDE_TAKIP_GEREKIR_MI']=='0')
		$uygunsuzlukYerindeTakip = '<font color="green">Gerektirmez</font>';
	else
		$uygunsuzlukYerindeTakip = '<font color="red">Gerektirir</font>';
	
	
	echo '<td>'.$uygunsuzluk['UYGUNSUZLUK_ID'].'</td><td>'. substr($uygunsuzluk['UYGUNSUZLUK_ACIKLAMASI'], 0, $maximumCharacters) .'... </td>'.
		'<td>'.$uygunsuzlukTuru.'</td>'.
		'<td>'.$uygunsuzlukYerindeTakip.'</td>'.
		'<td>'. substr($uygunsuzluk['DUZELTICI_FAALIYET'], 0, $maximumCharacters) .'... </td>'.
		'<td>'.$uygunsuzlukGiderildiMi.'</td>'.
		'<td align="center"><a href="index.php?option=com_denetim&layout=uygunsuzluk&uygunsuzluk_id='.$uygunsuzluk['UYGUNSUZLUK_ID'].'">DÜZENLE</a></td>'
        . '<td><a href="index.php?option=com_denetim&layout=uygunsuzluk_pdf&format=pdf&uygunsuzluk_id='.$uygunsuzluk['UYGUNSUZLUK_ID'].'" target="_blank">PDF</a></td>'
		. '<td><a href="index.php?option=com_denetim&layout=uygunsuzluk_word&uygunsuzluk_id='.$uygunsuzluk['UYGUNSUZLUK_ID'].'" target="_blank">WORD</a></td>';
		if($denetciMi || $isSektorSorumlusu){
			echo '<td align="center"><input type="button" value="Sil" onclick="deleteUy('.$uygunsuzluk['UYGUNSUZLUK_ID'].')"/></td>';
		}
	
	echo '</tr>';
}
?>




</tbody>
</table>





</div>
<script>
var settings = {
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
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
jQuery('#uygunsuzlukTable').dataTable(settings);

function deleteUy(uyId){
	if(confirm('Uygunsuzluğu silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			type:"POST",
			url:"index.php?option=com_denetim&task=uygunsuzlukSil&format=raw",
			data:"uyId="+uyId,
			success:function(data){
				window.location.reload();
			}
		});
	}
}
</script>
