<style>
    <!--
    .marclass {
        margin-bottom: 5px;
    }

    -->
</style>
<div class="anaDiv hColor font20 fontBold text-center">
    <u>Aday Bilgileri Düzenle</u>
</div>
<div class="anaDiv">
    <div class="div30 font16 hColor">
        T.C. Kimlik / Pasaport No:
    </div>
    <div class="div70">
        <input type="text" id="tcno" class="input-sm inputW50" value="<?php echo $_GET['tckimlik'] ?>"/><input
            class="btn btn-sm btn-primary" type="button" value="Getir" id="adayGetir"/>
    </div>
</div>
<hr>
<div id="adayBilgi" style="display:none; margin-top:10px;">
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            T.C. Kimlik / Pasaport No:
        </div>
        <div class="div70">
            <input type="text" id="tcKimlik" class="input-sm inputW50" disabled/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Adı:
        </div>
        <div class="div70">
            <input type="text" id="isim" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Soyadı:
        </div>
        <div class="div70">
            <input type="text" id="soyisim" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Doğum Tarihi:
        </div>
        <div class="div70">
            <input type="text" id="dtarih" readonly="true" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Telefon:
        </div>
        <div class="div70">
            <input type="text" id="telefon" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            IBAN:
        </div>
        <div class="div70">
            <input type="text" id="iban" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Email:
        </div>
        <div class="div70">
            <input type="email" id="email" class="input-sm inputW50"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Cinsiyeti:
        </div>
        <div class="div70">
            <select id="cins" class="input-sm">
                <option id="a0" value="0">Seçiniz</option>
                <option id="a1" value="1">Erkek</option>
                <option id="a2" value="2">Kadın</option>
                <option id="a3" value="3">Belirtilmemiş</option>
            </select>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Eğitimi:
        </div>
        <div class="div70">
            <select id="egitim" class="input-sm">
                <option id="b0" value="0">Seçiniz</option>
                <option id="b1" value="1">Okur Yazar Değil</option>
                <option id="b2" value="2">Okur Yazar</option>
                <option id="b3" value="3">İlkokul</option>
                <option id="b4" value="4">Orta Okul</option>
                <option id="b5" value="5">Meslek Lisesi</option>
                <option id="b6" value="6">Genel Lise</option>
                <option id="b7" value="7">Meslek Yüksekokulu</option>
                <option id="b8" value="8">Lisans</option>
                <option id="b9" value="9">Yüksek Lisans</option>
                <option id="b10" value="10">Doktora</option>
            </select>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor">
            Çalışma Durumu:
        </div>
        <div class="div70">
            <select id="cdurum" class="input-sm">
                <option id="c0" value="0">Seçiniz</option>
                <option id="c1" value="1">Çalışıyor</option>
                <option id="c2" value="2">Çalışmıyor</option>
                <option id="c3" value="3">Staj Yapıyor</option>
            </select>
        </div>
    </div>
    <div class="anaDiv">
        <button type="button" class="btn btn-success" id="AdayKaydet">Kaydet</button>
    </div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('#adayGetir').live('click', function (e) {
            e.preventDefault();
            var tcno = jQuery('#tcno').val();
            jQuery('#adayBilgi').hide();
            jQuery('#tcKimlik').val(tcno);
            // pop up içini sil
            jQuery('#isim').val('');
            jQuery('#soyisim').val('');
            jQuery('#dtarih').val('');
            jQuery('#dyer').val('');
            jQuery('#Bisim').val('');
            jQuery("#telefon").mask("(999) 999-99-99");
            jQuery("#iban").mask("TR 9999 9999 9999 9999 9999 9999");

            jQuery('#telefon').val('');
            jQuery('#iban').val('');
            jQuery('#email').val('');
            jQuery.ajax({
                async: false,
                type: 'post',
                url: 'index.php?option=com_belgelendirme&task=tcKayitliAday&format=raw',
                data: 'tcno=' + tcno,
                success: function (data) {
                    var dat = jQuery.parseJSON(data);
                    if (dat.length > 0) {
                        jQuery('#isim').val(dat[0]['ADI']);
                        jQuery('#soyisim').val(dat[0]['SOYADI']);
                        jQuery('#dtarih').val(dat[0]['DOGUM_TARIHI']);
                        jQuery('#dyer').val(dat[0]['DOGUM_YERI']);
                        jQuery('#Bisim').val(dat[0]['BABA_ADI']);
                        jQuery('#telefon').val(dat[0]['TELEFON']);
                        jQuery('#iban').val(dat[0]['IBAN']);
                        jQuery('#email').val(dat[0]['EMAIL']);

                        if (dat[0]['CINSIYETI'] == 1) {
                            jQuery('#a1').attr('selected', true);
                        }
                        else if (dat[0]['CINSIYETI'] == 2) {
                            jQuery('#a2').attr('selected', true);
                        }
                        else if (dat[0]['CINSIYETI'] == 2) {
                            jQuery('#a3').attr('selected', true);
                        }
                        else {
                            jQuery('#a0').attr('selected', true);
                        }

                        if (dat[0]['EGITIMI'] == 1) {
                            jQuery('#b1').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 2) {
                            jQuery('#b2').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 3) {
                            jQuery('#b3').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 4) {
                            jQuery('#b4').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 5) {
                            jQuery('#b5').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 6) {
                            jQuery('#b6').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 7) {
                            jQuery('#b7').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 8) {
                            jQuery('#b8').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 9) {
                            jQuery('#b9').attr('selected', true);
                        }
                        else if (dat[0]['EGITIMI'] == 10) {
                            jQuery('#b10').attr('selected', true);
                        }
                        else {
                            jQuery('#b0').attr('selected', true);
                        }

                        if (dat[0]['CALISMA_DURUMU'] == 1) {
                            jQuery('#c1').attr('selected', true);
                        }
                        else if (dat[0]['CALISMA_DURUMU'] == 2) {
                            jQuery('#c2').attr('selected', true);
                        }
                        else if (dat[0]['CALISMA_DURUMU'] == 3) {
                            jQuery('#c2').attr('selected', true);
                        }
                        else {
                            jQuery('#c0').attr('selected', true);
                        }

                        jQuery('#adayBilgi').show('slow');
                    }
                    else {
                        alert("Bu T.C. Kimlik No'suna ait bir kullanıcı bulunmamaktadır.");
                    }
                }
            });

        });

        jQuery('#AdayKaydet').live('click', function (e) {
            e.preventDefault();

            jQuery('#telefon').val(jQuery('#telefon').mask());
            if (jQuery('#iban').mask() != "") {
                jQuery('#iban').val("TR" + jQuery('#iban').mask());
            }
            var tcno = jQuery('#tcKimlik').val();
            if (jQuery('#isim').val() == '') {
                alert('Adı bölümünü boş bırakmayınız.');
            }
            else if (jQuery('#soyisim').val() == '') {
                alert('Soyadı bölümünü boş bırakmayınız.');
            }
            else if (jQuery('#dtarih').val() == '') {
                alert('Doğum Tarihi bölümünü boş bırakmayınız.');
            }

            else {
                jQuery.ajax({
                    type: 'post',
                    url: 'index.php?option=com_belgelendirme&task=AdayUpdate&format=raw',
                    data: 'tcno=' + jQuery('#tcKimlik').val() + '&ad=' + jQuery('#isim').val() + '&soyad=' + jQuery('#soyisim').val() + '&dtarih=' + jQuery('#dtarih').val() + '&cins=' + jQuery('#cins').val() + '&egitim=' + jQuery('#egitim').val() + '&Cdurum=' + jQuery('#cdurum').val() + '&telefon=' + jQuery('#telefon').val() + '&iban=' + jQuery('#iban').val() + '&email=' + jQuery('#email').val(),
                    success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if (dat) {
                            alert('Başarıyla düzeltildi.');
                        }
                    }
                });
            }

        });

        jQuery('#dtarih').live('hover', function (e) {
            e.preventDefault();
            jQuery(this).datepicker({
                dateFormat: 'dd/mm/yy',
                changeYear: true,
                changeMonth: true
            });
        });
        <?php
    if ($_GET['tckimlik']!=""){
    echo 'jQuery( "#adayGetir" ).trigger( "click" );';
    }
     ?>
    });


</script>