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
<form id="SinavAraForm" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&view=belge_olusturma&layout=yapilan_sinavlar">
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

<div class="anaDiv" style="overflow: auto">
    <table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="5%">Sınav ID</th>
			<th width="25%">Yeterlilik</th>
			<th width="25%">Kuruluş</th>
			<th width="10%">Sınav Tarihi</th>
			<th width="10%">Sınav Yeri</th>
			<th width="10%">Sınav Değerlendirici</th>
			<th width="10%">Adaylar</th>
			<th width="10%">Dekont</th>
			<th width="10%">Başarılı Aday</th>
		</tr>
	</thead>
	<tbody id="sonucBody" class="fontBold tdPad5">
    <?php
    foreach($sinavlar as $row){
        echo '<tr>';
        echo '<td>'.$row['SINAV_ID'].'</td>';
        echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
        echo '<td>'.$kurData[$row['KURULUS_ID']]['KURULUS_ADI'].'</td>';
        echo '<td>'.$row['BASLANGIC_TARIHI'].' '.$row['BASSAAT'].'</td>';
        echo '<td class="text-center">'.$row['SINAV_ILI'].'<br><button style="margin-top:5px;" type="button" class="btn btn-xs btn-primary" onclick="sinavYeriGetir('.$row['SINAV_ID'].')">Sinav Yeri</button></td>';
        echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="sinavDegerlendiriciGetir('.$row['SINAV_ID'].')">Değerlendirici</button></td>';
        echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="sinavAdayGetir('.$row['SINAV_ID'].')">Aday Exceli</button></td>';
        if($row['BELGE_ALMIS']){
            echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="sinavDekontGetir('.$row['SINAV_ID'].')">Dekont</button></td>';
            echo '<td>'.$row['BELGE_ALMIS'].'</td>';
        }else{
            echo '<td></td>';
            echo '<td>0</td>';
        }

        echo '</tr>';
    }
    ?>
	</tbody>
</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    var oTables = jQuery('#kurTable').dataTable({
        "aaSorting": [[ 0, "desc" ]],
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
			data:'yeterlilik_id='+yet+'&kurulus_id='+kur+'&basTarih='+bas+'&bitTarih='+bit+'&durum=2',
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
						ekle += '<td>'+vall['SINAV_TARIHI']+'</td>';
						ekle += '<td><a href="#" onclick="sinavYeriGetir('+vall['SINAV_ID']+')">Sınav Yeri</a></td>';
						ekle += '<td><a href="#" onclick="sinavDegerlendiriciGetir('+vall['SINAV_ID']+')">Değerlendirici</a></td>';
						ekle += '<td><a href="#" onclick="sinavAdayGetir('+vall['SINAV_ID']+')">Aday Exceli</a></td>';
// 						if(vall['DEKONT'].length>0){
// 							var dekont = "index.php?dl=sinavBelgeDekont/"+vall['SINAV_ID']+"/"+vall['DEKONT'];
// 							ekle += '<td><a href="'+dekont+'">Dekont</a></td>';
// 						}else{
// 							ekle += '<td>Dekont kayıtlı değil</td>';	
// 						}
						if(vall['BELGE_ALMIS']){
							ekle += '<td><a href="#" onclick="sinavDekontGetir('+vall['SINAV_ID']+')">Dekont</a></td>';
							ekle += '<td>'+vall['BELGE_ALMIS']+'</td>';
						}else{
							ekle += '<td></td>';
							ekle += '<td>0</td>';
						}
						
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
});

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

function sinavDegerlendiriciGetir(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavDegerGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			jQuery.each(dat,function(key,vall){
				var beyan = 'index.php?dl='+vall['BEYAN'];
				var cv = 'index.php?dl='+vall['CV'];
				ekle += '<div class="width150">Ad Soyad:</div><div>'+vall['ADI']+' '+vall['SOYADI']+'</div>';
				ekle += '<div class="width150">Kişisel Beyan:</div><div><a href="'+beyan+'"><img alt="" src="/MYK-BOR/images/pdf.png" width="30" height="30"></a></div>';
				ekle += '<div class="width150">Öz Geçmiş:</div><div><a href="'+cv+'"><img alt="" src="/MYK-BOR/images/pdf.png" width="30" height="30"></a></div><br><hr>';
			});

			jQuery('#sinavDegerIcerik').html(ekle);
			jQuery('#sinavDeger').lightbox_me({
          	  	centered: true
            });
		}
	});
}

