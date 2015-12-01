<?php 
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$YetUcret = $this->TesvikAdaylar['YetUcret'];

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
//         $image_file = K_PATH_IMAGES.'logo_example.jpg';
//         $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//         // Set font
        $this->SetFont('DejaVuSans', 'B', 10);
//         // Title
        $this->Cell(0, 0, '4447 İŞSİZLİK SİGORTASI KANUNUN EK 3 ÜNCÜ MADDESİ KAPSAMINDA TEHLİKELİ VE ÇOK TEHLİKELİ İŞLER SINIFINDA YER ALAN MESLEKLERDE MESLEKİ YETERLİLİK KURUMU KANUNU', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'KAPSAMINDA MESLEKİ YETERLİLİK BELGESİ ALMAYA HAK KAZANAN KİŞİLERİN SINAV VE BELGE ÜCRETLERİ (TL)', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('DejaVuSans', 'I', 10, '', true);
        $this->setCellPaddings(1, 1, 1, 1);
        
        // set cell margins
        $this->setCellMargins(1, 1, 1, 1);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
        $this->MultiCell(135, 0, '[VERTICAL ALIGNMENT - TOP] ', 1, 'J', 0, 0, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, '[VERTICAL ALIGNMENT - MIDDLE] ', 1, 'J', 0, 0, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, '[VERTICAL ALIGNMENT - BOTTOM] ', 1, 'J', 0, 0, '', '', true, 0, false, true);
        
        $this->SetY(-10);
        // Page number
        $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MYK');
$pdf->SetTitle('Denetim Rapor');
$pdf->SetSubject('Denetim Rapor');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0, PDF_MARGIN_TOP, 5);
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
$pdf->SetFont('DejaVuSans', '', 7, '', true);

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

$ilkSayfaUst = <<<EOD
<h4>BELGELENDİRME KURULUŞLARI İÇİN DENETİM FORMU</h4>
EOD;

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
// $pdf->writeHTMLCell(55, 30, '', '', $logo, 0, 0, 0, true, 'L', true);
// $pdf->writeHTMLCell(0, 30, '', '', $ilkSayfaUst, 0, 1, 0, true, 'C', true);


$html = '
<table width="100%" border="1" style="padding:3px;">
		<thead>
			<tr style="text-align:center">
				<th width="3%"><strong>A</strong></th>
				<th width="6%"><strong>B</strong></th>
				<th width="6%"><strong>C</strong></th>
				<th width="16%"><strong>D</strong></th>
				<th width="18%"><strong>E</strong></th>
				<th width="6%"><strong>F</strong></th>
				<th width="6%"><strong>G</strong></th>
				<th width="5%"><strong>I</strong></th>
				<th width="5%"><strong>J</strong></th>
				<th width="5%"><strong>K</strong></th>
				<th width="5%"><strong>L</strong></th>
				<th width="13%"><strong>M</strong></th>
				<th width="6%"><strong>N</strong></th>
			</tr>
			<tr style="text-align:center">
				<th width="3%"><strong>Sıra No</strong></th>
				<th width="6%"><strong>Adı Soyadı</strong></th>
				<th width="6%"><strong>TC Kimlik No</strong></th>
				<th width="16%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>
				<th width="18%"><strong>Belgelendirme Kuruluşu</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Kararı No:</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Tavan Ücret</strong></th>
				<th width="5%"><strong>Aday Sınav Ücreti</strong></th>
				<th width="5%"><strong>Fondan Karşılanan Brüt Ücret</strong></th>
				<th width="5%"><strong>Fondan Karşılanan Net Ücret</strong></th>
				<th width="5%"><strong>MYK Belge Ücreti</strong></th>
				<th width="13%"><strong>IBAN</strong></th>
				<th width="6%"><strong>GSM</strong></th>
			</tr>
		</thead>
	<tbody>';

$say = 0;
$TopSinav = 0;
$FonBürüt = 0;
$FonNet = 0;
$belgeUcret = 0;
foreach($AdayBilgi as $row){

$uc = 0;
foreach($UcretBilgi[$row['BELGENO']] as $cow){
	$uc += $cow['ucret'];
}

if($uc>0){
$say++;
$html .= '<tr nobr="true">';
$html .= '<td width="3%" align="center">'.$say.'</td>';
$html .= '<td width="6%">'.$row['ADI'].' '.$row['SOYADI'].'</td>';
$html .= '<td width="6%" align="center">'.$row['TC_KIMLIK'].'</td>';
$html .= '<td width="16%">'.$row['YETERLILIK_ADI'].' Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
// $html .= '<td width="16%">NC/CNC TAKIM TEZGAHLARI ELEKTRİK/ELEKTRONİK SERVİS GÖREVLİSİ Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
$html .= '<td width="18%">'.$row['KURULUS_ADI'].'</td>';
// $html .= '<td width="18%">Türkiye İnşaat Sanayicileri İşveren Sendikası Mesleki Yeterlilik ve Belgelendirme Merkezi İktisadi İşletmesi</td>';
$html .= '<td width="6%" align="center">'.$say.'</td>';
$html .= '<td width="6%" align="center">'.number_format($YetUcret[$row['BELGENO']],2,',','.').'</td>';
// $uc = 0;
// foreach($UcretBilgi[$row['BELGENO']] as $cow){
// 	$uc += $cow['ucret'];
// }
$TopSinav += $uc;

$html .= '<td width="5%" align="center">'.number_format($uc,2,',','.').'</td>';
if($YetUcret[$row['BELGENO']] > $uc){
	$html .= '<td width="5%" align="center">'.number_format($uc,2,',','.').'</td>';
	$alinacak = $uc;
}else{
	$html .= '<td width="5%" align="center">'.number_format($YetUcret[$row['BELGENO']],2,',','.').'</td>';
	$alinacak = $YetUcret[$row['BELGENO']];
}

$FonBürüt += $alinacak;
$FonNet += round(($alinacak-($alinacak*(0.00759))),2);
$html .= '<td width="5%" align="center">'.number_format(round(($alinacak-($alinacak*(0.00759))),2),2,',','.').'</td>';
$html .= '<td width="5%" align="center">'.number_format(50,2,',','.').'</td>';
// $html .= '<td width="12%">'.$row['IBAN'].'</td>';
$html .= '<td width="13%" align="center">TR888888888889999999999999999999</td>';
// $html .= '<td width="7%">'.$row['TELEFON'].'</td>';
$html .= '<td width="6%" align="center">+905438888888</td>';
$html .= '</tr>';
$belgeUcret += 50;
}
}

$html .= '<tr>';
$html .= '<td align="center"><strong>'.$say.'</strong></td>';
$html .= '<td colspan="6" align="center"><strong>TOPLAM</strong></td>';
$html .= '<td align="center"><strong>'.number_format($TopSinav,2,',','.').'-TL</strong></td>';
$html .= '<td align="center"><strong>'.number_format($FonBürüt,2,',','.').'-TL</strong></td>';
$html .= '<td align="center"><strong>'.number_format($FonNet,2,',','.').'-TL</strong></td>';
$html .= '<td align="center"><strong>'.number_format($belgeUcret,2,',','.').'-TL</strong></td>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';

$html .='</tbody>
</table>
';

// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($this->tesvikId.'#Tesvik İstek Raporu.pdf');
exit();