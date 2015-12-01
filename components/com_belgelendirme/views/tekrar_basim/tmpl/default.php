<?php
$BasimTalepSel = '<option value="0">Seçiniz</option>';
foreach($this->BasimTalep as $row){
	$BasimTalepSel .= '<option value="'.$row['BASIM_ID'].'">'.$row['BASIM_ID'].' - '.$row['BELGENO'].' - '.$row['AD'].' '.$row['SOYAD'].'</option>';
}
?>
<div class="anaDiv">
	<div class="divYan">
		<a href="index.php?option=com_belgelendirme&view=belge_olusturma" class="btn btn-xs btn-primary">Belge Başvuruları</a>
	</div>
	<div class="divYan">
		<a href="index.php?option=com_belgelendirme&view=tekrar_basim" class="btn btn-success">Belge Tekrar Basım Başvuruları</a>
	</div>
</div>
<div class="anaDiv text-center font20 hColor">
	Belge Tekrar Basım İşlemleri
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv">
	<div class="div30 font16 hColor">
		Tekrar Basım Başvuruları:
	</div>
	<div class="div70">
		<select id="BasimSelId" class="input-sm"><?php echo $BasimTalepSel;?></select>
	</div>
</div>
<div class="anaDiv text-center">
	<button type="button" class="btn btn-xs btn-primary" id="TekBelGetir">Getir</button>
</div>
<div class="anaDiv"><hr></div>
<div id="BelgeBilgi" style="display:none">
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Belge No:</h2></div>
		<div class="div80 fRight" id="BelgeNo"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">TC Kimlik No:</h2></div>
		<div class="div80 fRight" id="BelgeTc"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft hColor"><h2 class="hColor font16">Adı:</h2></div>
		<div class="div80 fRight" id="BelgeAd"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Soyadı:</h2></div>
		<div class="div80 fRight" id="BelgeSoyad"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Yeterlilik:</h2></div>
		<div class="div80 fRight" id="BelgeYeterlilik"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Seviye:</h2></div>
		<div class="div80 fRight" id="BelgeYetSeviye"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Belgelendirme Kuruluşu:</h2></div>
		<div class="div80 fRight" id="BelgeKur"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Belge Düzenlenme Tarihi:</h2></div>
		<div class="div80 fRight" id="BelgeTarih"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Belge Geçerlilik Tarihi:</h2></div>
		<div class="div80 fRight" id="BelgeBitTarih"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">İmza Yetkilisi:</h2></div>
		<div class="div80 fRight" id="BelgeYetkili"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">İmza Yetkilisi Ünvan:</h2></div>
		<div class="div80 fRight" id="BelgeYetkiliUnvan"></div>
	</div>
	<div class="anaDiv" style="display:none" id="DekBilgi">
		<div class="div20 font16 hColor fLeft">Dekont</div>
		<div class="div80 fRight" id="dekontlar"></div>
	</div>
	<div class="anaDiv font16">
		<div class="div20 fLeft"><h2 class="hColor font16">Belge Tekrar Basım Nedeni:</h2></div>
		<div class="div80 fRight" id="BelgeBasimNeden"></div>
	</div>
	<div class="anaDiv">
		<div class="divYan">
			<button type="button" class="btn btn-sm btn-primary" id="BasimBirim">Başarılı Olduğu Birimler</button>
		</div>
		<div class="divYan">
			<a href="#" target="_blank" class="btn btn-sm btn-warning" id="BasimExcel">Belge Basım Exceli</a>
		</div>
		<input type="hidden" id="BasimId" value="0" />
	</div>
	<div class="anaDiv"><hr></div>
	<div class="anaDiv">
		<div class="divYan">
			<button type="button" class="btn btn-sm btn-success" onclick="BasimaGonder()">Basıma Gönder</button>
		</div>
		<div class="divYan">
			<button type="button" class="btn btn-sm btn-danger" onclick="BasimIptal()">Basıma Göndermeyi İptal Et</button>
		</div>
	</div>
</div>

<div id="BasariliBirim" style="min-width: 30%; max-width:60%; min-height:50px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
		<h2 class="text-primari">Belge Üzerine Yazılacak Başarılı Birimler</h2>
	</div>
	<div class="anaDiv" id="birims">
    	
    </div>
    <input type="hidden" id="belgeId" />
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#TekBelGetir').live('click',function(){
		if(jQuery('#BasimSelId').val() == 0){
			alert('Lütfen Tekrar Basım için bir başvuru seçiniz.');
		}else{
			BasTalBilgileri(jQuery('#BasimSelId').val());
		}
	});

	jQuery('#BasimSelId').live('change',function(){
		SifirlaVeKapa();
	});

	jQuery('#BasimBirim').live('click',function(e){
		e.preventDefault();
		FuncBelgeBirim(jQuery('#belgeId').val());
	});
});

function SifirlaVeKapa(){
	jQuery('#BelgeNo').html('');
	jQuery('#BelgeTc').html('');
	jQuery('#BelgeAd').html('');
	jQuery('#BelgeSoyad').html('');
	jQuery('#BelgeYeterlilik').html('');
	jQuery('#BelgeYetSeviye').html('');
	jQuery('#BelgeKur').html('');
	jQuery('#BelgeTarih').html('');
	jQuery('#BelgeBitTarih').html('');
	jQuery('#BelgeYetkili').html('');
	jQuery('#BelgeYetkiliUnvan').html('');
	jQuery('#BelgeBasimNeden').html('');
	jQuery('#BasimExcel').attr('href','#');
	jQuery('#BasimId').val(0);
	jQuery('#dekontlar').html('');

	jQuery('#BelgeBilgi').hide();
	jQuery('#DekBilgi').hide();
}

