<?php
$kurulus = $this->kurulus_bilgi;
$abKur = $this->abKur;
$pro = $abKur['pro'];
$donem = $abKur['donem'];

// Kota Bilgileri
$KurPro = $this->ABKurPro;
$doviz = $this->doviz;
$TopKota = UcretDuzenle($this->ABKurKota);
$TopKullanilan = UcretDuzenle($this->ABKurKullanilanKota);
$TopKulDez = UcretDuzenle($this->ABKurKullanilanDezKota);
$ABKurBekKota = UcretDuzenle($this->ABKurBekKota);
$ABKurBekDezKota = UcretDuzenle($this->ABKurBekDezKota);

$TopDezKota = 0;
if($KurPro['DEZAVANTAJ']){
    $TopDezKota = $TopKota/10;
}
$TopDezsiz = $TopKota-$TopDezKota;

$dovizKuru = UcretDuzenle($doviz['alis']);

function UcretDuzenle($ucret){
    return str_replace(',', '.',$ucret);
}

function Hesapla($alinacak){
    $dat = floor($alinacak*100)/100;
    return number_format($dat,'2',',','.');
}
?>
<div class="anaDiv text-center">
    <?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>

<div class="anaDiv fontBold font18 hColor text-center">
    AB Hibe Protokolü
</div>
<div class="anaDiv" id="ProDok">
    <table style="width: 100%; text-align:center" border="1">
        <thead class="bg-primary text-center  thPad5">
        <tr>
            <th width="10%">Protokol Tarihi</th>
            <th width="20%">Protokol Dökümanı</th>
            <th width="10%">KDV</th>
            <th width="20%">Dezavantaj</th>
            <?php if($this->canEdit){
                echo '<th width="10%">Düzenle</th>';
            }?>
        </tr>
        </thead>
        <tbody class="text-center tdPad5 fontBold">
        <?php foreach($pro as $row){
            echo '<tr>';
            echo '<td>'.$row['PRO_TARIH'].'</td>';
            echo '<td><a href="index.php?dl=kurulus/'.$kurulus['USER_ID'].'/ab_protokol/'.$row['PRO_DOK'].'" class="btn btn-xs btn-warning">Protokol Dökümanı</a></td>';
            echo '<td>%'.$row['KDV'].'</td>';
            if($this->canEdit){
                if($row['DEZAVANTAJ']){
                    echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncDezUygulamaGuncelle('.$row['ID'].',0)">Dezavantaj Uygulamasını Kaldır</button></td>';
                }else{
                    echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncDezUygulamaGuncelle('.$row['ID'].',1)">Dezavantaj Uygulamasını Uygula</button></td>';
                }
            }else{
                if($row['DEZAVANTAJ']){
                    echo '<td>Dezavantaj Uygulması Var</td>';
                }else{
                    echo '<td>Dezavantaj Uygulması Yok</td>';
                }
            }

            if($this->canEdit){
                echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncProDuzenle('.$row['ID'].')">Düzenle</button></td>';
            }

            echo '</tr>';
        }?>
        </tbody>
    </table>
</div>
<?php if($this->canEdit && count($pro) == 0){ ?>
    <div class="anaDiv">
        <button type="button" class="btn btn-xs btn-primary" id="ProEkle">Protokol Sözleşmesi Ekle</button>
    </div>
<?php } ?>
<div class="anaDiv">
    <hr>
</div>
<div class="anaDiv fontBold font18 hColor text-center">
    AB Hibe Kotası
