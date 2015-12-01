<style>
<!--
.marclass{
margin-bottom:5px;
}
-->
</style>
<?php
$data = $this->adays;

if(count($data)>0){
	echo "<div style='margin-left:50px'>";
	foreach($data["hataMesaji"] as $key=>$mesaj){
		
		switch ($key){
			case 1:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['hatalıTckimlik'] as $tckimlik){
					echo "<li>Satır No: ".$tckimlik[0].", TC Kimlik No:".$tckimlik[1]."</li>";
				}
			echo "<hr>";				
			break;
			
			case 2:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['tckimlik'] as $tckimlik){
					echo "<li>Satır No: ".$tckimlik[0].", TC Kimlik No:<a href='#' id='tcDeg'>".$tckimlik[1]."</a></li>";
				}
				echo "<hr>";
			break;
			
			case 3:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['sinavTuruKoduSatir'] as $satir){
					echo "<li>Satır No: ".$satir."</li>";
				}
				echo "<hr>";
			break;
			
			case 4:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['sinavTarihi'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
				}
				echo "<hr>";
			break;
			
			case 5:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['sinavYeri'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Sınav Yeri: ".$satir[1]."</li>";
				}
				echo "<hr>";
			break;
			
			case 6:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['degerlendirici'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Değerlendirici TCKN: ".$satir[1]."</li>";
				}
				echo "<hr>";
			break;
			
			case 7:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['mukerrer'] as $satir){
					echo "<li>Satır no: ".$satir."</li>";
				}
			break;
			
			case 8:
				echo  "<h2>".$mesaj."</h2>";
				break;
			
			case 9:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['sinavTarihi360'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
				}
			break;
			
			case 10:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['hataliCins'] as $satir){
					echo "<li>Satır no: ".$satir[0]."</li>";
				}
				foreach($data['hataliEgitim'] as $satir){
					echo "<li>Satır no: ".$satir[0]."</li>";
				}
				foreach($data['hataliCalisma'] as $satir){
					echo "<li>Satır no: ".$satir[0]."</li>";
				}
			break;
			
			case 11:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['hataliIban'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Iban: ".$satir[1]."</li>";
				}
			break;
			case 12:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['hataliEmail'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Email: ".$satir[1]."</li>";
				}
			break;
			
			case 13:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['sinavYeri'] as $satir){
					echo "<li>Satır no: ".$satir[0].", Sınav Yeri: ".$satir[1]."</li>";
				}
				echo "<hr>";
			break;
			
			case 14:
				echo  "<h2>".$mesaj."</h2>";
				foreach($data['tckimlik_sistem'] as $tckimlik){
					echo "<li>Satır No: ".$tckimlik[0].", TC Kimlik No:<a href='#' id='tcDeg'>".$tckimlik[1]."</a></li>";
				}
				echo "<hr>";
			break;
			
		}
		
		
	}
	echo "</div>";
	echo '<br>';
	echo '<a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav='.$_GET['sinav'].'">Dosyayı tekrar yükle.</a>';
}
else{
?>
<form method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&task=AdayKaydet&layout=adaylar">
<div style="overflow:auto">
<table border="1" width="100%" >
<thead>
  <tr>
    <th width="3%">#</th>
    <th width="5%">T.C. Kimilik No</th>
    <th width="10%">Ad</th>
    <th width="15%">Soyad</th>
    <th width="8%">Doğum Tarihi</th>
    <th width="10%">Doğum Yeri</th>
    <th width="10%">Baba Adı</th>
    <th width="5%">Cinsiyet</th>
    <th width="15%">Eğitimi</th>
    <th width="10%">Çalışma Durumu</th>
    <th width="10%">Yeterlilik Kodu</th>
    <th width="5%">Yeterlilik Birim Kodu</th>
    <th width="5%">Sınav Tür Kodu</th>
    <th width="8%">Sınav Tarihi</th>
    <th width="5%">Sınav Saati</th>
    <th width="10%">Sınav Yeri</th>
    <th width="10%">Değerlendirici/Gözetmen</th>
  </tr>
  </thead>
  <tbody>
<?php 
foreach ($adays as $aday){
	echo '<tr>';
	foreach ($aday as $key=>$cow){
if(empty($cow) || $cow ==''){
		
}else{
	if($key){
		
	}
		echo '<td><input type="text" name="'.$key.'[]" value="'.$cow.'" readonly="true" size="10"/></td>';
		}
	}
	echo '</tr>';
}
?>
  </tbody>
</table>

</div>
<input type="submit" value="Kaydet"/>
</form>
<?php }?>

<div id="yeniDis" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="marclass"><span style="color:#063B5E;">T.C. Kimlik No: </span><input id="tcKimlik" style="margin-left:14px" disabled/></div>
	<div class="marclass"><span style="color:#063B5E;">Adı: </span><input id="isim" style="margin-left:77px"/></div>
	<div class="marclass"><span style="color:#063B5E;">Soyadı: </span><input id="soyisim" style="margin-left:56px"/></div>
	<div class="marclass"><span style="color:#063B5E;">Doğum Tarihi: </span><input id="dtarih" style="margin-left:21px" readonly="true" /></div>
