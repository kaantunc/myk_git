<?php 

$user = & JFactory::getUser();
$userId = $user->getOracleUserId();
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);


function kurulusIDdenUcretTarifesiGetir($kurulus_id)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT * FROM M_UCRET_TARIFESI
	WHERE USER_ID = ?";

	$result = $db->prep_exec($sql, array($kurulus_id));
	
	if(count($result)==0)
	{
		$ucretTarifesiID = $db->getNextVal('UCRET_TARIFESI_SEQ');
		$sql = "INSERT INTO M_UCRET_TARIFESI (USER_ID, UCRET_TARIFESI_ID)
		VALUES (?,?)";
		
		$result = $db->prep_exec_insert($sql, array($kurulus_id, $ucretTarifesiID));
		
		$sql = "SELECT * FROM M_UCRET_TARIFESI
		WHERE UCRET_TARIFESI_ID = ?";
		
		$result = $db->prep_exec($sql, array($ucretTarifesiID));
	}
	return $result[0];
}


function getUcretTarifesiUcretleri($ucret_tarifesi_id)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT * FROM M_UCRET_TARIFESI_UCRETLERI
	WHERE UCRET_TARIFESI_ID=?";

	$result = $db->prep_exec($sql, array($ucret_tarifesi_id));
	return $result;
}


?>
<style>
#belgelendirmeUcretleriTablosu thead tr td
{
	font-weight: bold;	
	border-bottom: 1px solid black;
	
}
#belgelendirmeUcretleriTablosu td
{
	padding-right:20px;
	padding-left:20px;
}


</style>
<?php 
$denetim = $this->denetim;
$kurulus_id = $_GET['kurulus_id'];
$ucretTarifesi = kurulusIDdenUcretTarifesiGetir($kurulus_id);
$ucretTarifesiUcretleri = getUcretTarifesiUcretleri($ucretTarifesi['UCRET_TARIFESI_ID']);
?>
<form method="post" action="index.php?option=com_denetim&task=ucretTarifesiKaydet&kurulus_id=<?php echo $_GET['kurulus_id']; ?>&ucret_tarifesi_id=<?php echo $ucretTarifesi['UCRET_TARIFESI_ID']; ?>" >

<input type="hidden" id="silinecekBelgelendirmeProgramlari" name="silinecekBelgelendirmeProgramlari[]" value="">


<table id="belgelendirmeUcretleriTablosu" style="width:100%;" >
<thead>
	<tr>
		<td>BELGELENDİRME PROGRAMI</td>
		<td style="width:100px;">ÜCRET</td>
		<td style="width:100px;">İNDİRİMLİ ÜCRET</td>
<?php 	
		if($denetlemesiYapilacakKurulusMu || $isSektorSorumlusu)
			echo '<td>SİL</td>';
		
?>		</tr>
</thead>

<tbody>
<?php 
echo '<h4>BELGELENDIRME PROGRAMI ÜCRETLERİ</h4>';
for ($i=0; $i<count($ucretTarifesiUcretleri); $i++)
{	
	echo '<tr id="'.$ucretTarifesiUcretleri[$i]['UCRET_ID'].'"><td>'.$ucretTarifesiUcretleri[$i]['BELGELENDIRME_PROGRAMI_ACKLM'].'</td>
			  <td style="width:100px;">'.$ucretTarifesiUcretleri[$i]['UCRET'].'</td>
			  <td style="width:100px;">'.$ucretTarifesiUcretleri[$i]['INDIRIMLI_UCRET'].'</td>
			  ';
	
	if($denetlemesiYapilacakKurulusMu || $isSektorSorumlusu)
		echo '<td><input type="button" value="SİL" onclick="deleteUcretRow('.$ucretTarifesiUcretleri[$i]['UCRET_ID'].')" ></td>';
	
	
	echo  '</tr>';
}
echo '</tbody></table>';

if($denetlemesiYapilacakKurulusMu || $isSektorSorumlusu)
	echo '<input type="button" value="Yeni Ekle" id="yeniUcretEkleButton" >';


echo '<br><br>';

echo '<h4>GENEL KURAL VE ŞARTLAR</h4>';
echo '<textarea style="width:100%; height:100px;" name="genelKuralveSartlarTextArea">'.$ucretTarifesi['GENEL_KURAL_SARTLAR'].'</textarea>';
echo '<br><br>';
echo '<h4>INDIRIMLER</h4>';
echo '<textarea style="width:100%; height:100px;" name="ucretTarifesiTextArea">'.$ucretTarifesi['INDIRIMLER'].'</textarea>';

if($denetlemesiYapilacakKurulusMu || $isSektorSorumlusu)
	echo '<input type="submit" value="KAYDET">';

?>





</form>
<script>
var settings = {
 		"bPaginate": false,
 		"bFilter": false,
 		"bInfo": false,
 		"bSort": false,
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

						
var oTableUcretler = jQuery('#belgelendirmeUcretleriTablosu').dataTable(settings);

jQuery('#yeniUcretEkleButton').click(function(e){
	oTableUcretler.fnAddData(['<input style="width:100%;" type="text" name="programAciklamasi[]">',
	                      	  '<input style="width:100px;" type="text" name="programUcreti[]">', 
	                      	  '<input style="width:100px;" type="text" name="indirimliUcret[]">',
	                      	  '<input type="button" value="SİL" onclick="deleteUcretRow(this);" >' 
	                      	  ]);
});

function deleteUcretRow(ucretID)
{
	if(isNaN(ucretID))
	{
		oTableUcretler.fnDeleteRow(jQuery(ucretID.getParent().getParent())[0]);
		oTableUcretler.fnDraw();
	}
	else
	{
		jQuery('#silinecekBelgelendirmeProgramlari').val(ucretID + '-' + jQuery('#silinecekBelgelendirmeProgramlari').val());
		oTableUcretler.fnDeleteRow(jQuery('#belgelendirmeUcretleriTablosu #'+ucretID)[0]);
		oTableUcretler.fnDraw();
	}
}
</script>