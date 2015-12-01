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
echo 'action=index.php?option=com_yeterlilik_taslak&layout=sart&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİK İÇİN GEREKLİ EĞİTİM ŞARTININ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">A) Şekli</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="sekil" title="" cols="50" name="sekil"><?php echo $taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">B) İçeriği</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="icerik" title="" cols="50" name="icerik"><?php echo $taslakYeterlilik["YETERLILIK_EGITIM_ICERIK"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">C) Süresi</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="egitim_sure" title="" cols="50" name="egitim_sure"><?php echo $taslakYeterlilik["YETERLILIK_EGITIM_SURE"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİK İÇİN GEREKLİ OLAN DENEYİM ŞARTININ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">A) Niteliği</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="nitelik" title="" cols="50" name="nitelik"><?php echo $taslakYeterlilik["YETERLILIK_DENEYIM_NITELIK"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">B) Süresi</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="deneyim_sure" title="" cols="50" name="deneyim_sure"><?php echo $taslakYeterlilik["YETERLILIK_DENEYIM_SURE"];?></textarea>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('sart', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>