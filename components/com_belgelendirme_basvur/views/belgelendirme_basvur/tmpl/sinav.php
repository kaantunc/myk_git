<?php 
$durum = $this->durum;
@$basvuru = $this->basvuru;
$sinavMerkez = $this->sinavMerkez;
?>
<form
	onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
	action="index.php?option=com_belgelendirme_basvur&amp;layout=sinav&amp;task=belgelendirmeKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_belgelendirme_basvuru_t3"
	name="ChronoContact_belgelendirme_basvuru_t3">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo '<h2><u>'.$this->kurulus['KURULUS_ADI'].' Sınav ve Belgelendirme Başvuru Formu</u></h2>';
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">11. Kuruluşun sınavlarını gerçekleştireceği merkez(ler)</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
  	<div id="sinavGercekMerkez_div" style="overflow-x:auto;">
            <table id="tablo_sinavGercekMerkez" style="width: 100%;">
                <thead class="tablo_header">
                        <tr>
                                <th>Sınav Merkezi[4]</th>
                                <th>Sınav yapılan yeterlilik(ler)</th>
                                <th>Sınavın şekli[3]</th>
                                <th>Sınav merkezinin tasarrufu</th>
                                <th>Merkezin adres ve iletişim bilgileri</th>
                                <th>Düzenle</th>
                                <th>Sil</th>
                        </tr>
                </thead>
                <tbody>
                    <?php 
                    $sayy = 0;
                    foreach ($sinavMerkez as $row) {
                        if($sayy%2==0){
                            echo '<tr class="tablo_row" id="merkez_'.$row['MERKEZ_ID'].'_'.$row['SINAV_SEKLI_ID'].'">';
                        }else{
                            echo '<tr id="merkez_'.$row['MERKEZ_ID'].'_'.$row['SINAV_SEKLI_ID'].'">';
                        }
                        echo '<td>'.$row['MERKEZ_ADI'].'</td>';
                        echo '<td>'.$row['YETERLILIK_ADI'].'('.$row['YETERLILIK_KODU'].')</td>';
                        echo '<td>'.$row['SINAV_SEKLI_ADI'].'</td>';
                        echo '<td>'.$row['MERKEZ_TEMIN_ADI'].'</td>';
                        echo '<td>'.$row['MERKEZ_ADRESI'].'</td>';
                        echo '<td><a href="#" id="merkezEdit">Düzenle</a></td>';
                        echo '<td><a href="#" id="merkezSil">Sil</a></td>';
                        echo '</tr>';
                        $sayy++;
                    }
                    ?>
                </tbody>
            </table>
	</div>
  </div>
  <input type="button" value="Yeni Sınav Yeri Ekle" id="sinavYeriEkle"/>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">12.	Kuruluşun sınavlarını gerçekleştireceği gezici sınav birim(ler)i[5] var mı?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE =	"";
$checkedH =	"";
 
if ($basvuru["GEZICI_BIRIM"])
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";	
?>

<div class="form_item">
  <div class="form_element cf_radiobutton">
    <div class="float_left">
      <input <?php echo $checkedE;?> value="1" title="" class="radio" id="radio00" name="radio0" type="radio" onclick="hideShowSelected(Array ('block'), Array('id_11'))"/>
      <label for="radio00" class="radio_label">Evet</label>
      <br />
      
<input <?php echo $checkedH;?> value="0" title="" class="radio" id="radio01" name="radio0" type="radio" onclick="hideShowSelected(Array ('none'), Array('id_11'))"/>
      <label for="radio01" class="radio_label">Hayır</label>
      <br />
    </div>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div style="display:none;" id ="id_11">
