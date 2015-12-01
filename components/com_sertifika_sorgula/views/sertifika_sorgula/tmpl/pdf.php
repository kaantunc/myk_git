<?php
defined('_JEXEC') or die('Restricted access');

$db = JFactory::getOracleDBO();

$birimler = array();
$data = $this->data;
$logo = $this->logo;
$serid = $_GET["ser_id"];
$say = 0;

foreach($data as $cows){
	if($cows["SERTIFIKA_BASVURU_ID"] == $serid){
		$ogrenci = $cows["OGRENCI_ADI"]." ".$cows["OGRENCI_SOYADI"];
		$adi = $cows["OGRENCI_ADI"];
		$soyadi = $cows["OGRENCI_SOYADI"];
		$yeterlilik = $cows["YETERLILIK_ADI"];
		$seviye = "Seviye ".$cows["SEVIYE_ID"];
		$yet_kod = $cows["YETERLILIK_KODU"];
		$sert_no = $cows["SERTIFIKA_NO"];
		$yetkili = $cows["YETKILI"];
		$unvan = $cows["UNVAN"];
		$baba = $cows["OGRENCI_BABA_ADI"];
		$dog_tarih = $cows["OGRENCI_DOGUM_TARIHI"];
		$dog_yer = $cows["OGRENCI_DOGUM_YERI"];
		$tc = $cows["TC_KIMLIK"];
		$sinav_tar = $cows["SINAV_TARIHI"];
		$belge_duz = $cows["SERTIFIKA_DUZENLENME_TARIHI"];
		$belge_gec = $cows["SERTIFIKA_GECERLILIK_TARIHI"];
		$user_id = $cows["USER_ID"];
		$ogrcik = $cows["OGRENME_CIKTI"];
		$yetId = $cows["YETERLILIK_ID"];
		$rev_no = $cows["REVIZYON_NO"];
		$rev_yet = $cows["REV_YETERLILIK_KODU"];
		$revyay_tar = $cows["REV_YAYIN_TARIHI"];
		$rev_tar = $cows["REVIZYON_TARIHI"];
		break;
	}
}

$cikti ="<ul>";
$fikti = explode('.', $ogrcik);
foreach ($fikti as $cows){
	$cikti .= "<li>".$cows."</li>";
}
$cikti .= "</ul>";
$tablePadding	= 3;
$kur_log = EK_FOLDER.'kurulus_logo/'.$user_id.'/'.$logo;
$kurum_log = EK_FOLDER.'kurulus_logo/myk/MYKlogo2.jpg';

$sqlkurum = "SELECT KURUM_KISI, KURUM_UNVAN FROM M_SERTIFIKA_BASVURU WHERE SERTIFIKA_BASVURU_ID = ?";
$kurumyetkili = $db->prep_exec($sqlkurum, array($serid));

foreach($data as $cows){
	if($cows["SERTIFIKA_BASVURU_ID"] == $serid && $cows["YENI_MI"] == 0){
			if(!in_array($cows["BIRIM_ADI"], $birimler["birim_adi"])){
				$birimler["birim_adi"][] = $cows["BIRIM_ADI"];		
				$birimler["birim_kodu"][] = $cows["BIRIM_KODU"].'/'.$cows["BIRIM_NO"];
				$say++;
			}
	}
	else if($cows["SERTIFIKA_BASVURU_ID"] == $serid && $cows["YENI_MI"] == 1){
		if(!in_array($cows["BIRIM_ADI"], $birimler["birim_adi"])){
			$birimler["birim_adi"][] = $cows["BIRIM_ADI"];
			$birimler["birim_kodu"][] = $cows["BIRIM_KODU"];
			$say++;
		}
	}
}

function getMerkezAdi($merkezler, $id){
	foreach($merkezler AS $merkezRow)
		if($merkezRow['MERKEZ_ID'] == $id)
			return $merkezRow['MERKEZ_ADI'];
	return FALSE;
}

