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

$post = JRequest::get( 'post' );
$get = JRequest::get('get');

?>
<div class="sinavGirisBaslik">Meslek Standartları</div>
<?php

$gorev = isset($post['gorev']) ? $post['gorev'] : "goster";

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';

if($gorev == "goster"){
	formGoster($itemIdStr);
}
else if($gorev == "hepsi"){
	captcha::check("index.php?option=com_meslek_std_ara&gorev=goster&Itemid=".$itemId);
	hepsiIleListele($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	<form action="index.php?option=com_meslek_std_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="hepsi" name="gorev" />
		<table>
			<tr>
				<td width="200">Sektöre göre ara</td>
				<td width="130"><?php echo sektorleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200">Meslek Standardı adına göre ara</td>
				<td width="130"><input type="text" name="standart_adi" /></td>
			</tr>
			<tr>
				<td width="200">Meslek Standardı koduna göre ara</td>
				<td width="130"><input type="text" name="standart_kodu" /></td>
			</tr>
			<tr>
				<td width="200">Seviyeye göre ara</td>
				<td width="130"><?php echo seviyeleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200">İçerdiği görevlere göre ara</td>
				<td width="130"><input type="text" name="gorev_adi" /></td>
			</tr>
			<tr>
				<td width="200">Oluşturan Kuruluşa göre ara</td>
				<td width="130"><input type="text" name="olusturan" /></td>
			</tr>
			<tr>
				<td colspan="2">Resmi Gazete'de yayınlanma tarihine göre ara</td>
			</tr>
			<tr>
				<td width="165">Başlangıç <input type="text" size="10" id="tarih_baslangic" name="tarih_baslangic" /><input type="button" value="..." id="tarih_baslangic_button"></input></td>
				<td width="165">Bitiş <input type="text" size="10" id="tarih_bitis" name="tarih_bitis" /><input type="button" value="..." id="tarih_bitis_button"></input></td>
			</tr>
			<tr>
				<td width="200"><?php echo JText::_("CAPTCHA_INFO");?></td>
				<td width="130">
					<img src="index.php?option=com_egbcaptcha&amp;width=150&amp;height=50&amp;characters=5" />
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
	
	$standart_adi = JRequest::getVar('standart_adi');
	$standart_kodu = JRequest::getVar('standart_kodu');
	$sektor_id = JRequest::getVar('sektor_id');
	$seviye_id = JRequest::getVar('seviye_id');
	$gorev_adi = JRequest::getVar('gorev_adi');
	$olusturan = JRequest::getVar('olusturan');
	$tarih_baslangic = JRequest::getVar('tarih_baslangic');
	$tarih_bitis = JRequest::getVar('tarih_bitis');
	
	
	$sonuclar = hepsiIleAra($db, $standart_adi, $standart_kodu,
			$sektor_id, $seviye_id, $gorev_adi, $olusturan, $tarih_baslangic, $tarih_bitis);
	
	
	listele($sonuclar, $itemIdStrOrj);
}

function listele($sonuclar, $itemIdStrOrj){
	
	$db = & JFactory::getOracleDBO();
	if(empty($sonuclar)){
		
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?option=com_meslek_std_ara'. $itemIdStrOrj.'">Geri</a>';
		
	}
	else{
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<!-- <th class="sortable-numeric">Standart Id</th>  standart id ye gerek yok -->
				<th class="sortable-text">Standart Adı</th>
				<th class="sortable-text">Referans Kodu</th>
				<th class="sortable-text">Standardın Sektörü</th>
				<th class="sortable-text">Standardın Seviyesi</th>
				<th class="sortable-text">Hazırlayan Kuruluş(lar)</th>
				<th class="sortable-numeric">Resmi Gazete Yayım Tarihi</th>
				<?php 
				if (isset ($sonuclar[0]['PROFIL_GOREV_ADI']))
					echo '<th class="sortable-text">İçerdigi Görev</th>'; 
				?>
				<th >PDF</th>
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

					// SON_TASLAK_PDF VARSA ONU İNDİR
			/*		if ( sonTaslakVarMi($satir['STANDART_ID']) ){
						$taslakUrl = "index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=indir&amp;id=4&amp;standart_id=".$satir['STANDART_ID'];
					} else { // YOKSA PDF ÜRET
						$taslakUrl = "index.php?option=com_meslek_std_taslak&amp;layout=tum_basvuru&amp;format=pdf&amp;form=5&amp;id=".getTaslakStandartEvrakId($db, $satir['STANDART_ID'])."&amp;standart_id=".$satir['STANDART_ID'];
					}		*/
					$taslakUrl = generatePDFPathForStandart($satir['STANDART_ID']);
						
					if (strripos($user_browser, 'msie') !== FALSE) {
						$clickHTML = 'target="_blank" href="'.$taslakUrl.'"';
					} else {
						$clickHTML = 'onclick="window.open(\''.$taslakUrl.'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
					}

					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					//echo '<td>'.$satir['STANDART_ID'].'</td>'; standart id ye gerek yok
					echo '<td>'. FormFactory::toUpperCase($satir['STANDART_ADI']) .'</td>';
					echo '<td>'.$satir['STANDART_KODU'].'</td>';
					echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
					echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
					echo '<td align=left>'. FormFactory::toUpperCase($satir['KURULUS_ADI']).'</td>';
					echo '<td>'.($satir['RESMI_GAZETE_TARIH']?$satir['RESMI_GAZETE_TARIH']:"&nbsp;").'</td>';
					if (isset ($satir['PROFIL_GOREV_ADI']))
						echo '<td>'.$satir['PROFIL_GOREV_ADI'].'</td>';
					echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" /></a></td>';
					echo '</tr>';
					$rowCount++;
				}
			
			
			?>
			
		</table>
		</div>
		<a href="index.php?option=com_meslek_std_ara<?php echo $itemIdStrOrj?>">Geri</a>
		<?php
	}

}

