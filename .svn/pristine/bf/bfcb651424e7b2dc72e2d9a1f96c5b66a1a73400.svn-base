<form
<?php 
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; 
	$alternatif = $this->alternatif;
	$altdata = $alternatif['data'];
	$altBirims = $alternatif['birims']; 
	$zorunluBirim = $this->zorunluBirim;
	$secmeliBirim = $this->secmeliBirim;
	$birims = '';
	foreach ($zorunluBirim as $cow){
		$birims .= '<input type="checkbox" checked="checked"  disabled value="'.$cow['BIRIM_ID'].'"/> '.$cow['BIRIM_KODU'].'-'.$cow['BIRIM_ADI'].'<br>';
	}
	foreach ($secmeliBirim as $cow){
		$birims .= '<input type="checkbox" name="Birims[]" value="'.$cow['BIRIM_ID'].'"/> '.$cow['BIRIM_KODU'].'-'.$cow['BIRIM_ADI'].'<br>';
	}
?>
</form>
<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">Gruplandırma Alternatifleri</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div style="margin-left:30px">

<?php if ($this->canEdit){
    if(is_array($altdata)){
        if(count($altdata) == 0){?>
        <div style="margin-bottom:10px">
        <p>Aşağıdaki alanlardan seçim yapılmaması durumunda belge hak edilmesi için zorunlu birimlerin alınmasının yeterli olacağı varsayılacaktır.</p>
        </div>
        <label>Belge hak edilmesi için;</label><br>
        <label><input type="radio" name="radioAlter" value="radioNewNum">Gerekli minimum seçmeli birim sayısını girmek istiyorum</label><br>
        <label><input type="radio" name="radioAlter" value="radioNewAlter">Gruplandırma alternatiflerini birimleri seçerek belirlemek istiyorum</label><br>
        <?php    
        }else{?>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery('#radioNewAlter').show();
                });
            </script>
        <?php    
        }
    }else{
        if(empty($altdata) || $altdata == 0){
        ?>
        <div style="margin-bottom:10px">
        <p>Aşağıdaki alanlardan seçim yapılmaması durumunda belge hak edilmesi için zorunlu birimlerin alınmasının yeterli olacağı varsayılacaktır.</p>
        </div>
        <label>Belge hak edilmesi için;</label><br>
        <label><input type="radio" name="radioAlter" value="radioNewNum">Gerekli minimum seçmeli birim sayısını girmek istiyorum</label><br>
        <label><input type="radio" name="radioAlter" value="radioNewAlter">Gruplandırma alternatiflerini birimleri seçerek belirlemek istiyorum</label><br>
        <?php
        }
        else{
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery('#radioNewNum').show();
                    jQuery('#altsay').val(<?php echo $altdata; ?>);
                    jQuery('#AltEkleNum').append('<a href="#" id="deleteNum">Sil</a>');
                });
            </script>
        <?php   
        }
    }?>


<div id="radioNewNum" style="display: none">
    <hr style="margin-top:10px">
    <form id="AltEkleNum" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">
            <strong>Belge verilmesi için gereken minumum seçmeli birim sayısı:</strong> <input type="text" id="altsay" name="altSay"/><br>
            <input type="hidden" name="altTipi" value="1"/>
            <a href="#" id="KayAltNum">Kaydet</a>
    </form> 
</div>
<div id="radioNewAlter" style="display: none;">
    <hr style="margin-top:10px">
    <a href="#" id="addAlt">Yeni Alternatif Ekle</a> 
    <div id="alterAdd" style="display:none">
            <form id="AltEkle" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">
                    <strong>Alternatif Adı:</strong> <input type="text" id="altname" name="altName"/><br>
                    <strong>Birimler:</strong>
                            <div id="Birims" style="margin-left:30px;">
                                    <?php echo $birims;?>
                            </div>
                    <input type="hidden" name="altTipi" value="2"/>
                    <a href="#" id="KayAlt">Kaydet</a>
            </form> 
