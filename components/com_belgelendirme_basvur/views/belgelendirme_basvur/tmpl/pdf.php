

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
	$sinavMerkez = $this->sinavMerkez;
	$birlikteKurulus = $this->birlikteKurulus;
	$yetkiTalep	 = $this->yetkiTalep; 
	$personel 	 = $this->personel;			
	$egitim 	 = $this->egitim;			
	$sertifika 	 = $this->sertifika;
	$isDeneyim 	 = $this->isDeneyim;			
	$dil 		 = $this->dil;
	$basvuru_ekleri  = $this->basvuru_ekleri;
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
	
	echo "<div id=\"basvuru\">";
	?>
	<br />
	<table nobr="true" border="1" cellspacing="0" cellpadding="3">
		<!-- KURULUS BILGILERI -->
		<tr>
			<td colspan="2"><strong>1. İletişim Bilgileri</strong></td>
	  	</tr>
		<tr >
			<td><strong>Ad:</strong></td>
			<td><?php echo $kurulus["KURULUS_ADI"];?></td>
	  	</tr>
		<tr >
			<td rowspan="2"><strong>Adres:</strong></td>
			<td ><?php echo FormFactory2::ignoreBreaks($kurulus["KURULUS_ADRESI"]);?></td>
		</tr>
		<tr>		
			<td ><?php echo $kurulus["KURULUS_POSTA_KODU"]." ".$kurulus["IL_ADI"];?></td>
	  	</tr>
		<tr >
			<td ><strong>Telefon:</strong></td>
			<td ><?php echo $kurulus["KURULUS_TELEFON"];?></td>
	  	</tr>
		<tr >
			<td ><strong>Faks:</strong></td>
			<td ><?php echo $kurulus["KURULUS_FAKS"];?></td>
	  	</tr>
		<tr >
			<td ><strong>İnternet Adresi:</strong></td>
			<td ><?php echo $kurulus["KURULUS_WEB"];?></td>
	  	</tr>
		<tr >
			<td ><strong>E-posta:</strong></td>
			<td ><?php echo $kurulus["KURULUS_EPOSTA"];?></td>
	  	</tr>
		<tr >
			<td ><strong>Varsa Faaliyette Bulunduğu İller:</strong></td>
			<td ><?php echo implode (" , ", $iller);?></td>
	  	</tr>
  		<tr >
			<td ><strong>2.Kuruluşun Statüsü  </strong>(kamu, özel, meslek kuruluşu, dernek, vakıf, sendika, konfederasyon, kooperatif, birlik, vb.)</td>
	  		<td ><?php echo $kurulus["KURULUS_STATU_ADI"];?></td>
	  	</tr>
		<!-- KURULUS BILGILERI SONU	-->
  
  		<!-- SINAV ve BELGELENDIRME BIRIMI	-->
  		<tr>
			<td colspan="2"><strong>3.Sınav ve belgelendirme ile ilgili süreçlerde görev alacak birime ilişkin bilgiler</strong></td>
	  	</tr>
    	<tr >
			<td ><strong>Ad:</strong></td>
	  		<td ><?php echo $basvuru["GOREV_BIRIM_ADI"];?></td>
	  	</tr>
    	<tr >
			<td ><strong>Adres:</strong></td>
	  		<td ><?php echo $basvuru["GOREV_BIRIM_ADRESI"];?></td>
	  	</tr>
    	<tr >
			<td ><strong>Telefon:</strong></td>
	  		<td ><?php echo $basvuru["GOREV_BIRIM_TELEFON"];?></td>
	  	</tr>
    	<tr >
			<td ><strong>Faks:</strong></td>
	  		<td ><?php echo $basvuru["GOREV_BIRIM_FAKS"];?></td>
	  	</tr>
  		<tr >
			<td ><strong>İnternet Adresi:</strong></td>
			<td ><?php echo $basvuru["GOREV_BIRIM_WEB"];?></td>
	  	</tr>
		<tr >
			<td ><strong>E-posta:</strong></td>
			<td ><?php echo $basvuru["GOREV_BIRIM_EPOSTA"];?></td>
	  	</tr>
	  	<!-- SINAV ve BELGELENDIRME BIRIMI SONU -->
	  	</table>
	  	<table nobr="true" border="1" cellspacing="0" cellpadding="3">
	  	<!-- IRTIBAT BILGILERI	-->
  		<tr>
			<td rowspan="<?php echo count($irtibat);?>"><strong>4.İrtibat Kurulacak Kişi(ler) ve İletişim Bilgileri</strong></td>
			<td><?php echo '<strong>İrtibat Kurulacak Kişi:</strong>'.$irtibat[0]["IRTIBAT_KISI_ADI"].'<br/>
			<strong>E-Posta:</strong>'.$irtibat[0]["IRTIBAT_EPOSTA"].'<br/>
			<strong>Telefon:</strong>'.$irtibat[0]["IRTIBAT_TELEFON"].'<br/>
			<strong>Faks:</strong>'.$irtibat[0]["IRTIBAT_FAKS"].'<br/>'; ?></td>
	  	</tr>
	  	<?php 
	  		for($i=1;$i<count($irtibat);$i++){
	  			echo '<tr><td><strong>İrtibat Kurulacak Kişi:</strong>'.$irtibat[$i]["IRTIBAT_KISI_ADI"].'<br/>
			<strong>E-Posta:</strong>'.$irtibat[$i]["IRTIBAT_EPOSTA"].'<br/>
			<strong>Telefon:</strong>'.$irtibat[$i]["IRTIBAT_TELEFON"].'<br/>
			<strong>Faks:</strong>'.$irtibat[0]["IRTIBAT_FAKS"].'<br/></td></tr>';	
	  		}
	  	?>
	  	<!-- IRTIBAT BILGILERI SONU -->
 	
  	</table>
  	
  	<?php //echo "<br />";
  	echo '<div nobr="true">';
	echo tableHTML ("<strong>5. Faaliyet Gösterdiği Sektör(ler)</strong>", null, $titleWidth, 0);
	echo "<br />";?>
  	
  	<table nobr="true" border="1" cellspacing="0" cellpadding="3">
  		<tr>
			<td><strong>Faaliyet Gösterdiği Sektör(ler)</strong></td>
			<td><strong>Açıklama</strong></td>
	  	</tr>
	  	<?php 
	  		foreach($sektor as $row){
	  			echo '<tr><td>'.$row["SEKTOR_ADI"].'</td>
			<td>'.$row["SEKTOR_ACIKLAMA"].'</td></tr>';	
	  		}
	  	?>
 	
  	</table>
  	
    <?php
    echo '</div>'; 
