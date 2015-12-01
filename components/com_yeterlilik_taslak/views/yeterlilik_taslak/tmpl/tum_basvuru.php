<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$yeterlilik_id		= $this->yeterlilik_id;
$yeterlilikBilgi 	= $this->yeterlilikBilgi;
$taslakYeterlilik 	= $this->taslakYeterlilik;
$kaynakMeslek		= $this->kaynakMeslek;
$kaynakBirim		= $this->kaynakBirim;
$zorunluBirim 		= $this->zorunluBirim;
$secmeliBirim 		= $this->secmeliBirim;
$bilgi				= $this->bilgi;
$beceri				= $this->beceri;
$yetkinlik			= $this->yetkinlik;
$teorikOlcme 		= $this->teorikOlcme;
$performansOlcme 	= $this->performansOlcme;
$onayliStandart		= $this->onayliStandart;
$onayliAltBirim		= $this->onayliAltBirim;
$katki_kurulus		= $this->katki_kurulus;
$gorus_kurulus		= $this->gorus_kurulus;
$terim				= $this->terim;
$standart 			= $this->standart;
$tur_id				= $this->tur_id;
$birim_bilgi		= $this->birim_bilgi; 	  
$birim_beceri 	  	= $this->birim_beceri;
$birim_yetkinlik 	= $this->birim_yetkinlik;
$canOpenEkler 		= $this->canOpenEkler;
$degerlendirme_ogrenme	= $this->degerlendirme_ogrenme;
$degerlendirme_ogrenme2	= $this->degerlendirme_ogrenme2;
//
$user =& JFactory::getUser();
$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
//
?>
<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">
	  
	<input type='hidden' value='1' name='2306e6467a830d886ea16ea1849f7ff5'/>	
	<input type='hidden' value='e84ad33046067593b8356745abbdd473' name='1cf1'/>

<?php 
if ($tur_id != -1) { //PDF Degilse
	if(!$isSektorSorumlusu){
?>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1, <?php echo $tur_id;?>);'/>
			<input type='button' name='bitirUst' value='Bitir' onClick='formSubmitted(2, <?php echo $tur_id;?>);'/>
		</div>
	</div>
<?php 
	}else{
?>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1, <?php echo $tur_id;?>);'/>
		</div>
	</div>
