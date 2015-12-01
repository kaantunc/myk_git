<?php
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

function getKuruluslar($db, $kurulusId){

	$sql = "SELECT * FROM M_KURULUS ORDER BY KURULUS_ADI ASC";
	$kuruluslar = $db->prep_exec($sql, array());
	$comboStr = '';
	if(isset($kuruluslar)){
		foreach ($kuruluslar as $row){
			if($row['USER_ID'] == $kurulusId)
				$comboStr .= '<option selected="selected" value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
			else
				$comboStr .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
		}
		//$comboStr.="**Başarısız##Başarısız";
	}

	return $comboStr;
}


function getDenetimSonuclar($db, $sonucId){

	$sql = "SELECT * FROM PM_DENETIM_SONUC ORDER BY DENETIM_SONUC_ID ASC";
	$kuruluslar = $db->prep_exec($sql, array());
	$comboStr = '';
	if(isset($kuruluslar)){
		foreach ($kuruluslar as $row){
			if($row['DENETIM_SONUC_ID'] == $sonucId)
				$comboStr .= '<option selected="selected" value="'.$row['DENETIM_SONUC_ID'].'">'.$row['DENETIM_SONUC_ADI'].'</option>';
			else
				$comboStr .= '<option value="'.$row['DENETIM_SONUC_ID'].'">'.$row['DENETIM_SONUC_ADI'].'</option>';
		}
		//$comboStr.="**Başarısız##Başarısız";
	}

	return $comboStr;
}
function denetimKaydet($db, $postData){

	$kurulus 		= $postData['kurulus'];
	$tarih 			= $postData['denetim_tarihi'];
	$hesapNo 		= $postData['hesapNo'];
	$raporPath		= $postData['path_rapor_0_1'];
	$raporFile 		= $postData['filename_rapor_0_1'];
	$rapor			= $raporPath.$raporFile;
	$sonuc			= ($postData['sonuc']!= 'Seçiniz')?$postData['sonuc']:null;
	$sonucAciklama 	= $postData['sonucAciklama'];
	$denetimSuresi 	= $postData['denetimSuresi'];
	$yatirildimi    = ($postData['yatirildimi']!= 'Seçiniz')?$postData['yatirildimi']:null;;

	$denetimId = $postData['denetimId'];

//	$sql = "INSERT INTO M_DENETIM
//			VALUES(?, ?, TO_DATE(?,'dd.mm.yyyy'), ?, ?, ?, ?)";

	$sql = "UPDATE M_DENETIM SET 
	
			DENETIM_KURULUS_ID = ?,
			DENETIM_TARIHI = TO_DATE(?, 'dd.mm.yyyy'),
			DENETIM_HESAP_NO = ?,
			DENETIM_SONUC_ID = ?,
			DENETIM_SONUC_ACIKLAMA = ?,
			DENETIM_RAPOR_PATH = ?,
			DENETIM_SURESI = ?,
			DENETIM_UCRETI_YATTI_MI = ?
			
			WHERE DENETIM_ID = ?";

	$params = array($kurulus, $tarih, $hesapNo, $sonuc, $sonucAciklama, $rapor,
			$denetimSuresi, $yatirildimi, $denetimId);

	$bilgiValues = FormFactory::getTableValues($postData, array("denetimEkibi", 2));

	$db->prep_exec_insert($sql, $params);

//	echo '<pre>';
//	print_r($bilgiValues);
//	echo '</pre>';
	
	// eski personel kayıtlarını sil
	$sql = "DELETE FROM M_DENETIM_EKIP WHERE DENETIM_ID = ?";
	$db->prep_exec_insert($sql, array($denetimId));
	

	$sql = "INSERT INTO M_DENETIM_EKIP VALUES (? ,?, ?, ?)";

	for($i = 0; $i < count ($bilgiValues)/2; $i++){
		$personel_id = $db->getNextVal(DENETIM_PERSONEL_ID_SEQ);
		$id = $i * 2;
		$ad = $bilgiValues[$id];
		$soyad = $bilgiValues[$id+1];
		$db->prep_exec_insert($sql, array($denetimId, $personel_id, $ad, $soyad));
	}
	
	global $mainframe;
	$mainframe->redirect('index.php?option=com_denetim_duzenle&denetimId='.$denetimId, JText::_('DEGISIKLIKLER_KAYDEDILDI'));

}

function getDenetim($db, $denetimId){
	$sql = "SELECT 	DENETIM_ID,
					DENETIM_KURULUS_ID,
					TO_CHAR(DENETIM_TARIHI, 'dd.mm.yyyy') AS DENETIM_TARIHI_F,
					DENETIM_HESAP_NO,
					DENETIM_SONUC_ID,
					DENETIM_SONUC_ACIKLAMA,
					DENETIM_RAPOR_PATH,
					DENETIM_SURESI,
					DENETIM_UCRETI_YATTI_MI
						FROM M_DENETIM WHERE DENETIM_ID = ?";
	$denetimler = $db->prep_exec($sql, array($denetimId));
	if(isset($denetimler[0]))
		return $denetimler[0];
	return FALSE;
}

function getDenetciPersoneller($db, $denetimId){
	$sql = "SELECT PERSONEL_AD, PERSONEL_SOYAD FROM M_DENETIM_EKIP WHERE DENETIM_ID = ?";
	$personeller = $db->prep_exec($sql, array($denetimId));
	return $personeller;
}

