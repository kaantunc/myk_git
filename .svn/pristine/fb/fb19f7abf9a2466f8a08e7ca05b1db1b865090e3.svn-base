<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once("libraries/joomla/utilities/browser_detection.php");
require_once('libraries/form/captcha.php');
//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		//MS Sektor Sorumlusu mu?
		$user	 =& JFactory::getUser();
		$group_id   = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		if (!$aut)
			$mainframe->redirect('index.php?', $message);	
		/////////////////////////////////////////////////////////////////////////////////

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$baslik = "Meslek Standartları İstatistikleri";
?>
<style type="text/css">
<!--
table tr th{font-size: 10px}
-->
</style>
<div class="sinavGirisBaslik"><?php echo $baslik;?></div>
<?php

$gorev = isset($_POST['gorev']) ? $_POST['gorev'] : "goster";

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';




hepsiIleListele();


function hepsiIleListele(){
	$db = & JFactory::getOracleDBO();	
	$sonuclar = hepsiIleAra($db);
	listele($sonuclar);
}

function listele($sonuclar){

	if(empty($sonuclar)){

		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';

	}
	else{
		?>
<div >
<table cellspacing="0" class="paginate-100 sortable" border="1">
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-numeric">Kuruluş Adı</th>
		<th class="sortable-numeric">Sektör</th>
		<th class="sortable-numeric">Protokol Kapsamında Yer Alanlar</th>
		<th class="sortable-numeric">Kuruluşca Çalışılanlar</th>
		<th class="sortable-numeric">Görüş Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Görüş Değerlendirme Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">İptal Edilenler</th>
		<th class="sortable-numeric">Sektör Komitesi Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Yönetim Kurulu Aşamasında Bulunanlar</th>
		<th class="sortable-numeric">Yayınlanmak Üzere Gönderilenler</th>
		<th class="sortable-numeric">Resmi Gazetede Yayımlananlar</th>
	</tr>
		<?php }?>
	

	<?php
	$user_browser = browser_detection('browser');
	$rowCount=1;
	$rowClass="";
	$sumPKS=0;
	$sumKTCD=0;
	$sumGA=0;
	$sumGDA=0;
	$sumIEM=0;
	$sumSKA=0;
	$sumYKA=0;
	$sumYUG=0;
	$sumRGY=0;

	foreach($sonuclar AS $yetki){
		foreach($yetki as $sonuc){
			foreach($sonuc as $satir){
		
			
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				echo '<tr class="'.$rowClass.'" >';
			
				echo '<td style="font-size:10px;">'.$rowCount.'</td>';
				echo '<td style="font-size:10px;">'.$satir['KURULUS_ADI'].'</td>';
				echo '<td style="font-size:10px;">'.$satir['SEKTOR_ADI'].'</td>';
				echo '<td>'.$satir['PKS'].'</td>';
				echo '<td>'.$satir['KTCD'].'</td>';
				echo '<td>'.$satir['GA'].'</td>';
				echo '<td>'.$satir['GDA'].'</td>';
				echo '<td>'.$satir['IEM'].'</td>';
				echo '<td>'.$satir['SKA'].'</td>';
				echo '<td>'.$satir['YKA'].'</td>';
				echo '<td>'.$satir['YUG'].'</td>';
				echo '<td>'.$satir['RGY'].'</td>';
				
				echo '</tr>';
					$rowCount++;
			
				
				$sumPKS=$sumPKS+$satir['PKS'];
				$sumKTCD=$sumKTCD+$satir['KTCD'];
				$sumGA=$sumGA+$satir['GA'];
				$sumGDA=$sumGDA+$satir['GDA'];
				$sumIEM=$sumIEM+$satir['IEM'];
				$sumSKA=$sumSKA+$satir['SKA'];
				$sumYKA=$sumYKA+$satir['YKA'];
				$sumYUG=$sumYUG+$satir['YUG'];
				$sumRGY=$sumRGY+$satir['RGY'];
			}
		}
	}
	
	 

	?>
	

</table>	
<table cellspacing="0" border="1">
<?php 

$protokolKapsamindakiler = getProtokolKapsamindaStd();
$kuruluscaCalisilan = getKuruluscaCalisilanStd();
$countsFromTable = getStandartCount();

//echo '<tr><td><strong>TOPLAM</strong></td><td align="center"><strong>'.$protokolKapsamindakiler.'</strong></td>';
echo '<tr><td><strong>TOPLAM</strong></td><td align="center"><strong>'.$sumPKS.'</strong></td>';
echo '<td align="center"><strong>'.$sumKTCD.'</strong></td>';
for($i=0; $i<count($countsFromTable); $i++)
	echo '<td align="center"><strong>'.$countsFromTable[$i].'</strong></td>';



/*			<td align='center'><strong>".$protokolKapsamindakiler."</strong></td>
			<td align='center'><strong>".$kuruluscaCalisilan."</strong></td>
			<td align='center'><strong>".$sumGA."</strong></td>
			<td align='center'><strong>".$sumGDA."</strong></td>
			<td align='center'><strong>".$sumIEM."</strong></td>
			<td align='center'><strong>".$sumSKA."</strong></td>
			<td align='center'><strong>".$sumYKA."</strong></td>
			<td align='center'><strong>".$sumYUG."</strong></td>
			<td align='center'><strong>".$sumRGY."</strong></td>*/
echo '</tr>';
			?>

<tr class="tablo_header">
		
		<th  style="font-size:10px;">&nbsp;</th>
		<th  style="font-size:10px;">Protokol Kapsamında Yer Alanlar</th>
		<th  style="font-size:10px;">Kuruluşca Çalışılanlar</th>
		<th  style="font-size:10px;">Görüş Aşamasında</th>
		<th  style="font-size:10px;">Görüş Aşamasında Bulunanlar</th>
		<th  style="font-size:10px;">İptal Edilenler</th>
		<th  style="font-size:10px;">Sektör Komitesi Aşamasında Bulunanlar</th>
		<th  style="font-size:10px;">Yönetim Kurulu Aşamasında Bulunanlar</th>
		<th  style="font-size:10px;">Yayınlanmak Üzere Gönderildi</th>
		<th  style="font-size:10px;">Resmi Gazetede Yayımlananlar</th>
	</tr>
</table>		
</div>
	<?php
	}
	?>
