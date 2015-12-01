<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'libraries/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$evrak_id		= $this->evrak_id;
$standart_id	= $this->standart_id;
$hazirlayan		= $this->hazirlayan;
$terim			= $this->terim;
$meslekTanitim 	= $this->meslekTanitim;
$meslekStandart = $this->meslekStandart;
$ekipman		= $this->ekipman;
$bilgiBeceri 	= $this->bilgiBeceri;
$tutumDavranis 	= $this->tutumDavranis;
$gorevAlan 		= $this->gorevAlan;
$yonetimKurulu  = $this->yonetimKurulu;
$profil 		= $this->profil;
$tur_id			= $this->tur_id;
$cellPadding	= 3;
//
$user =& JFactory::getUser();
$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
//

//Bilgiler
$bilgi = $this->bilgi;
$standart_bilgileri = $this->standart_bilgileri;
$data = $this->data;
$std 		= FormFactory::toUpperCase ($data["STANDART_ADI"]);
$seviye 	= FormFactory::toUpperCase ($data["SEVIYE_ADI"]);
$seviyeId = explode(' ', $seviye);
$seviyeId = $seviyeId[1];
$kurulusAd = $this->kurulusAd;
$sektor 	= "MYK ".$bilgi["SEKTOR_ADI"]." Sektör Komitesi";
$resmi 		= ($bilgi["RESMI_GAZETE_TARIH"] != null)? $bilgi["RESMI_GAZETE_TARIH"]." / ".$bilgi["RESMI_GAZETE_SAYI"] : "";
$karar 		= ($bilgi["KARAR_TARIHI"] != null) ? $bilgi["KARAR_TARIHI"]." Tarih ve ".$bilgi["KARAR_SAYI"]." Sayılı Karar" : "....... Tarih ve ....... Sayılı Karar";

$adH 	= $standart_bilgileri[0]["STANDART_ADI"];
$seviyeH	= $standart_bilgileri[0]["SEVIYE_ADI"];
$kodH	= $standart_bilgileri[0]["STANDART_KODU"];
$onayH	= $standart_bilgileri[0]["KARAR_TARIHI"];
$revH	= $standart_bilgileri[0]["REVIZYON_NO"];

$kodH = ($kodH)? $kodH : "..............";
$onayH = ($onayH)? $onayH : "..............";
$revH = ($revH=='00' || $revH=='0') ? '...' : $revH;
//Bilgiler Son

// New Word Document


// Baslik Style
$phpWord->addFontStyle('rBasStyle', array('bold'=>true, 'name'=>'Times New Roman', 'size'=>14));
$phpWord->addParagraphStyle('pBasStyle', array('align'=>'center', 'spaceAfter'=>100));

//İçerik Style
$phpWord->addFontStyle('rIcStyle', array('name'=>'Times New Roman', 'size'=>12));
$phpWord->addParagraphStyle('pIcStyle', array('align'=>'center', 'spaceAfter'=>100));

//İçerikBas Style
$phpWord->addFontStyle('rIcBasStyle', array('name'=>'Times New Roman', 'size'=>12,'bold'=>true));
$phpWord->addParagraphStyle('pIcStyle', array('align'=>'center', 'spaceAfter'=>100));

// New portrait section
$section = $phpWord->createSection(array('orientation'=>'portrait'));

//   Kapak
$section->addImage('images/myk_logo.jpg',array('width'=>152, 'height'=>187,'align'=>'center'));
$section->addTextBreak(3);
$section->addText('ULUSAL MESLEK STANDARDI','rBasStyle','pBasStyle');
$section->addTextBreak(3);
$section->addText($std,'rBasStyle','pBasStyle');
$section->addText($seviye,'rBasStyle','pBasStyle');
$section->addTextBreak(2);
$section->addText('REFERANS KODU / '.$bilgi['STANDART_KODU'],'rBasStyle','pBasStyle');
$section->addTextBreak(1);
$section->addText('RESMİ GAZETE TARİH-SAYI / '.$resmi,'rBasStyle','pBasStyle');
//   Kapak Son

