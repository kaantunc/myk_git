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
				<?php if($this->canEdit){
					echo '<th>Düzenle</th>';
				}?>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 1; 
		foreach($yets as $row){
			echo '<tr>';
			echo '<td>'.$say.'</td>';
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
			
			if($this->canEdit){
// 				echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncYetUcretDuzenle('.$row['YETERLILIK_ID'].')">Düzenle</button></td>';
				echo '<td><a href="index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout=yeterlilik_ucret&yetId='.$row['YETERLILIK_ID'].'" class="btn btn-xs btn-primary">Düzenle</a></td>';
			}
			$say++;
		}
		?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
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


	jQuery('#YetUcretKaydet').live('click',function(e){
		e.preventDefault();
		
		if(jQuery('#YetUcretForm input[name="basTarih"]').val() == ''){
			alert('Başlangıç Tarihi kısmını boş bırakmayınız.');
		}else if(jQuery('#YetUcretForm input[name="yetUcret"]').val() == ''){
			alert('Yeterlilik Ücreti kısmını boş bırakmayınız.');
		}else if(jQuery('#YetUcretForm input[name="yetId"]').val() == 0){
			alert('Bir hata meydana geldi. Sayfayı yenileyip tekrar deneyin.');
		}else{
			jQuery('#YetUcretForm').submit();
			OpenLightBox('#loaderGif');
			CloseLightBox('#yeniDis');
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

function FuncYetUcretDuzenle(yetId){
	// #YetUcretForm
	jQuery('#YetUcretForm input[name="basTarih"]').val('');
	jQuery('#YetUcretForm input[name="yetUcret"]').val('');
	jQuery('#YetUcretForm input[name="yetId"]').val(0);

	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_yeterlilik_taslak_yeni&task=YetUcretGetir&format=raw",
		data:"yetId="+yetId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			var yets = dat['yets'];
			var yetUcret = dat['yetUcret'];
		
			if(yetUcret){
				jQuery('#YetUcretForm input[name="yetUcret"]').val(yetUcret['UCRET']);
			}
			jQuery('#YetUcretForm select[name=kararSayi]').val(yetUcret['BAKANLAR_KURULU_KARAR_SAYI_ID']);
			jQuery('#YetUcretForm input[name=basTarih]').val(yetUcret['BAS_TARIH']);
			
			jQuery('#YetUcretForm #baslik').html(yets['YETERLILIK_KODU']+'/'+yets['REVIZYON']+' '+yets['YETERLILIK_ADI']+'</br> Yeterlilik Ücret Güncelleme Ekranı');
			jQuery('#YetUcretForm input[name="yetId"]').val(yetId);
			OpenLightBox('#yeniDis');
		}else{
			
		}
	});
}

</script>

<!-- Yeterlilik Ücret Ekleme MODAL -->
<div id="yeniDis" style="width:500px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="YetUcretForm" enctype="multipart/form-data" action="index.php?option=com_yeterlilik_taslak_yeni&task=YeterlilikUcretKaydet">
    	<div class="anaDiv text-center font20 hColor" id="baslik">
    		
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Karar Sayısı:
    		</div>
    		<div class="div60">
    			<select style="width:62%; height:25px;" name="kararSayi">
    				<option value="">Seçiniz</option>
    			<?php 
    				foreach($this->kararSayilari as $data){ 
    					echo "<option value='".$data['ID']."'>".$data['KARAR_SAYI']."</option>";
    				}	
    			?>
    			</select>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Başlangıç Tarihi:
    		</div>
    		<div class="div60">
    			<input type="text" class="input-sm tarih" name="basTarih"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Yeterlilik Ücreti:
    		</div>
    		<div class="div60">
    			<input type="number" class="input-sm" name="yetUcret" onkeypress="return isNumberKey(event)"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-success" id="YetUcretKaydet">Kaydet</button>
    		</div>
    		<div class="divYan">
    			<button type="button" class="btn btn-xs btn-danger" onclick="CloseLightBox('#yeniDis')">İptal</button>
    		</div>
    	</div>        
        <input type="hidden" name="yetId" value="0" />
    </form>
</div>
<!-- Yeterlilik Ücret Ekleme MODAL SON -->

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
