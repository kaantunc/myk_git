<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$atData = $this->atData;
$atTar = $this->atTar;
require_once 'libraries/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$phpWord = new \PhpOffice\PhpWord\PhpWord();

// Baslik Style
$phpWord->addFontStyle('rBasStyle', array('bold'=>true, 'name'=>'Times New Roman', 'size'=>12));
$phpWord->addParagraphStyle('pBasStyle', array('align'=>'center', 'spaceAfter'=>100));

//İçerik Style
$phpWord->addFontStyle('rIcStyle', array('name'=>'Times New Roman', 'size'=>12));
$phpWord->addParagraphStyle('pIcStyle', array('align'=>'center', 'spaceAfter'=>100));

//İçerikBas Style
$phpWord->addFontStyle('rIcBasStyle', array('name'=>'Times New Roman', 'size'=>12,'bold'=>true));
$phpWord->addParagraphStyle('pIcStyle', array('align'=>'center', 'spaceAfter'=>100));

// New portrait section
$section = $phpWord->addSection(array('orientation'=>'portrait'));

$section->addText('EK-8','rBasStyle',array('align'=>'right'));
$section->addText('Avrupa Topluluğu (AT) Yüklenicileri Tarafından 2.000 TL’nin Üstünde Yapılan Alımlara İlişkin Üçer Aylık Bildirim Tablosu','rBasStyle',array('align'=>'center'));
$section->addText('(KDV İstisna Sertifikası alınan vergi idaresine gönderilecektir)','rIcStyle',array('align'=>'center'));

$section->addTextBreak(1);

$styleTable = array('borderSize' => 6, 'borderColor' => '000000','cellMarginLeft' => 20);
$styleFirstRow = array('borderBottomSize' => 6, 'borderBottomColor' => '000000');
$styleCell = array('borderRightColor' => '000000', 'borderRightSize' => 6, 'valign'=>'center');
$fontStyleBold = array('bold'=>true, 'name'=>'Times New Roman', 'size'=>12);
$fontStyle = array('name'=>'Times New Roman', 'size'=>12);
$phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
$table = $section->addTable('Fancy Table');
$table->addRow();
$table->addCell(1500, $styleCell)->addText('Dönem', $fontStyleBold, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(8500, $styleCell)->addText($atTar['sBas'].' - '.$atTar['sBit'],$fontStyle, array('spaceBefore'=>10,'spaceAfter'=>10));
$table = $section->addTable('Fancy Table');
$table->addRow();
$table->addCell(10000, array('gridSpan' => 2, 'valign' => 'both'))->addText('AT Yüklenicisinin', $fontStyleBold, array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addRow();
$table->addCell(3250, $styleCell)->addText('Unvanı/Adı', $fontStyleBold, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(6750, $styleCell)->addText('Mesleki Yeterlilik Kurumu',$fontStyle, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addRow();
$table->addCell(3250, $styleCell)->addText('Tüzel Kişiler için Vergi Kimlik Numarası', $fontStyleBold, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(6750, $styleCell)->addText('6190515234', $fontStyle, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addRow();
$table->addCell(3250, $styleCell)->addText('Gerçek Kişiler için T.C. Kimlik Numarası', $fontStyleBold, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(6750, $styleCell)->addText('-',$fontStyle, array('spaceBefore'=>10,'spaceAfter'=>10));
$table->addRow();
$table->addCell(10000, array('gridSpan' => 2, 'valign' => 'center'))->addText('Temin edilen mal, hizmet ve işe ve Tedarikçilere ilişkin bilgiler', $fontStyleBold, array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));

$cellRowSpan = array('vMerge' => 'restart', 'borderRightColor' => '000000', 'borderRightSize' => 6, 'valign'=>'center');
$cellColSpan = array('gridSpan' => 2, 'borderRightColor' => '000000', 'borderRightSize' => 6, 'valign'=>'center');
$cellRowContinue = array('vMerge' => 'continue', 'borderRightColor' => '000000', 'borderRightSize' => 6);
// Kuruluş Faturaları
$styleTableKur = array('borderSize' => 6, 'borderColor' => '000000','cellMarginLeft' => 20);
$styleFirstRowKur = array('borderBottomSize' => 6, 'borderBottomColor' => '000000');
$phpWord->addTableStyle('KurTable', $styleTableKur, $styleFirstRow);
$table = $section->addTable('KurTable');
$table->addRow();
$table->addCell(500, $cellRowSpan)->addText('Sıra No', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(4000, $cellColSpan)->addText('Tedarikçinin', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(2800, $cellColSpan)->addText('Temin edilen mal, hizmet ve işin', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(2700, $cellColSpan)->addText('Faturanın', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));

$table->addRow();
$table->addCell(500, $cellRowContinue)->addText(null, $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(2100, $styleCell)->addText('Adı/Unvanı', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(1900, $styleCell)->addText("Vergi Kimlik No'su", $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(1250, $styleCell)->addText('Türü', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(1550, $styleCell)->addText('Tutarı', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(950, $styleCell)->addText('Tarihi', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$table->addCell(1750, $styleCell)->addText('Sayısı', $fontStyleBold,array('align'=>'center','spaceBefore'=>10,'spaceAfter'=>10));
$fontStyleTableIc = array('name'=>'Times New Roman', 'size'=>10);
$sira = 0;
foreach($atData as $row){
    $sira++;
    $table->addRow();
    $table->addCell(500, $styleCell)->addText($sira, $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(2100, $styleCell)->addText($row['KURULUS_ADI'], $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(1900, $styleCell)->addText($row['VERGI_KIMLIK_NO'], $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(1250, $styleCell)->addText('Belgelendirme için sınav hizmeti', $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(1550, $styleCell)->addText($row['FATURA_TUTAR'].' TL', $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(950, $styleCell)->addText($row['FATURA_TARIH'], $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
    $table->addCell(1750, $styleCell)->addText($row['FATURA_NO'], $fontStyleTableIc,array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0));
}
$section->addTextBreak(3);

$section->addText('Yukarıda yer alan harcamalar, “IPA Çerçeve Anlaşması kapsamındaki 20.07.2015 tarih TRH3.1UYEP2/P-04 sayılı AT Sözleşmesi” çerçevesinde yapılmıştır.','rIcStyle',array('align'=>'both'));
$section->addText('.../…/201..','rIcStyle',array('align'=>'right'));
$section->addTextBreak(1);
$section->addText('Bayram AKBAŞ','rIcStyle',array('align'=>'right'));
$section->addText('Kurum Başkanı','rIcStyle',array('align'=>'right'));
// SON KISIM

/*
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;');
header('Content-Disposition: attachment;filename="test.docx"');
header('Cache-Control: max-age=0');

// output the file to the browser
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');
exit; //you must have the exit!
*/

$tt = date('YmdHis');
$directory = EK_FOLDER.'abhibe/atword';
if (!file_exists($directory)){
    mkdir($directory, 0700,true);
}
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($directory.'/'.$tt.'.docx');
header ("location: index.php?dl=abhibe/atword/".$tt.'.docx');

?>