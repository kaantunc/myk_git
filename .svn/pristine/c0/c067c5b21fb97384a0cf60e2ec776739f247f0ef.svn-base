<?php
$kuruluslar = $this->kuruluslar;
$kurulusId = $this->kurulusId;
$sinavId = $this->sinavId;
$sinavlar = $this->sinavlar;
$belgeAdaylar = $this->belgeAdaylar;
$belgeSablon = $this->belgeSablon;

$kuruluss = '<option value="">Seçiniz</option>';
foreach ($kuruluslar as $kurulus){
	if($kurulus['USER_ID'] == $kurulusId){
		$kuruluss .= '<option value="'.$kurulus['USER_ID'].'" selected>'.$kurulus['KURULUS_ADI'].'</option>';
	}
	else{
		$kuruluss .= '<option value="'.$kurulus['USER_ID'].'">'.$kurulus['KURULUS_ADI'].'</option>';
	} 
}

$sinavs = '<option value="">Seçiniz</option>';
// $sinavs .= '<option value="-1">Kuruluşun yapmadığı sınavlardan Belge Hakedenler</option>';
foreach ($sinavlar as $sinav){
	if($sinav['BASVURU_ID'] == $sinavId){
		$sinavs .= '<option value="'.$sinav['BASVURU_ID'].'" selected>'.$sinav['SINAV_ID'].'('.$sinav['BASVURU_ID'].') - '.$sinav['BASLANGIC_TARIHI'].' - '.$sinav['YETERLILIK_KODU'].'-'.$sinav['YETERLILIK_ADI'].' ('.$sinav['SINAV_ILI'].')</option>';
	}
	else{
		$sinavs .= '<option value="'.$sinav['BASVURU_ID'].'">'.$sinav['SINAV_ID'].'('.$sinav['BASVURU_ID'].') - '.$sinav['BASLANGIC_TARIHI'].' - '.$sinav['YETERLILIK_KODU'].'-'.$sinav['YETERLILIK_ADI'].' ('.$sinav['SINAV_ILI'].')</option>';
	}
}
if($sinavId !='' && count($sinavlar)>0){
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
           jQuery('#displaySinav').show();
           jQuery('#displayAday').show();
        });
    </script>
    <?php
}
?>
<div class="anaDiv">
	<div class="divYan">
		<a href="index.php?option=com_belgelendirme&view=belge_olusturma" class="btn btn-success">Belge Başvuruları</a>
	</div>
	<div class="divYan">
		<a href="index.php?option=com_belgelendirme&view=tekrar_basim" class="btn btn-xs btn-primary">Belge Tekrar Basım Başvuruları</a>
	</div>
</div>
<div class="anaDiv text-center font20 hColor">
	Belge Başvuruları
</div>
<div class="anaDiv"><hr></div>
<div id="BelgeSorgula" class="anaDiv">
	<div class="div20 font16 hColor">
		Kurulus:
	</div>
	<div class="divYan">
		<select id="kurulus" class="input-sm" name="kurulus"><?php echo $kuruluss;?></select>
	</div>
	<div class="divYan">
		<button type="button" class="btn btn-xs btn-primary" id="getir">Getir</button>
	</div>
        <!--
        <label>Kurulus:<select id="kurulus" class="input-sm" name="kurulus"><?php echo $kuruluss;?></select><input type="button" class="btn btn-xs btn-primary" id="getir" value="Getir" /></label><br><br>
      
        <label  id="displaySinav" style="display: none;">Sınav ve Başvuru: <select style="margin-left: 9px;" id="basvuruId" name="sinav"><?php //echo $sinavs;?></select></label><br><br>
        <label id="displayAday" style="display: none"><button id="adayGetir">Bilgileri Getir</button></label>
         -->
</div>
<div class="anaDiv" id="displaySinav" style="display:none">
	<div class="div20 font16 hColor">
		Sınav ve Başvuru
	</div>
	<div class="divYan">
		<select class="input-sm" id="basvuruId" name="sinav"><?php echo $sinavs;?></select>
	</div>
	<div class="divYan" id="displayAday" style="display:none">
		<button type="button" class="btn btn-sm btn-primary" id="adayGetir">Bilgileri Getir</button>
	</div>
</div>
<style>
    .llable
{
width: 200px;
float: left;
text-align: left;
margin-right: 10px;
display: block
}

.width150{
	width:210px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>div{
	padding-top:10px;
}
.aramaClass{
	margin-bottom:10px;
	margin-top:10px;
}
.aramaClass1{
	margin-bottom:10px;
	margin-top:10px;
}
#sinavMerkezleri table tr td{
	text-align:center;
}
</style>
<form action="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belge_adaylar&sinavId=<?php echo $sinavId;?>" method="POST" enctype="multipart/form-data" id="BelgelendirmeForm">
    <input type="hidden" name="belgeSinav" id="belgeSinav"/>
