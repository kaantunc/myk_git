<?php
$bNo = $this->bNo;
?>
<div class="anaDiv text-center font18 fontBold hColor">
	AB Hibesi Aday Bildiriminde Bulunma (Belgesi Basılmış Adaylar İçin)
</div>
<div class="anaDiv">
    <div class="div30 fontBold hColor font18">
        Aday Belge No:
    </div>
    <div class="div70">
        <input type="text" id="bNo" class="input-sm inputW90" value="<?php echo !empty($bNo)?$bNo:'';?>"/>
    </div>
</div>
<div class="anaDiv">
    <button type="button" class="btn btn-sm btn-primary" id="bNoBilgiGetir">Getir</button>
</div>
<div class="anaDiv">
    <hr>
</div>
<div id="divHide" style="display: none">
    <form id="FormABHibe" enctype="multipart/form-data" method="post" action="index.php?option=com_belgelendirme_abhibe&task=ABHibeYoneticiAdayKaydet">
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            TC Kimlik No:
        </div>
        <div class="div70 fontBold font18" id="tckimlik">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Ad Soyad:
        </div>
        <div class="div70 fontBold font18" id="adsoyad">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Belge No:
        </div>
        <div class="div70 fontBold font18" id="belgeno">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Hesaplanan Ücret:
        </div>
        <div class="div70 fontBold font18" id="ucret">

        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Aday Başvuru IBAN:
        </div>
        <div class="div70 fontBold font18">
            <input type="text" name="basIban" class="input-sm inputW90"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Aday Başvuru Formu:
        </div>
        <div class="div70 fontBold font18">
            <input type="file" name="basForm" class="input-sm inputW90"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 fontBold hColor font18">
            Aday Dezavantaj Bilgisi:
        </div>
        <div class="div70 fontBold font18">
            <input type="file" name="adayDez" class="input-sm inputW90"/>
        </div>
    </div>
        <input type="hidden" name="bNo" value="0"/>
        <input type="hidden" name="tc" value="0"/>
    <div class="anaDiv">
        <button type="button" class="btn btn-sm btn-success" id="ABHibeKaydet">Kaydet</button>
    </div>
	<input type="hidden" name="itirazdurum" value="0"/>
    </form>
</div>

<div id="UyariLoader" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv font20 fontBold hColor text-center">
        <i class="fa fa-exclamation-circle"></i> Uyarı <i class="fa fa-exclamation-circle"></i>
    </div>
    <div class="anaDiv font16 text-warning fontBold text-center" id="UyariContent">

    </div>
    <div class="anaDiv">
        <button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">İptal</button>
    </div>
</div>

        <!-- Ücret Düzeltme Talebi-->
        <div id="UcretDuzTalep" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
                <div class="anaDiv font20 fontBold hColor text-center">
                    <i class="fa fa-exclamation-circle"></i> Ücret Düzeltme Talebi <i class="fa fa-exclamation-circle"></i>
                </div>
                <div class="anaDiv">
                    <div class="div20 font16 hColor">
                        Yeni Ücret:
                    </div>
                    <div class="div80">
                        <input type="text" name="itiraz_ucret" class="input-sm inputW95"  onkeypress="return isNumberKey(event)"/>
                    </div>
                </div>
                <div class="anaDiv">
                    <div class="div100 font16 hColor">
                        Açıklama:<br/>
                        <textarea name="itiraz_aciklama" class="inputW100" rows="10"></textarea>
                    </div>
                </div>
                <div class="anaDiv">
                    <div class="div20 font16 hColor">
                        Ek Dosya:
                    </div>
                    <div class="div80" id="filecontain">
                        <input type="file" name="itiraz_dosya"/>
                    </div>
                </div>
                <div class="anaDiv text-right">
                    <div class="divYan"><button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#UcretDuzTalep').trigger('close');">Kapat</button></div>
                    <div class="divYan"><button type="button" class="btn btn-xs btn-warning" id="UcretDuzFormTemizle">Formu Temizle</button></div>
                    <div class="divYan"><button type="button" class="btn btn-xs btn-success" id="UcretDuzFormKaydet">Kaydet</button></div>
                </div>

        </div>

