<?php 
$isteks = $this->TesvikIstekleri['isteks'];
$adayCount = $this->TesvikIstekleri['adayCount'];
$istekUcret = $this->TesvikIstekleri['istekUcret'];
$kurulus = $this->TesvikIstekleri['kurulus'];
// ttt
$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
$dovizKuru = UcretDuzenle($doviz['alis']);

function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}
function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
echo $this->iLink;
?>

<div class="anaDiv hColor font20 text-center text-underline fontBold">
	AB Hibesi Ücret İadesi Talepleri
</div>
<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar) -->
<div class="anaDiv" style="overflow: auto;">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">İstek ID</th>
				<th width="15%">Kuruluş</th>
				<th width="10%">Oluşturma Tarihi</th>
				<th width="10%">Aday Sayısı</th>
				<th width="10%">Durum</th>
				<?php 
				if($this->dId == 1){
					echo '<th width="10%">Talep PDF</th>';
					echo '<th width="10%">Yüklenecek PDF</th>';
				}else if($this->dId != 2){
					echo '<th width="10%">Yüklenen Dosyalar</th>';
                    echo '<th width="10%">Fatura</th>';
					echo '<th width="10%">Hesap Ekstresi</th>';
				}
				?>
				<th width="10%">Aday Başvuru Dökümanları</th>
				<th width="10%">Kuruluşa Faturalandırılacak Ücret</th>
				<th width="10%">Geri Ödenecek Ücret</th>
				<?php
				if($this->dId == 5){
					echo '<th width="10%">Geri Ödenen Ücret</th>';
				} 
				?>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php
		$say = 1;
		foreach ($isteks as $row){
			echo '<tr>';
			echo '<td><a class="btn btn-sm btn-primary" target="_blank" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=tesvik_adaylar&IstekId='.$row['ID'].'">'.$row['ID'].'</a></td>';
			if($kurulus[$row['ID']]['KURULUS_KISA_ADI'] == null){
				echo '<td>'.$kurulus[$row['ID']]['KURULUS_ADI'].'</td>';
			}else{
				echo '<td>'.$kurulus[$row['ID']]['KURULUS_KISA_ADI'].'</td>';
			}
			
			echo '<td>'.$row['BIT_TARIH'].'</td>';
			echo '<td>'.$adayCount[$row['ID']].'</td>';
			
			if($this->dId == 1){
				if($row['AB_ADAY_DOSYA'] == null){
					echo '<td><button style="margin-top:5px;" type="button" class="btn btn-xs btn-danger" onclick="FuncTesvikGeriGonder('.$row['ID'].')">İsteği Geri Gönder</button></td>';
					echo '<td>';
					echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF</a></td>';
					echo '<td>';
					if($row['DOVIZ_KURU'] == null){
						echo '<button type="button" class="btn btn-xs btn-danger" onclick="DKOlusturLinkeGit('.$row['ID'].')">PDF Oluştur ve Kuru Belirle</button><br>';
					}else{
						echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=tesvikpdf&IstekId='.$row['ID'].'">PDF</a><br>';
					}
					echo '<button style="margin-top:5px;" type="button" class="btn btn-xs btn-primary" onclick="FuncPdfYukle('.$row['ID'].')">Yükle</button>';
					echo '</td>';
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOnayaSun('.$row['ID'].',2)">İsteği Onayla</button><br>
							<button style="margin-top:5px;" type="button" class="btn btn-xs btn-danger" onclick="FuncTesvikGeriGonder('.$row['ID'].')">İsteği Geri Gönder</button></td>';
					echo '<td>';
					echo '<a target="_blank" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-danger">PDF</a></td>';
					echo '<td>';
					echo '<a style="margin-top:5px;" target="_blank" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'" class="btn btn-xs btn-danger">PDF</a><br>';
					echo '<button style="margin-top:5px;" type="button" class="btn btn-xs btn-warning" onclick="FuncPdfSil('.$row['ID'].')">Sil</button>';
					echo '</td>';
				}
			}else if($this->dId == 2){
				echo '<td><button type="button" class="btn btn-xs btn-success">Ödeme Dosyası Bekleniyor</button></td>';
			}else if($this->dId == 3){
				echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOnayaSun('.$row['ID'].',4)">Ödemeyi Onayla</button></td>';
				echo '<td>';
				echo '<a target="_blank" class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'">PDF</a><br>
							<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'">PDF <small>(Talep Edilen)</small></a><br>';
				echo '</td>';
                echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncGetFatura('.$row['ID'].')">Fatura</button></td>';
				echo '<td><a target="_blank" class="btn btn-xs btn-primary" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a></td>';
// 				$dosyaType = strtolower(pathinfo($row['DOSYA'], PATHINFO_EXTENSION));
// 				if($dosyaType == 'pdf' || $dosyaType == 'doc' || $dosyaType == 'docx' || $dosyaType == 'zip' || $dosyaType == 'rar'){
// 					echo '<td><a target="_blank" href="index.php?dl=abhibe/'.$row['USER_ID'].'/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-primary">İndir</a></td>';
// 				}else if($dosyaType == 'jpg' || $dosyaType == 'jpeg' || $dosyaType == 'png' || $dosyaType == 'gif' || $dosyaType == 'pjpeg'){
// 					echo '<td><a target="_blank" href="index.php?img=abhibe/'.$row['USER_ID'].'/'.$row['ID'].'/'.$row['DOSYA'].'" class="btn btn-xs btn-primary">İndir</a></td>';
// 				}
			}else if($this->dId == 4){
				echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncSGBOde('.$row['ID'].')">Ödeme Yap</button></td>';
				echo '<td>';
				echo '<a target="_blank" class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'">PDF</a><br>
							<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'">PDF <small>(Talep Edilen)</small></a><br>';
				echo '</td>';
                echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncGetFatura('.$row['ID'].')">Fatura</button></td>';
				echo '<td>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-primary" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a><br>';
				echo '</td>';
			}else if($this->dId == 5){
				echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncGeriOdemeBilgi('.$row['ID'].')">Geri Ödendi</button></td>';
				echo '<td>';
				echo '<a target="_blank" class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=aday_odeme&IstekId='.$row['ID'].'">Aday Ödeme Dosyası</a><br>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdfimzali/'.$row['ID'].'/'.$row['AB_ADAY_DOSYA'].'">PDF</a><br>
							<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-danger" href="index.php?dl=abhibe/adaypdf/'.$row['ID'].'/'.$row['DOSYA'].'">PDF <small>(Talep Edilen)</small></a><br>';
				echo '</td>';
                echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncGetFatura('.$row['ID'].')">Fatura</button></td>';
				echo '<td>';
				echo '<a style="margin-top:5px;" target="_blank" class="btn btn-xs btn-primary" href="index.php?dl=abhibe/ekstre/'.$row['ID'].'/'.$row['EKSTRE'].'">Ekstre</a><br>';
				echo '</td>';
			}
			
			echo '<td><a href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=aday_basvuru&IstekId='.$row['ID'].'" target="_blank" class="btn btn-xs btn-primary">İndir</a></td>';
			echo '<td>'.Hesapla(UcretDuzenle($istekUcret[$row['ID']]['kdvli'])).' TL</td>';
			echo '<td>'.Hesapla(UcretDuzenle($istekUcret[$row['ID']]['kdvsiz'])).' TL</td>';
			
			if($this->dId == 5){
				echo '<td>'.Hesapla(UcretDuzenle($row['ODENEN'])).' €</td>';
			}
			
			echo '</tr>';
			$say++;
		} 
		?>
		</tbody>
	</table>
