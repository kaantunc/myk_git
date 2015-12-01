<?php 
$user = &JFactory::getUser();
$basvuru_ekleri = $this->basvuru_ekleri;
$basekuzun = count($basvuru_ekleri);
$belge = array("taahutname","dekont","organizasyonsema","surecrehber","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","kurdegkayit","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
$belgeAciklama = array("1. Taahhütname",
"2. Dekont",
"3. Kurum/kuruluş organizasyon şeması",
"4. Akreditasyon süreçleriyle ilgili el kitabı, rehber ve prosedürler",
"5. Akreditasyon faaliyetlerinde görev alacak kişilerin listesi",
"6. Akreditasyon faaliyetlerinde görev alacak diğer kişilere ilişkin bilgi formu",
"7. Akreditasyon faaliyetlerinde görevlendirilecekler ve Akreditasyon süreçlerinde görev alacak diğer kişiler ile yönetmeliğin 17. maddesinin (b) ve (c) bentlerinde tanımlanan kişiler için yönetmelikteki şartları sağladığına dair kişisel beyan.",
"8. Akreditasyon faaliyetlerinde görev alan personel ve yöneticilere ilişkin görev tanımları",
"9. Başvuru sahibi kurum/kuruluşların kurucu metinleri (şirket ana sözleşmesi, dernek/vakıf tüzüğü, kurucu kanunlar, vb.)",
"10. Dışarıdan hizmet sağlayan kuruluşun yönetmelik hükümlerine ve akreditasyon şartlarına uygunluğu ile ilgili denetim raporları (Dışarıdan hizmet alımı yapan kuruluşlar için)",
"11. Akreditasyon ile ilgili dışarıdan sağlanan hizmetlere ilişkin ilgili kuruluş(lar)la yapılan olan protokol/sözleşme örnekleri",
"12. Ticaret sicil gazetesi şirket kuruluş ve değişiklik kayıtları (şirketler ve kooperatifler için)",
"13. Noter onaylı imza sirküleri[1] (Kuruluşu temsil ve ilzama yetkili kişiler ile kuruluş tarafından düzenlenen sertifikaları imzalamaya yetkili kişiler için)",
"14. Son üç yıla ilişkin bilanço, vergi levhası suretleri[2]",
"15. SGK’dan alınacak sosyal güvenlik prim borcu bulunmadığını gösterir yazı",
"16. Vergi borcu bulunmadığını göstermek üzere bağlı bulunulan vergi dairesinden alınacak yazı",
"17. Kuruluşu tanıtıcı materyal",
"18. Kuruluş Misyon&Vizyon",
"19. Kuruluşun sahip olduğu ürün hizmet veya kalite belgeleri",
"20. Konuyla ilgili ulusal veya uluslararası kuruluşlarca desteklenen projeler",
"21. Kuruluş ile ilgili ilave edilmek istenen ek dokümantasyon");
?>

<form
	onsubmit="return validate('ChronoContact_akreditasyon_basvuru_t4')"
	action="index.php?option=com_akreditasyon_basvur&amp;layout=basvuru_ekleri&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_akreditasyon_basvuru_t4"
	name="ChronoContact_akreditasyon_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
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
				
					echo '<tr id="dosyaclass-'.$ii.'-'.$j.'">';
	                echo '<td style="text-align:center;"><input type="text" name="dosyaadi['.$belge[$ii].'][]" class="'.$belge[$ii].'" id="dosya-'.$ii.'-'.$j.'" style="width: 300px;" value="'.$basvuru_ekleri[$taharray[$j]][BELGE_ADI].'"  readonly/><a style="padding-left:10px;" href="index.php?dl=akreditasyon_bavuru_ekleri/'.$basvuru_ekleri[0][EVRAK_ID].'/'.$belge[$ii].'/'.$basvuru_ekleri[$taharray[$j]][BELGE_ADI].'">Dosya İncele</a></td>';
	                echo '<td style="text-align:center;"><input type="button" name="sil" class="dosyaclass-'.$ii.'-'.$j.'" id="silButton" value="Sil"/></td>';
	                echo '<td style="width:2px;"><input type="hidden" name="belgeadi[]" class="'.$belge[$ii].'" id="belge-'.$ii.'-'.$j.'" value="'.$belge[$ii].'" style="width:1px;" /></td>';
					echo '</tr>';
				
				}
			}
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
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<input type="text" name="adet" class="" id="kac<?php echo $belge[$ii]; ?>" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" id="<?php echo $belge[$ii]; ?>" class="satirEkle" value="Adet yeni satır ekle"/>
<div class="cfclear">&nbsp;</div>	
</div>
<br>
<br>
<?php 
}
?>


<!--KAYDET BAS-->
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<!--KAYDET SON-->
</form>

<script type="text/javascript">
	
jQuery(document).ready(function() {

	jQuery('#silButton').live('click', function() {
		var silno = jQuery(this).attr("class");
		jQuery("#"+silno).remove();	
	});

} );
 jQuery(".satirEkle").live("click", function(){
		var ekle = jQuery(this).attr("id");
		var eklearray = new Array("taahutname","dekont","organizasyonsema","surecrehber","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
		var ekkle = (eklearray.indexOf(ekle));
		var kac = jQuery("#kac"+ekle).val();
		var adet = jQuery("."+ekle).length;
		var kac = parseInt(kac);
		var kac = kac + adet;
		for(adet; adet<kac; adet++){
			jQuery("#tablo_"+ekle).append('<tr id="dosyaclass-'+ekkle+'-'+adet+'"><td style="text-align:center;"><input type="file" name="dosya['+ekle+'][]" class="'+ekle+'" id="dosyaclass-'+ekkle+'-'+adet+'" value="" size="50px;"/></td><td style="text-align:center;"><input id="silButton" class="dosyaclass-'+ekkle+'-'+adet+'" type="button" value="Sil" name="sil"/></td><td><input type="hidden" name="'+ekle+'[]" class="'+ekle+'" id="belge-'+ekkle+'-'+adet+'" value="'+ekle+'" /></td></tr>');
		}
		
	});

</script>
