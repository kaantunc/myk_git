<?php
echo $this->pageTree;
$kurulus = $this->kurulus;
$taahut = $this->taahut;
if($taahut){
	$tahVarmi = 0;
}else{
	$tahVarmi = 1;
}
?>
<style>
#navigation {
    width:250px;
}
#content {
    width:700px;
}
#navigation,
#content {
    float:left;
    margin:10px;
}
.collapsible,
.page_collapsible {
    margin: 0;
    padding:10px;
    height:20px;

    border-top:#f0f0f0 1px solid;

	background:url(templates/paradigm_shift/images/title_arrow_green.png) no-repeat #cdcdcd scroll 15px 12px;
    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-transform:uppercase;
    color: #000;
    font-size:1em;
    cursor: pointer;
    font-weight: bold;
}

.collapsible em{
	padding: 0 0 0 25px; 
}
.collapse-open {
    background:url(templates/paradigm_shift/images/title_arrow.png) no-repeat #1C617C scroll 15px 12px;
    color: #fff;
}

.collapse-open span {
    display:block;
    float:right;
    padding:10px;
}

.collapse-open span {
    background:url(images/minus_white.png) center center no-repeat;
}

.collapse-close span {
    display:block;
    float:right;
    background:url(images/plus_green.png) center center no-repeat;
    padding:10px;
}

div.container {
    padding:0;
    margin:0;
}

