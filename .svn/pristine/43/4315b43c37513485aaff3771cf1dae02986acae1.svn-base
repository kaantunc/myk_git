<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Meslek Standardı Yetkilendirme Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="yetkilendirmeForm" name="yetkilendirmeForm" method="post"
		action="index.php?option=com_yetkilendirme_ms&amp;task=etkisizlestir">
	
		<div class="toolbar">
			<input
				id="etkinlestirButton" value="Etkin Hale Getir"
				name="etkinlestirButton" type="button" onclick="OnButton1();"
				/> 
			<input
				id="etkisizlestirButton" value="Etkisiz Hale Getir"
				name="etkisizlestirButton" type="button" onclick="OnButton2();"
				/> 
			<input
				id="silButton" value="Sil" 
				name="silButton" type="button"  onclick="OnButton3();"
				/> 
			<input id="duzenleButton" value="Düzenle"
				name="duzenleButton" type="button" disabled="disabled" class="disabled"  onclick="OnButton4();" />
			
			<input id="yeniButton" value="Yeni" name="yeniButton"
				type="button"  onclick="OnButton5();"
				/> 
	
			<div style="clear: both;"></div>
		</div>
	
		<div class="detayliAramaDiv">
			 <a id="detayliAramaGosterGizleButton" href="">Detaylı Arama Yap</a>
			 <br>
			
			<div id="detayliAramaFilters" class="detayliAramaFilters" style="display:none;">
				Kuruluş Adı:
				<br><input type="text" name="detayliArama_kurulusAdiTextbox" id="detayliArama_kurulusAdiTextbox" class="detayliArama" />
				<br>Standart Adı:
				<br><input type="text" name="detayliArama_ekliYeterlilikTextbox" id="detayliArama_ekliYeterlilikTextbox" class="detayliArama" />
				<br>Standart Sektörü:
				<br><select multiple="multiple" name="detayliArama_ekliYeterlilikSektorSelect[]" id="detayliArama_ekliYeterlilikSektorSelect" class="detayliArama" >
				<?php
					$sektorler = $this->meslekStandartSektorleri;
					echo "<option value='0'>Tümü</option>";
					for($i = 0; $i< count($sektorler); $i++)
					echo "<option value='".$sektorler[$i]["SEKTOR_ID"]."'>" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
				?>
				</select>
				
			</div>
			
		</div>
		
		
		<div>
			<table id="yetkilendirmeListe">
				<thead >
					<tr>
						<th>#</th>
						<th class="yetkilendirmeHead">Yetkilendirme Adı</th>
						<th>İmza Tarihi</th>
						<th>Bitiş Tarihi</th>
						<th>Türü</th>
						<th class="aktifHead">Aktif Mi?</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$yetkilendirmeler = $this->yetkilendirmeler;
				$etkinlikDurumlari = $this->etkinlikDurumlari;
	
				for($i=0; $i<count($yetkilendirmeler); $i++)
				{
					$backgroundColor = '';
					if($yetkilendirmeler[$i]["ETKIN"]== $etkinlikDurumlari[0]["DURUM_ID"]){//AKTIF
						$backgroundClass = "enabled";
					}
					else if($yetkilendirmeler[$i]["ETKIN"]== $etkinlikDurumlari[1]["DURUM_ID"]){//ETKISIZ
						$backgroundClass = "disabled";
					}
	
					echo '<tr>';
					echo '<td><input onclick="doThis();" type="checkbox" value="'.$yetkilendirmeler[$i]["YETKI_ID"].'" name="yetkilendirmelerCheckbox[]" id="yetkilendirmelerCheckbox'.$i.'"></td>';
					
					/*if(strlen($yetkilendirmeler[$i]["ILGILI_PROTOKOL_ID"])>0)
						echo '<td><a target="_blank" href="index.php?option=com_protokol_ms&layout=yeni&protokolID='.$yetkilendirmeler[$i]["ILGILI_PROTOKOL_ID"].'">Protokole Git</a></td>';
					else
						echo '<td>&nbsp;</td>';*/
					
					echo '<td><a href="index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$yetkilendirmeler[$i]["YETKI_ID"].'">'.$yetkilendirmeler[$i]["ADI"].'</a></td>';
					echo '<td>'.$yetkilendirmeler[$i]["IMZA_TARIHI"].'</td>';
					echo '<td>'.$yetkilendirmeler[$i]["BITIS_TARIHI"].'</td>';
					if($yetkilendirmeler[$i]['PROTOKOL_MU']==1){
						echo '<td>Protokol</td>';	
					}else if($yetkilendirmeler[$i]['PROTOKOL_MU']==0){
						echo '<td>Yetkilendirme</td>';
					}else{
						echo '<td></td>';
					}
					
					echo '<td class="'.$backgroundClass.'">'.$yetkilendirmeler[$i]["ACIKLAMA"].'</td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</form>
	
	<div style="clear:both;"></div>
</div>

<script type="text/javascript">
function OnButton1()
{
    document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;task=etkinlestir";
    document.yetkilendirmeForm.submit();             // Submit the page
    return true;
}
function OnButton2()
{
    document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;task=etkisizlestir";
    document.yetkilendirmeForm.submit();             // Submit the page
    return true;
}
function OnButton3()
{
	<?php 
			$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
			
			$yeterlilikKayitliYetkilendirmelerString = "";
			$standartlarKayitliYetkilendirmelerString = "";
			$x="..";
			?>

	if(confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' )==true)
	{		
	    document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;task=sil";
	    document.yetkilendirmeForm.submit();             // Submit the page
	}
    return true;
}
function OnButton4()
{
	var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
	document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;layout=yeni&amp;yetkilendirmeID="+editIndex;
    document.yetkilendirmeForm.submit();             // Submit the page
    return true;
}
function OnButton5()
{
    document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;layout=yeni";
    document.yetkilendirmeForm.submit();             // Submit the page
    return true;
}
jQuery(document).ready(function() {
	//INIT DATATABLE
	var detayliAramaResultsHidden = 1;
	
	var oTableKurulus = jQuery('#yetkilendirmeListe').dataTable({
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
    });


    jQuery('#detayliAramaGosterGizleButton').click( function (e) {

		if(detayliAramaResultsHidden==0)//gizli değilse gizle
    	{
	    	jQuery('#detayliAramaFilters').hide("slow");
    		
   			detayliAramaResultsHidden = 1;
    	}
    	else // zaten gizliyse göster
    	{
    		jQuery('#detayliAramaFilters').show("slow");

			detayliAramaResultsHidden = 0;
        	
    	}	
        
     	// Stop event handling in IE
        return false;
    } );

    jQuery('#detayliArama_kurulusAdiTextbox').keyup(function() {
		filterVariablesChanged();
	});
    jQuery('#detayliArama_ekliYeterlilikTextbox').keyup(function() {
    	filterVariablesChanged();
	});
    jQuery('#detayliArama_ekliYeterlilikSektorSelect').change(function() {
    	filterVariablesChanged();
	});
    
});

function filterVariablesChanged()
{
	var jqInputs = jQuery('.detayliArama');
	var sendData = jqInputs.serializeArray();

	
	var url = 'index.php?option=com_yetkilendirme_ms&task=ajaxFilterYetkilendirmeler&format=raw';
 
	
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
					
				  	var arrayToPut = data['array'];
				  	var oTableMS = jQuery('#yetkilendirmeListe').dataTable();

					oTableMS.fnClearTable();
					for(var i=0; i<arrayToPut.length; i++)
				    {
				    	var a = oTableMS.fnAddData( [
							'<td><input onclick="doThis();" type="checkbox" value="'+arrayToPut[i]["YETKI_ID"]+'" name="yetkilendirmelerCheckbox[]" id="yetkilendirmelerCheckbox'+i+'"></td>',
							'<td><a href="index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='+arrayToPut[i]["YETKI_ID"]+'">'+arrayToPut[i]["ADI"]+'</a></td>',
							'<td>'+arrayToPut[i]["IMZA_TARIHI"]+'</td>',
							'<td>'+arrayToPut[i]["BITIS_TARIHI"]+'</td>',
							'<td class="enabled">'+(arrayToPut[i]["PROTOKOL_MU"] == "1" ? 'Protokol' : 'Yetkilendirme')+'</td>',
							'<td>'+arrayToPut[i]["ACIKLAMA"]+'</td>',
				        ]);
				    	
				        
				    }  
			    	
			  }else{
				  var oTableMS = jQuery('#yetkilendirmeListe').dataTable();

					oTableMS.fnClearTable();
					
			  }
		  }
	});
}

function doThis()
{
	var $b = jQuery('input[type=checkbox]');
	var count = $b.filter(':checked').length; // works
	if(count==1)
	{
		jQuery("#duzenleButton").removeAttr('disabled');
		var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
		//alert(editIndex);
		//document.yetkilendirmeForm.action = "index.php?option=com_yetkilendirme_ms&amp;layout=yeni&amp;yetkilendirmeID="+editIndex;
		jQuery("#yetkilendirmeForm").attr("action", "index.php?option=com_yetkilendirme_ms&amp;layout=yeni&amp;yetkilendirmeID="+editIndex);
		
	}
	else
	{
		jQuery("#duzenleButton").attr('disabled', 'disabled');
	}
}
function JS_Sil()
{
	<?php 
	$yetkilendirmeArr = JRequest::getVar('yetkilendirmelerCheckbox');
	
	$yeterlilikKayitliYetkilendirmelerString = "";
	$standartlarKayitliYetkilendirmelerString = "";
	$x="..";
	?>

	return confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' );
}

</script>
