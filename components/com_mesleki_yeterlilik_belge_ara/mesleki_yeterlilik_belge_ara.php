<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once('libraries/form/captcha.php');
require_once("libraries/joomla/utilities/browser_detection.php");

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );

$document->addScript( SITE_URL.'/includes/js/jquery.blockUI.js');



?>
<div class="sinavGirisBaslik">Mesleki Yeterlilik Belgesi Sorgula</div>
<script>
function blockUI()
{
		jQuery.blockUI({ message: '<h1>Lütfen Bekleyin!</h1>',
			css: { 
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: '#000', 
	        '-webkit-border-radius': '10px', 
	        '-moz-border-radius': '10px', 
	        opacity: .5, 
	        color: '#fff' 
	    } }); 

}
</script>
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
	//echo '<script>blockUI();</script>';
	hepsiIleListele($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	<form  style="min-height: 300px;" action="index.php?option=com_mesleki_yeterlilik_belge_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="hepsi" name="gorev" />
		<table>
			<tr>
				<td width="200">TC Kimlik: </td>
				<td width="130"><input type="text" value="<?php echo $_POST['tc_kimlik'];?>" name="tc_kimlik" /></td>
			</tr>
			<tr>
				<td width="200">Ad: </td>
				<td width="130"><input type="text" name="ad" /></td>
			</tr>
			<tr>
				<td width="200">Soyad: </td>
				<td width="130"><input type="text" name="soyad" /></td>
			</tr>
			<tr>
				<td width="200">Belge No: </td>
				<td width="130"><input type="text" name="belgeno" /></td>
			</tr>
			<tr>
				<td width="200">Yeterlilik Ad: </td>
				<td width="130"><input type="text" name="yeterlilik_ad" /></td>
			</tr>
			<tr>
				<td width="200">Yeterlilik Seviye: </td>
				<td width="130"><input type="text" name="yeterlilik_seviye" /></td>
			</tr>
			<tr>
				<td width="200">Sınav Tarihi</td>
				<td width="130"><input type="text" name="sinav_tarih" /></td>
			</tr>
			<tr>
				<td width="200">Belge Düzenleme Tarihi</td>
				<td width="130"><input type="text" name="belge_duzenleme_tarih" /></td>
			</tr>
			<tr>
				<td width="200">Geçerlilik Tarihi</td>
				<td width="130"><input type="text" name="gecerlilik_tarih" /></td>
			</tr>
			<tr>
				<td width="200">Belgelendirme Kuruluşu</td>
				<td width="130"><input type="text" name="belgelendirme_kurulus" /></td>
			</tr>
			
			
		</table>
		<input  type="submit" onclick="blockUI(); return true;" value="&nbsp;Sorgula&nbsp;" />
	</form>
	<?php
	
}

function hepsiIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	
	$tc_kimlik = JRequest::getVar('tc_kimlik');
	$ad = JRequest::getVar('ad');
	$soyad = JRequest::getVar('soyad');
	$belgeno = JRequest::getVar('belgeno');
	$yeterlilik_ad = JRequest::getVar('yeterlilik_ad');
	$yeterlilik_seviye = JRequest::getVar('yeterlilik_seviye');
	$sinav_tarih = JRequest::getVar('sinav_tarih');
	$belge_duzenleme_tarih = JRequest::getVar('belge_duzenleme_tarih');
	$gecerlilik_tarih = JRequest::getVar('gecerlilik_tarih');
	$belgelendirme_kurulus = JRequest::getVar('belgelendirme_kurulus');
	
	$sonuclar = hepsiIleAra($db, $tc_kimlik, $ad,
			$soyad, $belgeno, $yeterlilik_ad, $yeterlilik_seviye, $sinav_tarih, $belge_duzenleme_tarih, $gecerlilik_tarih, $belgelendirme_kurulus);
	
	
	listele($sonuclar, $itemIdStrOrj);
}

function listele($sonuclar, $itemIdStrOrj){
	
	formGoster();
	
	$db = & JFactory::getOracleDBO();
	if(empty($sonuclar)){
		
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?option=com_mesleki_yeterlilik_belge_ara'. $itemIdStrOrj.'">Geri</a>';
		
	}
	else{
		?>

		
		<div id="sorguSonuclariPopupDiv" style=" padding:10px; overflow:auto; display:none; background-color:white; width:1020px; height:500px;">
		
		<div class="tableWrapper">
		<table cellspacing="0" style="padding-bottom:10px; font-size: 11px;" class="paginate-100 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<!-- <th class="sortable-numeric">Standart Id</th>  standart id ye gerek yok -->
				<th class="sortable-text">T.C. Kimlik No</th>
				<th class="sortable-text">Adı</th>
				<th class="sortable-text">Soyadı</th>
				<th class="sortable-text">Belge No</th>
				<th class="sortable-text">Yeterlilik Adı</th>
				<th class="sortable-text">Yeterlilik Seviyesi</th>
				<th class="sortable-numeric">Sınav Tarihi</th>
				<th class="sortable-numeric">Belge Düzenleme Tarihi</th>
				<th class="sortable-numeric">Geçerlilik Tarihi</th>
				<th class="sortable-numeric">Belgelendirme Kuruluşu</th>
				
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


					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'. $satir['TCKIMLIKNO'] .'</td>';
					echo '<td>'.$satir['AD'].'</td>';
					echo '<td>'.$satir['SOYAD'].'</td>';
					echo '<td>'.$satir['BELGENO'].'</td>';
					echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
					echo '<td>'.$satir['YETERLILIK_SEVIYESI'].'</td>';
					echo '<td>'.$satir['SINAV_TARIHI'].'</td>';
					echo '<td>'.$satir['BELGE_DUZENLEME_TARIHI'].'</td>';
					echo '<td>'.$satir['GECERLILIK_TARIHI'].'</td>';
					echo '<td>'.$satir['BELGELENDIRME_KURULUSU'].'</td>';
					echo '</tr>';
					$rowCount++;
				}
			
			
			?>
			
		</table>
		</div>
		<a href="index.php?option=com_mesleki_yeterlilik_belge_ara<?php echo $itemIdStrOrj?>">Geri</a>
		
		</div>
		
		<script>
		jQuery.unblockUI({});
		jQuery('#sorguSonuclariPopupDiv').lightbox_me({});
		</script>
		
		<?php
		
	}

}

