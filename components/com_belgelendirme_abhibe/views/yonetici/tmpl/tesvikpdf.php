<?php
require_once('libraries/tcpdf-new/tcpdf.php'); 
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$kurBilgi = $this->kurBilgi;
$tesvik = $this->tesvik;
$_SESSION['IstekId'] = $this->IstekId;
$KurPro = $this->ABKurPro;
$doviz = $this->doviz;
if($tesvik['DURUM'] == 0){
	$dovizKuru = UcretDuzenle($doviz['alis']);
}else{
	$dovizKuru = UcretDuzenle($tesvik['DOVIZ_KURU']);
}
$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*$dovizKuru;
$KurKdv = UcretDuzenle(1+($KurPro['KDV']/100));

function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
function UcretFloor($dat){
	return floor($dat*100)/100;
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
        $this->SetFont('DejaVuSans', 'B', 11);
//         // Title
        	$this->Cell(0, 0, 'BELGELENDİRME İÇİN DOĞRUDAN HİBE PROGRAMI KAPSAMINDA SINAV ÜCRETİ KARŞILANACAK', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 0, ' KİŞİ BİLDİRİM LİSTESİ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
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
$pdf->SetMargins(1, 15, 3);
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
// $pdf->SetFont('DejaVuSans', '', 7, '', true);

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
$pdf->SetFont('DejaVuSans', '', 11, '', true);
$html = '<table width="100%" border="0" style="padding:5px;">
			<tr>
				<td width="22%"><b>Belgelendirme Kuruluşu :</b></td>
				<td width="78%">'.$kurBilgi['KURULUS_ADI'].'</td>
			</tr>
			<tr>
				<td width="50%"><b>Liste Oluşturma Tarihi :</b> '.$tesvik['BIT_TARIH'].'</td>
				<td width="50%"><b>Talep ID :</b> '.$tesvik['ID'].'</td>
			</tr>
			<tr>
				<td width="50%"><b>Tavan Sınav Ücreti</b> (Max 300€) <b>:</b> '.Hesapla($maxUcret).' TL</td>
				<td width="50%"><b>Euro Kuru </b>('.$doviz['tarih'].') <b>:</b> '.$dovizKuru.' TL</td>
			</tr>
		</table><br>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);

$pdf->setCellMargins(1, 1, 1, 1);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
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
	
	$say = 0;
	$tt = 0;
	$ttSiz = 0;
	$pp = 0;
	$ppSiz = 0;
	$toplam = 0;
	foreach($AdayBilgi as $row){
		$say++;
		$html .= '<tr nobr="true">';
		$html .= '<td  width="2%">'.$say.'</td>';
		$html .= '<td  width="9%">'.$row['ADI'].' '.$row['SOYADI'].'</td>';
		$html .= '<td width="7%">'.$row['TC_KIMLIK'].'</td>';
		$html .= '<td width="10%">'.$row['BASIBAN'].'</td>';
		$html .= '<td width="13%">'.$row['BELGENO'].'</td>';
		$html .= '<td width="14%">'.$row['YETERLILIK_ADI'].'<br>Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
		$html .= '<td width="6%">'.$row['ILK_SINAV_TARIHI'].'</td>';
		
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
		
		$anaPara = UcretDuzenle($Hesap/$KurKdv);
		$ParaKdv = $Hesap-$anaPara;
		
		if($anaPara > UcretDuzenle($maxUcret)){
			$kdvli = UcretDuzenle($maxUcret)+$ParaKdv;
			$kdvsiz = UcretDuzenle($maxUcret);
		}else{
			$kdvli = $Hesap;				
			$kdvsiz = $anaPara;
		}
		// Ücret Hesabı SON
		
		$tt += $Hesap;
		$ttSiz += $anaPara;
		$pp += $kdvli;
		$ppSiz += $kdvsiz;
		
		$toplam += UcretDuzenle($kdvli);
		$html .= '<td width="8%" style="text-align:center">'.Hesapla($Hesap).' TL</td>';
		$html .= '<td width="8%" style="text-align:center">'.Hesapla($anaPara).' TL</td>';
		if($row['DEZAV'] != null){
			$html .= '<td width="8%" style="text-align:center">Dezavantajlı</td>';
		}else{
			$html .= '<td width="8%" style="text-align:center"></td>';
		}
		$html .= '<td width="8%" style="text-align:center">'.Hesapla($kdvli).' TL</td>';
		$html .= '<td width="8%" style="text-align:center">'.Hesapla($kdvsiz).' TL</td>';
		$html .= '</tr>';
	}
	
	$html .= '<tr>';
	$html .= '<td colspan="7" align="center"><strong>TOPLAM</strong></td>';
	$html .= '<td align="center"><strong>'.Hesapla($tt).' TL</strong></td>';
	$html .= '<td align="center"><strong>'.Hesapla($ttSiz).' TL</strong></td>';
	$html .= '<td align="center"></td>';
	$html .= '<td align="center"><strong>'.Hesapla($pp).' TL</strong></td>';
	$html .= '<td align="center"><strong>'.Hesapla($ppSiz).' TL</strong></td>';
	$html .= '</tr>';
	
	$html .='</tbody>
</table>
<br><br>';
// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'L', true);
$pdf->setCellMargins(5, 3, 5, 3);
$pdf->SetFont('DejaVuSans', '', 11, '', true);
$html = '<div width="100%" nobr="true">Kuruluşun yukarıdaki listede beyan ettiği tutarlar için sözleşme doğrultusunda ilgili hesaplara 
		“J” sütununda yazan onaylanmış tutarları iade yapması <strong style="text-decoration: underline;">uygundur.</strong> 
		Doğrudan hibe fon aktarımı için Kuruluşun ilgili tutarların ilgili hesaplara 
		iade edildiğini gösterir dekontları MYK Web Portal’a yüklemesi ve “K” sütununda yer alan toplam tutar kadar 
		KDV’den muaf faturayı sözleşme kurallarına uygun şekilde MYK adına düzenlemesi 
		<strong style="text-decoration: underline;">gerekmektedir.</strong></div>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'J', true);

$pdf->SetFont('DejaVuSans', '', 11, '', true);
$html = '<table width="100%" style="padding:10px;" nobr="true">
		<tr>
			<td>Ad Soyad:</td>
			<td></td>
		</tr>
		<tr>
			<td>Unvan:</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>.. / .. / ....</td>
		</tr>
		<tr>
			<td></td>
			<td><div style="color:#CDCDCD;width:100%">İmza</div></td>
		</tr>
		</table>';
$pdf->writeHTMLCell(0, 0, 200, '', $html, 0, 1, 0, true, 'J', true);
// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(440, 0, 'Ad Soyad:', 0, 1, 'C', 0, '', 0, false);
// $pdf->Cell(440, 0, 'Unvan:', 0, 1, 'C', 0, '', 0, false);
// $pdf->Cell(500, 0, '.. / .. / ....', 0, 1, 'C', 0, '', 0, false);
// $pdf->SetTextColor(192,192,192);
// $pdf->Cell(500, 0, 'İmza', 0, 1, 'C', 0, '', 0, false);
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($this->IstekId.'#ab_hibe_talep_uzman.pdf');
exit();