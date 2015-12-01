<?php
$kurulus = $this->kurs;
$yeterlilik = $this->yeterlilik;
$yetBirims = $this->yetBirims;
$denetims = $this->denetims;

$denetSelect = '<option value="0">Denetim Dışı</option>';
foreach($denetims as $row){
	$denetSelect .= '<option value="'.$row['DENETIM_ID'].'">'.$row['DENETIM_ID'].' ('.$row['DENETIM_TARIHI_BASLANGIC'].') '.$row['DENETIM_TURU_ACIKLAMA'].'</option>';
}
?>
<style>
<!--
.anaDiv{
	display:inline-block;
	width:100%;
	margin-top:10px;
}
.div50{
	width:50%;
	display:inline-block;
}
.div70{
	width:70%;
	display:inline-block;
}
.div30{
	width:30%;
	display:inline-block;
}
.divBorder{
	border: 1px solid #1C617C;;
	display:none;
}

.closeUl{
	font-size: medium;
}

.openUl{
	font-size: large;
	color:#26A9E0;
}

.ulBirim>li{
	padding:10px;
	list-style: outside none none;
}

.btnDanger{
	color:#ffffff;
	background-color:#C9302C;
	font-size:small;
	padding:5px;
	border-radius:10px;
	cursor:pointer;
}

.btnDuzenle{
	color:#ffffff;
	background-color:#46A285;
	font-size:small;
	padding:5px;
	border-radius:10px;
	cursor:pointer;
}

.btnYeniYetki{
	color:#ffffff;
	background-color:#1D9D74;
	font-size:small;
	padding:5px;
	border-radius:10px;
	cursor:pointer;
}

.birimTbody td{
padding:10px;
}
-->
</style>
<form id="yetkiForm" method="post" enctype="multipart/form-data" action="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&task=YeniYetkiKaydet">

<input type="hidden" name="kurulusId" value="<?php echo $kurulus['USER_ID'];?>" />
<input type="hidden" name="yetId" value="<?php echo $yeterlilik['YETERLILIK_ID'];?>" />

<div class="anaDiv">
	<h2><?php echo $kurulus['KURULUS_ADI'];?> Kuruluşu Yeterlilik Yetkilendirme</h2>
</div>
<div class="anaDiv">
	<h2><u><?php echo $yeterlilik['YETERLILIK_KODU'].'/'.$yeterlilik['REVIZYON'].' '.$yeterlilik['YETERLILIK_ADI'];?></u></h2>
</div>
<div class="anaDiv">
	<div class="div30">
		<button class="btnYeniYetki" type="button" id="TumSec"><i class="fa fa-plus-circle"></i> Tümünü Seç</button>
		<button class="btnDanger" type="button" id="TumKaldir"><i class="fa fa-minus-circle"></i> Tümünü Kaldır</button>
	</div>
	<div class="div30">
		Yetki Türü: <select id="denetSel"><?php echo $denetSelect;?></select><br>
		<button class="btnYeniYetki" type="button" id="TumUyg"><i class="fa fa-plus"></i> Tümüne Uygula</button>
	</div>
	<div class="div30" style="float:right">
		Tarih: <input type="text" class="tarih" readonly="readonly" id="tumTarih"/><br>
		<button class="btnYeniYetki" type="button" id="TumUygTarih"><i class="fa fa-plus"></i> Tümüne Uygula</button>
	</div>
</div>
<div class="anaDiv">
<!-- Birimler Bas -->
<table width="100%" border="1" cellpadding="0" cellspacing="1">
<thead style="text-align:center;background-color:#71CEED">
	<tr>
		<th width="3%">#</th>
		<th width="37%">Birim</th>
		<th width="15%">Yetki Verilme Tarihi</th>
		<th width="20%">Yetki Türü</th>
	</tr>
</thead>
<tbody class="birimTbody">
<?php foreach($yetBirims as $row){
	echo '<tr>';
	echo '<td><input type="checkbox" name="yetBirims[]" value="'.$row['BIRIM_ID'].'"/></td>';
	echo '<td>';
	if($yeterlilik['YENI_MI'] == 1){
		echo $row['BIRIM_KODU'].' '.$row['BIRIM_ADI'];
	}else{
		echo $yeterlilik['YETERLILIK_KODU'].'/'.$row['BIRIM_KODU'].' '.$row['BIRIM_ADI'];
	}
	echo '</td>';
	echo '<td><input type="text" name="yetkiTarih['.$row['BIRIM_ID'].']" readonly="readonly" class="BrTarih"/></td>';
	echo '<td><select name="yetkiTur['.$row['BIRIM_ID'].']" class="yetkiTur">'.$denetSelect.'</select></td>';
	echo '</tr>';
}?>
</tbody>
</table>
<!-- Birimler SON -->
</div>
<div class="anaDiv">
	<button class="btnYeniYetki" type="button" id="yetkiKaydet"><i class="fa fa-plus-circle"></i> Kaydet</button>
</div>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#TumSec').live('click',function(){
		jQuery('input[name="yetBirims[]"]').prop('checked',true);
	});

	jQuery('#TumKaldir').live('click',function(){
		jQuery('input[name="yetBirims[]"]').prop('checked',false);
	});

	jQuery('#yetkiKaydet').live('click',function(){
		if(jQuery('input[name="yetBirims[]"]:checked').length == 0){
			alert('Lütfen en az bir tane birim seçiniz.');
		}else{
			jQuery('#yetkiForm').submit();
		}
	});

	jQuery('#TumUyg').live('click',function(){
		jQuery('.yetkiTur').val(jQuery('#denetSel').val());
	});

	jQuery('#TumUygTarih').live('click',function(){
		jQuery('.BrTarih').val(jQuery('#tumTarih').val());
	});

	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});

	jQuery('.BrTarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});
});
</script>