<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">13.	Gezici sınav birim(ler)inde sınavlar için gerekli altyapının oluşturulması, şeffaf ve güvenilir bir sınavın gerçekleştirilmesi ve sınav için gerekli özel şartlar var ise bu şartların karşılanması için alınan önlemler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_18" title="" cols="60" name="madde_11"><?php echo $basvuru["GEZICI_BIRIM"];?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">14.	Sınav ve belgelendirme sürecinde dışarıdan hizmet alımı yapılan/yapılması planlanan kurum/kuruluş(lar) var mı?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE =	"";
$checkedH =	"";
 
if ($this->birlikteKurulus != null)
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";	
?>

<div class="form_item">
  <div class="form_element cf_radiobutton">
    <div class="float_left">
      <input <?php echo $checkedE;?> value="1" title="" class="radio" id="radio10" name="radio1" type="radio" onclick="hideShowSelected(Array ('block'), Array('id_13'))"/>
      <label for="radio10" class="radio_label">Evet</label>
      <br />
      
<input <?php echo $checkedH;?> value="0" title="" class="radio" id="radio11" name="radio1" type="radio" onclick="hideShowSelected(Array ('none'), Array('id_13'))"/>
      <label for="radio11" class="radio_label">Hayır</label>
      <br />
    </div>
  
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div style="display:none;" id ="id_13">
<div class="form_item">
  <div class="form_element cf_placeholder">
  <h3>Yıldızlı (*) alanlara boşluk bırakılmadan sadece sayı girilmesi gerekmektedir.</h3>
  <div id="disaridanHizmet_panel_div" class="panel_main_div"></div></div>
  <div class="cfclear">&nbsp;</div>
</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">15.	Sınav ve belgelendirme yapılan alanlarla ilgili eğitim veriliyor mu?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php
$checkedE =	"";
$checkedH =	"";
 
if ($basvuru["EGITIM_ACIKLAMA"])
	$checkedE = "checked=\"checked\"";
else
	$checkedH = "checked=\"checked\"";	
?>

<div class="form_item">
  <div class="form_element cf_radiobutton">
    <div class="float_left">
      <input <?php echo $checkedE; ?> value="1" title="" class="radio" id="radio20" name="radio2" type="radio" onclick="hideShowSelected(Array ('block'), Array('id_14'))"/>
      <label for="radio20" class="radio_label">Evet</label>
      <br />
      
<input <?php echo $checkedH; ?> value="0" title="" class="radio" id="radio21" name="radio2" type="radio" onclick="hideShowSelected(Array('none'), Array('id_14'))"/>
      <label for="radio21" class="radio_label">Hayır</label>
      <br />
    </div>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div style="display:none;" id ="id_14">
<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">16.	Eğitim ve belgelendirme faaliyetlerinin ayırımı konusunda alınan tedbirler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_19" title="" cols="60" name="madde_14"><?php echo $basvuru["EGITIM_ACIKLAMA"];?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">17.	Sınav ve belgelendirme çalışmaları için tahsis edilen kaynaklar, teknik ve fiziki altyapı imkânları</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_20" title="" cols="60" name="madde_15"><?php echo $basvuru["TEKNIK_FIZIKI_ACIKLAMA"];?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<?php if($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14){ ?>
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="button" id="kaydet"/>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php }
else if($this->canEdit){
?>
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="button" id="kaydet"/>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php   
}?>
<br>
<hr>
<div class="form_item" style="padding-top: 25px; font-style:italic;">
	<p>[3]-Teorik, uygulamalı vb.</p>
	<p>[4]-Sınav merkezi Yetkilendirme Başvurusunda bulunan Kuruluşun sınavlarını gerçekleştireceği merkezi ifade etmektedir.</p>
	<p>[5]-Gezici sınav birimi Kuruluşun sınav merkezi dışında sınavlarını gerçekleştirdiği yerdir. Sınav belirli bir merkezde yapılmıyorsa(Örneğin müşterinin tesislerinde yapılıyorsa veya sınav merkezinin yanı sıra müşterinin tesislerinde de sınav yapılıyorsa) bu soruyu "Evet" cevabı verilecektir.</p>
	<p>[6]-Dışarıdan hizmet alımı(örn. Sınav merkezi, sınavın tamamının veya bir kısmının Kuruluş dışından hizmet temini ile yaptırılması, sınav parçalarının muayenesi vb.) yapılan/yapılması planlanan her bir kurum/kuruluş için bu form doldurulacaktır. Dışarıdan hizmet alınan kuruluşların listesi ve alınan hizmetlerin niteliği belirtilmelidir.</p>
	<div class="cfclear">&nbsp;</div>