//     echo borderBegin ();
//   	$irtibatCount = count($irtibat);
// 	for ($i = 0; $i < $irtibatCount; $i++){
// 		$data = $irtibat [$i];
		
// 		echo tableHTML ("<strong>İrtibat Kurulacak Kişi:</strong>", $data["IRTIBAT_KISI_ADI"]);
// 		echo tableHTML ("<strong>E-Posta</strong>", $data["IRTIBAT_EPOSTA"]);
// 		echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["IRTIBAT_TELEFON"], $tableHTMLWidth, 0), tableHTML ("<strong>Faks:</strong>", $data["IRTIBAT_FAKS"],$tWidth, 0), $width);
// 		if ($i < $irtibatCount-1)
// 			echo "<br />";
// 	}
// 	echo borderEnd ();
	
	//FAALIYET BILGILERI
// 	echo "<br />";
// 	echo tableHTML ("<strong>5. Faaliyet Gösterdiği Sektör(ler)</strong>", null, $titleWidth, 0);
// 	echo "<br />";
// 	//Sektor
// 	$titles   = array ("Faaliyet Gösterdiği Sektör(ler)", "Açıklama");
// 	$tableIds = array ("SEKTOR_ADI", "SEKTOR_ACIKLAMA");
// 	echo tablo ($titles, $tableIds, $sektor);
	echo "<br />";
	echo "<br />";
	
	//Faaliyet Alanları
	echo tableHTML ("<strong>6. Faaliyet Alanları</strong>", null, $titleWidth, 0);
	echo "<br />";
