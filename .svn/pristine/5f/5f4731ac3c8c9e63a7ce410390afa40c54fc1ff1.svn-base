<?php
echo $this->sayfaLink;
$tesvikArray = $this->tesvikArray;
$yets = $this->yets;
$kurs = $this->kurs;
$belgeNo = $this->sonBelgeNo;
$sonBelgeNo = $belgeNo[0];
$sonBelSay = $belgeNo[1];
$yetBelgeNo = $belgeNo[2];

$basarili = $this->basarili;
$basariliUcretData = $this->basariliUcretData;
$basarisiz = $this->basarisiz;
$aciklama = $this->aciklama;

$yeterlilikBkUcret = $this->yeterlilikBkUcret;
$basariliABHibeUcretData = $this->basariliABHibeUcretData;
$ABHibeArray = $this->ABHibeArray;
?>

<style>
.width150{
	width:200px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>div{
	padding-top:10px;
}
.aramaClass{
	margin-bottom:30px;
}
.aramaSonuc{
 	display:none;
	margin-top:20px;
}
.belgeIslem{
	width:100%;
}
.belgeIslem>div{
	float:left;
}
.belgeIslem>div>span{
	color:#063B5E;
	font-weight:bold;
}
</style>
<div class="aramaClass">
<div class="width150">Kurulus Adı:</div><div><?php echo $kurs['KURULUS_ADI'];?></div>
<div class="width150">Kuruluş Kodu:</div><div><?php echo $kurs['KURULUS_YETKILENDIRME_NUMARASI'];?></div>
<div class="width150">Sınavın Yeterliliği:</div><div><?php echo $yets[0]['YETERLILIK_KODU'].'/'.$yets[0]['REVIZYON'].' '.$yets[0]['YETERLILIK_ADI'];?></div>
<div class="width150">Sınavın Tarihi:</div><div><?php echo $yets[0]['BASLANGIC_TARIHI'];?></div>
<div class="width150">Son Verilen Belge Numarası:</div><div><?php echo $sonBelgeNo;?></div>
</div>
<div class="anaDiv">
	<div class="div40"><button type="button" id="belgeNoVer" class="btn btn-xs btn-primary">Adaylara Otomatik Belge Numarası Ver</button></div>
	<div class="div60 text-right">
		<span class="hColor fontBold">Belge Verilme Tarihi: </span>
		<input type="text" id="ttarih" name="ttarih" readonly="readonly" class="input-sm"/> 
		<button type="button" id="tumTar" class="btn btn-xs btn-primary">Tüm Adaylara Uygula</button>
	</div>
</div>
<?php
 
if($yets[0]['BELGE_ZORUNLULUK_DURUM']){
?>
<div class="anaDiv">
	<div class="divYan fontBold">
		<input type="radio" name="tebligTum" value="0" checked/>Teşvikten Yararlanmayacak
		<input type="radio" name="tebligTum" value="1"/>Teşvikten Yararlanacak
<!-- 		<input type="radio" name="tebligTum" value="2"/>AB -->
	</div>
	<div class="divYan">
		<button type="button" id="tumTeblig" class="btn btn-xs btn-primary">Tüm Adaylara Uygula</button>
	</div>
</div>
<?php
}

?>
<form id="BelgeNoGonder" action="index.php?option=com_belgelendirme&task=BelgeNoSonucGonder" enctype="multipart/form-data" method="post">
<div class="anaDiv">
	<div class="div20 hColor fontBold">İmza Yetkilisi Adı:</div>
	<div class="div80"><input type="text" id="yetkiliAd" name="yetkiliAd" class="input-sm inputW50" /></div>
</div>
<div class="anaDiv">
	<div class="div20 hColor fontBold">İmza Yetkilisi Soyadı:</div>
	<div class="div80"><input type="text" id="yetkiliSoyAd" name="yetkiliSoyAd" class="input-sm inputW50" /></div>
</div>
<div class="anaDiv">
	<div class="div20 hColor fontBold">İmza Yetkilisi Ünvanı:</div>
	<div class="div80"><input type="text" id="yetkiliUnvan" name="yetkiliUnvan" class="input-sm inputW50"/></div>
</div>
<div class="anaDiv" id="dekontContainer">
<table width="100%" style="text-align:center;margin-bottom:10px;" border="1">
<tbody id="dekTbody">
	<tr>
		<td>Belgelendirme Dekontu:<input type="file" name="dekont[]" class="input-sm inputW90"/></td>
		<td>Dekont NO:<input type="text" class="dekontNo input-sm inputW90" name="dekontNo[]"/></td>
		<td>Dekont Tarih:<input type="text" class="dekontTarih input-sm inputW90" name="dekontTarih[]"/></td>
		<td>Belgelendirme Tutarı:<input type="text" class="tutar input-sm inputW90" name="tutar[]"/></td>
		<td><button type="button" id="dekSil" class="btn btn-xs btn-danger">Sil</button></td>
	</tr>
</tbody>
</table>
<button type="button" id="DekEkle" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Yeni Dekont Ekle</button>
</div>
<div class="anaDiv">
<table width="100%" style="text-align:center;margin-bottom:10px;" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="5%">#</th>
			<th width="30%">Aday Bilgisi</th>
			<th width="20%">Belge No:</th>
			<th width="15%">Belge Verilme Tarihi</th>
			<?php if($yets[0]['BELGE_ZORUNLULUK_DURUM'] || ($this->ABProVarMi && $yets[0]['ABHIBE'])){
				echo '<th width="30%">Teşvik Durumu</th>';
			}?>
		</tr>
	</thead>
	<tbody id="belgeIslemTbody">
		<?php
		$sayBas = 1; 
		foreach($basarili as $row){
			if($sayBas%2==0){
				$bgcolor="#efefef";
			}else{
				$bgcolor="#FFFFFF";
			}
			
			echo '<tr id="aday_'.$row['TC_KIMLIK'].'" bgcolor="'.$bgcolor.'">';
			echo '<td class="fontBold">'.$sayBas.'</td>';
			echo '<td class="fontBold">'.$row['TC_KIMLIK'].' - '.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td><input type="text" name="belgeNo['.$row['TC_KIMLIK'].']" id="belgeNo" class="input-sm inputW90"/></td>';
			echo '<td><input type="text" name="belgeTarih['.$row['TC_KIMLIK'].']" class="belgeTarih input-sm inputW90" readonly="true"/></td>';
			if($yets[0]['BELGE_ZORUNLULUK_DURUM'] || ($this->ABProVarMi && $yets[0]['ABHIBE'])){
				$ucret_detay = "";
				$ucret_detayHibe = "";
				foreach ($basariliUcretData[$row['TC_KIMLIK']]['UCRET_DETAY'] as $key => $val){
					$ucret_detay .= "Birim Kodu = ".$val['BIRIM_KODU']."</br> Ucreti = ".$val['ucret']." TL<hr>";
				}
				
				foreach ($basariliABHibeUcretData[$row['TC_KIMLIK']]['UCRET_DETAY'] as $key => $val){
					$ucret_detayHibe .= "Birim Kodu = ".$val['BIRIM_KODU']."</br> Ucreti = ".$val['ucret']." TL<hr>";
				}
				
				echo '<td align="left">';
					echo '<div class="anaDiv fontBold">';
						echo '<div class="div100">';
							echo '<input type="radio" class="tebligAday" name="teblig['.$row['TC_KIMLIK'].']" value="0" checked />Yararlanmayacak';
						echo '</div>';
						
						if($yets[0]['BELGE_ZORUNLULUK_DURUM'] && $basariliUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM']){
							echo '<div class="div100">';
							echo '<input type="radio" class="tebligAday" name="teblig['.$row['TC_KIMLIK'].']" value="1" '.($basariliUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM'] == false ? "disabled='disabled'" : "").'/>Devlet Teşviğinden Yararlanacak';
							echo '</div>';
						}
						
						if($this->ABProVarMi && $yets[0]['ABHIBE'] && $basariliABHibeUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM']){
							echo '<div class="div100">';
							echo '<input type="radio" class="tebligAday" name="teblig['.$row['TC_KIMLIK'].']" value="2" '.(($basariliABHibeUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM'] == false) ? "disabled='disabled'" : "").'/>AB Hibesinden Yararlanacak';
							echo '</div>';
						}
					echo '</div>';
						
						echo '<div class="tesvikContainer" style="background-color:#F5D96E; width=100%; display:none; padding:10px; float:left;" >';
						if($yets[0]['BELGE_ZORUNLULUK_DURUM'] && $basariliUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM']){
							echo '<div class="anaDiv fontBold">';
							echo 'Ücret :<input type="text" class="tooltip" title="'.$ucret_detay.'" value="'.$basariliUcretData[$row['TC_KIMLIK']]['TOPLAM_UCRET'].' TL" readonly="readonly"/><br>';
							echo '<span style="color:red; padding:5px;">B.K. Ücreti :'.($yeterlilikBkUcret['STATUS'] == true ? $yeterlilikBkUcret['DATA']['UCRET']." TL" : "-");
							echo '</div>';
							echo '<input type="button" value="Ücret Düzeltme Talebi" class="btn btn-xs btn-danger protestfee" style="float:right; margin:10px;" />';
						}	
						echo '</div>';
						
						echo '<div class="abhibeContainer" style="background-color:#F5D96E; width=100%; display:none; padding:10px; float:left;" >';
						if($this->ABProVarMi && $yets[0]['ABHIBE'] && $basariliABHibeUcretData[$row['TC_KIMLIK']]['TESVIK_DURUM']){
							echo '<div class="anaDiv fontBold">';
							echo 'Ücret :<input type="text" class="tooltip" title="'.$ucret_detayHibe.'" value="'.$basariliABHibeUcretData[$row['TC_KIMLIK']]['TOPLAM_UCRET'].' TL" readonly="readonly"/><br>';
							echo '<span style="color:red; padding:5px;">Maksimum Ödenecek: 300.00 €</span>';
							echo '</div>';
							echo '<div class="anaDiv">';
							echo '<input type="button" value="Ücret Düzeltme Talebi" class="btn btn-xs btn-danger protestfee" style="float:right; margin:10px;" />';
							echo '</div>';
							// IBAN
							echo '<div class="anaDiv">';
							echo '<div class="div20 fontBold font15 text-danger">IBAN:</div>';
							echo '<div class="div80"><input type="text" id="abiban_'.$row['TC_KIMLIK'].'" name="abiban['.$row['TC_KIMLIK'].']" class="abiban input-sm inputW90"/></div>';
							echo '<div class="fontBold fontItalic">(Hibenin iade edileceği, başvuru formunda yer alan IBAN No)</div>';
							echo '</div>';
							// IBAN SON
							// Basvuru pdf'i
							echo '<input type="hidden" class="basvurufiledurum" id="basvurufiledurum_'.$row['TC_KIMLIK'].'" name="basvurufile['.$row['TC_KIMLIK'].']" value="0">';
							echo '<div class="anaDiv" style="display:none" id="BasvuruFile_'.$row['TC_KIMLIK'].'">';
							echo '<div class="div90 font16 fontBold text-danger text-underline">Adayın Başvuru Formu</div>';
							echo '<span class="font16 hColor">Adayın Hibe Başvuru Formunu ıslak imzalı ve taranmış olarak yükleyiniz.</span>';
							echo '<input type="file" id="fileBasvuru_'.$row['TC_KIMLIK'].'" name="filebasvuru" />';
							echo '<button type="button" class="btn btn-xs btn-success" onclick="FuncBasvuruFileYukle('.$row['TC_KIMLIK'].','.$this->sinav_id.')">Yükle</button>';
							echo '</div>';
							echo '<div class="anaDiv" style="display:none" id="BasvuruFileYuk_'.$row['TC_KIMLIK'].'">';
							echo '<a id="BasvuruFileLink_'.$row['TC_KIMLIK'].'" target="_blank" href="#" class="btn btn-xs btn-primary">Başvuru Dosyası</a>';
							echo '<button type="button" class="btn btn-xs btn-danger" onclick="FuncBasvuruFileSil('.$row['TC_KIMLIK'].','.$this->sinav_id.')">Sil</button>';
							echo '</div>';
							// Basvuru pdf'i SON
							// Dezavantaj Dosyası
							echo '<div class="anaDiv">';
							echo '<input type="checkbox" class="DezCheck" name="DezAvantaj[]" value="'.$row['TC_KIMLIK'].'"><span class="font16 fontBold text-danger text-underline"> Dezavantajlı Aday</span>';
							echo '</div>';
							echo '<input type="hidden" id="dezavantajfile_'.$row['TC_KIMLIK'].'" value="0">';
							echo '<div class="anaDiv" style="display:none" id="DezFile_'.$row['TC_KIMLIK'].'">';
							echo '<span class="font16 hColor">Adayın Dezavantaj bilgisini PDF halinde sisteme yükleyiniz.</span>';
							echo '<input type="file" id="filedez_'.$row['TC_KIMLIK'].'" name="filedez" />';
							echo '<button type="button" class="btn btn-xs btn-success" onclick="DezFileYukle('.$row['TC_KIMLIK'].','.$this->sinav_id.')">Yükle</button>';
							echo '</div>';
							echo '<div class="anaDiv" style="display:none" id="DezFileYuk_'.$row['TC_KIMLIK'].'">';
							echo '<a id="DezFileLink_'.$row['TC_KIMLIK'].'" target="_blank" href="#" class="btn btn-xs btn-primary">Dezavantaj Kanıt Belgesi</a>';
							echo '<button type="button" class="btn btn-xs btn-danger" onclick="DezFileSil('.$row['TC_KIMLIK'].','.$this->sinav_id.')">Sil</button>';
							echo '</div>';
							// Dezavantaj Dosyası SON
						}
						echo '</div>';
						
						echo '<input type="hidden" class="itiraz_ucret" name="itiraz_ucret['.$row['TC_KIMLIK'].']" />';
						echo '<input type="hidden" class="itiraz_aciklama" name="itiraz_aciklama['.$row['TC_KIMLIK'].']" />';
				echo '</td>';
			}
			else{
				echo '<td align="left" class="fontBold hidden">';
				echo '<input type="hidden" name="teblig['.$row['TC_KIMLIK'].']" value="0"/>';
				echo '</td>';
			}

			echo '</tr>';
			$sayBas++;
		}
		foreach($basarisiz as $row){
			if($sayBas%2==0){
				$bgcolor="#efefef";
			}else{
				$bgcolor="#FFFFFF";
			}
				
			echo '<tr id="aday_'.$row['TC_KIMLIK'].'" bgcolor="'.$bgcolor.'">';
			echo '<td>'.$sayBas.'</td>';
			echo '<td>'.$row['TC_KIMLIK'].' - '.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td><input type="text" name="belgeNo['.$row['TC_KIMLIK'].']" id="belgeNo" style="width:100%;"/></td>';
			echo '<td><input type="text" name="belgeTarih['.$row['TC_KIMLIK'].']"  class="belgeTarih" style="width:100%;" readonly="true"/></td>';
			echo '</tr>';
			$sayBas++;
		}
		?>
	</tbody>
</table>
</div>
<?php foreach($aciklama as $key=>$val){
	echo '<input type="hidden" name="aciklama['.$key.']" value="'.$val.'"/>';
}?>
<input type="hidden" name="sinav_id" value="<?php echo $this->sinav_id;?>"/>
<div class="anaDiv">
	<div class="div50">
		<button type="button" class="btn btn-sm btn-danger" onclick="location.href='index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=aday_bildirim&sinavId=<?php echo $this->sinav_id;?>'">Geri</button>
	</div>
	<div class="div50 text-right">
		<button type="button" id="gonder" class="btn btn-sm btn-success">Kaydet</button>
	</div>
</div>
</form>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
<div id="protestFeeContainer" style="width:390px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="protestFeeForm" enctype="multipart/form-data" action="index.php?option=com_yeterlilik_taslak_yeni&task=TesvikItırazUcret">
    	<div class="anaDiv text-center font20 hColor" id="baslik">
    		Ücret Düzeltme Talebi
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Yeni Ücret:
    		</div>
    		<div class="div60">
    			<input type="text" name="itiraz_ucret_lightbox" class="input-sm inputW95"  onkeypress="return isNumberKey(event)"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div100 font16 hColor">
    			Açıklama:<br/>
    			<textarea name="itiraz_aciklama_lightbox" class="inputW100" rows="10"></textarea>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Ek Dosya:
    		</div>
    		<div class="div60" id="filecontain">
    			<input type="file" name="itiraz_dosya_lightbox"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div style="float:right;">
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-success" id="saveProtest">Kaydet</button>
	    		</div>
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-warning" id="clearProtest">Formu Temizle</button>
	    		</div>
	    		
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-danger" id="cancelProtest">İptal</button>
	    		</div>
    		</div>
    	</div>        
        <input type="hidden" name="parentId" value="0" />
    </form>
</div>
<div id="UyariLoader" style="width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="naDiv font20 fontBold text-warning text-center text-underline">
    	<i class="fa fa-exclamation-circle"></i> UYARI <i class="fa fa-exclamation-circle"></i>
    </div>
    <div class="anaDiv font16 fontBold text-primary text-center" id="UyariContent">
    
    </div>
    <div class="anaDiv">
    	<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">Kapat</button>
    </div>
</div>
<script type="text/javascript">
var DekontEkle = '<tr>'+
	'<td>Belgelendirme Dekontu:<input type="file" name="dekont[]" class="input-sm inputW90"/></td>'+
	'<td>Dekont NO:<input type="text" class="dekontNo input-sm inputW90" name="dekontNo[]"/></td>'+
	'<td>Dekont Tarih:<input type="text" class="dekontTarih input-sm inputW90" name="dekontTarih[]"/></td>'+
	'<td>Belgelendirme Tutarı:<input type="text" class="tutar input-sm inputW90" name="tutar[]"/></td>'+
	'<td><button type="button" id="dekSil" class="btn btn-xs btn-danger">Sil</button></td>'+
	'</tr>';

jQuery(document).ready(function(){

	var dekontcontrol = true;
	
	jQuery('#ttarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
	});

	jQuery('.dekontTarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
	});

	jQuery('.belgeTarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
	});

	jQuery('#tumTar').live('click',function(e){
		e.preventDefault();
		var tar = jQuery('#ttarih').val();
		jQuery.each(jQuery('.belgeTarih'),function(key,vall){
			vall.value = tar;
		});
	});

	jQuery('#belgeNoVer').live('click',function(e){
		e.preventDefault();
		var sonSayString = '<?php echo $sonBelSay;?>';
		var sonSay = '<?php echo $sonBelSay;?>';
		var belgeNoBas = '<?php echo $yetBelgeNo;?>';
		
		jQuery.ajax({
 			type: "POST",
 			dataType:"json",
 			url: "index.php?option=com_belgelendirme&task=checkBelgeNo&format=raw",
 			data: "belgeno="+belgeNoBas+'/'+sonSay+'&belgesayisi='+jQuery('input#belgeNo').length,
 			beforeSend:function(){
 				 jQuery.blockUI();
	 		},
 			success: function(data){ 
 	 			if(data.STATUS == true){
 	 				jQuery.each(data.BELGENO,function(key,val){
 	 					jQuery('input#belgeNo').eq(key).val(val);
 		 			});
 	 	 		}
 			},
 			complete : function (){
 				jQuery.unblockUI();
             }
 		});
			
// 			for(var i = sonSayString.length;i<5;i++){
// 				nobelge = nobelge+'0';
// 			}
	});

	jQuery('#gonder').live('click',function(e){
		e.preventDefault();
		if(confirm('Aday Sonuçlarını Göndermek istediğinizden emin misiniz? Gönderdikten sonra sonuç sayfasında işlem yapamazsınız.')){
			jQuery.blockUI();
			var belgeNoBas = '<?php echo $yetBelgeNo;?>';
			var belgeSira = 1;
			var tarihSira = 1;
			var belgeNoHata = 0;
			var belgeTarihHata = 0;
			var belNoArray = new Array();
			jQuery.each(jQuery('input#belgeNo'),function(key,val){
				if(val.value == '' || val.value.length == 0){
					belgeNoHata++;
					jQuery.unblockUI();
					jQuery('#UyariLoader #UyariContent').html(belgeSira+" No.'lu sıradaki adayın belge numarası geçersizdir. Lütfen tekrar girin.");
					jQuery('#UyariLoader').lightbox_me({
			        	 centered: true,
			             closeClick:false,
			             closeEsc:false  
		        	});
					return false;
				}else{
					var spplit = val.value.split('/');
					var valBelgeKod = spplit[0]+'/'+spplit[1]+'/'+spplit[2];
					var sonKisim = spplit[3];
					var sonKisNum = parseInt(spplit[3]);
					if(belgeNoBas != valBelgeKod){
						belgeNoHata++;
						jQuery.unblockUI();
						jQuery('#UyariLoader #UyariContent').html(belgeSira+" No.'lu sıradaki adayın belge numarası geçersizdir. Lütfen tekrar girin.");
						jQuery('#UyariLoader').lightbox_me({
				        	 centered: true,
				             closeClick:false,
				             closeEsc:false  
			        	});
						return false;
					}
					else if(jQuery.inArray(val.value,belNoArray)>-1){
						belgeNoHata++;
						jQuery.unblockUI();
						jQuery('#UyariLoader #UyariContent').html(belgeSira+" No.'lu sıradaki adayın belge numarası başka bir adayınki ile aynıdır. Lütfen değiştiriniz.");
						jQuery('#UyariLoader').lightbox_me({
				        	 centered: true,
				             closeClick:false,
				             closeEsc:false  
			        	});
						return false;
					}else if(sonKisim !== sonKisNum.toString()){
						belgeNoHata++;
						jQuery.unblockUI();
						jQuery('#UyariLoader #UyariContent').html(belgeSira+" No.'lu sıradaki adayın belge numarasının son '/' işaretinden sonraki hanesi 0 rakamı ile başlayamaz. Lütfen değiştiriniz.");
						jQuery('#UyariLoader').lightbox_me({
				        	 centered: true,
				             closeClick:false,
				             closeEsc:false  
			        	});
						return false;
					}
					else{
						jQuery.ajax({
							async: false,
							type:"POST",
							url:"index.php?option=com_belgelendirme&task=BelgeNoVarMi&format=raw",
							data:"belgeNo="+val.value,
							success:function(data){
								var dat = jQuery.parseJSON(data);
								if(dat){
									belgeNoHata++;
									jQuery.unblockUI();
									jQuery('#UyariLoader #UyariContent').html(belgeSira+" No.'lu sıradaki adayın belge numarası sistemde kayıtlı olan başka bir adayın belge numarası ile aynıdır. Lütfen değiştiriniz.");
									jQuery('#UyariLoader').lightbox_me({
							        	 centered: true,
							             closeClick:false,
							             closeEsc:false  
						        	});
									return false;
								}else{
									belNoArray.push(val.value);		
								}
							}
						});
						if(belgeNoHata>0){
							jQuery.unblockUI();
							return false;
						}
						
					}
					
				}
				belgeSira++;
			});
			jQuery.each(jQuery('input.belgeTarih'),function(key,val){
				if(val.value == '' || val.value.length == 0){
					belgeTarihHata++;
					jQuery.unblockUI();
					jQuery('#UyariLoader #UyariContent').html(tarihSira+" No.'lu sıradaki adayın belge verilme tarihi geçersizdir. Lütfen tekrar girin.");
					jQuery('#UyariLoader').lightbox_me({
			        	 centered: true,
			             closeClick:false,
			             closeEsc:false  
		        	});
					return false;
				}else{
					tarihSira++;
				}
			});

			var itirazHata = new Array();
			var i = 0;
			jQuery.each(jQuery('.itiraz_ucret'),function(key,val){
				data = jQuery('.itiraz_ucret:eq('+key+')').closest('tr').attr('id');
				tcDatas = data.split('_');
				tckimlik = tcDatas[1];
				if((jQuery('input[name="itiraz_ucret['+tckimlik+']"').val() != '' && jQuery('input[name="itiraz_ucret['+tckimlik+']"').length > 0) || 
				   (jQuery('input[name="itiraz_aciklama['+tckimlik+']"').val() != '' && jQuery('input[name="itiraz_aciklama['+tckimlik+']"').length > 0 )|| 
				   (jQuery('input[name="itiraz_dosya_lightbox['+tckimlik+']"').val() != '' && jQuery('input[name="itiraz_dosya_lightbox['+tckimlik+']"').length > 0)){
					if(jQuery('input[name="itiraz_ucret['+tckimlik+']"').val() == ''){
						itirazHata[i] = tckimlik+" Tc Kimlik numaralı aday için itiraz ücreti boş bırakılamaz.";
						i++;
					}

					if(jQuery('input[name="itiraz_aciklama['+tckimlik+']"').val() == ''){
						itirazHata[i] = tckimlik+" Tc Kimlik numaralı aday için itiraz açıklaması bırakılamaz.";
						i++;
					}

					if(jQuery('input[name="itiraz_dosya_lightbox['+tckimlik+']"').val() == ''){
						itirazHata[i] = tckimlik+" Tc Kimlik numaralı aday için itiraz dosyası bırakılamaz.";
						i++;
					}
				}
			});

			if(itirazHata.length > 0){
				jQuery.unblockUI();
				alert(itirazHata.join('\n'));
				return false;
			}

			if(dekontcontrol == true){
				
				var dekontnoHata = 0;
				jQuery.each(jQuery('input[name="dekontNo[]"]'),function(key,val){
					if(val.value == '' || val.value.length == 0){
						dekontnoHata++;
						jQuery.unblockUI();
						jQuery('#UyariLoader #UyariContent').html("Dekont Numarası boş bırakılamaz.");
						jQuery('#UyariLoader').lightbox_me({
				        	 centered: true,
				             closeClick:false,
				             closeEsc:false  
			        	});
						return false;
					}
				});
	
				var tutarHata = 0;
				jQuery.each(jQuery('input[name="tutar[]"]'),function(key,val){
					val.value.replace(',','.');
					if(val.value == '' || val.value.length == 0 || !jQuery.isNumeric(val.value)){
						tutarHata++;
						jQuery.unblockUI();
						jQuery('#UyariLoader #UyariContent').html("Dekont Tutarı boş bırakılamaz.");
						jQuery('#UyariLoader').lightbox_me({
				        	 centered: true,
				             closeClick:false,
				             closeEsc:false  
			        	});
						return false;
					}
				});
			}

			var dezHata = 0;
			jQuery('.DezCheck:checked').each(function(key,val){
				if(jQuery('#dezavantajfile_'+val.value).val() != 1){
					dezHata++;
					jQuery.unblockUI();
					jQuery('#UyariLoader #UyariContent').html(val.value+' TC Kimlik Numaralı aday Dezavantajlı olarak seçilmesine rağmen dezavantaj dosyası yüklenmemiştir. Lütfen Dezavantaj dosyasını yükleyiniz.');
					jQuery('#UyariLoader').lightbox_me({
			        	 centered: true,
			             closeClick:false,
			             closeEsc:false  
		        	});
					return false;
				}
			});

			var BasvuruFileHata = 0;
			var AbibanHata = 0;
			jQuery('.tebligAday[value="2"]:checked').each(function(key,val){
				var attrId = jQuery(this).closest('td').find('input.basvurufiledurum').attr('id');
				var pest = attrId.split("_");
				var tcno = pest[1];

				// Basvuru File Kontrol
				var deger = jQuery(this).closest('td').find('input.basvurufiledurum').val();
				if(deger == 0){
					BasvuruFileHata++;
					jQuery.unblockUI();
					jQuery('#UyariLoader #UyariContent').html(tcno+' kimlik numralı adayın Adayın Başvuru Formu sisteme ekleyeniz.');
					jQuery('#UyariLoader').lightbox_me({
			        	 centered: true,
			             closeClick:false,
			             closeEsc:false  
		        	});
					return false;
				}

				// Basvuru IBAN Kontrol
				var ibann = jQuery(this).closest('td').find('input.abiban').val();
				ibann = ibann.replace(/\s+/g, '')
				if(ibann.length != 26){
					AbibanHata++;
					jQuery.unblockUI();
					jQuery('#UyariLoader #UyariContent').html(tcno+' kimlik numaralı adayın AB Hibe kapsamında ücret iadesi yapılacak IBAN bilgisi eksik veya hatalıdır. Lütfen Kontrol ediniz.');
					jQuery('#UyariLoader').lightbox_me({
			        	 centered: true,
			             closeClick:false,
			             closeEsc:false  
		        	});
					return false;
				}
			});
			
			if(belgeTarihHata>0 || belgeNoHata>0 || dekontnoHata>0 || tutarHata>0 || dezHata>0 || BasvuruFileHata>0 || AbibanHata>0){
				return false;
			}else if(jQuery('#yetkiliAd').val()==''){
				jQuery.unblockUI();
				jQuery('#UyariLoader #UyariContent').html('Lütfen İmza Yetkilisi Adını giriniz.');
				jQuery('#UyariLoader').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
	        	});
			}else if(jQuery('#yetkiliSoyAd').val() == ''){
				jQuery.unblockUI();
				jQuery('#UyariLoader #UyariContent').html('Lütfen İmza Yetkilisi Soyadını giriniz.');
				jQuery('#UyariLoader').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
	        	});
			}else if(jQuery('#yetkiliUnvan').val()==''){
				jQuery.unblockUI();
				jQuery('#UyariLoader #UyariContent').html('Lütfen İmza Yetkilisi Ünvanını giriniz.');
				jQuery('#UyariLoader').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
	        	});
			}else{
				jQuery('#loaderGif').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
		        });
				jQuery('#BelgeNoGonder').submit();
			}
		}
	});

	jQuery('#dekSil').live('click',function(){
		jQuery(this).closest('tr').remove();
	});

	jQuery('#DekEkle').live('click',function(){
		jQuery('#dekTbody').append(DekontEkle);
	});

	jQuery('#tumTeblig').live('click',function(){
		jQuery('.tebligAday[value="'+jQuery('input[name="tebligTum"]:checked').val()+'"]').not('[disabled="disabled"]').prop('checked',true);
        if(jQuery('input[name="tebligTum"]:checked').val() == 1){
            jQuery('.tebligAday[value=1]:checked').each(function(){
                jQuery(this).closest('td').find(".abhibeContainer").hide();
                jQuery(this).closest('td').find(".tesvikContainer").show("slow");
            });
        }else{
            jQuery('.tebligAday[value=0]:checked').each(function() {
                jQuery(this).closest('td').find(".abhibeContainer").hide();
                jQuery(this).closest('td').find(".tesvikContainer").hide();
            });
        }
		//if(jQuery('.tebligAday[value=1]:checked').not('[disabled="disabled"]').length == jQuery('.tebligAday[value=1]').length){
        if(jQuery('.tebligAday[value=2]:checked').length == 0 && jQuery('.tebligAday[value=0]:checked').length == 0){
			dekontcontrol = false;
			<?php if(strtotime(str_replace('/', '-',$yets[0]['BASLANGIC_TARIHI'])) > strtotime(str_replace('/', '-','20/07/2015'))){ ?>
			if(jQuery(".tebligAday").not('[disabled="disabled"]').length > 0){
				jQuery("#dekontContainer").hide("slow");
			}
			<?php } ?>
			jQuery(".tebligAday").not('[disabled="disabled"]').find(".tesvikContainer").show("slow");
		}else{
			dekontcontrol = true;
			<?php if(strtotime(str_replace('/', '-',$yets[0]['BASLANGIC_TARIHI'])) > strtotime(str_replace('/', '-','20/07/2015'))){ ?>
			if(jQuery(".tebligAday").not('[disabled="disabled"]').length > 0){
				jQuery("#dekontContainer").show("slow");
			}
			<?php } ?>
			jQuery(".tebligAday").not('[disabled="disabled"]').find(".tesvikContainer").hide("slow");
		}	
	});

	jQuery(".tebligAday").not('[disabled="disabled"]').click(function(){
		
		if(jQuery(this).is(":checked") && jQuery(this).val() == "1"){
			jQuery(this).closest('td').find(".abhibeContainer").hide();
			jQuery(this).closest('td').find(".tesvikContainer").show("slow");
		}else if(jQuery(this).is(":checked") && jQuery(this).val() == "2"){
			jQuery(this).closest('td').find(".tesvikContainer").hide();
			var attrId = jQuery(this).closest('td').find('input[name="filebasvuru"]').attr('id');
			var pest = attrId.split("_");
			var tcno = pest[1];
			FuncABHibeBasvuruFileVarMi(tcno);
			jQuery(this).closest('td').find(".abhibeContainer").show("slow");
		}else if(jQuery(this).is(":checked") && jQuery(this).val() == "0"){
			jQuery(this).closest('td').find(".abhibeContainer").hide("slow");
			jQuery(this).closest('td').find(".tesvikContainer").hide("slow");
		}
		<?php if(strtotime(str_replace('/', '-',$yets[0]['BASLANGIC_TARIHI'])) > strtotime(str_replace('/', '-','20/07/2015'))) { ?>
		if(jQuery('.tebligAday[value=1]') && jQuery('.tebligAday[value=1]:checked').length > 0){
			//if(jQuery('.tebligAday[value=1]:checked').not('[disabled="disabled"]').length == jQuery('.tebligAday[value=1]').not('[disabled="disabled"]').length){
            if(jQuery('.tebligAday[value=2]:checked').length == 0 && jQuery('.tebligAday[value=0]:checked').length == 0){
				dekontcontrol = false;
				jQuery("#dekontContainer").hide("slow");
			}else{
				dekontcontrol = true;
				jQuery("#dekontContainer").show("slow");
			}
		}else{
            if(jQuery('.tebligAday[value=2]:checked').length == 0 && jQuery('.tebligAday[value=0]:checked').length == 0){
                dekontcontrol = false;
                jQuery("#dekontContainer").hide("slow");
            }else{
                dekontcontrol = true;
                jQuery("#dekontContainer").show("slow");
            }
        }
		<?php } ?>	
	});

	jQuery(".protestfee").click(function(){
		parentId = jQuery(this).closest("tr").attr("id");
		data = parentId.split('_');
		tcData = data[1];
		jQuery("#protestFeeContainer input[name=parentId]").val(jQuery(this).closest("tr").attr("id"));

		jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val('');
		jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val('');
		
		if(jQuery(this).closest('td').find('.itiraz_ucret').val() != ""){
			jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val(jQuery(this).closest('td').find('.itiraz_ucret').val());
		}

		if(jQuery(this).closest('td').find('.itiraz_aciklama').val != ""){
			jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val(jQuery(this).closest('td').find('.itiraz_aciklama').val());
		}
		
		if(jQuery(this).closest('td').find('.itiraz_dosya_lightbox').length > 0){
			jQuery("#protestFeeContainer #filecontain").append(jQuery(this).closest('td').find('.itiraz_dosya_lightbox'));
			jQuery("#protestFeeContainer .itiraz_dosya_lightbox").show();
		}else{
			jQuery("#protestFeeContainer #filecontain").html("<input type='file' class='itiraz_dosya_lightbox' name='itiraz_dosya["+tcData+"]' />"); 
		}

		jQuery("#protestFeeContainer").lightbox_me({
			overlaySpeed: 350,
			lightboxSpeed: 400,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	});

	jQuery("#cancelProtest").click(function(){
		parentId = jQuery("#protestFeeContainer input[name=parentId]").val();
		jQuery("#"+parentId+" td:last").append(jQuery("#protestFeeContainer .itiraz_dosya_lightbox"));
		jQuery("#"+parentId+" td:last .itiraz_dosya_lightbox").hide();

		if(jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val() != "" || jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val() != "" || jQuery("#protestFeeContainer .itiraz_dosya_lightbox").val() != null){
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltildi');
		}else{
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltme Talebi');
		}
		
 		jQuery('#protestFeeContainer').trigger('close');
	});

	jQuery("#saveProtest").click(function(){
		parentId = jQuery("#protestFeeContainer input[name=parentId]").val();
		jQuery("#"+parentId).find(".itiraz_ucret").val(jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val());
		jQuery("#"+parentId).find(".itiraz_aciklama").val(jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val());
		jQuery("#"+parentId+" td:last").append(jQuery("#protestFeeContainer .itiraz_dosya_lightbox"));
		jQuery("#"+parentId+" td:last .itiraz_dosya_lightbox").hide();

		if(jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val() != "" || jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val() != "" || jQuery("#protestFeeContainer .itiraz_dosya_lightbox").val() != null){
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltildi');
		}else{
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltme Talebi');
		}
		jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val("");
		jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val("");
		jQuery('#protestFeeContainer').trigger('close');
	});


	jQuery("#clearProtest").click(function(){

		parentId = jQuery("#protestFeeContainer input[name=parentId]").val();
		
		jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val("");
		jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val("");
		jQuery("#protestFeeContainer .itiraz_dosya_lightbox").val(null);

		if(jQuery("#protestFeeContainer input[name=itiraz_ucret_lightbox]").val() != "" || jQuery("#protestFeeContainer textarea[name=itiraz_aciklama_lightbox]").val() != "" || jQuery("#protestFeeContainer .itiraz_dosya_lightbox").val() != null){
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltildi');
		}else{
			jQuery("#"+parentId).find(".protestfee").val('Ücret Düzeltme Talebi');
		}
		
	});

	jQuery('input.tooltip').tooltipster({
		contentAsHTML: true,
		theme: 'tooltipster-shadow',
		positionTracker: true,
		interactive: true
    });

    jQuery('.DezCheck').live('change',function(e){
        e.preventDefault();
        var tc = jQuery(this).val();
        if(jQuery(this).prop('checked')){
        	jQuery.ajax({
        		async: false,
        		type : 'POST',
        		url : 'index.php?option=com_belgelendirme&task=GetDezFile&format=raw',
        		data : 'tc='+tc+'&sId=<?php echo $this->sinav_id;?>',
        		success : function(data) {
        			var dat = jQuery.parseJSON(data);
        			if(dat){
            			jQuery('#dezavantajfile_'+tc).val(1);
        				jQuery('#DezFile_'+tc).hide();
                        jQuery('#DezFileYuk_'+tc).show();
                        jQuery('#DezFileLink_'+tc).attr('href','index.php?dl=abhibe/dezavantaj/<?php echo $this->sinav_id;?>/'+dat['name']);
        			}else{
        				jQuery('#dezavantajfile_'+tc).val(0);
        				jQuery('#DezFile_'+tc).show();
                        jQuery('#DezFileYuk_'+tc).hide();
                        jQuery('#DezFileLink_'+tc).attr('href','#');
            		}
        	   }
        	});
        }else{
        	jQuery('#DezFileYuk_'+tc).hide();
        	jQuery('#DezFile_'+tc).hide();
        	jQuery('#dezavantajfile_'+tc).val(0);
        }
    });
});

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   
   if (!(
		   charCode == 8 
		   || charCode == 46 
		   || (charCode >= 35 && charCode <= 40)
		   || (charCode >= 48 && charCode <= 57)
     )){
      return false;
   }

   return true;
}

