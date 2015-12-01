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
.baslik{
	font-size:16px;
	color:#06395A; 
}
.basUcret{
	font-size:16px;
	font-weight: bold;
}
</style>
<?php 
$kurs = $this->kurs;
$yetId = $this->yetId;
$yetkiYets = $this->yetkiYets;
$yetkiBirims = $this->yetkiBirims;
// $yetkiBirims = $pata['yetkiBirims'];
// $turs = $pata['turs'];
// $ucrets = $pata['ucrets'];
$detay = $this->detay;

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
	<div class="div70">
	<h2 style="font-size:1.4em; color:#016BB7;">SINAV VE BELGELENDİRME ÜCRET TARİFESİ</h2>
	</div>
	<?php if(!empty($detay) || $detay != null){?>
<div class="div30">
	<button type="button" id="DetayBut" class="btn btn-sm btn-info">Genel Şartlar ve Açıklamalar</button>
</div>
<?php }?>
</div>
<?php
foreach($yetkiYets as $row){
?>
<div class="anaDiv" style="text-align: center;">
	<h2><?php echo $row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].')';?></h2>
</div>
<div class="anaDiv">
	<table width="100%" border="1">
		<thead style="text-align:center;background-color:#71CEED" class="theadBirims">
			<tr>
				<th width="5%">#</th>
				<th width="50%">Ulusal Yeterlilik Birimi</th>
				<th width="15%">Birim Sınav Ücreti</th>
			</tr>
		</thead>
		<tbody class="birimsTbody">
<?php
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach($yetkiBirims[$row['YETERLILIK_ID']] as $cow){
			if($say%2 == 0){
				echo '<tr '.$even.'>';
				$bgcolor = 'bgcolor="#efefef"';
			}else{
				echo '<tr>';
				$bgcolor = '';
			}
			
			echo '<td align="center">'.$say.'</td>';
			if($cow['YET_ESKI_MI'] == 1){
				echo '<td>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
			}else{
				echo '<td>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
			}
			
			echo '<td align="center">'.$cow['UCRET'].'</td>';
			echo '</tr>';
			
			$say++;
		
	}
?>
		</tbody>
	</table>
</div>
<?php if(!empty($row['UCRET'])){ ?>
<div class="anaDiv" style="text-align: center;">
	<span class="baslik">Yeterlilik Toplam Sınav Ücreti:</span> <span class="basUcret"><?php echo $row['UCRET']; ?></span>
</div>
<?php } ?>
<div class="divBorder"></div>
<?php
}
?>

<div id="Detay" style="min-width: 500px; max-width:800px; min-height:300px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="divBorder">
		<div class="text-center fontBold font16" style="background-color:#71CEED;padding:10px;">
			GENEL ŞARTLAR ve AÇIKLAMALAR
		</div>
		<div class="anaDiv font16" style="padding:10px;">
		<?php 
		if(!empty($detay) || $detay != null){
			echo $detay;
		}else{
			echo 'Herhangi bir şart veya açıklama bulunmamaktadır.';
		}
		?>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#DetayBut').live('click',function(e){
		e.preventDefault();
		jQuery('#Detay').lightbox_me({
			centered: true
		});
	});

	jQuery('#yetGetir').live('click',function(e){
		e.preventDefault();
		window.location.href = "index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus_tarife&kurId=<?php echo $kurs['USER_ID']?>&yetId="+jQuery('#yetSelect').val();
	});
});
// jQuery('#loaderGif').lightbox_me({
// 	centered: true,
// closeClick:false,
// closeEsc:false  
// });
//jQuery('#loaderGif').trigger('close');
</script>