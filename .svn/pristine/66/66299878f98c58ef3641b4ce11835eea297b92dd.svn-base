<?php
if(!is_array($this->bilgi)){
	echo '<h2>'.$this->belgeNo.' '.$this->bilgi.'</h2>';	
}else{
$bilgi = $this->bilgi[0];
$aday = $this->bilgi[1];
$birims = $this->bilgi[2];

?>
<style>
.width150{
	width:200px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>div{
	padding-bottom:10px;
	padding-top:10px;
}

.aramaClass{
	width:80%;
	display: table; 
	margin-right: auto; 
	margin-left: auto;
	border: 1px solid #000000;
	padding:10px;
}

</style>
<?php if($aday){?>
	<h2 style="text-align: center">Mesleki Yeterlilik Belgesi</h2>
	<div class="aramaClass">
	<div class="width150">Ad Soyad:</div><div><?php echo $aday['ADI'].' '.$aday['SOYADI'];?></div>
	<div class="width150">Belge No:</div><div><?php echo $this->belgeNo;?></div>
	<div class="width150">Yeterlilik:</div><div><?php echo $bilgi['YETERLILIK_KODU'].'/'.$bilgi['REVIZYON'].' '.$bilgi['YETERLILIK_ADI'];?></div>
	<div class="width150">Belgelendirme Kuruluşu:</div><div><?php echo $bilgi['KURULUS_ADI'];?></div>
	<div class="width150">Sınav Tarihi:</div><div><?php echo $bilgi['SINAV_TARIHI'];?></div>
	<div class="width150">Belge Verilme Tarihi:</div><div><?php echo $bilgi['BELGE_DUZENLEME_TARIHI'];?></div>
	<div class="width150">Belge Geçerlilik Tarihi:</div><div><?php echo $bilgi['GECERLILIK_TARIHI'];?></div>
	<?php
	if(count($birims)>0){
		echo '<h2>Başarılı Olunan Birimler</h2>';
		echo '<ul>'; 
		foreach ($birims as $row){
			echo '<li>'.$row['BIRIM_KODU'].' '.$row['BIRIM_ADI'].'</li>';
		}
		echo '</ul>';
		?>
		</div>
		<div>
		
		</div>
		<?php
		} 
	}else{
		?>
		<h2 style="text-align: center">Mesleki Yeterlilik Belgesi</h2>
		<div class="aramaClass">
			<div class="width150">TC Kimlik No:</div><div class=""><span><?php echo $bilgi["TCKIMLIKNO"];?> </span></div>
			<div class="width150"><span>Ad:</span></div><div class=""><span><?php echo $bilgi["AD"];?> </span></div>
			<div class="width150"><span>Soyad:</span></div><div><span><?php echo $bilgi["SOYAD"];?> </span></div>
			<div class="width150"><span>Belge No:</span></div><div><span><?php echo $bilgi["BELGENO"];?> </span></div>
			<div class="width150"><span>Yeterlilik Adı:</span></div><div><span><?php echo $bilgi["YETERLILIK_ADI"];?> </span></div>
			<div class="width150"><span>Yeterliliğin Seviyesi:</span></div><div><span><?php echo $bilgi["YETERLILIK_SEVIYESI"];?> </span></div>
			<!-- <div class="width150"><span>Sınav Tarihi:</span></div><div><span><?php echo $bilgi["SINAV_TARIHI"];?> </span></div> -->
			<div class="width150"><span>Belge Düzenleme Tarihi:</span></div><div><span><?php echo $bilgi["BELGE_DUZENLEME_TARIHI"];?> </span></div>
			<div class="width150"><span>Belge Geçerlilik Tarihi:</span></div><div class=""><span><?php echo $bilgi["GECERLILIK_TARIHI"];?> </span></div>
			<div class="width150"><span>Belgelendirme Kuruluşu:</span></div><div class="item_text"><span><?php echo $bilgi["BELGELENDIRME_KURULUSU"];?> </span></div>
		</div>
		
		<?php 
	}
}
?>