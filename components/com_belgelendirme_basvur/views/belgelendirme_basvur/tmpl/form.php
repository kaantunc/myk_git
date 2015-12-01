<?php 
$user = &JFactory::getUser();
$basvuru_docs = $this->basvuru_docs;
$basekuzun = count($basvuru_docs);

$durum = $this->durum;

$belge = array("onbasvuru", "yetkibasvuru", "onsozlesme", "yetsozlesme");
$belgeAciklama = array("Ön Başvuru Formu", "Yetkilendirme Başvurusu Formu", "Ön Başvuru Sözleşmesi", "Yetkilendirme Sözleşmesi" );
?>

<form
	
	action="index.php?option=com_belgelendirme_basvur&amp;layout=form&amp;task=belgelendirmeKaydet"
	enctype="multipart/form-data" method="post"
	id="BasvuruDocsEkle"
	name="ChronoContact_belgelendirme_basvuru_t3">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php
echo '<h2><u>'.$this->kurulus['KURULUS_ADI'].' Sınav ve Belgelendirme Başvuru Formu</u></h2>';
echo $this->pageTree;

for ($ii=0;$ii<count($belge);$ii++){
	?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading"><?php echo $belgeAciklama[$ii]?></h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div id="<?php echo $belge[$ii];?>_div">
		<table id="<?php echo $belge[$ii];?>" style="float:left; width:100%">
			<thead>
				<tr><?php if($ii == 2){
					?>
					<th>Belge</th>
					<th>Başlangıç Tarihi</th>
					<th>Bitiş Tarihi</th>
					<th class="sil" style="width:20px;">Sil</th>
				<?php }
                                else if($ii == 3){?>
                                        <th>Belge</th>
					<th>Başlangıç Tarihi</th>
					<th class="sil" style="width:20px;">Sil</th>
                               <?php }
				else{
				?>
					<th>Belge</th>
					<th style="text-align:center;">Tarihi</th>
					<th class="sil" style="width:20px;">Sil</th>
				<?php } ?>
				</tr>
			</thead>
			<tbody id="tablo_<?php echo $belge[$ii];?>">
			<?php
			$taharray = array();
			for($i=0; $i<$basekuzun; $i++){
				if($basvuru_docs[$i][BELGE_TURU] == $belge[$ii]){
					array_push($taharray,$i);
				}
			}
			
			if(count($taharray)>0){
				for($j=0; $j<count($taharray); $j++)
				{
					if($ii == 2){

							echo '<tr id="tr_'.$belge[$ii].'">';
							echo '<td style="text-align:center;">'.$basvuru_docs[$taharray[$j]]["BELGE_ADI"].'<a style="padding-left:10px;" href="index.php?dl=belgelendirme_basvuru_ekleri/'.$basvuru_docs[0][EVRAK_ID].'/DOCS/'.$belge[$ii].'/'.$basvuru_docs[$taharray[$j]][BELGE_ADI].'"><button type="button">Dosya İncele</button></a></td>';
							echo '<td style="text-align:center; padding-right: 20px;">'.$basvuru_docs[$taharray[$j]]["BAS_TARIH"].'</td>';
							echo '<td style="text-align:center; padding-right: 20px;">'.$basvuru_docs[$taharray[$j]]["BIT_TARIH"].'</td>';
							echo '<td style="text-align:center;"><input type="button" name="sil" id="silButton" value="Sil"/></td>';
							echo '</tr>';

					}
                    else if($ii == 3){
                            echo '<tr id="tr_'.$belge[$ii].'">';
							echo '<td style="text-align:center;">'.$basvuru_docs[$taharray[$j]]["BELGE_ADI"].'<a style="padding-left:10px;" href="index.php?dl=belgelendirme_basvuru_ekleri/'.$basvuru_docs[0][EVRAK_ID].'/DOCS/'.$belge[$ii].'/'.$basvuru_docs[$taharray[$j]][BELGE_ADI].'"><button type="button">Dosya İncele</button></a></td>';
							echo '<td style="text-align:center; padding-right: 20px;">'.$basvuru_docs[$taharray[$j]]["BAS_TARIH"].'</td>';
							//echo '<td style="text-align:center; padding-right: 20px;"><input type="text" class="pickdatetime required" name="tarih['.$belge[$ii].'][]"   value="'.$basvuru_docs[$taharray[$j]]["BIT_TARIH"].'" size="20px;"/></td>';
							echo '<td style="text-align:center;"><input type="button" name="sil"  id="silButton" value="Sil"/></td>';
							echo '</tr>';
                    }
					else{
						echo '<tr id="tr_'.$belge[$ii].'">';
		                echo '<td style="text-align:center;">'.$basvuru_docs[$taharray[$j]]["BELGE_ADI"].'<a style="padding-left:10px;" href="index.php?dl=belgelendirme_basvuru_ekleri/'.$basvuru_docs[0][EVRAK_ID].'/DOCS/'.$belge[$ii].'/'.$basvuru_docs[$taharray[$j]][BELGE_ADI].'"><button type="button">Dosya İncele</button></a></td>';
		                echo '<td style="text-align:center; padding-right: 20px;">'.$basvuru_docs[$taharray[$j]]["BAS_TARIH"].'</td>';
		                echo '<td style="text-align:center;"><input type="button" name="sil" id="silButton" value="Sil"/></td>';
						echo '</tr>';
					}
					
				}
			}
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<!-- <input type="text" name="adet" class="" id="kac<?php echo $belge[$ii]; ?>" value="1" style="width: 20px;"/> -->
		<?php if(count($taharray)>0){
                    if($durum == 0 ||$durum == 2 || $durum == 6 || $durum == 10 || $durum == 14 || $this->canEdit){?>
			<input style="display: none;" type="button" name="satirEkleButton" id="ekle_<?php echo $belge[$ii]; ?>" class="satirEkle" value="Yeni satır ekle"/>
                <?php }}
		else{if($durum == 0 ||$durum == 2 || $durum == 6 || $durum == 10 || $durum == 14 || $this->canEdit){?>
			<input type="button" name="satirEkleButton" id="ekle_<?php echo $belge[$ii]; ?>" class="satirEkle" value="Yeni satır ekle"/>
                <?php }}?>
<div class="cfclear">&nbsp;</div>	
</div>
<br>
<br>
<?php 
}
?>