</div>
<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar son) -->

<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
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
	
	jQuery('.tarih').live('hover',function(e){
		e.preventDefault();
		jQuery(this).datepicker({
			changeYear: true,
		    changeMonth: true
		});
	});

	jQuery('#KayOnay').live('click',function(e){
		e.preventDefault();
		if(jQuery('#SgbOdemeForm input[name="ucret"]').val() == ''){
			alert('Ödenen Ücret kısmını boş bırakmayınız.');
		}else if(jQuery('#SgbOdemeForm input[name="kur"]').val() == ''){
			alert('Ödenen Ücret Kuru kısmını boş bırakmayınız.');
		}else if(!jQuery('#SgbOdemeForm input[name="fileOdeme"]')[0].files[0]){
			alert('Ödeme Dekontu kısmını boş bırakmayınız.');
		}else{
			jQuery('#SgbOdemeForm').submit();
		}
	});

	jQuery('#GeriGonderKay').live('click',function(e){
		e.preventDefault();
		if(jQuery('#GeriGonderForm textarea[name="aciklama"]').val() == ''){
			alert('Açıklama kısmını boş bırakmayınız.');
		}else{
			if(confirm('Bu AB Hibe İsteğini Geri Göndermek  İstediğinizden Emin Misiniz?')){
				jQuery('#GeriGonderForm').submit();				
			}else{
				return false;
			}
		}
	});
});

