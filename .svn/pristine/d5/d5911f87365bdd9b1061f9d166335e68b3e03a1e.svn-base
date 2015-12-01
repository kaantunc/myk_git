<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$taslakYeterlilik = $this->taslakYeterlilik;
$gelistiren_kurulus = $this->gelistiren_kurulus;

$yeterlilikBilgi = $this->yeterlilikBilgi;

if($yeterlilikBilgi['YETERLILIK_DURUM_ID']==PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK)
	$ulusalOlmus = true;
else
	$ulusalOlmus = false;
	

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=aciklama&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">BELGE GEÇERLİLİK SÜRESİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="gecerlilik_sure" title="" cols="50" name="gecerlilik_sure"><?php echo $taslakYeterlilik["YETERLILIK_GECERLILIK_SURE"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">GÖZETİM SIKLIĞI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="metod_gozetim" title="" cols="50" name="metod_gozetim"><?php echo $taslakYeterlilik["YETERLILIK_METHOD_GOZETIM"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">BELGE YENİLEMEDE UYGULANACAK ÖLÇME-DEĞERLENDİRME YÖNTEMİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="degerlendirme_yontem" title="" cols="50" name="degerlendirme_yontem"><?php echo $taslakYeterlilik["YETERLILIK_DEG_YONTEM"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİĞİ GELİŞTİREN KURULUŞ(LAR)</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div>
		<table id="gelistirenKurulusTable" style="width:100%;">
		<thead>
			<tr><th style="width:30px;" >Sıra No</th><th>Kuruluş Adı</th><th style="width:40px;">İlk Geliştiren</th><th style="width:40px;">Revizyon</th><th style="width:75px;">Revizyon No</th><th>Satırı Sil?</th></tr>
		</thead>
		<tbody>
			<?php 
			
			for($i=0; $i<count($gelistiren_kurulus); $i++)
			{
				if($i%2==1) $rowClass='even'; else $rowClass = 'odd';
				if($gelistiren_kurulus[$i]["ILK_GELISTIRME_YAPAN"]=='1') $ilkGelistirenChecked = ' checked="checked" '; else  $ilkGelistirenChecked = ' '; 
				if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]=='1') $revizeYapanChecked = ' checked="checked" '; else  $revizeYapanChecked = ' ';
				if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]!='1') $revizeNoTextboxReadOnlyVal = ' readonly="readonly" '; else  $revizeNoTextboxReadOnlyVal = ' ';
				
				
				if($ulusalOlmus==true)
					$ilkGelistirenReadOnly = ' disabled="disabled" ';
				else
					$ilkGelistirenReadOnly = ' ';
					
				echo '<tr class="'.$rowClass.'">';
				echo '<td style="width:30px;" >'.($i+1).'</td>';
				echo '<td> <input type="text" name="inputkurulus-2[]" value="'.$gelistiren_kurulus[$i]["YETERLILIK_KURULUS_ADI"].'" class="required"  style="width:100%;"  /> </td>';
				echo '<td style="width:40px;"> <input type="checkbox" name="inputkurulus-3-1[]" style="margin-left:40%;" '.$ilkGelistirenChecked.' '.$ilkGelistirenReadOnly.' class="ilkGelistiren"></td>';
				echo '<td style="width:40px;"> <input type="checkbox" name="inputkurulus-4-1[]" style="margin-left:40%;" '.$revizeYapanChecked.' class="revizyon"><br></td>';
				echo '<td style="width:75px;"><input type="text" name="inputkurulus-5[]" '.$revizeNoTextboxReadOnlyVal.' class="revizyonNoTextBox" value="'.$gelistiren_kurulus[$i]["REVIZE_NO"].'" ></td>';
				echo '<td width="10%"><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>';
				echo '</tr>';
				
			}
			
			?>
		</tbody>
		</table>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div style="width:100%;">
<input style="float:left; height: 20px; margin-left: 50px;" type="text" id="satirSayisiTextbox" size="3" value="1" ><input style="float:left;" class="yeniKurulusEkleButton" type="button" value="Adet Satır Ekle">
</div>


