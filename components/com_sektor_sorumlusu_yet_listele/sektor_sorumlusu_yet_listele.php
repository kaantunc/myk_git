<?php 
ini_set("display_errors", "1");
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries'.DS.'form'.DS.'form.php');


$document = &JFactory::getDocument();

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

$condition = "";
if(isset($_POST['yeterlilik_kodu']) && $_POST['yeterlilik_kodu'] <> ""){
	$condition.= " AND  M_YETERLILIK.YETERLILIK_KODU like '%".$_POST['yeterlilik_kodu']."%'";
	$yeterlilik_kodu = $_POST['yeterlilik_kodu'];
}
if(isset($_POST['yeterlilik_adi']) && $_POST['yeterlilik_adi'] <> ""){
	$condition.= " AND NLS_LOWER(M_YETERLILIK.YETERLILIK_ADI, 'NLS_SORT = xturkish') LIKE '%".FormFactory::toLowerCase(trim($_POST['yeterlilik_adi']))."%' ";
	$yeterlilik_adi = $_POST['yeterlilik_adi'];
}
if(isset($_POST['seviye_id']) && $_POST['seviye_id'] <> ""){
	$condition.= " AND  M_YETERLILIK.SEVIYE_ID = '".$_POST['seviye_id']."'";
	$seviye_id = $_POST['seviye_id'];
}
if(isset($_POST['sektor_id']) && $_POST['sektor_id'] <> ""){
	$condition.= " AND  SEKTOR_ID = '".$_POST['sektor_id']."'";
	$sektor_id = $_POST['sektor_id'];
}


$user 	 	= &JFactory::getUser();
$user_id	= $user->getOracleUserId ();
$aut 		= FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
echo '<h2><u>Ulusal Yeterlilik Listeleme</u></h2><br>';
if (!$aut)
	$mainframe->redirect('index.php?', "Bu sayfayı görüntüleme yetkiniz yok");

$db = & JFactory::getOracleDBO();

$sql = "SELECT yeterlilik_id, yeterlilik_adi, 'Seviye '||seviye_id,'Revizyon '||revizyon, sektor_adi, kurulus_adi,
yeterlilik_durum_adi,
yeterlilik_surec_durum_adi
	FROM M_YETERLILIK
	JOIN m_yetki_yeterlilik USING (YETERLILIK_ID)
	JOIN m_kurulus_yetki USING (YETKI_ID)
	JOIN pm_sektorler USING (SEKTOR_ID)
	JOIN M_kurulus USING (USER_ID)
	JOIN pm_yeterlilik_durum USING (yeterlilik_durum_id)
	JOIN pm_yeterlilik_surec_durum USING (yeterlilik_surec_durum_id)
	WHERE KURULUS_TURU = 1 AND  NOT YETERLILIK_SUREC_DURUM_ID = -3 ".$condition."
    ORDER BY yeterlilik_adi";

$liste = $db->prep_exec(mb_convert_encoding($sql, "ISO-8859-9","UTF8"), array());
?>
<style>
	table#searchcriters tr td {
		padding: 8px 0 0 8px;
	}
</style>
<form action="?option=com_sektor_sorumlusu_yet_listele" method="post">
	<table cellspacing="0" class="display compact"  width="100%" id="searchcriters">
		<tr>
			<td>Yeterlilik Kodu:</td>
			<td><input type="text" name="yeterlilik_kodu" value="<?php echo $yeterlilik_kodu;?>" /></td>
		</tr>
		<tr>
			<td>Yeterlilik Adı:</td>
			<td><input type="text" name="yeterlilik_adi" value="<?php echo $yeterlilik_adi;?>" /></td>
		</tr>
		<tr>
			<td>Seviye:</td>
			<td><?php echo seviyeleriGoster($db,$seviye_id)?></td>
		</tr>
		<tr>
			<td>Sektör:</td>
			<td><?php echo sektorleriGoster($db,$sektor_id)?></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Ara">
			</td>
		</tr>
	</table>
