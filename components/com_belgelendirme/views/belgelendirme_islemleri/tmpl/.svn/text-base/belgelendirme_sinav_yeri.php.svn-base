<style>
<!--
span.label {
	width:150px;
	font-weight: bold;
}
-->
</style>
<?php 
$yets = $this->kurYets;

$programs = $this->programs;

// $yetOption = '<option value="">Seçiniz</option>';
// foreach ($yets as $yet){
// 	$yetOption .= '<option value="'.$yet['YETERLILIK_ID'].'">'.$yet['YETERLILIK_KODU'].' - '.$yet['YETERLILIK_ADI'].'</option>';
// }

$yetOption = '';
foreach ($yets as $yet){
	
$yetOption .= '<br><input type="checkbox" name="yets[]" value="'.$yet['YETERLILIK_ID'].'-T"/>'.trim($yet['YETERLILIK_KODU']).'/'.$yet['REVIZYON'].' - '.$yet['YETERLILIK_ADI'].' - <b>TEORİK</b> ';
$yetOption .= '<br><input type="checkbox" name="yets[]" value="'.$yet['YETERLILIK_ID'].'-P"/>'.trim($yet['YETERLILIK_KODU']).'/'.$yet['REVIZYON'].' - '.$yet['YETERLILIK_ADI'].' - <b>PRATİK</b> ';

//$yetOption .= '<br><input type="checkbox" name="yets[]" value="'.$yet['YETERLILIK_ID'].'"/>'.$yet['YETERLILIK_KODU'].' - '.$yet['YETERLILIK_ADI'];
}

// $ilOption = '';
// foreach ($ils as $il){
// 	$ilOption .=  '<option value="'.$il['IL_ID'].'">'.$il['IL_ADI'].'</option>';
// }
echo $this->sayfaLink;
?>
<h2 style="color:#063B5E; border-bottom: 1px solid #42627D;">Sınav Yeri Bildirim Ekranı</h2><br>
<button id="sinavs">Yeni Sinav Yeri Ekle</button>
<div>
	<input type="radio" name="yertype" value="0"  checked="checked"/>
		<span style="color:#063B5E;">Sınav Yeri Id: </span>
		<span id="tcRadio">
			<input id="yerval" name="yerval" /><input type="button" value="Güncelle" id="yerGetir" />
		</span>
	<br>
	<input type="radio" name="yertype" value="1" />
	<span style="color:#063B5E;">Yer Adı: </span>
</div><br>
<div id="yeniSinav" style="display:none">
<form method="POST" id="sinavYeriKaydetmeFormu"
	action="index.php?option=com_belgelendirme&task=sinav_yeri_kaydet&layout=belgelendirme_sinav_yeri" enctype="multipart/form-data">
<hr><br>
<div><span style="color:#063B5E;">Yer Adı: </span><input type="text" id="yerAd" name="yerAd" style="margin-left:10px;"/></div><br>
<div>
	<span style="color:#063B5E;">
		Yeterlilik(ler): 
	</span>
	<br>
	<span id="yeterlilikler">
	<?php // yetkilendirildiği yeterlilikler getirilicek 
		echo $yetOption;
	?>
	</span>
</div>
<br>
<div><span style="color:#063B5E;">Adres: </span><br><textarea id="adress" name="adress" style="margin-left:58px;"></textarea></div><br>

<div><span style="color:#063B5E;">Temin Durumu: </span><select name="temin" id="temin">
		<option value="">Seçiniz</option>
		<option value="1">Sözleşme ile</option>
		<option value="2">Gezici</option>
		<option value="3">Kuruluşa ait</option>
	</select></div><br>
<!--	<a href="#" id="sinavKaydet" >Kaydet</a>-->
<input type="hidden" id="sinavyerid" name="sinavyerid" value="" />
        <button id="sinavKaydet">Kaydet</button>
	
</form>						
</div>
<hr>
<br>
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
<!-- 		<th>Durumu</th>   -->	
<!-- 			<th width="5%">Sil</th> -->
		</tr>
	</thead>
	<tbody id="sınavTbody">


