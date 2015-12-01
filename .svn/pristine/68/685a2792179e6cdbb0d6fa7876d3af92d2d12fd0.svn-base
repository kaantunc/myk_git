<?php

$OncekiTesviktekiOdenmeyenler = $this->OncekiTesviktekiOdenmeyenler;
if (count($OncekiTesviktekiOdenmeyenler) > 0) {
    ?>
    <div class="anaDiv">
        <div class="div100 fontBold font20">
            ÖNCEKİ İSTEKLERDE TEŞVİK ÖDEMESİ YAPILAMAYAN ADAYLAR
        </div>
        Bu kişiler için ayrıca talepte bulunulmasına gerek yoktur. Hatayı giderdiğiniz adaylar için ödemeler bir sonraki teşvik talebinde otomatik olarak yapılacaktır.  Aday bilgilerini düzenlemek için TC Kimlik No üzerine tıklayınız.
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
     <script type="text/javascript">
         var oTables = jQuery('#odenmeyen').dataTable({
             "bInfo": true,
             "bPaginate": false,
             "bFilter": true,
             "oLanguage": {
                 "sInfo": "Ödeme yapılamayan aday sayısı: _TOTAL_",
                 "sSearch": "Ara"
             }
         });

 </script>