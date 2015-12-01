<?php
$data = $this->belgeNoBilgi;

$belgeNoBilgi = $data['belgeBilgi'];
$kurBilgi = $data['kurBilgi'];
$yetBilgi = $data['yetBilgi'];
$belgeDurumu = array(1=>'Geçerli',2=>"İptal",3=>"Askıda");

$selectDurum = '';
foreach($belgeDurumu as $key=>$val){
	$selected = '';
	if($key == $belgeNoBilgi['BELGEDURUMU']){
		$selected = ' selected="selected"';
	}
	$selectDurum .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
}
?>
<div class="anaDiv tCenter">
	<h2><u>Belge Bilgileri Düzeltme ve Tekrar Basım İşlemleri</u></h2>
</div>

<input type="hidden" name="belgeNo" value="<?php echo $belgeNoBilgi['BELGENO'];?>"/>
<input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>

<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Belge No:</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['BELGENO'];?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" id="BelgeNoModal">Aday Belge Numarası Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">TC Kimlik No:</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['TCKIMLIKNO'];?></div>
</div>
<div class="anaDiv font16">
	<div class="div20 fLeft hColor"><h2 class="hColor font16">Adı:</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['AD'];?></div>
</div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Soyadı:</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['SOYAD'];?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" onclick="AdayBilgisi(<?php echo $belgeNoBilgi['ID'];?>)">Aday Bilgisi Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Yeterlilik:</h2></div>
	<div class="div80 fRight"><?php echo $yetBilgi['YETERLILIK_KODU'].'/'.$yetBilgi['REVIZYON'].' '.$belgeNoBilgi['YETERLILIK_ADI'];?></div>
</div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Seviye:</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['YETERLILIK_SEVIYESI'];?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" onclick="FuncYetBilgisi(<?php echo $belgeNoBilgi['ID'];?>)">Yeterlilik Bilgisi Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Belgelendirme Kuruluşu:</h2></div>
	<div class="div80 fRight"><?php echo $kurBilgi['KURULUS_ADI']?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" onclick="FuncKurBilgisi(<?php echo $belgeNoBilgi['ID'];?>)">Kuruluş Bilgisi Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20"><h2 class="hColor font16">Belge Düzenlenme Tarihi:</h2></div>
	<div class="div80 "><?php echo $belgeNoBilgi['BELGE_DUZENLEME_TARIHI'];?></div>
</div>
<div class="anaDiv font16">
	<div class="div20"><h2 class="hColor font16">Belge Geçerlilik Tarihi:</h2></div>
	<div class="div80"><?php echo $belgeNoBilgi['GECERLILIK_TARIHI'];?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" id="BelgeTarihBilgisi">Belge Tarih Bilgileri Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">İmza Yetkilisi</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['IMZA_YETKILISI'];?></div>
</div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">İmza Yetkilisi Ünvan</h2></div>
	<div class="div80 fRight"><?php echo $belgeNoBilgi['IMZA_YETKILISI_UNVAN'];?></div>
</div>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" id="ImzaYetkiliModal">İmza Yetkili Bilgisi Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Belge Durumu:</h2></div>
	<div class="div80 fRight">
	<?php
	if($belgeNoBilgi['BELGEDURUMU'] == 1){
		echo 'Geçerli';
	}else if($belgeNoBilgi['BELGEDURUMU'] == 2){
		echo 'İptal Edildi';
	}else if($belgeNoBilgi['BELGEDURUMU'] == 3){
		echo 'Askıya Alındı';
	}
	?>
	</div>
</div>
<?php 
if($belgeNoBilgi['BELGEDURUMU'] == 3 || $belgeNoBilgi['BELGEDURUMU'] == 2){
?>
<div class="anaDiv font16">
	<div class="div20 fLeft"><h2 class="hColor font16">Açıklama:</h2></div>
	<div class="div80 fRight">
	<?php echo nl2br($belgeNoBilgi['IPTAL_ACIKLAMA']);?>
	</div>
</div>
<?php
}
?>
<div class="anaDiv">
	<button type="button" class="btn btn-xs btn-primary" id="BelgeDurumBut">Belge Durumunu Güncelle</button>
