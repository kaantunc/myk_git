<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//$evrak_id		 = $this->evrak_id;
$evrak_id		 = $_GET['evrak_id'];
$title 			 = $this->title;
$kurulus 		 = $this->kurulus;
$iller 			 = $this->iller;
$irtibat		 = $this->irtibat;
$sektor			 = $this->sektor;
$faaliyet		 = $this->faaliyet;
$basvuru		 = $this->basvuru;
$birlikteKurulus = $this->birlikteKurulus;
$sinavMerkez 	 = $this->sinavMerkez;
$yetkiTalep	 	 = $this->yetkiTalep;
$akreditasyon	 = $this->akreditasyon;
$personel 		 = $this->personel;			
$egitim 		 = $this->egitim;			
$sertifika 		 = $this->sertifika;			
$isDeneyim 		 = $this->isDeneyim;			
$dil 			 = $this->dil;
$basvuru_ekleri  = $this->basvuru_ekleriPDF;
$basvuru_turleri = $this->turler;
$belge = array(
			"taahutname",
			"dekont",
			"organizasyonsema",
			"surecrehber",
			"sertifikaornek",
			"gorevliliste",
			"gorevlibilgi",
			"gorevlibeyan",
			"peryongorevtanim",
			"kurucumetin",
			"denetimrapor",
			"protokolsozornek",
			"akreditasyonbelge",
			"akreditasyonrapor",
			"kurdegkayit",
			"imzasirku",
			"bilancovergi",
			"sgkborc",
			"vergi",
			"tanitim",
			"misviz",
			"urunhizmet",
			"ulusproje",
			"ekdokumantasyon"
	);
	$belgeAciklama = array(
	0=>"Taahhütname",
	1=>"Yetkilendirilme başvuru masraf karşılığının yatırıldığına dair dekont",
	2=>"Kurum/kuruluş organizasyon şeması",
	3=>"Sınav ve belgelendirme süreçleriyle ilgili el kitabı, rehber ve prosedürler",
	4=>"Yetkilendirilme talep edilen yeterliliklerle ilgili düzenlenen sertifika örnekleri",
	5=>"Sınavlarda görev alacak kişilerin listesi",
	6=>"Sınavlarda görevlendirilecekler ile belgelendirme süreçlerinde görev alacak diğer kişilere ilişkin bilgi formu",
	7=>"Sınavlarda görevlendirilecekler ve belgelendirme süreçlerinde görev alacak diğer kişiler ile yönetmeliğin 17. maddesinin (b) ve (c) bentlerinde tanımlanan kişiler için yönetmelikteki şartları sağladığına dair kişisel beyan.",
	8=>"Belgelendirme faaliyetlerinde görev alan personel ve yöneticilere ilişkin görev tanımları",
	9=>"Başvuru sahibi kurum/kuruluşların kurucu metinleri (şirket ana sözleşmesi, dernek/vakıf tüzüğü, kurucu kanunlar, vb.)",
	10=>"Dışarıdan hizmet sağlayan kuruluşun yönetmelik hükümlerine ve akreditasyon şartlarına uygunluğu ile ilgili denetim raporları (Dışarıdan hizmet alımı yapan kuruluşlar için)",
	11=>"Sınav ve belgelendirme ile ilgili dışarıdan sağlanan hizmetlere ilişkin ilgili kuruluş(lar)la yapılan olan protokol/sözleşme örnekleri",
	12=>"Akreditasyon belgesi ve akreditasyon kapsamını gösterir belge",
	13=>"Akreditasyona ilişkin denetim raporu veya uygunsuzluk raporları suretleri",
	14=>"Ticaret sicil gazetesi şirket kuruluş ve değişiklik kayıtları (şirketler ve kooperatifler için)",
	15=>"Noter onaylı imza sirküleri  (Kuruluşu temsil ve ilzama yetkili kişiler ile kuruluş tarafından düzenlenen sertifikaları imzalamaya yetkili kişiler için )",
	16=>"Son üç yıla ilişkin bilanço, vergi levhası suretleri",
	17=>"SGK’dan alınacak sosyal güvenlik prim borcu bulunmadığını gösterir yazı",
	18=>"Vergi borcu bulunmadığını göstermek üzere bağlı bulunulan vergi dairesinden alınacak yazı",
	19=>"Kuruluşu tanıtıcı materyal",
	20=>"Kuruluş Misyon&Vizyon",
	21=>"Kuruluşun sahip olduğu ürün hizmet veya kalite belgeleri",
	22=>"Konuyla ilgili ulusal veya uluslararası kuruluşlarca desteklenen projeler",
	23=>"Kuruluş ile ilgili ilave edilmek istenen ek dokümantasyon");

