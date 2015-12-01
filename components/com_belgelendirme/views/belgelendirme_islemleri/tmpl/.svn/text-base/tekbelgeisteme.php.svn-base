<?php 
$yeterlilik = $this->kurYets;
$yets = '';
foreach ($yeterlilik as $yet){
	$yets .= '<option value="'.$yet['YETERLILIK_ID'].'">'.$yet['YETERLILIK_KODU'].' - '.$yet['YETERLILIK_ADI'].'</option>';
}
$birims = $this->birims;
?>

<form id="belgeIsteme" method="POST" enctype="multipart/form-data" action="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=tekbelgeisteme">
	<label>T.C. Kimlik No:<input type="text" name="tckn" id="tckn"/></label><br>
	<label>Yeterlilik: <select name="yeterlilik_id" id="yeterlilik_id">
		<?php echo $yets;?>
	</select></label>
	<input type="button" value="Gönder" id="gonder"/>
</form>

<?php
if(is_array($birims)){
	if($birims[0] == true){
		echo '<hr>';
		echo '<h3>'.$birims[1].' T.C. Kimilik numaralı adayın bu yeterlilikten belge başvurusu tamamlanmıştır.</h3>';
		echo '<h4>Başarılı olduğu birimler</h4><ul>';
		foreach ($birims[2] as $birim){
			echo '<li>'.$birim[0]['BIRIM_KODU'].' - '.$birim[0]['BIRIM_ADI'].'</li>';
		}
		echo '</ul>';
	}
	else{
		echo '<hr>';
		echo '<h3>'.$birims[1].' T.C. Kimilik numaralı aday bu yeterlilikten belge almaya hak kazanamamıştır</h3>';
		echo '<h4>Başarılı olduğu birimler</h4>';
		foreach ($birims[3] as $birim){
			echo '<p>'.$birim[0]['BIRIM_KODU'].' - '.$birim[0]['BIRIM_ADI'].'</p>';
		}
		foreach ($birims[4] as $birim){
			echo '<p>'.$birim[0]['BIRIM_KODU'].' - '.$birim[0]['BIRIM_ADI'].'</p>';
		}
	}
}
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#gonder').live('click',function(e){
            e.preventDefault();
            if(confirm('Aday gerekli şartları sağladıysa, belge başvurusu tamamlanacaktır. Emin misiniz?')){
    //			jQuery('#belgeIsteme').submit();
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgesiVarmi&format=raw",
                    data: 'tckn='+jQuery('#tckn').val()+'&yeterlilik_id='+jQuery('#yeterlilik_id').val(),
                    success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat){
                            if(confirm('Aday daha önceden belge başvurusu yapılmıştır. Başvuruyu yenilerseniz önceki başvurusu iptal edilecektir. Devam etmek istiyor musunuz?')){
                                jQuery('#belgeIsteme').submit();
                            }
                        }
                        else{
                            jQuery('#belgeIsteme').submit();    
                        }
                    }
                });
            }
	});
});
</script>