<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

	$width 			= 260;
	$tableHTMLWidth = 120;
	$tWidth			= 75;
	$titleWidth	 	= 500;
	$kurulus 	 = $this->kurulus;
	$iller 		 = $this->iller;
	$irtibat	 = $this->irtibat;
	$sektor		 = $this->sektor;
	$faaliyet	 = $this->faaliyet;
	$basvuru	 = $this->basvuru;
	$akreditasyon= $this->akreditasyon;
	$birlikteKurulus = $this->birlikteKurulus;
	$yeterlilik	 = $this->yeterlilik; 
	$personel 	 = $this->personel;			
	$egitim 	 = $this->egitim;			
	$sertifika 	 = $this->sertifika;
	$isDeneyim 	 = $this->isDeneyim;			
	$dil 		 = $this->dil;
	$tablePadding=3;

	echo '<div id="basvuru">';
	//KURULUS BILGILERI
	echo blockTitle ("A. Kuruluşa Ait Bilgiler","",0);
	?>
	<br>
	<table border="1" cellpadding="<?php echo $tablePadding;?>">
		<!-- KURULUS BILGILERI -->
		<tr>
			<td colspan="2"><strong><br />1. İletişim Bilgileri<br /></strong></td>
	  	</tr>
		<tr >
			<td ><strong><br />Ad:<br /></strong></td>
			<td ><br /><?php echo $kurulus["KURULUS_ADI"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />Adres:<br /></strong></td>
			<td ><br /><?php echo FormFactory::ignoreBreaks($kurulus["KURULUS_ADRESI"]);?><br />
			<?php $kurulus["KURULUS_POSTA_KODU"]." ".$kurulus["IL_ADI"];?><br /></td>
		</tr>
		<tr >
			<td ><strong><br />Telefon:<br /></strong></td>
			<td ><br /><?php echo $kurulus["KURULUS_TELEFON"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />Faks:<br /></strong></td>
			<td ><br /><?php echo $kurulus["KURULUS_FAKS"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />İnternet Adresi:<br /></strong></td>
			<td ><br /><?php echo $kurulus["KURULUS_FAKS"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />E-posta:<br /></strong></td>
			<td ><br /><?php echo $kurulus["KURULUS_EPOSTA"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />Varsa Faaliyette Bulunduğu İller:<br /></strong></td>
			<td ><br /><?php echo implode (" , ", $iller);?><br /></td>
	  	</tr>
  		<tr >
			<td ><strong><br />2. Kuruluşun Statüsü</strong> (kamu, özel, meslek kuruluşu, dernek, vakıf, sendika, konfederasyon, kooperatif, birlik, vb.) <br /></td>
	  		<td style="margin-top: auto; margin-bottom: auto;"><br /><?php echo $kurulus["KURULUS_STATU_ADI"];?><br /></td>
	  	</tr>
		<!-- KURULUS BILGILERI SONU	-->
  
  		<!-- YETERLILIK BIRIMI	-->
  		<tr>
			<td colspan="2"><strong><br />3. Yeterlilikle İlgili Süreçlerde Görev Alacak Birime İlişkin Bilgiler<br /></strong></td>
	  	</tr>
    	<tr >
			<td ><strong><br />Ad:<br /></strong></td>
	  		<td ><br /><?php echo $basvuru["GOREV_BIRIM_ADI"];?><br /></td>
	  	</tr>
    	<tr >
			<td ><strong><br />Adres:<br /></strong></td>
	  		<td ><br /><?php echo FormFactory::ignoreBreaks($basvuru["GOREV_BIRIM_ADRESI"]);?><br /></td>
	  	</tr>
    	<tr >
			<td ><strong><br />Telefon:<br /></strong></td>
	  		<td ><br /><?php echo $basvuru["GOREV_BIRIM_TELEFON"];?><br /></td>
	  	</tr>
    	<tr >
			<td ><strong><br />Faks:<br /></strong></td>
	  		<td ><br /><?php echo $basvuru["GOREV_BIRIM_FAKS"];?><br /></td>
	  	</tr>
  		<tr >
			<td ><strong><br />İnternet Adresi:<br /></strong></td>
			<td ><br /><?php echo $basvuru["GOREV_BIRIM_WEB"];?><br /></td>
	  	</tr>
		<tr >
			<td ><strong><br />E-posta:<br /></strong></td>
			<td ><br /><?php echo $basvuru["GOREV_BIRIM_EPOSTA"];?><br /></td>
	  	</tr>
	  	<!-- YETERLILIK BIRIMI SONU -->
	  	
	  	<!-- IRTIBAT BILGILERI	-->
  		<tr>
			<td colspan="2"><strong><br />4.İrtibat Kurulacak Kişi(ler) ve İletişim Bilgileri<br /></strong></td>
	  	</tr>
	  	<!-- IRTIBAT BILGILERI SONU -->
 	
  	</table>
  	
    <?php 
    echo borderBegin ();
  	$irtibatCount = count($irtibat);
	for ($i = 0; $i < $irtibatCount; $i++){
		$data = $irtibat [$i];
		
		echo tableHTML ("<strong>İrtibat Kurulacak Kişi:</strong>", $data["IRTIBAT_KISI_ADI"]);
		echo tableHTML ("<strong>E-Posta</strong>", $data["IRTIBAT_EPOSTA"]);
		echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["IRTIBAT_TELEFON"], $tableHTMLWidth, 0), tableHTML ("<strong>Faks:</strong>", $data["IRTIBAT_FAKS"],$tWidth, 0), $width);
		if ($i < $irtibatCount-1)
			echo "<br />";
	}
	echo borderEnd ();
	
	//FAALIYET BILGILERI
	echo "<br />";
	echo blockTitle ("B. Kuruluşun","left",0);
	echo "<br />";
	echo tableHTML ("<strong>1. Faaliyet Gösterdiği Sektör(ler)</strong>", null, $titleWidth, 0);
	echo "<br />";
	//Sektor
	$titles   = array ("Faaliyet Gösterdiği Sektör(ler)", "Açıklama");
	$tableIds = array ("SEKTOR_ADI", "SEKTOR_ACIKLAMA");
	echo tablo ($titles, $tableIds, $sektor);
	echo "<br />";
	echo "<br />";
	
	//Faaliyet Alanları
	echo tableHTML ("<strong>2. Faaliyet Alanları</strong>", null, $titleWidth, 0);
	echo "<br />";
	$faaliyetCount = count($faaliyet);
	echo borderBegin ();
	for ($i = 0; $i < $faaliyetCount; $i++){
		$data = $faaliyet[$i];
		echo divHTML ($data["FALIYET_ALAN_ADI"]);
	}
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";
	
	//Faaliyet Suresi
	echo tableHTML ("<strong>3. Faaliyet Süresi</strong>"	, null, $titleWidth, 0);
	echo divHTML ($basvuru["FALIYET_SURE_ADI"]);
	echo "<br />";
	echo "<br />";
	
	echo tableHTML ("<strong>4.Varsa mevcut akreditasyon kapsamı</strong> (Akreditasyonlara ilişkin belgeler ek olarak verilecektir bu bölüme yalnızca kapsam yazılacaktır.)"	, null, $titleWidth, 0); 
	echo "<br />";
	$titles   = array ("Akreditasyon Adı", "Açıklama");
	$tableIds = array ("AKREDITASYON_ADI", "AKREDITASYON_ACIKLAMA");
	echo tablo ($titles, $tableIds, $akreditasyon);
	echo "<br />";
	echo "<br />";
	
	echo tableHTML ("<strong>5. Toplam personel sayısı : </strong>", $basvuru["PERSONEL_SAYISI"],$tableHTMLWidth, 0);
	echo "<br />";
	echo "<br />";
	echo tableHTML ("<strong>6. Organizasyon Şeması</strong>", null, $titleWidth, 0);
	echo "<br />";
	echo "<br />";
	echo tableHTML ("<strong>7. Yeterlilik hazırlamakla/ geliştirmekle görevlendirilen/ görevlendirilecek kişilere(*) ilişkin bilgiler; yeterlilik hazırlama/ geliştirme ve süreci koordine etme konusunda planlanan yetkinlik ve kapasite arttırıcı faaliyetler </strong>", null, $titleWidth, 0);
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["EKIP_ACIKLAMA"]);
	echo divHTML("Ekip Sayısı : ".$basvuru["EKIP_SAYISI"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<span style='font-size:10px;'><i>(*)Lütfen, belirtilen kişiler için Ek 1’de sunulan “Yeterlilik geliştirme Ekibinde Görevlendirilen Personele İlişkin Bilgi Formu”nu doldurunuz.</i></span><br/><br/>"; 

	//Birlikte Kurulus
	$kurulusCount = count ($birlikteKurulus);
	if ($kurulusCount > 0){
		echo tableHTML ("<strong>8. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?</strong>", null, $titleWidth, 0);
		echo divHTML("Evet");
		echo "<br />";
		
		echo borderBegin ();
		echo "<br />";
		for ($i = 0; $i < $kurulusCount; $i++){
			$data = $birlikteKurulus [$i];
			
			echo tableHTML ("<strong>Kuruluşun</strong>" , null);
			echo tableHTML ("<strong>Adı:</strong>"		 , $data["BIRLIKTE_KURULUS_ADI"]);
			echo tableHTML ("<strong>Statüsü:</strong>"	 , $data["KURULUS_STATU_ADI"]);
			echo tableHTML ("<strong>Yetkilisi:</strong>", $data["BIRLIKTE_KURULUS_YETKILISI"]);	
			echo tableHTML ("<strong>Adresi:</strong>"	 , $data["BIRLIKTE_KURULUS_ADRES"]);
			echo tableHTML (tableHTML ("<strong>Posta Kodu:</strong>", $data["BIRLIKTE_KURULUS_POSTAKOD"], $tableHTMLWidth , 0), tableHTML ("<strong>Şehir:</strong>", $data["IL_ADI"],$tWidth, 0), $width);
			echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["BIRLIKTE_KURULUS_TELEFON"], $tableHTMLWidth , 0), tableHTML ("<strong>Faks:</strong>", $data["BIRLIKTE_KURULUS_FAKS"],$tWidth, 0), $width);
			echo tableHTML (tableHTML ("<strong>E-Posta:</strong>", $data["BIRLIKTE_KURULUS_EPOSTA"], $tableHTMLWidth , 0),tableHTML ("<strong>Web:</strong>", $data["BIRLIKTE_KURULUS_WEB"],$tWidth, 0), $width);
			echo "<br />";
		}
	}else{
		echo tableHTML ("<strong>8. Yeterliliklerin hazırlanması/geliştirilmesi sürecinde birlikte çalışılması planlanan kurum/kuruluş(lar) var mı?</strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		echo "<br />";
	}
	echo "<br />";
	if ($kurulusCount > 0)
		echo borderEnd ();
	
	//Madde 9
	echo "<br />";
	echo "<br />";
	echo tableHTML ("<strong>9. Yeterlilik hazırlama/geliştirme çalışmaları için mevcut/sağlanacak altyapı imkânları</strong>", null, $titleWidth,0);
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["ALTYAPI_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	
	//Madde 10
	echo "<br />";
	if (($basvuru["DIS_ALIM_HIZMET"] != null) || ($basvuru["DIS_ALIM_TEDBIR"]!= null)){
		echo tableHTML ("<strong>10. Yeterliliklerin hazırlanması/geliştirilmesi için dışarıdan hizmet alımı planlanıyor mu?</strong>", null, $titleWidth, 0);
		echo divHTML("Evet");
		echo "<br />";
	
		echo tableHTML ("<strong>a) Alınması planlanan hizmetler</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["DIS_ALIM_HIZMET"]);
		echo "<br />";
		echo borderEnd ();
		
		
		echo tableHTML ("<strong>b) Alınacak hizmetlerin kalite güvencesine yönelik tedbirler</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["DIS_ALIM_TEDBIR"]);
		echo "<br />";
		echo borderEnd ();
	}else{
		echo tableHTML ("<strong>10. Yeterliliklerin hazırlanması/geliştirilmesi için dışarıdan hizmet alımı planlanıyor mu? </strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		echo "<br />";
	}
	echo "<br />";
	echo "<br />";
	
	//Madde 11
	echo tableHTML ("<strong>11. Yeterlilik taslaklarının resmi görüşe gönderilmesi öncesinde yeterlilik hazırlama/geliştirme sürecine konuyla ilgili tarafların (örgün ve yaygın eğitim ve öğretim kurumları, yetkilendirilmiş belgelendirme kuruluşları, ulusal meslek standardı hazırlamış kuruluşlar, meslek kuruluşları ile personel belgelendirmesi yapan akredite kuruluşlar ve sivil toplum kuruluşları) dâhil edilmesi ve danışma sürecine ilişkin plan ve yöntemler</strong>", null, $titleWidth, 0 );
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["DANISMA_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";

	//Madde 12
	echo tableHTML ("<strong>12.Yeterlilik Taslağında yer alan ve Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğinin 10 uncu maddesinin birinci fıkrasının (f) bendindeki hususların (Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri) belirlenmesi amacıyla gerçekleştirilmesi öngörülen pilot uygulamaya ilişkin usul ve yöntemler</strong>", null, $titleWidth, 0 );
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["PILOT_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";
	
	//YETERLILIK KAPSAMI
	echo blockTitle ("Yeterlilik Geliştirme Kapsamı/Planı", "left", 0);
	echo "<br />";
	//Yeterlilikler
	echo tableHTML ("<strong>13. Geliştirilmesi/Hazırlanması öngörülen yeterlilikleri belirtiniz</strong>", null, $titleWidth, 0 );
	echo "<br />";
	$titles   = array ("Yeterliliğin Adı", "Seviyesi", "Yeterliliğe ilişkin yasal düzenleme", "Yeterliliğe Kaynak Teşkil Eden Meslek Standardı, Meslek Standardı Birimleri/Görevleri Veya Yeterlilik Birimleri", "Yeterliliğin İlgili Olduğu Sektör", "Yeterliliklerin Geliştirilmesi/Hazırlanması İçin Öngörülen Başlangıç Tarihi", "Yeterliliklerin Geliştirilmesi/Hazırlanması İçin Öngörülen Bitiş Tarihi");
	$tableIds = array ("YETERLILIK_ADI", "SEVIYE_ADI", "YETERLILIK_YASAL", "KAYNAK_TESKIL_EDENLER", "SEKTOR_ADI", "YETERLILIK_BASLANGIC", "YETERLILIK_BITIS");
	echo tablo2 ($titles, $tableIds, $yeterlilik);
	echo "<br />";
	echo "<br />";
	
	echo tableHTML ("<strong>14. Bu mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren piyasa çalışması var mı?</strong>", null, $titleWidth, 0); 
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["PIYASA_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<span style='font-size:10px'><i>Var ise, forma eklenecektir. (Piyasa araştırması, anket analizleri, yerel ve uluslararası eğilimleri gösteren sayısal veriler vb.)</i></span>";
	echo "<br />";
	echo "<br />";
	
	echo "</div>";
	
	echo "<div id=\"ek\">";
	echo blockTitle ("EK 1. ULUSAL YETERLİLİK GELİŞTİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center", 0);
	
	for ($i = 0; $i < count($personel); $i++){
		echo "<div id=\"personel_".$i."\">";
		echo tableHTML ("<strong>1. Kişisel Bilgiler</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
//		echo tableHTML ("<strong>T.C. Kimlik No /<br /> Pasaport No:</strong>", $personel[$i]["GOREVLI_PERSONEL_KIMLIK_NO"]);
		echo tableHTML ("<strong>Adı:</strong>", $personel[$i]["GOREVLI_PERSONEL_ADI"]);
		echo tableHTML ("<strong>Soyadı:</strong>", $personel[$i]["GOREVLI_PERSONEL_SOYAD"]);
		echo tableHTML ("<strong>Telefon:</strong>", $personel[$i]["GOREVLI_PERSONEL_TELEFON"]);
		echo tableHTML ("<strong>Faks:</strong>", $personel[$i]["GOREVLI_PERSONEL_FAKS"]);
		echo tableHTML ("<strong>E-Posta:</strong>", $personel[$i]["GOREVLI_PERSONEL_EPOSTA"]);
		echo tableHTML ("<strong>Öğrenim Durumu:</strong>", $personel[$i]["GOREVLI_PERSONEL_OGRENIM"]);
		echo tableHTML ("<strong>Mesleği:</strong>", $personel[$i]["GOREVLI_PERSONEL_MESLEK"]);
		echo tableHTML ("<strong>Uzmanlık alanı:</strong>", $personel[$i]["GOREVLI_PERSONEL_UZMANLIK"]);
		echo "<br />";
		echo borderEnd ();
		echo "<br />";
		
		echo tableHTML ("<strong>2. Öğrenim</strong>", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Başlangıç Tarihi", "Bitiş Tarihi", "Eğitim Kurumu/Bölüm Adı");
		$tableIds = array ("EGITIM_BASLANGIC", "EGITIM_BITIS", "EGITIM_YERI");
		$egitimA = getPersonelArr ($egitim, $tableIds);
		if (isset ($egitimA[$i]))
			echo tablo ($titles, $tableIds, $egitimA[$i]);
		echo "<br />";
		
		echo tableHTML ("<strong>3. Yetkinliklere ilişkin diğer sertifika/belgeler</strong>", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Belge Adı", "Belge Alınan Yer", "Belge Alınma Tarihi", "Belge Hakkında Açıklayıcı Not");
		$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_YER", "SERTIFIKA_TARIH", "SERTIFIKA_ACIKLAMA");
		$sertifikaA = getPersonelArr ($sertifika, $tableIds);
		if (isset ($sertifikaA[$i]))
			echo tablo ($titles, $tableIds, $sertifikaA[$i]);
		echo "<br />";
		
		echo tableHTML ("<strong>4. Yeterlilik geliştirme sürecine ilişkin  alınan eğitimler/özel deneyimler</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
		echo "<br />";
		echo borderEnd ();
		echo "<br />";
		
		echo tableHTML ("<strong>5. İş Deneyimi</strong>", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
		$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
		$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
		if (isset ($isDeneyimA[$i]))
			echo tablo ($titles, $tableIds, $isDeneyimA[$i]);
		echo "<br />";
		
		echo tableHTML ("<strong>6. Yabancı Dil Bilgisi</strong> (1-Çok iyi / 5-Başlangıç)", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Yabancı Dil", "Okuma", "Konuşma", "Yazma", "Anlama");
		$tableIds = array ("DIL_ADI", "DIL_DERECESI");
		$dilA = getPersonelArr ($dil, $tableIds, 1);
		$tableIds = array ("DIL_ADI", "DIL_DERECESI_1", "DIL_DERECESI_2", "DIL_DERECESI_3", "DIL_DERECESI_4");
		echo tablo ($titles, $tableIds, $dilA[$i]);
		echo "</div>";
		//echo "<br clear=all style='page-break-before:always'>";
	}

	echo "</div>";

	function tableHTML ($title, $data, $width=120, $tab = 1){
		$table = '<table cellpadding="'.$tablePadding.'">
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

	
	function blockTitle ($title, $align="left", $tab = 1){
		$titleHTML = '<div style="font-size:14pt;text-align:'.$align.'"><b>'.$title.'</b></div>';
		if ($tab)
			return '<dt> </dt><dd>'.$titleHTML.'</dd>';
		else
			return $titleHTML;
	}
	
	function tablo ($paramTitles, $paramIds, $params){	
		$html = '';
		$colCount = count($paramTitles);
					
		$title = "<tr>";
		for ($i = 0; $i < $colCount; $i++){
			$title .= '<td style="text-align:center"><strong><br />'.$paramTitles[$i].'<br /></strong></td>';
		}
		$title .= "</tr>";
	
		$htmlPart = "";
		for ($i = 0; $i < count($params); $i++){ 
			$data = $params[$i];
			$part = "<tr>";
			for ($j = 0; $j < count($paramIds); $j++){
				$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramIds[$j]].'</dd><dd></dd></td>';
			}
			$part .= "</tr>";
			
			$htmlPart .= $part;
		}
		
		$html .= '<div style="height:auto;padding: 10px 15px;">
					<table border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
						<tbody>'.
							$title.$htmlPart 
						.'</tbody>
					</table>
				</div>';		

		return $html;
	}
	
	function tablo2 ($paramTitles, $paramIds, $params){	
		$html = '';
		$colCount = count($paramTitles);
					
		$title = "<tr>";
		for ($i = 0; $i < $colCount; $i++){
			$title .= '<td style="text-align:center">'.$paramTitles[$i].'</td>';
		}
		$title .= "</tr>";
	
		$htmlPart = "";
		for ($i = 0; $i < count($params); $i++){ 
			$data = $params[$i];
			$part = "<tr>";
			for ($j = 0; $j < count($paramIds); $j++){
				$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramIds[$j]].'</dd><dd></dd></td>';
			}
			$part .= "</tr>";
			
			$htmlPart .= $part;
		}
		
		$html .= '<div style="height:auto;padding: 10px 15px;">
					<table nobr="true" border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
						<tbody>'.
							$title.$htmlPart 
						.'</tbody>
					</table>
				</div>';		

		return $html;
	}
	
	function divHTML ($data){
		return "<div><dt> </dt><dd>".FormFactory::ignoreBreaks($data)."</dd></div>";
	}
	
	function  borderBegin (){
		return '<table nobr="true" border="1" cellpadding="'.$tablePadding.'"><tr><td>';
	}

	function  borderEnd (){
		return '</td></tr></table>';
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