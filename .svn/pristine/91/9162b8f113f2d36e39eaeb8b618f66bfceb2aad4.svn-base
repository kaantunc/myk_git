<?php
$kurs = $this->kurs;
$yetkiYets = $this->yetkiYets;
$yetkiBirims = $this->yetkiBirims;
?>

<style>
<!--
.anaDiv{
	display:inline-block;
	width:100%;
	margin-top:10px;
}
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
<div class="anaDiv">
	<h2><?php echo $kurs['KURULUS_ADI'];?> Kuruluşunun Yetki Onayı Bekleyen Yeterlilikler</h2>
</div>

<div class="anaDiv">
<?php if($yetkiYets){?>
	<ul style="list-style: outside none none;">
	<?php
	foreach($yetkiYets as $row){
		$say = 0;
		echo '<li><span class="closeUl" onclick="yetkiDuzenle('.$kurs['USER_ID'].','.$row['YETERLILIK_ID'].')"><i class="fa fa-shield fa-lg fa-rotate-270"></i> '.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</span>';
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
	window.location.href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=kurulus_yetki_duzenle&kurulusId="+kurId+"&yetkiYet="+yetId;
}

// jQuery('#loaderGif').lightbox_me({
// 	centered: true,
//     closeClick:false,
//     closeEsc:false  
// });
// jQuery('#loaderGif').trigger('close');
</script>