<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($programs as $key=>$cow){
		if($say%2==0){
			$bcolor = 'bgcolor="#efefef"';
		}else{
			$bcolor = 'bgcolor="#ffffff"';
		}
		$say++;
		echo '<tr '.$bcolor.'><td align="center" rowspan="'.count($cow).'">'.'<input type="hidden" name="yerid" value="'.$key.'" />'.$key.'</td>';
		for($i=0;$i<count($cow); $i++){
			if($i%2==1){
				$bcolor = 'bgcolor="#efefef"';
			}else{
				$bcolor = 'bgcolor="#ffffff"';
			}
			if($i == 0){
				echo '<td align="center" rowspan="'.count($cow).'">'.$cow[$i]['YER_ADI'].'<br><button type="button" onclick=newYet("'.$key.'")>Yeterlilik Ekle</button></td>';
				echo '<td>
						<button style="background-color:red;color:white" onclick=silYetki("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'_'.$cow[$i]['SINAV_TURU'].'")>
							Sil
						</button>'.
						'<input type="hidden" name="yetid" value="'.$cow[$i]['YETERLILIK_ID'].'" />'.
						'<input type="hidden" name="sinavtur" value="'.$cow[$i]['SINAV_TURU'].'" />'.
						trim($cow[$i]['YETERLILIK_KODU']).'/'.$cow[$i]['REVIZYON'].'-'.$cow[$i]['YETERLILIK_ADI'].' - '.($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>").'</td>';
				if($cow[$i]['BILDIRIM_DURUMU'] == 1){
					echo '<td align="center"><button  style="background-color:green;color:white;" type="button" onclick=bildirimIptal("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'")>Aktif</button> </td>';	
				}else{
					echo '<td align="center"><button  style="background-color:red;color:white;" type="button" onclick=bildir("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'")>Pasif</button> </td>';
				}
				if($cow[$i]['ONAY_DURUMU'] == 1 || $cow[$i]['TEMIN_DURUMU'] == 2){
					echo '<td align="center"><button  style="background-color:green;color:white;" type="button">Onaylandı</button> </td>';
				}else{
					echo '<td align="center"><button  style="background-color:red;color:white;" type="button">Onay Bekliyor</button> </td>';
				}
				echo '<td  align="center">'.($cow[$i]['OLUSTURMA_TARIHI'] == "" ? "-" : substr($cow[$i]['OLUSTURMA_TARIHI'],0,10)).'</td>';
				echo '<td  align="center">'.($cow[$i]['ONAY_TARIHI'] == "" ? "-" : substr($cow[$i]['ONAY_TARIHI'],0,10)).'</td>';
				echo '<td  align="center"><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/32pdf.png" onclick=pdfGoster("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'_'.$cow[$i]['SINAV_TURU'].'") /></td>';
				echo '<td rowspan="'.count($cow).'">'.$cow[$i]['ADRES'].'</td>';
				if($cow[$i]['TEMIN_DURUMU'] == 1){
					echo '<td rowspan="'.count($cow).'" align="center">Sözleşme ile</td>';
				}
				else if($cow[$i]['TEMIN_DURUMU'] == 2){
					echo '<td rowspan="'.count($cow).'" align="center">Gezici</td>';
				}
				else if($cow[$i]['TEMIN_DURUMU'] == 3){
					echo '<td rowspan="'.count($cow).'" align="center">Kuruluşa ait</td>';
				}
				echo '</tr>';
			}else{
				echo '<tr '.$bcolor.'>';	
				echo '<td>
						<button style="background-color:red;color:white" onclick=silYetki("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'_'.$cow[$i]['SINAV_TURU'].'")>
							Sil
						</button> '.
						'<input type="hidden" name="yetid" value="'.$cow[$i]['YETERLILIK_ID'].'" />'.
						'<input type="hidden" name="sinavtur" value="'.$cow[$i]['SINAV_TURU'].'" />'.
						trim($cow[$i]['YETERLILIK_KODU']).'/'.$cow[$i]['REVIZYON'].'-'.$cow[$i]['YETERLILIK_ADI'].' - '.($cow[$i]['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>").'</td>';
				if($cow[$i]['BILDIRIM_DURUMU'] == 1){
					echo '<td align="center"><button style="background-color:green;color:white;" type="button" onclick=bildirimIptal("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'")>Aktif</button> </td>';	
				}else{
					echo '<td align="center"><button style="background-color:red;color:white;" type="button" onclick=bildir("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'")>Pasif</button> </td>';
				}
				if($cow[$i]['ONAY_DURUMU'] == 1 || $cow[$i]['TEMIN_DURUMU'] == 2){
					echo '<td align="center"><button  style="background-color:green;color:white;" type="button">Onaylandı</button> </td>';
				}else{
					echo '<td align="center"><button  style="background-color:red;color:white;" type="button">Onay Bekliyor</button> </td>';
				}
				echo '<td  align="center">'.($cow[$i]['OLUSTURMA_TARIHI'] == "" ? "-" : substr($cow[$i]['OLUSTURMA_TARIHI'],0,10)).'</td>';
				echo '<td  align="center">'.($cow[$i]['ONAY_TARIHI'] == "" ? "-" : substr($cow[$i]['ONAY_TARIHI'],0,10)).'</td>';
				echo '<td  align="center"><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/32pdf.png" onclick=pdfGoster("'.$key.'_'.$cow[$i]['YETERLILIK_ID'].'_'.$cow[$i]['SINAV_TURU'].'") /></td>';
				echo '</tr>';
			}
		}
	}	?>
	</tbody>
</table>
<?php	
}?>

</div>

<div id="sinavYeriUp" style="width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=SinavYeriUpdate"  method="POST" id="sinavYeriUpdateForm">
	<h2><u>Sınav Merkezine Yeni Yeterlilik Ekle</u></h2><br>
		<div id="yets">
		</div>
		<input type="hidden" name="yerId" id="yerId" value=""/><br>
		<button type="submit">Kaydet</button>
	</form>
</div>
<div id="yeterlilikUygunlukFormuPanel" style="width: 40%; min-height:80px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=SinavYeriYeterlilikUygunlukSozlesmeFormuEkle"  method="POST" id="yeterlilikUygunlukPanelForm" enctype="multipart/form-data">
	<h2><u>Protokol / Sözleşme / Uygunluk Değerlendirme Formu</u></h2><br>
		<div id="yets">
		</div>
		<table width="100%">
			<tr>
				<td width="40%">Protokol / Sözleşme Formu : </td>
				<td width="60%">
					<input type="file" name="sinav_yeri_yeterlilik_sozlesme_formu" id="sinav_yeri_yeterlilik_sozlesme_formu" />
					<span></span>
				</td>
			</tr>
			<tr>
				<td>Uygunluk Değerlendirme Formu :</td>
				<td>
					<input type="file" name="sinav_yeri_yeterlilik_uygunluk_formu" id="sinav_yeri_yeterlilik_uygunluk_formu" />
					<span></span>
				</td>
			</tr>
		</table>
		<input type="hidden" name="yerid"/>
		<input type="hidden" name="yetid"/>
		<input type="hidden" name="sinavtur"/>
		<button type="submit" style="float:right;">Kaydet</button>
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var sinavyeterlilik = '<?php echo $yetOption;?>';
	
	jQuery('#sinavs').live('click',function(e){
		e.preventDefault();

		jQuery("#sinavyerid").val("");
		jQuery("#yerAd").val("");
		jQuery("#adress").html("");
		jQuery("#adress").removeAttr("readonly");
		jQuery("#temin").val("");
		jQuery("#yeterlilikler").html(sinavyeterlilik);
		
		jQuery('#yeniSinav').show('slow');
		jQuery(this).attr('id','sinavsHide');
	});

	jQuery('#sinavsHide').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniSinav').hide('slow');
		jQuery(this).attr('id','sinavs');
	});
	jQuery(".submitexamplace").click(function(){
		jQuery.ajax({
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=sinavYeriOnayla&format=raw",
			data:'yerid='+jQuery(this).attr('yerid')+'&durum=1',
			success:function(data){
				if(data.STATUS && data.STATUS != ""){
					alert(data.RESULT);
					window.location.reload();
				}else{
					alert("Onay işleminde hata oluştu");
				}
			}
		});
	});
	jQuery(".submitexamplaceerror").click(function(){
		alert("İlgili sınav yeri dosya sorumlunuzca onay beklemektedir.");
		return false;
	});
	jQuery('#sinavKaydet').live('click',function(e){
		e.preventDefault();
		
		if(jQuery('#yerAd').val() == ''){
			alert('Lütfen sınav yeri adını giriniz.');
		}
		else if(jQuery('input[name="yets[]"]:checked').length == 0){
			alert('Lütfen en az bir tane yeterlilik seçiniz.');
		}
		else if(jQuery('#adress').val() == ''){
			alert('Lütfen adresi boş bırakmayınız.');
		}
		else if(jQuery('#temin').val() == ''){
			alert('Lütfen temin durumunu seçiniz.');
		}
		
		else{
			jQuery('#sinavYeriKaydetmeFormu').submit();
		}

		
	});
	
	jQuery("#yerGetir").live('click',function(){
		yerType = jQuery("input[name=yertype]").val();
		yerVal  = jQuery("input[name=yerval]").val();
		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_belgelendirme&task=sinavYeriGetirEdit&format=raw",
			data:'yerType='+yerType+'&yerVal='+yerVal,
			dataType: "json",
			success:function(data){
				if(data.SINAV_YERI_ID != ""){
					jQuery("#yeniSinav").show("slow");
					jQuery("#sinavyerid").val(data.SINAV_YERI_ID);
					jQuery("#yerAd").val(data.SINAV_YERI_ADI);
					jQuery("#adress").html(data.SINAV_YERI_ADRESI);
					jQuery("#adress").attr("readonly","readonly");
					jQuery("#temin").val(data.SINAV_YERI_TEMIN_DURUMU);
					options = "";
					jQuery.each(data.YETERLILIK, function( key, val ) {
						jQuery.each(val, function( key2, val2 ) {
							jQuery.each(val2, function( key3, val3 ) {
								options += '<br><input type="checkbox" checked="checked" name="yets[]" value="'+val3.YETERLILIK_ID+'-'+val3.SINAV_TURU+'"/>'+val3.YETERLILIK_KODU+'/'+val3.REVIZYON+' - '+val3.YETERLILIK_ADI+' - '+(val3.SINAV_TURU == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>");
								options += "<table width='60%'>"+
												"<tr>"+
													"<td width='25%'><b>Protokol / Sözleşme Formu : </b></td>"+
													"<td width='35%'>";
								if(val3.SOZLESME_FORMU != ""){
									options += "<a href='index.php?dl="+val3.SOZLESME_FORMU+"'>"+
													"<img alt='PDF'  src='<?php echo SITE_URL; ?>/templates/elegance/images/32pdf.png' />"+
												"</a>"+
												"<a href='javascript:void(0);' class='changedoc' code='"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"'>Değiştir</a>";
								}else{
									options += "<input type='file' name='sinav_yeri_yeterlilik_sozlesme_formu_"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"' id='sinav_yeri_yeterlilik_sozlesme_formu_"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"'><span></span>";
								}	
								options += 	"</td>"+
										"</tr>"+
										"<tr>"+
											"<td><b>Uygunluk Değerlendirme Formu :</b></td>"+
											"<td>";
								if(val3.UYGUNLUK_DEGERLENDIRME_FORMU != ""){
									options += "<a href='index.php?dl="+val3.UYGUNLUK_DEGERLENDIRME_FORMU+"'>"+
													"<img alt='PDF'  src='<?php echo SITE_URL; ?>/templates/elegance/images/32pdf.png' />"+
												"</a>"+
												"<a href='javascript:void(0);' class='changedoc2' code='"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"'>Değiştir</a>";
								}else{
									options += "<input type='file' name='sinav_yeri_yeterlilik_uygunluk_formu_"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"' id='sinav_yeri_yeterlilik_uygunluk_formu_"+val3.YETERLILIK_ID+"-"+val3.SINAV_TURU+"'><span></span>";
								}
								options += "</td>"+
										"</tr>"+ 
									"</table>";
							});
						});
					});
					jQuery("#yeterlilikler").html(options);
				}else{
					jQuery("#adress").removeAttr("disabled");
				}
			}
		});
	});



	jQuery(".changedoc").live('click',function(){
		jQuery(this).closest('td').html("<input type='file' name='sinav_yeri_yeterlilik_sozlesme_formu_"+jQuery(this).attr("code")+"'"+
			"id='sinav_yeri_yeterlilik_sozlesme_formu_"+jQuery(this).attr("code")+"'>");
	});
	jQuery(".changedoc2").live('click',function(){
		jQuery(this).closest('td').html("<input type='file' name='sinav_yeri_yeterlilik_uygunluk_formu_"+jQuery(this).attr("code")+"'"+
			"id='sinav_yeri_yeterlilik_uygunluk_formu_"+jQuery(this).attr("code")+"'>");
	});
	jQuery(".changeSozlesmeForm").live('click',function(){
		jQuery("#sinav_yeri_yeterlilik_sozlesme_formu").show();
		jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(0) td:eq(1) span').html("");
		jQuery('#yeterlilikUygunlukFormuPanel button[type=submit]').show();
	});
	
	jQuery(".changeUygunlukForm").live('click',function(){
		jQuery("#sinav_yeri_yeterlilik_uygunluk_formu").show();
		jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(1) td:eq(1) span').html("");
		jQuery('#yeterlilikUygunlukFormuPanel button[type=submit]').show();
	});

	jQuery("input[type=checkbox][name='yets[]']").live('click',function(){
		yetid = jQuery(this).val();
		if(this.checked){
			jQuery(this).next().after('<table width="60%">'+
					'<tr>'+
					'<td width="25%"><b>Protokol / Sözleşme Formu : </b></td>'+
					'<td width="35%">'+
						'<input type="file" name="sinav_yeri_yeterlilik_sozlesme_formu_'+yetid+'" id="sinav_yeri_yeterlilik_sozlesme_formu_'+yetid+'" />'+
						'<span></span>'+
					'</td>'+
				'</tr>'+
				'<tr>'+
					'<td><b>Uygunluk Değerlendirme Formu :</b></td>'+
					'<td>'+
						'<input type="file" name="sinav_yeri_yeterlilik_uygunluk_formu_'+yetid+'" id="sinav_yeri_yeterlilik_uygunluk_formu_'+yetid+'" />'+
						'<span></span>'+
					'</td>'+
				'</tr>'+
			'</table>');
			jQuery(this).next().next().show('slow');
		}else{
			jQuery(this).next().next().hide('slow');
		}
	});
});	

