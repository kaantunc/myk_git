<style>
<!--
.customtable td{
	padding: 4px;
}
-->
</style>
<?php $notlar = $this->notlar;
$kurulus = $this->kurulus_bilgi;
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<div class="form_item">
<div style="padding:10px 0 0 20px;">
	<form id="NotForm" method="POST" action="index.php?option=com_profile&task=NotFormKaydet">
	<input type="hidden" name="kurulusId" value="<?php echo $kurulus['USER_ID'];?>"/>
	<table width="50%" class="customtable">
	  <tr>
	    <td width="20%">Puan</td>
	    <td width="90%">
	    	<select name="puan">
				<?php for($i = 1 ; $i <= 5 ; $i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</td>
	  </tr>
	  <tr>
	    <td>Not</td>
	    <td>
	    	<textarea name="not" style="width:400px; height:60px;"></textarea>
	    </td>
	  </tr>
	  <tr>
	  	<td colspan="2">
	  		<input type="submit" value="Ekle" style="float:right; padding:3px; margin: 0 20px 0 0;"/>
	  	</td>
	  </tr>
	</table>
	</form>
	<table id="notListesiGrid" class="display compact" style="text-align:center;margin-bottom:10px; margin-top:20px; width:100%" border="1">
		<thead style="background-color:#71CEED">
			<tr>
				<th width="3%">#</th>
				<th width="10%">Not</th>
				<th width="10%">Puan</th>
				<th width="15%">Ekleyen Kullanıcı</th>
				<th width="15%">Eklenme Tarihi</th>
				<th width="15%">Ekleyen Kurum</th>
				<th width="12%">İşlem</th>
			</tr>
		</thead>
		<tbody id="notlar">
		<?php 
		$i = 1;
		foreach($notlar as $not){?>
			<tr>
				<td><?php echo $i;?><input type="hidden" name="rowid" value="<?php echo $not['NOTID'];?>" /></td>
				<td><?php echo $not['NOTU'];?></td>
				<td><?php echo $not['PUAN'];?></td>
				<td><?php echo $not['USERNAME'];?></td>
				<td><?php echo $not['EKLENME_TARIHI'];?></td>
				<td><?php echo $not['KURULUS_ADI'];?></td>
				<td><input type="button" value="Düzenle" class="editRow"/> / <input type="button" value="Sil" class="removeRow" style="background-color: red; color:white;"/></td>
			</tr>
		<?php 
			$i++;
		}?>
		</tbody>
	</table>
	</div>
</div>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
<div id="updateNotContainer" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h4 style="padding:0 0 5px 0;">Not Güncelle</h4>
	<hr>
	<table width="50%" class="customtable" style="margin: 10px 0 0 0;">
	  <tr>
	    <td width="20%">Puan</td>
	    <td width="90%">
	    	<select name="puan">
				<?php for($i = 1 ; $i <= 5 ; $i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</td>
	  </tr>
	  <tr>
	    <td>Not</td>
	    <td>
	    	<textarea name="not" style="width:400px; height:60px;"></textarea>
	    </td>
	  </tr>
	  <tr>
	  	<td colspan="2">
	  		<input type="hidden" name="notid" value="" />
	  		<input type="button" id="cancelButton" value="İptal" style="float:right; padding:3px; margin: 0 20px 0 0;"/>
	  		<input type="button" id="updateButton" value="Güncelle" style="float:right; padding:3px; margin: 0 20px 0 0;"/>
	  	</td>
	  </tr>
	</table>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery('#notListesiGrid').dataTable({
			"aaSorting": [[ 2, "desc" ]],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"bInfo": true,
			"bPaginate": true,
			"bFilter": true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"sLengthMenu": "# _MENU_ öğe göster",
				"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
				"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
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
	});
	jQuery(".removeRow").click(function(){
		row = jQuery(this);
		notId = jQuery(this).closest('tr').find("input[name=rowid]").val();
		if(confirm("Notu silmek istediğinizden emin misiniz?")){
		jQuery.ajax({
	            type:"POST",
	            url:"index.php?option=com_profile&task=NotSil&format=raw",
	            data:"notId="+notId,
	            beforeSend: function() {
	            	jQuery('#loaderGif').lightbox_me({
	        			centered: true,
	        	        closeClick:false,
	        	        closeEsc:false  
	                });
	            },
	            success:function(data){
		            console.log(data);
			        row.closest('tr').remove();
	            },  
	            complete : function (){
					jQuery('#loaderGif').trigger('close');
					alert("Not başarıyla kaldırıldı");
	            }
			});
		}
	});

	jQuery(".editRow").click(function(){
		notId = jQuery(this).closest('tr').find("input[name=rowid]").val();
		jQuery.ajax({
            type:"POST",
            url:"index.php?option=com_profile&task=NotGetirWithId&format=raw",
            data:"notId="+notId,
            dataType: "json",
            beforeSend: function() {
            	jQuery('#updateNotContainer').lightbox_me({
        			centered: true,
        	        closeClick:false,
        	        closeEsc:false  
                });
            },
            success:function(data){
	            jQuery("#updateNotContainer select[name=puan]").val(data[0].PUAN);
	            jQuery("#updateNotContainer textarea[name=not]").val(data[0].NOTU);
	            jQuery("#updateNotContainer input[name=notid]").val(data[0].NOTID);
            }
		});
    });
    jQuery("#updateNotContainer #cancelButton").click(function(){
    	jQuery("#updateNotContainer select[name=puan]").val("");
        jQuery("#updateNotContainer textarea[name=not]").val("");
        jQuery("#updateNotContainer input[name=notid]").val("");
    	jQuery('#updateNotContainer').trigger('close');
    });

    jQuery("#updateNotContainer #updateButton").click(function(){
    	row = jQuery(this);
		notId = jQuery("#updateNotContainer input[name=notid]").val();
		puan = jQuery("#updateNotContainer select[name=puan]").val();
		not = jQuery("#updateNotContainer textarea[name=not]").val();
		jQuery.ajax({
	            type:"POST",
	            url:"index.php?option=com_profile&task=NotGuncelle&format=raw",
	            data:"notId="+notId+"&puan="+puan+"&not="+not,
	            dataType: "json",
	            beforeSend: function() {
	            	jQuery('#loaderGif').lightbox_me({
	        			centered: true,
	        	        closeClick:false,
	        	        closeEsc:false  
	                });
	            },
	            success:function(data){
		            if(data.STATUS == 1){
		            	alert(data.STATUSNAME);
		            	window.location.reload();
		            	updateDataTable();
		            }else{
		            	alert(data.STATUSNAME);
			        }
	            },  
	            complete : function (){
					jQuery('#loaderGif').trigger('close');
	            }
			});
    	jQuery('#updateNotContainer').trigger('close');
    });

    function updateDataTable(){
        $('#notListesiGrid').dataTable().fnDestroy();
    	jQuery('#notListesiGrid').dataTable().fnReloadAjax( 'index.php?option=com_profile&task=NotGetirWithId&format=raw' );
//     	jQuery('#notListesiGrid').dataTable( {
//     	        "ajax": "index.php?option=com_profile&task=NotGetirWithId&format=raw",
//     	        "columns": [
//     	            { "data": "Not" },
//     	            { "data": "Puan" },
//     	            { "data": "Ekleyen Kullanıcı" },
//     	            { "data": "Eklenme Tarihi" },
//     	            { "data": "Ekleyen Kurum" },
//     	            { "data": "salary" }
//     	] } );
    }
</script>