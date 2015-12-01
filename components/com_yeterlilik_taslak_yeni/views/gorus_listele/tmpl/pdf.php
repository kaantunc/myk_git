<?php

//echo '<pre>';
//print_r($this->gorusler);
//echo '</pre>';


$width = "40";
if (isset ($this->gorusler[0])){
	$gorus_id = -1;
	
	
	echo '<span style="width:100%; float:left; text-align:center;">';
	foreach($this->gorusler[0]["KURULUS_ADI_ARRAY"] as $kurulus)
		echo $kurulus.'<BR/>';
	echo '</span>';
	
	echo "<br />";
	echo '<span style="text-align:center;">'.$this->gorusler[0]["YETERLILIK_ADI"].' ('.$this->gorusler[0]["SEVIYE_ADI"].') </span>';
	echo "<br />";
	
	$html = "";
	foreach ($this->gorusler as $gorus){
		if ($gorus_id != $gorus["GORUS_ID"]){
			$html .= '<br />
					  <br />
					  <br />
					  <table>
						<tr>
							<td style="width:'.$width.'%;"><strong>Son Görüş Verme Tarihi :</strong></td>
							<td>'.$gorus["SON_GORUS_TARIH"].'</td>
						</tr>
						<tr>
							<td style="width:'.$width.'%;"><strong>Görüş Bildiren Kuruluş/Kişi/Unvanı :</strong></td>
							<td>'.$gorus["GORUS_BILDIREN"].'</td>
						</tr>
						<tr>
							<td style="width:'.$width.'%;"><strong>Görüş Bildiren E-posta :</strong></td>
							<td>'.$gorus["GORUS_E_POSTA"].'</td>
						</tr>
						<tr>
							<td style="width:'.$width.'%;"><strong>Görüş Bildiren Telefon :</strong></td>
							<td>'.$gorus["GORUS_TELEFON"].'</td>
						</tr>
						<tr>
							<td style="width:'.$width.'%;"><strong>Görüş Bildiren Faks :</strong></td>
							<td>'.$gorus["GORUS_FAKS"].'</td>
						</tr>
					  </table>';
			
			$html .= '<br />
					  <table border="1" style="text-align:center;">
						<tr>
							<td width="2%"><strong>#</strong></td>
							<td width="24%"><strong>Standart üzerindeki yer <br />(bölüm,satır no,sayfa no)</strong></td>
							<td width="24%"><strong>Görüş ve Öneriler</strong></td>
							<td width="24%"><strong>Değerlendirme</strong></td>
							<td width="24%"><strong>Düzeltme</strong></td>
						</tr>
					  </table>';
			 
			$gorus_id = $gorus["GORUS_ID"];
		}

		$html .= '<table border="1">
					<tr>
						<td width="2%">'.$gorus["SIRA_NO"].'</td>
						<td width="24%">'.$gorus["YETERLILIK_YERI"].'</td>
						<td width="24%">'.$gorus["GORUS_VE_ONERILER"].'</td>
						<td width="24%">'.$gorus["DEGERLENDIRME"].'</td>
						<td width="24%">'.$gorus["DUZELTME"].'</td>
					</tr>
				 </table>';
	}
	
	echo $html;
}

?>