<!-- <div class="marclass"><span style="color:#063B5E;">Doğum Yeri: </span><input id="dyer" style="margin-left:29px"/></div>
	<div class="marclass"><span style="color:#063B5E;">Baba Adı: </span><input id="Bisim" style="margin-left:43px"/></div> -->	
	<div class="marclass"><span style="color:#063B5E;">Cinsiyeti: </span><select id="cins" style="margin-left:46px">
	<option id="a1" value="1">Erkek</option>
	<option id="a2" value="2">Kadın</option>
	<option id="a3" value="3">Belirtilmemiş</option>
	</select></div>
	<div class="marclass"><span style="color:#063B5E;">Eğitimi: </span><select id="egitim" style="margin-left:56px">
		<option id="b1" value="1">Okur Yazar Değil</option>
		<option id="b2" value="2">Okur Yazar</option>
		<option id="b3" value="3">İlkokul</option>
		<option id="b4" value="4">Orta Okul</option>
		<option id="b5" value="5">Meslek Lisesi</option>
		<option id="b6" value="6">Genel Lise</option>
		<option id="b7" value="7">Meslek Yüksekoulu</option>
		<option id="b8" value="8">Lisans</option>
		<option id="b9" value="9">Yüksek Lisans</option>
		<option id="b10" value="10">Doktora</option>
	</select></div>
	<div class="marclass"><span style="color:#063B5E;">Çalışma Durumu: </span><select id="cdurum">
		<option id="c1" value="1">Çalışıyor</option>
		<option id="c2" value="2">Çalışmıyor</option>
		<option id="c3" value="3">Staj Yapıyor</option>
	</select></div>
	<input type="button" id="AdayKaydet" value="Kaydet"/>
	<input type="button" id="iptal" value="İptal"/>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#iptal').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniDis').trigger('close');
	});
	
	jQuery('#tcDeg').live('click',function(e){
		e.preventDefault();
		var tcno = jQuery(this).html();
		//alert(tcno);
		jQuery('#tcKimlik').val(tcno);
		// pop up içini sil
		jQuery('#isim').val('');
		jQuery('#soyisim').val('');
		jQuery('#dtarih').val('');
		jQuery('#dyer').val('');
		jQuery('#Bisim').val('');
		
		
		jQuery.ajax({
			type:'post',
			url:'index.php?option=com_belgelendirme&task=tcKayitliAday&format=raw',
			data:'tcno='+tcno,
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat.length>0){
					jQuery('#isim').val(dat[0]['ADI']);
					jQuery('#soyisim').val(dat[0]['SOYADI']);
					jQuery('#dtarih').val(dat[0]['DOGUM_TARIHI']);
					jQuery('#dyer').val(dat[0]['DOGUM_YERI']);
					jQuery('#Bisim').val(dat[0]['BABA_ADI']);

					
					if(dat[0]['CINSIYETI'] == 1){
						jQuery('#a1').attr('selected',true);
					}
					else if (dat[0]['CINSIYETI'] == 2){
						jQuery('#a2').attr('selected',true);
					}
					else{
						jQuery('#a3').attr('selected',true);
					}
					

					
					
					if(dat[0]['EGITIMI'] == 1){
						jQuery('#b1').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 2){
						jQuery('#b2').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 3){
						jQuery('#b3').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 4){
						jQuery('#b4').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 5){
						jQuery('#b5').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 6){
						jQuery('#b6').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 7){
						jQuery('#b7').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 8){
						jQuery('#b8').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 9){
						jQuery('#b9').attr('selected',true);
					}
					else if(dat[0]['EGITIMI'] == 10){
						jQuery('#b10').attr('selected',true);
					}

					if(dat[0]['CALISMA_DURUMU'] == 1){
						jQuery('#c1').attr('selected',true);
					}
					else if(dat[0]['CALISMA_DURUMU'] == 2){
						jQuery('#c2').attr('selected',true);
					}
					else if(dat[0]['CALISMA_DURUMU'] == 3){
						jQuery('#c2').attr('selected',true);
					}
					
					jQuery('#yeniDis').lightbox_me({
				        centered: true, 
				        });
				}
			}
		});
		
	});

	jQuery('#AdayKaydet').live('click',function(e){
		e.preventDefault();
		
		var tcno = jQuery('#tcKimlik').val();
		if(jQuery('#isim').val() == ''){
			alert('Adı bölümünü boş bırakmayınız.');
		}
		else if(jQuery('#soyisim').val() == ''){
			alert('Soyadı bölümünü boş bırakmayınız.');
		}
		else if(jQuery('#dtarih').val() == ''){
			alert('Doğum Tarihi bölümünü boş bırakmayınız.');
		}
// 		else if(jQuery('#dyer').val() == ''){
// 			alert('Doğum Yeri bölümünü boş bırakmayınız.');
// 		}
// 		else if(jQuery('#Bisim').val() == ''){
// 			alert('Baba Adı bölümünü boş bırakmayınız.');
// 		}

		else{
			jQuery.ajax({
				type:'post',
				url:'index.php?option=com_belgelendirme&task=AdayUpdate&format=raw',
				data:'tcno='+jQuery('#tcKimlik').val()+'&ad='+jQuery('#isim').val()+'&soyad='+jQuery('#soyisim').val()+'&dtarih='+jQuery('#dtarih').val()+'&cins='+jQuery('#cins').val()+'&egitim='+jQuery('#egitim').val()+'&Cdurum='+jQuery('#cdurum').val(),
				success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat){
						jQuery('#yeniDis').trigger('close');
						alert('Başarıyla düzeltildi.');
// 						if(jQuery('#tcDeg').length == 0){
// 							alert('Son gönderdiğiniz dosyayı tekrar gönderiniz.');
//							window.location.href = 'index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav=<?php echo $_GET['sinav']?>';
 						//}
					}
				}
			});
		}
		
	});

	jQuery('#dtarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
				dateFormat: 'dd/mm/yy',
		        changeYear: true,
		        changeMonth: true
		     });
		});
});
</script>