?>

<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_belgelendirme_basvuru_t3"
	name="ChronoContact_belgelendirme_basvuru_t3">
	  
	<input type="hidden" value="<?php echo $evrak_id;?>" name="evrak_id">
	<input type='hidden' value='1' name='2306e6467a830d886ea16ea1849f7ff5'/>	
	<input type='hidden' value='e84ad33046067593b8356745abbdd473' name='1cf1'/>

	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='goToPage2(<?php echo $evrak_id;?>);'/>
			<input type='button' name='bitirUst' value='Bitir' onClick='formSubmitted(2);'/>
		</div>
		
		<div style="clear:both;"></div>
	</div>
	
	<div class='form_element'>
		<h1 class='contentheading'><?php echo $title;?></h1>	
		<?php 
		//KURULUS BILGILERI
		echo "<br/>";echo "<br/>";
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
		echo "<br />";
		//Sektor
		$titles   = array ("5. Faaliyet Gösterdiği Sektör(ler)", "Faaliyet Gösterdiği Sektör(ler)", "Açıklama");
		$tableIds = array ("SEKTOR_ADI", "SEKTOR_ACIKLAMA");
		echo tabloHTML ($titles, $tableIds, $sektor);
		
		//Faaliyet Alanları
		echo "<br />";
		$titles   = array ("6. Faaliyet Alanları", "Faaliyet Alanları");
		$tableIds = array ("FALIYET_ALAN_ADI");
		echo tabloHTML ($titles, $tableIds, $faaliyet);

		//Faaliyet Suresi
		echo "<br />";
		echo blockTitle ("7. Faaliyet Süresi");
		echo  statikHTML (null, $basvuru["FALIYET_SURE_ADI"]);
		// Personel Sayısı
		echo "<br />";
		echo blockTitle ("8. Kuruluşun sürekli çalışan personel sayısı ile sınav ve belgelendirme faaliyetlerinde görev yapan personel sayısı");
		echo statikHTML ("a) Toplam Personel Sayısı", $basvuru["PERSONEL_SAYISI"]);
		echo statikHTML ("b) Görevlendirilecek ekipteki kişi sayısı", $basvuru["EKIP_SAYISI"]);
		
		echo "<br />";
		echo blockTitle ("9. Kuruluşun sınav ve belgelendirme faaliyetlerine ve yetkilendirilme talebine ilişkin bilgiler");
		echo statikHTML ("a) Sınav ve belgelendirme yapılan yeterlilikler, kuruluşun sınav ve belgelendirme faaliyetlerine ne zaman başladığı ve sürekliliği, bir yılda alınan ortalama başvuru, yapılan sınav ve verilen belge sayıları gibi kuruluşun faaliyetlerini açıklayan bilgiler", $basvuru["KURULUS_TALEP_ACIKLAMA"]);
		//Yeterlilik Talep
		echo   statikHTML ("b) Yetki talep edilen yeterlilik(ler)");
		$tableIds = array ("YETERLILIK_ADI", "SEVIYE_ADI", "VERILEN_BELGE", "YAPILAN_SINAV");
		//echo tabloHTML ($titles, $tableIds, $yetkiTalep, 0);?>
		<table nobr="true" border="1" style="width:100%; text-align:center;">
  		<tr>
		    <td width="30%" rowspan="2"><strong>Yeterliliğin Adı</strong></td>
		    <td width="20%" rowspan="2"><strong>Kodu</strong></td>
		    <td width="13%" rowspan="2"><strong>Seviyesi</strong></td>
		    <td width="42%" colspan="2"><strong>Başvuru tarihine kadar</strong></td>
		  </tr>
		  <tr>
		    <td width="20%"><strong>Verilmiş belge sayısı</strong></td>
		    <td width="22%"><strong>Gerçekleştirilmiş sınav sayısı</strong></td>
		  </tr>
	  	<?php 
	  		foreach($yetkiTalep as $row){
	  			echo '<tr><td width="30%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["YETERLILIK_ADI"].'</td>
			<td width="20%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["YETERLILIK_KODU"].'</td>
			<td width="13%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["SEVIYE_ADI"].'</td>
			<td width="20%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["VERILEN_BELGE"].'</td>
			<td width="22%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["YAPILAN_SINAV"].'</td></tr>';	
	  		}
	  	?>
 	
  	</table>
		<?php
		//AKREDITASYON
		echo blockTitle ("10. Kuruluş akreditasyon bilgileri");
		$akCount = count($akreditasyon);

		for ($i = 0; $i < $akCount; $i++){
			$data = $akreditasyon [$i];
			//echo statikHTML 	 ("10. Kuruluş akreditasyon bilgileri", null);
			echo statikTabloHTML ("Yetki talep edilen ve akredite olunan ulusal yeterlilik"	, $data["AKREDITASYON_ADI"]);
			echo statikTabloHTML ("Yeterlilik seviyesi/seviyeleri"	  						, $data["AKREDITASYON_SEVIYE"]);
			echo statikTabloHTML ("Akreditasyon kuruluşu ve akreditasyon standardı"	  		, $data["AKREDITASYON_STANDARDI"]);	
			echo statikTabloHTML ("Akreditasyon başlangıç tarihi"	  						, $data["AKREDITASYON_BASLANGIC"]);
			echo statikTabloHTML ("Akreditasyon bitiş tarihi"	  							, $data["AKREDITASYON_BITIS"]);
			echo statikTabloHTML ("Yetki talep edilen yeterlilikte gerçekleştirilen en son denetim tarihi"	  	, $data["AKREDITASYON_DENETIM"]);
			echo statikTabloHTML ("Yetki talep edilen ulusal yeterliliğin akreditasyon kapsamına alındığı tarih", $data["AKREDITASYON_KAPSAM"]);
			
			if ($i+1 < $akCount)
				echo spacer();
		}
		
		//SINAV KAPSAM
		echo  blockTitle ("11. Kuruluşun sınavlarını gerçekleştireceği merkez(ler)");
		$tableIds = array ("MERKEZ_ADI", "YETERLILIK_ADI", "SINAV_SEKLI_ADI", "MERKEZ_TEMIN_ADI", "MERKEZ_ADRESI");
		//echo tabloHTML ($titles, $tableIds, $sinavMerkez);?>
		<table nobr="true" border="1" cellspacing="0" cellpadding="3" style="text-align:center">
  		<tr>
		    <td width="20%"><strong>Sınav Merkezi</strong></td>
		    <td width="30%"><strong>Sınav yapılan yeterlilik(ler)</strong></td>
		    <td width="13%"><strong>Sınavın şekli</strong></td>
		    <td width="20%"><strong>Sınav merkezinin tasarrufu</strong></td>
		    <td width="22%"><strong>Merkezin adres ve iletişim bilgileri</strong></td>
		  </tr>
	  	<?php 
	  		foreach($sinavMerkez as $row){
	  			echo '<tr><td width="20%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["MERKEZ_ADI"].'</td>
			<td width="30%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["YETERLILIK_ADI"].' ('.$row["YETERLILIK_KODU"].')</td>
			<td width="13%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["SINAV_SEKLI_ADI"].'</td>
			<td width="20%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["MERKEZ_TEMIN_ADI"].'</td>
			<td width="22%" style="border-bottom-width:thin; border-style:none none dotted;">'.$row["MERKEZ_ADRESI"].'</td></tr>';	
	  		}
	  	?>
 	
  	</table>
		<?php 
		echo "<br />";
		echo "<br />";
		
		if (isset ($basvuru["GEZICI_BIRIM"]) && $basvuru["GEZICI_BIRIM"] != null){
			echo blockTitle ("12. Kuruluşun sınavlarını gerçekleştireceği gezici sınav birim(ler)i var mı?");
			echo statikHTML (null, "Evet");
			echo "<br />";
			
			echo blockTitle ("13. Gezici sınav birim(ler)inde sınavlar için gerekli altyapının oluşturulması, şeffaf ve güvenilir bir sınavın gerçekleştirilmesi ve sınav için gerekli özel şartlar var ise bu şartların karşılanması için alınan önlemler");
			echo statikHTML (null, $basvuru["GEZICI_BIRIM"]);
		}else{
			echo blockTitle ("12. Kuruluşun sınavlarını gerçekleştireceği gezici sınav birim(ler)i var mı?");
			echo statikHTML (null, "Hayır");
		}
			
		echo "<br />";
		
		//Madde 14 (Birlikte Kurulus)
		$kurulusCount = count ($birlikteKurulus);
		if ($kurulusCount > 0){
			echo "<br />";
			echo blockTitle ("14. Sınav ve belgelendirme sürecinde dışarıdan hizmet alımı yapılan/yapılması planlanan kurum/kuruluş(lar) var mı?");
			echo statikHTML (null, "Evet");
			echo "<br />";
			
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
				echo statikTabloHTML ("Alınması Planlanan Hizmetler" , $data["BIRLIKTE_KURULUS_HIZMET"]);
				
				if ($i+1 < $kurulusCount)
					echo spacer();
			}
		}else{
			echo blockTitle ("14. Sınav ve belgelendirme sürecinde dışarıdan hizmet alımı yapılan/yapılması planlanan kurum/kuruluş(lar) var mı?");
			echo statikHTML (null, "Hayır");
		}
		echo "<br />";
		
		if (isset ($basvuru["EGITIM_ACIKLAMA"]) && $basvuru["EGITIM_ACIKLAMA"] != null){
			echo blockTitle ("15. Sınav ve belgelendirme yapılan alanlarla ilgili eğitim veriliyor mu?");
			echo statikHTML (null, "Evet");
			echo "<br />";
			
			echo blockTitle ("16. Eğitim ve belgelendirme faaliyetlerinin ayırımı konusunda alınan tedbirler");
			echo statikHTML (null, $basvuru["EGITIM_ACIKLAMA"]);
		}else{
			echo blockTitle ("15. Sınav ve belgelendirme yapılan alanlarla ilgili eğitim veriliyor mu?");
			echo statikHTML (null, "Hayır");
		}
		
		echo "<br />";
		echo blockTitle ("17. Sınav ve belgelendirme çalışmaları için tahsis edilen kaynaklar, teknik ve fiziki altyapı imkânları");
		echo statikHTML (null, $basvuru["TEKNIK_FIZIKI_ACIKLAMA"]);
		echo "<br />";
		echo "<br />";
		
