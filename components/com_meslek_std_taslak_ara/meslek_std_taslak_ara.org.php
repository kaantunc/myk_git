<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once("libraries/joomla/utilities/browser_detection.php");

require_once('libraries/form/captcha.php');

$isProtokol = JRequest::getVar("protokol") == "1";
$protokolStr = $isProtokol?"&protokol=1":"";

$baslik = "Meslek Standardı Taslakları";

if($isProtokol){
	$baslik = "Protokol Kapsamındaki Meslekler";
}

define('M_TASLAK_WHERE_STR', "MESLEK_STANDART_SUREC_DURUM_ID = ".GORUSE_GONDERILMIS_STANDART
. " AND BASVURU_SEKLI_ID = ".KAYDEDILMIS_BASVURU_SEKLI_ID);

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

?>
<div class="sinavGirisBaslik"><?php echo $baslik;?></div>
<?php

$gorev = isset($_POST['gorev']) ? $_POST['gorev'] : "goster";

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';

if($gorev == "goster"){
	formGoster($itemIdStr, $protokolStr);
}
else if($gorev == "hepsi"){
	captcha::check("index.php?option=com_meslek_std_taslak_ara&gorev=goster$protokolStr&Itemid=$itemId");
	hepsiIleListele($itemIdStrOrj, $isProtokol, $protokolStr);
}

function formGoster($itemIdStr, $protokolStr){
	$db = & JFactory::getOracleDBO();
	?>
<form
	action="index.php?option=com_meslek_std_taslak_ara<?php echo $protokolStr?><?php echo $itemIdStr?>"
	method="post"><input type="hidden" value="hepsi" name="gorev" />
<table>
	<tr>
		<td width="200">Sektöre göre ara</td>
		<td width="130"><?php echo sektorleriGoster($db)?></td>
	</tr>
	<tr>
		<td width="200">Standart adına göre ara</td>
		<td width="130"><input type="text" name="standart_adi" /></td>
	</tr>
	<tr>
		<td width="200">Seviyeye göre ara</td>
		<td width="130"><?php echo seviyeleriGoster($db)?></td>
	</tr>
	<tr>
		<td width="200">İçerdigi görevlere göre ara</td>
		<td width="130"><input type="text" name="gorev_adi" /></td>
	</tr>
	<tr>
		<td width="200">Oluşturan Kuruluşa göre ara</td>
		<td width="130"><input type="text" name="olusturan" /></td>
	</tr>
	<tr>
		<td width="200"><?php echo JText::_("CAPTCHA_INFO");?></td>
		<td width="130"><img
			src="index.php?option=com_egbcaptcha&width=150&height=50&characters=5" />
		<div class="captchaInfo"><?php echo JText::_("CAPTCHA_PIC_INFO");?></div>
		<input id="verify_code" name="verify_code" type="text" /></td>
	</tr>
</table>
<input type="submit" value="Ara" /></form>
	<?php

}

function hepsiIleListele($itemIdStrOrj, $isProtokol, $protokolStr){
	$db = & JFactory::getOracleDBO();

	$standart_adi = JRequest::getVar('standart_adi');
	$sektor_id = JRequest::getVar('sektor_id');
	$seviye_id = JRequest::getVar('seviye_id');
	$gorev_adi = JRequest::getVar('gorev_adi');
	$olusturan = JRequest::getVar('olusturan');


	$sonuclar = hepsiIleAra($db, $standart_adi, $sektor_id, $seviye_id, $gorev_adi
			, $olusturan, $isProtokol, $protokolStr);


	listele($sonuclar, $itemIdStrOrj, $isProtokol, $protokolStr);
}

