<?php
$KurPro = $this->ABKurPro;
$toplamKota = $this->ABKurKota;
$OdenenKota = $this->ABKurKullanilanKota;
$OdenenDezKota = $this->ABKurKullanilanDezKota;
$ABKurBekKota = UcretDuzenle($this->ABKurBekKota);
$ABKurBekDezKota = UcretDuzenle($this->ABKurBekDezKota);
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$tesvik = $this->tesvik;
$kurBilgi = $this->kurBilgi;
$dovizKuru = $tesvik['DOVIZ_KURU'];

$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*UcretDuzenle($dovizKuru);

$TopDezKota = UcretDuzenle($toplamKota)/10;
$TopDezsiz = $toplamKota-$TopDezKota;

$TopKDV = 0;
$TopKDVsiz = 0;
foreach ($AdayBilgi as $row){
	$TopKDV += UcretDuzenle($row['KDVLI']);
	$TopKDVsiz += UcretDuzenle($row['KDVSIZ']);
}
?>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	İstek Id:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $tesvik['ID']?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	Kuruluş:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $kurBilgi['KURULUS_ADI'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	Ücret İadesi Talep Tarihi:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $tesvik['BIT_TARIH']?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Unvan:
	</div>
	<div class="div70 fontBold font20">
		<?php echo $tesvik['IMZA_UNVAN'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Ad Soyad:
	</div>
	<div class="div70 fontBold font20">
		<?php echo $tesvik['IMZA_ISIM'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		KDV'li toplam tutarı:
	</div>
	<div class="div70 font20 fontBold" id="SeciliKDV">
		<?php echo Hesapla($TopKDV);?> TL
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		KDV'siz toplam tutarı:
	</div>
	<div class="div70 font20 fontBold" id="SeciliKDVsiz">
		<?php echo Hesapla($TopKDVsiz);?> TL
	</div>
</div>
<div class="anaDiv text-warning font16 fontBold">
	<i class="fa fa-exclamation-circle"></i> 
	KDV'siz tutar üzerinden kesilen faturayı yükleyin
	<i class="fa fa-exclamation-circle"></i>
</div>
<!-- Fatura Yükleme BAS -->
<div class="anaDiv" style="display: inline-flex">
	<div class="div20 hColor font20 fontBold">
		Fatura:
	</div>
	<div class="div80">
<?php
$fatlink = "#";
if($tesvik['FATURA'] == null){
	echo '<input type="hidden" id="FatDurum" value="0"/>';
?>
<div class="anaDiv" id="Fat" style="border:1px solid #00A7DE;">
	<button type="button" class="btn btn-xs btn-warning" onclick="OpenLightBox('#FaturaDosyasi')">Fatura Yükle</button>
</div>
<?php
}else{
	echo '<input type="hidden" id="FatDurum" value="1"/>';
	$fatlink = "index.php?dl=abhibe/fatura/".$tesvik['ID']."/".$tesvik['FATURA'];
?>
<div class="anaDiv divBorder" id="FatYuk" style="border:1px solid #00A7DE;">
    <div class="div30 fontBold font16 hColor">
        Fatura No:
    </div>
    <div class="div70 fontBold font16">
        <?php echo $tesvik['FATURA_NO'];?>
    </div>
    <div class="div30 fontBold font16 hColor">
        Fatura Tutarı:
    </div>
    <div class="div70 fontBold font16">
        <?php echo $tesvik['FATURA_TUTAR'].' TL';?>
    </div>
    <div class="div30 fontBold font16 hColor">
        Fatura Tarihi:
    </div>
    <div class="div70 fontBold font16">
        <?php echo $tesvik['FATURA_TARIH'];?>
    </div>
    <div class="div30 fontBold font16 hColor">
        Fatura Dosyası:
    </div>
    <div class="div70 fontBold font16">
        <a id="FatLink" target="_blank" href="<?php echo $fatlink;?>" class="btn btn-xs btn-primary">Fatura Görüntüle</a>
    </div>
    <div class="div90 text-right">
        <button type="button" class="btn btn-xs btn-danger" onclick="FuncABHibeFaturaSil(<?php echo $tesvik['ID'];?>)"><i class="fa fa-minus"></i> Sil</button>
    </div>
</div>
<?php
}
?>
	</div>
</div>
<div class="anaDiv text-warning font16 fontBold">
	<i class="fa fa-exclamation-circle"></i> 
	 Onaylanan liste üzerinden  katılımcılara yapılacak ödemeler isim sırasına göre kesintiye uğramadan belirli 
	 zaman aralığında yapılmalıdır.  Ödeme tamamlandıktan 72 saat sonra, bu zaman aralığını gösteren 
	 (ödemelere başlandığı tarih ile 72 saat sonrası  arası), banka yetkili kişisi tarafından imzalanmış ve 
	 mühürlenmiş banka ekstresi ilgili bankadan alınmalıdır.   Geri ödemeleri gösteren dekontlar, MYK’ya kesilen 
	 fatura ve hesap ekstresi  Portal’a yüklenmelidir.
	<i class="fa fa-exclamation-circle"></i>
</div>
<div class="anaDiv">
	<div class="div30 fontBold font20 hColor">
		Hesap ekstresi:
	</div>
	<div class="div70" style="border:1px solid #00A7DE;">
		<div class="anaDiv">
		<?php
		if($tesvik['EKSTRE'] == null){
			echo '<input type="hidden" id="EkstreDurum" value="0"/>';
		?>
		<button type="button" class="btn btn-xs btn-warning" onclick="OpenLightBox('#EkstreDosyasi')">Hesap Ekstresi Yükle</button>
		<?php 
		}else{
			echo '<input type="hidden" id="EkstreDurum" value="1"/>';
		?>
		<div class="divYan">
			<a target="_blank" href="index.php?dl=abhibe/ekstre/<?php echo $tesvik['ID'];?>/<?php echo $tesvik['KURULUS_ODEME_DOSYASI'];?>" class="btn btn-xs btn-primary">Hesap Ektresi Görüntüle</a>
		</div>
		<div class="divYan">
			<button type="button" class="btn btn-xs btn-danger" onclick="FuncABHibeEkstreSil(<?php echo $tesvik['ID'];?>)">Sil</button>
		</div>
		<?php 
		}
		?>
		</div>
	</div>
</div>
<!-- ekstre Yükleme SON -->
<div class="anaDiv text-warning font16 fontBold">
	<i class="fa fa-exclamation-circle"></i> 
	 Adaylara yapılacak geri ödemeler her bir aday için ayrı ayrı yapılmalı ve tek dekont halinde burada yüklenmelidir.
	 Birden fazla aday için aynı IBANA geri ödeme yapılacak ise yine her bir aday için ayrı ayrı kişi ismi ve TC Kimlik 
	 numarası belirtilerek geri ödemeler yapılmalıdır ve bu dekontlar adaylara karşılık gelen satırlara yüklenmelidir.
	<i class="fa fa-exclamation-circle"></i>
</div>
<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th>#</th>
				<th>Adı Soyadı</th>
				<th>TC Kimlik</th>
				<th>Belge No</th>
				<th>Belge Düzenlenme Tarihi</th>
				<th>Yeterlilik</th>
				<th>Ödenmesi Gereken Ücret</th>
				<th>Ödeme Dekontu</th>
				<th>Başvuru Dosyası</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 0;
		foreach ($AdayBilgi as $row){
			$say++;
			echo '<tr>';
			echo '<td>'.$say.'</td>';
			
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['BELGE_DUZENLEME_TARIHI'].'</td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '<td>'.Hesapla(UcretDuzenle($row['KDVLI'])).' TL</td>';
			
			echo '<td>';
			$varStyle = "";
			$yokStyle = "";
			$odemeLink = "#";
			$odeVal = 0;
			if($row['ODEME_DOSYASI'] == null){
				$varStyle="display:none";
			}else{
				$odeVal = 1;
				$yokStyle="display:none";
				$odemeLink = "index.php?dl=abhibe/odeme/".$row['ISTEK_ID']."/".urlencode($row['ODEME_DOSYASI']);
			}
				
			// Ödeme pdf'i
			echo '<input type="hidden" class="odemefiledurum ofd_'.$row['MATID'].'" name="odemefile['.$row['BELGENO'].']" id="'.$row['BELGENO'].'" value="'.$odeVal.'">';
			echo '<div style="'.$yokStyle.'" class="OF_'.$row['MATID'].'">';
			?>
			<button type="button" class="btn btn-xs btn-success" onclick="FileLightBox(<?php echo $row['MATID'];?>,<?php echo $row['ISTEK_ID'];?>)">Yükle</button>
			<?php 
			echo '</div>';
			echo '<div style="'.$varStyle.'" class="OFY_'.$row['MATID'].'">';
			echo '<a target="_blank" href="'.$odemeLink.'" class="btn btn-xs btn-primary OFL_'.$row['MATID'].'">Ödeme Dekontu</a><br>';
			?>
			<button style="margin-top: 5px;" type="button" class="btn btn-xs btn-danger" onclick="FuncOdemeFileSil(<?php echo $row['MATID'];?>,<?php echo $row['ISTEK_ID'];?>)">Sil</button>
			<?php
			echo '</div>';
			// Ödeme pdf'i SON
			echo '</td>';

            echo '<td><button type="button" class="btn btn-xs btn-info" onclick=FuncBasvuruDosyasiGetir("'.$row['BELGENO'].'")>İndir</button></td>';

			echo '</tr>';
		} 
		?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50">
		<a href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe" class="btn btn-xs btn-danger">Geri</a>
	</div>
<!-- 	<div class="div50 text-right"> -->
<!-- 		<button type="button" class="btn btn-xs btn-success" id="OdemeKaydet">Kaydet</button> -->
<!-- 	</div> -->
</div>


<div id="OdemeDosyasi" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		AB Hibe Aday Ödeme Dekontu
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center">
		<i class="fa fa-exclamation-circle"></i> Adayın Ödeme dekontunu pdf olarak yükleyiniz. <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			Dekont:
		</div>
		<div class="div80">
			<input type="file" name="fileodeme" class="input-sm inputW95"/>
			<input type="hidden" name="matId" value="0"/>
			<input type="hidden" name="sId" value="0"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#OdemeDosyasi').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-xs btn-success" onclick="FuncOdemeFileYukle()">Yükle</button>
		</div>
	</div>
</div>
<div id="UyariLoader" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		<i class="fa fa-exclamation-circle"></i> Uyarı <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center" id="UyariBelgeNo">
		 
	</div>
	<div class="anaDiv">
		<button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">İptal</button>
	</div>
</div>

<div id="FaturaDosyasi" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
<form id="FaturaForm" action="index.php?option=com_belgelendirme_abhibe&task=ABHibeFaturaYukle" enctype="multipart/form-data" method="post">
	<div class="anaDiv font20 fontBold hColor text-center">
		Fatura Bilgisi
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center">
		<i class="fa fa-exclamation-circle"></i> Fatura dosyasını pdf olarak yükleyiniz. <i class="fa fa-exclamation-circle"></i>
	</div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura Tutarı:
        </div>
        <div class="div80">
            <input type="text" name="faturatutar" class="input-sm inputW95" onkeypress="return isNumberKey(event)"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura No:
        </div>
        <div class="div80">
            <input type="text" name="faturano" class="input-sm inputW95"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div20 font18 fontBold hColor">
            Fatura Tarih:
        </div>
        <div class="div80">
            <input type="text" name="faturatarih" class="input-sm inputW95 ttarih"/>
        </div>
    </div>
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			Fatura Dosyası:
		</div>
		<div class="div80">
			<input type="file" name="filefatura" class="input-sm inputW95"/>
			<input type="hidden" name="tId" value="<?php echo $tesvik['ID'];?>"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#FaturaDosyasi').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-xs btn-success" onclick="FuncABHibeFaturaKaydet()">Yükle</button>
		</div>
	</div>
</form>
</div>
<div id="EkstreDosyasi" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
<form id="EkstreForm" action="index.php?option=com_belgelendirme_abhibe&task=ABHibeEkstreYukle" enctype="multipart/form-data" method="post">
	<div class="anaDiv font20 fontBold hColor text-center">
		Hesap Ekstre Dosyası
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center">
		<i class="fa fa-exclamation-circle"></i> Onaylanan liste üzerinden  katılımcılara yapılacak ödemeler isim sırasına göre kesintiye uğramadan belirli zaman aralığında yapılmalıdır.  Ödeme tamamlandıktan 76 saat sonra, bu zaman aralığını gösteren ( ödemelere başlandığı tarih ile 76 saat sonrası  arası), banka yetkili kişisi tarafından imzalanmış ve mühürlenmiş banka ekstresi ilgili bankadan alınmalıdır.   Geri ödemeleri gösteren dekontlar, MYK’ya kesilen fatura ve hesap ekstresi  Portal’a yüklenmelidir. <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			Hesap Ekstresi:
		</div>
		<div class="div80">
			<input type="file" name="fileekstre" class="input-sm inputW95"/>
			<input type="hidden" name="tId" value="<?php echo $tesvik['ID'];?>"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#EkstreDosyasi').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-xs btn-success" onclick="FuncABHibeEkstreKaydet()">Yükle</button>
		</div>
	</div>
</form>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
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
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Belge Var)",
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

	jQuery('#OdemeKaydet').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();

        var HataAdayOdeme = 0;
        jQuery('.odemefiledurum').each(function(){
			if(jQuery(this).val() == 0){
				HataAdayOdeme++;
				jQuery('#UyariLoader #UyariBelgeNo').html(jQuery(this).attr('id')+" Belge No'lu Adayın Ödeme dekontu pdf olarak yükleyiniz.");
				OpenLightBox('#UyariLoader');
				return false;
			}
        });

        if(HataAdayOdeme > 0){
            return false;
       	}else{
           	
        }
	});

    jQuery('.ttarih').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true
        });
    });
});

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

