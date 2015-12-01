<style>
.blueBackgrounded
{
	background-color: #C6D9F1;
	font-weight: bold;
}
</style>
<?php 
$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>

<form
	<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=secmeli&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
		<div class="form_element cf_heading">
			<h1 class="contentheading">YETERLİLİĞİ OLUŞTURAN YETERLİLİK BİRİMLERİ</h1>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
		<div class="form_element cf_heading">
			<h2 class="contentheading">Grup B: Seçmeli Yeterlilik Birimleri</h2>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
		<div class="form_element cf_textarea">
			<textarea class="cf_inputbox" rows="3" <?php echo $readOnly;?>
				id="secmeli_aciklama" title="" cols="50" name="secmeli_aciklama"><?php echo $this->taslakYeterlilik["SECMELI_ACIKLAMA"] ? $this->taslakYeterlilik["SECMELI_ACIKLAMA"] : "";?></textarea>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
		<div class="form_element cf_button">
			<input type="button" id="aciklamaKaydet" value="Açıklama Kaydet" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	<br>

	<div class="form_item">
		<div class="form_element cf_placeholder">
			<div id="secmeli_birim_div">
				<table id="tablo_zorunlu_birim" style="width: 100%;">
					<thead class="tablo_header">
						<tr>
							<th width="8%">Sıra No</th>
							<th width="10%">Birim No</th>
							<th width="72%">Birim Adı</th>
							<th width="5%">Güncelle</th>
							<th width="10%">Birim Türleri</th>
							<th width="5%">Sil</th>
						</tr>
					</thead>
					<tbody>
				<?php 
				$sqy = 1;
				foreach ($this->secmeliBirim as $row){
					if($sqy%2==0){
						echo '<tr class="tablo_row" id="zor_'.$row['YETERLILIK_ALT_BIRIM_ID'].'">';
					}else{
						echo '<tr class="tablo_row2" id="zor_'.$row['YETERLILIK_ALT_BIRIM_ID'].'">';
					}
					
					echo '<td>'.$sqy.'</td>';
					echo '<td>'.$row['YETERLILIK_ALT_BIRIM_NO'].'</td>';
					echo '<td><input type="text" value="'.$row['YETERLILIK_ALT_BIRIM_ADI'].'" id="birimAdi" size="92"/></td>';
					echo '<td><input type="button" id="guncelle" value="Güncelle"/></td>';
					echo '<td><input type="button" id="turs" value="Tür"/></td>';
					echo '<td><input type="button" id="sil" value="Sil"/></td>';
					echo '</tr>';
					$sqy++;
				}
				?>
			</tbody>
				</table>
			</div>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px; margin-bottom: 25px">
		<div class="form_element cf_button">
			<input value="Yani Seçmeli Birim Ekle" id="sBirimekle" type="button" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

<div class="form_item">
		<div class="form_element cf_heading">
			<h1 class="contentheading">BİRİMLERİN GRUPLANDIRMA ALTERNATİFLERİ</h1>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
		<div class="form_element cf_textarea">
			<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
				id="alternatif" title="" cols="50" name="alternatif"><?php echo $this->taslakYeterlilik["YETERLILIK_GRUP_ALTERNATIF"];?></textarea>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Gruplandırma Alternatifi Kaydet" id="gBririmEkle"
				type="button" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"
				onclick="yorumKaydet('secmeli', <?php echo $this->yeterlilik_id;?>)" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<?php 