// 		if (count($personel) > 0)
// 			echo blockTitle ("EK 1. SINAV VE BELGELENDİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center");
// 		for ($i = 0; $i < count($personel); $i++){
// 			echo blockTitle ("1. Kişisel Bilgiler");
// 			echo statikTabloHTML ("T.C. Kimlik No / Pasaport No", $personel[$i]["GOREVLI_PERSONEL_KIMLIK_NO"]);
// 			echo statikTabloHTML ("Adı", $personel[$i]["GOREVLI_PERSONEL_ADI"]);
// 			echo statikTabloHTML ("Soyadı", $personel[$i]["GOREVLI_PERSONEL_SOYAD"]);
// 			echo statikTabloHTML ("Telefon", $personel[$i]["GOREVLI_PERSONEL_TELEFON"]);
// 			echo statikTabloHTML ("Faks", $personel[$i]["GOREVLI_PERSONEL_FAKS"]);
// 			echo statikTabloHTML ("E-Posta", $personel[$i]["GOREVLI_PERSONEL_EPOSTA"]);
// 			echo statikTabloHTML ("Öğrenim Durumu", $personel[$i]["GOREVLI_PERSONEL_OGRENIM"]);
// 			echo statikTabloHTML ("Mesleği", $personel[$i]["GOREVLI_PERSONEL_MESLEK"]);
// 			echo statikTabloHTML ("Görevi", $personel[$i]["GOREVLI_PERSONEL_UZMANLIK"]);
// 			echo statikTabloHTML ("Sınavlarda görev alacaklar için <br /> görev alacağı yeterlilikler", $personel[$i]["GOREVLI_PERSONEL_YETERLILIK"]);
// 			echo "<br />";
			
