<?php
$kurulus = $this->kurulus_bilgi;
$DSorumlu = $this->DSorumlu;
$yetkiYeterlilik = $this->yetkiliYet;
$programs = $this->programs;
$SinavaGirenTop = $this->SinavaGirenTop;
$SinavBasTop = $this->SinavBasTop;
$deger = $this->deger[0];
// $sinavGirBas = $this->sinavGirBas[0];
// $sinavGirBassiz = $this->sinavGirBas[1];
$belgeler = $this->belgeler;
?>
<style>
<!--
.anaSol{
float:left;
width:49%;
}

.anaOrta{
float:left;
width:2%;
}

.anaSag{
float:right;
width:49%;
}

.btnMav{
	color:#ffffff;
	background-color:#71CEED;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
-->
</style>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<div class="anaDiv">
<table style="width:100%;text-align:center;color:#ffffff; font-size: large;">
  <tr>
    <td bgcolor="#00A5DD" width="30%" rowspan="2"><img src='<?php echo "index.php?dl=kurulus_logo/".$kurulus['USER_ID']."/".$kurulus['LOGO'];?>' style='width:100%;height:200px'/></td>
    <td bgcolor="#00A5DD" width="70%"><?php echo $kurulus['KURULUS_ADI']?></td>
  </tr>
  <tr>
    <td bgcolor="#171963" width="70%"><?php echo $kurulus['KURULUS_ADRESI'].'</br> Telefon: '.$kurulus['KURULUS_TELEFON'].'  E-posta: '.$kurulus['KURULUS_EPOSTA'];?></td>
  </tr>
</table>
</div>

<div class="anaDiv">
<div class="anaSol">
<?php if(count($DSorumlu)>0){?>
	<div class="anaDiv">
		<table style="width:100%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
			<tr>
				<td bgcolor="#00A5DD" style="color:#ffffff;font-size: large;">Dosya Sorumluları</td>
			</tr>
			<?php foreach ($DSorumlu as $val){
				echo '<tr><td>'.$val[0]->name.'</td></tr>';
			}?>
		</table>
	</div>
<?php }?>	
	
<?php if($programs){ ?>
	<hr><br>
	<div id="anaDiv">
	<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Sınav Merkezi</p>
	<table style="width:100%; text-align:center"  border="1" cellpadding="0" cellspacing="1">
		<thead style="background-color:#71CEED"> 
			<tr>
				<th width="5%">Sınav Yeri ID</th>
				<th width="20%">Yer Adı</th>
				<th width="35%">Adres</th>
	<!-- 			<th width="5%">Sil</th> -->
			</tr>
		</thead>
		<tbody id="sınavTbody">
	
	
	<?php 
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach ($programs as $key=>$cow){
			if($say%2==0){
				$bcolor = 'bgcolor="#efefef"';
			}else{
				$bcolor = 'bgcolor="#ffffff"';
			}
			
			echo '<tr '.$bcolor.'><td align="center">'.$cow['SINAV_YERI_ID'].'</td>';
			echo '<td align="center">'.$cow['YER_ADI'].'</td>';
			echo '<td align="center">'.$cow['ADRES'].'</td>';
			echo '</tr>';
			
			if($say == 5){
				break;
			}
			$say++;
		}?>
		<tr><td colspan="3"><a target="_blank" href="index.php?option=com_profile&view=profile&layout=sinav_merkez&kurulus=<?php echo $kurulus['USER_ID']?>">Devamı...</a></td></tr>
		</tbody>
	</table>
	</div>
<?php }?>

</div>

<div class="anaOrta"></div>

<div class="anaSag">
<?php if($yetkiYeterlilik){?>
<div class="anaDiv">
<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Yetkilendirilen Yeterlilikler</p>
<table style="width:100%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">#</th>
			<th width="70%">Yeterlilik</th>
			<th width="20%">Birimler</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach ($yetkiYeterlilik as $key=>$cow){
			if($say%2==0){
				$bcolor = 'bgcolor="#efefef"';
			}else{
				$bcolor = 'bgcolor="#ffffff"';
			}
			
			echo '<tr '.$bcolor.'>';
			echo '<td align="center">'.$say.'</td>';
			echo '<td align="center">';
// 			if($cow['REVIZYON_NO'] && $cow['REVIZYON_DURUMU']==1){
// 				echo trim($cow['YETERLILIK_REV_KOD']).'/'.$cow['REVIZYON_NO'].' - '.$cow['YETERLILIK_ADI'];
// 			}
// 			else{
// 				echo trim($cow['YETERLILIK_KODU']).'/00 - '.$cow['YETERLILIK_ADI'];
// 			}
			echo trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'];
			echo '</td>';
			
			echo '<td align="center"><input type="button" onclick="getBirims('.$cow['YETERLILIK_ID'].')" value="Birimler"/></td>';
			echo '</tr>';
			
			if($say == 5){
				break;
			}
			$say++;
		}?>
	<tr>
		<td colspan="3"><a target="_blank" href="index.php?option=com_profile&view=profile&layout=yetki_yeterlilik&kurulus=<?php echo $kurulus['USER_ID']?>">Devamı...</a></td>
	</tr>
	</tbody>
</table>
</div>
<?php }?>

<?php if(count($deger)>0){?>
<hr><br>
<div class="anaDiv">
<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Değerlendiriciler</p>
<table style="width:100%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="30%">Kimlik No:</th>
			<th width="35%">Ad</th>
			<th width="35%">Soyad</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach ($deger as $cow){
			if($say%2==0){
				$bcolor = 'bgcolor="#efefef"';
			}else{
				$bcolor = 'bgcolor="#ffffff"';
			}
			
			echo '<tr '.$bcolor.'>';
			echo '<td align="center">'.$cow['TC_KIMLIK'].'</td>';
			echo '<td align="center">'.$cow['ADI'].'</td>';
			echo '<td align="center">'.$cow['SOYADI'].'</td>';
			echo '</tr>';
			
			if($say == 5){
				break;
			}
			$say++;
		}?>
	<tr>
		<td colspan="3"><a target="_blank" href="index.php?option=com_profile&view=profile&layout=degerlendirici&kurulus=<?php echo $kurulus['USER_ID']?>">Devamı...</a></td>
	</tr>
	</tbody>
</table>
</div>
<?php }?>

</div>
</div>

<?php if(count($belgeler)>0){?>
<hr>
<br>
<div class="anaDiv">
	<button type="button" class="btn btn-primary" onclick="SinavGirmisTop(<?php echo $kurulus['USER_ID'];?>)">Sınav Başarı Yüzdeleri (Portal Üzerinden)</button>
</div>
<?php }?>

<?php if($belgeler){ ?>
<hr>
<br>
<div class="anaDiv">
<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Verilen Belgeler</p>
	<table width="100%" style="text-align:center" border="1">
		<thead style="background-color:#71CEED">
			<tr>
				<th width="15%">Yeterlilik Kodu</th>
				<th width="40%">Yeterlilik Adı</th>
				<th width="10%">Portal Üzerinden Verilen Belge Sayısı</th>
				<th width="10%">Manuel Verilen Belge Sayısı</th>
				<th width="13%">Toplam Verilen Belge Sayısı</th>
				<th width="12%">Yıllara Göre Dağılım</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$say = 1;
		$belsay = 0;
		$haksay = 0;
		foreach($belgeler as $key => $row){
			if($say%2 == 0){
				echo '<tr bgcolor="#efefef">';
			}else{
				echo '<tr bgcolor="#ffffff">';
			}
			
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].'</td>';
			echo '<td>'.$row['YETERLILIK_ADI'].'</td>';
			if($row['HAKSAY']){
				$hak = $row['HAKSAY'];
			}else{
				$hak = 0;
			}
			echo '<td>'.$hak.'</td>';
			
			if($row['BELSAY']){
				$bel = $row['BELSAY'];
			}else{
				$bel = 0;
			}
			echo '<td>'.$bel.'</td>';
			echo '<td>'.($hak+$bel).'</td>';
			echo '<td><a href="javascript:void(0);" class="verilenbelgeyeterlilikdetay" yetid="'.$key.'"/>Göster</td>';
			echo '</tr>';
			$say++;
			$belsay += $bel;
			$haksay += $hak;
		}
		?>
		<tr>
			<td colspan="2" align="right">Toplam:</td>
			<td><?php echo $haksay;?></td>
			<td><?php echo $belsay;?></td>
			<td><?php echo $belsay+$haksay;?></td>
			<td><a href="javascript:void(0);" class="verilenbelgedetay"/>Toplamı Göster</td></td>
		</tr>
		</tbody>
	</table>
</div>
<?php }?>