</div>
<div class="anaDiv"><hr></div>
<div class="anaDiv text-right">
	<button type="button" class="btn btn-success btn-sm" id="BelgeBasBut">Belgeyi Tekrar Bas</button>
</div>


<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="UyariModal" style="min-width: 30%; max-width:60%; min-height:50px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
		<h2 class="text-danger"></h2>
	</div>
	<div class="anaDiv">
    	<button type="button" class="btn btn-warning btn-xs fRight" id="UyariKapat">Kapat</button>
    </div>
</div>

<div id="BelgeDurumModal" style="min-width: 30%; max-width:60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
		<h2><u>Belge Durum Bilgisi</u></h2>
	</div>
	<div class="anaDiv">
		<div class="div20 hColor font18">Belge Durumu:</div>
		<div class="div80 font16">
		<?php
		if($belgeNoBilgi['BELGEDURUMU'] == 1){
			echo 'Geçerli';
		}else if($belgeNoBilgi['BELGEDURUMU'] == 2){
			echo 'İptal Edildi';
		}else if($belgeNoBilgi['BELGEDURUMU'] == 3){
			echo 'Askıya Alındı';
		}
		?>
		</div>
	</div>
	<?php 
	if($belgeNoBilgi['BELGEDURUMU'] == 3 || $belgeNoBilgi['BELGEDURUMU'] == 2){
	?>
	<div class="anaDiv">
		<div class="div20 hColor font18">Açıklama:</div>
		<div class="div80 font16">
		<?php echo nl2br($belgeNoBilgi['IPTAL_ACIKLAMA']);?>
		</div>
	</div>
	<?php
	}
	?>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
		<h2><u>Güncel Belge Durum Bilgisi</u></h2>
	</div>
	<form id="FormBelgeDurum" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeDurumGuncelle">
	<div class="anaDiv">
		<div class="div20 hColor font18">Belge Durumu:</div>
		<div class="div80 font16">
			<select id="belgeDurumu" name="belgeDurumu" class="input-sm">
				<option value="0">Seçiniz</option>
				<option value="1">Geçerli</option>
				<option value="2">İptal Et</option>
				<option value="3">Askıya Al</option>
			</select>
		</div>
	</div>
	<div class="anaDiv" id="belgeAcik" style="display: none;">
		<div class="div20 hColor font18">Açıklama:</div>
		<div class="div80 font16">
			<textarea rows="3" style="width:60%" name="aciklama" id="aciklama" class="input-sm"></textarea>
		</div>
	</div>
	<input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>
	<input type="hidden" name="belgeNo" value="<?php echo $belgeNoBilgi['BELGENO'];?>"/>
	    <div class=anaDiv>
	    	<button type="button" class="btn btn-xs btn-primary" id="BelgeDurumGuncelle">Güncelle</button>
	    	<button type="button" class="btn btn-xs btn-danger" id="BelgeDurumIptal">İptal</button>
	    </div>
	</form>
</div>

<div id="AdayBilgisi" style="width: 400px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki Aday Bilgileri</u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Adı:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['AD'];?></div>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Soyadı:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['SOYAD'];?></div>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncel Aday Bilgileri</u></u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Adı:</div>
    	<div class="div80 font16" id="gAd"></div>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Soyadı:</div>
    	<div class="div80 font16" id="gSoyad"></div>
    </div>
    <div class=anaDiv>
    	<button type="button" class="btn btn-xs btn-primary" onclick="FuncAdayBilgiGuncelle(<?php echo $belgeNoBilgi['ID']?>)">Güncelle</button>
    	<button type="button" class="btn btn-xs btn-danger" id="AdayBilgisiIptal">İptal</button>
    </div>
