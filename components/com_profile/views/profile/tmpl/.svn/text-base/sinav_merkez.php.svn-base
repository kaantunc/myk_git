<?php
$kurulus = $this->kurulus_bilgi;
$programs = $this->programs;
?>
<style>
.active{
	background-color:green;
	color:white;
}
.passive{
	background-color:red;
	color:white;
}
</style>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<div id="KayitliSinavs">
<?php if(count($programs) > 0){
?>
<table style="width:100%;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED"> 
		<tr>
			<th width="5%">Sınav Yeri ID</th>
			<th width="20%">Yer Adı</th>
			<th width="30%">Yeterlilik</th>
			<th width="5%">Etkin</th>
			<th width="5%">Onay</th>
			<th>Eklenme Tarihi</th>
			<th>Onay Tarihi</th>
			<th width="10%">Döküman</th>
			<th width="35%">Adres</th>
			<th width="10%">Temin Durumu</th>
<!-- 			<th>Durumu</th> -->
<!-- 			<th width="5%">Sil</th> -->
		</tr>
	</thead>
	<tbody id="sınavTbody">


<?php 
	$even = "bgcolor='#efefef'";
	$say = 1;
	foreach ($programs as $key=>$cow){
		if($say%2==0){
			$bcolor = "bgcolor='#efefef'";
		}else{
			$bcolor = "bgcolor='#ffffff'";
		}
		$say++;
		echo "<tr ".$bcolor."><td align='center' rowspan='".count($cow)."'>".$key."</td>";
		for($i=0;$i<count($cow); $i++){
			if($i%2==1){
				$bcolor = "bgcolor='#efefef'";
			}else{
				$bcolor = "bgcolor='#ffffff'";
			}
			if($i == 0){
				echo '<td align="center" rowspan="'.count($cow).'">'.$cow[$i]['YER_ADI']."</td>";
				if($cow[$i]['REVIZYON'] <> ""){
					echo "<td>".trim($cow[$i]['YETERLILIK_KODU'])."/".$cow[$i]['REVIZYON']."-".$cow[$i]['YETERLILIK_ADI'].' - '.($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>")."</td>";
				}else{
					echo "<td>".trim($cow[$i]['YETERLILIK_KODU'])."/00-".$cow[$i]['YETERLILIK_ADI']." - ".($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>")."</td>";
				}
				if($cow[$i]['BILDIRIM_DURUMU'] == 1){
					echo "<td align='center'><button  class='active' type='button'>Aktif</button> </td>";	
				}else{
					echo "<td align='center'><button  class='passive' type='button'>Pasif</button> </td>";
				}
				if($cow[$i]['ONAY_DURUMU'] == 1 || $cow[$i]['TEMIN_DURUMU'] == 2){
					echo "<td align='center'><button class='active cancelsinavyerionaylayeterlilik' yerid='".$cow[$i]['SINAV_YERI_ID']."' yetid='".$cow[$i]['YETERLILIK_ID']."' sinavtur = '".$cow[$i]['SINAV_TURU']."' type='button'>Onaylandı</button> </td>";
				}else{
					echo "<td align='center'><button class='passive submitsinavyerionaylayeterlilik'' yerid='".$cow[$i]['SINAV_YERI_ID']."' yetid='".$cow[$i]['YETERLILIK_ID']."' sinavtur = '".$cow[$i]['SINAV_TURU']."' type='button'>Onay Bekliyor</button> </td>";
				}
				echo "<td  align='center'>".($cow[$i]['OLUSTURMA_TARIHI'] == "" ? "-" : substr($cow[$i]['OLUSTURMA_TARIHI'],0,10)).'</td>';
				echo "<td  align='center'>".($cow[$i]['ONAY_TARIHI'] == "" ? "-" : substr($cow[$i]['ONAY_TARIHI'],0,10)).'</td>';
				echo "<td  align='center'><a href='javascript:void(0);' class='uygunlukformupanel' yerid='".$cow[$i]['SINAV_YERI_ID']."' yetid='".$cow[$i]['YETERLILIK_ID']."' sinavtur = '".$cow[$i]['SINAV_TURU']."'><img alt='PDF' src='".SITE_URL."/templates/elegance/images/32pdf.png'/></a></td>";
				echo "<td rowspan='".count($cow)."'>".$cow[$i]['ADRES']."</td>";
				if($cow[$i]['TEMIN_DURUMU'] == 1){
					echo "<td rowspan='".count($cow)."' align='center'>Sözleşme ile</td>";
				}
				else if($cow[$i]['TEMIN_DURUMU'] == 2){
					echo "<td rowspan='".count($cow)."' align='center'>Gezici</td>";
				}
				else if($cow[$i]['TEMIN_DURUMU'] == 3){
					echo "<td rowspan='".count($cow)."' align='center'>Kuruluşa ait</td>";
				}
				echo "</tr>";
			}else{
				echo "<tr ".$bcolor.">";
				if($cow[$i]['REVIZYON'] <> ""){
					echo '<td>'.trim($cow[$i]['YETERLILIK_KODU']).'/'.$cow[$i]['REVIZYON'].'-'.$cow[$i]['YETERLILIK_ADI'].' - '.($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>").'</td>';
				}else{
					echo '<td>'.trim($cow[$i]['YETERLILIK_KODU']).'/00-'.$cow[$i]['YETERLILIK_ADI'].' - '.($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>").'</td>';
				}
				if($cow[$i]['BILDIRIM_DURUMU'] == 1){
					echo '<td align="center"><button class="active" type="button" >Aktif</button> </td>';	
				}else{
					echo '<td align="center"><button class="passive" type="button" >Pasif</button> </td>';
				}
				if($cow[$i]['ONAY_DURUMU'] == 1 || $cow[$i]['TEMIN_DURUMU'] == 2){
					echo '<td align="center"><button class="active cancelsinavyerionaylayeterlilik" yerid="'.$cow[$i]['SINAV_YERI_ID'].'" yetid="'.$cow[$i]['YETERLILIK_ID'].'" sinavtur = "'.$cow[$i]['SINAV_TURU'].'" type="button">Onaylandı</button> </td>';
				}else{
					echo '<td align="center"><button class="passive submitsinavyerionaylayeterlilik" yerid="'.$cow[$i]['SINAV_YERI_ID'].'" yetid="'.$cow[$i]['YETERLILIK_ID'].'" sinavtur = "'.$cow[$i]['SINAV_TURU'].'" type="button">Onay Bekliyor</button> </td>';
				}
				echo "<td  align='center'>".($cow[$i]['OLUSTURMA_TARIHI'] == "" ? "-" : substr($cow[$i]['OLUSTURMA_TARIHI'],0,10))."</td>";
				echo "<td  align='center'>".($cow[$i]['ONAY_TARIHI'] == "" ? "-" : substr($cow[$i]['ONAY_TARIHI'],0,10))."</td>";
				echo "<td  align='center'><a href='javascript:void(0);' class='uygunlukformupanel' yerid='".$cow[$i]['SINAV_YERI_ID']."' yetid='".$cow[$i]['YETERLILIK_ID']."' sinavtur = '".$cow[$i]['SINAV_TURU']."'><img alt='PDF' src='".SITE_URL."/templates/elegance/images/32pdf.png' /></a></td>";
				echo "</tr>";
			}
		}
	}	?>
	</tbody>
</table>
<?php	
}?>

</div>

<div id="yeterlilikUygunlukFormuPanel" style="width: 40%; min-height:80px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=SinavYeriYeterlilikUygunlukSozlesmeFormuEkle"  method="POST" id="yeterlilikUygunlukPanelForm" enctype="multipart/form-data">
	<h2><u>Protokol / Sözleşme / Uygunluk Değerlendirme Formu</u></h2><br>
		<div id="yets">
		</div>
		<table width="100%">
			<tr>
				<td width="45%">Protokol/Sözleşme Formu: </td>
				<td width="55%">
					<span></span>
				</td>
			</tr>
			<tr>
				<td>Uygunluk Değerlendirme Formu:</td>
				<td>
					<span></span>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php echo $this->geriLink;?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".submitexamplace").click(function(){
		if (confirm("İlgili sınav yeri onaylanacak emin misiniz!") == true) {
			submitOrCancelExamPlace(jQuery(this).attr('yerid'),'1');
		}
	});

	jQuery(".cancelexamplace").click(function(){
		if (confirm("İlgili sınav yeri onayı kaldırılacak emin misiniz!") == true) {
			submitOrCancelExamPlace(jQuery(this).attr('yerid'),'0');
		}
	});
	
	jQuery(".submitexamplaceerror").click(function(){
		alert("İlgili sınav yeri dosya sorumlunuzca onay beklemektedir.");
		return false;
	});

	jQuery(".cancelsinavyerionaylayeterlilik").click(function(){
		if (confirm("İlgili sınav yeri ilgili yeterlilik için onayı kaldırılacak emin misiniz!") == true) {
			submitOrCancelExamPlaceForYeterlilik(jQuery(this).attr('yerid'),jQuery(this).attr("yetid"),jQuery(this).attr("sinavtur"),'0');
		}
	});
	jQuery(".submitsinavyerionaylayeterlilik").click(function(){
		if (confirm("İlgili sınav yeri ilgili yeterlilik için onaylanacak emin misiniz!") == true) {
			submitOrCancelExamPlaceForYeterlilik(jQuery(this).attr('yerid'),jQuery(this).attr("yetid"),jQuery(this).attr("sinavtur"),'1');
		}
	});

	jQuery(".uygunlukformupanel").click(function(){
		yerid = jQuery(this).attr("yerid");
		yetid = jQuery(this).attr("yetid");
		sinavTur = jQuery(this).attr("sinavtur");
		jQuery.ajax({
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=sozlemeUygunlukFormu&format=raw",
			data:'yerId='+yerid+'&yetId='+yetid+'&sinavTur='+sinavTur,
			success:function(data){
				if(data.STATUS == 1){
					control = true;
					if(data.DATA.SOZLESME_FORMU != ""){
						control = false;
						sozlesme = data.DATA.SOZLESME_FORMU.split('/');
						jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(0) td:eq(1) span').html(sozlesme[3]+"<a href='index.php?dl="+data.DATA.SOZLESME_FORMU+"' style='color:red; float:right;'>İndir</a>");
					}else{
						jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(0) td:eq(1) span').html("-");
					}
					if(data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU != ""){
						control = false;
						uygunluk = data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU.split('/');
						jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(1) td:eq(1) span').html(uygunluk[3]+"<a href='index.php?dl="+data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU+"' style='color:red; float:right;'>İndir</a>");
					}else{
						jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(1) td:eq(1) span').html("-");
					}
					jQuery('#yeterlilikUygunlukFormuPanel').lightbox_me({
						  centered: true
						});
				}else{
					alert("Teknik bir hata oluştu.Lütfen daha sonra tekrar deneyiniz!");
				}
			}
		});
	});
});

function submitOrCancelExamPlace(yerid , durum){
	jQuery.ajax({
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_profile&task=sinavYeriOnayla&format=raw",
		data:'yerid='+yerid+'&durum='+durum,
		success:function(data){
			if(data.STATUS && data.STATUS != ""){
				alert(data.RESULT);
				window.location.reload();
			}else{
				alert("Onay işleminde hata oluştu");
			}
		}
	});
}
function submitOrCancelExamPlaceForYeterlilik(yerid , yeterlilikid, sinav_turu , durum){
	jQuery.ajax({
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_profile&task=sinavYeriOnaylaForYeterlilik&format=raw",
		data:'yerid='+yerid+'&yetid='+yeterlilikid+'&sinavtur='+sinav_turu+'&durum='+durum,
		success:function(data){
			if(data.STATUS && data.STATUS != ""){
				alert(data.RESULT);
				window.location.reload();
			}else{
				alert("Onay işleminde hata oluştu");
			}
		}
	});
}
</script>