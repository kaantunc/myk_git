<?php 
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$YetUcret = $this->TesvikAdaylar['YetUcret'];
$BelgeMasraf = $this->TesvikAdaylar['BelgeMasraf'];
$TesvikBilgi = $this->TesvikBilgi;
$_SESSION['IstekId'] = $this->IstekId;

function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}

function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
//         $image_file = K_PATH_IMAGES.'logo_example.jpg';
//         $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//         // Set font
        $this->SetFont('DejaVuSans', 'B', 10);
//         // Title
        	$this->Cell(0, 0, '6645 SAYILI KANUN KAPSAMINDA MYK MESLEKİ YETERLİLİK BELGESİ ALAN ADAYLARA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 0, 'GERİ ÖDENECEK SINAV ÜCRET İADESİ LİSTESİ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-18);
        // Set font
        $this->SetFont('DejaVuSans', 'I', 9, '', true);
        $this->setCellPaddings(1, 1, 1, 1);
        $this->setCellMargins(1, 1, 1, 1);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
//         $this->MultiCell(135, 0, 'LİSTE TARİHİ : '.$_SESSION['tesvik']['TARIH'], 0, 'L', 0, 0, '', '', true, 0, false, true);
//         $this->MultiCell(135, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true);
//         $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 'R', 0, 1, '', '', true, 0, false, true);
//         $this->MultiCell(135, 0, 'LİSTE KODU : 4447/'.$_SESSION['tesvikId'], 0, 'L', 0, 0, '', '', true, 0, false, true);
        // Page number
        $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MYK');
$pdf->SetTitle('Tesvik Istek');
$pdf->SetSubject('Tesvik Istek');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(8, 15, 8);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('DejaVuSans', '', 8, '', true);

// $pdf->setLanguageArray($l);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
// $pdf->Cell(0, 0, 'TEST CELL STRETCH: scaling', 0, 1, 'C', 0, '', 1);

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// İlk Sayfa Logo ve Yazı
// Set some content to print
$logo = <<<EOD
<img src="images/MYKlogo.jpg"/>
EOD;

// $ilkSayfaUst = <<<EOD 
// <h4>BELGELENDİRME KURULUŞLARI İÇİN ÜCRET İADESİ TALEP FORMU</h4>
EOD;
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
// $pdf->writeHTMLCell(55, 30, '', '', $logo, 0, 0, 0, true, 'L', true);
// $pdf->writeHTMLCell(0, 30, '', '', $ilkSayfaUst, 0, 1, 0, true, 'C', true);

$html = '<table width="100%" border="0" style="padding:5px;">
			<tr>
				<td width="25%">Liste Oluştuma Tarihi :</td>
				<td width="75%">'.substr($TesvikBilgi['BIT_TARIH'],0,10).'</td>
			</tr>
			<tr>
				<td>Belgelendirme Kuruluşu :</td>
				<td>'.$TesvikBilgi['KURULUS_ADI'].'</td>
			</tr>
		</table><br>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