// 			$titles   = array ("2. Öğrenim","Başlangıç Tarihi", "Bitiş Tarihi", "Eğitim Kurumu/Bölüm Adı");
// 			$tableIds = array ("EGITIM_BASLANGIC", "EGITIM_BITIS", "EGITIM_YERI");
// 			$egitimA = getPersonelArr ($egitim, $tableIds);
// 			if (isset ($egitimA[$i]))
// 				echo tabloHTML ($titles, $tableIds, $egitimA[$i]);
// 			echo "<br />";
			
// 			$titles   = array ("3. Mesleğe ilişkin diğer sertifika/belgeler","Belge Adı", "Belge Alınan Yer", "Belge Alınma Tarihi", "Belge Hakkında Açıklayıcı Not");
// 			$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_YER", "SERTIFIKA_TARIH", "SERTIFIKA_ACIKLAMA");
// 			$sertifikaA = getPersonelArr ($sertifika, $tableIds);
// 			if (isset ($sertifikaA[$i]))
// 				echo tabloHTML ($titles, $tableIds, $sertifikaA[$i]);
// 			echo "<br />";
			
// 			echo blockTitle ("4. Meslek standardı hazırlama sürecine ilişkin alınan eğitimler/özel deneyimler");
// 			echo statikHTML (null, $personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
// 			echo "<br />";

