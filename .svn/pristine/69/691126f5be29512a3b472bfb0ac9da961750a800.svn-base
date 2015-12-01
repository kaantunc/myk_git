<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$model = $this->getModel();

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
$gelistiren_kurulus = $this->gelistiren_kurulus;
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
if ($tur_id != -1 and !$isSektorSorumlusu) { //PDF Degilse
	
		
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

?>	
	<div class='form_element'>
	<div id="taslak">
		<?php 
		
		echo baslikHTML ("TANITIM");
		//TANITIM
		echo blockTitle ("ULUSLARARASI SINIFLAMADAKİ YERİ");
		echo '<div id="sinif">';
		if ($standart != null){
			foreach ($standart as $row){
				echo statikTabloHTML ($row["STANDART_ADI"].": "	, $row["STANDART_ACIKLAMA"]);
				echo "<br />";
			}
		}
		echo "</div>";
		
		echo blockTitle ("AMAÇ");
		echo statikHTML ("", $taslakYeterlilik["YETERLILIK_AMAC"]);
		
		
		
		echo baslikHTML ("YETERLİLİK KAYNAĞI");
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
		
		
		echo baslikHTML ("YETERLİLİK ŞARTLARI");
		//YETERLILIK SARTLARI
		echo '<div id="baslik">';
		echo "<br /><br />";
		echo blockTitle ("YETERLİLİK SINAVINA GİRİŞ ŞART(LAR)I", null);
		echo "</div>";
		echo '<div>';
		echo statikTabloHTML ("", $taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"]);
		echo "<br />";
		echo "</div>";
		
		
		echo baslikHTML ("YETERLİLİĞİN YAPISI");
		//YETERLİLİĞİN YAPISI
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("BİRİMLERİN GRUPLANDIRMA ALTERNATİFLERİ");
		echo "</div>";
		echo '<div id="grup">';
		echo statikHTML ("", $taslakYeterlilik["BIRIMLERIN_GRUPLANDIRILMA"]);
		echo "</div>";
		
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("İLAVE ÖĞRENME ÇIKTILARI");
		echo "</div>";
		echo '<div id="grup">';
		echo statikHTML ("", $taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"]);
		echo "</div>";
		
		
		echo baslikHTML ("ÖLÇME ve DEĞERLENDİRME");
		//ÖLÇME ve DEĞERLENDİRME
		echo '<div id="baslik">';
		echo "<br />";
		echo blockTitle ("ÖLÇME ve DEĞERLENDİRME");
		echo "</div>";
		echo '<div id="grup">';
		echo statikHTML ("", $taslakYeterlilik["YETERLILIK_ORTAM"]);
		echo "</div>";
		
		echo baslikHTML ("AÇIKLAMA");
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
		for($i=0; $i<count($gelistiren_kurulus); $i++)
		{
			if($gelistiren_kurulus[$i]["ILK_GELISTIRME_YAPAN"]=="1")
				$ilkGelistirmeYapan = " (İlk Geliştiren)";
			else 
				$ilkGelistirmeYapan = "";
			
			if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]=="1")
			{	
				$revizeYapan = " (Revize Yapan)";
				$revizeNosu = ' (Revize No: '.$gelistiren_kurulus[$i]["REVIZE_NO"].')';
			}
			else
			{
				$revizeYapan = "";
				$revizeNosu = "";
			}
					
			echo statikTabloHTML (($i+1).". ", $gelistiren_kurulus[$i]["YETERLILIK_KURULUS_ADI"].$ilkGelistirmeYapan.$revizeYapan.$revizeNosu);
				
			echo "";
		}
		echo "<br />";
		
		
		
		echo baslikHTML ("EK2");
		//EK2
		echo '<div id="ek2">';
		echo blockTitle ("TERİMLER, SİMGELER ve KISALTMALAR");
		if($taslakYeterlilik["TERIM_ACIKLAMA"]) echo nl2br($taslakYeterlilik["TERIM_ACIKLAMA"]). "<br />";
		if ($terim != null){
			foreach ($terim as $row){
				echo statikTabloHTML ($row["TERIM_ADI"].": "	, $row["TERIM_ACIKLAMA"]);
				
			}
		}
		echo "ifade eder.<br>";
		echo '</div>';
		
		
		
		echo baslikHTML ("EK3");
		//EK3
		echo blockTitle ("MESLEKTE YATAY ve DİKEY ILERLEME YOLLARI");
		echo statikHTML (""	 , $taslakYeterlilik["MESLEKTE_YATAY_DIKEY"]);
		echo "<br /><br />";
		
		
		
		echo baslikHTML ("EK4");
		//EK4
		echo blockTitle ("DEĞERLENDİRİCİ ÖLÇÜT");
		echo statikHTML (""	 , $taslakYeterlilik["DEGERLENDIRICI_OLCUT"]);
		echo "<br /><br />";
		
		
		echo baslikHTML ("EK5");
		//EK5
		echo blockTitle ("RESMİ GÖRÜŞE GÖNDERİLMESİ ÖNCESİNDE YETERLİLİK TASLAĞINA KATKIDA BULUNAN KURUM/KURULUŞLAR");
		for($i=0; $i<count($katki_kurulus); $i++)
		{
			echo statikTabloHTML (($i+1).". ", $katki_kurulus[$i]["YETERLILIK_KURULUS_ADI"]);
			echo "";
		}
		echo "<br />";
		
		
		
		
		echo baslikHTML ("EK6");
		//EK6
		echo blockTitle ("YETERLİLİK TASLAĞININ GÖRÜŞE GÖNDERİLDİĞİ KURUM ve KURULUŞLAR");
		for($i=0; $i<count($gorus_kurulus); $i++)
		{
			echo statikTabloHTML (($i+1).". ", $gorus_kurulus[$i]["YETERLILIK_KURULUS_ADI"]);
			echo "";
		}
		echo "<br />";
		
		
		
		echo baslikHTML ("EK9");
		//EK9
		echo blockTitle ("YETERLİLİK SINAVINA GİRİŞ ŞARTLARI ve BELGE GEÇERLİLİK SÜRESİNE İLİŞKİN AÇIKLAMA");
		echo statikHTML (""	 , $taslakYeterlilik["YETERLILIK_EK_ACIKLAMA"]);
		echo "<br /><br />";
		
		
		echo baslikHTML ("BIRIMLER").'<br><br>';
		//BIRIMLER
		$eklenmisBirim = $this->eklenmisBirim;
		for($i=0; $i<count($eklenmisBirim); $i++)//HER BIRIM ICIN
		{
			//// SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT SULEYMAN ABI JAVASCRIPT
			
			
			$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
			echo blockTitle ($eklenmisBirim[$i]["BIRIM_KOD"].'-'.$eklenmisBirim[$i]["BIRIM_ADI"]);
		
			
			
			// SULEYMAN ABI JAVASCRIPT BITTI
			
			
			
			//BIRIM POPUPLARI
			$totalBaglamCount = 0;
			$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
			$birimAdi = $eklenmisBirim[$i]["BIRIM_ADI"];
			$popupStyle = ' style="border: 1px solid #00A7DE; padding: 10px; width:100%; background-color: white; " ';
				
			
			echo '<div id="biriminDetaylariPopupDiv-'.$birimID.'" '.$popupStyle.'>';
			echo '<div style="height:500px; overflow:auto;">';
				
			echo '<table id="birimDetayiIlkTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
			<tr>
			<td class="blueBackgrounded" style="width:30px">1</td>
			<td class="blueBackgrounded">YETERLİLİK BİRİMİ ADI</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_ADI"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded" style="width:30px">2</td>
			<td class="blueBackgrounded">REFERANS KODU</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_KODU"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded" style="width:30px">3</td>
			<td class="blueBackgrounded">SEVİYE</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_SEVIYE"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded" style="width:30px">4</td>
			<td class="blueBackgrounded">KREDİ DEĞERİ</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_KREDI"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded" rowspan="3"  style="width:30px">5</td>
			<td class="blueBackgrounded">A)YAYIN TARİHİ</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_YAYIN_TAR"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded">B)REVİZYON NO</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_REV_NO"].'</td>
			</tr>
			<tr>
			<td class="blueBackgrounded">C)REVİZYON TARİHİ</td>
			<td>'.$eklenmisBirim[$i]["BIRIM_REV_TAR"].'</td>
			</tr>
				
			</tbody></table>';
				
			echo '<table  id="birimDetayiIkinciTable-'.$birimID.'"  border="1" style="width:100%; float:left;"><tbody>
			<tr>
			<td class="blueBackgrounded" style="width:30px">6</td>
			<td class="blueBackgrounded">YETERLİLİK BİRİMİNE KAYNAK TEŞKİL EDEN MESLEK STANDARDI</td>
			</tr>
			<tr><td class="" colspan="2">';
			//Teşkil Eden Standartlar Burada
			
			echo '&nbsp;';
			//Teşkil Eden Standartlar Biter
				
			echo '</td></tr>
			<tr>
			<td class="blueBackgrounded" style="width:30px">7</td>
			<td class="blueBackgrounded">ÖĞRENME ÇIKTILARI</td>
			</tr>
			<tr><td class="" colspan="2">';
				
			//echo $birimlerleDetaylari[$i]["YETERLILIK_ID"]." - ".$birimlerleDetaylari[$i]["BIRIM_ID"]." - ".$birimlerleDetaylari[$i]["ZORUNLU"]." - ".$birimlerleDetaylari[$i]["OGRENME_CIKTISI_ID"]." - ";
			$ogrenmeCiktisiViewID = 'biriminOgrenmeCiktilari-'.$birimID;
			$buBiriminOgrenmeCiktilari = $this->$ogrenmeCiktisiViewID;
				
			// SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE SULEYMAN ABININ TABLE
			echo '<table id="biriminDetaylariTablosu-'.$birimID.'" class="tableGib" border="0">
			<thead class="gibHeader">
			<tr style="display:none;">
			<td colspan="2">Öğrenme Çıktısı</td>
			<td colspan="2">Başarım Ölçütleri</td>
			</tr>
			</thead>';
				
			
				
			$buBiriminBaglamlariViewID = 'biriminBaglamlari-'.$birimID;
			$buBiriminBaglamlari = $this->$buBiriminBaglamlariViewID;
			$birimBaglamiText = "";
			for($j=0; $j<count($buBiriminBaglamlari); $j++)
			{
			if($j!=0)
				$birimBaglamiText .= '
				';
				$birimBaglamiText .= $buBiriminBaglamlari[$j]["BAGLAM_ACIKLAMA"];
			}
				
			echo '<tr class="tablo_header_acik ogrenmeCiktisiRow">
			<td colspan="4">Birim Bağlamı:'.$birimBaglamiText.'
			<br><br>Öğrenim Çıktıları ve Başarım Ölçütleri:<br>';
			
			$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
				
			$ogrenmeCiktisiViewID = 'biriminOgrenmeCiktilari-'.$birimID;
			$buBiriminOgrenmeCiktilari = $this->$ogrenmeCiktisiViewID;
				
			for($j=0; $j<count($buBiriminOgrenmeCiktilari); $j++)
			{
				$ogrenmeCiktisiID = $buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_ID"];
				$buOgrenmeCiktisininBaglamlariViewID = 'ogrenmeCiktisininBaglamlari-'.$birimID."-".$ogrenmeCiktisiID;
				$buOgrenmeCiktisininBaglamlari = $this->$buOgrenmeCiktisininBaglamlariViewID;
				$buOgrenmeCiktisininBasarimOlcutuViewID = 'ogrenmeCiktisininBasarimOlcutleri-'.$birimID.'-'.$ogrenmeCiktisiID;
				$buOgrenmeCiktisininBasarimOlcutleri = $this->$buOgrenmeCiktisininBasarimOlcutuViewID;
				
				
				echo '<strong>'.($j+1).': '.$buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_YAZISI"].' - </strong>'.$buOgrenmeCiktisininBaglamlari[0]["BAGLAM_ACIKLAMA"].'<br>';
					
				
				for($k=0; $k<count($buOgrenmeCiktisininBasarimOlcutleri); $k++)
				{
				$basarimOlcutuID = $buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ID"];
				
				$buBasarimOlcutununBaglamlariViewID = 'basarimOlcutununBaglamlari-'.$birimID."-".$ogrenmeCiktisiID."-".$basarimOlcutuID;
				$buBasarimOlcutununBaglamlari = $this->$buBasarimOlcutununBaglamlariViewID;
				
				echo '<strong>&nbsp;&nbsp;&nbsp;&nbsp; '.($j+1).'. '.($k+1).': '.$buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ADI"].' - </strong>'.$buBasarimOlcutununBaglamlari[0]["BAGLAM_ACIKLAMA"].'<br>';
				}
			}
			
				
			
			echo '</td>
			</tr>';
			
			
			
			echo '</table>';
			echo '<input style="display:none;" type="button" onclick="jQuery(\'.gsira\').css(\'display\',\'block\')" value="Yeniden Sırala" />';
			// BITTI SULEYMAN ABININ TABLE--------------------------------------------------------------
			//ÖĞRENME ÇIKTILARI Biter
			
				
			echo '</td></tr>';
				
			echo '<tr>
			<td class="blueBackgrounded" style="width:30px">8</td>
			<td class="blueBackgrounded">ÖLÇME VE DEĞERLENDİRME</td>
			</tr>
			<tr id="teorikSinavlarRow-0"  class="teorikSinavlarRow"><td class="blueBackgrounded" class="" colspan="2">8 a) Teorik Sınav </td></tr>';

			
			echo '<tr><td colspan="2">';
			$buBiriminTeorikSinavlariViewID = 'biriminTeorikSinavlari-'.$birimID;
			$buBiriminTeorikSinavlari = $this->$buBiriminTeorikSinavlariViewID;
			for($j=0; $j<count($buBiriminTeorikSinavlari); $j++)
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp; <strong>T'.($j+1).': "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminTeorikSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'" </strong>'
						.' <br>SORU SAYISI: '.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI"]
						.' <br>BAŞARI KRİTERİ: %'.$buBiriminTeorikSinavlari[$j]["BASARI_KRITERI"]
						.' <br>MİN SORU SÜRESİ: ('.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_DK"].':'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_SN"].')'
						.' <br>MAX SORU SÜRESİ: ('.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_DK"].':'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_SN"].')'
						.'<br>';
			}
			echo '</td><tr>';					
				
			echo '<tr id="performansSinavlariRow-0" class="performansSinavlariRow"><td class="blueBackgrounded" class="" colspan="2">8 b) Performansa Dayalı Sınav</td></tr>';
			
			echo '<tr><td colspan="2">';
			$buBiriminPerformansSinavlariViewID = 'biriminPerformansSinavlari-'.$birimID;
			$buBiriminPerformansSinavlari = $this->$buBiriminPerformansSinavlariViewID;
			for($j=0; $j<count($buBiriminPerformansSinavlari); $j++)
				echo '&nbsp;&nbsp;&nbsp;&nbsp;<strong> P'.($j+1).': "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminPerformansSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'"</strong>
				<br>BAŞARI KRİTERİ: %'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI"].'<br>';
							
			
			echo '</td></tr>';
								
				
			echo '<tr id="digerSinavlarRow-0" class="digerSinavlarRow"><td class="blueBackgrounded" class="" colspan="2">8 c) Ölçme ve Değerlendirmeye İlişkin Diğer Koşullar </td></tr>';
			
			echo '<tr><td colspan="2">';
			$buBiriminDigerSinavlariViewID = 'biriminDigerSinavlari-'.$birimID;
			$buBiriminDigerSinavlari = $this->$buBiriminDigerSinavlariViewID;
			for($j=0; $j<count($buBiriminDigerSinavlari); $j++)
				echo '&nbsp;&nbsp;&nbsp;&nbsp; <strong>D'.($j+1).': "'.FormFactory::replaceNewLinesForJavascriptCode($buBiriminDigerSinavlari[$j]["OLC_DEG_ACIKLAMA"]).'</strong><br>';
							
			echo '</td></tr>';	
				
			echo '<tr class="birimGelistirenKuruluslarRow" id="birimGelistirenKuruluslarRow-0"><td class="blueBackgrounded" style="width:30px">9</td><td class="blueBackgrounded">YETERLİLİK BİRİMİNİ GELİŞTİREN KURUM/KURULUŞ(LAR) </td></tr>';
				
			$yeterliligiGelistirenKuruluslar = $this->gelistiren_kurulus;
			for($j=0; $j<count($yeterliligiGelistirenKuruluslar); $j++)
			echo '<tr class="yeterliligiGelistirenKuruluslardan darkGrayBackgrounded " style="display:none;" >
			<td colspan="2"><input class="yeterliligiGelistirenKuruluslarCheckbox" name="yeterliligiGelistirenKuruluslarCheckbox-'.$birimID.'" type="checkbox" value="'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'" >'.$yeterliligiGelistirenKuruluslar[$j]["YETERLILIK_KURULUS_ADI"].'</input></td>
			</tr>';
				
				
			$buBirimiGelistirenKuruluslarViewID = 'birimiGelistirenKuruluslar-'.$birimID;
			$buBirimiGelistirenKuruluslar = $this->$buBirimiGelistirenKuruluslarViewID;
			for($j=0; $j<count($buBirimiGelistirenKuruluslar); $j++)
			{
			if($buBirimiGelistirenKuruluslar[$j]["YETERLILIKTEN_ALINTI"]=="1")
			{
			$yeterliliktenEklendi = "yeterliliktenEklendi";
			$readOnly = ' readOnly="readOnly" ';
				
			}
			else
			{
			$yeterliliktenEklendi = "";
			$readOnly = ' ';
			}
				
			echo '<tr id="birimGelistirenKuruluslarRow-'.($j+1).'" class="birimGelistirenKuruluslarRow">
			<td style="width:30px" class="blueBackgrounded">
			<input type="button" class="birimGelistirenKuruluslardanSilButton '.$yeterliliktenEklendi.'" id="birimGelistirenKuruluslardanSilButton-'.($j+1).'" value="SİL">
			</td>
			<td>
			<input type="text" value="'.$buBirimiGelistirenKuruluslar[$j]["KURULUS_ADI"].'" name="birimGelistirenKuruluslar-'.$birimID.'['.($j+1).']" style="width:80%;" class="birimGelistirenKuruluslar" '.$readOnly.'>
			</td>
			</tr>';
			}
				
			echo '<tr class="birimDogrulayanSektorKomitesiRow" id="birimDogrulayanSektorKomitesiRow-0">
			<td class="blueBackgrounded" style="width:30px">
			10
			</td>
			<td class="blueBackgrounded">
			YETERLİLİK BİRİMİNİ DOĞRULAYAN SEKTÖR KOMİTESİ : &nbsp;
			<input style="display:none;" type="button" value="EKLE" id="birimDogrulayanSektorKomitesiEkleButton-'.$birimID.'" class="birimDogrulayanSektorKomitesiEkleButton" ></input>
			<font style="font-weight:normal;">MYK '.FormFactory::toUpperCase($this->yeterliliginSektoru[0]["SEKTOR_ADI"]).' SEKTÖR KOMİTESİ</font>
			</td>
			</tr>';
				
				
			$buBirimiDogrulayanKomiteUyeleriViewID = 'birimiDogrulayanKomiteUyeleri-'.$birimID;
			$buBirimiDogrulayanKomiteUyeleri = $this->$buBirimiDogrulayanKomiteUyeleriViewID;
			
			for($j=0; $j<count($buBirimiDogrulayanKomiteUyeleri); $j++)
			echo '<tr>
			<td style="width:30px" class="blueBackgrounded">
			<input type="button" value="SİL" class="birimDogrulayanSektorKomitesiSilButton">
			</td>
			<td>
			<input type="text" style="width:80%;" name="birimDogrulayanSektorKomitesi-'.$birimID.'[]" value="'.$buBirimiDogrulayanKomiteUyeleri[$j]['KOMITE_UYESI_ADI'].'">
			</td>
			</tr>';
				
				
				
				
			echo '<tr class="" id="">
			<td colspan="2" class="blueBackgrounded">
			EKLER
			</td>
			</tr>';
				
			echo '<tr class="" id="">
			<td class="blueBackgrounded" style="width:30px">EK1</td>
			<td class="blueBackgrounded">Yeterlilik Biriminin Kazandırılması için Tavsiye Edilen Eğitime İlişkin Bilgiler
			</td>
			</tr>';
			
			//////// EK 1  //////////////////
			echo '<tr><td colspan="2" style="padding-left:20px; ">';
				
			$buBiriminEk1YazilariViewID = 'buBiriminEk1Yazilari-'.$birimID;
			$buBiriminEk1Yazilari = $this->$buBiriminEk1YazilariViewID;
			for($j=0; $j<count($buBiriminEk1Yazilari); $j++)
				echo $buBiriminEk1Yazilari[$j]["EK1_YAZISI"].'<br>';
					
			echo '</td></tr>';
				
				
			////    EK1 BITER    //////////////////////
				
			echo '<tr class="" id="">
			<td class="blueBackgrounded" style="width:30px">EK2</td>
			<td class="blueBackgrounded">Yeterlilik Biriminde Belirtilen Değerlendirme Araçları İle Ölçülen Başarım Ölçütlerine İlişkin Tablo';
				
			if($eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]=='1')
				echo'<br>Kontrol Listeli';
			else
				echo '<br>Kontrol Listesiz';
				
			echo '</td>
			</tr>';
				
				
			///////////////// Ek - 2
			if($eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]!='1')
			{
				echo '<tr class="">
				<td style="width:30px" colspan="2">
				<div id="kontrolListesizEk2-'.$birimID.'">
				<table class="KontrolListesizEk2Tablolari" id="KontrolListesizEk2Tablolari-'.$birimID.'" style="width:100%;">
				<thead>
					<tr><th class="blueBackgrounded" style="width:40%;">Başarım Ölçütü</th>
					<th class="blueBackgrounded" style="width:60%;">Değerlendirme Aracı</th></tr>
				</thead><tbody>';
			
				$biriminEk2si_KontrolListesizViewID = 'biriminEk2si_KontrolListesiz-'.$birimID;
				$biriminEk2si_KontrolListesiz = $this->$biriminEk2si_KontrolListesizViewID;
					
				for($j=0; $j<count($biriminEk2si_KontrolListesiz); $j++)
				{
					echo '<tr><td>'.$biriminEk2si_KontrolListesiz[$j]["OGRENME_CIKTISI_INDEX"].'.'.$biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_INDEX"].'</td>';
					echo '<td>'.$biriminEk2si_KontrolListesiz[$j]["SINAV_IDENTIFIER"].$biriminEk2si_KontrolListesiz[$j]["SINAV_INDEX"].'</td></tr>';
				}
					
				echo '</tbody></table></div>';
				echo '</td></tr>';
			}	
			else
			{
				echo '<tr><td colspan="2"><div style="float:left; width:100%;" id="kontrolListeliEk2Div1-'.$birimID.'">
				<table class="KontrolListeliEk2Tablosu1" id="KontrolListeliEk2Tablosu1-'.$birimID.'" style="width:100%;">
				<thead>
				<tr>
				<th class="blueBackgrounded">BG Kodu</th>
				<th class="blueBackgrounded">Bilgi ve Anlayış</th>
				<th class="blueBackgrounded">UMS İlgili Bölüm</th>
				<th class="blueBackgrounded">Yeterlilik Birimi Başarım Ölçütü</th>
				<th class="blueBackgrounded">Değerlendirme Aracı</th>
				</tr>
				</thead>
				
				<tbody>';
					
				$biriminEk2si_KontrolListeliTablo1ViewID = 'biriminEk2si_KontrolListeli-Tablo1-'.$birimID;
				$biriminEk2si_KontrolListeliTablo1 = $this->$biriminEk2si_KontrolListeliTablo1ViewID;
				for($j=0; $j<count($biriminEk2si_KontrolListeliTablo1); $j++)
				{
				$olcmeDegerlendirmeler = $model->getBiriminEk2KontrolListeli_OlcmeDegerlendirmesi($biriminEk2si_KontrolListeliTablo1[$j]['EK2_KONTROL_LISTELI_ID']);
				$olcDegText = '';
				foreach ($olcmeDegerlendirmeler as $od)
				$olcDegText .= $od['DEGERLENDIRME_ARACI_HARF'].$od['DEGERLENDIRME_ARACI_NUMARA'].'<br>';
				
				echo '<tr>
				<td>BG'.$biriminEk2si_KontrolListeliTablo1[$j]["SIRA_NO"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo1[$j]["EK_YAZISI"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo1[$j]["MESLEK_STANDARDI_BO_TEXT"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo1[$j]["OGRENME_CIKTISI_INDEX"].'.'.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_INDEX"].'</td>
				<td>'.$olcDegText.'</td>
				</tr>';
					
				}
					
				echo '</tbody></table>
				</div>
				
				<div style="float:left; width:100%;"  id="KontrolListeliEk2Div2-'.$birimID.'"">
				<table class="KontrolListeliEk2Tablosu2" id="KontrolListeliEk2Tablosu2-'.$birimID.'" style="width:100%;">
				<thead>
				<tr>
				<th class="blueBackgrounded">BY Kodu</th>
				<th class="blueBackgrounded">Beceri</th>
				<th class="blueBackgrounded">UMS İlgili Bölüm</th>
				<th class="blueBackgrounded">Yeterlilik Birimi Başarım Ölçütü</th>
				<th class="blueBackgrounded">Değerlendirme Aracı</th>
				</tr>
				</thead>
				
				<tbody>';
					
				$biriminEk2si_KontrolListeliTablo2ViewID = 'biriminEk2si_KontrolListeli-Tablo2-'.$birimID;
				$biriminEk2si_KontrolListeliTablo2 = $this->$biriminEk2si_KontrolListeliTablo2ViewID;
				for($j=0; $j<count($biriminEk2si_KontrolListeliTablo2); $j++)
				{
				$olcmeDegerlendirmeler = $model->getBiriminEk2KontrolListeli_OlcmeDegerlendirmesi($biriminEk2si_KontrolListeliTablo2[$j]['EK2_KONTROL_LISTELI_ID']);
				$olcDegText = '';
				foreach ($olcmeDegerlendirmeler as $od)
					$olcDegText .= $od['DEGERLENDIRME_ARACI_HARF'].$od['DEGERLENDIRME_ARACI_NUMARA'].'<br>';
				
					echo '<tr>
				<td>BY'.$biriminEk2si_KontrolListeliTablo2[$j]["SIRA_NO"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo2[$j]["EK_YAZISI"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo2[$j]["MESLEK_STANDARDI_BO_TEXT"].'</td>
				<td>'.$biriminEk2si_KontrolListeliTablo2[$j]["OGRENME_CIKTISI_INDEX"].'.'.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_INDEX"].'</td>
				<td>'.$olcDegText.'</td>
				</tr>';
				}
				
				echo '</tbody></table>
				</div>
				
				</td>
				</tr>';
			}	
				
			
			//////////////////// EK 2 BITER
				
				
				
			echo '</tbody></table>';
			
				
			echo '</div>';
			echo '</div>';
				
			
			
			//BIRIM POPUP BITER
			
			
			
			
			
		}
		
		
		
		
		//KAYNAK YETERLILIK BIRIMI 

		?>
	</div>
	</div>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriAlt' value='Geri' onClick='formSubmitted(1, <?php echo $tur_id;?>);'/>
			<?php if (!$isSektorSorumlusu){?>
			<input type='button' name='bitirAlt' value='Bitir' onClick='formSubmitted(2, <?php echo $tur_id;?>);'/>
			<?php }?>
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

function baslikHTML($baslikText)
{
	return '<div style="width:100%; float:left;" class="tumBasvuruBaslik">'.$baslikText.'</div>';
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
	var form = document.ChronoContact_yeterlilik_taslak;
	if (num == 1) { //Geri
		form.action = 'index.php?option=com_yeterlilik_taslak_yeni&layout=tanitim&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
    }else if (num == 2){ 
		if (tur == 1){
			form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=sektorSorumlusunaGonder&yeterlilik_id=<?php echo $yeterlilik_id;?>';  
	    }else if (tur == 2){ // Onaylanmis
	    	form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=onBasvuruBitir&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
		}else if (tur == 3){ // Onaylanmis Taslak Basvuru
	    	form.action = 'index.php?option=com_yeterlilik_taslak_yeni&task=basvuruBitir&yeterlilik_id=<?php echo $yeterlilik_id;?>'; 
		}
    }   
	form.submit(); 
}
</script>