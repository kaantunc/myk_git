<div class="anaDiv text-center fontBold hColor font18">
    Avrupa Topluluğu (AT) Yüklenicileri Tarafından 2.000 TL’nin Üstünde Yapılan Alımlara İlişkin Üçer Aylık Bildirim Tablosu Sorgusu
</div>
<form id="atForm" action="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=atword" enctype="multipart/form-data" method="post">
<div class="anaDiv">
    <div class="div30 fontBold font16 hColor">
        Sorgu Başlangıcı:
    </div>
    <div class="div70">
        <input type="text" name="sBas" class="input-sm tarih"/>
    </div>
</div>
<div class="anaDiv">
    <div class="div30 fontBold font16 hColor">
        Sorgu Bitişi:
    </div>
    <div class="div70">
        <input type="text" name="sBit" class="input-sm tarih"/>
    </div>
</div>
<div class="anaDiv">
    <button type="button" class="btn btn-sm btn-success" id="calistir">Çalıştır</button>
</div>
</form>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.tarih').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true
        });
    });

    jQuery('#calistir').live('click',function(e){
        e.preventDefault();
        var sBas = jQuery('input[name="sBas"]').val();
        var sBit = jQuery('input[name="sBit"]').val();
        if(sBas == '' || sBit == ''){
            alert('Lütfen Sorgu Başlangıç ve Bitiş Tarihlerini Giriniz.');
        }else{
            jQuery('#atForm').submit();
        }
    });
});
</script>