function DezFileYukle(tc,sId){
	var formData = new FormData();
	formData.append('file', jQuery('#filedez_'+tc)[0].files[0]);
	formData.append('tc', tc);
	formData.append('sId', sId);

	jQuery.ajax({
		async: false,
		url : 'index.php?option=com_belgelendirme&task=DezFileYukle&format=raw',
		type : 'POST',
		data : formData,
		processData: false,  // tell jQuery not to process the data
		contentType: false,  // tell jQuery not to set contentType
		success : function(data) {
			var dat = jQuery.parseJSON(data);
			if(dat['hata']){
				alert(dat['message']);
				jQuery('#dezavantajfile_'+tc).val(0);
			}else{
                jQuery('#DezFile_'+tc).hide();
                jQuery('#DezFileYuk_'+tc).show();
                jQuery('#DezFileLink_'+tc).attr('href','index.php?dl=abhibe/dezavantaj/'+sId+'/'+dat['name']);
                jQuery('#dezavantajfile_'+tc).val(1);
                alert(dat['message']);
            }
            jQuery('#loaderGif').trigger('close');
	   }
	});
}

function DezFileSil(tc,sId){
	jQuery.ajax({
		async: false,
		url : 'index.php?option=com_belgelendirme&task=DezFileSil&format=raw',
		type : 'POST',
		data : 'tc='+tc+'&sId='+sId,
		success : function(data) {
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('#dezavantajfile_'+tc).val(0);
				jQuery('#DezFileYuk_'+tc).hide();
                jQuery('#DezFile_'+tc).show();
                jQuery('#DezFileLink_'+tc).attr('href','#');
				alert('Aday Dezavantaj dosyası başarıyla silindi.');
			}else{
                alert('Bir hata meydana geldi. Tekrar deneyin.');
            }
            jQuery('#loaderGif').trigger('close');
	   }
	});
}

