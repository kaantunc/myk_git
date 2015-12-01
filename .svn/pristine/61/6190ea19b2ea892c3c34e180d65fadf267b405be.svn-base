<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');

$classBirinci = "leftCol";
$classIkinci = "rightCol";


$protokolID = $this->protokolID;

if(isset($protokolID) && !empty($protokolID))
{
	if(!$this->msProtokoluMu)
	{
		global $mainframe;
		$mainframe->redirect("index.php?option=com_protokol_ms&layout=yeni", JText::_("PROTOKOL_CHECK_ERROR"), 'error');
	}

	$arr[0] = "1";
	$arr[1] = "2";

	$seciliProtokol = $this->seciliProtokol;
	$seciliProtokolKuruluslari = $this->seciliKuruluslar;

	$protokolAdi = $seciliProtokol[0]["ADI"];
	$imzaTarihi = $seciliProtokol[0]["IMZA_TARIHI"];
	$msSayisi = $seciliProtokol[0]["SAYISI"];
	$dosya = $seciliProtokol[0]["DOSYA"];
	$protokolSuresi = $seciliProtokol[0]["SURESI"];
	
	$kurulusVeStandartVisibilitysi = "display: block;";
	$kaydetButtonTexti = JText::_("PROTOKOL_GUNCELLE_BUTTON_TEXT");
}
else
{
	$kurulusVeStandartVisibilitysi = "display: none;";
	$kaydetButtonTexti = JText::_("PROTOKOL_YENI_BUTTON_TEXT");
}

$meslekStandartSeviyeleri = $this->meslekStandartSeviyeleri;
$meslekStandartSektorleri = $this->meslekStandartSektorleri;

//SEVIYELER
$seviyeOptions = "<option value=''></option>";
foreach($meslekStandartSeviyeleri as $seviye){
	$seviyeOptions .= "<option value='".$seviye["SEVIYE_ID"]."'>".$seviye["SEVIYE_ADI"]."</option>";
}

//SEKTORLER
$sektorOptions = "<option value=''></option>";
foreach($meslekStandartSektorleri as $sektor){
	$sektorOptions .= "<option value='".$sektor["SEKTOR_ID"]."'>".$sektor["SEKTOR_ADI"]."</option>";
}

