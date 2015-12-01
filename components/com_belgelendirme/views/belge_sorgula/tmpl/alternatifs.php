<?php
$yets = $this->yets;
$yeterlilik = '<option value="0">Seçiniz</option>';

foreach ($yets as $row){
	$yeterlilik .= '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</option>';
}
?>
<style>
.width150{
	width:150px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>div{
	padding-top:10px;
}
.aramaSonuc{
 	display:none;
	margin-top:20px;
}
#alternatifId{
	display:none;
}
</style>
<div class="aramaClass">
<div class="width150">Yeterlilik:</div><div><select id="yeterlilik"><?php echo $yeterlilik;?></select></div>
<div id="alternatifId"><div class="width150">Alternatif:</div><div><select id="altId"></select></div>
<div><button type="button" id="alternatifIndir">Ara</button></div></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#yeterlilik').live('change',function(e){
		e.preventDefault();
		jQuery('#alternatifId').hide();
		jQuery('#altId').html('');
		
		var yetId = jQuery(this).val();
		if(yetId == 0){
			alert('Lütfen bir yeterlilik seçiniz.');
		}
		else{
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_belgelendirme&task=getAlternatifYeterlilik&format=raw",
				data:'yetId='+yetId,
				success:function(data){
					var dat = jQuery.parseJSON(data);
					if(dat.length>0){
						var alternatif = '<option value="0">Seçiniz</option>';
						jQuery.each(dat,function(key,vall){
							alternatif += '<option value="'+vall['ALTERNATIF_ID']+'">'+vall['ALTERNATIF_ADI']+'</option>';
						});

						jQuery('#altId').html(alternatif);
						jQuery('#alternatifId').show();
					}
					else{
						alert('Seçmiş olduğunuz yeterliliğin alternatifi tanımlanmamıştır.');
					}
				}
			});
		}
	});
});
</script>