// 	$faaliyetCount = count($faaliyet);
// 	echo borderBegin ();
// 	for ($i = 0; $i < $faaliyetCount; $i++){
// 		$data = $faaliyet[$i];
// 		echo divHTML ($data["FALIYET_ALAN_ADI"]);
// 	}
// 	echo "<br />";
// 	echo borderEnd ();
?>
	<table nobr="true" border="1" cellspacing="0" cellpadding="3">
  		<tr>
  			<td>
			<?php 
	  		foreach($faaliyet as $row){
	  			echo $row["FALIYET_ALAN_ADI"].'<br/>';
	  		}
	  	?>
	  		</td>
	  	</tr>
  	</table>
<?php 
	echo "<br />";
	echo "<br />";
	
	//Faaliyet Suresi
	echo tableHTML ("<strong>7. Faaliyet Süresi</strong>"	, null, $titleWidth, 0);
	echo divHTML ($basvuru["FALIYET_SURE_ADI"]);
	echo "<br />";
	echo "<br />";
	echo '<div nobr="true">';
	echo tableHTML ("<strong>8.	Kuruluşun sürekli çalışan personel sayısı ile sınav ve belgelendirme faaliyetlerinde görev yapan personel sayısı : </strong>", null,$titleWidth, 0);
	echo divHTML ("Kuruluşun sürekli çalışan personel sayısı :".$basvuru["PERSONEL_SAYISI"]);
	echo divHTML ("Sınav ve belgelendirme faaliyetlerinde görev yapan personel sayısı :".$basvuru["EKIP_SAYISI"]);
	echo '</div>';
	echo "<br />";
	echo "<br />";
	echo '<div nobr="true">';
	echo tableHTML ("<strong>9.	Kuruluşun sınav ve belgelendirme faaliyetlerine ve yetkilendirilme talebine ilişkin bilgiler</strong>", null, $titleWidth, 0);
	echo "<br />";
