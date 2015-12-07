<?php 
if(isset($_GET['tur'])){
	$_SESSION['basvuru_tur'] =$_GET['tur'];
}

$basvuru = $this->basvuru;
$kurulus = $this->kurulus;
$faaliyet = $this->faaliyet;
?>
<style>
#basvuru_ek_dokuman_conatiner table tr td{
	text-align:center;
}
/* webkit solution */
::-webkit-input-placeholder { text-align:center; }
/* mozilla solution */
input:-moz-placeholder { text-align:center; }
</style>
<form
	onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
	action="index.php?option=com_meslek_std_basvur&amp;layout=basvuru_yeni&amp;task=standartKaydetYeni"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t3"
	name="ChronoContact_meslek_std_basvuru_t3">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />
<input type='hidden' id="updated" value='0' name='updated'/>

<?php 
echo '<h2><u>'.$this->kurulus['KURULUS_ADI'].' Ulusal Meslek Standartı Hazırlama Başvuru Formu</u></h2>';
//echo $this->pageTree;
?>
<br/>
<?php
if($basvuru['BASVURU_DURUM_ID'] == "" || $basvuru['BASVURU_DURUM_ID'] == "-1" || $basvuru['BASVURU_DURUM_ID'] == "-2" || $basvuru['BASVURU_DURUM_ID'] == "2" || $this->ssyetkili == "1" ){?>
	<input style="padding:5px; margin: 10px 0 25px 29px;" value="Kaydet" name="kaydet" type="submit" />
<?php } 
	if($this->evrak_id <> "" && ($basvuru['BASVURU_DURUM_ID'] == "-1" || $basvuru['BASVURU_DURUM_ID'] == "2")){?>
		<input style="padding:5px; margin: 10px 0 25px 10px;" type="button" name="gonder" value="Tüm Basvuruyu Görüntüle / Bitir" onclick="basvuruGonder(-1)">
<?php } ?>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Başvuru Tarihi</label>
    <input class="cf_inputbox" size="30"  id="basvuru_tarihi" name="basvuru_tarihi" type="text" value="<?php echo substr($basvuru['BASVURU_TARIHI'],0,10);?>"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Başvuru Durumu</label>
    <select name='basvuru_durumu' <?php if($this->ssyetkili !="1") { echo "disabled='disabled'"; } ?>>
    	<option value="">Seçiniz</option>
    <?php 
    	foreach ($this->basvuru_durumlari as $basvuru_durum){
    		echo "<option value='".$basvuru_durum['BASVURU_DURUM_ID']."'".($basvuru_durum['BASVURU_DURUM_ID'] == $basvuru['BASVURU_DURUM_ID'] ? "selected" : "").">".$basvuru_durum['BASVURU_DURUM_ADI']."</option>";
    	}
    ?>
    </select>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Başvurulan Sektörler</label>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item" style="margin-bottom:10px;">
  <div class="form_element cf_placeholder">
	<div id="sektor_div"></div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Açıklama</label>
    <textarea class="cf_inputbox" rows="5" id="basvuru_aciklama" title="" cols="100" name="basvuru_aciklama"><?php echo $this->basvuru["BELIRTILECEK_DIGER_HUSUSLAR"]; ?></textarea> 	      
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Başvuru Dökümanı</label>
    <?php 
    	if($this->basvuru["BASVURU_EK_DOSYASI_PATH"] <> ""){
    		echo getBasvuruBelgesiTDData($basvuru["BASVURU_EK_DOSYASI_PATH"], $basvuru["EVRAK_ID"], $kurulus);
    	}else{
    		echo '<input type="file" name="basvuru_dokumani" class="required" />';
    	}
    ?>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Başvuru Döküman Tarihi</label>
    <input class="cf_inputbox" size="10" id="basvuru_dokuman_tarihi" name="basvuru_dokuman_tarihi" type="text" readonly="readonly" value="<?php echo ($this->basvuru["BASVURU_EK_DOSYASI_TARIHI"] <> "" ? $this->basvuru["BASVURU_EK_DOSYASI_TARIHI"] : date("d.m.Y")); ?>"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_textbox">
    <label class="cf_label" style="width: 150px;">Ek Dökümanlar</label>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div id="basvuru_ek_dokuman_conatiner" class="form_item">
  	<table width="90%" style="margin:0 auto;">
  		<thead style="background-color:#71CEED">
  		<tr id="ek_dokuman_header">
  		  	<th>Açıklama</th>
  			<th>Döküman Adı</th>
  			<th>Tarih</th>
  			<th>İşlem</th>
  		</tr>
  		</thead>
  		<tbody>
  		<?php 
  			foreach ($this->ekler as $ek_dosya){ ?>
  				<tr>
  				  	<td><input type="hidden" name="ek_id" value="<?php  echo $ek_dosya['BASVURU_EK_ID']; ?>"/> <?php echo $ek_dosya['BASVURU_EK_ACIKLAMA'];?></td>
  					<td><?php echo $ek_dosya['BASVURU_EK_ADI'];?></td>
  					<td><?php echo substr($ek_dosya['BASVURU_EK_TARIH'],0,10);?></td>
  					<td>
  						<a style="color:green; text-decoration:underline;" href="index.php?dl=basvuruDosyalari/<?php echo $kurulus['USER_ID'].'/'.$this->evrak_id.'/ek_dosya/'.$ek_dosya['BASVURU_EK_PATH']; ?>">İndir</a>
  						<input style="background-color:red;color:#ffffff;margin-left:5px;" type="button" class="DeleteDoc" value="Sil">
	  				</td>	
  				</tr>
  		<?php }
  		?>
  		</tbody>
  		<tfoot>
	  		<tr id="new_document_add_container" style="display:none;">
	  			<td colspan="4" style="padding-top:15px;">
	  				<center>
	  					<input class="cf_inputbox" size="15" id="basvuru_ek_dokuman_tarihi" name="basvuru_ek_dokuman_tarihi" placeholder="Ek Döküman Tarihi" type="text" value=""/><br>
		  				<input type="file" name="basvuru_ek_dokuman" style="margin:5px;"/><br>
		  				<input type="text" name="basvuru_ek_dokuman_aciklama" size="50" placeholder="Ek Döküman Açıklama" /><br>
		  				<input style="background-color:green;color:#ffffff" type="button" id="SaveDoc" value="Ekle">
		  				<input style="background-color:red;color:#ffffff;margin-left:5px;" type="button" id="CancelDoc" value="İptal">
	  				</center>
	  			</td>
	  		</tr>
  		</tfoot>
  	</table>
