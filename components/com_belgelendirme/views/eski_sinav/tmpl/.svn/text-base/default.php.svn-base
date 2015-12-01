<?php
$yeterlilik = $this->yeterlilikler;

$selectYet = '<option value="0">Seçiniz</option>';

foreach ($yeterlilik as $yet){
	$selectYet .= '<option value="'.$yet['YETERLILIK_ID'].'">'
			.$yet['YETERLILIK_KODU'].'/'.$yet['REVIZYON'].' '.$yet['YETERLILIK_ADI'].
	'</option>';
}

?>
<style>
.anaDiv{
width: 100%;
padding:15px 15px;
}
.leftDiv{
width:20%;
float:left;
}
.rightDiv{
width:80%;
float:right;
}
</style>

<h2><u>Adaylara Başarılı Birim Ekleme Modülü</u></h2>

<form id="EskiBirimForm" method="post" action="index.php?option=com_belgelendirme&view=eski_sinav&layout=aday_yeter" enctype="multipart/form-data">
<div class="anaDiv">
<div class="leftDiv"><h2>Yeterlilik:</h2></div>
<div class="rightDiv"><select style="width:50%" id="yetSelect" name="yetSelect"><?php echo $selectYet;?></select></div>
</div>

<div class="anaDiv">
<div class="leftDiv"><h2>Kimlik No:</h2></div>
<div class="rightDiv"><input type="text" style="width:50%" id="textKimlik" name="Kimlik"/></div>
</div>
</form>

<div class="anaDiv">
<input type="button" id="eskiGetir" value="Getir" />
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#eskiGetir').live('click',function(e){
		e.preventDefault();
		var kimlik = jQuery('#textKimlik').val();
		var yetId = jQuery('#yetSelect').val();

		if(yetId == 0){
			alert('Lütfen bir yeterlilik seçiniz.');
		}
		else if(kimlik == ''){
			alert('Lütfen başarılı birim eklemek istediğiniz adayın kimlik numarasını giriniz.');
		}
		else{
			jQuery('#EskiBirimForm').submit();
		}
	});
})
</script>