<script type="text/javascript">
jQuery(document).ready(function(){
    <?php if(!empty($bNo)){ ?>
    FuncGetBNOBilgi('<?php echo $bNo; ?>');
    <?php } ?>

    jQuery('#bNoBilgiGetir').live('click',function(e){
        e.preventDefault();
        FuncGetBNOBilgi(jQuery('#bNo').val());
    });

    jQuery('#divHide #ABHibeKaydet').live('click',function(e){
    	e.preventDefault();
        jQuery.blockUI();
        var iban = jQuery('#divHide input[name="basIban"]').val();
        if(iban.length != 26){
            jQuery('#UyariLoader #UyariContent').html('IBAN bilgisi hatalıdır. Kontrol ediniz.');
            jQuery.unblockUI();
            OpenLightBox('#UyariLoader');
        }else if(!jQuery('#divHide input[name="basForm"]')[0].files[0]){
            jQuery('#UyariLoader #UyariContent').html('Lütfen Başvuru Formunu Giriniz.');
            jQuery.unblockUI();
            OpenLightBox('#UyariLoader');
        }else if(jQuery('#divHide input[name="basForm"]')[0].files[0].type != 'application/pdf'){
            jQuery('#UyariLoader #UyariContent').html('Lütfen Başvuru Formunun PDF Formatında Olduğundan Emin Olunuz.');
            jQuery.unblockUI();
            OpenLightBox('#UyariLoader');
        }else if(jQuery('#divHide input[name="adayDez"]')[0].files[0] && jQuery('#divHide input[name="adayDez"]')[0].files[0].type != 'application/pdf'){
            jQuery('#UyariLoader #UyariContent').html('Lütfen Dezavantaj Dosyasının PDF Formatında Olduğundan Emin Olunuz.');
            jQuery.unblockUI();
            OpenLightBox('#UyariLoader');
        }else{
        	if(jQuery('input[name="itirazdurum"]').val() == 1){
        		jQuery('#FormABHibe').append(jQuery('div#UcretDuzTalep input'));
        		jQuery('#FormABHibe').append(jQuery('div#UcretDuzTalep textarea'));
            }
            jQuery('#FormABHibe').submit();
            //jQuery.unblockUI();
        }
    });

    jQuery('#UcretDuzTalep #UcretDuzFormTemizle').live('click',function(e){
        e.preventDefault();
        if(confirm('Ücret Düzeltme Formundaki Girmiş Oldugunuz Bilgiler Silinecektir. Emin misiniz?')){
            jQuery("#UcretDuzTalep input[name='itiraz_ucret']").val("");
            jQuery("#UcretDuzTalep textarea[name='itiraz_aciklama']").val("");
            jQuery("#UcretDuzTalep input[name='itiraz_dosya']").val(null);
            jQuery('input[name="itirazdurum"]').val(0);
            jQuery('#divHide #UcetDuzBut').html('Ücret Düzeltme Talebi');
        }
        return false;
    });

    jQuery('#UcretDuzTalep #UcretDuzFormKaydet').live('click',function(e){
        e.preventDefault();
        var itucret = jQuery("#UcretDuzTalep input[name='itiraz_ucret']").val();
        var itaciklama = jQuery("#UcretDuzTalep textarea[name='itiraz_aciklama']").val();

        if(itucret.length == 0){
            alert('Lütfen Yeni Ücreti Giriniz.');
        }else if(itaciklama.length == 0){
            alert('Lütfen Açıklama Giriniz.');
        }else if(!jQuery("#UcretDuzTalep input[name='itiraz_dosya']")[0].files[0]){
            alert('Lütfen Ek Dosyayı Giriniz.');
        }else if(jQuery("#UcretDuzTalep input[name='itiraz_dosya']")[0].files[0].type != 'application/pdf'){
            alert('Lütfen Ek Dosyayının Formatının PDF Oldugundan Emin Olunuz.');
        }else{
            jQuery('input[name="itirazdurum"]').val(1);
            jQuery('#divHide #UcetDuzBut').html('Ücret Düzeltildi');
            jQuery('#UcretDuzTalep').trigger('close');
        }
    });

    jQuery('#divHide #UcetDuzBut').live('click',function(e){
        e.preventDefault();
        OpenLightBox('#UcretDuzTalep');
    });
});

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

function FuncGetBNOBilgi(bNo){
    jQuery('#divHide').hide();
    jQuery.blockUI();
    jQuery.ajax({
        async:true,
        type:'POST',
        url:'index.php?option=com_belgelendirme_abhibe&task=AjaxGetAbHibeBelgeNo&format=raw',
        data:'bNo='+bNo
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat['hata']){
            jQuery('#UyariLoader #UyariContent').html(dat['message']);
            jQuery.unblockUI();
            OpenLightBox('#UyariLoader');
        }else{
            var AdayBilgi = dat['AdayBilgi'];
            var UcretBilgi = dat['UcretBilgi'];
            var ucret = 0;
            jQuery('#divHide #tckimlik').html(AdayBilgi['TC_KIMLIK']);
            jQuery('#divHide #adsoyad').html(AdayBilgi['ADI']+' '+AdayBilgi['SOYADI']);
            jQuery('#divHide #belgeno').html(AdayBilgi['BELGE_NO']);
            jQuery('#divHide input[name="bNo"]').val(AdayBilgi['BELGE_NO']);
            jQuery('#divHide input[name="tc"]').val(AdayBilgi['TC_KIMLIK']);
            if(jQuery.type(UcretBilgi) == 'object'){
            	jQuery.each(UcretBilgi,function(key,val){
                    ucret += parseInt(val['ucret'].replace(',','.'));
                });
            }
            
            var ekUcret = '<div class="divYan">'+number_format(ucret,2,',','.')+' TL</div><div style="margin-left: 20px;" class="divYan"><button type="button" class="btn btn-sm btn-danger" id="UcetDuzBut">Ücret Düzeltme Talebi</button></div>';
            jQuery('#divHide #ucret').html(ekUcret);
            jQuery('#divHide').show('slow');
            jQuery.unblockUI();
        }
    });

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