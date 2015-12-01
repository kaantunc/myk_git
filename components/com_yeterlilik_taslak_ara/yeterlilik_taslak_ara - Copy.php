<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once("libraries/joomla/utilities/browser_detection.php");

require_once('libraries/form/captcha.php');

define('M_TASLAK_WHERE_STR', "YETERLILIK_SUREC_DURUM_ID = ".GORUSE_GONDERILMIS_YETERLILIK  
		. " AND BASVURU_SEKLI_ID = ".KAYDEDILMIS_BASVURU_SEKLI_ID);

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

?>
<div class="sinavGirisBaslik">Yeterlilik Taslakları</div>
<?php

$gorev = isset($_POST['gorev']) ? $_POST['gorev'] : "goster";

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';

if($gorev == "goster"){
	formGoster($itemIdStr);
}
else if($gorev == "hepsi"){
	captcha::check("?option=com_yeterlilik_taslak_ara&gorev=goster&Itemid=$itemId");
	hepsiIleListele($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	<form action="?option=com_yeterlilik_taslak_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="hepsi" name="gorev" />
		<table>
			<tr>
				<td width="200">Sektöre göre ara</td>
				<td width="130"><?php echo sektorleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200">Yeterlilik adına göre ara</td>
				<td width="130"><input type="text" name="yeterlilik_adi" /></td>
			</tr>
			<tr>
				<td width="200">Seviyeye göre ara</td>
				<td width="130"><?php echo seviyeleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200">Oluşturan Kuruluşa göre ara</td>
				<td width="130"><input type="text" name="olusturan" /></td>
			</tr>
			<tr>
				<td width="200"><?php echo JText::_("CAPTCHA_INFO");?></td>
				<td width="130">
					<img src="index.php?option=com_egbcaptcha&width=150&height=50&characters=5" />
					<div class="captchaInfo"><?php echo JText::_("CAPTCHA_PIC_INFO");?></div>
					<input id="verify_code" name="verify_code" type="text" />
				</td>
			</tr>
			</table>
			<input type="submit" value="Ara" />
	</form>
	<?php
	
}

function hepsiIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	
	$yeterlilik_adi = JRequest::getVar('yeterlilik_adi');
	$sektor_id = JRequest::getVar('sektor_id');
	$seviye_id = JRequest::getVar('seviye_id');
	$olusturan = JRequest::getVar('olusturan');
	
	$sonuclar = hepsiIleAra($db, $yeterlilik_adi, $sektor_id, $seviye_id, $olusturan);
	
	listele($sonuclar, $itemIdStrOrj);
}

function listele($sonuclar, $itemIdStrOrj){
	
	if(empty($sonuclar)){
		
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		
	}
	else{
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-numeric">Yeterlilik Id</th>
				<th class="sortable-text">Seviye</th>
				<th class="sortable-text">Yeterlilik Adı</th>
				<th class="sortable-text">Kuruluş Adı</th>
				<th class="sortable-text">Görüş Bildir</th>
				<th>PDF</th>
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
						$clickHTML = 'target="_blank" href="index.php?option=com_yeterlilik_taslak&amp;task=indir&amp;id=1&amp;yeterlilik_id='.$satir['YETERLILIK_ID'].'"';
					} else {                     
						$clickHTML = 'onclick="window.open(\'index.php?option=com_yeterlilik_taslak&amp;task=indir&amp;id=1&amp;yeterlilik_id='.$satir['YETERLILIK_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
					}	
					
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.$satir['YETERLILIK_ID'].'</td>';
					echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
					echo '<td>'.FormFactory::toUpperCase($satir['YETERLILIK_ADI']).'</td>';
					echo '<td>'.FormFactory::toUpperCase($satir['KURULUS_ADI']).'</td>';
					echo '<td><a href="index.php?option=com_yeterlilik_taslak&amp;view=gorus_bildir&amp;yeterlilikId='.$satir['YETERLILIK_ID'].'">Görüs Bildir</a></td>';
					echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /></a></td>';
										
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
	<a href="index.php?option=com_yeterlilik_taslak_ara<?php echo $itemIdStrOrj?>">Geri</a>
	<?php
}

function  hepsiIleAra($db, $yeterlilik_adi, $sektor_id, $seviye_id, $olusturan){

	$yetAdiStr = $yeterlilik_adi ? 'TURKCE_UPPER(YETERLILIK_ADI) LIKE TURKCE_UPPER(?)' : '';  
	$olusturanStr = $olusturan ? 'TURKCE_UPPER(KURULUS_ADI) LIKE TURKCE_UPPER(?)' : ''; 		
	$sektorIdStr = $sektor_id != 'Seçiniz' ? 'SEKTOR_ID = ?' : ''; 
	$seviyeIdStr = $seviye_id != 'Seçiniz' ? 'SEVIYE_ID = ?' : ''; 
	
	// @todo * deme gerekenleri yaz
	$sql = "SELECT YETERLILIK_ID,
				   SEVIYE_ADI,
				   YETERLILIK_ADI,
				   KURULUS_ADI,
				   EVRAK_ID 
			FROM M_TASLAK_YETERLILIK 
			JOIN M_YETERLILIK USING (YETERLILIK_ID)
			JOIN PM_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_ID)
			JOIN PM_SEVIYE USING (SEVIYE_ID) 
			LEFT JOIN ".DB_PREFIX.".EVRAK USING (EVRAK_ID) 
			JOIN M_KURULUS USING (USER_ID) 
		WHERE ".M_TASLAK_WHERE_STR." 	
		".($yetAdiStr ? ("AND ". $yetAdiStr) : '')."
		".($sektorIdStr ? ("AND ". $sektorIdStr) : '')." 
		".($olusturanStr ? ("AND ". $olusturanStr) : '')."
		".($seviyeIdStr ? ("AND ". $seviyeIdStr) : '')."
		 ORDER BY YETERLILIK_ADI";

	$params = array();
	
	if($yetAdiStr != '')
		$params[] = "%".$yeterlilik_adi."%";
	if($sektorIdStr != '')
		$params[] = $sektor_id;
	if($olusturan != '')
		$params[] = "%".$olusturan."%";
	if($seviyeIdStr != '')
		$params[] = $seviye_id;
		
	return $db->prep_exec($sql, $params);
	
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