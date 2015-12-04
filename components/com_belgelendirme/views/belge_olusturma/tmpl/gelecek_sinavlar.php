<?php 
echo $this->sayfaLink;
$yets = $this->yets;
$kurs = $this->kurs;
$sinavlar = $this->sinavlar['sinavlar'];
$kurData = $this->sinavlar['kurData'];

$yeterlilikler = '<option value="0">Seçiniz</option>';
foreach ($yets as $row){
	$yeterlilikler .= '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' - '.$row['YETERLILIK_ADI'].'</option>';
}

$kuruluslar = '<option value="0">Seçiniz</option>';
foreach ($kurs as $row){
	$kuruluslar .= '<option value="'.$row['KURULUS_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
?>
<form id="SinavAraForm" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&view=belge_olusturma&layout=gelecek_sinavlar">
    <div class="anaDiv">
        <div class="div20 font16 hColor">
            Yeterlilik:
        </div>
        <div class="div80">
            <select name="yeterlilik" class="input-sm inputW100"><?php echo $yeterlilikler;?></select>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font16 hColor">
            Kuruluş:
        </div>
        <div class="div80">
            <select name="kurulus" class="input-sm inputW100"><?php echo $kuruluslar;?></select>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font16 hColor">
            Sınav Tarih Aralığı:
        </div>
        <div class="div80">
            <div class="divYan"><input type="text" name="basTarih" class="sinavTarih input-sm"></div>
            <div class="divYan"><input type="text" name="bitTarih" class="sinavTarih input-sm"></div>
        </div>
    </div>
    <div class="anaDiv">
        <button type="button" class="btn btn-sm btn-success" id="SinavAra">Ara</button>
    </div>
</form>

<div class="anaDiv">
    <table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
	<thead style="background-color:#71CEED" class="thPad5">
		<tr>
			<th width="5%">Sınav ID</th>
			<th width="20%">Yeterlilik</th>
			<th width="20%">Kuruluş</th>
			<th width="10%">Sınav Tarihi</th>
			<th width="10%">Sınav yeri</th>
			<th width="10%">Aday Dosyası</th>
			<th width="15%">Aday Dosyası Yükle</th>
            <th width="10%">İptal</th>
		</tr>
	</thead>
	<tbody id="sonucBody"  class="fontBold tdPad5">
    <?php
        foreach($sinavlar as $row){
            echo '<tr>';
            echo '<td>'.$row['SINAV_ID'].'</td>';
            echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
            echo '<td>'.$kurData[$row['KURULUS_ID']]['KURULUS_ADI'].'</td>';
            echo '<td>'.$row['BASLANGIC_TARIHI'].' '.$row['BASSAAT'].'</td>';
            echo '<td class="text-center">'.$row['SINAV_ILI'].'<br><button style="margin-top:5px;" type="button" class="btn btn-xs btn-primary" onclick="sinavYeriGetir('.$row['SINAV_ID'].')">Sinav Yeri</button></td>';
            echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="adayDosyasi('.$row['SINAV_ID'].')">Aday Dosyası</button></td>';
            echo '<td><a target="_blank" class="btn btn-xs btn-warning" href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav='.$row['SINAV_ID'].'">Aday Dosyası Yükle</a></td>';
            echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncSinavIptal('.$row['SINAV_ID'].')">İptal</button></td>';
            echo '</tr>';
        }
    ?>
	</tbody>
</table>
</div>
<div id="sinavYeri" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
    <h2><u>Sınav Yeri</u></h2>
    <div id="sinavYeriIcerik">

    </div>
</div>
<script type="text/javascript">
var IptalFile = '<div class="anaDiv"><div class="div70"><input type="file" class="input-sm inputW90" name="IptalFile[]"/></div><div class="div30"><button type="button" class="btn btn-xs btn-danger IptalFileSil"><i class="fa fa-minus"></i> Sil</button></div></div>';
jQuery(document).ready(function(){
    var oTables = jQuery('#kurTable').dataTable({
 		//"aaSorting": [[ 1, "asc" ]],
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bInfo": true,
        "bPaginate": true,
        "bFilter": true,
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sLengthMenu": "# _MENU_ öğe göster",
            "sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
            "sInfo": "_START_ - _END_ (Toplam _TOTAL_ İstek Oluşturuldu)",
            "sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
            "sSearch": "Ara",
            "oPaginate": {
                "sFirst":    "<?php echo JText::_("FIRST");?>",
                "sPrevious": "Önceki",
                "sNext":     "Sonraki",
                "sLast":     "<?php echo JText::_("LAST");?>"
            }
        }
    });

    jQuery('#SinavAra').live('click',function(e){
        e.preventDefault();
        if(jQuery('#SinavAraForm input[name="basTarih"]').val() == ''){
            alert('Lütfen Sorgunun Yapılacağı Başlangıç Tarihini Seçiniz.');
        }else{
            jQuery('#SinavAraForm').submit();
        }
    });

	jQuery('.sinavTarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
	});

	jQuery('#sinavAra').live('click',function(e){
		e.preventDefault();
		jQuery('#loaderGif').lightbox_me({
			centered: true,
	        closeClick:false,
	        closeEsc:false  
        });
		jQuery('.aramaSonuc').hide();
		jQuery('#sonucBody').html('');
		var yet = jQuery('#yeterlilik').val();
		var kur = jQuery('#kurulus').val();
		var bas = jQuery('#basTarih').val();
		var bit = jQuery('#bitTarih').val();
		
		jQuery.ajax({
			type:"POST",
			url:"index.php?option=com_belgelendirme&task=SinavSearch&format=raw",
			data:'yeterlilik_id='+yet+'&kurulus_id='+kur+'&basTarih='+bas+'&bitTarih='+bit+'&durum=4',
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat.length>0){
					var say = 1;
					var ekle = '';
					jQuery.each(dat,function(key,vall){
						if(say%2==0){
							ekle += '<tr bgcolor="#efefef">';
						}else{
							ekle += '<tr bgcolor="#ffffff">';
						}
	
						ekle += '<td>'+vall['SINAV_ID']+'</td>';
						ekle += '<td>'+vall['YETERLILIK_KODU']+'/'+vall['REVIZYON']+' - '+vall['YETERLILIK_ADI']+'</td>';
						ekle += '<td>'+vall['KURULUS_ADI']+'</td>';
						ekle += '<td>'+vall['BASLANGIC_TARIHI']+'</td>';
						ekle += '<td>'+vall['SINAV_ILI'].toLocaleUpperCase()+'</td>';
						ekle += '<td><button onclick="adayDosyasi('+vall['SINAV_ID']+')">Aday Dosyası</button></td>';
						var urlpath = "window.open('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav="+vall['SINAV_ID']+"')";
						ekle += '<td><button onclick="'+urlpath+'">Aday Dosyası Yükle</button></td>';
						ekle += '</tr>';
						say++;
					});
	
					jQuery('#sonucBody').html(ekle);
					jQuery('.aramaSonuc').fadeToggle('slow');
					jQuery('#loaderGif').trigger('close');
				}
				else{
					alert('Aradığınız kriterlere uygun bir sınav bulunamadı.');
					jQuery('#loaderGif').trigger('close');
				}
			}
		});
	});

    jQuery('.IptalFileSil').live('click',function(e){
        e.preventDefault();
        jQuery(this).closest('.anaDiv').remove();
    });

    jQuery('#IptalFileEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#iptalFiles').append(IptalFile);
    });

    jQuery('#SinavIptalKaydet').live('click',function(e){
        e.preventDefault();
        //30000000
        var IptalAciklama = jQuery('#SinavIptalFormu textarea[name="IptalAcik"]').val();
        var FileSize = 0;
        var FileHata = 0;
        jQuery('#SinavIptalFormu input[name="IptalFile[]"]').each(function(){
            var FileType = jQuery(this)[0].files[0].type;
            if(FileType != 'image/png' && FileType != 'image/jpeg' && FileType != "application/zip" && FileType != "application/x-zip"
                && FileType != "application/x-rar-compressed" && FileType != "application/pdf" && FileType != "application/x-7z-compressed"){
                alert('Lütfen .png, .jpeg, .pdf, .zip, .rar uzantılı dosyalar ekleyiniz.');
                FileHata++;
                return false;
            }
            FileSize += jQuery(this)[0].files[0].size;
        });

        if(FileHata > 0){
            return false;
        }else if(FileSize > 30000000){
            alert("Sınav İptali İçin Eklenen Dosyaların Boyutları 30 MB'tı Geçmemelidir. Lütfen Kontrol Ediniz.");
            return false;
        }else if(IptalAciklama == '' || IptalAciklama.length == 0){
            alert('Lütfen Sınav İptali İçin Açıklama Giriniz.');
            return false;
        }else{
            jQuery('#SinavIptalFormu').submit();
        }
    });
});