</div>

<div id="YetkiliBilgisi" style="width: 50%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki İmza Yetkilisi Bilgileri</u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Adı ve Soyadı:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['IMZA_YETKILISI'];?></div>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Ünvanı:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['IMZA_YETKILISI_UNVAN'];?></div>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncellenecek İmza Yetkilisi Bilgileri</u></u></h2>
    </div>
    <form id="FormImzaYetkili" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeImzaYetkilisiGuncelle">
	    <div class=anaDiv>
	    	<div class="div20 hColor font18">Adı ve Soyadı:</div>
	    	<div class="div80"><input type="text" name="yetkili" class="input-sm" style="width:50%"/></div>
	    </div>
	    <div class=anaDiv>
	    	<div class="div20 hColor font18">Ünvanı:</div>
	    	<div class="div80"><input type="text" name="yetkiliUnvan" class="input-sm" style="width:50%"/></div>
	    </div>
	    <input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>
	    <div class=anaDiv>
	    	<button type="button" class="btn btn-xs btn-primary" id="YetkiliGuncelle">Güncelle</button>
	    	<button type="button" class="btn btn-xs btn-danger" id="YetkiliIptal">İptal</button>
	    </div>
    </form>
</div>

<div id="YeterlilikBilgisi" style="width: 60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki Yeterlilik Bilgileri</u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Yeterlilik Adı:</div>
    	<div class="div80 font16"><?php echo $yetBilgi['YETERLILIK_KODU'].'/'.$yetBilgi['REVIZYON'].' '.$belgeNoBilgi['YETERLILIK_ADI'];?></div>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Seviyesi:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['YETERLILIK_SEVIYESI'];?></div>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncel Yeterlilik Bilgileri</u></u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Yeterlilik Adı:</div>
    	<div class="div80 font16" id="gYet"></div>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Seviyesi:</div>
    	<div class="div80 font16" id="gYetSeviye"></div>
    </div>
    <div class=anaDiv>
    	<button type="button" class="btn btn-xs btn-primary" onclick="FuncYetBilgiGuncelle(<?php echo $belgeNoBilgi['ID']?>)">Güncelle</button>
    	<button type="button" class="btn btn-xs btn-danger" id="YeterlilikBilgisiIptal">İptal</button>
    </div>
</div>

<div id="KurulusBilgisi" style="width: 60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki Kuruluş Bilgilesi</u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Kuruluş Adı:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['KURULUS_ADI'];?></div>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncel Kuruluş Bilgilesi</u></u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Kuruluş Adı:</div>
    	<div class="div80 font16" id="gKur"></div>
    </div>
    <div class=anaDiv>
    	<button type="button" class="btn btn-xs btn-primary" onclick="FuncKurBilgiGuncelle(<?php echo $belgeNoBilgi['ID']?>)">Güncelle</button>
    	<button type="button" class="btn btn-xs btn-danger" id="KurBilgisiIptal">İptal</button>
    </div>
</div>

<div id="BelgeNoBilgisi" style="width: 60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki Belge Numarası</u></h2>
    </div>
    <div class=anaDiv>
    	<div class="div20 hColor font18">Belge No:</div>
    	<div class="div80 font16"><?php echo $belgeNoBilgi['BELGENO'];?></div>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncellenecek Belge Numarası</u></u></h2>
    </div>
    <form id="FormBelgeNo" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeBelgeNoGuncelle">
	    <div class=anaDiv>
	    	<div class="div20 hColor font18">Belge No:</div>
	    	<div class="div80"><input type="text" name="noBelge" class="input-sm" style="width:50%"/></div>
	    </div>
	    <div class=anaDiv>
	    	<button type="button" class="btn btn-xs btn-primary" onclick="FuncBelgeNoBilgiGuncelle(<?php echo $belgeNoBilgi['ID'];?>)">Güncelle</button>
	    	<button type="button" class="btn btn-xs btn-danger" id="BelgeNoBilgisiIptal">İptal</button>
	    </div>
	    <input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>
    </form>