function silYetki(yerId){
// 	alert(yerId);
	var id = yerId.split('_');
	
	if(confirm('Sinav Merkezini Silmek İstediğinizden emin misiniz?')){
		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_belgelendirme&task=sinavYeriSil&format=raw",
			data:'yerId='+id[0]+'&yetId='+id[1]+'&sinavTur='+id[2],
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Silmek istediğiniz Sınav Merkezi daha önce kullanılmış. Silme yetkiniz yoktur.');
				}else{
					alert('Sınav Merkezi başarıyla silindi.');
					window.location.reload();
				}
			}
		});
	}
}

function newYet(yerId){
	jQuery.ajax({
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=sinavYeriNotYets&format=raw",
		data:'yerId='+yerId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var ekle = '';
				jQuery.each(dat,function(key,vall){
					ekle += '<input type="checkbox" value="'+vall['YETERLILIK_ID']+'-'+vall['SINAV_TURU']+'" name="yets[]" /> '+vall['YETERLILIK_KODU']+'/'+vall['REVIZYON']+' - '+vall['YETERLILIK_ADI']+' - '+(vall['SINAV_TURU'] == "T" ? "<b>TEORİK</b>" : "<b>PRATİK</b>")+'<br>';
				});
				jQuery('#sinavYeriUp #yets').html(ekle);
				jQuery('#sinavYeriUp #yerId').val(yerId);
				jQuery('#sinavYeriUp').lightbox_me({
					  centered: true,
// 					    closeClick:false,
// 					    closeEsc:false  
					});
			}else{
				alert('Sınav Merkezine eklenebilecek yeterlilik bulunmamaktadır.');
			}
		}
	});
}