<div class="anaDiv">
<?php echo $this->geriLink;?>
</div>

<div id="YetkiBirim" style=" min-width: 50%; max-height:500px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
    
</div>

<div id="SinavGirmis" style=" min-width: 50%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Sınav Başarı Yüzdeleri (Portal Üzerinden)</p>
<table style="width:100%; text-align:center;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">Yeterlilik Kodu</th>
			<th width="40%">Yeterlilik</th>
			<th width="10%">Sınava Giren Aday</th>
			<th width="10%">İlk Sınavda Belge Alan Aday</th>
			<th width="10%">İlk Sınav Başarı Yüzdesi</th>
			<th width="10%">Belgeli Aday</th>
			<th width="10%">Genel Başarı Yüzdesi</th>
		</tr>
	</thead>
	<tbody id="sgTbody">
	
	</tbody>
	</table>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="verilenbelgeDetayContainer" style="width:520px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv">
		<p style="background-color:#00A5DD;color:#ffffff;font-size: large;text-align:center">Verilen Belgeler</p>
		<div  id="verilenBelgelerYeterlilikDetay">
			<div class="anaDiv">
	    		<div class="div25 font16 hColor">
	    			Yeterlilik Adı:
	    		</div>
	    		<div class="div75"  id="yeterlilikad"></div>
	    	</div>
	    	<div class="anaDiv">
	    		<div class="div25 font16 hColor">
	    			Yeterlilik Kodu:
	    		</div>
	    		<div class="div75" id="yeterlilikkod"></div>
	    	</div>
    	</div>
		<table width="100%" style="text-align:center" border="1">
			<thead style="background-color:#71CEED">
				<tr>
					<th width="10%">Yıl</th>
					<th width="10%">Portal Üzerinden Verilen Belge Sayısı</th>
					<th width="10%">Manuel Verilen Belge Sayısı</th>
					<th width="15%">Toplam Verilen Belge Sayısı</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".verilenbelgeyeterlilikdetay").click(function(){
		  jQuery("#verilenBelgelerYeterlilikDetay").show();
		 jQuery("#verilenbelgeDetayContainer").lightbox_me({
				overlaySpeed: 350,
				lightboxSpeed: 400,
		    	centered: true,
		        closeClick:true,
		        closeEsc:true,
		        overlayCSS: {background: 'black', opacity: .7}
		    });
		    
		jQuery.ajax({
			type: "POST",
			dataType:"json",
			url: "index.php?option=com_profile&format=raw&task=verilenBelgelerDetayByYetId",
			data: "kurid=<?php echo $kurulus['USER_ID'];?>&yetid="+jQuery(this).attr('yetid'),
			beforeSend:function(){
				 jQuery.blockUI();
 			},
			success: function(data){
				jQuery("#verilenbelgeDetayContainer table tbody").html("");
				jQuery.each(data,function(key,val){
					jQuery("#verilenbelgeDetayContainer #yeterlilikad").html(val['YETERLILIK_DATAS']['YETERLILIK_ADI']);
					jQuery("#verilenbelgeDetayContainer #yeterlilikkod").html(val['YETERLILIK_DATAS']['YETERLILIK_KODU']+'/'+val['YETERLILIK_DATAS']['REVIZYON']);
					jQuery.each(val['YETERLILIK_VERILEN_BELGE'],function(key2,val2){
						val2['BELSAY'] = (val2['BELSAY'] ? val2['BELSAY'] : 0);
						val2['HAKSAY'] = (val2['HAKSAY'] ? val2['HAKSAY'] : 0);
						
						val2['BELSAY'] = parseInt(val2['BELSAY']);
						val2['HAKSAY'] = parseInt(val2['HAKSAY']);
							jQuery("#verilenbelgeDetayContainer table tbody").append("<tr>"+
																						"<td>"+key2+"</td>"+
																						"<td>"+val2['HAKSAY']+"</td>"+
																						"<td>"+val2['BELSAY']+"</td>"+
																						"<td>"+(val2['BELSAY']+val2['HAKSAY'])+"</td>"+
																					 "</tr>");
					
					});
				});
			},
			complete : function (){
				jQuery.unblockUI();
         	}
		});
    });

    jQuery(".verilenbelgedetay").click(function(){
        jQuery("#verilenBelgelerYeterlilikDetay").hide();
    	jQuery("#verilenbelgeDetayContainer").lightbox_me({
			overlaySpeed: 350,
			lightboxSpeed: 400,
	    	centered: true,
	        closeClick:true,
	        closeEsc:true,
	        overlayCSS: {background: 'black', opacity: .7}
	    });

    	jQuery.ajax({
			type: "POST",
			dataType:"json",
			url: "index.php?option=com_profile&format=raw&task=verilenBelgelerDetay",
			data: "kurid=<?php echo $kurulus['USER_ID'];?>",
			beforeSend:function(){
				 jQuery.blockUI();
 			},
			success: function(data){
				jQuery("#verilenbelgeDetayContainer table tbody").html("");
				jQuery.each(data['YETERLILIK_VERILEN_BELGE'],function(key,val){

					val['BELSAY'] = (val['BELSAY'] ? val['BELSAY'] : 0);
					val['HAKSAY'] = (val['HAKSAY'] ? val['HAKSAY'] : 0);
					
					val['BELSAY'] = parseInt(val['BELSAY']);
					val['HAKSAY'] = parseInt(val['HAKSAY']);
					
					jQuery("#verilenbelgeDetayContainer table tbody").append("<tr>"+
							"<td>"+key+"</td>"+
							"<td>"+val['HAKSAY']+"</td>"+
							"<td>"+val['BELSAY']+"</td>"+
							"<td>"+(val['BELSAY']+val['HAKSAY'])+"</td>"+
						 "</tr>");
				});
			},
			complete : function (){
				jQuery.unblockUI();
         	}
		});
    });
});
	
