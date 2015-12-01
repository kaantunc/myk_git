<?php 
$data = $this->ek_8;

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=ek_8&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">EKLER</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 8 : Yeterlilik için öngörülen eğitim şartı, deneyim şartı ve belgenin geçerlilik süresine ilişkin dayanak/gerekçe belirtilerek ekte sunulacaktır. (Yeterlilik için öngörülen eğitim ve deneyim şartının neden gerekli olduğu; ayrıca yeterlilik belgesi için öngörülen geçerlilik süresinin neye dayanılarak belirlendiği bu bölümde belirtilerek bu gerekliliklere ilişkin ulusal ya da uluslar arası standart, sözleşme, mevzuat vs. varsa belirtilecektir.)</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="aciklama" title="" cols="70" name="aciklama"><?php echo $this->taslakYeterlilik["YETERLILIK_EK_ACIKLAMA"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

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

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_8', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>