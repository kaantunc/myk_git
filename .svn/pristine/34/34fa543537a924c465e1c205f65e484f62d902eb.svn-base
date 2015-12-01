<style>

.btnYeniYetki{
	color:#ffffff;
	background-color:#71CEED;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
.divBorder{
	border: 1px solid #1C617C;;
	width:100%;
}

.birimsTbody td{
	padding:5px;
}

.theadBirims th{
	padding:10px;
	font-size:15px;
}
</style>
<?php 
$kurs = $this->kurs;
$yetId = $this->yetId;
$yetkiYets = $this->yetkiYets;
$yetkiBirims = $this->yetkiBirims;

$selectYets = '<option value="0">Hepsi</option>';
foreach($this->SelectYets as $row){
	$selected = '';
	if($yetId == $row['YETERLILIK_ID']){
		$selected = 'selected="selected"';
	}
// 	$selectYets .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</option>';
	if($row['REVIZYON'] !== '00'){
		$selectYets .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].') (Revizyon '.$row['REVIZYON'].')</option>';
	}else{
		$selectYets .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].')</option>';
	}
}
?>
<div class="anaDiv">
<?php echo $this->sayfaLink;?>
</div>
<div class="anaDiv" style="text-align:center;">
	<div class="div50">
		<img style="height:200px;max-width: 100%" src="index.php?dl=kurulus_logo/<?php echo $kurs['USER_ID'];?>/<?php echo $kurs['LOGO'];?>">
	</div>
</div>
<div class="anaDiv" style="text-align:center;">
	<h2><u><?php echo $kurs['KURULUS_ADI'];?></u></h2>
</div>
<div class="anaDiv">
	<div class="div20"><h2>Ulusal Yeterlilik:</h2></div>
	<div class="div80"><select id="yetSelect" class="input-sm inputW95"><?php echo $selectYets;?></select></div>	
</div>
<div class="anaDiv" style="text-align: center;"><button type="button" class="btn btn-sm btn-success" id="yetGetir"><i class="fa fa-search"></i> Getir</button></div>
<div class="anaDiv">
	<table width="100%" border="1">
		<thead style="text-align:center;background-color:#71CEED" class="theadBirims">
			<tr>
				<th width="5%">#</th>
				<th width="40%">Ulusal Yeterlilik</th>
				<th width="45%">Ulusal Yeterlilik Birimi</th>
				<th width="10%">Yetki Tarihi</th>
				<?php if($kurs['ASKI']){
// 					echo '<th width="10%">Askıya Alınma Tarihi</th>';
					echo '<th width="10%">Yetki Kaldırılma Tarihi</th>';
				}?>
			</tr>
		</thead>
		<tbody class="birimsTbody">
		<?php
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach($yetkiYets as $row){
			if($say%2 == 0){
				echo '<tr '.$even.'>';
				$bgcolor = 'bgcolor="#efefef"';
			}else{
				echo '<tr>';
				$bgcolor = '';
			}
			$countBirim = count($yetkiBirims[$row['YETERLILIK_ID']]);
			echo '<td rowspan="'.$countBirim.'" align="center">'.$say.'</td>';
			echo '<td rowspan="'.$countBirim.'">'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].')</td>';
			
			$countSay = 1;
			$bg = 'bgcolor="#efefef"';
			foreach($yetkiBirims[$row['YETERLILIK_ID']] as $cow){
				if($countSay == 1){
					if($cow['YET_ESKI_MI'] == 1){
						echo '<td>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
					}else{
						echo '<td>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
					}
					echo '<td align="center">'.substr($cow['YETKININ_VERILDIGI_TARIH'],0,10).'</td>';
					if($kurs['ASKI']){
						echo '<td align="center" class="text-danger">'.substr($kurs['TARIH'],0,10).'</td>';
					}
					echo '</tr>';
				}else{
					echo '<tr '.$bgcolor.'>';
// 					if($countSay%2 == 0){
// 						echo '<tr '.$bg.'>';
// 					}else{
// 						echo '<tr>';
// 					}
					
					if($cow['YET_ESKI_MI'] == 1){
						echo '<td>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
					}else{
						echo '<td>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
					}
					echo '<td align="center">'.substr($cow['YETKININ_VERILDIGI_TARIH'],0,10).'</td>';
					if($kurs['ASKI']){
						echo '<td align="center" class="text-danger">'.substr($kurs['TARIH'],0,10).'</td>';
					}
					echo '</tr>';
				}
				$countSay++;
			}
			$say++;
		}
		?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#yetGetir').live('click',function(e){
		e.preventDefault();
		window.location.href = "index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus_kapsam&kurId=<?php echo $kurs['USER_ID']?>&yetId="+jQuery('#yetSelect').val();
	});
});
</script>