function bildirimIptal(yerId){
	var id = yerId.split('_');

	jQuery.ajax({
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=sinavYeriBildirimIptal&format=raw",
		data:'yerId='+id[0]+'&yetId='+id[1],
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Sınav Merkezi yeterlilik bildirim iptali başarılı.');
				window.location.reload();
			}else{
				alert('Sınav Merkezi yeterlilik bildirimi iptalinde hata meydana geldi. Lütfen tekrar deneyiniz.');
				window.location.reload();
			}
		}
	});
}

function bildir(yerId){
	var id = yerId.split('_');

	jQuery.ajax({
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=sinavYeriBildirim&format=raw",
		data:'yerId='+id[0]+'&yetId='+id[1],
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Sınav Merkezi yeterlilik bildirimi başarılı.');
				window.location.reload();
			}else{
				alert('Sınav Merkezi yeterlilik bildiriminde hata meydana geldi. Lütfen tekrar deneyiniz.');
				window.location.reload();
			}
		}
	});
}

function pdfGoster(Ids){
	var id = Ids.split('_');
	yerid = id[0];
	yetid = id[1];
	sinavTur = id[2];
//		yerid = jQuery(this).closest("table").find("td:nth-child(1) input[name=yerid]").val();
//		yetid = jQuery(this).closest("tr").find("input[name=yetid]").val();
//		sinavTur = jQuery(this).closest("tr").find("input[name=sinavtur]").val();
	jQuery.ajax({
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_belgelendirme&task=sozlemeUygunlukFormu&format=raw",
		data:'yerId='+yerid+'&yetId='+yetid+'&sinavTur='+sinavTur,
		success:function(data){
			if(data.STATUS == 1){
				control = true;
				control2 = true;
				if(data.DATA.SOZLESME_FORMU != ""){
					control = false;
					sozlesme = data.DATA.SOZLESME_FORMU.split('/');
					jQuery("#sinav_yeri_yeterlilik_sozlesme_formu").hide();
					jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(0) td:eq(1) span').html(sozlesme[3]+"<a href='index.php?dl="+data.DATA.SOZLESME_FORMU+"' style='color:red; float:right;'>İndir</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' class='changeSozlesmeForm' style='color:red; float:right; padding-right:3px;'>Değiştir</a>");
				}else{
					jQuery("#sinav_yeri_yeterlilik_sozlesme_formu").show();
					jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(0) td:eq(1) span').html("");
				}
				if(data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU != ""){
					control2 = false;
					uygunluk = data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU.split('/');
					jQuery("#sinav_yeri_yeterlilik_uygunluk_formu").hide();
					jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(1) td:eq(1) span').html(uygunluk[3]+"<a href='index.php?dl="+data.DATA.UYGUNLUK_DEGERLENDIRME_FORMU+"' style='color:red; float:right;'>İndir</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' class='changeUygunlukForm' style='color:red; float:right; padding-right:3px;'>Değiştir</a>");
				}else{
					jQuery("#sinav_yeri_yeterlilik_uygunluk_formu").show();
					jQuery('#yeterlilikUygunlukFormuPanel table tr:eq(1) td:eq(1) span').html("");
				}

				if(!control && !control2){
					jQuery('#yeterlilikUygunlukFormuPanel button[type=submit]').hide();
				}else{
					jQuery('#yeterlilikUygunlukFormuPanel button[type=submit]').show();
				}
				jQuery("#yeterlilikUygunlukFormuPanel input[name=yerid]").val(yerid);
				jQuery("#yeterlilikUygunlukFormuPanel input[name=yetid]").val(yetid);
				jQuery("#yeterlilikUygunlukFormuPanel input[name=sinavtur]").val(sinavTur);
				jQuery('#yeterlilikUygunlukFormuPanel').lightbox_me({
					centered: true
				});
			}else{
				alert("Teknik bir hata oluştu.Lütfen daha sonra tekrar deneyiniz!");
			}
		}
	});
}
</script>