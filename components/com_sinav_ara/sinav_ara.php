<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/captcha.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

global $mainframe;
$session =& JFactory::getSession();

captcha::check("index.php?option=com_chronocontact&Itemid=195");

//Security Code Check
////////////////////////////////////////////////////
//$code = $session->get('security_code');
//$v_code = JRequest::getVar('verify_code');
//if(($code != $v_code )) {
//	$message = "Doğrulama Kodunu yanlış girdiniz. Lütfen tekrar deneyin.";
//	$mainframe->redirect("index.php?option=com_chronocontact&Itemid=195", $message);
//}
//////////////////////////////////////////////////


if(!isset($_POST['kimlik_no'])){
	
	echo "Hata oluştu.";
	
}

else {

	$kimlikNo = $_POST['kimlik_no'];
	
	$db = & JFactory::getOracleDBO();
	
	$sonuclar = kimlikNoIleAraGenel($db, $kimlikNo);
	
	$rv = sinavSonuclariniGoster($sonuclar);
	
	if($rv==-1)
		echo '<div class="sonucBulunamadi">Sonuç bulunamadı.</div>';

}

/*function OgrBilgi($sinavsonuc, $ogr, $rowCount, $rowClass){
	$ekle = '';
	$say = count($ogr);
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			$say++;
		}
	}
	foreach($sinavsonuc as $sonuc){
		if($sonuc[0]['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			$ekle .='<tbody><tr class="'.$rowClass.'" style="text-align:center;">
			<td rowspan = "'.$say.'"></td>
			<td rowspan = "'.$say.'">'.$rowCount.'</td>
			<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_KAYIT_NO'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['TC_KIMLIK'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_SOYADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_TARIHI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_DOGUM_YERI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['OGRENCI_BABA_ADI'].'</td>
				<td rowspan = "'.$say.'">'.$sonuc['YETERLILIK_ADI'].'</td>';
			return $ekle;
		}
	}
}

function Birimler($sinavsonuc, $ogr, $rowClass){
	$ekle = '';
	foreach($sinavsonuc as $sonuc){
		if($sonuc['TC_KIMLIK'] == $ogr['TC_KIMLIK']){
			if($sonuc['YENI_MI'] == 0){
				if($sonuc['SEKIL'] == 0){
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Teorik)</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr><tr class="'.$rowClass.'" style="text-align:center;">';
				}
				else{
					$ekle .= '<td>'.$sonuc['YETERLILIK_ALT_BIRIM_ADI'].'('.$sonuc['YETERLILIK_ALT_BIRIM_NO'].'/ Pratik)</td>
					<td>'.$sonuc['ALDIGI_NOT'].'</td>
					<td>'.$sonuc['SINAV_TARIHI'].'</td>
					<td>'.$sonuc['SINAV_SAAT'].'</td>
					<td>'.$sonuc['MERKEZ_ADI'].'</td>
					<td>'.$sonuc['GOZETMEN'].'</td>
					<td>'.$sonuc['DEGERLENDIRICI'].'</td>
					</tr>
					<tr class="'.$rowClass.'" style="text-align:center;">';
				}
			}
			else{
				$ekle .= '<td>'.$sonuc['BIRIM_ADI'].'('.$sonuc['BIRIM_KODU'].'/	'.$sonuc['OLC_DEG_HARF'].')</td>
				<td>'.$sonuc['ALDIGI_NOT'].'</td>
				<td>'.$sonuc['SINAV_TARIHI'].'</td>
				<td>'.$sonuc['SINAV_SAAT'].'</td>
				<td>'.$sonuc['MERKEZ_ADI'].'</td>
				<td>'.$sonuc['GOZETMEN'].'</td>
				<td>'.$sonuc['DEGERLENDIRICI'].'</td>	
				</tr><tr class="'.$rowClass.'" style="text-align:center;">';
			}
		}
	}
	return $ekle.'</tr>';
}
*/
function sinavSonuclariniGoster($sonuclar){
	
	if(empty($sonuclar[0])){
		return -1;
	}
	else{
		?>
		<div class="tableWrapper">
		<h1>Sınav Sonuçları</h1>
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-date-dmy">Tarih</th>
				<th class="sortable-text">Sınav Saati</th>
				<th class="sortable-text">Merkez_adı</th>
				<th class="sortable-text">Yeterlilik</th>
				<th class="sortable-text">Birim Adı</th>
				<th class="sortable-text">Sınav Şekli</th>
				<th class="sortable-numeric">Aldığı Not</th>
				<th class="sortable-text">Durum</th>
			</tr>
			
			<?php
				$rowCount=1;
				$rowClass="";
				for($ii = 0; $ii < count($sonuclar[1]); $ii++){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
					
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.$sonuclar[0][$ii]['SINAV_TARIHI'].'</td>';
					echo '<td>'.$sonuclar[0][$ii]['SINAV_SAAT'].'</td>';
					echo '<td>'.$sonuclar[0][$ii]['MERKEZ_ADI'].'</td>';
					echo '<td>'.$sonuclar[0][$ii]['YETERLILIK_ADI'].'</td>';
					echo '<td>'.$sonuclar[1][$ii][0]['BIRIM_ADI'].'</td>';
					if(strlen($sonuclar[0][$ii]['SEKIL']) > 0){
						if($sonuclar[0][$ii]['SEKIL'] == 0){
							echo '<td>'.$sonuclar[0][$ii]['YETERLILIK_KODU'].'/'.$sonuclar[1][$ii][0]['BIRIM_NO'].' PRATİK</td>';
						}
						else{
							echo '<td>'.$sonuclar[0][$ii]['YETERLILIK_KODU'].'/'.$sonuclar[1][$ii][0]['BIRIM_NO'].' TEORİK</td>';
						}
					}
					else{
						if($sonuclar[1][$ii][0]["OLC_DEG_HARF"] == "P")
							echo '<td>'.$sonuclar[1][$ii][0]['BIRIM_KODU'].'/ PRATİK</td>';
						else
							echo '<td>'.$sonuclar[1][$ii][0]['BIRIM_KODU'].'/ TEORİK</td>';
					}
					echo '<td>'.$sonuclar[0][$ii]['ALDIGI_NOT'].'</td>';
					echo '<td>'.$sonuclar[0][$ii]['SINAV_DURUM_ADI'].'</td>';
					//echo '<td>'.$satir['SINAV_DURUM_ID'].'</td>';
					echo '</tr></tbody>';
					$rowCount++;
				}
				/*foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					echo '<td>'.getStr($satir['TARIH']).'</td>';
					echo '<td>'.getStr($satir['SINAV_SAAT']).'</td>';
					echo '<td>'.getStr($satir['YETERLILIK_ADI']).'</td>';
					echo '<td>'.getStr($satir['YETERLILIK_ALT_BIRIM_ADI']).'</td>';
					echo '<td>'.getStr($satir['ALDIGI_NOT']).'</td>';
					echo '<td>'.getStr($satir['SINAV_DURUM_ADI']).'</td>';
					//echo '<td>'.$satir['SINAV_DURUM_ID'].'</td>';
					echo '</tr>';
					$rowCount++;
				}*/
			?>
		</table>
		</div>
		<a href="javascript:history.go(-1)">Geri</a>
		<?php
		return 0;
	}
}