$secmeliBirimTur = $this->secmeliBirimTur;
foreach ($this->secmeliBirim as $row){?>
<div id="BirimTurs_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>" style=" min-width: 80%; max-height:80%; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
<form action="index.php?option=com_yeterlilik_taslak&task=turKaydet&layout=secmeli&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" method="post" style="padding:5px" id="turForm_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>">
<table id="birimTurleri_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>" border="1" style="width:100%; float:left;margin-bottom:10px;">
	<tr>
		<td class="blueBackgrounded">Birim Adı:</td>
		<td><?php echo $row['YETERLILIK_ALT_BIRIM_ADI'];?></td>
	</tr>
	<tr>
		<td class="blueBackgrounded">Referans Kodu:</td>
		<td><?php echo $row['YETERLILIK_ALT_BIRIM_NO'];?></td>
	</tr>
	<tr id="teorikSinavlarRow-0" class="teorikSinavlarRow">
		<td colspan="2" class="blueBackgrounded">Teorik Sınav <input type="button" class="teorikSinavEkleButton" id="teorikSinavEkleButton_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>" value="EKLE"></td>
	</tr>
	<?php 
	$say = 1;
	foreach($secmeliBirimTur[$row['YETERLILIK_ALT_BIRIM_ID']] as $cow){
		if($cow['TUR'] == 1){
			echo '<tr id="teorikSinavlarRow-'.$say.'" class="teorikSinavlarRow">';
			echo '<td class="blueBackgrounded" style="width:30px"><input class="teorikSinavSilButton" type="button" value="SİL"></td>';
			echo '<td><strong>TÜR KODU</strong><br>'.'<input type="text" value="'.$cow['TUR_KODU'].'" class="TeorikSinavTuru" name="TeorikSinavTuru['.$say.']" style="width:400px;"><br>'
			.'<strong>SINAV ADI</strong><br>'.'<input class="ciftTirnaksiz" type="text" value="'.$cow['TUR_ADI'].'" name="TeorikSinavAdi['.$say.']" style="width:400px;"><br>'
  			.'<strong>SINAV AÇIKLAMASI</strong><br>'.'<textarea class="ciftTirnaksiz" name="TeorikSinavAciklama['.$say.']" rows="3" style="width:100%;">'.$cow['TUR_ACIKLAMA'].'</textarea></td></tr>';
		}
	}?>
	<tr class="performansSinavlariRow" id="performansSinavlariRow-0">
		<td colspan="2" class="blueBackgrounded">Performansa Dayalı Sınav <input type="button" class="performansSinaviEkleButton" id="performansSinaviEkleButton_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>" value="EKLE"></td>
	</tr>
	<?php
	$say = 1; 
	foreach($secmeliBirimTur[$row['YETERLILIK_ALT_BIRIM_ID']] as $cow){
		if($cow['TUR'] == 2){
		echo '<tr id="performansSinavlariRow-'.$say.'" class="performansSinavlariRow">';
		echo '<td class="blueBackgrounded" style="width:30px"><input class="performansSinaviSilButton" type="button" value="SİL"></td>';
		echo '<td><strong>TÜR KODU</strong><br>'
		.'<input type="text" value="'.$cow['TUR_KODU'].'" class="PerformansSinavTuru" name="PerformansSinavTuru['.$say.']" style="width:400px;"><br>'
		.'<strong>SINAV ADI</strong><br>'
		.'<input class="ciftTirnaksiz" type="text" value="'.$cow['TUR_ADI'].'" name="PerformansSinavAdi['.$say.']" style="width:400px;"><br>'
		.'<strong>SINAV AÇIKLAMASI</strong><br>'
		.'<textarea class="ciftTirnaksiz" name="PerformansSinavAciklama['.$say.']" rows="3" style="width:100%;">'.$cow['TUR_ACIKLAMA'].'</textarea></td></tr>';
		
		}
	}?>
</table>

<input type="hidden" name="BirimId" value="<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>"/>
<input type="button" value="Kaydet" onclick="TurKaydet(<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>)"/>
<input type="button" onclick="lightboxClose('BirimTurs_<?php echo $row['YETERLILIK_ALT_BIRIM_ID'];?>')" value="İptal"/>
</form>
</div>
<?php }?>

<div id="secmeliBirimler"
	style="min-width: 10px; min-height: 10px; background-color: white; border: 1px solid #00A7DE; display: none; padding: 20px">
	<form id="secmeliForm"
		action="index.php?option=com_yeterlilik_taslak&layout=secmeli&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>"
		method="post">
		<strong>Seçmeli Birim Adı</strong><br> <br> <input type="text"
			name="zbirim" id="zbirim" size="50" /><br> <br> <input type="hidden"
			name="tip" value="0" /> <input type="button" value="Kaydet"
			id="secmeliKaydet" /> <input type="button" value="İptal"
			id="secmeliIptal" />
	</form>
</div>

<div id="loaderGif"
	style="min-width: 10px; min-height: 10px; background-color: white; border: 1px solid #00A7DE; display: none; padding: 20px">
	<img src="media/system/images/ajax-loader.gif">
</div>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";

// dTables.secmeli_birim = new Array(new Array("text","","4", "", readOnly),
// 								  new Array("text","", "5", "", "readOnly"),
// 								  new Array("text","required", "100", "", readOnly),
// 								  new Array("text","numeric", "5", "", readOnly));

// function createTables(){
// 	var tableName = 'secmeli_birim'; 
// 	var headers   = new Array ('Sıra No', 'Birim No','Birim Adı', 'Kredi Değeri');
// 	createTable(tableName, headers);
// 	patchSatirEkle(tableName, headers, tableName);
// 	addSecmeliValues (dTables.secmeli_birim, tableName);

// 	if (isReadOnly){
// 		satirEkleKaldir (tableName);
// 		satirSilKaldir (tableName, 3);
// 	}
// }

// function addSecmeliValues (secmeli, name){
// 	var length = secmeli.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
// 	var arrId  = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = secmeli[i][0];
// 	}
	<?php
// 	$tableCount = count ($this->secmeliBirim);

