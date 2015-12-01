<?php

echo $this->sayfaLink;
?>

<div class="anaDiv font20 hColor fontBold text-center">
	Bakanlar Kurulu Karar Sayıları
</div>
<?php if($this->canEdit){ ?>
<form id="KararNoEkle" action="index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout=kurul_kararno&task=kararNoEkle" method="post">
<div class="anaDiv">
	<div class="div25 hColor fontBold">Bakanalar Kurulu Karar Sayısı</div>
	<div class="div75"><input type="text" name="karar_sayisi"  class="input-sm inputW50"/></div>
</div>
<div class="anaDiv">
	<div class="div25 hColor fontBold">Tarih</div>
	<div class="div75"><input type="text" name="karar_tarih"  class="input-sm inputW50"/></div>
</div>
<div class="anaDiv">
	<div class="div45">
		<button type="submit" id="kararEkle" class="btn btn-sm btn-success" style="float:right; margin: 0 10px 0 0;">Ekle</button>
	</div>
</div>
</form>
<?php } ?>
<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th>#</th>
				<th>Karar No</th>
				<th>Tarih</th>
				<?php if($this->canEdit){ ?>
				<th>İşlem</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php 
			$i = 1;
			foreach ($this->kararSayilari as $data){ ?>
				<tr>
					<td width="5%"><?php echo $i;?></td>
					<td><?php echo $data['KARAR_SAYI'];?></td>
					<td><?php echo substr($data['KARAR_TARIH'],0,10);?></td>
					<?php if($this->canEdit){ ?>
					<td>
						<button type="button" kararid="<?php echo $data['ID'];?>" class="btn btn-sm btn-danger kararSil">Sil</button>
						<button type="button" kararid="<?php echo $data['ID'];?>" class="btn btn-sm btn-warning kararDuzenle">Düzenle</button>
					</td>
					<?php } ?>
				</tr>
		<?php }
		?>
		</tbody>
	</table>
</div>

<div class="kararNoDuzenlePopupDiv" id="kararNoDuzenlePopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:375px; height:100px; display:none; background-color: white;">
	<table>
		<tr>
			<td><b>Bakanalar Kurulu Karar Sayısı</b><input type="hidden" name="karar_id_edit" /></td>
			<td><input type="text" name="karar_sayisi_edit"  class="input-sm inputW50"/></td>
		</tr>
		<tr>
			<td><b>Tarih</b></td>
			<td><input type="text" name="karar_tarih_edit"  class="input-sm inputW50"/></td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="float:right; padding:5px;">
					<input type="button" id="save" class="btn btn-xs btn-success" value="Kaydet" />
					<input type="button" id="canceledit" class="btn btn-xs btn-danger" value="İptal" />
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
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

	jQuery("input[name=karar_tarih],input[name=karar_tarih_edit]").datepicker({
        changeYear: true,
        changeMonth: true
 	});
 	
 	jQuery(".kararDuzenle").click(function(){
 	 	 jQuery("input[name=karar_sayisi_edit]").val(jQuery(this).closest("tr").find("td:eq(1)").html());
 	 	 jQuery("input[name=karar_tarih_edit]").val(jQuery(this).closest("tr").find("td:eq(2)").html());
 	 	 jQuery("input[name=karar_id_edit]").val(jQuery(this).attr('kararid'));
 		 jQuery('#kararNoDuzenlePopupDiv').lightbox_me({
	        	centered: true,
	        	closeClick:false,
	        	closeEsc:false,
	         });
 	});
 	jQuery(".kararSil").click(function(){
 	 	if(confirm('İlgili karar no silinecek emin misiniz?')){

	 		jQuery.ajax({
				  url: "index.php?option=com_yeterlilik_taslak_yeni&task=kararNoSil&format=raw",
				  type: "POST",
				  data: "kararId="+jQuery(this).attr('kararid'),
				  dataType: 'json',
				  beforeSend:function(){
						 jQuery.blockUI();
		 		  },
				  success: function(data) {
					  if(data['STATUS'] == "1"){
						  alert(data['MESSAGE']);  
						  window.location.reload();
					  }else{
						  alert(data['MESSAGE']);
					  }
				  },
				  complete : function (){
						jQuery.unblockUI();
		          }
			});	
 	 	}
 	});

 	jQuery("#canceledit").click(function(){
 		jQuery('#kararNoDuzenlePopupDiv').trigger('close');
	});

	jQuery("#save").click(function(){
		jQuery('#kararNoDuzenlePopupDiv').trigger('close');
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=kararNoDuzenle&format=raw",
			  type: "POST",
			  data: "kararId="+jQuery("input[name=karar_id_edit]").val()+"&kararNo="+jQuery("input[name=karar_sayisi_edit]").val()+"&kararTarih="+jQuery("input[name=karar_tarih_edit]").val(),
			  dataType: 'json',
			  beforeSend:function(){
					 jQuery.blockUI();
	 		  },
			  success: function(data) {
				  if(data['STATUS'] == "1"){
					  alert(data['MESSAGE']);  
					  window.location.reload();
				  }else{
					  alert(data['MESSAGE']);
				  }
			  },
			  complete : function (){
					jQuery.unblockUI();
	          }
		});	
	});
});
</script>