<div id="sablon" style="display: none;" class="aramaClass">
<hr>
   <div style="width: 100%" class="aramaClass1"><div class="width150">İmza Yetkili Ad:</div><div id="yetkiliAd"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">İmza Yetkili Soyad:</div><div id="yetkiliSoyAd"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">İmza Yetkili Ünvan:</div><div id="yetkiliUnvan"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">Teşvikten Yararlanan Sayı:</div><div id="tesvik_yararlanan"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">AB Hibesinden Yararlanan Sayı:</div><div id="ab_yararlanan"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">Teşvikten Yararlanmayan Sayı:</div><div id="tesvik_yararlanmayan"></div></div>
   <div style="width: 100%" class="aramaClass1"><div class="width150">Dekont:</div><div id="dekont"></div></div>
   <input type="hidden" name="selectedBasvuruId" />
   <input type="hidden" name="selectedSinavId" />
</div>
<div id="sinavMerkezleri" style="display: none; margin-top: 10px;">
	<br><hr><br>
	 <div>
    	<h2>Sınav için Kullanılan Sınav Merkezleri</h2>
    	  <table width="100%" border="0" cellpadding="0" cellspacing="1">
	        <thead style="background-color:#71CEED">
	            <tr>
	                <th>#</th>
	                <th>Sınav Türü</th>
	                <th>Sınav Merkezi Id</th>
	                <th>Sınav Merkezi Adı</th>
	                <th>Sınav Merkezi Türü</th>
	            </tr>
	        </thead>
	        <tbody id="sinavMerkez">
	        
	        </tbody>
	    </table>
	<br><hr><br>
	</div>
</div>
<div id="adaylar" style="display: none; margin-top: 10px;">
    <br><hr><br>
    <div id="belgeHakki">
    	<h2>Belge Almaya Hak Kazananlar(Sistem tarafından onaylanmış)</h2>
	    <table width="100%" border="0" cellpadding="0" cellspacing="1">
	        <thead style="background-color:#71CEED">
	            <tr>
	                <th>#</th>
	                <th>Sıra</th>
	                <th>T.C. Kimlik No:</th>
	                <th>Ad</th>
	                <th>Soyad</th>
	                <th>Belge No:</th>
	                <th>Belge Verilme Tarihi:</th>
	                <th>Başarılı Birimler</th>
	                <th>Teşvik Durumu</th>
	            </tr>
	        </thead>
	        <tbody id="AdayYaz"></tbody>
	    </table>
    </div>
    <br>
    <hr>
    <br>
    <div id="belgeHaksiz">
    <h2>Belge Almaya Hak Kazananlar(Sistem tarafından onaylanmamış)</h2>
	    <table width="100%" border="0" cellpadding="0" cellspacing="1">
	        <thead style="background-color:#71CEED">
	            <tr>
	                <th>#</th>
	                <th>T.C. Kimlik No:</th>
	                <th>Ad</th>
	                <th>Soyad</th>
	                <th>Belge No:</th>
	                <th>Belge Verilme Tarihi:</th>
	                <th>Başarılı Birimler</th>
	                <th>Açıklama</th>
	            </tr>
	        </thead>
	        <tbody id="AdayYaz"></tbody>
	    </table>
    </div>
    <br>
    <button type="button" class="btn btn-sm btn-primary" id="kaydet">Seçilen Adayları Belgelendir</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-sm btn-danger" id="basvuruReddet">Reddet</button>
<!--     <br><br> -->
<!--     <input type="button" value="Seçilen Adayları Geri Gönder" id="geriGonder"/> -->
</div>
</form>
    
