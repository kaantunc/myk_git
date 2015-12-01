<?php
$kurulus = $this->AllKurulus;

$type = $this->type;

$kuruluslar = '<option value="0">Seçiniz</option>';
foreach($kurulus as $row){
	$kuruluslar .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
?>
<div>
<label for="kurulus">Kuruluş Adı:</label>
<select name="kurulus" id="kurulus"><?php echo $kuruluslar;?></select>
<input type="button" id="getir" value="Getir" />
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#getir').live('click',function(e){
		e.preventDefault();
		if(jQuery('#kurulus').val()==0){
			alert('Lütfen bir kuruluş seçiniz.');
		}else{
			<?php if($type == "degerlendirici"){ ?>
				window.location.href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_degerlendirici&kurulus='+jQuery('#kurulus').val();			
			<?php }else{ ?>
				window.location.href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_sinav_yeri&kurulus='+jQuery('#kurulus').val();
			<?php } ?>
			}
	});
});
</script>