<?php 
	}
}
?>	
	<div class='form_element'>
	<div id="taslak">
		<?php 
		//ULUSLARARASI SINIFLAMA
		echo blockTitle ("ULUSLARARASI SINIFLAMADAKİ YERİ");
		echo '<div id="sinif">';
		if ($standart != null){
			foreach ($standart as $row){
				echo statikTabloHTML ($row["STANDART_ADI"].": "	, $row["STANDART_ACIKLAMA"]);
				echo "<br />";
			}
		}
		echo "</div>";
		
		//AMAC ve GEREKCE
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("AMACI ve GEREKÇESİ");
		echo "</div>";
		echo '<div id="amac">';
		echo statikHTML ("", $taslakYeterlilik["YETERLILIK_AMAC"]);
		echo "</div>";
		
		//KAYNAK MESLEK STANDARDI
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo blockTitle ("YETERLİLİĞE KAYNAK TEŞKİL EDEN MESLEK STANDARTLARI", null);
		echo "</div>";
		echo '<div id="kaynakMeslek">';
		if ($kaynakMeslek != null){
			foreach ($kaynakMeslek as $row){
				if ($row["KAYNAK_ID"] == -1)
					echo statikTabloHTML ("", $row["KAYNAK_ACIKLAMA"]);
				else
					echo statikTabloHTML ("", getStandartAdi($row["KAYNAK_ID"]));
					
				echo "<br />";
			}
		}
		echo "</div>";		
		
		//KAYNAK YETERLILIK BIRIMI 
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("YETERLİLİĞE KAYNAK TEŞKİL EDEN YETERLİLİK BİRİMLERİ", null);
		echo "</div>";
		echo '<div id="kaynakBirim">';
		if ($kaynakBirim != null){
			foreach ($kaynakBirim as $row){
				if ($row["KAYNAK_ID"] == -1)
					echo statikTabloHTML ("", $row["KAYNAK_ACIKLAMA"]);
				else
					echo statikTabloHTML ("", getYeterlilikAltBirimAdi($row["KAYNAK_ID"]));
				echo "<br />";
			}
		}
		echo "</div>";

		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("YETERLİLİĞİ OLUŞTURAN YETERLİLİK BİRİMLERİ");
		echo "</div>";
		//ZORUNLU ALT BIRIM
		echo statikHTML ("Grup A: Zorunlu Yeterlilik Birimleri", null);
		echo '<div id="zorunlu">';
		if($taslakYeterlilik["ZORUNLU_ACIKLAMA"]) echo "<br />".nl2br($taslakYeterlilik["ZORUNLU_ACIKLAMA"])."<br />";
		if ($zorunluBirim != null){
			foreach ($zorunluBirim as $row){
				echo statikTabloHTML ($row["YETERLILIK_ALT_BIRIM_NO"].") "	, $row["YETERLILIK_ALT_BIRIM_ADI"]);
				echo "<br />";
			}
		}
		echo "</div>";
		
		//SECMELI ALT BIRIM
		echo '<div id="baslik">';
		echo "<br />";
		echo statikHTML ("Grup B: Seçmeli Yeterlilik Birimleri", null);
		echo "</div>";
		echo '<div id="secmeli">';
		if($taslakYeterlilik["SECMELI_ACIKLAMA"]) echo "<br />".nl2br($taslakYeterlilik["SECMELI_ACIKLAMA"])."<br />";
		if ($secmeliBirim != null){
			foreach ($secmeliBirim as $row){
				echo statikTabloHTML ($row["YETERLILIK_ALT_BIRIM_NO"].") "	, $row["YETERLILIK_ALT_BIRIM_ADI"]);
				echo "<br />";
			}
		}
		echo "</div>";
		
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("BİRİMLERİN GRUPLANDIRMA ALTERNATİFLERİ");
		echo "</div>";
		echo '<div id="grup">';
		echo statikHTML ("", $taslakYeterlilik["YETERLILIK_GRUP_ALTERNATIF"]);
		echo "</div>";

		// SART
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo blockTitle ("YETERLİLİK İÇİN GEREKLİ EĞİTİM ŞARTININ");
		echo "</div>";
		echo '<div id="sekil">';
		echo statikHTML ("A) Şekli"	 , $taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"]);
		echo "</div>";
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo "</div>";
		echo '<div id="icerik">';
		echo statikHTML ("B) İçeriği", $taslakYeterlilik["YETERLILIK_EGITIM_ICERIK"]);
		echo "</div>";
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo "</div>";
		echo '<div id="sure">';
		echo statikHTML ("C) Süresi" , $taslakYeterlilik["YETERLILIK_EGITIM_SURE"]);
		echo "</div>";
		
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo blockTitle ("YETERLİLİK İÇİN GEREKLİ OLAN DENEYİM ŞARTININ");
		echo "</div>";
		echo '<div id="nitelik">';
		echo statikHTML ("A) Niteliği"	, $taslakYeterlilik["YETERLILIK_DENEYIM_NITELIK"]);
		echo "</div>";
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo "</div>";
		echo '<div id="sure2">';
		echo statikHTML ("B) Süresi"	, $taslakYeterlilik["YETERLILIK_DENEYIM_SURE"]);
		echo "</div>";
		
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo blockTitle ("SAHİP OLUNMASI GEREKEN ÖĞRENME ÇIKTILARI");
		//BILGI
		echo statikHTML ("Bilgiler", null);
		echo "</div>";
		echo '<div id="bilgi"><ul>';
		if ($bilgi != null){
			$i = 1;
			foreach ($bilgi as $row){
				//echo statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				echo "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				echo "<br />";
			}
		}
		echo "</ul></div>";
		
		echo '<div id="baslik">';
		echo "<br />";
		//BECERI
		echo statikHTML ("Beceriler", null);
		echo "</div>";
		echo '<div id="beceri"><ul>';
		if ($beceri != null){
			$i = 1;
			foreach ($beceri as $row){
				//echo statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				echo "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				echo "<br />";
			}
		}
		echo "</ul></div>";
		
		echo '<div id="baslik">';
		echo "<br>";
		//YETKINLIKLER
		echo statikHTML ("Yetkinlikler", null);
		echo "</div>";
		echo '<div id="yetkinlik"><ul>';
		if ($yetkinlik != null){
			$i = 1;
			foreach ($yetkinlik as $row){
				//echo statikTabloHTML ($i++.". ", $row["BECERI_YETKINLIK_ADI"]);
				echo "<li>" . $row["BECERI_YETKINLIK_ADI"] . "</li>";
				echo "<br />";
			}
		}
		echo "</ul></div>";
		echo "<br />";
		
		
		echo blockTitle ("ÇALIŞMA ORTAMI ve KOŞULLARI");
		echo statikHTML (""	 , $taslakYeterlilik["YETERLILIK_ORTAM"]);
		echo "<br /><br />";
		
		$paramTitles = array ("Değerlendirme Araçları", "Değerlendirme Materyalleri", "Puanlama", "Başarı Ölçütü", "Gerekli Görülen Diğer Şartlar");
		$paramIds	 = array ("DEGERLENDIRME_ARAC_ADI","DEGERLENDIRME_MATERYAL","DEGERLENDIRME_PUANLAMA","DEGERLENDIRME_BASARI_OLCUT","DEGERLENDIRME_DIGER");
		echo blockTitle ("YETERLİLİK İÇİN UYGULANACAK SINAV ve DEĞERLENDİRMEYE İLİŞKİN BİLGİLER");
		echo statikHTML ("A) Sınav ve Değerlendirme Araçlarına İlişkin Bilgiler", null);
		//TEORIK OLCME ARACLARI
		echo statikHTML ("Teorik Ölçme Araçları", null);
		if ($teorikOlcme != null){
			echo tabloHTML ($paramTitles, $paramIds, $teorikOlcme);
		}

		echo "<br />";
		//PERFORMANSA DAYALI OLCME ARACLARI
		echo statikHTML ("Performansa Dayalı Ölçme Araçları", null);
		if ($performansOlcme != null){
			echo tabloHTML ($paramTitles, $paramIds, $performansOlcme);
		}
		echo "<br />";
		
		echo statikHTML ("Sınav ve Değerlendirme Araçlarıyla İlgili Diğer Koşullar"	 , $taslakYeterlilik["YETERLILIK_DIGER"]);
		echo "<br /><br />";

		echo statikHTML ("B) Değerlendirici Ölçütleri"	 , $taslakYeterlilik["YETERLILIK_DEGERLENDIRICI"]);
		echo "<br /><br />";
		
		//ACIKLAMA
		echo blockTitle ("YETERLİLİK BELGESİNİN GEÇERLİLİK SÜRESİ");
		echo statikHTML (""	 , $taslakYeterlilik["YETERLILIK_GECERLILIK_SURE"]);
		echo "<br /><br />";

		echo blockTitle ("BELGE SAHİBİNİN GÖZETİMİNDE UYGULANACAK PERFORMANS İZLEME METODLARI ve BELGE SAHİBİNİN GÖZETİM SIKLIĞI");
		echo statikHTML (""	 , $taslakYeterlilik["YETERLILIK_METHOD_GOZETIM"]);
		echo "<br /><br />";

		echo blockTitle ("GEÇERLİLİK SÜRESİ DOLAN BELGELERİN YENİLENMESİNDE UYGULANACAK DEĞERLENDİRME YÖNTEMLERİ");
		echo statikHTML (""	 , $taslakYeterlilik["YETERLILIK_DEG_YONTEM"]);
		echo "<br /><br />";
		
		echo blockTitle ("YETERLİLİĞİ GELİŞTİREN KURULUŞLAR");
		if ($katki_kurulus != null){
			$i = 1;
			foreach ($katki_kurulus as $row){
				echo statikTabloHTML ($i++.". ", $row["YETERLILIK_KURULUS_ADI"]);
				echo "<br />";
			}
		}
		echo "<br />";
		
		//EKLER
	//	echo blockTitle ("EKLER", "center");
		//EK 1
		echo '<div id="ek1">';
		echo blockTitle ("EK1 : Terimler, Simgeler ve Kısaltmalar", "center");
		if($taslakYeterlilik["TERIM_ACIKLAMA"]) echo "<br />".nl2br($taslakYeterlilik["TERIM_ACIKLAMA"]). "<br />";
		if ($terim != null){
			foreach ($terim as $row){
				echo statikTabloHTML ($row["TERIM_ADI"].": "	, $row["TERIM_ACIKLAMA"]);
				echo "<br />";
			}
		}
		echo "ifade eder.";
		echo '</div>';
		
		//EK 2
		echo '<div id="ek2">';
		echo blockTitle ("EK 2 : Yeterliliği Oluşturan Yeterlilik Birimlerine İlişkin Tablo", "center");

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
			$colCount = 3;
			$yetBilgiColCount = 4;
			for ($i = 0; $i < count ($newBirimBilgi); $i++){
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
			
			//if (count ($newBirimBilgi)%3 != 0){
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
		
		if($canOpenEkler){
			echo '<div id="ek3">';
			echo '<h3 style="text-align:center;">EK3 :</h3>';
			echo '<span style="text-align:center;"><b>Yeterlilikte Belirtilen Değerlendirme Araçları İle Ölçülen Öğrenme Çıktılarına İlişkin Tablo</b></span>';
			echo '<br/><br/>';
			echo '<table border="1">';
			echo '<tr><th><b>Değerlendirme Aracı</b></th><th><b>Ölçülen Öğrenme Çıktıları</b></th></tr>';
			if ($degerlendirme_ogrenme2 != null){
				foreach ($degerlendirme_ogrenme2 as $dogg){
					echo '<tr><td>';
					echo $dogg["DEGERLENDIRME_ARAC_ADI"];
					echo "</td><td>".$dogg["BECERI_YETKINLIK_ADI"];
					echo '</td></tr>';
				}
			}
			echo '</table>';
			echo '<br/>';
			
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
		?>
	</div>
	</div>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriAlt' value='Geri' onClick='formSubmitted(1, <?php echo $tur_id;?>);'/>
			<input type='button' name='bitirAlt' value='Bitir' onClick='formSubmitted(2, <?php echo $tur_id;?>);'/>
		</div>
	</div>
	
</form>
        
<?php

function statikHTML ($paramTitle, $param){
	if (strlen($paramTitle) != 0){
		$html = '<div style = "height:auto; padding:5px;">
					<span><strong>'.
					$paramTitle
					.'</strong></span>
				</div><br />';
	}else{
		$html = "";
	}
	
	if (strlen($param) != 0){
		$html .= '<div style = "height:auto; padding: 5px 5px 5px 10px;">
					<span>'.$param.'</span>			
				  </div>';
	}
	
	return $html;
}

function statikTabloHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
				<span><strong>'.$paramTitle.'</strong>'.$param.'</span>
			</div>';
	
	return $html; 
}

function tabloHTML ($paramTitles, $paramIds, $params){	
	$html = "";
				
	$title = "<tr>";
	for ($i = 0; $i < count($paramTitles); $i++){
		$title .= '<td width="20%"><strong>'.$paramTitles[$i].'</strong></td>';
	}
	$title .= "</tr>";

	$htmlPart = "";
	for ($i = 0; $i < count($params); $i++){ 
		$data = $params[$i];
		$part = "<tr>";
		for ($j = 0; $j < count($paramIds); $j++){
			$part .= '<td >'.$data[$paramIds[$j]].'</td>';
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

function blockTitle ($title, $align="left"){
	return '<h3 style="font-weight:bold;margin-top:15px;font-size:15px;text-align:'.$align.';">'.$title.'</h3><br>';
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
function formSubmitted (num, tur)
{
	//alert(num+"-"+tur);
	var form = document.ChronoContact_yeterlilik_taslak;
	if (num == 1) { //Geri
		form.action = 'index.php?option=com_yeterlilik_taslak&layout=tanitim&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
    }else if (num == 2){ 
		if (tur == 1){
			form.action = 'index.php?option=com_yeterlilik_taslak&task=sektorSorumlusunaGonder&yeterlilik_id=<?php echo $yeterlilik_id;?>';  
	    }else if (tur == 2){ // Onaylanmis
	    	form.action = 'index.php?option=com_yeterlilik_taslak&task=onBasvuruBitir&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
		}else if (tur == 3){ // Onaylanmis Taslak Basvuru
	    	form.action = 'index.php?option=com_yeterlilik_taslak&task=basvuruBitir&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
		}
    }   
	form.submit(); 
}
</script>