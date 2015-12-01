<?php
$yetUcret = $this->yetUcrets['yetUcret'];
$yetBilgi = $this->yetUcrets['yetBilgi'];
?>

<div class="anaDiv text-center fontBold font20 hColor">
<?php echo $yetBilgi[0]['YETERLILIK_KODU'].'/'.$yetBilgi[0]['REVIZYON'].' '.$yetBilgi[0]['YETERLILIK_ADI'].'<br><br>'.'Bakanlar Kurulu Dönemlik Ücret Tarifesi';?>
</div>

<?php if($this->canEdit){?>
<div class="anaDiv text-right">
	<button type="button" class="btn btn-sm btn-primary" onclick="FuncYetUcretYeni()"><i class="fa fa-plus"></i> Yeni Ücret Ekle</button>
</div>
<?php }?>

<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact text-center">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th>#</th>
				<th>Ücret</th>
				<th>Başlangıç Tarihi</th>
				<th>BK Karar Sayı</th>
				<?php if($this->canEdit){
					echo '<th>Düzenle</th>';
					echo '<th>Sil</th>';
				}?>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 1; 
		foreach($yetUcret as $row){
			echo '<tr>';
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['UCRET'].' TL</td>';
			echo '<td>'.$row['BAS_TARIH'].'</td>';
			echo '<td>'.$row['KARAR_SAYI'].'</td>';
			if($this->canEdit){
				echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncYetUcretDuzenle('.$row['ID'].')">Düzenle</button></td>';
				echo '<td><button type="button" class="btn btn-xs btn-danger" onclick="FuncYetUcretSil('.$row['ID'].')">Sil</button></td>';
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
   
   if(charCode != 8 
		   && !(charCode == 46 && evt.target.value.indexOf('.') <= 0) 
		   && !(charCode >= 48 && charCode <= 57) 
		   && !(charCode >= 35 && charCode <= 40) 
		   ){
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

function FuncYetUcretYeni(){
	jQuery('select[name="kararSayi"]').val('');
	jQuery('input[name="basTarih"]').val('');
	jQuery('input[name="yetUcret"]').val('');
	jQuery('input[name="yetUcId"]').val(0);
	OpenLightBox('#yeniDis');
	return false;
}

function FuncYetUcretDuzenle(yetUcId){
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_yeterlilik_taslak_yeni&task=AjaxGetYetUcret&format=raw",
		data:"yetUcId="+yetUcId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);

		if(dat){
			jQuery('select[name="kararSayi"]').val(dat['KARAR_ID']);
			jQuery('input[name="basTarih"]').val(dat['BAS_TARIH']);
			jQuery('input[name="yetUcret"]').val(dat['UCRET']);
			jQuery('input[name="yetUcId"]').val(dat['ID']);
			OpenLightBox('#yeniDis');
		}else{
			alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
		}
		return false;
	});
}

function FuncYetUcretSil(yetUcId){
	if(confirm('Bu ücret tarifesini silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_yeterlilik_taslak_yeni&task=AjaxDeleteYetUcret&format=raw",
			data:"yetUcId="+yetUcId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Yeterlilik dönem ücreti başarılı bir şekilde silindi.');
				OpenLightBox('#loaderGif');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				OpenLightBox('#loaderGif');
				window.location.reload();
			}
		});
	}
	return false;
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
    			<input type="text" class="input-sm" name="yetUcret" onkeypress="return isNumberKey(event)"/>
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
        <input type="hidden" name="yetId" value="<?php echo $this->yetId;?>" />
        <input type="hidden" name="yetUcId" value="0" />
    </form>
</div>
<!-- Yeterlilik Ücret Ekleme MODAL SON -->

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>