<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$gorev = isset($_POST['gorev']) ? $_POST['gorev'] : "goster";

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&Itemid='.$itemId) : '';

if($gorev == "goster"){
	formGoster($itemIdStr);
}
else if($gorev == "sektor_id"){
	sektorIleListele($itemIdStrOrj);
}
else if($gorev == "yeterlilik_kodu"){
	yeterlilikIleListele($itemIdStrOrj);
}
else if($gorev == "yeterlilik_adi"){
	adIleListele($itemIdStrOrj);
}
else if($gorev == "seviye_id"){
	seviyeIleListele($itemIdStrOrj);
}
else if($gorev == "meslek_std_kod"){
	meslekStdKodIleListele($itemIdStrOrj);
}
else if($gorev == "meslek_std_adi"){
	meslekStdAdIleListele($itemIdStrOrj);
}
else if($gorev == "olusturan"){
	olusturanIleListele($itemIdStrOrj);
}
else if($gorev == "yeterlilik_birimi"){
	birimIleListele($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="sektor_id" name="gorev" />
		<table>
			<tr>
				<td width="150px">Sektöre göre ara</td>
				<td width="130px"><?php echo sektorleriGoster($db)?></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="yeterlilik_kodu" name="gorev" />
		<table>
			<tr>
				<td width="150px">Yeterlilik koduna göre ara</td>
				<td width="130px"><input type="text" name="yeterlilik_kodu" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="yeterlilik_adi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Yeterlilik adına göre ara</td>
				<td width="130px"><input type="text" name="yeterlilik_adi" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="seviye_id" name="gorev" />
		<table>
			<tr>
				<td width="150px">Seviyeye göre ara</td>
				<td width="130px"><?php echo seviyeleriGoster($db)?></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="yeterlilik_birimi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Yeterlilik birimine göre ara</td>
				<td width="130px"><input type="text" name="yeterlilik_birimi" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="meslek_std_kod" name="gorev" />
		<table>
			<tr>
				<td width="150px">Kaynak teşkil eden meslek standardı koduna göre ara</td>
				<td width="130px"><input type="text" name="meslek_std_kod" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="meslek_std_adi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Kaynak teşkil eden meslek standardi adina göre ara</td>
				<td width="130px"><input type="text" name="meslek_std_adi" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="olusturan" name="gorev" />
		<table>
			<tr>
				<td width="150px">Kaynak teşkil eden meslek standardi oluşturan kuruluşa göre ara</td>
				<td width="130px"><input type="text" name="olusturan" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_yeterlilik_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="yeterlilik_adi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Tümünü Listele</td>
				<td colspan="2"><input type="submit" value="Listele"></td>
			</tr>
		</table>
	</form>
	<?php
	
}

function yeterlilikIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = yeterlilikKoduIleAra($db, $_POST['yeterlilik_kodu']);
	listele($sonuclar, $itemIdStrOrj);
}

function meslekStdKodIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = meslekStdKodIleAra($db, $_POST['meslek_std_kod']);
	listele($sonuclar, $itemIdStrOrj);
}

function meslekStdAdIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = meslekStdAdIleAra($db, $_POST['meslek_std_adi']);
	listele($sonuclar, $itemIdStrOrj);
}

function olusturanIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = olusturanIleAra($db, $_POST['olusturan']);
	listele($sonuclar, $itemIdStrOrj);
}

function adIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$yetAdi = JRequest::getVar('yeterlilik_adi');
	$sonuclar = yeterlilikAdiIleAra($db, $yetAdi);
	listele($sonuclar, $itemIdStrOrj);
}

function birimIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$yetBirimi = JRequest::getVar('yeterlilik_birimi');
	$sonuclar = yeterlilikBirimiIleAra($db, $yetBirimi);
	birimListele($sonuclar, $itemIdStrOrj);
}

function sektorIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = sektorIdIleAra($db, $_POST['sektor_id']);
	listele($sonuclar, $itemIdStrOrj);
}

function seviyeIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();
	$sonuclar = seviyeIdIleAra($db, $_POST['seviye_id']);
	listele($sonuclar, $itemIdStrOrj);
}

