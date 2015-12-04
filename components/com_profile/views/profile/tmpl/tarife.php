<style>
.btnYeniYetki{
	color:#ffffff;
	background-color:#71CEED;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
.btnKaydet{
	color:#ffffff;
	background-color:#71CEED;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
.btnIptal{
	color:#ffffff;
	background-color:#D24231;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
.divBorder{
	border: 1px solid #1C617C;;
	width:99%;
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
$kurulus = $this->kurulus_bilgi;
$yetkiYets = $this->yetkiYets;
$pata = $this->yetkiBirims;
$yetkiBirims = $pata['yetkiBirims'];
$turs = $pata['turs'];
$ucrets = $pata['ucrets'];
$detay = $this->detay;
$OnayliUcretYets = $this->OnayliUcretYets;
$OnayBekleyenTarifeler = $this->OnayBekleyenTarifeler;
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
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
	foreach($yetkiBirims[$row['YETERLILIK_ID']] as $cow){
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
if(isset($row['UCRET'])){
	if(!empty($row['UCRET'])){
?>
<div class="anaDiv">
	<div class="div50 font18 hColor">
		<span>Yeterlilik için toplam ücret bedeli:</span> <span class="basUcret"><?php echo $row['UCRET']; ?></span>
	</div>	
	<?php 
	if(array_key_exists($row['YETERLILIK_ID'], $OnayliUcretYets)){
	?>
	<div class="div50 text-right font16">
		<p><span class="hColor">Ücret Tarifesi Başlangıç Dönemi:</span> <?php echo $OnayliUcretYets[$row['YETERLILIK_ID']]['TARIH'];?></p>
		<p><span class="hColor">Ücret Tarifesi Dönemi:</span> <?php echo $OnayliUcretYets[$row['YETERLILIK_ID']]['DONEM'];?></p>
	</div>
	<?php
	}
	?>
</div>
<?php 
	} 
}

if(array_key_exists($row['YETERLILIK_ID'], $OnayBekleyenTarifeler)){
	if($this->canEdit){
		if($OnayBekleyenTarifeler[$row['YETERLILIK_ID']]['DURUM'] == 1){
		?>
		<div class="anaDiv text-warning font18 text-right">
			Dosya sorumlusu onayı bekleniyor.
		</div>
		<?php
		}else if($OnayBekleyenTarifeler[$row['YETERLILIK_ID']]['DURUM'] == 2){
		?>
		<div class="anaDiv text-warning font18 text-right">
			Yönetici onayı bekleniyor.-
		</div>
		<?php
		}
	}else{
	?>
	<div class="anaDiv text-warning font18 text-right">
		Onay bekleniyor.
	</div>
	<?php
	}
	
?>

<?php
}
?>

<div class="anaDiv" style="text-align: right;">
	<button type="button" class="btn btn-sm btn-info" onclick="FuncUcretTarfie(<?php echo $kurulus['USER_ID'];?>,<?php echo $row['YETERLILIK_ID'];?>)">Ücret Tarifesi Düzenle</button>
</div>

<div class="divBorder"></div>
<?php
}
?>

<form method="post" enctype="multipart/form-data" action="index.php?option=com_profile&task=UcretSartKaydet">
<input type="hidden" name="kurId" value="<?php echo $kurulus['USER_ID'];?>"/>
<div class="anaDiv">
	<h2>Genel Şartlar ve Açıklamalar</h2>
</div>
<div class="anaDiv">
	<textarea rows="10" name="detay" style="width:100%"><?php echo $detay;?></textarea>
</div>
<div class="anaDiv">
<button type="submit" class="btnYeniYetki">Kaydet</button>
</div>
</form>

<div id="YetkiBirimUcret" style=" max-width: 70%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
<form method="post" enctype="multipart/form-data" action="index.php?option=com_profile&task=UcretKaydet">		
    <div class="anaDiv">
    	<h2 id="YetAdi"></h2>
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
			<tbody class="birimsTbody" id="BirimsUcret">
			
			</tbody>
		</table>
    </div>
    
    <input type="hidden" name="kId" value="<?php echo $kurulus['USER_ID'];?>"/>
    <input type="hidden" name="yId" />
    <input type="hidden" name="dId" />
    <div class="anaDiv">
    	<div class="div30 font16 hColor">
    		Yeterlilik için toplam ücret bedeli:
    	</div>
    	<div class="div70">
    		<input type="text" class="input-sm text-end" name="YetUcret" />
    	</div>
	</div>
	<div class="anaDiv">
    	<div class="div30 font16 hColor">
    		Dönem Başlangıç Tarihi:
    	</div>
    	<div class="div70">
    		<input type="text" class="input-sm text-end tarih" name="UcretDonem" />
    	</div>
	</div>
    <div class="anaDiv">
    	<div class="div50">
	    	<button type="submit" class="btn btn-sm btn-success" id="KaydetBtn">Kaydet</button>
		    <button type="button" id="UcretIptal" class="btn btn-sm btn-danger">İptal</button>
    	</div>
    	<div class="div25 text-right" id="kurOnay" style="display:none">
    		<button type="button" class="btn btn-sm btn-warning" onclick="FuncOnayaGonder(1)">Onaya Gönder</button>
    	</div>
    	<div class="div25 text-right" id="dsOnay" style="display:none">
    		<button type="button" class="btn btn-sm btn-warning" onclick="FuncOnayaGonder(2)">Onayla</button>
    	</div>
    	<div class="div25 text-right" id="yonOnay" style="display:none">
    		<button type="button" class="btn btn-sm btn-warning" onclick="FuncOnayaGonder(3)">Onayla</button>
    	</div>
    	<div class="div25 text-right" id="OnayReddet" style="display:none">
    		<button type="button" class="btn btn-sm btn-danger" onclick="FuncOnayaGonder(0)">Reddet</button>
    	</div>
    </div>
</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery('#UcretIptal').live('click',function(){
		jQuery('#YetkiBirimUcret').trigger('close');
	});

	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});
});

