<?php 
$mykdeneyim=$this->mykdeneyim;
$deneyim_tipleri=$this->deneyim_tipleri;
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
	action="index.php?option=com_uzman_basvur&amp;layout=myk_deneyimi&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
}
echo $this->pageTree;

$turSelect = '<option value="0">Seçiniz</option>';
foreach ($deneyim_tipleri as $value) {
    $turSelect .= '<option value="'.$value['DENEYIM_NO'].'">'.$value['DENEYIM_ADI'].'</option>';
}
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">MYK ile İlgili Deneyimler </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div>
		<table id="mykdeneyim" style="float:left; width:100%">
			<thead>
				<tr>
					<th style="width:140px;">Deneyim Tipi</th>
					<th style="width:400px;">Açıklama</th>
					<th style="width:30px;">Süre (Ay)</th>
					<th style="width:20px;">Sil</th>
                                        <th style="width:20px;">Düzenle</th>
				</tr>
			</thead>
			<tbody>
			<?php
			
			foreach($mykdeneyim as $satir)
			{
				$kayit="var";
// 				if ($satir["DURUM"]==1){
				echo '<tr id="MykDeneyim_'.$satir['MYKDENEYIM_ID'].'">';
				echo '<td>';
      			foreach($deneyim_tipleri as $satir2){
      				
      				if ($satir[TIP]==$satir2[DENEYIM_NO]){
      					echo $satir2[DENEYIM_ADI];
      				}
      			}
				echo '</td>';
                echo '<td>'.$satir["ACIKLAMA"].'</td>';
                echo '<td>'.$satir["SURE"].'</td>';
                echo '<td style="text-align:center;"><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
                echo '<td style="text-align:center;"><input type="button" name="duz" class="required" id="duzenleButton" value="Düzenle"/></td>';
				echo '</tr>';

			}
			
			
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
<!--		<input type="text" name="adet" class="required" id="adet" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="adet yeni MYK DENEYİMİ ekle" onclick="satirekle(jQuery('#adet').val());"/>-->
	
	
<div style="float:left; width:100%; padding-top:13px;">Ulusal Meslek Standartları ve Ulusal Yeterlilikler için deneyim açıklamanızda Meslek Standardı veya Yeterlilik Hazırlama, Geliştirme veya Doğrulama süreçlerinden hangilerinde görev aldığınızı açıklamanızda ayrıntılarıyla belirtiniz.</div>
<?php 
if ($this->canEdit){
?>
<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Yeni MYK Deneyimi Ekle"/><br>
	<input type="submit" value="Kaydet"/>
<?php 
}
?>
<div class="cfclear">&nbsp;</div>
	
</div>
</form>
<script type="text/javascript">

		
jQuery(document).ready(function() {
	
jQuery('#mykdeneyim').dataTable({
        "aoColumns": [
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

    jQuery('#satirEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#tip').val('');
        jQuery('#aciklama').val('');
        jQuery('#sure').val('');
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
                    url: "index.php?option=com_uzman_basvur&task=MYKDeneyimSil&format=raw",
                    data: 'mykdeneyimId='+trId[1],
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
        var tip = jQuery('#tip').val();
        var aciklama = jQuery('#aciklama').val();
        var sure = jQuery('#sure').val();

        if(tip == '' || tip.length==0){
            alert('Lütfen Deneyim Tipi bölümünü boş bırakmayınız.');
        }
        else if(aciklama == '' || aciklama.length==0){
            alert('Lütfen Açıklama bölümünü boş bırakmayınız.');
        }
        else if(sure == '' || sure.length==0){
             alert('Lütfen Süre bölümünü boş bırakmayınız.');
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
        jQuery('#tip').val('');
        jQuery('#aciklama').val('');
        jQuery('#sure').val('');
        var trId = jQuery(this).closest('tr').attr('id');
        trId = trId.split('_');
        jQuery('#mykdeneyimId').val(trId[1]);
        jQuery.ajax({
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=MYKDeneyimGetir&format=raw",
            data:'mykdeneyimId='+trId[1],
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            jQuery('#tip').children('option[value="'+dat[0]['TIP']+'"]').attr('selected','selected');
                            jQuery('#aciklama').val(dat[0]['ACIKLAMA']);
                            jQuery('#sure').val(dat[0]['SURE']);
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
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=myk_deneyimi&task=basvuruKaydet">
        <div class="hidedivTop"><span>Deneyim Tipi:</span><br><select name="tip" id="tip"><?php echo $turSelect;?></select></div>
        <div class="hidedivTop"><span>Açıklama:</span><br><textarea name="aciklama" id="aciklama"></textarea></div>
        <div class="hidedivTop"><span>Süre</span><br><input type="text" name="sure" id="sure"/></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="mykdeneyimId" id="mykdeneyimId"/><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
