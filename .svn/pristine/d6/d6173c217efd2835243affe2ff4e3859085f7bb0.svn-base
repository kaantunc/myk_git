<?php 
$sertifika=$this->sertifika;
?>
<style>
td.ortala{
    text-align: center;
}
</style>
<?php 
if ($this->canEdit){
?>
<form
	onsubmit="return validate('ChronoContact_uzman_basvuru_t4')"
	action="index.php?option=com_uzman_basvur&amp;layout=sertifika&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">
<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />
		

<?php 
}
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Sertifika ve Belgeler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<input type="hidden" name="tc_kimlik" value="<?php echo $this->evrak_id?>" />

<div class="form_item">
	<div>
		<table id="sertifika" style="float:left; width:100%">
			<thead>
				<tr>
                                        <th style="width:200px;">Belge/Sertifika Adı</th>
					<th style="width:200px;">Veren Kurum/Kuruluş</th>
					<th style="width:200px;">Tarih</th>
					<th style="width:200px;">Belge</th>
					<th style="width:200px;">Açıklama</th>
					<th style="width:20px;">Sil</th>
                                        <th style="width:20px;">Düzenle</th>
				</tr>
			</thead>
			<tbody id="sertifikas">
			<?php
			
			foreach($sertifika as $satir)
			{
				$i++;
				$kayit="var";
				
// 				if ($satir["DURUM"]==1){
					$dsy=explode("/", $satir[PATH]);
					foreach ($dsy as $parca){$dos=$parca;}
					echo '<tr id="sertifika_'.$satir['SERTIFIKA_ID'].'">';
	                echo '<td>'.$satir["BELGE_ADI"].'</td>';
                        echo '<td>'.$satir["VEREN"].'</td>';
	                echo '<td>'.$satir["TARIH"].'</td>';
	                echo '<td>';
	                echo '<span id="dosyaadi'.$satir['SERTIFIKA_ID'].'">'.substr($dos,0,40).'...</span>';
	                if ($dos){
	                	//echo '<input name=dosyaadi['.$satir['SERTIFIKA_ID'].'] type=hidden value="'.$satir[PATH].'" id="dosyaadiinput'.$satir['SERTIFIKA_ID'].'">';
	                	if(!$this->ssmi){
	                		echo '<br><a id="degistirbuton'.$satir['SERTIFIKA_ID'].'" style="cursor:pointer" onclick="jQuery(\'#dosya'.$satir['SERTIFIKA_ID'].'\').css(\'display\',\'block\');jQuery(\'#dosyaadi'.$satir['SERTIFIKA_ID'].'\').css(\'display\',\'none\');jQuery(\'#degistirbuton'.$satir['SERTIFIKA_ID'].'\').css(\'display\',\'none\');jQuery(\'#indirbuton'.$satir['SERTIFIKA_ID'].'\').css(\'display\',\'none\');jQuery(\'#dosyaadiinput'.$satir['SERTIFIKA_ID'].'\').remove();">Değiştir</a>';
	                	}
	                	echo '&nbsp;&nbsp;&nbsp;<a id="indirbuton'.$satir['SERTIFIKA_ID'].'" href="index.php?dl='.$satir[PATH].'">Oku/indir</a>';
	                	$display="none";
	                } else {
	                	$display="block";
	                   	$required="required";
	                }
	                	//echo '<input type="file" name="dosya['.$satir['SERTIFIKA_ID'].']" class="" style="display:'.$display.'" id="dosya'.$satir['SERTIFIKA_ID'].'" style="width: 210px;"  />';
	                echo '</td>';
	                echo '<td>'.$satir["ACIKLAMA"].'</td>';
	                echo '<td style="text-align:center;"><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
                        echo '<td style="text-align:center;"><input type="button" name="sil" class="required" id="duzenleButton" value="Düzenle"/></td>';
					echo '</tr>';
					$dos="";
					$dsy="";
// 				} else {
// 					$dsy=explode("/", $satir[PATH]);
// 					foreach ($dsy as $parca){
// 						$dos=$parca;
// 					}
// 					echo '<tr>';
// 					echo '<td>
// 					<input disabled type="text" name="belge[]" class="required" id="belge'.$i.'" value="'.$satir["BELGE_ADI"].'" style="width: 98%;"  /></td>';
// 					echo '<td><input disabled type="text" name="veren[]" class="required" id="veren'.$i.'" value="'.$satir["VEREN"].'" style="width: 98%;"  /></td>';
// 					echo '<td><input disabled type="text" name="tarih[]" class="" id="tarih'.$i.'" value="'.$satir["TARIH"].'" style="width: 98%;"  /></td>';
// 					echo '<td>';
// 					echo '<span id="dosyaadi'.$i.'">'.$dos.'</span>';
// 					echo '<br><a id="indirbuton'.$i.'" href="index.php?dl='.$satir[PATH].'">Oku/indir</a>';
// 					echo '</td>';
// 					echo '<td><textarea disabled name="aciklama[]" class="required" id="aciklama'.$i.'">'.$satir["ACIKLAMA"].'</textarea></td>';
// 					echo '<td style="text-align:center;"></td>';
// 					echo '</tr>';
// 					$dos="";
// 					$dsy="";
						
// 				}
			}
			
			
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
<!--		<input type="text" name="adet" class="required" id="adet" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="adet yeni SERTİFİKA/BELGE ekle"/>-->
<?php 
if ($this->canEdit){
?>	
    <input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Yeni Belge/Sertifika Ekle"/><br>
	<input type="submit" value="Kaydet"/>
	</form>
<?php 
}
?>
<div class="cfclear">&nbsp;</div>
	
