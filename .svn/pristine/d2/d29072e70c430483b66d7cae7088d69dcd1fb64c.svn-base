<?php
$kurs = $this->kurs;
$yetkiYets = $this->yetkiYets;
$yetkiBirims = $this->yetkiBirims;
$yetkiDisiYets = $this->yets;

$yetkiDisiSelect = '<option value="0">Seçiniz</option>';
foreach($yetkiDisiYets as $tow){
	$yetkiDisiSelect .= '<option value="'.$tow['YETERLILIK_ID'].'">'.$tow['YETERLILIK_KODU'].'/'.$tow['REVIZYON'].' '.$tow['YETERLILIK_ADI'].'</option>';
}
?>

<style>
<!--
.divBorder{
	border: 1px solid #1C617C;;
	display:none;
}

.closeUl{
	font-size: medium;
	cursor:pointer;
}

.openUl{
	font-size: large;
	color:#26A9E0;
	cursor:pointer;
}

.DangerSpan{
	color:#c9302c;
	font-size:17px;
}

ul>li{
padding:10px;
}

.btnDanger{
	color:#ffffff;
	background-color:#C9302C;
	font-size:medium;
	padding:2px;
	border-radius:10px;
	cursor:pointer;
}

.btnDuzenle{
	color:#ffffff;
	background-color:#46A285;
	font-size:medium;
	padding:2px;
	border-radius:10px;
	cursor:pointer;
}

.btnYeniYetki{
	color:#ffffff;
	background-color:#1D9D74;
	font-size:medium;
	padding:2px;
	border-radius:10px;
	cursor:pointer;
}
-->
</style>
<?php 
if($kurs['ASKI']){
?>
<div class="anaDiv text-center">
	<img src="<?php echo SITE_URL;?>images/askiyaalindi.gif" />
</div>
<?php	
}
?>
<div class="anaDiv">
	<h2><?php echo $kurs['KURULUS_ADI'];?> Kuruluşunun Yetkilendirildiği Yeterlilikler</h2>
</div>

<div class="anaDiv">
<button class="btn btn-sm btn-success" type="button" id="newYet"><i class="fa fa-lg fa-plus-circle"></i> Yeni Yeterlilik Yetki Ver</button>
</div>

<div class="anaDiv">
<?php if($yetkiYets){?>
	<ul style="list-style: outside none none;">
	<?php
	foreach($yetkiYets as $row){
		$say = 0;
		echo '<li><span class="closeUl"><i class="fa fa-shield fa-lg fa-rotate-270"></i> '.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</span>';
		echo '<div class="divBorder"><ul id="yet_'.$row['YETERLILIK_ID'].'">';
		foreach($yetkiBirims[$row['YETERLILIK_ID']] as $cow){
			if($cow['DURUM'] == 1){
				if($cow['YET_ESKI_MI'] == 1){
					echo '<li>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</li>';
				}else{
					echo '<li>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</li>';
				}	
			}else{
				$say++;
			}
		}
		if($say == count($yetkiBirims[$row['YETERLILIK_ID']])){
			echo "<li><span class='DangerSpan'>Kuruluşun, bu yeterliliğin birimlerinden yetkileri alınmıştır. Detaylı bilgi için 'Yetkiyi Düzenle' tuşuna basınız.</span></li>";
		}
		echo '</ul>';
		echo '<button class="btn btn-sm btn-info" type="button" onclick="yetkiDuzenle('.$kurs['USER_ID'].','.$row['YETERLILIK_ID'].')" ><i class="fa fa-pencil fa-lg"></i> Yetkiyi Düzenle</button>';
		echo '</div>';
		echo '</li>';
	} 
	?>
	</ul>
<?php }else{ ?>
<h3>Kuruluş henüz hiç bir yeterlilikten yetkilendirilmemiştir.</h3>
<?php } ?>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>

<div id="YeniYetkiDiv" style=" min-width: 200px; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
<form id="yetkiForm" method="post" enctype="multipart/form-data" action="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yeni_yetki">
<div class="anaDiv">
	Yeterlilikler: <select name="yetkiYet" id="yetkiYet"><?php echo $yetkiDisiSelect;?></select>
	<input type="hidden" name="kurulusId" value="<?php echo $kurs['USER_ID'];?>"/>
</div>
<div class="anaDiv">
	<button class="btn btn-sm btn-success" type="button" id="YetkiVer"><i class="fa fa-lg fa-plus-circle"></i> Ekle</button>
	<button class="btn btn-sm btn-danger" type="button" id="YetkiIptal"><i class="fa fa-lg fa-times-circle"></i> İptal</button>
</div>
</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.closeUl').live('click',function(){
// 		jQuery('.openUl').closest('li').children('div').hide();
// 		jQuery('.openUl').children('i').addClass('fa-rotate-270');
// 		jQuery('.openUl').addClass('closeUl');
// 		jQuery('.openUl').removeClass('openUl');

		jQuery(this).closest('li').children('div').show();
		jQuery(this).children('i').removeClass('fa-rotate-270');
		jQuery(this).addClass('openUl');
		jQuery(this).removeClass('closeUl');
	});

	jQuery('.openUl').live('click',function(){
		jQuery(this).closest('li').children('div').hide();
		jQuery(this).children('i').addClass('fa-rotate-270');
		jQuery(this).addClass('closeUl');
		jQuery(this).removeClass('openUl');
	});

	jQuery('#newYet').live('click',function(){
		jQuery('#YeniYetkiDiv').lightbox_me({
			centered: true,
		    closeClick:false,
		    closeEsc:false  
		});
	});

	jQuery('#YetkiIptal').live('click',function(){
		jQuery('#YeniYetkiDiv').trigger('close');
	});

	jQuery('#YetkiVer').live('click',function(){
		if(jQuery('#yetkiYet').val() == 0 || jQuery('#yetkiYet').val() == ''){
			alert('Lütfen eklemek istediğiniz yeterliliği seçiniz.');
		}else{
			jQuery('#yetkiForm').submit();
		}
	});
});

function yetkiDuzenle(kurId,yetId){
	window.location.href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki_duzenle&kurulusId="+kurId+"&yetkiYet="+yetId;
}

// jQuery('#loaderGif').lightbox_me({
// 	centered: true,
//     closeClick:false,
//     closeEsc:false  
// });
// jQuery('#loaderGif').trigger('close');
</script>