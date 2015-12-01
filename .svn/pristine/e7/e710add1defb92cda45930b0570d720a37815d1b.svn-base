<?php 
$dil=$this->dil;
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
	action="index.php?option=com_uzman_basvur&amp;layout=yabanci_dil&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
}
echo $this->pageTree;
$tur = array('A1','A2','B1','B2','C1','C2');
$turSelect = '<option value="0">Seçiniz</option>';
foreach ($tur as $value) {
    $turSelect .= '<option value="'.$value.'">'.$value.'</option>';
}
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Yabancı Dil Bilgileri </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<input type="hidden" name="tc_kimlik" value="<?php echo $this->evrak_id?>" />

<div class="form_item">
	<div>
		<table id="egitim" style="float:left; width:100%; ">
			<thead>
				<tr>
					<th style="width:250px;">Dil</th>
					<th style="width:30px;">Okuma</th>
					<th style="width:30px;">Yazma</th>
					<th style="width:30px;">Konuşma</th>
					<th style="width:30px;">Dinleme</th>
					<th style="width:20px;">Sil</th>
                                        <th style="width:20px;">Düzenle</th>
				</tr>
			</thead>
			<tbody>
			<?php
			
			foreach($dil as $satir)
			{
				$kayit="var";
// 				if ($satir["DURUM"]==1){
				echo '<tr id="Dil_'.$satir['DIL_ID'].'">';
                                echo '<td>'.$satir['DIL'].'</td>';
                                echo '<td>'.$satir['OKUMA'].'</td>';
                                echo '<td>'.$satir['YAZMA'].'</td>';
                                echo '<td>'.$satir['KONUSMA'].'</td>';
                                echo '<td>'.$satir['ANLAMA'].'</td>';
				
				echo '<td style="text-align:center;"><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
                                echo '<td style="text-align:center;"><input type="button" name="duzenle" class="required" id="duzenleButton" value="Düzenle"/></td>';
				echo '</tr>';
			}
			
			
			
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
<!--		<input type="text" name="adet" class="required" id="adet" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="adet yeni DİL ekle" onclick="satirekle(jQuery('#adet').val());"/>-->
<?php 
if ($this->canEdit){
?>	
<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Yeni Yabancı Dil Ekle"/><br>
	<input type="submit" value="Kaydet"/>
<?php 
}
?>	
<div class="cfclear">&nbsp;</div>
	
</div>
</form>
<br><br>
<b>NOT 1:</b> Yabancı dil bilginizi <a href="ekler/ek-1.docx">Ek-1 dökümanını</a> doğrultusunda değerlendirip girmelisiniz.
<br>
<b>NOT 2:</b> Yabancı dile ilişkin sertifika ve belgeler “sertifika ve belgeler” bölümüne eklenecektir.

<script type="text/javascript">
jQuery(document).ready(function() {
    
    jQuery('#egitim').dataTable({
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
	
/*******************************************************************************/
jQuery('#satirEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#yabanciDil').val('');
        jQuery('#okumaTur').val('');
        jQuery('#yazmaTur').val('');
        jQuery('#konusmaTur').val('');
        jQuery('#dinlemeTur').val('');
        jQuery('#yeniDis').lightbox_me({
        	centered: true,
            closeClick:false,
            closeEsc:false  
        });		
    });
    
    jQuery('#silButton').live('click', function(e) {
            e.preventDefault();
            if(confirm('Bu kaydı silmek istediğinizden emin misiniz?')){
                var trId = jQuery(this).closest('tr').attr('id');
                trId = trId.split('_');
                jQuery(this).closest('tr').remove();
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_uzman_basvur&task=DilSil&format=raw",
                    data: 'dilId='+trId[1],
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
/****************************************************************/

jQuery('#gonder').live('click',function(e){
        e.preventDefault();
        var yabanciDil = jQuery('#yabanciDil').val();
        var okumaTur = jQuery('#okumaTur').val();
        var yazmaTur = jQuery('#yazmaTur').val();
        var konusmaTur = jQuery('#konusmaTur').val();
        var dinlemeTur = jQuery('#dinlemeTur').val();
        if(yabanciDil == '' || yabanciDil.length==0){
            alert('Lütfen Dil bölümünü boş bırakmayınız.');
        }
        else if(okumaTur == '' || okumaTur.length==0){
            alert('Lütfen Okuma bölümünü boş bırakmayınız.');
        }
        else if(yazmaTur == '' || yazmaTur.length==0){
             alert('Lütfen Yazma bölümünü boş bırakmayınız.');
        }
        else if(konusmaTur == '' || konusmaTur.length==0){
             alert('Lütfen Konuşma bölümünü boş bırakmayınız.');
        }
        else if(dinlemeTur == '' || dinlemeTur.length==0){
             alert('Lütfen Dinleme bölümünü boş bırakmayınız.');
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
        jQuery('#yabanciDil').val('');
        jQuery('#okumaTur').val('');
        jQuery('#yazmaTur').val('');
        jQuery('#konusmaTur').val('');
        jQuery('#dinlemeTur').val('');
        var trId = jQuery(this).closest('tr').attr('id');
        trId = trId.split('_');
        jQuery('#dilId').val(trId[1]);
        jQuery.ajax({
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=DilGetir&format=raw",
            data:'dilId='+trId[1],
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            jQuery('#okumaTur').children('option[value="'+dat[0]['OKUMA']+'"]').attr('selected','selected');
                            jQuery('#yazmaTur').children('option[value="'+dat[0]['YAZMA']+'"]').attr('selected','selected');
                            jQuery('#konusmaTur').children('option[value="'+dat[0]['KONUSMA']+'"]').attr('selected','selected');
                            jQuery('#dinlemeTur').children('option[value="'+dat[0]['ANLAMA']+'"]').attr('selected','selected');
                            jQuery('#yabanciDil').val(dat[0]['DIL']);
                            jQuery('#yeniDis').lightbox_me({
                            	centered: true,
                                closeClick:false,
                                closeEsc:false  
                            });
                        }
                    }
        });

    });

});

</script>

<style>
    .hidedivTop{
        margin-top: 10px;
    }
</style>
<div id="yeniDis" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" action="index.php?option=com_uzman_basvur&layout=yabanci_dil&task=basvuruKaydet">
        <div class="hidedivTop"><span>Dil:</span><br><input type="text" id="yabanciDil" name="yabanciDil" /></div>
        <div class="hidedivTop"><span>Okuma:</span><br><select name="okumaTur" id="okumaTur"><?php echo $turSelect;?></select></div>
        <div class="hidedivTop"><span>Yazma:</span><br><select name="yazmaTur" id="yazmaTur"><?php echo $turSelect;?></select></div>
        <div class="hidedivTop"><span>Konuşma:</span><br><select name="konusmaTur" id="konusmaTur"><?php echo $turSelect;?></select></div>
        <div class="hidedivTop"><span>Dinleme:</span><br><select name="dinlemeTur" id="dinlemeTur"><?php echo $turSelect;?></select></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="dilId" id="dilId"/><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
