<?php

defined('_JEXEC') or die('Restricted access');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries/form/form_config.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );

$user =& JFactory::getUser();

if(!FormFactory::sektorSorumlusuMu($user)){
	global $mainframe;
	$mainframe->redirect('index.php', 'Yetkiniz Yok!', 'Error');
}

if (isset($_POST['gorev']))
	$gorev = $_POST['gorev'];
else if (isset($_GET['gorev']))
	$gorev = $_GET['gorev']; 
else {
	$gorev = "goster";
}

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&Itemid='.$itemId) : '';

if($gorev == "goster"){
	formGoster($itemIdStr);
}
else if($gorev == "hepsi"){
	hepsiIleListele($itemIdStrOrj);
}
else if ($gorev == "indir"){
	$file = getFilePath (JRequest::getVar('denetimId'));
	if ($file != -1)
		FormFactory::readFileFromDB ($file);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
<form action="index.php?option=com_denetim_ara<?php echo $itemIdStr?>"
	method="post"><input type="hidden" value="hepsi" name="gorev" />
<table>
	<tr>
		<td width="200px">Kuruluş adına göre ara</td>
		<td width="180px"><input type="text" name="kurulus_adi" /></td>
	</tr>
	<tr>
		<td width="200px">Personel adına göre ara</td>
		<td width="180px"><input type="text" name="personel_adi" /></td>
	</tr>
	<tr>
		<td width="200px">Personel soyadına göre ara</td>
		<td width="180px"><input type="text" name="personel_soyadi" /></td>
	</tr>
	<tr>
		<td width="200px">Denetim sonucuna göre ara</td>

		<td width="180px"><select name="sonuc_id">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo getDenetimSonuclar($db)?>
		</select></td>
	</tr>
	<tr>
		<td width="200px">Denetim sonucu açıklamasına göre ara</td>
		<td width="180px"><input type="text" name="denetim_sonuc" /></td>
	</tr>
<!--	<tr>-->
<!--		<td width="200px">Denetim tarihine göre ara</td>-->
<!--		<td width="180px"><input type="text" id="denetim_tarihi" name="tarih" /><input type="button" value="..." id="denetim_tarihi_button"></input></td>-->
<!--	</tr>-->
	<tr>
		<td colspan="2">Denetim tarihine göre ara</td>
	</tr>
	<tr>
		<td width="180px">Başlangıç <input type="text" size="10" id="denetim_tarih_baslangic" name="denetim_tarih_baslangic" /><input type="button" value="..." id="denetim_tarih_baslangic_button"></input></td>
		<td width="180px">Bitiş <input type="text" size="10" id="denetim_tarih_bitis" name="denetim_tarih_bitis" /><input type="button" value="..." id="denetim_tarih_bitis_button"></input></td>
	</tr>
</table>
<input type="submit" value="Ara"></form>
<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});

//cal.manageFields("denetim_tarihi_button", "denetim_tarihi", "%d.%m.%Y");
cal.manageFields("denetim_tarih_baslangic_button", "denetim_tarih_baslangic", "%d.%m.%Y");
cal.manageFields("denetim_tarih_bitis_button", "denetim_tarih_bitis", "%d.%m.%Y");
      
//]]></script>
			<?php

}

function hepsiIleListele($itemIdStrOrj){
	$db = & JFactory::getOracleDBO();

	$kurulus_adi 	= JRequest::getVar('kurulus_adi');
	$personel_adi 	= JRequest::getVar('personel_adi');
	$personel_soyadi 	= JRequest::getVar('personel_soyadi');
	$sonuc_id	  	= JRequest::getVar('sonuc_id');
	$sonuc_aciklama = JRequest::getVar('denetim_sonuc');
	//$tarih			= JRequest::getVar('tarih');
	$tarih_baslangic = JRequest::getVar('denetim_tarih_baslangic');
	$tarih_bitis 	 = JRequest::getVar('denetim_tarih_bitis');
	
	$sonuclar = hepsiIleAra($db, $kurulus_adi, $personel_adi, $personel_soyadi,
			$sonuc_id, $sonuc_aciklama, $tarih_baslangic, $tarih_bitis);

	listele($sonuclar, $itemIdStrOrj);
}

function listele($sonuclar, $itemIdStrOrj){

	if(empty($sonuclar)){

		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?com_denetim_ara"'. $itemIdStrOrj.'">Geri</a>';

	}
	else{
		?>
<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-numeric">Denetim Id</th>
		<th class="sortable-text">Kurulus Adı</th>
		<th class="sortable-text">Denetim Tarihi</th>
		<th class="sortable-text">Denetim Sonucu</th>
		<th class="sortable-text">Sonuç Açıklama</th>
		<th class="sortable-text">Rapor</th>
		<th class="sortable-text">Düzenle</th>
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
		echo '<td>'.$satir['DENETIM_ID'].'</td>';
		echo '<td>'.($satir['KURULUS_ADI']?$satir['KURULUS_ADI']:"&nbsp;").'</td>';
		echo '<td>'.($satir['DENETIM_TARIHI_F']?$satir['DENETIM_TARIHI_F']:"&nbsp;").'</td>';
		
		$denetimSonucu = $satir['DENETIM_SONUC_ADI'];
		$denetimSonucu = $denetimSonucu ? $denetimSonucu : '-';
		
		echo '<td>'.$denetimSonucu.'</td>';
		
		$aciklama = $satir['DENETIM_SONUC_ACIKLAMA'];
		
		echo '<td>'.($aciklama ? $aciklama : '-').'</td>';
		if($satir['DENETIM_RAPOR_PATH']==NULL)
			echo '<td>-</td>';
		else
			echo '<td><a href="index.php?option=com_denetim_ara&denetimId='.$satir['DENETIM_ID'].'&gorev=indir">İndir</a></td>';
		echo '<td><a href="index.php?option=com_denetim_duzenle&denetimId='.$satir['DENETIM_ID'].'">Düzenle</a></td>';
		echo '</tr>';
		$rowCount++;
	}
	?>
</table>
</div>
<a href="index.php?option=com_denetim_ara<?php echo $itemIdStrOrj?>">Geri</a>
	<?php
	}

}