function DKOlusturLinkeGit(tId){
	var link = 'index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=tesvikpdf&IstekId='+tId;
	window.open(link,'_blank');
	setTimeout(function(){
		window.location.reload(); 
	}, 5000);
	
}

function FuncPdfYukle(IstekId){
	jQuery('#TesvikPdfIstek input[name="IstekId"]').val(IstekId);
	OpenLightBox('#TesvikPdf');
}

function FuncTesvikIstekSil(tId){
	if(confirm('Bu Teşvik İsteğini Silmek İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikSil&format=raw",
			data:'IstekId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Talebi Başarıyla Silindi.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Silme İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function KotaOdemeKontrolWithId(IstekId){
	var durum = false;

	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme_abhibe&task=KotaOdemeKontrolWithId&format=raw",
		data:"IstekId="+IstekId+'&doviz=<?php echo $dovizKuru;?>'
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat['hata']){
			durum = true;
			alert(dat['mesaj']);
		}
	});

	return durum;
}

function FuncTesvikOnayaSun(tId,dId){
	var durum = false;
	if(dId == 2 && !KotaOdemeKontrolWithId(tId)){
		if(confirm('Bu Hibe İsteğini Onaylayarak Kuruluşun Adaylara Ödeme Yapmasını İstediğinizden Emin Misiniz?')){
			durum = true;
		}
	}else if(dId == 4 && confirm("Bu Hibe İsteğinin Ödenmesi İçin SGB'ye Göndermek İstediğinizden Emin Misiniz?")){
		durum = true;
	}else{
		return false;
	}
	
	if(durum){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_abhibe&task=YoneticiHibeOnayla&format=raw",
			data:'IstekId='+tId+'&dId='+dId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Hibe İsteği Başarıyla Onaylandı.');
				window.location.reload();
			}else{
				alert('Bira hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncGeriOdemeBilgi(tId){
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme_abhibe&task=GeriOdemeBilgi&format=raw",
		data:'IstekId='+tId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('div#GeriOdemeBilgi #GeriUcret').html(number_format(dat['ODENEN'],'2',',','.')+' €');
			jQuery('div#GeriOdemeBilgi #GeriKur').html(dat['BANKA_KURU']+' TL');
			jQuery('div#GeriOdemeBilgi #GeriTarih').html(dat['ODEME_TARIHI']);
			OpenLightBox('div#GeriOdemeBilgi');
		}else{
			alert('Bira hata meydana geldi. Lütfen tekrar deneyin.');
		}
	});
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

function FuncSGBOde(tId){
	jQuery('#SgbOdemeForm input[name="IstekId"]').val(tId);
	jQuery('#SgbOdemeForm input[name="ucret"]').val('');
	jQuery('#SgbOdemeForm input[name="Otarih"]').val('');
	jQuery('#SgbOdemeForm input[name="kur"]').val('');
	OpenLightBox('#SgbOdeme');
}

function FuncTesvikGeriGonder(tId){
	jQuery('#GeriGonderForm input[name="IstekId"]').val(tId);
	jQuery('#GeriGonderForm textarea[name="aciklama"]').val('');
	OpenLightBox('#GeriGonder');
}

