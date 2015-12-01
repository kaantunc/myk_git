<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=beceri&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">SAHİP OLUNMASI GEREKEN ÖĞRENME ÇIKTILARI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Beceriler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="beceri_div">
		<table id="tablo_beceri" style="width: 100%;text-align:center;">
			<thead class="tablo_header">
				<tr>
					<th width="5%">Sıra No</th>
					<th width="70%">Beceri</th>
					<th width="5%">Sil?</th>
					<th width="10%">Güncelle</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$sayy = 1;
			foreach($this->beceri as $row){
				if($sayy%2 == 0){
					echo '<tr class="tablo_row" id="beceri_'.$row['BECERI_YETKINLIK_ID'].'">';
				}else{
					echo '<tr class="tablo_row2" id="beceri_'.$row['BECERI_YETKINLIK_ID'].'">';
				}
				
				echo '<td>'.$sayy.'</td>';
				echo '<td><input type="text" value="'.$row['BECERI_YETKINLIK_ADI'].'" id="bilgiAdi" size="110"/></td>';
				echo '<td><input id="sil" type="button" value="Sil"></td>';
				echo '<td><input id="guncelle" type="button" value="Güncelle"></td></tr>';
				$sayy++;
			}
		?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
    <div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<button id="beceriTopluekle">Toplu Beceri Ekle</button>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
if ($this->canEdit){
?>
<!--	<div class="form_item" style="padding-top: 25px;">-->
<!-- 		<div class="form_element cf_button"> -->
<!-- 			<input value="Kaydet" name="kaydet" type="submit" /> -->
<!-- 		</div> -->
<!-- 		<div class="cfclear">&nbsp;</div> -->
<!-- 	</div> -->
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('beceri', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<div id="TopluBeceri" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form id="BilgiFrom" method="post" enctype="multipart/form-data" action="index.php?option=com_yeterlilik_taslak&layout=beceri&<?php echo $task;?>&yeterlilik_id=<?php echo $this->yeterlilik_id;?>">
	<h2>Toplu Beceri Ekle</h2>
		<textarea rows="14" cols="52" id="tplBeceri" name="bilgi"></textarea>
		<button id="beceriEkle">Ekle</button>
		<button id="beceriIptal">İptal</button>
	</form>
</div>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";
		
// dTables.beceri = new Array(new Array("text","","4", "", readOnly),	
// 						   new Array("text","required", "100", "", readOnly));

// function createTables(){
// 	var tableName = 'beceri'; 
// 	var headers	  = new Array ('Sıra No', 'Beceri');
// 	createTable(tableName, headers);
// 	patchSatirEkle(tableName, headers, tableName);
// 	addBeceriValues (dTables.beceri, tableName);

// 	if (isReadOnly){
// 		satirEkleKaldir (tableName);
// 		satirSilKaldir (tableName, 2);
// 	}
// }

// function addBeceriValues (beceri, name){
// 	var length = beceri.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
// 	var arrId  = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = beceri[i][0];
// 	}
	<?php
// 	$tableCount = count ($this->beceri);

// 	$c = 0;
// 	$id = 0;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $this->beceri[$i];
// 		echo 'arrId['.$id++.']= "'.$arr["BECERI_YETKINLIK_ID"].'";';
		
// 		echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BECERI_YETKINLIK_ADI"] ).'";';
// 	}
	
// 	?>
	
// 	if (isset (arr))
// 		addTableValues (arr, params, name, arrId);
//}

jQuery(document).ready(function(){
	jQuery('#beceriTopluekle').live('click',function(e){
		e.preventDefault();
		jQuery('#TopluBeceri').lightbox_me({
			centered: true,
            closeClick:false,
            closeEsc:false 
                });
	});

	jQuery('#beceriEkle').live('click',function(e){
		e.preventDefault();
		var topluBeceri = jQuery('#tplBeceri').val();

		var yetId = <?php echo $this->yeterlilik_id;?>;

		if(topluBeceri == '' || topluBeceri.length == 0){
			alert('Lütfen Beceri bilgilerini giriniz.');
		}else{
			jQuery('#TopluBeceri').trigger('close');
			jQuery('#loaderGif').lightbox_me({
	            centered: true,
	            closeClick:false,
	            closeEsc:false
	        });
			jQuery('#BilgiFrom').submit();
// 			jQuery.ajax({
// 				type:'POST',
// 				url:"index.php?option=com_yeterlilik_taslak&task=ajaxAddBilgi&format=raw",
// 				data:'yetId='+yetId+'&bilgi='+topluBeceri+'&tip=1',
// 				success:function(data){
// 					window.location.reload();
// 				}
// 			});
		}
// 		text=toplubeceri.replace("\r\n","\n");
// 	    var ek1Array=text.split("\n");
// 	    for(var i=0; i<ek1Array.length; i++){
// 	    	rowEkleYeni(ek1Array[i]);
// 	    }
// 	    jQuery('#TopluBeceri').trigger('close');
	});

	jQuery('#beceriIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#tplBeceri').html('');
		jQuery('#TopluBeceri').trigger('close');
	});

	jQuery('#sil').live('click',function(e){
		e.preventDefault();
		var id = jQuery(this).closest('tr').attr('id');
		id = id.split('_');

		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_yeterlilik_taslak&task=getAjaxBagliBilgi&format=raw",
			data:'id='+id[1],
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat.length>0){
					alert('Bu Beceriyi silmek için önce eklerden silmeniz gerekmektedir.');
				}
				else{
					if(confirm('Bu Beceriyi silmek istediğinizden emin misiniz?')){
						jQuery('#loaderGif').lightbox_me({
				            centered: true,
				            closeClick:false,
				            closeEsc:false
				        });
						jQuery.ajax({
							type:'POST',
							url:"index.php?option=com_yeterlilik_taslak&task=ajaxDelBilgi&format=raw",
							data:'id='+id[1],
							success:function(data){
								window.location.reload();
								}
						});
					}
				}
			}
		});
	});

	jQuery('#guncelle').live('click',function(e){
		e.preventDefault();
		var id = jQuery(this).closest('tr').attr('id');
		id = id.split('_');

		var bilgiAdi = jQuery(this).closest('tr').children('td').children('#bilgiAdi').val();
		jQuery('#loaderGif').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
		jQuery.ajax({
			type:'POST',
			url:"index.php?option=com_yeterlilik_taslak&task=ajaxGuncelleBilgi&format=raw",
			data:'id='+id[1]+'&bilgi='+bilgiAdi,
			success:function(data){
				window.location.reload();
				}
		});
			
	});
});

function rowEkleYeni(deger){
	var sira = jQuery('#tablo_beceri').children('tbody').children('tr').length+1;
	if(sira%2==0){
		var klas = 'tablo_row2';
	}
	else{
		var klas = 'tablo_row';
	}
	var ekle = '<tr id="tablo_beceri_'+sira+'" class="'+klas+'">'+
			'<td><input type="text" id="inputbeceri-1-'+sira+'" name="inputbeceri-1[]" size="4" value="'+sira+'" readonly=""></td>'+
			'<td><input type="text" id="inputbeceri-2-'+sira+'" name="inputbeceri-2[]" size="100" class="required" value="'+deger+'"></td>'+
			'<td width="10%" class="tablo_sil_hucre"><input type="button" id="satirSil_beceri-'+sira+'" value="Sil"></td>'+
			'</tr>';
	jQuery('#tablo_beceri').children('tbody').append(ekle);
}
</script>