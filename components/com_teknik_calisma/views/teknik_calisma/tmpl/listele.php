<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Teknik Çalışma Grubu Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form id="teknikCalismaGrubuForm" name="teknikCalismaGrubuForm" method="post"
		action="index.php?option=com_teknik_calisma">
	
		<div class="toolbar">
			<input id="yeniButton" value="Yeni" 
				name="etkinlestirButton" type="button"  
				onclick="OnButton2();" /> 
	
			<div style="clear: both;"></div>
		</div>
		
		
		
		<div>
			<table id="protokolListe">
				<thead >
					<tr>
						<th>#</th>
						<th>Düzenle</th>
						<th>TÇG Adı</th>
						<th>TÇG Yetkilisi</th>
					</tr>
				</thead>
				<tbody>
	
				<?php
				$teknikCalismaGruplari = $this->teknikCalismaGruplari;
				
				for($i=0; $i<count($teknikCalismaGruplari); $i++)
				{
					
					echo '<tr>';
					echo '<td><input type="checkbox" value="'.$teknikCalismaGruplari[$i]["USER_ID"].'" name="protokollerCheckbox[]" id="protokollerCheckbox'.$i.'"></td>';
					echo '<td><a href="index.php?option=com_teknik_calisma&layout=default&tcg_id='.$teknikCalismaGruplari[$i]["USER_ID"].'">DÜZENLE</a></td>';
					echo '<td>'.$teknikCalismaGruplari[$i]["KURULUS_ADI"].'</td>';
					echo '<td>'.$teknikCalismaGruplari[$i]["KURULUS_YETKILISI"].'</td>';
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

function OnButton2()
{
    document.teknikCalismaGrubuForm.action = "index.php?option=com_teknik_calisma";
    document.teknikCalismaGrubuForm.submit();             // Submit the page
    return true;
}


var oTableKurulus = jQuery('#protokolListe').dataTable({
   	"oLanguage": {
		"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
		"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
		"sInfo": "<?php echo JText::_("INFO");?>",
		"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
		"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
		"sSearch": "<?php echo JText::_("FILTER");?>",
		"oPaginate": {
			"sFirst":    "<?php echo JText::_("FIRST");?>",
			"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
			"sNext":     "<?php echo JText::_("NEXT");?>",
			"sLast":     "<?php echo JText::_("LAST");?>"
		}
	}
});



</script>
