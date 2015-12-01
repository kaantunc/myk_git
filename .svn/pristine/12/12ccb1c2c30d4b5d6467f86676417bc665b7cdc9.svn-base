<?php
header( 'Location: http://www.myk.gov.tr/index.php/tr/yetkilendirilmi-belgelendirme-kurulular' );
// geri kalan kod hiç bir işe yaramıyor. header var. header baska sayfaya yönlendiriyor.

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");

require_once('libraries/form/captcha.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$gorev = JRequest::getVar('gorev');

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';

?>
<div class="sinavGirisBaslik">Yetkilendirilmiş Kuruluşlar</div>
<?php

if($gorev == "goster" || $gorev == ''){
	formGoster($itemIdStr);
}
else if($gorev == "hepsi"){
	captcha::check("index.php?option=com_yetkilendirilmis_kurulus_ara&gorev=goster&Itemid=$itemId");
	hepsiIleListele($itemIdStrOrj);
}
else if ($gorev == "tumu"){
	tumunuListele ($itemIdStrOrj);
}else if ($gorev == "ayrinti"){
	kurulusBilgiListele ($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	
	<form action="index.php?option=com_yetkilendirilmis_kurulus_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="hepsi" name="gorev" />
		<table>
			<tr>
				<td width="200">Kuruluş Adı</td>
				<td width="130"><input type="text" name="kurulus_adi" style="width:150px;"/></td>
			</tr>
			<tr>
				<td width="200">Kuruluş Türü</td>
				<td width="130"><?php echo turleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200">Faaliyette Bulunduğu Sektörler</td>
				<td width="130"><?php echo sektorleriGoster($db)?></td>
			</tr>
			<tr>
				<td width="200"><?php echo JText::_("CAPTCHA_INFO");?></td>
				<td width="130">
					<img src="index.php?option=com_egbcaptcha&width=150&height=50&characters=5" />
					<div class="captchaInfo"><?php echo JText::_("CAPTCHA_PIC_INFO");?></div>
					<input id="verify_code" name="verify_code" type="text" />
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="Ara" /></td>
			</tr>
		</table>
		
	</form>
<!--	<br />-->
<!--	<form action="?option=com_yetkilendirilmis_kurulus_ara<?php //echo $itemIdStr?>" method="post">-->
<!--		<input type="hidden" value="tumu" name="gorev" />-->
<!--		<table>-->
<!--			<tr>-->
<!--				<td colspan="2"><input type="submit" value="Tümünü Listele"></td>-->
<!--			</tr>-->
<!--		</table>-->
<!--	</form>-->
	<?php
}

function turleriGoster($db){
	
$kurulusSec = JRequest::getVar('sec');

	//$turler = turleriAl($db);
	?>
	
	<select name="tur_id" style="width:150px;">
		<option <?php echo $kurulusSec == null ? 'selected="selected"' : ""; ?> value="0">Seçiniz</option>
			<option <?php echo ($kurulusSec == "mshk" ? 'selected="selected"' : ""); ?> value="1">Meslek Standardı Hazırlayan Kuruluş</option>
			<option <?php echo $kurulusSec == "yhk" ? 'selected="selected"' : ""; ?> value="2">Yeterlilik Hazırlayan Kuruluş</option>
			<option <?php echo $kurulusSec == "sbk" ? 'selected="selected"' : ""; ?> value="3">Sınav ve Belgelendirme Kuruluşu</option>
			<option <?php echo $kurulusSec == "akre" ? 'selected="selected"' : ""; ?> value="3">Akreditasyon Kuruluşu</option>
		<?php 
//		foreach($turler AS $tur)
//			echo '<option value="'.$tur['KURULUS_DURUM_ID'].'">'.$tur['KURULUS_DURUM_ADI'].'</option>';
		?>
	</select>
	<?php
}

function hepsiIleListele($itemIdStrOrj){
	$kurulusAdi  = JRequest::getVar('kurulus_adi');
	$kurulusTuru = JRequest::getVar('tur_id');
	$sektorler	 = JRequest::getVar('sektorler');
	
	$db = & JFactory::getOracleDBO();
	$sonuclar = hepsiIleAra($db, $kurulusAdi, $kurulusTuru, $sektorler);
	listele($sonuclar, $itemIdStrOrj);	
}

function tumunuListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = tumunuAra($db);
	listele($sonuclar, $itemIdStrOrj);
}

function kurulusBilgiListele ($itemIdStrOrj){
	$userId  = JRequest::getVar('id');
	$kurulusTuru = JRequest::getVar('tur');
		
	$db = & JFactory::getOracleDBO();
	$sonuclar = hazirlananMeslekYeterlilikAra($db, $userId, $kurulusTuru);
	bilgiListele($sonuclar,$userId, $itemIdStrOrj);
}


function listele($sonuclar,$itemIdStrOrj){
	$user = JFactory::getUser ();
	$db = & JFactory::getOracleDBO();
	$sektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
	
	if(empty($sonuclar)){	
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'">Geri</a>';
	}
	else{
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-text">Kuruluş Adı</th>
				<th class="sortable-text">Kuruluş Yetki Durumu</th>
				<th >Faaliyet Gösterdiği Sektörler</th>
				<th >Hazırlamakta Olduğu Standartları Görüntüle</th>
				<th >Hazırlamakta Olduğu Yeterlilikleri Görüntüle</th>
			</tr>
			
			<?php
				$yetStandartOlmayanIds =explode(',',YET_STANDART_OLMAYAN_KURULUS_IDS);
				$meslekStdIds = explode(',',SADECE_MESLEK_STD_KURULUS_DURUM_IDS);
				$yetIds = explode(',',SADECE_YETERLILIK_KURULUS_DURUM_IDS);
				
				$rowCount=1;
				$rowClass="";
				foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.$satir['KURULUS_ADI'].'</td>';
					echo '<td>'.$satir['KURULUS_DURUM_ADI'].'</td>';
					echo '<td>'.getSektorAdiStr( $db, $satir['USER_ID']) .'</td>';
					if (array_search ($satir['KURULUS_DURUM_ID'], $yetStandartOlmayanIds) !== FALSE ){
						echo '<td>-</td>';
						echo '<td>-</td>';
					}else if (array_search ($satir['KURULUS_DURUM_ID'], $meslekStdIds) !== FALSE){
						echo '<td><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'&amp;gorev=ayrinti&amp;id='.$satir['USER_ID'].'&amp;tur=1">Görüntüle</a></td>';
						echo '<td>-</td>';
					}else if (array_search ($satir['KURULUS_DURUM_ID'], $yetIds) !== FALSE){
						echo '<td>-</td>';
						echo '<td><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'&amp;gorev=ayrinti&amp;id='.$satir['USER_ID'].'&amp;tur=2">Görüntüle</a></td>';
					}else{ // Ikisi birden
						echo '<td><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'&amp;gorev=ayrinti&amp;id='.$satir['USER_ID'].'&amp;tur=1">Görüntüle</a></td>';
						echo '<td><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'&amp;gorev=ayrinti&amp;id='.$satir['USER_ID'].'&amp;tur=2">Görüntüle</a></td>';
					}
					echo '</tr>';
					$rowCount++;
				}
			?>	
		</table>
		</div>
		<br />
		<a href="index.php?option=com_yetkilendirilmis_kurulus_ara<?php echo $itemIdStrOrj?>">Geri</a>
		<?php
	}

}