function  hepsiIleAra($db, $standart_adi, $standart_kodu,$sektor_id, $seviye_id, 
						 $gorev_adi, $olusturan , $tarih_baslangic, $tarih_bitis){
	
//	$firephp = FirePHP::getInstance(true);
	
	/////// STANDARDI HAZIRLAMAMISSA AMA ORTAGIYSA //////////////
	$arananStandartIDCondition = $olusturan ? "(STANDART_ID IN (SELECT M_TASLAK_MESLEK.STANDART_ID 
					FROM M_TASLAK_MESLEK,M_TASLAK_MESLEK_HAZIRLAYAN 
					WHERE M_TASLAK_MESLEK_HAZIRLAYAN.TASLAK_MESLEK_ID = M_TASLAK_MESLEK.TASLAK_MESLEK_ID 
						AND NOT M_TASLAK_MESLEK_HAZIRLAYAN.KURULUS_TURU = 2 AND TURKCE_UPPER(HAZIRLAYAN_KURULUS_ADI) LIKE '%' || TURKCE_UPPER(?) || '%' ))"  : '' ;
	//echo $arananStandartIDler;
	/////////////////////////////////////////////////////////////
	//$firephp->log("asd".$arananStandartIDCondition);
		
	
	
	
	$stdAdiStr = $standart_adi ? 'TURKCE_UPPER(STANDART_ADI) LIKE TURKCE_UPPER(?)' : ''; 
	$stdKoduStr = $standart_kodu ? 'TURKCE_UPPER(STANDART_KODU) LIKE TURKCE_UPPER(?)' : ''; 
	$olusturanStr = $olusturan ? "TURKCE_UPPER(KURULUS_ADI) LIKE '%' || TURKCE_UPPER(?) || '%'" : ""; 
	$gorevStr = $gorev_adi ? 'TURKCE_UPPER(PROFIL_GOREV_ADI) LIKE TURKCE_UPPER(?)' : '';		
	$sektorIdStr = $sektor_id != 'Seçiniz' ? 'SEKTOR_ID = ?' : ''; 
	$seviyeIdStr = $seviye_id != 'Seçiniz' ? 'SEVIYE_ID = ?' : ''; 
	$tarihStr = "";
	if ($tarih_baslangic || $tarih_bitis){
		if ($tarih_baslangic && $tarih_bitis)
			$tarihStr = "AND RESMI_GAZETE_TARIH BETWEEN TO_DATE('".$tarih_baslangic."','dd/mm/yyyy') AND TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
		else if ($tarih_baslangic)
			$tarihStr = "AND RESMI_GAZETE_TARIH >= TO_DATE('".$tarih_baslangic."','dd/mm/yyyy')";
		else if ($tarih_bitis)
			$tarihStr = "AND RESMI_GAZETE_TARIH <= TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
	}
	
	$sql = "SELECT  distinct 
					STANDART_ID,
					STANDART_ADI,
					STANDART_KODU,
					SEVIYE_ADI,
					SEKTOR_ADI,
					
					".(($gorevStr) ? " PROFIL_GOREV_ADI, " : " ").
					"TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') AS RESMI_GAZETE_TARIH 
			FROM M_MESLEK_STANDARTLARI 
			JOIN PM_SEKTORLER USING (SEKTOR_ID) 
			JOIN PM_SEVIYE USING (SEVIYE_ID) 		