</div>
</form>

<div id="yeniDis" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
  				
    <strong>Sınav Merkezi:</strong></br>
    <input type="text" id="merkezAd" name="merkezAd" size="35" class="required"></br></br>
    <strong>Sınav Yapılan Yeterlilik(ler):</strong></br>
    <div style="max-height:100px;overflow:auto;"><br>
<!--                     <select id="merkezYet" name="merkezYet"> -->
<!--                             <option value="0">Seçiniz</option> -->
                            <?php 
//                             foreach ($this->pm_kayitli_yet as $row) {
//                                 echo '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_ADI'].'('.$row['YETERLILIK_KODU'].')</option>';
//                             }
                            foreach ($this->pm_kayitli_yet as $row) {
                            	echo '<input type="checkbox" name="merkezYet[]" id="merkezYet" value="'.$row['YETERLILIK_ID'].'"> '.$row['YETERLILIK_ADI'].'('.$row['YETERLILIK_KODU'].')<br>';
                            }
                            ?>
<!--                     </select>--></div></br>
    <strong>Sınavın Şekli:</strong></br>
                    <select id="merkezSekil" name="merkezSekil">
                            <option value="0">Seçiniz</option>
                            <option value="1">Teorik</option>
                            <option value="2">Pratik</option>
                            <option value="3">Teorik, Pratik</option>
                    </select></br></br>


    <strong>Sınav Merkezinin Tasarrufu:</strong>
    </br><input type="radio" id="merkezTas" name="merkezTas" value="1" checked="checked">Basvuran kurulusa aittir<br>
            <input type="radio" id="merkezTas" name="merkezTas" value="2">Protokol /sözlesme ile temin edilmektedir<br></br>

    <strong>Merkezin adres ve iletişim bilgileri:</strong></br>
    <textarea id="merkezAdres" name="merkezAdres" style="max-width: 400px;min-width: 400px"></textarea></br></br>
	<input type="hidden" id="merkezEditId" />
    <input type="button" id="merkezKaydet" value="Kaydet"/> <input type="button" value="İptal" id="merkezPopSil"/>
</div>

<div id="yeniDisEdit" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
  				
    <strong>Sınav Merkezi:</strong></br>
    <input type="text" id="merkezAdEdit" name="merkezAd" size="35" class="required"></br></br>
    <strong>Sınav Yapılan Yeterlilik:</strong></br>
                    <select id="merkezYetEdit" name="merkezYet">
                    <!-- Burası seçtiği yeterliliklerden gelicek -->
                            <option value="0">Seçiniz</option>
                            <?php 
                            foreach ($this->pm_kayitli_yet as $row) {
                                echo '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_ADI'].'('.$row['YETERLILIK_KODU'].')</option>';
                            }
                            ?>
                    </select></br></br>
    <strong>Sınavın Şekli:</strong></br>
                    <select id="merkezSekilEdit" name="merkezSekil">
                            <option value="0">Seçiniz</option>
                            <option value="1">Teorik</option>
                            <option value="2">Pratik</option>
                            <option value="3">Teorik, Pratik</option>
                    </select></br></br>


    <strong>Sınav Merkezinin Tasarrufu:</strong>
    </br><input type="radio" id="merkezTasEdit" name="merkezTas" value="1" checked="checked">Basvuran kurulusa aittir<br>
            <input type="radio" id="merkezTasEdit" name="merkezTas" value="2">Protokol /sözlesme ile temin edilmektedir<br></br>

    <strong>Merkezin adres ve iletişim bilgileri:</strong></br>
    <textarea id="merkezAdresEdit" name="merkezAdresEdit" style="max-width: 400px;min-width: 400px"></textarea></br></br>

    <input type="button" id="merkezKaydetEdit" value="Kaydet"/> <input type="button" value="İptal" id="merkezPopSilEdit"/>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<script type="text/javascript">

