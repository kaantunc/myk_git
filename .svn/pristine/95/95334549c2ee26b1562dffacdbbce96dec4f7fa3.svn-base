<?php

echo $this->sayfaLink;

$yets = $this->yets;
$yetUcret = $this->yetUcret;
$sektorler = $this->sektorler;

$sekSelect = '<option value="0">Bütün Sektörler</option>';
foreach($sektorler as $row){
	$selected = '';
	if($this->sekId == $row['SEKTOR_ID']){
		$selected = ' selected="selected"';
	}
	
	$sekSelect .= '<option value="'.$row['SEKTOR_ID'].'" '.$selected.'>'.$row['SEKTOR_ADI'].'</option>';
}
?>
<div class="anaDiv font20 hColor fontBold text-center">
Yeterlilik Bazlı Bakanlar Kurulu Ücret Tarifesi
</div>
<form action="index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout=default" method="post" enctype="application/x-www-form-urlencoded">
<div class="anaDiv">
	<div class="div20 hColor font16">
		Sektörler:
	</div>
	<div class="div80">
		<select class="input-sm inputW95" name="sekId"><?php echo $sekSelect; ?></select>
	</div>
</div>
<div class="anaDiv text-center">
	<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Ara</button>
</div>
</form>

<div class="anaDiv"><hr></div>

<form id="YetUcretForm" action="index.php?option=com_yeterlilik_taslak_yeni&task=ToplamZamUygula" method="post" enctype="application/x-www-form-urlencoded">
<div class="anaDiv">
	<div class="div30 fontBold hColor">
		Uygulanacak Zam:
	</div>
	<div class="div70">
		<i class="fontBold">%</i><input type="text" name="zam" class="input-sm" onkeypress="return isNumberKey(event)"/>
	</div>
</div>

<div class="anaDiv">
	<div class="div30 fontBold hColor">
		Başlangıç Tarihi:
	</div>
	<div class="div70">
		<input type="text" class="input-sm tarih" name="basTarih" readonly="readonly"/>
	</div>
</div>

<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th>#</th>
				<th>Yeterlilik</th>
				<th>Revizyon</th>
				<th>Sektör</th>
				<th>Ücret</th>
				<th>Başlangıç Tarihi</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 1; 
		foreach($yets as $row){
			echo '<tr>';
			echo '<td><input type="checkbox" name="yets['.$row['YETERLILIK_ID'].']" value="'.$row['YETERLILIK_ID'].'" class="YetUcCheck" checked="checked"/></td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '<td>'.$row['REVIZYON'].'</td>';
			echo '<td>'.$row['SEKTOR_ADI'].'</td>';
			if(array_key_exists($row['YETERLILIK_ID'], $yetUcret)){
				echo '<td>'.$yetUcret[$row['YETERLILIK_ID']]['UCRET'].' TL</td>';
				echo '<td>'.$yetUcret[$row['YETERLILIK_ID']]['BAS_TARIH'].'</td>';
			}else{
				echo '<td></td>';
				echo '<td></td>';
			}
			$say++;
		}
		?>
		</tbody>
	</table>
</div>

<div class="anaDiv">
	<button type="button" class="btn btn-sm btn-success" id="ZamKaydet">Zam Uygula</button>
</div>

</form>

<script type="text/javascript">
jQuery(document).ready(function($){
	jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": false,
		"bFilter": false,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Yeterlilik Var)",
			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
	});

	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});


	jQuery('#ZamKaydet').live('click',function(e){
		e.preventDefault();
		
		if(jQuery('#YetUcretForm input[name="basTarih"]').val() == ''){
			alert('Başlangıç Tarihi kısmını boş bırakmayınız.');
		}else if(jQuery('#YetUcretForm input[name="zam"]').val() == ''){
			alert('Uygulanacak Zam kısmını boş bırakmayınız.');
		}else{
			jQuery('#YetUcretForm').submit();
			OpenLightBox('#loaderGif');
		}
	});

});

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   
   if (!(
		   charCode == 8 
		   || charCode == 46 
		   || (charCode >= 35 && charCode <= 40)
		   || (charCode >= 48 && charCode <= 57)
     )){
      return false;
   }

   return true;
}

function CloseLightBox(ele){
	jQuery(ele).trigger('close');
	jQuery("#YetUcretForm select[name=kararSayi]").val('');
	return true;
}

function OpenLightBox(ele, overSpeed, boxSpeed){
	jQuery(ele).lightbox_me({
		overlaySpeed: 350,
		lightboxSpeed: 400,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

function UyariLightBox(sonra){
	if(sonra){
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7},
	        onClose: OpenLightBox(sonra)
	    });
	}else{
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	}
}
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