function FileLightBox(matId,sId){
	jQuery('#OdemeDosyasi input[name="fileodeme"]').val('');
	jQuery('#OdemeDosyasi input[name="matId"]').val(matId);
	jQuery('#OdemeDosyasi input[name="sId').val(sId);
	OpenLightBox('#OdemeDosyasi');
}

function FuncOdemeFileYukle(){
	var matId = jQuery('#OdemeDosyasi input[name="matId"]').val();
	var sId = jQuery('#OdemeDosyasi input[name="sId"]').val();
	if(!jQuery('#OdemeDosyasi input[name="fileodeme"]')[0].files[0]){
		alert('Lütfen Aday Ödeme Dekontunu Boş Bırakmayınız.');
	}else{
		var formData = new FormData();
		formData.append('file', jQuery('#OdemeDosyasi input[name="fileodeme"]')[0].files[0]);
		formData.append('matId', matId);
		formData.append('sId', sId);
	
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayOdemeFileYukle&format=raw',
			type : 'POST',
			data : formData,
			processData: false,  // tell jQuery not to process the data
			contentType: false,  // tell jQuery not to set contentType
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat['hata']){
					alert(dat['message']);
					jQuery('input.ofd_'+matId).val(0);
				}else{
	                jQuery('div.OF_'+matId).hide();
	                jQuery('div.OFY_'+matId).show();
	                jQuery('a.OFL_'+matId).attr('href','index.php?dl=abhibe/odeme/'+sId+'/'+dat['name']);
	                jQuery('input.ofd_'+matId).val(1);
	                alert(dat['message']);
	            }
				jQuery('#OdemeDosyasi').trigger('close');
		   }
		});
	}
}