// 	echo "<br />";
	echo tableHTML ("a)	Sınav ve belgelendirme yapılan yeterlilikler, kuruluşun sınav ve belgelendirme faaliyetlerine ne zaman başladığı ve sürekliliği, bir yılda alınan ortalama başvuru, yapılan sınav ve verilen belge sayıları gibi kuruluşun faaliyetlerini açıklayan bilgiler.", null, $titleWidth, 0);
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["KURULUS_TALEP_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo '</div>';
	echo "<br />";
	echo '<div nobr="true">';
	echo tableHTML ("b)	Yetki talep edilen yeterlilik(ler)", null, $titleWidth, 0);
	echo "<br />";
	//Yetki talep edilen yeterlilik
	$titles   = array ("Yeterliliğin Adı", "Kodu", "Seviyesi", "Verilmiş belge sayısı", "Gerçekleştirilmiş sınav sayısı");
	$tableIds = array ("YETERLILIK_ADI","YETERLILIK_KODU", "SEVIYE_ADI", "VERILEN_BELGE", "YAPILAN_SINAV");
	$width = array('30%','20%','15%','20%','20%');
	//echo tablo ($titles, $tableIds, $yetkiTalep,$width);
	?>
	<table nobr="true" border="1" cellspacing="0" cellpadding="3" style="text-align:center">
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
	  			echo '<tr><td width="30%">'.$row["YETERLILIK_ADI"].'</td>
			<td width="20%">'.$row["YETERLILIK_KODU"].'</td>
			<td width="13%">'.$row["SEVIYE_ADI"].'</td>
			<td width="20%">'.$row["VERILEN_BELGE"].'</td>
			<td width="22%">'.$row["YAPILAN_SINAV"].'</td></tr>';	
	  		}
	  	?>
 	
  	</table>
	<?php
	echo '</div>';
	echo "<br />";
	echo "<br />";
	
	//AKREDITASYON
	echo '<div id="akredit" nobr="true">';
	echo tableHTML ("<strong>10. Kuruluş akreditasyon bilgileri</strong>", null, $titleWidth, 0);
	echo "<br />";
	$akCount = count($akreditasyon);
	
	for ($i = 0; $i < $akCount; $i++){
		$data = $akreditasyon [$i];
		//echo borderBegin ();
		
		$aktable= '<table nobr="true" border="1" width="100%" cellpadding="3" cellspacing="0">
					<tr width="100%">
						<td width="50%"><strong>Yetki talep edilen ve akredite olunan ulusal yeterlilik</strong></td>
						<td width="50%">'. $data["AKREDITASYON_ADI"].'</td>
				  	</tr>
					<tr width="100%">
						<td width="50%"><strong>Yeterlilik seviyesi/seviyeleri</strong></td>
						<td width="50%">'. $data["AKREDITASYON_SEVIYE"].'</td>
				  	</tr>
					<tr width="100%">
						<td width="50%"><strong>Akreditasyon kuruluşu ve akreditasyon standardı</strong></td>
						<td width="50%">'. $data["AKREDITASYON_STANDARDI"].'</td>
				  	</tr>
					<tr width="100%">
						<td width="50%"><strong>Akreditasyon tarihi ve akreditasyon geçerlilik tarihi</strong></td>
						<td width="50%">'. $data["AKREDITASYON_BASLANGIC"].' - '.$data["AKREDITASYON_BITIS"].'</td>
				  	</tr>
					<tr width="100%">
						<td width="50%"><strong>Yetki talep edilen yeterlilikte gerçekleştirilen en son denetim tarihi</strong></td>
						<td width="50%">'. $data["AKREDITASYON_DENETIM"].'</td>
				  	</tr>
					<tr width="100%">
						<td width="50%"><strong>Yetki talep edilen ulusal yeterliliğin akreditasyon kapsamına alındığı tarih</strong></td>
						<td width="50%">'. $data["AKREDITASYON_KAPSAM"].'</td>
				  	</tr>
			  	</table>';
		


		echo $aktable;
// 		echo "<dt> </dt><dd>".$aktable."</dd>";
// 		echo tableHTMLBorder ("Yetki talep edilen ve akredite olunan ulusal yeterlilik", $data["AKREDITASYON_ADI"],'50%');
// 		echo tableHTMLBorder ("Yeterlilik seviyesi/seviyeleri", $data["AKREDITASYON_SEVIYE"],'50%');
// 		echo tableHTMLBorder ("Akreditasyon kuruluşu ve akreditasyon standardı", $data["AKREDITASYON_STANDARDI"],'50%');	
// 		echo tableHTMLBorder ("Akreditasyon başlangıç tarihi"	, $data["AKREDITASYON_BASLANGIC"],'50%');
// 		echo tableHTMLBorder ("Akreditasyon bitiş tarihi"	, $data["AKREDITASYON_BITIS"],'50%');
// 		echo tableHTMLBorder ("Yetki talep edilen yeterlilikte gerçekleştirilen en son denetim tarihi", $data["AKREDITASYON_DENETIM"],'50%');
// 		echo tableHTMLBorder ("Yetki talep edilen ulusal yeterliliğin akreditasyon kapsamına alındığı tarih", $data["AKREDITASYON_KAPSAM"],'50%');
		
		echo "<br />";
		//echo borderEnd ();
	}
	echo "</div>";
	echo "<br />";
	
	echo '<div id="sinavMer" nobr="true">';
	echo tableHTML ("<strong>11. Kuruluşun sınavlarını gerçekleştireceği merkez(ler):</strong>", null, $titleWidth, 0);
	echo "<br />";
	$titles   = array ("Sınav Merkezi","Sınav yapılan yeterlilik(ler)", "Sınavın şekli", "Sınav merkezinin tasarrufu", "Merkezin adres ve iletişim bilgileri");
	$tableIds = array ("MERKEZ_ADI", "YETERLILIK_ADI", "SINAV_SEKLI_ADI", "MERKEZ_TEMIN_ADI", "MERKEZ_ADRESI");
	//echo tablo ($titles, $tableIds, $sinavMerkez);
	?>
	<table border="1" cellspacing="0" cellpadding="3" style="text-align:center">
  		<tr>
		    <td width="20%"><strong>Sınav Merkezi</strong></td>
		    <td width="30%"><strong>Sınav yapılan yeterlilik(ler)</strong></td>
		    <td width="13%"><strong>Sınavın şekli</strong></td>
		    <td width="20%"><strong>Sınav merkezinin tasarrufu</strong></td>
		    <td width="22%"><strong>Merkezin adres ve iletişim bilgileri</strong></td>
		  </tr>
	  	<?php 
	  		foreach($sinavMerkez as $row){
	  			echo '<tr nobr="true"><td width="20%">'.$row["MERKEZ_ADI"].'</td>
			<td width="30%">'.$row["YETERLILIK_ADI"].' ('.$row["YETERLILIK_KODU"].')</td>
			<td width="13%">'.$row["SINAV_SEKLI_ADI"].'</td>
			<td width="20%">'.$row["MERKEZ_TEMIN_ADI"].'</td>
			<td width="22%">'.$row["MERKEZ_ADRESI"].'</td></tr>';	
	  		}
	  	?>
 	
  	</table>
	
	<?php 
	echo "<br />";
	echo '</div>';
	echo "<br />";
	echo '<div nobr="true">';
	echo tableHTML ("<strong>12. Kuruluşun sınavlarını gerçekleştireceği gezici sınav birim(ler)i var mı?</strong>", null, $titleWidth, 0);
	if ($basvuru["GEZICI_BIRIM"] != null){
		echo divHTML("Evet");
		echo "<br />";
		echo tableHTML ("<strong>13. Gezici sınav birim(ler)inde sınavlar için gerekli altyapının oluşturulması, şeffaf ve güvenilir bir sınavın gerçekleştirilmesi ve sınav için gerekli özel şartlar var ise bu şartların karşılanması için alınan önlemler:</strong>", null, $titleWidth, 0);
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["GEZICI_BIRIM"]);
		echo "<br />";
		echo borderEnd ();
	}else{
		echo divHTML("Hayır");
	}
	echo '</div>';
	echo "<br />";
	
	//Birlikte Kurulus
	echo '<div nobr="true">';
	$kurulusCount = count ($birlikteKurulus);
	if ($kurulusCount > 0){
		echo tableHTML ("<strong>14. Sınav ve belgelendirme sürecinde dışarıdan hizmet alımı yapılan/yapılması planlanan kurum/kuruluş(lar) var mı?</strong>", null, $titleWidth, 0);
		echo divHTML("Evet");
		echo "<br />";
		echo tableHTML ("Dışarıdan hizmet alımı yapılması planlanan kurum/kuruluşun", null, $titleWidth, 0);
		echo borderBegin ();
		echo "<br />";
		for ($i = 0; $i < $kurulusCount; $i++){
			$data = $birlikteKurulus [$i];
			?>
			<table cellpadding="3">
			  <tr>
			    <td><strong>Adı:</strong></td>
			    <td><?php echo $data["BIRLIKTE_KURULUS_ADI"]; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Statüsü:</strong></td>
			    <td><?php echo $data["KURULUS_STATU_ADI"];?></td>
			  </tr>
			  <tr>
			    <td><strong>Yetkilisi:</strong></td>
			    <td><?php echo $data["BIRLIKTE_KURULUS_YETKILISI"]; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Adresi:</strong></td>
			    <td><?php echo $data["BIRLIKTE_KURULUS_ADRES"];?></td>
			  </tr>
			  <tr>
			    <td><strong>Posta Kodu:</strong> <?php echo $data["BIRLIKTE_KURULUS_POSTAKOD"];?></td>
			    <td><strong>Şehir:</strong><?php echo $data["IL_ADI"];?></td>
			  </tr>
			  <tr>
			    <td><strong>Telefon:</strong><?php echo $data["BIRLIKTE_KURULUS_TELEFON"];?></td>
			    <td><strong>Faks:</strong><?php echo $data["BIRLIKTE_KURULUS_FAKS"];?></td>
			  </tr>
			  <tr>
			    <td><strong>E-Posta:</strong><?php echo $data["BIRLIKTE_KURULUS_EPOSTA"];?></td>
			    <td><strong>Web:</strong><?php echo $data["BIRLIKTE_KURULUS_WEB"];?></td>
			  </tr>
			  <tr>
			    <td><strong>Alınması Planlanan Hizmetler:</strong></td>
			    <td><?php echo $data["BIRLIKTE_KURULUS_HIZMET"];?></td>
			  </tr>
			</table>

			<?php
			
			//echo tableHTML ("<strong>Kuruluşun</strong>" , null);
// 			echo tableHTML ("<strong>Adı:</strong>"		 , $data["BIRLIKTE_KURULUS_ADI"]);
// 			echo tableHTML ("<strong>Statüsü:</strong>"	 , $data["KURULUS_STATU_ADI"]);
// 			echo tableHTML ("<strong>Yetkilisi:</strong>", $data["BIRLIKTE_KURULUS_YETKILISI"]);	
// 			echo tableHTML ("<strong>Adresi:</strong>"	 , $data["BIRLIKTE_KURULUS_ADRES"]);
// 			echo tableHTML (tableHTML ("<strong>Posta Kodu:</strong>", $data["BIRLIKTE_KURULUS_POSTAKOD"], $tableHTMLWidth , 0), tableHTML ("<strong>Şehir:</strong>", $data["IL_ADI"],$tWidth, 0), $width);
// 			echo tableHTML (tableHTML ("<strong>Telefon:</strong>", $data["BIRLIKTE_KURULUS_TELEFON"], $tableHTMLWidth , 0), tableHTML ("<strong>Faks:</strong>", $data["BIRLIKTE_KURULUS_FAKS"],$tWidth, 0), $width);
// 			echo tableHTML (tableHTML ("<strong>E-Posta:</strong>", $data["BIRLIKTE_KURULUS_EPOSTA"], $tableHTMLWidth , 0),tableHTML ("<strong>Web:</strong>", $data["BIRLIKTE_KURULUS_WEB"],$tWidth, 0), $width);
// 			echo tableHTML ("Alınması Planlanan Hizmetler" , $data["BIRLIKTE_KURULUS_HIZMET"]);
			echo "<br />";
		}
	}else{
		echo tableHTML ("<strong>14. Sınav ve belgelendirme sürecinde dışarıdan hizmet alımı yapılan/yapılması planlanan kurum/kuruluş(lar) var mı?</strong>", null, $titleWidth, 0);
		echo divHTML("Hayır");
		echo "<br />";
	}
	
	if ($kurulusCount > 0){
			echo borderEnd ();
		}
	echo '</div>';
	echo "<br />";
	echo '<div nobr="true">';
	echo tableHTML ("<strong>15. Sınav ve belgelendirme yapılan alanlarla ilgili eğitim veriliyor mu?</strong>", null, $titleWidth,0);
	if ($basvuru["EGITIM_ACIKLAMA"] != null){
		echo divHTML("Evet");
		echo "<br />";
		
		echo tableHTML ("<strong>16. Eğitim ve belgelendirme faaliyetlerinin ayırımı konusunda alınan tedbirler:</strong>", null, $titleWidth, 0 );
		echo "<br />";
		echo borderBegin ();
		echo divHTML($basvuru["EGITIM_ACIKLAMA"]);
		echo "<br />";
		echo borderEnd ();
	}else{
		echo divHTML("Hayır");
	}
	echo '</div>';
	echo "<br />";
	echo "<br />";

	echo '<div nobr="true">';
	echo tableHTML ("<strong>17. Sınav ve belgelendirme çalışmaları için tahsis edilen kaynaklar, teknik ve fiziki altyapı imkânları:</strong>", null, $titleWidth, 0 );
	echo "<br />";
	echo borderBegin ();
	echo divHTML($basvuru["TEKNIK_FIZIKI_ACIKLAMA"]);
	echo "<br />";
	echo borderEnd ();
	echo "<br />";
	echo "<br />";
	echo '</div>';
	?>
	
	<?php 
	echo "</div>";
	
	echo '<div nobr="true">';
	echo "<div style='float:center;text-align:center;'><dt> </dt><dd><strong>".FormFactory2::ignoreBreaks('BAŞVURAN KURULUŞ TARAFINDAN BAŞVURU FORMU EKİNDE VERİLEN BİLGİ VE BELGELER')."</strong></dd></div>";
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
	<?php 
	echo "</div>";
	
	echo "<div id=\"ek\">";
