<?php 

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');

require_once('libraries'.DS.'form'.DS.'form.php');


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );



$user 	 	= &JFactory::getUser();
$user_id	= $user->getOracleUserId ();
$aut 		= FormFactory::checkAuthorization  ($user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
echo '<h2><u>Meslek Standardı Listesi</u></h2><br>';
if (!$aut)
	$mainframe->redirect('index.php?', "Bu sayfayı görüntüleme yetkiniz yok");

$liste = getList();

echo '<table id="liste" border="1" cellspacing="0" cellpadding="50">
<thead>
	<tr>
		<th class="sortable-numeric" align="center">Sıra No</th>
		<th class="sortable-numeric">Standart ID</th>
		<th class="sortable-text">Standart Adı</th>
		<th class="sortable-text" style="width:65px;">Seviye</th>
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
		if($field==$row['STANDART_ID'])
			$standart_id=$field;
		
		if($field==$row['STANDART_ADI'])
			$fieldValue = FormFactory::toUpperCase($field);	
		else
			$fieldValue = $field;
		 
		echo '<td style="padding-left:5px; padding-right:3px;">'.$fieldValue.'</td>';
	}
	
	$taslakUrl = generatePDFPathForStandart($standart_id);
	
	if (strripos($user_browser, 'msie') !== FALSE) {
		$clickHTML = 'target="_blank" href="'.$taslakUrl.'"';
	} else {
		$clickHTML = 'onclick="window.open(\''.$taslakUrl.'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
	}
	
	echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /></a></td>';
		
	echo '</tr>';
	
	$index++;
}
echo '</tbody></table>';


function generatePDFPathForStandart($standart_id)
{
	$_db = &JFactory::getOracleDBO();

	$sql= "SELECT *
	FROM m_standart_revizyon
	WHERE standart_id = ? AND REVIZYON_DURUMU=14 ORDER BY REVIZYON_NO DESC";
	$params = array ($standart_id);
	$data = $_db->prep_exec($sql, $params);

	if(count($data)>0)
	{
		if($data[0]['SON_TASLAK_PDF']!='')//yani en ustteki revizyon
			// YOKSA PDF ÜRET
			$taslakUrl = "index.php?option=com_meslek_std_taslak&amp;layout=pdf&amp;format=pdf&amp;form=5&amp;id=".getTaslakStandartEvrakId($_db, $standart_id)."&amp;standart_id=".$standart_id;
		else
			$taslakUrl= 'index.php?dl='.$data[0]['SON_TASLAK_PDF'];
	}
	else
	{
		$sql= "SELECT *
		FROM m_taslak_meslek
		WHERE standart_id = ?";
		$params = array ($standart_id);
		$data = $_db->prep_exec($sql, $params);

		if(count($data)>0 && $data[0]['SON_TASLAK_PDF']!='')
			$taslakUrl = 'index.php?dl='.$data[0]['SON_TASLAK_PDF'];
		else
			$taslakUrl = "index.php?option=com_meslek_std_taslak&amp;layout=pdf&amp;format=pdf&amp;form=5&amp;id=".getTaslakStandartEvrakId($_db, $standart_id)."&amp;standart_id=".$standart_id;
	}

	return $taslakUrl;
}

function getTaslakStandartEvrakId($db, $standart_id){
	$sql = "SELECT EVRAK_ID
	FROM M_TASLAK_MESLEK
	WHERE STANDART_ID = ?";

	$data = $db->prep_exec_array($sql, array($standart_id));
	if (isset ($data[0]))
		return $data[0];
	else
		return -1;
}

function getList()
{
	
	$db = & JFactory::getOracleDBO();
    
    $sql = "SELECT standart_id, standart_adi, 'Seviye '||seviye_id, sektor_adi, kurulus_adi, meslek_standart_durum_adi, standart_surec_durum_adi
	FROM M_MESLEK_STANDARTLARI
	JOIN m_yetki_standart USING (STANDART_ID)
	JOIN m_kurulus_yetki USING (YETKI_ID)
	JOIN pm_sektorler USING (SEKTOR_ID)
	JOIN M_kurulus USING (USER_ID)
	JOIN pm_meslek_standart_durum USING (meslek_standart_durum_id)
	JOIN pm_meslek_standart_surec_durum USING (meslek_standart_surec_durum_id)
	WHERE KURULUS_TURU = 1 AND  NOT MESLEK_STANDART_SUREC_DURUM_ID = -3
    ORDER BY standart_adi";
	
    $array = $db->prep_exec($sql, array());
    
   return $array;
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