<div id="yeniDis" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#kaydet').live('click',function(e){
		e.preventDefault();
		if(confirm('Seçilen adayları belgelendirmek istediğinzden emin misiniz?')){
			jQuery('#BelgelendirmeForm').submit();
		}
	});
	
	jQuery('#kurulus').live('change',function(e){
		e.preventDefault();
		jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();
        jQuery('#sinavMerkezleri').hide();
        jQuery('#sablon').hide();
	});

	jQuery('#displaySinav').live('change',function(e){
		e.preventDefault();
        jQuery('#adaylar').hide();
        jQuery('#sinavMerkezleri').hide();
        jQuery('#sablon').hide();
	});

	jQuery("#basvuruReddet").click(function(){
		if(confirm("İlgili başvuru red edilerek kuruluşa geri gönderilecek emin misiniz ?")){
	        jQuery.ajax({
	        	async : false,
	            type:"POST",
	            url:"index.php?option=com_belgelendirme&task=basvuruReddet&format=raw",
	            dataType: "json",
	            data:"basvuruId="+jQuery("input[name=selectedBasvuruId]").val()+"&sinavId="+jQuery("input[name=selectedSinavId]").val(),
	            success:function(data){
	           		if(data.STATUS == "1"){
						alert(data.RESULT);
						window.location.reload();
	               	}else{
	                	alert(data.RESULT);   	
	                }
	            }
	        });
		}
	});
    jQuery('#getir').live('click',function(e){
        e.preventDefault();
        jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();
        jQuery('#sinavMerkezleri').hide();
        jQuery('#sablon').hide();
        var kurulusId = jQuery('#kurulus').val();
        if(kurulusId == ''){
            alert('Lütfen bir kuruluş seçiniz.');
        }
        else{
            jQuery.ajax({
                type: 'POST',
                url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=KurulusSinavlar&format=raw",
                data:'kurulus_id='+kurulusId+'&durum_id=1',
                success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            var sinav = '<option value="">Seçiniz</option>';
//                             sinav += '<option value="-1">Kuruluşun yapmadığı sınavlardan Belge Hakedenler</option>';
                            jQuery.each(dat,function(key,value){
                                sinav += '<option value="'+value['BASVURU_ID']+'">'+value['SINAV_ID']+'('+value['BASVURU_ID']+') - '+value['BASLANGIC_TARIHI']+' - '+value['YETERLILIK_KODU']+'-'+value['YETERLILIK_ADI']+' ('+value['SINAV_ILI']+')</option>';
                            });
                            jQuery('#basvuruId').html(sinav);
                            jQuery('#displaySinav').show();
                            jQuery('#displayAday').show();
                        }
                        else{
                        	var sinav = '<option value="">Seçiniz</option>';
//                             sinav += '<option value="-1">Kuruluşun yapmadığı sınavlardan Belge Hakedenler</option>';
                            jQuery('#basvuruId').html(sinav);
                            jQuery('#displaySinav').show();
                            jQuery('#displayAday').show();
                      	}
                    }
            });
        }
    });
    
    jQuery('#adayGetir').live('click',function(e){
        e.preventDefault();
        jQuery('#adaylar').hide();
        jQuery('#sinavMerkezleri').hide();
        jQuery('#sablon').hide();
        var kurulus = jQuery('#kurulus').val();

        jQuery.ajax({
        	async : false,
            type:"POST",
            url:"index.php?option=com_belgelendirme&task=getKurulusLogoTamMi&format=raw",
            data:"kurulusId="+kurulus,
            success:function(data){
                var dat = jQuery.parseJSON(data);
                if(dat[0] == false){
                	var birims = '<h3 style="color:#1C617C">Kuruluşun aşağıda yer alan bilgileri eksiktir. Bilgileri tamamlanmadan belgelendirme sürecine devam edilemez.</h3><hr style="color:#1C617C"><ul>';
                    jQuery.each(dat[1],function(key,value){
                        birims += '<li>'+value+'</li>';
                    });
                    birims += '</lu>';
                    birims += '<br><a href="index.php?option=com_kurulus_edit&view=kurulus_logo&kurulusId='+kurulus+'">Kuruluşun Bilgilerini Düzenle</a>';
                    jQuery('#yeniDis').html(birims);
                    jQuery('#yeniDis').lightbox_me({
                        centered: true, 
                    });
                }
                else if(dat[0]==true){
                    adayBilgileriGetir();
                }
            }
        });
    });
    
    jQuery('#birimler').live('click',function(e){
        e.preventDefault();
        var hakId = jQuery(this).closest('tr').attr('id');
        jQuery.ajax({
            type: 'POST',
            url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeAdayBirimler&format=raw",
            data:'hakId='+hakId,
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        var birims = '<h3 style="color:#1C617C">Başarılı olduğu birimler</h3><hr style="color:#1C617C"><ul>';
                        jQuery.each(dat,function(key,value){
                            birims += '<li>'+value['BIRIM_KODU']+' - '+value['BIRIM_ADI']+'</li>';
                        });
                        birims += '</lu>';
                        jQuery('#yeniDis').html(birims);
                        jQuery('#yeniDis').lightbox_me({
                            centered: true, 
                        });
                    }
        });
    });

    jQuery('#mykMarkaDegistir').live('click',function(e){
        e.preventDefault();
        jQuery('#mykMarka').show();
        jQuery('#mykMarkaDegistir').hide();
        jQuery('#mykMarkaGoster').hide();
    });
    
    jQuery('#turkakMarkaDegistir').live('click',function(e){
        e.preventDefault();
        jQuery('#turkakMarka').show();
        jQuery('#turkakMarkaDegistir').hide();
        jQuery('#turkakMarkaGoster').hide();
    });
    
    jQuery('#yetkitarih').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd/mm/yy'
        });
    });
});

