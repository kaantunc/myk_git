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
$yonetimKurulu  = $this->yonetimKurulu;
$profil 		= $this->profil;
$tur_id			= $this->tur_id;
$cellPadding	= 3;
//
$user =& JFactory::getUser();
$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
//
?>
	<div class='form_element'>
		<?php  
		//Hazirlayan
		echo blockTitle ("STANDARDI HAZIRLAYAN KURULUŞLAR");
		echo '<div id="hazirlayan">';
		$kuruluslar="";
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
		echo blockTitle ("TERİMLER, SİMGELER VE KISALTMALAR","center");
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
		echo statikHTML ("2.1. Meslek Tanımı", $meslekTanitim["MESLEK_TANIM"], 0);
		echo '</div>';
		
		echo '<div id="tanitim2">';
		echo statikHTML ("2.2. Mesleğin Uluslararası Sınıflandırma Sistemlerindeki Yeri", null);
		if ($meslekStandart != null){
			foreach ($meslekStandart as $row){
				echo statikTabloHTML ($row["STANDART_ADI"].": "	, $row["STANDART_ACIKLAMA"]);
			}
		}else
		
		echo '</div>';
		
		echo '<div id="tanitim3">';
		echo statikHTML ("2.3. Sağlık, Güvenlik ve Çevre ile ilgili Düzenlemeler", $meslekTanitim["MESLEK_SAGLIK_DUZENLEME"]);
		//echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim4">';
		echo statikHTML ("2.4. Meslek ile İlgili Diğer Mevzuat", $meslekTanitim["MESLEK_MEVZUAT"]);
		//echo "<br />";
		echo '</div>';
		
		echo '<div id="tanitim5">';
		echo statikHTML ("2.5. Çalışma Ortamı ve Koşulları", $meslekTanitim["MESLEK_CALISMA_KOSUL"]);
		//echo "<br />";
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
		
		//Ekipman
		echo '<div id="ekipman">';
		echo statikHTML2 ("3.2. Kullanılan Araç, Gereç ve Ekipman", null);
		if ($ekipman != null){
			$i = 1;
			echo "<ol>";
			foreach ($ekipman as $row){
				echo statikTabloLightHTML ("<li value=".$i++.">",$row["EKIPMAN_ADI"]);
			}
		}
		echo "</ol></div>";
		
		//Bilgi/Beceri
		echo '<div id="bilgiBeceri">';
		echo statikHTML2 ("3.3. Bilgi ve Beceriler", null);
		$i = 1;
			echo "<ol>";
		if ($bilgiBeceri != null){
			foreach ($bilgiBeceri as $row){
				echo statikTabloLightHTML ("<li value=".$i++.">", $row["BILGI_BECERI_ADI"]);
			}
		}
		echo "</ol></div>";
		
		//Tutum/Davranış
		echo '<div id="tutumDavranis">';
		echo statikHTML2 ("3.4. Tutum ve Davranışlar", null);
		if ($tutumDavranis != null){
			$i = 1;
			echo "<ol>";
			foreach ($tutumDavranis as $row){
				echo statikTabloLightHTML ("<li value=".$i++." style='padding-left:20px;'>",$row["TUTUM_DAVRANIS_ADI"]);
			}
		}
		echo "</ol></div>";
		
		echo '<div id="tutumDavranis_son">';
		echo "</div>";
		
		if (isset($gorevAlan[0]) || isset($gorevAlan[1]) || isset($gorevAlan[2]) || isset($gorevAlan[3]) || isset($yonetimKurulu) || isset($gorevAlan[5])){
			echo '<div id="gorev_alan">';
			echo blockTitle ("<u>Ek:</u> Meslek Standardı Hazırlama Sürecinde Görev Alanlar");
			echo statikHTML ("1. Meslek Standardı Hazırlayan Kuruluşun Meslek Standardı Ekibi", null);
			if (isset($gorevAlan) && $gorevAlan[0]!= null){
				foreach ($gorevAlan[0] as $row){
					$gorevalanunvan="";
					$gorevalankurulus="";
					$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
					$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
					echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
				}
			}
			echo statikHTML ("2. Teknik Çalışma Grubu Üyeleri", null);
			if (isset($gorevAlan) && $gorevAlan[1]!= null){
				foreach ($gorevAlan[1] as $row){
					$gorevalanunvan="";
					$gorevalankurulus="";
					$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
					$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
					echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
				}
			}

			echo statikHTML ("3. Görüş İstenen Kişi, Kurum ve Kuruluşlar", null);
			if (isset($gorevAlan) && $gorevAlan[2]!= null){
				foreach ($gorevAlan[2] as $row){
					$ad	= "";
					$unvan = "";
					if ($row["GOREV_ALAN_AD_SOYAD"] != "")
						$ad = $row["GOREV_ALAN_AD_SOYAD"]." - ";
					if ($row["GOREV_ALAN_UNVAN"] != "")
						$unvan = $row["GOREV_ALAN_UNVAN"]." , ";
						
					echo statikTabloLightHTML ($ad, $unvan.$row["GOREV_ALAN_KURULUS"]);
				}
			}
			echo statikHTML ("4. MYK Sektör Komitesi Üyeleri ve Uzmanlar", null);
			if (isset($gorevAlan) && $gorevAlan[3]!= null){
				echo "<table cellpadding=0><tbody>";
				foreach ($gorevAlan[3] as $row){
					/// kurulus adi parantez icinde:
					echo statikTabloLighttdHTML2 ($row["GOREV_ALAN_AD_SOYAD"].", ", $row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")");
				}
				echo "</tbody></table>";
			}
				
			echo statikHTML ("5. MYK Yönetim Kurulu", null);
			if ($yonetimKurulu!= null){
				echo "<table cellpadding=0>";			
				foreach ($yonetimKurulu as $row){
					/// kurulus adi parantez icinde:
					echo statikTabloLighttdHTML2 ($row["GOREV_ALAN_AD_SOYAD"].", ", $row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")");
				}
				echo "</table>";
			}
			echo "</div>";
		}
		?>

	</div>