</div>
<div class="anaDiv" id="ProDonem">
    <table style="width: 100%; text-align:center" border="1">
        <thead class="bg-primary text-center thPad5">
        <tr>
            <th width="15%">Tarih</th>
            <th width="15%">Hibe Ücreti</th>
            <?php if(!$this->canEdit){?>
                <th width="15%">Hibe Kullanımı</th>
            <?php } ?>
            <?php if($this->canEdit){?>
                <th width="15%">Düzenle</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody class="text-center tdPad5 fontBold">
        <?php foreach($donem as $row){
            echo '<tr>';
            echo '<td>'.$row['BAS_TARIH'].'</td>';
            echo '<td>'.$row['UCRET'].' €</td>';
            if(!$this->canEdit){
                echo '<td><a target="_blank" class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe">Hibe Kullanımı</a></td>';
            }
            if($this->canEdit){
                echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncDonemDuzenle('.$row['ID'].')">Düzenle</button></td>';
            }
            echo '</tr>';
        }?>
        </tbody>
    </table>
</div>
<?php if($this->canEdit && count($donem) == 0){ ?>
    <div class="anaDiv">
        <button type="button" class="btn btn-xs btn-primary" id="DonemEkle">Hibe Dönemi Ekle</button>
    </div>
<?php } ?>
<div class="anaDiv">
    <hr>
</div>
<div class="anaDiv fontBold font18 hColor text-center">
    Kuruluş Vergi Kimlik No
</div>
<div class="anaDiv">
    <div class="div20 font16 fontBold hColor">
        Vergi Kimlik No:
    </div>
    <div class="div80">
        <div class="divYan font18 fontBold"><?php echo $kurulus['VERGI_KIMLIK_NO'];?></div>
        <div class="divYan" style="margin-left: 50px;"><button type="button" class="btn btn-sm btn-primary" onclick="FuncVergiNoDuzenle(<?php echo $kurulus['KURULUS_ID'];?>)">Düzenle</button></div>
    </div>
</div>
<div class="anaDiv">
    <hr>
</div>
<?php if($donem && $pro){ ?>
    <div class="anaDiv">
        <div class="div60 font16 fontBold hColor">
            TC Merkez Bankası EURO <span class="font16">(<?php echo $doviz['tarih'];?>)</span>:
        </div>
        <div class="div40 fontBold font16">
            <?php echo $doviz['alis'].' TL';?>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    AB Hibe Toplam Kota <span class="font16">(TL)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla($TopKota*UcretDuzenle($dovizKuru)).' TL';?>
                </div>
            </div>
        </div>
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    AB Hibe Toplam Kota <span class="font16">(EURO)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla($TopKota).' €';?>
                </div>
            </div>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    AB Hibe Kullanilan Toplam Kota <span class="font16">(TL)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla(UcretDuzenle($TopKullanilan)*UcretDuzenle($dovizKuru)).' TL';?>
                </div>
            </div>
        </div>
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    AB Hibe Kullanilan Toplam Kota <span class="font16">(EURO)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla(UcretDuzenle($TopKullanilan)).' €';?>
                </div>
            </div>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Kullanılabilir Kota <span class="font16">(TL)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php
                    echo Hesapla(($TopDezsiz-($TopKullanilan-$TopKulDez))*UcretDuzenle($dovizKuru)). 'TL';
                    // 				echo Hesapla($OdenenDezKota*UcretDuzenle($dovizKuru)).' TL';?>
                </div>
            </div>
        </div>
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Kullanılabilir Kota <span class="font16">(EURO)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla($TopDezsiz-($TopKullanilan-$TopKulDez)).' €';?>
                </div>
            </div>
        </div>
    </div>
    <?php if($KurPro['DEZAVANTAJ']){ ?>
        <div class="anaDiv">
            <div class="div50">
                <div class="anaDiv">
                    <div class="div60 font16 fontBold hColor">
                        Kullanılabilir Dezavantajlı Kota <span class="font16">(TL)</span>:
                    </div>
                    <div class="div40 fontBold font16">
                        <?php
                        echo Hesapla(($TopDezKota-$TopKulDez)*UcretDuzenle($dovizKuru)). 'TL';
                        // 				echo Hesapla($OdenenDezKota*UcretDuzenle($dovizKuru)).' TL';?>
                    </div>
                </div>
            </div>
            <div class="div50">
                <div class="anaDiv">
                    <div class="div60 font16 fontBold hColor">
                        Kullanılabilir Dezavantajlı Kota <span class="font16">(EURO)</span>:
                    </div>
                    <div class="div40 fontBold font16">
                        <?php echo Hesapla($TopDezKota-$TopKulDez).' €';?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="anaDiv">
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Geri Ödemesi Beklenen Ücret <span class="font16">(TL)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php
                    echo Hesapla(($ABKurBekKota-$ABKurBekDezKota)*UcretDuzenle($dovizKuru)). 'TL';
                    ?>
                </div>
            </div>
        </div>
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Geri Ödemesi Beklenen Ücret <span class="font16">(EURO)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla($ABKurBekKota-$ABKurBekDezKota).' €';?>
                </div>
            </div>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Geri Ödemesi Beklenen Dezavantajlı Ücret <span class="font16">(TL)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php
                    echo Hesapla($ABKurBekDezKota*UcretDuzenle($dovizKuru)). 'TL';
                    ?>
                </div>
            </div>
        </div>
        <div class="div50">
            <div class="anaDiv">
                <div class="div60 font16 fontBold hColor">
                    Geri Ödemesi Beklenen Dezavantajlı Ücret <span class="font16">(EURO)</span>:
                </div>
                <div class="div40 fontBold font16">
                    <?php echo Hesapla($ABKurBekDezKota).' €';?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function(){

    jQuery('#DonemEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#DonemDiv').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
    });

    jQuery('#DonemIptal').live('click',function(e){
        e.preventDefault();
        jQuery('#DonemDiv').trigger('close');
    });

    jQuery('#DonemKaydet').live('click',function(e){
        e.preventDefault();
        if(jQuery('#DonemDiv input[name="BasTar"]').val() == ''){
            alert('Lüften Dönem Başlangıç Tarihini Boş Bırakmayınız.');
        }else if(jQuery('#DonemDiv input[name="ucret"]').val() == ''){
            alert('Lüften Dönem Ücretini Boş Bırakmayınız.');
        }else{
            jQuery('#DonemForm').submit();
        }
    });

    jQuery('#ProEkle').live('click',function(e){
        e.preventDefault();
        jQuery('.proYuklu').hide();
        jQuery('.proYuksuz').show();
        jQuery('#ProDiv').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
    });

    jQuery('#ProIptal').live('click',function(e){
        e.preventDefault();
        if(jQuery('#ProForm input[name="dId"]').val() == 0 && jQuery('#ProForm input[name="pId"]').val() != 0){
            alert('Lüften Protokol Dosyasını Yükleyin.');
        }else{
            jQuery('#ProDiv').trigger('close');
        }

    });

    jQuery('#ProKaydet').live('click',function(e){
        e.preventDefault();
        if(jQuery('#ProDiv input[name="proTar"]').val() == ''){
            alert('Lüften Protokol Tarihini Boş Bırakmayınız.');
        }else if(jQuery('#ProDiv input[name="proKDV"]').val() == ''){
            alert('Lüften KDV Tutarını Boş Bırakmayınız.');
        }else if(jQuery('#ProForm input[name="proVergiKimlik"]').val() == 0){
            alert('Lüften Kuruluş Vergi Kimlik Numarasını Giriniz.');
        }else if(jQuery('#ProForm input[name="dId"]').val() == 0 && !jQuery('#ProForm input[name="proDok"]')[0].files[0]){
            alert('Lüften Protokol Dosyasını Yükleyin.');
        }else{
            jQuery('#ProForm').submit();
        }
    });

    jQuery('.tarih').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd/mm/yy'
        });
    });

    jQuery('#VergiNoKaydet').live('click',function(e){
        e.preventDefault();
        var kId = jQuery('#VergiNoDiv input[name="kId"]').val();
        var vergino = jQuery('#VergiNoDiv input[name="vergino"]').val();
        jQuery.ajax({
            async:false,
            type:"POST",
            url:"index.php?option=com_profile&task=AjaxKurVergiNoGuncelle&format=raw",
            data:"kId="+kId+"&vergino="+vergino
        }).done(function(data){
            var dat = jQuery.parseJSON(data);
            if(dat){
                alert('Kuruluş Vergi Numarası Başarıyla Düzenlendi.');
                window.location.reload();
            }else{
                alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
                window.location.reload();
            }
        });
    });
});