// 	echo blockTitle ("EK 1. SINAV VE BELGELENDİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center", 0);
	
// 	for ($i = 0; $i < count($personel); $i++){
// 		echo "<div id=\"personel_".$i."\">";
// 		echo tableHTML ("<strong>1. Kişisel Bilgiler</strong>", null, $titleWidth);
// 		echo "<br />";
// 		echo borderBegin ();
// 		echo tableHTML ("<strong>T.C. Kimlik No /<br /> Pasaport No:</strong>", $personel[$i]["GOREVLI_PERSONEL_KIMLIK_NO"]);
// 		echo tableHTML ("<strong>Adı:</strong>", $personel[$i]["GOREVLI_PERSONEL_ADI"]);
// 		echo tableHTML ("<strong>Soyadı:</strong>", $personel[$i]["GOREVLI_PERSONEL_SOYAD"]);
// 		echo tableHTML ("<strong>Telefon:</strong>", $personel[$i]["GOREVLI_PERSONEL_TELEFON"]);
// 		echo tableHTML ("<strong>Faks:</strong>", $personel[$i]["GOREVLI_PERSONEL_FAKS"]);
// 		echo tableHTML ("<strong>E-Posta:</strong>", $personel[$i]["GOREVLI_PERSONEL_EPOSTA"]);
// 		echo tableHTML ("<strong>Öğrenim Durumu:</strong>", $personel[$i]["GOREVLI_PERSONEL_OGRENIM"]);
// 		echo tableHTML ("<strong>Mesleği:</strong>", $personel[$i]["GOREVLI_PERSONEL_MESLEK"]);
// 		echo tableHTML ("<strong>Görevi:</strong>", $personel[$i]["GOREVLI_PERSONEL_UZMANLIK"]);
// 		echo tableHTML ("<strong>Sınavlarda görev<br />alacaklar için<br />görev alacağı yeterlilikler:</strong>", $personel[$i]["GOREVLI_PERSONEL_YETERLILIK"]);
// 		echo "<br />";
// 		echo borderEnd ();
// 		echo "<br />";
		