<br>
<hr>
<div class="form_item" style="padding-top: 25px; font-weight:bold;">NOT :
	<p style="font-style:italic; font-weight:bold;">1-)1., 7. ve 8. maddeler için MYK tarafından belirlenen formları kullanılacaktır.</p>
	<p style="font-style:italic; font-weight:bold;">2-)Kuruluşlar, başvuru formu ve eklerini kuruluşun antetli kağıdına yazılmış bir yazı ile MYK'ya ileteceklerdir.</p>
	<div class="cfclear">&nbsp;</div>
</div>
<hr>
<div class="form_item" style="padding-top: 25px; font-style:italic;">
	<p>[7]-Kamu idarelerindeki ilgili ilişkilerin tatbik imzalarının resmi yazı ekinde gönderilmesi yeterlidir.</p>
	<p>[8]-17., 18. ve 19.maddelerdeki belgeler kamu idarelerinden talep edilmemektedir.</p>
	<p>[9]-20. , 21. 23. ve 24. maddelerdeki belgeler zorunlu değildir.</p>
	<div class="cfclear">&nbsp;</div>
</div>
</form>

<script type="text/javascript">
	
jQuery(document).ready(function(){

	jQuery('#silButton').live('click', function(e){
		e.preventDefault();

		if(jQuery(this).attr('class')){
			var tur = jQuery(this).attr('class').split('_');
			tur = tur[1];
			jQuery('#tr_'+tur).remove();
			jQuery('#kaydet').remove();
			jQuery('#'+tur+'_div').append('<input id="ekle_'+tur+'" class="satirEkle" type="button" value="Yeni satır ekle" name="satirEkleButton">');
		}else{
			var anaId = jQuery(this).closest('tr').attr('id');
			anaId = anaId.split('_');
			
			if(confirm('Bu belgeyi silmek istediğinizden emin misiniz?')){
				jQuery.ajax({
					type:'POST',
					url:'index.php?option=com_belgelendirme_basvur&task=ajaxDelBasvuruDocs&format=raw',
					data:'evrak_id=<?php echo $_GET['evrak_id']?>'+'&tur='+anaId[1],
					success:function(data){
						window.location.reload();
					}
				});
			}
		}
	});

	
 jQuery(".satirEkle").live("click", function(e){
	 e.preventDefault();
	if(jQuery('#kaydet').length>0){
		alert('Önceden yeni dosya eklemek için bir bölüm açtınız. O bölümü tamamlamadan veya silmeden yeni dosya ekleyemezsiniz.');
	}else{
		var ekle = jQuery(this).attr("id").split('_');
		ekle = ekle[1];
		var eklearray = new Array("onbasvuru", "yetkibasvuru", "onsozlesme", "yetsozlesme");
		var ekkle = (eklearray.indexOf(ekle));
		
			if(ekle == "onsozlesme"){
				jQuery("#tablo_"+ekle).append('<tr id="tr_'+ekle+'">'+
						'<td style="text-align:center;"><input type="file" name="dosya['+ekle+']" class="'+ekle+' required" id="dosyaclass-'+ekkle+'-0" value="" size="50px;"/></td>'+
						'<td style="text-align:center;"><input class="pickdatetime required" type="text" name="tarih['+ekle+'][]"   value="" size="20px;"/></td>'+
						'<td style="text-align:center;"><input class="pickdatetime required" type="text" name="tarih['+ekle+'][]"   value="" size="20px;"/></td>'+
						'<td style="text-align:center;"><input id="silButton" class="sil_'+ekle+'" type="button" value="Sil" name="sil"/></td>'+
						'</tr>');
				jQuery('#'+ekle+'_div').append('<input type="button" id="kaydet" value="Kaydet"/>');
				}
			else if(ekle == "yetsozlesme"){
                            jQuery("#tablo_"+ekle).append('<tr id="tr_'+ekle+'">'+
						'<td style="text-align:center;"><input type="file" name="dosya['+ekle+']" class="'+ekle+' required" id="dosyaclass-'+ekkle+'-0" value="" size="50px;"/></td>'+
						'<td style="text-align:center;"><input class="pickdatetime required" type="text" name="tarih['+ekle+'][]"   value="" size="20px;"/></td>'+
						'<td style="text-align:center;"><input id="silButton" class="sil_'+ekle+'" type="button" value="Sil" name="sil"/></td>'+
						'</tr>');
                            jQuery('#'+ekle+'_div').append('<input type="button" id="kaydet" value="Kaydet"/>');
            }
			else{
				jQuery("#tablo_"+ekle).append('<tr id="tr_'+ekle+'">'+
						'<td style="text-align:center;"><input type="file" name="dosya['+ekle+']" class="'+ekle+' required" id="dosyaclass-'+ekkle+'-0" value="" size="50px;"/></td>'+
						'<td style="text-align:center;"><input class="pickdatetime required" type="text" name="tarih['+ekle+'][]"   value="" size="20px;"/></td>'+
						'<td style="text-align:center;"><input id="silButton" class="sil_'+ekle+'" type="button" value="Sil" name="sil"/></td>'+
						'</tr>');
				jQuery('#'+ekle+'_div').append('<input type="button" id="kaydet" value="Kaydet"/>');
			}
			jQuery("input#ekle_"+ekle).remove();
	}
	});

	jQuery('#kaydet').live('click',function(e){
		e.preventDefault();
		var tur = jQuery(this).parent('div').attr('id').split('_');
		tur = tur[0];
		var hata = 0;
		jQuery.each(jQuery('input[name="tarih['+tur+'][]"]'),function(key,vall){
			if(vall.value.length == 0 || vall.value == ''){
				hata++;
			}
		});
		if(hata > 0){
			alert('Eklemek istediğiniz dosyanın tarih alanını boş bırakmayınız.');
		}else{
			jQuery('#BasvuruDocsEkle').submit();
		}
	});
});

 jQuery('.pickdatetime').live('hover',function(){
		jQuery(this).datepicker({
	        changeYear: true,
	        changeMonth: true
	     });
	});
</script>