jQuery(document).ready(function(){
	hideShowRadioButtonText ();

	jQuery('#sinavYeriEkle').live('click',function(e){
            e.preventDefault();
            jQuery('#merkezAd').val('');
            //jQuery('#merkezYet').val(0);
            jQuery.each(jQuery('#merkezYet:checked'),function(key,vall){
            	vall.checked=false;
    		});
            jQuery('#merkezSekil').val(0);
            jQuery('input#merkezTas[value=1]').prop('checked',true);
            jQuery('#merkezAdres').val('');
            
            jQuery('#yeniDis').lightbox_me({
                centered: true,
                closeClick:false,
                closeEsc:false
            });
	});

	jQuery('#merkezPopSil').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniDis').trigger('close');
	});

	jQuery('#merkezKaydet').live('click',function(e){
		e.preventDefault();
		var merkezAd = jQuery('#merkezAd').val();
		var merkezYet = jQuery('#merkezYet').val();
		var merkezSekil = jQuery('#merkezSekil').val();
		var merkezTas = jQuery('input#merkezTas:checked').val();
		var merkezAdres = jQuery('#merkezAdres').val();

		var yets = new Array();
		jQuery.each(jQuery('#merkezYet:checked'),function(key,vall){
			yets.push(vall.value);
		});
                
		if(merkezAd.length == 0 || merkezAd == ''){
			alert('Sınav Merkezi alanını boş bırakmayınız.');
		}
		else if(jQuery('#merkezYet:checked').length == 0){
			alert('Sınav Yapılan Yeterliliği seçiniz.');
		}
        else if(merkezSekil == 0){
			alert('Sınavın Şeklini seçiniz.');
		}else{
                    jQuery('#yeniDis').trigger('close');
                    jQuery('#loaderGif').lightbox_me({
                        centered: true,
                        closeClick:false,
                        closeEsc:false
                    });
                    jQuery.ajax({
                        type: 'POST',
                        url: "index.php?option=com_belgelendirme_basvur&task=sinavMerkeziKaydet&format=raw",
                        data:'merkezAd='+merkezAd+'&merkezYet='+yets+'&merkezSekil='+merkezSekil+'&merkezTas='+merkezTas+'&merkezAdres='+merkezAdres+'&evrak_id=<?php echo $this->evrak_id;?>',
                        success: function(data){
                          if(jQuery.parseJSON(data)){
                              alert('Sınav merkezi başarıyla eklendi.');
                              window.location.reload();
                          }else{
                              alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
                              window.location.reload();
                          }
                        }
                    });
         }
	});
        
        jQuery('#merkezSil').live('click',function(e){
            e.preventDefault();
            var id = jQuery(this).closest('tr').attr('id').split('_');
            var merkezId = id[1];
            var sinavSekil = id[2];
            if(confirm('Sınav merkezini silmek istediğinizden emin misiniz?')){
                jQuery('#loaderGif').lightbox_me({
                    centered: true,
                    closeClick:false,
                    closeEsc:false
                });
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_belgelendirme_basvur&task=sinavMerkeziSil&format=raw",
                    data:'merkezId='+merkezId+'&sekil='+sinavSekil,
                    success: function(data){
                          window.location.reload();
                    }
                });
            }else{
                return false;
            }
        });
        
        jQuery('#merkezEdit').live('click',function(e){
            e.preventDefault();
            var id = jQuery(this).closest('tr').attr('id').split('_');
            var merkezId = id[1];
            var sinavSekil = id[2];
            jQuery('#merkezAdEdit').val('');
            jQuery('#merkezYetEdit').val(0);
            jQuery('#merkezSekilEdit').val(0);
            jQuery('input#merkezTasEdit[value=1]').prop('checked',true);
            jQuery('#merkezAdresEdit').val('');
			jQuery('#merkezEditId').val(merkezId);
            
            jQuery.ajax({
                type:'POST',
                url:"index.php?option=com_belgelendirme_basvur&task=ajaxGetSinavMerkezi&format=raw",
                data:'merkezId='+merkezId+'&sekil='+sinavSekil,
                success:function(data){
					var dat = jQuery.parseJSON(data);
					jQuery('#merkezAdEdit').val(dat[0]['MERKEZ_ADI']);
		            jQuery('#merkezYetEdit').children('option[value='+dat[0]['YETERLILIK_ID']+']').prop('selected',true);
		            jQuery('#merkezSekilEdit').children('option[value='+dat[0]['SINAV_SEKLI_ID']+']').prop('selected',true);
		            jQuery('input#merkezTasEdit[value='+dat[0]['MERKEZ_TEMIN_ID']+']').prop('checked',true);
		            jQuery('#merkezAdresEdit').val(dat[0]['MERKEZ_ADRESI']);
                    
                	jQuery('#yeniDisEdit').lightbox_me({
                        centered: true,
	                    closeClick:false,
	                    closeEsc:false
                	});
                }
            });
        });

        jQuery('#merkezPopSilEdit').live('click',function(e){
            e.preventDefault();
            e.preventDefault();
    		jQuery('#yeniDisEdit').trigger('close');
        });

        jQuery('#merkezKaydetEdit').live('click',function(e){
    		e.preventDefault();
    		var merkezAd = jQuery('#merkezAdEdit').val();
    		var merkezYet = jQuery('#merkezYetEdit').val();
    		var merkezSekil = jQuery('#merkezSekilEdit').val();
    		var merkezTas = jQuery('input#merkezTasEdit:checked').val();
    		var merkezAdres = jQuery('#merkezAdresEdit').val();
    		var merkezId = jQuery('#merkezEditId').val();
                    
    		if(merkezAd.length == 0 || merkezAd == ''){
    			alert('Sınav Merkezi alanını boş bırakmayınız.');
    		}
    		else if(merkezYet == 0){
    			alert('Sınav Yapılan Yeterliliği seçiniz.');
    		}
                    else if(merkezSekil == 0){
    			alert('Sınavın Şeklini seçiniz.');
    		}else{
                        jQuery('#yeniDisEdit').trigger('close');
                        jQuery('#loaderGif').lightbox_me({
                            centered: true,
                            closeClick:false,
                            closeEsc:false
                        });
                        jQuery.ajax({
                            type: 'POST',
                            url: "index.php?option=com_belgelendirme_basvur&task=sinavMerkeziUpdate&format=raw",
                            data:'merkezId='+merkezId+'&merkezAd='+merkezAd+'&merkezYet='+merkezYet+'&merkezSekil='+merkezSekil+'&merkezTas='+merkezTas+'&merkezAdres='+merkezAdres+'&evrak_id=<?php echo $this->evrak_id;?>',
                            success: function(data){
                              if(jQuery.parseJSON(data)){
                                  window.location.reload();
                              }else{
                                  window.location.reload();
                              }
                            }
                        });
                    }
    	});
});