div.content {
    background:#fafafa;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}

div.content ul, div.content p {
    margin:0;
    padding:3px;
}

div.content ul li {
    list-style-position:inside;
    line-height:25px;
}

div.content ul li a {
    color:#555555;
}

code {
    overflow:auto;
}
.form_item{
	padding: 5px 0 5px 0;
}
.form_item input{
	float:none;
}
</style>
<div class="anaDiv text-center">
	<div class="divYan">
		<a href="#" class="btn btn-sm btn-primary">Denetçi</a>
	</div>
	<div class="divYan">
		<?php if(in_array(3, $this->BilgiOnay) && in_array(4, $this->BilgiOnay)){?>
		<button type="button" onclick="FuncTeknikBilgiOnaylimi(true)" class="btn btn-xs btn-default">Teknik Uzman</button>
		<?php }else{ ?>
		<button type="button" onclick="FuncTeknikBilgiOnaylimi(false)" class="btn btn-xs btn-default">Teknik Uzman</button>
		<?php } ?>
	</div>
<!-- 	<div class="divYan">
		<a href="index.php?option=com_uzman_basvur&view=uzman_basvur&layout=moderator&tc_kimlik=<?php echo $this->evrak_id;?>" class="btn btn-sm btn-default">Moderatör</a>
 	</div> -->
</div>

<form method="POST" id="DenetciForm" enctype="multipart/form-data" action="index.php?option=com_uzman_basvur&layout=denetci&task=basvuruKaydet">
<input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
<div class="anaDiv font18">
	<div class="div40 hColor">
		MYK Denetim Etiği Taahhütnamesi:
	</div>
	<div class="div60">
	<?php if($taahut){ ?>
		<a href="index.php?dl=<?php echo $taahut['BELGE_PATH'];?>"><img src="index.php?img=ekler/pdf48.png" /></a>
	<?php }else{ ?>
		<input type="file" name="detTaahut" class="input-sm inputW100"/>
	<?php } ?>
	</div>
	<div class="div95 font12 fontBold" style="margin-top:5px;">
		Not: Denetçi Başvurunuzun değerlendirilmesi için <a href="index.php?dl=ekler/MYKDenetimTaahutname.pdf" class="text-underline font16"><strong>MYK Denetim Etiği Taahhütnamesi</strong></a>'nin çıktısını alıp  
		imzayalarak sisteme yüklemeniz gerekmektedir. 
	</div>
	<?php if($taahut && $kurulus['DENETCI'] == 0){ ?>
	<div class="div95 text-right">
		<button type="button" class="btn btn-sm btn-danger" onclick="FuncTaahutSil(<?php echo $this->evrak_id;?>)">Taahhütnameyi Sil</button>
	</div>
	<?php } ?>
	<?php if(empty($taahut) && ($kurulus['DENETCI'] == 0 || $this->canEdit)){?>
	<div class="div95 text-right">
		<button type="button" class="btn btn-sm btn-success" id="dtFormKaydet">Kaydet</button>
	</div>
	<?php }?>
</div>
<div class="anaDiv"><hr></div>

<div id="accordion_container" style="float:left; width:99%; margin-top:20px;">
	<div class="collapsible" id="section1"><em>Denetçi / Tetkikçi Belgesi</em><span></span></div>
	<div class="container">
		<div class="content">
			<div class="anaDiv">
			<table width="100%" style="text-align:center;margin-bottom:10px;border-radius:5px" border="1" class="display compact">
				<thead class="thPad5 bg-info">
					<tr>
						<th>Belge Adı</th>
						<th>Yükle / İncele</th>
						<th>Geçerlilik Tarihi</th>
						<th>Durumu</th>
						<th>Sil</th>
					</tr>
				</thead>
				<tbody id="dtBelge" class="tdPad5">
				<?php foreach($this->dtBelge as $row){
					echo '<tr id="bId_'.$row['BELGE_ID'].'">';
					echo '<td>'.$row['BELGE_ADI'].'</td>';
					echo '<td><a href="index.php?dl='.$row['BELGE_PATH'].'" target="_blank" class="btn btn-xs btn-primary">İndir</td>';
					echo '<td>'.$row['TARIH'].'</td>';
					if($this->canEdit){
							if($row['DURUM'] == 0){
								echo '<td>
    								<button type="button" class="btn btn-xs btn-success" onclick="FuncBelgeGecOnayla('.$row['BELGE_ID'].',1)">Onayla</button>
    								<button type="button" class="btn btn-xs btn-danger" onclick="FuncBelgeGecOnayla('.$row['BELGE_ID'].',-1)">Reddet</button>
    								</td>';
							}else if($row['DURUM'] == -1){
								echo '<td class="bg-danger text-white font16 fontBold">Reddedildi</td>';
							}else{
								echo '<td class="bg-success text-white font16 fontBold">Onaylandı</td>';
							}
					}else{
						if($row['DURUM'] != 2){
							echo '<td class="bg-info text-white font16 fontBold">Onay Bekleniyor</td>';
						}else if($row['DURUM'] == -1){
							echo '<td class="bg-danger text-white font16 fontBold">Reddedildi</td>';
						}else{
							echo '<td class="bg-success text-white font16 fontBold">Onaylandı</td>';
						}
					}
					
					if($kurulus['DENETCI'] == 0 || $this->canEdit){
						echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncBelgeGecSil('.$row['BELGE_ID'].')">Sil</button></td>';
					}else{
						echo '<td></td>';
					}

					echo '</tr>';
				}?>
				</tbody>
			</table>
			</div>
			<?php if($kurulus['DENETCI'] == 0 || $this->canEdit){?>
			<div class="anaDiv">
				<div class="div50">
					<button type="button" class="btn btn-sm btn-primary" id="dtBelgeEkle"><i class="fa fa-plus"></i> Yeni Denetçi/Tetkikçi Belgesi Ekle</button>
				</div>
				<div class="div50 text-right">
					<button type="button" class="btn btn-sm btn-success" id="dtFormKaydet">Kaydet</button>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
	<div class="collapsible" id="section2"><em>Denetim Deneyim Bilgileri</em><span></span></div>
	<div class="container">
		<div class="content">
			<div class="anaDiv font12 fontBold hColor">
				"Aynı Kuruluş tarafından aynı denetim türünde birden fazla denetimde görevlendirildiyseniz 
				bunları toplu olarak tek kayıtta girebilirsiniz."
			</div>
			<div class="anaDiv">
				<table width="100%" style="text-align:center;margin-bottom:10px;border-radius:5px" border="1" class="display compact">
					<thead class="thPad5 bg-info">
						<tr>
							<th>Tarih</th>
							<th>Denetim Türü</th>
							<th>Görevlendirilen Kuruluş</th>
							<th>Denetlenen Kuruluş</th>
							<th>Toplam Görev Süresi</th>
							<th>Açıklama</th>
							<th>Düzenle</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody id="dtDeneyim" class="tdPad5">
					<?php 
					foreach($this->dtDeneyim as $row){
						echo '<tr id="deneyim_'.$row['DENEYIM_ID'].'">';
						echo '<td>'.$row['TARIH'].'</td>';
						echo '<td>'.$row['DENETIM_TUR'].'</td>';
						echo '<td>'.$row['GOR_KUR'].'</td>';
						echo '<td>'.nl2br($row['DEN_KUR']).'</td>';
						echo '<td>'.$row['GOR_SURE'].'</td>';
						echo '<td>'.nl2br($row['ACIKLAMA']).'</td>';
						if($kurulus['DENETCI'] == 0 || $this->canEdit){
							echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncDeneyimDuz('.$row['DENEYIM_ID'].')">Düzenle</button></td>';
							echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncDeneyimSil('.$row['DENEYIM_ID'].')">Sil</button></td>';
						}else{
							echo '<td></td>';
							echo '<td></td>';
						}
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
			</div>
			<?php if($kurulus['DENETCI'] == 0 || $this->canEdit){ ?>
			<div class="anaDiv">
				<button type="button" class="btn btn-sm btn-primary" id="dtDeneyimEkle"><i class="fa fa-plus"></i> Yeni Deneyim Bilgisi Ekle</button>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="collapsible" id="section3"><em>Denetçi Başvurusunda Değerlendirilmesi İstenen Diğer Kanıtlayıcı Belgeler</em><span></span></div>
	<div class="container">
		<div class="content">
			<div class="anaDiv">
				<table width="100%" style="text-align:center;margin-bottom:10px;border-radius:5px" border="1" class="display compact">
					<thead class="thPad5 bg-info">
						<tr>
							<th>Belge Adı</th>
							<th>Belge</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody id="dtKanit" class="tdPad5">
					<?php foreach($this->dtKanit as $row){
						echo '<tr id="kId_'.$row['BELGE_ID'].'">';
						echo '<td>'.$row['BELGE_ADI'].'</td>';
						echo '<td><a href="index.php?dl='.$row['BELGE_PATH'].'" target="_blank" class="btn btn-xs btn-primary">İndir</td>';
						if($kurulus['DENETCI'] == 0 || $this->canEdit){
							echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncBelgeKanitSil('.$row['BELGE_ID'].')">Sil</button></td>';
						}else{
							echo '<td></td>';
						}
						echo '</tr>';
					}?>
					</tbody>
				</table>
			</div>
			<?php if($kurulus['DENETCI'] == 0 || $this->canEdit){ ?>
			<div class="anaDiv">
				<div class="div50">
					<button type="button" class="btn btn-sm btn-primary" id="dtKanitEkle"><i class="fa fa-plus"></i> Yeni Kanıtlayıcı Belge Ekle</button>
				</div>
				<div class="div50 text-right">
					<button type="button" class="btn btn-sm btn-success" id="dtFormKaydet">Kaydet</button>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="collapsible" id="section3"><em>Müsaitlik Durumu</em><span></span></div>
	<div class="container">
		<div class="content">
			<div class="anaDiv font12 fontBold hColor">
				Örnek: 'Her zaman, Her ayın 20'i ile 30'u arası, sadece hafta içi vb.'
			</div>
			<div class="anaDiv">
			<?php if($kurulus['DENETCI'] == 0 || $this->canEdit){ ?>
				<textarea rows="10" class="inputW100" name="musait"><?php echo $this->dtMusait?$this->dtMusait['MUSAIT']:''; ?></textarea>
			<?php }else{ ?>
				<textarea rows="10" class="inputW100" name="musait" readonly="readonly"><?php echo $this->dtMusait?$this->dtMusait['MUSAIT']:''; ?></textarea>
			<?php } ?>
			</div>
			<?php if($kurulus['DENETCI'] == 0 || $this->canEdit){ ?>
			<div class="anaDiv text-right">
				<button type="button" class="btn btn-sm btn-success" id="dtFormKaydet">Kaydet</button>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
</form>

<?php if($kurulus['DENETCI'] == 0){ ?>
<div class="anaDiv text-right">
	<button type="button" class="btn btn-sm btn-primary" onclick="FuncDenetciBasvuruKaydet('<?php echo $this->evrak_id;?>',1,<?php echo $tahVarmi;?>)">Denetçi Başvurusunu Tamamla</button>
</div>
<?php }else if($kurulus['DENETCI'] == 1 && $this->canEdit){ ?>
<div class="anaDiv text-right">
	<div class="divYan"><button type="button" class="btn btn-sm btn-primary" onclick="FuncDenetciBasvuruKaydet('<?php echo $this->evrak_id;?>',2,false)">Denetçi Başvurusunu Onayla</button></div>
	<div class="divYan"><button type="button" class="btn btn-sm btn-danger" onclick="FuncDenetciBasvuruKaydet('<?php echo $this->evrak_id;?>',0,false)">Denetçi Başvurusunu Reddet</button></div>
</div>
<?php }else if($kurulus['DENETCI'] == 2 && $this->Yönetici){ ?>
<div class="anaDiv text-right">
	<div class="divYan"><button type="button" class="btn btn-sm btn-primary" onclick="FuncDenetciBasvuruKaydet('<?php echo $this->evrak_id;?>',3,false)">Denetçi Başvurusunu Onayla</button></div>
	<div class="divYan"><button type="button" class="btn btn-sm btn-danger" onclick="FuncDenetciBasvuruKaydet('<?php echo $this->evrak_id;?>',0,false)">Denetçi Başvurusunu Reddet</button></div>
</div>
<?php } ?>

<script type="text/javascript">
function FuncDenetciBasvuruKaydet(tc,durum,taahut){
	if(confirm('Başvuruyu tamamladıktan sonra, denetçi başvuru bilgileri onaylanana kadar değişiklik yapamazsınız.')){
		if(jQuery('#dtBelge').length == 0){
			jQuery('#UyariContent').html('Denetçi / Tetkikçi Belgesi eklemeden başvuruyu tamamlayamazsnız.');
			UyariLightBox();
		}else if(taahut){
			jQuery('#UyariContent').html('Taahütnameyi eklemeden başvuruyu tamamlayamazsnız.');
			UyariLightBox();
		}else{
			jQuery.ajax({
				async: false,
		        type: 'POST',
		        url: "index.php?option=com_uzman_basvur&task=DenetciBasvurusuTamamla&format=raw",
		        data: 'tc='+tc+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					var durum = dat['durum'];
					var message = dat['message'];
					alert(message);
					window.location.reload();
				}else{
					alert('Denetçi Başvurusu Tamamlanamadı. Lütfen Tekrar Deneyin.');
				}
			});
		}
	}
	return false;
}
					
var dtBelge = '<tr>'+
'<td><input type="text" class="input-sm inputW95" name="dtBelgeAdi[]"/></td>'+
'<td><input type="file" class="input-sm inputW95" name="dtBelgeFile[]"/></td>'+
'<td><input type="text" class="input-sm inputW95 tarih" readonly="readonly" name="dtBelgeTarih[]"/></td>'+
'<td></td>'+
'<td><button type="button" class="btn btn-xs btn-danger" id="dtBelgeSil">Sil</button></td>'+
'</tr>';

var dtKanit = '<tr>'+
'<td><input type="text" class="input-sm inputW95" name="dtKanit[]"/></td>'+
'<td><input type="file" class="input-sm inputW95" name="dtKanitFile[]"/></td>'+
'<td><button type="button" class="btn btn-xs btn-danger" id="dtKanitSil">Sil</button></td>'+
'</tr>';

jQuery(document).ready(function(){
	jQuery('.collapsible').collapsible({
        defaultOpen: 'section1'
     });
	
	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});

	jQuery('#dtBelgeSil').live('click',function(e){
		e.preventDefault();
		jQuery(this).closest('tr').remove();
	});

	jQuery('#dtBelgeEkle').live('click',function(e){
		e.preventDefault();
		jQuery('#dtBelge').append(dtBelge);
	});

	jQuery('#dtKanitSil').live('click',function(e){
		e.preventDefault();
		jQuery(this).closest('tr').remove();
	});

	jQuery('#dtKanitEkle').live('click',function(e){
		e.preventDefault();
		jQuery('#dtKanit').append(dtKanit);
	});

	jQuery('#dtDeneyimSil').live('click',function(e){
		e.preventDefault();
		jQuery(this).closest('tr').remove();
	});

	jQuery('#dtDeneyimEkle').live('click',function(e){
		e.preventDefault();
		FuncDeneyimSifirla();
// 		jQuery('#dtDeneyim').append(dtDeneyim);
		jQuery('#DeneyimModal').lightbox_me({
        	centered: true,
            closeClick:false,
            closeEsc:false,
            overlayCSS: {background: 'black', opacity: .7}
        });
	});

	jQuery('#DeneyimIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#DeneyimModal').trigger('close');
	});

	jQuery('#DeneyimGonder').live('click',function(e){
		e.preventDefault();
		var dtTarih = jQuery('input[name="dtTarih"]').val();
		var dtTur = jQuery('input[name="dtTur"]').val();
		var dtGorKur = jQuery('input[name="dtGorKur"]').val();
		var dtDenKur = jQuery('textarea[name="dtDenKur"]').val();
		var dtSure = jQuery('input[name="dtSure"]').val();
		var dtAcik = jQuery('textarea[name="dtAcik"]').val();

		if(dtTarih == ''){
			jQuery('#UyariContent').html('Deneyim Bilgileri Ekleme Ekranında Tarih Alanını Boş Bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
	        	centered: true
	        });
		}else if(dtTur == ''){
			jQuery('#UyariContent').html('Deneyim Bilgileri Ekleme Ekranında Denetim Türü Alanını Boş Bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
	        	centered: true
	        });
		}else if(dtGorKur == ''){
			jQuery('#UyariContent').html('Deneyim Bilgileri Ekleme Ekranında Görevlendiren Kuruluş Alanını Boş Bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
	        	centered: true
	        });
		}else if(dtDenKur == ''){
			jQuery('#UyariContent').html('Deneyim Bilgileri Ekleme Ekranında Denetlenen Kuruluş Alanını Boş Bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
	        	centered: true
	        });
		}else if(dtSure == ''){
			jQuery('#UyariContent').html('Deneyim Bilgileri Ekleme Ekranında Toplam Görev Süresi Alanını Boş Bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
	        	centered: true
	        });
		}else{
			FuncDeneyimKaydet(jQuery('#DeneyimForm').serialize());
		}
