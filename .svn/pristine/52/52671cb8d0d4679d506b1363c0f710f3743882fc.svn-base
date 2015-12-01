<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$evrak_id		 = $this->evrak_id;
$title 			 = $this->title;
$kurulus 		 = $this->kurulus;
$iller 			 = $this->pm_il;
$sektor			 = $this->pm_sektor;
$sektorler		 = explode("#",$this->kurulus["SEKTORLER"]);
$mykdeneyim 	 = $this->mykdeneyim;
$deneyim_tipleri = $this->deneyim_tipleri;
$sektorlerim 	 = $this->basvuru_sektor;
$basvuru_yeterlilik=$this->basvuru_yeterlilik;
$egitim 		 = $this->egitim;			
$sertifika 		 = $this->sertifika;			
$deneyim		 = $this->deneyim;
$alanlar		 = $this->basvuru_alanlari;
$dil 			 = $this->dil;
$dsy=explode("/", $kurulus[CV_PATH]);
$parcasayisi=count($dsy);
$cv="/cv/".$dsy[$parcasayisi-2]."/".$dsy[$parcasayisi-1];

if(isset($iller)){
	foreach ($iller as $row){
		if ($row["IL_ID"] != 0 ){
			if ($row["IL_ID"]==$this->kurulus["IL"] ){
				$sehir = $row['IL_ADI'];
			}
		}
	}
}

if(isset($sektor)){
	foreach ($sektor as $row){
		$selected = '';
		for ($i = 0; $i < count($sektorler); $i++){
			if ($sektorler[$i] == $row["SEKTOR_ID"]){
				$secimsektor .= $row["SEKTOR_ADI"]. "\n\r";
			}
		}

	}
}

if ($kurulus["BASVURU_DURUM"]==0){
?>
<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">
	  
	<input type="hidden" value="<?php echo $evrak_id;?>" name="evrak_id">
	<input type='hidden' value='1' name='2306e6467a830d886ea16ea1849f7ff5'/>	
	<input type='hidden' value='e84ad33046067593b8356745abbdd473' name='1cf1'/>

	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1);' style="margin-right:20px;"/>
			<!-- input type="button"  name="printbutton" value="Yazdır" onclick="return print1('print2')" style="margin-right:20px;"/>
			<input type="button"  name="printbutton" value="PDF" onclick="window.location = 'index.php?option=com_uzman_basvur&format=pdf&layout=pdf';" style="margin-right:20px;"/-->
			<input type='button' name='bitirUst' value='Başvuruyu Tamamla' onClick='formSubmitted(2);' style="margin-right:20px;"/>
			<br/><br/>

		</div>
		
		<div style="clear:both;"></div>
	</div>