function bilgiListele($sonuclar,$userId, $itemIdStrOrj){
	if(empty($sonuclar)){	
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?option=com_yetkilendirilmis_kurulus_ara'.$itemIdStrOrj.'">Geri</a>';
	}
	else{
		$user = &JFactory::getUser();
		$aut = checkAuthorizationForDurum ($user, $userId);
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<?php 
				if (isset ($sonuclar[0]['YETERLILIK_ADI']))
					echo '<th class="sortable-text">Hazırlamakta Olduğu Yeterlilik</th>';
				if (isset ($sonuclar[0]['STANDART_ADI']))
					echo '<th class="sortable-text">Hazırlamakta Olduğu Standart</th>';
				?>
				
				<th class="sortable-text">Seviye</th>
				<th class="sortable-text">Sektör</th>
				<?php if ($aut) {?>
				<th class="sortable-text">Durum</th>
				<th class="sortable-text">PDF</th>
				<?php }?>
			</tr>
			
			<?php
				$rowCount=1;
				$rowClass="";
				$user_browser = browser_detection('browser');
			
				foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";	
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					if (isset ($satir['YETERLILIK_ADI'])){
						if ($aut)
							echo '<td><a href="index.php?option=com_yeterlilik_taslak&layout=tanitim&id='.$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'].'">'.$satir['YETERLILIK_ADI'].'</a></td>';
						else
							echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
						
						if (strripos($user_browser, 'msie') !== FALSE) {
							$clickHTML = 'target="_blank" href="index.php?option=com_yeterlilik_taslak&layout=tanitim&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'].'"';
						} else {                     
							$clickHTML = 'onclick="window.open(\'index.php?option=com_yeterlilik_taslak&layout=tanitim&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
						}
					}
					if (isset ($satir['STANDART_ADI'])){
						if ($aut)
							echo '<td><a href="index.php?option=com_meslek_std_taslak&layout=terim&id='.$satir['EVRAK_ID'].'&standart_id='.$satir['STANDART_ID'].'">'.$satir['STANDART_ADI'].'</a></td>';
						else
							echo '<td>'.$satir['STANDART_ADI'].'</td>';
							
						if (strripos($user_browser, 'msie') !== FALSE) {
							$clickHTML = 'target="_blank" href="index.php?option=com_meslek_std_taslak&layout=terim&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&standart_id='.$satir['STANDART_ID'].'"';
						} else {                     
							$clickHTML = 'onclick="window.open(\'index.php?option=com_meslek_std_taslak&layout=terim&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&standart_id='.$satir['STANDART_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
						}
					}				
					echo '<td>'.$satir['SEVIYE_ADI'].'</td>';		
					echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
					if (isset ($satir['YETERLILIK_ADI']) && $aut){
						echo '<td>'.$satir['YETERLILIK_SUREC_DURUM_ADI'].'</td>';
						echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td>';
					}
					if (isset ($satir['STANDART_ADI']) && $aut){
						echo '<td>'.$satir['STANDART_SUREC_DURUM_ADI'].'</td>';
						echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td>';
					}			
					echo '</tr>';
					$rowCount++;
				}
			?>	
		</table>
		</div>
		<br />
		<a href="index.php?option=com_yetkilendirilmis_kurulus_ara<?php echo $itemIdStrOrj?>">Geri</a>
		<?php
	}

}