JOIN M_YETKI_STANDART USING (STANDART_ID)
JOIN M_KURULUS_YETKI USING (YETKI_ID)
						JOIN M_KURULUS USING (USER_ID) 
			" .
			(($gorevStr) ? 
			"JOIN M_TASLAK_MESLEK USING (STANDART_ID)
			 JOIN M_TASLAK_MESLEK_PROFIL USING (TASLAK_MESLEK_ID) " : "").	
			" 
		WHERE MESLEK_STANDART_SUREC_DURUM_ID IN (".RESMI_GAZETEDE_YAYINLANMIS_STANDART.")  
		
		".($stdAdiStr ? ("AND ". $stdAdiStr) : '')."
		".($stdKoduStr ? ("AND ". $stdKoduStr) : '')."
		".($sektorIdStr ? ("AND ". $sektorIdStr) : '')."
		".($gorevStr ? ("AND ". $gorevStr) : '')." 
		".($olusturanStr ? ("AND ". $olusturanStr) : '')."
		".($seviyeIdStr ? ("AND ". $seviyeIdStr) : '')." 
		".$tarihStr."
		".($arananStandartIDCondition ? (" OR ".$arananStandartIDCondition) : '');
	
		
	$params = array();
	
	if($stdAdiStr != '')
		$params[] = "%".$standart_adi."%";
	if($stdKoduStr != '')
		$params[] = "%".$standart_kodu."%";
	if($sektorIdStr != '')
		$params[] = $sektor_id;
	if($gorevStr != '')
		$params[] = "%".$gorev_adi."%";
	if($olusturan != '')
		$params[] = "%".$olusturan."%";
	if($seviyeIdStr != '')
		$params[] = $seviye_id;
	if($olusturan != '')
		$params[] = "%".$olusturan."%";
	
	
	/////////// ASIL STANDARDI HAZIRLAMISSA DIGER KURUMLARI EKLEMEK ///////////////////////
	/*$firephp->log("--SQL:---".$sql."---");
	$firephp->log("***COUNT-PARAMS***".count($params)."**");
	$firephp->log($params); 
		*/
		
	
	$result = $db->prep_exec($sql, $params);
	for($i=0; $i<count($result); $i++)
	{
		$standart_IDsi =  $result[$i]["STANDART_ID"];
		$hazirlayanKuruluslar = $db->prep_exec("SELECT hazirlayan_kurulus_adi as kurulus_adi
												FROM m_taslak_meslek_hazirlayan
												JOIN m_taslak_meslek USING (taslak_meslek_id)
												WHERE standart_id = ?
												ORDER BY hazirlayan_kurulus_adi", array($standart_IDsi));
		if (!$hazirlayanKuruluslar){
		
			$hazirlayanKuruluslar = $db->prep_exec("SELECT kurulus_adi
													FROM m_kurulus
													JOIN m_kurulus_yetki USING (user_id)
													JOIN m_yetki_standart USING (yetki_id)
													WHERE standart_id = ?
													ORDER BY kurulus_adi", array($standart_IDsi));
		}
 		for($j=0; $j<count($hazirlayanKuruluslar); $j++)
		{
			$result[$i]["KURULUS_ADI"] .=  "* ".$hazirlayanKuruluslar[$j]["KURULUS_ADI"]."<br>";
		}
	}
		
	return $result;
	/////////////////////////////////////////////////////
	
	
	
	
	//return $db->prep_exec($sql, $params);
	
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

function sonTaslakVarMi ($standart_id){
	
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT SON_TASLAK_PDF  
			   FROM m_taslak_meslek			   	 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data[0]["SON_TASLAK_PDF"])){
			return true;
		} else {
			return false;
		}
}

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
		if($data[0]['SON_TASLAK_PDF']=='')//yani en ustteki revizyon
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


?>

<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});

cal.manageFields("tarih_baslangic_button", "tarih_baslangic", "%d.%m.%Y");
cal.manageFields("tarih_bitis_button", "tarih_bitis", "%d.%m.%Y");
      
//]]></script>