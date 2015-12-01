<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->taslaklar;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir onaylanmış taslak bulunmamaktadır.</div>';
}
else{
	
?>

<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-date-dmy">Yeterlilik Adı</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Sektör</th>
		<th class="sortable-text">Başlangıç Tarihi</th>
		<?php 
		if ($this->sektorSorumlusu){
			echo "<th>Taslağa Git</th>";
			echo "<th>".JText::_("SEKTOR_SORUMLUSU_GIRECEGI_BILGILER")."</th>";
		}
		?>
		<th>PDF</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$user_browser = browser_detection('browser');
		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			$pdfOlusturUrl = "index.php?option=com_yeterlilik_taslak&layout=tum_basvuru&format=pdf&form=5&id=".$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'];
			$pdfIndirUrl = "index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=4&yeterlilik_id=".$satir['YETERLILIK_ID'];			
			
			if(isset($satir['SON_TASLAK_PDF']) && !empty($satir['SON_TASLAK_PDF']))
				$pdfUrl = $pdfIndirUrl;
			else
				$pdfUrl = $pdfOlusturUrl;
			
			if (strripos($user_browser, 'msie') !== FALSE) {
				$clickHTML = 'target="_blank" href="'.$pdfUrl.'"';
			} else {                     
				$clickHTML = 'onclick="window.open(\''.$pdfUrl.'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
			}	
					
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
			echo '<td>'.$satir['BASLANGIC_TARIHI_FORMATTED'].'</td>';			
			if ($this->sektorSorumlusu){
				echo '<td><a href="index.php?option=com_yeterlilik_taslak&layout=tanitim&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Git</a></td>';
				echo '<td><a href="index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Git</a></td>';
			}	
			echo '<td><a '.$clickHTML.' rel="nofollow" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<?php
}

?>

