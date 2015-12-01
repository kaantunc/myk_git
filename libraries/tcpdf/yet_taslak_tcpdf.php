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
class YET_TASLAK_PDF extends TCPDF {
    //Page header
    public function Header() {
    	global $globalYeterlilikId;
        global $yeterlilik_bilgileri;
    	$ad 	= "";
        $kod	= "";
        $yayin	= "";
        $rev	= "";
    	//$bilgiler = $this->getYeterlilikBilgi ($globalYeterlilikId);
		$bilgiler=$yeterlilik_bilgileri;
		$imgTopMargin = 5;
		$imgLeftMargin = 20;
		$imgScale = 15;
		$logoLeftMargin = 20;
		$logoTopMargin = 15;
		
        // Logo
        //$this->Image(K_PATH_IMAGES.'myk_logo.png', $imgLeftMargin, $imgTopMargin, $imgScale);
        // Set font
        $this->SetFont('freeserif', '', 10);
		
        // Title
        if (isset ($bilgiler[0])){
        	$ad 	= $bilgiler[0]["YETERLILIK_ADI"];
        	$kod	= $bilgiler[0]["YETERLILIK_KODU"];
        	$yayin	= $bilgiler[0]["YAYIN_TARIHI"];
        	$rev	= $bilgiler[0]["REVIZYON_NO"];
        	$seviye = $bilgiler[0]["SEVIYE_ID"];
        }
        $yayin = ($yayin)? $yayin : ".......";
         
        $this->Cell(0, 0, $kod.' '.$ad.' (Seviye '.$seviye.')', '', 0, 'L');
       	$rev = (($rev=='00' || $rev=='0') ? '...' : $rev);
       	$this->Cell(0, 0, 'Yayın Tarihi: '.$yayin.' Rev.No:'.$rev, '', 1, 'R');
    }
    
    // Page footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C'); 
        $line_width =1;
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(64, 0, 0)));         
		$this->Cell(0, 10, "© Mesleki Yeterlilik Kurumu, ".date("Y"), 'T', 0, 'L');
        $this->Cell(0, 10, "Sayfa ".$this->getAliasNumPage(), 'T', 0, 'R');
    }
    
}
?>