<?php 
$yorum=$this->yorum;
?>
<style>
td.ortala{
    text-align: center;
}
</style>
<?php 
if ($this->canEdit){
?>
<form
	onsubmit="return validate('ChronoContact_uzman_basvuru_t4')"
	action="index.php?option=com_uzman_basvur&amp;layout=ss_islemleri&amp;task=basvuruKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_uzman_basvuru_t4"
	name="ChronoContact_uzman_basvuru_t4">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
}
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Uzman İşlemleri </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
		Yorum:<br>
			<textarea name="yorum" rows="5" cols="100"><?php echo $yorum["YORUM"];?></textarea>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit"  onclick="<?php echo $this->onclick;?>" class="styled-button-8"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<div class="cfclear">&nbsp;</div>
	
</div>
<?php
if ($this->isSektorSorumlusu){
	if ($this->kurulus["BASVURU_DURUM"]==1){;
?>
<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button"><b>ONAY BEKLİYOR</b>
			<button name="islem" value="onayla" type="submit" />Onayla (Kaydet)</button>
			<!-- button name="islem" value="reddet" type="submit" />Reddet</button-->
			<button name="islem" value="iade" type="submit" />Kullanıcıya Geri Gönder</button>
		</div>
		<div class="cfclear">&nbsp;</div>
</div>
<?php 
	} 

	if ($this->kurulus["BASVURU_DURUM"]==2){
?>
<div class="form_item" style="padding-top: 25px;">

		<div class="form_element cf_button"><b>ONAYLANMIŞ:</b>
			<button name="islem" value="iade" type="submit" />Onayı İptal Et</button>
		</div>
		<div class="cfclear">&nbsp;</div>
</div>
<?php 
		
	}
} 

?>
</form> 