//footer
$paraStyle = array('bold'=>true, 'align' => 'center');
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$TableMeslek = array('borderSize'=>1, 'borderColor'=>'000000', 'cellMargin'=>0);
$footer = $section->createFooter();
$tfooter = $footer->addTable($TableMeslek);
$tfooter->addRow();
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addRow();
$tfooter->addCell(8000,array('valign'=>'left'))->addText('© Mesleki Yeterlilik Kurumu, 2013',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$tfooter->addCell(8000,array('valign'=>'right'))->addPreserveText('Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle');
//$footer->addPreserveText('    © Mesleki Yeterlilik Kurumu, 2013               						        Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle' );
//footer Son

//header
$subsequent = $section->addHeader();
$subsequent->firstPage();
$header = $section->createHeader();
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceAfter'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceAfter'=>0));
$theader = $header->addTable();
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText($adH.'('.$seviyeH.')',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText($kodH.' / '.$onayH.' / '.$revH,array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText('Ulusal Meslek Standardı',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText('Referans Kodu / Onay Tarihi / Rev. No',array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
//header Son

//2. Sayfa Table

$styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>600);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'00000', 'bgColor'=>'66BBFF');

// Define cell style arrays
$styleCell = array('valign'=>'center');

// Define font style for first row
$fontStyle = array('bold'=>true, 'name'=>'Times New Roman', 'size'=>12);

// Add table style
$phpWord->addTableStyle('myOwnTableStyle', $styleTable);
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$cellStyle = array('spacing'=>0,'align'=>'left','spaceBefore'=>0,'spaceAfter'=>400);
// Add table
$table = $section->addTable('myOwnTableStyle');
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Meslek:',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($std,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Seviye:',$fontStyle,$cellStyle);
$footCell = $table->addCell(5000,array('borderSize'=>6,'valign'=>'left'));
$footRun = $footCell->addTextRun();
$footRun->addText($seviye,$fontStyle,$cellStyle);
$footNote = $footRun->addFootnote();
$footNote->addText('Mesleğin yeterlilik seviyesi, sekizli (8) seviye matrisinde seviye ('.$seviyeId.') olarak belirlenmiştir.',array('name'=>'Times New Roman', 'size'=>10));
// $table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Seviye:',$fontStyle,$cellStyle);
// $table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($seviye,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Referans Kodu:',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($bilgi["STANDART_KODU"],$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Standardı Hazırlayan Kuruluş(lar):',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($kurulusAd,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Standardı Doğrulayan Sektör Komitesi:',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($sektor,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('MYK Yönetim Kurulu Onay Tarih/ Sayı:',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($karar,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Resmi Gazete Tarih/Sayı: ',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($resmi,$fontStyle,$cellStyle);
$table->addRow(2);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText('Revizyon No:',$fontStyle,$cellStyle);
$table->addCell(5000,array('borderSize'=>6,'valign'=>'left'))->addText($bilgi["REVIZYON_NO"],$fontStyle,$cellStyle);
//2. Sayfa Table SON

//Terimler
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$section->addText("TERİMLER, SİMGELER VE KISALTMALAR",'rIcBasStyle','pBasStyle');
$space75Left = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>75);
if ($terim[0] != null){
	foreach ($terim[0] as $row){
		$textrun = $section->createTextRun($space75Left);
		$textrun->addText($row["TERIM_ADI"].": ", 'rIcBasStyle');
		$textrun->addText($row["TERIM_ACIKLAMA"], 'rIcStyle');
	}
	$section->addText('ifade eder.','rIcStyle',array('align'=>'both'));
}
//Terimler Son
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$section->addText('İÇİNDEKİLER','rIcBasStyle','pBasStyle');
//**********************************İÇİNDEKİLER**********************************************************//
//Önemli: İçindekiler Kısmı yok. Yapılacak ins.
$phpWord->addTitleStyle(1,array('name'=>'Times New Roman', 'size'=>12,'bold'=>true),array('align'=>'both','spaceBefore'=>150,'spaceAfter'=>0,'spacing'=>150));
$phpWord->addTitleStyle(2,array('name'=>'Times New Roman', 'size'=>12,'bold'=>true),array('align'=>'both','spaceBefore'=>150,'spaceAfter'=>0,'spacing'=>150));
$fontStyleIcindekiler = array('spaceAfter'=>60, 'size'=>12);
$section->addTOC($fontStyle,$fontStyle);

//**********************************İÇİNDEKİLER**********************************************************//

