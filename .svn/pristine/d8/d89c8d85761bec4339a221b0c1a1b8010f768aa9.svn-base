<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

	$width 			= 260;//260
	$tableHTMLWidth = 120;
	$tWidth			= 75;
	$tWidth2		= 35;
	$titleWidth	 	= 500;
	$kurulus 		= $this->kurulus;
	$iller 		 	= $this->iller;
	$irtibat		= $this->irtibat;
	$sektor		 	= $this->sektor;
	$faaliyet	 	= $this->faaliyet;
	$basvuru		= $this->basvuru;
	$bagliKurulus	= $this->bagliKurulus;
	$birlikteKurulus= $this->birlikteKurulus;
	$meslek		 	= $this->meslek; 
	$personel 		= $this->personel;			
	$egitim 		= $this->egitim;			
	$sertifika 		= $this->sertifika;			
	$isDeneyim 		= $this->isDeneyim;			
	$dil 			= $this->dil;
	$basvuru_ek		= $this->basvuru_ek;
	$tablePadding	= 3;
	

	echo '<div id="basvuru">';
	//KURULUS BILGILERI
	echo borderBegin ();
	echo blockTitle ("Kuruluşun");
	echo tableHTML ("<strong>Adı:</strong>"			  , $kurulus["KURULUS_ADI"]);
	echo tableHTML ("<strong>Statüsü:</strong>"		  , $kurulus["KURULUS_STATU_ADI"]);
	echo tableHTML ("<strong>Yetkilisi:</strong>"	  , $kurulus["KURULUS_YETKILISI"]);	