function FuncOdemeFileSil(matId,sId){
	if(confirm('Adaya ait ödeme dekontunu silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayOdemeFileSil&format=raw',
			type : 'POST',
			data : 'matId='+matId+'&sId='+sId,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat){
					jQuery('input.ofd_'+matId).val(0);
					jQuery('div.OFY_'+matId).hide();
	                jQuery('div.OF_'+matId).show();
	                jQuery('a.OFL_'+matId).attr('href','#');
					alert('Aday Ödeme dekontu başarıyla silindi.');
				}else{
	                alert('Bir hata meydana geldi. Tekrar deneyin.');
	            }
		   }
		});
	}
}

function FuncABHibeFaturaKaydet(){
	if(!jQuery('#FaturaForm input[name="filefatura"]')[0].files[0]){
		alert('Lütfen Yüklemek İstediğiniz Dosyayı Seçiniz.');
	}else if(jQuery('#FaturaForm input[name="faturatutar"]').val() == ''){
        alert('Lütfen Fatura Tutarını Giriniz.');
    }else if(jQuery('#FaturaForm input[name="faturano"]').val() == ''){
        alert('Lütfen Fatura Numarasını Giriniz.');
    }else if(jQuery('#FaturaForm input[name="faturatarih"]').val() == ''){
        alert('Lütfen Fatura Tarihini Giriniz.');
    }else{
		jQuery('#FaturaForm').submit();
	}
}