function listele($sonuclar, $itemIdStrOrj, $isProtokol, $protokolStr){
	//$standartAdi = $_POST['standart_adi'];// POST OLACAK

	//echo $standartAdi;
	//echo '<pre>';
	//print_r($sonuclar);
	//echo '</pre>';

	if(empty($sonuclar)){

		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';

	}
	else{
		?>
<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-numeric">Standart Id</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Standart Adi</th>
		<th class="sortable-text">Kurulus Adi</th>
		<?php
		if (isset ($sonuclar[0]['PROFIL_GOREV_ADI']))
		echo '<th class="sortable-text">Içerdigi Görev</th>';
		?>
		<?php if(!$isProtokol){?>
		<th class="sortable-text">Görüs Bildir</th>
		<th>PDF</th>
		<?php }?>
	</tr>

	<?php
	$user_browser = browser_detection('browser');
	$rowCount=1;
	$rowClass="";
	foreach($sonuclar AS $satir){
		if($rowCount%2==0)
		$rowClass = "even_row";
		else
		$rowClass = "odd_row";
			
		if (strripos($user_browser, 'msie') !== FALSE) {
			$clickHTML = 'target="_blank" href="index.php?option=com_meslek_std_taslak&amp;task=indir&amp;id=1&amp;standart_id='.$satir['STANDART_ID'].'"';
		} else {
			$clickHTML = 'onclick="window.open(\'index.php?option=com_meslek_std_taslak&amp;task=indir&amp;id=1&amp;standart_id='.$satir['STANDART_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
		}

		echo '<tr class="'.$rowClass.'">';
		echo '<td>'.$rowCount.'</td>';
		echo '<td>'.$satir['STANDART_ID'].'</td>';
		echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
		echo '<td>'.FormFactory::toUpperCase($satir['STANDART_ADI']).'</td>';
		echo '<td>'.FormFactory::toUpperCase($satir['KURULUS_ADI']).'</td>';
		if (isset ($satir['PROFIL_GOREV_ADI']))
		echo '<td>'.$satir['PROFIL_GOREV_ADI'].'</td>';
		if(!$isProtokol) echo '<td><a href="index.php?option=com_meslek_std_taslak&amp;view=gorus_bildir&amp;standartId='.$satir['STANDART_ID'].'">Görüs Bildir</a></td>';
		if(!$isProtokol) echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /></a></td>';

		echo '</tr>';
		$rowCount++;
	}

	?>

</table>
</div>
	<?php
	}
	?>
<br />
<a
	href="index.php?option=com_meslek_std_taslak_ara<?php echo $protokolStr?><?php echo $itemIdStrOrj?>">Geri</a>
	<?php
}

function  hepsiIleAra($db, $standart_adi, $sektor_id, $seviye_id, $gorev_adi, $olusturan, $isProtokol){

	$stdAdiStr = $standart_adi ? 'TURKCE_UPPER(STANDART_ADI) LIKE TURKCE_UPPER(?)' : '';
	$olusturanStr = $olusturan ? 'TURKCE_UPPER(KURULUS_ADI) LIKE TURKCE_UPPER(?)' : '';
	$gorevStr = $gorev_adi ? 'TURKCE_UPPER(PROFIL_GOREV_ADI) LIKE TURKCE_UPPER(?)' : '';
	$sektorIdStr = $sektor_id != 'Seçiniz' ? 'SEKTOR_ID = ?' : '';
	$seviyeIdStr = $seviye_id != 'Seçiniz' ? 'SEVIYE_ID = ?' : '';

	if($isProtokol){
		$sql = "SELECT
					STANDART_ID,
					SEVIYE_ADI,
					STANDART_ADI,
					KURULUS_ADI,
					EVRAK_ID 
			FROM M_MESLEK_STANDARTLARI
			JOIN PM_MESLEK_STANDART_DURUM USING (MESLEK_STANDART_SUREC_DURUM_ID)
			JOIN PM_SEVIYE USING (SEVIYE_ID) 
      		JOIN M_MESLEK_STAN_EVRAK USING(STANDART_ID)
			LEFT JOIN ".DB_PREFIX.".EVRAK USING (EVRAK_ID) 
			JOIN M_KURULUS USING (USER_ID) 
		WHERE ( STANDART_ID NOT IN (SELECT STANDART_ID FROM M_TASLAK_MESLEK)
          AND M_KURULUS.MS_LISTE_ONAY = 1 
          AND MESLEK_STANDART_SUREC_DURUM_ID != -3)	
		".($stdAdiStr ? ("AND ". $stdAdiStr) : '')."
		".($sektorIdStr ? ("AND ". $sektorIdStr) : '')."
		".($gorevStr ? ("AND ". $gorevStr) : '')." 
		".($olusturanStr ? ("AND ". $olusturanStr) : '')."
		".($seviyeIdStr ? ("AND ". $seviyeIdStr) : '')."
		 ORDER BY STANDART_ADI";

	}
	else{
		$sql = "SELECT 	" .
		(($gorevStr) ?
					"PROFIL_GOREV_ADI," : "")."  
					STANDART_ID,
					SEVIYE_ADI,
					STANDART_ADI,
					KURULUS_ADI,
					EVRAK_ID 
			FROM M_TASLAK_MESLEK
			JOIN M_MESLEK_STANDARTLARI USING (STANDART_ID)
			JOIN PM_MESLEK_STANDART_DURUM USING (MESLEK_STANDART_SUREC_DURUM_ID)
			JOIN PM_SEVIYE USING (SEVIYE_ID) 
			LEFT JOIN ".DB_PREFIX.".EVRAK USING (EVRAK_ID) 
			JOIN M_KURULUS USING (USER_ID) 
			" .
		(($gorevStr) ?
			"JOIN M_TASLAK_MESLEK_PROFIL USING (TASLAK_MESLEK_ID) " : "").	
			" 
		WHERE ".M_TASLAK_WHERE_STR." 	
		".($stdAdiStr ? ("AND ". $stdAdiStr) : '')."
		".($sektorIdStr ? ("AND ". $sektorIdStr) : '')."
		".($gorevStr ? ("AND ". $gorevStr) : '')." 
		".($olusturanStr ? ("AND ". $olusturanStr) : '')."
		".($seviyeIdStr ? ("AND ". $seviyeIdStr) : '')."
		 ORDER BY STANDART_ADI";
	}

//	jimport('joomla.error.log');
//	$log = &JLog::getInstance();
//	$log->addEntry(array('LEVEL' => '1','STATUS' => 'SOME ERROR:','COMMENT' =>$sql));
	
	$params = array();

	if($stdAdiStr != '')
	$params[] = "%".$standart_adi."%";
	if($sektorIdStr != '')
	$params[] = $sektor_id;
	if($gorevStr != '')
	$params[] = "%".$gorev_adi."%";
	if($olusturan != '')
	$params[] = "%".$olusturan."%";
	if($seviyeIdStr != '')
	$params[] = $seviye_id;

	$results = $db->prep_exec($sql, $params);
	
	//$log->addEntry(array('LEVEL' => '1','STATUS' => 'SOME ERROR:','COMMENT' =>print_r($results,true)));
	
	if($db->isError())
	{
		$log->addEntry(array('LEVEL' => '1','STATUS' => 'SOME ERROR:','COMMENT' =>print_r($db->getErrorInfo(),true)));
		JError::raiseWarning( 500, "Bir hata Oluştu, hata Kodu: " . $db->getErrorCode() );
	}
	
	return $results;

}

//function sektorleriAl($db){
//
//	$sql = "SELECT *
//			FROM PM_SEKTORLER ORDER BY SEKTOR_ADI ASC";
//
//	return $db->prep_exec($sql, array());
//}

function sektorleriGoster($db){

	$sektorler = FormParametrik::getSektor();
	?>

<select name="sektor_id">
	<option selected="selected" value="Seçiniz">Seçiniz</option>
	<?php
	foreach($sektorler AS $sektor)
	echo '<option value="'.$sektor['SEKTOR_ID'].'">'.$sektor['SEKTOR_ADI'].'</option>';
	?>
</select>
	<?php
}

function seviyeleriAl($db){

	$sql = "SELECT *
		FROM PM_SEVIYE ORDER BY SEVIYE_ADI ASC";

	return $db->prep_exec($sql, array());
}

function seviyeleriGoster($db){

	$seviyeler = seviyeleriAl($db);
	?>

<select name="seviye_id">
	<option selected="selected" value="Seçiniz">Seçiniz</option>
	<?php
	foreach($seviyeler AS $seviye)
	echo '<option value="'.$seviye['SEVIYE_ID'].'">'.$seviye['SEVIYE_ADI'].'</option>';
	?>
</select>
	<?php
}

?>