?>
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Meslek Standardı Protokolü</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form method="post" id="yeniprotokolForm"
		action="index.php?option=com_protokol_ms&amp;task=protokolKaydet">
		<input type="hidden" id="protokolID" name="protokolID" value="<?php echo $protokolID;?>" />

		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Adı:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="protokolAdiTextbox" class="required"
					id="protokolAdi" value="<?php echo $protokolAdi; ?>"
					maxlength="400" style="width: 300px;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol İmza Tarihi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required" type="text" maxlength="10" name="imzaTarihiDatePicker" id="imzaTarihiDatePicker"
					value="<?php echo $imzaTarihi; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Meslek Standardı Sayısı:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="msSayisiTextbox" class="required"
					id="msSayisi"  onkeyup="jQuery(this).val(jQuery(this).val().replace(/\D/g,''));"  value="<?php echo $msSayisi; ?>" style="width: 35px;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Sektörleri:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<select name="protokolSektorleriMultipleSelect[]"  id="protokolSektorleriMultipleSelect"  multiple="multiple">
					<?php
					$sektorler = $this->meslekStandartSektorleri;
					$protokolSektorleri = $this->protokolunSektorleri;
					
					
					for($i = 0; $i< count($sektorler); $i++)
					{	
						$selected = "";					
						for($j=0; $j< count($protokolSektorleri); $j++)
						if($sektorler[$i]["SEKTOR_ID"] == $protokolSektorleri[$j]["SEKTOR_ID"])
							$selected = ' selected ';

						$x= "<option value='".$sektorler[$i]["SEKTOR_ID"]."' ".$selected." >" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
						echo $x;
					}					
					?>
				</select>
				<br><font class="kucukMinikAciklamaYazisiClassi">Çoklu seçmek veya silmek için (Ctrl) tuşunu kullanınız</font>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Süresi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="protokolSuresiTextbox" class="required"
					id="protokolSuresiTextbox" onkeyup="jQuery(this).val(jQuery(this).val().replace(/\D/g,''));"  value="<?php echo $protokolSuresi; ?>" style="width: 35px;" />(ay)
			</div>
			<div style="clear: both;"></div>
		</div>
		
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Dosyası:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<div id="protokolDosya_div"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div style="<?php echo $kurulusVeStandartVisibilitysi; ?>" class="kurulus_wrapper">
			<div class="title_wrapper">
				<strong>Protokol Uzatma Süreleri:</strong>
			</div>
			
			<div class="gridview_wrapper">
				<div style="width: 100%; padding-top: 10px;padding-bottom: 10px;">
					<a id="newUzatma" href="">Yeni Uzatma Ekle </a>
				</div>
				
				<div>
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="uzatmalar">
						<thead>
							<tr>
								<th>Uzatma Süresi (Ay Bazında)</th>
								<th>Açıklama</th>
								<th><?php echo JText::_("EDIT_TEXT"); ?></th>
								<th><?php echo JText::_("DELETE_TEXT"); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						$data = $this->uzatmalar;
						
						if ($data != null){
							foreach ($data as $row){
								$elm = "<tr id='".$row['UZATMA_ID']."'>";
						
								$elm .= "<td>".$row['UZATMA_SURESI']."</td>";
								$elm .= "<td>".$row['ACIKLAMA']."</td>";
								$elm .= "<td><a class='editUzatma' href=''>".JText::_("EDIT_TEXT")."</a></td>";
								$elm .= "<td><a class='deleteUzatma' href=''>".JText::_("DELETE_TEXT")."</a></td>";
						
								$elm .= "</tr>";
						
								echo $elm;
							}
						}						
						?>
						</tbody>
					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>

		<div style="<?php echo $kurulusVeStandartVisibilitysi; ?>" class="kurulus_wrapper">
			<div class="title_wrapper">
				<strong> Protokole Dahil Kuruluşlar:</strong>
			</div>

			<div class="gridview_wrapper">
				<div>
					<table cellpadding="0" cellspacing="0" border="0" class="display"
						id="kuruluslar">
						<thead>
							<tr>
								<th class="no_sort">#</th>
								<th>Kuruluş Türü</th>
								<th>Kuruluş Adı</th>
								<th>Kuruluş Yetkilisi</th>
								<th>Yetkili Kişi Unvanı</th>
								<th>Kuruluş Web Adresi</th>
							</tr>
						</thead>
						<tbody>
	
						<?php
						$kuruluslar = $this->kuruluslar;
						$j=0;
						$allTheTableContents = "";
						for($i=0; $i<count($kuruluslar); $i++)
						{
							$allTheRowContents = "";
							
							$checked = "";
							$class = "";
							$rowChecked = false;
							$yetkilendirmeKurulusTuru_AsilChecked = "";
							$yetkilendirmeKurulusTuru_YardimciChecked = "";
								
							if($kuruluslar[$i]["USER_ID"]== $seciliProtokolKuruluslari[$j]["USER_ID"])
							{
								$checked = ' checked="checked" ';
								$rowChecked = true;
								$class = 'checkedRow';
								
								if($seciliProtokolKuruluslari[$j]["KURULUS_TURU"] == PM_YETKILENDIRME_KURULUS_TURU__YARDIMCI)
									$yetkilendirmeKurulusTuru_YardimciChecked = "checked='checked'";
								else
									$yetkilendirmeKurulusTuru_AsilChecked = "checked='checked'";
								
								$j++;
							}
							$allTheRowContents .= '<tr class=" '.$class.' ">';
							$allTheRowContents .= '<td><input type="checkbox" value="'.$kuruluslar[$i]["USER_ID"].'" class="kurulusCheckbox" name="kurulusCheckbox[]" '.$checked.' ></td>';
							
							$allTheRowContents .= '<td>';
							$allTheRowContents .= '<input type="radio" class="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'"  name="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'" value="'.PM_YETKILENDIRME_KURULUS_TURU__ASIL.'" '.$yetkilendirmeKurulusTuru_AsilChecked.'>Asıl<br>';
							$allTheRowContents .= '<input type="radio" class="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'"  name="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'" value="'.PM_YETKILENDIRME_KURULUS_TURU__YARDIMCI.'" '.$yetkilendirmeKurulusTuru_YardimciChecked.'>Yardımcı';
							$allTheRowContents .= '</td>';
							
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_ADI"].'</td>';
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_YETKILISI"].'</td>';
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_YETKILI_UNVANI"].'</td>';
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_WEB"].'</td>';
							$allTheRowContents .= '</tr>';
							
							if($rowChecked==true)
								$allTheTableContents = $allTheRowContents.$allTheTableContents;
							else
								$allTheTableContents = $allTheTableContents.$allTheRowContents;
							
						}
						
						echo $allTheTableContents;
						
						?>
						</tbody>
					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>

		<div class="submit_button">
			<input type="submit" value="<?php echo $kaydetButtonTexti; ?>"
				name="kaydetButton" id="kaydetButton" />
		</div>
	</form>

	<div style="clear: both;"></div>
