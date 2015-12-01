<?php 
$il = $this->pm_il;
$sektor = $this->pm_sektor;
// $basvuru_alanlari = $this->basvuru_alanlari;
// $deneyim_tipleri = $this->deneyim_tipleri;
$uzman_bilgi=$this->kurulus;
foreach ($this->basvuru_sektor as $row){
// 	if ($row[DURUM]==1){
	$sektorlerim[]=$row[SEKTOR_ID];
// 	} else {
// 		$sektorlerim2[]=$row[SEKTOR_ID];
// 		$durum=2;
// 	}
} 
$basvuru_yeterlilik=$this->basvuru_yeterlilik;

if ($this->canEdit){

?>
<form
	onsubmit="return validate('ChronoContact_uzman_basvuru_t4')"
	action="index.php?option=com_uzman_basvur&amp;layout=basvuru_bilgi&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />


<?php 
}
echo $this->pageTree;
?>

<style>
td.ortala{
    text-align: center;
}
</style>
<div class="anaDiv text-center">
	<div class="divYan">
		<?php if(in_array(1, $this->BilgiOnay) && in_array(2, $this->BilgiOnay)){?>
		<button type="button" class="btn btn-xs btn-default" onclick="FuncDenetBilgiOnaylimi(true)">Denetçi</button>
		<?php }else{ ?>
		<button type="button" class="btn btn-xs btn-default" onclick="FuncDenetBilgiOnaylimi(false)">Denetçi</button>
		<?php } ?>
	</div>
	<div class="divYan">
		<?php if(in_array(3, $this->BilgiOnay) && in_array(4, $this->BilgiOnay)){?>
		<button type="button" onclick="FuncTeknikBilgiOnaylimi(true)" class="btn btn-xs btn-default">Teknik Uzman</button>
		<?php }else{ ?>
		<button type="button" onclick="FuncTeknikBilgiOnaylimi(false)" class="btn btn-xs btn-default">Teknik Uzman</button>
		<?php } ?>
	</div>
<!-- 	<div class="divYan"> -->
<!-- 		<a href="index.php?option=com_uzman_basvur&view=uzman_basvur&layout=moderator" class="btn btn-sm btn-default">Moderatör</a> -->
<!-- 	</div> -->
</div>
<div class="anaDiv font16">
	<p class="font18 fontBold">Denetçi Başvurusu;</p>
	<p><strong>MYK Uzman Havuzuna;</strong> MYK tarafından belgelendirme kuruluşlarına yönelik yapılan yetkilendirme, 
	gözetim ve kapsam genişletme gibi denetimlerde <strong>Baş Denetçi veya Denetçi</strong> olarak, en az 15 gün
	önceden haber verilmesi şartıyla, yılda 60 günü geçmemek kaydıyla, yurdun her yerinde görevlendirileceğimin farkında
	olarak, gereken denetçi niteliklerini taşıdımı ve denetimle ilgili görev ve sorumlulukları yerine getireceğimi 
	beyan ederek,<p>
</div>
<div class="anaDiv text-center">
	<?php if(in_array(1, $this->BilgiOnay)){
	$btnClass = 'btn-success';
	}else{
	$btnClass = 'btn-primary';
	} ?>
	<div class="divYan"><button type="button" class="font10 btn btn-xs <?php echo $btnClass;?>" onclick="OpenLightBox('#DenetNitModal')">DENETÇİNİN SAHİP OLMASI GEREKEN NİTELİKLER</button></div>
	<?php if(in_array(2, $this->BilgiOnay)){
	$btnClass = 'btn-success';
	}else{
	$btnClass = 'btn-primary';
	} ?>
	<div class="divYan"><button type="button" class="font10 btn btn-xs <?php echo $btnClass;?>" onclick="OpenLightBox('#DenetSorModal')">DENETÇİNİN / BAŞ DENETÇİNİN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI</button></div>
