<?php

include_once 'libraries/php-excel-v1.1/php-excel.class.php';
// defined( '_JEXEC' ) or die( 'Restricted access' );
// if (!headers_sent()) {
// 	header_remove();
// }

// // Redirect output to a client’s web browser (Excel2007)
// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// header("Content-Disposition: attachment; filename=BelgelendirmeExceli.xls");  //File name extension was wrong
// header("Expires: 0");
// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// header("Cache-Control: private",false);

$belgeAdayExcel = $this->belgeAdayExcel[0];
$yetkili = $this->belgeAdayExcel[1];
$kurData = $this->belgeAdayExcel[2];

 
$data = array(
        1 => array ('Belge No', 'T.C. No', 'Ad','Soyad','Yeterlilik Kodu','Yeterlilik Adı','Yeterlilik Seviyesi',
	        'Yeterlilik Yayınlanma Tarihi','Revizyon Tarihi','Revizyon No','Kuruluş Adı','Kuruluş Logo','MYK Markası','TURKAK Markası',
	        'MYK Markası Kodu','TURKAK Markası Kodu','Belge Düzenleme Tarihi','Belge Geçerlilik Tarihi','Kurulus Internet Sitesi','Imza Yetkilisi',
	        'Imza Yetkilisi Unvan','Yeterlilik Birimleri','KareKod Linki')
        );

foreach ($belgeAdayExcel as $belge){
$data[]	= array($belge['BELGENO'],$belge['TC_KIMLIK'],$belge['AD'],
	$belge['SOYAD'],
	$belge['YETERLILIK_KODU'],
	$belge['YETERLILIK_ADI'],
	'Seviye - '.$belge['YETERLILIK_SEVIYESI'],
	tarihAyarla($belge['YAYIN_TARIHI']),
	'-',
	$belge['REVIZYON'],
	$kurData['KURULUS_ADI'],
	$kurData['LOGO'],
	$kurData['MYK_MARKASI'],
	$kurData['TURKAK_MARKASI'],
	$kurData['KURULUS_YETKILENDIRME_NUMARASI'],
	$kurData['AKREDITASYON_NO'],
	$belge['BELGE_DUZENLEME_TARIHI'],
	$belge['GECERLILIK_TARIHI'],
	$kurData['KURULUS_WEB'],
	$yetkili['YETKILI_AD'].' '.$yetkili['YETKILI_SOYAD'],
	$yetkili['YETKILI_UNVAN'],
	str_replace('/', '#', $belge['BELGENO']).'.txt',
	str_replace('/', '#', $belge['BELGENO']).'.png',);
}

function tarihAyarla($tarih){
	$dat = explode(' ',$tarih);
	return $dat[0];
}

function revizyonNoAyarla($rev){
	if(strlen($rev)>1){
		return (string)$rev;
	}else{
		return '0'.(string)$rev;
	}
}

$xls = new Excel_XML('UTF-8', false, 'My Test Sheet');
$xls->addArray($data);
$xls->generateXML('my-test');
exit();
?>