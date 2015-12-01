<?php 
$user = &JFactory::getUser();
$durum = $this->durum;
$deger = $this->degerlen;
$yeterlilikler = $this->pm_kayitli_yet;
$basvuru_ekleri = $this->basvuru_ekleri;
$basekuzun = count($basvuru_ekleri);
$belge = array("taahutname","dekont","organizasyonsema","surecrehber","sertifikaornek","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","akreditasyonbelge","akreditasyonrapor","kurdegkayit","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
$belgeAciklama = array("1. Taahhütname *",
"2. Yetkilendirilme başvurusu masraf karşılığının yatırıldığına dair dekont *",
"3. Kurum/kuruluş organizasyon şeması *",
"4. Sınav ve belgelendirme süreçleriyle ilgili el kitabı, rehber ve prosedürler *",
"5. Yetkilendirilme talep edilen yeterliliklerle ilgili düzenlenen sertifika örnekleri",
"6. Sınavlarda görev alacak kişilerin listesi",
"7. Sınavlarda görevlendirilecekler ile belgelendirme süreçlerinde görev alacak diğer kişilere ilişkin bilgi formu",
"8. Sınavlarda görevlendirilecekler ve belgelendirme süreçlerinde görev alacak diğer kişiler ile yönetmeliğin 17. maddesinin (b) ve (c) bentlerinde tanımlanan kişiler için yönetmelikteki şartları sağladığına dair kişisel beyan",
"9. Belgelendirme faaliyetlerinde görev alan personel ve yöneticilere ilişkin görev tanımları *",
"10. Başvuru sahibi kurum/kuruluşların kurucu metinleri (şirket ana sözleşmesi, dernek/vakıf tüzüğü, kurucu kanunlar, vb.) *",
"11. Dışarıdan hizmet sağlayan kuruluşun yönetmelik hükümlerine ve akreditasyon şartlarına uygunluğu ile ilgili denetim raporları (Dışarıdan hizmet alımı yapan kuruluşlar için)",
"12. Sınav ve belgelendirme ile ilgili dışarıdan sağlanan hizmetlere ilişkin ilgili kuruluş(lar)la yapılan olan protokol/sözleşme örnekleri",
"13. Akreditasyon belgesi ve akreditasyon kapsamını gösterir belge",
"14. Akreditasyona ilişkin denetim raporu veya uygunsuzluk raporları suretleri *",
"15. Ticaret sicil gazetesi şirket kuruluş ve değişiklik kayıtları (şirketler ve kooperatifler için) *",
"16. Noter onaylı imza sirküleri[7] (Kuruluşu temsil ve ilzama yetkili kişiler ile kuruluş tarafından düzenlenen sertifikaları imzalamaya yetkili kişiler için) *",
"17. Son üç yıla ilişkin bilanço, vergi levhası suretleri[8] *",
"18. SGK’dan alınacak sosyal güvenlik prim borcu bulunmadığını gösterir yazı[8] *",
"19. Vergi borcu bulunmadığını göstermek üzere bağlı bulunulan vergi dairesinden alınacak yazı[8] *",
"20. Kuruluşu tanıtıcı materyal[9]",
"21. Kuruluş Misyon&Vizyon[9]",
"22. Kuruluşun sahip olduğu ürün hizmet veya kalite belgeleri[9]",
"23. Konuyla ilgili ulusal veya uluslararası kuruluşlarca desteklenen projeler[9]",
"24. Kuruluş ile ilgili ilave edilmek istenen ek dokümantasyon[9]");
?>

<form
	onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
	action="index.php?option=com_belgelendirme_basvur&amp;layout=ek2&amp;task=belgelendirmeKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_belgelendirme_basvuru_t3"
	name="ChronoContact_belgelendirme_basvuru_t3">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />

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
				<tr>
					<th>Belge(ler)</th>
					<th class="sil" style="width:20px;">Sil</th>
				
				</tr>
			</thead>
			<tbody id="tablo_<?php echo $belge[$ii];?>">
			<?php
			$taharray = array();
			for($i=0; $i<$basekuzun; $i++){
				if($basvuru_ekleri[$i][BELGE_TURU]==$belge[$ii]){
					array_push($taharray,$i);
				}
			}
			
			if(count($taharray)>0){
				for($j=0; $j<count($taharray); $j++)
				{
				
					echo '<tr id="'.$basvuru_ekleri[$taharray[$j]][TARIH].'_'.$basvuru_ekleri[$taharray[$j]][BELGE_TURU].'">';
	                echo '<td style="text-align:center;">'.$basvuru_ekleri[$taharray[$j]][BELGE_ADI].'<input type="button" value="Dosya İncele" onClick="window.open('."'index.php?dl=belgelendirme_basvuru_ekleri/".$basvuru_ekleri[0][EVRAK_ID]."/".$belge[$ii]."/".$basvuru_ekleri[$taharray[$j]][BELGE_ADI]."'".')" style="margin-left:10px;"/></td>';
	                if($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14 || $this->canEdit){
	                	echo '<td style="text-align:center;"><input type="button" name="sil" class="dosyaclass-'.$ii.'-'.$j.'" id="silButton" value="Sil"/></td>';
	                }else{
	                	echo '<td></td>';
	                }
	                //echo '<td style="width:2px;"><input type="hidden" name="belgeadi[]" class="'.$belge[$ii].'" id="belge-'.$ii.'-'.$j.'" value="'.$belge[$ii].'" style="width:1px;" /></td>';
					echo '</tr>';
				
				}
			}
//			if(isset($deger) && $ii == 5){
//				$row = 0;
//				foreach($deger as $tows){
//					$row++;
//					echo '<tr id="dosyaclass-5-'.$row.'">';
//					echo '<td style="text-align:center;"><input type="text" style="width: 300px;" value="'.$tows["YETERLILIK_ADI"].'-'.$tows["SEVIYE_ADI"].'"  readonly/><input type="hidden" name="yeterlilik[]" value="'.$tows["YETERLILIK_ID"].'"  readonly/></td>';
//					echo '<td style="text-align:center;"><input type="text" name="degerlendirici[]"  style="width: 300px;" value="'.$tows["DEGERLENDIRICI"].'"  readonly/></td>';
//					echo '<td style="text-align:center;"><input type="button" name="sil" class="dosyaclass-'.$ii.'-'.$row.'" id="silButton" value="Sil"/></td>';
//					echo '</tr>';
//				}
//			}
			
			
			/*else{
				echo '<tr id="dosyaclass-'.$ii.'-0">';
				echo '<td><input type="file" name="dosya['.$belge[$ii].'][]" class="'.$belge[$ii].'" id="dosya-'.$ii.'-0" style="width: 210px;" value=""/></td>';
				echo '<td style="text-align:center;"><input type="button" name="sil" class="dosyaclass-'.$ii.'-0" id="silButton" value="Sil"/></td>';
				echo '</tr>';
			}*/
			
			?>
			</tbody>
		</table>
		</div>
    <?php if($ii == 5){ ?>
<!--    <div class="cfclear" style="height:20px;">&nbsp;</div>
    <input type="button" id="DegerKaydet" value="Kaydet"/>-->
    <?php }if($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14 || $this->canEdit){?>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<input type="button" name="satirEkleButton" id="<?php echo $belge[$ii]; ?>" class="satirEkle" value="Yeni satır ekle"/>
<div class="cfclear">&nbsp;</div>	
</div>
<br>
<br>
<?php 
}
    }
