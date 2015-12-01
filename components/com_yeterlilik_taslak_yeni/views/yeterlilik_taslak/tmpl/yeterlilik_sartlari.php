<?php 
$taslakYeterlilik = $this->taslakYeterlilik;

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_sartlari&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİK SINAVINA GİRİŞ ŞART(LAR)I</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea" style="width:100%; float:left;"> 
		<textarea onblur="validateSart();" onmouseout="validateSart();"  class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="sekil" title="" cols="100" name="sekil"><?php echo $taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"];?></textarea>
	</div>
	<div id="ERRORDIV" style="width:100%; float:left;" >
		<font id="ERRORTEXT" color="red" style="margin-left: 50px;"></font>		
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" id="submitButton" onmouseover="validateSart();" type="submit" />
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('yeterlilik_sartlari', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>


</form>