</div><?php }?><hr style="margin-top:10px;">
</div>
<div id="Alters" style="margin-top:10px">
	<?php foreach ($altdata as $cow){
		echo '<div id="'.$cow['ALTERNATIF_ID'].'"><div id="AltUp">
			<strong>Alternatif Adı:</strong> '.$cow['ALTERNATIF_ADI'].'<br>
			<strong>Birimler:</strong> ';
		$ss = count($altBirims[$cow['ALTERNATIF_ID']]);
		if( $ss > 0){
			foreach ($zorunluBirim as $pow){
				echo $pow['BIRIM_KODU'].',';
			}
			$row = 1;
			foreach ($altBirims[$cow['ALTERNATIF_ID']] as $tow){
				if($ss != $row){
					echo $tow['BIRIM_KODU'].',';
				}
				else{
					echo $tow['BIRIM_KODU'];
				}
				$row++;
			}
		}
		else{
			$row = 1;
			$ss = count($zorunluBirim);
			foreach ($zorunluBirim as $pow){
				if($ss != $row){
					echo $pow['BIRIM_KODU'].',';
				}
				else{
					echo $pow['BIRIM_KODU'];
				}
				$row++;
			}
		}
		if ($this->canEdit){
			echo '<br><a href="#" id="update">Güncelle</a> | <a href="#" id="delete">Sil</a><hr></div></div>';
		}
	}?>
</div>
</div>
<script type="text/javascript">
var altdata = <?php echo json_encode($altdata);?>;
var altBirims = <?php echo json_encode($altBirims);?>;
var zorunlu = <?php echo json_encode($zorunluBirim);?>;
var secmeli = <?php echo json_encode($secmeliBirim);?>;

