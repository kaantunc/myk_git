<?php 
$this->scheduledTasks;
?>
<div class="anaDiv hColor font20 text-center fontBold">
	Zamanlanmış Görevler
</div>
	<div class="container">
		<div class="content">
			<div class="adv-table">
			  <input type="button" name="addtask" value="Zamanlanmış Görev Ekle" class="btn btn-sm btn-primary" />
			  <table id="tasklist" class="display compact table table-hover table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th>Görev Adı</th>
							<th>Başlangıç Tarih - Saat</th>
							<th>Bitiş Tarih - Saat</th>
							<th>Görev Tipi</th>
							<th>Detay</th>
						</tr>
					</thead>
					<tbody id="tasks">
						<?php 
						$i = 1;
						foreach ($this->scheduledTasks as $task) {
							echo "<tr taskid='".$task['ID']."'>
									<td>".$i."</td>
									<td>".$task['TASK_NAME']."</td>
									<td>".$task['TASK_STARTTIME']."</td>
									<td>".$task['TASK_ENDTIME']."</td>
									<td>".$task['TASK_TYPE']."</td>
									<td>"
			  							.($task['TASK_STATUS'] == 0 ? "<input type='button' class='btn btn-xs btn-success' value='Aktif Et' onclick='changeStatus(".$task['ID'].",1);' />" : "<input type='button' class='btn btn-xs btn-info' value='Pasif Et' onclick='changeStatus(".$task['ID'].",0);'/>").
			  						   " <input type='button' class='btn btn-xs btn-warning taskdetail' value='Detay' />
										<input type='button' class='btn btn-xs btn-danger taskremove' value='Sil' />
									</td>
								  </tr>";
							$i++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<div id="taskContainer" style="width:520px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="protestFeeForm" enctype="multipart/form-data" action="index.php?option=com_scheduled_tasks&task=SaveScheduledTask">
    	<div class="anaDiv text-center font20 hColor" id="baslik">
    		Zamanlanmış Görev Formu
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Görev Adı:
    		</div>
    		<div class="div60">
    			<input type="text" name="task_name" class="input-sm inputW60"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Görev Tipi:
    		</div>
    		<div class="div60">
    			<select name="task_type" class="input-sm inputW60" >
    				<option>Seçiniz</option>
    				<option value="1">Fonksiyon</option>
    				<option value="2">Sorgu</option>
    				<option value="3">Url</option>
    			</select>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Görev Çalışma Şekli:
    		</div>
    		<div class="div60">
    			<select name="task_worktype" class="input-sm inputW60" >
    				<option>Seçiniz</option>
    				<option value="1">Her saniye</option>
    				<option value="2">Her Dakika</option>
    				<option value="3">Her Saat</option>
    				<option value="4">Her Gün</option>
    				<option value="5">Her Hafta</option>
    				<option value="6">Her Ay</option>
    				<option value="7">Her Yıl</option>
    			</select>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Görev Durumu:
    		</div>
    		<div class="div60">
    			<select name="task_status" class="input-sm inputW60" >
    				<option>Seçiniz</option>
    				<option value="0">Pasif</option>
    				<option value="1">Aktif</option>
    			</select>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Başlangıç Tarih - Saat:
    		</div>
    		<div class="div60">
    			<input type="text" name="task_starttime"  class="input-sm inputW60" />
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Bitiş Tarih - Saat:
    		</div>
    		<div class="div60">
    			<input type="text" name="task_endtime" class="input-sm inputW60"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div class="div100 font16 hColor">
    			Görev içerik
    		</div>
    		<div class="div100 font16 hColor">
    			<textarea name="task_content" cols="82" rows="20"></textarea>
    		</div>
    	</div>
    	
    	<div class="anaDiv">
    		<div style="float:right;">
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-success" id="saveTask">Kaydet</button>
	    		</div>
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-danger" id="cancelTask">İptal</button>
	    		</div>
    		</div>
    	</div>        
        <input type="hidden" name="parentId" value="0" />
    </form>
</div>

<script>
	jQuery(document).ready(function(){
		var options = new Array();
		 options['id'] = "tasklist";
		 options['paging'] = false;

		 options['bFilter'] = false;
		 options['bInfo'] = false;
	
		 var oTableBirim = Datatable_bootstrap.init(options);

		 jQuery("#cancelTask").click(function(){
			 jQuery("#taskContainer input,select,textarea").val('');
			 jQuery("#taskContainer input[name=parentId]").val('0');
			 jQuery("#taskContainer").trigger('close');
	     });
		 jQuery("input[name=task_starttime],input[name=task_endtime]").mask("99/99/9999 99:99");
		 jQuery("input[name=addtask]").click(function(){
			 jQuery("#taskContainer").lightbox_me({
					overlaySpeed: 350,
					lightboxSpeed: 400,
			    	centered: true,
			        closeClick:false,
			        closeEsc:false,
			        overlayCSS: {background: 'black', opacity: .7}
			    });
		 });

		 jQuery("#saveTask").click(function(){

			 parameters = 'task_name='+jQuery("input[name=task_name]").val()+
			    		  '&task_type='+jQuery("select[name=task_type]").val()+
			    		  '&task_worktype='+jQuery("select[name=task_worktype]").val()+
			    		  '&task_status='+jQuery("select[name=task_status]").val()+
			    		  '&task_starttime='+jQuery("input[name=task_starttime]").val()+
			    		  '&task_endtime='+jQuery("input[name=task_endtime]").val()+
			    		  '&task_content='+jQuery("textarea[name=task_content]").val()+
			    		  '&task_id='+jQuery("#taskContainer input[name=parentId]").val();
			 jQuery.ajax({
		 			type: "POST",
		 			dataType:"json",
		 			url: "index.php?option=com_scheduled_tasks&format=raw&task="+(jQuery("#taskContainer input[name=parentId]").val() == "0" ? "addScheduledTask": "editScheduledTask" ),
		 			data: parameters,
		 			beforeSend:function(){
		 				 jQuery.blockUI();
			 		},
		 			success: function(data){
			 			alert(data['MESSAGE']);
		 				if(data['STATUS'] == true){
	 		 				window.location.reload();
			 			}
		 			},
		 			complete : function (){
		 				jQuery.unblockUI();
		             }
		 		});
		  });

		  jQuery(".taskdetail").click(function(){

			  jQuery.ajax({
		 			type: "POST",
		 			dataType:"json",
		 			url: "index.php?option=com_scheduled_tasks&task=getScheduledTaskById&format=raw",
		 			data: "taskid="+jQuery(this).closest('tr').attr('taskid'),
		 			beforeSend:function(){
		 				 jQuery.blockUI();
			 		},
		 			success: function(data){ 
		 			console.log(data['DATA']);
		 				if(data['STATUS'] == true){
		 					jQuery("#taskContainer input[name=task_name]").val(data['DATA']['TASK_NAME']);
		 					jQuery("#taskContainer select[name=task_type]").val(data['DATA']['TASK_TYPE_ID']);
		 					jQuery("#taskContainer select[name=task_worktype]").val(data['DATA']['TASK_WORKTYPE_ID']);
		 					jQuery("#taskContainer select[name=task_status]").val(data['DATA']['TASK_STATUS']);
		 					jQuery("#taskContainer input[name=task_starttime]").val(data['DATA']['TASK_STARTTIME']);
		 					jQuery("#taskContainer input[name=task_endtime]").val(data['DATA']['TASK_ENDTIME']);
		 					jQuery("#taskContainer textarea[name=task_content]").val(data['DATA']['TASK_CONTENT']);
		 					jQuery("#taskContainer input[name=parentId]").val(data['DATA']['TASK_ID']);
			 			}else{
							alert(data['MESSAGE']);
					 	}
		 			},
		 			complete : function (){
		 				jQuery.unblockUI();
		             }
		 		});
		 		
			 jQuery("#taskContainer input[name=parentId]").val(jQuery(this).closest('tr').attr('taskid'));
			 jQuery("#taskContainer").lightbox_me({
					overlaySpeed: 350,
					lightboxSpeed: 400,
			    	centered: true,
			        closeClick:false,
			        closeEsc:false,
			        overlayCSS: {background: 'black', opacity: .7}
			    });
		  });

		  jQuery(".taskremove").click(function(){
			  message = jQuery(this).closest('tr').find('td:eq(1)').html()+' adlı zamanlanmış göreviniz silinecektir.Emin misiniz ?';
		      if(confirm(message)){
		    	  jQuery.ajax({
			 			type: "POST",
			 			dataType:"json",
			 			url: "index.php?option=com_scheduled_tasks&task=deleteScheduledTaskById&format=raw",
			 			data: "taskid="+jQuery(this).closest('tr').attr('taskid'),
			 			beforeSend:function(){
			 				 jQuery.blockUI();
				 		},
			 			success: function(data){ 
			 				alert(data['MESSAGE']);
			 				
			 				if(data['STATUS'] == true){
			 					window.location.reload();	
				 			}
			 			},
			 			complete : function (){
			 				jQuery.unblockUI();
			             }
			 		});
			      
			  }
		  });
	});

function changeStatus(taskid,status){
	  jQuery.ajax({
			type: "POST",
			dataType:"json",
			url: "index.php?option=com_scheduled_tasks&task=changeTaskStatus&format=raw",
			data: "taskid="+taskid+"&status="+status,
			beforeSend:function(){
				 jQuery.blockUI();
	 		},
			success: function(data){ 
				alert(data['MESSAGE']);
				
				if(data['STATUS'] == true){
					window.location.reload();	
	 			}
			},
			complete : function (){
				jQuery.unblockUI();
           }
		});
}
</script>
