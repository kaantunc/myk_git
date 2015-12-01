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
$birlikteKurulus = $this->birlikteKurulus;
$yeterlilik	 = $this->yeterlilikTum; 
$personel 		= $this->personel;			
$egitim 		= $this->egitim;			
$sertifika 		= $this->sertifika;			
$isDeneyim 		= $this->isDeneyim;			
$dil 			= $this->dil;

?>
<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_basvuru_t2"
	name="ChronoContact_yeterlilik_basvuru_t2">
	  
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
		echo blockTitle ("A. Kuruluşa Ait Bilgiler");
		
		//KURULUS BILGILERI
		echo blockTitle ("1. İletişim Bilgileri");
		echo statikTabloHTML ("Adı"				, $kurulus["KURULUS_ADI"]);
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
		echo blockTitle ("2. Kuruluşun Statüsü");
		echo statikTabloHTML ("Statüsü"			, $kurulus["KURULUS_STATU_ADI"]);
		
		//IRTIBAT BILGILERI
		//Birim
		echo blockTitle ("3.Yeterlilikle İlgili Süreçlerde Görev Alacak Birime İlişkin Bilgiler");
		echo statikTabloHTML ("Ad"				, $basvuru["GOREV_BIRIM_ADI"]);
		echo statikTabloHTML ("Adres"			, $basvuru["GOREV_BIRIM_ADRESI"]);
		echo statikTabloHTML ("Telefon"			, $basvuru["GOREV_BIRIM_TELEFON"]);
		echo statikTabloHTML ("Faks"			, $basvuru["GOREV_BIRIM_FAKS"]);
		echo statikTabloHTML ("İnternet Adresi"	, $basvuru["GOREV_BIRIM_WEB"]);
		echo statikTabloHTML ("E-posta"			, $basvuru["GOREV_BIRIM_EPOSTA"]);
		
		//İrtibat
		echo blockTitle ("4. İrtibat kurulacak kişi(ler) ve iletişim bilgileri");
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
		echo blockTitle ("B. KURULUŞUN");
		//Sektor
		$titles   = array ("1. Faaliyet Gösterdiği Sektör(ler)", "Faaliyet Gösterdiği Sektör(ler)", "Açıklama");
		$tableIds = array ("SEKTOR_ADI", "SEKTOR_ACIKLAMA");
		echo tabloHTML ($titles, $tableIds, $sektor);
		
		//Faaliyet Alanları
		echo "<br>";
		$titles   = array ("2. Faaliyet Alanları", "Faaliyet Alanları");
		$tableIds = array ("FALIYET_ALAN_ADI");
		echo tabloHTML ($titles, $tableIds, $faaliyet);

		//Faaliyet Suresi
		echo "<br>";
		echo statikTabloHTML ("3. Faaliyet Süresi"	, $basvuru["FALIYET_SURE_ADI"]);
		//Akreditasyon
		echo statikHTML 	 ("4.Varsa mevcut akreditasyon kapsamı", null);
		// Personel Sayısı
		echo "<br>";
		echo statikTabloHTML ("5. Personel Sayısı", $basvuru["PERSONEL_SAYISI"]);
		//Sema
		echo statikHTML 	 ("6. Organizasyon seması", null);

		//Madde 7 (Hazırlama Ekibi)
		echo "<br>";
		echo statikHTML ("7. Yeterlilik hazırlamakla/ geliştirmekle görevlendirilen/ görevlendirilecek kişilere(*) ilişkin bilgiler; yeterlilik hazırlama/ geliştirme ve süreci koordine etme konusunda planlanan yetkinlik ve kapasite arttırıcı faaliyetler", "");
		echo statikHTML ("a) Yeterlilik hazırlama/ geliştirme ve süreci koordine etme konusunda planlanan yetkinlik ve kapasite arttırıcı faaliyetler", $basvuru["EKIP_ACIKLAMA"]);
		echo statikTabloHTML ("b) Görevlendirilecek ekipteki kişi sayısı", $basvuru["EKIP_SAYISI"]);
			
		//Madde 8 (Birlikte Kurulus)
		$kurulusCount = count ($birlikteKurulus);
		if ($kurulusCount > 0){
			echo "<br>";
			echo statikHTML ("8. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?", "Evet");
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
			echo statikHTML ("8. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?", "Hayır");
		}
		
		//Madde 9
		echo "<br>";
		echo statikHTML ("9. Yeterlilik hazırlama/geliştirme çalışmaları için mevcut/sağlanacak altyapı imkânları", $basvuru["ALTYAPI_ACIKLAMA"]);
		
		//Madde 10
		echo "<br>";
		if (($basvuru["DIS_ALIM_HIZMET"] != null) || ($basvuru["DIS_ALIM_TEDBIR"]!= null)){
			echo statikHTML ("10. Yeterliliklerin hazırlanması/geliştirilmesi için dışarıdan hizmet alımı planlanıyor mu?", "Evet");
			echo statikHTML ("a) Alınması planlanan hizmetler", $basvuru["DIS_ALIM_HIZMET"]);
			echo statikHTML ("b) Alınacak hizmetlerin kalite güvencesine yönelik tedbirler", $basvuru["DIS_ALIM_TEDBIR"]);
		}else{
			echo statikHTML ("10. Yeterliliklerin hazırlanması/geliştirilmesi için dışarıdan hizmet alımı planlanıyor mu?", "Hayır");
		}

		//Madde 11
		echo "<br>";
		echo statikHTML ("11. Yeterlilik taslaklarının resmi görüşe gönderilmesi öncesinde yeterlilik hazırlama/geliştirme sürecine konuyla ilgili tarafların (örgün ve yaygın eğitim ve öğretim kurumları, yetkilendirilmiş belgelendirme kuruluşları, ulusal meslek standardı hazırlamış kuruluşlar, meslek kuruluşları ile personel belgelendirmesi yapan akredite kuruluşlar ve sivil toplum kuruluşları) dâhil edilmesi ve danışma sürecine ilişkin plan ve yöntemler", $basvuru["DANISMA_ACIKLAMA"]);

		//Madde 12
		echo "<br>";
		echo statikHTML ("12.Yeterlilik Taslağında yer alan ve Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğinin 10 uncu maddesinin birinci fıkrasının (f) bendindeki hususların (Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri) belirlenmesi amacıyla gerçekleştirilmesi öngörülen pilot uygulamaya ilişkin usul ve yöntemler", $basvuru["PILOT_ACIKLAMA"]);
		
		//STANDART KAPSAMI
		echo "<br>";
		echo blockTitle ("Yeterlilik Geliştirme Kapsamı/Planı");
		//Yeterlilikler