</div>

<div id="TarihBilgisi" style="width: 60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belge Üzerindeki Tarih Bilgileri</u></h2>
    </div>
    <div class="anaDiv">
			<div class="div30"><h2 class="hColor">Belge Düzenlenme Tarihi:</h2></div>
			<div class="div70 font16"><?php echo $belgeNoBilgi['BELGE_DUZENLEME_TARIHI'];?></div>
		</div>
		<div class="anaDiv">
			<div class="div30 hColor"><h2 class="hColor">Belge Geçerlilik Tarihi:</h2></div>
			<div class="div70 font16"><?php echo $belgeNoBilgi['GECERLILIK_TARIHI'];?></div>
		</div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv">
    	<h2><u>Güncellenecek Tarih Bilgileri</u></u></h2>
    </div>
    <form id="FormTarih" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeTarihGuncelle">
	    <div class="anaDiv">
			<div class="div30"><h2 class="hColor">Belge Düzenlenme Tarihi:</h2></div>
			<div class="div70"><input type="text" id="belgeDuzTarih" class="tarih input-sm" name="belgeDuzTarih" value="<?php echo $belgeNoBilgi['BELGE_DUZENLEME_TARIHI'];?>" readonly="readonly" style="width: 12%"/></div>
		</div>
<!--
 		<div class="anaDiv">
			<div class="div30"><h2 class="hColor">Belge Geçerlilik Tarihi:</h2></div>
			<div class="div70"><input type="text" id="belgeGecTarih" class="tarih input-sm" name="belgeGecTarih" value="<?php echo $belgeNoBilgi['GECERLILIK_TARIHI'];?>" readonly="readonly" style="width: 12%"/></div>
		</div>
 -->
	    <div class=anaDiv>
	    	<button type="button" class="btn btn-xs btn-primary" onclick="FuncTarihBilgiGuncelle(<?php echo $belgeNoBilgi['ID'];?>)">Güncelle</button>
	    	<button type="button" class="btn btn-xs btn-danger" id="TarihBilgisiIptal">İptal</button>
	    </div>
	    <input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>
    </form>
</div>

<div id="TekrarBasim" style="width: 60%; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv">
    	<h2><u>Belgenin Tekrar Basımı</u></h2>
    </div>
    <div class="anaDiv"><hr></div>
    <div class="anaDiv"><a class="btn btn-sm btn-success" href="index.php?option=com_belgelendirme&view=tekrar_basim&layout=belgeExcel&belgeNo=<?php echo urlencode($belgeNoBilgi['BELGENO']);?>" target="_blank">Belge Basım Exceli İndir</a></div>
<form id="FormBasim" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=BelgeTekrarBas">
	<div class="anaDiv">
		<div class="div30"><h2 class="hColor">Belge Basım Nedeni:</h2></div>
		<div class="div70">
			<select name="basimNeden" class="input-sm">
				<option value="1">MYK Basım Hatası</option>
				<option value="2">Kuruluş Basım Hatası</option>
			</select>
		</div>
	</div>
	<div class="anaDiv" id="dekontlar" style="display:none">
		<table width="100%" style="text-align:center;margin-bottom:10px;" border="1">
			<thead style="background-color:#71CEED;">
				<tr>
					<th>Belgelendirme Dekontu:</th>
					<th>Dekont No:</th>
					<th>Belgelendirme Tutarı:</th>
					<th>Sil</th>
				</tr>
			</thead>
			<tbody id="dekTbody" class="tdPad5">
				
			</tbody>
		</table>
		<button type="button" id="DekEkle" class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i> Yeni Dekont Ekle</button>
	</div>
	<div class="anaDiv"><hr></div>
	<div class="anaDiv">
		<button type="button" class="btn btn-xs btn-primary" id="BasimGonder">Basıma Gönder</button>
	    <button type="button" class="btn btn-xs btn-danger" id="BasimIptal">İptal</button>
	</div>
	<input type="hidden" name="belgeId" value="<?php echo $belgeNoBilgi['ID'];?>"/>
