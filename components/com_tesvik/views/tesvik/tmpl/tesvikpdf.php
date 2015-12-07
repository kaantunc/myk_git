<?php
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];

$tesvik = $this->tesvik;
if ($tesvik['LISTE_KODU'] == "") {
    $_SESSION['liste_kodu'] = " - ";
} else {
    $_SESSION['liste_kodu'] = str_pad($tesvik['LISTE_KODU'], 3, "0", STR_PAD_LEFT);
}
$_SESSION['tesvik'] = $this->tesvik;
if (strlen($this->tesvikId) == 1) {
    $_SESSION['tesvikId'] = '00' . $this->tesvikId;
} else if (strlen($this->tesvikId) == 2) {
    $_SESSION['tesvikId'] = '0' . $this->tesvikId;
} else {
    $_SESSION['tesvikId'] = $this->tesvikId;
}

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
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
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-18);
        // Set font
        $this->SetFont('DejaVuSans', 'I', 9, '', true);
        $this->setCellPaddings(1, 1, 1, 1);
        $this->setCellMargins(1, 1, 1, 1);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
        $this->MultiCell(135, 0, 'LİSTE TARİHİ : ' . $_SESSION['tesvik']['TARIH'], 0, 'L', 0, 0, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, 'Sayfa ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 'R', 0, 1, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, 'LİSTE KODU : 4447/' . $_SESSION['liste_kodu'], 0, 'L', 0, 0, '', '', true, 0, false, true);
        // Page number
//         $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

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
$pdf->SetMargins(1, PDF_MARGIN_TOP, 1);
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
				<th width="7%"><strong>B</strong></th>
				<th width="6%"><strong>C</strong></th>
				<th width="16%"><strong>D</strong></th>
				<th width="18%"><strong>E</strong></th>
				<th width="6%"><strong>F</strong></th>
				<th width="6%"><strong>G</strong></th>
				<th width="6%"><strong>I</strong></th>
				<th width="6%"><strong>J</strong></th>
				<th width="6%"><strong>K</strong></th>
				<th width="13%"><strong>L</strong></th>
				<th width="7%"><strong>M</strong></th>
			</tr>
			<tr style="text-align:center">
				<th width="3%"><strong>Sıra No</strong></th>
				<th width="7%"><strong>Adı Soyadı</strong></th>
				<th width="6%"><strong>TC Kimlik No</strong></th>
				<th width="16%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>
				<th width="18%"><strong>Belgelendirme Kuruluşu</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Kararı No:</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Tavan Ücret</strong></th>
				<th width="6%"><strong>Kuruluş Sınav Ücreti</strong></th>
				<th width="6%"><strong>Fondan Karşılanan Ücret</strong></th>
				<th width="6%"><strong>MYK Belge Ücreti</strong></th>
				<th width="13%"><strong>IBAN</strong></th>
				<th width="7%"><strong>GSM</strong></th>
			</tr>
		</thead>
	<tbody>';

$say = 0;
$TopSinav = 0;
$FonBürüt = 0;
$FonNet = 0;
$TopBelgeMasraf = 0;
$temmuzOncesi = 0;
$temSay = 0;
foreach ($AdayBilgi as $row) {
    $say++;
    $html .= '<tr nobr="true">';
    $html .= '<td width="3%" align="center">' . $say . '</td>';
    $html .= '<td width="7%">' . $row['ADI'] . ' ' . $row['SOYADI'] . '</td>';
    $html .= '<td width="6%" align="center">' . $row['TC_KIMLIK'] . '</td>';
    $html .= '<td width="16%">' . $row['YETERLILIK_ADI'] . ' Seviye ' . $row['YETERLILIK_SEVIYESI'] . '</td>';
// $html .= '<td width="16%">NC/CNC TAKIM TEZGAHLARI ELEKTRİK/ELEKTRONİK SERVİS GÖREVLİSİ Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
    $html .= '<td width="18%">' . $row['KURULUS_ADI'] . '</td>';
// $html .= '<td width="18%">Türkiye İnşaat Sanayicileri İşveren Sendikası Mesleki Yeterlilik ve Belgelendirme Merkezi İktisadi İşletmesi</td>';
    $html .= '<td width="6%" align="center">' . $row['BK_KARAR_SAYI'] . '</td>';
    $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['BK_UCRET']), 2, ',', '.') . '</td>';

    $uc = UcretDuzenle($row['SINAV_UCRET']);
    $TopSinav += $uc;

    $html .= '<td width="6%" align="center">' . number_format($uc, 2, ',', '.') . '</td>';
    $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['DAMGALI_UCRET']), 2, ',', '.') . '</td>';

    $FonBürüt += UcretDuzenle($row['DAMGALI_UCRET']);
    $FonNet += UcretDuzenle($row['DAMGASIZ_UCRET']);

    if ($row['BELGE_MASRAF'] == 1) {
        $html .= '<td width="6%" align="center">0,00</td>';
        $temmuzOncesi += UcretDuzenle($row['BELGE_UCRET']);
        $temSay++;
    } else {
        $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['BELGE_UCRET']), 2, ',', '.') . '</td>';
        $TopBelgeMasraf += UcretDuzenle($row['BELGE_UCRET']);
    }

    $html .= '<td width="13%">' . trim(str_replace(' ', '', $row['IBAN'])) . '</td>';
// $html .= '<td width="13%" align="center">TR888888888889999999999999999999</td>';
    $html .= '<td width="7%">' . str_replace(' ', '', $row['TELEFON']) . '</td>';
// $html .= '<td width="6%" align="center">+905438888888</td>';
    $html .= '</tr>';

}

$html .= '<tr>';
$html .= '<td align="center"><strong>' . $say . '</strong></td>';
$html .= '<td colspan="6" align="center"><strong>TOPLAM</strong></td>';
$html .= '<td align="center"><strong>' . number_format($TopSinav, 2, ',', '.') . '-TL</strong></td>';
$html .= '<td align="center"><strong>' . number_format($FonBürüt, 2, ',', '.') . '-TL</strong></td>';
// $html .= '<td align="center"><strong>'.number_format($FonNet,2,',','.').'-TL</strong></td>';
$html .= '<td align="center"><strong>' . number_format($TopBelgeMasraf, 2, ',', '.') . '-TL</strong></td>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';

$html .= '</tbody>
</table>
';

// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

$pdf->SetFont('DejaVuSans', '', 12, '', true);
$temmuzYazi = '1-' . $temSay . ' sıra no arasındaki adayların MYK belge ücretleri kendileri tarafından yatırıldığından, toplam MYK belge ücreti olan <strong>' . number_format($temmuzOncesi, 2, ',', '.') . ' TL</strong> geri ödenmek üzere adayların hesaplarına yatırılacak ve bu adaylar için 50.00 TL ilave ücret iadesi yapılacaktır.';
$pdf->writeHTMLCell(0, 0, '', '', $temmuzYazi, 0, 1, 0, true, 'L', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$filepath = "tesvikpdf/" . $_GET['tesvikId'] . "_4447_Ek_3_Yaranlanici_Listesi.pdf";
if ($tesvik["DURUM"] > 0) {
    $pdf->Output(EK_FOLDER . $filepath, "F");
    header("location: index.php?dl=" . $filepath);
} else {
    $pdf->Output("4447_Ek_3_Yaranlanici_Listesi.pdf");
}

exit();


function UcretDuzenle($ucret)
{
    return str_replace(',', '.', $ucret);
}

function DamgasizHesapla($alinacak)
{
    $dat = $alinacak - ($alinacak * (0.00759));
    $dat = floor($dat * 100) / 100;
    return number_format($dat, '2', ',', '.');
}