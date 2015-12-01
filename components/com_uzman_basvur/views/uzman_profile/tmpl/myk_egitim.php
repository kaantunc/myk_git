<?php 
$egitim=$this->myk_egitim; 
?>
<form
	onsubmit="return validate('ChronoContact_uzman_basvuru_t4')"
	action="index.php?option=com_uzman_basvur&amp;layout=myk_egitim&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="anaDiv font20 hColor text-center">
	MYK Eğitim Bilgileri
</div>

<div class="anaDiv">
	<table width="100%" style="text-align:center;margin-bottom:10px;" border="1" id="egitim" class="display compact">
		<thead class="thPad5 bg-info" style="">
				<tr>
					<th width="10%">Başlangıç Tarihi</th>
					<th width="20%">Eğitim Türü</th>
					<th width="20%">Eğitmen Adı</th>
					<th width="10%">Eğitim Süresi</th>
					<th width="30%">Açıklama</th>
					<th width="10%">Düzenle</th>
					<th width="10%">Sil</th>
				</tr>
			</thead>
			<tbody class="tdPad5">
			<?php
			
			foreach($egitim as $row)
			{
				echo '<tr>';
				echo '<td>'.$row['TARIH'].'</td>';
				echo '<td>'.$row['TUR'].'</td>';
				echo '<td>'.$row['EGITMEN'].'</td>';
				echo '<td>'.$row['SURE'].'</td>';
				echo '<td>'.nl2br($row['ACIKLAMA']).'</td>';
				echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncMykEgitimDuz('.$row['EGITIM_ID'].')">Düzenle</button></td>';
				echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncMykEgitimSil('.$row['EGITIM_ID'].')">Sil</button></td>';
				echo '</tr>';
			}
			
			?>
			</tbody>
		</table>
</div>

<div class="anaDiv">
	<div class="divYan">
		<button type="button" class="btn btn-sm btn-primary" id="satirEkle">Yeni Eğitim Ekle</button>
	</div>
	<div class="divYan">
		<button type="submit" class="btn btn-sm btn-success">Kaydet</button>
	</div>
</div>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
    
    jQuery('#egitim').dataTable({
        "aoColumns": [
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

    jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});
    
    jQuery('#satirEkle').live('click',function(e){
        e.preventDefault();
		FuncEgitimTemizle();
        jQuery('#yeniDis').lightbox_me({
        	centered: true,
            closeClick:false,
            closeEsc:false  
        });		
    });
    
/****************************************************************/

	jQuery('#gonder').live('click',function(e){
        e.preventDefault();
        var tarih = jQuery('input[name="basTarih"]').val();
    	var tur = jQuery('input[name="tur"]').val();
    	var egitmen = jQuery('input[name="egitmen"]').val();
    	var sure = jQuery('input[name="sure"]').val();
        
        if(tarih == '' || tarih.length==0){
            alert('Lütfen, Eğitim Başlangıç Tarihi bölümünü boş bırakmayınız.');
        }
        else if(tur == '' || tur.length==0){
            alert('Lütfen, Eğitim Türü bölümünü boş bırakmayınız.');
        }
        else if(egitmen == '' || egitmen.length==0){
             alert('Lütfen, Eğitmen Adı bölümünü boş bırakmayınız.');
        }
        else if(sure == '' || sure.length==0){
             alert('Lütfen, Eğitim Süresi bölümünü boş bırakmayınız.');
        }
        else{
            jQuery('#belgeYeni').submit();
        }
    });
    
    jQuery('#iptal').live('click',function(e){
        e.preventDefault();
        FuncEgitimTemizle();
        jQuery('#yeniDis').trigger('close'); 
    });
});
	

function FuncEgitimTemizle(){
	jQuery('input[name="basTarih"]').val('');
	jQuery('input[name="tur"]').val('');
	jQuery('input[name="egitmen"]').val('');
	jQuery('input[name="sure"]').val('');
	jQuery('input[name="egitId"]').val(0);
}

function FuncMykEgitimDuz(egitId){
	FuncEgitimTemizle();
    jQuery('input[name="egitId"]').val(egitId);
    jQuery.ajax({
    	async:false,
        type: 'POST',
        url: "index.php?option=com_uzman_basvur&task=MykEgitimGetir&format=raw",
        data:'egitId='+egitId
    }).done(function(data){
    	var dat = jQuery.parseJSON(data);
        if(dat.length>0){
        	jQuery('input[name="basTarih"]').val(dat[0]['TARIH']);
        	jQuery('input[name="tur"]').val(dat[0]['TUR']);
        	jQuery('input[name="egitmen"]').val(dat[0]['EGITMEN']);
        	jQuery('input[name="sure"]').val(dat[0]['SURE']);
        	jQuery('textarea[name="acik"]').val(dat[0]['ACIKLAMA']);
            jQuery('#yeniDis').lightbox_me({
            	centered: true,
                closeClick:false,
                closeEsc:false  
            });
        }
    });
}

function FuncMykEgitimSil(egitId){
	if(confirm('Bu kaydı silmek istediğinizden emin misiniz?')){
        jQuery.ajax({
        	async:false,
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=MykEgitimSil&format=raw",
            data: 'egitId='+egitId
        }).done(function(data){
        	jQuery('#loaderGif').lightbox_me({
           	 centered: true,
                closeClick:false,
                closeEsc:false  
            });
           window.location.reload();
        });
    }
}
</script>

<!-- MYK Egitim Ekleme MODAL -->
<div id="yeniDis" style="width:500px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=myk_egitim&task=basvuruKaydet">
    	<div class="anaDiv text-center font20 hColor">
    		MYK Eğitim Bilgisi Ekleme Ekranı
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Başlangıç Tarihi:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm tarih" name="basTarih"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Eğitim Türü:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm" name="tur"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Eğitmen Adı:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm" name="egitmen" />
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Eğitim Süresi:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm" name="sure" />
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Açıklama:
    		</div>
    		<div class="div60">
    			<textarea rows="5" class="inputW95" name="acik"></textarea>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-success" id="gonder">Kaydet</button>
    		</div>
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-danger" id="iptal">İptal</button>
    		</div>
    	</div>        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="egitId" id="egitId" value="0"/>

    </form>
</div>
<!-- MYK Egitim Ekleme MODAL SON -->

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
