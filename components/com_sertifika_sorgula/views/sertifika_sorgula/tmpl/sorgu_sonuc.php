<?php defined('_JEXEC') or die('Restricted access'); 
$kisi = $this->user; 
?>
<div class="form_element cf_heading">
	<h1 class="contentheading">Mesleki Yeterlilik Belgesi Sorgu Sonuçları</h1>

	<div style="clear: both;"></div>
</div>


<?php
$data = $this->data[0];
$exdata = $this->data[1];

if (empty($data) && empty($exdata)){
?>
	<div class=no_result>Uygun sonuç bulunamadı.</div>
<?php
}else if(!empty($data)){
	$serid = array();
	foreach ($data as $rows){
		if(!in_array($rows["SERTIFIKA_BASVURU_ID"], $serid))
			$serid[] = $rows["SERTIFIKA_BASVURU_ID"];
	}
	
	function getAnabilgiler($data, $serId){
		$ekle = '';
		foreach($data as $tows){
			if($tows["SERTIFIKA_BASVURU_ID"] == $serId){
				$ekle .= '<tr style="overflow:auto"><td>'.$tows["TC_KIMLIK"].'</td>'
						.'<td>'.$tows["OGRENCI_ADI"].'</td>'
						.'<td>'.$tows["OGRENCI_SOYADI"].'</td>'
						.'<td>'.$tows["KURULUS_ADI"].'</td>'
						.'<td>'.$tows["SER_TARIH"].'</td>'
						.'<td>'.$tows["YETERLILIK_KODU"].' - '.$tows["YETERLILIK_ADI"].'</td>';
				return $ekle;
			}
		}
	}
	
	function getBirimler($data, $serId){
		$birimler = array();
		$ekle = '<td>';
		foreach($data as $tows){
			if($tows["SERTIFIKA_BASVURU_ID"] == $serId){
				if($tows["YENI_MI"] == 0){
					$birimler[] = $tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'- '.$tows["BIRIM_ADI"];
					/*if($tows["SEKIL"] == 0){
						if(!in_array(($tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Teorik)- '.$tows["BIRIM_ADI"]), $birimler)){
							$birimler[] = $tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Teorik)- '.$tows["BIRIM_ADI"];
						}
						//$ekle .= $tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Teorik)- '.$tows["BIRIM_ADI"].'<br/><hr/>';
					}
					else{ 
						if(!in_array(($tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Pratik)- '.$tows["BIRIM_ADI"]), $birimler)){
							$birimler[] = $tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Pratik)- '.$tows["BIRIM_ADI"];
						}
						//$ekle .= $tows["BIRIM_KODU"].'/'.$tows["BIRIM_NO"].'(Pratik)- '.$tows["BIRIM_ADI"].'<br/><hr/>';
					}*/
				}
				else{
					$birimler[] = $tows["BIRIM_KODU"].'- '.$tows["BIRIM_ADI"];
					/*if($tows["SEKIL"] == 'P'){
						if(!in_array(($tows["BIRIM_KODU"].'(Pratik)- '.$tows["BIRIM_ADI"]), $birimler)){
							$birimler[] = $tows["BIRIM_KODU"].'(Pratik)- '.$tows["BIRIM_ADI"];
						}
						//$ekle .= $tows["BIRIM_KODU"].'(Pratik)- '.$tows["BIRIM_ADI"].'<br/><hr/>';
					}
					else{
						if(!in_array(($tows["BIRIM_KODU"].'(Teorik)- '.$tows["BIRIM_ADI"]), $birimler)){
							$birimler[] = $tows["BIRIM_KODU"].'(Teorik)- '.$tows["BIRIM_ADI"];
						}
						//$ekle .= $tows["BIRIM_KODU"].'(Teorik)- '.$tows["BIRIM_ADI"].'<br/><hr/>';
					}*/
				}
			}
		}
		foreach ($birimler as $cows){
			$ekle.=$cows.'<br/><hr/>';
		}
		return $ekle.'</td>';
	}
	
	function getDuznelenecekBilgiler($data, $serId, $kisi){
		$ekle = '';
		foreach($data as $tows){
			if($tows["SERTIFIKA_BASVURU_ID"] == $serId){
				if($kisi == 2){
					//if($tows["SERTIFIKA_DURUM_ID"] == 0){
						$ekle .= '<td><input size="20" type="text" id="yetkili" name="yetkili['.$serId.']" value="'.$tows["YETKILI"].'"/></td>'
						.'<td><input size="20" type="text" id="unvan" name="unvan['.$serId.']" value="'.$tows["UNVAN"].'"/></td>'
						.'<td><textarea rows="7" cols="40" type="text" id="ogrenmecikti" name="ogrenmecikti['.$serId.']" />'.$tows["OGRENME_CIKTI"].'</textarea></td>'
						.'<td><input size="10" type="text" class="belgegectarih" name="belgegectarih['.$serId.']" value="'.$tows["SERTIFIKA_GECERLILIK_TARIHI"].'"/></td>'
						.'<td><input size="10" type="text" class="belgeduztarih" name="belgeduztarih['.$serId.']" value="'.$tows["SERTIFIKA_DUZENLENME_TARIHI"].'"/></td>'
						.'<td><input size="10" type="text" class="sinavtarih" name="sinavtarih['.$serId.']" value="'.$tows["SINAV_TARIHI"].'"/></td>'
						.'<td><input type="text" size="10" id="belgeno" name="belgeno['.$serId.']" value="'.$tows["SERTIFIKA_NO"].'"/></td>';
						return $ekle;
					}
					/*else if($tows["SERTIFIKA_DURUM_ID"] == -1){
						$ekle = '<td>'.$tows["SERTIFIKA_GECERLILIK_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_DUZENLENME_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_NO"].'</td>';
						return $ekle;
					}
					else if($tows["SERTIFIKA_DURUM_ID"] == 1){
						$ekle = '<td>'.$tows["SERTIFIKA_GECERLILIK_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_DUZENLENME_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_NO"].'</td>';
						return $ekle;
					}
				}*/
				else{
					$ekle = '<td>'.$tows["YETKILI"].'</td>'
						.'<td>'.$tows["UNVAN"].'</td>'
						.'<td>'.$tows["OGRENME_CIKTI"].'</td>'  
						.'<td>'.$tows["SERTIFIKA_GECERLILIK_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_DUZENLENME_TARIHI"].'</td>'
						.'<td>'.$tows["SINAV_TARIHI"].'</td>'
						.'<td>'.$tows["SERTIFIKA_NO"].'</td>';
						return $ekle;
				}
			}
		}
	}
	
	function getDurum($data, $serId, $kisi){
		$ekle = '';

		foreach($data as $tows){
			if($tows["SERTIFIKA_BASVURU_ID"] == $serId){
				if($tows["SERTIFIKA_DURUM_ID"] == 0){
					if($kisi == 2){
					$ekle .= '<td><select name="durum['.$serId.']">
					<option value="'.$tows["SERTIFIKA_DURUM_ID"].'">'.$tows["SERTIFIKA_DURUM_ADI"].'</option>
					<option value="1">Onayla</option>
					<option value="-1">Reddet</option>
					</select></td>
					<td><input type="checkbox" name="serId[]" value="'.$serId.'"/></td>'
					.'<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
					}
					else{
						$ekle = '<td>'.$tows["SERTIFIKA_DURUM_ADI"].'</td>'
						.'<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
					}
				}
				else if($tows["SERTIFIKA_DURUM_ID"] == 1){
					if($kisi == 2){
					$ekle .= '<td><select name="durum['.$serId.']">
					<option value="'.$tows["SERTIFIKA_DURUM_ID"].'">'.$tows["SERTIFIKA_DURUM_ADI"].'</option>
					<option value="0">Beklet</option>
					<option value="-1">Reddet</option>
					</select></td>
					<td><input type="checkbox" name="serId[]" value="'.$serId.'"/></td>'
					.'<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
					}
					else{
						$ekle = '<td>'.$tows["SERTIFIKA_DURUM_ADI"].'</td>'
						.'<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
					}
				}
				else if($tows["SERTIFIKA_DURUM_ID"] == -1){
					if($kisi == 2){
						$ekle .= '<td><select name="durum['.$serId.']">
										<option value="'.$tows["SERTIFIKA_DURUM_ID"].'">'.$tows["SERTIFIKA_DURUM_ADI"].'</option>
										<option value="1">Onayla</option>
										<option value="0">Beklet</option>
										</select></td>
										<td><input type="checkbox" name="serId[]" value="'.$serId.'"/></td>
										<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
						/*$ekle = '<td>'.$tows["SERTIFIKA_DURUM_ADI"].'</td>'
						.'<td><input type="checkbox" name="serId[]" value="'.$serId.'" DISABLED/></td>'
						.'<td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';*/ 
					}
					else{
						$ekle = '<td>'.$tows["SERTIFIKA_DURUM_ADI"].'</td><td><a href="index.php?option=com_sertifika_sorgula&view=sertifika_sorgula&layout=pdf&format=pdf&ser_id='.$serId.'">Görüntüle</a></td>';
					}
				}
				return $ekle;
			}
		}
	}
?>
<form method="post" action="index.php?option=com_sertifika_sorgula&task=sertifikaVer">
		<div class="title">
			<span>Mesleki Yeterlilik Belgesi</span>
		</div>
		
		<div class="tableWrapper" style="overflow-x:auto;">
			<table cellspacing="0" class="paginate-10 sortable" border="1" id="sorguSonucTable"  width="2200px" style="font-size: smaller;">
				<thead>
					<tr>
						<th class="sortable-numeric">TC Kimlik No</th>
						<th class="sortable-text">Ad</th>
						<th class="sortable-text">Soyad</th>
						<th class="sortable-text">Kuruluş Adı</th>
						<th class="sortable-date-dmy">Başvuru Tarihi</th>
						<th class="sortable-text">Yeterlilik</th>
						<th class="sortable-text" width="500px">Birimler</th>
						<th class="sortable-text">Yetkili</th>
						<th class="sortable-text">Yetkili Ünvanı</th>
						<th class="sortable-text" width="200px">Yeterliliğine İlişkin Öğrenme Çıktıları</th>
						<th class="sortable-date-dmy">Belge Geçerlilik Tarihi</th>
						<th class="sortable-date-dmy">Belge Düzenleme Tarihi</th>
						<th class="sortable-date-dmy">Sınav Tarihi</th>
						<th class="sortable-text">Belge No</th>
						<th class="sortable-text">Sertifika Durum</th>
						<?php if($kisi == 2){?>
						<th class="sortable-text">Sertifika Ver</th>
						<?php }?>
						<th class="sortable-text">Sertifika Görüntüle</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach($serid as $cows){
						echo getAnabilgiler($data, $cows);
						echo getBirimler($data, $cows);
						echo getDuznelenecekBilgiler($data, $cows, $kisi);
						echo getDurum($data, $cows, $kisi);
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
			<div style="clear: both;"></div>
		</div>
		<?php if($kisi == 2){?>
<input type="submit" value="Kaydet">
<?php }?>
</form>
<?php
}
?>
<div id="eskidata">
<?php
foreach($exdata as $row){
?>
		<div class="title">
			<span>Mesleki Yeterlilik Belgesi</span>
		</div>
		
		<div class="wrap">
			<div class="item">
				<div class="item_title">
					<span>TC Kimlik No:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["TCKIMLIKNO"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
		
			<div class="item">
				<div class="item_title">
					<span>Ad:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["AD"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
		
			<div class="item">
				<div class="item_title">
					<span>Soyad:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["SOYAD"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge No:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGENO"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Yeterlilik Adı:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["YETERLILIK_ADI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Yeterliliğin Seviyesi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["YETERLILIK_SEVIYESI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Sınav Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["SINAV_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge Düzenleme Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGE_DUZENLEME_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belge Geçerlilik Tarihi:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["GECERLILIK_TARIHI"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<div class="item">
				<div class="item_title">
					<span>Belgelendirme Kuruluşu:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["BELGELENDIRME_KURULUSU"];?> </span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<?php if($row["BELGEDURUMU"] == 2){?>
			<div class="item">
				<div class="item_title">
					<span>Belge Durumu:</span>
				</div>
				<div class="item_text">
					<span style="color:red">Belge İptal Edildi.</span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			
			<div class="item">
				<div class="item_title">
					<span>Belge İptal Açıklaması:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["IPTAL_ACIKLAMA"];?></span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<?php }else if($row["BELGEDURUMU"] == 3){?>
			<div class="item">
				<div class="item_title">
					<span>Belge Durumu:</span>
				</div>
				<div class="item_text">
					<span style="color:red">Belge Askıya Alındı.</span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			
			<div class="item">
				<div class="item_title">
					<span>Belge Askıya Alınma Açıklaması:</span>
				</div>
				<div class="item_text">
					<span><?php echo $row["IPTAL_ACIKLAMA"];?></span>
				</div>
		
				<div style="clear: both;"></div>
			</div>
			<?php }else if($row["BELGEDURUMU"] == 4){ ?>
				<div class="item">
					<div class="item_title">
						<span>Belge Durumu:</span>
					</div>
					<div class="item_text">
						<span style="color:red">Belge geçerlilik tarihi dolmuştur.</span>
					</div>
					<div style="clear: both;"></div>
				</div>
			<?php }else{?>
				<div class="item">
				<div class="item_title">
					<span>Belge Durumu:</span>
				</div>
				<div class="item_text">
					<span style="color:green">Belge Geçerli.</span>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php }?>
		
			<div style="clear: both;"></div>
		</div>
<?php
	}
?>
</div>


<script type="text/javascript">

jQuery(".belgegectarih").live("hover",function(){
	//jQuery(".tarihsecbuton").hide();
	jQuery(this).datepicker({  
        duration: '',  
        showTime: true,  
        constrainInput: false,
        changeYear: true,
        changeMonth: true,  
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: false  
     });
});

jQuery('#sorguSonucTable tbody tr *').live('click', function (e) {

	var thisRow = jQuery(this)[0];
	var thisTableBody = jQuery(this).parent()[0];

	while(thisRow.getTag()!="tr")
	{
		thisRow = thisRow.getParent();
		thisTableBody = thisTableBody.getParent();
	}
		
	for(var i=0; i<thisTableBody.getChildren().length; i++)
	{
		if(	thisTableBody.getChildren()[i].classList!=undefined 
			&& thisTableBody.getChildren()[i].classList.contains("odd"))
			jQuery(thisTableBody.getChildren()[i]).css("background-color","#E1E1E1");
		else
			jQuery(thisTableBody.getChildren()[i]).css("background-color","white");
	}
	jQuery(thisRow).css("background-color","#C1D1E1");

});


jQuery(".belgeduztarih").live("hover",function(){
	//jQuery(".tarihsecbuton").hide();
	jQuery(this).datepicker({  
        duration: '',  
        showTime: true,  
        constrainInput: false,
        changeYear: true,
        changeMonth: true,  
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: false  
     });
});

jQuery(".sinavtarih").live("hover",function(){
	//jQuery(".tarihsecbuton").hide();
	jQuery(this).datepicker({  
        duration: '',  
        showTime: true,  
        constrainInput: false,
        changeYear: true,
        changeMonth: true,  
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: false  
     });
});

function goToPage(ser_id){
    window.location.href="index.php?option=com_belgelendirme_basvur&layout=pdf&format=pdf&ser_id=".$ser_id;
}
</script>