//SINAV GERCEK MERKEZ
<?php
// $param = array ($this->pm_kayitli_yet, $this->pm_sinav_sekli);
// $k = ')), new Array("combo", new Array(';
// $r = 'dTables.sinavGercekMerkez = new Array( new Array("text", "required"), new Array("combo", new Array(';
// $p = '';

// for ($i = 0; $i < count ($param); $i++){
// $data = $param[$i];

// $s = 'new Array ("Seçiniz", "Seçiniz"),';
// if(isset($data)){
//     foreach ($data as $row){
//     	if(isset($row[0]))
//     	{
//     		$id	   = $row[0];
//     		$value = $row[1];
//     		if (isset ($row[2]))
//     		$value = $row[1]."-".$row[2];
    	
//     		$s .= 'new Array ("'.$id.'","'.FormFactory2::normalizeVariable ($value).'"),';
//     	}
//     	else if(isset($row['YETERLILIK_ID'])){
//     		$id	   = $row['YETERLILIK_ID'];
//     		$value = $row['YETERLILIK_ADI'];
//     		if (isset ($row['SEVIYE_ADI']))
//     		$value = $row['YETERLILIK_ADI']."-".$row['SEVIYE_ADI'];
    		 
//     		$s .= 'new Array ("'.$id.'","'.FormFactory2::normalizeVariable ($value).'"),';
//     	}
//     }
// }
// if ($i == 0)
// 	$s = substr ($s, 0, strlen($s)-1);
// else
// 	$s .= 'new Array ("3", "Teorik, Pratik")';


