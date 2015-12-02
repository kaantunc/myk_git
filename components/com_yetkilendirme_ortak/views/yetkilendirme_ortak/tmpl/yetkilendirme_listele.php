<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Protokol Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="protokolForm" name="protokolForm" method="post"
		action="index.php?option=com_yetkilendirme_ortak&amp;task=etkisizlestir">
	
		<div class="toolbar">
			<input
				id="etkinlestirButton" value="Etkin Hale Getir"
				name="etkinlestirButton" type="button"
				onclick="OnButton1();" /> 
			<input
				id="etkisizlestirButton" value="Etkisiz Hale Getir"
				name="etkisizlestirButton" type="button"
				onclick="OnButton2();" /> 
			<input 
				id="silButton" value="Sil" name="silButton" type="button"
				formaction="index.php?option=com_yetkilendirme_ortak&amp;task=sil"
				onclick="OnButton3();" /> 
				
			<input id="duzenleButton" value="Düzenle"
				name="duzenleButton" type="button" disabled="disabled"  
				onclick="OnButton4();"/>
				
			<input id="yeniButton" value="Yeni" 
				name="etkinlestirButton" type="button"  
				onclick="OnButton5();" /> 
	
			<div style="clear: both;"></div>
		</div>
		
		<div class="detayliAramaDiv">
			 <a id="detayliAramaGosterGizleButton" href="">Detaylı Arama Yap</a>
			 <br>
			
			<div id="detayliAramaFilters" class="detayliAramaFilters" style="display:none;">
				Kuruluş Adı:
				<br><input type="text" name="detayliArama_kurulusAdiTextbox" id="detayliArama_kurulusAdiTextbox" class="detayliArama" />
				<br>Yeterlilik veya Meslek Standartı Adı:
				<br><input type="text" name="detayliArama_ekliYeterlilikTextbox" id="detayliArama_ekliYeterlilikTextbox" class="detayliArama" />
				<br>Yeterlilik veya Meslek Standartı Sektörü:
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
			<table id="protokolListe" width="100%">
				<thead >
					<tr>
						<th>#</th>
						<th>Id</th>
						<th class="protokolHead">Yetkilendirme Adı</th>
						<th>İmza Tarihi</th>
						<th>Bitiş Tarihi</th>
						<th>Türü</th>
						<th class="aktifHead">Aktif Mi?</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$protokoller = $this->protokoller;
				$etkinlikDurumlari = $this->etkinlikDurumlari;
	
				for($i=0; $i<count($protokoller); $i++)
				{
					$backgroundColor = '';
					if($protokoller[$i]["ETKIN"]== $etkinlikDurumlari[0]["DURUM_ID"]){//AKTIF
						$backgroundClass = "enabled";
					}
					else if($protokoller[$i]["ETKIN"]== $etkinlikDurumlari[1]["DURUM_ID"]){//ETKISIZ
						$backgroundClass = "disabled";
					}
	
					echo '<tr>';
					echo '<td><input onclick="doThis();" type="checkbox" value="'.$protokoller[$i]["YETKI_ID"].'" name="protokollerCheckbox[]" id="protokollerCheckbox'.$i.'"></td>';
					echo '<td>'.$protokoller[$i]["YETKI_ID"].'</td>';
					/*if(strlen($protokoller[$i]["ILGILI_PROTOKOL_ID"])>0)
						echo '<td><a target="_blank" href="index.php?option=com_protokol_yet&layout=yeni&protokolID='.$protokoller[$i]["ILGILI_PROTOKOL_ID"].'">Protokole Git</a></td>';
					else
						echo '<td>&nbsp;</td>';*/
					
					echo '<td><a href="index.php?option=com_yetkilendirme_ortak&layout=yeni&protokolID='.$protokoller[$i]["YETKI_ID"].'">'.$protokoller[$i]["ADI"].'</a></td>';
					echo '<td>'.$protokoller[$i]["IMZA_TARIHI"].'</td>';
					echo '<td>'.$protokoller[$i]["BITIS_TARIHI"].'</td>';
					if($protokoller[$i]['PROTOKOL_MU']==1){
						echo '<td>Protokol</td>';
					}else if($protokoller[$i]['PROTOKOL_MU']==0){
						echo '<td>Yetkilendirme</td>';
					}else{
						echo '<td></td>';
					}
					echo '<td class="'.$backgroundClass.'">'.$protokoller[$i]["ACIKLAMA"].'</td>';
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
    document.protokolForm.action = "index.php?option=com_yetkilendirme_ortak&amp;task=etkinlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton2()
{
    document.protokolForm.action = "index.php?option=com_yetkilendirme_ortak&amp;task=etkisizlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton3()
{
	<?php 
			$protokolArr = JRequest::getVar('protokollerCheckbox');
			
			$yeterlilikKayitliProtokollerString = "";
			$standartlarKayitliProtokollerString = "";
			$x="..";
			?>

	if(confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' )==true)
	{		
	    document.protokolForm.action = "index.php?option=com_yetkilendirme_ortak&amp;task=sil";
	    document.protokolForm.submit();             // Submit the page
	}
    return true;
}
function OnButton4()
{
	var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
	document.protokolForm.action = "index.php?option=com_yetkilendirme_ortak&amp;layout=yeni&amp;protokolID="+editIndex;
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton5()
{
    document.protokolForm.action = "index.php?option=com_yetkilendirme_ortak&amp;layout=yeni";
    document.protokolForm.submit();             // Submit the page
    return true;
}

jQuery(document).ready(function() {
	//INIT DATATABLE
	var detayliAramaResultsHidden = 1;
	
    var oTableKurulus = jQuery('#protokolListe').dataTable({
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

	
	var url = 'index.php?option=com_yetkilendirme_ortak&task=ajaxFilterYetkilendirmeler&format=raw';

	
	
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){ 
					
				  	var arrayToPut = data['array'];
				  	var oTableMS = jQuery('#protokolListe').dataTable();

					oTableMS.fnClearTable();
					for(var i=0; i<arrayToPut.length; i++)
				    {
					    var backgroundClass = "";
					    if(arrayToPut[i]["ETKIN"]=="1") 
					    	backgroundClass = "enabled";
					    else 
					    	backgroundClass = "disabled";

				    	var a = oTableMS.fnAddData( [
							'<td><input onclick="doThis();" type="checkbox" value="'+arrayToPut[i]["YETKI_ID"]+'" name="yetkilendirmelerCheckbox[]" id="yetkilendirmelerCheckbox'+i+'"></td>',
							'<td>'+arrayToPut[i]["YETKI_ID"]+'</td>',
							'<td><a href="index.php?option=com_yetkilendirme_ortak&layout=yeni&protokolID='+arrayToPut[i]["YETKI_ID"]+'">'+arrayToPut[i]["ADI"]+'</a></td>',
							'<td>'+arrayToPut[i]["IMZA_TARIHI"]+'</td>',
							'<td>'+arrayToPut[i]["BITIS_TARIHI"]+'</td>',
							'<td class="enabled">'+(arrayToPut[i]["PROTOKOL_MU"] == "1" ? 'Protokol' : 'Yetkilendirme')+'</td>',
							'<td>'+arrayToPut[i]["ACIKLAMA"]+'</td>',
				        ]);
				    	
				        
				    }  
			    	
			  }else{
				  
				  var oTableMS = jQuery('#protokolListe').dataTable();

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
		//document.protokolForm.action = "index.php?option=com_protokol&amp;layout=yeni&amp;protokolID="+editIndex;
		$("#protokolForm").attr("action", "index.php?option=com_yetkilendirme_ortak&amp;layout=yeni&amp;protokolID="+editIndex);
		
	}
	else
	{
		jQuery("#duzenleButton").attr('disabled', 'disabled');
	}

	
}
function JS_Sil()
{
	<?php 
	$protokolArr = JRequest::getVar('protokollerCheckbox');
	
	$yeterlilikKayitliProtokollerString = "";
	$standartlarKayitliProtokollerString = "";
	$x="..";
	?>

	return confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek<?php echo $x; ?>' );
}

</script>