?>

<br>
<hr>
<div class="form_item" style="padding-top: 25px; font-weight:bold;">NOT :
	<p style="font-style:italic; font-weight:bold;">1. 1., 7. ve 8. maddeler için MYK tarafından belirlenen formları kullanılacaktır.</p>
	<p style="font-style:italic; font-weight:bold;">2. Kuruluşlar, başvuru formu ve eklerini kuruluşun antetli kağıdına yazılmış bir yazı ile MYK'ya ileteceklerdir.</p>
	<p style="font-style:italic; font-weight:bold;">3. * Sunulması zorunlu belgeleri ifade eder.</p>
        <p style="font-style:italic; font-weight:bold;">4. 6. madde de Yeterlilik Kodu, Yeterlilik Adı, Değerlendirici T.C. Kimlik No, Değerlendirici Adı ve Değerlendirici Soyadı bilgilerini içeren döküman yüklenmelidir.</p>
	<div class="cfclear">&nbsp;</div>
</div>
<hr>
<div class="form_item" style="padding-top: 25px; font-style:italic;">
	<p>[7]-Kamu idarelerindeki ilgili ilişkilerin tatbik imzalarının resmi yazı ekinde gönderilmesi yeterlidir.</p>
	<p>[8]-17., 18. ve 19.maddelerdeki belgeler kamu idarelerinden talep edilmemektedir.</p>
	<p>[9]-20., 21., 22., 23. ve 24. maddelerdeki belgeler zorunlu değildir.</p>
	<div class="cfclear">&nbsp;</div>