function adayDosyasi(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavAdayGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			if(dat.length > 0){
				jQuery.each(dat,function(key,vall){
					var exurl = "index.php?dl=sinav_bildirimleri/"+vall['KURULUS_ID']+'_'+vall['SINAV_ID']+'_'+vall['PAKET_ID']+'.'+vall['UZANTI'];
					ekle += '<div class="width150">Aday Dosyası:</div><div><a href="'+exurl+'">Dosya İndir</a></div><br><hr>';
				});
			}else{
				ekle = '<h3>Henüz aday bildirilmemiştir.</h3>';
			}
			jQuery('#sinavAdayIcerik').html(ekle);
			jQuery('#sinavAday').lightbox_me({
          	  	centered: true
            });
		}
	});
}
function sinavYeriGetir(sinavId){
    jQuery('#sinavYeriIcerik').html('');
    jQuery.ajax({
        async: false,
        type:"POST",
        url:"index.php?option=com_belgelendirme&task=sinavYeriGetir&format=raw",
        data:"sinav_id="+sinavId,
        success:function(data){
            var dat = jQuery.parseJSON(data);
            var ekle = '';
            jQuery.each(dat,function(key,vall){
                ekle += '<div class="width150">Yer Adı:</div><div>'+vall['YER_ADI']+'</div>';
                ekle += '<div class="width150">Yer Adresi:</div><div>'+vall['ADRES']+'</div><br><hr>';
            });

            jQuery('#sinavYeriIcerik').html(ekle);
            jQuery('#sinavYeri').lightbox_me({
                centered: true
            });
        }
    });
}
function FuncSinavIptal(sId){
    jQuery('#SinavIptalFormu textarea[name="IptalAcik"]').val('');
    jQuery('#SinavIptalFormu #iptalFiles').html('');
    jQuery('#SinavIptalFormu input[name="sId"]').val(sId);
    OpenLightBox('#SinavIptalDiv');
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
</script>

<!-- Sinav İptal -->
<div id="SinavIptalDiv" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="SinavIptalFormu" action="index.php?option=com_belgelendirme&view=belge_olusturma&layout=gelecek_sinavlar&task=program_iptal" enctype="multipart/form-data">
        <div class="anaDiv font20 fontBold hColor text-center">
            Sınav İptali
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                Açıklama:
            </div>
            <div class="div70">
                <textarea class="inputW90" name="IptalAcik"></textarea>
            </div>
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                İptal Ekleri:
            </div>
            <div class="div70" id="iptalFiles">

            </div>
        </div>
        <div class="anaDiv">
            <button type="button" class="btn btn-sm btn-primary" id="IptalFileEkle"><i class="fa fa-plus"></i> Dosya Ekle</button>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#SinavIptalDiv').trigger('close');">İptal</button>
            </div>
            <div class="div50 text-right">
                <button type="button" class="btn btn-sm btn-success" id="SinavIptalKaydet">Kaydet</button>
            </div>
        </div>
        <input type="hidden" name="sId" value="0"/>
        <input type="hidden" name="canEdit" value="true"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="sinavAday" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Adayları</u></h2>
	<br>
    <div id="sinavAdayIcerik">
    
    </div>
</div>