// 			$titles   = array ("5. İş Deneyimi", "Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
// 			$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
// 			$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
// 			if (isset ($isDeneyimA[$i]))
// 				echo tabloHTML ($titles, $tableIds, $isDeneyimA[$i]);
// 			echo "<br />";
			
// 			$titles   = array ("6. Yabancı Dil Bilgisi", "Yabancı Dil", "Okuma", "Konuşma", "Yazma", "Anlama");
// 			$tableIds = array ("DIL_ADI", "DIL_DERECESI");
// 			$dilA = getPersonelArr ($dil, $tableIds, 1);
// 			$tableIds = array ("DIL_ADI", "DIL_DERECESI_1", "DIL_DERECESI_2", "DIL_DERECESI_3", "DIL_DERECESI_4");
// 			echo tabloHTML ($titles, $tableIds, $dilA[$i]);
// 			echo "<br />";

// 			if ($i < count($personel)-1){
// 				echo spacer ();
// 				echo "<br />";	
// 			}
// 		}
		
		echo blockTitle("BAŞVURAN KURULUŞ TARAFINDAN BAŞVURU FORMU EKİNDE VERİLEN BİLGİ VE BELGELER");
		echo '<br/>';
		$taharray = array();
		for($ii = 0; $ii < count($belge); $ii++){
			for($kk=0; $kk<count($basvuru_ekleri); $kk++){
				if($basvuru_ekleri[$kk][BELGE_TURU]==$belge[$ii]){
					array_push($taharray,$ii);
				}
			}
		}
		?>
			<table nobr="true" cellpadding="3" border="1" cellspacing="0">
			<?php
					foreach ($taharray as $row){
						echo '<tr>
								<td width="10%"><strong>Ek-'.($row+1).'</strong></td>
								<td width="90%">'.$belgeAciklama[$row].'</td>
							</tr>';
					}
			?>
			</table>
	</div>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='goToPage2(<?php echo $evrak_id;?>);'/>
			<input type='button' name='bitirUst' value='Bitir' onClick='formSubmitted(2);'/>
		</div>
	</div>
	
</form>
        
<?php

function statikHTML ($paramTitle, $param){
	$html = "";
	if (strlen($paramTitle) != 0){
		$html = '<div style = "height:auto; padding:5px;">
					<span><strong>'.
					$paramTitle
					.': </strong></span>
				</div>';
	}
	if (strlen($param) != 0){
		$html .= '<div style = "height:auto; padding: 5px 5px 5px 10px;">
					<span>'.FormFactory2::ignoreBreaks($param).'</span>			
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
	  						FormFactory2::ignoreBreaks($param)
	  						.'</td>	
						</tr>
					</tbody>
				</table>
			</div>';
	
	return $html; 
}

function tabloHTML ($paramTitles, $paramIds, $params, $block=1){	
	$colCount = count($paramTitles)-1;


	if ($block){
		$html = blockTitle ($paramTitles[0]);
	}else{
		$html = '<div style = "height:auto; padding:5px;">
			<span style = "font-size:14px; width:35%; padding-left: 2px;"><strong>'
			.$paramTitles[0].
			':</strong></span>
		</div>';
	}
				
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
	return '<h3 style="margin-top:15px;font-size:15px;border-bottom:1px solid #42627D;text-align:'.$align.';">'.$title.'</h3>';
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
	var form = document.ChronoContact_belgelendirme_basvuru_t3;
	if (num == 1) { 
		form.action = 'index.php?option=com_belgelendirme_basvur&Itemid=212'; 
    } else if (num == 2){
		form.action = 'index.php?option=com_belgelendirme_basvur&task=basvuruBitir&evrak_id=<?php echo $evrak_id;?>'; 
    }    
	form.submit(); 
}
</script>