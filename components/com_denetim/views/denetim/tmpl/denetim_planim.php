<?php

$seciliDenetim = $this->seciliDenetim;
$seciliDenetiminDenetimEkibi = $this->seciliDenetiminDenetimEkibi;

if( $this->seciliDenetim != null)
{
	$seciliDenetim = $this->seciliDenetim;
	$denetim_id = $_REQUEST['denetim_id'];
}
else
{
	global $mainframe;
	$mainframe->redirect('index.php?option=com_denetim&layout=denetim_listele', "Böyle bir denetim kayitli değil");
}

$uzmanDis = $this->uzmanDis;

$pm_roller = $this->ekipRolleri;
for($i=0; $i<count($pm_roller); $i++)
	$rollerOption .= '<option value="'.$pm_roller[$i]['ROL_ID'].'">'.$pm_roller[$i]['ROL_ADI'].'</option>';

?>

   <script src="includes/js/smartspinner/smartspinner.js" type="text/javascript"></script>
    <link href="includes/js/smartspinner/smartspinner.css" type="text/css" rel="stylesheet"/>
 <style>
table thead tr td
{
font-weight: bold;
}
 </style>   
   
<form method="POST" id="ekipKaydetmeFormu"
	action="index.php?option=com_denetim&task=ekip_kaydet&denetim_id=<?php echo $denetim_id; ?>">
	<br> 
	
	<h4>Denetim Başlangıç Tarihi: <?php echo $seciliDenetim['DENETIM_TARIHI_BASLANGIC']; ?></h4>
	<h4>Denetim Bitiş Tarihi: <?php echo $seciliDenetim['DENETIM_TARIHI_BITIS']; ?></h4>
	<h4>Denetim Suresi: <?php echo $seciliDenetim['DENETIM_SURESI']; ?> </h4>
	<h4>Denetim Gündemi: </h4>
	<?php echo nl2br($seciliDenetim['DENETIM_GUNDEMI']); ?>
	<h4>Denetim
	Ücreti: <?php echo $seciliDenetim['DENETIM_UCRETI']; ?></h4> 
	<h4>Denetim Ekibi:</h4>

	<div id="kayitliUzmanlarDiv">
		<table style="width:100%; float:left;" id="kayitliUzmanlarTable">
			<thead>
				<tr><td style="display:none;">#</td><td>AD</td><td>SOYAD</td><td>KURUM</td>
													<td>ÜNVAN</td><td>ROLÜ</td><td>ÇALIŞMA BAŞLANGIÇ TARİHİ</td><td>ÇALIŞACAĞI GÜN SAYISI</td></tr>
			</thead>
			<tbody>
				
				<?php 
				$uzmanlar = $this->seciliDenetiminDenetimEkibi;
				for($i=0; $i<count($uzmanlar); $i++)
				{
					echo '<tr id="'.$uzmanlar[$i]['CALISMA_SURESI_ID'].'">';
					echo '<td style="display:none;"><input type="checkbox" class="kayitliUzmanlarCheckbox" value="'.$uzmanlar[$i]['USER_ID'].'"/></td>';
					echo '<td>'.$uzmanlar[$i]['AD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['SOYAD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM_UNVANI'].'</td>';
					echo '<td>'.$uzmanlar[$i]['PERSONEL_ROLU'].'</td>';
					echo '<td>'.$uzmanlar[$i]['BASLANGIC_TARIHI'].'</td>';
					echo '<td>'.((substr($uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI'], 0, 1)==',') ? '0'.$uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI'] : $uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI'] ).'</td>';
					echo '</tr>';
				}

				?>
				
			</tbody>
		</table>
	</div>
<br><br><br><br><br><br>
<div id="KayitliDis">
<h4>Uzman Dışındaki Ekip: </h4>

	<table id="uzmanDis" style="float:left">
		<thead>
			<tr style="text-align:center">
				<td width='10%'>AD</td>
				<td width='15%'>SOYAD</td>
				<td width='20%'>KURUM</td>
				<td width='10%'>ÜNVAN</td>
				<td width='10%'>ROLÜ</td>
				<td width='10%'>ÇALIŞMA BAŞLANGIÇ TARİHİ</td>
				<td width='5%'>ÇALIŞACAĞI GÜN SAYISI</td>
			</tr>
		</thead>
		<tbody id="Distbody">
		<?php if(count($uzmanDis)>0){
			foreach ($uzmanDis as $cow){
				echo '<tr id="'.$cow['ID'].'" class="odd" style="text-align:center">
						<td>'.$cow['AD'].'</td>
						<td>'.$cow['SOYAD'].'</td>
						<td>'.$cow['KURUM'].'</td>
						<td>'.$cow['UNVAN'].'</td>
						<td>'.$cow['ROL_ADI'].'</td>
						<td>'.$cow['BAS_TARIH'].'</td>
						<td>'.$cow['GUN'].'</td>
					</tr>';
			}
		}?>
		</tbody>
	</table>	
</div>
	<br><br>


	<font id="errorDiv" color="red" style="display:none; width:100%; float:left;">Lütfen Gerekli Alanları Doldurunuz</font>

</form>

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
				
jQuery('#kayitliUzmanlarTable').dataTable(settings);
jQuery('#uzmanDis').dataTable(settings);


<?php 

$uzmanlar2 = $this->seciliDenetiminDenetimEkibi;
for($i=0; $i<count($uzmanlar2); $i++)
{
	echo ' ekipRoluSelectiniSec('.$i.', '.$uzmanlar2[$i]['PERSONEL_ROLU'].'); ';	
}

?>

</script>