// $p .= $s.$k;

// $k = ')), new Array("radio", new Array(new Array("1", "Basvuran kurulusa aittir","checked"), new Array("2", "Protokol /sözlesme ile temin edilmektedir"))),new Array("textarea"));';
// }
// $r .= $p;
// echo $r;
?>
// SINAV GERCEK MERKEZ SONU

//DISARIDAN HIZMET PANEL
<?php
$param = array ($this->pm_kurulus_statu, $this->pm_il);
$k = ')), new Array("Yetkilisi", "text"), new Array("Adresi", "textarea"), new Array("Şehir", "combo", new Array(';
$r = 'dPanels.disaridanHizmet_panel =  new Array("Dışarıdan hizmet alımı yapılması planlanan kurum/kuruluşun[6];", new Array("Adı", "text"), new Array("Statüsü", "combo", new Array(';
$p = '';

for ($i = 0; $i < count ($param); $i++){
$data = $param[$i];

$s = 'new Array ("Seçiniz", "Seçiniz"),';
if(isset($data)){
    foreach ($data as $row){
        $id = $row[0];
        $value = $row[1];
        if ($id != 0)
            $s .= 'new Array ("'.$id.'","'.FormFactory2::normalizeVariable ($value).'"),';
    }
}

$s = substr ($s, 0, strlen($s)-1);
$p .= $s.$k;

$k = '),"comboReq"), new Array("Posta Kodu*", "text", "numeric"), new Array("Telefon*", "text", "numeric"), new Array("Faks*", "text", "numeric"), new Array("E-Posta", "text", "e-mail"), new Array("Web", "text", "url"), new Array ("Alınması planlanan hizmetler","textarea"));';
}
$r .= $p;
echo $r;
?>
//DISARIDAN HIZMET PANEL SONU

// function createTables (){
// 	var tableName = "sinavGercekMerkez";
// 	createTable(tableName, new Array( 'Sınav Merkezi[4]',
// 									  'Sınav yapılan yeterlilik(ler)',
// 									  'Sınavın şekli[3]',
// 									  'Sınav merkezinin tasarrufu',
// 									  'Merkezin adres ve iletişim bilgileri'));
// 	addSinavMerkezValues (dTables.sinavGercekMerkez, tableName);
// }

function createPanels (){
	createAddDisHizmetValues ("disaridanHizmet_panel", "Kurum/Kuruluş");
}

// function addSinavMerkezValues (sinavMerkez, name){
// 	var length = sinavMerkez.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
// 	var arrId  = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = sinavMerkez[i][0];
// 	}
	
	<?php
// 	$data = $this->sinavMerkez;	
// 	$tableCount = count ($data);
	
// 	$c = 0;
// 	$id = 0;
// 	$merkez_id = -1;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $data[$i];
	