</form>
</div>

<script type="text/javascript">
var ilkBelgeNo = '<?php echo $belgeNoBilgi['BELGENO'];?>';
var DekontEkle = '<tr>'+
'<td><input type="file" name="dekont[]" class="input-sm" /></td>'+
'<td><input type="text" class="dekontNo input-sm" name="dekontNo[]" /></td>'+
'<td><input type="text" class="tutar input-sm" name="tutar[]" /></td>'+
'<td><button type="button" class="btn btn-xs btn-danger" id="dekSil">Sil</button></td>'+
'</tr>';
/*var belgeNoArray = belgeNo.split('/');
var kurKod = belgeNoArray[0];
var yetKod = belgeNoArray[1];
var revKod = belgeNoArray[2];
var siraKod = belgeNoArray[3];*/

// jQuery('#loaderGif').lightbox_me({
// 	centered: true,
//     closeClick:false,
//     closeEsc:false  
// });
// jQuery('#loaderGif').trigger('close');

jQuery(document).ready(function(){
	jQuery('#BelgeDurumBut').live('click',function(e){
		e.preventDefault();
		jQuery('#BelgeDurumModal').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});

	jQuery('#BelgeDurumIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#BelgeDurumModal').trigger('close');
	});

	jQuery('#BelgeDurumGuncelle').live('click',function(e){
		e.preventDefault();
		if(jQuery('#belgeDurumu').val() == 0){
			jQuery('#UyariModal h2').html('Lütfen Belge Durumunu seçiniz.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
		}else if(jQuery('#belgeDurumu').val() == 2 || jQuery('#belgeDurumu').val() == 3){
			if(jQuery('#aciklama').val() == ''){
				jQuery('#UyariModal h2').html('Lütfen Belge Durumunu Açıklama alanını boş bırakmayınız.');
				jQuery('#UyariModal').lightbox_me({
					centered: true,
				    closeClick:false,
				    closeEsc:false
				});
			}else{
				jQuery('#FormBelgeDurum').submit();
			}
		}else{
			jQuery('#aciklama').val('');
			jQuery('#FormBelgeDurum').submit();
		}
		
		
	});
	
	jQuery('#belgeDurumu').change(function(){
		if(jQuery(this).val() == 2 || jQuery(this).val() == 3){
			jQuery('#belgeAcik').show();
		}else{
			jQuery('#belgeAcik').hide();
		}
	});

	jQuery('#dekSil').live('click',function(){
		jQuery(this).closest('tr').remove();
	});

	jQuery('#DekEkle').live('click',function(){
		jQuery('#dekTbody').append(DekontEkle);
	});

	jQuery('#BasimGonder').live('click',function(e){
		e.preventDefault();
		jQuery('#FormBasim').submit();
	});

	jQuery('select[name="basimNeden"]').change(function(e){
		e.preventDefault();
		if(jQuery(this).val() == 2){
			jQuery('#dekontlar').show();
		}else{
			jQuery('#dekontlar').hide();
		}
	});

	jQuery('#BasimIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#TekrarBasim').trigger('close');
	});

	jQuery('#BelgeBasBut').live('click',function(e){
		e.preventDefault();
		jQuery('#TekrarBasim').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});
	
	jQuery('#TarihBilgisiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#TarihBilgisi').trigger('close');
	});
	
	jQuery('#BelgeTarihBilgisi').live('click',function(e){
		e.preventDefault();
		jQuery('#TarihBilgisi').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});
	
	jQuery('#BelgeNoBilgisiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('input[name="noBelge"]').val('');
		jQuery('#BelgeNoBilgisi').trigger('close');
	});
	
	jQuery('#BelgeNoModal').live('click',function(e){
		e.preventDefault();
		jQuery('#BelgeNoBilgisi').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});
	
	jQuery('#UyariKapat').live('click',function(e){
		e.preventDefault();
		jQuery('#UyariModal').trigger('close');
	});
	
	jQuery('#KurBilgisiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#KurulusBilgisi').trigger('close');
	});
	
	jQuery('#YeterlilikBilgisiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#YeterlilikBilgisi').trigger('close');
	});
	
	jQuery('#YetkiliGuncelle').live('click',function(e){
		e.preventDefault();
		if(jQuery('input[name="yetkili"]').val() == ''){
			jQuery('#UyariModal h2').html('Yetkili Ad ve Soyadı boş bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
// 			alert('Yetkili Ad ve Soyadı boş bırakmayınız.');
		}else if(jQuery('input[name="yetkiliUnvan"]').val() == ''){
			jQuery('#UyariModal h2').html('Yetkili Ünvanını boş bırakmayınız.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
// 			alert('Yetkili Ünvanını boş bırakmayınız.');
		}else{
			jQuery('#FormImzaYetkili').submit();
		}
	});
	
	jQuery('#YetkiliIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#YetkiliBilgisi').trigger('close');
	});

	jQuery('#ImzaYetkiliModal').live('click',function(e){
		e.preventDefault();
		jQuery('#YetkiliBilgisi').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});
	
	jQuery('#AdayBilgisiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#AdayBilgisi').trigger('close');
	});
	
	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});

	jQuery('#kurulus').live('change',function(){
		jQuery.ajax({
			async:false,
			type:'POST',
			url:'index.php?option=com_belgelendirme&task=getAjaxYbKod&format=raw',
			data:'kurulus='+jQuery(this).val()
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat[0]['YB_KODU'] == '' || dat[0]['YB_KODU'].length == 0){
				alert('Kuruluşun yetkilendirme numarası girilmemiştir. Önce yetkilendirme numarasını giriniz.');
			}else{
				var belgeNo = jQuery('#noBelge').val();
				var belgeNoArray = belgeNo.split('/');
				var kurKod = belgeNoArray[0];
				var yetKod = belgeNoArray[1];
				var revKod = belgeNoArray[2];
				var siraKod = belgeNoArray[3];
				var YeniNo = dat[0]['YB_KODU']+'/'+yetKod+'/'+revKod+'/'+siraKod;
				jQuery('#noBelge').val(YeniNo);
			}
		});
	});

	jQuery('#yets').live('change',function(){
		jQuery.ajax({
			async:false,
			type:'POST',
			url:'index.php?option=com_belgelendirme&task=getAjaxYets&format=raw',
			data:'yetId='+jQuery(this).val()
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var belgeNo = jQuery('#noBelge').val();
				var belgeNoArray = belgeNo.split('/');
				var kurKod = belgeNoArray[0];
				var yetKod = dat[0]['YETERLILIK_KODU'];
				var revKod = dat[0]['REVIZYON'];
				var siraKod = belgeNoArray[3];
				var YeniNo = kurKod+'/'+yetKod+'/'+revKod+'/'+siraKod;
				jQuery('#noBelge').val(YeniNo);
			}else{
				
			}
		});
	});
	
	jQuery('#belgeDurumu').change(function(){
		if(jQuery(this).val() == 2 || jQuery(this).val() == 3){
			jQuery('#belgeAcik').show();
		}else{
			jQuery('#belgeAcik').hide();
		}
	});

});