<?php }?>	
	<div class='form_element' id="print2">
		<h1 class='contentheading'><?php echo $title;?></h1><br><br>	
		<?php 
		//KURULUS BILGILERI
		echo blockTitle ("1. İletişim Bilgileri");
		echo statikTabloHTML ("TC Kimlik No"	, $kurulus["TC_KIMLIK"]);
		echo statikTabloHTML ("Ünvanı"		, $kurulus[ONEK]);	
		echo statikTabloHTML ("Adı Soyadı"		, $kurulus[AD]." ".$kurulus[SOYAD]);	
		echo spacer ();
		echo statikTabloHTML ("Çalıştığı Kurum/kuruluş"	, $kurulus["KURUM"]);
		echo statikTabloHTML ("Kurumdaki/kuruluştaki Ünvanı"	, $kurulus["KURUM_UNVANI"]);
		echo statikTabloHTML ("Memuriyet Derecesi/Kademesi"	, $kurulus["DERECE"]."/".$kurulus["KADEME"]);
		echo spacer ();
		echo statikTabloHTML ("Adresi"			, $kurulus["ADRES"]);
		echo statikTabloHTML ("Posta Kodu"		, $kurulus["POSTAKODU"]);
		echo statikTabloHTML ("Şehir"			, $sehir);
		echo spacer ();
		echo statikTabloHTML ("Telefon"			, $kurulus["TEL"]);
		echo statikTabloHTML ("Faks"			, $kurulus["FAX"]);
		echo statikTabloHTML ("E-Posta"			, $kurulus["EPOSTA"]);
		echo statikTabloHTML ("Web"				, $kurulus["WEB"]);
		if($sektorSorumlusuMu){
			echo statikTabloHTML ("CV"				, $cv);
		}else {
			echo statikTabloHTML ("CV"				, "Eklendi");
		}
		
		//Başvuru Bilgileri
		echo blockTitle ("2. Başvuru Bilgileri");
		
		$titles   = array ("Teknik Uzman İçin Başvurduğu Sektörler", "Sektörler");
		$tableIds = array ("SEKTOR_ADI");
		echo tabloHTML ($titles, $tableIds, $sektorlerim, 1);
		echo blockTitle ("Görev Almak İstediğiniz Alanlar");
		echo statikTabloHTML ("Denetçi Olmak İstiyorum "	, $kurulus["DENETCI"]?"Evet":"Hayır");
		echo statikTabloHTML ("Teknik Uzman Olmak İstiyorum "	, $kurulus["UZMAN"]?"Evet":"Hayır");
		foreach ($alanlar as $row){
			if ($row["ALAN_TIPI"]==1){
				echo "<li><u>Ulusal Yeterlilik Uzmanlık Alanları:</u> ";
			}
			if ($row["ALAN_TIPI"]==2){
				echo "<li><u>Meslek Standartı Uzmanlık Alanları:</u> ";
			}
			if ($row["ALAN_TIPI"]==3){
				echo "<li><u>Denetimlerde Uzmanlık yapmak istediğiniz alanlar:</u> ";
			}
			if ($row["ALAN_TIPI"]==4){
				echo "<li><u>Diğer Konularda Uzmanlık yapmak istediğiniz alanlar:</u> ";
			}
			echo $row["ALAN"]."</li>";
		}
		
		
		//Eğitim
		$titles   = array ("3. Eğitim Bilgileri", "Türü", "Okul Adı", "Bölüm", "Başlama Tarihi", "Mezuniyet Tarihi");
		$tableIds = array ("TUR", "OKUL", "BOLUM", "BASLANGIC", "BITIS");
		echo tabloHTML ($titles, $tableIds, $egitim, 1);
		
		
		//Yabancı Dil
		$titles   = array ("4. Yabancı Dil Bilgisi", "Dil", "Okuma", "Yazma", "Konuşma", "Dinleme");
		$tableIds = array ("DIL", "OKUMA", "YAZMA", "KONUSMA", "ANLAMA");
		echo tabloHTML ($titles, $tableIds, $dil, 1);
		
		//Sertifika ve Belgeler
		$titles   = array ("5. Sertifika Ve Belgeler", "Belge/Sertifika Adı", "Veren Kurum/Kuruluş", "Verilme Tarihi", "Açıklama", "Dosya Yolu");
		$tableIds = array ("BELGE_ADI", "VEREN", "TARIH", "ACIKLAMA", "PATH");
		echo tabloHTML ($titles, $tableIds, $sertifika, 1);
		
		//İş Deneyimleri
		$titles   = array ("6. İş Deneyimleri", "Başlangıç", "Bitiş", "Kurum/Kuruluş", "Ünvanı", "İş Tanımı");
		$tableIds = array ("BASLANGIC", "BITIS", "ISYERI", "UNVAN", "IS_TANIMI");
		echo tabloHTML ($titles, $tableIds, $deneyim, 1);
		
		//MYK ile İlgili Deneyimler
		$titles   = array ("7. MYK ile İlgili Deneyimler", "Çalıştığı Alan", "Açıklama", "Süre (Ay)");
		$tableIds = array ("TIP", "ACIKLAMA", "SURE");
		echo tabloHTML ($titles, $tableIds, $mykdeneyim, 1,$deneyim_tipleri);
		
		
		
		
		?>
	</div>
	
	<?php 
	if ($kurulus["BASVURU_DURUM"]==0){
?>
	<div class="form_element">
		 <div style="padding-bottom:10px;">
			<input type='button' name='geriUst' value='Geri' onClick='formSubmitted(1);' style="margin-right:20px;"/>
			<!-- input type="button"  name="printbutton" value="Yazdır" onclick="return print1('print2')" style="margin-right:20px;"/>
			<input type="button"  name="printbutton" value="PDF" onclick="window.location = 'index.php?option=com_uzman_basvur&format=pdf&layout=pdf';" style="margin-right:20px;"/-->
			<input type='button' name='bitirUst' value='Başvuruyu Tamamla' onClick='formSubmitted(2);' style="margin-right:20px;"/>
		</div>
	</div>
	
</form>
        
<?php
}

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

function tabloHTML ($paramTitles, $paramIds, $params, $block=1,$diger=""){	
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
			if ($paramIds[$j]=="TUR"){
				if ($data[$paramIds[$j]]==1){
					$icerik="Lise";
				}
				if ($data[$paramIds[$j]]==2){
					$icerik="Ön Lisans";
				}
				if ($data[$paramIds[$j]]==3){
					$icerik="Lisans";
				}
				if ($data[$paramIds[$j]]==4){
					$icerik="Yüksek Lisans";
				}
				if ($data[$paramIds[$j]]==5){
					$icerik="Doktora";
				}
				if ($data[$paramIds[$j]]==9){
					$icerik="Diğer";
				}
				
			} else if ($paramIds[$j]=="PATH") {
				if ($data[$paramIds[$j]]!=""){
					if($sektorSorumlusuMu){							
						$dsy=explode("/", $data[$paramIds[$j]]);
						$parcasayisi=count($dsy);
						$icerik="/belge/".$dsy[$parcasayisi-2]."/".$dsy[$parcasayisi-1];
					} else {
						$icerik="Eklendi";
					}
				} else {
					$icerik="Eklenmedi";
				}
				
			} else if ($paramIds[$j]=="TIP") {
				foreach($diger as $satir2){
       				if ($data[$paramIds[$j]]==$satir2[DENEYIM_NO]){
      					$icerik= $satir2[DENEYIM_ADI];
      				}
      				
      			}

				
			} else {
				$icerik=$data[$paramIds[$j]];
			}
			$part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;">'.$icerik.'</td>';
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
<!--
function formSubmitted (num)
{
	var form = document.ChronoContact_uzman_basvuru_t4;
	if (num == 1) { 
		form.action = 'index.php?option=com_uzman_basvur'; 
    } else if (num == 2){
		form.action = 'index.php?option=com_uzman_basvur&task=basvuruBitir'; 
    }    
	form.submit(); 
}

function print1(strid) {
	if(confirm("Do you want to print?"))	{
		var values = document.getElementById(strid);
		var printing =
		window.open('','','left=0,top=0,width=550,height=400,toolbar=0,scrollbars=0,sta­?tus=0');
		printing.document.write(values.innerHTML);
		printing.document.close();
		printing.focus();
		printing.print();
		printing.close();
	}
}

//-->
</script>