function FuncABHibeFaturaSil(tId){
	if(confirm('Fatura dosyasını silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeFaturaSil&format=raw',
			type : 'POST',
			data : 'tId='+tId,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Fatura dosyası başarıyla silindi.');
					window.location.reload();
				}else{
	                alert('Bir hata meydana geldi. Tekrar deneyin.');
	                window.location.reload();
	            }
		   }
		});
	}
}

function FuncABHibeEkstreKaydet(){
	if(!jQuery('#EkstreForm input[name="fileekstre"]')[0].files[0]){
		alert('Lütfen Yüklemek İstediğiniz Dosyayı Seçiniz.');
	}else{
		jQuery('#EkstreForm').submit();
	}
}

function FuncABHibeEkstreSil(tId){
	if(confirm('Hesap ekstre dosyasını silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeEkstreSil&format=raw',
			type : 'POST',
			data : 'tId='+tId,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat){
					alert('Hesap ekstre dosyası başarıyla silindi.');
					window.location.reload();
				}else{
	                alert('Bir hata meydana geldi. Tekrar deneyin.');
	                window.location.reload();
	            }
		   }
		});
	}
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

function FuncBasvuruDosyasiGetir(bNo){
    jQuery.ajax({
        async:false,
        type:'POST',
        url:'index.php?option=com_belgelendirme_abhibe&task=AjaxAdayBasvuruDosyasi&format=raw',
        data:'bNo='+bNo
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            window.open('http://portal.myk.gov.tr/index.php?dl=abhibe/basvuru/'+dat['SINAV_ID']+'/'+dat['DOKUMAN']);
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
        }
    });
}
</script>

<?php 
function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}

function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
?>