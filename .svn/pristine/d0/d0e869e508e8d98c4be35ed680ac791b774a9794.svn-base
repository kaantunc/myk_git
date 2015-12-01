<?php 
$egitim=$this->egitim;
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
	action="index.php?option=com_uzman_basvur&amp;layout=egitim&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
}
echo $this->pageTree;
$tur = array(1=>'Lise',2=>'Önlisans',3=>'Lisans',4=>'Lisansüstü',5=>'Doktora',9=>'Diğer');
$turSelect = '<option value="0">Seçiniz</option>';
foreach ($tur as $key=>$value) {
    $turSelect .= '<option value="'.$key.'">'.$value.'</option>';
}
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Eğitim Bilgileri </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div>
		<table id="egitim" style="float:left; width:100%">
			<thead>
				<tr>
					<th style="width:40px;">Tür</th>
					<th style="width:270px;">Okul Adı</th>
					<th style="width:200px;">Bölüm</th>
					<th style="width:110px;">Başlangıç Yılı</th>
					<th style="width:110px;">Mezuniyet Yılı</th>
					<th style="width:20px;">Sil</th>
                                        <th style="width:20px;">Düzenle</th>
				</tr>
			</thead>
			<tbody>
			<?php
			
			foreach($egitim as $satir)
			{
				$kayit="var";
// 				if ($satir["DURUM"]==1){
					echo '<tr id="Egitim_'.$satir['EGITIM_ID'].'">';
                                        echo '<td>';
					if ($satir['TUR']=="1"){
						echo "Lise";
					}
					else if ($satir['TUR']=="2"){
						echo "Önlisans";
					}
					else if ($satir['TUR']=="3"){
						echo "Lisans";
					}
					else if ($satir['TUR']=="4"){
						echo "Lisansüstü";
					}
					else if ($satir['TUR']=="5"){
						echo "Doktora";
					}
					else if ($satir['TUR']=="9"){
						echo "Diğer";
					}
					echo '</td>';
//					echo '<td><select name=tur[]>';
//					echo '<option value=1';
//					if ($satir[TUR]=="1"){
//						echo " selected";
//					}
//					echo '>Lise</option>';
//					echo '<option value=2';
//					if ($satir[TUR]=="2"){
//						echo " selected";
//					}
//					echo '>Önlisans</option>';
//					echo '<option value=3';
//					if ($satir[TUR]=="3"){
//						echo " selected";
//					}
//					echo '>Lisans</option>';
//					echo '<option value=4';
//					if ($satir[TUR]=="4"){
//						echo " selected";
//					}
//					echo '>Lisansüstü</option>';
//					echo '<option value=5';
//					if ($satir[TUR]=="5"){
//						echo " selected";
//					}
//					echo '>Doktora</option>';
//					echo '<option value=9';
//					if ($satir[TUR]=="9"){
//						echo " selected";
//					}
//					echo '>Diğer</option>';
//					echo '</select></td>';
					echo '<td>'.$satir["OKUL"].'</td>';
					echo '<td>'.$satir["BOLUM"].'</td>';
					echo '<td>'.$satir["BASLANGIC"].'</td>';
					echo '<td>'.$satir["BITIS"].'</td>';
					echo '<td style="text-align:center;"><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
                                        echo '<td style="text-align:center;"><input type="button" name="duzenle" class="required" id="duzenleButton" value="Düzenle"/></td>';
					echo '</tr>';
// 				} else {
// 					echo '<tr>';
// 					echo '<td><select disabled name=tur[]>';
// 					echo '<option value=1';
// 					if ($satir[TUR]=="1"){
// 						echo " selected";
// 					}
// 					echo '>Lise</option>';
// 					echo '<option value=2';
// 					if ($satir[TUR]=="2"){
// 						echo " selected";
// 					}
// 					echo '>Önlisans</option>';
// 					echo '<option value=3';
// 					if ($satir[TUR]=="3"){
// 						echo " selected";
// 					}
// 					echo '>Lisans</option>';
// 					echo '<option value=4';
// 					if ($satir[TUR]=="4"){
// 						echo " selected";
// 					}
// 					echo '>Lisansüstü</option>';
// 					echo '<option value=5';
// 					if ($satir[TUR]=="5"){
// 						echo " selected";
// 					}
// 					echo '>Doktora</option>';
// 					echo '<option value=9';
// 					if ($satir[TUR]=="9"){
// 						echo " selected";
// 					}
// 					echo '>Diğer</option>';
// 					echo '</select></td>';
// 					echo '<td><input disabled type="text" name="okul[]" class="required" id="okul" value="'.$satir["OKUL"].'" style="width: 98%;"  /></td>';
// 					echo '<td><input disabled type="text" name="bolum[]" class="" id="bolum" value="'.$satir["BOLUM"].'" style="width: 98%;"  /></td>';
// 					echo '<td><input disabled type="text" name="baslangic[]" class="required" id="baslangic" value="'.$satir["BASLANGIC"].'" style="width: 98%;"  /></td>';
// 					echo '<td><input disabled type="text" name="bitis[]" class="required" id="bitis" value="'.$satir["BITIS"].'" style="width: 98%;"  /></td>';
// 					echo '<td style="text-align:center;"></td>';
// 					echo '</tr>';

// 				}
			}
				
			
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<!--<input type="text" name="adet" class="required" id="adet" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="adet yeni OKUL ekle" onclick="satirekle(jQuery('#adet').val());"/>-->
<?php 
if ($this->canEdit){
?>	
	<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Yeni Eğitim Ekle"/><br>
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
    jQuery.fn.dataTableExt.afnSortData['dom-select'] = function  ( oSettings, iColumn )
    {
	return jQuery.map( oSettings.oApi._fnGetTrNodes(oSettings), function (tr, i) {
		return $('td:eq('+iColumn+') select', tr).val();
	} );
    };

var tur = new Array();
tur.push(1);
tur.push('Lise');
tur.push(2);
tur.push('Önlisans');
tur.push(3);
tur.push('Lisans');
tur.push(4);
tur.push('Lisansüstü');
tur.push(5);
tur.push('Doktora');
tur.push(9);
tur.push('Diğer');

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

    jQuery('#satirEkle').live('click',function(e){
        e.preventDefault();
//        jQuery('#egitimTur').val('');
        jQuery('#okulAdi').val('');
        jQuery('#okulBolum').val('');
        jQuery('#okulBas').val('');
        jQuery('#okulBit').val('');
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
                    url: "index.php?option=com_uzman_basvur&task=EgitimSil&format=raw",
                    data: 'egitId='+trId[1],
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
        var egitimTur = jQuery('#egitimTur').val();
        var okulAdi = jQuery('#okulAdi').val();
        var okulBolum = jQuery('#okulBolum').val();
        var okulBas = jQuery('#okulBas').val();
        var okulBit = jQuery('#okulBit').val();
        if(egitimTur == '' || egitimTur.length==0){
            alert('Lütfen Tür bölümünü boş bırakmayınız.');
        }
        else if(okulAdi == '' || okulAdi.length==0){
            alert('Lütfen Okul Adı bölümünü boş bırakmayınız.');
        }
        else if(okulBolum == '' || okulBolum.length==0){
             alert('Lütfen Bölüm bölümünü boş bırakmayınız.');
        }
        else if(okulBas == '' || okulBas.length==0){
             alert('Lütfen Başlangıç Yılı bölümünü boş bırakmayınız.');
        }
        else if(okulBit == '' || okulBit.length==0){
             alert('Lütfen Mezuniyet Yılı bölümünü boş bırakmayınız.');
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
//        jQuery('#egitimTur').val('');
        jQuery('#okulAdi').val('');
        jQuery('#okulBolum').val('');
        jQuery('#okulBas').val('');
        jQuery('#okulBit').val('');
        var trId = jQuery(this).closest('tr').attr('id');
        trId = trId.split('_');
        jQuery('#egitId').val(trId[1]);
        jQuery.ajax({
            type: 'POST',
            url: "index.php?option=com_uzman_basvur&task=EgitimGetir&format=raw",
            data:'egitId='+trId[1],
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            jQuery('#egitimTur').children('option[value="'+dat[0]['TUR']+'"]').attr('selected','selected');
                            jQuery('#okulAdi').val(dat[0]['OKUL']);
                            jQuery('#okulBolum').val(dat[0]['BOLUM']);
                            jQuery('#okulBas').val(dat[0]['BASLANGIC']);
                            jQuery('#okulBit').val(dat[0]['BITIS']);
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
    <form method="POST" id="belgeYeni" enctype="multipart/form-data" name="ChronoContact_uzman_basvuru_t4" action="index.php?option=com_uzman_basvur&layout=egitim&task=basvuruKaydet">
        <div class="hidedivTop"><span>Tür:</span><br><select name="egitimTur" id="egitimTur"><?php echo $turSelect;?></select></div>
        <div class="hidedivTop"><span>Okul Adı:</span><br><input type="text" name="okulAdi" id="okulAdi" size="34"/></div>
        <div class="hidedivTop"><span>Bölüm:</span><br><input type="text" name="okulBolum" id="okulBolum" size="34"/></div>
        <div class="hidedivTop"><span>Başlangıç Yılı:</span><br><input type="text" name="okulBas" id="okulBas" size="34"/></div>
        <div class="hidedivTop"><span>Mezuniyet Yılı:</span><br><input type="text" name="okulBit" id="okulBit" size="34"/></div>
        
        <input type="hidden" name="tckimlik" value="<?php echo $this->evrak_id;?>" />
        <input type="hidden" name="egitId" id="egitId"/><br><br>
        <input type="button" id="gonder" value="Gönder"/>
        <input type="button" id="iptal" value="İptal"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