function getYetAdi($yeterlilikler, $id){
	foreach($yeterlilikler AS $yetRow)
		if($yetRow['YETERLILIK_ID'] == $id)
			return $yetRow['YETERLILIK_ADI'];
	return FALSE;
}

function getAltBirimAdi($altbirimler,$sekiller, $id){
	$ekle='';
	$say = count($altbirimler[$id]);
	for($ii = 0; $ii < $say; $ii++){
		if(strlen($sekiller[$id][$ii]) > 0){
			if($sekiller[$id][$ii] == 0){
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Teorik)</p>';
			}
			else{
				$ekle .= '<p>'.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['YETERLILIK_ALT_BIRIM_NO'].' / Pratik)</p>';
			}
		}
		else{
			$ekle .= '<p>'.$altbirimler[$id][$ii][0]['BIRIM_ADI'].'('.$altbirimler[$id][$ii][0]['BIRIM_KODU'].'/'.$altbirimler[$id][$ii][0]['OLC_DEG_HARF'].$altbirimler[$id][$ii][0]['OLC_DEG_NUMARA'].')</p>';
		}
	}
	return $ekle;
	return FALSE;
}

function turkce_sirala($a, $b) {
	$turkce = array('ç' => 'c', 'ğ' => 'g', 'ı' => 'i', 'ö' => 'o',
			'ş' => 's', 'ü' => 'u', 'Ç' => 'C', 'Ğ' => 'G',
			'İ' => 'I', 'Ö' => 'O', 'Ş' => 'S', 'Ü' => 'U');

	$a = preg_replace("/(ı|ğ|ü|ş|ö|ç|Ğ|Ü|Ş|İ|Ö|Ç)/e", "\$turkce['\\1'].'~'", $a);
	$b = preg_replace("/(ı|ğ|ü|ş|ö|ç|Ğ|Ü|Ş|İ|Ö|Ç)/e", "\$turkce['\\1'].'~'", $b);

	if ($a == $b)
		return 0;

	return ($a < $b) ? -1 : 1;
}


?>
<?php 

echo tableHTML2("null",$kur_log, $kurum_log);
echo '<br/>';
echo '<div style="font-family: Bookman Old Style; font-size: 26; text-align:center; color:gray;" >
	<strong>MESLEKİ YETERLİLİK BELGESİ</strong>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>';

echo '<div style="font-family: Calibri; font-size: 24; text-align:center;">
	<strong>'.$ogrenci.'</strong>
</div>
<br/>
<br/>';

echo '<div style="font-family: Calibri; font-size: 20; text-align:center;">
	<strong>'.$yeterlilik.'</strong>
</div>';

echo '<div style="font-family: Calibri; font-size: 18; text-align:center;">
	<strong>'.$seviye.'</strong>
</div>';

echo '<div style="font-family: Calibri; font-size: 16; text-align:center;">
	(Kod: '.$yet_kod.')
</div>
<br/>';

echo '<div style="font-family: Calibri; font-size: 15; text-align:center;">
Ulusal yeterliliğinde teorik ve uygulamalı sınavlarda başarılı olarak
<br/><strong>'.substr($yet_kod,2).' / '.$sert_no.'</strong> No.’lu bu belgeyi almaya hak kazanmıştır.
</div>
<br/>
<br/>
<br/>
<br/>
<br/>';

echo '<div style="font-family: Calibri; font-size: 12; text-align:center;">
	<table>
		<thead>
			<tr>
				<th>'.$yetkili.'</th>
				<th>'.$kurumyetkili[0]["KURUM_KISI"].'</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>'.$unvan.'</td>
				<td>'.$kurumyetkili[0]["KURUM_UNVAN"].'</td>
			</tr>
		</tbody>
	</table>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>';

echo '<div style="font-family:Times New Roman; font-size: 10;">
Bu belge, 21/9/2006 tarih ve 5544 sayılı Mesleki Yeterlilik Kurumu Kanununa dayanılarak düzenlenmiştir. Belge kapsamı ile ilgili bilgiler ve kullanımına ilişkin şartlar arka sayfadadır.
</div><br/><br/>';