// 	$c = 0;
// 	$id = 0;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $this->secmeliBirim[$i];
// 		echo 'arrId['.$id++.']= "'.$arr["YETERLILIK_ALT_BIRIM_ID"].'";';
		
// 		echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_NO"]) .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_ADI"]) .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ALT_BIRIM_KREDI"]) .'";';
// 	}
// 	?>
	
// 	if (isset (arr))
// 		addTableValues (arr, params, name, arrId);
// }

			jQuery(document).ready(function(){
				jQuery('#sil').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).closest('tr').attr('id').split('_');
					var yetId = <?php echo $this->yeterlilik_id;?>;
					jQuery.ajax({
						type:"POST",
						url:"index.php?option=com_yeterlilik_taslak&task=ajaxZorunluBaglimi&format=raw",
						data:'birimId='+id[1]+'&yetId='+yetId,
						success:function(data){
							var dat = jQuery.parseJSON(data);
							if(dat){
								alert('Silmek istediğiniz birime bağlı ekler bulunmaktadır. Önce eklerden silmeniz gerekmektedir.');
							}else{
								if(confirm('Seçmeli birimi silmek istediğinizden emin misiniz?')){
									jQuery('#secmeliBirimler').trigger('close');
									jQuery('#loaderGif').lightbox_me({
							            centered: true,
							            closeClick:false,
							            closeEsc:false
							        });
									jQuery.ajax({
										type:"POST",
										url:"index.php?option=com_yeterlilik_taslak&task=ajaxZorunluSil&format=raw",
										data:'birimId='+id[1]+'&yetId='+yetId+'&tur=1',
										success:function(data){
											window.location.reload();
										}
									});
								}
							}	
						}									
					});		
				});

				jQuery('#sBirimekle').live('click',function(e){
					e.preventDefault();
					jQuery('#zbirim').val('');
					jQuery('#secmeliBirimler').lightbox_me({
			            centered: true,
			            closeClick:false,
			            closeEsc:false
			        });
				});

				jQuery('#secmeliIptal').live('click',function(e){
					e.preventDefault();
					jQuery('#secmeliBirimler').trigger('close');
				});

				jQuery('#secmeliKaydet').live('click',function(e){
					e.preventDefault();
					var birim = jQuery('#zbirim').val();
					if(birim = '' || birim.length == 0){
						alert('Lütfen Seçmeli Birim Adını boş bırakmayınız.');
					}
					else{
						jQuery('#secmeliForm').submit();
					}
				});

				jQuery('#guncelle').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).closest('tr').attr('id').split('_');
					var yetId = <?php echo $this->yeterlilik_id;?>;
					var birim = jQuery(this).closest('tr').children('td').children('#birimAdi').val();
					if(birim.length == 0 || birim == ''){
						alert('Lütfen Birim Adını giriniz.');
					}else{
						jQuery('#loaderGif').lightbox_me({
				            centered: true,
				            closeClick:false,
				            closeEsc:false
				        });
						jQuery.ajax({
							type:"POST",
							url:"index.php?option=com_yeterlilik_taslak&task=ajaxZorunluGuncelle&format=raw",
							data:'birimId='+id[1]+'&yetId='+yetId+'&birim='+birim,
							success:function(data){
								window.location.reload();
							}
						});
					}
				});

				jQuery('#aciklamaKaydet').live('click',function(e){
					e.preventDefault();
					var acik = jQuery('#secmeli_aciklama').val();
					var yetId = <?php echo $this->yeterlilik_id;?>;
					jQuery('#loaderGif').lightbox_me({
			            centered: true,
			            closeClick:false,
			            closeEsc:false
			        });
					jQuery.ajax({
						type:"POST",
						url:"index.php?option=com_yeterlilik_taslak&task=ajaxAciklamaKaydet&format=raw",
						data:"acik="+acik+'&tur=secmeli_birim&yetId='+yetId,
						success:function(data){
							if(jQuery.parseJSON(data)){
								alert('Açıklama başarıyla eklenmiştir.');
							}else{
								alert('Açıklama eklerken bir hata meydana geldi. Tekrar deneyin.');
							}
							jQuery('#loaderGif').trigger('close');
						}
					});
				});

				jQuery('#gBririmEkle').live('click',function(e){
					e.preventDefault();
					var alternatif = jQuery('#alternatif').val();
					var yetId = <?php echo $this->yeterlilik_id;?>;
					jQuery('#loaderGif').lightbox_me({
			            centered: true,
			            closeClick:false,
			            closeEsc:false
			        });
					jQuery.ajax({
						type:"POST",
						url:"index.php?option=com_yeterlilik_taslak&task=ajaxAlternatifKaydet&format=raw",
						data:"alter="+alternatif+'&yetId='+yetId,
						success:function(data){
							if(jQuery.parseJSON(data)){
								alert('Gruplandırma alternatifleri başarıyla eklenmiştir.');
							}else{
								alert('Gruplandırma alternatifleri eklerken bir hata meydana geldi. Tekrar deneyin.');
							}
							jQuery('#loaderGif').trigger('close');
						}
					});
				});

				jQuery('#turs').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).closest('tr').attr('id').split('_');
					jQuery('#BirimTurs_'+id[1]).lightbox_me({
			            centered: true,
			            closeClick:false,
			            closeEsc:false
			        });
				});

				jQuery('.teorikSinavEkleButton').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).attr('id').split('_');
					var trlength = jQuery('#birimTurleri_'+id[1]+' .teorikSinavlarRow').length;

					var ekle = '<tr id="teorikSinavlarRow-'+trlength+'" class="teorikSinavlarRow">';
					ekle += '<td class="blueBackgrounded" style="width:30px"><input class="teorikSinavSilButton" type="button" value="SİL"></td>';
					ekle +='<td><strong>TÜR KODU</strong><br>'
					+'<input type="text" value="" class="TeorikSinavTuru" name="TeorikSinavTuru['+trlength+']" style="width:400px;"><br>'
					+'<strong>SINAV ADI</strong><br>'
					+'<input class="ciftTirnaksiz" type="text" value="" name="TeorikSinavAdi['+trlength+']" style="width:400px;"><br>'
					+'<strong>SINAV AÇIKLAMASI</strong><br>'
					+'<textarea class="ciftTirnaksiz" name="TeorikSinavAciklama['+trlength+']" rows="3" style="width:100%;"></textarea></td></tr>';

					jQuery('#birimTurleri_'+id[1]+' #teorikSinavlarRow-'+(trlength-1)).after(ekle);
				});

				jQuery('.performansSinaviEkleButton').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).attr('id').split('_');
					var trlength = jQuery('#birimTurleri_'+id[1]+' .performansSinavlariRow').length;

					var ekle = '<tr id="performansSinavlariRow-'+trlength+'" class="performansSinavlariRow">';
					ekle += '<td class="blueBackgrounded" style="width:30px"><input class="performansSinaviSilButton" type="button" value="SİL"></td>';
					ekle +='<td><strong>TÜR KODU</strong><br>'
					+'<input type="text" value="" class="PerformansSinavTuru" name="PerformansSinavTuru['+trlength+']" style="width:400px;"><br>'
					+'<strong>SINAV ADI</strong><br>'
					+'<input class="ciftTirnaksiz" type="text" value="" name="PerformansSinavAdi['+trlength+']" style="width:400px;"><br>'
					+'<strong>SINAV AÇIKLAMASI</strong><br>'
					+'<textarea class="ciftTirnaksiz" name="PerformansSinavAciklama['+trlength+']" rows="3" style="width:100%;"></textarea></td></tr>';

					jQuery('#birimTurleri_'+id[1]+' #performansSinavlariRow-'+(trlength-1)).after(ekle);
				});


				jQuery('.teorikSinavSilButton').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).closest('table').attr('id').split('_');
					jQuery(this).closest('tr').remove();
					var say = 0;
					jQuery.each(jQuery('#birimTurleri_'+id[1]+' .teorikSinavlarRow'),function(key,vall){
						vall.setAttribute('id','teorikSinavlarRow-'+say);
						say++;
					});
				});

				jQuery('.performansSinaviSilButton').live('click',function(e){
					e.preventDefault();
					var id = jQuery(this).closest('table').attr('id').split('_');
					jQuery(this).closest('tr').remove();
					var say = 0;
					jQuery.each(jQuery('#birimTurleri_'+id[1]+' .performansSinavlariRow'),function(key,vall){
						vall.setAttribute('id','performansSinavlariRow-'+say);
						say++;
					});
				});
			});

			function lightboxClose(data){
				jQuery('#'+data).trigger('close');
			}

			function TurKaydet(birimId){
				var turArray = new Array();
				var hata = 0;
				jQuery.each(jQuery('#birimTurleri_'+birimId+' .TeorikSinavTuru'),function(key,vall){
					if(jQuery.inArray(vall.value.toUpperCase(),turArray)>-1){
						hata++;
					}else{
						turArray.push(vall.value.toUpperCase());
					}
				});

				jQuery.each(jQuery('#birimTurleri_'+birimId+' .PerformansSinavTuru'),function(key,vall){
					if(jQuery.inArray(vall.value.toUpperCase(),turArray)>-1){
						hata++;
					}else{
						turArray.push(vall.value.toUpperCase());
					}
				});

				if(hata == 0){
					jQuery('#turForm_'+birimId).submit();
				}else{
					alert('Benzer birim tür kodları kullanılmıştır. Lütfen düzeltiniz.');
				}
			}
</script>