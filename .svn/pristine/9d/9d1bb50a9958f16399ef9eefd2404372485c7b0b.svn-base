<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Yeterlilik Protokol Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="protokolForm" name="protokolForm" method="post"
		action="index.php?option=com_protokol_yet&amp;task=etkisizlestir">
	
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
		
		<div>
			<table id="protokolListe">
				<thead >
					<tr>
						<th>#</th>
						<th>Protokol ID</th>
						<th class="protokolHead">Protokol Adı</th>
						<th>İmza Tarihi</th>
						<th class="aktifHead">Aktiflik Durumu</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$protokoller = $this->protokoller;
				$etkinlikDurumlari = $this->etkinlikDurumlari;
	
				for ($i = 0; $i < count($protokoller); $i++)
				{
					$satir = $protokoller[$i];
					
					$backgroundColor = '';
					if($satir["ETKIN"]== $etkinlikDurumlari[0]["DURUM_ID"]){//AKTIF
						$backgroundClass = "enabled";
					}
					else if($satir["ETKIN"]== $etkinlikDurumlari[1]["DURUM_ID"]){//ETKISIZ
						$backgroundClass = "disabled";
					}
	
					echo '<tr>';
					echo '<td><input onclick="doThis();" type="checkbox" value="'.$satir["PROTOKOL_ID"].'" name="protokollerCheckbox[]" id="protokollerCheckbox'.$i.'"></td>';
					echo '<td>'.$satir["PROTOKOL_ID"].'</td>';
					echo '<td><a href="index.php?option=com_protokol_yet&layout=yeni&protokolID='.$satir["PROTOKOL_ID"].'">'.$satir["ADI"].'</a></td>';
					echo '<td>'.$satir["IMZA_TARIHI"].'</td>';
					echo '<td class="'.$backgroundClass.'">'.$satir["ACIKLAMA"].'</td>';
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
    document.protokolForm.action = "index.php?option=com_protokol_yet&amp;task=etkinlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton2()
{
    document.protokolForm.action = "index.php?option=com_protokol_yet&amp;task=etkisizlestir";
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton3()
{
	<?php 
	$protokolArr = JRequest::getVar('protokollerCheckbox');
	?>

	if(confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek' )==true)
	{		
	    document.protokolForm.action = "index.php?option=com_protokol_yet&amp;task=sil";
	    document.protokolForm.submit();             // Submit the page
	}
    return true;
}
function OnButton4()
{
	var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
	document.protokolForm.action = "index.php?option=com_protokol_yet&amp;layout=yeni&amp;protokolID="+editIndex;
    document.protokolForm.submit();             // Submit the page
    return true;
}
function OnButton5()
{
    document.protokolForm.action = "index.php?option=com_protokol_yet&amp;layout=yeni";
    document.protokolForm.submit();             // Submit the page
    return true;
}
jQuery(document).ready(function() {
	//INIT DATATABLE
    var oTableProtokol = jQuery('#protokolListe').dataTable({
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
    
});

function doThis()
{
	var $b = jQuery('input[type=checkbox]');
	var count = $b.filter(':checked').length; // works
	if(count==1)
	{
		jQuery("#duzenleButton").removeAttr('disabled');
		var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
		jQuery("#protokolForm").attr("action", "index.php?option=com_protokol_yet&amp;layout=yeni&amp;protokolID="+editIndex);
		
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
	?>

	return confirm('Silmek istediğinize emin misiniz? Bütün veriler silinecek' );
}

</script>