//		echo statikHTML ("13. Geliştirilmesi/Hazırlanması öngörülen yeterlilikleri belirtiniz", null);
//		echo "<br />";
		$titles   = array ("13. Geliştirilmesi/Hazırlanması öngörülen yeterlilikleri belirtiniz", "Yeterliliğin Adı", "Seviyesi", "Yeterliliğe ilişkin yasal düzenleme", "Yeterliliğe Kaynak Teşkil Eden Meslek Standardı, Meslek Standardı Birimleri/Görevleri Veya Yeterlilik Birimleri", "Yeterliliğin İlgili Olduğu Sektör", "Yeterliliklerin Geliştirilmesi/ Hazırlanması İçin Öngörülen Başlangıç Tarihi", "Yeterliliklerin Geliştirilmesi/ Hazırlanması İçin Öngörülen Bitiş Tarihi");
		$tableIds = array ("YETERLILIK_ADI", "SEVIYE_ADI", "YETERLILIK_YASAL", "STANDART_ADI", "SEKTOR_ADI", "YETERLILIK_BASLANGIC", "YETERLILIK_BITIS");
		echo tabloHTML ($titles, $tableIds, $yeterlilik);
		echo "<br>";
		
		echo statikHTML ("14. Bu mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren piyasa çalışması var mı?", $basvuru["PIYASA_ACIKLAMA"]); 
		echo "<br>";
		
		if (count($personel) > 0)
			echo blockTitle ("EK 1. ULUSAL YETERLİLİK GELİŞTİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center");
		
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
			echo "<br />";
			
			$titles   = array ("3. Yetkinliklere ilişkin diğer sertifika/belgeler","Belge Adı", "Belge Alınan Yer", "Belge Alınma Tarihi", "Belge Hakkında Açıklayıcı Not");
			$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_YER", "SERTIFIKA_TARIH", "SERTIFIKA_ACIKLAMA");
			$sertifikaA = getPersonelArr ($sertifika, $tableIds);
			if (isset ($sertifikaA[$i]))
				echo tabloHTML ($titles, $tableIds, $sertifikaA[$i]);
			echo "<br />";
			
			echo statikHTML ("4. Yeterlilik geliştirme sürecine ilişkin  alınan eğitimler/özel deneyimler", $personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
			echo "<br />";

			$titles   = array ("5. İş Deneyimi", "Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
			$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
			$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
			if (isset ($isDeneyimA[$i]))
				echo tabloHTML ($titles, $tableIds, $isDeneyimA[$i]);
			echo "<br />";
			
			$titles   = array ("6. Yabancı Dil Bilgisi", "Yabancı Dil", "Okuma", "Konuşma", "Yazma", "Anlama");
			$tableIds = array ("DIL_ADI", "DIL_DERECESI");
			$dilA = getPersonelArr ($dil, $tableIds, 1);
			$tableIds = array ("DIL_ADI", "DIL_DERECESI_1", "DIL_DERECESI_2", "DIL_DERECESI_3", "DIL_DERECESI_4");
			if (isset ($dilA[$i]))
				echo tabloHTML ($titles, $tableIds, $dilA[$i]);
			
			echo "<br />";

			if ($i < count($personel)-1){
				echo spacer ();
				echo "<br />";	
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

function blockTitle ($title){
	return '<h3 style="margin-top:15px;font-size:15px;border-bottom:1px solid #42627D;">'.$title.'</h3>';
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
	var form = document.ChronoContact_yeterlilik_basvuru_t2;
	if (num == 1) { 
		form.action = 'index.php?option=com_yeterlilik_basvur&Itemid=211'; 
    } else if (num == 2){
		form.action = 'index.php?option=com_yeterlilik_basvur&task=basvuruBitir'; 
    }    
	form.submit(); 
}
</script>