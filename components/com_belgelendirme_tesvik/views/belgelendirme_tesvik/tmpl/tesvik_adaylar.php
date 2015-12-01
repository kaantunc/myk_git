<?php
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$YetUcret = $this->TesvikAdaylar['YetUcret'];
$BelgeMasraf = $this->TesvikAdaylar['BelgeMasraf'];
$OncekiTesviktekiOdenmeyenler = $this->OncekiTesviktekiOdenmeyenler;
if (count($OncekiTesviktekiOdenmeyenler) > 0) {
    ?>
    <div class="anaDiv">
        <div class="div100 fontBold font20">
            ÖNCEKİ İSTEKLERDE TEŞVİK ÖDEMESİ YAPILAMAYAN ADAYLAR
        </div>
        Bu kişiler için ayrıca talepte bulunulmasına gerek yoktur. Hatayı giderdiğiniz adaylar için ödemeler bir sonraki teşvik talebinde otomatik olarak yapılacaktır. Aday bilgilerini düzenlemek için TC Kimlik No üzerine tıklayınız.
        <table width="100%" cellpadding="0" cellspacing="1" id="odenmeyen" class="display compact">
            <thead style="text-align:center;background-color:#71CEED">
            <tr>
                <th width="10%">TC Kimlik</th>
                <th width="12%">Adı</th>
                <th width="12%">Soyadı</th>
                <th width="20%">IBAN</th>
                <th width="25%">Belge No</th>
                <th width="15%">Odenmeme Sebebi</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($OncekiTesviktekiOdenmeyenler as $row) {
                if ($row['ODENDI'] == -2) {
                    $aciklama = "IADE EDİLDİ";
                } else {
                    if ($row['ACIKLAMA'] == "") {
                        $aciklama = "IBAN HATALI";
                    } else {
                        $aciklama = $row['ACIKLAMA'];
                    }
                }

                echo '<tr>';
                echo '<td><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bilgileri&tckimlik=' . $row['TCKIMLIKNO'] . '" target="_blank">' . $row['TCKIMLIKNO'] . '</a></td>';
                echo '<td>' . $row['AD'] . '</td>';
                echo '<td>' . $row['SOYAD'] . '</td>';
                echo '<td>' . $row['IBAN'] . '</td>';
                echo '<td>' . trim($row['BELGENO']," ") . '</td>';
                echo '<td>' . $aciklama . '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <hr>
    <br><br>
    <?php
}
?>
    <div class="anaDiv">
        <div class="div100 fontBold font20">
            YENİ TEŞVİK TALEBİ
        </div>
    </div>
    <div class="anaDiv">
        <div class="div30 font20 hColor">
            Ücret İadesi Talep Tarihi:
        </div>
        <div class="div70 fontBold font20">
            <?php echo $this->bitTarih; ?>
        </div>
    </div>
    <form id="TesvikIstek" action="index.php?option=com_belgelendirme_tesvik&task=TesvikAdayYarat"
          enctype="multipart/form-data" method="post">
        <!-- <input type="hidden" name="bas_tarih" value="<?php echo $this->basTarih; ?>"/> -->
        <input type="hidden" name="bit_tarih" value="<?php echo $this->bitTarih; ?>"/>

        <div class="anaDiv">
            <div class="div30 hColor font20">
                İmza Yetkilisi Unvan:
            </div>
            <div class="div70">
                <input type="text" class="input-sm inputW50" name="unvan"/>
            </div>
        </div>
        <div class="anaDiv">
            <div class="div30 hColor font20">
                İmza Yetkilisi Ad Soyad:
            </div>
            <div class="div70">
                <input type="text" class="input-sm inputW50" name="isim"/>
            </div>
        </div>
        <div class="anaDiv">
            <table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
                <thead style="text-align:center;background-color:#71CEED">
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Adı Soyadı</th>
                    <th width="10%">TC Kimlik</th>
                    <th width="15%">Belge No</th>
                    <th width="10%">Belge Düzenlenme Tarihi</th>
                    <th width="25%">Yeterlilik</th>
                    <th width="10%">Sınav Ücreti</th>
                    <th width="10%">Belge Masrafı</th>
                    <th width="10%">Toplam</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $say = 0;
                foreach ($AdayBilgi as $row) {
                    $say++;
                    // Ücret Hesabı
                    $Odenecek = 0;
                    $Hesap = 0;
                    if ($row['ITIRAZ_DURUM'] == null || $row['ITIRAZ_DURUM'] == -1) {
                        foreach ($UcretBilgi[$row['BELGENO']] as $cow) {
                            $Hesap += UcretDuzenle($cow['ucret']);
                        }
                    } else {
                        $Hesap = UcretDuzenle($row['ITIRAZ_UCRET']);
                    }

                    if ($Hesap > UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET'])) {
                        $Odenecek = UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET']);
                    } else {
                        $Odenecek = $Hesap;
                    }
                    // Ücret Hesabı SON
                    echo '<tr>';
                    echo '<td><input type="checkbox" name="adays[]" value="' . $row['BELGENO'] . '" checked="checked"/></td>';
                    echo '<td>' . $row['ADI'] . ' ' . $row['SOYADI'] . '</td>';
                    echo '<td>' . $row['TCKIMLIKNO'] . '</td>';
                    echo '<td>' . $row['BELGENO'] . '</td>';
                    echo '<td>' . $row['BELGE_DUZENLEME_TARIHI'] . '</td>';
                    echo '<td>' . $row['YETERLILIK_KODU'] . '/' . $row['REVIZYON'] . ' ' . $row['YETERLILIK_ADI'] . '</td>';
                    echo '<td>' . Hesapla($Odenecek) . ' TL</td>';
                    echo '<td>' . UcretDuzenle($BelgeMasraf[$row['BELGENO']]) . ' TL</td>';
                    echo '<td>' . Hesapla($Odenecek + UcretDuzenle($BelgeMasraf[$row['BELGENO']])) . ' TL</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <a href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik"
                   class="btn btn-sm btn-danger">İptal</a>
            </div>
            <div class="div50 text-right">
                <button type="button" class="btn btn-sm btn-success" id="TesvikKaydet">Kaydet</button>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
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
                        "sFirst": "<?php echo JText::_("FIRST");?>",
                        "sPrevious": "Önceki",
                        "sNext": "Sonraki",
                        "sLast": "<?php echo JText::_("LAST");?>"
                    }
                }

            });
            <?php