</div>

<!-- JAVASCRIPT -->

<script type="text/javascript">
var inputChanged = false;
var settings = {
    "oLanguage": {
		"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
		"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
		"sInfo": "<?php echo JText::_("INFO");?>",
		"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
		"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
		"sSearch": "<?php echo JText::_("SEARCH");?>",
		"oPaginate": {
			"sFirst":    "<?php echo JText::_("FIRST");?>",
			"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
			"sNext":     "<?php echo JText::_("NEXT");?>",
			"sLast":     "<?php echo JText::_("LAST");?>"
		}
	}
};
var msg = 'Sayfayı terketmek üzeresiniz. Kaydedilmemiş verileriniz kaybolacak.';
jQuery(window).bind('beforeunload', function(e) {
	// For IE and Firefox prior to version 4
	if (e) {
		e.returnValue = msg;
	}

	// For Safari
	if(inputChanged==true)
	return msg;
}); 

jQuery(document).ready(function() {	
	jQuery( "input:submit", ".submit_button" ).button();

	//ON SUBMIT VALIDATE
	jQuery("#yeniprotokolForm").validate();
	jQuery.extend(jQuery.validator.messages, {
	    required: "*"
	});
	
	//TAKVIM
	jQuery( "#imzaTarihiDatePicker" ).datepicker({ });

	//INIT TABLES
    var oTableKurulus = jQuery('#kuruluslar').dataTable(settings);
    var oTableUzatma = jQuery('#uzatmalar').dataTable(settings);
    
	///////////////////////////////////////////////////////////////////////////////////////
	jQuery('input').change(function() {
		inputChanged=true;
	});
	jQuery('select').change(function() {
		inputChanged=true;
	});
	
	///////////////////////////////////////////////////////////////////////////////////////

	//NEW ROW FOR UZATMALAR
    jQuery('#newUzatma').click( function (e) {
        e.preventDefault();       
        var aiNew = oTableUzatma.fnAddData( [ '', //Uzatma Suresi
	                                          '', //Aciklama
	                                          '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>', //Guncelle
	                                          '<a class="deleteUzatma" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
	                                        ], true );
        nRow = oTableUzatma.fnGetNodes( aiNew[0] );
        editUzatmaRow( oTableUzatma, nRow, true);

     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//SAVE ROW FOR UZATMALAR
    jQuery('#uzatmalar a.saveUzatma').live('click', function (e) {
        e.preventDefault();

        var nRow = jQuery(this).parents('tr')[0]; 
        if (validate (nRow)){
        	saveUzatmaRow( oTableUzatma, nRow, true);
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END SAVE ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//EDIT ROW FOR UZATMALAR
    jQuery('#uzatmalar a.editUzatma').live('click', function (e) {
        e.preventDefault();
         
        //Get the row as a parent of the link that was clicked on
        var nRow = jQuery(this).parents('tr')[0];
         
        if (this.innerHTML == "<?php echo JText::_("SAVE_TEXT");?>" ) {
            //This row is being edited and should be saved
            if (validate (nRow)){
            	saveUzatmaRow( oTableUzatma, nRow, false);
            }
        }
        else {
            //No row currently being edited
            editUzatmaRow( oTableUzatma, nRow, false );
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END EDIT ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//DELETE ROW FOR UZATMALAR
    jQuery('#uzatmalar a.deleteUzatma').live('click', function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        var id = nRow.getAttribute('id');

      	//Satir yeni eklenmemisse
        if (id != null){
	        jQuery( "#dialog-confirm" ).dialog({
		        buttons: {
					"<?php echo JText::_("DELETE_TEXT");?>": function() {
				        deleteUzatmaRow( oTableUzatma, nRow );
				        jQuery( this ).dialog( "close" );
					},
					"<?php echo JText::_("CANCEL_TEXT");?>": function() {
						jQuery( this ).dialog( "close" );
						
					}
		        }
			});

	        jQuery( "#dialog-confirm" ).dialog("open");
        }else{
        	oTableMS.fnDeleteRow( nRow );
        }      

     	// Stop event handling in IE
        return false;
    } );
  	//END DELETE ROW FOR UZATMALAR
  	
	///////////////////////////////////////////////////////////////////////////////////////

  	//CANCEL EDIT FOR UZATMALAR
    jQuery('#uzatmalar a.cancelUzatma').live('click', function (e) {
    	e.preventDefault();
        
        var nRow = jQuery(this).parents('tr')[0];
        cancelUzatmaEdit( oTableUzatma, nRow );

     	// Stop event handling in IE
        return false;
    } );
    
  	///////////////////////////////////////////////////////////////////////////////////////
  	
	//DIALOG
	jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	jQuery( "#dialog-confirm" ).dialog({
		resizable: false,
		modal: true,
		autoOpen: false
	});

	// ATTACH EVENT TO MOUSEDOWN
	var seciliKurulusIDleri = [];
	var seciliKurulusRolleri = [];
	jQuery('#kuruluslar_next, #kuruluslar_previous').live('mousedown', function (e) {
		kurulusIDleriniKaydet();
	});

	function kurulusIDleriniKaydet()
	{
		jQuery('.kurulusCheckbox').each(function() {
			var index = seciliKurulusIDleri.indexOf(jQuery(this).val());
			if( index != -1)
			{
					seciliKurulusIDleri.splice(index, 1);
					seciliKurulusRolleri.splice(index, 1);
					
			}
		 }); //DROP ALL THE CHECKBOXES IF THEY EXIST

		jQuery('.kurulusCheckbox:checked').each(function() {
			var kurulusID = jQuery(this).val();
			var kurulusRol = jQuery('.kurulusTuruRadioButtons-'+kurulusID+':checked').val();
			
			seciliKurulusIDleri.push(kurulusID);
			seciliKurulusRolleri.push(kurulusRol);
		 });//ADD THE ONES THAT ARE SELECTED AND NOT IN THE ARRAY
	}

	jQuery('#kaydetButton').live('mousedown', function (e) {
		jQuery(window).unbind('beforeunload');
		kurulusIDleriniKaydet();
		
		var kurulusIdleriText = "";
		var kurulusRolleriText = "";
		for(var i=0; i<seciliKurulusIDleri.length; i++)
		{	//alert(''+seciliKurulusIDleri[i]);
			kurulusIdleriText += "&seciliKurulusIDleri[]=" + seciliKurulusIDleri[i];

			//alert(seciliKurulusRolleri[i]);
			
			if(typeof(seciliKurulusRolleri[i])=="undefined")
			 	seciliKurulusRolleri[i] = 1; //ASIL KURULUS

			kurulusRolleriText += "&seciliKurulusRolleri[]=" + seciliKurulusRolleri[i];
			
		}

		//alert(kurulusIdleriText+kurulusRolleriText);
		jQuery("#yeniprotokolForm").attr("action", "index.php?option=com_protokol_ms&amp;task=protokolKaydet" + kurulusIdleriText + kurulusRolleriText);
		jQuery("#yeniprotokolForm").submit();
	});
	/////////////////////////////////////////////////////////////////////////////////
	



	
} );

function editUzatmaRow ( oTable, nRow, isSave )
{
	inputChanged=true;
	
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    
    jqTds[0].innerHTML = '<input size="50" class="required " value="'+aData[0]+'" type="text" name="uzatmaSuresi"  onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" />';
    jqTds[1].innerHTML = '<input size="50" class="required " value="'+aData[1]+'" type="text" name="uzatmaAciklama"/>';

    
    if (!isSave)
    	jqTds[2].innerHTML = '<a class="editUzatma" href=""><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelUzatma" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
    else
    	jqTds[2].innerHTML = '<a class="saveUzatma" href=""><?php echo JText::_("SAVE_TEXT");?></a>';
}

function cancelUzatmaEdit ( oTable, nRow )
{
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    jqTds[0].innerHTML = aData[0];
    jqTds[1].innerHTML = aData[1];
    jqTds[2].innerHTML = '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>';
}

function saveUzatmaRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var sendData = jqInputs.serializeArray();
	var sendDataSelects = jqSelects.serializeArray();
	var sendDataAll = sendData.concat(sendDataSelects);
	
	var protokolID = jQuery("#protokolID").val();
		
	var url = 'index.php?option=com_protokol_ms&task=ajaxUzatmaKaydet&format=raw&protokolID='+protokolID;

	if (!isSave){
		url = 'index.php?option=com_protokol_ms&task=ajaxUzatmaGuncelle&format=raw&protokolID='+protokolID;

		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');
		
		sendDataAll.push(obj);
	}
			
	jQuery.ajax({
		  url: url,
		  data: sendDataAll,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){				
			    oTable.fnUpdate( jqInputs[0].value, nRow, 0, false );
			    oTable.fnUpdate( jqInputs[1].value, nRow, 1, false );
			    oTable.fnUpdate( '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 2, false );

				  if (isSave){
						nRow.setAttribute('id', data['id']);
						alert("Başarıyla eklendi");					
					}
			  }
			  else
			  {
				  alert("Eklemede hata");
			  }

			  oTable.fnDraw();	 
		  }
	});
}

function deleteUzatmaRow ( oTable, nRow)
{
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();

	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');

	sendData.push(obj);

	var protokolID = document.getElementById("protokolID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_protokol_ms&task=ajaxUzatmaSil&format=raw&protokolID="+protokolID,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				oTable.fnDeleteRow( nRow );
				//updateYetkilendirmeStandartlari(data['array']);
				//existingVariablesChanged();
			  }else{
			  	oTable.fnDraw();
			  }
		  }
	});	
}

//FILE UPLOAD
dTables.protokolDosya = new Array(new Array("upload"));

function createTables(){
	tableName = "protokolDosya";
	createTable(tableName, new Array(''));
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 0);
	addProtokolDosya (tableName);
}

function addProtokolDosya (tableName){
	<?php
 	$path = $dosya;	
 	echo "var path = '".FormFactory::normalizeVariable ($path)."';";
 	echo "var fileName = '".FormFactory::getNormalFilename(basename  ($path))."';";
	?>

	if (path != null && path != ''){
		var id		 = tableName + "_0";
		var sira	 = 1;
		var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
		var inputPath = '<input type="hidden" value="'+path+'" name="path_'+id+'_'+sira +'">' +
						'<input type="hidden" value="" name="filename_'+id+'_'+sira +'">';				
			
		var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!';
		result 	  += '<input type="button" value="İndir" onclick="window.location.href=\'index.php?option=com_protokol_ms&amp;task=indir&amp;protokolID=<?php echo $protokolID;?>\'" class="up_submitbtn" style="float:none;"> <\/div>';
		result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\''+sira+'\')" /><\/div>';
		resultDiv.innerHTML = result;
	
		var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
		uploadSpan.style.visibility = 'hidden';
		uploadSpan.style.height = 0;
	}
}

</script>