<?php 
$data = array_merge($this->zorunluBirim, $this->secmeliBirim);
$bilgiYetkinlik = array ($this->bilgi, $this->beceri, $this->yetkinlik);

$birimler = '<option value="0">Seçiniz</option>';
foreach ($data as $row){
	$birimler .= '<option value="'.$row['YETERLILIK_ALT_BIRIM_ID'].'">'.$row['YETERLILIK_ALT_BIRIM_ADI'].'</option>';
}
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=ek_birim&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">EKLER</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 2 : Yeterliliği Oluşturan Yeterlilik Birimlerine İlişkin Tablo</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Bilgiler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="bilgi_div">
		<table id="tablo_bilgi" style="width: 100%;">
			<thead class="tablo_header">
			<tr>
				<th>#</th>
				<th>Alt Birim</th>
				<th>Bilgi</th>
				<th>Sil</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$sqy = 1; 
			foreach($this->birim_bilgi as $row){
				if($sqy%2==0){
					echo '<tr class="tablo_row2" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}else{
					echo '<tr class="tablo_row" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}
				echo '<td>'.$sqy.'</td>';
				echo '<td>'.$row['YETERLILIK_ALT_BIRIM_ADI'].'</td>';
				echo '<td>'.$row['BECERI_YETKINLIK_ADI'].'</td>';
				echo '<td><input type="button" id="sil" value="Sil"/></td>';
				echo '</tr>';
				$sqy++;
			}?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<input type="button" value="Yeni Bilgiler Ekle" id="bilgiEkle"/>
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
		<table id="tablo_beceri" style="width: 100%;">
			<thead class="tablo_header">
			<tr>
				<th>#</th>
				<th>Alt Birim</th>
				<th>Bilgi</th>
				<th>Sil</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$sqy = 1; 
			foreach($this->birim_beceri as $row){
				if($sqy%2==0){
					echo '<tr class="tablo_row2" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}else{
					echo '<tr class="tablo_row" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}
				echo '<td>'.$sqy.'</td>';
				echo '<td>'.$row['YETERLILIK_ALT_BIRIM_ADI'].'</td>';
				echo '<td>'.$row['BECERI_YETKINLIK_ADI'].'</td>';
				echo '<td><input type="button" id="sil" value="Sil"/></td>';
				echo '</tr>';
				$sqy++;
			}?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<input type="button" value="Yeni Beceriler Ekle" id="beceriEkle"/>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Yetkinlikler</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="yetkinlik_div">
		<table id="tablo_yetkinlik" style="width: 100%;">
			<thead class="tablo_header">
			<tr>
				<th>#</th>
				<th>Alt Birim</th>
				<th>Bilgi</th>
				<th>Sil</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$sqy = 1; 
			foreach($this->birim_yetkinlik as $row){
				if($sqy%2==0){
					echo '<tr class="tablo_row2" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}else{
					echo '<tr class="tablo_row" id="bilgi_'.$row['YETERLILIK_ALT_BIRIM_ID'].'_'.$row['BECERI_YETKINLIK_ID'].'">';
				}
				echo '<td>'.$sqy.'</td>';
				echo '<td>'.$row['YETERLILIK_ALT_BIRIM_ADI'].'</td>';
				echo '<td>'.$row['BECERI_YETKINLIK_ADI'].'</td>';
				echo '<td><input type="button" id="sil" value="Sil"/></td>';
				echo '</tr>';
				$sqy++;
			}?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<input type="button" value="Yeni Yetkinlikler Ekle" id="yetkinlikEkle"/>
</div>
<br/>
***Uyarı: Bu sayfaya veri girmeden önce Zorunlu ve Seçmeli Birimlerin girişi tamamlanmış olmalıdır. Bu sayfaya veri girdikten sonra Zorunlu ve Seçmeli Birimler üzerinde değişiklik yapamazsınız.
<?php 
if ($this->canEdit){
?>
	<!-- <div class="form_item" style="padding-top: 25px;"> -->
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_birim', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<div id="bilgiler" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="bilgiForm" action="index.php?option=com_yeterlilik_taslak&layout=ek_birim&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" method="post">
    <strong>Alt Birim</strong><br>
    <select id="bilgibirim" name="birim">
    	<?php 
    		echo $birimler;
    	?>
    </select><br><br>
    <strong>Bilgi</strong><br>
    <div style="max-height:200px;overflow:auto;"><br>
    	<?php 
    	foreach ($this->bilgi as $row) {
    		echo '<input type="checkbox" name="bilgi[]" id="bilgi" value="'.$row['BECERI_YETKINLIK_ID'].'"> '.$row['BECERI_YETKINLIK_ADI'].'<br>';
    	}
    	?>
    </div><br>
    <input type="hidden" name="tip" value="0"/>
    <input type="button" value="Kaydet" id="BilgiKaydet"/>
    <input type="button" value="İptal" id="bilgiIptal"/>
    </form>
</div>

<div id="beceriler" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="beceriForm" action="index.php?option=com_yeterlilik_taslak&layout=ek_birim&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" method="post">
    <strong>Alt Birim</strong><br>
    <select id="beceribirim" name="birim">
    	<?php 
    		echo $birimler;
    	?>
    </select><br><br>
    <strong>Beceri</strong><br>
    <div style="max-height:200px;overflow:auto;"><br>
    	<?php 
    	foreach ($this->beceri as $row) {
    		echo '<input type="checkbox" name="bilgi[]" id="beceri" value="'.$row['BECERI_YETKINLIK_ID'].'"> '.$row['BECERI_YETKINLIK_ADI'].'<br>';
    	}
    	?>
    </div><br>
    <input type="hidden" name="tip" value="1"/>
    <input type="button" value="Kaydet" id="BeceriKaydet"/>
    <input type="button" value="İptal" id="beceriIptal"/>
    </form>
</div>

<div id="yetkinlikler" style="max-width:613px; min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="yetkinlikForm" action="index.php?option=com_yeterlilik_taslak&layout=ek_birim&task=taslakKaydet&yeterlilik_id=<?php echo $this->yeterlilik_id;?>" method="post">
    <strong>Alt Birim</strong><br>
    <select id="yetkinlikbirim" name="birim">
    	<?php 
    		echo $birimler;
    	?>
    </select><br><br>
    <strong>yetkinlik</strong><br>
    <div style="max-height:200px;overflow:auto;"><br>
    	<?php 
    	foreach ($this->yetkinlik as $row) {
    		echo '<input type="checkbox" name="bilgi[]" id="yetkinlik" value="'.$row['BECERI_YETKINLIK_ID'].'"> '.$row['BECERI_YETKINLIK_ADI'].'<br>';
    	}
    	?>
    </div><br>
    <input type="hidden" name="tip" value="2"/>
    <input type="button" value="Kaydet" id="YetkinlikKaydet"/>
    <input type="button" value="İptal" id="yetkinlikIptal"/>
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

jQuery(document).ready(function(){

	jQuery('#bilgiEkle').live('click',function(e){
		e.preventDefault();
		jQuery.each(jQuery('#bilgi:checked'),function(key,vall){
        	vall.checked=false;
		});
		jQuery('#bilgibirim').val(0);
		jQuery('#bilgiler').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
	});

	jQuery('#bilgiIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#bilgiler').trigger('close');
	});

	jQuery('#BilgiKaydet').live('click',function(e){
		e.preventDefault();
		if(jQuery('#bilgi:checked').length == 0 ){
			alert('Lütfen en az bir bilgi seçiniz.');
		}else if(jQuery('#bilgibirim').val()==0){
			alert('Lütfen birim seçiniz.');
		}else{
			jQuery('#bilgiForm').submit();
		}
	});

	jQuery('#beceriEkle').live('click',function(e){
		e.preventDefault();
		jQuery.each(jQuery('#beceri:checked'),function(key,vall){
        	vall.checked=false;
		});
		jQuery('#beceribirim').val(0);
		jQuery('#beceriler').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
	});

	jQuery('#beceriIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#beceriler').trigger('close');
	});

	jQuery('#BeceriKaydet').live('click',function(e){
		e.preventDefault();
		if(jQuery('#beceri:checked').length == 0 ){
			alert('Lütfen en az bir beceri seçiniz.');
		}else if(jQuery('#beceribirim').val()==0){
			alert('Lütfen birim seçiniz.');
		}else{
			jQuery('#beceriForm').submit();
		}
	});

	jQuery('#yetkinlikEkle').live('click',function(e){
		e.preventDefault();
		jQuery.each(jQuery('#yetkinlik:checked'),function(key,vall){
        	vall.checked=false;
		});
		jQuery('#yetkinlikbirim').val(0);
		jQuery('#yetkinlikler').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
	});

	jQuery('#yetkinlikIptal').live('click',function(e){
		e.preventDefault();
		jQuery('#yetkinlikler').trigger('close');
	});

	jQuery('#YetkinlikKaydet').live('click',function(e){
		e.preventDefault();
		if(jQuery('#yetkinlik:checked').length == 0 ){
			alert('Lütfen en az bir yetkinlik seçiniz.');
		}else if(jQuery('#yetkinlikbirim').val()==0){
			alert('Lütfen birim seçiniz.');
		}else{
			jQuery('#yetkinlikForm').submit();
		}
	});
	
	jQuery('#sil').live('click',function(e){
		e.preventDefault();
		var id = jQuery(this).closest('tr').attr('id');
		id = id.split('_');
		var birim_id = id[1];
		var bilgi_id = id[2];
		if(confirm('Silmek istediğinizden emin misiniz?')){
			jQuery('#loaderGif').lightbox_me({
	            centered: true,
	            closeClick:false,
	            closeEsc:false
	        });
			jQuery.ajax({
				type:"POST",
				url:"index.php?option=com_yeterlilik_taslak&layout=ek_birim&task=ajaxEkBirimSil&format=raw",
				data:"birimId="+birim_id+'&bilgiId='+bilgi_id,
				success:function(data){
					window.location.reload();
				}
			});
		}
	});
});






