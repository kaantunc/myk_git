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

	echo "<div id=\"ek\">";
	echo blockTitle ("EK 1. ULUSAL YETERLİLİK GELİŞTİRME EKİBİNDE GÖREVLENDİRİLEN PERSONELE İLİŞKİN BİLGİ FORMU", "center", 0);
	
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
		$table = '<table nobr="true">
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
				$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramIds[$j]].'</dd><dd></dd></td>';
			}
			$part .= "</tr>";
			
			$htmlPart .= $part;
		}
		
		$html .= '<div style="height:auto;padding: 10px 15px;">
					<table nobr="true" border="1" style="width:100%;">
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
	
?>