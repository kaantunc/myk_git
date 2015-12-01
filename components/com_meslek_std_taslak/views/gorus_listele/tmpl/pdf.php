<?php

//echo '<pre>';
//print_r($this->gorusler);
//echo '</pre>';

$width = "550px";
if (isset ($this->gorusler[0])){
	$gorus_id = -1;
	echo '<span style="text-align:center;">'.$this->gorusler[0]["KURULUS_ADI"].'</span>';
	echo "<br />";
	echo '<span style="text-align:center;">'.$this->gorusler[0]["STANDART_ADI"].' ('.$this->gorusler[0]["SEVIYE_ADI"].') </span>';
	echo "<br />";
	
	$html .= '<br />
		  <table border="1" style="text-align:center;">
			<tr>
				<td width="2%"><strong>#</strong></td>
				<td width="20%"><strong>Görüş Bildiren Kuruluş/Kişi/Unvanı :</strong></td>
				<td width="20%"><strong>Standart üzerindeki yer <br />(bölüm,satır no,sayfa no)</strong></td>
				<td width="20%"><strong>Görüş ve Öneriler</strong></td>
				<td width="19%"><strong>Değerlendirme</strong></td>
				<td width="19%"><strong>Düzeltme</strong></td>
			</tr>
		  </table>';
	$i = 1;
	foreach ($this->gorusler as $gorus){	
		$html .= '<table border="1">
					<tr>
						<td width="2%">'.$i.'</td>
						<td width="20%">'.$gorus["GORUS_BILDIREN"].'</td>
						<td width="20%">'.$gorus["STANDART_YERI"].'</td>
						<td width="20%">'.$gorus["GORUS_VE_ONERILER"].'</td>
						<td width="19%">'.$gorus["DEGERLENDIRME"].'</td>
						<td width="19%">'.$gorus["DUZELTME"].'</td>
					</tr>
				 </table>';
		
		$i++;
	}
	
	echo $html;
}

?>