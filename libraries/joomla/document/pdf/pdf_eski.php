<?php
/**
* @version		$Id: pdf.php 10707 2008-08-21 09:52:47Z eddieajau $
* @package		Joomla.Framework
* @subpackage	Document
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form.php');

/**
 * DocumentPDF class, provides an easy interface to parse and display a pdf document
 *
 * @package		Joomla.Framework
 * @subpackage	Document
 * @since		1.5
 */
define ('PDF_TIPI_BASVURU', 'BASVURU');
define ('PDF_TIPI_MS_TASLAK', 'MS_TASLAK');
define ('PDF_TIPI_YET_TASLAK', 'YET_TASLAK');

class JDocumentPDF extends JDocument
{
		
	var $_engine	= null;

	var $_name		= 'joomla';

	var $_header	= null;

	var $_margin_header	= 5;//5
	var $_margin_footer	= 10;//10
	var $_margin_top	= 25;//25
	var $_margin_bottom	= 25;//25
	var $_margin_left	= 15;//15
	var $_margin_right	= 15;//15

	// Scale ratio for images [number of points in user unit]
	var $_image_scale	= 4;

	
	
	
	/**
	 * Class constructore
	 *
	 * @access protected
	 * @param	array	$options Associative array of options
	 */
	function __construct($options = array())
	{
		parent::__construct($options);

		if (isset($options['margin-header'])) {
			$this->_margin_header = $options['margin-header'];
		}

		if (isset($options['margin-footer'])) {
			$this->_margin_footer = $options['margin-footer'];
		}

		if (isset($options['margin-top'])) {
			$this->_margin_top = $options['margin-top'];
		}

		if (isset($options['margin-bottom'])) {
			$this->_margin_bottom = $options['margin-bottom'];
		}

		if (isset($options['margin-left'])) {
			$this->_margin_left = $options['margin-left'];
		}

		if (isset($options['margin-right'])) {
			$this->_margin_right = $options['margin-right'];
		}

		if (isset($options['image-scale'])) {
			$this->_image_scale = $options['image-scale'];
		}

		//set mime type
		$this->_mime = 'application/pdf';

		//set document type
		$this->_type = 'pdf';
		/*
		 * Setup external configuration options
		 */
//		define('K_TCPDF_EXTERNAL_CONFIG', true);
//		/*
//		 * Path options
//		 */

//		// Installation path
//		define("K_PATH_MAIN", JPATH_LIBRARIES.DS."tcpdf");

//		// URL path
//		define("K_PATH_URL", JPATH_BASE);
//		// Fonts path
//		//define("K_PATH_FONTS", JPATH_SITE.DS.'language'.DS."pdf_fonts".DS);

//		// Cache directory path
//		define("K_PATH_CACHE", K_PATH_MAIN.DS."cache");

//		// Cache URL path
//		define("K_PATH_URL_CACHE", K_PATH_URL.DS."cache");
//		// Images path
//		define("K_PATH_IMAGES", K_PATH_MAIN.DS."images");
//		// Blank image path
//		define("K_BLANK_IMAGE", K_PATH_IMAGES.DS."_blank.png");
//		/*
//		 * Format options
//		 */
//		// Cell height ratio
//		define("K_CELL_HEIGHT_RATIO", 1.25);

//		// Magnification scale for titles
//		define("K_TITLE_MAGNIFICATION", 1.3);

//		// Reduction scale for small font
//		define("K_SMALL_RATIO", 2/3);

//		// Magnication scale for head
//		define("HEAD_MAGNIFICATION", 1.1);

		/*
		 * Create the pdf document
		 */

		jimport('tcpdf.tcpdf');

		// Default settings are a portrait layout with an A4 configuration using millimeters as units
		$this->_engine = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		//set margins
		$this->_engine->SetMargins($this->_margin_left, $this->_margin_top, $this->_margin_right);
		//set auto page breaks
		$this->_engine->SetAutoPageBreak(TRUE, $this->_margin_bottom);
		$this->_engine->SetHeaderMargin($this->_margin_header);
		$this->_engine->SetFooterMargin($this->_margin_footer);
		$this->_engine->setImageScale($this->_image_scale);
		$this->_engine->SetFont('freeserif', '', 10);
	}

	 /**
	 * Sets the document name
	 *
	 * @param   string   $name	Document name
	 * @access  public
	 * @return  void
	 */
	function setName($name = 'joomla') {
		$this->_name = $name;
	}

	/**
	 * Returns the document name
	 *
	 * @access public
	 * @return string
	 */
	function getName() {
		return $this->_name;
	}
	

	 /**
	 * Sets the document header string
	 *
	 * @param   string   $text	Document header string
	 * @access  public
	 * @return  void
	 */
	function setHeader($text) {
		$this->_header = $text;
	}

	/**
	 * Returns the document header string
	 *
	 * @access public
	 * @return string
	 */
	function getHeader() {
		return $this->_header;
	}

	
	function render_Kapak($pdf, $dataFont, $bilgi, $resmi, $std, $seviye)
	{
		
		//eksiz ise kapağı basmayacaz
		$pdf->AddPage();
		
		// Taslak Kapak
		$pdf->setJPEGQuality(100);
		$x = 75;
		$y 	= 30;
		$width = 50;
		$height = 70;
		
		$pdf->Image(K_PATH_IMAGES.'myk_logo.jpg', $x, $y, $width, $height);
		
		// Taslak Data
		$pdf->SetPrintHeader(true);
		
		// KAPAK
		
		$pdf->SetFont($dataFont, "B", "16");
		$pdf->Cell(0, 55, "", 0, 1, 'C');
		$pdf->Cell(0, 50, "ULUSAL MESLEK STANDARDI", 0, 1, 'C');
		$pdf->Cell(0, 10, $std, 0, 1, 'C');
		$pdf->Cell(0, 0 , $seviye, 0, 1, 'C');
		$pdf->Cell(0, 10, "", 0, 1, 'C');
		$pdf->Cell(0, 30, "REFERANS KODU / ".$bilgi["STANDART_KODU"], 0, 1, 'C');
		$pdf->Cell(0, 0 , "RESMİ GAZETE TARİH-SAYI / ".$resmi, 0, 1, 'C');
			
		// KAPAK SON
		// ---------------------------------------------------------
					
	}
	function render_InitializePDF($pdfTipi, $setAutoPageBreak=FALSE, $pdfMarginTop, $pdfMarginHeader, $pdfMarginFooter, $pdfMarginLeft = PDF_MARGIN_LEFT, $pdfMarginRight = PDF_MARGIN_RIGHT)
	{
		
		// ---------------------------------------------------------
		// create new PDF document
		// Header ve Footer MYK'ya ozel pdf class
				
		if($pdfTipi==PDF_TIPI_MS_TASLAK)
		{
			jimport('tcpdf.ms_taslak_tcpdf');
			$pdf = new MS_TASLAK_PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}
		else if($pdfTipi==PDF_TIPI_YET_TASLAK)
		{
			jimport('tcpdf.yet_taslak_tcpdf');
			$pdf = new YET_TASLAK_PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
		}
		else //if($pdfTipi==PDF_TIPI_BASVURU)
		{
			jimport('tcpdf.basvuru_tcpdf');
			$pdf = new BASVURU_PDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}	
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
		// set margins
		$pdf->SetMargins($pdfMarginLeft, $pdfMarginTop, $pdfMarginRight);
		$pdf->SetHeaderMargin($pdfMarginHeader);
		$pdf->SetFooterMargin($pdfMarginFooter);
		
		// set auto page breaks
		if($setAutoPageBreak==TRUE)
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		else
			$pdf->SetAutoPageBreak(FALSE);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// ---------------------------------------------------------
					
		return $pdf;
	}
	/**
	 * Render the document.
	 *
	 * @access public
	 * @param boolean 	$cache		If true, cache the output
	 * @param array		$params		Associative array of attributes
	 * @return 	The rendered data
	 */
		