</div>
<script type="text/javascript">
    
    jQuery.fn.dataTableExt.afnSortData['dom-text'] = function  ( oSettings, iColumn )
    {
        var aData = [];
        jQuery( 'td:eq('+iColumn+') input', oSettings.oApi._fnGetTrNodes(oSettings) ).each( function () {
            aData.push( this.value );
        } );
        return aData;
    };
    
    jQuery.fn.dataTableExt.afnSortData['dom-textarea'] = function  ( oSettings, iColumn )
    {
        var aData = [];
        jQuery( 'td:eq('+iColumn+') textarea', oSettings.oApi._fnGetTrNodes(oSettings) ).each( function () {
            aData.push( this.value );
        } );
        return aData;
    };
		
jQuery(document).ready(function() {
    
    jQuery('#sertifika').dataTable({
        "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ],
            "oLanguage": {
                            "sProcessing":   "İşleniyor...",
                            "sLengthMenu":   "Sayfada _MENU_ Kayıt Göster",
                            "sZeroRecords":  "Eşleşen Kayıt Bulunmadı",
                            "sInfo":         "  _TOTAL_ Kayıttan _START_ - _END_ Arası Kayıtlar",
                            "sInfoEmpty":    "Kayıt Yok",
                            "sInfoFiltered": "( _MAX_ Kayıt İçerisinden Bulunan)",
                            "sInfoPostFix":  "",
                            "sSearch":       "Bul:",
                            "sUrl":          "",
                            "oPaginate": {
                                "sFirst":    "İlk",
                                "sPrevious": "Önceki",
                                "sNext":     "Sonraki",
                                "sLast":     "Son"
                            }
                        }
    });
	
	jQuery('#silButton').live('click', function(e) {
            e.preventDefault();
            if(confirm('Bu kaydı silmek istediğinizden emin misiniz?')){
                var trId = jQuery(this).closest('tr').attr('id');
                trId = trId.split('_');
                jQuery(this).closest('tr').remove();
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_uzman_basvur&task=SertifikaSil&format=raw",
                    data: 'serId='+trId[1],
                    success: function (data) {
                         jQuery('#loaderGif').lightbox_me({
                        	 centered: true,
                             closeClick:false,
                             closeEsc:false 
                         });
                        window.location.reload();
                    }
            });
            }
            
	});

	jQuery('#satirEkle').live('click',function(e){
            e.preventDefault();
            jQuery('#yeniDis #belgeAdi').val('');
            jQuery('#yeniDis #verenKur').val('');
            jQuery('#yeniDis #belgeTarih').val('');
            jQuery('#yeniDis #belgeAci').val('');
            jQuery('#yeniDis #dosyaAdi').val('');
            jQuery('#yeniDis').lightbox_me({
            	centered: true,
                closeClick:false,
                closeEsc:false 
            });		
	});