function getBirims(yetId){
	jQuery('#YetkiBirim').html('');
	jQuery.ajax({
		asycn:false,
		type:"POST",
		url:"index.php?option=com_profile&task=YetkiliBirims&format=raw",
		data:"yetId="+yetId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var ekle = '<h2><u>'+dat[0]['YETERLILIK_KODU']+' '+dat[0]['YETERLILIK_ADI']+'</u></h2><br>';
				ekle += '<table style="margin-bottom:10px; margin-top:10px; width:100%" border="1">'
						+'<thead style="background-color:#71CEED">'
					+'<tr>'
						+'<th width="10%">#</th>'
						+'<th width="70%">Yeterlilik</th>'
						+'<th width="20%">Yetki Tarihi</th>'
					+'</tr>'
				+'</thead>'
				+'<tbody>';
				var say = 1;
				jQuery.each(dat[1],function(key,vall){
					if(say%2 == 0){
						ekle += '<tr bgcolor="#efefef">';
					}else{
						ekle += '<tr>';
					}
					ekle+='<td align="center">'+say+'</td>';
					if(dat[0]['YENI_MI'] == 0){
						ekle += '<td>'+dat[0]['YETERLILIK_KODU']+'/'+vall['BIRIM_KODU']+' - '+vall['BIRIM_ADI']+'</td>';
					}
					else{
						ekle += '<td>'+vall['BIRIM_KODU']+' - '+vall['BIRIM_ADI']+'</td>';
					}
					ekle+='<td align="center">'+vall['TARIH']+'</td>';
					ekle+='</tr>';
					say++;
				});

				jQuery('#YetkiBirim').html(ekle);
				
	             jQuery('#YetkiBirim').lightbox_me({
	           	  	centered: true,
	             });
			}
		}
	});
}

