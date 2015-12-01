<div class="form_element cf_heading">
	<h1 class="contentheading">Mesleki Yeterlilik Belgesi Sorgu Sonuçları</h1>

	<div style="clear: both;"></div>
</div>


<?php
$data = $this->data;

if (empty($data)){
?>
	<div class=no_result>Uygun sonuç bulunamadı.</div>
<?php
}else{
	foreach($data as $row){
?>
		<div class="title">
			<span>Mesleki Yeterlilik Belgesi</span>
		</div>
		
		<div class="wrap">
			<div class="item">
				<div class="item_title">
					<span>TC Kimlik No:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["TCKIMLIKNO"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
		
			<div class="item">
				<div class="item_title">
					<span>Ad:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["AD"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
		
			<div class="item">
				<div class="item_title">
					<span>Soyad:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["SOYAD"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge No:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGENO"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Yeterlilik Adı:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["YETERLILIK_ADI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Yeterliliğin Seviyesi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["YETERLILIK_SEVIYESI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Sınav Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["SINAV_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge Düzenleme Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGE_DUZENLEME_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge Geçerlilik Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["GECERLILIK_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belgelendirme Kuruluşu:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGELENDIRME_KURULUSU"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
		
			<div style="clear: both;"></div>
		</div>
<?php
	}
}
?>