//jQuery('#yeniDis').lightbox_me({
//            centered: true 
//        });
//jQuery('#yeniDis').trigger('close'); 
// jQuery('#loaderGif').lightbox_me({
//    centered: true 
//});
    jQuery('#gonder').live('click',function(e){
        e.preventDefault();
        var belgeAdi = jQuery('#yeniDis #belgeAdi').val();
        var verenKur = jQuery('#yeniDis #verenKur').val();
        var belgeTarih = jQuery('#yeniDis #belgeTarih').val();
        var belgeAci = jQuery('#yeniDis #belgeAci').val();
        if(belgeAdi == '' || belgeAdi.length==0){
            alert('Lütfen Belge/Sertifika Adı bölümünü boş bırakmayınız.');
        }
        else if(verenKur == '' || verenKur.length==0){
            alert('Lütfen Veren Kurum/Kuruluş bölümünü boş bırakmayınız.');
        }
        else if(belgeTarih == '' || belgeTarih.length==0){
             alert('Lütfen Tarih bölümünü boş bırakmayınız.');
        }
        else if(belgeAci == '' || belgeAci.length==0){
             alert('Lütfen Açıklama bölümünü boş bırakmayınız.');
        }
        else{
            jQuery('#belgeYeni').submit();
        }
    });
    
    jQuery('#iptal').live('click',function(e){
        e.preventDefault();
        jQuery('#yeniDis').trigger('close'); 
    });
    
    jQuery('#duzenleButton').live('click',function(e){
        e.preventDefault();
        jQuery('#yeniDuz #belgeAdi').val('');
        jQuery('#yeniDuz #verenKur').val('');
        jQuery('#yeniDuz #belgeTarih').val('');
        jQuery('#yeniDuz #belgeAci').val('');
        jQuery('#yeniDuz #indirbutonDuz').attr('href','#');
        jQuery('#yeniDuz #dosyaadiDuz').html('');
        var trId = jQuery(this).closest('tr').attr('id');
        trId = trId.split('_');
        jQuery('#serId').val(trId[1]);
        jQuery.ajax({
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=SertifikaGetir&format=raw",
            data:'serId='+trId[1],
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            jQuery('#yeniDuz #belgeAdi').val(dat[0]['BELGE_ADI']);
                            jQuery('#yeniDuz #verenKur').val(dat[0]['VEREN']);
                            jQuery('#yeniDuz #belgeTarih').val(dat[0]['TARIH']);
                            jQuery('#yeniDuz #belgeAci').val(dat[0]['ACIKLAMA']);
                            jQuery('#yeniDuz #indirbutonDuz').attr('href','index.php?dl='+dat[0]['PATH']+'&option=com_uzman_basvur');
                            var path = dat[0]['PATH'].split('/');
                            jQuery('#yeniDuz #dosyaadiDuz').html(path[2]);
                            jQuery('#yeniDuz').lightbox_me({
                            	centered: true,
                                closeClick:false,
                                closeEsc:false  
                            });
                        }
                    }
        });

    });
    
    jQuery('#iptalDuz').live('click',function(e){
        e.preventDefault();
        jQuery('#yeniDuz').trigger('close'); 
    });
    
    jQuery('#gonderDuz').live('click',function(e){
        e.preventDefault();
        var belgeAdi = jQuery('#yeniDuz #belgeAdi').val();
        var verenKur = jQuery('#yeniDuz #verenKur').val();
        var belgeTarih = jQuery('#yeniDuz #belgeTarih').val();
        var belgeAci = jQuery('#yeniDuz #belgeAci').val();
        if(belgeAdi == '' || belgeAdi.length==0){
            alert('Lütfen Belge/Sertifika Adı bölümünü boş bırakmayınız.');
        }
        else if(verenKur == '' || verenKur.length==0){
            alert('Lütfen Veren Kurum/Kuruluş bölümünü boş bırakmayınız.');
        }
        else if(belgeTarih == '' || belgeTarih.length==0){
             alert('Lütfen Tarih bölümünü boş bırakmayınız.');
        }
        else if(belgeAci == '' || belgeAci.length==0){
             alert('Lütfen Açıklama bölümünü boş bırakmayınız.');
        }
        else{
            jQuery('#belgeYeniDuz').submit();
        }
    });
});


</script>
<?php
if ($kayit==""){
	//echo "<script>satirekle(1);</script>";
}
?>
<style>
    .hidedivTop{
        margin-top: 10px;
    }
</style>
<div id="yeniDis" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=sertifika&task=basvuruKaydet">
        <div class="hidedivTop"><span>Belge/Sertifika Adı:</span><br><input type="text" name="belgeAdi" id="belgeAdi" size="34"/></div>
        <div class="hidedivTop"><span>Veren Kurum/Kuruluş:</span><br><input type="text" name="verenKur" id="verenKur" size="34"/></div>
        <div class="hidedivTop"><span>Tarih:</span><br><input type="text" name="belgeTarih" id="belgeTarih" size="34"/></div>
        <div class="hidedivTop"><span>Belge:</span><br><input type="file" name="dosyaAdi" id="dosyaAdi"/></div>
        <div class="hidedivTop"><span>Açıklama:</span><br><textarea name="belgeAci" id="belgeAci" cols="29" rows="5"></textarea></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" /><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="yeniDuz" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="belgeYeniDuz" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=sertifika&task=basvuruKaydet">
        <div class="hidedivTop"><span>Belge/Sertifika Adı:</span><br><input type="text" name="belgeAdi" id="belgeAdi" size="34"/></div>
        <div class="hidedivTop"><span>Veren Kurum/Kuruluş:</span><br><input type="text" name="verenKur" id="verenKur" size="34"/></div>
        <div class="hidedivTop"><span>Tarih:</span><br><input type="text" name="belgeTarih" id="belgeTarih" size="34"/></div>
        <div class="hidedivTop"><span>Belge:</span><br><span id="dosyaadiDuz" style="margin-right: 10px"></span><a id="indirbutonDuz" href="#">Oku/indir</a><br>
            <hr><h3>Belgenizi değitirmek isterseniz yeni bir dosya seçin.</h3>
            <input type="file" name="dosyaAdi"/>
        </div>
        <div class="hidedivTop"><span>Açıklama:</span><br><textarea name="belgeAci" id="belgeAci" cols="29" rows="5"></textarea></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="serId" id="serId"/><br><br>
        <input type="button" id="gonderDuz" value="Gönder"/>
        <input type="button" id="iptalDuz" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
