<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once("libraries/joomla/utilities/browser_detection.php");
//$user_browser = browser_detection('browser');
?>
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Yönetim Kurulu Listesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<!-- ~Action? -->
	<form id="yonetimKuruluForm" name="yonetimKuruluForm" method="POST"
		action="index.php?option=com_yonetim_kurulu">

		<div class="toolbar">
			<input id="etkinlestirButton" value="Etkin Hale Getir"
				name="etkinlestirButton" type="button" onclick="EtkinlestirButton();" /> 
			<input id="etkisizlestirButton" value="Etkisiz Hale Getir"
				name="etkisizlestirButton" type="button" onclick="EtkisizlestirButton();" /> 
			<input id="silButton" value="Sil" name="silButton" type="button" disabled="disabled" class="disabled"
				onclick="SilButton();" />
			<input id="duzenleButton" value="Düzenle"
				name="duzenleButton" type="button" disabled="disabled" class="disabled" onclick="DuzenleButton();" />
			<input id="yeniButton" value="Yeni" name="yeniButton" type="button"
				onclick="YeniButton();" />

			<div style="clear: both;"></div>

		</div>

		<div>
			<table id="yonetimKuruluListe">
				<thead>
					<tr>
						<th class="checkbox">#</th>
						<th>Ad Soyad</th>
						<th>Unvan</th>
						<th class="kurum">Kurum</th>
						<th class="tarih">Başlangıç Tarihi</th>
						<th class="tarih">Bitiş Tarihi</th>
						<th class="aktifHead">Aktiflik Durumu</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$yonetimKurulu=$this->yonetimKurulu;
				$etkinlikDurumlari = $this->etkinlikDurumlari;
				for($i=0; $i<count($yonetimKurulu); $i++)
				{
					if($yonetimKurulu[$i]['ETKIN']== $etkinlikDurumlari[0]['DURUM_ID']){
						$backgroundClass = "enabled";
					}
					else if($yonetimKurulu[$i]['ETKIN']== $etkinlikDurumlari[1]['DURUM_ID']){
						$backgroundClass = "disabled";
					}
					echo '<tr>';
					echo '<td><input onclick="doThis();" type="checkbox" value="'.$yonetimKurulu[$i]["UYE_ID"].'" name="yonetimKuruluCheckbox[]" id="yonetimKuruluCheckbox'.$i.'"></td>';
					echo '<td>'.$yonetimKurulu[$i]['AD_SOYAD'].'</td>';
					echo '<td>'.$yonetimKurulu[$i]['UNVAN'].'</td>';
					echo '<td>'.$yonetimKurulu[$i]['KURUM'].'</td>';
					echo '<td>'.$yonetimKurulu[$i]['ETKINLIK_BASLANGIC_TARIHI'].'</td>';
					echo '<td>'.$yonetimKurulu[$i]['ETKINLIK_BITIS_TARIHI'].'</td>';
					echo '<td class="'.$backgroundClass.'">'.$yonetimKurulu[$i]["ACIKLAMA"].'</td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>

	</form>
	<div style="clear: both;"></div>

</div>

<script type="text/javascript">
	
function EtkinlestirButton()
{
    document.yonetimKuruluForm.action = "index.php?option=com_yonetim_kurulu&amp;task=etkinlestir";
    document.yonetimKuruluForm.submit();             // Submit the page
    return true;
}
function EtkisizlestirButton()
{
    document.yonetimKuruluForm.action = "index.php?option=com_yonetim_kurulu&amp;task=etkisizlestir";
    document.yonetimKuruluForm.submit();             // Submit the page
    return true;
}

function SilButton()
{
	<?php 
	$yonetimKuruluArr = JRequest::getVar('yonetimKuruluCheckbox');	
	?>
	var $b = jQuery('input[type=checkbox]');
	var count = $b.filter(':checked').length;
	var msg="";
	if(count==1)
		msg="Seçilen üyeyi silmek istediğinize emin misiniz?";
	else
		msg="Seçilen üyeleri silmek istediğinize emin misiniz?";
	if(confirm(msg)==true)
	{		
	    document.yonetimKuruluForm.action = "index.php?option=com_yonetim_kurulu&amp;task=sil";
	    document.yonetimKuruluForm.submit();             // Submit the page
	}
    return true;
}

function DuzenleButton()
{
	var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
	document.yonetimKuruluForm.action = "index.php?option=com_yonetim_kurulu&amp;layout=yeni&amp;uyeID="+editIndex;
    document.yonetimKuruluForm.submit();             // Submit the page
    return true;
}

function YeniButton()
{
    document.yonetimKuruluForm.action = "index.php?option=com_yonetim_kurulu&amp;layout=yeni";
    document.yonetimKuruluForm.submit();             // Submit the page
    return true;
}


jQuery(document).ready(function(){
	jQuery('#yonetimKuruluListe').dataTable({
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

	if(count>0)
		jQuery("#silButton").removeAttr('disabled');
	else
		jQuery("#silButton").attr('disabled', 'disabled');
	if(count==1)
	{
		jQuery("#duzenleButton").removeAttr('disabled');
		var editIndex = jQuery('input[type=checkbox]').filter(':checked').val();
		jQuery("#yonetimKuruluForm").attr("action", "index.php?option=com_yonetim_kurulu&amp;layout=yeni&amp;uyeID="+editIndex);
	}
	else
	{
		jQuery("#duzenleButton").attr('disabled', 'disabled');
	}
}

</script>