</form>
<br>
<?php echo '<table id="liste" border="1" cellspacing="0" cellpadding="50">
				<thead>
					<tr>
						<th class="sortable-numeric" align="center">Sıra No</th>
						<th class="sortable-numeric">Yeterlilik ID</th>
						<th class="sortable-text">Yeterlilik Adı</th>
						<th class="sortable-text" style="width:65px;">Seviye</th>
						<th class="sortable-text">Revizyon</th>
						<th class="sortable-text">Sektör</th>
						<th class="sortable-text">Yetki Verilen Kuruluş</th>
						<th class="sortable-text">Durumu</th>
						<th class="sortable-text">Süreç Durumu</th>
						<th>PDF</th>
					</tr>
				</thead>
				<tbody>';

$index = 1;
foreach($liste as $row)
{
	echo '<tr>';
	echo '<td align="center">'.$index.'</td>';
	foreach($row as $field)
	{
		if($field==$row['YETERLILIK_ID'])
			$yeterlilik_id=$field;
		
		if($field==$row['YETERLILIK_ADI'])
			$fieldValue = FormFactory::toUpperCase($field);
		else
			$fieldValue = $field;
		
		echo '<td style="padding-left:5px; padding-right:3px;">'.$field.'</td>';
	}
	
	$taslakUrl = generatePDFPathForYeterlilik($yeterlilik_id,$row['SON_TASLAK_PDF']);
	
	echo '<td><a href="'.$taslakUrl.'" rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /></a></td>';
		
	echo '</tr>';
	
	$index++;
}
echo '</tbody></table>';


function generatePDFPathForYeterlilik($yeterlilik_id,$taslak_pdf)
{
	$_db = &JFactory::getOracleDBO();

	$componentName = 'com_yeterlilik_taslak_yeni';

	if($taslak_pdf == ""){
		$sql= "SELECT * FROM m_taslak_yeterlilik WHERE yeterlilik_id = ?";
		$params = array ($yeterlilik_id);
		$data = $_db->prep_exec($sql, $params);
	
		if(count($data)>0 && $data[0]['SON_TASLAK_PDF']!='')
			$taslakUrl = 'index.php?dl='.$data[0]['SON_TASLAK_PDF'];
		else
			$taslakUrl = "index.php?option=".$componentName."&amp;layout=pdf&amp;format=pdf&amp;form=5&amp;id=".getTaslakYeterlilikEvrakId($_db, $yeterlilik_id)."&amp;yeterlilik_id=".$yeterlilik_id;
	}else{
		$taslakUrl = "index.php?option=com_yeterlilik_taslak_yeni&amp;view=taslak_revizyon&amp;task=indir&amp;id=4&amp;yeterlilik_id=".$yeterlilik_id;
	}
	return $taslakUrl;
}

function getTaslakYeterlilikEvrakId($db, $yeterlilik_id){
	$sql = "SELECT EVRAK_ID 
			FROM M_TASLAK_YETERLILIK 
			WHERE YETERLILIK_ID = ?";
	
	$data = $db->prep_exec_array($sql, array($yeterlilik_id)); 
	if (isset ($data[0]))
		return $data[0];
	else
		return -1;
}
    
function sektorleriGoster($db,$sektor_id = null){

	$sektorler = FormParametrik::getSektor();
	?>
	
	<select name="sektor_id">
		<option selected="selected" value="">Seçiniz</option>
		<?php 
		foreach($sektorler AS $sektor)
			echo '<option value="'.$sektor['SEKTOR_ID'].'" '.($sektor['SEKTOR_ID'] == $sektor_id ? 'selected=\"selected\"' : '').'>'.$sektor['SEKTOR_ADI'].'</option>';
		?>
	</select>
<?php
}

function seviyeleriGoster($db,$seviye_id = null){

	$sql = "SELECT * FROM PM_SEVIYE ORDER BY SEVIYE_ADI ASC";

	$seviyeler = $db->prep_exec($sql, array());
	?>
	
	<select name="seviye_id">
		<option selected="selected" value="">Seçiniz</option>
		<?php 
		foreach($seviyeler AS $seviye)
			echo '<option value="'.$seviye['SEVIYE_ID'].'" '.($seviye['SEVIYE_ID'] == $seviye_id ? 'selected=\"selected\"' : '').'>'.$seviye['SEVIYE_ADI'].'</option>';
		?>
	</select>
<?php
}
?>

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

var oTableKurulus = jQuery('#liste').dataTable(settings);
	
</script>