</div>
<div class="anaDiv text-center">
<?php if(in_array(1, $this->BilgiOnay) && in_array(2, $this->BilgiOnay)){?>
<p><button type="button" class="btn btn-xs btn-success" onclick="FuncDenetBilgiOnaylimi(true)"><strong>Denetimlerde Denetçi/Baş Denetçi Olarak Görev Yapmak Üzere Başvuru Yapmak İstiyorum.</strong></button></p>
<?php }else{ ?>
<p><button type="button" class="btn btn-xs btn-success" onclick="FuncDenetBilgiOnaylimi(false)"><strong>Denetimlerde Denetçi/Baş Denetçi Olarak Görev Yapmak Üzere Başvuru Yapmak İstiyorum.</strong></button></p>
<?php } ?>
</div>
<div class="anaDiv"><hr></div>

<div class="anaDiv font16">
	<p class="font18 fontBold">Teknik Uzman Başvurusu;</p>
	<p><strong>MYK Uzman Havuzuna;</strong> MYK tarafından belgelendirme kuruluşlarına yönelik yapılan yetkilendirme, 
	gözetim ve kapsam genişletme gibi denetimlerde ve mesleki uzmanlık gerektiren diğer konularda <strong>Teknik Uzman</strong> 
	olarak, en geç 15 gün önceden haber verilmesi şartıyla, yılda 60 günü geçmemek kaydıyla, yurdun her yerinde 
	görevlendirilebileceğimin farkında olarak, gereken Teknik Uzman niteliklerini taşıdığımı ve denetimle ilgili görev ve 
	sorumlulukları yerine getireceğimi beyan ederek,</p>
</div>
<div class="anaDiv text-center">
	<?php if(in_array(3, $this->BilgiOnay)){
	$btnClass = 'btn-success';
	}else{
	$btnClass = 'btn-primary';
	} ?>
	<div class="divYan"><button type="button" class="font10 btn btn-xs <?php echo $btnClass;?>" onclick="OpenLightBox('#TeknikNitModal')">TEKNİK UZMANIN SAHİP OLMASI GEREKEN NİTELİKLER</button></div>
	<?php if(in_array(4, $this->BilgiOnay)){
	$btnClass = 'btn-success';
	}else{
	$btnClass = 'btn-primary';
	} ?>
	<div class="divYan"><button type="button" class="font10 btn btn-xs <?php echo $btnClass;?>" onclick="OpenLightBox('#TeknikSorModal')">TEKNİK UZMANIN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI</button></div>
</div>
<div class="anaDiv text-center">
	<?php if(in_array(3, $this->BilgiOnay) && in_array(4, $this->BilgiOnay)){?>
		<p><button type="button" onclick="FuncTeknikBilgiOnaylimi(true)" class="btn btn-xs btn-success"><strong>Denetimlerde Teknik Uzman Olarak Görev Almak Üzere Başvuru Yapmak İstiyorum.</strong></button></p>
	<?php }else{ ?>
	<p><button type="button" onclick="FuncTeknikBilgiOnaylimi(false)" class="btn btn-xs btn-success"><strong>Denetimlerde Teknik Uzman Olarak Görev Almak Üzere Başvuru Yapmak İstiyorum.</strong></button></p>
	<?php } ?>
</div>
<script type="text/javascript">
function CloseLightBox(ele){
	jQuery(ele).trigger('close');
	return true;
}

function OpenLightBox(ele){
	jQuery(ele).lightbox_me({
		overlaySpeed: 250,
		lightboxSpeed: 300,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

function FuncBilgiOnay(uId,bilgi){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_uzman_basvur&task=BilgilendirmeOnayla&format=raw",
		data:"uId="+uId+"&bilgi="+bilgi
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			alert('Okundu ve Onaylandı.');
			window.location.reload();
		}else{
			alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
			window.location.reload();
		}
	});
}