//Giriş
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$section->addTitle('1.	GİRİŞ',1);
$section->addText(FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") ulusal meslek standardı 5544 sayılı Mesleki Yeterlilik Kurumu (MYK) Kanunu ile anılan Kanun uyarınca çıkartılan \"Ulusal Meslek Standartlarının Hazırlanması Hakkında Yönetmelik\" ve \"Mesleki Yeterlilik Kurumu Sektör Komitelerinin Kuruluş, Görev, Çalışma Usul ve Esasları Hakkında Yönetmelik\" hükümlerine göre MYK'nın görevlendirdiği ".FormFactory::ucWordsLeaveConjunction($kurulusAd)." tarafından hazırlanmıştır.",'rIcStyle',array('align'=>'both'));
$section->addText(FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") ulusal meslek standardı, sektördeki ilgili kurum ve kuruluşların görüşleri alınarak değerlendirilmiş, ".$sektor." tarafından incelendikten sonra MYK Yönetim Kurulunca onaylanmıştır.",'rIcStyle',array('align'=>'both'));
//Giriş SON

//Meslek Tanıtımı
$space75Both = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>75);
$space150Both = array('align'=>'both','spaceBefore'=>150,'spaceAfter'=>0,'spacing'=>150);
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$section->addTitle('2.	MESLEK TANITIMI',1);
$section->addTitle('2.1.	Meslek Tanımı',2);
$textt = NormalTextExplode($meslekTanitim["MESLEK_TANIM"]);
foreach($textt as $row){
	if(strlen($row)>1){
		$section->addText($row,'rIcStyle',$space75Both);
	}
}

$section->addTitle('2.2.	Mesleğin Uluslararası Sınıflandırma Sistemlerindeki Yeri',2);
foreach($meslekStandart as $row){
	$textrun = $section->createTextRun();
	$textrun->addText($row["STANDART_ADI"].": ", 'rIcBasStyle');
	$textt = NormalTextExplode($row["STANDART_ACIKLAMA"]);
	foreach ($textt as $cow)
	if(strlen($cow)>1){
		$textrun->addText($cow, 'rIcStyle',$space75Both);
	}
}

$section->addTitle('2.3.	Sağlık, Güvenlik ve Çevre ile İlgili Düzenlemeler',2);
$textt = NormalTextExplode($meslekTanitim["MESLEK_SAGLIK_DUZENLEME"]);
foreach($textt as $row){
	if(strlen($row)>0){
		$section->addText($row,'rIcStyle',$space75Both);
	}
}

$section->addTitle('2.4.	Meslek ile İlgili Diğer Mevzuat',2);
$textt = NormalTextExplode($meslekTanitim["MESLEK_MEVZUAT"]);
foreach($textt as $row){
	if(strlen($row)>0){
		$section->addText($row,'rIcStyle',$space75Both);
	}
}

$section->addTitle('2.5.	Çalışma Ortamı ve Koşulları',2);
$textt = NormalTextExplode($meslekTanitim["MESLEK_CALISMA_KOSUL"]);
foreach($textt as $row){
	if(strlen($row)>0){
		$section->addText($row,'rIcStyle',$space75Both);
	}
}

$section->addTitle('2.6.	Mesleğe İlişkin Diğer Gereklilikler ',2);
$textt = NormalTextExplode($meslekTanitim["MESLEK_GEREKLILIK"]);
foreach($textt as $row){
	if(strlen($row)>0){
		$section->addText($row,'rIcStyle',$space75Both);
	}
}
//$section->addTextBreak(1);
//Meslek Tanıtımı SON