function FuncPdfSil(IstekId){
	if(confirm("Yüklemiş Olduğunuz Aday PDF'ini Silmek İstediğinizden Emin Misiniz?")){
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_belgelendirme_abhibe&task=TesvikAdayImzaliPdfSil&format=raw",
			data:'IstekId='+IstekId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Başarıyla silindi.');
				window.location.reload();
			}else{
				alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncGetFatura(IstekId){
    jQuery('#TesvikFatura #faturatutar').html('');
    jQuery('#TesvikFatura #faturano').html('');
    jQuery('#TesvikFatura #faturatarih').html('#');
    jQuery('#TesvikFatura #filefatura').attr('href','#');
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_belgelendirme_abhibe&task=AjaxGetFaturaBilgi&format=raw",
        data:'IstekId='+IstekId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            jQuery('#TesvikFatura #faturatutar').html(dat['FATURA_TUTAR']+' TL');
            jQuery('#TesvikFatura #faturano').html(dat['FATURA_NO']);
            jQuery('#TesvikFatura #faturatarih').html(dat['FATURA_TARIH']);
            var fatLink = 'index.php?dl=abhibe/fatura/'+IstekId+'/'+dat['FATURA'];
            jQuery('#TesvikFatura #filefatura').attr('href',fatLink);
            OpenLightBox('#TesvikFatura');
        }else{
            alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
            window.location.reload();
        }
    });
}

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   
   if (!(
		   charCode == 8 
		   || charCode == 46 
		   || (charCode >= 35 && charCode <= 40)
		   || (charCode >= 48 && charCode <= 57)
     )){
      return false;
   }

   return true;
}

function number_format(number, decimals, dec_point, thousands_sep) {
	  //  discuss at: http://phpjs.org/functions/number_format/
	  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // improved by: davook
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Theriault
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // bugfixed by: Michael White (http://getsprink.com)
	  // bugfixed by: Benjamin Lupton
	  // bugfixed by: Allan Jensen (http://www.winternet.no)
	  // bugfixed by: Howard Yeend
	  // bugfixed by: Diogo Resende
	  // bugfixed by: Rival
	  // bugfixed by: Brett Zamir (http://brett-zamir.me)
	  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  //  revised by: Luke Smith (http://lucassmith.name)
	  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
	  //    input by: Jay Klehr
	  //    input by: Amir Habibi (http://www.residence-mixte.com/)
	  //    input by: Amirouche
	  //   example 1: number_format(1234.56);
	  //   returns 1: '1,235'
	  //   example 2: number_format(1234.56, 2, ',', ' ');
	  //   returns 2: '1 234,56'
	  //   example 3: number_format(1234.5678, 2, '.', '');
	  //   returns 3: '1234.57'
	  //   example 4: number_format(67, 2, ',', '.');
	  //   returns 4: '67,00'
	  //   example 5: number_format(1000);
	  //   returns 5: '1,000'
	  //   example 6: number_format(67.311, 2);
	  //   returns 6: '67.31'
	  //   example 7: number_format(1000.55, 1);
	  //   returns 7: '1,000.6'
	  //   example 8: number_format(67000, 5, ',', '.');
	  //   returns 8: '67.000,00000'
	  //   example 9: number_format(0.9, 0);
	  //   returns 9: '1'
	  //  example 10: number_format('1.20', 2);
	  //  returns 10: '1.20'
	  //  example 11: number_format('1.20', 4);
	  //  returns 11: '1.2000'
	  //  example 12: number_format('1.2000', 3);
	  //  returns 12: '1.200'
	  //  example 13: number_format('1 000,50', 2, '.', ' ');
	  //  returns 13: '100 050.00'
	  //  example 14: number_format(1e-8, 8, '.', '');
	  //  returns 14: '0.00000001'

	  number = (number + '')
	    .replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
	}
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="GeriGonder" style=" max-width: 70%; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
<form id="GeriGonderForm" action="index.php?option=com_belgelendirme_abhibe&task=ABHibeGeriGonder" enctype="multipart/form-data" method="post">
	<div class="anaDiv fontBold hColor font20 text-center">
		AB Hibe İsteği Geri Gönder
	</div>
    <div class="anaDiv" style="display: inline-flex">
    	<div class="div30 hColor font18 fontBold">
    		Açıklama:
    	</div>
    	<div class="div70">
    		<textarea name="aciklama" class="inputW90"></textarea>
    		<input type="hidden" name="IstekId"/>
    	</div>
    </div>
    <div class="anaDiv">
    	<div class="div50 text-left">
    		<button type="button" class="btn btn-danger fontBold font18" onclick="CloseLightBox('#GeriGonder')">İptal</button>
    	</div>
    	<div class="div50 text-right">
    		<button type="button" class="btn btn-success fontBold font18" id="GeriGonderKay">Kaydet</button>
    	</div>
    </div>
