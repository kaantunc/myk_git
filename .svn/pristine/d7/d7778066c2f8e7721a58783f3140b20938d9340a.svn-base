<?php
$kurs = $this->kurs;
$yets = $this->yets[0];
$belgeliler = $this->belgeliler;
?>

<h2><?php echo $kurs['KURULUS_ADI'];?></h2>
<br><hr>
<h3><?php echo $yets['YETERLILIK_KODU'].' '.$yets['YETERLILIK_ADI'];?></h3>
<br>
<table id="sinavTable" style="width:100%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
		<thead style="background-color:#71CEED"> 
			<tr>
				<th width="20%">Belge No.</th>
				<th width="10%">Kimlik No.</th>
				<th width="10%">Adı</th>
				<th width="15%">Soyadı</th>
				<th width="10%">Sınav Tarihi</th>
				<th width="10%">Belge Düzenleme Tarihi</th>
				<th width="10%">Belge Geçerlilik Tarihi</th>
				<th width="15%">İmza Yetkilisi</th>
			</tr>
		</thead>
		<tbody id="sinavTbody">
		<?php
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach($belgeliler as $row){
			if($say%2==0){
				$bcolor = 'bgcolor="#efefef"';
			}else{
				$bcolor = 'bgcolor="#ffffff"';
			}
			
			echo '<tr '.$bcolor.'>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['AD'].'</td>';
			echo '<td>'.$row['SOYAD'].'</td>';
			echo '<td>'.$row['SINAV_TARIHI'].'</td>';
			echo '<td>'.$row['BELGE_DUZENLEME_TARIHI'].'</td>';
			echo '<td>'.$row['GECERLILIK_TARIHI'].'</td>';
			echo '<td>'.$row['IMZA_YETKILISI'].'</td>';
			echo '</tr>';
			$say++;
		}
		?>
		</tbody>
</table>