function FuncProDuzenle(pId){
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_profile&task=AjaxKurProGetir&format=raw",
        data:"pId="+pId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            jQuery('#ProForm input[name="proTar"]').val(dat['PRO_TARIH']);
            jQuery('#ProForm input[name="proKDV"]').val(dat['KDV']);
            jQuery('#ProForm input[name="pId"]').val(dat['ID']);
            jQuery('.proYuklu #proDok').attr('href','index.php?dl=kurulus/'+dat['KURULUS_ID']+'/ab_protokol/'+dat['PRO_DOK']);
            jQuery('.proYuklu').show();
            jQuery('.proYuksuz').hide();
            jQuery('#ProForm input[name="dId"]').val(1);
            jQuery('#ProDiv').lightbox_me({
                centered: true,
                closeClick:false,
                closeEsc:false
            });
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            window.location.reload();
        }
    });
}

function FuncDonemDuzenle(dId){
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_profile&task=HibeDonemDuzenle&format=raw",
        data:"dId="+dId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            jQuery('#DonemForm input[name="BasTar"]').val(dat['BAS_TARIH']);
            jQuery('#DonemForm input[name="ucret"]').val(dat['UCRET']);
            jQuery('#DonemForm textarea[name="aciklama"]').val(dat['ACIKLAMA']);
            jQuery('#DonemForm input[name="dId"]').val(dId);
            jQuery('#DonemDiv').lightbox_me({
                centered: true,
                closeClick:false,
                closeEsc:false
            });
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            window.location.reload();
        }
    });
}