function FuncDenetBilgiOnaylimi(durum){
	if(durum){
		window.location.href = "index.php?option=com_uzman_basvur&view=uzman_profile&layout=denetci&tc_kimlik=<?php echo $this->evrak_id;?>";
	}else{
		jQuery('#UyariContent').html("Denetçi Başvurusu yapmak için öncelikle, 'DENETÇİNİN SAHİP OLMASI GEREKEN NİTELİKLER' ve 'DENETÇİNİN / BAŞ DENETÇİNİN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI' bilgilerini okuyup, onaylamanız gerekmektedir.");
		OpenLightBox('#UyariModal');
	}
}

function FuncTeknikBilgiOnaylimi(durum){
	if(durum){
		window.location.href = "index.php?option=com_uzman_basvur&view=uzman_profile&layout=teknik_uzman&tc_kimlik=<?php echo $this->evrak_id;?>";
	}else{
		jQuery('#UyariContent').html("Teknik Uzman Başvurusu yapmak için öncelikle, 'TEKNİK UZMANIN SAHİP OLMASI GEREKEN NİTELİKLER' ve 'TEKNİK UZMANIN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI' bilgilerini okuyup, onaylamanız gerekmektedir.");
		OpenLightBox('#UyariModal');
	}
}

function UyariLightBox(sonra){
	if(sonra){
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7},
	        onClose: OpenLightBox(sonra)
	    });
	}else{
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	}
}
</script>

<div id="UyariModal" class="bg-danger" style="color:#ffffff; width: 600px; min-height:100px; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 text-center fontBold">
		Uyarı
	</div>
	<div class="anaDiv font16 fontBold" id="UyariContent">
		
	</div>
	<div class="anaDiv text-right">
		<button type="button" class="btn btn-xs btn-default" onclick="CloseLightBox('#UyariModal')">Kapat</button>
	</div>
</div>

<div id="DenetNitModal" style="width:800px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font18 hColor text-center">
		DENETÇİNİN SAHİP OLMASI GEREKEN NİTELİKLER
	</div>
	
	<div class="anaDiv font16">
		<p>Denetçi olarak görevlendirilecek kişilerin;</p> 
		<p>a) En az lisans düzeyinde yükseköğrenim görmüş olması,</p>
		<p>b) Kurum mevzuatı, ulusal yeterlilik sistemi ve bileşenleri, personel belgelendirme, uygunluk değerlendirme faaliyetleri ile yönetim sistemleri hakkında bilgi sahibi olduğunu gösterir kanıtlara sahip olması ya da sayılan konularda Kurum tarafından belirlenen ilgili eğitimleri başarı ile tamamlaması,</p> 
		<p>c) 40 saatlik baş denetçi/denetçi eğitimini başarıyla tamamlamış olması ve akredite bir kuruluş tarafından denetçi olarak belgelendirilmiş olması veya ulusal / uluslararası geçerliliğe sahip denetçi/baş denetçi belgesine sahip olması,</p>
		<p>ç) Kurum dışından görevlendirilenlerin; en az 5 yıllık mesleki deneyime sahip olması, belgelendirme kuruluşu denetimleri, uygunluk değerlendirme faaliyetleri veya yönetim sistemleri alanlarında toplamda 20 günden az olmamak kaydıyla asgari 5 denetimi başarı ile tamamlaması, 9 günden az olmamak kaydıyla en az 3 Kurum denetiminde başka bir başdenetçi ile birlikte görev alması,</p>
		<p>d) Kurum içinden görevlendirilenlerin; Kurumda 3 yılını (b) bendinde sayılan teknik hususlarda çalışarak tamamlamış olması ve Kurum denetimlerinde yardımcı denetçi olarak 20 günden az olmamak kaydıyla asgari 5 denetimi başarı ile tamamlaması,</p>
		<p>e) Sınav ve Belgelendirme Dairesi Başkanlığınca yapılacak değerlendirmeye göre görevlendirilmeye uygun görülmesi,</p>
		<p>gereklidir.</p>
	</div>
	<div class="anaDiv">
		<?php if(!in_array(1, $this->BilgiOnay)){ ?>
		<div class="divYan"><button type="button" class="btn btn-sm btn-success" onclick="FuncBilgiOnay(<?php echo $this->evrak_id;?>,1)">Okudum ve Onaylıyorum</button></div>
		<?php }else{ ?>
		<div class="divYan text-success font16 fontBold">Okundu ve Onaylandı</div>
		<?php } ?>
		<div class="divYan fRight"><button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#DenetNitModal')">Kapat</button></div>
	</div>
