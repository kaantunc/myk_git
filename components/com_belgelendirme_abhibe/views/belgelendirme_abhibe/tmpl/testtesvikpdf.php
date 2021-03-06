<?php
require_once('libraries/tcpdf-new/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
//         $image_file = K_PATH_IMAGES.'logo_example.jpg';
//         $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//         // Set font
        $this->SetFont('DejaVuSans', 'B', 9);
//         // Title
        $this->Cell(0, 0, 'BELGELENDİRME İÇİN DOĞRUDAN HİBE PROGRAMI KAPSAMINDA SINAV ÜCRETİ KARŞILANACAK', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 0, ' KİŞİ TALEP BİLDİRİM LİSTESİ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

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
$pdf->SetTitle('AB Hibe Istek');
$pdf->SetSubject('AB Hibe Istek');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(2, 15, 2);
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
// $pdf->SetFont('DejaVuSans', '', 8, '', true);

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
$pdf->setCellMargins(5, 3, 5, 3);
$pdf->SetFont('DejaVuSans', '', 9, '', true);
$html = '<table width="100%" border="0" style="padding:5px;">
			<tr>
				<td width="22%"><b>Belgelendirme Kuruluşu :</b></td>
				<td width="78%">ABC Belgelendirme</td>
			</tr>
			<tr>
				<td width="50%"><b>Liste Oluşturma Tarihi :</b> xx/xx/xxxx</td>
				<td width="50%"><b>Talep ID :</b> YB0016/1</td>
			</tr>
            <tr>
				<td width="50%"><b>Tavan Sınav Ücreti</b> (Max 300€) <b>:</b> MYK onayı ile belirlenecektir</td>
				<td width="50%"><b>Euro Kuru </b>('.$doviz['tarih'].') <b>:</b> MYK onayı ile belirlenecektir</td>
			</tr>
		</table><br>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

$pdf->setCellMargins(1, 1, 1, 1);
$pdf->SetFont('DejaVuSans', '', 7, '', true);
$html = '
<table width="100%" border="1" style="padding:5px;">
		<thead>';
$html .= '<tr style="text-align:center">
				<th width="2%"><strong>A</strong></th>
				<th width="9%"><strong>B</strong></th>
				<th width="7%"><strong>C</strong></th>
				<th width="10%"><strong>D</strong></th>
				<th width="13%"><strong>E</strong></th>
				<th width="14%"><strong>F</strong></th>
				<th width="6%"><strong>G</strong></th>
				<th width="8%"><strong>H</strong></th>
				<th width="8%"><strong>I</strong></th>
				<th width="8%"><strong>İ</strong></th>
				<th width="8%"><strong>J</strong></th>
				<th width="8%"><strong>K</strong></th>
			</tr>';

$html .= '<tr style="text-align:center">
				<th width="2%"><strong>#</strong></th>
				<th width="9%"><strong>Adı Soyadı</strong></th>
				<th width="7%"><strong>TC Kimlik No</strong></th>
				<th width="10%"><strong>IBAN</strong></th>
				<th width="13%"><strong>Belge No</strong></th>
				<th width="14%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>';

$html .= '<th width="6%"><strong>İlk Sınav Tarihi</strong></th>';

$html .= '<th width="8%"><strong>Tahakkuk Eden Sınav Ücreti (KDV Dahil)</strong></th>';
$html .= '<th width="8%"><strong>MYK’dan Talep Edilen Ücret İadesi (KDV Hariç)</strong></th>';
$html .= '<th width="8%"><strong>Dezavantaj Durumu</strong></th>';
$html .= '<th width="8%"><strong>Kişiye İade Edilecek Onaya Tabi Tutar (KDV Dahil)</strong></th>';
$html .= '<th width="8%"><strong>MYK ‘ya Fatura Edilecek Tutarlar (KDV Hariç)</strong></th>';
$html .= '</tr>';
$html .= '</thead>
	<tbody>';

$html .= '<tr nobr="true">';
$html .= '<td width="2%"></td>';
$html .= '<td width="9%"></td>';
$html .= '<td width="7%"></td>';
$html .= '<td width="10%"></td>';
$html .= '<td width="13%"></td>';
$html .= '<td width="14%"></td>';
$html .= '<td width="6%"></td>';

$html .= '<td width="8%">A</td>';
$html .= '<td width="8%">A/18</td>';

$html .= '<td width="8%">Hayır</td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '</tr>';
$html .= '<tr nobr="true">';
$html .= '<td width="2%"></td>';
$html .= '<td width="9%"></td>';
$html .= '<td width="7%"></td>';
$html .= '<td width="10%"></td>';
$html .= '<td width="13%"></td>';
$html .= '<td width="14%"></td>';
$html .= '<td width="6%"></td>';

$html .= '<td width="8%">B</td>';
$html .= '<td width="8%">B/18</td>';

$html .= '<td width="8%">Hayır</td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td colspan="7" align="center"><strong>TOPLAM:</strong></td>';
$html .= '<td align="center"><strong></strong></td>';
$html .= '<td align="center"><strong></strong></td>';
$html .= '<td align="center"></td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '<td width="8%">MYK onayı ile belirlenecektir</td>';
$html .= '</tr>';

$html .='</tbody>
</table>
<br><br>';
// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

$pdf->setCellMargins(5, 3, 5, 3);
$pdf->SetFont('DejaVuSans', '', 9, '', true);
$html = 'İş bu liste ile;';
$html .= '<ul>';
$html .= '<li>Yukarıda ismi geçen MYK Mesleki Yeterlilik Belgesi almaya hak kazanmış kişilerden imzalı olarak “Adaylar İçin Doğrudan Hibe Başvuru Formu”nun ve dezavantajlı kişilerden de sözleşmede belirtilen belgelerin teslim alındığını,</li>';
$html .= '<li>Sınav ücretlerinin yukarıdaki listede “H” sütununda beyan edilen tutarlar üzerinden tahakkuk ettirildiğini,</li>';
$html .= '<li>MYK tarafından onaylanarak “J” sütununda bildirilecek “KDV Dâhil” tutarların adayların bildirmiş olduğu IBAN hesaplarına iade edileceğini,</li>';
$html .= '<li>İadelerin ilgili hesaplara yapıldığına dair dekontların MYK Web Portal’a yüklenerek, “K” sütununda MYK tarafından bildirilecek toplam tutar kadar KDV hariç fatura düzenleneceğini,</li>';
$html .= '<li>Bu liste 2 nüsha halinde "Onaylı Kişiler Listesi"ne göre kesilecek fatura ile beraber MYK‘ya iletileceğini</li>';
$html .= '</ul>';
$html .= 'beyan ve taahhüt ederim.<br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'J', true);

$pdf->SetFont('DejaVuSans', '', 9, '', true);
$html = '<table width="100%" style="padding:10px;" nobr="true">
		<tr>
			<td><div style="width:50%;">Ad Soyad</div>: </td>
		</tr>
		<tr>
			<td><div style="width:50%;">Unvan</div>: </td>
		</tr>
		<tr>
			<td><div style="width:50%;">Tarih</div>: .. / .. / ....</td>
		</tr>
		<tr>
			<td><div style="width:50%;">İmza</div>:</td>
		</tr>
		</table>';
$pdf->writeHTMLCell(0, 0, 50, '', $html, 0, 1, 0, true, 'C', true);

// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(440, 0, $this->tesvik['IMZA_UNVAN'], 0, 1, 'C', 0, '', 0, false);
// $pdf->Cell(440, 0, $this->tesvik['IMZA_ISIM'], 0, 1, 'C', 0, '', 0, false);
// $pdf->Cell(440, 0, '../../....', 0, 1, 'C', 0, '', 0, false);
// $pdf->SetTextColor(192,192,192);
// $pdf->Cell(440, 0, 'İmza', 0, 1, 'C', 0, '', 0, false);


// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($this->IstekId.'#ab_hibe_talep_kur.pdf');
exit();