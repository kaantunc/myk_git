<?php 
echo $this->pageTree;

$tesvikonaykomitesi = $this->tesvikonaykomitesi;
$usergroups = $this->usergroups;
?>

<div style="padding-top:25px;padding-bottom: 15px;width:100%;float: none;text-align:center; font-size:16px; font-weight: bold;">

</div>
<div style="width:100%;float: none;">
	<form action="index.php?option=com_admin&layout=tesvikonaykomitesi&task=tesvikOnayKomitesiKaydet" method="post" id="genelKurulForm">
		<input type="button" class="btn btn-info" id="adduser" value="Kişi Ekle" />
		<div class="adv-table">
			<table width="100%" id="liste"  class="display compact table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<th width="10%">#</th>
						<th>Adı Soyadı</th>
						<th>Birimi</th>
						<th width="10%">İşlem</th>
						<th width="10%">Sıra</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$i = 1;
					foreach($tesvikonaykomitesi as $data){
				?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $data['ADSOYAD'];?>
							<input type="hidden" class='usercode' name="usercode[]" value="<?php echo $data['USER_ID']; ?>" />
						</td>
						<td><?php echo $data['GROUP'];?>
							<input type="hidden" class='groupcode' name="groupcode[]" value="<?php echo $data['ROL_ID']; ?>" />
						</td>
						<td><input type='button' class='btn btn-danger small removeuser' value='Sil' /></td>
						<td>
							<?php if($i == 1){?>
								<a href="javascript:void(0)" class="uprow" style="display:none;">
									<img src="<?php echo SITE_URL;?>images/arrow_up.png">
								</a>
								<a href="javascript:void(0)" class="downrow">
									<img src="<?php echo SITE_URL;?>images/arrow_down.png">
								</a>
							<?php }else if($i == count($tesvikonaykomitesi)){?>
								<a href="javascript:void(0)" class="uprow">
									<img src="<?php echo SITE_URL;?>images/arrow_up.png">
								</a>
								<a href="javascript:void(0)" class="downrow" style="display:none;">
									<img src="<?php echo SITE_URL;?>images/arrow_down.png">
								</a>
							<?php } else{ ?>
								<a href="javascript:void(0)" class="uprow">
									<img src="<?php echo SITE_URL;?>images/arrow_up.png">
								</a>
								<a href="javascript:void(0)" class="downrow">
									<img src="<?php echo SITE_URL;?>images/arrow_down.png">
								</a>					
							<?php }?>
						</td>
					</tr>	
				<?php
						$i++;
					}
				?>
				</tbody>
			</table>
		</div>
		<div style="float:right; margin: 0 20px 0 0;">
		    <input type="submit" class="btn btn-success" value="Kaydet" />
		</div>
	</form>
