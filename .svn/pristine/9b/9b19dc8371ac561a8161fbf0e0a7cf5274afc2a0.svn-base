<?php
$txtDatas = $this->txtDatas;
$tesvik   = $this->tesvik;
if($tesvik['LISTE_KODU'] == ""){
	$_SESSION['liste_kodu'] = " - ";
}else{
	$_SESSION['liste_kodu'] = str_pad($tesvik['LISTE_KODU'],3, "0", STR_PAD_LEFT);
}
$_SESSION['tesvik'] = $this->tesvik;
if(strlen($this->tesvikId) == 1){
	$_SESSION['tesvikId'] = '00'.$this->tesvikId;
}else if(strlen($this->tesvikId) == 2){
	$_SESSION['tesvikId'] = '0'.$this->tesvikId;
}else{
	$_SESSION['tesvikId'] = $this->tesvikId;
}

if($txtDatas['status'] == "aftertransfer"){
	$_SESSION['tesvik']['TARIH'] = $txtDatas['odeme_tarihi'];
}

if($txtDatas['status'] == "aftertransfer"){
	$_SESSION['pdf_title'] = "BANKADAN İLETİLEN AKİBET DOSYASI İÇERİĞİ";
}else if($txtDatas['status'] == "beforetransfer"){
	$_SESSION['pdf_title'] = '4447 SAYILI KANUNUN EK 3 ÜNCÜ MADDESİ KAPSAMINDA <br>ÖDEME YAPILACAK YARARLANICILARIN LİSTESİ';
}else if($txtDatas['status'] == "temptransfer"){
	$_SESSION['pdf_title'] = '4447 SAYILI KANUNUN EK 3 ÜNCÜ MADDESİ KAPSAMINDA <br>ÖDEME YAPILACAK YARARLANICILARIN LİSTESİ';
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
        // $this->Cell(0, 0, $_SESSION['pdf_title'], 0, 1, 'C', 0, '', 0, false, 'T', 'M');
		$this->writeHTMLCell(0, 0, 10, '', $_SESSION['pdf_title'], 0, 1, 0, true, 'C', true);
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
        $this->MultiCell(135, 0, 'LİSTE TARİHİ : '.$_SESSION['tesvik']['TARIH'], 0, 'L', 0, 0, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true);
//         $this->MultiCell(135, 0, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 'R', 0, 1, '', '', true, 0, false, true);
        $this->MultiCell(135, 0, 'LİSTE KODU : 4447/'.$_SESSION['liste_kodu'] , 0, 'L', 0, 0, '', '', true, 0, false, true);
        // Page number
        $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }
}

// create new PDF document
$pdf = new MYPDF('H', PDF_UNIT, 'A4', true, 'UTF-8', false);

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

// $ilkSayfaUst = <<<EOD
// <h4>BELGELENDİRME KURULUŞLARI İÇİN DENETİM FORMU</h4>
// EOD;

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
// $pdf->writeHTMLCell(55, 30, '', '', $logo, 0, 0, 0, true, 'L', true);
// $pdf->writeHTMLCell(0, 30, '', '', $ilkSayfaUst, 0, 1, 0, true, 'C', true);

if($txtDatas['status'] == 'aftertransfer'){
	$html = '<center>
	<table width="98%" border="1" style="padding:3px;">
			<thead>
				<tr style="text-align:center">
					<th width="5%"><strong>A</strong></th>
					<th width="10%"><strong>B</strong></th>
					<th width="17%"><strong>C</strong></th>
					<th width="23%"><strong>D</strong></th>
					<th width="10%"><strong>E</strong></th>
					<th width="13%"><strong>F</strong></th>
					<th width="7%"><strong>G</strong></th>
					<th width="15%"><strong>H</strong></th>
				</tr>
				<tr style="text-align:center">
					<th width="5%"><strong>Sıra No</strong></th>
					<th width="10%"><strong>TC Kimlik No</strong></th>
					<th width="17%"><strong>Adı Soyadı</strong></th>
					<th width="23%"><strong>IBAN</strong></th>
					<th width="10%"><strong>Ödeme Tarihi</strong></th>
					<th width="13%"><strong>Ödenen Tutar</strong></th>
					<th width="7%"><strong>Ödeme Durumu</strong></th>
					<th width="15%"><strong>Ödeme Açıklama</strong></th>
				</tr>
			</thead>
		<tbody>';
}else{
	$html = '<center>
	<table width="98%" border="1" style="padding:3px;">
			<thead>
				<tr style="text-align:center">
					<th width="10%"><strong>A</strong></th>
					<th width="20%"><strong>B</strong></th>
					<th width="20%"><strong>C</strong></th>
					<th width="25%"><strong>D</strong></th>
					<th width="10%"><strong>E</strong></th>
					<th width="15%"><strong>F</strong></th>
				</tr>
				<tr style="text-align:center">
					<th width="10%"><strong>Sıra No</strong></th>
					<th width="20%"><strong>TC Kimlik No</strong></th>
					<th width="20%"><strong>Adı Soyadı</strong></th>
					<th width="25%"><strong>IBAN</strong></th>
					<th width="10%"><strong>Ödeme Tarihi</strong></th>
					<th width="15%"><strong>Ödenen Tutar</strong></th>
				</tr>
			</thead>
		<tbody>';
}