<?php

function blockTitle ($title, $align="left"){
	return '<span align='.$align.'><b><font size=14>'.$title.'</font></b></span><br>';
}

function statikHTML ($paramTitle, $param, $bottomPadding=0 ){
	$html = '<br/>
				<span><strong>'.
				$paramTitle
				.'</strong></span>
			<p>';
	
	if (strlen($param) != 0){
		$html .= '
					<span style="padding:0px; margin:0px; text-align:justify;">'.FormFactory::ignoreBreaks(rtrim($param, "\x00..\x1F")).'</span>			
				  ';
	}
	
	return $html;
}

function statikHTML2 ($paramTitle, $param, $bottomPadding=0 ){
	$html = '<br/>
				<span><strong>'.
				$paramTitle
				.'</strong></span>
			<br>';
	
	if (strlen($param) != 0){
		$html .= '
					<span style="padding:0px; margin:0px; text-align:justify;">'.FormFactory::ignoreBreaks(rtrim($param, "\x00..\x1F")).'</span>			
				  ';
	}
	
	return $html;
}

function statikTabloHTML ($paramTitle, $param){	
	$html = '<div>
				<span style="text-align:justify;"><strong>'.rtrim($paramTitle, "\x00..\x1F").'</strong>'.rtrim($param, "\x00..\x1F").'</span>
			</div>';
	
	return $html; 
}
function statikTabloLightHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding-top:-10px">
				<span>'.$paramTitle.$param.'</span>
			</div>';
	
	return $html; 
}

function statikTabloLighttdHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
				<tr><td width=30%>'.$paramTitle."</td><td width=70%> ".$param.'</td></tr>
			</div>';
	
	return $html; 
}
function statikTabloLighttdHTML2 ($paramTitle, $param){
	$html = '<tr><td width=40%>'.$paramTitle."</td><td width=70%> ".$param.'</td></tr>';

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
			$gorevArrDip [$gorevIndex]  = $arr["PROFIL_GOREV_DIPNOT"];
			$gorevIndex++;
		}else if ($arr["PROFIL_ISLEM_ADI"] != null){
			if ($islemParent != $arr["PARENT_ID"]){
				$arrIslemIndex = 0;
				$islemParent = $arr["PARENT_ID"];
				
				$islemArr [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
				$islemArrDip [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_DIPNOT"];
				$arrIslemIndex++;
				$islemIndex++;
			}else{
				$islemArr [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
				$islemArrDip [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_DIPNOT"];
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
				$basarimArrDip [$basarimGorevIndex][$basarimIndex][$arrBasarimIndex++]  = $arr["PROFIL_BASARIM_DIPNOT"];
				$basarimIndex++;
			}else{
				$basarimArr [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_OLCUT"];
				$basarimArrDip [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_DIPNOT"];
				$arrBasarimIndex++;
			}
		}
	}
	
	$letterWidth="5%";
	$dataWidth=(85/3)."%";
//	$letterWidth=(50/3)."%";
//	$dataWidth=(50/3)."%";
	$htmlTitle =	'<table border="1" width="100%" cellpadding=".$cellPadding.">
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
        $Dipnot="";	   
		$gorevRowSpan = 0;
		$islemBasarimHtml = "";
        if ($gorevArrDip[$i]!=""){    
		  $Dipnot .='<strong>'.$tableLetters[$i].': </strong>'.$gorevArrDip[$i].'<br>';
        }
		$j=0;
		foreach ($gorev as $islem){
			$islemRowSpan = 0;
			$basarimHtml = "";
            if ($islemArrDip[$i][$j]!=""){
                $Dipnot.='<strong>'.$tableLetters[$i].'.'.($j+1).'</strong>: '.$islemArrDip[$i][$j].'<br>';
            }							
			$k=0;
			foreach ($islem as $basarim){
                if ($basarimArrDip[$i][$j][$k+1]!=""){
                    $Dipnot.="<strong>".$tableLetters[$i].'.'.($j+1).'.'.($k+1)."</strong>: ".$basarimArrDip[$i][$j][$k+1]."<br>";
                }
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
		$html .= '<div id="gibTablo'.($i+1).'">'.$htmlTitle.$tabloHtmlPart.'</tbody></table></div>';
        if ($Dipnot!=""){
            $html.='<strong>Dipnotlar</strong><br><small>'.$Dipnot.'</small>';
        }
        $html.='<br /><br />';
		$i++;
	}

	return $html;
}

?>