//BILGI YETKINLIK
<?php
// $data = array_merge($this->zorunluBirim, $this->secmeliBirim);
// $bilgiYetkinlik = array ($this->bilgi, $this->beceri, $this->yetkinlik);
// $names = array ("bilgi", "beceri", "yetkinlik");

// for ($i = 0; $i < 3; $i++){
// 	$r = $names[$i].' = new Array(new Array("text","","4", "", readOnly),new Array("combo", new Array(';
// 	$s = 'new Array ("Seçiniz", "Seçiniz"),';
	
// 	if(isset($data)){
// 	  foreach ($data as $row){
// 	      $id 	 = $row["YETERLILIK_ALT_BIRIM_ID"];
// 	      $value = FormFactory::normalizeVariable ($row["YETERLILIK_ALT_BIRIM_ADI"] );
// 	      $s .= 'new Array ("'.$id.'","'.$value.'"),';
// 	  }
// 	}
	
// 	$s = substr ($s, 0, strlen($s)-1);
// 	$r = $r.$s.'),"comboReq", "", "250"), new Array("combo", new Array(';
	
// 	$s = 'new Array ("Seçiniz", "Seçiniz"),';
// 	if(isset($bilgiYetkinlik[$i])){
// 	  foreach ($bilgiYetkinlik[$i] as $row){
// 	      $id 	 = $row["BECERI_YETKINLIK_ID"];
// 	      $value = FormFactory::normalizeVariable ($row["BECERI_YETKINLIK_ADI"] );
// 	      $s .= 'new Array ("'.$id.'","'.$value.'"),';
// 	  }
// 	}
	