function listele($sonuclar, $itemIdStrOrj){
		
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
				<th class="sortable-numeric">Yeterlilik Id</th>
				<th class="sortable-text">Yeterlilik Adı</th>
				<th class="sortable-text">Yeterlilik Kodu</th>
				<th class="sortable-text">Yeterliliğin Sektörü</th>
				<th class="sortable-text">Yeterliliğin Seviyesi</th>
			</tr>
			
			<?php
				$rowCount=1;
				$rowClass="";
				foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";

					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.$satir['YETERLILIK_ID'].'</td>';
					echo '<td>'. FormFactory::toUpperCase($satir['YETERLILIK_ADI']).'</td>';
					echo '<td>'.$satir['YETERLILIK_KODU'].'</td>';
					echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
					echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
					echo '</tr>';
					$rowCount++;
				}
			
			
			?>
			
		</table>
		</div>
		<a href="index.php?option=com_yeterlilik_ara<?php echo $itemIdStrOrj?>">Geri</a>
		<?php
	}

}

function birimListele($sonuclar, $itemIdStrOrj){
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
				<th class="sortable-text">Standart Adı</th>
				<th class="sortable-text">Birim</th>
			</tr>
			<?php
				$rowCount=1;
				$rowClass="";
				foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.$satir['YETERLILIK_ID'] .'</td>';
					echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
					echo '<td>'. FormFactory::toUpperCase($satir['YETERLILIK_ADI']) .'</td>';
					echo '<td>'.$satir['YETERLILIK_ALT_BIRIM_NO'].") ".$satir['YETERLILIK_ALT_BIRIM_ADI'].'</td>';
					
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

function sektorIdIleAra($db, $sektorId){
	$sql = "SELECT *
			FROM M_YETERLILIK
				NATURAL JOIN PM_SEKTORLER
				NATURAL JOIN PM_SEVIYE
			WHERE SEKTOR_ID = ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array($sektorId));
	
}

function seviyeIdIleAra($db, $seviyeId){	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
		WHERE SEVIYE_ID = ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array($seviyeId));
	
}

function yeterlilikKoduIleAra($db, $yeterlilikKodu){
	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
		WHERE YETERLILIK_KODU = ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array($yeterlilikKodu));
	
}

function meslekStdKodIleAra($db, $meslekStdKodu){
	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
			NATURAL JOIN M_STANDART_YETERLILIK
			JOIN M_MESLEK_STANDARTLARI USING (STANDART_ID) 
		WHERE STANDART_KODU = ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array($meslekStdKodu));
	
}

function meslekStdAdIleAra($db, $meslekStdAd){
	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
			NATURAL JOIN M_STANDART_YETERLILIK
			JOIN M_MESLEK_STANDARTLARI USING (STANDART_ID) 
		WHERE STANDART_ADI LIKE ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array("%$meslekStdAd%"));
	
}

function olusturanIleAra($db, $olusturan){
	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
			NATURAL JOIN M_YETERLILIK_EVRAK
			JOIN M_BASVURU USING (EVRAK_ID)
			JOIN M_KURULUS USING (USER_ID)
		WHERE KURULUS_ADI LIKE ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array("%$olusturan%"));
	
}

function yeterlilikAdiIleAra($db, $yeterlilikAdi){
	
	$sql = "SELECT *
		FROM M_YETERLILIK
			NATURAL JOIN PM_SEKTORLER
			NATURAL JOIN PM_SEVIYE
		WHERE YETERLILIK_ADI LIKE ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array("%$yeterlilikAdi%"));
	
}

function yeterlilikBirimiIleAra($db, $yeterlilikBirimi){
	
	$sql = "SELECT *
			FROM M_YETERLILIK
				NATURAL JOIN M_YETERLILIK_ALT_BIRIM 
				NATURAL JOIN PM_SEKTORLER
				NATURAL JOIN PM_SEVIYE
			WHERE YETERLILIK_ADI LIKE ? AND YETERLILIK_SUREC_DURUM_ID = ".ARA_YETERLILIK_SUREC_DURUM_ID;
	
	return $db->prep_exec($sql, array("%$yeterlilikBirimi%"));
	
}

//function sektorleriAl($db){
//		
//	$sql = "SELECT *
//		FROM PM_SEKTORLER ORDER BY SEKTOR_ADI ASC";
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