// 		alert(jQuery('#DeneyimForm').serialize());
	});

	jQuery('#UyariIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#UyariModal').trigger('close');
	});

	jQuery('#dtFormKaydet').live('click',function(e){
		e.preventDefault();
		var dtBelgeHata = 0;
		jQuery('input[name="dtBelgeAdi[]"]').each(function(){
			if(jQuery(this).val() == ''){
				dtBelgeHata++;
			}
		});

		jQuery('input[name="dtBelgeTarih[]"]').each(function(){
			if(jQuery(this).val() == ''){
				dtBelgeHata++;
			}
		});

		var dtKanitHata = 0;
		jQuery('input[name="dtKanit[]"]').each(function(){
			if(jQuery(this).val() == ''){
				dtKanitHata++;
			}
		});

		if(dtBelgeHata > 0){
			jQuery('#UyariContent').html('Denetçi / Tetkikçi Belgesi Yükleme Alanında, Belge Adını, Denetçi/Tetkikçi Belgesini ve Belge Geçerlilik Tarihi alanlarını boş bırakmayınız.');
			UyariLightBox();
		}else if(dtKanitHata > 0){
			jQuery('#UyariContent').html('Denetçi Başvurusunda Değerlendirilmesi İstenen Diğer Kanıtlayıcı Belgesi Yükleme Alanında, Belge Adını ve Belge alanlarını boş bırakmayınız.');
			UyariLightBox();
		}else{
			jQuery('#DenetciForm').submit();
		}
	});
});

