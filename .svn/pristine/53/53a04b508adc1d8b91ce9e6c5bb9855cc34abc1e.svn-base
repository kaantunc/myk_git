<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	$user 	= &JFactory::getUser();
	$yeterlilikBilgi	= $this->yeterlilikBilgi;
	$taslakYeterlilik 	= $this->taslakYeterlilik;
	$standart 			= $this->standart;
	$kaynakMeslek		= $this->kaynakMeslek;
	$kaynakBirim		= $this->kaynakBirim;
	$zorunluBirim 		= $this->zorunluBirim;
	$secmeliBirim 		= $this->secmeliBirim;
	$bilgi				= $this->bilgi;
	$beceri				= $this->beceri;
	$yetkinlik			= $this->yetkinlik;
	$teorikOlcme 		= $this->teorikOlcme;
	$performansOlcme 	= $this->performansOlcme;
	$gelistiren_kurulus = $this->gelistiren_kurulus;
	$katki_kurulus		= $this->katki_kurulus;
	//EKLER
	$terim				= $this->terim;
	$birim_bilgi		= $this->birim_bilgi;
	$birim_beceri		= $this->birim_beceri;
	$birim_yetkinlik	= $this->birim_yetkinlik;
	$gorus_kurulus		= $this->gorus_kurulus;
	$canOpenEkler		= $this->canOpenEkler;