$db = & JFactory::getOracleDBO();

$gorev = isset($_POST['gorev']) ? $_POST['gorev'] : "goster";
$denetimId = isset($_GET['denetimId']) ? $_GET['denetimId'] : "";

if($gorev == "goster"){
	
	$denetimRow = getDenetim($db, $denetimId);

	//$personeller = getPersonel($db);
	$kuruluslar = getKuruluslar($db, $denetimRow['DENETIM_KURULUS_ID']);
	$denetimSonuc = getDenetimSonuclar($db, $denetimRow['DENETIM_SONUC_ID']);
	$denetciler = getDenetciPersoneller($db, $denetimId);
	
	//formGoster($kuruluslar, $personeller, $denetimSonuc, $denetimRow);
	formGoster($kuruluslar, $denetimSonuc, $denetimRow);
	
}
else if($gorev == "kaydet"){
		
	denetimKaydet($db, $_POST);
}



function formGoster($kuruluslar, $denetimSonuc, $denetimRow){
	?>

<script type="text/javascript">
	dTables.denetimEkibi = new Array(new Array("text","required", "30"), new Array("text","required", "30"));

	dTables.rapor = new Array(new Array("upload"));
	
	</script>
<form method="POST" action="index.php?option=com_denetim_duzenle"
	id="denetim_form" onSubmit="return validate('denetim_form')">
	<input type="hidden" name="gorev" value="kaydet"></input>
	<input type="hidden" name="denetimId" value="<?php echo $denetimRow['DENETIM_ID']?>"></input>
<table>
	<tr>
		<td>Denetim Yapılan Kuruluş</td>
		<td><select name="kurulus">
			<option value="Seçiniz">Seçiniz</option>
			<?php echo $kuruluslar?>
		</select></td>
	</tr>
	<tr>
		<td>Denetim Tarihi</td>
		<td><input type="text" id="inputdenetim_tarihi" name="denetim_tarihi"
			size="10" value="<?php echo $denetimRow['DENETIM_TARIHI_F']?>" class="required date"> <input type="button" value="..."
			id="denetim_tarihi_button"></input>(GG.AA.YYYY)</td>
	</tr>
	<tr>
		<td>Denetim Süresi</td>
		<td><input type="text" name="denetimSuresi" value="<?php echo $denetimRow['DENETIM_SURESI']?>"  size="10"></td>
	</tr>
	<tr>
		<td>DENETİM EKİBİ</td>
		<td>
		<div id="denetimEkibi_div"></div>
		</td>
	</tr>
	<tr>
		<td>DENETİM MASRAF KARŞILIĞI /HESAP NUMARASI</td>
		<td><input type="text" value="<?php echo $denetimRow['DENETIM_HESAP_NO']?>" name="hesapNo"></input></td>
	</tr>
	<tr>
		<td>MASRAF YATIRILDI MI?</td>
		<td><select name="yatirildimi">
			<option value="Seçiniz">Seçiniz</option>
			<option value="0" <?php echo $denetimRow['DENETIM_UCRETI_YATTI_MI'] == '0' ? 'selected="selected"':''?>>Hayır</option>
			<option value="1" <?php echo $denetimRow['DENETIM_UCRETI_YATTI_MI'] == '1' ? 'selected="selected"':''?>>Evet</option>		
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
		<td><input type="text" name="sonucAciklama" value="<?php echo $denetimRow['DENETIM_SONUC_ACIKLAMA']?>"></input></td>
	</tr>
</table>

<br />
<input type="submit" value="Kaydet"></input></form>
<script type="text/javascript">
	function createTables(){
		createTable('denetimEkibi',new Array ('Personel Adı', 'Soyadı'));
		personelleriEkle();

		tableName = "rapor";
		createTable(tableName, new Array(''));
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 0);
		addRapor (tableName);
	}

	function addRapor (tableName){
		<?php
		$path = $denetimRow["DENETIM_RAPOR_PATH"];	
		echo "var path = '".FormFactory::normalizeVariable ($path)."';";
		echo "var fileName = '".FormFactory::getNormalFilename(basename  ($path))."';";
		?>
		if (path != null && path != ''){
			var id		 = tableName + "_0";
			var resultDiv 	= document.getElementById(id + "_result_div_1");
			var inputPath = '<input type="hidden" value="'+path+'" name="path_'+id+'_1">' +
							'<input type="hidden" value="" name="filename_'+id+'_1">';				
				
			var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
			result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\'1\')" /></div>';
			resultDiv.innerHTML = result;
		
			var uploadSpan = document.getElementById(id + "_upload_form_span_1");
			uploadSpan.style.visibility = 'hidden';
			uploadSpan.style.height = 0;
		}
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

cal.manageFields("denetim_tarihi_button", "inputdenetim_tarihi", "%d.%m.%Y");
      
//]]></script>

<script type="text/javascript">

function personelleriEkle(){
	var i = 1;
	
	<?php 
		foreach($denetciler AS $denetci){
			?>
			if(i != 1)
				addNRow('denetimEkibi','2','denetimEkibi');
			
			inp = document.getElementById('inputdenetimEkibi-1-'+i);
			inp.value="<?php echo $denetci['PERSONEL_AD']?>";
			inp = document.getElementById('inputdenetimEkibi-2-'+i);
			inp.value="<?php echo $denetci['PERSONEL_SOYAD']?>";
			i++;
			<?php
		}
	
	?>
	
}

</script>