function FuncDeneyimSifirla(){
	jQuery('input[name="dtTarih"]').val('');
	jQuery('input[name="dtTur"]').val('');
	jQuery('input[name="dtGorKur"]').val('');
	jQuery('textarea[name="dtDenKur"]').val('');
	jQuery('input[name="dtSure"]').val('');
	jQuery('textarea[name="dtAcik"]').val('');
	jQuery('input[name="deneyimId"]').val(0);
	return false;
}

function FuncDeneyimKaydet(vall){
	CloseLightBox('div#DeneyimModal');
// 	OpenLightBox('div#loaderGif',200,250);
    
	var sonuc = FuncDeneyimKaydetAjax(vall);
// 	setTimeout(function(){}, 7000);

	if(sonuc){
// 		CloseLightBox('div#loaderGif');
		alert('Deneyim Bilgisi başarıyla eklendi.');
	}else{
// 		CloseLightBox('div#loaderGif');
// 		jQuery('#UyariContent').html('Deneyim Bilgisi kayıt aşamasında bir hata meydana geldi. Lütfen tekrar deneyin.');
// 		UyariLightBox('div#DeneyimModal');
		alert('Deneyim Bilgisi kayıt aşamasında bir hata meydana geldi. Lütfen tekrar deneyin.');
		OpenLightBox('div#DeneyimModal');
	}
}

