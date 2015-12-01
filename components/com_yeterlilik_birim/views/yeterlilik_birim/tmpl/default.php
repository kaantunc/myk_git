<?php
$birimID = $this->birimID;
$info = $this->birimInfo[0];

if(!isset($birimID) || empty($birimID))
{	
	$kaynakVisibility = "display: none;";
	$kaydetButtonTexti = "Birim Ekle";
}
else
{
	$kaynakVisibility = "display: block;";
	$kaydetButtonTexti = "Değişiklikleri Kaydet";
}

//SEVIYELER
$seviyeOptions = "<option value=''></option>";
foreach($this->seviyeler as $seviye){
	$seviyeOptions .= "<option value='".$seviye["SEVIYE_ID"]."'>".$seviye["SEVIYE_ADI"]."</option>";
}

//SEKTORLER
$sektorOptions = "<option value=''></option>";
foreach($this->sektorler as $sektor){
	$sektorOptions .= "<option value='".$sektor["SEKTOR_ID"]."'>".$sektor["SEKTOR_ADI"]."</option>";
}
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Yeterlilik Birimi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="genel_wrapper">
	<div class="form_content">
		<form method="post" id="form" action="index.php?option=com_yeterlilik_birim&amp;task=birimKaydet">
			<input type="hidden" id="birimID" name="birimID" value="<?php echo $birimID;?>"/>
	
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Yeterlilik Birim Adı</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="birim_ad" name="birim_ad" type="text" value="<?php echo $info["YETERLILIK_BIRIM_ADI"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Referans Kodu</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="referans_kodu" name="referans_kodu" type="text" value="<?php echo $info["YETERLILIK_BIRIM_KODU"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Seviyesi</label>
			    <select id="seviye" name="seviye">
			    	<?php echo $seviyeOptions; ?>
			  	</select>
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Kredi Değeri</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="kredi_degeri" name="kredi_degeri" type="text" value="<?php echo $info["YETERLILIK_BIRIM_KREDI"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Yayın Tarihi</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="yayin_tarihi" name="yayin_tarihi" type="text" value="<?php echo $info["YETERLILIK_BIRIM_YAYIN_TAR"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Revizyon No</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="revizyon_no" name="revizyon_no" type="text" value="<?php echo $info["YETERLILIK_BIRIM_REV_NO"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="form_item">
			  <div class="form_element cf_textbox">
			    <label class="cf_label" style="width: 150px;">Revizyon Tarihi</label>
			    <input class="cf_inputbox required" maxlength="150" size="30" id="revizyon_tarihi" name="revizyon_tarihi" type="text" value="<?php echo $info["YETERLILIK_BIRIM_REV_TAR"];?>"/>
			  
			  </div>
			  <div class="cfclear">&nbsp;</div>
			</div>
			
			<div class="submit_button">
				<input type="submit" value="<?php echo $kaydetButtonTexti;?>"
					name="kaydetButton" id="kaydetButton" />
			</div>	
		</form>
	</div>

	<div class="cfclear">&nbsp;</div>
</div>


<div class="kaynak_wrapper" style="<?php echo $kaynakVisibility;?>">
	<div class="title_wrapper">
		<strong> Yeterlilik Birimine Kaynak Teşkil Eden Meslek Standart(lar)ı:</strong>
	</div>
	
	<div class="gridview_wrapper" >
	
		<div class="varolan_standart_ekle">
			<a id="addExistingMeslekStandart" href="">Ulusal Meslek Standardı Ekle</a>
		</div>

		<div class="existing_standart_wrapper" id="existing_standart_wrapper">

			<div id="existing_standart_container">

				<div class="search_container">
					Meslek Seviyesi Seçiniz:<br/> 
					<select id="existing_seviyeler">
						<?php echo $seviyeOptions; ?>
					</select> 
					<br/> 
					Meslek Sektörü Seçiniz:<br/> 
					<select	id="existing_sektorler">
						<?php echo $sektorOptions; ?>
					</select>
				</div>

				<div id="varolanStandartlarContainer">
					<div class= "varolanStandartlariEkleDiv">
						<a href=''class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
					</div>

					<div style="width: 100%;">
						<table id="existing_meslekStandartlari">
							<thead>
								<tr>
									<th>#</th>
									<th>Standart Kodu</th>
									<th>Standart Adı</th>
									<th>Standart Seviyesi</th>
									<th>Standart Sektörü</th>
									<th>Standart Durumu</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>

					<div style="clear: both;"></div>
					<div style="width: 100%; padding-top: 10px;">
						<a href='' class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
					</div>
				</div>


			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div class="yeni_kaynak">
			<a id="yeniKaynak" href="">Diğer Standart Ekle </a>
		</div>

		<div class="kaynak_tablo">
			<table id="kaynak_meslek_standartlari">
				<thead>
					<tr>
						<th>Meslek Standardı</th>
						<th>Açıklama</th>
						<th>Güncelle</th>
						<th>Sil</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					//DATABASE
					$elm = "";
					for($i = 0; $i < count($this->birimKaynak); $i++){
						$row = $this->birimKaynak[$i];
						if (empty($row["STANDART_ID"])){
							$standartText = "Diğer";
						}else{
							$standartText = $row["STANDART_KODU"]."-".$row["STANDART_ADI"]." (".$row["SEVIYE_ADI"].")";
						}
						
						$elm .= '<tr id="'.$row["KAYNAK_ID"].'">';
						$elm .= '<td>'.$standartText.'</td>';
						$elm .= '<td>'.$row["KAYNAK_ACIKLAMA"].'</td>';
						$elm .= "<td><a class='editKaynak' href=''>".JText::_("EDIT_TEXT")."</a></td>";
						$elm .= "<td><a class='deleteKaynak' href=''>".JText::_("DELETE_TEXT")."</a></td>";
						$elm .= '</tr>';
					}
					
					echo $elm;
					?>
				</tbody>
			</table>
			
			<div class="cfclear">&nbsp;</div>
		</div>
	</div>
	
	<div id="dialog-confirm"
		title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
		<p>
			<span class="ui-icon ui-icon-alert"
				style="float: left; margin: 0 7px 20px 0;"></span>
			
			<?php echo JText::_("DELETE_CONFIRM_TEXT");?></p>
	</div>
	
	<div class="cfclear">&nbsp;</div>
</div>

<!-- JAVASCRIPT -->

<script type="text/javascript">
var existingStandartHidden = 1;

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

jQuery(document).ready(function() {	
	//JQueryUI Button
	jQuery( "input:submit", ".submit_button" ).button();

	//DIALOG
	jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	jQuery( "#dialog-confirm" ).dialog({
		resizable: false,
		modal: true,
		autoOpen: false
	});
	
	//INIT TABLES
    var oTableMS = jQuery('#kaynak_meslek_standartlari').dataTable(settings);
    var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable(settings);

	//VAROLAN STANDART ARAMA 
    jQuery('#addExistingMeslekStandart').click( function (e) {

		if(existingStandartHidden==0)//gizli değilse gizle
    	{
	    	jQuery('#existing_meslekStandartlari').hide();
    		jQuery('#existing_standart_wrapper').hide();
    		jQuery('#existing_seviyeler').val(0);
    		jQuery('#existing_sektorler').val(0);

    		var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
			oTableVarolanMS.fnClearTable();

    		existingStandartHidden = 1;
    	}
    	else // zaten gizliyse göster
    	{
    		jQuery('#existing_standart_wrapper').show();
    		jQuery('#existing_meslekStandartlari').show();
        	existingStandartHidden = 0;
        	existingVariablesChanged();
    	}	
        
     	// Stop event handling in IE
        return false;
    } );

    //VALUE CHANGED
	jQuery('#existing_sektorler').change(function() {
		existingVariablesChanged();
	});
	jQuery('#existing_seviyeler').change(function() {
		existingVariablesChanged();
	});

	//VAROLAN STANDARTLARI EKLE
    jQuery('.varolanStandartlariEkleButton').live('click', function (e) {

    	if(jQuery("#existing_sektorler").val()== 0 && jQuery("#existing_seviyeler").val()== 0  )
    	{	//IKISI DE SECILI DEGIL
    		jQuery("#existing_sektorler").css("border", "1px solid red");
    		jQuery("#existing_seviyeler").css("border", "1px solid red");
    		
    	}
    	else
    	{
    		jQuery("#existing_sektorler").css("border", "1px solid #C6C3C6");
    		jQuery("#existing_seviyeler").css("border", "1px solid #C6C3C6");
    	
	    	var jqInputs = jQuery('.varolanStandartlarCheckbox');
	    	var sendData = jqInputs.serializeArray();
	    	
			var url = 'index.php?option=com_yeterlilik_birim&task=ajaxAddFromVarolanStandartlar&format=raw&birimID=' + jQuery("#birimID").val();
			
	    	jQuery.ajax({
	    		  url: url,
	    		  data: sendData,
	    		  type: "POST",
	    		  dataType: 'json',
	    		  success: function(data) {
	    			  if(data['success']){
	    				  alert("Başarıyla Eklendi");
	    			    	existingVariablesChanged();
	    			    	updateKaynakStandartlari(data['array']);
	     			  }else{
	    				  alert("Hata oluştu");
	    			  }
	    		  }
	    	});
    	}
    	// Stop event handling in IE
        return false;
    } );

    //YENI KAYNAK EKLE
    jQuery('#yeniKaynak').click( function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        
        var aiNew = oTableMS.fnAddData( [ '', //Standart
                                          '', //Aciklama
                                          '<a class="editKaynak" href=""><?php echo JText::_("EDIT_TEXT");?></a>', //Guncelle
                                          '<a class="deleteKaynak" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
                                        ], true );
        var nRow = oTableMS.fnGetNodes( aiNew[0] );
        editMSRow( oTableMS, nRow, true);

     	// Stop event handling in IE
        return false;
    } );

  	//KAYNAK DUZENLE
    jQuery('#kaynak_meslek_standartlari a.editKaynak').live('click', function (e) {
        e.preventDefault();
         
        //Get the row as a parent of the link that was clicked on
        var nRow = jQuery(this).parents('tr')[0];
         
        if (this.innerHTML == "<?php echo JText::_("SAVE_TEXT");?>" ) {
            //This row is being edited and should be saved
            if (validate (nRow)){
            	saveMSRow( oTableMS, nRow, false);
            }
        }
        else {
            //No row currently being edited
            editMSRow( oTableMS, nRow, false );
        }

     	// Stop event handling in IE
        return false;
    } );

  	//KAYNAK KAYDET
    jQuery('#kaynak_meslek_standartlari a.saveKaynak').live('click', function (e) {
        e.preventDefault();

        var nRow = jQuery(this).parents('tr')[0]; 
        if (validate (nRow)){
        	saveMSRow( oTableMS, nRow, true);
        }

     	// Stop event handling in IE
        return false;
    } );

    //KAYNAK SIL
    jQuery('#kaynak_meslek_standartlari a.deleteKaynak').live('click', function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        var id = nRow.getAttribute('id');

      	//Satir yeni eklenmemisse
        if (id != null){
	        jQuery( "#dialog-confirm" ).dialog({
		        buttons: {
					"<?php echo JText::_("DELETE_TEXT");?>": function() {
				        deleteMSRow( oTableMS, nRow );
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

  	//KAYNAK IPTAL
    jQuery('#kaynak_meslek_standartlari a.cancelKaynak').live('click', function (e) {
    	e.preventDefault();
        
        var nRow = jQuery(this).parents('tr')[0];
        cancelMSEdit( oTableMS, nRow );

     	// Stop event handling in IE
        return false;
    } );
    
});

function editMSRow ( oTable, nRow, isSave )
{
	inputChanged=true;
	
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);

    if(isSave)
    {
    	jqTds[0].innerHTML = '<td>Diğer</td>';
    }

    jqTds[1].innerHTML = '<input size="50" value="'+aData[1]+'" type="text" name="aciklama"/>';
   
    if (!isSave)
    	jqTds[2].innerHTML = '<a class="editKaynak" href=""><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelKaynak" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
    else
    	jqTds[2].innerHTML = '<a class="saveKaynak" href=""><?php echo JText::_("SAVE_TEXT");?></a>';
}

function cancelMSEdit ( oTable, nRow )
{
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    jqTds[0].innerHTML = aData[0];
    jqTds[1].innerHTML = aData[1];
    jqTds[2].innerHTML = '<a class="editKaynak" href=""><?php echo JText::_("EDIT_TEXT");?></a>';
}

function saveMSRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);	
	var sendData = jqInputs.serializeArray();
	var birimID = jQuery("#birimID").val();	
	var url = 'index.php?option=com_yeterlilik_birim&task=ajaxKaynakKaydet&format=raw&birimID='+birimID;

	if (!isSave){
		url = 'index.php?option=com_yeterlilik_birim&task=ajaxKaynakGuncelle&format=raw&birimID='+birimID;
		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');
		sendData.push(obj);
	}
			
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				oTable.fnUpdate( jqInputs[0].value, nRow, 1, false );
				oTable.fnUpdate( '<a class="editKaynak" href=""><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 2, false );

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

function deleteMSRow ( oTable, nRow)
{
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();
	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');
	sendData.push(obj);
	var birimID = document.getElementById("birimID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_yeterlilik_birim&task=ajaxKaynakSil&format=raw&birimID="+birimID,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				oTable.fnDeleteRow( nRow );
				updateKaynakStandartlari(data['array']);
				existingVariablesChanged();
			  }else{
			  	oTable.fnDraw();
			  }
		  }
	});	
}

//COMBOBOX VALUE CHANGED
function existingVariablesChanged()
{
	
	if(jQuery("#existing_sektorler").val()== 0 && jQuery("#existing_seviyeler").val()== 0  )
	{	//IKISI DE SECILI DEGIL
		jQuery("#existing_sektorler").css("border", "1px solid red");
		jQuery("#existing_seviyeler").css("border", "1px solid red");

		jQuery("#varolanStandartlarContainer").hide();
		jQuery(".varolanStandartlariEkleButton").hide();
		jQuery("#existing_meslekStandartlari").hide();
		
	}
	else
	{
		jQuery("#existing_sektorler").css("border", "1px solid #C6C3C6");
		jQuery("#existing_seviyeler").css("border", "1px solid #C6C3C6");

		jQuery("#varolanStandartlarContainer").show();
		jQuery("#existing_meslekStandartlari").show();

		//AJAX CALL FETCHING DATA FROM DATABASE
		var sektorlerText = "";
		var seviyelerText = "";
		var sendData = null;
		var birimIDText = "&birimID=" + jQuery("#birimID").val();
		
		if(jQuery("#existing_sektorler").val()!= 0  ) ;
			sektorlerText = "&sektorID="+jQuery("#existing_sektorler").val();
		if(jQuery("#existing_seviyeler").val()!= 0  ) ;
			seviyelerText = "&seviyeID="+jQuery("#existing_seviyeler").val();

		var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
		oTableVarolanMS.fnClearTable();
		oTableVarolanMS.fnAddData( ["GETİRİLİYOR.", "","","","", "", ""]);
			
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_birim&task=ajaxFetchExistingStandart&format=raw"+seviyelerText+sektorlerText+birimIDText,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					//jQuery("#bilgilendirme").html(data['data']);
					putVarolanStandartDataToGrid(data['array']);
					jQuery(".varolanStandartlariEkleButton").show();
					//oTable.fnDeleteRow( nRow );
				  }else{
				  	//jQuery("#bilgilendirme").html(data['data']);
					oTableVarolanMS.fnClearTable();
					oTableVarolanMS.fnAddData( [ data['data'], "","","","","","" ]);
					jQuery(".varolanStandartlariEkleButton").hide();	
					//alert("FAIL, LOL!");
				  	//oTable.fnDraw();
				  }
			  }
		});
	}
}

