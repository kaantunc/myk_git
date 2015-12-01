<?php
include 'PDFMerger.php';

$pdf = new PDFMerger;

	$pdf->addPDF('samplepdfs/one.pdf', '1, 3, 4')
	->addPDF('samplepdfs/two.pdf', '1-2')
	//->addPDF('samplepdfs/three.pdf', 'all')
	//->merge('file', 'samplepdfs/TEST3.pdf'); // secilen yere kaydediliyor
	->merge('browser', 'kaantunc.pdf');
	
	
	/*
	for($i=0; $i<150; $i++){
		$pdf->addPDF('samplepdfs/one.pdf', '1');
	}
	$pdf->merge('browser', 'kaantunc.pdf');
	*/
	
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