<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kurulus_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" id="tumunuKaydetButton" type="button" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('aciklama', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

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



var settings = 
{
 		"bPaginate": false,
 		"bFilter": false,
 		"bInfo": false,
	    "oLanguage": 
		{
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": 
			{
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
};

						
var oTableBirim = jQuery('#gelistirenKurulusTable').dataTable(settings);



jQuery('.gelistirenKurulusSilButton').live("click", function(e){

	jQuery(this.getParent().getParent()).remove();
	adjustNumbersOfTable();
});
jQuery('.yeniKurulusEkleButton').live("click", function(e){

	var eklenecekSatirlar = jQuery('#satirSayisiTextbox');

	if(!isNaN(parseInt(jQuery('#satirSayisiTextbox').val())))
	{
		var count = parseInt(jQuery('#satirSayisiTextbox').val());
		jQuery('#gelistirenKurulusTable tbody tr td.dataTables_empty').parent().remove();
		
		for(var i=0; i<count; i++)
		{
			
			var satirCount = jQuery('#gelistirenKurulusTable tbody tr').length + 1;
			
			var rowClass = "even";
			if(satirCount%2 == 1) rowClass = "odd";
			
			var satir = '<tr class="'+rowClass+'">'
			+ '<td style="width:30px;" >'+satirCount+'</td>'
			+ '<td> <input type="text" name="inputkurulus-2[]" class="required"  style="width:100%;"  /> </td>'
			+ '<td style="width:40px;"> <input type="checkbox" name="inputkurulus-3-1[]" style="margin-left:40%;" <?php echo $ilkGelistirenReadOnly; ?> class="ilkGelistiren"></td>'
			+ '<td style="width:40px;"> <input type="checkbox" name="inputkurulus-4-1[]" style="margin-left:40%;" class="revizyon"><br></td>'
			+ '<td style="width:75px;"><input type="text" name="inputkurulus-5[]" readOnly="readOnly" class="revizyonNoTextBox"></td>'
			+ '<td width="10%"><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>'
			+ '</tr>';

			jQuery('#gelistirenKurulusTable tbody').append(satir);
				
		}
						
	}
});

function adjustNumbersOfTable()
{
	var rows = jQuery('#gelistirenKurulusTable tbody tr');
	for(var i=0; i<rows.length; i++)
	{
		rows[i].getChildren()[0].innerHTML = (i+1);
	}
}

jQuery('.revizyon').live("click", function() {

	var revizyonTextboxElement = jQuery(this.getParent()).next().children().filter('input')
		
	if(this.checked==true)
	{
		jQuery(revizyonTextboxElement).removeAttr('readOnly');
	}
	else
	{
		jQuery(revizyonTextboxElement).attr('readOnly', 'readOnly');
		jQuery(revizyonTextboxElement).val("");	
	} 
		
 });

jQuery('#tumunuKaydetButton').live("click", function(e){

	var revizyonCheckBoxlari = jQuery('.revizyon');
	var ilkGelistirenCheckboxlari = jQuery('.ilkGelistiren');
	
	for(var i=0; i<revizyonCheckBoxlari.length; i++)
	{
		if(revizyonCheckBoxlari[i].checked==true)
			jQuery('#ChronoContact_yeterlilik_taslak').append('<input type="hidden" name="revizyonCheckBoxlari[]" value="1" >');		
		else
			jQuery('#ChronoContact_yeterlilik_taslak').append('<input type="hidden" name="revizyonCheckBoxlari[]" value="0" >');		
	}
	for(var i=0; i<ilkGelistirenCheckboxlari.length; i++)
	{
		if(ilkGelistirenCheckboxlari[i].checked==true)
			jQuery('#ChronoContact_yeterlilik_taslak').append('<input type="hidden" name="ilkGelistirenCheckBoxlari[]" value="1" >');		
		else
			jQuery('#ChronoContact_yeterlilik_taslak').append('<input type="hidden" name="ilkGelistirenCheckBoxlari[]" value="0" >');		
	}

	jQuery('#ChronoContact_yeterlilik_taslak').submit();
});


</script>