</div>
<?php
if($basvuru['BASVURU_DURUM_ID'] == "" || $basvuru['BASVURU_DURUM_ID'] == "-1" || $basvuru['BASVURU_DURUM_ID'] == "2" || $this->ssyetkili == "1" ){?>
<div class="form_element cf_button">
	<input type="button" value="Yeni Döküman + " id="NewDocs" style="margin-right:10px;" />
</div>
	<div class="cfclear">&nbsp;</div>
<?php }

	if($basvuru['BASVURU_DURUM_ID'] == "" || $basvuru['BASVURU_DURUM_ID'] == "-1" || $basvuru['BASVURU_DURUM_ID'] == "-2" || $basvuru['BASVURU_DURUM_ID'] == "2" || $this->ssyetkili == "1" ){?>
	<input style="padding:5px; margin: 10px 0 25px 29px;" value="Kaydet" name="kaydet" type="submit" />
	<?php }
?>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
</form>
<script>
	jQuery("input[type=button]").not("[value='Başvuru Bilgileri'],[value='Ekler']").hide();
	jQuery(document).ready(function(){
	
			jQuery('form').submit(function(){
				jQuery('select[name=basvuru_durumu]').removeAttr('disabled');
			});
			
			jQuery("input[name=kaydet]").click(function(){ 
				if(jQuery("#BasvuruDocument").length>0){
					jQuery("#dosya").removeClass("required");
				}
			});
		   jQuery("input[name=gonder]").click(function(){
			   if(confirm("Başvuruyu tamamlamak istediğinizden emin misiniz ? ")){
				   jQuery.ajax({
			            type:"POST",
			            url:"index.php?option=com_yeterlilik_basvur&task=basvuruBitirYeni&format=raw",
			            data:"evrak_id="+jQuery("input[name=evrak_id]").val(),
			            dataType: "json",
			            beforeSend: function() {
			            	jQuery('#loaderGif').lightbox_me({
			        			centered: true,
			        	        closeClick:false,
			        	        closeEsc:false  
			                });
			            },
			            success:function(data){
				            if(data.status != ""){
								alert(data.result);
				            	window.location.reload();
					        }else{
								alert("Başvuru tamamlanırken hata oluştu.");
						    }

			            }
					});
			   }
		   });
		   jQuery('#basvuru_tarihi').live('hover',function(e){
		        e.preventDefault();
		        jQuery(this).datepicker({
		            changeYear: true,
		            changeMonth: true
		        });
		    });
		   jQuery('#basvuru_ek_dokuman_tarihi').live('hover',function(e){
		        e.preventDefault();
		        jQuery(this).datepicker({
		            changeYear: true,
		            changeMonth: true
		        });
		    });
		    jQuery("#NewDocs").show();
		    jQuery("#SaveDoc").show();
		    jQuery("#CancelDoc").show();
		    jQuery(".DeleteDoc").show();
		    jQuery('input[name=gonder]').show();

		    <?php if($basvuru['BASVURU_DURUM_ID'] != "-1" && $basvuru['BASVURU_DURUM_ID'] != "-2" && $this->ssyetkili !="1"){?>
			
				jQuery(".DeleteDoc").hide();
				jQuery("#raporSilCheckbox").hide();
				jQuery("#raporSilCheckboxText").hide();
				jQuery("#formGosterButton").hide();
				
				
			<?php } ?>
		    jQuery("#NewDocs").click(function(){
				jQuery("#new_document_add_container").toggle("slow");
				jQuery(this).val() == "Yeni Döküman + " ? jQuery(this).val('Yeni Döküman - ') : jQuery(this).val('Yeni Döküman + ');
			});

			if(jQuery("#basvuru_ek_dokuman_conatiner table tbody tr").length == 0){
				jQuery("#basvuru_ek_dokuman_conatiner table tbody").append("<tr id='empty_ek_dokuman' bgcolor='#efefef'><td colspan='4' style='text-align:center;'>Ek Döküman Bulunmamaktadır!</td></tr>");
			}

		    jQuery("#SaveDoc").click(function(){
			    if(jQuery("input[type=file][name=basvuru_ek_dokuman]").val() != ""){
			    var appendTr = "<tr>"+
			   					    "<td><input type='hidden' name='ek_dokuman_aciklama[]' value='"+jQuery("input[type=text][name=basvuru_ek_dokuman_aciklama]").val()+"' class='ek_dokuman_aciklama'/>"+jQuery("input[type=text][name=basvuru_ek_dokuman_aciklama]").val()+"</td>"+
			    					"<td>"+jQuery('input[type=file][name=basvuru_ek_dokuman]').val().toString().split('\\')[jQuery('input[type=file][name=basvuru_ek_dokuman]').val().toString().split('\\').length-1]+"</td>"+
			    					"<td><input type='hidden' name='ek_dokuman_tarih[]' value='"+jQuery("input[type=text][name=basvuru_ek_dokuman_tarihi]").val()+"' class='ek_dokuman_tarih'/>"+jQuery("input[type=text][name=basvuru_ek_dokuman_tarihi]").val()+"</td>"+
			    					"<td><input type='button' class='removeDoc' value='Sil' /></td>"+
			    			   "</tr>"; 
			    if(jQuery("#basvuru_ek_dokuman_conatiner table tbody").find("#empty_ek_dokuman").length > 0){
			    	jQuery("#basvuru_ek_dokuman_conatiner table tbody").find("#empty_ek_dokuman").remove();
				}
			    jQuery("#basvuru_ek_dokuman_conatiner table tbody").append(appendTr);	
			    if(jQuery("#basvuru_ek_dokuman_conatiner table tbody tr").length%2 == 0){
			    	jQuery("#basvuru_ek_dokuman_conatiner table tbody tr:last").attr("bgcolor","#efefef");
				}else{
					jQuery("#basvuru_ek_dokuman_conatiner table tbody tr:last").attr("bgcolor","#ffffff"); 
				}
			    jQuery("#basvuru_ek_dokuman_conatiner table tbody tr:last td:eq(0)").append(jQuery("input[type=file][name=basvuru_ek_dokuman]"));   
			    jQuery("#basvuru_ek_dokuman_conatiner table tbody tr:last td:eq(0)").find("input[type=file]").attr('name','ek_dokuman[]');
			    jQuery("#basvuru_ek_dokuman_conatiner table tbody tr:last td:eq(0)").find("input[type=file]").hide();
			    jQuery("#basvuru_ek_dokuman_conatiner table tfoot tr input[name=basvuru_ek_dokuman_aciklama]").prev('br').remove().end().before("<input type='file' name='basvuru_ek_dokuman' style='margin:5px;'/><br>");
			    jQuery("input[type=text][name=basvuru_ek_dokuman_aciklama]").val("");
			    jQuery("input[type=text][name=basvuru_ek_dokuman_tarihi]").val("");
			    }else{
					alert("Lütfen eklemek istediğiniz dökümanı seçiniz !");
				}
			});
			jQuery(".removeDoc").live('click',function(){
				jQuery(this).closest('tr').remove();	
				if(jQuery("#basvuru_ek_dokuman_conatiner table tbody tr").length == 0){
					jQuery("#basvuru_ek_dokuman_conatiner table tbody").append("<tr id='empty_ek_dokuman' bgcolor='#efefef'><td colspan='4' style='text-align:center;'>Ek Döküman Bulunmamaktadır!</td></tr>");
				}
			});
			jQuery("#CancelDoc").click(function(){
				jQuery("#new_document_add_container").toggle("slow");
			});
			jQuery(".DeleteDoc").click(function(){
					ekId = jQuery(this).closest("tr").find("input[name=ek_id]").val();
					jQuery.ajax({
				            type:"POST",
				            url:"index.php?option=com_yeterlilik_basvur&task=BasvuruEkSil&format=raw",
				            data:"ekId="+ekId,
				            dataType: "json",
				            beforeSend: function() {
				            	jQuery('#loaderGif').lightbox_me({
				        			centered: true,
				        	        closeClick:false,
				        	        closeEsc:false  
				                });
				            },
				            success:function(data){
					            if(data.status != ""){
									alert(data.result);
	 				            	window.location.reload();
						        }else{
									alert("Başvuru eki silme esnasında hata oluştu.");
							    }

				            }
						});
			});
	});

	//SEKTORLER
	<?php
	$data = $this->pm_sektor;

	$r = 'dTables.sektor = new Array( new Array("combo", new Array(';
	$s = 'new Array ("Seçiniz", "Seçiniz"),';

	if(isset($data)){
	  foreach ($data as $row){
	      $id = $row[0];
	      $value = $row[1];
	      $s .= 'new Array ("'.$id.'","'.$value.'"),';
	  }
	}

	$s = substr ($s, 0, strlen($s)-1);
	$r = $r.$s.'),"comboReq"), new Array ("text", "", "65"));';
	echo $r;
	?>
	//SEKTORLER SONU
	
	function createTables(){
	var tableName = "sektor";
	createTable( tableName, new Array ('Faaliyet Gösterdiği Sektör(ler)', 'Açıklama'));
	addSektorValues (dTables.sektor, tableName);

//	tableName = "faaliyet";
//	createTable(tableName, new Array ('Faaliyet Alanları'));
//	addFaaliyetValues (dTables.faaliyet, tableName);

	tableName = "yetkiTalep";
	createTable(tableName , new Array('Yeterliliğin Adı',
                                	  
 									  'Başvuru tarihine kadar<br />verilmiş belge sayısı',
									  'Başvuru tarihine kadar<br />gerçekleştirilmiş sınav sayısı'));

	addYetkiTalepValues (dTables.yetkiTalep, tableName);
}

