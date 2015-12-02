<style>
<!--
span.label {
	width:150px;
	font-weight: bold;
}
-->
</style>
<?php 
$yets = $this->kurYets;

$getDegers = $this->getDegs;

$yetOption = '<option value="0">Seçiniz</option>';
foreach ($yets as $yet){
	$yetOption .= '<option value="'.$yet['YETERLILIK_ID'].'">'.$yet['YETERLILIK_KODU'].'/'.$yet['REVIZYON'].' - '.$yet['YETERLILIK_ADI'].'</option>';
}

// $ilOption = '';
// foreach ($ils as $il){
// 	$ilOption .=  '<option value="'.$il['IL_ID'].'">'.$il['IL_ADI'].'</option>';
// }
echo $this->sayfaLink;
?>


<h2 style="color:#063B5E; border-bottom: 1px solid #42627D;">Yeni Değerlendirici Ekle</h2><br>
	
<form method="POST" id="degerlendiriciSinavKaydetmeFormu"
	action="index.php?option=com_belgelendirme&task=degerlendiriciSinav_kaydet&layout=belgelendirme_degerlendirici" enctype="multipart/form-data">
	<div><input type="radio" name="radioTC" value="0"  checked="checked"/><span style="color:#063B5E;">TC Kimlik No: </span><span id="tcRadio"><input id="tcno" name="tcno" /><input type="button" value="Getir" id="tcGetir" /></span><br>
	<input type="radio" name="radioTC" value="1" /><span style="color:#063B5E;">Pasaport No: </span><span style="display:none;" id="digerRadio"><input id="uyrukDiger" name="uyrukDiger" /><input type="button" value="Getir" id="tcGetir" /></span>
	</div><br>
	<input type="hidden" name="tckimlik" id="tckimlik"/>
	<input type="hidden" name="uyruk" id="uyruk"/>
	<input type="hidden" name="yeniDeg" id="yeniDeg"/>
	
	<div id="getDeger" style="display:none">
	<hr>
		<div><span style="color:#063B5E; margin-right:85px;">Adı: </span><input type="text" id="getAd" name="getAd"/></div><br>
		<div><span style="color:#063B5E; margin-right:66px;">Soyadı: </span><input type="text" id="getSoyAd" name="getSoyAd" /></div><br>
		<div><span style="color:#063B5E; margin-right:19px;">Kişisel Beyan: </span>
			<div id="beyanIMG"><a href="#" id="getBeyan"><img alt="" src="images/pdf.png" width="50" height="50"></a></div>
			<div id="beyanFile" style="display:none;"><input type="file" name="gunBeyan" id="gunBeyan"/></div>
			<div>Yeni Beyan Ekle: <input type="checkbox" name="beyanCheck" id="beyanCheck"/></div>
		</div><br>
		<div><span style="color:#063B5E; margin-right:40px;">Özgeçmiş: </span>
		<div id="CVIMG"><a href="#" id="getCV"><img alt="" src="images/pdf.png" width="50" height="50"></a></div>
		<div id="cvFile" style="display:none;"><input type="file" name="gunCV" id="gunCV"/></div>
		<div>Yeni CV Ekle: <input type="checkbox" name="CVCheck" id="CVCheck"/></div>
		<br></div>
		<button id="degerlenGun">Değerlendirici Güncelle</button>
	</div><br>
	
	<div id="getDegerYeni" style="display:none">
	<hr> 
		<div><span style="color:#063B5E;">Adı: </span><input type="text" id="isim" name="isim" style="margin-left:77px;"/></div><br>
		<div><span style="color:#063B5E;">Soyadı: </span><input type="text" id="soyisim" name="soyisim" style="margin-left:56px;" /></div><br>
		<div><span style="color:#063B5E;">Kişisel Beyan: </span><input type="file" id="beyan" name="beyan" style="margin-left:15px;" /></div><br>
		<div><span style="color:#063B5E;">Özgeçmiş: </span><input type="file" id="cv" name="cv" style="margin-left:36px;" /></div><br>
	
	</div>
	
	<div id="yetHidden" style="display:none">
	<div><span style="color:#063B5E;">Yeterlilik: </span>
					<div id="yeterlilik" style="margin-left:26px;">
						<?php // yetkilendirildiği yeterlilikler getirilicek 
							//echo $yetOption;
						?>
						</div></div><br>