function BelgeNoVarMi(belge){
	var belgeVar = false;
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeNoVarMi&format=raw",
		data:"belgeNo="+belge,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				belgeVar = true;
			}else{
				belgeVar = false;		
			}
		}
	});

	return belgeVar;
}

function AdayBilgisi(belgeId){
	jQuery('#UyariModal h2').html('');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeAdayBilgisi&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#gAd').html(dat['ADI']);
			jQuery('#gSoyad').html(dat['SOYADI']);
			jQuery('#AdayBilgisi').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false  
			});
		}else{
			jQuery('#UyariModal h2').html('Aday Bilgileri Güncel Durumda. Aday bilgilerini düzenlemek istiyorsanız Aday Bilgileri Düzenleme linkinden ulaşabilirsiniz.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
		}
	});
}

function FuncAdayBilgiGuncelle(belgeId){
	jQuery('#AdayBilgisi').trigger('close');
	jQuery('#loaderGif').lightbox_me({
		centered: true,
	    closeClick:false,
	    closeEsc:false  
	});
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeAdayBilgisiGuncelle&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			window.location.reload();
		}else{
			alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			window.location.reload();
		}
	});
}

function FuncYetBilgisi(belgeId){
	jQuery('#UyariModal h2').html('');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeYetBilgisi&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#gYet').html(dat['YETERLILIK_KODU']+'/'+dat['REVIZYON']+' '+dat['YETERLILIK_ADI']);
			jQuery('#gYetSeviye').html(dat['SEVIYE_ID']);
			jQuery('#YeterlilikBilgisi').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false  
			});
		}else{
			jQuery('#UyariModal h2').html('Yeterlilik Bilgileri Güncel Durumda.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
		}
	});
}

