<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

$sonuclar = $this->yeterlilik;
//$listeDurum = $this->listeDurum;

// if (!$listeDurum){
// 	echo '<div class="sonucBulunamadi">Hazırlanacak Ulusal Yeterlilik listeniz, henüz Sektör Sorumlusu tarafından onaylanmamıştır.</div>';
// }else if(empty($sonuclar)){
// 	echo '<div class="sonucBulunamadi">Henüz hiçbir taslak ön başvurusu bulunmamaktadır.</div>';
// }
if (empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir taslak ön başvurusu bulunmamaktadır.</div>';
}
else{
?>
<style>
table tr{
	text-align:left;
} 
</style>
<div class="form_item" style="margin: 0 0 20px 0;">
  <div class="form_element cf_heading" style="margin:0;">
  	<h3 class="contentheading">Yeterlilik Ön Taslaklarım</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="tableWrapper">
<table cellspacing="0" id="ontaslaklarim">
	<thead>
	<tr class="tablo_header">
		<th class="sortable">#</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Yeterlilik Kodu</th>
		<th class="sortable-text">Seviye</th>
		<th class="sortable-text">Revizyon</th>
		<th class="sortable-text">Sektör</th>
		<th class="sortable-text">Durum</th>
		<th>Düzenle</th>
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
			
			$option = "com_yeterlilik_taslak_yeni";
				
			$form	= YT2_BASVURU_TIP;
			$id		= "&yeterlilik_id=".$satir['YETERLILIK_ID'];//"&yeterlilik_id=".getYeterlilikId($satir["EVRAK_ID"]);
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

			$satir['YETERLILIK_BILGISI'] = ($satir['YETERLILIK_KODU'] <> "" ? current(explode('-',$satir['YETERLILIK_KODU'])) : "...")."-".$satir['SEVIYE_ID']."/".$satir['REVIZYON'];
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.($satir['YETERLILIK_KODU'] <> "" ? $satir['YETERLILIK_KODU'] : "-").'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td>'.$satir['REVIZYON'].'</td>';
			echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
			echo '<td>'.$satir['YETERLILIK_DURUM_ADI'].'</td>';
			echo '<td><a href="index.php?option='.$option.'&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Düzenle</a></td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<script>
jQuery(document).ready(function(){
	jQuery('#ontaslaklarim').dataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
		});
});
</script>
<?php 
}

	function getEvrakDurumAdi ($yeterlilikId){
		$evrakId = getOracleEvrakId ($yeterlilikId);
		$evrakDurumId =	getEvrakDurumId ($evrakId);
		$evrakDurum		= "";
		
		if ($evrakDurumId){
			if ($evrakDurumId == KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID){
				$evrakDurum = JText::_("DEGISIKLIK_YAPILMIS_ON_TASLAK");
			}else if ($evrakDurumId == ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID){
				$evrakDurum = JText::_("INCELEMEYE_GONDERILMIS_ON_TASLAK");
			}else if ($evrakDurumId == KAYDEDILMEMIS_BASVURU_SEKLI_ID){
				$evrakDurum = JText::_("ONAYLANMIS_ON_TASLAK");
			}
		}else{
			$evrakDurum = JText::_("OLUSTURULMAMIS_ON_TASLAK");
		}
	
		return $evrakDurum;
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