<!--	<a href="#" id="degerlenKaydet">Kaydet</a>-->
        <button id="degerlenKaydet">Kaydet</button>
	</div>
</form>
<hr>
<br>
<div id="degerlendiriciler">
<?php if(count($getDegers)){?>
<table style="width:100%;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">T.C. Kimlik No</th>
			<th width="20%">Adı</th>
			<th width="20%">Soyadı</th>
			<th width="40%">Yeterlilik</th>
			<th width="20%">Detay</th>
			<th width="10%">Etkin</th>
			<th width="10%">Sil</th>
			<th width="10%">Durumu</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($getDegers as $key=>$cow){
	if($say%2 == 0){
		echo '<tr '.$even.'>';
	}else{
		echo '<tr>';
	}
	$say++;
	echo '<td align="center" rowspan="'.count($cow).'">'.$key.'</td>';
	$i=0;
	foreach($cow as $row){
		if(($say+$i)%2==1){
			$bcolor = 'bgcolor="#efefef"';
		}else{
			$bcolor = 'bgcolor="#ffffff"';
		}
		
		if($i == 0){
			echo '<td align="center" rowspan="'.count($cow).'">'.$row['ADI'].'</td>';
			echo '<td align="center" rowspan="'.count($cow).'">'.$row['SOYADI'].'</td>';
				echo '<td align="center"><a href="javascript:void(0)" tcno="'.$key.'" yetid="'.$row['YETERLILIK_ID'].'" class="yetdetay"/>'.trim($row['YETERLILIK_KODU']).'/'.$row['REVIZYON'].'-'.$row['YETERLILIK_ADI'].'</a></td>';
				echo '<td align="center"><button style="background-color:blue;color:white;" class="degerlendiriciYeterlilikDetay" type="button" tcid="'.$row['TC_KIMLIK'].'" yetid="'.$row['YETERLILIK_ID'].'">Detay</button></td>';
				if($row['ONAY_BEKLEYEN_DGRLNDRC'] == ""){
					echo '<td align="center"><button style="background-color:blue;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\');" type="button" title="Onay Bekliyor">Onay Bekliyor</button></td>';
				}else{
					if($row['ETKIN'] == 1){
						echo '<td align="center"><button style="background-color:green;color:white;" type="button" title="Etkin" onclick=etkisizKil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Aktif</button></td>';
					}else{
						echo '<td align="center"><button style="background-color:red;color:white;" type="button" title="Etkisiz" onclick=etkinKil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Pasif</button> </td>';
					}
				}
				echo '<td align="center"><button type="button" style="background-color:red;color:white" onclick=degYetSil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Sil</button></td>';
				if($row['ONAY_BEKLEYEN_DGRLNDRC'] == "" || $row['ONAY_BEKLEYEN_DGRLNDRC'] == "0"){
					echo '<td colspan="2" align="center"><button style="background-color:blue;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\');" type="button">Onay Bekliyor</button></td>';
				}else if($row['ONAY_BEKLEYEN_DGRLNDRC'] == "2"){
					echo '<td colspan="2" align="center"><button style="background-color:red;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\');" type="button">Red Edildi</button></td>';
				}else{
					echo '<td colspan="2" align="center"><button style="background-color:green;color:white;" type="button" tcid="'.$row['TC_KIMLIK'].'" yetid="'.$cow['YETERLILIK_ID'].'">Onaylandı</button></td>';
				}
				echo	'</tr>';
		}
		else{
			echo	'<tr '.$bcolor.'>';
			echo '<td align="center"><a href="javascript:void(0)" tcno="'.$key.'" yetid="'.$row['YETERLILIK_ID'].'" class="yetdetay"/>'.trim($row['YETERLILIK_KODU']).'/'.$row['REVIZYON'].'-'.$row['YETERLILIK_ADI'].'</a></td>';
			echo '<td align="center"><button style="background-color:blue;color:white;" class="degerlendiriciYeterlilikDetay" type="button" tcid="'.$row['TC_KIMLIK'].'" yetid="'.$row['YETERLILIK_ID'].'">Detay</button></td>';
			if($row['ONAY_BEKLEYEN_DGRLNDRC'] == ""){
				echo '<td align="center"><button style="background-color:blue;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\');" type="button" title="Onay Bekliyor">Onay Bekliyor</button></td>';
			}else{
				if($row['ETKIN'] == 1){
					echo '<td align="center" ><button style="background-color:green;color:white;" type="button" title="Etkin" onclick=etkisizKil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Aktif</button></td>';
				}else{
					echo '<td align="center"><button style="background-color:red;color:white;" type="button" title="Etkisiz" onclick=etkinKil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Pasif</button> </td>';
				}
			}
			echo '<td align="center"><button type="button" style="background-color:red;color:white" onclick=degYetSil("'.$row['YETERLILIK_ID'].'_'.$key.'")>Sil</button></td>';
			if($row['ONAY_BEKLEYEN_DGRLNDRC'] == "" || $row['ONAY_BEKLEYEN_DGRLNDRC'] == "0"){
				echo '<td colspan="2" align="center"><button style="background-color:blue;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\');"" type="button" title="Onay Bekliyor">Onay Bekliyor</button></td>';
			}else if($row['ONAY_BEKLEYEN_DGRLNDRC'] == "2"){
				echo '<td colspan="2" align="center"><button style="background-color:red;color:white;" type="button" tcid="'.$row['TC_KIMLIK'].'" yetid="'.$cow['YETERLILIK_ID'].'">Red Edildi</button></td>';	
			}else{
				echo '<td colspan="2" align="center"><button style="background-color:green;color:white;" type="button" tcid="'.$row['TC_KIMLIK'].'" yetid="'.$cow['YETERLILIK_ID'].'">Onaylandı</button></td>';
			}
			echo	'</tr>';
		}
		$i++;
	}
		
	}?>
	</tbody>
</table>
<?php }?>
</div>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <table id="changeddatas">
    	<tr>
    		<td><input type="hidden" name="willconfirmeduser" id="willconfirmeduser"/>Adı :</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Soyadı :</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Beyan</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Cv</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td colspan="2">
	  			<div style="float:right; padding:10px;">
		    		<button value="Onayla" id="confirmuser" style="background-color:grey;color:white;">Onayla</button>
		    		<button value="Reddet" id="declineuser" style="background-color:grey;color:white;">Reddet</button>
		    		<button value="İptal" id="canceluser" style="background-color:grey;color:white;">İptal</button>
	  			</div>
  			</td>
    	</tr>
    	<tr>
    		<td colspan="2"><em style="color:red;">Not: Parantez içerisindeki ifadeler son güncelleme esnasında yapılan değişikliklerdir.</em></td>
    	</tr>
    </table>
