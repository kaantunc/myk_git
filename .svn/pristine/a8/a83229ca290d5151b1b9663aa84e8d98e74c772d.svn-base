<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');

require_once('libraries/form/captcha.php');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$itemId = JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&Itemid='.$itemId) : '';

$gorev = isset($_POST['kimlik_no']) ? "ara" : "pdf";

if($gorev == "ara"){
	captcha::check("index.php?option=com_chronocontact&Itemid=194");
	$kimlikNo = $_POST['kimlik_no'];
	$sonuclar = kimlikNoIleAra($kimlikNo);
	formGoster($sonuclar, $itemIdStr);
}
else if($gorev=="pdf"){
	$sertifikaId = $_GET['sertifikaId'];
	$sayfa = $_GET['sayfa'];

$sertifikaPath = getSertifikaPath($sertifikaId, $sayfa);
if($sertifikaPath != NULL)
	pdfGoster($sertifikaPath);
}
function formGoster($sonuclar, $itemIdStr){
//	echo '<pre>';
//	print_r($sonuclar);
//	echo '</pre>';
	
	if(empty($sonuclar)){
		?>
		<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>
		<br />
		<a href="index.php?option=com_chronocontact<?php echo $itemIdStr?>">Geri</a>
		<?php	
	}
	else{
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-text">Sertifika No</th>
				<th class="sortable-text">Ön Yüz PDF</th>
				<th class="sortable-text">Arka Yüz PDF</th>
				<th class="sortable-date-dmy">Oluşturulma Tarihi</th>
				<th class="sortable-date-dmy">Geçerlilik Tarihi</th>
			</tr>
			
			<?php
				$rowCount=1;
				$rowClass="";
				foreach($sonuclar AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';
					//echo '<td> <a href="'.$satir['SERTIFIKA_PATH'].'">Sertifika Adı'.$rowCount.'</a></td>';
					echo '<td>'.$satir['SERTIFIKA_NO'].'</td>';
					echo '<td> <a href="index.php?option=com_sertifika_ara&sertifikaId='.$satir['EVRAK_ID'].'&sayfa=on">Ön Yüz</a></td>';
					echo '<td> <a href="index.php?option=com_sertifika_ara&sertifikaId='.$satir['EVRAK_ID'].'&sayfa=arka">Arka Yüz</a></td>';
					echo '<td>'.($satir['OLUSTURMA_TARIHI']?$satir['OLUSTURMA_TARIHI']:"nsbp;").'</td>';
					echo '<td>'.($satir['GECERLILIK_TARIHI']?$satir['GECERLILIK_TARIHI']:"nsbp;").'</td>';					
					echo '</tr>';
					$rowCount++;
				}
			?>
		</table>
		</div>
		<a href="index.php?option=com_chronocontact<?php echo $itemIdStr?>">Geri</a>
		<?php
	}
}

function kimlikNoIleAra($kimlikNo){
	$db = & JFactory::getOracleDBO();
	
	$sql = "SELECT 	EVRAK_ID,
					SERTIFIKA_NO,
					TO_CHAR(SERTIFIKA_DUZENLEME_TARIHI, 'DD.MM.YYYY') AS OLUSTURMA_TARIHI,
					TO_CHAR(SERTIFIKA_GECERLILIK_TARIHI, 'DD.MM.YYYY') AS GECERLILIK_TARIHI
			FROM m_sertifika 
			WHERE tc_kimlik = ? AND
				sertifika_durum_id = ".ARA_SERTIFIKA_DURUM_ID."
			ORDER BY SERTIFIKA_DUZENLEME_TARIHI DESC";
		
	return $db->prep_exec($sql, array($kimlikNo));	
}


function getSertifikaPath($id, $sayfa){
	$db = & JFactory::getOracleDBO();
	
	$sql = "SELECT 	SERTIFIKA_PATH, SERTIFIKA_PATH2
			FROM m_sertifika 
			WHERE EVRAK_ID = ? AND
				sertifika_durum_id = ".ARA_SERTIFIKA_DURUM_ID;
	
	$results = $db->prep_exec($sql, array($id));
	
	//echo '<pre>';
	//print_r($results);
	//echo '</pre>';
	
	if(isset($results[0])){
	
		if($sayfa == "on")
			$realPath = $results[0]['SERTIFIKA_PATH'];
		else if ($sayfa == "arka")
			$realPath = $results[0]['SERTIFIKA_PATH2'];
		
		$virtualPath = "Y:/";
		
		$virtualPath .= substr($realPath, strpos($realPath, "upload")+strlen("upload")+1);
		
		return $virtualPath;
	}
	return 	NULL;
}

function pdfGoster($file){

// Define the parameters for the shell command
$location = "\\\\myk04\upload_mis";
$user = "Administrator";
$pass = "Mykb2mAZ14";
$letter = "Y";

// Map the drive
system("net use ".$letter.": \"".$location."\" ".$pass." /user:".$user." /persistent:no");
//echo "net use ".$letter.": \"".$location."\" ".$pass." /user:".$user." /persistent:no";
	//echo '-<pre>';
//print_r($rv);
	//echo '</pre>-';

// Open the directory
//$dir = opendir($letter.":/");

	if (file_exists($file)) {
	//	echo "exits.";
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}

}
?>