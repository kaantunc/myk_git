<?php 

$model = $this->getModel();

$user = & JFactory::getUser();
$userId = $user->getOracleUserId();

$denetciMi = FormFactory::buIDDenetciMi($userId);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);

?>


<table id="dekontlarTable" style="width:100%; float:left;">
	<thead>
		<tr>
		
		<th>Kuruluş adı</th>
		<th>Dekont Nüshası</th>
		<th>Dekont No</th>
		<th>Masraf Nedeni</th>
		<th>Masraf Tutarı</th>
		<th>Masraf Tarihi</th>
		<th>Yetki Durumu</th>
		<th>Yetkilendirilme Tarihi</th>

		</tr>
	</thead>


	<tbody>

<?php 

	

if($isSektorSorumlusu==true)
	$dekontlar = $model->getDekontlar();
else 
	$dekontlar = $model->getDekontlar($userId);
	
$belgeMasrafDekontlari = $dekontlar['BELGE_MASRAF'];
$denetimDekontlari = $dekontlar['DENETIM'];
$yillikAidatDekontlari = $dekontlar['YILLIK_AIDAT'];

for($i=0; $i<count($belgeMasrafDekontlari); $i++)
{
	echo '<tr>
		<td>'.$belgeMasrafDekontlari[$i]['KURULUS_ADI'].'</td>
		<td>';
	
	if($belgeMasrafDekontlari[$i]['DEKONT_PATH']!='')
		echo '<div style="text-align:center;"><a href="index.php?dl=dekontNushalari/'.$belgeMasrafDekontlari[$i]['DEKONT_ID'].'/'.$belgeMasrafDekontlari[$i]['DEKONT_PATH'].'"><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /><br>PDF</a></div>';
	
	echo'</td>
		<td>'.$belgeMasrafDekontlari[$i]['DEKONT_NO'].'</td>
		<td>Belge Masraf Karşılığı</td>
		<td>'.$belgeMasrafDekontlari[$i]['DEKONT_UCRETI'].'</td>
		<td>'.$belgeMasrafDekontlari[$i]['DEKONT_TARIHI'].'</td>
		<td>'.$model->getYetkiDurumuByKurulusID($belgeMasrafDekontlari[$i]['USER_ID']).'</td>
		<td>'.$model->getYetkilendirmeTarihiByKurulusID($belgeMasrafDekontlari[$i]['USER_ID']).'</td>
		</tr>';
}
	
for($i=0; $i<count($denetimDekontlari); $i++)
{
	echo '<tr>
	<td>'.$denetimDekontlari[$i]['KURULUS_ADI'].'</td>
	<td>';
	
	if($denetimDekontlari[$i]['DEKONT_PATH']!='')
		echo '<div style="text-align:center;"><a href="index.php?dl=dekontNushalari/'.$denetimDekontlari[$i]['DEKONT_ID'].'/'.$denetimDekontlari[$i]['DEKONT_PATH'].'"><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /><br>PDF</a></div>';
	
	echo'</td>
	<td>'.$denetimDekontlari[$i]['DEKONT_NO'].'</td>
	<td>Denetim Ücreti</td>
	<td>'.$denetimDekontlari[$i]['DEKONT_UCRETI'].'</td>
	<td>'.$denetimDekontlari[$i]['DEKONT_TARIHI'].'</td>
	<td>'.$model->getYetkiDurumuByKurulusID($denetimDekontlari[$i]['USER_ID']).'</td>
	<td>'.$model->getYetkilendirmeTarihiByKurulusID($denetimDekontlari[$i]['USER_ID']).'</td>
	</tr>';
	
}

for($i=0; $i<count($yillikAidatDekontlari); $i++)
{
	echo '	<tr>
	<td>'.$yillikAidatDekontlari[$i]['KURULUS_ADI'].'</td>
	<td>';
	
	if($yillikAidatDekontlari[$i]['DEKONT_PATH']!='')
		echo '<div style="text-align:center;"><a href="index.php?dl=dekontNushalari/'.$yillikAidatDekontlari[$i]['DEKONT_ID'].'/'.$yillikAidatDekontlari[$i]['DEKONT_PATH'].'"><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /><br>PDF</a></div>';
	
	echo'</td>
	<td>'.$yillikAidatDekontlari[$i]['DEKONT_NO'].'</td>
	<td>Yıllık Aidat</td>
	<td>'.$yillikAidatDekontlari[$i]['DEKONT_UCRETI'].'</td>
	<td>'.$yillikAidatDekontlari[$i]['DEKONT_TARIHI'].'</td>
	<td>'.$model->getYetkiDurumuByKurulusID($yillikAidatDekontlari[$i]['USER_ID']).'</td>
	<td>'.$model->getYetkilendirmeTarihiByKurulusID($yillikAidatDekontlari[$i]['USER_ID']).'</td>
	</tr>';
}



?>


	</tbody>


</table>


<script>
var settings = {
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"bSort":true,
		"aaSorting": [[4,'desc']],
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
				
jQuery('#dekontlarTable').dataTable(settings);

</script>