// 		echo tableHTML ("<strong>2. Öğrenim</strong>", null, $titleWidth);
// 		echo "<br />";
// 		$titles   = array ("Başlangıç Tarihi", "Bitiş Tarihi", "Eğitim Kurumu/Bölüm Adı");
// 		$tableIds = array ("EGITIM_BASLANGIC", "EGITIM_BITIS", "EGITIM_YERI");
// 		$egitimA = getPersonelArr ($egitim, $tableIds);
// 		if (isset ($egitimA[$i]))
// 			echo tablo ($titles, $tableIds, $egitimA[$i]);
// 		echo "<br />";
		
// 		echo tableHTML ("<strong>3. Yetkinliklere ilişkin diğer sertifika/belgeler</strong>", null, $titleWidth);
// 		echo "<br />";
// 		$titles   = array ("Belge Adı", "Belge Alınan Yer", "Belge Alınma Tarihi", "Belge Hakkında Açıklayıcı Not");
// 		$tableIds = array ("SERTIFIKA_ADI", "SERTIFIKA_YER", "SERTIFIKA_TARIH", "SERTIFIKA_ACIKLAMA");
// 		$sertifikaA = getPersonelArr ($sertifika, $tableIds);
// 		if (isset ($sertifikaA[$i]))
// 			echo tablo ($titles, $tableIds, $sertifikaA[$i]);
// 		echo "<br />";
		