function FuncDeneyimKaydetAjax(vall){
	var sonuc = false;
	jQuery.ajax({
    	async:false,
        type: 'POST',
        url: "index.php?option=com_uzman_basvur&task=DenetciDeneyimKaydet&format=raw",
        data:vall
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        var durum = dat['durum'];
        if(durum){
            var deger = dat['deger'];
            var ekle = '<tr id="deneyim_'+deger['DENEYIM_ID']+'">';
            ekle += '<td>'+deger['TARIH']+'</td>';
            ekle += '<td>'+deger['DENETIM_TUR']+'</td>';
            ekle += '<td>'+deger['GOR_KUR']+'</td>';
            ekle += '<td>'+deger['DEN_KUR']+'</td>';
            ekle += '<td>'+deger['GOR_SURE']+'</td>';
            ekle += '<td>'+deger['ACIKLAMA']+'</td>';
            ekle += '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncDeneyimDuz('+deger['DENEYIM_ID']+')">Düzenle</button></td>';
            ekle += '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncDeneyimSil('+deger['DENEYIM_ID']+')">Sil</button></td>';
            ekle += '</tr>';

            jQuery('tr#deneyim_'+deger['DENEYIM_ID']).remove();
            
            jQuery('#dtDeneyim').append(ekle);
            sonuc = true;
        }else{
            sonuc = false;
        }
    });
    return sonuc;
}