function FuncABHibeBasvuruFileVarMi(tc){
	jQuery.ajax({
		async: false,
		type : 'POST',
		url : 'index.php?option=com_belgelendirme&task=ABHibeBasvuruFileVarMi&format=raw',
		data : 'tc='+tc+'&sId=<?php echo $this->sinav_id;?>',
		success : function(data) {
			var dat = jQuery.parseJSON(data);
			if(dat){
    			jQuery('#basvurufiledurum_'+tc).val(1);
				jQuery('#BasvuruFile_'+tc).hide();
                jQuery('#BasvuruFileYuk_'+tc).show();
                jQuery('#BasvuruFileLink_'+tc).attr('href','index.php?dl=abhibe/basvuru/<?php echo $this->sinav_id;?>/'+dat['name']);
			}else{
				jQuery('#basvurufiledurum_'+tc).val(0);
				jQuery('#BasvuruFile_'+tc).show();
                jQuery('#BasvuruFileYuk_'+tc).hide();
                jQuery('#BasvuruFileLink_'+tc).attr('href','#');
    		}
	   }
	});
}

function FuncBasvuruFileYukle(tc,sId){
	var formData = new FormData();
	formData.append('file', jQuery('#fileBasvuru_'+tc)[0].files[0]);
	formData.append('tc', tc);
	formData.append('sId', sId);

	jQuery.ajax({
		async: false,
		url : 'index.php?option=com_belgelendirme&task=ABHibeBasvuruFileYukle&format=raw',
		type : 'POST',
		data : formData,
		processData: false,  // tell jQuery not to process the data
		contentType: false,  // tell jQuery not to set contentType
		success : function(data) {
			var dat = jQuery.parseJSON(data);
			if(dat['hata']){
				alert(dat['message']);
				jQuery('#basvurufiledurum_'+tc).val(0);
			}else{
                jQuery('#BasvuruFile_'+tc).hide();
                jQuery('#BasvuruFileYuk_'+tc).show();
                jQuery('#BasvuruFileLink_'+tc).attr('href','index.php?dl=abhibe/basvuru/'+sId+'/'+dat['name']);
                jQuery('#basvurufiledurum_'+tc).val(1);
                alert(dat['message']);
            }
            jQuery('#loaderGif').trigger('close');
	   }
	});
}

function FuncBasvuruFileSil(tc,sId){
	jQuery.ajax({
		async: false,
		url : 'index.php?option=com_belgelendirme&task=ABHibeBasvuruFileSil&format=raw',
		type : 'POST',
		data : 'tc='+tc+'&sId='+sId,
		success : function(data) {
			var dat = jQuery.parseJSON(data);
			if(dat){
				jQuery('#basvurufiledurum_'+tc).val(0);
				jQuery('#BasvuruFileYuk_'+tc).hide();
                jQuery('#BasvuruFile_'+tc).show();
                jQuery('#BasvuruFileLink_'+tc).attr('href','#');
				alert('Aday Başvuru dosyası başarıyla silindi.');
			}else{
                alert('Bir hata meydana geldi. Tekrar deneyin.');
            }
            jQuery('#loaderGif').trigger('close');
	   }
	});
}
</script>