if($this->OnayUserMi){
	$html = '
<table width="100%" border="1" style="padding:5px;">
		<thead>
			<tr style="text-align:center">
				<th width="4%"><strong>Sıra No</strong></th>
				<th width="14%"><strong>Adı Soyadı</strong></th>
				<th width="9%"><strong>TC Kimlik No</strong></th>
				<th width="17%"><strong>Belge No</strong></th>
				<th width="26%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>';
	
	$html .= '<th width="7%"><strong>İlk Sınav Tarihi</strong></th>';
	
	$html .= '<th width="7%"><strong>Sınav Ücreti</strong></th>
				<th width="7%"><strong>Belge Masrafı</strong></th>
				<th width="9%"><strong>Toplam</strong></th>
			</tr>
		</thead>
	<tbody>';
	
	$say = 0;
	$toplam = 0;
	foreach($AdayBilgi as $row){
		$say++;
		$html .= '<tr nobr="true">';
		$html .= '<td  width="4%">'.$say.'</td>';
		$html .= '<td  width="14%">'.$row['ADI'].' '.$row['SOYADI'].'</td>';
		$html .= '<td width="9%">'.$row['TC_KIMLIK'].'</td>';
		$html .= '<td width="17%">'.$row['BELGENO'].'</td>';
		$html .= '<td width="26%">'.$row['YETERLILIK_ADI'].' Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
		$html .= '<td width="7%">'.$row['ILK_SINAV_TARIHI'].'</td>';
		
	
		// Ücret Hesabı
		$Odenecek = 0;
		$Hesap = 0;
		if($row['ITIRAZ_DURUM'] == null || $row['ITIRAZ_DURUM'] == -1){
			foreach ($UcretBilgi[$row['BELGENO']] as $cow){
				$Hesap += $cow['ucret'];
			}
		}else{
			$Hesap = UcretDuzenle($row['ITIRAZ_UCRET']);
		}
	
		if($Hesap >= UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET'])){
			$Odenecek = UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET']);
		}else{
			$Odenecek = $Hesap;
		}
		// Ücret Hesabı SON
		$toplam += $Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']]);
		$html .= '<td width="7%">'.Hesapla($Odenecek).' TL</td>';
		$html .= '<td width="7%">'.UcretDuzenle($BelgeMasraf[$row['BELGENO']]).' TL</td>';
		$html .= '<td width="9%">'.Hesapla($Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']])).' TL</td>';
		$html .= '</tr>';
	}
	
	$html .= '<tr>';
	$html .= '<td colspan="8" align="center"><strong>TOPLAM</strong></td>';
	$html .= '<td align="center"><strong>'.Hesapla($toplam).' TL</strong></td>';
	$html .= '</tr>';
	
	$html .='</tbody>
</table>
<br><br>';
}else{
	$html = '
<table width="100%" border="1" style="padding:5px;">
		<thead>
			<tr style="text-align:center">
				<th width="5%"><strong>Sıra No</strong></th>
				<th width="15%"><strong>Adı Soyadı</strong></th>
				<th width="10%"><strong>TC Kimlik No</strong></th>
				<th width="18%"><strong>Belge No</strong></th>
				<th width="26%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>';
	$html .= '<th width="8%"><strong>Sınav Ücreti</strong></th>
				<th width="9%"><strong>Belge Masrafı</strong></th>
				<th width="9%"><strong>Toplam</strong></th>
			</tr>
		</thead>
	<tbody>';
	
	$say = 0;
	$toplam = 0;
	foreach($AdayBilgi as $row){
		$say++;
		$html .= '<tr nobr="true">';
		$html .= '<td  width="5%">'.$say.'</td>';
		$html .= '<td  width="15%">'.$row['ADI'].' '.$row['SOYADI'].'</td>';
		$html .= '<td width="10%">'.$row['TC_KIMLIK'].'</td>';
		$html .= '<td width="18%">'.$row['BELGENO'].'</td>';
		$html .= '<td width="26%">'.$row['YETERLILIK_ADI'].' Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
	
		// Ücret Hesabı
		$Odenecek = 0;
		$Hesap = 0;
		if($row['ITIRAZ_DURUM'] == null || $row['ITIRAZ_DURUM'] == -1){
			foreach ($UcretBilgi[$row['BELGENO']] as $cow){
				$Hesap += $cow['ucret'];
			}
		}else{
			$Hesap = UcretDuzenle($row['ITIRAZ_UCRET']);
		}
	
		if($Hesap >= UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET'])){
			$Odenecek = UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET']);
		}else{
			$Odenecek = $Hesap;
		}
		// Ücret Hesabı SON
		$toplam += $Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']]);
		$html .= '<td width="8%">'.Hesapla($Odenecek).' TL</td>';
		$html .= '<td width="9%">'.UcretDuzenle($BelgeMasraf[$row['BELGENO']]).' TL</td>';
		$html .= '<td width="9%">'.Hesapla($Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']])).' TL</td>';
		$html .= '</tr>';
	}
	
	$html .= '<tr>';
	$html .= '<td colspan="7" align="center"><strong>TOPLAM</strong></td>';
	$html .= '<td align="center"><strong>'.Hesapla($toplam).' TL</strong></td>';
	$html .= '</tr>';
	
	$html .='</tbody>
</table>
<br><br>';
}



// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

$pdf->SetFont('DejaVuSans', '', 11, '', true);
$html="<p>Yukarıda ismi geçen kişilerden belirtilen MYK Mesleki Yeterlilik Belgesi sınav ücretlerin tahsil edildiğini, iş bu ücretlerin doğruluğunu ve kayıt altına alındığını taahhüt ederim.</p><br><br>";
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

// $ImzaTable = '<table nobr="true" width="100%" border="0" style="padding:5px;">
		// <tbody>
		// <tr>
			// <td>Yukarıda ismi geçen kişilerden belirtilen MYK Mesleki Yeterlilik Belgesi sınav ücretlerin tahsil edildiğini, iş bu ücretlerin doğruluğunu ve kayıt altına alındığını taahhüt ederim.</td>
		// </tr>
		// <tr style="text-align:center">
			// <td>../../....</td>
		// </tr>
		// <tr style="text-align:center">
			// <td>İmza</td>
		// </tr>
		// <tr style="text-align:center">
			// <td><strong>'.$this->tesvik['IMZA_UNVAN'].'</strong></td>
		// </tr>
		// <tr style="text-align:center">
			// <td>'.$this->tesvik['IMZA_ISIM'].'</td>
		// </tr>
		// </tbody>
		// </table>';
// $pdf->SetFont('DejaVuSans', '', 12, '', true);
// $pdf->writeHTMLCell(0, 0, '', '', $ImzaTable, 0, 1, 0, true, 'C', true);

$pdf->SetFont('DejaVuSans', '', 12, '', true);
$pdf->Cell(440, 0, '../../....', 0, 1, 'C', 0, '', 0, false);
$pdf->SetTextColor(192,192,192);
$pdf->Cell(440, 0, 'İmza', 0, 1, 'C', 0, '', 0, false);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(440, 0, $this->tesvik['IMZA_UNVAN'], 0, 1, 'C', 0, '', 0, false);
$pdf->Cell(440, 0, $this->tesvik['IMZA_ISIM'], 0, 1, 'C', 0, '', 0, false);

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($this->IstekId.'#Ücret İadesi Talebi.pdf');
exit();