// 	$s = substr ($s, 0, strlen($s)-1);
// 	echo $r.$s.'),"comboReq", "", "400"));';
// }
// ?>
// //BILGI YETKINLIK SON

// dTables.bilgi		= bilgi;
// dTables.beceri		= beceri;
// dTables.yetkinlik  	= yetkinlik;

// function createTables(){
// 	var tableName = 'bilgi'; 
// 	var headers	  = new Array ('Sira No', 'Alt Birim', 'Bilgi');
// 	createTable(tableName, headers);
// 	patchSatirEkle(tableName, headers, tableName);
// 	addBilgiValues (dTables.bilgi, tableName);
	
// 	if (isReadOnly){
// 		satirEkleKaldir (tableName);
// 		satirSilKaldir (tableName, 3);
// 	}
	
// 	tableName = 'beceri'; 
// 	headers	  = new Array ('Sira No', 'Alt Birim', 'Beceri');
// 	createTable(tableName, headers);
// 	patchSatirEkle(tableName, headers, tableName);
// 	addBeceriValues (dTables.beceri, tableName);

// 	if (isReadOnly){
// 		satirEkleKaldir (tableName);
// 		satirSilKaldir (tableName, 3);
// 	}
	
// 	tableName = 'yetkinlik'; 
// 	headers	  = new Array ('Sira No', 'Alt Birim', 'Yetkinlik');
// 	createTable(tableName, headers);
// 	patchSatirEkle(tableName, headers, tableName);
// 	addYetkinlikValues (dTables.yetkinlik, tableName);