function getStr($val){
	return $val ? $val : '-';
}

function kimlikNoIleAraGenel($db, $kimlikNo){
	$sonuc = array();
	$karams = array();
	$sql = "SELECT  M_SINAV_SONUCU.TC_KIMLIK, M_SINAV.USER_ID, M_SINAV.EVRAK_ID, M_SINAV_SONUCU.M_SINAV_ID, 
			        M_SINAV.SINAV_TARIHI, M_SINAV.SINAV_SAAT, M_SINAV.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.SEVIYE_ID,
			        M_SINAV_SONUCU.ALT_BIRIM_ID, M_SINAV_SONUCU.SEKIL, M_YETERLILIK.YENI_MI, M_SINAV_MERKEZI.MERKEZ_ID, M_SINAV_MERKEZI.MERKEZ_ADI, 
			        PM_SINAV_DURUM.SINAV_DURUM_ADI, M_SINAV_SONUCU.ALDIGI_NOT
				FROM M_SINAV_SONUCU
				JOIN M_SINAV ON M_SINAV_SONUCU.M_SINAV_ID = M_SINAV.M_SINAV_ID
		        JOIN M_SINAV_MERKEZI ON M_SINAV.MERKEZ_ID = M_SINAV_MERKEZI.MERKEZ_ID
		        JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				JOIN PM_SINAV_DURUM ON M_SINAV_SONUCU.SINAV_DURUM_ID = PM_SINAV_DURUM.SINAV_DURUM_ID
				WHERE M_SINAV_SONUCU.TC_KIMLIK = ?
				ORDER BY M_SINAV.SINAV_TARIHI";

	$sinavlar = $db->prep_exec($sql, array($kimlikNo));
	
	foreach($sinavlar as $rows){
		if($rows["YENI_MI"] == 0){
			$yenimi = "SELECT YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO,
						 YETERLILIK_ID
						FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ALT_BIRIM_ID = ?";
			$karams[] = $db->prep_exec($yenimi, array($rows["ALT_BIRIM_ID"]));
		}
		else{
			$yenimi = "SELECT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, BAGIMLI_OLDUGU_YET_ID AS YETERLILIK_ID,
			OLC_DEG_HARF, OLC_DEG_NUMARA
			FROM M_BIRIM JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) WHERE ID = ?";
			$karams[] = $db->prep_exec($yenimi, array($rows["ALT_BIRIM_ID"]));
		}
	}
	$sonuc[] = $sinavlar;
	$sonuc[] = $karams;
	return $sonuc;
}

?>