<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$evrak_id	 = $this->evrak_id;
$title 		 = $this->title;
$kurulus 	 = $this->kurulus;
$iller 		 = $this->iller;
$irtibat	 = $this->irtibat;
$sektor		 = $this->sektor;
$faaliyet	 = $this->faaliyet;
$basvuru	 = $this->basvuru;
$bagliKurulus	 = $this->bagliKurulus;
$birlikteKurulus = $this->birlikteKurulus;
$meslek		 	 = $this->meslek; 
$personel 		= $this->personel;			
$egitim 		= $this->egitim;			
$sertifika 		= $this->sertifika;			
$isDeneyim 		= $this->isDeneyim;			
$dil 			= $this->dil;

?>
<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">
	  
	<input type="hidden" value="<?php echo $evrak_id;?>" name="evrak_id">
	<input type='hidden' value='1' name='2306e6467a830d886ea16ea1849f7ff5'/>	
	<input type='hidden' value='e84ad33046067593b8356745abbdd473' name='1cf1'/>

	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1);'/>
			<input type='button' name='bitirUst' value='Bitir' onClick='formSubmitted(2);'/>
		</div>
		
		<div style="clear:both;"></div>
	</div>
	
	<div class='form_element'>
		<h1 class='contentheading'><?php echo $title;?></h1>
		<div style="clear:both;"></div>	
		<?php 
		echo blockTitle ("Kuruluşun");
		
		//KURULUS BILGILERI
		echo statikTabloHTML ("Adı"				, $kurulus["KURULUS_ADI"]);
		echo statikTabloHTML ("Statüsü"			, $kurulus["KURULUS_STATU_ADI"]);
		echo statikTabloHTML ("Yetkilisi"		, $kurulus["KURULUS_YETKILISI"]);	
		echo statikTabloHTML ("Yetkili Unvanı"	, $kurulus["KURULUS_YETKILI_UNVANI"]);
		echo spacer ();
		echo statikTabloHTML ("Adresi"			, $kurulus["KURULUS_ADRESI"]);
		echo statikTabloHTML ("Posta Kodu"		, $kurulus["KURULUS_POSTA_KODU"]);
		echo statikTabloHTML ("Şehir"			, $kurulus["IL_ADI"]);
		echo spacer ();
		echo statikTabloHTML ("Telefon"			, $kurulus["KURULUS_TELEFON"]);
		echo statikTabloHTML ("Faks"			, $kurulus["KURULUS_FAKS"]);
		echo statikTabloHTML ("E-Posta"			, $kurulus["KURULUS_EPOSTA"]);
		echo statikTabloHTML ("Web"				, $kurulus["KURULUS_WEB"]);
		echo spacer ();
		echo statikTabloHTML ("Faaliyette Bulunduğu İller"	, implode($iller, " , "));
		
		//IRTIBAT BILGILERI
		echo "<br>";
		echo blockTitle ("İrtibat Bilgileri");
		$irtibatCount = count($irtibat);

		for ($i = 0; $i < $irtibatCount; $i++){
			$data = $irtibat [$i];
			
			echo statikHTML 	 ("İrtibat Kurulacak Kişinin", null);
			echo statikTabloHTML ("Adı Soyadı", $data["IRTIBAT_KISI_ADI"]);
			echo statikTabloHTML ("E-Posta"	  , $data["IRTIBAT_EPOSTA"]);
			echo statikTabloHTML ("Telefon"	  , $data["IRTIBAT_TELEFON"]);	
			echo statikTabloHTML ("Faks"	  , $data["IRTIBAT_FAKS"]);
			
			if ($i+1 < $irtibatCount)
				echo spacer();
		}
		
		//FAALIYET BILGILERI
		echo "<br>";
		echo blockTitle ("KURULUŞUN");
		//Sektor
		$titles   = array ("Faaliyet Gösterdiği Sektör(ler)", "Faaliyet Gösterdiği Sektör(ler)", "Açıklama");
		$tableIds = array ("SEKTOR_ADI", "SEKTOR_ACIKLAMA");
		echo tabloHTML ($titles, $tableIds, $sektor);
		
		//Faaliyet Alanları
		echo "<br>";
		$titles   = array ("Faaliyet Alanları", "Faaliyet Alanları");
		$tableIds = array ("FALIYET_ALAN_ADI");
		echo tabloHTML ($titles, $tableIds, $faaliyet);

		//Faaliyet Suresi
		echo "<br>";
		echo statikTabloHTML ("Faaliyet Süresi"	, $basvuru["FALIYET_SURE_ADI"]);
		
		//Bagli Kurulus
		echo "<br>";
		$titles   = array ("Kuruluş, Meslek / Sivil Toplum Kuruluşu ise", "Bağlı Kuruluş (Oda, Federasyon, Dernek, Sendika vb.) Adları");
		$tableIds = array ("BAGLI_KURULUS_ADI");
		echo tabloHTML ($titles, $tableIds, $bagliKurulus);
		
		echo "<br>";
		echo statikTabloHTML ("Üye (Gerçek kişi) Sayısı" , $basvuru["UYE_SAYISI"]);
		
		// Madde 5
		echo "<br>";
		echo statikHTML 	 ("5. Organizasyon seması ve toplam çalışan personel sayısı", null);
		echo statikTabloHTML ("Personel Sayısı", $basvuru["PERSONEL_SAYISI"]);

		//Madde 6 (Hazırlama Ekibi)
		echo "<br>";
		if ($basvuru["HAZIRLAMA_EKIBI"]){
			echo statikHTML ("6. Meslek standardı hazırlama ekibi oluşturulmuş mudur?", "Evet");
			echo statikHTML ("a1) Görevlendirilen ekipte bulunan personelin* meslek standardı geliştirme ve süreci koordine etme konusundaki yetkinliğini artırmak için planlanan kapasite geliştirme faaliyetleri vb. hususlar", $basvuru["EKIP_ACIKLAMA"]);
			echo statikHTML ("a2) Görevlendirilecek ekipteki kişi sayısı", $basvuru["EKIP_SAYISI"]);
		}else{
			echo statikHTML ("6. Meslek standardı hazırlama ekibi oluşturulmuş mudur?", "Hayır");
			echo statikHTML ("b) Meslek standardı hazırlama ekibi oluşturulmasına ve kapasite geliştirilmesine yönelik planlar", $basvuru["EKIP_ACIKLAMA"]);
		}
			
		//Madde 7 (Birlikte Kurulus)
		$kurulusCount = count ($birlikteKurulus);
		if ($kurulusCount > 0){
			echo "<br>";
			echo statikHTML ("7. Meslek standardı hazırlamada birlikte çalışılması planlanan kurum/kuruluş(lar) var mıdır?", "Evet");
			echo "<br>";
			
			for ($i = 0; $i < $kurulusCount; $i++){
				$data = $birlikteKurulus [$i];
				
				echo statikHTML 	 ("Kuruluşun" 	, null);
				echo statikTabloHTML ("Adı"		 	, $data["BIRLIKTE_KURULUS_ADI"]);
				echo statikTabloHTML ("Statüsü"	 	, $data["KURULUS_STATU_ADI"]);
				echo statikTabloHTML ("Yetkilisi"	, $data["BIRLIKTE_KURULUS_YETKILISI"]);	
				echo statikTabloHTML ("Adresi"	 	, $data["BIRLIKTE_KURULUS_ADRES"]);
				echo statikTabloHTML ("Şehir"		, $data["IL_ADI"]);
				echo statikTabloHTML ("Posta Kodu"	, $data["BIRLIKTE_KURULUS_POSTAKOD"]);
				echo statikTabloHTML ("Telefon"	  	, $data["BIRLIKTE_KURULUS_TELEFON"]);	
				echo statikTabloHTML ("Faks"	  	, $data["BIRLIKTE_KURULUS_FAKS"]);
				echo statikTabloHTML ("E-Posta"	  	, $data["BIRLIKTE_KURULUS_EPOSTA"]);
				echo statikTabloHTML ("Web"	  		, $data["BIRLIKTE_KURULUS_WEB"]);
				
				if ($i+1 < $kurulusCount)
					echo spacer();
			}
		}else{
			echo statikHTML ("7. Meslek standardı hazırlamada birlikte çalışılması planlanan kurum/kuruluş(lar) var mıdır?", "Hayır");
		}
		
		//Madde 8
		echo "<br>";
		echo statikHTML ("8. Meslek standardı hazırlama çalışmaları için mevcut / sağlanacak altyapı imkanları", $basvuru["ALTYAPI_ACIKLAMA"]);
		
		//Madde 9
		echo "<br>";
		if (($basvuru["DIS_ALIM_HIZMET"] != null) || ($basvuru["DIS_ALIM_TEDBIR"]!= null)){
			echo statikHTML ("9. Meslek standartlarının hazırlanması için dışarıdan hizmet alımı planlanıyor mu?", "Evet");
			echo statikHTML ("a) Alınması planlanan hizmetler", $basvuru["DIS_ALIM_HIZMET"]);
			echo statikHTML ("b) Alınacak hizmetlerin kalite güvencesine yönelik tedbirler", $basvuru["DIS_ALIM_TEDBIR"]);
		}else{
			echo statikHTML ("9. Meslek standartlarının hazırlanması için dışarıdan hizmet alımı planlanıyor mu? ", "Hayır");
		}

		//Madde 10
		echo "<br>";
		echo statikHTML ("10. Meslek standardı hazırlama sürecine ilgili tarafların (meslekle ilgili kamu kurumları, işçi, işveren, meslek örgütleri, eğitim sağlayıcılar) dahil edilmesi ve danışma sürecine ilişkin plan ve yöntemler", $basvuru["DANISMA_ACIKLAMA"]);
		
		//STANDART KAPSAMI
		echo "<br>";
		echo blockTitle ("Meslek Standardı Hazırlama Kapsamı/Planı");
		//Meslek Standartları
		$titles   = array ("11. Hazırlanması düşünülen meslek standartlarını lütfen belirtiniz", "Meslek", "Seviye", "Mesleğe ilişkin yasal düzenleme", "Mevcut meslek standardı çalışması", "Planlanan Meslek Standardı başlangıç tarihi", "Planlanan Meslek Standardı bitiş tarihi");
		$tableIds = array ("STANDART_ADI", "SEVIYE_ADI", "YASAL_DUZENLEME", "MEVCUT_CALISMA", "BASLANGIC_TARIHI", "BITIS_TARIHI");
		echo tabloHTML ($titles, $tableIds, $meslek);
		echo "<br>";
		
		echo statikHTML ("12. Bu mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren piyasa çalışması var mıdır?", $basvuru["PIYASA_ACIKLAMA"]);
		echo statikHTML ("13. Belirtilmek istenen diğer hususlar", $basvuru["DIGER_HUSUSLAR"]);
		
		if (count($personel) > 0){
			echo "<br>";
			echo blockTitle ("EK 1. MESLEK STANDARDI HAZIRLAMA EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center");
			for ($i = 0; $i < count($personel); $i++){
				echo statikTabloHTML ("1. Kişisel Bilgiler</strong>", null);
				echo statikTabloHTML ("T.C. Kimlik No / Pasaport No", $personel[$i]["GOREVLI_PERSONEL_KIMLIK_NO"]);
				echo statikTabloHTML ("Adı", $personel[$i]["GOREVLI_PERSONEL_ADI"]);
				echo statikTabloHTML ("Soyadı", $personel[$i]["GOREVLI_PERSONEL_SOYAD"]);
				echo statikTabloHTML ("Telefon", $personel[$i]["GOREVLI_PERSONEL_TELEFON"]);
				echo statikTabloHTML ("Faks", $personel[$i]["GOREVLI_PERSONEL_FAKS"]);
				echo statikTabloHTML ("E-Posta", $personel[$i]["GOREVLI_PERSONEL_EPOSTA"]);
				echo statikTabloHTML ("Öğrenim Durumu", $personel[$i]["GOREVLI_PERSONEL_OGRENIM"]);
				echo statikTabloHTML ("Mesleği", $personel[$i]["GOREVLI_PERSONEL_MESLEK"]);
				echo statikTabloHTML ("Görevi", $personel[$i]["GOREVLI_PERSONEL_UZMANLIK"]);
				echo "<br />";
				
				$titles   = array ("2. Öğrenim","Başlangıç Tarihi", "Bitiş Tarihi", "Eğitim Kurumu/Bölüm Adı");
				$tableIds = array ("EGITIM_BASLANGIC", "EGITIM_BITIS", "EGITIM_YERI");
				$egitimA = getPersonelArr ($egitim, $tableIds);
				if (isset ($egitimA[$i]))
					echo tabloHTML ($titles, $tableIds, $egitimA[$i]);
				else
					echo statikHTML ("2. Öğrenim","Başlangıç Tarihi", null);
				echo "<br />";
				
				$titles   = array ("3. Mesleğe ilişkin diğer sertifika/belgeler","Belge Adı", "Belge Alınan Yer", "Belge Alınma Tarihi", "Belge Hakkında Açıklayıcı Not");
				$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_YER", "SERTIFIKA_TARIH", "SERTIFIKA_ACIKLAMA");
				$sertifikaA = getPersonelArr ($sertifika, $tableIds);
				if (isset ($sertifikaA[$i]))
					echo tabloHTML ($titles, $tableIds, $sertifikaA[$i]);
				else
					echo statikHTML ("3. Mesleğe ilişkin diğer sertifika/belgeler", null);
				echo "<br />";
				
				echo statikHTML ("4. Meslek standardı hazırlama sürecine ilişkin alınan eğitimler/özel deneyimler", $personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
				echo "<br />";
	
				$titles   = array ("5. İş Deneyimi", "Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
				$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
				$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
				if (isset ($isDeneyimA[$i]))
					echo tabloHTML ($titles, $tableIds, $isDeneyimA[$i]);
				else
					echo statikHTML ("5. İş Deneyimi", null);
				echo "<br />";
				
				$titles   = array ("6. Yabancı Dil Bilgisi", "Yabancı Dil", "Okuma", "Konuşma", "Yazma", "Anlama");
				$tableIds = array ("DIL_ADI", "DIL_DERECESI");
				$dilA = getPersonelArr ($dil, $tableIds, 1);
				$tableIds = array ("DIL_ADI", "DIL_DERECESI_1", "DIL_DERECESI_2", "DIL_DERECESI_3", "DIL_DERECESI_4");
				if (isset ($dilA[$i]))
					echo tabloHTML ($titles, $tableIds, $dilA[$i]);
				else
					echo statikHTML ("6. Yabancı Dil Bilgisi", null);
				
				echo "<br />";
	
				if ($i < count($personel)-1){
					echo spacer ();
					echo "<br />";	
				}
			}
		}
		
		?>
	</div>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1);'/>
			<input type='button' name='bitirUst' value='Bitir' onClick='formSubmitted(2);'/>
		</div>
	</div>
	
</form>
        
<?php

function statikHTML ($paramTitle, $param){
	$html = '<div style = "height:auto; padding:5px;">
				<span><strong>'.
				$paramTitle
				.': </strong></span>
			</div>';
	if (strlen($param) != 0){
		$html .= '<div style = "height:auto; padding: 5px 5px 5px 10px;">
					<span>'.FormFactory::ignoreBreaks($param).'</span>			
				</div>';
	}
	return $html; 
}
function statikTabloHTML ($paramTitle, $param){	
	if (is_array ($param)){
		$param = implode ($param, ",");
	}
		
	$html = '<div style = "height:auto; padding:5px;">
				<table style = "width:100%;">
					<tbody>
						<tr>
							<td style = "font-size:14px; width:35%;"><strong>'.
							$paramTitle
							.': </strong></td>
							<td>'.
	  						FormFactory::ignoreBreaks($param)
	  						.'</td>	
						</tr>
					</tbody>
				</table>
			</div>';
	
	return $html; 
}

function tabloHTML ($paramTitles, $paramIds, $params){	
	$colCount = count($paramTitles)-1;
	$html = '<div style = "height:auto; padding:5px;">
		<span style = "font-size:14px; width:35%; padding-left: 2px;"><strong>'
		.$paramTitles[0].
		':</strong></span>
	</div>';
				
	$title = "<tr>";
	for ($i = 1; $i < count($paramTitles); $i++){
		$title .= '<td style="background-color:#EEEEEE; color:#000000;"><strong>'.$paramTitles[$i].'</strong></td>';
	}
	$title .= "</tr>";

	$htmlPart = "";
	for ($i = 0; $i < count($params); $i++){ 
		$data = $params[$i];
		$part = "<tr>";
		for ($j = 0; $j < count($paramIds); $j++){
			$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;">'.$data[$paramIds[$j]].'</td>';
		}
		$part .= "</tr>";
		
		$htmlPart .= $part;
	}
	
	$html .= '<div style="height:auto;padding: 10px 15px;">
				<table border="1" style="width:100%; text-align:center;">
					<tbody>'.
						$title.$htmlPart
					.'</tbody>
				</table>
			</div>';		


	return $html;
}

function spacer (){
	return '<div style="border-bottom:1px solid #42627D;margin-top: 10px; margin-bottom: 10px;"></div>';
}

function blockTitle ($title, $align="left"){
	return '<h3 style="margin-top:15px;font-size:15px;border-bottom:1px solid #42627D;text-align:'.$align.'">'.$title.'</h3>';
}

function getPersonelArr ($arr, $params, $dil = 0){
	$returnArr = array ();
	$personelId = -1;
	$c = -1;
	$p = 0;
	for ($i = 0; $i < count($arr); $i++){
		if ($personelId != $arr[$i]["GOREVLI_PERSONEL_ID"]){
			$personelId = $arr[$i]["GOREVLI_PERSONEL_ID"];
			$c++;
			$p = 0;
		}
		
		for ($j = 0; $j < count($params); $j++){
			$returnArr [$c][$p][$params[$j]] = $arr[$i][$params[$j]];
		}
		$p++;
	}
	
	if ($dil){
		$dilReturn = array ();
		for ($i = 0; $i < count($returnArr); $i++){ //Personel
			$c = 0;
			for ($j = 0; $j < count($returnArr[ $i])/4; $j++){ //Dil
				$dilReturn [$i][$c]["DIL_ADI"] = $returnArr[$i][$j*4]["DIL_ADI"];
				for ($k = 0; $k < 4; $k++){
					if (isset ($returnArr[$i][$k+$j*4]["DIL_DERECESI"]))
						$dilReturn [$i][$c]["DIL_DERECESI_".($k+1)] = $returnArr[$i][$k+$j*4]["DIL_DERECESI"];
					else
						$dilReturn [$i][$c]["DIL_DERECESI_".($k+1)] = null;
				}
				$c++;
			}
		}
		
		$returnArr = $dilReturn;
	}
	
	
	return $returnArr;
}
?>

<script type="text/javascript">
function formSubmitted (num)
{
	var form = document.ChronoContact_meslek_std_basvuru_t1;
	if (num == 1) { 
		form.action = 'index.php?option=com_meslek_std_basvur&evrak_id='+<?php echo $evrak_id;?>; 
    } else if (num == 2){
		form.action = 'index.php?option=com_meslek_std_basvur&amp;task=basvuruBitir'; 
    }    
	form.submit(); 
}
</script>