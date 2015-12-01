<?php 
$kurulus = $this->kurulus_bilgi;
?>
<form
	onsubmit="return validate('ChronoContact_com_profile_t1')"
	action="index.php?option=com_profile&amp;layout=irtibat&amp;task=irtibatkaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_com_profile_t1"
	name="ChronoContact_com_profile_t1">

<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
	
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
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
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

	addPanelValues (arry, name, panelCount, rowCount);
}

function addPanelValues (arry,name,panelCount, rowCount, skip){
	if (skip == null)
		skip = 0;
	
	var count = 0;
	if (arry.length != 0){
		for (var i = 1; i < (panelCount+1); i++){
			var elementId =  name+i;
			if(i == 1)
				elementId =  name;
			
			var idInp = document.createElement("input");
			idInp.setAttribute("type", "hidden");
			idInp.setAttribute("id", elementId);
			idInp.setAttribute("name", elementId);
			idInp.setAttribute("value", arry [count]);
			
			var mainDiv = document.getElementById(name + "_div");
			mainDiv.appendChild(idInp);

			count++;			
			for (var j = skip; j < rowCount+skip; j++){
				var itemId = 'input'+ name+i+'-'+(j+2)+'-'+(j+1); 
				if (i == 1) 
					itemId = 'input'+ name+'-'+(j+2)+'-'+(j+1);
      
				var item = document.getElementById (itemId);
				item.value = arry[count];
				count++;
			}
		}
	}
}
jQuery(document).ready(function (){	
	jQuery(".irtibatTelFax").live("focus",function (){
		jQuery(this).mask("(999) 999-9999");
	});
});
</script>