</div>
<div id="yenikisiekle" style="border: 1px solid #00A7DE; padding: 10px; width:350px; height:85px; display:none; background-color: white;">
	<table width="100%">
		<tr>
			<td width="40%"><b>Birim</b></td>
			<td width="60%">
				<select id="usergroup" style="width:100%;">
					<option>Seçiniz</option>
					<?php foreach ($usergroups as $usergroup){
						echo "<option value='".$usergroup['id']."'>".$usergroup['name']."</option>";
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Personel</b></td>
			<td>
				<select id="userlist" style="width:100%;">
					<option>Seçiniz</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="button" id="choseuser" style="float:right; margin:10px 10px 10px 0px;" value="Seç" />
				<input type="button" id="canceluser" style="float:right; margin:10px 10px 10px 0px;" value="İptal" />
			</td>
		</tr>
	</table>
</div>
<script>
	jQuery(document).ready(function(){
		
		 var options = new Array();
		 options['id'] = "liste";
		 options['paging'] = false;
		 var oTableBirim = Datatable_bootstrap.init(options);
		
		jQuery("#adduser").click(function(){
			 jQuery('#yenikisiekle').lightbox_me({
	        	centered: true,
	        	closeClick:false,
	        	closeEsc:false,
	         });
		});

		jQuery("#canceluser").click(function(){
			 jQuery('#yenikisiekle').trigger("close");
		});

		jQuery("#usergroup").change(function(){
			if(jQuery(this).val() != ""){
				jQuery("#userlist option[value]:not(null)").remove()
				jQuery.ajax({
			 		asycn:false,
			 		type:"POST",
			 		dataType: 'json',
			 		url:"index.php?option=com_admin&task=getUserByGroup&format=raw",
			 		data:"userGroup="+jQuery(this).val(),
			 		success:function(data){
			 			jQuery.each( data, function( key,val ) {
							  jQuery("#userlist").append("<option value='"+val['id']+"'>"+val['name']+"</option>");
						 });
			 		}
			 	});
			}
		});

		jQuery("#choseuser").click(function(){
			username = jQuery("#userlist option:selected").html();
			usercode = jQuery("#userlist option:selected").val();

			groupname = jQuery("#usergroup option:selected").html(); 
			groupcode = jQuery("#usergroup option:selected").val(); 
			rownum = (jQuery("#liste tbody tr").length+1).toString();

			if(jQuery("#liste").find(".usercode[value='"+usercode+"']").length < 1){
			var aiAdded = oTableBirim.fnAddData([rownum,
			                                     username+"<input type='hidden' class='usercode' name='usercode[]' value='"+usercode+"' />",
			                                     groupname+"<input type='hidden' class='groupcode' name='groupcode[]' value='"+groupcode+"' />",
			                         			 "<input type='button' class='btn btn-danger small removeuser' value='Sil' />",
			                         			 "<a href='javascript:void(0);' class='uprow'><img src='<?php echo SITE_URL;?>/images/arrow_up.png'/></a>   <a href='javascript:void(0);' class='downrow' style='display:none;'><img src='<?php echo SITE_URL;?>/images/arrow_down.png'/></a>"]);
			jQuery('#yenikisiekle').trigger("close");
			jQuery("#usergroup").val('');
			jQuery("#usergroup").trigger('change');
			setUpDownButtons("liste");
			}else{
				alert("İlgili komite üyesi daha önce eklenmiştir.");
			}
		});

		jQuery(".removeuser").live('click',function(){
			if(confirm('Seçmiş olduğunuz kullanıcı onay komitesinden kaldırılacak emin misiniz?')){
				var nRow = jQuery(this).parents('tr')[0];
				oTableBirim.fnDeleteRow( nRow );
			}
		});

		jQuery(".uprow").live('click',function(){
    	 	var index = jQuery(this).parents("tr").index();
    	    if ((index-1) >= 0) {
    	        var data = oTableBirim.fnGetData();
    	        oTableBirim.fnClearTable();
    	        data.splice((index-1), 0, data.splice(index,1)[0]);
    	        oTableBirim.fnAddData(data);
    	    }
	    	    jQuery(".uprow").show();
		    	 jQuery(".downrow").show();
		    	 jQuery(".uprow:first").hide();
		    	 jQuery(".downrow:first").show();
		    	 jQuery(".uprow:last").show();
		    	 jQuery(".downrow:last").hide();
		 });
	     jQuery(".downrow").live('click',function(){
	    	  var index = jQuery(this).parents("tr").index();
		   	    if ((index+1) >= 0) {
		   	        var data = oTableBirim.fnGetData();
			   	 	oTableBirim.fnClearTable();		   	     	
		   	        data.splice((index+1), 0, data.splice(index,1)[0]);
		   	     	oTableBirim.fnAddData(data);
		   	    }
		   	 jQuery(".uprow").show();
	    	 jQuery(".downrow").show();
	    	 jQuery(".uprow:first").hide();
	    	 jQuery(".downrow:first").show();
	    	 jQuery(".uprow:last").show();
	    	 jQuery(".downrow:last").hide();
		 });
	});

	function setUpDownButtons(table_id){
		jQuery("#"+table_id+" tbody tr").each(function(index){
			if(index == 0){
				jQuery(this).find(".uprow").hide();
				jQuery(this).find(".downrow").show();
			}else if(index == (jQuery("#"+table_id+" tbody tr").length - 1)){
				jQuery(this).find(".uprow").show();
				jQuery(this).find(".downrow").hide();
			}else{
				jQuery(this).find(".uprow").show();
				jQuery(this).find(".downrow").show();
			}
		});
	}
	
</script>
