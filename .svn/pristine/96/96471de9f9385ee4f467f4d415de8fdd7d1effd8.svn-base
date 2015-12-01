<?php
require_once(dirname(__FILE__).'/tcpdf.php');

/**
 * main configuration file
 */
require_once(dirname(__FILE__).'/config/tcpdf_config.php');

// includes some support files

/**
 * unicode data
 */
require_once(dirname(__FILE__).'/unicode_data.php');

/**
 * html colors table
 */
require_once(dirname(__FILE__).'/htmlcolors.php');

// Extend the TCPDF class to create custom Header and Footer
class BASVURU_PDF extends TCPDF {
    //Page header
    public function Header() {
		$imgTopMargin = 5;
		$imgLeftMargin = 25;
		$imgScale = 15;
		$logoLeftMargin = 20;
		$logoTopMargin = 15;
		
        // Logo
		/**
		 * Set start-writing mark on current page for multicell borders and fills.
		 * This function must be called after calling Image() function for a background image.
		 * Background images must be always inserted before calling Multicell() or WriteHTMLCell() or WriteHTML() functions.
		 */
		
		$this->Image(K_PATH_IMAGES.'myk_basvuru_logo.png', $imgLeftMargin, $imgTopMargin, $imgScale);

		$this->setPageMark();
        $form = $_GET['form'];
        
        if($form == '1'){
        	$baslik="T.C. MESLEKİ YETERLİLİK KURUMU";
        	$fontSize=14;
        } else if($form == '2'){
        	$baslik="ULUSAL YETERLİLİK TASLAĞI HAZIRLAMA/GELİŞTİRME BAŞVURU FORMU";
        	$fontSize=12;
        } else if ($form == '3') {
        	$baslik="T.C. MESLEKİ YETERLİLİK KURUMU";
        	$fontSize=14;        	 
        }
        $this->SetFont('freeserif', 'B', $fontSize);
        $this->writeHTMLCell(140, 0, 40, 10, $baslik, 0, 0, 0, 0, 'C' );
		
        
        // Set font
		
    }
    
    // Page footer
    public function Footer() {
        
    	$this->SetFont('freeserif', 'B', $fontSize);
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('dejavusans', 'I', 8);
        //Kalin Cizgi
        $line_width = 0.6;
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(98, 36, 35)));         
		$this->Cell(0, 10, "© Mesleki Yeterlilik Kurumu, ".date("Y"), 'T', 0, 'L');
        $this->Cell(0, 10, "Sayfa ".$this->getAliasNumPage(). " / ".$this->getAliasNbPages(), 'T', 0, 'R');
        //Ince Cizgi
        $this->SetY(-14);
        $line_width = 0.2;
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(98, 36, 35)));
        $this->Cell(0, 0, "", 'T', 0, 'L');
    }
}
?>