function sinavAdayGetir(sinavId){
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavAdayGetir&format=raw",
		data:"sinav_id="+sinavId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var ekle = '';
			jQuery.each(dat,function(key,vall){
				var exurl = "index.php?dl=sinav_bildirimleri/"+vall['KURULUS_ID']+'_'+vall['SINAV_ID']+'_'+vall['PAKET_ID']+'.'+vall['UZANTI'];
				ekle += '<div class="width150">Aday Dosyası:</div><div><a href="'+exurl+'">Dosya İndir</a></div><br><hr>';
			});

			jQuery('#sinavAdayIcerik').html(ekle);
			jQuery('#sinavAday').lightbox_me({
          	  	centered: true
            });
		}
	});
}

function sinavDekontGetir(sinavId){
	jQuery('#TbodyDekont').html('');
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=sinavDekontGetir&format=raw",
		data:"sinav_id="+sinavId
	}).done(function(data){
		var kat = jQuery.parseJSON(data);
		var durum = kat['durum'];
		var dat = kat['dekont'];
		if(durum == 1){
			var ekle = '';
			var say = 1;
			jQuery.each(dat,function(key,vall){
				var dekurl = "index.php?dl=sinavBelgeDekont/"+sinavId+'/'+vall['DEKONT'];
				ekle += '<tr>';
				ekle += '<td>'+say+'</td>';
				ekle += '<td>'+vall['DEKONTNO']+'</td>';
				ekle += '<td>'+vall['DEKONT_TARIH']+'</td>';
				ekle += '<td>'+vall['TUTAR']+' TL</td>';
				ekle += '<td><a href="'+dekurl+'" target="_blank">Dekont İndir</a></td>';
				ekle += '<td>'+vall['BASIM_TARIHI']+'</td>';
				ekle += '</tr>';
			});
			
			jQuery('#TbodyDekont').html(ekle);
			jQuery('#sinavDekont').lightbox_me({
          	  	centered: true
            });
		}else if(durum == 2){
			var ekle = '';
			var say = 1;
			jQuery.each(dat,function(key,vall){
				var dekurl = "index.php?dl=sinavBelgeDekont/"+sinavId+'/'+vall['DEKONT'];
				ekle += '<tr>';
				ekle += '<td>'+say+'</td>';
				ekle += '<td>'+vall['DEKONTNO']+'</td>';
				ekle += '<td>'+vall['DEKONT_TARIH']+'</td>';
				ekle += '<td>'+vall['TUTAR']+' TL</td>';
				ekle += '<td><a href="'+dekurl+'" target="_blank">Dekont İndir</a></td>';
				ekle += '<td></td>';
				ekle += '</tr>';
			});
			
			jQuery('#TbodyDekont').html(ekle);
			jQuery('#sinavDekont').lightbox_me({
          	  	centered: true
            });
		}else{
			alert('Bu sınava ait dekont yoktur.');
		}
		
	});
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

<div id="sinavYeri" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Yeri</u></h2>
    <div id="sinavYeriIcerik">
    
    </div>
</div>

<div id="sinavDeger" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Değerlendiricileri</u></h2>
    <div id="sinavDegerIcerik">
    
    </div>
</div>

<div id="sinavAday" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Adayları</u></h2>
    <div id="sinavAdayIcerik">
    
    </div>
</div>

<div id="sinavDekont" style=" min-width: 300px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px;width:50%">
	<h2><u>Sınav Dekontları</u></h2>
    <table width="100%" border="1" cellpadding="0" cellspacing="1">
    	<thead style="text-align:center;background-color:#71CEED">
    		<tr>
    			<th>#</th>
    			<th>Dekont No</th>
    			<th>Dekont Tarihi</th>
    			<th>Tutar</th>
    			<th>Dekont</th>
    			<th>Basım Tarihi</th>
    		</tr>
    	</thead>
    	<tbody id="TbodyDekont">
    	</tbody>
    </table>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>