function CloseLightBox(ele){
	jQuery(ele).trigger('close');
	return true;
}

function OpenLightBox(ele, overSpeed, boxSpeed){
	jQuery(ele).lightbox_me({
		overlaySpeed: 350,
		lightboxSpeed: 400,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

function UyariLightBox(sonra){
	if(sonra){
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7},
	        onClose: OpenLightBox(sonra)
	    });
	}else{
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	}
}

function FuncDeneyimSil(deneyimId){
	if(confirm('Deneyim bilgisiniz silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_uzman_basvur&task=DenetciDeneyimSil&format=raw",
	        data: "deneyimId="+deneyimId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('#deneyim_'+deneyimId).remove();
			}else{
				jQuery('#UyariContent').html('Deneyim bilgisi silinemedi. Sayfayı yenileyip tekrar deneyin.');
				UyariLightBox();
			}
		});
	}
	return false;
}

function FuncDeneyimDuz(deneyimId){
	jQuery.ajax({
		async:false,
        type: 'POST',
        url: "index.php?option=com_uzman_basvur&task=DenetciDeneyimGetir&format=raw",
        data: "deneyimId="+deneyimId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#DeneyimForm input[name="dtTarih"]').val(dat['TARIH']);
			jQuery('#DeneyimForm input[name="dtTur"]').val(dat['DENETIM_TUR']);
			jQuery('#DeneyimForm input[name="dtGorKur"]').val(dat['GOR_KUR']);
			jQuery('#DeneyimForm textarea[name="dtDenKur"]').val(dat['DEN_KUR']);
			jQuery('#DeneyimForm input[name="dtSure"]').val(dat['GOR_SURE']);
			jQuery('#DeneyimForm textarea[name="dtAcik"]').val(dat['ACIKLAMA']);
			jQuery('#DeneyimForm input[name="deneyimId"]').val(dat['DENEYIM_ID']);

			OpenLightBox('#DeneyimModal');
			
		}else{
			jQuery('#UyariContent').html('Sayfayı yenileyip, tekrar deneyin.');
			UyariLightBox();
		}
	});
}

function FuncBelgeGecSil(bId){
	if(confirm('Belgeyi silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_uzman_basvur&task=DenetciBelgeGecSil&format=raw",
	        data: "bId="+bId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('tr#bId_'+bId).remove();
			}else{
				jQuery('#UyariContent').html('Sayfayı yenileyip tekrar deneyin.');
				UyariLightBox();
			}
		});
	}
	return false;
}

