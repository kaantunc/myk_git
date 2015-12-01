<?php 
echo $this->sayfaLink;
$denetimRapor = $this->denetimRapor;

$disabled = '';
if($denetimRapor && $denetimRapor['DURUM'] == 1){
	$disabled = 'disabled="disabled"';
}
?>
<form enctype="multipart/form-data"  method="post" 
action="index.php?option=com_denetim&task=raporKaydet&denetim_id=<?php echo $_REQUEST['denetim_id']; ?>">

<?php 

$seciliDenetim = $this->seciliDenetim;

$raporYukenebilirMi = ((strtotime($seciliDenetim['DENETIM_TARIHI_BASLANGIC'])-time()) > -24 * 60 * 60
		&&(strtotime($seciliDenetim['DENETIM_TARIHI_BASLANGIC'])-time()) < 30 * 24 * 60 * 60 ) ? false : true;

if($raporYukenebilirMi == true)
{
	
	$uploaderContent = '<div class="anaDiv font16 hColor">Denetim sonuç raporu form olarak ıslak imzalı olarak upload edilmelidir.<br>
	<input class="input-sm" type="file" name="dosya" id="dosya" style="width: 210px;"  />
	<input class="btn btn-xs btn-success" type="submit" value="kaydet" ></div>';
	
	if(strlen($seciliDenetim['DENETIM_RAPOR_PATH']) > 0)
	{
		echo '<div class="anaDiv" style="float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green; margin:10px; ">
			Bu denetime denetim raporu eklenmiş. 
			&nbsp;&nbsp;&nbsp; 
			| 
			&nbsp;&nbsp;&nbsp;
			<a style="color:green; text-decoration:underline;" href="index.php?dl=denetimler/'.$seciliDenetim['DENETIM_ID'].'/sonuc_belgeleri/'.$seciliDenetim['DENETIM_RAPOR_PATH'].'">İndirmek için tıklayınız</a>
			&nbsp;&nbsp;&nbsp; 
			| 
			&nbsp;&nbsp;&nbsp;
			<a style="color:green; text-decoration:underline;" href="#" id="formGosterButton">Değiştirmek için buraya tıklayınız</a> 
		</div>';
		
		echo '<div id="toggleableDiv" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';
		
		
	}else{
		echo $uploaderContent;
	}
?>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Organizasyon Yapısının Uygunluğu
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[ORG_YAP_UYG]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['ORG_YAP_UYG']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Eğitim Belgelendirme Ayrımı
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[EGI_BEL_AYR]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['EGI_BEL_AYR']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Kritik görevlerde sorumluluklar açık olarak belirlenmiş mi?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[KRI_GOR_SOR]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['KRI_GOR_SOR']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Belgelendirme faaliyetlerinin etkilenmemesine yönelik önlemler
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[BEL_FAA_ET]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['BEL_FAA_ET']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Kuruluşun yetki kapsamındaki faaliyetleri için yeterli (sayı ve nitelik olarak) insan kaynağının varlığı
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[KUR_YET_FAA]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['KUR_YET_FAA']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Sınav yapanlar ilgili ulusal yeterliliğin şartlarını sağlıyor mu?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[SIN_YAP_SART]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['SIN_YAP_SART']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Fiziki altyapı ve teknik donanım faaliyetleri gerçekleştirmeye uygun mudur?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[FIZ_ALT_TEK]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['FIZ_ALT_TEK']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Mali yapı faaliyetleri sürdürmeye uygun mudur?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[MAL_YAP_FAA]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['MAL_YAP_FAA']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Sınav belgelendirme süreçlerine ilişkin prosedürler ve uygulama uyumlu mudur?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[SIN_BEL_SUR]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['SIN_BEL_SUR']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Tutulan kayıtlar incelendi mi?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[TUT_KAY_INC]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['TUT_KAY_INC']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Gezici sınav birimleri ile gerçekleştirilen sınavlara ilişkin inceleme yapıldı mı? 
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[GEZ_SIN_BIR]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['GEZ_SIN_BIR']:'';?></textarea>
	</div>
</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		İtiraz ve şikayetlerin değerlendirilmesine ilişkin prosedür ve kayıtlar 
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[ITI_SIK_DEG]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['ITI_SIK_DEG']:'';?></textarea>
	</div>
</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Farklı sınav heyetleri arasındaki değerlendirmelerde uygulama birliğinin sağlanmasına yönelik önlemler 
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[FAR_SIN_HEY]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['FAR_SIN_HEY']:'';?></textarea>
	</div>
</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Mevcut sınav materyali ulusal yeterliliklerle uyumlu mudur?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[MEV_SIN_MET]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['MEV_SIN_MET']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Yapılan sınavlar ile sınav materyali tutarlı mıdır?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[YAP_SIN_MET]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['YAP_SIN_MET']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		İç denetim kayıtları var mıdır?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[IC_DEN_KAY]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['IC_DEN_KAY']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Dış denetimler ve sonuçları nelerdir?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[DIS_DEN]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['DIS_DEN']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Denetimde uygunsuzluk tespit edildi mi?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[DEN_UYG_TES]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['DEN_UYG_TES']:'';?></textarea>
	</div>

</div>

<div class="anaDiv" style="display:inline-flex">
	<div class="div40 font16 hColor">
		Varsa uygunsuzluklar kapatıldı mı?
	</div>
	<div class="div60">
		<textarea rows="3" class="inputW100" name="rapor[VAR_UYG_KAP]" <?php echo $disabled;?>><?php echo $denetimRapor?$denetimRapor['VAR_UYG_KAP']:'';?></textarea>
	</div>

</div>

<div class="anaDiv">
	<?php if($denetimRapor['DURUM'] != 1){ ?>
	<div class="divYan">
		<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Kaydet</button>
	</div>
	<?php } ?>
	
	<div class="divYan">
		<a target="_blank" href="index.php?option=com_denetim&view=denetim&layout=raporpdf&denetim_id=<?php echo $_REQUEST['denetim_id']; ?>" class="btn btn-sm btn-primary">Rapor PDF</a>
	</div>
	
	<?php if($denetimRapor && $denetimRapor['DURUM'] == 0){ ?>
	<div class="divYan fRight">
		<button type="button" class="btn btn-sm btn-warning" onclick="FuncRaporOnayla(<?php echo $_REQUEST['denetim_id']; ?>)"><i class="fa fa-paper-plane fa-lg"></i> Raporu Onayla ve Denetçilere Gönder</button>
	</div>
	<?php } ?>
	
	<?php if($denetimRapor && $denetimRapor['DURUM'] == 1){ ?>
	<div class="divYan fRight">
		<button type="button" class="btn btn-sm btn-danger" onclick="FuncRaporOnayIptal(<?php echo $_REQUEST['denetim_id']; ?>)">Raporun Onayını Geri Al</button>
	</div>
	<?php } ?>
	
</div>
<?php 
}
else
	echo '<div style="width:90%; float:left; border-top:3px solid red;
	border-bottom:3px solid red; padding:4px; background-color: #FFEEEE;
	color:red; margin:10px; ">
	Henüz denetim tarihi gelmemiş
		
			<br>
		
			<a style="color:red; text-decoration:underline;" href="index.php?option=com_denetim&layout=denetim_listele">GERİ</a>
		
		</div>';


?>
</form>


<script>
jQuery('#formGosterButton').live('click',function(e){
	e.preventDefault();
	
	jQuery('#toggleableDiv').toggle('slow');
});

function FuncRaporOnayla(dId){
	if(confirm('Denetim Raporunu onayladıktan sonra rapora müdahele edemezsiniz. Raporda düzeltme yapmak isterseniz tekrardan denetçi onayına sunmanız gerekmektedir.')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_denetim&task=DenetimRaporOnayla&format=raw",
	        data: "denetim_id="+dId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Rapor onaylandı ve Denetçilerin onayına sunuldu.');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}
	return false;
}

function FuncRaporOnayIptal(dId){
	if(confirm('Denetim Raporunun Onayını geri almanız durumunda denetçi onayları iptal edilecektir.')){
		jQuery.ajax({
			async:false,
	        type: 'POST',
	        url: "index.php?option=com_denetim&task=DenetimRaporOnayIptal&format=raw",
	        data: "denetim_id="+dId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Rapor onayı geri alındı ve Denetçilerin onayı iptal edildi.');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}
	return false;
}
</script>