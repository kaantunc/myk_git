<?php 
$deneyim=$this->deneyim;
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
	action="index.php?option=com_uzman_basvur&amp;layout=is_deneyimi&amp;task=basvuruKaydet"
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
  	<h3 class="contentheading">İş Deneyimleri </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div>
		<table id="deneyim" style="float:left; width:100%">
			<thead>
				<tr>
					<th style="width:100px;">Başlangıç</th>
					<th style="width:100px;">Bitiş</th>
					<th style="width:200px;">Kurum/Kuruluş</th>
					<th style="width:150px;">Ünvanı</th>
					<th style="width:200px;">İş Tanımı</th>
					<th style="width:20px;">Sil</th>
                                        <th style="width:20px;">Düzenle</th>
				</tr>
			</thead>
			<tbody>
			<?php
			
			foreach($deneyim as $satir)
			{
				$kayit="var";
// 				if ($satir["DURUM"]==1){
					echo '<tr id="Is_'.$satir['DENEYIM_ID'].'">';
					echo '<td>'.$satir["BASLANGIC"].'</td>';
					echo '<td>'.$satir["BITIS"].'</td>';
					echo '<td>'.$satir["ISYERI"].'</td>';
					echo '<td>'.$satir["UNVAN"].'</td>';
					echo '<td>'.$satir["IS_TANIMI"].'</td>';
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
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="adet yeni İŞ DENEYİMİ ekle" onclick="satirekle(jQuery('#adet').val());"/>-->
	
<?php 
if ($this->canEdit){
?>
	<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Yeni İş Deneyimi Ekle"/><br>
	<input type="submit" value="Kaydet"/>
<?php 
}
?>
<div class="cfclear">&nbsp;</div>
	
</div>
</form>
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
    
    jQuery('#deneyim').dataTable({
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
                url: "index.php?option=com_uzman_basvur&task=IsSil&format=raw",
                data: 'isId='+trId[1],
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
        jQuery('#isBas').val('');
        jQuery('#isBit').val('');
        jQuery('#isKur').val('');
        jQuery('#isUnvan').val('');
        jQuery('#isTanim').val('');
        jQuery('#yeniDis').lightbox_me({
        	centered: true,
            closeClick:false,
            closeEsc:false  
        });		
    });	

    jQuery('#gonder').live('click',function(e){
        e.preventDefault();
        var isBas = jQuery('#isBas').val();
        var isBit = jQuery('#isBit').val();
        var isKur = jQuery('#isKur').val();
        var isUnvan = jQuery('#isUnvan').val();
        var isTanim = jQuery('#isTanim').val();
        if(isBas == '' || isBas.length==0){
            alert('Lütfen Başlangıç bölümünü boş bırakmayınız.');
        }
        else if(isBit == '' || isBit.length==0){
            alert('Lütfen Bitiş bölümünü boş bırakmayınız.');
        }
        else if(isKur == '' || isKur.length==0){
             alert('Lütfen Kurum/Kuruluş bölümünü boş bırakmayınız.');
        }
        else if(isUnvan == '' || isUnvan.length==0){
             alert('Lütfen Ünvanı bölümünü boş bırakmayınız.');
        }
        else if(isTanim == '' || isTanim.length==0){
             alert('Lütfen İş Tanımı bölümünü boş bırakmayınız.');
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
        jQuery('#isBas').val('');
        jQuery('#isBit').val('');
        jQuery('#isKur').val('');
        jQuery('#isUnvan').val('');
        jQuery('#isTanim').val('');
        var trId = jQuery(this).closest('tr').attr('id');
        trId = trId.split('_');
        jQuery('#isId').val(trId[1]);
        jQuery.ajax({
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=IsGetir&format=raw",
            data:'isId='+trId[1],
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            jQuery('#isBas').val(dat[0]['BASLANGIC']);
                            jQuery('#isBit').val(dat[0]['BITIS']);
                            jQuery('#isKur').val(dat[0]['ISYERI']);
                            jQuery('#isUnvan').val(dat[0]['UNVAN']);
                            jQuery('#isTanim').val(dat[0]['IS_TANIMI']);
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
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=is_deneyimi&task=basvuruKaydet">
        <div class="hidedivTop"><span>Başlangıç:</span><br><input type="text" name="isBas" id="isBas" size="34"/></div>
        <div class="hidedivTop"><span>Bitiş:</span><br><input type="text" name="isBit" id="isBit" size="34"/></div>
        <div class="hidedivTop"><span>Kurum/Kuruluş:</span><br><input type="text" name="isKur" id="isKur" size="34"/></div>
        <div class="hidedivTop"><span>Ünvanı:</span><br><input type="text" name="isUnvan" id="isUnvan" size="34"/></div>
        <div class="hidedivTop"><span>İş Tanımı:</span><br><textarea name="isTanim" id="isTanim" cols="29" rows="5"></textarea></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="isId" id="isId" /><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
