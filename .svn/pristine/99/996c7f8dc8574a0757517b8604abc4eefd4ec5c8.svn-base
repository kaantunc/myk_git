
<form
	onsubmit="return validate('ChronoContact_meslek_std_basvuru_t1')"
	action="index.php?option=com_meslek_std_basvur&amp;layout=irtibat&amp;task=standartKaydet&evrak_id=<?php echo $this->evrak_id; ?>"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>
	
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">İrtibat Bilgileri</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="irtibat_panel_div" class="panel_main_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php }?>
</form>

<script type="text/javascript">
dPanels.irtibat_panel =  new Array("İrtibat Kurulacak Kişinin;", new Array("Adı Soyadı", "text", "required"), new Array("E-Posta", "text", "required email", "e-mail"), new Array("Telefon", "text", "irtibatTelFax required"), new Array("Faks", "text", "irtibatTelFax required"));

function createPanels (){
	createAddIrtibatValues ("irtibat_panel", "İrtibat Bilgisi");
}

function createAddIrtibatValues (name, buttonName){
	var arry = new Array ();
	<?php
	$data = $this->irtibat;
	$panelCount = count($data);
	
	echo 'var panelCount ='. $panelCount.';'; 
	
	$c = 0;
	for ($i=0; $i< $panelCount; $i++) {
		$arrIrtibat = $data[$i];
		echo 'arry['.$c++.']= "'. $arrIrtibat["IRTIBAT_ID"] .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrIrtibat["IRTIBAT_KISI_ADI"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrIrtibat["IRTIBAT_EPOSTA"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrIrtibat["IRTIBAT_TELEFON"]) .'";';
		echo 'arry['.$c++.']= "'. FormFactory::normalizeVariable ($arrIrtibat["IRTIBAT_FAKS"]) .'";';
		
	}
	?>

	var rowCount = 4;
	createNPanels(panelCount, name, buttonName);

	if (isset (arry))
		addPanelValues (arry, name, panelCount, rowCount);
}
jQuery("#ChronoContact_meslek_std_basvuru_t1").validate();
jQuery(document).ready(function (){	
	jQuery(".irtibatTelFax").live("focus",function (){
			jQuery(this).mask("(999) 999-9999");
		});
<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2 && $this->ssyetkili != true && $this->evrak_id != -1){?>
	jQuery('#addNewPanelButton_irtibat_panel').remove();
	jQuery('.panel_kaldir_button').remove();
<?php } ?>
});
</script>