</div>

<div id="DenetSorModal" style="width:800px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font18 hColor text-center">
		DENETÇİNİN/ BAŞ DENETÇİNİN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI
	</div>
	<div class="anaDiv font16">
	<ol type="a">
		<li>Denetimlerde MYK’yi temsil etmek ve denetimlerin MYK denetim mevzuatına uygun gerçekleşmesini sağlamak,</li>
		<li>Denetim öncesi kendisine teslim edilen dokümanları incelemek,</li>
		<li>Denetimde izlenecek sınavların belirlenmesine yardımcı olmak,</li>
		<li>Denetimi yönetmek ve gerçekleştirmek,</li>
		<li>Denetim ekibini temsil etmek.</li>
		<li>Denetimin gerçekleştirileceği ofis ve sahalarda iş sağlığı ve güvenliği kurallarına uyulmasını; denetim ekibinin sağlığını ve güvenliğini koruyucu önlemlerin alınmasını sağlamak, gerekli önlemler alınmadığı taktirde denetimi sonlandırmak,</li>
		<li>Denetim ekibi arasında görev paylaşımı yapmak ve görevlerin yerine getirilip getirilmediğini takip etmek,</li>
		<li>Açılış konuşmasını yapmak ve açılış toplantısını yönetmek,</li>
		<li>Denetim ekibinde teknik uzmanın bulunduğu durumlarda teknik uzman(lar)ın görevleri ile ilgili bilgilendirme yapmak,</li> 
		<li>Kuruluş dokümanlarının, kalite yönetim sisteminin, organizasyon yapısının, personel dosyalarının ve altyapı imkanlarının ulusal yeterlilik sistemine, MYK mevzuatına ve ilgili usul ve esaslara uygunluğunu kontrol etmek,</li>
		<li>Kuruluşun teknik imkanlarının, sınav yeri koşullarının, personel altyapısının organizasyonel yapısının ve denetim esnasında gerçekleştirilen sınavın ilgili ulusal yeterliliklere uygunluğunu kontrol etmek,</li>
		<li>Uygunsuzlukları tespit etmek, takip denetimine karar vermek, uygunsuzluk raporlarını hazırlamak,</li>
		<li>Denetim sonuç raporunun hazırlanmasına katkıda bulunmak, </li>
		<li>Kapanış toplantısını yapmak, uygunsuzluk raporlarını Kuruluşa okuyarak açıklamak,</li> 
		<li>Kuruluş tarafından gönderilen destekleyici dokümanları ve uygunsuzluk kapatma formlarını inceleyerek uygunsuzlukların kapatılıp kapatılmadığına karar vermek,</li>
		<li>Yardımcı denetçi tarafından hazırlanan “Denetim Formu”nu inceleyerek onaylamak ve imzalamak,</li>
		<li>MYK Web Portalında baş denetçi tarafından gerçekleştirilmesi gereken işlemleri gerçekleştirmek.</li>
	</ol>
	</div>
	<div class="anaDiv">
		<?php if(!in_array(2, $this->BilgiOnay)){ ?>
		<div class="divYan"><button type="button" class="btn btn-sm btn-success" onclick="FuncBilgiOnay(<?php echo $this->evrak_id;?>,2)">Okudum ve Onaylıyorum</button></div>
		<?php }else{ ?>
		<div class="divYan text-success font16 fontBold">Okundu ve Onaylandı</div>
		<?php } ?>
		<div class="divYan fRight"><button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#DenetSorModal')">Kapat</button></div>
	</div>