function putVarolanStandartDataToGrid(arrayToPut)
{
	jQuery('#existing_meslekStandartlari').show();

	var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();

	oTableVarolanMS.fnClearTable();
	
    for(var i=0; i<arrayToPut.length; i++)
    {
    	oTableVarolanMS.fnAddData( [
			"<input type='checkbox' value='"+arrayToPut[i]["STANDART_ID"]+"' id='varolanStandartlarCheckbox-"+i+"' name='varolanStandartlarCheckbox[]' class='varolanStandartlarCheckbox' /> ",
			arrayToPut[i]["STANDART_KODU"],
			arrayToPut[i]["STANDART_ADI"],
			arrayToPut[i]["SEVIYE_ADI"],
			arrayToPut[i]["SEKTOR_ADI"],
			arrayToPut[i]["STANDART_SUREC_DURUM_ADI"],
			 "&nbsp;"
    	]);
    }  
}

function updateKaynakStandartlari(arrayToPut)
{
	var oTableMS = jQuery('#kaynak_meslek_standartlari').dataTable();

	oTableMS.fnClearTable();
	for(var i=0; i<arrayToPut.length; i++)
    {
		var standartText = "Diğer";
	    if (arrayToPut[i]["STANDART_ID"].length > 0)
	    	standartText = arrayToPut[i]["STANDART_KODU"] +"-"+arrayToPut[i]["STANDART_ADI"]+" (" + arrayToPut[i]["SEVIYE_ADI"] + ")";

    	var a = oTableMS.fnAddData( [
			standartText,
			arrayToPut[i]["KAYNAK_ACIKLAMA"],
			'<td><a class="editKaynak" href=""><?php echo JText::_("EDIT_TEXT"); ?></a></td>',
			'<td><a class="deleteKaynak" href=""><?php echo JText::_("DELETE_TEXT"); ?></a></td>'
        ]);
    	var nRow = oTableMS.fnSettings().aoData[ a[0] ].nTr;
        nRow.setAttribute('id', arrayToPut[i]["KAYNAK_ID"]);
    }  
}

</script>