echo '<div>';
//echo borderBegin2();
echo borderBegin();
//echo '<table nobr="true" cellpadding="10" width="1950px">
echo '<table nobr="true" cellpadding="5" width="1950px">			
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Kimlik Bilgileri</strong></th>
				</tr>
				<tr>
					<td>
						<table border="1" nobr="true">
							<tr>
								<td>Adı																						 :'.$adi.'</td>
								<td>Baba Adı													 :'.$baba.'</td>
							</tr>
							<tr>
								<td>Soyadı														 	  :'.$soyadi.'</td>
								<td>Doğum Tarihi       :'.$dog_tarih.'</td>	
							</tr>
							<tr>
								<td>TC. Kimlik No			  :'.$tc.'</td>
								<td>Doğum Yeri								 :'.$dog_yer.'</td>
							</tr>
						</table>
					</td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Belgelendirme Bilgileri</strong></th>
				</tr>
				<tr>
					<td>
						<table border="1" nobr="true">
							<tr>
								<td>Sınav tarihi									              :<strong>'.$sinav_tar.'</strong></td>
								<td>Belge düzenleme tarihi							:<strong>'.$belge_duz.'</strong></td>
							</tr>
							<tr>
								<td>Belge geçerlilik tarihi							:<strong>'.$belge_gec.'</strong></td>
								<td>Belge No.										                  :<strong>'.$sert_no.'</strong></td>
							</tr>
						</table>
					</td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10;"><strong>İşbu Belgenin Dayandığı Yeterliliğin</strong></th>
				</tr>
				<tr>
					<td>
						<table border="1" nobr="true"><tr>';
							if(!empty($revyay_tar) || $revyay_tar != null){
								echo '<td>Yayımlanma tarihi     :'.$revyay_tar.'</td>';
							}
							else{
								echo '<td>Yayımlanma tarihi     :.....</td>';
							}
							if(!empty($rev_yet) || $rev_yet != null){
								echo '<td>Referans Kodu       :'.$rev_yet.'</td>';
							}
							else{
								echo '<td>Referans Kodu       :.....</td>';
							}
echo							'</tr>
							<tr>';
							if(!empty($rev_tar) || $rev_tar != null){
								echo '<td>Revizyon Tarihi									:'.$rev_tar.'</td>';
							}
							else{
								echo '<td>Revizyon Tarihi									:.....</td>';
							}
							if(!empty($rev_no) || $rev_no != null){
								echo '<td>Revizyon No:									:'.$rev_no.'</td>';
							}
							else{
								echo '<td>Revizyon No:									:.....</td>';
							}
							