//******************************************************* MESLEK PROFİLİ ***********************************************************************//
$section = $phpWord->createSection(array('orientation'=>'landscape'));
//footer
$paraStyle = array('bold'=>true, 'align' => 'center');
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceAfter'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceAfter'=>0));
$footer = $section->createFooter();
$tfooter = $footer->addTable();
$tfooter->addRow();
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addRow();
$tfooter->addCell(8000,array('valign'=>'left'))->addText('© Mesleki Yeterlilik Kurumu, 2013',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$tfooter->addCell(8000,array('valign'=>'right'))->addPreserveText('Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle');
//$footer->addPreserveText('    © Mesleki Yeterlilik Kurumu, 2013               						        Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle' );
//footer Son
//header
$header = $section->createHeader();
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceAfter'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceAfter'=>0));
$theader = $header->addTable();
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText($adH.'('.$seviyeH.')',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText($kodH.' / '.$onayH.' / '.$revH,array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText('Ulusal Meslek Standardı',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText('Referans Kodu / Onay Tarihi / Rev. No',array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
//header Son

$phpWord->addParagraphStyle('YatayBasStyle', array('align'=>'left', 'spaceAfter'=>0, 'spaceBefore'=>0, 'spacing'=>0));
$section->addTitle('3.	MESLEK PROFİLİ',1);
$section->addTitle('3.1.	Görevler, İşlemler ve Başarım Ölçütleri',2);

//table Style
$phpWord->addFontStyle('tBasStyle', array('align'=>'center','bold'=>true, 'name'=>'Times New Roman', 'size'=>10));
$phpWord->addFontStyle('tIcStyle', array('align'=>'center','bold'=>false, 'name'=>'Times New Roman', 'size'=>10));
$phpWord->addFontStyle('tpStyle', array('align'=>'center'));

$gridSpan2 = array('gridSpan' => 2,'valign'=>'center','borderSize'=>6);
$TableMeslek = array('borderSize'=>2, 'borderColor'=>'000000', 'cellMargin'=>100);
$phpWord->addTableStyle('TableMeslek', $TableMeslek);

$space0Center = array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
$space0Left = array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
$space0Both = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);

$tableLetters = array ('A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Y','Z');
$html = "";
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
		$gorevArrDip [$gorevIndex]  = $arr["PROFIL_GOREV_DIPNOT"];
		$gorevIndex++;
	}else if ($arr["PROFIL_ISLEM_ADI"] != null){
		if ($islemParent != $arr["PARENT_ID"]){
			$arrIslemIndex = 0;
			$islemParent = $arr["PARENT_ID"];

			$islemArr [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
			$islemArrDip [$islemIndex][$arrIslemIndex]  = $arr["PROFIL_ISLEM_DIPNOT"];
			$arrIslemIndex++;
			$islemIndex++;
		}else{
			$islemArr [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_ADI"];
			$islemArrDip [($islemIndex-1)][$arrIslemIndex]  = $arr["PROFIL_ISLEM_DIPNOT"];
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
			$basarimParent = $arr["PARENT_ID"];

			$basarimArr [$basarimGorevIndex][$basarimIndex][$arrBasarimIndex++]  = $arr["PROFIL_BASARIM_OLCUT"];
			$basarimArrDip [$basarimGorevIndex][$basarimIndex][$arrBasarimIndex++]  = $arr["PROFIL_BASARIM_DIPNOT"];
			$basarimIndex++;
		}else{
			$basarimArr [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_OLCUT"];
			$basarimArrDip [$basarimGorevIndex][$basarimIndex-1][$arrBasarimIndex]  = $arr["PROFIL_BASARIM_DIPNOT"];
			$arrBasarimIndex++;
		}
	}
}

$devamiVar = array();
$i=0;
foreach ($basarimArr as $gorev){
	$j=0;
	$t=1;
	foreach ($gorev as $islem){

		if($t>24){
			$devamiVar[$i] = true;
			$t=0;
		}
		
		if(strlen($islemArr[$i][$j])>42){
			$t = $t + (int)($islemArr[$i][$j]/42);
		}
		
		$k=0;
		foreach ($islem as $basarim){
			if($t>24){
				$devamiVar[$i] = true;
				$t=0;
			}
				
			if(strlen($basarim)>93){
				$t = $t + (int)(strlen($basarim)/93);
			}
			$k++;
			$t++;
		}
			
		$j++;
	}

	$i++;
}


$i=0;
foreach ($basarimArr as $gorev){
	if($i!=0){
		$section = $phpWord->createSection(array('orientation'=>'landscape'));
	}
	$table = $section->addTable('TableMeslek');
	
	$table->addRow(null,array('tblHeader'=>true)); 
	$table->addCell(2600, $gridSpan2)->addText('Görevler','tBasStyle',$space0Left);
	$table->addCell(2600, $gridSpan2)->addText('İşlemler','tBasStyle',$space0Left);
	$table->addCell(8000, $gridSpan2)->addText('Başarım Ölçütleri','tBasStyle',$space0Left);
	$table->addRow(null,array('tblHeader'=>true));
	$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
	$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
	$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
	$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
	$table->addCell(500,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
	$table->addCell(7500,array('valign'=>'center','borderSize'=>6))->addText('Açıklama','tBasStyle',$space0Left);

	$table->addRow();
	$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i],'tBasStyle',$space0Left);
	if($devamiVar[$i]){
		$cellRun = $table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6));
		$cellRun->addText($gorevArr[$i],'tIcStyle',$space0Both);
		$cellRun->addText('(devamı var)',array('name'=>'Times New Roman', 'size'=>8),$space0Left);
// 		$statusCellTextRun = $cellRun->createTextRun();
// 		$statusCellTextRun->addText($gorevArr[$i],'tIcStyle',$space0Left);
// 		$statusCellTextRun->addText('(Devamı var.)',array('name'=>'Times New Roman', 'size'=>8),$space0Left);
		//$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($gorevArr[$i].'(Devamı var.)','tIcStyle',$space0Left);
	}
	else{
		$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($gorevArr[$i],'tIcStyle',$space0Both);
	}
	

// 	$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>0));
// 	$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>0));
// 	$table->addCell(500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>0));
// 	$table->addCell(8300,array('vMerge'=>'restart','valign'=>'center','borderSize'=>0));
	
	$Dipnot="";
	$gorevRowSpan = 0;
	$islemBasarimHtml = "";
	if ($gorevArrDip[$i]!=""){
		$Dipnot .='<strong>'.$tableLetters[$i].': </strong>'.$gorevArrDip[$i].'<br>';
	}
	$j=0;
	$t=1;
	foreach ($gorev as $islem){
		
		if($t>24){
// 			$footNote = $section->addFootnote();
// 			$footNote->addText('Devamı var...');
			$section = $phpWord->createSection(array('orientation'=>'landscape'));
			$table = $section->addTable('TableMeslek');
		
			$table->addRow(null,array('tblHeader'=>true));
			$table->addCell(2600, $gridSpan2)->addText('Görevler','tBasStyle',$space0Left);
			$table->addCell(2600, $gridSpan2)->addText('İşlemler','tBasStyle',$space0Left);
			$table->addCell(8000, $gridSpan2)->addText('Başarım Ölçütleri','tBasStyle',$space0Left);
			$table->addRow(null,array('tblHeader'=>true));
			$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
			$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
			$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
			$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
			$table->addCell(500,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
			$table->addCell(7500,array('valign'=>'center','borderSize'=>6))->addText('Açıklama','tBasStyle',$space0Left);
			$table->addRow();
			$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i],'tBasStyle',$space0Left);
			$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($gorevArr[$i],'tIcStyle',$space0Both);
			$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1),'tBasStyle',$space0Left);
			$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($islemArr[$i][$j],'tIcStyle',$space0Both);
			$t=0;
		}
		
		else if($j == 0){
			$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1),'tBasStyle',$space0Left);
			$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($islemArr[$i][$j],'tIcStyle',$space0Both);
		}else{
			$table->addRow();
			$table->addCell(100,array('vMerge'=>'fusion','borderSize'=>6));
			$table->addCell(2500,array('vMerge'=>'fusion','borderSize'=>6));
			$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1),'tBasStyle',$space0Left);
			$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($islemArr[$i][$j],'tIcStyle',$space0Both);
		}
		
		if(strlen($islemArr[$i][$j])>42){
			$t = $t + (int)($islemArr[$i][$j]/42);
		}
			
		$islemRowSpan = 0;
		$basarimHtml = "";
		if ($islemArrDip[$i][$j]!=""){
			$Dipnot.='<strong>'.$tableLetters[$i].'.'.($j+1).'</strong>: '.$islemArrDip[$i][$j].'<br>';
		}
		$k=0;
		foreach ($islem as $basarim){
			if ($basarimArrDip[$i][$j][$k+1]!=""){
				$Dipnot.="<strong>".$tableLetters[$i].'.'.($j+1).'.'.($k+1)."</strong>: ".$basarimArrDip[$i][$j][$k+1]."<br>";
			}
			if($t>24){
// 				$footNote = $section->addFootnote();
// 				$footNote->addText('Devamı var...');
				$section = $phpWord->createSection(array('orientation'=>'landscape'));
				$table = $section->addTable('TableMeslek');
				
				$table->addRow(null,array('tblHeader'=>true));
				$table->addCell(2600, $gridSpan2)->addText('Görevler','tBasStyle',$space0Left);
				$table->addCell(2600, $gridSpan2)->addText('İşlemler','tBasStyle',$space0Left);
				$table->addCell(8000, $gridSpan2)->addText('Başarım Ölçütleri','tBasStyle',$space0Left);
				$table->addRow(null,array('tblHeader'=>true));
				$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
				$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
				$table->addCell(100,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
				$table->addCell(2500,array('valign'=>'center','borderSize'=>6))->addText('Adı','tBasStyle',$space0Left);
				$table->addCell(500,array('valign'=>'center','borderSize'=>6))->addText('Kod','tBasStyle',$space0Left);
				$table->addCell(7500,array('valign'=>'center','borderSize'=>6))->addText('Açıklama','tBasStyle',$space0Left);
				$table->addRow();
				$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i],'tBasStyle',$space0Left);
				$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($gorevArr[$i],'tIcStyle',$space0Both);
				$table->addCell(100,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1),'tBasStyle',$space0Left);
				$table->addCell(2500,array('vMerge'=>'restart','valign'=>'center','borderSize'=>6))->addText($islemArr[$i][$j],'tIcStyle',$space0Both);
				$table->addCell(500,array('borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1).'.'.($k+1),'tBasStyle',$space0Left);
				$table->addCell(8300,array('borderSize'=>6))->addText($basarim,'tIcStyle',$space0Both);
				$t=0;
			}
			else if ($k == 0){
				$table->addCell(500,array('borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1).'.'.($k+1),'tBasStyle',$space0Left);
				$table->addCell(8300,array('borderSize'=>6))->addText($basarim,'tIcStyle',$space0Both);
					
			}else{
				$table->addRow();
				$table->addCell(100,array('vMerge'=>'fusion','borderSize'=>6));
				$table->addCell(2500,array('vMerge'=>'fusion','borderSize'=>6));
				$table->addCell(100,array('vMerge'=>'fusion','borderSize'=>6));
				$table->addCell(2500,array('vMerge'=>'fusion','borderSize'=>6));
				$table->addCell(500,array('borderSize'=>6))->addText($tableLetters[$i].'.'.($j+1).'.'.($k+1),'tBasStyle',$space0Left);
				$table->addCell(8300,array('borderSize'=>6))->addText($basarim,'tIcStyle',$space0Both);
			}
			
			if(strlen($basarim)>93){
				$t = $t + (int)(strlen($basarim)/93);
			}
			$k++;
			$t++;
		}
			
		$j++;
	}


	if ($Dipnot!=""){
		$html.='<strong>Dipnotlar</strong><br><small>'.$Dipnot.'</small>';
	}
	$html.='<br /><br />';
	
	$i++;
}

