<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once('libraries/form/form.php');

$evrak_id		= $this->evrak_id;
$standart_id	= $this->standart_id;
$hazirlayan		= $this->hazirlayan;
$terim			= $this->terim;
$meslekTanitim 	= $this->meslekTanitim;
$meslekStandart = $this->meslekStandart;
$ekipman		= $this->ekipman;
$bilgiBeceri 	= $this->bilgiBeceri;
$tutumDavranis 	= $this->tutumDavranis;
$gorevAlan 		= $this->gorevAlan;
$profil 		= $this->profil;
$tur_id			= $this->tur_id;
//
	
$user =& JFactory::getUser();
$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
//
?>
<form
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">
	  
	<input type="hidden" value="<?php echo $evrak_id;?>" name="evrak_id">
	<input type='hidden' value='1' name='2306e6467a830d886ea16ea1849f7ff5'/>	
	<input type='hidden' value='e84ad33046067593b8356745abbdd473' name='1cf1'/>

	<div class='form_element'>
		<?php 
		//Hazirlayan
		echo blockTitle ("STANDARDI HAZIRLAYAN KURULUŞLAR");
		echo '<div id="hazirlayan">';
// 		if ($hazirlayan != null){
// 			if (count($hazirlayan) > 0)
// 				echo "<span>". FormFactory::toUpperCase($hazirlayan[0]["KURULUS_ADI"]) ."</span><br/>";
// 			else
// 				echo "<span>". FormFactory::toUpperCase($hazirlayan[0]["KURULUS_ADI"]) ."</span>";
				
// 			for ($i = 0; $i < count($hazirlayan); $i++){
// 				$row = $hazirlayan[$i];
				
// 				if ($i == count($hazirlayan)-1)
// 					echo "<span>". FormFactory::toUpperCase($row["HAZIRLAYAN_KURULUS_ADI"]) ."</span>";
// 				else
// 					echo "<span>". FormFactory::toUpperCase($row["HAZIRLAYAN_KURULUS_ADI"]) ."</span><br/>";
// 			}
// 		}
		for ($i=0; $i< count($hazirlayan); $i++) {
		
 			if ($hazirlayan[$i]["HAZIRLAYAN_KURULUS_ADI"]){
 				$kuruluslar.= '<span>';
				if ($hazirlayan[$i]["KURULUS_TURU"]==2){
				$kuruluslar.= "Yardımcı Kuruluş: ";
				}
				$kuruluslar.= ucfirst(FormFactory::normalizeVariable ($hazirlayan[$i]["HAZIRLAYAN_KURULUS_ADI"])) .'</span><br>';
 			} else {
 				$kuruluslar.= '<span>'.ucfirst(FormFactory::normalizeVariable ($hazirlayan[$i]["KURULUS_ADI"])) .'</span><br>';
 			}
 			
			
 		}
		echo mb_substr($kuruluslar,0,-4,"utf-8");
		echo '</div>';

		//TERIM / KISALTMA
		echo '<div id="terim">';
		echo blockTitle ("TERİMLER, SİMGELER VE KISALTMALAR");
		if ($terim != null){
			foreach ($terim[0] as $row){
				echo statikTabloHTML ($row["TERIM_ADI"].": "	, $row["TERIM_ACIKLAMA"]);
				echo "<br />";
			}
		}
		echo "ifade eder.";
		echo '</div>';
		
		//MESLEK TANITIMI
		echo '<div id="tanitim">';
		echo blockTitle ("2. MESLEK TANITIMI");
		echo statikHTML ("2.1. Meslek Tanımı", $meslekTanitim["MESLEK_TANIM"]);
		//echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim2">';
		echo statikHTML ("2.2. Mesleğin Uluslararası Sınıflandırma Sistemlerindeki Yeri", null);
		if ($meslekStandart != null){
			foreach ($meslekStandart as $row){
				echo statikTabloHTML ($row["STANDART_ADI"].": "	, $row["STANDART_ACIKLAMA"]);
				echo "<br />";
			}
		}else
			echo "<br />";
		
		echo '</div>';
		
		echo '<div id="tanitim3">';
		echo statikHTML ("2.3. Sağlık, Güvenlik ve Çevre ile ilgili Düzenlemeler", $meslekTanitim["MESLEK_SAGLIK_DUZENLEME"]);
		echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim4">';
		echo statikHTML ("2.4. Meslek ile İlgili Diğer Mevzuat", $meslekTanitim["MESLEK_MEVZUAT"]);
		echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim5">';
		echo statikHTML ("2.5. Çalışma Ortamı ve Koşulları", $meslekTanitim["MESLEK_CALISMA_KOSUL"]);
		echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim6">';
		echo statikHTML ("2.6. Mesleğe İlişkin Diğer Gereklilikler", $meslekTanitim["MESLEK_GEREKLILIK"]);
		echo "</div>";
		
		//MESLEK PROFILI
		echo '<div id="profil_tablo">';
		echo blockTitle ("3. MESLEK PROFİLİ");
		echo "</div>";
		//Basarim Olcut
		echo statikHTML ("3.1. Görevler, İşlemler ve Başarım Ölçütleri", null);
		echo gibTabloHTML ($profil);		
		echo "<br />";
		
		//Ekipman
		echo '<div id="ekipman">';
		echo statikHTML ("3.2. Kullanılan Araç, Gereç ve Ekipman", null);
		if ($ekipman != null){
			$i = 1;
			foreach ($ekipman as $row){
				echo statikTabloLightHTML ("&nbsp;&nbsp;&nbsp;".$i++.". ", $row["EKIPMAN_ADI"]);
			}
		}
		echo "</div>";
		echo "<br />";
		
		//Bilgi/Beceri
		echo '<div id="bilgiBeceri">';
		echo statikHTML ("3.3. Bilgi ve Beceriler", null);
		$i = 1;
		if ($bilgiBeceri != null){
			foreach ($bilgiBeceri as $row){
				echo statikTabloLightHTML ("&nbsp;&nbsp;&nbsp;".$i++.". ", $row["BILGI_BECERI_ADI"]);
			}
		}
		echo "<br />";
		echo "</div>";
		
		//Tutum/Davranış
		echo '<div id="tutumDavranis">';
		echo statikHTML ("3.4. Tutum ve Davranışlar", null);
		if ($tutumDavranis != null){
			$i = 1;
			foreach ($tutumDavranis as $row){
				echo statikTabloLightHTML ("&nbsp;&nbsp;&nbsp;".$i++.". ",$row["TUTUM_DAVRANIS_ADI"]);
			}
		}
		echo "</div>";
		
		echo '<div id="tutumDavranis_son">';
		echo "<br />";
		?>

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

function statikTabloHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
				<span><strong>'.$paramTitle.'</strong>'.$param.'</span>
			</div>';
	
	return $html; 
}
function statikTabloLightHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
				<span>'.$paramTitle.$param.'</span>
			</div>';
	
	return $html; 
}


function gibTabloHTML ($profil){
	$tableLetters = array ('A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Y','Z');
	$html = "";
	$gorevIndex = 0;
	$islemIndex = 0;
	$basarimIndex = 0;
	$basarimGorevIndex = -1;
	
	$gorev_profil_id = 0;
	$eski_profil_id  = 0; 
	$islemParent = 0; 
	$basarimParent = 0; 
	for ($i = 0; $i < count($profil); $i++){
		$arr = $profil[$i];
	
		if ($arr["PROFIL_GOREV_ADI"] != null){
			$gorev_profil_id = $arr["PROFIL_ID"];
			$gorevArr [$gorevIndex]  = $arr["PROFIL_GOREV_ADI"];
			$gorevIndex++;
		}else if ($arr["PROFIL_ISLEM_ADI"] != null){
			if ($islemParent != $arr["PARENT_ID"]){
				$arrIslemIndex = 0;
				$islemParent = $arr["PARENT_ID"];
				
				$islemArr [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
				$arrIslemIndex++;
				$islemIndex++;
			}else{
				$islemArr [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
				$arrIslemIndex++;
			}
		}else if ($arr["PROFIL_BASARIM_OLCUT"] != null){
			if ($eski_profil_id != $gorev_profil_id){
				$basarimIndex = 0;
				$basarimGorevIndex++;
				$gorev_profil_id = $eski_profil_id;
			}
			
			if ($basarimParent != $arr["PARENT_ID"]){
				$arrBasarimIndex = 0;
				$basarimParent = $arr["PARENT_ID"];
				
				$basarimArr [$basarimGorevIndex][$basarimIndex][$arrBasarimIndex++]  = $arr["PROFIL_BASARIM_OLCUT"];
				$basarimIndex++;
			}else{
				$basarimArr [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_OLCUT"];
				$arrBasarimIndex++;
			}
		}
	}
	
	$letterWidth="5%";
	$dataWidth=(85/3)."%";
//	$letterWidth=(50/3)."%";
//	$dataWidth=(50/3)."%";
	$htmlTitle =	'<table border="1" width="100%">
						<thead>
							<tr align="center" valign="middle">
								<td colspan="2"><strong>Görevler</strong></td>
								<td colspan="2"><strong>İşlemler</strong></td>
								<td colspan="2"><strong>Başarım Ölçütleri</strong></td>
							</tr>
						</thead>
						<tbody >
							<tr align="center" valign="middle">
								<td width="'.$letterWidth.'"><strong>Kod</strong></td>
								<td width="'.$dataWidth.'"><strong>Adı</strong></td>
								<td width="'.$letterWidth.'"><strong>Kod</strong></td>
								<td width="'.$dataWidth.'"><strong>Adı</strong></td>
								<td width="'.$letterWidth.'"><strong>Kod</strong></td>
								<td width="'.$dataWidth.'"><strong>Açıklama</strong></td>
							</tr>';
	
	$i=0;	   
	foreach ($basarimArr as $gorev){
		$gorevRowSpan = 0;
		$islemBasarimHtml = "";
		$j=0;
		foreach ($gorev as $islem){
			$islemRowSpan = 0;
			$basarimHtml = "";
			$k=0;
			foreach ($islem as $basarim){
				if ($k == 0){
					$basarimHtmlFirst = "<td width=\"".$letterWidth."\" align=\"center\" valign=\"middle\"><strong>".$tableLetters[$i].'.'.($j+1).'.'.($k+1)."</strong></td>
								 		 <td width=\"".$dataWidth."\">".$basarim."</td>";
				}else{
					$basarimHtml .= "<tr><td width=\"".$letterWidth."\" align=\"center\" valign=\"middle\"><strong>".$tableLetters[$i].'.'.($j+1).'.'.($k+1)."</strong></td>
								 	 <td width=\"".$dataWidth."\">".$basarim."</td></tr>";
				}

				$gorevRowSpan++;
				$islemRowSpan++;
				$k++;
			}	
			$islemHtml = '<td width="'.$letterWidth.'" align="center" valign="middle" rowspan="'.$islemRowSpan.'"><strong>'.$tableLetters[$i].'.'.($j+1).'</strong></td>
   			 			  <td width="'.$dataWidth.'" rowspan="'.$islemRowSpan.'">'.$islemArr[$i][$j].'</td>';
							
			if ($j == 0){
				$islemBasarimHtmlFirst = $islemHtml.$basarimHtmlFirst;
				$basarimHtmlPart = $basarimHtml;
			}else{
				$islemBasarimHtml .= '<tr>'.$islemHtml.$basarimHtmlFirst.'</tr>'.$basarimHtml;
			}
			$j++;
		}
		
		$gorevHtml = '<td width="'.$letterWidth.'" align="center" valign="middle" rowspan="'.$gorevRowSpan.'"><strong>'.$tableLetters[$i].'</strong></td>
					   <td width="'.$dataWidth.'" rowspan="'.$gorevRowSpan.'">'.$gorevArr[$i].'</td>';
		
		$tabloHtmlPart = '<tr>'.$gorevHtml.$islemBasarimHtmlFirst.'</tr>'.$basarimHtmlPart.$islemBasarimHtml;
		$html .= '<div id="gibTablo'.($i+1).'">'.$htmlTitle.$tabloHtmlPart.'</tbody></table></div><br /><br />';
		$i++;
	}

	return $html;
}

function blockTitle ($title, $align="center"){
	return '<h3 style="font-weight:bold;margin-top:15px;font-size:15px;text-align:'.$align.';">'.$title.'</h3> <br />';
}
?>

<script type="text/javascript">
function formSubmitted (num, tur)
{
	var form = document.ChronoContact_meslek_std_taslak;
	if (num == 1) { //Geri
		var taslak = "";
		if (tur == 3)
			taslak = "&taslak=1";
		form.action = 'index.php?option=com_meslek_std_taslak&layout=terim&standart_id=<?php echo $standart_id;?>' + taslak; 
    }else if (num == 2){ // On Basvuru Sektor Sorumlusuna Gönder
		if (tur == 1){
			form.action = 'index.php?option=com_meslek_std_taslak&task=sektorSorumlusunaGonder&standart_id=<?php echo $standart_id;?>'; 
	    }else if (tur == 2){ // Onaylanmis
	    	form.action = 'index.php?option=com_meslek_std_taslak&task=onBasvuruBitir&standart_id=<?php echo $standart_id;?>';
		}else if (tur == 3){ // Onaylanmis Taslak Basvuru
	    	form.action = 'index.php?option=com_meslek_std_taslak&task=basvuruBitir&standart_id=<?php echo $standart_id;?>';
		}
    }   
	form.submit(); 
}
</script>