jQuery(document).ready(function(){
    jQuery('input:radio[name="radioAlter"]').change(function(e){
       e.preventDefault();
       if(jQuery(this).val() == 'radioNewNum'){
           jQuery('#radioNewAlter').hide('slow');
           jQuery('#radioNewNum').show('slow');
       }
       else if(jQuery(this).val() == 'radioNewAlter'){
           jQuery('#radioNewNum').hide('slow');
           jQuery('#radioNewAlter').show('slow');
       }
       
    });
    
	jQuery('#addAlt').live('click',function(e){
		e.preventDefault();
		var altupId = jQuery('#updateAlt').parent('div').attr('id');
		jQuery('div#'+altupId).children('#AltUp').show();
		jQuery('#updateAlt').remove();
		jQuery('#alterAdd').show();
		jQuery('#addAlt').attr('id','alterHide');
	});

	jQuery('#alterHide').live('click',function(e){
		e.preventDefault();
		jQuery('#alterAdd').hide();
		jQuery('#altname').val('');
		jQuery('#Birims').html('');
		jQuery('#Birims').html('<?php echo $birims;?>');
		jQuery('#alterHide').attr('id','addAlt');
	});
	
	jQuery('#KayAlt').live('click',function(e){
		e.preventDefault();
		//alert(jQuery('#Birims input').serialize());
		if(jQuery('#altname').val() == '' ){
			alert('Lütfen Alternatif Adı Girniz.');
		}
		else{
			jQuery('#AltEkle').submit();
		}
	});
        
        jQuery('#KayAltNum').live('click',function(e){
		e.preventDefault();
		//alert(jQuery('#Birims input').serialize());
		if(jQuery('#altsay').val() == '' ){
			alert('Lütfen Alternatif Adı Girniz.');
		}
		else{
			jQuery('#AltEkleNum').submit();
		}
	});

	//update işlemi
	jQuery('#update').live('click',function(e){
		e.preventDefault();
		var altupId = jQuery('#updateAlt').parent('div').attr('id');
		jQuery('div#'+altupId).children('#AltUp').show();
		jQuery('#updateAlt').remove();
		var altId = jQuery(this).closest('#AltUp').parent('div').attr('id');
		var zor = '';
		var sec = '';
		jQuery.each(zorunlu,function(key,vall){
			zor +='<input type="checkbox" checked="checked"  disabled value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
		});
		jQuery.each(secmeli,function(key,vall){
			if(typeof altBirims[altId][vall['BIRIM_ID']] == 'undefined'){
				sec +='<input type="checkbox" name="Birims[]" value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
			}
			else{
				sec += '<input type="checkbox" name="Birims[]" checked="checked" value="'+vall['BIRIM_ID']+'"/> '+vall['BIRIM_KODU']+'-'+vall['BIRIM_ADI']+'<br>';
			}
			
		});
		var ekle = '<div id="updateAlt">'+
			'<form id="form_'+altId+'" action="index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" enctype="multipart/form-data" method="post">'+
			'<strong>Alternatif Adı:</strong> <input type="text" id="altname" name="altName" value="'+altdata[altId]['ALTERNATIF_ADI']+'"/><br>'+
				'<strong>Birimler:</strong>'+
				'<div id="Birims" style="margin-left:30px;">'+
				zor+sec+
				'</div>'+
				'<input type="hidden" name="altId" value="'+altId+'" />'+
				'<input type="hidden" name="upGun" value="1"/>'+
				'<a href="#" id="Guncelle">Kaydet</a> | <a href="#" id="iptal">İptal</a></form><hr></div>';
		jQuery('div#'+altId).children('#AltUp').hide();
		jQuery('div#'+altId).append(ekle);
		
	});

	jQuery('#Guncelle').live('click',function(e){
		e.preventDefault();
		var altId = jQuery(this).closest('#updateAlt').parent('div').attr('id');
		if(jQuery('div#'+altId+' div#updateAlt #form_'+altId).children('#altname').val() == '' ){
			alert('Lütfen Alternatif Adı Girniz.');
		}
		else{
			jQuery('#form_'+altId).submit();
		}
		//alert(jQuery('div#'+altId).children('#updateAlt').children('input').serialize()+jQuery('div#'+altId+' div#updateAlt').children('#Birims').children('input').serialize());
// 		jQuery.ajax({
// 			type: "POST",
//  			url: "index.php?option=com_yeterlilik_taslak&layout=alternatif&task=taslakKaydet&yeterlilik_id=255",
//  			data: jQuery('div#'+altId+' div#updateAlt').children('input#altname').serialize()+'&'+jQuery('div#'+altId+' div#updateAlt').children('#Birims').children('input').serialize()+'&altId='+altId+'&update='+1,
//  			success: function(data){
//  				window.location.reload(true);
//  			}
// 		});
	});
	
	// güncelleme iptal
	jQuery('#iptal').live('click',function(e){
		e.preventDefault();
		var altId = jQuery(this).closest('#updateAlt').parent('div').attr('id');
		jQuery('div#'+altId).children('#updateAlt').remove();
		jQuery('div#'+altId).children('#AltUp').show();
	});

	// silme işlemi
	jQuery('#delete').live('click',function(e){
		e.preventDefault();
		var altId = jQuery(this).closest('#AltUp').parent('div').attr('id');
		if(confirm('Bu alternatifi silmek istediğinizden emin misiniz?')){
			jQuery.ajax({
	 			type: "POST",
	 			url: "index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=AlternatifSil",
	 			data: 'altId='+altId+'&delete='+2,
	 			success: function(data){
	 				//jQuery('div#'+altId).remove();
                                        window.location.reload();
	 			}
	 		});
		}
	});
        
        jQuery('#deleteNum').live('click',function(e){
           e.preventDefault();
           if(confirm('Bu alternatifi silmek istediğinizden emin misiniz?')){
                jQuery.ajax({
                        type: "POST",
                        url: "index.php?option=com_yeterlilik_taslak_yeni&layout=alternatif&task=AlternatifSil",
                        data: 'yetId='+<?php echo $_GET['yeterlilik_id'];?>+'&delete='+1,
                        success: function(data){
                                //jQuery('div#'+altId).remove();
                                window.location.reload();
                        }
                });
            }
        });
});
</script>