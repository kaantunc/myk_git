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
class MS_TASLAK_PDF extends TCPDF {
    //Page header
    public function Header() {
    	global $globalStandartId;
    	global $standart_bilgileri;
    	//$bilgiler = $this->getStandartBilgi ($globalStandartId);
        $bilgiler=$standart_bilgileri;
        $ad 	= "";
        $seviye	= "";
        $kod	= "..............";
        $onay	= "..............";
        $rev	= "";
		$imgTopMargin = 5;
		$imgLeftMargin = 20;
		$imgScale = 15;
		$logoLeftMargin = 20;
		$logoTopMargin = 15;
		
        // Logo
        //$this->Image(K_PATH_IMAGES.'myk_logo.png', $imgLeftMargin, $imgTopMargin, $imgScale);
        // Set font
        $this->SetFont('freeserif', '', 10);
        $this->SetY(15);
		
        // Title
        if (isset ($bilgiler[0])){
        	$ad 	= $bilgiler[0]["STANDART_ADI"];
        	$seviye	= $bilgiler[0]["SEVIYE_ADI"];
        	$kod	= $bilgiler[0]["STANDART_KODU"];
        	$onay	= $bilgiler[0]["KARAR_TARIHI"];
        	$rev	= $bilgiler[0]["REVIZYON_NO"];
        }
        $kod = ($kod)? $kod : "..............";
        $onay = ($onay)? $onay : "..............";
        
        
        $this->Cell(0, 0, FormFactory::ucwordsTR($ad).' ('.$seviye.') ', '', 0, 'L');
//    	$this->Cell(0, 0, $kod.'/'.$onay.'/'.$rev, '', 1, 'R');
    	$x = $this->GetX()- 14;
    	
    	$rev = ($rev=='00' || $rev=='0') ? '...' : $rev;
    	$this->WriteHTMLCell(14, 0, $x, $this->GetY(), '/ '.$rev, 0);
		$x = $x - 20;
		$this->WriteHTMLCell(20, 0, $x, $this->GetY(), '/ '.$onay, 0);
		$x = $x - 23;
		$this->WriteHTMLCell(24, 0, $x, $this->GetY(), $kod, 0);
		$this->ln();
		
        $this->Cell(0, 0, 'Ulusal Meslek Standardı', '', 0, 'L');
//      $this->Cell(0, 0, 'Referans Kodu/Onay Tarihi/ Rev. No', '', 1, 'R');
		$x = $this->GetX()- 14;
		$this->WriteHTMLCell(14, 0, $x, $this->GetY(), "/ Rev. No", 0);
		$x = $x - 20;
		$this->WriteHTMLCell(20, 0, $x, $this->GetY(), "/ Onay Tarihi", 0);
		$x = $x - 23;
		$this->WriteHTMLCell(23, 0, $x, $this->GetY(), "Referans Kodu ", 0);
    }
    
    // Page footer
    public function Footer() {
    	global $globalStandartId;
    	global $standart_bilgileri;
    	//$bilgiler = $this->getStandartBilgi ($globalStandartId);
        $bilgiler=$standart_bilgileri;
    	$resmi_tarih = null;
    	if (isset ($bilgiler[0])){
    		$resmi_tarih = $bilgiler[0]["RESMI_GAZETE_TARIH"];
    	}
        // Position at 1.5 cm from bottom
        $this->SetY(-22);
        // Set font
        $this->SetFont('freeserif', '', 12);
        // Page number
        //$this->Cell(0, 10, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C'); 
        $line_width =1;
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(64, 0, 0)));         
		if ($resmi_tarih){
			$this->Cell(0, 7, "© Mesleki Yeterlilik Kurumu, ".$resmi_tarih, 'T', 0, 'L');
		}else{
			$this->Cell(0, 7, "© Mesleki Yeterlilik Kurumu, ".date("Y"), 'T', 0, 'L');
		}
//		$this->SetRightMargin(10);
        $this->Cell(0, 7, "Sayfa ".$this->getAliasNumPage(), 'T', 0, 'R');
    }
    
}
?>