// 	if (isReadOnly){
// 		satirEkleKaldir (tableName);
// 		satirSilKaldir (tableName, 3);
// 	}
// }

// function addBilgiValues (bilgi, name){
// 	var length = bilgi.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = bilgi[i][0];
// 	}
	<?php
// 	$tableCount = count ($this->birim_bilgi);

// 	$c = 0;
// 	$id = 0;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $this->birim_bilgi[$i];
		
// 		echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 		echo 'arr['.$c++.']= "'. $arr["YETERLILIK_ALT_BIRIM_ID"] .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BECERI_YETKINLIK_ID"] ) .'";';
// 	}
	
// 	?>
	
// 	if (isset (arr))
// 		addTableValues (arr, params, name);
// }

// function addBeceriValues (beceri, name){
// 	var length = beceri.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = beceri[i][0];
// 	}
	<?php
// 	$tableCount = count ($this->birim_beceri);

// 	$c = 0;
// 	$id = 0;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $this->birim_beceri[$i];
		
// 		echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 		echo 'arr['.$c++.']= "'. $arr["YETERLILIK_ALT_BIRIM_ID"] .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BECERI_YETKINLIK_ID"] ) .'";';
// 	}
	
// 	?>
	
// 	if (isset (arr))
// 		addTableValues (arr, params, name);
// }

// function addYetkinlikValues (yetkinlik, name){
// 	var length = yetkinlik.length;
// 	var params = new Array ();
// 	var arr    = new Array ();
	
// 	for (var i = 0; i < length; i++){
// 		params[i] = yetkinlik[i][0];
// 	}
	<?php
// 	$tableCount = count ($this->birim_yetkinlik);

// 	$c = 0;
// 	$id = 0;
// 	for ($i=0; $i< $tableCount; $i++) {
// 		$arr = $this->birim_yetkinlik[$i];
		
// 		echo 'arr['.$c++.']= "'. ($i+1) .'";';
// 		echo 'arr['.$c++.']= "'. $arr["YETERLILIK_ALT_BIRIM_ID"] .'";';
// 		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BECERI_YETKINLIK_ID"] ) .'";';
// 	}
	
// 	?>
	
// 	if (isset (arr))
// 		addTableValues (arr, params, name);
//}
</script>
