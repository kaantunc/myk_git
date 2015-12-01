<?php 

$denetim_id = JRequest::getVar("denetim_id");
$denetimRapor = $this->denetimRapor;
$seciliDenetim = $this->seciliDenetim;
$kurulus = $this->kurulus;
$raporOnay = $this->denetimRaporOnay;
$_SESSION['raporOnay'] = $raporOnay;

$ekip = '';
$say = 1;
foreach ($this->seciliDenetiminDenetimEkibi as $row){
	$ekip .= $say.'. '.$row['AD'].' '.$row['SOYAD'].' - '.$row['ROL_ADI'].'<br/>';
	$say++;
}

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
//         $image_file = K_PATH_IMAGES.'logo_example.jpg';
//         $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//         // Set font
//         $this->SetFont('helvetica', 'B', 20);
//         // Title
//         $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('DejaVuSans', 'I', 8);
        if($_SESSION['raporOnay']){
        	$this->Cell(0, 0, 'Bu döküman Yardımcı Denetçi tarafından oluşturulmuş olup Baş Denetçi ve varsa Denetçi(ler) tarafından elektronik ortamda onaylanmıştır.', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        }
        // Page number
        $this->Cell(0, 10, 'Sayfa '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('DejaVuSans', '', 14, '', true);

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
$pdf->writeHTMLCell(55, 30, '', '', $logo, 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(0, 30, '', '', $ilkSayfaUst, 0, 1, 0, true, 'C', true);

$pdf->SetFont('DejaVuSans', '', 11, '', true);
$pdf->writeHTMLCell(0, 10, '', '', '<strong>Dosya No:</strong> YB-'.$seciliDenetim['YB_KODU'], 0, 1, 0, true, 'L', true);

// 1. Kısım
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>1)	Belgelendirme Kuruluşunun Adı-Tanımı</strong>', 0, 1, 0, true, 'L', true);
$BirinciKisim = '
		<p><strong>1)	Belgelendirme Kuruluşunun Adı-Tanımı</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>Adı:</strong></td>
			<td width="65%">'.$kurulus['KURULUS_ADI'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>Adres:</strong></td>
			<td width="65%">'.$kurulus['KURULUS_ADRESI'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>Posta kodu-Şehir:</strong></td>
			<td width="65%">'.$kurulus['KURULUS_POSTA_KODU'].'-'.$kurulus['IL_ADI'].'</td>
		</tr>
	</tbody>
</table>
';

$pdf->writeHTMLCell(0, 10, '', '', $BirinciKisim, 0, 1, 0, true, 'J', true);

$BirinciDiger = '
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>Denetim Tarihi:</strong></td>
			<td width="65%">'.$seciliDenetim['DENETIM_TARIHI_BASLANGIC'].' - '.$seciliDenetim['DENETIM_TARIHI_BITIS'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>Denetim Ekibi:</strong></td>
			<td width="65%">'.$ekip.'</td>
		</tr>
	</tbody>
</table>';
$pdf->writeHTMLCell(0, 10, '', '', $BirinciDiger, 0, 1, 0, true, 'J', true);

// 1. Kısım Son

// 2. Kısım Başlangıç
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>2)	Organizasyon Yapısı, Görev ve Sorumluluklar</strong>', 0, 1, 0, true, 'L', true);

$html = '
		<p><strong>2)	Organizasyon Yapısı, Görev ve Sorumluluklar</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>2.1 Organizasyon yapısının uygunluğu</strong></td>
			<td width="65%">'.$denetimRapor['ORG_YAP_UYG'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>2.2 Eğitim belgelendirme ayrımının yapılması</strong></td>
			<td width="65%">'.$denetimRapor['EGI_BEL_AYR'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>2.3 Kritik görevlerde sorumlulukların açık olarak belirlenmesi</strong></td>
			<td width="65%">'.$denetimRapor['KRI_GOR_SOR'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>2.4 Belgelendirme faaliyetlerinin etkilenmemesine yönelik önlemlerin alınması</strong></td>
			<td width="65%">'.$denetimRapor['BEL_FAA_ET'].'</td>
		</tr>
	</tbody>
</table>
';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 10, '', '', $html, 0, 1, 0, true, 'J', true);
// 2. Kısım Son

// 3. Kısım Baş
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>3)	İnsan Kaynakları, Fiziki, Teknik Ve Mali İmkânları</strong>', 0, 1, 0, true, 'L', true);