// 		if ($merkez_id != $arr["MERKEZ_ID"]){
// 			echo 'arrId['.$id++.']= "'.$arr["MERKEZ_ID"] .'";';
// 		    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["MERKEZ_ADI"]) .'";';
// 		    echo 'arr['.$c++.']= "'. $arr["YETERLILIK_ID"] .'";';
// 		    echo 'arr['.$c++.']= "'. $arr["SINAV_SEKLI_ID"] .'";';
// 		    echo 'arr['.$c++.']= "'. $arr["MERKEZ_TEMIN_ID"] .'";';
// 		    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["MERKEZ_ADRESI"]) .'";';
// 		   // echo 'arr['.$c++.']= "'. $arr["MERKEZ_ID"] .'";';
// 		    $merkez_id = $arr["MERKEZ_ID"];
// 		}else{
// 			echo 'arr['.($c-3).']= "3";';
// 		}
// 	}
// 	?>

// 	if (isset (arr))
// 		addTableValues2 (arr, arrId, params, name);
	
// }

function createAddDisHizmetValues (name, buttonName){
	var arry = new Array ();
	<?php
	$data = $this->birlikteKurulus;
	$panelCount = count($data);
	
	echo 'var panelCount ='. $panelCount.';'; 
	
	$c = 0;
	for ($i=0; $i< $panelCount; $i++) {
		$arrKurulus = $data[$i];
	
		echo 'arry['.$c++.']= "'. $arrKurulus["BIRLIKTE_KURULUS_ID"] .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_ADI"]) .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["KURULUS_STATU_ID"] .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_YETKILISI"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_ADRES"]) .'";';
	    echo 'arry['.$c++.']= "'. $arrKurulus["IL_ID"] .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_POSTAKOD"]).'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_TELEFON"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_FAKS"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_EPOSTA"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_WEB"]) .'";';
	    echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrKurulus["BIRLIKTE_KURULUS_HIZMET"]) .'";';
	}
	?>
	var rowCount = 11;
	createNPanels(panelCount, name, buttonName);

	if (isset (arry))
		addPanelValues (arry, name, panelCount, rowCount);
}

function hideShowRadioButtonText (){
	var item = document.getElementById ("radio00");
	if (item.checked) 
		hideShowSelected(Array ('block'), Array('id_11'));

	item = document.getElementById ("radio10");
	if (item.checked){
		hideShowSelected(Array ('block'), Array('id_13'));
	}

	item = document.getElementById ("radio20");
	if (item.checked)
		hideShowSelected(Array ('block'), Array('id_14'));
}

function submitForm (){
	var form = document.ChronoContact_belgelendirme_basvuru_t3;    
	var item = document.getElementById ("radio11");
	var element = document.getElementById("id_13");

	if (item.checked && element != null)
		elementSil (element);
	
	if (form.onsubmit()){
		form.submit();
	}
}

jQuery(document).ready(function(){
   jQuery('#kaydet').live('click',function(e){
       e.preventDefault();
       var yets = 0;
       jQuery.each(jQuery('select[name="inputsinavGercekMerkez-2[]"] option:selected'),function(index,deger){
          if(deger.value == 'Seçiniz'){
              yets++;
          }
       });
       if(yets>0){
           alert('Lütfen "11. Kuruluşun sınavlarını gerçekleştireceği merkez(ler)" bölümündeki "Sınav yapılan yeterlilik(ler)" kısmını boş bırakmayınız.');
       }
       
       var sekils = 0;
       jQuery.each(jQuery('select[name="inputsinavGercekMerkez-3[]"] option:selected'),function(index,deger){
          if(deger.value == 'Seçiniz'){
              sekils++;
          }
       });
       if(sekils>0){
           alert('Lütfen "11. Kuruluşun sınavlarını gerçekleştireceği merkez(ler)" bölümündeki "Sınavın şekli" kısmını boş bırakmayınız.');
       }
       
       if(sekils == 0 && yets == 0){
           submitForm();
       }
   });
});
</script>