echo	'</tr></table>
					</td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10;"><strong>İşbu Belgenin Yeterlilik Birimleri</strong></th>
				</tr>
				<tr>
					<td>
						<table border="1" nobr="true">
							<thead>
								<tr>
									<th width="80%"><strong>Yeterlilik birim adı</strong></th>
									<th width="20%" align="center"><strong>Kodu</strong></th>
								</tr>
							</thead>
							<tbody>
							'; 
							for($ii = 0; $ii < $say; $ii++)
							{
								echo '<tr><td width="80%">'.$birimler["birim_adi"][$ii].'</td><td width="20%" align="left">'.substr($birimler["birim_kodu"][$ii], 2).'</td></tr>';
							}
							echo '
							</tbody>
						</table>
					</td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Sınav Bilgileri ve Yeterlilik Kapsamı</strong></th>
				</tr>
				<tr>
							<td>İşbu belgenin adına düzenlendiği kişinin kaynakçı yeterlilik sınavıyla ilgili sınav parçası, yeterlilik kapsamı ve sınav parçasının muayenelerine ilişkin bilgiler sınav ve belgelendirme işlemlerini gerçekleştiren yetkilendirilmiş kuruluş tarafından düzenlenen belgede verilmektedir.</td>
				</tr>
		</table>
		</td>
		</tr>				
		<tr>
		<td>
		<table nobr="true" cellpadding="0" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Belgelendirilen Kişinin Yeterliliğine İlişkin Öğrenme Çıktıları</strong></th>
				</tr>
				<tr>
							<td>'.$cikti.'</td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Belgelendirilen Kişinin Yükümlülükleri</strong></th>
				</tr>
				<tr>
							<td><p>Bu belgenin adına düzenlendiği kişi,  '.$yeterlilik.' Ulusal Yeterliliğinde yer alan gözetim şartlarına uymadığı durumda belgenin geçersiz kılınabileceğini kabul eder.</p></td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Ulusal Meslekî Yeterlilik Sistemi</strong></th>
				</tr>
				<tr>
						<td><p>Ulusal ve uluslararası meslek standartlarını temel alarak teknik ve meslekî eğitim standartlarının ve yeterliliklerin geliştirilmesi, uygulanması ve bunlara ilişkin akreditasyon, yetkilendirme, denetim, ölçme, değerlendirme ve belgelendirmeye ilişkin kural ve faaliyetleri kapsayan adil, şeffaf ve güvenilir bir sistemdir.</p></td>
				</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table nobr="true" cellpadding="5" width="1950px">		
				<tr>
					<th style="font-family: Times New Roman; font-size:10; text-align:center;"><strong>Mesleki Yeterlilik Seviyeleri ve Avrupa Yeterlilikler Çerçevesi (AYÇ) Referans Seviyeleri</strong></th>
				</tr>
				<tr>
					<td><p>30 Aralık 2008 tarihli ve 27096 sayılı Resmî Gazete’de yayımlanan Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğine göre hazırlanmış olan ulusal yeterliliklerin seviyeleri, Avrupa Birliği tarafından benimsenen yeterlilik esaslarına ve AYÇ’ye uyumludur. AYÇ sekiz ana yeterlilik seviyesinden oluşur ve her bir seviye belli bilgi, beceri ve yetkinlikleri içerir. Genel olarak, seviye ne kadar artarsa, kişiden beklenen bilgi, beceri ve yetkinlikler de bu oranda artmaktadır. İşbu belgenin düzenlendiği <?php echo $seviye;?>. Seviye yeterlilikler; “Çalışan görevlerin tamamlanmasıyla ilgili sorumluluk alır ve problemlerin çözümünde kendi davranışlarını ortama uyarlar.“ şeklinde tanımlanmaktadır.</p></td>
				</tr>
		</table>
		';
echo borderEnd();
//echo borderEnd();
echo '</div><div width="2000px"><table nobr="true" width="2000px" cellpadding="20"><tr><th align="center">http://www.myk.gov.tr</th></tr></table></div>';


function divHTML ($data){
	return "<div><dt> </dt><dd>".FormFactory::ignoreBreaks($data)."</dd></div>";
}

function  borderBegin (){
	return '<table nobr="true" width="2000px" border="1" cellpadding="20" ><tr><td>';
}

function  borderBegin2(){
	return '<table nobr="true" border="1" width="2050px" cellpadding="20" ><tr><td>';
}

function  borderEnd(){
	return '</td></tr></table>';
}

function blockTitle ($title, $align="left", $tab = 1){
	$titleHTML = '<h3 style="font-size:15px;text-align:'.$align.'">'.$title.'</h3>';
	if ($tab)
	return '<dt> </dt><dd>'.$titleHTML.'</dd>';
	else
	return $titleHTML;
}

function tableHTML ($title, $data, $width=120, $tab = 1){
	$table = '<table nobr="true" cellpadding="'.$tablePadding.'">
					<tr >
						<td width="'.$width.'">'.$title.'</td>
						<td >'.$data.'</td>
				  	</tr>
			  	</table>';

	if ($tab)
	return "<dt> </dt><dd>".$table."</dd>";
	else
	return $table;
}

function tableHTML2 ($title, $data, $data2){
	$table = '<table nobr="true" cellpadding="50">
					<tr>
						<td align="left"><img src="'.$data.'" height="286.74px" width="661.98px"/></td>
						<td align="right"><img src="'.$data2.'" height="286.74px" width="661.98px"/></td>
				  	</tr>
			  	</table>';
	
	return $table;
}
?>