function hepsiIleAra($db, $kurulusAdi, $kurulusTuru, $sektorler){ 
	$sektorStr = ($sektorler) ? " AND SEKTOR_ID IN ( ".implode (" , ", $sektorler)." ) " : "";
	$sqlWhere = "";
	
	if ($kurulusTuru == 1){ //Meslek Standardi
		$sqlWhere = "AND KURULUS_DURUM_ID IN (".MESLEK_STD_KURULUS_DURUM_IDS.")";
	}else if ($kurulusTuru == 2){ //Yeterlilik	
		$sqlWhere = "AND KURULUS_DURUM_ID IN (".YETERLILIK_KURULUS_DURUM_IDS.")";
	}else if ($kurulusTuru == 3){ // Sinav ve Belgelendirme
		$sqlWhere = "AND KURULUS_DURUM_ID IN (".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.")";
	}else if ($kurulusTuru == 4){ // Akreditasyon
		$sqlWhere = "AND KURULUS_DURUM_ID IN (".AKREDITASYON_KURULUS_DURUM_IDS.")";
	}
	
	$sql = "SELECT DISTINCT KURULUS_ADI, KURULUS_DURUM_ID, KURULUS_DURUM_ADI, USER_ID
	        FROM M_KURULUS 
				JOIN PM_KURULUS_DURUM USING (KURULUS_DURUM_ID) 
				JOIN M_BASVURU USING (USER_ID) 
				LEFT JOIN M_BASVURU_SEKTOR USING (EVRAK_ID) 
				LEFT JOIN PM_SEKTORLER USING (SEKTOR_ID) 
		    WHERE KURULUS_DURUM_ID <> 1 
		    	  AND TURKCE_UPPER(KURULUS_ADI) LIKE TURKCE_UPPER(?) ".
				  $sqlWhere.
				  $sektorStr;

	$params = array("%".$kurulusAdi."%");

	return $db->prep_exec($sql, $params);
}