</div>
<div id="degelerdiriciOlcutKarsilama" style="width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=degelerdiriciOlcutKarsilamaKaydet"  method="POST" id="degelerdiriciOlcutKarsilamaForm">
	<h2><u>Ölçüt Karşılama Formu</u></h2><br>
		<b>Değerlendirici Ölçütleri</b><br/>
		<textarea rows="6" cols="70" name="degerlendirici_olcutleri"></textarea><br/><br/>
		<b>Ölçütlerin Karşılandığına Dair Açıklama</b>
		<textarea rows="6" cols="70" name="olcut_karsilama_aciklama"></textarea><br/>
		<input type="hidden" name="tcno" />
		<input type="hidden" name="yetid" />
		<button type="submit" style="float:right;">Kaydet</button>
	</form>
</div>
<div id="degerlendiriciYeterlilikDetayPanel" style="width: 35%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=degelerdiriciOlcutKarsilamaKaydet"  method="POST" id="degerlendiriciYeterlilikDetayForm">
	<h2><u>Değerlenedirici Yeterlilik Detay Formu</u></h2><br>
		<table>
			<tr>
				<td><b>Yeterlilik Adı</b></td>
				<td></td>
			</tr>
			<tr>
				<td><b>Eklenme Tarihi</b></td>
				<td></td>
			</tr>
			<tr>
				<td><b>Onay Tarihi</b></td>
				<td></td>
			</tr>
		</table>
		<br/>
		<b>MESAJLAR</b>
		<hr/>
		<div id="messageContainer">
		</div>
	</form>