?>	
	<div id="taslak">
	<table border="1">
		<?php 
		$count = 1;
		$data = "";
		echo tableRow ($count++, "YETERLİLİĞİN ADI:", "&nbsp;".$yeterlilikBilgi["YETERLILIK_ADI"]);
		echo tableRow ($count++, "REFERANS KODU:",  "&nbsp;".$yeterlilikBilgi["YETERLILIK_KODU"]);
		echo tableRow ($count++, "SEVİYESİ:", "&nbsp;".substr($yeterlilikBilgi["SEVIYE_ADI"],7,1));		
		echo tableRow ($count++, "TÜRÜ:", "&nbsp;-");
		echo tableRow ($count++, "KREDİ DEĞERİ:", "&nbsp;-");
		echo tableRow ($count++, "A)YAYIN TARİHİ:<br />B)REVİZYON NO:<br/>C)REVİZYON TARİHİ:", "&nbsp;".$yeterlilikBilgi["YAYIN_TARIHI"]."<br />"."&nbsp;".$yeterlilikBilgi["REVIZYON_NO"]."<br />"."&nbsp;".$yeterlilikBilgi["REVIZYON_TARIHI"]);
		$standartHTML = "";
		if ($standart != null){
			foreach ($standart as $row){
				$standartHTML .= statikTabloHTML ("&nbsp;".$row["STANDART_ADI"].": "	, $row["STANDART_ACIKLAMA"]);
				//$standartHTML .= "<br />";
			}
		}
		echo tableRow ($count++, "ULUSLARARASI SINIFLAMADAKİ YERİ:",$standartHTML);
		echo tableRow ($count++, "AMACI ve GEREKÇESİ:", "&nbsp;".$taslakYeterlilik["YETERLILIK_AMAC"]);
		echo tableRow ($count++, "İLGİLİ OLDUĞU SEKTÖR:", "&nbsp;".$yeterlilikBilgi["SEKTOR_ADI"]);
		$kaynakMeslekHTML = "";
		if ($kaynakMeslek != null){
			foreach ($kaynakMeslek as $row){
				if ($row["KAYNAK_ID"] == -1)
					$kaynakMeslekHTML .= statikTabloHTML ("", $row["KAYNAK_ACIKLAMA"]);
				else
				//MYK/ 09UMS0006-4 Referans Kodlu Bacacı-Seviye-4 Meslek Standardı
					$kaynakMeslekHTML .=  statikTabloHTML ("","MYK/ ".getStandartKodu($row["KAYNAK_ID"])." Referans Kodlu ".getStandartAdi($row["KAYNAK_ID"])."-Seviye-".getStandartSeviye($row["KAYNAK_ID"])." Meslek Standardı");
					
				//$kaynakMeslekHTML .= "<br />";
			}
		}	
		echo tableRowTitle ($count++, "YETERLİLİĞE KAYNAK TEŞKİL EDEN MESLEK STANDARDI");
		echo tableRowData ($kaynakMeslekHTML);
		$kaynakBirimHTML = "";
		if ($kaynakBirim != null){
			foreach ($kaynakBirim as $row){
				if ($row["KAYNAK_ID"] == -1)
					$kaynakBirimHTML .= statikTabloHTML ("", $row["KAYNAK_ACIKLAMA"]);
				else
					$kaynakBirimHTML .= statikTabloHTML ("", getYeterlilikAltBirimAdi($row["KAYNAK_ID"]));
				
				//$kaynakBirimHTML .= "<br />";
			}
		}
		echo tableRowTitle ($count++, "YETERLİLİĞE KAYNAK TEŞKİL EDEN YETERLİLİK BİRİM/BİRİMLERİ");
		echo tableRowData ($kaynakBirimHTML);
		echo tableRowTitle ($count++, "YETERLİLİĞİ OLUŞTURAN YETERLİLİK BİRİMLERİ");
		$zorunluBirimHTML = "<span><strong>Grup A: Zorunlu Yeterlilik Birimleri</strong></span>";
		if($taslakYeterlilik["ZORUNLU_ACIKLAMA"]) $zorunluBirimHTML .= "<br />".nl2br($taslakYeterlilik["ZORUNLU_ACIKLAMA"]). "<br />";
		if ($zorunluBirim != null){
			foreach ($zorunluBirim as $row){
				$zorunluBirimHTML .= statikTabloHTML ($row["YETERLILIK_ALT_BIRIM_NO"].") "	, $row["YETERLILIK_ALT_BIRIM_ADI"]);
				//$zorunluBirimHTML .= "<br />";
			}
		}
		$secmeliBirimHTML = "<span><strong>Grup B: Seçmeli Yeterlilik Birimleri</strong></span>";
		if($taslakYeterlilik["SECMELI_ACIKLAMA"]) $secmeliBirimHTML .= "<br />".nl2br($taslakYeterlilik["SECMELI_ACIKLAMA"]). "<br />";
		if ($secmeliBirim != null){
			foreach ($secmeliBirim as $row){
				$secmeliBirimHTML .= statikTabloHTML ($row["YETERLILIK_ALT_BIRIM_NO"].") "	, $row["YETERLILIK_ALT_BIRIM_ADI"]);
				//$secmeliBirimHTML .= "<br />";
			}
		}
		echo tableRowData ($zorunluBirimHTML."<br />".$secmeliBirimHTML);
		echo tableRowTitle ($count++, "BİRİMLERİN GRUPLANDIRMA ALTERNATİFLERİ");
		echo tableRowData ($taslakYeterlilik["YETERLILIK_GRUP_ALTERNATIF"]);
		echo tableRowTitle ($count++, "YETERLİLİK İÇİN GEREKLİ EĞİTİM ŞARTININ");
		// Pdf'teki new line sorununu cozmek icin,
		// nl2br( ) kullanılarak '\n' karakterleri '</br>' karakterleriyle değiştirildi:
		echo tableRowDataTitle ("A) ŞEKLİ", nl2br($taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"]));
		echo tableRowDataTitle ("B) İÇERİĞİ", nl2br($taslakYeterlilik["YETERLILIK_EGITIM_ICERIK"]));
		echo tableRowDataTitle ("C) SÜRESİ", nl2br($taslakYeterlilik["YETERLILIK_EGITIM_SURE"]));
		echo tableRowTitle ($count++, "YETERLİLİK İÇİN GEREKLİ DENEYİM ŞARTININ");
		echo tableRowDataTitle ("A) NİTELİĞİ", nl2br($taslakYeterlilik["YETERLILIK_DENEYIM_NITELIK"]));
		echo tableRowDataTitle ("B) SÜRESİ", nl2br($taslakYeterlilik["YETERLILIK_DENEYIM_SURE"]));
		//BILGI
		$bilgiHTML = "<ul>";
		if ($bilgi != null){
			$i = 1;
			foreach ($bilgi as $row){
				//$bilgiHTML .= statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				$bilgiHTML .= "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				//$bilgiHTML .= "<br />";
			}
		}
		$bilgiHTML .= "</ul>";
		//BECERI
		$beceriHTML = "<ul>";
		if ($beceri != null){
			$i = 1;
			foreach ($beceri as $row){
				//$beceriHTML .= statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				$beceriHTML .= "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				//$beceriHTML .= "<br />";
			}
		}
		$beceriHTML .= "</ul>";
		//YETKINLIKLER
		$yetkinlikHTML = "<ul>";
		if ($yetkinlik != null){
			$i = 1;
			foreach ($yetkinlik as $row){
				//$yetkinlikHTML .= statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				$yetkinlikHTML .= "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				//$yetkinlikHTML .= "<br />";
			}
		}
		$yetkinlikHTML .= "</ul>";
		echo tableRowTitle ($count++, "SAHİP OLUNMASI GEREKEN ÖĞRENME ÇIKTILARI");
?>
		<!--<table border="1">-->
			<tr>
				<td align="center" style="background-color:RGB(238, 236, 225);">BİLGİLER</td>
				<td align="center" style="background-color:RGB(238, 236, 225);">BECERİLER</td>
				<td align="center" style="background-color:RGB(238, 236, 225);">YETKİNLİKLER</td>
			</tr>
			<tr>
				<td align="center" valign="middle"><?php echo $bilgiHTML;?></td>
				<td align="center" valign="middle"><?php echo $beceriHTML;?></td>
				<td align="center" valign="middle"><?php echo $yetkinlikHTML;?></td>
			</tr>
		<!--</table>-->
<?php 
		echo tableRowTitle ($count++, "ÇALIŞMA ORTAMI VE KOŞULLARI");
		echo tableRowData (nl2br($taslakYeterlilik["YETERLILIK_ORTAM"]));
		echo tableRowTitle ($count++, "YETERLİLİK İÇİN UYGULANACAK SINAV VE DEĞERLENDİRMEYE İLİŞKİN BİLGİLER");
		echo tableRowData ("A) SINAV VE DEĞERLENDİRME ARAÇLARINA İLİŞKİN BİLGİLER");
?>
		<table border="1">
			<tr>
				<td></td>
				<td>Değerlendirme Araçları</td>
				<td>Değerlendirme Materyalleri</td>
				<td>Puanlama</td>
				<td>Başarı Ölçütü</td>
				<td>Gerekli Görülen Diğer Şartlar</td>
			</tr>
			<tr>
				<td rowspan="<?php echo count($teorikOlcme);?>">Teorik ölçme araçları</td>
<?php 
			if (count($teorikOlcme) == 0){
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</tr>";
			}else {
				$counter = 0;
				foreach ($teorikOlcme as $row){
					if($counter != 0) echo "<tr>";
					
					echo "<td align="."center".">".$row["DEGERLENDIRME_ARAC_ADI"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_MATERYAL"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_PUANLAMA"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_BASARI_OLCUT"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_DIGER"]."</td>";
					echo "</tr>";
					$counter++;
				}
			}
?>
			
			<tr>
				<td rowspan="<?php echo count($performansOlcme);?>">Performansa dayalı araçları</td>
<?php 
			if (count($performansOlcme) == 0){
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</tr>";
			}else {
				$counter = 0;
				foreach ($performansOlcme as $row){
					if($counter != 0) echo "<tr>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_ARAC_ADI"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_MATERYAL"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_PUANLAMA"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_BASARI_OLCUT"]."</td>";
					echo "<td align="."center".">".$row["DEGERLENDIRME_DIGER"]."</td>";
					echo "</tr>";
					$counter++;
				}
			}
?>
			<tr>
				<td>Sınav ve Değerlendirme Araçlarıyla İlgili Diğer Koşullar</td>
				<td colspan=5 align="center"><?php echo nl2br($taslakYeterlilik["YETERLILIK_DIGER"])?></td>
			</tr>
		</table>

<?php 
		echo tableRowData ("B) DEĞERLENDİRİCİ ÖLÇÜTLERİ");
		echo tableRowData (nl2br($taslakYeterlilik["YETERLILIK_DEGERLENDIRICI"]));
		echo tableRow ($count++, "YETERLİLİK BELGESİNİN GEÇERLİLİK SÜRESİ", nl2br($taslakYeterlilik["YETERLILIK_GECERLILIK_SURE"]));
		echo tableRow ($count++, "BELGE SAHİBİNİN GÖZETİMİNDE UYGULANACAK PERFORMANS İZLEME METODLARI VE BELGE SAHİBİNİN GÖZETİM SIKLIĞI", nl2br($taslakYeterlilik["YETERLILIK_METHOD_GOZETIM"]));
		echo tableRow ($count++, "GEÇERLİLİK SÜRESİ DOLAN BELGELERİN YENİLENMESİNDE UYGULANACAK DEĞERLENDİRME YÖNTEMLERİ", nl2br($taslakYeterlilik["YETERLILIK_DEG_YONTEM"]));
		$katkiKurulusHTML = "";
		if ($katki_kurulus != null){
			$i = 1;
			foreach ($katki_kurulus as $row){
				$katkiKurulusHTML .= statikTabloHTML ($i++.". ", $row["YETERLILIK_KURULUS_ADI"]);
				//$katkiKurulusHTML .= "<br />";
			}
		}
	//katkı kuruluş yerine geliştiren kuruluş yazılmalıydı - Azat
		$gelistirenKurulusHTML = "";
		if ($gelistiren_kurulus != null){
			$i = 1;
			foreach ($gelistiren_kurulus as $row){
				if (count($gelistiren_kurulus) == 1)
					$gelistirenKurulusHTML .= statikTabloHTML (" ", $row["YETERLILIK_KURULUS_ADI"]);
								
				else
					$gelistirenKurulusHTML .= statikTabloHTML ($i++.". ", $row["YETERLILIK_KURULUS_ADI"]);
				//$katkiKurulusHTML .= "<br />";
			}
		}
		echo tableRow ($count++, "YETERLİLİĞİ GELİŞTİREN KURULUŞ(LAR)", $gelistirenKurulusHTML);
		echo tableRow ($count++, "YETERLİLİĞİ DOĞRULAYAN SEKTÖR KOMİTESİ", "MYK ".$yeterlilikBilgi["SEKTOR_ADI"]." Sektör Komitesi");
		$tarih = ($yeterlilikBilgi["KARAR_TARIHI"]) ? $yeterlilikBilgi["KARAR_TARIHI"] : ".......";
		$sayi  = ($yeterlilikBilgi["KARAR_SAYI"]) ? $yeterlilikBilgi["KARAR_SAYI"] : ".......";
		echo tableRow ($count++, "MYK YÖNETİM KURULU ONAY TARİH VE SAYISI", $tarih." tarih ve ".$sayi." sayılı karar");
		?>
	</table>
	</div>
<?php 
	//EKLER
	
	echo '<div id="ek1">';
	echo '<h3 style="text-align:center;">EK1 :</h3>';
	echo '<span style="text-align:center;">Terimler, Simgeler ve Kısaltmalar</span><br />';
	if($taslakYeterlilik["TERIM_ACIKLAMA"]) echo "<br />".nl2br($taslakYeterlilik["TERIM_ACIKLAMA"]). "<br />";
	if ($terim != null){
		foreach ($terim as $row){
			echo statikTabloHTML ($row["TERIM_ADI"].": "	, $row["TERIM_ACIKLAMA"]);
			echo "<br />";
		}
	}
	echo "ifade eder.";
	echo '</div>';

	echo '<div id="ek2">';
	echo '<h3 style="text-align:center;">EK2 :</h3>';
	echo '<span style="text-align:center;">Yeterliliği Oluşturan Yeterlilik Birimlerine İlişkin Tablo</span><br />';

	if ($birim_bilgi != null){
		$newBirimBilgi 		= convertBirimBeceriYetkinlik2DArray ($birim_bilgi);
		$newBirimBeceri 	= convertBirimBeceriYetkinlik2DArray ($birim_beceri);
		$newBirimYetkinlik	= convertBirimBeceriYetkinlik2DArray ($birim_yetkinlik);
		
		$table			 = "";
		$tablePart  	 = "";
		$tableNoRow 	 = "";
		$tableAdRow 	 = "";
		$tableSeviyeRow  = "";
		$tableKrediRow 	 = "";
		$tableOgrenmeRow = "";
		$tableBilgiRow	 = "";
		$tableBeceriRow	 = "";
		$tableYetRow	 = "";
		//$colCount = 3;
		$colCount = 3;
		$yetBilgiColCount = 4;
		for ($i = 0; $i < count ($newBirimBilgi); $i++){
			// $İ=0,3,6 degerlerinde calisacak.$i != 0 degerinde eski tabloyu kapat
			// yeni tablo olustur. Boylece yanyana en fazla 3 tane birime ait bilgiler goruntulenecek.
			if ($i%$colCount == 0){
				if ($i != 0){
					$tableNoRow 	.= "</tr>";
					$tableAdRow 	.= "</tr>";
					$tableSeviyeRow .= "</tr>";
					$tableKrediRow  .= "</tr>";
					$tableOgrenmeRow = "<tr><td  colspan=\"".($colCount+1)."\">İÇERDİĞİ ÖĞRENME ÇIKTILARI</td></tr>";
					$tableBilgiRow	.= "</tr>";
					$tableBeceriRow	.= "</tr>";
					$tableYetRow	.= "</tr>";
					$tablePart 		.= $tableNoRow.$tableAdRow.$tableSeviyeRow.$tableKrediRow.$tableOgrenmeRow.$tableBilgiRow.$tableBeceriRow.$tableYetRow.'</table>';
					$table 			.= $tablePart.'<br />';
				}
				
				$tablePart		= '<table border="1">';	
				$tableNoRow 	= '<tr><td></td>';
				$tableAdRow 	= '<tr><td>YETERLİLİK BİRİMİNİN ADI VE KODU</td>';
				$tableSeviyeRow = "<tr><td>SEVİYESİ</td>";
				$tableKrediRow  = "<tr><td>KREDİ DEĞERİ</td>";
				$tableBilgiRow	= "<tr><td>BİLGİLER</td>";
				$tableBeceriRow	= "<tr><td>BECERİLER</td>";
				$tableYetRow	= "<tr><td>YETKİNLİKLER</td>";
			}	
			
			$tableNoRow 	.= "<td>".$newBirimBilgi[$i]["YETERLILIK_ALT_BIRIM_NO"]."</td>";
			$tableAdRow 	.= "<td>".$newBirimBilgi[$i]["YETERLILIK_ALT_BIRIM_ADI"]."</td>";
			$tableSeviyeRow .= "<td>".$yeterlilikBilgi["SEVIYE_ADI"]."</td>";
			$tableKrediRow 	.= "<td>".$newBirimBilgi[$i]["YETERLILIK_ALT_BIRIM_KREDI"]."</td>";
				
			//BILGI
			$bilgi = " - ";
			$rowCount = count($newBirimBilgi[$i])-$yetBilgiColCount;
			for ($j = 0; $j < $rowCount; $j++){
				$bilgi .= $newBirimBilgi[$i][$j];
				
				if ($j < $rowCount-1)
					$bilgi .= "<br /> - ";
			}
			$tableBilgiRow .= "<td>".$bilgi."</td>";
			
			//BECERI
			$beceri = " - ";
			$rowCount = count($newBirimBeceri[$i])-$yetBilgiColCount;
			for ($j = 0; $j < $rowCount; $j++){
				$beceri .= $newBirimBeceri[$i][$j];
				
				if ($j < $rowCount-1)
					$beceri .= "<br /> - ";
			}
			$tableBeceriRow .= "<td>".$beceri."</td>";

			//YETKINLIK
			$yetkinlik = " - ";
			$rowCount = count($newBirimYetkinlik[$i])-$yetBilgiColCount;
			for ($j = 0; $j < $rowCount; $j++){
				$yetkinlik .= $newBirimYetkinlik[$i][$j];
				
				if ($j < $rowCount-1)
					$yetkinlik .= "<br /> - ";
			}
			$tableYetRow .= "<td>".$yetkinlik."</td>";
		}
		
		//if (count($newBirimBilgi)%$colCount != 0){
		
			$tableNoRow 	.= "</tr>";
			$tableAdRow 	.= "</tr>";
			$tableSeviyeRow .= "</tr>";
			$tableKrediRow  .= "</tr>";
			$tableOgrenmeRow = "<tr><td colspan=\"".(count ($newBirimBilgi)%$colCount+1)."\" >İÇERDİĞİ ÖĞRENME ÇIKTILARI</td></tr>";
			$tableBilgiRow	.= "</tr>";
			$tableBeceriRow	.= "</tr>";
			$tableYetRow	.= "</tr>";
			$tablePart 		.= $tableNoRow.$tableAdRow.$tableSeviyeRow.$tableKrediRow.$tableOgrenmeRow.$tableBilgiRow.$tableBeceriRow.$tableYetRow.'</table>';
			$table 			.= $tablePart;
		//}
		
		echo $table;
	}
		
	echo '</div>';

	if (FormFactory::checkAuthorization ($user, YT2_GROUP_ID)){
	//if($canOpenEkler){
		echo '<div id="ek3">';
		echo '<h3 style="text-align:center;">EK3 :</h3>';
		echo '<span style="text-align:center;">Yeterlilikte Belirtilen Değerlendirme Araçları İle Ölçülen Öğrenme Çıktılarına İlişkin Tablo</span>';
	
		echo '</div>';
	
		echo '<div id="ek4">';
		echo '<h3 style="text-align:center;">EK4 :</h3>';
		echo '<span style="text-align:center;"><b>Resmi Görüşe Gönderilmesi Öncesinde Yeterlilik Taslağına Katkıda Bulunan Kurum/Kuruluşlar</b></span>';
		echo '<br/><br/>';
		echo '<table border="1">';
		if ($katki_kurulus != null){
			foreach ($katki_kurulus as $row1){
				echo '<tr><td>';
				echo  $row1["YETERLILIK_KURULUS_ADI"];
				echo '</td></tr>';
			}
		}
		echo '</table>';
		echo '<br/>';
		echo '</div>';

		echo '<div id="ek5">';
		echo '<h3 style="text-align:center;">EK5 :</h3>';
		echo '<span style="text-align:center;"><b>Yeterlilik Taslağının Görüşe Gönderildiği Kurum ve Kuruluşlar</b></span>';
		echo '<br/><br/>';
		echo '<table border="1">';
		if ($gorus_kurulus != null){
			foreach ($gorus_kurulus as $row1){
				echo '<tr><td>';
				echo  $row1["YETERLILIK_KURULUS_ADI"];
				echo '</td></tr>';
			}
		}
		echo '</table>';
		echo '<br/>';
		echo '</div>';
	
		echo '<div id="ek6">';
		echo '<h3 style="text-align:center;">EK6 :</h3>';
		echo '<span style="text-align:center;">Yeterlilik Taslağına ilişkin Kurum ve Kuruluşlardan Gelen Görüşlerin Değerlendirilmesine ilişkin Form</span>';
	
		echo '</div>';
	
		echo '<div id="ek7">';
		echo '<h3 style="text-align:center;">EK7 :</h3>';
		echo '<span style="text-align:center;">Yeterlilik Taslağında yer alan ve Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğinin 10 uncu maddesinin birinci fıkrasının (f) bendindeki hususların (Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri) belirlenmesi amacıyla gerçekleştirilen pilot uygulamaya ilişkin belge ve kayıtlar</span>';
	
		echo '</div>';
	
		echo '<div id="ek8">';
		echo '<h3 style="text-align:center;">EK8 :</h3>';
		echo '<span style="text-align:center;"><b>Yeterlilik için öngörülen eğitim şartı, deneyim şartı ve belgenin geçerlilik süresine ilişkin dayanak/gerekçe belirtilerek ekte sunulacaktır. (Yeterlilik için öngörülen eğitim ve deneyim şartının neden gerekli olduğu; ayrıca yeterlilik belgesi için öngörülen geçerlilik süresinin neye dayanılarak belirlendiği bu bölümde belirtilerek bu gerekliliklere ilişkin ulusal ya da uluslar arası standart, sözleşme, mevzuat vs. varsa belirtilecektir.)</b></span>';
		echo '<br/><br/>';
		echo $taslakYeterlilik["YETERLILIK_EK_ACIKLAMA"];

		echo '</div>';
	}

	
	function tableRow ($count, $title, $data){
		$style = 'style="background-color:RGB(238, 236, 225);"';
		$numWidth = 8;
		$width = (100-$numWidth)/2;
	
		return  '<tr><td '.$style.' width="'.$numWidth.'%">'.$count.')</td>
				<td '.$style.' width="'.$width.'%">'.$title.'</td>
				<td width="'.$width.'%" >'.$data.'</td></tr>';
	}

	function tableRowTitle ($count, $title){
		$style = 'style="background-color:RGB(238, 236, 225);"';
		$numWidth = 8;
		$width = 100-$numWidth;
	
		return  '<tr><td '.$style.' width="'.$numWidth.'%">'.$count.')</td>
				<td '.$style.' width="'.$width.'%">'.$title.'</td></tr>';
	}
	
	function tableRowData ($data){
		return  '<tr>
					<td width="100%">'.$data.'</td>
				 </tr>';
	}
	
	function tableRowDataTitle ($title, $data){
		return  '<tr>
					<td width="35%">'.$title.'</td>
					<td width="65%">'.$data.'</td>
			 	</tr>';
	}
	
	function statikTabloHTML ($paramTitle, $param){	
		$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
					<span><strong>'.$paramTitle.'</strong>'.$param.'</span>
				</div>';
		
		return $html; 
	}
	
	//Birimler ve Beceri yetkinliklerin bulundugu array'i alir
	//Birimlere gore ayirir ve birim bilgilerini kolon adlariyla tutar.
	//Beceri yetkinlikleri ise sirayla numeric olarak koyar 
	function convertBirimBeceriYetkinlik2DArray ($array){
		$newArray = array();
		
		$altBirimId = -1;
		$altBirimCount = -1;
		$bilgiCount = 0;
		for ($i = 0; $i < count($array); $i++){
			if ($altBirimId == $array[$i]["YETERLILIK_ALT_BIRIM_ID"]){
				$bilgiCount++;
				$newArray[$altBirimCount][$bilgiCount] = $array[$i]["BECERI_YETKINLIK_ADI"];
			}else{
				$bilgiCount = 0;
				$altBirimCount++;
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_ADI"]= $array[$i]["YETERLILIK_ALT_BIRIM_ADI"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_KODU"]= $array[$i]["YETERLILIK_ALT_BIRIM_KODU"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_KREDI"]= $array[$i]["YETERLILIK_ALT_BIRIM_KREDI"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_NO"]= $array[$i]["YETERLILIK_ALT_BIRIM_NO"];
				$newArray[$altBirimCount][$bilgiCount] = $array[$i]["BECERI_YETKINLIK_ADI"];
				$altBirimId = $array[$i]["YETERLILIK_ALT_BIRIM_ID"];
			}
		}
		
		return $newArray;
	}
	
	function getStandartAdi($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT standart_adi 
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	function getStandartKodu($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT standart_kodu
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	function getStandartSeviye($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT seviye_id
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getYeterlilikAltBirimAdi($alt_birim_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT yeterlilik_alt_birim_adi, yeterlilik_alt_birim_kodu 
				FROM m_yeterlilik_alt_birim   
				WHERE yeterlilik_alt_birim_id = ?";
		
		$params = array ($alt_birim_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0]["YETERLILIK_ALT_BIRIM_ADI"]." - ".$data[0]["YETERLILIK_ALT_BIRIM_KODU"];
		else
			return null;
	}
?>

<script type="text/javascript">

</script>