<br />

	<?php


function  hepsiIleAra($db){

	
// 	$sql = "select KURULUS_ADI, SEKTOR_ADI,  count(*) AS PKS, sum (KTCD) as KTCD,SUM(GA) AS GA,SUM(GDA) AS GDA,SUM(IEM) AS IEM,SUM(SKA) AS SKA,SUM(YKA) AS YKA,SUM(YUG) AS YUG,sum(RGY) AS RGY from
// ( SELECT KURULUS_ADI,
//         STANDART_ADI,
//         SEKTOR_ADI,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (0,-2,-4) then 1 else 0 end as KTCD,
//         case when MESLEK_STANDART_SUREC_DURUM_ID=4 then 1 else 0 end as GA,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (6,7,8) then 1 else 0 end as GDA,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (-1,5,15) then 1 else 0 end as IEM,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (2,3,9,11) then 1 else 0 end as SKA,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (10,12) then 1 else 0 end as YKA,
//         case when MESLEK_STANDART_SUREC_DURUM_ID IN (1,13) then 1 else 0 end as YUG,
//         case when MESLEK_STANDART_SUREC_DURUM_ID=14 then 1 else 0 end as RGY
//   FROM M_MESLEK_STANDARTLARI 
                     
                        
//                         JOIN M_YETKI_STANDART ON (M_MESLEK_STANDARTLARI.STANDART_ID=M_YETKI_STANDART.STANDART_ID)
//                         JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_STANDART.YETKI_ID)
//                         JOIN M_KURULUS_YETKI ON (M_KURULUS_YETKI.YETKI_ID=M_YETKI.YETKI_ID)
//                         JOIN M_KURULUS ON (M_KURULUS.USER_ID=M_KURULUS_YETKI.USER_ID)
//                         JOIN PM_SEKTORLER ON (PM_SEKTORLER.SEKTOR_ID=M_MESLEK_STANDARTLARI.SEKTOR_ID)
                       
//   WHERE MESLEK_STANDART_SUREC_DURUM_ID<>-3 AND M_YETKI.ETKIN=1 AND M_YETKI.PROTOKOL_MU=1 AND YETKI_TURU=1  ORDER BY KURULUS_ADI, STANDART_ADI) group by KURULUS_ADI,SEKTOR_ADI order by KURULUS_ADI";
	
	$sql = "SELECT  M_KURULUS.USER_ID,
					M_YETKI_STANDART.YETKI_ID,
					M_MESLEK_STANDARTLARI.SEKTOR_ID,
					M_KURULUS.KURULUS_ADI, 
					PM_SEKTORLER.SEKTOR_ADI,
					M_MESLEK_STANDARTLARI.STANDART_ADI,
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID
 			  FROM M_MESLEK_STANDARTLARI 
              JOIN M_YETKI_STANDART ON (M_MESLEK_STANDARTLARI.STANDART_ID=M_YETKI_STANDART.STANDART_ID)
              JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_STANDART.YETKI_ID)
              JOIN M_KURULUS_YETKI ON (M_KURULUS_YETKI.YETKI_ID=M_YETKI.YETKI_ID)
              JOIN M_KURULUS ON (M_KURULUS.USER_ID=M_KURULUS_YETKI.USER_ID)
              JOIN PM_SEKTORLER ON (PM_SEKTORLER.SEKTOR_ID=M_MESLEK_STANDARTLARI.SEKTOR_ID)
             WHERE MESLEK_STANDART_SUREC_DURUM_ID<>-3 AND 
		           M_YETKI.ETKIN=1 AND 
		           M_YETKI.PROTOKOL_MU=1 AND 
		           YETKI_TURU=1  
          ORDER BY KURULUS_ADI";
	$params = array();
	$datas  = $db->prep_exec($sql, $params);
	
	$result = array();
	foreach($datas as $data){
		if(!array_key_exists($data['SEKTOR_ID'], $result[$data['USER_ID']][$data['YETKI_ID']])){
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KURULUS_ADI']  = $data['KURULUS_ADI'];
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SEKTOR_ADI']  = $data['SEKTOR_ADI'];
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD'] = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']   = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']  = 0;
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']  = 0;
		}
	
		if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '0' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-2' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-4'){
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD']++;
			
		}else if($data[$data['USER_ID']]['MESLEK_STANDART_SUREC_DURUM_ID'] == '4'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']++;
			
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '6' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '7' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '8'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']++;
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-1' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '5' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '15'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']++;
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '2' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '3' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '9' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '11'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']++;
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '10' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '12'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']++;
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '1' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '13'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']++;
		}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '14'){
			
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']++;
		}
		$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']++;
	}
	
	//$log->addEntry(array('LEVEL' => '1','STATUS' => 'SOME ERROR:','COMMENT' =>print_r($results,true)));
	