function adayBilgileriGetir(){
	 var basvuruId = jQuery('#basvuruId').val();
     if(basvuruId == ''){
         alert('Lütfen bir sınav seçiniz.');
     }
     else{
         jQuery('#belgeSinav').val(basvuruId);
          jQuery.ajax({
         	async : false,
             type: 'POST',
             url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeAdayGetirWithBasvuruId&format=raw",
             data:'basvuruId='+basvuruId+'&kurulusId='+jQuery("#kurulus").val()+'&durum_id=1',
             success: function (data) {
                     var dat = jQuery.parseJSON(data);
                     if(dat.length>0){
                         var adaylarBelgeHakki = '';
                         var evenBelgeHakki = 'bgcolor="#efefef"';
                         var sayBelgeHakki = 1;

                         var adaylarBelgeHaksiz = '';
                         var evenBelgeHaksiz = 'bgcolor="#efefef"';
                         var sayBelgeHaksiz = 1;
                         jQuery.each(dat,function(key,value){
                             if(value['AKTIF'] == 0){
	                                if(sayBelgeHakki%2 == 0){
	                                    adaylarBelgeHakki += '<tr id="'+value['ID']+'" '+evenBelgeHakki+' style="text-align:center">';
	                                }
	                                else{
	                                    adaylarBelgeHakki += '<tr id="'+value['ID']+'" style="text-align:center">';
	                                }
	                                adaylarBelgeHakki += '<td><input type="checkbox" checked="checked" name="belgeAday[]" value="'+value['ID']+'" /></td>'
	                                	+'<td>'+sayBelgeHakki+'</td>'
	                                    +'<td>'+value['TC_KIMLIK']+'</td>'
	                                    +'<td>'+value['ADI']+'</td>'
	                                    +'<td>'+value['SOYADI']+'</td>'
	                                    +'<td>'+value['BELGE_NO']+'</td>'
	                                    +'<td>'+value['BELGE_BAS_TARIH']+'</td>'
	                                    +'<td><input type="button" id="birimler" value="Birimleri"/></td>';
	                                    if(value['TESVIK'] == 1){
	                                    	adaylarBelgeHakki +='<td class="bg-success fontBold text-white">Devlet Teşviği</td>';
		                                }else if(value['TESVIK'] == 2){
		                                	adaylarBelgeHakki +='<td class="bg-success fontBold text-white">AB Hibesi</td>';
			                            }else{
		                                	adaylarBelgeHakki +='<td>Yararlanmayacak</td>';
			                            }
	                                    adaylarBelgeHakki +='</tr>';
	                                sayBelgeHakki++;
                             }else if(value['AKTIF'] == 1){
                             	if(sayBelgeHaksiz%2 == 0){
	                                    adaylarBelgeHaksiz += '<tr id="'+value['ID']+'" '+evenBelgeHaksiz+' style="text-align:center">';
	                                }
	                                else{
	                                    adaylarBelgeHaksiz += '<tr id="'+value['ID']+'" style="text-align:center">';
	                                }
	                                adaylarBelgeHaksiz += '<td><input type="checkbox" name="belgeAday[]" value="'+value['ID']+'" /></td>'
	                                    +'<td>'+value['TC_KIMLIK']+'</td>'
	                                    +'<td>'+value['ADI']+'</td>'
	                                    +'<td>'+value['SOYADI']+'</td>'
	                                    +'<td>'+value['BELGE_NO']+'</td>'
	                                    +'<td>'+value['BELGE_BAS_TARIH']+'</td>'
	                                    +'<td><input type="button" id="birimler" value="Birimleri"/></td>'
	                                    +'<td>'+value['ACIKLAMA'].replace(/(\r\n|\n\r|\r|\n)/g, "<br>")+'</td></tr>';
	                                sayBelgeHaksiz++;
                             }
                         });
                         if(sayBelgeHakki>1){
                         	jQuery('#belgeHakki #AdayYaz').html(adaylarBelgeHakki);
                         	jQuery('#belgeHakki').show();  
                         }else{
                         	jQuery('#belgeHakki').hide();
                         }

                         if(sayBelgeHaksiz>1){
                         	jQuery('#belgeHaksiz #AdayYaz').html(adaylarBelgeHaksiz);
                         	jQuery('#belgeHaksiz').show();    
                         }else{
                         	jQuery('#belgeHaksiz').hide();
                         }

                         
                     }
                     else{
                         jQuery('#AdayYaz').html('');
                     }
                 }
         });
         
         jQuery.ajax({
         	 async : false,
             type: 'POST',
             url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeImzaYetkiliGetir&format=raw",
             data:'basvuruId='+basvuruId,
             success: function (data) {
                 var dat = jQuery.parseJSON(data);
                 	jQuery("input[name=selectedBasvuruId]").val(dat[0]['BASVURU_ID']);
                 	jQuery("input[name=selectedSinavId]").val(dat[0]['SINAV_ID']);
                 	
                    jQuery('#yetkiliAd').html(dat[0]['YETKILI_AD']);
                    jQuery('#yetkiliSoyAd').html(dat[0]['YETKILI_SOYAD']);
                    jQuery('#yetkiliUnvan').html(dat[0]['YETKILI_UNVAN']);
                    var dek = '<table width="70%" style="text-align: center" border="1"><thead><tr><th>Dekont No.</th><th>Dekont</th><th>Dekont Tutarı</th><th>Dekont Tarihi</th></tr></thead>';
                    jQuery.each(dat,function(key,vall){
                        dek += '<tr>';
                        dek += '<td>'+vall['DEKONTNO']+'</td>';
                        var path = vall['DEKONT'];
                        var splitpath = path.split('.');
                        var urlpath = '';
                        if(vall['DEKONT']){
    	                    if(splitpath[splitpath.length-1] == 'pdf' || splitpath[splitpath.length-1] == 'PDF'){
    	                        urlpath = 'index.php?dl=sinavBelgeDekont/'+vall['SINAV_ID']+'/'+path;
    	                    }else{
    	                    	urlpath = 'index.php?img=sinavBelgeDekont/'+vall['SINAV_ID']+'/'+path;
    	                    }
                        }
                        else{
                        	urlpath = '#';
                        }
                        dek += '<td><a href="'+urlpath+'" target="_blank">'+path+'</a></td>';
                        dek += '<td>'+vall['TUTAR']+'</td>';
                        dek += '<td>'+vall['DEKONT_TARIH']+'</td>';
                        dek += '</tr>';
                    });
                    dek += '</tbody></table>';
                    jQuery('#dekont').html(dek);
             }
         });

         jQuery.ajax({
             type: 'POST',
             async : false,
             url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeSinavMerkezleriGetirWithBasvuruId&format=raw",
             datatype:'json',
             data:'basvuruId='+basvuruId,
             success: function (data) {
            	 var dat = jQuery.parseJSON(data);
                 var sinavmerkez = "";
                 var i = 1;
            	 jQuery.each(dat,function(key,val){ 
            		 sinavmerkez += "<tr>";
            		 	 sinavmerkez += "<td>"+i+"</td>";
	            		 sinavmerkez += "<td>"+val['SINAV_TURU_KODU']+"</td>";
	            		 sinavmerkez += "<td>"+val['SINAV_YERI_ID']+"</td>";
	            		 sinavmerkez += "<td>"+val['YER_ADI']+"</td>";
	            		 sinavmerkez += "<td>"+val['TEMIN_DURUMU']+"</td>";
            		 sinavmerkez += "</tr>";
            		 i++;
                 });
                 jQuery("#sinavMerkezleri tbody").html(sinavmerkez);
             }
         });
         jQuery("#tesvik_yararlanan").html('');
         jQuery("#ab_yararlanan").html('');
         jQuery("#tesvik_yararlanmayan").html('');
         jQuery.ajax({
             type: 'POST',
             url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=GetTesvikSayilariWithBasvuruId&format=raw",
             datatype:'json',
             data:'basvuruId='+basvuruId,
             success: function (data) {
            	 var dat = jQuery.parseJSON(data);
                 jQuery("#tesvik_yararlanan").html(dat['TESVIK_YARARLANAN']);
                 jQuery("#tesvik_yararlanmayan").html(dat['TESVIK_YARARLANMAYAN']);
                 jQuery("#ab_yararlanan").html(dat['AB_YARARLANAN']);
                 jQuery("#sinavMerkezleri").show('slow');
                 jQuery('#sablon').show('slow');
                 jQuery('#adaylar').show('slow');
             }
         });
//         jQuery('#sablon').show('slow');
//         jQuery('#adaylar').show('slow');
         
     }
}

//geri bildirim için jQuery('input[name="belgeAday[]"]:checked').serialize()
</script>