$say = 0;


$orderby = "ODEME_DURUMU";
$sortArray = array();
foreach($txtDatas['content'] as $data){
	foreach($data as $key=>$value){
		if(!isset($sortArray[$key])){
			$sortArray[$key] = array();
		}
		$sortArray[$key][] = $value;
	}
}
array_multisort($sortArray[$orderby],SORT_ASC,$txtDatas['content']);
//dd($txtDatas['content']);exit;
foreach($txtDatas['content'] as $row){

$say++;
if($txtDatas['status'] == 'aftertransfer'){
	$html .= '<tr nobr="true">';
	$html .= '<td width="5%" align="center">'.$say.'</td>';
	$html .= '<td width="10%" align="center">'.$row['TCKN'].'</td>';
	$html .= '<td width="17%">'.$row['ADSOYAD'].'</td>';
	$html .= '<td width="23%">'.$row['IBAN'].'</td>';
	$html .= '<td width="10%">'.$row['BANKA_ODEME_TARIHI'].'</td>';
	$html .= '<td width="13%">'.$row['ODENEN_TUTAR'].'</td>';
	$html .= '<td width="7%">'.$row['ODEME_DURUMU'].'</td>';
	$html .= '<td width="15%">'.$row['ODEME_ACIKLAMA'].'</td>';
	$html .= '</tr>';
}else{
	$html .= '<tr nobr="true">';
	$html .= '<td width="10%" align="center">'.$say.'</td>';
	$html .= '<td width="20%" align="center">'.$row['TCKN'].'</td>';
	$html .= '<td width="20%">'.$row['ADSOYAD'].'</td>';
	$html .= '<td width="25%">'.$row['IBAN'].'</td>';
	$html .= '<td width="10%">'.$row['BANKA_ODEME_TARIHI'].'</td>';
	$html .= '<td width="15%">'.$row['ODENEN_TUTAR'].'</td>';
	$html .= '</tr>';
}
	

}

if($txtDatas['status'] == 'aftertransfer'){
	$html .= '<tr>';
	$html .= '<td align="center"><strong>'.$say.'</strong></td>';
	$html .= '<td colspan="4" align="center"><strong>ÖDENEN TOPLAM TUTAR</strong></td>';
	$html .= '<td align="left"><strong>'.number_format(($txtDatas['odenen_toplam_tutar'] ), 2, ',', '.').'-TL</strong></td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td align="center"><strong>'.$say.'</strong></td>';
	$html .= '<td colspan="4" align="center"><strong>ÖDENEMEYEN TOPLAM TUTAR</strong></td>';
	$html .= '<td align="left"><strong>'.number_format($txtDatas['odenemeyen_toplam_tutar'], 2, ',', '.').'-TL</strong></td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td align="center"><strong>'.$say.'</strong></td>';
	$html .= '<td colspan="4" align="center"><strong>GENEL TOPLAM TUTAR</strong></td>';
	$html .= '<td align="left"><strong>'.number_format($txtDatas['odenen_toplam_tutar']+$txtDatas['odenemeyen_toplam_tutar'], 2, ',', '.').'-TL</strong></td>';
	$html .= '</tr>';
}else{
	$html .= '<tr>';
	$html .= '<td align="center"><strong>'.$say.'</strong></td>';
	$html .= '<td colspan="4" align="center"><strong>TOPLAM</strong></td>';
	$html .= '<td align="left"><strong>'.number_format($txtDatas['toplam_tutar'], 2, ',', '.').'-TL</strong></td>';
	$html .= '</tr>';
}
$html .='</tbody>
</table></center>';

// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 0, 5, '', $html, 0, 1, 0, true, 'L', true);


// $pdf->SetFont('DejaVuSans', '', 12, '', true);
// $temmuzYazi = '1-'.$temSay.' sıra no arasındaki adayların MYK belge ücretleri kendileri tarafından yatırıldığından, toplam MYK belge ücreti olan <strong>'.number_format($temmuzOncesi,2,',','.').' TL</strong> geri ödenmek üzere adayların hesaplarına yatırılacak ve bu adaylar için 50.00 TL ilave ücret iadesi yapılacaktır.';
// $pdf->writeHTMLCell(0, 0, '', '', $temmuzYazi, 0, 1, 0, true, 'L', true);

if($txtDatas['status'] == "aftertransfer"){
	$pdf->Output('#Banka Akibet.pdf');
}else if($txtDatas['status'] == "beforetransfer"){
	$pdf->Output($this->tesvikId.'#4447_Ek_3 Banka Ödeme Listesi.pdf');
}else if($txtDatas['status'] == "temptransfer"){
	$pdf->Output($this->tesvikId.'#4447_Ek_3 Banka Listesi.pdf');
}

exit();