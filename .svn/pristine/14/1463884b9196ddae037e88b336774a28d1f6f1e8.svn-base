<?php 

$model = $this->getModel();
$donemler = $model->getTarifeDonemleri();

$user = & JFactory::getUser();
$userId = $user->getOracleUserId();

$adminMi = FormFactory::checkAclGroupId ($user->id, YONETICI_GROUP_ID);
?>

<form id="tarifeDonemiForm" action="index.php?option=com_finans&task=tarifeDonemiKaydet" method="POST">


<h4 style="padding-bottom:10px;">Tarife Dönemleri (Detayları Görmek İçin Üzerine Tıklayınız)</h4>

<?php 
if($adminMi==true)
	echo '<input type="button" value="YENİ" onclick="window.location=\'index.php?option=com_finans&layout=tarife_donemi\';">';
?>
	<table style="width:100%; float:left;" id="tarifeDonemleriTable">
		<thead>
			<tr>
				<th>DÖNEM BAŞLANGICI</th>
				<th>DÖNEM BİTİŞİ</th>
				<th>BELGE MASRAFI</th>
				<th>YETKİLENDIRME BAŞVURU MASRAFI</th>
				<th>DENETİM BEDELİ (Adam/Gün)</th>
			</tr>
		</thead>
		<tbody>
<?php 
			for($i=0; $i<count($donemler); $i++)
			{
				echo '<tr id="'.$donemler[$i]['TARIFE_DONEMI_ID'].'">';
				echo 	'<td>'.$donemler[$i]['TARIFE_BASLANGICI'].'</td>';
				echo 	'<td>'.$donemler[$i]['TARIFE_BITISI'].'</td>';
				echo 	'<td>'.$donemler[$i]['BELGE_MASRAFI'].'</td>';
				echo 	'<td>'.$donemler[$i]['YETKILENDIRME_BASVURU_MASRAFI'].'</td>';
				echo 	'<td>'.$donemler[$i]['DENETIM_BEDELI_ADAM_UCRET'].'</td>';
				echo '</tr>';
			}
?>
		</tbody>
	</table>


</form>

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


var oTableKurulus1 = jQuery('#tarifeDonemleriTable').dataTable(settings);

jQuery('#tarifeDonemleriTable *').click(function(e){
	var element = jQuery(this);
	while(jQuery(element)[0].tagName != 'TR')
		element = jQuery(element).parent();
	window.location = 'index.php?option=com_finans&layout=tarife_donemi&donem_id='+jQuery(element).attr('id');
});
</script>