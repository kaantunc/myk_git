<?php
$kurulus = $this->kurulus_bilgi;
$belgeler = $this->belgeler;
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<table width="100%" style="text-align:center" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">Yeterlilik Kodu</th>
			<th width="40%">Yeterlilik Adı</th>
			<th width="15%">Portal Üzerinden Verilen Belge Sayısı</th>
			<th width="15%">Manuel Verilen Belge Sayısı</th>
			<th width="20%">Toplam Verilen Belge Sayısı</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$say = 1;
	$belsay = 0;
	$haksay = 0;
	foreach($belgeler as $row){
		if($say%2 == 0){
			echo '<tr bgcolor="#efefef">';
		}else{
			echo '<tr bgcolor="#ffffff">';
		}
		
		echo '<td>'.$row['YETERLILIK_KODU'].'</td>';
		echo '<td>'.$row['YETERLILIK_ADI'].'</td>';
		if($row['HAKSAY']){
			$hak = $row['HAKSAY'];
		}else{
			$hak = 0;
		}
		echo '<td>'.$hak.'</td>';
		
		if($row['BELSAY']){
			$bel = $row['BELSAY'];
		}else{
			$bel = 0;
		}
		echo '<td>'.$bel.'</td>';
		echo '<td>'.($hak+$bel).'</td>';
		echo '</tr>';
		$say++;
		$belsay += $bel;
		$haksay += $hak;
	}
	?>
	<tr>
		<td colspan="2" align="right">Toplam:</td>
		<td><?php echo $haksay;?></td>
		<td><?php echo $belsay;?></td>
		<td><?php echo $belsay+$haksay;?></td>
	</tr>
	</tbody>
</table>

<?php echo $this->geriLink;?>