//**************************************************************** MESLEK PROFİLİ SON 3.1 *****************************************************************//

//**************************************************************** MESLEK PROFİLİ 3.2 *****************************************************************//
$section = $phpWord->createSection(array('orientation'=>'portrait'));

//footer
$paraStyle = array('bold'=>true, 'align' => 'center');
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceAfter'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceAfter'=>0));
$footer = $section->createFooter();
$tfooter = $footer->addTable();
$tfooter->addRow();
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addCell(8000,array('borderTopColor' => '400000', 'borderTopSize' => 20))->addText('',array(),array('spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0));
$tfooter->addRow();
$tfooter->addCell(8000,array('valign'=>'left'))->addText('© Mesleki Yeterlilik Kurumu, 2013',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$tfooter->addCell(8000,array('valign'=>'right'))->addPreserveText('Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle');
//$footer->addPreserveText('    © Mesleki Yeterlilik Kurumu, 2013               						        Sayfa {PAGE}',array('name'=>'Times New Roman', 'size'=>11), 'rightHeadStyle' );
//footer Son

//header
$header = $section->createHeader();
$phpWord->addParagraphStyle('leftHeadStyle', array('align'=>'left', 'spaceAfter'=>0));
$phpWord->addParagraphStyle('rightHeadStyle', array('align'=>'right', 'spaceAfter'=>0));
$theader = $header->addTable();
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText($adH.'('.$seviyeH.')',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText($kodH.' / '.$onayH.' / '.$revH,array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
$theader->addRow();
$theader->addCell(8000,array('valign'=>'left'))->addText('Ulusal Meslek Standardı',array('name'=>'Times New Roman', 'size'=>11),'leftHeadStyle');
$theader->addCell(8000,array('valign'=>'right'))->addText('Referans Kodu / Onay Tarihi / Rev. No',array('name'=>'Times New Roman', 'size'=>11),'rightHeadStyle');
//header Son
$section->addTitle('3.2.	Kullanılan Araç, Gereç ve Ekipman',2);
$space75Left = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>75);
if ($ekipman != null){
	$i = 1;
	foreach ($ekipman as $row){
		if($i>9){
			$section->addText($i.'. '.$row["EKIPMAN_ADI"],'rIcStyle',$space75Left);
		}else{
			if(count($ekipman)>9){
				$section->addText($i.'.   '.$row["EKIPMAN_ADI"],'rIcStyle',$space75Left);
			}else{
				$section->addText($i.'.  '.$row["EKIPMAN_ADI"],'rIcStyle',$space75Left);
			}
		}
		$i++;
	}
}
//**************************************************************** MESLEK PROFİLİ 3.2 *****************************************************************//

//**************************************************************** MESLEK PROFİLİ 3.3 *****************************************************************//
$section->addTitle('3.3.	Bilgi ve Beceriler',2);
if ($bilgiBeceri != null){
	$i = 1;
	foreach ($bilgiBeceri as $row){
		if($i>9){
			$section->addText($i.'. '.$row["BILGI_BECERI_ADI"],'rIcStyle',$space75Left);
		}else{
			if(count($bilgiBeceri)>9){
				$section->addText($i.'.   '.$row["BILGI_BECERI_ADI"],'rIcStyle',$space75Left);
			}else{
				$section->addText($i.'.  '.$row["BILGI_BECERI_ADI"],'rIcStyle',$space75Left);
			}
			
		}
		
		$i++;
	}
}
//**************************************************************** MESLEK PROFİLİ 3.3 SON*****************************************************************//

//**************************************************************** MESLEK PROFİLİ 3.4 *****************************************************************//
$section->addTitle('3.4.	 Tutum ve Davranışlar',2);
if ($tutumDavranis != null){
	$i = 1;
	foreach ($tutumDavranis as $row){
		if($i>9){
			$section->addText($i.'. '.$row["TUTUM_DAVRANIS_ADI"],'rIcStyle',$space75Left);
		}else{
			if(count($tutumDavranis)>9){
				$section->addText($i.'.   '.$row["TUTUM_DAVRANIS_ADI"],'rIcStyle',$space75Left);
			}else{
				$section->addText($i.'.  '.$row["TUTUM_DAVRANIS_ADI"],'rIcStyle',$space75Left);
			}
			
		}
		$i++;
	}
}
//**************************************************************** MESLEK PROFİLİ 3.4 SON*****************************************************************//

//**************************************************************** 4.	ÖLÇME, DEĞERLENDİRME VE BELGELENDİRME *****************************************************************//
$section = $phpWord->createSection(array('orientation'=>'portrait'));
$section->addTitle('4.	ÖLÇME, DEĞERLENDİRME VE BELGELENDİRME',1);
$section->addText(FormFactory::ucwordsTR($data["STANDART_ADI"])." (".$data["SEVIYE_ADI"].") meslek standardını esas alan ulusal yeterliliklere göre belgelendirme amacıyla yapılacak ölçme ve değerlendirme, gerekli şartların sağlandığı ölçme ve değerlendirme merkezlerinde yazılı ve/veya sözlü teorik ve uygulamalı olarak gerçekleştirilecektir.",'rIcStyle',$space75Left);
$section->addText("Ölçme ve değerlendirme yöntemi ile uygulama esasları bu meslek standardına göre hazırlanacak ulusal yeterliliklerde detaylandırılır. Ölçme ve değerlendirme ile belgelendirmeye ilişkin işlemler Mesleki Yeterlilik, Sınav ve Belgelendirme Yönetmeliği çerçevesinde yürütülür.",'rIcStyle',$space75Left);
//**************************************************************** 4.	ÖLÇME, DEĞERLENDİRME VE BELGELENDİRME SON*****************************************************************//

//*************************************************************** EK ************************************************************************//
if (isset($gorevAlan[0]) || isset($gorevAlan[1]) || isset($gorevAlan[2]) || isset($gorevAlan[3]) || isset($yonetimKurulu) || isset($gorevAlan[5])){
	$section = $phpWord->createSection(array('orientation'=>'portrait'));
	$space75Both = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>75);
	$space150Both = array('align'=>'both','spaceBefore'=>150,'spaceAfter'=>0,'spacing'=>150);
	$phpWord->addFontStyle('rEkIcBasStyle', array('name'=>'Times New Roman', 'size'=>12,'bold'=>true));
	$textrun = $section->createTextRun();
	$textrun->addText("Ek: ", 'rEkIcBasStyle');
	$textrun->addText("Meslek Standardı Hazırlama Sürecinde Görev Alanlar", 'rIcBasStyle');
	
	$section->addText("1. Meslek Standardı Hazırlayan Kuruluşun Meslek Standardı Ekibi",'rIcBasStyle',$space150Both);
	
	if (isset($gorevAlan) && $gorevAlan[0]!= null){
		foreach ($gorevAlan[0] as $row){
			$gorevalanunvan="";
			$gorevalankurulus="";
			$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
			$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
			//echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
			
			$textrun = $section->createTextRun($space75Both);
			$textrun->addText($row["GOREV_ALAN_AD_SOYAD"], 'rIcStyle');
			$textrun->addText($gorevalankurulus.$gorevalanunvan, 'rIcStyle');
		}
	}
	
	$section->addText("2. Teknik Çalışma Grubu Üyeleri",'rIcBasStyle',$space150Both);
	if (isset($gorevAlan) && $gorevAlan[1]!= null){
		foreach ($gorevAlan[1] as $row){
			$gorevalanunvan="";
			$gorevalankurulus="";
			$gorevalanunvan = ($row["GOREV_ALAN_UNVAN"]!="") ? (" - ".$row["GOREV_ALAN_UNVAN"]): "";
			$gorevalankurulus = ($row["GOREV_ALAN_KURULUS"]!="") ? (", ".$row["GOREV_ALAN_KURULUS"]): "";
			//echo statikTabloLightHTML ($row["GOREV_ALAN_AD_SOYAD"], $gorevalankurulus.$gorevalanunvan);
			
			$textrun = $section->createTextRun($space75Both);
			$textrun->addText($row["GOREV_ALAN_AD_SOYAD"], 'rIcStyle');
			$textrun->addText($gorevalankurulus.$gorevalanunvan, 'rIcStyle');
		}
	}

	
	$section->addText("3. Görüş İstenen Kişi, Kurum ve Kuruluşlar",'rIcBasStyle',$space150Both);
	if (isset($gorevAlan) && $gorevAlan[2]!= null){
		foreach ($gorevAlan[2] as $row){
			$ad	= "";
			$unvan = "";
			if ($row["GOREV_ALAN_AD_SOYAD"] != "")
				$ad = $row["GOREV_ALAN_AD_SOYAD"]." - ";
			if ($row["GOREV_ALAN_UNVAN"] != "")
				$unvan = $row["GOREV_ALAN_UNVAN"]." , ";

			//echo statikTabloLightHTML ($ad, $unvan.$row["GOREV_ALAN_KURULUS"]);
			
			$textrun = $section->createTextRun($space75Both);
			$textrun->addText($ad, 'rIcStyle');
			$textrun->addText($unvan.$row["GOREV_ALAN_KURULUS"], 'rIcStyle');
			}
		}
	
	
	$section->addText("4. MYK Sektör Komitesi Üyeleri ve Uzmanlar",'rIcBasStyle',$space150Both);
	if (isset($gorevAlan) && $gorevAlan[3]!= null){
		echo "<table cellpadding=0><tbody>";
		foreach ($gorevAlan[3] as $row){
			/// kurulus adi parantez icinde:
			//echo statikTabloLighttdHTML2 ($row["GOREV_ALAN_AD_SOYAD"].", ", $row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")");
			$textrun = $section->createTextRun($space75Both);
			$textrun->addText($row["GOREV_ALAN_AD_SOYAD"].", ", 'rIcStyle');
			$textrun->addText($row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")", 'rIcStyle');
		}
		echo "</tbody></table>";
	}

	$section->addText("5. MYK Yönetim Kurulu",'rIcBasStyle',$space150Both);
	if ($yonetimKurulu!= null){
		echo "<table cellpadding=0>";
		foreach ($yonetimKurulu as $row){
			/// kurulus adi parantez icinde:
			$textrun = $section->createTextRun($space75Both);
			$textrun->addText($row["GOREV_ALAN_AD_SOYAD"].", ", 'rIcStyle');
			$textrun->addText($row["GOREV_ALAN_UNVAN"]." (".$row["GOREV_ALAN_KURULUS"].")", 'rIcStyle');
		}
	}
}
//*************************************************************** EK SON ************************************************************************//

function NormalTextExplode($text){
	return explode("\n",$text);
}
// SON KISIM

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;');
header('Content-Disposition: attachment;filename="'.$std.'-'.$seviyeId.'.docx"');
header('Cache-Control: max-age=0');

// output the file to the browser
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');
exit; //you must have the exit!
?>