</div>
<style>
	#messageContainer{
		float:left;
	}
	#messageContainer .row{
		float: left;
		width: 100%;
		margin:10px;
		border-bottom: 1px solid #CCCCCC;
	}
	
	#messageContainer .rowright{
		float: right;
		width: 100%;
		margin:10px;
		border-bottom: 1px solid #CCCCCC;
	}
	
	#messageContainer .row .messageinform{
		width:auto;
		float:left;
		padding-bottom: 10px;
	}
	
	#messageContainer .row .messageinformright{
		width:auto;
		float:right;
		padding-bottom: 10px;
	}
	
	#messageContainer .row .messagesender{
		float:left;
		font-weight: bold;
	}	
	#messageContainer .row .messagetime{
		float:left;
		color: red;
		padding : 0 0 0 10px;
	}	
	#messageContainer .row .message{
		float:left;
		padding:3px 0 0px 10px;
		width: 100%;
	}
	
	#messageContainer .row .messageright{
		float:left;
		width: 100%;
		text-align: right;
	}	
	
</style>
<script type="text/javascript">
function tckimlikkontorolu(tcno) {
    var tckontrol,toplam; tckontrol = tcno; toplam = Number(tcno.substring(0,1)) + Number(tcno.substring(1,2)) +
    Number(tcno.substring(2,3)) + Number(tcno.substring(3,4)) +
    Number(tcno.substring(4,5)) + Number(tcno.substring(5,6)) +
    Number(tcno.substring(6,7)) + Number(tcno.substring(7,8)) +
    Number(tcno.substring(8,9)) + Number(tcno.substring(9,10)); 
    strtoplam = String(toplam); onunbirlerbas = strtoplam.substring(strtoplam.length,strtoplam.length-1);

    if(onunbirlerbas == tcno.substring(10,11)) {
        return true;
    } else{ 
        return false; 
    } 
}

