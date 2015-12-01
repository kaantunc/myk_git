<script type="text/javascript">
<?php 
$sektorSorumlusu = $this->sektorSorumlusu;

echo "var gorevArr   = new Array();";
echo "var islemArr   = new Array();";
echo "var basarimArr = new Array();";
echo "var dipnotArr  = new Array();";

$gorevIndex = 0;
$islemIndex = 0;
$basarimIndex = 0;

$gorev_profil_id = 0; 
$islemParent = 0; 
$basarimParent = 0; 
for ($i = 0; $i < count($this->profil); $i++){
	$arr = $this->profil[$i];

	if ($arr["PROFIL_GOREV_ADI"] != null){
		$gorev_profil_id = $arr["PROFIL_ID"];
		echo "gorevArr [".$gorevIndex."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_GOREV_ADI"])."';";
		$gorevIndex++;
	}else if ($arr["PROFIL_ISLEM_ADI"] != null){
		if ($islemParent != $arr["PARENT_ID"]){
			$arrIslemIndex = 0;
			$islemParent = $arr["PARENT_ID"];
			echo "islemArr [".$islemIndex."]  = new Array();";
			
			echo "islemArr [".$islemIndex."][".$arrIslemIndex."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_ISLEM_ADI"])."';";
			$arrIslemIndex++;
			$islemIndex++;
		}else{
			echo "islemArr [".($islemIndex-1)."][".$arrIslemIndex."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_ISLEM_ADI"])."';";
			$arrIslemIndex++;
		}
	}else if ($arr["PROFIL_BASARIM_OLCUT"] != null){
		if ($basarimParent != $arr["PARENT_ID"]){
			$arrBasarimIndex = 0;
			$arrDipnotIndex = 0;
			$basarimParent = $arr["PARENT_ID"];
			echo "basarimArr [".$basarimIndex."]  = new Array();";
			echo "dipnotArr  [".$basarimIndex."]  = new Array();";
			
			echo "basarimArr [".$basarimIndex."][".$arrBasarimIndex++."]  = '".$gorev_profil_id."';";
			echo "basarimArr [".$basarimIndex."][".$arrBasarimIndex++."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_OLCUT"])."';";
			echo "dipnotArr  [".$basarimIndex."][".$arrDipnotIndex++."]  = '".$gorev_profil_id."';";
			echo "dipnotArr  [".$basarimIndex."][".$arrDipnotIndex++."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_DIPNOT"])."';";
			$basarimIndex++;
		}else{
			echo "basarimArr [".($basarimIndex-1)."][".$arrBasarimIndex."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_OLCUT"])."';";
			echo "dipnotArr  [".($basarimIndex-1)."][".$arrDipnotIndex."]  = '".FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_DIPNOT"])."';";
			$arrBasarimIndex++;
			$arrDipnotIndex++;
		}
	}
}

if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>		
jQuery(document).ready(function(){
	if (isReadOnly){
		createAddGibValues (gorevArr, islemArr, basarimArr,dipnotArr, 'readOnly');
		tableGibSatirEkleKaldir ();
	}else{
		createAddGibValues (gorevArr, islemArr, basarimArr,dipnotArr);
	}

});
</script>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=meslek_profil&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">3. MESLEK PROFİLİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3.1.	Görevler, İşlemler ve Başarım Ölçütleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
<!--  <div class="form_element">-->
<div id="gibTable"></div>
<?php

if ($this->canEdit)
	echo '<input type="button" onclick="addGibTable(\'gibTable\')" value="Görev Tablosu Ekle" />';
?>
  </div>
  <div class="cfclear">&nbsp;</div>
<!--</div>-->

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('meslek_profil', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>
