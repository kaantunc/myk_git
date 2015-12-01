<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->yeterlilik;
//$listeDurum = $this->listeDurum;

// if (!$listeDurum){
// 	echo '<div class="sonucBulunamadi">Hazırlanacak Ulusal Yeterlilik listeniz, henüz Sektör Sorumlusu tarafından onaylanmamıştır.</div>';
// }
if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir taslak ön başvurusu bulunmamaktadır.</div>';
}
else{
?>

<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Sektör</th>
		<th class="sortable-text">Durum</th>
		<th>Formatı Görüntüle</th>
		<th>PDF</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$user_browser = browser_detection('browser');
		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			//
			$layout = "pdf";
			$option = "com_yeterlilik_taslak";
			$form	= YT2_BASVURU_TIP;
			$id		= "&yeterlilik_id=".$satir['YETERLILIK_ID'];
			if (strripos($user_browser, 'msie') !== FALSE) {
				$clickHTML = 'target="_blank" href="index.php?option='.$option.$id.'&layout='.$layout.'&format=pdf&form='.$form.'&id='.getOracleEvrakId($satir['YETERLILIK_ID']).'"';//$satir['EVRAK_ID']
			} else {                     
				$clickHTML = 'onclick="window.open(\'index.php?option='.$option.$id.'&layout='.$layout.'&format=pdf&form='.$form.'&id='.getOracleEvrakId($satir['YETERLILIK_ID']).'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
			}	
			//
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
			echo '<td>'.getEvrakDurumAdi ($satir['YETERLILIK_DURUM_ID']).'</td>';
			echo '<td><a href="index.php?option=com_yeterlilik_taslak&layout=tanitim&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Görüntüle</a> /
					  <a href="index.php?option=com_yeterlilik_taslak_yeni&layout=tanitim&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Görüntüle Yeni</a></td>';
			echo '<td><a '.$clickHTML.'><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<?php 
}

	function getEvrakDurumAdi ($yeterlilikDurumId){
		$durumAdi = "";
		if($yeterlilikDurumId==PM_YETERLILIK_DURUMU__OLUSTURULMAMIS_ONTASLAK)
		$durumAdi = JText::_("OLUSTURULMAMIS_ON_TASLAK");
		else if($yeterlilikDurumId == PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK)
		$durumAdi = JText::_("DEGISIKLIK_YAPILMIS_ON_TASLAK");
		else if($yeterlilikDurumId == PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK)
		$durumAdi = JText::_("INCELEMEYE_GONDERILMIS_ON_TASLAK");
		else if($yeterlilikDurumId==PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK)
		$durumAdi = JText::_("ONAYLANMIS_ON_TASLAK");
	
		return $durumAdi;
	}

	function getOracleEvrakId ($yeterlilikId){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT evrak_id 
			   FROM m_taslak_yeterlilik  
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilikId);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getEvrakDurumId ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT basvuru_sekli_id 
				FROM ".DB_PREFIX.".evrak 
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return false;
	}
?>