function BasTalBilgileri(BasimId){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=TekrarBasimBilgi&format=raw",
		data:"BasimId="+BasimId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		var BB = dat['BasimBilgi'];
		var DB = dat['DekontBilgi'];

		jQuery('#BasimId').val(BB['BASIM_ID']);
		jQuery('#BelgeNo').html(BB['BELGENO']);
		jQuery('#BelgeTc').html(BB['TCKIMLIKNO']);
		jQuery('#BelgeAd').html(BB['AD']);
		jQuery('#BelgeSoyad').html(BB['SOYAD']);
		jQuery('#BelgeYeterlilik').html(BB['YETERLILIK_KODU']+'/'+BB['REVIZYON']+' '+BB['YETERLILIK_ADI']);
		jQuery('#BelgeYetSeviye').html(BB['SEVIYE_ID']);
		jQuery('#BelgeKur').html(BB['BELGELENDIRME_KURULUSU']);
		jQuery('#BelgeTarih').html(BB['BELGE_DUZENLEME_TARIHI']);
		jQuery('#BelgeBitTarih').html(BB['GECERLILIK_TARIHI']);
		jQuery('#BelgeYetkili').html(BB['IMZA_YETKILISI']);
		jQuery('#BelgeYetkiliUnvan').html(BB['IMZA_YETKILISI_UNVAN']);
		jQuery('#BelgeBasimNeden').html(BB['BASIM_NEDENI']);
		jQuery('#belgeId').val(BB['ID']);
		jQuery('#BasimExcel').attr('href','index.php?option=com_belgelendirme&view=tekrar_basim&layout=belgeExcel&belgeNo='+BB['BELGENO']);

		if(DB.length >0){
			var dek = '<table width="100%" style="text-align: center" border="1"><thead><tr><th>Dekont No.</th><th>Dekont</th><th>Dekont Tutarı</th><th>Dekont Tarihi</th></tr></thead>';
	        jQuery.each(DB,function(key,vall){
	            dek += '<tr>';
	            dek += '<td>'+vall['DEKONTNO']+'</td>';
	            var path = vall['DEKONT'];
	            var splitpath = path.split('.');
	            var urlpath = '';
	            if(vall['DEKONT']){
	                if(splitpath[splitpath.length-1] == 'pdf' || splitpath[splitpath.length-1] == 'PDF'){
	                    urlpath = 'index.php?dl=sinavBelgeTekrarDekont/'+BB['ID']+'/'+path;
	                }else{
	                	urlpath = 'index.php?img=sinavBelgeTekrarDekont/'+BB['ID']+'/'+path;
	                }
	            }
	            else{
	            	urlpath = '#';
	            }
	            dek += '<td><a href="'+urlpath+'" target="_blank">'+path+'</a></td>';
	            dek += '<td>'+vall['TUTAR']+'</td>';
	            dek += '<td>'+vall['TARIH']+'</td>';
	            dek += '</tr>';
	        });
	        dek += '</tbody></table>';
	        jQuery('#dekontlar').html(dek);
	        jQuery('#DekBilgi').show();
		}
		jQuery('#BelgeBilgi').show('slow');
	});
}

function BasimaGonder(){
	var BasimId = jQuery('#BasimId').val();
	if(BasimId == 0){
		alert('Lütfen bir belge seçiniz.');
	}else{
		if(confirm('Bu Belgeyi Basıma Göndermek İstiyor musunuz?')){
			jQuery.ajax({
				async:false,
				type:'POST',
				url:"index.php?option=com_belgelendirme&task=BelgeBasimaGonder&format=raw",
				data:"BasimId="+BasimId
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Belge Basıma Gönderildi.');
					window.location.reload();
				}else{
					alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
					window.location.reload();
				}
			});
		}
	}
}

function BasimIptal(){
	var BasimId = jQuery('#BasimId').val();
	if(BasimId == 0){
		alert('Lütfen bir belge seçiniz.');
	}else{
		if(confirm('Bu Belgenin Basımını İptal Etmek İstiyor musunuz?')){
			jQuery.ajax({
				async:false,
				type:'POST',
				url:"index.php?option=com_belgelendirme&task=BelgeBasimIptal&format=raw",
				data:"BasimId="+BasimId
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Belge Basımı İptal Edildi.');
					window.location.reload();
				}else{
					alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
					window.location.reload();
				}
			});
		}
	}
}

function FuncBelgeBirim(belgeId){
	jQuery('#birims').html('');
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeBasariliBirim&format=raw",
		data:'belgeId='+belgeId,
		dataType: 'json',
		success:function(data){
			// var dat = jQuery.parseJSON(data);
			if(data){
				console.log(data);
			
				var ekle = "<ul>";
				jQuery.each(data['birims'],function(key,val){
					jQuery.each(val,function(key2,val2){
						ekle += "<li>"+val2.BIRIM_KODU+" "+val2['BIRIM_ADI']+"</li>";
					});
				});
				ekle += "</ul>";
				jQuery('#birims').html(ekle);
				jQuery('#BasariliBirim').lightbox_me({
					centered: true
				});
			}else{
				jQuery('#UyariModal h2').html('Adayın Başarılı Olduğu birim gözükmemektedir. Lütfen Yetkili birisiyle iletişime geçiniz.');
				jQuery('#UyariModal').lightbox_me({
					centered: true,
				    closeClick:false,
				    closeEsc:false
				});
			}
		}
	});
}
</script>