/*	if($db->isError())
	{
		$log->addEntry(array('LEVEL' => '1','STATUS' => 'SOME ERROR:','COMMENT' =>print_r($db->getErrorInfo(),true)));
		JError::raiseWarning( 500, "Bir hata Oluştu, hata Kodu: " . $db->getErrorCode() );
	}*/
  
	return $result;
}


function getProtokolKapsamindaStd()
{
	/*$titles = array('PROTOKOL_KAPSAMINDA', 'KURULUŞCA_ÇALIŞILAN', 'GÖRÜŞ_AŞAMASINDA',	'GÖRÜŞ_DEĞERLENDIRME_AŞAMASINDA',	'İPTAL_EDILDI',	'SEKTÖR_KOMITESI_AŞAMASINDA',	'YÖNETIM_KURULU_AŞAMASINDA','YAYINLANMAK_ÜZERE_GÖNDERILDI', 'RESMI_GAZETEDE_YAYINLANDI');
	$sqls = array(
	'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" FROM M_YETKI_STANDART',//protokol kapsamı
	'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" FROM M_MESLEK_STANDARTLARI WHERE MESLEK_STANDART_SUREC_DURUM_ID IN ('.PM_MESLEK_STANDART_SUREC_DURUMU__SEKTOR_SORUMLUSU_TARAFINDAN_INCELENIYOR.','.PM_MESLEK_STANDART_SUREC_DURUMU__KURULUSTAN_ISLAK_IMZALI_DOKUMAN_GONDERILMESI_BEKLENIYOR.')',		
	'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" FROM M_MESLEK_STANDARTLARI WHERE MESLEK_STANDART_SUREC_DURUM_ID = '.PM_MESLEK_STANDART_SUREC_DURUMU__RESMI_GORUSE/KAMUOYUNUN_GORUSUNE_SUNULDU ,		
	'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" FROM M_MESLEK_STANDARTLARI WHERE MESLEK_STANDART_SUREC_DURUM_ID = '.PM_MESLEK_STANDART_SUREC_DURUMU__KURULUSUN_GORUSLERI_YANSITMASI_BEKLENIYOR ,		
	'');*/	
	$db = & JFactory::getOracleDBO();
	
	$sql = 'SELECT COUNT(STANDART_ID) AS "COUNT" FROM M_YETKI_STANDART 
				
                JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_STANDART.YETKI_ID)
			WHERE  M_YETKI.PROTOKOL_MU=1 AND YETKI_TURU=1
			';
	$params = array();
	$result = $db->prep_exec($sql, $params);
	return $result[0]['COUNT'];
}

