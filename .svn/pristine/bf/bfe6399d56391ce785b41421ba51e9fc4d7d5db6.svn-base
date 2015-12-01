<?php 
$statistic = $this->statistic;
?>
<style>
<!--

.container{
	float:left;
}
.container .adv-table{
	float:left;
	width:48%;   
	margin:5px;
}
.container .adv-table .adv-table-head{
	padding: 5px 0 5px 0;
	dislay : inline;
}
.container .adv-table .adv-table-head .adv-table-title{
	float:left;
	font-weight: bold;
}
.container .adv-table .adv-table-head button{
	float:right;
}
.container table{
	width:100%;
}
.container table tr td:first-child{
	width:89%;
}
.container table tr td:last-child{
	width:11%;
	text-align:right;
<?php if($this->perm == false){?>
	display:none;
<?php }?>
}
-->
</style>
<div class="anaDiv hColor font20 text-center fontBold">
	MYK GENEL İSTATİSTİKLER
</div>
<form  id="statisticform" action="index.php?option=com_istatistik&view=istatistik&layout=default&task=savestatistics" enctype="multipart/form-data" method="post">
<div class="container">
		<div class="adv-table">
		  <div class="adv-table-head">
			  <div class="adv-table-title">
			  	ULUSAL MESLEK STANDARTLARI(UMS)
			  </div>
		   <?php if($this->istatistik_duzenleme_yetki){ ?>
			  <button class="edittable btn btn-xs btn-primary">Düzenle</button>
			  <button class="canceledit btn btn-xs btn-primary" style="display:none;">İptal</button>
		    <?php } ?>
		  </div>
		  <table class="display compact table table-hover table-bordered table-striped">
				<tbody>
					<tr>
						<td>UMS Hazırlama İşbirliği Protokolü Sayısı</td>
						<td detay="ums_kurulus_sayi_edit"><?php echo $statistic['ums_kurulus_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_kurulus_sayi"><?php echo $statistic['ums_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Protokoller Çerçevesinde Hazırlanacak UMS Sayısı(Resmi Gazete'de yayımlananlar dahil)</td>
						<td detay="ums_hazirlanacak_sayi_edit"><?php echo $statistic['ums_hazirlanacak_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_hazirlanacak_sayi"><?php echo $statistic['ums_hazirlanacak_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Çalışmaları Sürdürülen UMS Sayısı(Resmi Gazete'de yayımlananlar dahil)</td>
						<td detay="ums_calismaya_baslanilan_sayi_edit"><?php echo $statistic['ums_calismaya_baslanilan_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_calismaya_baslanilan_sayi"><?php echo $statistic['ums_calismaya_baslanilan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Resmi Gazetede Yayımlanan UMS Sayısı</td>
						<td detay="ums_resmi_gazetede_sayi_edit"><?php echo $statistic['ums_resmi_gazetede_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_resmi_gazetede_sayi"><?php echo $statistic['ums_resmi_gazetede_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Yürürlükten Kaldırılarak İptal Edilen UMS Sayısı</td>
						<td detay="ums_yururluktrn_kaldirilan_sayi_edit"><?php echo $statistic['ums_yururluktrn_kaldirilan_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_yururluktrn_kaldirilan_sayi"><?php echo $statistic['ums_yururluktrn_kaldirilan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Güncellenen UMS Sayısı</td>
						<td detay="ums_guncellenen_sayi_edit"><?php echo $statistic['ums_guncellenen_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_guncellenen_sayi"><?php echo $statistic['ums_guncellenen_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Tehlikeli ve Çok Tehlikeli İşlerde Yayımlanan UMS Sayısı</td>
						<td detay="ums_tehlikeli_islerde_sayi_edit"><?php echo $statistic['ums_tehlikeli_islerde_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_tehlikeli_islerde_sayi"><?php echo $statistic['ums_tehlikeli_islerde_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>İnşaat Sektöründe Yayımlanan UMS Sayısı</td>
						<td detay="ums_insaatta_yayinlanan_sayi_edit"><?php echo $statistic['ums_insaatta_yayinlanan_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="ums_insaatta_yayinlanan_sayi"><?php echo $statistic['ums_insaatta_yayinlanan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="adv-table">
		  <div class="adv-table-head">
			  <div class="adv-table-title">
			  	ULUSAL YETERLİLİKLER(UY)
			  </div>
		  <?php if($this->istatistik_duzenleme_yetki){ ?>
			  <button class="edittable btn btn-xs btn-primary">Düzenle</button>
			  <button class="canceledit btn btn-xs btn-primary" style="display:none;">İptal</button>
		   <?php } ?>
		  </div>
		  <table class="display compact table table-hover table-bordered table-striped">
				<tbody>
					<tr>
						<td>UY Hazırlama İşbirliği Protokolü Sayısı</td>
						<td detay="uy_kurulus_sayi_edit"><?php echo $statistic['uy_kurulus_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_kurulus_sayi"><?php echo $statistic['uy_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Protokoller Çerçevesinde Hazırlanacak UY Sayısı</td>
						<td detay="uy_hazirlanacak_sayi_edit"><?php echo $statistic['uy_hazirlanacak_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_hazirlanacak_sayi"><?php echo $statistic['uy_hazirlanacak_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Çalışmaları Sürdürülen UY Sayısı(Yönetim Kurulu tarafından onaylananlar dahil)</td>
						<td detay="uy_calismalari_surdurulen_sayi_edit"><?php echo $statistic['uy_calismalari_surdurulen_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_calismalari_surdurulen_sayi"><?php echo $statistic['uy_calismalari_surdurulen_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Onaylanan UY Sayısı</td>
						<td detay="uy_onaylanan_sayi_edit"><?php echo $statistic['uy_onaylanan_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_onaylanan_sayi"><?php echo $statistic['uy_onaylanan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Güncellenen UY Sayısı</td>
						<td detay="uy_guncellenen_sayi_edit"><?php echo $statistic['uy_guncellenen_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_guncellenen_sayi"><?php echo $statistic['uy_guncellenen_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Tehlikeli ve Çok Tehlikeli İşlerde Yayımlanan UY Sayısı</td>
						<td detay="uy_tehlikeli_islerde_sayi_edit"><?php echo $statistic['uy_tehlikeli_islerde_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_tehlikeli_islerde_sayi"><?php echo $statistic['uy_tehlikeli_islerde_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>İnşaat Sektöründe Yayımlanan UY Sayısı</td>
						<td detay="uy_insaatta_yayinlanan_sayi_edit"><?php echo $statistic['uy_insaatta_yayinlanan_sayi']['ISTATISTIK_SAYISI_EDIT'];?></td>
						<td detay="uy_insaatta_yayinlanan_sayi"><?php echo $statistic['uy_insaatta_yayinlanan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<div class="container">
		<div class="adv-table">
		  <div class="adv-table-head">
			  <div class="adv-table-title">
			  	BELGELENDİRME KURULUŞLARI
			  </div>
		  <?php if($this->istatistik_duzenleme_yetki){ ?>
			  <button class="edittable btn btn-xs btn-primary">Düzenle</button>
			  <button class="canceledit btn btn-xs btn-primary" style="display:none;">İptal</button>
		  <?php } ?>
		  </div>
		  <table class="display compact table table-hover table-bordered table-striped">
				<tbody>
					<tr>
						<td>Yetkilendirilmiş Belgelendirme Kuruluş Sayısı</td>
						<td detay="sb_kurulus_sayi_edit"><?php echo $statistic['sb_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_kurulus_sayi"><?php echo $statistic['sb_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Tehlikeli ve Çok tehlikeli İşlerde Belgelendirme Yapan Kuruluş Sayısı</td>
						<td detay="sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi_edit"><?php echo $statistic['sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi"><?php echo $statistic['sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>İnşaatta Belgelendirme Yapan Kuruluş Sayısı</td>
						<td detay="sb_insaatta_belgelendirme_yapan_sayi_edit"><?php echo $statistic['sb_insaatta_belgelendirme_yapan_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_insaatta_belgelendirme_yapan_sayi"><?php echo $statistic['sb_insaatta_belgelendirme_yapan_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Belgelendirme Yapılan Ulusal Yeterlilik(Meslek) Sayısı</td>
						<td detay="sb_belgelendirme_yapilan_meslek_sayi_Edit"><?php echo $statistic['sb_belgelendirme_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_belgelendirme_yapilan_meslek_sayi"><?php echo $statistic['sb_belgelendirme_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Tehlikeli ve Çok Tehlikeli İşlerde Belgelendirmesi Yapılan Meslek Sayısı</td>
						<td detay="sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi_edit"><?php echo $statistic['sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi"><?php echo $statistic['sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>	
					</tr>
					<tr>
						<td>İnşaatta Belgelendirmesi Yapılan Meslek Sayısı</td>
						<td detay="sb_insatta_belgelendirilmesi_yapilan_meslek_sayi_edit"><?php echo $statistic['sb_insatta_belgelendirilmesi_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_insatta_belgelendirilmesi_yapilan_meslek_sayi"><?php echo $statistic['sb_insatta_belgelendirilmesi_yapilan_meslek_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Belgelendirme Yapılan Sektör Sayısı</td>
						<td detay="sb_belgelendirme_yapilan_sektor_sayi_edit"><?php echo $statistic['sb_belgelendirme_yapilan_sektor_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sb_belgelendirme_yapilan_sektor_sayi"><?php echo $statistic['sb_belgelendirme_yapilan_sektor_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="adv-table">
		  <div class="adv-table-head">
			  <div class="adv-table-title">
			  	MYK MESLEKİ YETERLİLİK BELGELERİ
			 </div>
		   <?php if($this->istatistik_duzenleme_yetki){ ?>
			  <button class="edittable btn btn-xs btn-primary">Düzenle</button>
			  <button class="canceledit btn btn-xs btn-primary" style="display:none;">İptal</button>
		   <?php } ?>
		  </div>
		  <table class="display compact table table-hover table-bordered table-striped">
				<tbody>
					<tr>
						<td>Verilen Toplam MYK Mesleki Yeterlilik Belgesi Sayısı</td>
						<td detay="verilen_myk_belge_sayi_edit"><?php echo $statistic['verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="verilen_myk_belge_sayi"><?php echo $statistic['verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>İnşaat Sektöründe Verilen Toplam Mesleki Yeterlilik Belgesi Sayısı</td>
						<td detay="insaatta_verilen_myk_belge_sayi_edit"><?php echo $statistic['insaatta_verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="insaatta_verilen_myk_belge_sayi"><?php echo $statistic['insaatta_verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Tehlikeli ve Çok Tehlikeli İşlerde Verilen Toplam MYK Mesleki Yeterlilik Belgesi Sayısı</td>
						<td detay="tehlikeli_islerde_verilen_myk_belge_sayi_edit"><?php echo $statistic['tehlikeli_islerde_verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="tehlikeli_islerde_verilen_myk_belge_sayi"><?php echo $statistic['tehlikeli_islerde_verilen_myk_belge_sayi']['ISTATISTIK_SAYISI'];?></td>		
					</tr>
				</tbody>
			</table>
		</div>
		<div class="adv-table">
		  <div class="adv-table-head">
			  <div class="adv-table-title">
			  	SEKTÖR KOMİTELERİ
			  </div>
    	  <?php if($this->istatistik_duzenleme_yetki){ ?>
			  <button class="edittable btn btn-xs btn-primary">Düzenle</button>
			  <button class="canceledit btn btn-xs btn-primary" style="display:none;">İptal</button>
		  <?php } ?>
		  </div>
		  <table class="display compact table table-hover table-bordered table-striped">
				<tbody id="tasks">
					<tr>
						<td>Sektör Sayısı</td>
						<td detay="sektor_sayi_edit"><?php echo $statistic['sektor_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="sektor_sayi"><?php echo $statistic['sektor_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
					<tr>
						<td>Oluşturulan(Aktif) Sektör Komiteleri Sayısı</td>
						<td detay="aktif_sektor_komite_sayi_edit"><?php echo $statistic['aktif_sektor_komite_sayi']['ISTATISTIK_SAYISI'];?></td>
						<td detay="aktif_sektor_komite_sayi"><?php echo $statistic['aktif_sektor_komite_sayi']['ISTATISTIK_SAYISI'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="clear:both;"></div>
		<?php if($this->perm == true){?>
		<center>
			<button class="savestatistics btn btn-default btn-success" style="width:300px;">KAYDET</button>
		</center>
		<?php } ?>
</div>
</form>
<script>
jQuery(document).ready(function(){
	jQuery("button.edittable").click(function(){
		jQuery(this).hide();
		jQuery(this).closest('div').find('button.canceledit').show();
		jQuery(this).closest('.adv-table').find('table tr').each(function() {
			val = jQuery(this).find('td:eq(1)').html();
			name = jQuery(this).find('td:eq(1)').attr('detay');
			jQuery(this).find('td:eq(1)').html("<input type='text' name='"+name+"' value='"+val+"' class='input-sm' style='width:23px;' maxlength='3' />");
		});
		return false;
	});
	jQuery("button.canceledit").click(function(){
		jQuery(this).closest('.adv-table').find('table tr').each(function() {
			val = jQuery(this).find('td:eq(1) input').val();
			jQuery(this).find('td:eq(1)').html(val);
		});
		jQuery(this).hide();
		jQuery(this).closest('div').find('button.edittable').show();
		return false;
	});
	jQuery(".savestatistics").click(function(){
		if(confirm('Belirtmiş olduğunuz MYK istatistik değerleri işlenecek emin misiniz ?')){
			jQuery("form#statisticform").submit();
		}
	});
});
</script>
