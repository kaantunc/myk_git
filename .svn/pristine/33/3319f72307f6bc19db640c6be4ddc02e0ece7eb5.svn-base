<?php
defined('_JEXEC') or die('Restricted access');

$sonuclar = $this->goruslerAyrinti;


//    		echo 'data: <pre>';
//			print_r($sonuclar);	
//			echo '</pre>';	

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir görüş bildirilmemiş.</div>';
}
else{


?>
<form action="?option=com_meslek_std_taslak&task=gorusCevapla" method="POST">
<input type="hidden" name="gorusId" value="<?php echo $sonuclar[0]['GORUS_ID']?>"></input>
<input type="hidden" name="standartId" value="<?php echo $this->standartId?>"></input>
<div class="tableWrapper">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th class="sortable-numeric">Sıra No</th>
		<th class="sortable-text">Standart üzerindeki<br />
								  yer (bölüm, satır no,<br />
								  sayfa no)</th>
		<th class="sortable-text">Görüş ve Öneriler</th>
		<th class="sortable-text">Değerlendirme</th>
		<th class="sortable-text">Düzeltme</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'">';
			echo '<td>'.$satir['SIRA_NO'].'</td>';
			echo '<td>'.$satir['STANDART_YERI'].'</td>';
			echo '<td>'.$satir['GORUS_VE_ONERILER'].'</td>';
			
			if($this->canEdit){
			
				echo '<td><textarea name="degerlendirme_'.$satir['SIRA_NO'].'">'.$satir['DEGERLENDIRME'].'</textarea></td>';
				echo '<td><textarea name="duzeltme_'.$satir['SIRA_NO'].'">'.$satir['DUZELTME'].'</textarea></td>';
			
			}
			
			else{
				
				echo '<td>'.$satir['DEGERLENDIRME'].'</td>';
				echo '<td>'.$satir['DUZELTME'].'</td>';
			
			}
			
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<div style="margin-left:50px; margin-top:16px">
<input type="button" value="Geri" onclick="javascript:history.go(-1)"></input>

<?php 
if($this->canEdit){
?>
	<input type="submit" value="Kaydet"></input>
<?php
}
?>
</div>
</form>
<?php
}

?>

