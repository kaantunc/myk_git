Aday Bildirimleriniz sadece aşağıdaki dosyayı doldurarak yapabilirsiniz. <br><br>
<button onclick="location.href='ekler/aday_bildirim.xls'">Aday Bildirim Dosyası</button>
<!-- <a href="ekler/aday_bildirim.xlsx" target="_blank">Aday Bildirim Dosyası</a> --><br><hr><br>

<?php
//echo $this->canEdit;
$paketler=$this->excelAday;
$sinavBilgi = $this->sinavBilgi;
$bildirim =  $paketler['bildirim'];
echo "<p style='font-size:14px'><span style='color:#1C617C;font-size:15px'>Yeterlilik:</span> ".$sinavBilgi[0]['YETERLILIK_KODU']." - ".$sinavBilgi[0]['YETERLILIK_ADI']."</p>";
echo "<p style='font-size:14px'><span style='color:#1C617C;font-size:15px'>Sınav Tarihi:</span> ".$sinavBilgi[0]['BASLANGIC_TARIHI']."</p><br>";

if(count($paketler)>0){
	echo 'Daha önceden bildirdiğiniz aday dosyaları:<hr>';
}
if(count($bildirim)>0){
    echo "<table width='100%'>";
    echo "<thead style='background-color:#71CEED'>"
    . "<tr>"
            . "<th width='30%'>Dosya Yükleme Tarihi</th>"
            . "<th width='10%'>Aday Sayısı</th>"
            . "<th width='20%'>Adayları Sil</th>"
            . "<th width='20%'>Dosyayı İndir</th>"
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
                    . '<td>'.$row['adayCount'].'</td>'
                    . '<td><a href="#" id="adaySil">Adayları Sil</a></td>'
                    . '<td><a href="index.php?dl=sinav_bildirimleri/'.$row['paket_Adi'].'">İndir</a></td></tr>';
        }
        $say++;
    }
    echo "</tbody>";
    echo '</table>';
    echo '<hr>';
}
?>




<form method="POST" id="adayBildirimForm" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=adaylar&sinav=<?php echo $_GET['sinav'];?>">
		<input type="file" name="upload"/>
		<input type="submit" value="Aday Dosyasını Kaydet" id="kaydet"/>
</form>
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery('#kaydet').live('click',function(e){
           e.preventDefault();
          jQuery('#adayBildirimForm').submit();
          jQuery('#loaderGif').lightbox_me({
        	  centered: true,
              closeClick:false,
              closeEsc:false 
          });
   });
    jQuery('#adaySil').live('click',function(e){
       e.preventDefault();
       var paketId = jQuery(this).closest('tr').attr('id');
       var sinavId = <?php echo $_GET['sinav'];?>;
       if(confirm('Bu dosyaya ait adayları SİLMEK istediğinizden emin misiniz?')){
           jQuery.ajax({
               type: 'POST',
               url: "index.php?option=com_belgelendirme&task=BildirilmisAdaySil&format=raw",
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
});
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>