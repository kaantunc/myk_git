<?php

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');

require_once('libraries'.DS.'form'.DS.'form.php');

if(!FormFactory::akreditasyonKurulusumu()){
	global $mainframe;
	$mainframe->redirect('index.php', JText::_('AKREDITASYON_YETKINIZ_YOK'), "error");
}

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$gorev = JRequest::getVar('gorev');

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&Itemid='.$itemId) : '';

function akreditasyonKurulusumu(){
    $user_id = JFactory::getUser()->getOracleUserId();
    $db = & JFactory::getOracleDBO();
    
    $sql = "SELECT KURULUS_DURUM_ID FROM M_KURULUS WHERE USER_ID = ?";
    
    $durumIdler = $db->prep_exec($sql, array($user_id));
    
    if(isset($durumIdler)){
    	if($durumIdler[0]['KURULUS_DURUM_ID'] == 8)
    		return true;
    	else
    		return false;
    }
    
}
?>
<div class="sinavGirisBaslik">Yetkilendirilmiş Kuruluşlar</div>
<?php

if($gorev == "goster" || $gorev == ''){
	formGoster($itemIdStr);
}
else if($gorev == "kurulus_adi"){
	adIleListele($itemIdStrOrj);
}

function formGoster($itemIdStr){
	$db = & JFactory::getOracleDBO();
	?>
	
	<form action="?option=com_akredite_kurulus_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="kurulus_adi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Ada göre ara</td>
				<td width="130px"><input type="text" name="kurulus_adi" /></td>
				<td><input type="submit" value="Ara"></td>
			</tr>
		</table>
	</form>
	<form action="?option=com_akredite_kurulus_ara<?php echo $itemIdStr?>" method="post">
		<input type="hidden" value="kurulus_adi" name="gorev" />
		<table>
			<tr>
				<td width="150px">Tümünü Listele</td>
				<td colspan="2"><input type="submit" value="Listele"></td>
			</tr>
		</table>
	</form>
	<?php
}

function adIleListele($itemIdStrOrj){
	
	//$kurulus_adi = isset($_POST['kurulus_adi']) ? $_POST['kurulus_adi'] : ''; 
	
	$kurulus_adi = JRequest::getVar('kurulus_adi');
	
	$db = & JFactory::getOracleDBO();
	$sonuclar = adIleAra($db, $kurulus_adi);
	listele($sonuclar, $itemIdStrOrj);
	
}

function listele($sonuclar, $itemIdStrOrj){
	//$standartAdi = $_POST['standart_adi'];// POST OLACAK
		
	//echo $standartAdi;
	//echo '<pre>';
	//print_r($sonuclar);
	//echo '</pre>';
	
	if(empty($sonuclar)){
		
		echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
		echo '<br /><a href="index.php?option=com_akredite_kurulus_ara'.$itemIdStrOrj.'">Geri</a>';
		
	}
	else{
		?>
		<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-text">Kuruluş Adı</th>
				<th class="sortable-text">Yetkili</th>
				<th class="sortable-text">Yetkisi</th>
				<th class="sortable-text">Sil?</th>
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
					echo '<td>'.$satir['KURULUS_ADI'].'</td>';
					$yetkili = $satir['KURULUS_YETKILISI'] ? $satir['KURULUS_YETKILISI'] : "-";
					echo '<td>'.$yetkili.'</td>';
					$yetkisi = $satir['AKREDITE_YETKI_ADI'] ? $satir['AKREDITE_YETKI_ADI'] : "-";
					echo '<td>'.$yetkisi.'</td>';
					echo '<td><a href="index.php?option=com_akreditasyon&task=kurulusSil&kurulusId='.$satir['USER_ID'].'">Sil</a></td>';
					
					echo '</tr>';
					$rowCount++;
				}
			
			
			?>
			
		</table>
		</div>
		<a href="index.php?option=com_akredite_kurulus_ara<?php echo $itemIdStrOrj?>">Geri</a>
		<?php
	}

}

//function adIleAra($db, $kurulusAdi){
//		
//	$userId = JFactory::getUser()->getOracleUserId();
//	
//	$sql = "SELECT DISTINCT   KURULUS_ADI,
//					KURULUS_YETKILISI,
//					YETKILENDIRME_NUMARASI,
//					AKREDITE_YETKI_ADI
//        FROM M_AKREDITE_KURULUS_YETKI
//	    NATURAL JOIN PM_AKREDITE_YETKI
//	    JOIN M_AKREDITASYON USING (AKREDITASYON_ID)
//	    JOIN M_BASVURU ON (M_AKREDITASYON.EVRAK_ID = M_BASVURU.EVRAK_ID)
//	    JOIN M_KURULUS ON (M_AKREDITE_KURULUS_YETKI.USER_ID = M_KURULUS.USER_ID)
//	    WHERE M_BASVURU.USER_ID = ? AND UPPER(KURULUS_ADI) LIKE ?";
//	
//	return $db->prep_exec($sql, array($userId, "%".strtoupper($kurulusAdi)."%"));
//	
//}
function adIleAra($db, $kurulusAdi){
		
	$userId = JFactory::getUser()->getOracleUserId();
		
	$sql = "SELECT DISTINCT  USER_ID, KURULUS_ADI,
					KURULUS_YETKILISI,
					AKREDITE_YETKI_ADI
        FROM M_AKREDITE_KURULUS_YETKI
	    LEFT JOIN PM_AKREDITE_YETKI USING (AKREDITE_YETKI_ID)
	    JOIN M_KURULUS ON (DENETLENEN_KURULUS_ID = M_KURULUS.USER_ID)
	    WHERE DENETCI_KURULUS_ID = ? AND TURKCE_UPPER(KURULUS_ADI) LIKE TURKCE_UPPER(?)";
	
	return $db->prep_exec($sql, array($userId, "%".$kurulusAdi."%"));
	
}
?>