//	echo tableHTML ("<strong>Yetkili Unvanı:</strong>", $kurulus["KURULUS_YETKILI_UNVANI"]);
	echo borderEnd ();
	
	echo borderBegin ();
	echo tableHTML ("<strong>Adresi:</strong>", FormFactory::ignoreBreaks($kurulus["KURULUS_ADRESI"]));
	echo tableHTML (tableHTML ("<strong>Posta Kodu:</strong>", $kurulus["KURULUS_POSTA_KODU"], $tableHTMLWidth, 0),  tableHTML ("<strong>Şehir:</strong>", $kurulus["IL_ADI"],$tWidth2,0), $width);
	echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $kurulus["KURULUS_TELEFON"], $tableHTMLWidth, 0), tableHTML ("<strong>Faks:</strong>", $kurulus["KURULUS_FAKS"],$tWidth2,0), $width);
	echo tableHTML ("<strong>E-Posta:</strong>", $kurulus["KURULUS_EPOSTA"]);
    echo tableHTML ("<strong>Web:</strong>"	, $kurulus["KURULUS_WEB"]);
	echo borderEnd ();
	
	echo borderBegin ();
	//IRTIBAT BILGILERI
	$irtibatCount = count($irtibat);
	for ($i = 0; $i < $irtibatCount; $i++){
		$data = $irtibat [$i];
		
		echo tableHTML ("<strong>İrtibat Kurulacak Kişi:</strong>", $data["IRTIBAT_KISI_ADI"]);
		echo tableHTML ("<strong>E-Posta:</strong>", $data["IRTIBAT_EPOSTA"]);
		echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["IRTIBAT_TELEFON"], $tableHTMLWidth, 0), tableHTML ("<strong>Faks:</strong>", $data["IRTIBAT_FAKS"],$tWidth2, 0), $width);
		if ($i < $irtibatCount-1)
			echo "<br />";
	}
	echo borderEnd ();
	echo "1) MYK tarafından doldurulacaktır.<br/><br/>";
	echo borderBegin ();
	//FAALIYET ILLER
	echo tableHTML ("<strong>Varsa Faaliyette bulunduğu diğer iller</strong>", null, $titleWidth);
	$ilCount = count($iller);
	for ($i = 0; $i < $ilCount; $i++){
		$ilFirst = tableHTML ("<strong>".($i+1).")</strong>", $iller [$i], 20, 0);
		$ilSec	 = "";
		if (isset ($iller [$i+1])){
			$i++;
			$ilSec = tableHTML ("<strong>".($i+1).")</strong>", $iller [$i] , 20, 0);
		}

		echo tableHTML ($ilFirst, $ilSec, $width);
	}
	echo borderEnd ();

	//FAALIYET BILGILERI
	echo "<br />";
	echo blockTitle ("KURULUŞUN", "left", 0);
	echo "<br />";
	echo tableHTML ("<strong>1. Faaliyet Gösterdiği Sektör(ler)</strong>", null, $titleWidth, 0);
	echo "<br />";
	//Sektor
	$titles   = array ("Faaliyet Gösterdiği Sektör(ler)");
	$tableIds = array ("SEKTOR_ADI");
	//echo tablo ($titles, $tableIds, $sektor);
	echo borderBegin ();
	for($i=0; $i<count($sektor); $i++)
	{
		echo divHTML ($sektor[$i]["SEKTOR_ADI"]."\n");
	}
	echo borderEnd ();
	
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
	/*$db = & JFactory::getOracleDBO();
	$faliyetSureleri = $db->prep_exec_array("SELECT FALIYET_SURE_ADI FROM PM_FALIYET_SURESI", array());
	for($i=0; $i<count($faliyetSureleri); $i++)
	{
		$checked = $faliyetSureleri[$i][0]==$basvuru["FALIYET_SURE_ADI"] ? 'checked' : '';
		echo "<input type='checkbox'".$checked.">".$faliyetSureleri[$i]."<br>";
	}*/	
	echo divHTML ($basvuru["FALIYET_SURE_ADI"]); 
	
	echo "<br />";
	echo "<br />";
	
	//Bagli Kurulus
	echo tableHTML ("<strong>4. Kuruluş, Meslek / Sivil Toplum Kuruluşu ise;</strong>", null, $titleWidth, 0);
	echo tableHTML ("<strong>Bağlı Kuruluş (Oda, Federasyon, Dernek, Sendika vb.) Adları</strong>", null, $titleWidth);
	$bagliCount = count($bagliKurulus);
	for ($i = 0; $i < $bagliCount; $i++){
		$data = $bagliKurulus[$i];
		echo divHTML ($data["BAGLI_KURULUS_ADI"]);
		
		if ($i < $bagliCount-1)
			echo "<br />";
	}
	echo "<br />";
	
	echo tableHTML ("<strong>Üye (Gerçek kişi) sayısı: </strong>", $basvuru["UYE_SAYISI"]);
	echo "<br />";
	echo "<br />";
	//
	$orgSema="";
	if(!empty($basvuru["ORGANIZASYON_SEMASI"]) && file_exists(EK_FOLDER.$basvuru["ORGANIZASYON_SEMASI"]))
		$orgSema = "Organizasyon şeması için eklere göz atınız.";
	else
		$orgSema = "Dökümana organizasyon şeması eklenmemiştir.";
	//
    
	echo tableHTML ("<strong>5. Organizasyon seması ve toplam çalışan personel sayısı</strong>", null, $titleWidth, 0);
	//echo tableHTML2("", $basvuru["ORGANIZASYON_SEMASI"]);
	echo borderBegin ();
	echo tableHTML ("<strong>NOT :</strong>",$orgSema, "8%");//
	echo tableHTML ("<strong>Personel Sayısı :</strong>", $basvuru["PERSONEL_SAYISI"]);
	if(!empty($basvuru["DIGER_HUSUSLAR"])){
    	echo tableHTML ("<strong>Diğer Hususlar :</strong>","");
    	echo tableHTML ($basvuru["DIGER_HUSUSLAR"], null, "400", 0);
    }
	echo "<br />";
	echo "<br />";
	echo borderEnd();
	
	
	//Madde 6 (Hazırlama Ekibi)
	if ($basvuru["HAZIRLAMA_EKIBI"]){
		echo tableHTML ("<strong>6. Meslek standardı hazırlama ekibi oluşturulmuş mudur?</strong>", null, $titleWidth,0);
		echo divHTML("Evet");
		echo "<br />";
		echo tableHTML ("<strong>a1) Görevlendirilen ekipte bulunan personelin* meslek standardı geliştirme ve süreci koordine etme konusundaki yetkinliğini artırmak için planlanan kapasite geliştirme faaliyetleri vb. hususlar</strong>", null, $titleWidth-20);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["EKIP_ACIKLAMA"]);
		echo "<br />";
		echo borderEnd ();
		echo "<br />";
		echo tableHTML ("<strong>a2) Görevlendirilecek ekipteki kişi sayısı</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["EKIP_SAYISI"]);
		echo borderEnd ();
		echo "<br />";
	}else{
		echo tableHTML ("<strong>6. Meslek standardı hazırlama ekibi oluşturulmuş mudur?</strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		echo "<br />";
		echo tableHTML ("<strong>b) Meslek standardı hazırlama ekibi oluşturulmasına ve kapasite geliştirilmesine yönelik planlar</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["EKIP_ACIKLAMA"]);
		echo "<br />";
		echo borderEnd ();
		echo "<br />";
	}
	echo "<br />";

	//Madde 7 (Birlikte Kurulus)
	$kurulusCount = count ($birlikteKurulus);
	if ($kurulusCount > 0){
		echo tableHTML ("<strong>7. Meslek standardı hazırlamada birlikte çalışılması planlanan kurum/kuruluş(lar) var mıdır?</strong>", null, $titleWidth, 0);
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
			echo tableHTML ("<strong>Adresi:</strong>"	 , FormFactory::ignoreBreaks($data["BIRLIKTE_KURULUS_ADRES"]));
			echo tableHTML (tableHTML ("<strong>Posta Kodu:</strong>", $data["BIRLIKTE_KURULUS_POSTAKOD"], $tableHTMLWidth , 0), tableHTML ("<strong>Şehir:</strong>", $data["IL_ADI"],$tWidth, 0), $width);
			echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["BIRLIKTE_KURULUS_TELEFON"], $tableHTMLWidth , 0), tableHTML ("<strong>Faks:</strong>", $data["BIRLIKTE_KURULUS_FAKS"],$tWidth, 0), $width);
			echo tableHTML ("<strong>E-Posta:</strong>"		 , $data["BIRLIKTE_KURULUS_EPOSTA"]);
			echo tableHTML ("<strong>Web:</strong>"	 , $data["BIRLIKTE_KURULUS_WEB"]);
			echo "<br />";
		}
		echo borderEnd();
		
	}else{
		echo tableHTML ("<strong>7. Meslek standardı hazırlamada birlikte çalışılması planlanan kurum/kuruluş(lar) var mıdır?</strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		//echo "<br />";
	}
	echo "<br />";
	
	//Madde 8
	echo "<br />";
	echo "<br />";
	echo tableHTML ("<strong>8. Meslek standardı hazırlama çalışmaları için mevcut / sağlanacak altyapı imkanları</strong>", null, $titleWidth,0);
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["ALTYAPI_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	
	//Madde 9
	echo "<br />";
	if (($basvuru["DIS_ALIM_HIZMET"] != null) || ($basvuru["DIS_ALIM_TEDBIR"]!= null)){
		echo tableHTML ("<strong>9. Meslek standartlarının hazırlanması için dışarıdan hizmet alımı planlanıyor mu?</strong>", null, $titleWidth, 0);
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
		echo tableHTML ("<strong>9. Meslek standartlarının hazırlanması için dışarıdan hizmet alımı planlanıyor mu?</strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		echo "<br />";
	}
	echo "<br />";
	echo "<br />";
	
	//Madde 10
	echo tableHTML ("<strong>10. Meslek standardı hazırlama sürecine ilgili tarafların (meslekle ilgili kamu kurumları, işçi, işveren, meslek örgütleri, eğitim sağlayıcılar) dahil edilmesi ve danışma sürecine ilişkin plan ve yöntemler</strong>", null, $titleWidth, 0 );
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["DANISMA_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";
	
	//STANDART KAPSAMI
	echo blockTitle ("Meslek Standardı Hazırlama Kapsamı/Planı", "left", 0);
	echo "<br />";
	//Meslek Standartları
	echo tableHTML ("<strong>11. Hazırlanması düşünülen meslek standartlarını lütfen belirtiniz</strong>", null, $titleWidth, 0 );
	echo "<br />";
	$titles   = array ("Meslek", "Tanımı", "Seviye*", "Mesleğe İlişkin Yasal Düzenleme Var mıdır?", "Mevcut Meslek Standardı Çalışması var mıdır?", "Planlanan Meslek Standardı HazırlamaTakvimi");
	$tableIds = array ("STANDART_ADI","STANDART_TANIMI", "SEVIYE_ADI", "YASAL_DUZENLEME", "MEVCUT_CALISMA", "BASLANGIC_TARIHI BITIS_TARIHI");
	echo tablo ($titles, $tableIds, $meslek);
	echo "<br />";
	echo "<br />";
	
	echo tableHTML ("<strong>12. Bu mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren piyasa çalışması var mıdır?</strong>", null, $titleWidth, 0); 
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["PIYASA_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";
	
	echo tableHTML ("<strong>13.  Belirtilmek istenen diğer hususlar ve/veya eklenmek istenen belgeler (tanıtım broşürü, süreli yayınlar vb.) </strong>", null, $titleWidth, 0);
	echo "<br />";
	if(!empty($basvuru_ek)){
		$titles   = array ("Başvuru Adı", "Başvuru Açıklaması","Ek");
		$tableIds = array ("BASVURU_EK_ADI","BASVURU_EK_ACIKLAMA");
		echo tablo_for_basvuru_ek($titles, $tableIds, $basvuru_ek);
	}
	else{
		echo borderBegin ();
		echo divHTML("Herhangi bir belge bulunamadı...");
		echo "<br />";
		echo borderEnd ();
	}
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "</div>";
	
	echo "<div id=\"ek\">";
	echo blockTitle ("EK 1. MESLEK STANDARDI HAZIRLAMA EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center", 0);
	
	for ($i = 0; $i < count($personel); $i++){
		echo "<div id=\"personel_".$i."\">";
		echo tableHTML ("<strong>1. Kişisel Bilgiler</strong>", null, $titleWidth);
		echo "<br />";
		echo borderBegin ();
		echo tableHTML ("<strong>T.C. Kimlik No /<br /> Pasaport No:</strong>", $personel[$i]["GOREVLI_PERSONEL_KIMLIK_NO"]);
		echo tableHTML ("<strong>Adı:</strong>", $personel[$i]["GOREVLI_PERSONEL_ADI"]);
		echo tableHTML ("<strong>Soyadı:</strong>", $personel[$i]["GOREVLI_PERSONEL_SOYAD"]);
		echo tableHTML ("<strong>Telefon:</strong>", $personel[$i]["GOREVLI_PERSONEL_TELEFON"]);
		echo tableHTML ("<strong>Faks:</strong>", $personel[$i]["GOREVLI_PERSONEL_FAKS"]);
		echo tableHTML ("<strong>E-Posta:</strong>", $personel[$i]["GOREVLI_PERSONEL_EPOSTA"]);
		echo tableHTML ("<strong>Eğitim Durumu:</strong>", $personel[$i]["GOREVLI_PERSONEL_OGRENIM"]);
		echo tableHTML ("<strong>Mesleği:</strong>", $personel[$i]["GOREVLI_PERSONEL_MESLEK"]);
		echo tableHTML ("<strong>Uzmanlık Alanı:</strong>", $personel[$i]["GOREVLI_PERSONEL_UZMANLIK"]);
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
		
		echo tableHTML ("<strong>3. Mesleğe ilişkin diğer sertifika/belgeler</strong>", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Belge Adı", "Belge Hakkında Açıklayıcı Not");
		$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_ACIKLAMA");
		$sertifikaA = getPersonelArr ($sertifika, $tableIds);
		if (isset ($sertifikaA[$i]))
			echo tablo ($titles, $tableIds, $sertifikaA[$i]);
		echo "<br />";
		
		echo tableHTML ("<strong>4. Meslek standardı hazırlama sürecine ilişkin alınan eğitimler/özel deneyimler</strong>", null, $titleWidth);
		echo "<br />";
		//echo borderBegin ();
		echo divHTML($personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
		echo "<br />";
		//echo borderEnd ();
		echo "<br />";
		
		echo tableHTML ("<strong>5. İş Deneyimi</strong>", null, $titleWidth);
		echo "<br />";
		$titles   = array ("Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
		$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
		$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
		if (isset ($isDeneyimA[$i]))
			echo tablo ($titles, $tableIds, $isDeneyimA[$i]);
		echo "<br />";
		
		echo tableHTML ("<strong>6. Yabancı Dil Bilgisi</strong>: 1’den 5’e kadar derecelendiriniz. (1- mükemmel- 5 temel)", null, $titleWidth);
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
	$flag=0;//
	echo "<br/><br/><br/><br/>";
	if(!empty($basvuru_ek)){
		echo "<div id=\"ek2\">";
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		echo blockTitle ("EK 2.  BELİRTİLMEK İSTENEN DİĞER HUSUSLAR VE/VEYA EKLENMEK İSTENEN BELGELER", "center", 0);
		for ($i = 0; $i < count($basvuru_ek); $i++){
			echo borderBegin ();
			echo divHTML("Broşür - ".($i+1)." : ".$basvuru_ek[$i]["BASVURU_EK_ADI"]);
			if(file_exists(EK_FOLDER.$basvuru_ek[$i]["BASVURU_EK_PATH"]))
				echo tableHTML("", $basvuru_ek[$i]["BASVURU_EK_PATH"]);
//				echo tableHTML("", file_get_contents(EK_FOLDER.$basvuru_ek[$i]["BASVURU_EK_PATH"]));
			echo "<br />";
			echo borderEnd ();
		}
		echo "</div>";
		$flag=1;//
	}
	//
	if(!empty($basvuru["ORGANIZASYON_SEMASI"]) && file_exists($basvuru["ORGANIZASYON_SEMASI"])){
		echo '<br pagebreak="true" />';
		echo "<div id=\"ek3\">";
		if($flag)
			echo blockTitle ("EK 3.  ORGANİZASYON ŞEMASI", "center", 0);
		else
			echo blockTitle ("EK 2.  ORGANİZASYON ŞEMASI", "center", 0);			
		echo borderBegin ();
		echo tableHTML2("Organizasyon Şeması", $basvuru["ORGANIZASYON_SEMASI"]);
		echo borderEnd ();
		echo "</div>";
	}
	//
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
	//
	function tableHTML2 ($title, $data, $width=120, $tab = 1){
		$table = '<table nobr="true" cellpadding="'.$tablePadding.'">
					<tr >
						<td ><img src="'.$data.'" width="400" height="300"/></td>
				  	</tr>
			  	</table>';
		
		if ($tab)
			return "<dt> </dt><dd>".$table."</dd>";
		else
			return $table;
	}
	//	
	function blockTitle ($title, $align="left", $tab = 1){
		$titleHTML = '<h3 style="font-size:15px;text-align:'.$align.'">'.$title.'</h3>';
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
				$paramparts=explode(" ",$paramIds[$j]);
				if(!empty($paramparts[1]))		
					$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramparts[0]].'  '.$data[$paramparts[1]].'</dd><dd></dd></td>';
				else
					$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramparts[0]].'</dd><dd></dd></td>';
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
	function tablo_for_basvuru_ek ($paramTitles, $paramIds, $params){	
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
					$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"></td>';
			}
			$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>Ek 2 / Broş- '.($i+1).' </dd><dd></dd></td>';
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