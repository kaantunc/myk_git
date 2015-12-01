<?php 
/*
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/components/com_meslek_std_basvur/js/meslek_std_basvur.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );

$user =& JFactory::getUser();

if(!FormFactory::sektorSorumlusuMu($user)){
	global $mainframe;
	$mainframe->redirect('index.php', 'Yetkiniz Yok!', 'Error');
}

//function getPersonel($db){
//	$sql = "SELECT *
//		FROM ".DB_PREFIX.".TG_USER
//			JOIN ".DB_PREFIX.".P_PERSONEL USING (USER_ID)
//			JOIN ".DB_PREFIX.".P_BIRIM USING (BIRIM_ID)
//                WHERE DIS_KURUM_MU = ".DIS_KURUM_DEGIL_ID." AND USER_ID != ".ADMIN_ID." AND
//                BIRIM_YETKILISI = ".BIRIM_YETKILISI_DEGIL."
//			ORDER BY DISPLAY_NAME";
//
//	$personeller = $db->prep_exec($sql, array());
//
//	$comboStr = '';
//
//	if(isset($personeller)){
//		foreach ($personeller as $row){
//			$comboStr .= ', new Array("'.$row["USER_ID"] . '","'. $row["DISPLAY_NAME"] . ' ' . $row["DISPLAY_SURNAME"]. '")';
//		}
//		//$comboStr.="**Başarısız##Başarısız";
//	}
//
//	return $comboStr;
//}

function getKuruluslar($db){

	$sql = "SELECT * FROM M_KURULUS ORDER BY KURULUS_ADI ASC";
	$kuruluslar = $db->prep_exec($sql, array());
	$comboStr = '';
	if(isset($kuruluslar)){
		foreach ($kuruluslar as $row){
			$comboStr .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
		}
		//$comboStr.="**Başarısız##Başarısız";
	}

	return $comboStr;
}

function getDenetim($db, $kurulus){
	$sql = "SELECT *
			FROM M_DENETIM 
			   JOIN M_DENETIM_EKIP USING (DENETIM_ID) 
			WHERE DENETIM_KURULUS_ID = ? AND DENETIM_SONUC_ID = NULL";

	$sonuclar = $db->prep_exec($sql, array($kurulus));

	//echo '<pre>';
	//print_r($sonuclar);
	//echo '</pre>';

	$sonuclarStr = '';
	if(!empty($sonuclar)){
		foreach($sonuclar AS $sonuc){
			$sonuclarStr .= $sonuc["DENETIM_TARIHI_BASLANGIC"] . "##".
			$sonuc["DENETIM_HESAP_NO"]. "##".
			$sonuc["DENETIM_RAPOR_PATH"]. "##".
			$sonuc["DENETIM_SONUC_ID"]. "##".
			$sonuc["DENETIM_SONUC_ACIKLAMA"]. "##";
		}
	}
	else{
		$sonuclarStr = "no";
	}

	echo $sonuclarStr;
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
function denetimKaydet($db, $postData){

	$kurulus 	= $postData['kurulus'];
	$tarih 	= $postData['denetim_tarihi_baslangic'];
	$denetimSuresi    = $postData['denetimSuresi'];
	$hesapNo    = $postData['hesapNo'];
	$yatirildimi    = ($postData['yatirildimi']!= 'Seçiniz')?$postData['yatirildimi']:null;;
	$raporPath  = "";
	$raporFile  = "";
	if (isset ($postData['path_rapor_0_1'])){
		$raporPath		= $postData['path_rapor_0_1'];
		$raporFile 		= $postData['filename_rapor_0_1'];
	}
	$rapor			= $raporPath.$raporFile;
	$sonuc			= ($postData['sonuc']!= 'Seçiniz')?$postData['sonuc']:null;
	$sonucAciklama 	= $postData['sonucAciklama'];

	$denetim_id = $db->getNextVal('DENETIM_ID_SEQ');

	$sql = "INSERT INTO M_DENETIM
			VALUES(?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?, ?, ?, ?)";

	$params = array($denetim_id, $kurulus, $tarih, $hesapNo, $rapor, $sonuc,
			$sonucAciklama, $denetimSuresi, $yatirildimi);
			
	$bilgiValues = FormFactory::getTableValues($postData, array("denetimEkibi", 2));

	$db->prep_exec_insert($sql, $params);

//	echo '<pre>';
//	print_r($bilgiValues);
//	echo '</pre>';
	$sql = "INSERT INTO M_DENETIM_EKIP VALUES (? ,?, ?, ?)";

	for($i = 0; $i < count ($bilgiValues)/2; $i++){
		$personel_id = $db->getNextVal(DENETIM_PERSONEL_ID_SEQ);
		$id = $i * 2;
		$ad = $bilgiValues[$id];
		$soyad = $bilgiValues[$id+1];
		$db->prep_exec_insert($sql, array($denetim_id, $personel_id, $ad, $soyad));
	}
	global $mainframe;
	$mainframe->redirect('index.php', 'Denetim Verileri Kaydedildi.');

}

$db = & JFactory::getOracleDBO();
if(!isset($_POST['gorev'])){
	//$personeller = getPersonel($db);
	$kuruluslar = getKuruluslar($db);
	$denetimSonuc = getDenetimSonuclar($db);
//	formGoster($kuruluslar, $personeller, $denetimSonuc);
	formGoster($kuruluslar, $denetimSonuc);
}
else if ($_POST['gorev'] == "kaydet"){
	//	echo '<pre>';
	//	print_r($_POST);
	//	echo '</pre>';
	denetimKaydet($db, $_POST);
}else if ($_POST['gorev'] == "denetimAl"){
	$kurulus = $_POST ['kurulus'];
	getDenetim($db, $kurulus);
}


function formGoster($kuruluslar, $denetimSonuc){
	?>

<script type="text/javascript">
//	dTables.denetimEkibi = new Array(
//			new Array( "combo",
//					new Array(
//						new Array("Seçiniz", "Seçiniz") <?php //echo $personeller?>
//					))
//			);

	dTables.denetimEkibi = new Array(new Array("text","required", "30"), new Array("text","required", "30"));
	dTables.rapor = new Array(new Array("upload"));
	
	</script>
<form method="POST" action="index.php?option=com_denetim"
	id="denetim_form" onSubmit="return validate('denetim_form')"><input
	type="hidden" name="gorev" value="kaydet"></input>
<table>
	<tr>
		<td>Denetim Yapılan Kuruluş</td>
		<td><select name="kurulus" class="comboReq">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $kuruluslar?>
		</select></td>
	</tr>
	<tr>
		<td>Denetim Tarihi</td>
		<td><input type="text" id="inputdenetim_tarihi_baslangic" name="denetim_tarihi"
			size="10" class="required date"> <input type="button" value="..."
			id="denetim_tarihi_baslangic_button"></input>(GG.AA.YYYY)</td>
	</tr>
	<tr>
		<td>Denetim Süresi</td>
		<td><input type="text" name="denetimSuresi" size="10"></td>
	</tr>
	<tr>
		<td>DENETİM EKİBİ</td>
		<td>
		<div id="denetimEkibi_div"></div>
		</td>
	</tr>
	<tr>
		<td>DENETİM MASRAF KARŞILIĞI /HESAP NUMARASI</td>
		<td><input type="text" name="hesapNo"></input></td>
	</tr>
	<tr>
		<td>MASRAF YATIRILDI MI?</td>
		<td><select name="yatirildimi">
			<option value="Seçiniz">Seçiniz</option>
			<option value="0">Hayır</option>
			<option value="1">Evet</option>		
		</select></td>
	</tr>
	<tr>
		<td>DENETİM RAPORU</td>
		<td>
		<div id="rapor_div"></div>
		
		</td>
	</tr>
	<tr>
		<td>DENETİM SONUCU</td>
		<td><select name="sonuc">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $denetimSonuc?>
		</select></td>
	</tr>
	<tr>
		<td>DENETİM SONUCU AÇIKLAMA</td>
		<td><input type="text" name="sonucAciklama"></input></td>
	</tr>
</table>

<br />
<input type="submit" value="Kaydet"></input></form>
<script type="text/javascript">
	function createTables(){
		createTable('denetimEkibi',new Array ('Personel Adı', 'Soyadı'));

		tableName = "rapor";
		createTable(tableName, new Array(''));
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 0);
	}

	</script>
		<?php
}

?>

<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});

cal.manageFields("denetim_tarihi_baslangic_button", "inputdenetim_tarihi", "%d.%m.%Y");
      
//]]></script>

<script type="text/javascript">
function kurulusSecildi(kurulus){
	if(kurulus == "Seçiniz")
		return;

	//jQuery('#denetim_form').show();

	//daha önce eklenmiş kayıtları getir doldur tabloyu 
	
	xmlhttpPost(null, 'index.php?option=com_denetim&gorev=denetimAl&format=raw',
	function (){
		return getKurulusQueryString(kurulus);
	},
	getDenetimUpdate);
	
}

function getKurulusQueryString(kurulus){
	var qstr = 'kurulus=' + kurulus;
	return qstr;
}

function getDenetimUpdate(str){
	//alert(str);

	if(str == "no"){
		alert("Seçilen kuruluş için denetim planı bulunmamaktadır. Şimdi oluşturabilirsiniz.");
		
		return;
	}

	
}
</script>
