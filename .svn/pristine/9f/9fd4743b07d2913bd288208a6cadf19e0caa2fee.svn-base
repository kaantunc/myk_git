<?php
$kurulus = $this->kurs;
$yeterlilik = $this->yeterlilik;
$yetBirims = $this->yetBirims;
$birims = $this->birims;
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
.div40{
	width:40%;
	display:inline-block;
}
.div30{
	width:30%;
	display:inline-block;
}
.div20{
	width:20%;
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
	font-size:medium;
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
<form id="yetkiForm" method="post" enctype="multipart/form-data" action="index.php?option=com_belgelendirme_yetki&task=YetkiOnayla">

<input type="hidden" name="kurulusId" value="<?php echo $kurulus['USER_ID'];?>" />
<input type="hidden" name="yetId" value="<?php echo $yeterlilik['YETERLILIK_ID'];?>" />

<div class="anaDiv">
	<h2><?php echo $kurulus['KURULUS_ADI'];?> Kuruluşu Yeterlilik Yetkilendirme</h2>
</div>
<div class="anaDiv">
	<h2><u><?php echo $yeterlilik['YETERLILIK_KODU'].'/'.$yeterlilik['REVIZYON'].' '.$yeterlilik['YETERLILIK_ADI'];?></u></h2>
</div>
<div class="anaDiv">
	<div class="div70">
		<button class="btnYeniYetki" type="button" id="TumSec"><i class="fa fa-plus-circle"></i> Hepsine Onay Ver</button>
		<button class="btnDanger" type="button" id="TumKaldir"><i class="fa fa-minus-circle"></i> Hepsinin Onayını Kaldır</button>
	</div>
</div>
<div class="anaDiv">
<!-- Birimler Bas -->
<table width="100%" border="1" cellpadding="0" cellspacing="1">
<thead style="text-align:center;background-color:#71CEED">
	<tr>
		<th width="3%">#</th>
		<th width="37%">Birim</th>
		<th width="15%">Yetki <span style="color:green">Verilme</span>/<span style="color:red">Geri Alınma</span> Tarihi</th>
		<th width="20%">Yetki Türü</th>
		<th width="25%">Açıklama</th>
	</tr>
</thead>
<tbody class="birimTbody">
<?php foreach($birims as $row){
	$checked = '';
	if(array_key_exists($row['BIRIM_ID'], $yetBirims)){
		$gecTarih = '';
		if($yetBirims[$row['BIRIM_ID']]['DURUM'] == 1){
// 			$checked = 'checked="true"';
			$gecTarih = substr($yetBirims[$row['BIRIM_ID']]['YETKININ_VERILDIGI_TARIH'],0,10).' tarihinde yetki verildi.)';
		}else if($yetBirims[$row['BIRIM_ID']]['DURUM'] == 0){
			$gecTarih = substr($yetBirims[$row['BIRIM_ID']]['YETKININ_GERI_ALINDIGI_TARIH'],0,10).' tarihinde yetki geri alındı.)';
		}
	
	
	$denetSelect = 'Denetim Dışı';
	foreach($denetims as $pow){
		$selected = "";
		if($pow['DENETIM_ID'] == $yetBirims[$row['BIRIM_ID']]['DENETIM_ID']){
			$denetSelect = $pow['DENETIM_ID'].' ('.$pow['DENETIM_TARIHI_BASLANGIC'].') '.$pow['DENETIM_TURU_ACIKLAMA'];
		}
// 		$denetSelect = '<option value="'.$pow['DENETIM_ID'].'" '.$selected.'>'.$pow['DENETIM_ID'].' ('.$pow['DENETIM_TARIHI_BASLANGIC'].') '.$pow['DENETIM_TURU_ACIKLAMA'].'</option>';
	}
	
	echo '<tr>';
	echo '<td><input checked="checked" type="checkbox" name="yetBirims[]" value="'.$row['BIRIM_ID'].'" /></td>';
	echo '<td>';
	if($yeterlilik['YENI_MI'] == 1){
		echo $row['BIRIM_KODU'].' '.$row['BIRIM_ADI'];
	}else{
		echo $yeterlilik['YETERLILIK_KODU'].'/'.$row['BIRIM_KODU'].' '.$row['BIRIM_ADI'];
	}
	echo '</td>';
	
	if($yetBirims[$row['BIRIM_ID']]['DURUM'] == 1){
		echo '<td bgcolor="green" align="center">';
		echo '<span style="color:white;font-size:16px;font-weight:bold">'.substr($yetBirims[$row['BIRIM_ID']]['YETKININ_VERILDIGI_TARIH'],0,10).'</span>';
	}else if($yetBirims[$row['BIRIM_ID']]['DURUM'] == 0){
		echo '<td bgcolor="red" align="center">';
		echo '<span style="color:white;font-size:16px;font-weight:bold">'.substr($yetBirims[$row['BIRIM_ID']]['YETKININ_GERI_ALINDIGI_TARIH'],0,10).'</span>';
	}
	echo '</td>';
	echo '<td>';
	echo $denetSelect;
	echo '</td>';
	echo '<td>';
	if($yetBirims[$row['BIRIM_ID']]['DENETIM_ID']>0){
		echo '('.$yetBirims[$row['BIRIM_ID']]['DENETIM_ID'].' denetiminde ';
	}else{
		echo '(Denetim dışı ';
	}
	echo $gecTarih;
	echo '</td>';
	echo '</tr>';
	}
}?>
</tbody>
</table>
<!-- Birimler SON -->
</div>
<div class="anaDiv">
	<button class="btnYeniYetki" type="button" id="yetkiKaydet"><i class="fa fa-plus-circle"></i> Onayla</button>
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
// 		if(jQuery('input[name="yetBirims[]"]:checked').length == 0){
// 			if(confirm('Verilen yetkileri almak istediğinizden emin misiniz?')){
// 				jQuery('#yetkiForm').submit();
// 			}else{
// 				return false;
// 			}
// 		}else{
// 			jQuery('#yetkiForm').submit();
// 		}
		jQuery('#yetkiForm').submit();
	});

	jQuery('#TumUyg').live('click',function(){
		jQuery('.yetkiTur').val(jQuery('#denetSel').val());
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