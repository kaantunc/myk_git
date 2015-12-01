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
class YET_TASLAK_YENI_PDF extends TCPDF {
    //Page header
    public function Header($rightText) {
    	global $globalYeterlilikId;
        global $yeterlilik_bilgileri;
        $ad 	= "";
        $kod	= "";
        $yayin	= "";
        $rev	= "";
    	//$bilgiler = $this->getYeterlilikBilgi ($globalYeterlilikId);
		$bilgiler=$yeterlilik_bilgileri;
        
		$imgTopMargin = 5;
		$imgLeftMargin = 15;
		$imgScale = 15;
		$logoLeftMargin = 15;
		$logoTopMargin = 15;
		
        // Logo
        //$this->Image(K_PATH_IMAGES.'myk_logo.png', $imgLeftMargin, $imgTopMargin, $imgScale);
        // Set font
        $this->SetFont('freeserif', '', 11);
        
        // Title
        if (isset ($bilgiler[0])){
        	$ad 	= $bilgiler[0]["YETERLILIK_ADI"];
        	$kod	= $bilgiler[0]["YETERLILIK_KODU"];
        	$yayin	= $bilgiler[0]["YAYIN_TARIHI"];
        	$rev	= $bilgiler[0]["REVIZYON_NO"];
        	$seviye = $bilgiler[0]["SEVIYE_ID"];
        }
        $yayin = ($yayin)? $yayin : ".......";
        $kod = ($kod)? $kod : ('__UY00..-'.$seviye);
//        $this->SetLeftMargin(-30);

        if($this->headerTexti=='')
        	$this->headerTextiSol = $kod.' '.FormFactory::ucWordsLeaveConjunction(FormFactory::toLowerCase($ad));
        
        //$this->Cell(0, 0, $this->headerTextiSol , '', 0, 'L');//.' (Seviye '.$seviye.')'
        //$this->MultiCell(130, 15, $this->headerTextiSol, 1, 'L', 0, 10, 15, true);
        
        $rev = ((($rev=='00' || $rev=='0' || $rev=='') && $this->yeterlilikUlusalMi($globalYeterlilikId)==false) ? '...' : $rev);
        
        if($this->headerTexti=='')
        	$this->headerTexti = 'Yayın Tarihi: '.$yayin.' Rev.No:'.$rev;

        //$this->Cell(0, 0, $this->headerTexti, '', 1, 'R');
        $this->SetX(13.5);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(110, 20, $this->headerTextiSol	, 0, 'L', 1, 0, '', '', true, 0, false, true, 40);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(2,  20, ' ' 					, 0, 'L', 1, 0, '', '', true, 0, false, true, 40);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(67.5,  20, $this->headerTexti	, 0, 'R', 1, 0, '', '', true, 0, false, false, 40);
        
        //$this->MultiCell(55, 40, '[VERTICAL ALIGNMENT - TOP] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T');
		//$this->MultiCell(55, 40, '[VERTICAL ALIGNMENT - MIDDLE] asd', 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'M');
		//$this->MultiCell(55, 40, '[VERTICAL ALIGNMENT - BOTTOM] '.$txt, 1, 'J', 1, 1, '', '', true, 0, false, true, 40, 'B');
		        
    }
    
    public function setHeaderSagYazisi($text)
    {
    	$this->headerTexti=$text;
    }
    
    public function getHeaderSagYazisi()
    {
    	return $this->headerTexti;
    }
    
    public function setHeaderSolYazisi($text)
    {
    	$this->headerTextiSol=$text;
    }
    
    public function getHeaderSolYazisi()
    {
    	return $this->headerTextiSol;
    }
    // Page footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
		$this->SetX(13.5);
        // Set font
        $this->SetFont('freeserif', '', 11);
        // Page number
        //$this->Cell(0, 10, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C'); 
//        $line_width =1;
//		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(64, 0, 0)));         
		$this->Cell(65, 10, "© Mesleki Yeterlilik Kurumu, ".date("Y"), '0', 0, 'L');
		$this->Cell(70, 10, "ULUSAL YETERLİLİK", '0', 0, 'C');
		$currentPageNo=$this->PageNo();
		if ($currentPageNo==2){$sayfa="i";}
		else if ($currentPageNo==3){$sayfa="ii";}
		else {
			$sayfa=$currentPageNo-3;
		}
		$this->Cell(45, 10, $sayfa, '0', 0, 'R');
    }
    
    function getYeterlilikBilgi ($yeterlilik_id){
    	$db = &JFactory::getOracleDBO();
    	
    	$sql = "SELECT  YETERLILIK_ADI,
    					YETERLILIK_KODU,
    					REVIZYON_NO,
    					TO_CHAR (YAYIN_TARIHI, 'dd.mm.yyyy') AS YAYIN_TARIHI,
    					SEVIYE_ID 
    			FROM M_YETERLILIK  
    				JOIN M_TASLAK_YETERLILIK USING (YETERLILIK_ID) 
    			WHERE YETERLILIK_ID = ?";
    	
    	return $db->prep_exec($sql, array ($yeterlilik_id));
    }
    
    function yeterlilikUlusalMi($globalYeterlilikId)
    {
    	$db = &JFactory::getOracleDBO();
    	 
    	$sql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ? AND YETERLILIK_DURUM_ID=".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK;
    	$result = $db->prep_exec($sql, array ($globalYeterlilikId));
    	 
    	if(count($result)>0)
    		return true;
    	else
    		return false;
    }
}
?>