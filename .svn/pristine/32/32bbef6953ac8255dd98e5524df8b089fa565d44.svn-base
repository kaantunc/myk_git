<?php
include_once('libraries/PDFMerger/PDFMerger.php');

$AdayBasvuru = $this->AdayBasvuru;

$pdf = new PDFMerger;
foreach($AdayBasvuru as $row){
	$pdf->addPDF(EK_FOLDER.'abhibe/basvuru/'.$row['SINAV_ID'].'/'.$row['DOKUMAN'], 'all');
}
// $pdf->addPDF(EK_FOLDER.'samplepdfs/one.pdf', '1, 3, 4');
// $pdf->addPDF(EK_FOLDER.'samplepdfs/two.pdf', '1-2');
//->addPDF('samplepdfs/three.pdf', 'all')
//->merge('file', 'samplepdfs/TEST3.pdf'); // secilen yere kaydediliyor
$pdf->merge('browser', 'AB_HIBE_'.$this->IstekId.'.pdf');