</form>
</div>

<div id="SgbOdeme" style=" max-width: 70%; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="SgbOdemeForm" action="index.php?option=com_belgelendirme_abhibe&task=SGBUcretKaydet" enctype="multipart/form-data" method="post">
    	<input type="hidden" name="IstekId" value="0"/>
    	<div class="anaDiv text-center fontBold hColor font18">
    		AB Hibe Ücret İadesi Kapsamında Ödenen Ücret
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödenen Ücret (EURO):
    		</div>
    		<div class="div70">
    			<input type="text" name="ucret" class="input-sm inputW90" onkeypress="return isNumberKey(event)"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödenen Ücret (EURO) Kuru:
    		</div>
    		<div class="div70">
    			<input type="text" name="kur" class="input-sm inputW90" onkeypress="return isNumberKey(event)"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödeme Tarihi: 
    		</div>
    		<div class="div70">
    			<input type="text" name="Otarih" class="input-sm inputW90 tarih" />
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödeme Dekontu:
    		</div>
    		<div class="div70">
    			<input type="file" name="fileOdeme" class="input-sm inputW90" />
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div50 text-left">
    			<button type="button" class="btn btn-danger fontBold font18" onclick="CloseLightBox('#SgbOdeme')">İptal</button>
    		</div>
    		<div class="div50 text-right">
    			<button type="button" class="btn btn-success fontBold font18" id="KayOnay">Kaydet ve Onayla</button>
    		</div>
    	</div>
    </form>
</div>

<div id="GeriOdemeBilgi" style=" max-width: 70%; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    	<div class="anaDiv text-center fontBold hColor font18">
    		AB Hibe Ücret İadesi Kapsamında Ödenen Ücret Bilgisi
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödenen Ücret (EURO):
    		</div>
    		<div class="div70 fontBold font18" id="GeriUcret">
    			
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödenen Ücret (EURO) Kuru:
    		</div>
    		<div class="div70 fontBold font18" id="GeriKur">
    			
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Ödeme Tarihi: 
    		</div>
    		<div class="div70 fontBold font18" id="GeriTarih">

    		</div>
    	</div>
    	<div class="anaDiv">
    		<button type="button" class="btn btn-danger fontBold font18" onclick="CloseLightBox('#GeriOdemeBilgi')">İptal</button>
    	</div>
</div>

<div id="TesvikPdf" style=" min-width: 150px; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="TesvikPdfIstek" action="index.php?option=com_belgelendirme_abhibe&task=TesvikAdayImzaliPdfKaydet" enctype="multipart/form-data" method="post">
    	<input type="hidden" name="IstekId" value="0"/>
    	<div class="anaDiv text-center fontBold hColor font18">
    		Ücret İadesi Talep İmzalı Aday PDF Dökümanı Yükle
    	</div>
    	<div class="anaDiv">
    		<div class="div30 hColor fontBold font16">
    			Döküman:
    		</div>
    		<div class="div70">
    			<input type="file" name="IstekPdf" class="input-sm inputW90"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div50 text-left">
    			<button type="button" class="btn btn-danger fontBold font18" onclick="CloseLightBox('#TesvikPdf')">İptal</button>
    		</div>
    		<div class="div50 text-right">
    			<button type="submit" class="btn btn-success fontBold font18">Kaydet</button>
    		</div>
    	</div>
    </form>
</div>

<div id="TesvikFatura" style="width: 50%; min-height:150px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv text-center fontBold hColor font18">
        Fatura Bilgileri
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura Tutarı:
        </div>
        <div class="div80 font18 fontBold" id="faturatutar">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura No:
        </div>
        <div class="div80 font18 fontBold" id="faturano">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura Tarih:
        </div>
        <div class="div80 font18 fontBold" id="faturatarih">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura Dosyası:
        </div>
        <div class="div80">
            <a id="filefatura" target="_blank" class="btn btn-sm btn-info" href="#">İndir</a>
        </div>
    </div>
    <div class="anaDiv">
        <button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#TesvikFatura')">İptal</button>
    </div>
</div>