function FuncYetBilgiGuncelle(belgeId){
	jQuery('#YeterlilikBilgisi').trigger('close');
	jQuery('#loaderGif').lightbox_me({
		centered: true,
	    closeClick:false,
	    closeEsc:false  
	});
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeYeterlilikBilgisiGuncelle&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			window.location.reload();
		}else{
			alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			window.location.reload();
		}
	});
}

function FuncKurBilgisi(belgeId){
	jQuery('#UyariModal h2').html('');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeKurBilgisi&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#gKur').html(dat['KURULUS_ADI']);
			jQuery('#KurulusBilgisi').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false  
			});
		}else{
			jQuery('#UyariModal h2').html('Kuruluş Bilgileri Güncel Durumda.');
			jQuery('#UyariModal').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false  
			});
		}
	});
}

function FuncKurBilgiGuncelle(belgeId){
	jQuery('#KurulusBilgisi').trigger('close');
	jQuery('#loaderGif').lightbox_me({
		centered: true,
	    closeClick:false,
	    closeEsc:false  
	});
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeKurulusBilgisiGuncelle&format=raw",
		data:'belgeId='+belgeId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			window.location.reload();
		}else{
			alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			window.location.reload();
		}
	});
}

function FuncBelgeNoBilgiGuncelle(belgeId){
	var NewBelgeNo = jQuery('input[name="noBelge"]').val();
	var BelgeNo = "<?php echo $belgeNoBilgi['BELGENO'];?>";
	if(NewBelgeNo == '' || NewBelgeNo.length == 0){
		alert('Belge numarasını boş bırakamazsınız.');
		return false;
	}else if(BelgeNoVarMi(NewBelgeNo) && BelgeNo != NewBelgeNo){
		alert('Belge numarasını daha önce kullanılmış. Lütfen değiştiriniz.');
		return false;
	}else if(BelgeNoUygunFormatMi(NewBelgeNo,belgeId)){
		alert('Belge numarası formatı uygun değildir.');
	}else{
		jQuery('#BelgeNoBilgisi').trigger('close');
		jQuery('#loaderGif').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
		jQuery('#FormBelgeNo').submit();
	}
}

function BelgeNoUygunFormatMi(BelgeNo,belgeId){
	var belgeVar = true;
	jQuery.ajax({
		async: false,
		type:"POST",
		url:"index.php?option=com_belgelendirme&task=BelgeNoEditKontrol&format=raw",
		data:"belgeNo="+BelgeNo+'&belgeId='+belgeId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				belgeVar = false;
			}else{
				belgeVar = true;		
			}
		}
	});

	return belgeVar;
}
</script>