if (count($OncekiTesviktekiOdenmeyenler) > 0) {
 ?>
            var oTables = jQuery('#odenmeyen').dataTable({
                "bInfo": true,
                "bPaginate": false,
                "bFilter": true,
                "oLanguage": {
                    "sInfo": "Ödeme yapılamayan aday sayısı: _TOTAL_",
                    "sSearch": "Ara"
                }
            });
<?php
}
?>
            jQuery('#TesvikKaydet').live('click', function (e) {
                e.preventDefault();
                oTables.fnFilter('');
                var oSettings = oTables.fnSettings();
                oSettings._iDisplayLength = <?php echo $say;?>;
                oTables.fnDraw();

                var belgelist = "";
                jQuery.each(jQuery('input[name="adays[]"]:checked'), function () {
                    belgelist += jQuery(this).val() + ",";
                });
                belgelist = belgelist.slice(0, -1);

                control = adayControl(belgelist);
                if (control == true) {
                    alert("Yukarıdaki listede kırmızı ile işaretlenmiş olan satırlardaki adayların IBAN veya Telefon bilgileri bulunmamaktadır.İlgili alanları aday bilgileri düzenlenleme kısmından güncelleyebilirsiniz !");
                    return false;
                } else {
                    if (jQuery('input[name="adays[]"]:checked').length > 0) {
                        jQuery('#TesvikIstek').submit();
                    } else if (jQuery('#TesvikIstek input[name="unvan"]').val() == '') {
                        alert('Ücret İadesi Talebinde bulunması gereken imza yetkilisi ünvan kısmını boş bırakamazsınız.');
                    } else if (jQuery('#TesvikIstek input[name="isim"]').val() == '') {
                        alert('Ücret İadesi Talebinde bulunması gereken imza yetkilisi ad soyad kısmını boş bırakamazsınız.');
                    } else {
                        alert('Ücret İadesi Talebinde bulunmak için en az bir aday seçmelisiniz.');
                    }
                }
            });
        });

        function adayControl(belgelist) {
            var glob_control = false;
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                async: false,
                url: "index.php?option=com_belgelendirme_tesvik&task=adayBilgiKontrol&format=raw",
                data: "belgelist=" + belgelist,
                success: function (data) {
                    jQuery.each(data, function (key, val) {
                        if (val['ERR'] == 1 || val['ERR'] == 2) {
                            glob_control = true;
                            jQuery('input[name="adays[]"][value="' + key + '"]').closest('tr').css('background-color', '#ff4136');
                            jQuery('input[name="adays[]"][value="' + key + '"]').closest('tr').find('td:eq(0)').css('background-color', '#ff4136');
                        }
                    });
                }
            });
            return glob_control;
        }
    </script>

<?php
function UcretDuzenle($ucret)
{
    return str_replace(',', '.', $ucret);
}

function Hesapla($alinacak)
{
    $dat = floor($alinacak * 100) / 100;
    return number_format($dat, '2', ',', '.');
}

?>