function getKuruluscaCalisilanStd()
{
	$db = & JFactory::getOracleDBO();

	$sql = 'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" 
	FROM M_MESLEK_STANDARTLARI JOIN M_TASLAK_MESLEK USING (STANDART_ID)
	JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_STANDART.YETKI_ID)
	WHERE MESLEK_STANDART_SUREC_DURUM_ID IN (0,-2,-4) AND M_YETKI.PROTOKOL_MU=1 AND YETKI_TURU=1';
	//AND MESLEK_STANDART_DURUM_ID IN ('.PM_MESLEK_STANDART_DURUMU__KURULUSCA_CALISILAN.')';
	 		
	$params = array();
	$result = $db->prep_exec($sql, $params);
	return $result[0]['COUNT'];
}

function getGorusAsamasindaStd()
{
	$db = & JFactory::getOracleDBO();

	$sql = 'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" FROM M_MESLEK_STANDARTLARI WHERE MESLEK_STANDART_SUREC_DURUM_ID = '.PM_MESLEK_STANDART_SUREC_DURUMU__RESMI_GORUSE_KAMUOYUNUN_GORUSUNE_SUNULDU;
	$params = array();
	$result = $db->prep_exec($sql, $params);
	return $result[0]['COUNT'];
}

function getStandartCount()
{
	$Durum_SurecDurum_Tablosu = array(
		//	array('-2, -1, -5, 0'	, '-2, 0, -4'), Kuruluşça çalışılanı toplayarak alalım bura yerine
			array('-2, -1, -5, 0'	, '4'),
			array('-2, -1, -5, 0'	, '8, 7,6'),
			array(			 '-4'	, '-1,5, 15'),
			array('-2, -1, -5, 0'	, '2, 3,11, 9'),
			array('-2, -1, -5, 0'	, '10, 12'),
			array(			  '1'	, '1, 13'),
			array(			  '2'	, '14'),

	);
	
	   
		
		
	for($i=0; $i<count($Durum_SurecDurum_Tablosu); $i++)
	{
		$db = & JFactory::getOracleDBO();
		
		$sql = 'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT" 
		FROM M_MESLEK_STANDARTLARI JOIN M_TASLAK_MESLEK USING (STANDART_ID) 
		WHERE  MESLEK_STANDART_SUREC_DURUM_ID IN ('.$Durum_SurecDurum_Tablosu[$i][1].')';
		$params = array();
		$result = $db->prep_exec($sql, $params);	
		$resultToReturn[] = $result[0]["COUNT"]; 
	}
	return $resultToReturn;
		
	
	
}