// 		echo tableHTML ("<strong>4. Yeterlilik geliştirme sürecine ilişkin  alınan eğitimler/özel deneyimler</strong>", null, $titleWidth);
// 		echo "<br />";
// 		echo borderBegin ();
// 		echo divHTML($personel[$i]["GOREVLI_PERSONEL_DENEYIM"]);
// 		echo "<br />";
// 		echo borderEnd ();
// 		echo "<br />";
		
// 		echo tableHTML ("<strong>5. İş Deneyimi</strong>", null, $titleWidth);
// 		echo "<br />";
// 		$titles   = array ("Başlangıç Tarihi", "Bitiş Tarihi", "İşyeri", "Unvan", "İş Tanımı");
// 		$tableIds = array ("DENEYIM_BASLANGIC", "DENEYIM_BITIS", "DENEYIM_ISYERI", "DENEYIM_UNVAN", "DENEYIM_ISTANIMI");
// 		$isDeneyimA = getPersonelArr ($isDeneyim, $tableIds);
// 		if (isset ($isDeneyimA[$i]))
// 			echo tablo ($titles, $tableIds, $isDeneyimA[$i]);
// 		echo "<br />";
		
// 		echo tableHTML ("<strong>6. Yabancı Dil Bilgisi</strong>", null, $titleWidth);
// 		echo "<br />";
// 		$titles   = array ("Yabancı Dil", "Okuma", "Konuşma", "Yazma", "Anlama");
// 		$tableIds = array ("DIL_ADI", "DIL_DERECESI");
// 		$dilA = getPersonelArr ($dil, $tableIds, 1);
// 		$tableIds = array ("DIL_ADI", "DIL_DERECESI_1", "DIL_DERECESI_2", "DIL_DERECESI_3", "DIL_DERECESI_4");
// 		echo tablo ($titles, $tableIds, $dilA[$i]);
// 		echo "</div>";
// 		echo "<br />";
// 		//echo "<br clear=all style='page-break-before:always'>";
// 	}

	echo "</div>";
	

	function tableHTML ($title, $data, $width=120, $tab = 1){
		$table = '<table nobr="true" cellspacing="0" cellpadding="3">
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
	
	function tableHTMLBorder ($title, $data, $width=120, $tab = 1){
		$table = '<table nobr="true" border="1">
					<tr >
						<td width="'.$width.'"><strong>'.$title.'</strong></td>
						<td >'.$data.'</td>
				  	</tr>
			  	</table>';
	
		if ($tab)
			return "<dt> </dt><dd>".$table."</dd>";
		else
			return $table;
	}
	

	
	function blockTitle ($title, $align="left", $tab = 1){
		$titleHTML = '<h3 style="font-size:15px;text-align:'.$align.'">'.$title.'</h3>';
		if ($tab)
			return '<dt> </dt><dd>'.$titleHTML.'</dd>';
		else
			return $titleHTML;
	}
	
	function tablo ($paramTitles, $paramIds, $params,$width=0){	
		$html = '';
		$colCount = count($paramTitles);

		if(is_array($width)){
			$title = "<tr>";
			for ($i = 0; $i < $colCount; $i++){
				$title .= '<td width="'.$width[$i].'" style="text-align:center"><strong><br />'.$paramTitles[$i].'<br /></strong></td>';
			}
			$title .= "</tr>";
			
			$htmlPart = "";
			for ($i = 0; $i < count($params); $i++){
				$data = $params[$i];
				$part = "<tr>";
				for ($j = 0; $j < count($paramIds); $j++){
					$part .= '<td width="'.$width[$j].'" style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramIds[$j]].'</dd><dd></dd></td>';
				}
				$part .= "</tr>";
			
				$htmlPart .= $part;
			}
		}
		else{
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
		}
		$html .= '<table nobr="true" border="1" style="width:100%;">
						<tbody>'.
							$title.$htmlPart 
						.'</tbody>
					</table>';		
		return $html;
	}
	
	function divHTML ($data){
		return "<div><dt> </dt><dd>".FormFactory2::ignoreBreaks($data)."</dd></div>";
	}
	
	function  borderBegin (){
		return '<table nobr="true" border="1"><tr><td>';
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
	
	function statikHTML ($paramTitle, $param){
		$html = '<div style = "height:auto; padding:5px;">
				<span><strong>'.
					$paramTitle
					.'</strong></span>
			</div><br />';
	
		if (strlen($param) != 0){
			$html .= '<div style = "height:auto; padding: 5px 5px 5px 10px;">
					<span style="text-align:justify;">'.FormFactory::ignoreBreaks($param).'</span>
				  </div>';
		}
	
		return $html;
	}
	
?>