<?php
$kurulus = $this->kurulus;

$kurSelect = '<option value="0">Seçiniz</option>';
foreach($kurulus as $row){
	$kurSelect .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
}
?>
<style>
.btnYeniYetki{
	color:#ffffff;
	background-color:#1D9D74;
	font-size:medium;
	padding:5px;
	border-radius:10px;
}
</style>
<div class="anaDiv">
<h2><u>Belgelendirme Kuruluşlarına Yetki Verme</u></h2>
</div>
<form id="yetYetkiForm" method="post" enctype="multipart/form-data" action="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki">
<div class="anaDiv">
Kurulus: <select name="kurulusId" id="kurId"><?php echo $kurSelect;?></select>
</div>
<div class="anaDiv">
<button class="btn btn-sm btn-success" type="button" id="kurGetir"><i class="fa fa-lg fa-search-plus"></i> Kuruluşun Yetki Kapsamı Getir</button>
</div>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#kurGetir').live('click',function(){
		if(jQuery('#kurId').val() == 0 || jQuery('#kurId').val() == ''){
			alert('Lütfen Bir Kuruluş Seçiniz.');
		}else{
			jQuery('#yetYetkiForm').submit();
		}
	});
});
</script>