<?php 
$kurulus = $this->kurulus_bilgi;
echo $this->tipLink;
$yetkiYets = $this->yetkiYets;
$pata = $this->yetkiBirims;
$yetkiBirims = $pata['yetkiBirims'];
$turs = $pata['turs'];
$ucrets = $pata['ucrets'];
$detay = $this->detay;
$OnayliUcretYets = $this->OnayliUcretYets;
$OnayBekleyenTarifeler = $this->OnayBekleyenTarifeler;
?>
<div class="anaDiv">
<?php echo $this->sayfaLink;?>
</div>
<div class="anaDiv">
	<?php echo '<h2 style="margin-bottom:10px;"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>

<?php
foreach($yetkiYets as $row){
?>
<div class="anaDiv">
	<div class="div95 font18 hColor">
		<?php echo $row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'];?>
	</div>
</div>
<div class="anaDiv">
	<table width="100%" border="1">
		<thead style="text-align:center;background-color:#71CEED" class="theadBirims">
			<tr>
				<th width="5%">#</th>
				<th width="50%">Yetkili Ulusal Yeterlilik Birimi</th>
				<th width="15%">Toplam Birim Ücreti</th>
			</tr>
		</thead>
		<tbody class="birimsTbody">
<?php
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach($yetkiBirims[$row['DONEM_ID']] as $cow){
		if($say%2 == 0){
			echo '<tr '.$even.'>';
			$bgcolor = 'bgcolor="#efefef"';
		}else{
			echo '<tr>';
			$bgcolor = '';
		}
		
		echo '<td>'.$say.'</td>';
		if($cow['YET_ESKI_MI'] == 1){
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
		}else{
			echo '<td>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
		}
		
		if(isset($cow['UCRET'])){
			echo '<td class="text-end">'.$cow['UCRET'].'</td>';
		}else{
			echo '<td class="text-end"></td>';
		}
		
		echo '</tr>';
		$say++;
		
	}
?>
		</tbody>
	</table>
</div>
<?php
}
?>