	function render( $cache = true, $params = array())
	{
		
		//Formu PDF'e cevir
		if (isset ($_GET['form'])){
			$form 	  = $_GET['form'];
			$evrak_id = $_GET['id'];
			
			if ($form < 5){ // T1, T2, T3, T4 
				
				global $mainframe;
				$user 	 	= &JFactory::getUser();
				$user_id	= $user->getOracleUserId ();
				
				if($form==1)
						$group_id = T1_GROUP_ID;//MESLEK STANDARDI BASVURUSU 
				else if($form==2)
						$group_id = T2_GROUP_ID;//YETERLILIK BASVURU
				else if($form==3)
						$group_id = T3_GROUP_ID;//BELGELENDIRME BASVURU
				else if($form==4)
						$group_id = T4_GROUP_ID;//AKREDITASYON BASVURU
				
				$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
				$aut = FormFactory::checkAuthorization  ($user, $group_id);
				if (!$aut && !$isSektorSorumlusu)
					$mainframe->redirect('index.php?', YETKI_MESAJ);
				
				
				$personelCount = $this->getPersonelCount ($evrak_id);
				$titles = array ("Meslek Standardı Hazırlama Başvuru Formu", "Yeterlilik Başvuru Formu", "Belgelendirme Başvuru Formu", "Akreditasyon Başvuru Formu");
				//Title Configuration
				$title = $titles[($form-1)];
				//Unique Filename
				$name = FormFactory::generateUniqueFilename ("basvuru_".$form);
				
				$titleFont = 'freeserif';
				$titleStyle = 'BI';
				$titleFontSize = 15;
				
				//Data Configuration
				$dataFont = 'freeserif';
				$dataStyle = '';
				$dataFontSize = 10;

				$pdf = $this->render_InitializePDF(PDF_TIPI_BASVURU, TRUE, PDF_MARGIN_TOP+10, PDF_MARGIN_HEADER+10, PDF_MARGIN_FOOTER, 25, 25);
				
				// ---------------------------------------------------------
				// Form Title
				// set font
				$pdf->SetFont($titleFont, $titleStyle, $titleFontSize);		
				// add a page
				if($form != -5)//ek degilse yeni sayfa ekle onyazi için
					$pdf->AddPage();			
				// print a line using Cell()
				$pdf->Cell(0, 5, $title, 0, 1, 'C');
				
				// ---------------------------------------------------------
				// Form Data 
				$pdf->SetFont($dataFont, $dataStyle, $dataFontSize);
				// ON YAZI
				if($form != -5)//ekleri yazdırırken on yazi koymamak için
					$this->writeOnyazi ($form, $pdf);
				$pdf->Ln(15);
				// HTML
				$pdf->WriteHTML($this->parseTaslak ($this->getBuffer(), "basvuru", "ek"), true);
				//$pdf->WriteHTML($this->fixHTML($this->getBuffer(), $form), true);
				
				// ALT YAZ
				$pdf->SetFont($dataFont, 'B', $dataFontSize);
				if($form != -5)//ekleri yazdırırken alt yazi koymamak için
					$this->writeAltyazi ($pdf, $evrak_id);
				$pdf->SetFont($dataFont, '', $dataFontSize);
				if ($personelCount > 0){
					$pdf->AddPage ();
					$pdf->WriteHTML($this->parseTaslak ($this->getBuffer(), "ek", "personel_0"), true);
					for ($i = 0; $i < $personelCount; $i++){
						$sec = "";
						if ($i < $personelCount-1){
							$sec =  "personel_".($i+1);
							$pdf->WriteHTML($this->parseTaslak ($this->getBuffer(), "personel_".$i, $sec), true);
							$pdf->AddPage ();
						}else{
							$pdf->WriteHTML($this->parseTaslak ($this->getBuffer(), "personel_".$i, $sec), true);
						}
					}
				}
							
			}else{ // Taslaklar
				
				$taslakHTML = $this->fixHTML($this->getBuffer(), $form);
				//Unique Filename
				$name = FormFactory::generateUniqueFilename ("taslak_".$form);;
			
				//Data Configuration
				$dataFont = 'freeserif';
				$dataStyle = '';
				$dataFontSize = 10;
						
				if (isset($_GET["standart_id"])){ 			//Meslek Standart Taslak
					
					//  YETKI KONTROL� COM_MESLEK_STD_TASLAK'DA TASLAK LISTELEME SAYFASINDAN ALINDI
					global $mainframe;
					$user = &JFactory::getUser ();
					
					$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
					$standartKurulusu = FormFactory::checkAuthorization  ($user, YT1_GROUP_ID);
					
					//YETKI KONTROL
					/////////////////////////////////////////////////////////////////////////////////
					$message = YETKI_MESAJ;
					if (!$sektorSorumlusu && !$standartKurulusu)
					$mainframe->redirect('index.php?', $message);
					/////////////////////////////////////////////////////////////////////////////////
					
					
					$pdf = $this->render_InitializePDF(PDF_TIPI_MS_TASLAK, FALSE, PDF_MARGIN_TOP-5, PDF_MARGIN_HEADER, PDF_MARGIN_FOOTER);
					
					
					global $globalStandartId;
					$standart_id= $_GET["standart_id"];
					$globalStandartId = $standart_id;
					$bilgi 		= $this->getStandartRevizyonBilgi ($standart_id);
					$data 		= $this->getStandartSeviye ($_GET["standart_id"]);
					$std 		= FormFactory::toUpperCase ($data["STANDART_ADI"]);
					$seviye 	= FormFactory::toUpperCase ($data["SEVIYE_ADI"]);
					$kurulusAd  = $this->getKurulusAd ($evrak_id);
					$sektor 	= "MYK ".$bilgi["SEKTOR_ADI"]." Sektör Komitesi";
					$resmi 		= ($bilgi["RESMI_GAZETE_TARIH"] != null)? $bilgi["RESMI_GAZETE_TARIH"]." / ".$bilgi["RESMI_GAZETE_SAYI"] : "";
					$karar 		= ($bilgi["KARAR_TARIHI"] != null) ? $bilgi["KARAR_TARIHI"]." Tarih ve ".$bilgi["KARAR_SAYI"]." Sayılı Karar" : "....... Tarih ve ....... Sayılı Karar";				
					$kurulusAdlari = $this->parseTaslak ($taslakHTML, "hazirlayan", "terim");

					// ---------------------------------------------------------
					$pdf->SetPrintHeader(false);
					$eksiz='0';
					$eksiz=$_GET['eksiz'];					
					
					if ($eksiz!='1'){
						
						$this->render_Kapak($pdf, $dataFont, $bilgi, $resmi, $std, $seviye);
					
					}
					$pdf->SetFont($dataFont, $dataStyle, $dataFontSize);
					// ILK SAYFA
					$pdf->AddPage();
					$pdf->SetFont($dataFont, "B", $dataFontSize);
					$arr = array ("Meslek :", "Seviye :", "Referans Kodu:", "Standardı Hazırlayan Kuruluş(lar):", "Standardı Doğrulayan Sektör Komitesi:", "MYK Yönetim Kurulu Onay Tarih/Sayı:", "Resmi Gazete Tarih/Sayı:", "Revizyon No:");
					$dataArr = array ($std, $seviye."<sup>I</sup>", $bilgi["STANDART_KODU"], $kurulusAdlari, $sektor, $karar, $resmi, $bilgi["REVIZYON_NO"]);
					for ($i = 0; $i < count($arr); $i++){
						//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign=0)
						$pdf->MultiCell(85, 28 , $arr[$i], 		1, "L", 0, 0, '', '', 1, 0, 1, 1, 0, 1); 
						$pdf->MultiCell(85, 28 , $dataArr[$i] , 1, "L", 0, 0, '', '', 1, 0, 1, 1, 0, 1); 
						
						$pdf->Ln(); //new row
					}
					
					$pdf->Ln(16);
					$dipnot = "<sup>I</sup> Mesleğin yeterlilik seviyesi, sekizli (8) seviye matrisinde seviye ".$this->convertRakam($data["SEVIYE_ID"])." (".$data["SEVIYE_ID"].") olarak belirlenmiştir.";
					$pdf->MultiCell(50, 7 , "", "B", "L", 0, 1, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->SetFont($dataFont, $dataStyle, 9);
					$pdf->WriteHTML($dipnot, false);
										
					// set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					
					$pdf->SetFont($dataFont, $dataStyle, $dataFontSize);
					// TERIMLER
					$pdf->AddPage();
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "terim", "tanitim"), false);
					$indexPage = $pdf->getPage()+1;
					
					// DATA					
					$pdf->AddPage();
					$pdf->Bookmark('1.  GİRİŞ', 0, 0);
					$pdf->Ln();
					$pdf->WriteHTML ($this->getHTMLTitle ("1.  GİRİŞ"));
					$pdf->Ln();
					$girisIlk = FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") ulusal meslek standardı 5544 sayılı Mesleki Yeterlilik Kurumu (MYK) Kanunu ile anılan Kanun uyarınca çıkartılan \"Ulusal Meslek Standartlarının Hazırlanması Hakkında Yönetmelik\" ve \"Mesleki Yeterlilik Kurumu Sektör Komitelerinin Kuruluş, Görev, Çalışma Usul ve Esasları Hakkında Yönetmelik\" hükümlerine göre MYK'nın görevlendirdiği ".FormFactory::ucWordsLeaveConjunction($kurulusAd)." tarafından hazırlanmıştır.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisIlk.'</span>', true, 0, true, true);
					//$pdf->Write(2, $girisIlk, 0, 0, 'J');
					//$pdf->Ln();
					$pdf->Ln();
					$girisSon = FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") ulusal meslek standardı, sektördeki ilgili kurum ve kuruluşların görüşleri alınarak değerlendirilmiş, ".$sektor." tarafından incelendikten sonra MYK Yönetim Kurulunca onaylanmıştır.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisSon.'</span>', true, 0, true, true);
					//$pdf->Write(2, $girisSon, 0, 0, 'J');					
					
					$pdf->AddPage();
					$pdf->Bookmark('2.  MESLEK TANITIMI', 0, 0);
					$pdf->Bookmark('2.1. Meslek Tanımı', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim", "tanitim2"), true);
					$pdf->Bookmark('2.2.  Mesleğin Uluslararası Sınıflandırma Sistemlerindeki Yeri', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim2", "tanitim3"), true);
					$pdf->Bookmark('2.3. Sağlık, Güvenlik ve Çevre ile İlgili Düzenlemeler', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim3", "tanitim4"), true);
					$pdf->Bookmark('2.4. Meslek ile İlgili Diğer Mevzuat', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim4", "tanitim5"), true);
					$pdf->Bookmark('2.5. Çalışma Ortamı ve Koşulları', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim5", "tanitim6"), true);
					$pdf->Bookmark('2.6. Mesleğe İlişkin Diğer Gereklilikler', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tanitim6", "profil_tablo"), false);
					

					
					$pdf->AddPage("L");
					$tabloCount = $this->getProfilCount ($_GET["standart_id"]);
					$pdf->Bookmark('3.  MESLEK PROFİLİ', 0, 0);
					$pdf->Bookmark('3.1. Görevler, İşlemler ve Başarım Ölçütleri', 1, 0);
					
					$this->writeProfilTable ($pdf, $standart_id);
					
//					for ($i = 0; $i < $tabloCount-1; $i++){
//						if ($i == 0){
//							$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "profil_tablo", "gibTablo1"), true);
//						}
//						
//						$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "gibTablo".($i+1), "gibTablo".($i+2)), true);		
//						$pdf->AddPage();
//					}
//					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "gibTablo".$tabloCount, "ekipman"), true);		

					$pdf->AddPage("P");
					$pdf->Write(0, "", 0, 0, 'L');
					$pdf->Bookmark('3.2. Kullanılan Araç, Gereç ve Ekipman', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "ekipman", "bilgiBeceri"), true);
					$pdf->Bookmark('3.3. Bilgi ve Beceriler', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "bilgiBeceri", "tutumDavranis"), true);
					$pdf->Bookmark('3.4. Tutum ve Davranışlar', 1, 0);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "tutumDavranis", "tutumDavranis_son"), false);
					
					$pdf->AddPage();
					$pdf->Bookmark('4.  ÖLÇME, DEĞERLENDİRME VE BELGELENDİRME', 0, 0);
					$pdf->Ln();
					$pdf->WriteHTML ($this->getHTMLTitle ("4.  ÖLÇME, DEĞERLENDİRME VE BELGELENDİRME"));
					$pdf->Ln();
					$olcmeIlk = FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") meslek standardını esas alan ulusal yeterliliklere göre belgelendirme amacıyla yapılacak ölçme ve değerlendirme, gerekli şartların sağlandığı ölçme ve değerlendirme merkezlerinde yazılı ve/veya sözlü teorik ve uygulamalı olarak gerçekleştirilecektir.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$olcmeIlk.'</span>', true, 0, true, true);
					//$pdf->Write(2, $olcmeIlk, 0, 0, 'L');
					$pdf->Ln();
					$olcmeSon = "Ölçme ve değerlendirme yöntemi ile uygulama esasları bu meslek standardına göre hazırlanacak ulusal yeterliliklerde detaylandırılır. Ölçme ve değerlendirme ile belgelendirmeye ilişkin işlenmeler Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliği çerçevesinde yürütülür.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$olcmeSon.'</span>', true, 0, true, true);
					//$pdf->Write(2, $olcmeSon, 0, 0, 'L');
					
					$gorevAlan = $this->parseTaslak ($taslakHTML, "gorev_alan", "");
					$gorevAlanGoster = $this->canViewGorevAlan ($standart_id);
					
					if ($gorevAlan !== FALSE && $gorevAlanGoster){
						$pdf->AddPage();
						$pdf->WriteHTML($gorevAlan, false);
					}
					//İçindekiler
					
					if ($eksiz!='1'){
					$pdf->AddPage();
					// write the TOC title
					$pdf->SetFont($dataFont, "B", $dataFontSize);
					$pdf->MultiCell(0, 0, 'İÇİNDEKİLER', 0, 'C', 0, 1, '', '', true, 0);
					$pdf->Ln();
					$pdf->addTOC($indexPage, 'courier', '.', 'İçindekiler');
					}
				}else if (isset($_GET["yeterlilik_id"])){	//Yeterlilik Taslak
					
					///// BU KISIM COM_YETERLILIK_TASLAK / YETERLILIK TASLAK KISMINDAN ALINDI
					global $mainframe;
					$message= YETKI_MESAJ;
					$user 	= &JFactory::getUser();
					$user_id= $user->getOracleUserId ();
					$yeterlilik_id = $_GET["yeterlilik_id"];
					$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
					$isYetkiliKurulus  = FormFactory::yeterlilikHazirlamayaYetkiliMi ($user_id, $yeterlilik_id);
						
					//YETKI KONTROL
					/////////////////////////////////////////////////////////////////////////////////
					if (!$isSektorSorumlusu && !$isYetkiliKurulus){
						$mainframe->redirect('index.php?', $message);
					}
					/////////////////////////////////////////////////////////////////////////////////
					/////////////////////////////////////////////////////////////////////////////////
					
					$pdf = $this->render_InitializePDF(PDF_TIPI_YET_TASLAK, TRUE, PDF_MARGIN_TOP-5, PDF_MARGIN_HEADER, PDF_MARGIN_FOOTER);
					
					global $globalYeterlilikId;
					$yeterlilik_id = $_GET["yeterlilik_id"];
					$globalYeterlilikId = $yeterlilik_id;
					$bilgi 		= $this->getYeterlilikRevizyonBilgi ($yeterlilik_id);
					$data   	= $this->getYeterlilikSeviye ($yeterlilik_id);
					$yet 		= $data["YETERLILIK_ADI"];
					$seviye 	= $data["SEVIYE_ADI"];
					$kurulusAd 	= $this->getKurulusAd ($evrak_id);	

					// ---------------------------------------------------------
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
					$pdf->SetAutoPageBreak(FALSE, 0);
					$pdf->AddPage();
					// KAPAK
					$pdf->SetMargins(0, 0, 0);
					$pdf->setJPEGQuality(100);
					$x = 90;
					$y 	= 3; 
					$width = 20;
					$height = 25;
					
					//TURUNCU KISIM
					$pdf->SetY(0);
					$pdf->SetFillColor(227, 108, 10); //TURUNCU
					$pdf->MultiCell(0, 32, "", 0, 'C', 1);
					$pdf->Image(K_PATH_IMAGES.'myk_logo.jpg', $x, $y, $width, $height);
					$pdf->Ln(1);
				
					//YESIL KISIM
					$widthY = 3*210/4-1;
					$pdf->SetFont($dataFont, "B", "30");
					$firstY = $pdf->GetY();
					$pdf->SetFillColor(155, 187, 89); //YESIL
					$pdf->MultiCell($widthY, 20, "", 0, 'C', 1);
				
					$pdf->MultiCell($widthY, 33 , "ULUSAL YETERLİLİK", 0, "C", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->SetFont($dataFont, "B", "18");
					$pdf->Ln ();
					$pdf->MultiCell($widthY, 6 , $bilgi["YETERLILIK_KODU"]." ".FormFactory::toUpperCase( $yet ), 0, "C", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->Ln ();
					$pdf->MultiCell($widthY, 6 , FormFactory::toUpperCase( $seviye ), 0, "C", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->Ln ();
					$pdf->MultiCell($widthY, 65, "", 0, 'C', 1);
					$pdf->SetFont($dataFont, "B", "10");
					$pdf->MultiCell($widthY, 6 , "YAYIN TARİHİ : ".$bilgi["YAYIN_TARIHI"], 		0, "C", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->Ln ();
					$pdf->MultiCell($widthY, 6 , "REVİZYON NO : ".$bilgi["REVIZYON_NO"], 		0, "C", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->Ln ();
					$pdf->MultiCell($widthY, 12, "", 0, 'C', 1);
					$lastY = $pdf->GetY();
					
					//MAVI KISIM
					$widthM = 210/4;
					$heightM = $lastY -$firstY;
					$pdf->SetY($firstY);
					$pdf->MultiCell($widthY+1, $heightM , "", 0, "L", 0, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->SetFillColor(219, 229, 241); //MAVI
					$pdf->MultiCell($widthM, $heightM , "", 0, "L", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					
					//KIRMIZI KISIM
					$heightK = 20;
					$pdf->SetY($lastY);
					$pdf->Ln(1);
					$pdf->SetFillColor(148, 54, 52); //KIRMIZI
					for ($i = 0; $i < 4; $i++){
						$widthK = 210/4-1;
						if ($i == 3)
							$widthK = 210/4;
							
						$pdf->MultiCell($widthK, $heightK , "", 0, "L", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
						$pdf->SetX($pdf->getX()+1);
					}
					$pdf->Ln($heightK+1);
					
					//PEMBE & KOYU MAVI
					$heightP = 75;
					$pdf->SetFillColor(192, 80, 77); //PEMBE
					$pdf->MultiCell($widthY, $heightP , "", 0, "L", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					$pdf->SetX($pdf->getX()+1);
					$pdf->SetFillColor(120, 192, 212); //KOYU MAVI
					$pdf->MultiCell($widthM, $heightP , "", 0, "L", 1, 0, '', '', 1, 0, 1, 1, 0, 1);

					$pdf->Ln($heightP+1);
					
					//ALT KIRMIZI
					$pdf->SetFillColor(148, 54, 52); //KIRMIZI
					$pdf->MultiCell(0, $heightK-5 , "", 0, "L", 1, 0, '', '', 1, 0, 1, 1, 0, 1);
					
					//KAPAK SON
					
					// ---------------------------------------------------------
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->SetFont($dataFont, $dataStyle, $dataFontSize);
					$pdf->SetPrintHeader(true);
					$pdf->AddPage();
					$pdf->setPrintFooter(true);
					
					//ONSOZ
					$pdf->WriteHTML ($this->getHTMLTitle ("ÖNSÖZ", 'center'));
					$pdf->Ln();
					// $yet, yeterlilik ismi buyuk harf yapildi:
					
					$onsozIlk = "<b>".FormFactory::ucwordsTR($yet)." - ".$seviye."</b> Ulusal Yeterliliği 5544 sayılı Mesleki Yeterlilik Kurumu (MYK) Kanunu ile anılan Kanun uyarınca çıkarılan “Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliği” hükümlerine göre hazırlanmıştır.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$onsozIlk.'</span>', true, 0, true, true);
					//$pdf->Write(2, $onsozIlk, 0, 0, 'L');
					//$pdf->Ln();
					$pdf->Ln();
					$onsozOrta = "Yeterlilik taslağı, ".$bilgi["KARAR_TARIHI"]." tarihinde imzalanan işbirliği protokolü ile görevlendirilen ". FormFactory::ucWordsLeaveConjunction($kurulusAd) ." tarafından hazırlanmıştır. Hazırlanan taslak hakkında sektördeki ilgili kurum ve kuruluşların görüşleri alınmış ve görüşler değerlendirilerek taslak üzerinde gerekli düzenlemeler yapılmıştır. Nihai taslak MYK ".$bilgi["SEKTOR_ADI"]." Sektör Komitesi tarafından incelenip değerlendirildikten ve Komitenin uygun görüşü alındıktan sonra, MYK Yönetim Kurulunun ".$bilgi["KARAR_TARIHI"]." tarih ve ".$bilgi["KARAR_SAYI"]." sayılı kararı ile onaylanarak Ulusal Yeterlilik Çerçevesine (UYÇ) yerleştirilmesine karar verilmiştir.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$onsozOrta.'</span>', true, 0, true, true);
					$pdf->Ln();
					$onsozSon = "Yeterliliğin hazırlanması, görüş bildirilmesi, incelenmesi ve doğrulanmasında katkı sağlayan kişi, kurum ve kuruluşlara görüş ve katkıları için teşekkür eder, yararlanabilecek tüm tarafların bilgisine sunarız.";
					//$pdf->Write(2, $onsozSon, 0, 0, 'L');
					$pdf->writeHTML('<span style="text-align:justify;">'.$onsozSon.'</span>', true, 0, true, true);
					//$pdf->Ln();
					$pdf->Ln();
					$pdf->Write(2, "Mesleki Yeterlilik Kurumu", 0, 0, 'R');
					$pdf->AddPage();
					
					//GIRIS
					$pdf->WriteHTML ($this->getHTMLTitle ("GİRİŞ", 'center'));
					$pdf->Ln();
					$girisP1 = "Ulusal yeterliliğin hazırlanmasında, sektör komitelerinde incelenmesinde ve MYK Yönetim Kurulu tarafından onaylanarak yürürlüğe konulmasında temel ölçütler Mesleki Yeterlilik, Sınav Ve Belgelendirme Yönetmeliğinde belirlenmiştir.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisP1.'</span><br />', true, 0, true, true);
//					$pdf->Write(2, $girisP1, 0, 0, 'L');
//					$pdf->Ln();
					//$pdf->Ln();
					$girisP2 = "Ulusal yeterlilik aşağıdaki hususlarla tanımlanır;";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisP2.'</span>', false, 0, true, true);
					//$pdf->Write(2, $girisP2, 0, 0, 'L');
					$pdf->SetMargins(PDF_MARGIN_LEFT+10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					//$pdf->Ln();
					$pdf->Ln();
					//$girisP3 = "a)Yeterliliğin adı ve seviyesi,\nb)Yeterliliğin amacı ve gerekçesi,\nc)Yeterliliğin ilgili olduğu sektör,\nç)Yeterlilik için gerekli olan; şekli, içeriği, süresi gibi özellikleri belirtilen eğitim ve deneyim şartları,\nd)Yeterliliğe kaynak teşkil eden meslek standardı, meslek standardı birimleri/görevleri veya yeterlilik birimleri,\ne)Yeterliliğin kazanılması için sahip olunması gereken öğrenme çıktıları,\nf)Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri,\ng)Yeterlilik belgesinin geçerlilik süresi, yenilenme şartları, gerekli görülmesi halinde belge sahibinin gözetimine ilişkin şartlar.";
					// ornek ciktidaki gibi buradaki listeye harfler eklendi:
					$girisP3 = "<ol type="."a"."><li>Yeterliliğin adı ve seviyesi,</li><li>Yeterliliğin amacı ve gerekçesi,</li><li>Yeterliliğin ilgili olduğu sektör,</li><li>Yeterlilik için gerekli olan; şekli, içeriği, süresi gibi özellikleri belirtilen eğitim ve deneyim şartları,</li><li>Yeterliliğe kaynak teşkil eden meslek standardı, meslek standardı birimleri/görevleri veya yeterlilik birimleri,</li><li>Yeterliliğin kazanılması için sahip olunması gereken öğrenme çıktıları,</li><li>Yeterliliğin kazanılmasında uygulanacak değerlendirme usul ve esasları, değerlendirmede ihtiyaç duyulan asgari sınav materyali ile değerlendirici ölçütleri,</li><li>Yeterlilik belgesinin geçerlilik süresi, yenilenme şartları, gerekli görülmesi halinde belge sahibinin gözetimine ilişkin şartlar.</li></ol>";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisP3.'</span>', false, 0, true, true);
					//$pdf->Write(2, $girisP3, 0, 0, 'L');
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->Ln();
					$girisP4 = "Ulusal yeterlilikler ulusal meslek standardının bulunduğu alanlarda söz konusu ulusal meslek standardı esas alınarak, bulunmadığı alanlarda ise uluslararası meslek standardı esas alınarak oluşturulur.";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisP4.'</span>', true, 0, true, true);
					//$pdf->Write(2, $girisP4, 0, 0, 'L');
					//$pdf->Ln();
					$girisP5 = "Ulusal yeterlilikler;";
					$pdf->Write(2, $girisP5, 0, 0, 'L');
					$pdf->SetMargins(PDF_MARGIN_LEFT+10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->Ln();
					//$girisP6 = "Örgün ve yaygın eğitim ve öğretim kurumları,\nYetkilendirilmiş belgelendirme kuruluşları,\nKuruma yetkilendirme ön başvurunda bulunmuş kuruluşlar,\nUlusal meslek standardı hazırlamış kuruluşlar,\nMeslek kuruluşları ile bunların müşterek çalışmasıyla oluşturulur.";
					$girisP6 = "<ul style="."list-style-type: square"."><li>Örgün ve yaygın eğitim ve öğretim kurumları,</li><li>Yetkilendirilmiş belgelendirme kuruluşları,</li><li>Kuruma yetkilendirme ön başvurunda bulunmuş kuruluşlar,</li><li>Ulusal meslek standardı hazırlamış kuruluşlar,</li><li>Meslek kuruluşları ile bunların müşterek çalışmasıyla oluşturulur.</li></ul>";
					$pdf->writeHTML('<span style="text-align:justify;">'.$girisP6.'</span>', false, 0, true, true);
					//$pdf->Write(2, $girisP6, 0, 0, 'L');
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->AddPage();
					
					//TASLAK DATA
					$pdf->WriteHTML ($this->getHTMLTitle ("ULUSAL YETERLİLİK", 'center'));
					$pdf->Ln();
					
					//$pdf->WriteHTML ($taslakHTML);
					$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "taslak", "ek1"), true);
					$pdf->AddPage();
					
					$pdf->WriteHTML ($this->getHTMLTitle ("EKLER", 'center'));
					$num = 3;
					for ($i = 1; $i < $num; $i++){
						if ($i == $num-1)
							$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "ek".$i, ""), true);
						else{
							$pdf->WriteHTML($this->parseTaslak ($taslakHTML, "ek".$i, "ek".($i+1)), true);
							$pdf->AddPage();
						}	
					}
					
				}
				
				// ---------------------------------------------------------
				
			}
			
			//$this->savePdfFile ($pdf, $name, $id);
		}else{ //Article PDF'e cevir
			$name = $this->getName();
			$pdf = &$this->_engine;
			
			// Set PDF Metadata
			$pdf->SetCreator($this->getGenerator());
			$pdf->SetTitle($this->getTitle());
			$pdf->SetSubject($this->getDescription());
			$pdf->SetKeywords($this->getMetaData('keywords'));
	
			// Set PDF Header data
			$pdf->setHeaderData('',0,$this->getTitle(), $this->getHeader());
	
			// Set PDF Header and Footer fonts
			$lang = &JFactory::getLanguage();
			$font = $lang->getPdfFontName();
			$font = ($font) ? $font : 'freeserif';
			
			$pdf->setRTL($lang->isRTL());
	
			$pdf->setHeaderFont(array($font, '', 10));
			$pdf->setFooterFont(array($font, '', 8));
			// Initialize PDF Document
			$pdf->AliasNbPages();
			$pdf->AddPage();
	
			// Build the PDF Document string from the document buffer
			$this->fixLinks();	
			$pdf->WriteHTML($this->getBuffer(), true);
		}
		
		$data = $pdf->Output('', 'S');

		// Set document type headers
		parent::render();

		//JResponse::setHeader('Content-Length', strlen($data), true);

		JResponse::setHeader('Content-disposition', 'inline; filename="'.$name.'.pdf"', true);
		
		//Close and output PDF document
		return $data;
	}

	function fixLinks()
	{

	}

	function fixHTML($html, $form){
		$begin = "<script";
		return substr($html, 0, strrpos  ( $html  ,$begin )-1);
	}
	
	
	function savePdfFile ($pdf, $name, $id){
		$path	  = "ekler/";
		$filePath = $path.$name.".pdf";
		$pdf->Output($filePath, 'F');
		//$this->insertUploadFile ($id, $name, $filePath);
	}
	
	function insertUploadFile ($evrak_id, $dosya_adi,$path){
		$db  = & JFactory::getOracleDBO();
		/** Sabit Tablo Degerleri 
		****************************************************/
		$file_id		= $db->getNextVal("PDF_ID_SEQ");
		$evrak_durum	= 1;
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO upload 
				values( ?, ?, ?, ?, ?, ?)";
			         
		$params = array($file_id,
						$evrak_id,
						$dosya_adi,
						$path,
						$evrak_durum
						);
	
		return $db->prep_exec_insert($sql, $params);
	}
	
	function writeOnyazi ($form, $pdf){
		if ($form == 1){ // Meslek Standardi Formu
			$dosyaNo	= "Dosya No : MYK-SHK-";
			$pdf->Cell(0, 10, "", 0, 1, 'C');
			$pdf->Write(2, $dosyaNo, 0, 'L');
			$meslekYazi = "05/10/2007 tarih ve 26664 sayı ile Resmi Gazetede yayımlanan Ulusal Meslek Standartlarının Hazırlanması Hakkında Yönetmeliğin 7/2 Maddesine göre meslek standardı hazırlama başvurusunda bulunmaktayız.";
			$pdf->Cell(0, 10, "", 0, 1, 'C');
			$pdf->Write(2, $meslekYazi, 0, 'L');
		}else if ($form == 2){
			$yetYazi = "30 Aralık 2008 tarih ve 27096 sayılı Resmi Gazetede yayımlanan Mesleki Yeterlilik Sınav ve Belgelendirme Yönetmeliğinin 12 nci maddesi 1 inci fıkrasında belirtilen şartları taşıyan kurum/kuruluş olarak yukarıda anılan yönetmelik hükümleri kapsamında aşağıda sayılan meslek/mesleklere ilişkin yeterlilik(ler)i geliştirmek istiyoruz.";
			$pdf->Cell(0, 10, "", 0, 1, 'C');
			$pdf->Write(2, $yetYazi, 0, 'L');
			$yetYazi = "Kurum/kuruluşa ilişkin gerekli bilgiler aşağıdaki bölümlerde izah edilmiştir.";
			$pdf->Cell(0, 10, "", 0, 1, 'C');
			$pdf->Write(2, $yetYazi, 0, 'L');
		}else if ($form == 3){
			$belgeYazi = "30 Aralık 2008 tarih ve 27096 sayılı Resmi Gazetede yayımlanan Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliğinde belirtilen şartları karşıladığımızı beyan ederek anılan yönetmelik hükümleri kapsamında aşağıda sayılan yeterlilik(ler)de yetkilendirilmiş belgelendirme kuruluşu olma talebimizin değerlendirilmesini arz ederiz.";
			$pdf->Cell(0, 10, "", 0, 1, 'C');
			$pdf->Write(2, $belgeYazi, 0, 'L');
		}else if ($form == 4){
		}
	}
	
	function writeAltyazi ($pdf, $evrak_id){
		// ---------------------------------------------------------
		//Data Configuration
		$dataFont = 'freeserif';
		$dataStyle = '';
		$dataFontSize = 10;
		
		$pdf2 = $this->render_InitializePDF(PDF_TIPI_BASVURU, FALSE, 0, 0, 0);
		$pdf2->SetFont($dataFont, $dataStyle, $dataFontSize);
		
		$fontFamily = $pdf->getFontFamily( );
		$kurulusBilgi  = $this->getKurulusAltyaziBilgi ($evrak_id);

		$imza = "......................................";
		$hataPayi = 2;
		//yer ve imza bilgilerinin aynı sayfada cikmasi icin
		$pos=$pdf->GetY();
		$height=$pdf->getPageHeight();
		$rem=$height-$pos;
		if($rem<($height/4)){
			$pdf->AddPage();
		}
		//
		$pdf->Cell(0, 10, "", 0, 1, 'C');
		$pdf->Write(2, "Yer    : ", 0, 'L');
		$pdf->setFont ($fontFamily, '');
		$pdf->Write(2, $kurulusBilgi["IL_ADI"], 0, 'L');
		$pdf->ln();
		$pdf->setFont ($fontFamily, 'B');
		$pdf->Write(2, "Tarih : ", 0, 'L');
		$pdf->setFont ($fontFamily, '');
		$pdf->Write(2, $kurulusBilgi["BASVURU_TARIHI"], 0, 'L');
		$pdf->ln();
		$pdf->ln();

		$pdf2->AddPage ();
		$x1 = $pdf2->GetX();
		$pdf2->Write(2, $kurulusBilgi["KURULUS_YETKILISI"],"", 0, 'L');
		$x2 = $pdf2->GetX();
		$width1 = $x2 -$x1;
		$pdf2->Ln();
		$x1 = $pdf2->GetX();
		$pdf2->Write(2, $kurulusBilgi["KURULUS_YETKILI_UNVANI"],"", 0, 'L');
		$x2 = $pdf2->GetX();
		$width2 = $x2 -$x1;
		$pdf2->Ln();
		$x1 = $pdf2->GetX();
		$pdf2->Write(2, $imza,"", 0, 'L');
		$x2 = $pdf2->GetX();
		$width3 = $x2 -$x1;
		$pdf2->Close();
		
		$width = $width2;
		if ($width1 > $width)
			$width = $width1;
		if ($width3 > $width)
			$width = $width3;
			
		$html = '<table>
					<tr>
						<td width="'.($width+$hataPayi).'mm"></td>
						<td width="25mm" style="text-decoration:underline;">
						<strong>Yetkilinin :</strong>
						</td>
					</tr>
					<tr>
						<td width="'.($width+$hataPayi).'mm">'.
						$kurulusBilgi["KURULUS_YETKILISI"]
						.'</td>
						<td width="25mm">
						<strong>Adı Soyadı :</strong>
						</td>
					</tr>
					<tr>
						<td width="'.($width+$hataPayi).'mm"> '.
						$kurulusBilgi["KURULUS_YETKILI_UNVANI"]
						.'</td>
						<td width="25mm">
						<strong>Unvanı :</strong>
						</td>
					</tr>
				 </table>';
						
		$html2 = '<table>
					<tr>
						<td width="'.($width+$hataPayi).'mm">'.
						$imza
						.'</td>
						<td width="25mm">
						<strong>İmza :</strong>
						</td>
					</tr>
				  </table>';

		$pdf->setRTL(true);				
		$pdf->WriteHTML ($html, false, false, false, false, 'L');
		$pdf->Ln();
		$pdf->WriteHTML ($html2, false, false, false, false, 'L');
		//$pdf->WriteHTMLCell($width+40, 0, $pdf->GetX()+width, $pdf->GetY(), $html, 1, 0, 0, true, 'L', false);
		$pdf->setRTL(false);
	}
	
	function parseTaslak ($str, $beginPart, $endPart){
		$begin 	= '<div id="'.$beginPart.'">';
		$beginIndex = strpos($str, $begin);
		
		if ($beginIndex === FALSE)
			return false;
			
		if ($endPart != ""){
			$end 	= '<div id="'.$endPart.'">';
			$endIndex 	= strpos($str, $end, $beginIndex);
			return substr($str, $beginIndex, ($endIndex-$beginIndex));
		}else{
			return substr($str, $beginIndex);
		}
		
	}
	
	function getStandartSeviye ($standart_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT standart_adi, seviye_adi, seviye_id 
				FROM m_meslek_standartlari 
					JOIN pm_seviye USING (seviye_id) 
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $db->prep_exec($sql, $params);
		return $data[0]; 
	}

	function getStandartDurum ($standart_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT MESLEK_STANDART_SUREC_DURUM_ID  
				FROM m_meslek_standartlari 
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $db->prep_exec_array($sql, $params);
		return $data[0]; 
	}
	
	function getYeterlilikSeviye ($yeterlilik_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT yeterlilik_adi, seviye_adi 
				FROM m_yeterlilik  
					JOIN pm_seviye USING (seviye_id) 
				WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $db->prep_exec($sql, $params);
		return $data[0]; 
	}
	
	function getKurulusAd ($evrak_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT kurulus_adi 
				FROM m_kurulus  
					JOIN m_basvuru USING (user_id)  
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $db->prep_exec($sql, $params);
		return $data[0]["KURULUS_ADI"]; 
	}
	
	function getProfilCount ($standart_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT count(*)
				FROM m_taslak_meslek_profil 
					JOIN m_taslak_meslek USING (taslak_meslek_id) 
				WHERE standart_id = ? AND parent_id = -1";
		
		$params = array ($standart_id);
		
		$data = $db->prep_exec_array($sql, $params);
		return $data[0]; 
	}
	
	function getPersonelCount ($evrak_id){
		$db = &JFactory::getOracleDBO ();
		
		$sql = "SELECT count(*)
				FROM m_basvuru_personel   
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $db->prep_exec_array($sql, $params);
		return $data[0]; 
	}
	
	function getHTMLTitle ($data, $align='left'){
		return '<h3 style="font-weight: bold;font-size: 15px; text-align: '.$align.';">'.$data.'</h3>';
	}
	
	function getStandartRevizyonBilgi ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT STANDART_KODU,
					  REVIZYON_NO,
					  SEKTOR_ADI, 
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI, 
					  TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') RESMI_GAZETE_TARIH,
					  RESMI_GAZETE_SAYI  
			   FROM m_meslek_standartlari 
			   	  JOIN m_taslak_meslek USING (standart_id) 
			   	  JOIN pm_sektorler USING (sektor_id) 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}

	function getYeterlilikRevizyonBilgi ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT YETERLILIK_KODU,
					  REVIZYON_NO,
					  SEKTOR_ADI, 
					  TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI 
			   FROM m_yeterlilik 
			   	  JOIN m_taslak_yeterlilik USING (yeterlilik_id) 
			   	  JOIN pm_sektorler USING (sektor_id) 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getProfilValues ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT 	PROFIL_ID,
						PARENT_ID,
						PROFIL_GOREV_ADI,
						PROFIL_ISLEM_ADI,
						PROFIL_BASARIM_OLCUT,
						PROFIL_BASARIM_DIPNOT  
			   FROM m_taslak_meslek_profil 
			   	 JOIN m_taslak_meslek USING (taslak_meslek_id) 
			   WHERE standart_id = ? 
			   ORDER BY profil_id";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getKurulusAltyaziBilgi ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT IL_ADI,
					  KURULUS_YETKILISI, 
					  KURULUS_YETKILI_UNVANI, 
					  TO_CHAR (BASVURU_TARIHI, 'DD/MM/YYYY' ) AS BASVURU_TARIHI	     
			   FROM M_KURULUS 
			   		JOIN M_BASVURU USING (USER_ID)
			   		LEFT JOIN ".DB_PREFIX.".P_IL ON IL_ID = KURULUS_SEHIR   
			   WHERE EVRAK_ID = ?";
		
		$data = $_db->prep_exec($sql, array($evrak_id));
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function writeProfilTable ($pdf, $standart_id){				
		// ---------------------------------------------------------
		// create new PDF document
		jimport('tcpdf.basvuru_tcpdf');
		//Data Configuration
		$dataFont = 'freeserif';
		$dataStyle = '';
		$dataFontSize = 12;
		// Header ve Footer MYK'ya ozel pdf class
		$pdf2 = new BASVURU_PDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set default monospaced font
		$pdf2->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf2->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
		$pdf2->SetHeaderMargin(0);
		$pdf2->SetFooterMargin(0);
		// set auto page breaks
		$pdf2->SetAutoPageBreak(FALSE);
		// set font
		$pdf2->SetFont($dataFont, $dataStyle, $dataFontSize);			
		// ---------------------------------------------------------
		
		$profil		= $this->getProfilValues ($standart_id);
		$tableLetters = array ('A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Y','Z');
		$margins = $pdf->getMargins();
		$widthB = ($pdf->getPageWidth ()-$margins["left"]-$margins["right"])/2;
		$width  = ($pdf->getPageWidth ()-$margins["left"]-$margins["right"])/4;
		$widthK = 15;					
		$widthA = $width - $widthK;	
		
		$gorevIndex = 0;
		$islemIndex = 0;
		$basarimIndex = 0;
		$basarimGorevIndex = -1;
		
		$gorev_profil_id = 0;
		$eski_profil_id  = 0; 
		$islemParent = 0; 
		$basarimParent = 0; 
		for ($i = 0; $i < count($profil); $i++){
			$arr = $profil[$i];
		
			if ($arr["PROFIL_GOREV_ADI"] != null){
				$gorev_profil_id = $arr["PROFIL_ID"];
				$gorevArr [$gorevIndex]  = $arr["PROFIL_GOREV_ADI"];
				$gorevIndex++;
			}else if ($arr["PROFIL_ISLEM_ADI"] != null){
				if ($islemParent != $arr["PARENT_ID"]){
					$arrIslemIndex = 0;
					$islemParent = $arr["PARENT_ID"];
					
					$islemArr [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
					$arrIslemIndex++;
					$islemIndex++;
				}else{
					$islemArr [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
					$arrIslemIndex++;
				}
			}else if ($arr["PROFIL_BASARIM_OLCUT"] != null){
				if ($eski_profil_id != $gorev_profil_id){
					$basarimIndex = 0;
					$basarimGorevIndex++;
					$gorev_profil_id = $eski_profil_id;
				}
				
				if ($basarimParent != $arr["PARENT_ID"]){
					$arrBasarimIndex = 0;
					$arrDipnotIndex = 0;
					$basarimParent = $arr["PARENT_ID"];
					
					$dipnotArr  [$basarimGorevIndex][$basarimIndex][$arrDipnotIndex++]  = $arr["PROFIL_BASARIM_DIPNOT"];
					$basarimArr [$basarimGorevIndex][$basarimIndex][$arrBasarimIndex++]  = $arr["PROFIL_BASARIM_OLCUT"];
					$basarimIndex++;
				}else{
					$dipnotArr [$basarimGorevIndex][$basarimIndex-1][$arrDipnotIndex]  = $arr["PROFIL_BASARIM_DIPNOT"];
					$basarimArr [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_OLCUT"];
					$arrBasarimIndex++;
					$arrDipnotIndex++;
				}
			}
		}
		
		$pdf->WriteHTML ($this->getHTMLTitle ("3.  MESLEK PROFİLİ"));
		$pdf->Ln();		
		$pdf->WriteHTML ($this->getHTMLTitle ("3.1. Görevler, İşlemler ve Başarım Ölçütleri"));
		$pdf->Ln();

		$this->writeProfilTableElements ($pdf, $pdf2, $gorevArr, $islemArr, $basarimArr,$dipnotArr, $tableLetters, $width, $widthB, $widthK, $widthA);
	}
	
	function writeProfilTableElements ($pdf, $pdf2, $gorevArr, $islemArr, $basarimArr,$dipnotArr, $tableLetters, $width, $widthB, $widthK, $widthA){						
		$devamDummy = "<br />(devamı var)";
		$fontFamily = $pdf->getFontFamily( );
		$hataPayi 	= 20;
		$basarimHataPayi = 0.2;
		$dipnotFirst = true;
		$_j = 0;
		$_k = 0;
		$firstX = $pdf->GetX();
		$firstY = $pdf->GetY();
		$islemBreak = false;
		$no = 1; 
		$dipnotHeightTotal = 0;
		
		for ($i = 0; $i < count ($gorevArr); $i++){
			$dipnotAciklama = array();
			$break = false;
			$gorevHeight = 0;
			$pdf->setFont ($fontFamily, 'B');
			$pdf->Cell($width, 5, "Görevler", 1, 0, 'C');
			$pdf->Cell($width, 5, "İşlemler", 1, 0, 'C');
			$pdf->Cell($widthB, 5, "Başarım Ölçütleri", 1, 1, 'C');

			$pdf->Cell($widthK, 5, "Kod", 1, 0, 'C');
			$gorevX = $pdf->GetX();
			$pdf->Cell($widthA, 5, "Adı", 1, 0, 'C');
			$pdf->Cell($widthK, 5, "Kod", 1, 0, 'C');
			$islemX = $pdf->GetX();
			$pdf->Cell($widthA, 5, "Adı", 1, 0, 'C');
			$pdf->Cell($widthK, 5, "Kod", 1, 0, 'C');
			$basarimX = $pdf->GetX();
			$pdf->Cell($widthB - $widthK, 5, "Açıklama", 1, 1, 'C');
			$gorevY = $pdf->GetY();
			$islemY = $gorevY;

			for ($j = $_j; $j < count ($islemArr[$i]); $j++){
				if (!$islemBreak){
					//Islemin break durumunu kontrol et
					//Devamli Yukseklik
					$pdf2->AddPage ();
					$pdf2->WriteHTMLCell($widthA,0,$pdf2->GetX(), $pdf2->GetY(), $islemArr[$i][$j].$devamDummy, 1);
					$pdf2->Ln();
					$heightIslemDevam = $pdf2->getY();
					$pdf2->deletePage($pdf2->getPage());
					//Devamsiz Yukseklik
					$pdf2->AddPage ();
					$pdf2->WriteHTMLCell($widthA,0,$pdf2->GetX(), $pdf2->GetY(), $islemArr[$i][$j], 1);
					$pdf2->Ln();
					$heightIslemDevamsiz = $pdf2->getY();
					$pdf2->deletePage($pdf2->getPage());
					
					if ($pdf->checkPageBreak($heightIslemDevamsiz+$hataPayi, '', false)){
						//Kesin Break var
						$_k = 0;
						$_j = $j;
						$islemBreak = true;
						break;
					}else if ( $pdf->checkPageBreak($heightIslemDevam+$hataPayi, '', false)){
						//Devami Var yazilacaksa break var
						//Sonuncu basarim olcutune kadar kontrol et
						$heightCheck = 0;
						$dipnotHeightCheck = 0;
						$dipNo = 1;
						for ($l = 0; $l < count ($basarimArr[$i][$j]); $l++){
							$dipnotNo = "";						
							if ($dipnotArr[$i][$j][$l] != null){
								$dipnotNo = "<sup>".$this->convertRomanNumerals($dipNo)."</sup>";
								$dipNo++;
							}
							
							$pdf2->AddPage ();
							$pdf2->WriteHTMLCell($widthB - $widthK,0,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$basarimArr[$i][$j][$l].$dipnotNo.'</span>', 1);							
							$pdf2->Ln();
							$heightCheck += $pdf2->getY();
							$pdf2->deletePage($pdf2->getPage());
							
							//Dipnot
							if ($dipnotArr[$i][$j][$l] != null){
								$pdf2->AddPage ();
								if ($dipNo == 2)
									$pdf2->MultiCell(50, 7 , "", "B", "L", 0, 1, '', '', 1, 0, 1, 1, 0, 1);			
								$pdf2->WriteHTMLCell(0 ,0 ,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$dipnotNo." ".$dipnotArr[$i][$j][$l].'</span>', 0);
								$pdf2->Ln(5);
								$dipnotHeightCheck += $pdf2->getY();
								$pdf2->deletePage($pdf2->getPage());
							}
						}
						
						if ($pdf->checkPageBreak($heightCheck+$dipnotHeightCheck, '', false)){
							$_k = 0;
							$_j = $j;
							$islemBreak = true;
							break;
						}
					}
				}
				
				$islemHeight = 0;
				$dipNo = 1;
				for ($k = $_k; $k < count ($basarimArr[$i][$j]); $k++){
					$ekleme = 0;
					$dipnotNo = "";
																
					if ($dipnotArr[$i][$j][$k] != null){
						$dipnotNo = "<sup>".$this->convertRomanNumerals($no)."</sup>";
						$dipNo++;
					}
						
					//Su anki basarim olcutu
					$pdf2->AddPage ();
					$pdf2->WriteHTMLCell($widthB - $widthK,0,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$basarimArr[$i][$j][$k].$dipnotNo.'</span>', 1 );
					$pdf2->Ln();
					$height = $pdf2->getY();
								
					$pdf2->deletePage($pdf2->getPage());
					
					//Dipnot
					$dipnotHeight = 0;
					if ($dipnotArr[$i][$j][$k] != null){
						$pdf2->AddPage ();
						if ($dipNo == 2)
							$pdf2->MultiCell(50, 7 , "", "B", "L", 0, 1, '', '', 1, 0, 1, 1, 0, 1);			
						$pdf2->WriteHTMLCell(0 ,0 ,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$dipnotNo." ".$dipnotArr[$i][$j][$k].'</span>', 0);
						$pdf2->Ln(5);
						$dipnotHeight = $pdf2->getY();
						$dipnotHeightTotal += $dipnotHeight;
						$pdf2->deletePage($pdf2->getPage());
					}
					
					//Bir sonraki basarim olcutu
					$heightSonraki = 0;
					if ($k < count ($basarimArr[$i][$j]) - 1 ){
						$pdf2->AddPage ();
						$pdf2->WriteHTMLCell($widthB - $widthK,0,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$basarimArr[$i][$j][$k+1].$dipnotNo.'</span>', 1);
						$pdf2->Ln();
						
						$heightSonraki = $pdf2->getY();
						$pdf2->deletePage($pdf2->getPage());
						
						//Dipnot
						$dipnotHeightSonraki = 0;
						if ($dipnotArr[$i][$j][$k+1] != null){
							$pdf2->AddPage ();
							if ($dipNo == 2)
								$pdf2->MultiCell(50, 7 , "", "B", "L", 0, 1, '', '', 1, 0, 1, 1, 0, 1);			
							$pdf2->WriteHTMLCell(0 ,0 ,$pdf2->GetX(), $pdf2->GetY(), '<span style="text-align:justify;">'.$dipnotNo." ".$dipnotArr[$i][$j][$k+1].'</span>', 0);
							$pdf2->Ln(5);
							$dipnotHeightSonraki = $pdf2->getY();
							$pdf2->deletePage($pdf2->getPage());
						}
					}
					
					if (!$pdf->checkPageBreak(($height+$dipnotHeightTotal), '', false)){
						//Bir sonrakinde page break var mi?
						if ($pdf->checkPageBreak(($height+$dipnotHeight) + ($heightSonraki+$dipnotHeightSonraki), '', false)){
							if ( $heightIslemDevam + $basarimHataPayi > ($islemHeight+$height)){
								$ekleme = $heightIslemDevam - $islemHeight - $height + $basarimHataPayi;
							}
						}
						//Yoksa sonuncuda miyim?
						else if ( $k == count ($basarimArr[$i][$j]) - 1){
							if ( $heightIslemDevamsiz + $basarimHataPayi > ($islemHeight+$height)){
								$ekleme = $heightIslemDevamsiz - $islemHeight - $height + $basarimHataPayi;
							}
						}
						
						//Aciklama
						$pdf->setFont ($fontFamily, '');
						
						if ($ekleme > 0){						
							$pdf->WriteHTMLCell($widthB - $widthK,$height + $ekleme,$basarimX, $pdf->GetY(), '<span style="text-align:justify;">'.$basarimArr[$i][$j][$k].$dipnotNo.'</span>', 1 , $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true, $valign = 1);
						}
						else{ 
							$pdf->WriteHTMLCell($widthB - $widthK,$height + $ekleme,$basarimX, $pdf->GetY(), '<span style="text-align:justify;">'.$basarimArr[$i][$j][$k].$dipnotNo.'</span>', 1);
						}
												
						//Kod
						$pdf->setFont ($fontFamily, 'B');
						$pdf->WriteHTMLCell($widthK,$height + $ekleme,$basarimX-$widthK, $pdf->GetY(), $tableLetters[$i].".".($j+1).".".($k+1), 1 , $ln=0, $fill=0, $reseth=true, $align='C', $autopadding=true, $valign = 1);
						$pdf->Ln();
						$islemHeight += $height + $ekleme;
						$_k = 0;
					}else{
						$break = true;	
						$_k = $k;
						break;
					}
					
					if ($dipnotArr[$i][$j][$k] != null){
						$dipnotAciklama[($no-1)] = $dipnotArr[$i][$j][$k];
						$no++;
					}
				}
				
				$devam = "";
				if ($break){ //BREAK VAR
					$devam = $devamDummy;
					
					//if ($heightIslemDevam+$hataPayi > $islemHeight)
						//$islemHeight = $heightIslemDevam+$hataPayi-0.3;
				}else{ // BREAK YOK
					//if ($heightIslemDevamsiz > $islemHeight)
						//$islemHeight = $heightIslemDevamsiz +$hataPayi;
				}
				
				//if (!$break){
				if (!$break || ($break && $_k > 0)){
					$pdf->SetY($islemY);
					//Aciklama
					$pdf->setFont ($fontFamily, '');
					$pdf->WriteHTMLCell($widthA,$islemHeight,$islemX, $pdf->GetY(), $islemArr[$i][$j].$devam, 1 , $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true, $valign = 1);
					//Kod
					$pdf->setFont ($fontFamily, 'B');
					$pdf->WriteHTMLCell($widthK,$islemHeight,$islemX-$widthK, $pdf->GetY(), $tableLetters[$i].".".($j+1), 1 , $ln=0, $fill=0, $reseth=true, $align='C', $autopadding=true, $valign = 1);
					$pdf->Ln();
					
					$islemY = $pdf->GetY();
					$gorevHeight += $islemHeight;
				}
				
				if ($break){
					$_j = $j;
					break;
				}else{
					$_j = 0;
				}
				
				$islemBreak = false;
			}
			
			$devam = "";
			if ($break || $islemBreak){
				$devam = $devamDummy;
			}
			
			//Aciklama
			$pdf->setFont ($fontFamily, '');
			$pdf->WriteHTMLCell($widthA,$gorevHeight,$gorevX, $gorevY, $gorevArr[$i].$devam, 1 , $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true, $valign = 1);
			//Kod
			$pdf->setFont ($fontFamily, 'B');
			$pdf->WriteHTMLCell($widthK,$gorevHeight,$gorevX-$widthK, $gorevY, $tableLetters[$i], 1 , $ln=0, $fill=0, $reseth=true, $align='C', $autopadding=true, $valign = 1);
			
			//Sayfadaki dipnotlar
			$pdf->SetFont($fontFamily, '', 9);
			$pdf->Ln();
			
			$y = $pdf->h-30;
			for($p = count($dipnotAciklama); $p >0; $p--){
				$dipnotNo = "<sup>".$this->convertRomanNumerals($p)."</sup>";
				$pdf->WriteHTMLCell(0 ,0 ,$pdf->GetX(), $y, '<span style="text-align:justify;">'.$dipnotNo." ".$dipnotAciklama[$p-1].'</span>', 0, 1);
				$y = $y-5;
				if ($dipnotFirst && $p == 1){
					$pdf->MultiCell(50, 7 , "", "B", "L", 0, 1, $pdf->GetX(), $y-2, 1, 0, 1, 1, 0, 1);
					$dipnotFirst = false;
				}
			}
			
			$pdf->setFont ($fontFamily, 'B');
			if ($i < count($gorevArr) -1 || $break || $islemBreak){
				$pdf->AddPage();
				$dipnotFirst = true;
				$dipnotHeightTotal = 0;
				$no = 1;
			}
				
			if ($break || $islemBreak){
				$i--;
			}
		}
		$pdf2->close();
		$pdf->SetXY ($firstX, $firstY);
		$pdf->setFont ($fontFamily, '');
	}
	
	function canViewGorevAlan ($standart_id){
		$durum = $this->getStandartDurum($standart_id);
		//if ( $durum == ONAYLANMIS_STANDART || $durum == RESMI_GAZETEDE_YAYINLANMIS_STANDART){
			return true;
		//}login olmamış kullanıcının standardın eklerini (görev alanları) görülmesi istendiğinden fonksiyon her zaman true dönecek şekilde değiştirildi.
		
		return true;
	}
	
	function convertRakam ($rakam){
		if ($rakam == 1)
			return "bir";
		if ($rakam == 2)
			return "iki";
		if ($rakam == 3)
			return "üç";
		if ($rakam == 4)
			return "dört";
		if ($rakam == 5)
			return "beş";
		if ($rakam == 6)
			return "altı";
		if ($rakam == 7)
			return "yedi";
		if ($rakam == 8)
			return "sekiz";
	}

	function convertRomanNumerals($num) 
	{
	    $n = intval($num);
	    $res = '';
	 
	    /*** roman_numerals array  ***/
	    $roman_numerals = array(
	                'M'  => 1000,
	                'CM' => 900,
	                'D'  => 500,
	                'CD' => 400,
	                'C'  => 100,
	                'XC' => 90,
	                'L'  => 50,
	                'XL' => 40,
	                'X'  => 10,
	                'IX' => 9,
	                'V'  => 5,
	                'IV' => 4,
	                'I'  => 1);
	 
	    foreach ($roman_numerals as $roman => $number) 
	    {
	        /*** divide to get  matches ***/
	        $matches = intval($n / $number);
	 
	        /*** assign the roman char * $matches ***/
	        $res .= str_repeat($roman, $matches);
	 
	        /*** substract from the number ***/
	        $n = $n % $number;
	    }
	 
	    /*** return the res ***/
	    return $res;
    }
}