$html = '
		<p><strong>3)	İnsan Kaynakları, Fiziki, Teknik Ve Mali İmkânları</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>3.1 Kuruluşun yetki kapsamındaki faaliyetleri için yeterli (sayı ve nitelik olarak) insan kaynağının varlığı</strong></td>
			<td width="65%">'.$denetimRapor['KUR_YET_FAA'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>3.2 Sınav yapanların ilgili ulusal yeterliliğin şartlarını sağlaması</strong></td>
			<td width="65%">'.$denetimRapor['SIN_YAP_SART'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>3.3 Fiziki altyapı ve teknik donanımın sınav ve belgelendirme faaliyetlerini gerçekleştirmeye uygunluğu</strong></td>
			<td width="65%">'.$denetimRapor['FIZ_ALT_TEK'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>3.4 Mali yapının faaliyetleri sürdürmeye uygunluğu</strong></td>
			<td width="65%">'.$denetimRapor['MAL_YAP_FAA'].'</td>
		</tr>
	</tbody>
</table>
';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 10, '', '', $html, 0, 1, 0, true, 'J', true);
// 3. Kısım Son

// 4. Kısım Baş
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>3)	İnsan Kaynakları, Fiziki, Teknik Ve Mali İmkânları</strong>', 0, 1, 0, true, 'L', true);

$html = '
		<p><strong>4)	Sınav Ve Belgelendirme Süreçleri</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>4.1 Sınav ve belgelendirme süreçlerine ilişkin prosedürlerin ve uygulamanın uygunluğu</strong></td>
			<td width="65%">'.$denetimRapor['SIN_BEL_SUR'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>4.2 Tutulan kayıtlar</strong></td>
			<td width="65%">'.$denetimRapor['TUT_KAY_INC'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>4.3 Gezici sınav birimleri ile gerçekleştirilen sınavlara ilişkin doküman ve uygulama</strong></td>
			<td width="65%">'.$denetimRapor['GEZ_SIN_BIR'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>4.4 İtiraz ve şikayetlerin değerlendirilmesine ilişkin prosedür ve kayıtlar</strong></td>
			<td width="65%">'.$denetimRapor['ITI_SIK_DEG'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>4.5 Farklı sınav heyetleri arasındaki değerlendirmelerde uygulama birliğinin sağlanmasına yönelik önlemler</strong></td>
			<td width="65%">'.$denetimRapor['FAR_SIN_HEY'].'</td>
		</tr>
	</tbody>
</table>
';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 10, '', '', $html, 0, 1, 0, true, 'J', true);
// 4. Kısım Son

// 5. Kısım Baş
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>3)	İnsan Kaynakları, Fiziki, Teknik Ve Mali İmkânları</strong>', 0, 1, 0, true, 'L', true);

$html = '
		<p><strong>5)	Sınav Materyali</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>5.1 Mevcut sınav materyalinin ulusal yeterliliklerle uyumu</strong></td>
			<td width="65%">'.$denetimRapor['MEV_SIN_MET'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>5.2 Yapılan sınavlar ile sınav materyalinin tutarlılığı</strong></td>
			<td width="65%">'.$denetimRapor['YAP_SIN_MET'].'</td>
		</tr>
	</tbody>
</table>
';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 10, '', '', $html, 0, 1, 0, true, 'J', true);
// 5. Kısım Son

// 6. Kısım Baş
// $pdf->writeHTMLCell(0, 10, '', '', '<strong>3)	İnsan Kaynakları, Fiziki, Teknik Ve Mali İmkânları</strong>', 0, 1, 0, true, 'L', true);

$html = '
		<p><strong>6)	İç / Dış Denetimler</strong></p>
<table width="100%" border="1" style="padding:10px">
	<tbody>
		<tr nobr="true">
			<td width="35%"><strong>6.1 İç denetim kayıtlarının mevcudiyeti</strong></td>
			<td width="65%">'.$denetimRapor['IC_DEN_KAY'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>6.2 Dış denetimler ve sonuçları </strong></td>
			<td width="65%">'.$denetimRapor['DIS_DEN'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>6.3 İç ve dış denetimde tespit edilen uygunsuzluklar</strong></td>
			<td width="65%">'.$denetimRapor['DEN_UYG_TES'].'</td>
		</tr>
		<tr nobr="true">
			<td width="35%"><strong>6.4 İç ve dış denetimde tespit edilen uygunsuzlukların kapatılması</strong></td>
			<td width="65%">'.$denetimRapor['VAR_UYG_KAP'].'</td>
		</tr>
	</tbody>
</table>
';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(0, 10, '', '', $html, 0, 1, 0, true, 'J', true);
// 6. Kısım Son

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($denetim_id.'#Denetim Raporu.pdf');
exit();