function  hepsiIleAra($db, $tc_kimlik, $ad,
			$soyad, $belgeno, $yeterlilik_ad, $yeterlilik_seviye, $sinav_tarih, $belge_duzenleme_tarih, $gecerlilik_tarih, $belgelendirme_kurulus){
			
	$tcKimlikStr = $tc_kimlik ? "TCKIMLIKNO=?":'';
	$adStr = $ad ? 'TURKCE_UPPER(AD) LIKE TURKCE_UPPER(?)' : ''; 
	$soyadStr = $soyad ? 'TURKCE_UPPER(SOYAD) LIKE TURKCE_UPPER(?)' : ''; 
	$belgenoStr = $belgeno ? 'BELGENO=?' : ''; 
	$yeterlilikAdStr = $yeterlilik_ad ? 'TURKCE_UPPER(YETERLILIK_ADI) LIKE TURKCE_UPPER(?)' : ''; 
	$yeterlilikSeviyeStr = $yeterlilik_seviye ? 'YETERLILIK_SEVIYESI=?' : ''; 
	$sinavTarihStr = $sinav_tarih ? 'TURKCE_UPPER(SINAV_TARIHI) LIKE TURKCE_UPPER(?)' : '';		
	$belgeDuzenlemeTarihStr = $belge_duzenleme_tarih ? 'TURKCE_UPPER(BELGE_DUZENLEME_TARIHI) LIKE TURKCE_UPPER(?)' : '';	
	$gecerlilikTarihStr = $gecerlilik_tarih ? 'TURKCE_UPPER(GECERLILIK_TARIHI) LIKE TURKCE_UPPER(?)' : '';	 
	$belgelendirmeKurulusStr = $belgelendirme_kurulus ? 'TURKCE_UPPER(BELGELENDIRME_KURULUSU) LIKE TURKCE_UPPER(?)' : '';	
	
	
	$sql = "SELECT TCKIMLIKNO,
					AD,
					SOYAD,
					BELGENO,
					YETERLILIK_ADI,
					YETERLILIK_SEVIYESI,
					SINAV_TARIHI,
					BELGE_DUZENLEME_TARIHI,
					GECERLILIK_TARIHI,
					BELGELENDIRME_KURULUSU
			FROM M_BELGE_SORGU
			
		WHERE 1=1 		
		".($tcKimlikStr ? ("AND ". $tcKimlikStr) : '')."
		".($adStr ? ("AND ". $adStr) : '')."
		".($soyadStr ? ("AND ". $soyadStr) : '')."
		".($belgenoStr ? ("AND ". $belgenoStr) : '')." 
		".($yeterlilikAdStr ? ("AND ". $yeterlilikAdStr) : '')."
		".($yeterlilikSeviyeStr ? ("AND ". $yeterlilikSeviyeStr) : '')." 
		".($sinavTarihStr ? ("AND ". $sinavTarihStr) : '')." 
		".($belgeDuzenlemeTarihStr ? ("AND ". $belgeDuzenlemeTarihStr) : '')." 
		".($gecerlilikTarihStr ? ("AND ". $gecerlilikTarihStr) : '')." 
		".($belgelendirmeKurulusStr ? ("AND ". $belgelendirmeKurulusStr) : '')." 
		";

	$params = array();
	
	
	
	if($tcKimlikStr != '')
		$params[] = $tc_kimlik;
	if($adStr != '')
		$params[] = "%".$ad."%";
	if($soyadStr != '')
		$params[] = "%".$soyad."%";
	if($belgenoStr != '')
		$params[] = $belgeno;
	if($yeterlilikAdStr != '')
		$params[] = "%".$yeterlilik_ad."%";
	if($yeterlilikSeviyeStr != '')
		$params[] = $yeterlilik_seviye;
	if($sinavTarihStr != '')
		$params[] = "%".$sinav_tarih."%";
	if($belgeDuzenlemeTarihStr != '')
		$params[] = "%".$belge_duzenleme_tarih."%";
	if($gecerlilikTarihStr != '')
		$params[] = "%".$gecerlilik_tarih."%";
	if($belgelendirmeKurulusStr != '')
		$params[] = "%".$belgelendirme_kurulus."%";
		
	
	return $db->prep_exec($sql, $params);
	
}



?>

<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});

cal.manageFields("tarih_baslangic_button", "tarih_baslangic", "%d.%m.%Y");
cal.manageFields("tarih_bitis_button", "tarih_bitis", "%d.%m.%Y");
      
//]]></script>