</div>

<div id="TeknikNitModal" style="width:800px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font18 hColor text-center">
		TEKNİK UZMANIN SAHİP OLMASI GEREKEN NİTELİKLER 
	</div>
	<div class="anaDiv font16">
		<p>a) En az lise ve dengi seviyede eğitim sahibi olması,</p>
		<p>b) Denetime konu ulusal yeterlilik(ler)te tanımlanan değerlendirici ölçütlerini sağlaması,</p>
		<p>c) Ulusal yeterlilik(ler), , öğrenme kazanımlarına dayalı ölçme-değerlendirme sistemi ve MYK denetimlerinde dikkat edilecek hususlarla ilgili eğitim almış olması</p> 
		<p>gereklidir.</p>
	</div>
	<div class="anaDiv">
		<?php if(!in_array(3, $this->BilgiOnay)){ ?>
		<div class="divYan"><button type="button" class="btn btn-sm btn-success" onclick="FuncBilgiOnay(<?php echo $this->evrak_id;?>,3)">Okudum ve Onaylıyorum</button></div>
		<?php }else{ ?>
		<div class="divYan text-success font16 fontBold">Okundu ve Onaylandı</div>
		<?php } ?>
		<div class="divYan fRight"><button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#TeknikNitModal')">Kapat</button></div>
	</div>
</div>

<div id="TeknikSorModal" style="width:800px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font18 hColor text-center">
		TEKNİK UZMANIN DENETİMLE İLGİLİ GÖREV VE SORUMLULUKLARI 
	</div>
	<div class="anaDiv font16">
		<ol type="a">
			<li>Denetim öncesi kendisine teslim edilen dokümanları ve denetim gündeminde yer alan ulusal yeterlilik(ler)i incelemek,</li>
			<li>Kuruluş soru bankasının ve diğer sınav materyalinin ilgili ulusal yeterlilik(ler)e uygunluğunu incelemek,</li>
			<li>Kuruluş değerlendiricilerinin, karar vericilerinin ve program komitesi üyelerinden en az birinin ilgili ulusal yeterlilik(ler)de belirtilen değerlendirici ölçütlerini sağlayıp sağlamadığını kontrol etmek,</li>
			<li>Sınav yerinin, sınav koşullarının ve sınavla ilgili diğer şartların ilgili ulusal yeterlilik(ler)e uygunluğunu denetlemek,</li>
			<li>Sınav ve belgelendirme süreçlerine ilişkin bulgularını diğer denetim ekibi üyeleri ile paylaşmak,</li>
			<li>Denetim sonrası değerlendirme raporlarını hazırlamak ve denetim ekibi ile paylaşmak,</li>
			<li>Kendi görev alanları ile uygunsuzluk raporlarının yazılmasına katkıda bulunmak.</li>
			<li>Uygunsuzluklara yönelik kuruluş tarafından kendi alanı ile ilgili gönderilen düzeltici faaliyetleri incelemek ve faaliyetlerin uygun olup olmadığını raporlamak,</li>
		</ol>
	</div>
	<div class="anaDiv">
		<?php if(!in_array(4, $this->BilgiOnay)){ ?>
		<div class="divYan"><button type="button" class="btn btn-sm btn-success" onclick="FuncBilgiOnay(<?php echo $this->evrak_id;?>,4)">Okudum ve Onaylıyorum</button></div>
		<?php }else{ ?>
		<div class="divYan text-success font16 fontBold">Okundu ve Onaylandı</div>
		<?php } ?>
		<div class="divYan fRight"><button type="button" class="btn btn-sm btn-danger" onclick="CloseLightBox('#TeknikSorModal')">Kapat</button></div>
	</div>
</div>