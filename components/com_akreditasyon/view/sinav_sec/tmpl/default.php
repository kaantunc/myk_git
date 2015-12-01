<?php
defined('_JEXEC') or die('Restricted access');


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->sinavlar;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">'.JText::_('SINAV_BILDIRIMI_YOK').'</div>';
}
else{


?>

<div class="tableWrapper">
<form action="?option=com_sinav&task=sertifikaBasvur" method="POST">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-date-dmy">Sınav Tarihi</th>
		<th class="sortable-text">Sınav Merkezi</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Sınav Türü</th>
		<th class="sortable-text">Sınav Şekli</th>
		<th class="sortable-numeric">Toplam Aday</th>
		<th class="sortable-text">Sonuç Gir</th>
		<th class="sortable-text">Sertifika İsteği</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		$checkBoxDisabled = "";
		foreach($sonuclar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.($satir['SINAV_TARIHI_FORMATTED']?$satir['SINAV_TARIHI_FORMATTED']:"&nsbp;").'</td>';
			echo '<td>'.($satir['MERKEZ_ADI']?$satir['MERKEZ_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['YETERLILIK_ADI']?$satir['YETERLILIK_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_TUR_ADI']?$satir['SINAV_TUR_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_SEKLI_ADI']?$satir['SINAV_SEKLI_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['TOPLAM_ADAY']?$satir['TOPLAM_ADAY']:"&nsbp;").'</td>';
			
			if(($satir['BASARILI_ADAY'] != BASARILI_ADAY_EKLENDI) && 
					($satir['BASARILI_ADAY'] != BASARILI_ADAY_EKLENMEDI)){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				echo '<td>'.JText::_('SERTIFIKA_BASVURUSU_YAPILMIS').'</td>';
			}
			else {
				if($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENMEDI){
					$checkBoxDisabled = 'disabled="disabled"';
					echo '<td><a href="?option=com_sinav&task=sinavSonucuGir&sinavId='.$satir['M_SINAV_ID'].'">Sonuç Gir</a></td>';
				}
				
				else{// BASARILI_ADAY_EKLENDI
					$checkBoxDisabled = '';
					//echo '<td>'.JText::_('SINAV_SONUC_GIRILMIS').'</td>';
					echo '<td><a href="?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				}
				
				echo '<td><input '.$checkBoxDisabled.' value="1" name="sertifika_'.$satir['M_SINAV_ID'].'" type="checkbox" /></td>';
			}
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
<div style="float: right; margin-top:4px">
<input type="submit" value=" Sertifika için Başvur">
</div>
<div style="clear: right"></div>

</form>
</div>
<?php
}
?>
