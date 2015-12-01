<?php 
$sonuclar = $this->kuruluslar;
$tur	  = $this->kurulus_tur;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Uygun sonuç bulunamadı.</div>';
}
else{
?>
	<div class="tableWrapper">
		<table cellspacing="0" class="paginate-10 sortable">
			<tr class="tablo_header">
				<th>#</th>
				<th class="sortable-text">Kuruluş Adı</th>
				<th >Kuruluş Bilgileri Ayrıntı</th>
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
					echo '<td><a href="index.php?option=com_kurulus_edit&layout=kurulus_bilgi&tur='.$tur.'&id='.$satir['USER_ID'].'">Ayrıntı</a></td>';
					echo '</tr>';
					$rowCount++;
				}
			?>	
		</table>
	</div>
<?php }?>