function SinavGirmisTop(kurId){
	jQuery('#loaderGif').lightbox_me({
		centered: true,
        closeClick:false,
        closeEsc:false  
    });
	jQuery.ajax({
		asycn:false,
		type:'POST',
		url:"index.php?option=com_profile&task=SinavaGirmisTop&format=raw",
		data:'kurId='+kurId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		var basarili = dat;
		var ekle = '';
		var even = 'bgcolor="#efefef"';
		var say = 1;
		var sayGir = 0;
		var sayBas = 0;
		var sayBassiz = 0;
		
		jQuery.each(dat,function(key,val){
			if(say%2==0){
				bcolor = 'bgcolor="#efefef"';
			}else{
				bcolor = 'bgcolor="#ffffff"';
			}
			
			ekle += '<tr '+bcolor+'>';
			ekle += '<td align="center">'+val['YETERLILIK_KODU']+'/'+val['REVIZYON']+'</td>';
			ekle += '<td align="center">'+val['YETERLILIK_ADI']+'</td>';
			ekle += '<td align="center">'+val['ADAY']+'</td>';
			ekle += '<td align="center">'+(val['BELGELI']-val['BELGELIBASSIZ'])+'</td>';
			ekle += '<td align="center">'+(parseFloat((val['BELGELI']-val['BELGELIBASSIZ'])/val['ADAY'])*100).toFixed(2)+'</td>';
			ekle += '<td align="center">'+val['BELGELI']+'</td>';
			ekle += '<td align="center">'+(parseFloat(val['BELGELI']/val['ADAY'])*100).toFixed(2)+'</td>';
			
// 			ekle += '<td align="center">%'+Math.ceil((parseInt(val['BELGE_ALAN'])*100)/(parseInt(basarisiz[val['YETERLILIK_ID']])+parseInt(val['BELGE_ALAN'])))+'</td>';
			ekle += '</tr>';
// 			sayGir += parseInt(val['SINAVA_GIREN']);
// 			sayBas += parseInt(val['BELGE_ALAN']);
// 			sayBassiz += parseInt(basarisiz[val['YETERLILIK_ID']]);
			say++;
		});

// 		ekle += '<tr>';
// 		ekle += '<td colspan="2" align="right">Toplam:</td>';
// 		ekle += '<td>'+sayGir+'</td>';
// 		ekle += '<td>'+sayBas+'</td>';
// 		ekle += '<td>'+sayBassiz+'</td>';
// 		ekle += '<td>%'+Math.ceil((parseInt(sayBas)*100)/(parseInt(sayBas)+parseInt(sayBassiz)))+'</td>';
// 		ekle += '</tr>';

		jQuery('#sgTbody').html(ekle);
		jQuery('#loaderGif').trigger('close');
		jQuery('#SinavGirmis').lightbox_me({
       	  	centered: true,
        });
	});
}
</script>