<?php
$paketler = $this->excelAday;
$adaySayisi = $this->adaySayisi;
$sinavBilgi = $this->sinavBilgi;
$bildirim =  $paketler['bildirim'];
$sonuc =  $paketler['sonuc'];

echo "<p style='font-size:14px'><span style='color:#1C617C;font-size:15px'>Yeterlilik:</span> ".$sinavBilgi[0]['YETERLILIK_KODU']." - ".$sinavBilgi[0]['YETERLILIK_ADI']."</p>";
echo "<p style='font-size:14px'><span style='color:#1C617C;font-size:15px'>Sınav Tarihi:</span> ".$sinavBilgi[0]['BASLANGIC_TARIHI']."</p><br>";

if(count($paketler)>0){
	echo 'Daha önceden bildirdiğiniz aday dosyaları aşağıda verilmiştir. Bu dosyaları indirip puan ve sonuç kısımlarını doldurarak tekrar yükleyiniz.<hr>';
}

if(count($bildirim)>0){
    echo "Sonuç Bildirilmeyen Dosyalar<br>";
     echo "<table width='100%'>";
    echo "<thead style='background-color:#71CEED'>"
    . "<tr>"
            . "<th width='30%'>Dosya Yükleme Tarihi</th>"
            . "<th width='10%'>Kayıt Sayısı</th>"
            . "<th width='10%'>Aday Sayısı</th>"
            . "<th width='20%'>Dosyayı İndir</th>"
            . "<th width='20%'>Sonuc Gönder</th>"
    . "</tr></thead>";
     echo "<tbody align='center'>";
    $even = 'bgcolor="#efefef"';
    $say = 1;
    foreach ($bildirim as $row){
        if ($row['paket_Tip']==1){
            if($say%2 == 0){
               echo '<tr id="'.$row['paket_Id'].'">'; 
            }
            else{
               echo '<tr '.$even.' id="'.$row['paket_Id'].'">'; 
            }
            echo '<td style="margin-left:10px;">'.substr($row['paket_Tarih'],0,-7).'</td>'
                    . '<td>'.$adaySayisi[0].'</td>'
                    . '<td>'.$row['adayCount'].'</td>'
                    . '<td><a href="index.php?dl=sinav_bildirimleri/'.$row['paket_Adi'].'">İndir</a></td>'
                    . '<td><a href="#" id="GonderSonuc">Sonuç Gönder</a></td></tr>';
        }
        $say++;
    }
    echo "</tbody>";
    echo '</table>';
    echo '<hr>';
}
if(count($sonuc)>0){
    echo "Sonuç Bildirilmiş Dosyalar<br>";
    echo "<table width='100%'>";
    echo "<thead style='background-color:#71CEED'>"
    . "<tr>"
            . "<th width='30%'>Dosya Yükleme Tarihi</th>"
            . "<th width='10%'>Kayıt Sayısı</th>"
            . "<th width='10%'>Aday Sayısı</th>"
            . "<th width='20%'>Sonuçları Sil</th>"
           . "<th width='20%'>Dosyayı İndir</th>"
            . "<th width='20%'>Sonuc Gönder</th>"
    . "</tr></thead>";
    echo "<tbody align='center'>";
    $even = 'bgcolor="#efefef"';
    $say = 1;
    foreach ($sonuc as $row){
        if ($row['paket_Tip']==2){
            if($say%2 == 0){
               echo '<tr id="'.$row['paket_Id'].'">'; 
            }
            else{
               echo '<tr '.$even.' id="'.$row['paket_Id'].'">'; 
            }
            echo '<td>'.substr($row['paket_Tarih'],0,-7).'</td>'
                     . '<td>'.$adaySayisi[0].'</td>'
                    . '<td>'.$row['adayCount'].'</td>'
                    
                    . '<td><a href="#" id="adaySil">Sonuçları Sil</a></td>'
                    . '<td><a href="index.php?dl=sinav_bildirimleri/'.$row['paket_Adi'].'">İndir</a></td>'
                    . '<td><a href="#" id="GonderSonuc">Sonuç Gönder</a><td></tr>';
        }
        $say++;
    }
    echo '</tbody>';
    echo '</table>';
    echo '<hr>';
    echo '<div style="display:inline-block;width:100%;margin-top:10px;font-size:15px;">';
    echo '<a href="#" onclick="sonucGonder('.$sinavBilgi[0]['SINAV_ID'].')">Sonuç Bildirimini tamamlamak istiyorsanız tıklayın diyebiliriz</a>';
    echo '</div>';
}
?>

<script type="text/javascript">
function sonucGonder(sinavId){
	jQuery.ajax({
        type: 'POST',
        url:'index.php?option=com_belgelendirme&task=sonucGonderYetkilimi&format=raw',//false dönerse cık, true dönerse başarılı işleme devam
        data:'sinavId='+sinavId,
        success: function (data) {
            var dat = jQuery.parseJSON(data);
            if(dat == true){
				window.location.href="index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=aday_bildirim&sinavId="+sinavId;
            }
            else{
                alert('Sonuçlarını bildirmediğiniz adaylar var. Lütfen kontrol ettikten sonra tekrar deneyiniz.');
            }
         }
     });
}

jQuery(document).ready(function(){
    jQuery('#adaySil').live('click',function(e){
       e.preventDefault();
       var paketId = jQuery(this).closest('tr').attr('id');
       var sinavId = <?php echo $_GET['sinav'];?>;
       if(confirm('Bu dosyaya ait aday sonuçlarını SİLMEK istediğinizden emin misiniz?')){
           jQuery.ajax({
               type: 'POST',
               url: "index.php?option=com_belgelendirme&task=adaySonucSil&format=raw",
               data: 'paketId='+paketId+'&sinavId='+sinavId,
               success: function (data) {
                        if(jQuery.parseJSON(data) == true){
                            alert('Başarıyla silindi.');
                            window.location.reload();
                        }
                        else{
                            alert('İşlemde bir sorun meydana geldi. Tekrar deneyiniz');
                        }
                    }
           });
       }
   });
   
    jQuery('#GonderSonuc').live('click',function(e){
        e.preventDefault();
        var paketId = jQuery(this).closest('tr').attr('id');
        jQuery('#paketId').val(paketId);
        jQuery('#yeniDis').lightbox_me({
        	centered: true,
            closeClick:false,
            closeEsc:false  
        });
    });
   
   jQuery('#iptal').live('click',function(e){
        e.preventDefault();
        jQuery('#yeniDis').trigger('close');
    });
    
    jQuery('#gonder').live('click',function(e){
        e.preventDefault();
        jQuery('#sonucBildirimForm').submit();
        jQuery('#yeniDis').trigger('close'); 
         jQuery('#loaderGif').lightbox_me({
        	 centered: true,
             closeClick:false,
             closeEsc:false  
        });
    });
    
});
</script>

<div id="yeniDis" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="sonucBildirimForm" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=sonuclar&sinav=<?php echo $_GET['sinav'];?>">
        <input type="file" name="upload"/>
        <input type="hidden" name="paketId" id="paketId"/><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>