function tumunuAra($db){
	$sql = "SELECT * 
	        FROM M_KURULUS 
	        	JOIN PM_KURULUS_DURUM USING (KURULUS_DURUM_ID) 
		    WHERE KURULUS_DURUM_ID > 1 ";
	
	return $db->prep_exec($sql, array());
	
}

function hazirlananMeslekYeterlilikAra($db, $userId, $tur){
	if ($tur == 1){
		$sqlJoin = "JOIN M_MESLEK_STAN_EVRAK USING (EVRAK_ID)
   					JOIN M_MESLEK_STANDARTLARI USING (STANDART_ID) 
    				JOIN PM_MESLEK_STANDART_SUREC_DURUM USING (MESLEK_STANDART_SUREC_DURUM_ID) 
					JOIN PM_SEVIYE USING (SEVIYE_ID) 
	        		JOIN PM_SEKTORLER USING (SEKTOR_ID)";
		
		$selectPart = "EVRAK_ID,STANDART_ID, STANDART_ADI,STANDART_SUREC_DURUM_ADI, SEVIYE_ADI, SEKTOR_ADI";
		$wherePart	= "AND MS_LISTE_ONAY = 1 AND MESLEK_STANDART_SUREC_DURUM_ID <> -3";
	}else if ($tur == 2){
		$sqlJoin = "JOIN M_YETERLILIK_EVRAK USING (EVRAK_ID)
					JOIN M_YETERLILIK USING (YETERLILIK_ID)
					JOIN PM_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_ID) 
					JOIN PM_SEVIYE USING (SEVIYE_ID) 
	        		JOIN PM_SEKTORLER USING (SEKTOR_ID)";

		$selectPart = "EVRAK_ID,YETERLILIK_ID,YETERLILIK_ADI,YETERLILIK_SUREC_DURUM_ADI, SEVIYE_ADI, SEKTOR_ADI";
		$wherePart  = "AND YET_LISTE_ONAY = 1 AND YETERLILIK_SUREC_DURUM_ID <> -3";
	}
	
	$sql = "SELECT ".$selectPart." 
	        FROM M_BASVURU 
	        	JOIN M_KURULUS USING (USER_ID) 
	        	".$sqlJoin." 
		    WHERE USER_ID = ? AND KURULUS_DURUM_ID <> 1 
				".$wherePart;
	
	return $db->prep_exec($sql, array($userId));
}

function sektorleriGoster($db){
	
	$sektorler = FormParametrik::getSektor();
	?>
	
	<select id="list" name="sektorler[]" size="10" title="" style='width:150px;' multiple="multiple">
		<?php 
		foreach($sektorler AS $sektor)
			echo '<option value="'.$sektor['SEKTOR_ID'].'">'.$sektor['SEKTOR_ADI'].'</option>';
		?>
	</select>
	<?php
}

//function sektorleriAl($db){
//		
//	$sql = "SELECT *
//			FROM PM_SEKTORLER ORDER BY SEKTOR_ADI ASC";
//	
//	return $db->prep_exec($sql, array());
//}

function getSektorAdiStr( $db, $user_id){
	$sql = "SELECT SEKTOR_ADI 
			FROM M_BASVURU 
				JOIN M_BASVURU_SEKTOR USING (EVRAK_ID) 
				JOIN PM_SEKTORLER USING (SEKTOR_ID) 
			WHERE USER_ID = ?  
			ORDER BY SEKTOR_ADI ASC";
	
	$data = $db->prep_exec_array($sql, array($user_id));
	
	if (isset ($data[0]))
		return implode (" , ",  $data);
	else
		return ""; 
}

function checkAuthorizationForDurum ($user, $searchUserId){
	$result = false;
	$user_id = $user->getOracleUserId ();
	
	if ($searchUserId == $user_id)
		$result = true;
	else if (FormFactory::sektorSorumlusuMu($user))
		$result = true;
		
	return $result;
}
?>