</div>
</form>
<script type="text/javascript">
	
jQuery(document).ready(function() {

    jQuery('#silButton').live('click', function() {
        if(jQuery(this).closest('tr').children('td').children('input[type="file"]').length == 1){
            jQuery(this).closest('tr').remove();
        }
        else{
            var id = jQuery(this).closest('tr').attr('id');
            id = id.split('_');
            var tarih = id[0];
            var belge = id[1];
            if(confirm('Bu belgeyi silmek istediğinizden emin misiniz?')){
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_belgelendirme_basvur&task=belgelendirmeEkSil",
                    data:'tarih='+tarih+'&belge='+belge+'&evrak_id=<?php echo $this->evrak_id;?>',
                    success: function (data) {
                        jQuery('#loaderGif').lightbox_me({
                            centered: true
                        });
                        window.location.reload();
                    }
                });
            }
        }    
    });

    jQuery('#DegerKaydet').live('click',function(e){
        if(jQuery('input[type="file"]').length > 0){
             alert('Önceden yeni dosya eklemek için bir bölüm açtınız. O bölümü tamamlamadan veya silmeden yeni dosya ekleyemezsiniz.');
        }
        else{
            jQuery('#ChronoContact_belgelendirme_basvuru_t3').submit(); 
        }
    });

    jQuery(".satirEkle").live("click", function(){
     if(jQuery('input[type="file"]').length > 0){
        alert('Önceden yeni dosya eklemek için bir bölüm açtınız. O bölümü tamamlamadan veya silmeden yeni dosya ekleyemezsiniz.');
     }
     else{
		var ekle = jQuery(this).attr("id");
		var eklearray = new Array("taahutname","dekont","organizasyonsema","surecrehber","sertifikaornek","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","akreditasyonbelge","akreditasyonrapor","kurdegkayit","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
		var ekkle = (eklearray.indexOf(ekle));
		var kac = jQuery("#kac"+ekle).val();
		var adet = jQuery("."+ekle).length;
		var kac = parseInt(kac);
		var kac = kac + adet;
//		for(adet; adet<kac; adet++){
//			if(ekle == "gorevliliste"){
//				jQuery("#tablo_"+ekle).append('<tr id="dosyaclass-'+ekkle+'-'+adet+'"><td style="text-align:center;"><select name="yeterlilik[]">'+
//					<?php echo "'";
						$ekle = ''; 
						foreach($yeterlilikler as $cows){
							$ekle .= '<option value ="'.$cows["YETERLILIK_ID"].'">'.$cows["YETERLILIK_ADI"].'-'.$cows["SEVIYE_ADI"].'</option>';
						}
						echo $ekle;
						echo "'";
						?>//
//						+'</select></td><td style="text-align:center;"><input type="text" name="degerlendirici[]" value=""/></td><td style="text-align:center;"><input id="silButton" class="dosyaclass-'+ekkle+'-'+adet+'" type="button" value="Sil" name="sil"/></td></tr>');
//				}
//			else{
				jQuery("#tablo_"+ekle).append('<tr id="dosyaclass-'+ekkle+'-'+adet+'"><td style="text-align:center;"><input type="file" name="dosya['+ekle+']" class="'+ekle+'" id="dosyaclass-'+ekkle+'-'+adet+'" value="" size="50px;"/> <button id="ekYukle">Yükle</button></td><td style="text-align:center;"><input id="silButton" class="dosyaclass-'+ekkle+'-'+adet+'" type="button" value="Sil" name="sil"/></td></tr>');
//			}
//		}
        }	
   });
        
        jQuery('#ekYukle').live('click',function(e){
            e.preventDefault();
            
            jQuery('#ChronoContact_belgelendirme_basvuru_t3').submit();
            var cas = 2;
        });
        
});

</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>