function FuncDezUygulamaGuncelle(id,dId){
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_profile&task=DezUygulamaGuncelle&format=raw",
        data:"id="+id+"&dId="+dId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            alert('Dezavantaj Yararlanma Uygulaması Başarıyla Düzenlendi.');
            window.location.reload();
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            window.location.reload();
        }
    });
}

function FuncHibeKullanimi($kId){
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_profile&task=HibeKullanimi&format=raw",
        data:"kId="+kId
    }).done(function(data){

    });
}

function ProDokSil(){
    var pId = jQuery('#ProForm input[name="pId"]').val();
    if(confirm('Protokol Dökümanını silmek istediğinizden emin misiniz?')){
        jQuery.ajax({
            async:false,
            type:"POST",
            url:"index.php?option=com_profile&task=ProDokSil&format=raw",
            data:"pId="+pId
        }).done(function(data){
            var dat = jQuery.parseJSON(data);
            if(dat){
                jQuery('.proYuklu').hide();
                jQuery('.proYuksuz').show();
                jQuery('#ProForm input[name="dId"]').val(0);
                alert('Yeni Prokol Dosyasını Seçebilirsiniz.');
            }else{
                alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            }
        });
    }else{
        return false;
    }
}

function FuncVergiNoDuzenle(kId){
    jQuery.ajax({
        async:false,
        type:"POST",
        url:"index.php?option=com_profile&task=AjaxGetKurVergiNo&format=raw",
        data:"kId="+kId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            jQuery('#VergiNoDiv input[name="vergino"]').val(dat['VERGI_KIMLIK_NO']);
            jQuery('#VergiNoDiv').lightbox_me({
                centered: true,
                closeClick:false,
                closeEsc:false
            });
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
        }
    });
}
</script>