function hepsiIleAra($db, $kurulus_adi, $personel_adi, $personel_soyadi,
		$sonuc_id, $sonuc_aciklama, $tarih_baslangic, $tarih_bitis){

	$kurulusAdiStr		= $kurulus_adi ? 'TURKCE_UPPER(KURULUS_ADI) LIKE TURKCE_UPPER(?)' : '';
	$personelAdiStr 	= $personel_adi ? 'TURKCE_UPPER(PERSONEL_AD) LIKE TURKCE_UPPER(?)' : '';
	$personelSoyadiStr 	= $personel_soyadi ? 'TURKCE_UPPER(PERSONEL_SOYAD) LIKE TURKCE_UPPER(?)' : '';
	//$tarihStr 		= $tarih ? "DENETIM_TARIHI = TO_DATE(?, 'dd.mm.yyyy')" : '';
	$sonucIdStr 		= $sonuc_id != 'Seçiniz' ? 'DENETIM_SONUC_ID = ?' : '';
	if ($sonuc_id == '-1' || $sonuc_id == 'Seçiniz')
		$sonucAciklamaStr = $sonuc_aciklama ? 'TURKCE_UPPER() LIKE TURKCE_UPPER(?)' : '';
	else
		$sonucAciklamaStr = '';
		
	$tarihStr = "";
	if ($tarih_baslangic || $tarih_bitis){
		if ($tarih_baslangic && $tarih_bitis)
			$tarihStr = "AND DENETIM_TARIHI BETWEEN TO_DATE('".$tarih_baslangic."','dd/mm/yyyy') AND TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
		else if ($tarih_baslangic)
			$tarihStr = "AND DENETIM_TARIHI >= TO_DATE('".$tarih_baslangic."','dd/mm/yyyy')";
		else if ($tarih_bitis)
			$tarihStr = "AND DENETIM_TARIHI <= TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
	}
	
	$sql = "SELECT 	DISTINCT 
					DENETIM_ID,
					DENETIM_RAPOR_PATH,
					KURULUS_ADI,
					TO_CHAR(DENETIM_TARIHI, 'dd.mm.yyyy') AS DENETIM_TARIHI_F,
					DENETIM_SONUC_ADI,
					DENETIM_SONUC_ACIKLAMA
				FROM M_DENETIM
				JOIN M_KURULUS ON (
					M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)
				LEFT JOIN M_DENETIM_EKIP USING (DENETIM_ID) 
				LEFT JOIN PM_DENETIM_SONUC USING (DENETIM_SONUC_ID) 
			WHERE 1 = 1 	
			".($kurulusAdiStr ? ("AND ". $kurulusAdiStr) : '')."
			".($personelAdiStr ? ("AND ". $personelAdiStr) : '')."
			".($personelSoyadiStr ? ("AND ". $personelSoyadiStr) : '')."
			".($sonucIdStr ? ("AND ". $sonucIdStr) : '')."
			".($sonucAciklamaStr ? ("AND ". $sonucAciklamaStr) : '')."	
			".$tarihStr;
	
//	echo "-$sql-";
	
	$params = array();

	if($kurulusAdiStr != '')
		$params[] = "%".$kurulus_adi."%";
	if($personelAdiStr != '')
		$params[] = "%".$personel_adi."%";
	if($personelSoyadiStr != '')
		$params[] = "%".$personel_soyadi."%";
//	if($tarihStr != '')
//	$params[] = $tarih;
	if($sonucIdStr != '')
		$params[] = $sonuc_id;
	if($sonucAciklamaStr != '')
		$params[] = "%".$sonuc_aciklama."%";

	return $db->prep_exec($sql, $params);

}


function getDenetimSonuclar($db){

	$sql = "SELECT * FROM PM_DENETIM_SONUC ORDER BY DENETIM_SONUC_ID ASC";
	$kuruluslar = $db->prep_exec($sql, array());
	$comboStr = '';
	if(isset($kuruluslar)){
		foreach ($kuruluslar as $row){
			$comboStr .= '<option value="'.$row['DENETIM_SONUC_ID'].'">'.$row['DENETIM_SONUC_ADI'].'</option>';
		}
		//$comboStr.="**Başarısız##Başarısız";
	}

	return $comboStr;
}

function sonuclariAl($db){
	$sql = "SELECT *
			FROM PM_DENETIM_SONUC 
			ORDER BY DENETIM_SONUC_ID ASC";

	return $db->prep_exec ($sql, array());
}

function sonuclariGoster($db){

	$sonuclar = sonuclariAl($db);
	?>

<select name="sonuc_id">
	<option selected="selected" value="Seçiniz">Seçiniz</option>
	<?php
	foreach($sonuclar AS $sonuc)
	echo '<option value="'.$sonuc['DENETIM_SONUC_ID'].'">'.$sektor['DENETIM_SONUC_ADI'].'</option>';
	?>
</select>
	<?php
}

function getFilePath ($denetimId){
	$db = & JFactory::getOracleDBO();
	
	$sql = "SELECT DENETIM_RAPOR_PATH 
			FROM M_DENETIM  
			WHERE DENETIM_ID = ?";
	
	$results = $db->prep_exec_array($sql, array($denetimId));
	
	if (isset ($results[0])){
		return $results[0];
	}else{
		return -1;
	}
}

?>