function FuncOnayaGonder(durum){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_profile&task=ajaxUcretOnayaGonder&format=raw",
		data:'uId='+jQuery('#YetkiBirimUcret input[name="kId"]').val()+'&yId='+jQuery('#YetkiBirimUcret input[name="yId"]').val()+'&durum='+durum+'&donemId='+jQuery('#YetkiBirimUcret input[name="dId"]').val()
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			if(durum == 3){
				alert('Yeterlilik Ücret Tarifesi Başarıyla Onaylandı.');
			}else if(durum == 2){
				alert('Yeterlilik Ücret Tarifesi Başarıyla Yönetici Onayına Sunuldu.');
			}else if(durum == 1){
				alert('Yeterlilik Ücret Tarifesi Başarıyla Dosya Sorumlusunun Onayına Sunuldu.');
			}else if(durum == 0){
				alert('Yeterlilik Ücret Tarifesi Başarıyla Reddedildi.');
			}
			window.location.reload();
		}else{
			alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			window.location.reload();
		}
	});
}

function FuncUcretTarfieYetkiliMi(uId,yId){
	var durum = false;
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_profile&task=ajaxGetYetUcretYetkilimi&format=raw",
		data:'uId='+uId+'&yId='+yId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		durum = dat;
	});
	return durum;
}

function FuncUcretTarfie(uId,yId){
	var yetkiliMi = FuncUcretTarfieYetkiliMi(uId,yId);
	if(yetkiliMi){
		jQuery('#YetkiBirimUcret input[name="dId"]').val(0);
		jQuery('#YetkiBirimUcret input[name="UcretDonem"]').val('');
		jQuery('#YetkiBirimUcret input[name="YetUcret"]').val('');

		jQuery('#kurOnay').hide();
		jQuery('#dsOnay').hide();
		jQuery('#yonOnay').hide();
		jQuery('#OnayReddet').hide();
		
		jQuery.ajax({
			async:false,
			type:'POST',
			url:"index.php?option=com_profile&task=ajaxGetYetUcret&format=raw",
			data:'uId='+uId+'&yId='+yId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('#YetkiBirimUcret input[name="yId"]').val(yId);
				var yets = dat['yets'];
				var birims = dat['birims']['yetkiBirims'];
				var donemBilgi = dat['donemBilgi'];
				var donemId = 0;
				var donemDurum = 0;
				if(donemBilgi){
					if(donemBilgi['DURUM'] == 3){
						donemId = 0;
					}else{
						donemId = donemBilgi['DONEM_ID'];
					}
					donemDurum = donemBilgi['DURUM'];
					jQuery('#YetkiBirimUcret input[name="UcretDonem"]').val(donemBilgi['TARIH']);

					if(donemDurum == 0){
						jQuery('#kurOnay').show();
					}else if(donemDurum == 1){
						jQuery('#dsOnay').show();
						jQuery('#OnayReddet').show();
					}else if(donemDurum == 2){
						jQuery('#yonOnay').show();
						jQuery('#OnayReddet').show();
					}
				}
				
				jQuery('#YetkiBirimUcret input[name="dId"]').val(donemId);
				
				jQuery('#YetkiBirimUcret h2#YetAdi').html(yets['YETERLILIK_KODU']+'/'+yets['REVIZYON']+' '+yets['YETERLILIK_ADI']);
				jQuery('#YetkiBirimUcret input[name="YetUcret"]').val(yets['UCRET']);

				var say = 1;
				var bgcolor = 'bgcolor="#efefef"';
				var ekle = '';
				jQuery.each(birims,function(key,val){
					if(say%2 == 0){
						bgcolor = 'bgcolor="#efefef"';
					}else{
						bgcolor = 'bgcolor="#ffffff"';
					}
					ekle += '<tr '+bgcolor+'>';
					
					ekle += '<td>'+say+'</td>';

					if(val['YET_ESKI_MI'] == 1){
						ekle +=  '<td>'+yets['YETERLILIK_KODU']+'/'+val['BIRIM_KODU']+' '+val['BIRIM_ADI']+'</td>';
					}else{
						ekle +=  '<td>'+val['BIRIM_KODU']+' '+val['BIRIM_ADI']+'</td>';
					}

					if(val['UCRET'].length>0 || val['UCRET'] != ''){
						ekle += '<td><input class="input-sm inputW95 text-end" type="text" name="BirimUcret['+val['BIRIM_ID']+']" value="'+val['UCRET']+'" onkeypress="return isNumberKey(event)"/></td>';
					}else{
						ekle += '<td><input class="input-sm inputW95 text-end" type="text" name="BirimUcret['+val['BIRIM_ID']+']" onkeypress="return isNumberKey(event)"/></td>';
					}
					
					ekle += '</tr>';
					
					say++;
				});

				
				jQuery('#BirimsUcret').html(ekle);
				jQuery('#YetkiBirimUcret').lightbox_me({
					centered: true,
				    closeClick:false,
				    closeEsc:false
				});
			}
	});
		
	}else{
		alert('Bu Yeterliliğin Ücret Tarifesi Onay Beklemektedir. Dosya Sorumlusu Onaylamadan Veya Reddetmeden Değişiklik Yapamazsınız.');
	}	
}

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;

   if(charCode != 8 
		   && !(charCode == 46 && evt.target.value.indexOf('.') <= 0) 
		   && !(charCode >= 48 && charCode <= 57) 
		   && !(charCode >= 35 && charCode <= 40) 
		   ){
	   return false;
	}

	return true
}
</script>