<div id="ProDiv" style="max-width: 50%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
    <form id="ProForm" method="post" enctype="multipart/form-data" action="index.php?option=com_profile&view=abuzman&task=ABProKaydet">
        <div class="anaDiv font20 fontBold hColor text-center">
            AB Protokolü
        </div>
        <div class="anaDiv">
            <div class="div30 font16 hColor fontBold">Protokol Tarihi:</div>
            <div class="div70"><input type="text" class="input-sm tarih" name="proTar"/></div>
        </div>
        <div class="anaDiv">
            <div class="div30 font16 hColor fontBold">Protokol Dökümanı:</div>
            <div class="div70">
                <div class="anaDiv proYuksuz" style="display:none">
                    <input type="file" class="input-sm" name="proDok"/>
                </div>
                <div style="display:none" class="anaDiv proYuklu">
                    <div class="divYan">
                        <a id="proDok" target="_blank" href="#" class="btn btn-xs btn-primary">Protokol Dökümanı</a>
                    </div>
                    <div class="divYan">
                        <button type="button" class="btn btn-xs btn-danger" onclick="ProDokSil()">Sil</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="anaDiv">
            <div class="div30 font16 hColor fontBold">KDV Tutarı: %</div>
            <div class="div70"><input type="number" class="input-sm" name="proKDV"/></div>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <button type="button" class="btn btn-xs btn-danger" id="ProIptal">İptal</button>
            </div>
            <div class="div50 text-right">
                <button type="button" class="btn btn-xs btn-success" id="ProKaydet">Kaydet</button>
            </div>
        </div>
        <input type="hidden" name="kId" value="<?php echo $kurulus['USER_ID'];?>"/>
        <input type="hidden" name="pId" value="0"/>
        <input type="hidden" name="dId" value="0"/>
    </form>
</div>

<div id="DonemDiv" style="max-width: 70%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
    <form id="DonemForm" method="post" enctype="multipart/form-data" action="index.php?option=com_profile&view=abuzman&task=ABDonemKaydet">
        <div class="anaDiv font18 fontBold hColor">
            AB Hibe Kotası
        </div>
        <div class="anaDiv">
            <div class="div30 font18 hColor">Tarih:</div>
            <div class="div70"><input type="text" class="input-sm tarih" name="BasTar"/></div>
        </div>
        <div class="anaDiv">
            <div class="div30 font18 hColor">Hibe Ücreti:</div>
            <div class="div70"><input type="number" class="input-sm" name="ucret"/></div>
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 font18 hColor">Açıklama:</div>
            <div class="div70"><textarea name="aciklama" class="inputW90"></textarea></div>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <button type="button" class="btn btn-xs btn-danger" id="DonemIptal">İptal</button>
            </div>
            <div class="div50 text-right">
                <button type="button" class="btn btn-xs btn-success" id="DonemKaydet">Kaydet</button>
            </div>
        </div>
        <input type="hidden" name="kId" value="<?php echo $kurulus['USER_ID'];?>"/>
        <input type="hidden" name="dId" value="0"/>
    </form>
</div>

<!-- Kuruluş Vergi Kimlik NO -->
<div id="VergiNoDiv" style="max-width: 50%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
    <div class="anaDiv font18 fontBold hColor">
        Kuruluş Vergi Kimlik No
    </div>
    <div class="anaDiv">
        <div class="div30 font18 hColor">Vergi Kimlik No:</div>
        <div class="div70"><input type="text" class="input-sm" name="vergino"/></div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <button type="button" class="btn btn-xs btn-danger" onclick="jQuery('#VergiNoDiv').trigger('close');">İptal</button>
        </div>
        <div class="div50 text-right">
            <button type="button" class="btn btn-xs btn-success" id="VergiNoKaydet">Kaydet</button>
        </div>
    </div>
    <input type="hidden" name="kId" value="<?php echo $kurulus['USER_ID'];?>"/>
</div>