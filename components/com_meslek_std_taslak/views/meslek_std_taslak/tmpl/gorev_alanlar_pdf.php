<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$gorevAlan = $this->gorevAlan;
$yonetimKurulu  = $this->yonetimKurulu;
$i = 0;	
if (isset($gorevAlan[0]) || isset($gorevAlan[1]) || isset($gorevAlan[2]) || isset($gorevAlan[3]) || isset($yonetimKurulu) || isset($gorevAlan[5])){
?>
<div id="gorev_alan">
<h3 style="font-weight:bold;margin-top:15px;font-size:15px;text-align:left;">Meslek Standardı Hazırlama Sürecinde Görev Alanlar</h3> <br />
<?php
if (isset($gorevAlan) && $gorevAlan[0]!= null){
	
	echo statikHTML (++$i .". Meslek Standardı Hazırlayan Kuruluşun Meslek Standardı Ekibi", null);
	
	foreach ($gorevAlan[0] as $row){
		$gorevalanunvan="";
		$gorevalankurulus="";
		$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
		$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
		echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
		//echo statikTabloHTML ($row["GOREV_ALAN_AD_SOYAD"]." - ", $row["GOREV_ALAN_UNVAN"]." , ".$row["GOREV_ALAN_KURULUS"]);
	}
}
echo "<br /><br />";		

if (isset($gorevAlan) && $gorevAlan[1]!= null){

	echo statikHTML (++$i .". Teknik Çalışma Grubu Üyeleri", null);
	
	foreach ($gorevAlan[1] as $row){
		$gorevalanunvan="";
		$gorevalankurulus="";
		$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
		$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
		echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
		//echo statikTabloHTML ($row["GOREV_ALAN_AD_SOYAD"]." - ", $row["GOREV_ALAN_UNVAN"].$virgul.$row["GOREV_ALAN_KURULUS"]);
		
	}
}
echo "<br /><br />";

if (isset($gorevAlan) && $gorevAlan[2]!= null){
	
	echo statikHTML (++$i .". Görüş İstenen Kişi, Kurum ve Kuruluşlar", null);
	
	foreach ($gorevAlan[2] as $row){
		$ad	= "";
		$unvan = "";
		if ($row["GOREV_ALAN_AD_SOYAD"] != "")
			$ad = $row["GOREV_ALAN_AD_SOYAD"]." - ";
		if ($row["GOREV_ALAN_UNVAN"] != "")
			$unvan = $row["GOREV_ALAN_UNVAN"]." , ";
			
		echo statikTabloHTML ($ad, $unvan.$row["GOREV_ALAN_KURULUS"]);
	}
}
echo "<br /><br />";

if (isset($gorevAlan) && $gorevAlan[3]!= null){
	
	echo statikHTML (++$i .". MYK Sektör Komitesi Üyeleri ve Uzmanlar", null);
	echo "<table>";
	foreach ($gorevAlan[3] as $row){
		echo statikTabloLighttdHTML ($row["GOREV_ALAN_AD_SOYAD"].", ", $row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")");
	}
	echo "</table>";
}
echo "<br /><br />";

if ($yonetimKurulu!= null){
	
	echo statikHTML (++$i .". MYK Yönetim Kurulu", null);
	echo "<table>";
	foreach ($yonetimKurulu as $row){
		echo statikTabloLighttdHTML ($row["GOREV_ALAN_AD_SOYAD"].", ", $row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")");
	}
	echo "</table>";
}
echo "<br /><br /></div>";


}else{
	echo '<div class="sonucBulunamadi">Henüz hiçbir görev alan bilgisi bulunmamaktadır.</div>';	
}
	
function statikTabloHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
			<span>'.$paramTitle.$param.'</span>
			</div>';
	return $html; 
}
function statikTabloLightHTML ($paramTitle, $param){	
	$html = '<div style = "height:auto; padding: 5px 5px 5px 10px;">
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