function addSektorValues (sektor, name){
	var length = sektor.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = sektor[i][0];
	}
	
	<?php
	$data = $this->sektor;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arrId['.$id++.']= "'. $arr["SEKTOR_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ID"] .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["SEKTOR_ACIKLAMA"]) .'";';
	}
	?>

	if (isset (arr))
 		addTableValues (arr,arrId, params, name);
}

jQuery('#formGosterButton').live('click',function(e){
	e.preventDefault();
	
	jQuery('#toggleableDiv').toggle('slow');
	
	if(jQuery('#degistirFieldSelected').val()=='1')
		jQuery('#degistirFieldSelected').val("0");
	else
		jQuery('#degistirFieldSelected').val("1");
});
	
</script>
<?php 
function getBasvuruBelgesiTDData($raporPath, $evrak_id, $kurulus)
{
	
	$resultToReturn = '';

	$uploaderContent = '<input type="file" name="basvuru_dokumani[]" class="required" id="basvuru_dokumani" style="width: 210px;"  />';

	if(strlen($raporPath) > 0)
	{
		$resultToReturn .= '<div id="BasvuruDocument" style="width:100%; float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green;">
			<div style="float:left;">
				Başvuru Belgesi Eklenmiş.
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="index.php?dl=basvuruDosyalari/'.$kurulus['USER_ID'].'/'.$evrak_id.'/'.$raporPath.'">İndir</a>
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="#" id="formGosterButton">Değiştir</a>
				<input type="hidden" id="degistirFieldSelected" name="degistirFieldSelected" value="0">
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
			</div>
			<div style="float:left;">
				<input type="checkbox" id="raporSilCheckbox" name="raporSilCheckbox" value="1">
				&nbsp;&nbsp;
				<a onclick="if(jQuery(\'#raporSilCheckbox\').attr(\'checked\')==\'checked\') jQuery(\'#raporSilCheckbox\').removeAttr(\'checked\'); else jQuery(\'#raporSilCheckbox\').attr(\'checked\', \'checked\')" style="color:green; text-decoration:underline;" id="raporSilCheckboxText" href="#">Sil</a>
				&nbsp;&nbsp;&nbsp;
			</div>
		</div>';

		$resultToReturn .= '<div id="toggleableDiv" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';

		//$resultToReturn .= '<div style="padding-top:10px; width:100%; float:left;"><input type="button" onclick="window.location=\'index.php?option=com_denetim&layout=denetim_listele\';" value="GERİ" ></div>';


	}
	else
	{
		$resultToReturn .= $uploaderContent;
	}


	return $resultToReturn;
}

?>