jQuery(document).ready(function(){

	jQuery('#beyanCheck').live('change',function(e){
		e.preventDefault();
		if(jQuery(this).prop('checked') == true){
			jQuery('#beyanFile').show();
			jQuery('#beyanIMG').hide();
		}
		else{
			jQuery('#beyanFile').hide();
			jQuery('#beyanIMG').show();
		}
	});

	jQuery('#CVCheck').live('change',function(e){
		e.preventDefault();
		if(jQuery(this).prop('checked') == true){
			jQuery('#cvFile').show();
			jQuery('#CVIMG').hide();
		}
		else{
			jQuery('#cvFile').hide();
			jQuery('#CVIMG').show();
		}
	});
	
	jQuery('input[name=radioTC]').live('change',function(e){
		e.preventDefault();
		if(jQuery(this).val()==1){
			jQuery('#uyrukDiger').val('');
			jQuery('#tcno').val('');
			jQuery('#tcRadio').hide();
			jQuery('#digerRadio').show();
			jQuery('#getDeger').hide('slow');
            jQuery('#yetHidden').hide('slow');
            jQuery('#getDegerYeni').hide('slow');
		}else{
			jQuery('#uyrukDiger').val('');
			jQuery('#tcno').val('');
			jQuery('#digerRadio').hide();
			jQuery('#tcRadio').show();
			jQuery('#getDeger').hide('slow');
            jQuery('#yetHidden').hide('slow');
            jQuery('#getDegerYeni').hide('slow');
		}
	});

	
	jQuery('#tcGetir').live('click',function(e){
            jQuery('#getDeger').hide('slow');
            jQuery('#yetHidden').hide('slow');
            jQuery('#getDegerYeni').hide('slow');
            var uyruk = jQuery('input[name=radioTC]:checked').val();
     if(uyruk==0){
		if(jQuery('#tcno').val().length == 11){
			var tcno = jQuery('#tcno').val();
			if(tckimlikkontorolu(tcno)){
				jQuery.ajax({
					type:'post',
					url:'index.php?option=com_belgelendirme&task=tcKayitlimi&format=raw',
					data:'tcno='+tcno,
					success:function(data){
						var cat = jQuery.parseJSON(data);
						var dat = cat[0];
						var yet = cat[1];
						if(dat.length>0){
							jQuery('#getAd').val(dat[0]['ADI']);
							jQuery('#getSoyAd').val(dat[0]['SOYADI']);
							if(dat[0]['BEYAN'] == '' || dat[0]['BEYAN'].length == 0){
								jQuery('#beyanFile').show();
								jQuery('#beyanIMG').hide();
								jQuery('#beyanCheck').closest('div').hide();
							}else{
								jQuery('#getBeyan').attr('href','index.php?dl='+dat[0]['BEYAN']);
							}
							if(dat[0]['CV'] == '' || dat[0]['CV'].length == 0){
								jQuery('#cvFile').show();
								jQuery('#CVIMG').hide();
								jQuery('#CVCheck').closest('div').hide();
							}else{
								jQuery('#getCV').attr('href','index.php?dl='+dat[0]['CV']);
							}
							jQuery('#tckimlik').val(jQuery('#tcno').val());
							jQuery('#uyruk').val(uyruk);
							jQuery('#yeniDeg').val(0);
							jQuery('#getDeger').show('slow');
							jQuery('#yetHidden').show('slow');
						}
						else{
							jQuery('#yeniDeg').val(1);
							jQuery('#getDegerYeni').show('slow');
							jQuery('#uyruk').val(uyruk);
							jQuery('#yetHidden').show('slow');
						}

						var ekle = '';
						jQuery.each(yet,function(key,vall){
							ekle +='<input type="checkbox" name="yets[]" value="'+vall['YETERLILIK_ID']+'" '+(vall['SELECTED'] == "1" ? "class='addComment'" : "")+'/>'+
								   '<span'+(vall['STATUS'] == "2" ? " style='color:red;'" : "")+'> '+
								   		jQuery.trim(vall['YETERLILIK_KODU'])+'/'+vall['REVIZYON']+'-'+vall['YETERLILIK_ADI']+
								   		(vall['STATUS'] == "2" ? " <i> (İlgili yeterlilik dosya sorumlunuz tarafından red edilmiştir!)</i>" : "")+
								   '</span><br>';
						});
						if(ekle.length>0){
							jQuery('#yeterlilik').html(ekle);
						}
						else{
							jQuery('#yeterlilik').html('<h2>Kapsam dahilinde başka yeterlilik bulunmamaktadır.</h2>');
						}
						
					}
				});
			}
			else{
				alert('Girdiğiniz T.C. Kimlik No hatalıdır.');
			}
		}
		else{
			alert('Girdiğiniz T.C. Kimlik No hatalıdır.');
			jQuery('#getDegerYeni').hide('slow');
			jQuery('#getDeger').hide('slow');
			jQuery('#yetHidden').hide('slow');
		}
     }else if(uyruk == 1){
    	 jQuery.ajax({
				type:'post',
				url:'index.php?option=com_belgelendirme&task=tcKayitlimi&format=raw',
				data:'tcno='+jQuery('#uyrukDiger').val(),
				success:function(data){
					var cat = jQuery.parseJSON(data);
					var dat = cat[0];
					var yet = cat[1];
					if(dat.length>0){
						jQuery('#getAd').val(dat[0]['ADI']);
						jQuery('#getSoyAd').val(dat[0]['SOYADI']);
						jQuery('#tckimlik').val(jQuery('#tcno').val());
						if(dat[0]['BEYAN'] == '' || dat[0]['BEYAN'].length == 0){
							jQuery('#beyanFile').show();
							jQuery('#beyanIMG').hide();
							jQuery('#beyanCheck').closest('div').hide();
						}else{
							jQuery('#getBeyan').attr('href','index.php?dl='+dat[0]['BEYAN']);
						}
						if(dat[0]['CV'] == '' || dat[0]['CV'].length == 0){
							jQuery('#cvFile').show();
							jQuery('#CVIMG').hide();
							jQuery('#CVCheck').closest('div').hide();
						}else{
							jQuery('#getCV').attr('href','index.php?dl='+dat[0]['CV']);
						}
						jQuery('#uyruk').val(uyruk);
						jQuery('#yeniDeg').val(0);
						jQuery('#getDeger').show('slow');
						jQuery('#yetHidden').show('slow');
					}
					else{
						jQuery('#yeniDeg').val(1);
						jQuery('#uyruk').val(uyruk);
						jQuery('#getDegerYeni').show('slow');
						jQuery('#yetHidden').show('slow');
					}

					var ekle = '';
					jQuery.each(yet,function(key,vall){
						ekle +='<input type="checkbox" name="yets[]" value="'+vall['YETERLILIK_ID']+'"/><span> '+jQuery.trim(vall['YETERLILIK_KODU'])+'/'+vall['REVIZYON']+'-'+vall['YETERLILIK_ADI']+'</span><br>';
					});
					if(ekle.length>0){
						jQuery('#yeterlilik').html(ekle);
					}
					else{
						jQuery('#yeterlilik').html('<h2>Kapsam dahilinde başka yeterlilik bulunmamaktadır.</h2>');
					}
				}
			});
     }
	});

    jQuery(".degerlendiriciYeterlilikDetay").click(function(){
        
        jQuery.ajax({
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=degerlendiriciYeterlilikDetay&format=raw",
			data:'yetid='+jQuery(this).attr('yetid')+'&tcno='+jQuery(this).attr('tcid'),
			success:function(data){
				if(data.STATUS == "1"){			
					jQuery("#degerlendiriciYeterlilikDetayPanel table tr:eq(0) td:eq(1)").html(data.DATA.YETERLILIK_ADI);	
					jQuery("#degerlendiriciYeterlilikDetayPanel table tr:eq(1) td:eq(1)").html(data.DATA.OLUSTURMA_TARIHI);		
					jQuery("#degerlendiriciYeterlilikDetayPanel table tr:eq(3) td:eq(1)").html(data.DATA.ONAY_TARIHI);	
					jQuery("#messageContainer").html('');
					jQuery.each(data.MESSAGE, function( key , val ) { 
						jQuery("#messageContainer").append('<div class="row">'+
																'<div class="'+(key%2 == 0 ? "messageinform" : "messageinformright")+'">'+
																	'<div class="messagesender">'+val.SENDER_NAME+'</div>'+
																	'<div class="messagetime">'+val.MESSAGE_TIME+'</div>'+
																'</div>'+
																'<div class="'+(key%2 == 0 ? "message" : "messageright")+'">'+val.MESSAGE+'</div>'+
															'</div>'); 
					});
			    	jQuery('#degerlendiriciYeterlilikDetayPanel').lightbox_me({
						centered: true
				    });
				}else{
					alert("Teknik bir hata oluştu.Lütfen daha sonra tekrar deneyiniz!");
				}
			}
		 });
    });
        jQuery('#tcno').live('keyup',function(e){
           e.preventDefault;
           if(jQuery(this).val().length < 11){
                jQuery('#getDeger').hide('slow');
                jQuery('#yetHidden').hide('slow');
                jQuery('#getDegerYeni').hide('slow');
           }
        });
        
	jQuery('#sinavs').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniSinav').show('slow');
		jQuery(this).attr('id','sinavsHide');
	});

	jQuery('#sinavsHide').live('click',function(e){
		e.preventDefault();
		jQuery('#yeniSinav').hide('slow');
		jQuery(this).attr('id','sinavs');
	});

	 jQuery('#bastar').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
		});


	jQuery('#degerlenKaydet').live('click',function(e){
		e.preventDefault();
		var uyruk = jQuery('input[name=radioTC]:checked').val();
		if(jQuery('#yeniDeg').val() == 1 && jQuery('#isim').val() == ''){
			alert('Lütfen değerlendirici adını boş bırakmayınız.');
		}
		else if(jQuery('#yeniDeg').val() == 1 && jQuery('#soyisim').val() == ''){
			alert('Lütfen değerlendirici soyadını boş bırakmayınız.');
		}
		else if(uyruk==0){
			if(jQuery('#tcno').val().length != 11){
				alert('Geçerli bir T.C. Kimlik No giriniz.');
			}
			else if(jQuery('#tcno').val().length == 11 && !tckimlikkontorolu(jQuery('#tcno').val())){
				alert('Geçerli bir T.C. Kimlik No giriniz.');
			}
			else{
				jQuery('#degerlendiriciSinavKaydetmeFormu').submit();
			}
		}
		else{
			jQuery('#degerlendiriciSinavKaydetmeFormu').submit();
		}
	});

	jQuery('#degerlenGun').live('click',function(e){
		e.preventDefault();
		jQuery('#yets').val(0);
		var uyruk = jQuery('input[name=radioTC]:checked').val();
		if(jQuery('#yeniDeg').val() == 1 && jQuery('#isim').val() == ''){
			alert('Lütfen değerlendirici adını boş bırakmayınız.');
		}
		else if(jQuery('#yeniDeg').val() == 1 && jQuery('#soyisim').val() == ''){
			alert('Lütfen değerlendirici soyadını boş bırakmayınız.');
		}
		else if(uyruk==0){
			if(jQuery('#tcno').val().length != 11){
				alert('Geçerli bir T.C. Kimlik No giriniz.');
			}
			else if(jQuery('#tcno').val().length == 11 && !tckimlikkontorolu(jQuery('#tcno').val())){
				alert('Geçerli bir T.C. Kimlik No giriniz.');
			}
			else{
				jQuery('#degerlendiriciSinavKaydetmeFormu').submit();
			}
		}
		else{
			jQuery('#degerlendiriciSinavKaydetmeFormu').submit();
		}
	});
	jQuery(".submituserforyeterlilik").click(function(){
		jQuery.ajax({
			asycn:false,
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=degerlendiriciSubmitForYeterlilik&format=raw",
			data:'tcno='+jQuery(this).attr('tcid')+'&yetid='+jQuery(this).attr('yetid'),
			success:function(data){
				if(data.STATUS && data.STATUS != ""){
					alert(data.RESULT);
					window.location.reload();
				}else{
					alert("Onay işleminde hata oluştu");
				}
			}});
	});
	jQuery(".submituser").click(function(){
		jQuery.ajax({
			asycn:false,
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=degerlendiriciGetDatas&format=raw",
			data:'tcno='+jQuery(this).attr('tcid')+'&yetid='+jQuery(this).attr('yetid'),
			success:function(data){
				jQuery.each(data, function( index2, value2 ) { 
						 if(jQuery.isPlainObject(value2['ADI'])){
							 jQuery("#changeddatas tr:eq(0) td:eq(1)").html(value2['ADI']['NEWVALUE']+"<em style='color:red;'>("+value2['ADI']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(0) td:eq(1)").html(value2['ADI']);
						 }
						 
						 if(jQuery.isPlainObject(value2['SOYADI'])){
							 jQuery("#changeddatas tr:eq(1) td:eq(1)").html(value2['SOYADI']['NEWVALUE']+"<em style='color:red;'>("+value2['SOYADI']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(1) td:eq(1)").html(value2['SOYADI']);
						 }

						 if(jQuery.isPlainObject(value2['BEYAN'])){
							 jQuery("#changeddatas tr:eq(2) td:eq(1)").html(value2['BEYAN']['NEWVALUE']+"<em style='color:red;'>("+value2['BEYAN']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(2) td:eq(1)").html(value2['BEYAN']);
						 }
						 
						 if(jQuery.isPlainObject(value2['CV'])){
							 jQuery("#changeddatas tr:eq(3) td:eq(1)").html(value2['CV']['NEWVALUE']+"<em style='color:red;'>("+value2['CV']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(3) td:eq(1)").html(value2['CV']);
						 }
						 
						 jQuery("#changeddatas #willconfirmeduser").val(value2['TC_KIMLIK']);
				});
				jQuery('#loaderGif').lightbox_me({
					centered: true,
			        closeClick:false,
			        closeEsc:false  
		        });
			}
		});
	
	});
//	jQuery(".submitusererror").click(function(){
//		alert("İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.");
//		return false;
//	});
	jQuery("#confirmuser").click(function(){
		submitOrCancelUser(jQuery("#changeddatas #willconfirmeduser").val(),"1");
	});
	jQuery("#declineuser").click(function(){
		submitOrCancelUser(jQuery("#changeddatas #willconfirmeduser").val(),"0");
	});
	jQuery("#canceluser").click(function(){
		jQuery('#loaderGif').trigger('close');
	});
	//echo json_encode($model->ajaxSaveBelgeKur());

	jQuery(".yetdetay").click(function(){
		yetid = jQuery(this).attr('yetid');
		tcno = jQuery(this).attr('tcno');
		jQuery.ajax({
			asycn:false,
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=degerlendiriciOlcutKarsilamaDetay&format=raw",
			data:'yetid='+yetid+'&tcno='+tcno,
			success:function(data){
				if(data.STATUS == "1"){
					jQuery("#degelerdiriciOlcutKarsilama input[name=yetid]").val(yetid);
					jQuery("#degelerdiriciOlcutKarsilama input[name=tcno]").val(tcno);
					jQuery("textarea[name=degerlendirici_olcutleri]").html(data.DATA.DEGERLENDIRICI_OLCUT);	
					jQuery("textarea[name=olcut_karsilama_aciklama]").html(data.DATA.OLCUT_KARSILAMA_ACIKLAMA);					
					jQuery('#degelerdiriciOlcutKarsilama').lightbox_me({
						centered: true
			        });
				}else{
					alert("Teknik bir hata oluştu.Lütfen daha sonra tekrar deneyiniz!");
				}
			}
		 });
	});

	jQuery("input[type=checkbox][name='yets[]']").live('click',function(){
		yetid = jQuery(this).val();
		if(this.checked){
			jQuery(this).next().after('<div class=".yenidegelerlendiriciolcutcontainer" style="width:100%; display:none;">'+
									  	'<b>Değerlendirici Ölçütleri</b><br/>'+
											'<textarea rows="6" cols="70" name="degerlendirici_olcutleri_'+yetid+'"></textarea><br/><br/>'+
											'<b>Ölçütlerin karşılandığına dair açıklama</b><br/>'+
											'<i>"Ölçütlerin karşılandığına dair bilgileri yazınız veya bilgi formunda ilgili alanlara atıf yapınız."</i>'+
											'<textarea rows="6" cols="70" name="olcut_karsilama_aciklama_'+yetid+'"></textarea><br/><br/>'+
											(jQuery(this).hasClass( "addComment") ? '<b>Red açıklaması</b><br/><textarea rows="6" cols="70" name="red_aciklama_'+yetid+'"></textarea><br/>' : "")+
									  '</div>');

			jQuery.ajax({
				asycn:false,
				type:'POST',
				dataType: "json",
				url:"index.php?option=com_belgelendirme&task=getYeterlilikDegelendiriciOlcut&format=raw",
				data:'yetid='+yetid,
				success:function(data){
					if(data.STATUS == "1"){
						jQuery('textarea[name=degerlendirici_olcutleri_'+yetid+']').html(data.DEGERLENDIRICI_OLCUT);
					}
				}
			 });
			jQuery(this).next().next().show('slow');
		}else{
			jQuery(this).next().next().hide('slow');
		}
	});
});

function submitOrCancelUser(tcno,status){
	jQuery.ajax({
		asycn:false,
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_belgelendirme&task=degerlendiriciSubmitOrCancel&format=raw",
		data:'tcno='+tcno+'&durum='+status,
		success:function(data){
			if(data.STATUS && data.STATUS != ""){
				alert(data.RESULT);
				window.location.reload();
			}else{
				alert("Onay işleminde hata oluştu");
			}
		}
	 });
}
function etkinKil(deger){
	var data = deger.split('_');
	var yetId = data[0];
	var degerId = data[1];
	jQuery.ajax({
		asycn:false,
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=degerlendiriciEtkin&format=raw",
		data:'yetId='+yetId+'&degerId='+degerId+'&etkin=1',
		success:function(data){
			window.location.reload();
			}
	});
}

function etkisizKil(deger){
	var data = deger.split('_');
	var yetId = data[0];
	var degerId = data[1];
	jQuery.ajax({
		asycn:false,
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=degerlendiriciEtkin&format=raw",
		data:'yetId='+yetId+'&degerId='+degerId+'&etkin=0',
		success:function(data){
				window.location.reload();
			}
	});
}

function degYetSil(deger){
	if(confirm('Yeterliği değerlendiriciden almak istediğinizden emin misiniz?')){
		var data = deger.split('_');
		var yetId = data[0];
		var degerId = data[1];
		jQuery.ajax({
			asycn:false,
			type:'POST',
			url:"index.php?option=com_belgelendirme&task=degerYetSil&format=raw",
			data:'yetId='+yetId+'&degerId='+degerId,
			success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat){
						alert('Silme işlemi başarılı.');
						window.location.reload();
					}else{
						alert('Silmek istediğiniz değerlendirici yapmış olduğunuz bir sınavda görev aldığı için silemezsiniz.');
					}
				}
		});
	}
}
</script>