function FuncBelgeKanitSil(kId){
	if(confirm('Belgeyi silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_uzman_basvur&task=DenetciBelgeKanitSil&format=raw",
	        data: "kId="+kId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('tr#kId_'+kId).remove();
			}else{
				jQuery('#UyariContent').html('Sayfayı yenileyip tekrar deneyin.');
				UyariLightBox();
			}
		});
	}
	return false;
}

function FuncBelgeGecOnayla(bId,durum){
	if(durum == -1){
		if(confirm('Belgeyi reddetmek istediğizden emin misiniz?')){
			jQuery.ajax({
				async:false,
		        type: 'POST',
		        url: "index.php?option=com_uzman_basvur&task=DenetciBelgeDurumKaydet&format=raw",
		        data: "bId="+bId+'&durum='+durum
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Belge Reddedildi.');
					window.location.reload();
				}else{
					jQuery('#UyariContent').html('Sayfayı yenileyip tekrar deneyin.');
					UyariLightBox();
				}
			});
		}
	}else{
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_uzman_basvur&task=DenetciBelgeDurumKaydet&format=raw",
	        data: "bId="+bId+'&durum='+durum
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Belge Onaylandı.');
				window.location.reload();
			}else{
				jQuery('#UyariContent').html('Sayfayı yenileyip tekrar deneyin.');
				UyariLightBox();
			}
		});
	}
	return false;
}

function FuncTeknikBilgiOnaylimi(durum){
	if(durum){
		window.location.href = "index.php?option=com_uzman_basvur&view=uzman_basvur&layout=teknik_uzman&tc_kimlik=<?php echo $this->evrak_id;?>";
	}else{
		jQuery('#UyariContent').html("Teknik Uzman Başvurusu yapmak için öncelikle, 'TEKNİK UZMANIN SAHİP OLMASI GEREKEN NİTELİKLER' ve 'TEKNİK UZMANIN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI' bilgilerini okuyup, onaylamanız gerekmektedir.");
		OpenLightBox('#UyariModal');
	}
}

function FuncTaahutSil(uId){
	if(confirm('Taahütnameyi silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_uzman_basvur&task=TaahutSil&format=raw",
	        data: "uId="+uId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Taahütname başarıyla silindi.');
				window.location.reload();
			}else{
				jQuery('#UyariContent').html('Bir hata meydana geldi. Sayfayı yenileyip tekrar deneyin.');
				UyariLightBox();
			}
		});
	}

	return false;
}

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
</script>

<!-- Denetçi Deneyim MODAL Bas -->
<div id="DeneyimModal" style="width:500px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form id="DeneyimForm">
    	<div class="anaDiv text-center font20 hColor">
    		Deneyim Bilgileri Ekleme Ekranı
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Tarih:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm inputW100" name="dtTarih"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Denetim Türü:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm inputW100" name="dtTur"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Görevlendiren Kuruluş:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm inputW100" name="dtGorKur" />
    		</div>
    	</div>
    	<div class="anaDiv" style="display:inline-flex">
    		<div class="div40 font16 hColor">
    			Denetlenen Kuruluş:
    		</div>
    		<div class="div60">
    			<textarea class="inputW100" name="dtDenKur" ></textarea>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Toplam Görev Süresi:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm inputW100" name="dtSure" />
    		</div>
    	</div>
    	<div class="anaDiv" style="display:inline-flex">
    		<div class="div40 font16 hColor">
    			Açıklama:
    		</div>
    		<div class="div60">
    			<textarea class="inputW100" name="dtAcik"></textarea>
    		</div>
    	</div>
    	<div class="anaDiv text-right">
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-danger" id="DeneyimIptal">İptal</button>
    		</div>
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-success" id="DeneyimGonder">Kaydet</button>
    		</div>
    	</div>        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="deneyimId" id="deneyimId" value="0"/>
	</form>
</div>
<!-- Denetçi Deneyim MODAL SON -->

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="UyariModal" class="bg-danger" style="color:#ffffff; width: 500px; min-height:100px; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 text-center fontBold">
		Uyarı
	</div>
	<div class="anaDiv font16 fontBold" id="UyariContent">
		
	</div>
	<div class="anaDiv text-right">
		<button type="button" class="btn btn-xs btn-default" id="UyariIptal">Kapat</button>
	</div>
</div>